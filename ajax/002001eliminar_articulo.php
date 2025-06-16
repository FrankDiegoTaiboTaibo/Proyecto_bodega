<?php
    header('Content-Type: application/json');
    include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
    require_once("../config/db.php"); // Archivos y variables para conexion a db
    require_once("../config/conexion.php");

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
    $datos = array();

    if ($action == 'ajax') {

        if (isset($_POST['id'])) {
            $id = trim($_POST['id']);


            $sql_delete =  "DELETE 
                        FROM articulos 
                        WHERE id_articulo ='$id' ";
            $query_delete = mysqli_query($con, $sql_delete);

            if ($query_delete) {
                $datos['exito'] = "El registro se eliminó con éxito.";
            } else {
                $datos['error'] = "Hubo un error en el proceso, por favor intente nuevamente.";
            }
        }
    }

    echo json_encode($datos);
?>
