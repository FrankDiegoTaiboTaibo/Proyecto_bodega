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

            $sql_update = "UPDATE articulos
                           SET estado_articulo = CASE WHEN estado_articulo = 1 THEN 0
                                                      WHEN estado_articulo = 0 THEN 1
                                                      ELSE estado_articulo
                                                 END
                           WHERE id_articulo = '$id'";

            $query_update = mysqli_query($con, $sql_update);

            if ($query_update) {

                $datos['exito'] = "El estado del artículo cambió con éxito.";
            } else {
                $datos['errores'] = "Hubo un error en el proceso, por favor intente nuevamente.";
            }
        }
    }

    echo json_encode($datos);

?>
