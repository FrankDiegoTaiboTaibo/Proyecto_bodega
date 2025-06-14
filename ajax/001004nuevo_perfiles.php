<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
  exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
  // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
  // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
  require_once("../libraries/password_compatibility_library.php");

  echo strlen($_POST['perfil_descripcion']);
}
if (empty($_POST['perfil_descripcion'])) {
  $errors[] = "Perfil vacíos";
} elseif (
  !empty($_POST['perfil_descripcion'])
  && strlen($_POST['perfil_descripcion']) >= 2
  && strlen($_POST['perfil_descripcion']) <= 50
  //&& !empty($_POST['user_consulta'])
) {
  require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
  require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

  // escaping, additionally removing everything that could be (html/javascript-) code
  $perfil = mysqli_real_escape_string($con, (strip_tags($_POST["perfil_descripcion"], ENT_QUOTES)));


  // check if user or email address already exists
  $sql = "SELECT * FROM perfil WHERE perfil_descripcion = '" . $perfil . "';";
  $query_check_user_name = mysqli_query($con, $sql);
  $query_check_user = mysqli_num_rows($query_check_user_name);
  if ($query_check_user == 1) {
    $errors[] = "Lo sentimos , el nombre de usuario ya está en uso.";
  } else {
    // write new user's data into database
    $sql = "INSERT INTO perfil (perfil_descripcion)
                            VALUES('" . $perfil . "');";
    $query_new_user_insert = mysqli_query($con, $sql);

    // if user has been added successfully
    if ($query_new_user_insert) {
      $messages[] = "La cuenta ha sido creada con éxito.";
    } else {
      $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
    }
  }
} else {
  $errors[] = "¡Un error desconocido ocurrió.";
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