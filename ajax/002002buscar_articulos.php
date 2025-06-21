<?php
require_once("../config/db.php");
require_once("../config/conexion.php");

if (isset($_POST['id_articulo'])) {
    $id_articulo = intval($_POST['id_articulo']);
    
    $sql = "SELECT *
            FROM articulos 
            WHERE id_articulo = $id_articulo";
    
    $query = mysqli_query($con, $sql);
    
    if ($row = mysqli_fetch_assoc($query)) {
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
?>
