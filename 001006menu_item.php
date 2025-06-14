<?php
  /*-------------------------
  Autor: Frank Taibo
  Cod Menu: 001
  Cod Item Menu:006
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
  $title="Menu item";
  if (isset($title))
    {
      
      $user_perfil_id=$_SESSION['user_perfil_id'];
      $menu_cod='001';
      $menu_item_cod='006';
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
        <button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" ></span> Nuevo Item Menu</button>
      </div>
      <h4><i class='icon-lista icono-titulo'></i> Ítems Menú</h4>
    </div>      
      <div class="panel-body">
      <?php
      include("modal/001006registro_menu_item.php");
      include("modal/001006editar_menu_item.php");
      ?>
      <form class="form-horizontal" role="form" id="datos_cotizacion">
        
            <div class="form-group row">
              <label for="q" class="col-md-2 control-label">Nombres Ítem Menú:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" id="q" placeholder="Nombre" onkeyup='load(1);'>
              </div>
              
              
              
              <div class="col-md-3">
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
  <script type="text/javascript" src="js/001006menu_item.js"></script>
  <script type="text/javascript" src="js/bootstrap-select.js"></script>
  
  


  </body>
</html>
<script>
$( "#guardar_menu_item" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/001006nuevo_menu_item.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#guardar_datos').attr("disabled", false);
      load(1);
      }
  });
  event.preventDefault();
})

$( "#editar_menu_item" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/001006editar_menu_item.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax2").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax2").html(datos);
      $('#actualizar_datos2').attr("disabled", false);
      load(1);
      }
  }); 
  event.preventDefault();
})

  function get_user_id(id){
    $("#user_id_mod").val(id);
  }

function obtener_datos(id){
var item_descripcion = $("#descripcion_i"+id).val();
      var menu_id = $("#menu_i"+id).val();
      var item_url = $("#url_i"+id).val();
      var item_tipo = $("#tipo_i"+id).val();
      var item_estado = $("#estado_i"+id).val();
      var item_interno = $("#interno_i"+id).val();
      var item_codigo = $("#codigo_i"+id).val();
      var item_orden = $("#orden_i"+id).val();
      var item_icono = $("#icono_i"+id).val();

      $("#mod_id").val(id);
      $("#item_descripcion2").val(item_descripcion);
      $("#menu_id2").val(menu_id);
      $("#item_url2").val(item_url);
      $("#item_tipo2").val(item_tipo);
      $("#item_estado2").val(item_estado);
      $("#item_interno2").val(item_interno);
      $("#item_codigo2").val(item_codigo);
      $("#item_orden2").val(item_orden);
      $("#item_icono2").val(item_icono);

    if ($("#"+item_icono).length ) {
        $("#"+item_icono)[0].checked = true;
      } 
    if(item_tipo == 0)
      $("#item_tipo2")[0].checked = false;
    else
      $("#item_tipo2")[0].checked = true;

    if(item_estado == 0)
      $("#item_estado2")[0].checked = false;
    else
      $("#item_estado2")[0].checked = true;

    if(item_interno == 0)
      $("#item_interno2")[0].checked = false;
    else
      $("#item_interno2")[0].checked = true;  

    }
</script>