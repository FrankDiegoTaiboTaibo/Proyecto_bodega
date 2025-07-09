<?php
  /*-------------------------
  Autor: Frank Taibo
  Cod Menu: 002
  Cod Item Menu:004
  ---------------------------*/
  session_start();
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
    exit;
        }

  /* Connect To Database*/ 
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    $active_usuarios="active";  
  $title="Stock Actual";
  if (isset($title))
    {
      
      $user_perfil_id=$_SESSION['user_perfil_id'];
      $menu_cod='002';
      $menu_item_cod='004';
    }
    include("modal/valida_permiso.php");
  
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

          <div class="btn-group pull-right">
          <button id='btnExportar' class='btn btn-success' onclick='descargar(1)'>
            <i class='icon-archivo-excel'></i> Descargar Excel
          </button>
        </div>


      <h4><i class='icon-validacion icono-titulo'></i> Stock Actual</h4>

    </div>      

      

      <div class="panel-body">
      
      <form class="form-horizontal" role="form" id="datos_cotizacion">
        
            <div class="form-group row">
              <label for="q" class="col-md-1 control-label">Artículo:</label>
              <div class="col-md-2">
                <input type="text" class="form-control" id="q" placeholder="Nombre Artículo" onkeyup='load(1);'>
              </div>

                   <label for="fil_fecha" class="col-md-1 control-label">Fecha Ingreso</label>
            <div class="col-md-2">
              <input class="form-control" id="fil_fecha" name="fil_fecha" type="text">
            </div>
              
              
              <div class="col-md-2">
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
  <script type="text/javascript" src="js/002004stock_actual.js"></script>

  
  


  </body>
</html>


