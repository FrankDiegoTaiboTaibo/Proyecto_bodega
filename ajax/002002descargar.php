<?php
    require_once("../config/db.php");
    require_once("../config/conexion.php");

    $id_ingreso = $_GET['id'];

    $sql = "SELECT nombre_archivo_fisico FROM ingreso WHERE id_ingreso = '$id_ingreso'";
    $query = mysqli_query($con, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $nombre_fisico = $row['nombre_archivo_fisico'];
        $ruta_documento = $_SERVER["DOCUMENT_ROOT"] . '/Proyecto_bodega/DOCUMENTOS/' . $nombre_fisico . '.pdf';

        if (file_exists($ruta_documento)) {
            // Forzar la descarga
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($ruta_documento) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($ruta_documento));
            flush(); // Limpia el búfer del sistema
            readfile($ruta_documento);
            exit;
        }
    }
?>
