<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_listado="active";
	$title="Inicio.";
	if (isset($title))
		{
			$user_consulta=$_SESSION['user_consulta'];
		}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
  	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php if ($user_consulta=='0'){?> 
		    <div class="btn-group pull-right">
				
			</div>
			<?php } ?>
			<h4>FARMACIA</h4>
		</div>
		<div class="panel-body">
		
			
			
			
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
				
				
				
			</form>
			
			
		
	
			
			
			
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
  </body>
</html>
