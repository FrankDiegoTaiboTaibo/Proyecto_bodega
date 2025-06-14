<?php
include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre'])) {
  $errors[] = "Nombre vacío";
} else if (!empty($_POST['nombre'])) {
  /* Connect To Database*/
  require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
  require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

  $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
  $id_cod = mysqli_real_escape_string($con, (strip_tags($_POST["id_cod"], ENT_QUOTES)));
  $orden = mysqli_real_escape_string($con, (strip_tags($_POST["orden"], ENT_QUOTES)));
  if ($orden == "") {
    $orden = PHP_INT_MAX;
  } //En caso de no ingresar un valor de orden, será por defecto el último
  $orden = $orden <= 0 ? 1 : $orden; // Para una mejor visualizacion no existiran numeros menores o iguaLes a 0
  $estado = isset($_POST['estado']) ? 1 : 0;

  //Validación del codigo, si existe retorna un mensaje de error
  $sql_val = "SELECT menu_cod FROM menu WHERE menu_cod = '" . $id_cod . "'";
  $query = mysqli_query($con, $sql_val);
  $count = mysqli_num_rows($query);

  if ($count == 0) {

    //Obtengo los menus ordenados segun su orden designado
    $sql_list = mysqli_query($con, "SELECT * FROM menu ORDER by menu_orden asc");

    $orden_menus = array();

    //Almaceno los ids en un arreglo
    while ($fila = mysqli_fetch_array($sql_list))
      array_push($orden_menus, $fila['menu_id']);

    $orden_a_agregar = array($orden);

    //Añado un ids "0" en su futura posición en el arreglo
    array_splice($orden_menus, $orden - 1, 0, 0);

    //Actualizo los ids que se desplazaran por el ingreso del nuevo valor
    foreach ($orden_menus as $key) {

      $pos = array_search($key, $orden_menus);

      if ($key != 0) {
        $sql_update = "UPDATE menu SET menu_orden='" . ($pos + 1) . "' WHERE menu_id='" . $key . "'";
        $query_update = mysqli_query($con, $sql_update);
      } else {
        $orden = $pos + 1;
      }
    }

    $sql = "INSERT INTO menu (menu_descripcion,menu_cod,menu_estado,menu_orden) VALUES ('$nombre','$id_cod','$estado','$orden')";

    $query_new_insert = mysqli_query($con, $sql);
    if ($query_new_insert) {
      $messages[] = "Menú '" . $nombre . "' ha sido ingresado satisfactoriamente.";
    } else {
      $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
    }
  } else {
    $errors[] = "El código de menú '" . $id_cod . "' ya lo utiliza otro menú. Ingrese otro.";
  }


  //Inserto el nuevo menu con sus respectivas mensajes


} else {
  $errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>¡Error!</strong>
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