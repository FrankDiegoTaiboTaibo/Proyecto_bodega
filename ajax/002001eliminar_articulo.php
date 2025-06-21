<?php
    header('Content-Type: application/json');
    include('is_logged.php'); // Verifica login
    require_once("../config/db.php");
    require_once("../config/conexion.php");

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
    $datos = array();

    if ($action == 'ajax') {
        if (isset($_POST['id'])) {
            $id = trim($_POST['id']);

            // Verificar si el artículo está relacionado en ingreso
            $sql_check = "SELECT 1 FROM ingreso WHERE id_articulo = '$id' LIMIT 1";
            $query_check = mysqli_query($con, $sql_check);

            if (mysqli_num_rows($query_check) > 0) {
                $datos['error'] = "No se puede eliminar el artículo porque existe en registros de ingreso.";
            } else {
                // Si no existe, se puede eliminar
                $sql_delete = "DELETE FROM articulos WHERE id_articulo = '$id'";
                $query_delete = mysqli_query($con, $sql_delete);

                if ($query_delete) {
                    $datos['exito'] = "El registro se eliminó con éxito.";
                } else {
                    $datos['error'] = "Error al eliminar el artículo. Intente nuevamente.";
                }
            }
        } else {
            $datos['error'] = "ID no recibido.";
        }
    }

    echo json_encode($datos);
?>
