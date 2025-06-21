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

        //Validar Stock minimo
        if (!isset($_POST['cantidad_mod'])) {
            $datos['errores']['cantidad_mod'] = 'El campo <b>Cantidad</b> es inválido.';
        } else {
            $cantidad_mod = trim($_POST['cantidad_mod']);

            if (!is_numeric($cantidad_mod) || intval($cantidad_mod) < 0) {
                $datos['errores']['cantidad_mod'] = 'El campo <b>Cantidad</b> es inválido. El valor debe ser de tipo numérico mayor a cero.';
            } elseif (intval($cantidad_mod) < 10) {
                $datos['errores']['cantidad_mod'] = 'El <b>Cantidad</b> debe ser al menos <b>10</b>.';
            }
        }

        //validación fecha Vencimiento
        if (!isset($_POST['fechaVencimiento_mod']) || empty($_POST['fechaVencimiento_mod'])) {
            $datos['errores']['fechaVencimiento_mod'] = 'El campo <b>Fecha Vencimiento</b> está en blanco.';
        } else {
            $fechaVencimiento_mod = trim($_POST['fechaVencimiento_mod']);
            $valores = explode('/', $fechaVencimiento_mod);
            if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
                $datos['errores']['fechaVencimiento_mod'] = 'El campo <b>Fecha Vencimiento</b> es inválido.';
            } else {
                $fechaVencimiento_mod = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
            }
        }

        //Validar tipo ingreso
        if (!isset($_POST['tipoIngreso_mod']) ||  empty($_POST['tipoIngreso_mod'])) {
            $datos['errores']['tipoIngreso_mod'] = 'El campo <b>Tipo Ingreso</b> está vacio.';
        } else {
            $tipoIngreso_mod = trim($_POST['tipoIngreso_mod']);
        }

        //Validar proveedor
        if (!isset($_POST['proveedor_mod']) ||  empty($_POST['proveedor_mod'])) {
            $datos['errores']['proveedor_mod'] = 'El campo <b>Proveedor</b> está vacio.';
        } else {
            $proveedor_mod = trim($_POST['proveedor_mod']);
        }

        //Validar observacion
        if (isset($_POST['observacion_mod']) ||  !empty($_POST['observacion_mod'])) {
            $observacion_mod = trim($_POST['observacion_mod']);
        }


        //Si no existen errores se procede a guardar el registro.
        if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

            $sql_update = "UPDATE ingreso
                            SET cantidad = '$cantidad_mod',
                                fecha_vencimiento = '$fechaVencimiento_mod',
                                tipo_ingreso ='$tipoIngreso_mod',
                                proveedor = '$proveedor_mod',
                                observacion = '$observacion_mod',
                                fecha_edicion = CURRENT_TIMESTAMP,
                                usuario_editor_id = '$user_id'
                            WHERE id_ingreso = '$id'";

            $query_update = mysqli_query($con, $sql_update);

            if ($query_update) {
                  $sql_insert = "INSERT INTO ingreso_anulacion (id_ingreso,
                                                        fecha_anulacion,
                                                        descripcion_motivo, 
                                                        usuario_anulacion_id,
                                                        accion_motivo)
                                        VALUES('$id',
                                            CURRENT_TIMESTAMP, 
                                            'SE EDITA INGRESO',
                                            '$user_id',
                                            2)";

            $query_insert = mysqli_query($con, $sql_insert);

             if ($query_insert) {
                                $datos['exito'] = 'El registro se ha actualizado en el sistema.';

             }else{
                $datos['errores']['update'] = 'Ha ocurrido un <b>error</b> en el proceso de actualizar el registro. Intente nuevamente.';

             }

            } else {
                $datos['errores']['update'] = 'Ha ocurrido un <b>error</b> en el proceso de actualizar el registro. Intente nuevamente.';
            }
        }
    }
    echo json_encode($datos);
?>