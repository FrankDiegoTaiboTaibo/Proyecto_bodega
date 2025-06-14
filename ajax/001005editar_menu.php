<?php
include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
  $errors[] = "ID vacío";
} else if (empty($_POST['mod_nombre'])) {
  $errors[] = "Nombre vacío";
} else if (
  !empty($_POST['mod_id']) &&
  !empty($_POST['mod_nombre'])
) {
  /* Connect To Database*/
  require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
  require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
  // escaping, additionally removing everything that could be (html/javascript-) code
  $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
  $codigo = mysqli_real_escape_string($con, (strip_tags($_POST["mod_codigo"], ENT_QUOTES)));
  $id_menu = intval($_POST['mod_id']);
  $estado = isset($_POST['mod_estado']) ? 1 : 0;

  //Validación del codigo, si existe retorna un mensaje de error
  $sql_val = "SELECT menu_cod FROM menu WHERE menu_cod = '" . $codigo . "' and menu_id <> $id_menu";
  $query = mysqli_query($con, $sql_val);
  $count = mysqli_num_rows($query);

  if ($count == 0) {

    $orden = intval($_POST['mod_orden']);
    if ($orden == "") {
      $orden = PHP_INT_MAX;
    } //En caso de no ingresar un valor de orden, será por defecto el último
    $orden = $orden <= 0 ? 1 : $orden; // Para una mejor visualizacion el menor valor de orden será el 1

    //Obtengo los menus ordenados segun su orden designado
    $sql_list = mysqli_query($con, "SELECT * FROM menu WHERE menu_id <> $id_menu ORDER by menu_orden asc");

    $orden_menus = array();

    //Almaceno los ids en un arreglo
    while ($fila = mysqli_fetch_array($sql_list))
      array_push($orden_menus, $fila['menu_id']);

    $orden_a_agregar = array($orden);

    //Añado un id de en su futura posición en el arreglo
    array_splice($orden_menus, $orden - 1, 0, $id_menu);

    //Actualizo los ordenes que se desplazarán por modificarse
    foreach ($orden_menus as $key) {

      $pos = array_search($key, $orden_menus);

      $sql_update = "UPDATE menu SET menu_orden='" . ($pos + 1) . "' WHERE menu_id='" . $key . "'";
      $query_update = mysqli_query($con, $sql_update);
    }

    //Actualización de los otros datos del menú
    $sql = "UPDATE menu SET menu_descripcion='" . $nombre . "',menu_estado='" . $estado . "',menu_cod='" . $codigo . "' WHERE menu_id='" . $id_menu . "'";
    $query_update = mysqli_query($con, $sql);
    if ($query_update) {
      $messages[] = "Menú ha sido actualizado satisfactoriamente.";
    } else {
      $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
    }
  } else {
    $errors[] = "El código de menú '" . $codigo . "' ya lo utiliza otro menú. Ingrese otro.";
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