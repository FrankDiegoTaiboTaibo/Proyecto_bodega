<?php
/*-------------------------
	Autor: Frank Taibo
	Cod Menu: 001
	Cod Item Menu:007
	---------------------------*/
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
  header("location: login.php");
  exit;
}

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos

$active_area = "active";
$title = "Accesos";
if (isset($title)) {
  $user_consulta = $_SESSION['user_consulta'];
  $user_perfil_id = $_SESSION['user_perfil_id'];
  $menu_cod = '001';
  $menu_item_cod = '007';
}
include("modal/valida_permiso.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("head.php"); ?>
</head>

<body>
  <?php
  include("navbar.php");
  ?>

  <div class="container">
    <div class="panel panel-primary">

      <div class="panel-heading">
        <h4><i class='icon-barrera icono-titulo'></i> Accesos</h4>
      </div>
      <div class="panel-body">
        <?php
        include("modal/001007editar_accesos.php");
        ?>
        <form class="form-horizontal" role="form" id="datos_cotizacion">

          <div class="form-group row">
            <label for="q" class="col-md-2 control-label">Nombre Perfil:</label>
            <div class="col-md-5">
              <input type="text" class="form-control" id="q" placeholder="Nombre perfil" onkeyup='load(1);'>
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-default" onclick='load(1);'>
                <span class="glyphicon glyphicon-search"></span> Buscar</button>
              <span id="loader"></span>
            </div>

          </div>

        </form>
        <div id="resultados"></div><!-- Carga los datos ajax -->
        <div class='outer_div'></div><!-- Carga los datos ajax -->

      </div>
    </div>

  </div>
  <hr>
  <?php
  include("footer.php");
  ?>
  <script type="text/javascript" src="js/001007accesos.js"></script>
</body>

</html>