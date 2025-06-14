<?php
    include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
    header('Content-Type: application/json');
    //____________________________________________Connect To Database
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

    //Código de validación de datos
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : ''; //--determina si una variable está definida y no es NULL.
    $datos = array();
    //Validaciones
    if ($action == 'ajax') {

        $user_id = $_SESSION['user_id'];

        //Validar nombreArticulo
        if (!isset($_POST['nombreArticulo']) ||  empty($_POST['nombreArticulo'])) {
            $datos['errores']['nombreArticulo'] = 'El campo <b>Nombre Artículo</b> está vacio.';
        } else {
            $nombreArticulo = trim($_POST['nombreArticulo']);
        }

        //Validar dosis
        if (!isset($_POST['dosis']) ||  empty($_POST['dosis'])) {
            $datos['errores']['dosis'] = 'El campo <b>Dosis</b> está vacio.';
        } else {
            $dosis = trim($_POST['dosis']);
        }

        //Validar presentacion
        if (!isset($_POST['presentacion']) ||  empty($_POST['presentacion'])) {
            $datos['errores']['presentacion'] = 'El campo <b>Presentación</b> está vacio.';
        } else {
            $presentacion = trim($_POST['presentacion']);
        }

        //Validar cantidad
        if (!isset($_POST['cantidad'])) {
            $datos['errores']['cantidad'] = 'El campo <b>Cantidad</b> es inválido.';
        } else {
            $cantidad = trim($_POST['cantidad']);
            if (!is_numeric($cantidad) || intval($cantidad) < 0)
                $datos['errores']['cantidad'] = 'El campo <b>Cantidad</b> es inválido. El valor debe ser de tipo numérico mayor a cero.';
        }

        //Validar fecha
        if (!isset($_POST['fechaVencimiento']) || empty($_POST['fechaVencimiento'])) {
            $datos['errores']['fechaVencimiento'] = 'El campo <b>Fecha Vencimiento</b> esta en blanco.';
        } else {
            $fechaVencimiento = trim($_POST['fechaVencimiento']);
            $valores = explode('/', $fechaVencimiento);
            if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])))
                $datos['errores']['fechaVencimiento'] = 'El campo <b>Fecha Vencimiento</b> es inválida.';
            else
                $fechaVencimiento = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
        }


        if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

              $sql_exist = "SELECT * 
                   FROM articulo
                   WHERE nombre_articulo  = '$nombreArticulo' 
                   AND dosis_articulo = '$dosis'";

        $query_exist = mysqli_query($con, $sql_exist);

        if (mysqli_num_rows($query_exist) > 0) {
          $datos['errores']['sql'] = "Ya existe el articulo con esa dosis";

        } else {

               $sql_insert = "INSERT INTO articulo (nombre_articulo,
                                                                  dosis_articulo,
                                                                  presentacion_articulo, 
                                                                  cantidad_articulo, 
                                                                  fecha_venciimiento,
                                                                  observacion,
                                                                  usuario_editor,
                                                                  estado_articulo)
                                  VALUES('$nombreArticulo',
                                          '$dosis',
                                          '$presentacion',
                                          '$cantidad',
                                          '$fechaVencimiento',
                                          '$',
                                          '$user_id',
                                          1)";

          $query_insert = mysqli_query($con, $sql_insert);

          if (!$query_insert)
            $datos['errores']['sql'] = "Error en la carga.";
          else {
            $datos['exito'] = "El cargo fue creado con éxito.";
          }



        }
        }
    }

    echo json_encode($datos);
?>