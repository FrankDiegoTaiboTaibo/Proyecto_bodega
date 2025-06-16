<?php
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
    include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
    header('Content-Type: application/json');

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : ''; //--determina si una variable está definida y no es NULL.
    $datos = array();

    if ($action == 'ajax') {

         $user_id = $_SESSION['user_id'];
          $id = $_POST['id'];
       //Validar nombreArticulo
        if (!isset($_POST['nombreArticulo_mod']) ||  empty($_POST['nombreArticulo_mod'])) {
            $datos['errores']['nombreArticulo_mod'] = 'El campo <b>Nombre Artículo</b> está vacio.';
        } else {
            $nombreArticulo_mod = trim($_POST['nombreArticulo_mod']);
        }

        //Validar codigo isp
        if (!isset($_POST['codigoIsp_mod']) ||  empty($_POST['codigoIsp_mod'])) {
            $datos['errores']['codigoIsp_mod'] = 'El campo <b>Código</b> está vacio.';
        } else {
            $codigoIsp_mod = trim($_POST['codigoIsp_mod']);
        }

          //Validar codigo barra
        if (!isset($_POST['codigoBarra_mod']) ||  empty($_POST['codigoBarra_mod'])) {
            $datos['errores']['codigoBarra_mod'] = 'El campo <b>Código bodega</b> está vacio.';
        } else {
            $codigoBarra_mod = trim($_POST['codigoBarra_mod']);
        }

              //Validar concentración
        if (!isset($_POST['concentracion_mod']) ||  empty($_POST['concentracion_mod'])) {
            $datos['errores']['concentracion_mod'] = 'El campo <b>Concentración</b> está vacio.';
        } else {
            $concentracion_mod = trim($_POST['concentracion_mod']);
        }

        //Validar dosis
        if (!isset($_POST['formaFarmaceutica_mod']) ||  empty($_POST['formaFarmaceutica_mod'])) {
            $datos['errores']['formaFarmaceutica_mod'] = 'El campo <b>Forma farmaceutica</b> está vacio.';
        } else {
            $formaFarmaceutica_mod = trim($_POST['formaFarmaceutica_mod']);
        }

        //Validar Via administración
        if (!isset($_POST['viaAdministracion_mod']) ||  empty($_POST['viaAdministracion_mod'])) {
            $datos['errores']['viaAdministracion_mod'] = 'El campo <b>Vía de administración</b> está vacio.';
        } else {
            $viaAdministracion_mod = trim($_POST['viaAdministracion_mod']);
        }

             //Validar Unidad de medida
        if (!isset($_POST['unidadMedida_mod']) ||  empty($_POST['unidadMedida_mod'])) {
            $datos['errores']['unidadMedida_mod'] = 'El campo <b>Unidad de medida</b> está vacio.';
        } else {
            $unidadMedida_mod = trim($_POST['unidadMedida_mod']);
        }
    

                 //Validar Laboratorio
        if (!isset($_POST['laboratorio_mod']) ||  empty($_POST['laboratorio_mod'])) {
            $datos['errores']['laboratorio_mod'] = 'El campo <b>Laboratorio_mod</b> está vacio.';
        } else {
            $laboratorio_mod = trim($_POST['laboratorio_mod']);
        }
       

                     //Validar Tipo de articulo
        if (!isset($_POST['tipoArticulo_mod']) ||  empty($_POST['tipoArticulo_mod'])) {
            $datos['errores']['tipoArticulo_mod'] = 'El campo <b>Tipo de artículo</b> está vacio.';
        } else {
            $tipoArticulo_mod = trim($_POST['tipoArticulo_mod']);
        }

        //Validar Stock minimo
        if (!isset($_POST['stockMinimo_mod'])) {
            $datos['errores']['stockMinimo_mod'] = 'El campo <b>Stock minimo</b> es inválido.';
        } else {
            $stockMinimo_mod = trim($_POST['stockMinimo_mod']);
            if (!is_numeric($stockMinimo_mod) || intval($stockMinimo_mod) < 0)
                $datos['errores']['stockMinimo_mod'] = 'El campo <b>Stock minimo</b> es inválido. El valor debe ser de tipo numérico mayor a cero.';
        }
       

        //Si no existen errores se procede a guardar el registro.
        if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

                $sql_update = "UPDATE articulos
                                      SET nombre_articulo = '$nombreArticulo_mod',
                                          codigo_isp = '$codigoIsp_mod',
                                          codigo_barra ='$codigoBarra_mod',
                                          concentracion = '$concentracion_mod',
                                          forma_farmaceutica = '$formaFarmaceutica_mod',
                                          via_administracion = '$viaAdministracion_mod',
                                          unidad_medida = '$unidadMedida_mod',
                                          laboratorio = '$laboratorio_mod',
                                          tipo_articulo = '$tipoArticulo_mod',
                                          stock_minimo = '$stockMinimo_mod',
                                          fecha_edicion = CURRENT_TIMESTAMP,
                                          usuario_editor_id = '$user_id'
                                      WHERE id_articulo = '$id'";

                $query_update = mysqli_query($con, $sql_update);

                if ($query_update) {
                    $datos['exito'] = 'El registro se ha actualizado en el sistema.';
                } else {
                    $datos['errores']['update'] = 'Ha ocurrido un <b>error</b> en el proceso de actualizar el registro. Intente nuevamente.';
                }
          
        }
    }
    echo json_encode($datos);
?>