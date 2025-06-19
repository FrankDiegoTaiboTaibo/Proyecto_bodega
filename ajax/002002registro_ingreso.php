<?php
  require_once("../config/db.php");
  require_once("../config/conexion.php");
  include('is_logged.php');
  header('Content-Type: application/json');
  mysqli_set_charset($con, "utf8");
  date_default_timezone_set('Chile/Continental');

  $datos = array();
  $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];
  if ($action == 'guardar') {

$stock_minimo = 0;

     if (!isset($_POST['id_articulo']) ||  empty($_POST['id_articulo'])) {
            $datos['errores']['id_articulo'] = 'El campo <b>Artículo</b> está vacio.';
        } else {
            $id_articulo = trim($_POST['id_articulo']);

             $validar_cantidad_articulo = "SELECT * 
                                           FROM articulos 
                                           WHERE id_articulo = '$id_articulo'";
             $query_validar = mysqli_query($con, $validar_cantidad_articulo);

            $row = mysqli_fetch_array($query_validar);

            $codigo_isp = $row['codigo_isp'];
      $stock_minimo = $row['stock_minimo'];

          if (!isset($_POST['cantidad']) ||  empty($_POST['cantidad'])) {
    $datos['errores']['cantidad'] = 'El campo <b>Cantidad</b> es inválido.';
} else {
    $cantidad = trim($_POST['cantidad']);

    if (!is_numeric($cantidad) || intval($cantidad) < 0) {
        $datos['errores']['cantidad'] = 'El campo <b>Cantidad</b> es inválido. El valor debe ser de tipo numérico mayor a cero.';
    } elseif (intval($cantidad) < intval($stock_minimo)) {
        $datos['errores']['cantidad'] = 'La cantidad mínima de ingreso para este artículo es de <b>' . intval($stock_minimo) . '</b>.';
    }
}



        
                 //Validar Tipo de articulo
        if (!isset($_POST['lote']) ||  empty($_POST['lote'])) {
            $datos['errores']['lote'] = 'El campo <b>Lote</b> está vacio.';
        } else {
            $lote = trim($_POST['lote']);
        }


        // Validar fecha_encimiento
    if (!isset($_POST['fecha_vencimiento']) || empty($_POST['fecha_vencimiento'])) {
        $datos['errores']['fecha_vencimiento'] = 'El campo <b>Fecha Vencimiento</b> está en blanco.';
    } else {
        $fecha_vencimiento = trim($_POST['fecha_vencimiento']);
        $valores = explode('/', $fecha_vencimiento);
        if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
            $datos['errores']['fecha_vencimiento'] = 'El campo <b>Fecha Vencimiento</b> es inválido.';
        } else {
            $fecha_vencimiento = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
        }
    }

                     //Validar Tipo de articulo
        if (!isset($_POST['proveedor']) ||  empty($_POST['proveedor'])) {
            $datos['errores']['proveedor'] = 'El campo <b>proveedor</b> está vacio.';
        } else {
            $proveedor = trim($_POST['proveedor']);
        }

                            //Validar Tipo de articulo
        if (!isset($_POST['tipo_ingreso']) ||  empty($_POST['tipo_ingreso'])) {
            $datos['errores']['tipo_ingreso'] = 'El campo <b>tipo_ingreso</b> está vacio.';
        } else {
            $tipo_ingreso = trim($_POST['tipo_ingreso']);
        }

                              //Validar Tipo de articulo
        if (!isset($_POST['observacion']) ||  empty($_POST['observacion'])) {
            $datos['errores']['observacion'] = 'El campo <b>observacion</b> está vacio.';
        } else {
            $observacion = trim($_POST['observacion']);
        }


           if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
      $extensionArchivo = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);

      if ($_FILES['archivo']['size'] > 10485760) {
        $datos['errores']['archivos'] = "El archivo es demasiado grande. El tamaño máximo permitido es 10 MB.";
      }
    } else {
      $datos['errores']['archivos'] = "Selecciona un archivo válido.";
    }
$codigo_isp = preg_replace('/[^A-Za-z0-9_\-]/', '_', $codigo_isp);

        }





    if (!(isset($datos['errores'])) || is_null($datos['errores'])) {
 $fecha_hora_chile = date("dmYHis");
$nombre_archivo_fisico = $fecha_hora_chile . "_" . $codigo_isp;
$ruta_documentos = $_SERVER["DOCUMENT_ROOT"] . '/Proyecto_bodega/DOCUMENTOS/';
$ruta_destino = $ruta_documentos . $nombre_archivo_fisico.'.pdf';

// Asegúrate de que el directorio exista
if (!is_dir($ruta_documentos)) {
    mkdir($ruta_documentos, 0777, true);
}


      if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_destino)) {
        $sql_insert = "INSERT INTO ingreso(id_articulo, 
                                                      cantidad, 
                                                      lote, 
                                                      fecha_vencimiento, 
                                                      tipo_ingreso, 
                                                      proveedor, 
                                                      usuario_creador_id, 
                                                      fecha_creacion, 
                                                      usuario_editor_id,
                                                      fecha_edicion,
                                                      observacion,
                                                      nombre_archivo_fisico) values ('$id_articulo',
                                                                      '$cantidad',
                                                                      '$lote',
                                                                      '$fecha_vencimiento',
                                                                      '$tipo_ingreso',
                                                                      '$proveedor',
                                                                      '$user_id',
                                                                      CURRENT_TIMESTAMP,
                                                                      '$user_id',
                                                                      CURRENT_TIMESTAMP,
                                                                      '$observacion',
                                                                      '$nombre_archivo_fisico')";
        $query_insert = mysqli_query($con, $sql_insert);

        if (!$query_insert) {

          $datos['errores']['sql'] = "Lo sentimos, el registro falló. Por favor, regrese y vuelva a intentarlo.";
        } else {
       

          $datos['exito'] = "Archivo subido con éxito y datos guardados.";

       
        }
      } else {
        $datos['errores']['archivos'] = "Error al subir el archivo." ;
      }
    }
  }

  echo json_encode($datos);
