<?php
  /*-------------------------
  Autor: Frank Taibo
  Cod Menu: 002
  Cod Item Menu:001
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
  $title="Artículo";
  if (isset($title))
    {
      
      $user_perfil_id=$_SESSION['user_perfil_id'];
      $menu_cod='002';
      $menu_item_cod='001';
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
    <div class="container-fluid">
    <div class="panel panel-primary">
    <div class="panel-heading">
        <div class="btn-group pull-right">
        <button type='button' class="btn btn-success" data-toggle="modal" data-target="#registroArticulo"><span class="glyphicon glyphicon-plus" ></span> Nuevo Artículo</button>
      </div>
      <h4><i class='icon-encuesta icono-titulo'></i> Artículo</h4>
    </div>      
    
      <?php
      include("modal/002001registro_articulo.php");
       include("modal/002001editar_articulo.php");
     /* include("modal/001002registro_usuarios.php");
      include("modal/001002ver_usuarios.php"); */
     /*  
      
      
      require_once("modal/001002cambiar_password.php");
      
      */ ?> 
       <div class="panel-body">
      <form class="form-horizontal" role="form" id="datos_cotizacion">
        
            <div class="form-group row">
              <label for="q" class="col-md-1 control-label">Artículo:</label>
              <div class="col-md-3">
                <input type="text" class="form-control" id="q" placeholder="Nombre Artículo" onkeyup='load(1);'>
              </div>

              <label for="fil_tipo" class="col-sm-1 control-label">Tipo</label>
            <div class='col-sm-2'>
              <select id="fil_tipo" class='selectpicker form-control' title="Seleccione el tipo" onchange='load(1);'>
                <option value="" selected>TODOS</option>
                <option value="Medicamento">Medicamento</option>
                                        <option value="Insumo Médico">Insumo Médico</option>
                                        <option value="Dispositivo Médico">Dispositivo Médico</option>
                                        <option value="Vacuna">Vacuna</option>
                                        <option value="Material de Curación">Material de Curación</option>
                                        <option value="Producto de Laboratorio">Producto de Laboratorio</option>
                                        <option value="Elemento de Protección Personal">Elemento de Protección Personal</option>
                                        <option value="Otros">Otros</option>
              </select>
            </div>

          <label for="fil_estado" class="col-sm-1 control-label">Estado</label>
            <div class='col-sm-2'>
              <select id="fil_estado" class='selectpicker form-control' title="Seleccione el estado" onchange='load(1);'>
                <option value="" selected>TODOS</option>
                <option value="1">Habilitado</option>
                <option value="0">Deshabilitado</option>
              </select>
            </div>
              
              
              
              <div class="col-md-2">
                <button type="button" class="btn btn-default" onclick='load(1);'>
                  <span class="glyphicon glyphicon-search" ></span> Buscar</button>
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
  <script type="text/javascript" src="js/002001articulos.js"></script>

  
  


  </body>
</html>


