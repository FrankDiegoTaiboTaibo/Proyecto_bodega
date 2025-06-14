<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/

if (empty($_POST['mod_id_perfil'])) {
  $errors[] = "ID perfil no enviado";
} else if (!empty($_POST['mod_id_perfil'])) {
  // Connect To Database
  require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
  require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
  // escaping, additionally removing everything that could be (html/javascript-) code


  $id_perfil = intval($_POST['mod_id_perfil']);
  $ids_items = mysqli_real_escape_string($con, (strip_tags($_POST["mod_nombres_checkboxs"], ENT_QUOTES)));
  $ids_items = explode(";", $ids_items);
  array_pop($ids_items);

  $estado_update = true;
  //Se recorren los valores obtenidos en los checksboxs
  foreach ($ids_items as $valor) {

    $menu_item_id = substr($valor, 9);
    $estado = isset($_POST[$valor]) ? 1 : 0;

    //Validamos su existencia
    $sql = "SELECT COUNT(*) AS numrows FROM acceso WHERE perfil_id='" . $id_perfil . "' AND menu_item_id='" . $menu_item_id . "'";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    $numrows = $row['numrows'];

    if ($numrows > 0 && $estado == 0) { //Si existe y la decision es retirar acceso, se elimina

      $sql_delete = "DELETE FROM acceso WHERE perfil_id='" . $id_perfil . "' AND menu_item_id='" . $menu_item_id . "'";
      $query_delete = mysqli_query($con, $sql_delete);

      if (!$query_delete)
        $estado_update = false;
    } elseif ($numrows == 0 && $estado == 1) { //Si no existe y la decision es dar acceso, se crea
      $sql_insert = "INSERT INTO acceso(perfil_id, menu_item_id) VALUES ('" . $id_perfil . "','" . $menu_item_id . "')";
      $query_insert = mysqli_query($con, $sql_insert);

      if (!$query_insert)
        $estado_update = false;
    }
  }

  if ($estado_update) {
    $messages[] = "Los accesos han sido actualizados satisfactoriamente.";
  } else {
    $errors[] = "Lo siento, alguno de los accesos no lograron actualizarce. Intenta nuevamente." . mysqli_error($con);
  }
} else {
  $errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error!</strong>
    <?php
    foreach ($errors as $error) {
      echo $error;
    }
    ?>
  </div>
<?php
}
if (isset($messages)) {

?>
  <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>¡Bien hecho!</strong>
    <?php
    foreach ($messages as $message) {
      echo $message;
    }
    ?>
  </div>
<?php
}

?>