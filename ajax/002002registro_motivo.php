<?php
require_once("../config/db.php"); // Archivos y variables para conexion a db
require_once("../config/conexion.php");
include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado

header('Content-Type: application/json');

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$datos = array();

if ($action == 'ajax') {

    if (isset($_POST['id'])) {

        $id = intval($_POST['id']);
        $user_id = $_SESSION['user_id'];

        //Validar Tipo de articulo
        if (!isset($_POST['descMotivo']) ||  empty($_POST['descMotivo'])) {
            $datos['errores']['descMotivo'] = 'El campo <b>Motivo de Anulación o Activación</b> está vacio.';
        } else {
            $descMotivo = trim($_POST['descMotivo']);
        }

        if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

            $sql_insert = "INSERT INTO ingreso_anulacion (id_ingreso,
                                                        fecha_anulacion,
                                                        descripcion_motivo, 
                                                        usuario_anulacion_id)
                                        VALUES('$id',
                                            CURRENT_TIMESTAMP, 
                                            '$descMotivo',
                                            '$user_id')";

            $query_insert = mysqli_query($con, $sql_insert);
            $ultimo_id = mysqli_insert_id($con);

            if (!$query_insert)
                $datos['errores']['sql'] = "Error en la carga.";
            else {

                $sql_update = "UPDATE ingreso
                            SET estado_ingreso = CASE WHEN estado_ingreso = 1 THEN 0
                                                        WHEN estado_ingreso = 0 THEN 1
                                                        ELSE estado_ingreso
                                                    END
                            WHERE id_ingreso = '$id'";

                $query_update = mysqli_query($con, $sql_update);

                if ($query_update) {

                    $sql_accion = "SELECT * FROM ingreso WHERE id_ingreso = '$id'";

                    $query_accion = mysqli_query($con, $sql_accion);
                    $fila = mysqli_fetch_array($query_accion);

                    $estado = $fila['estado_ingreso'];

                    $sql_update = "UPDATE ingreso_anulacion
                            SET accion_motivo = '$estado'
                            WHERE id_ingreso = '$id' AND id_anulacion = '$ultimo_id'";

                    $query_update = mysqli_query($con, $sql_update);

                    if ($query_update) {
                        $datos['exito'] = "El estado del artículo cambió con éxito.";
                    } else {
                        $datos['errores'] = "Hubo un error en el proceso, por favor intente nuevamente.";
                    }
                } else {
                    $datos['errores'] = "Hubo un error en el proceso, por favor intente nuevamente.";
                }
            }
        }
    }
}

echo json_encode($datos);
