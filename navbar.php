  <?php
        include("modal/001002cambiar_password.php");
  //  require_once ("/config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  //  require_once ("/config/conexion.php");//Contiene funcion que conecta a la base de datos
  
    if (isset($title))
    {
      $id=$_SESSION['user_id'];
      $user_id=$_SESSION['user_name'];
      $user_consulta=$_SESSION['user_consulta'];
      $user_perfil_id=$_SESSION['user_perfil_id'];
      $user_nombre=$_SESSION['firstname'];
      $user_apellido=$_SESSION['lastname'];
     
  ?>


<nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="inicio.php"> FARMACIA</a>
  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
        <?php
          $uno=1;
        $corte_menu="xxx";
        $sql="select t3.menu_descripcion, t2.menu_item_descripcion, t2.menu_item_tipo,t2.menu_item_url, t2.menu_item_icono from acceso t1, menu_item t2, menu t3 where t1.perfil_id=".$user_perfil_id." and t1.menu_item_id=t2.menu_item_id and t2.menu_id=t3.menu_id and t3.menu_estado=1 and t2.menu_item_estado=1 order by menu_orden, menu_item_orden";    
        $query = mysqli_query($con, $sql);  
        //echo "ID ".$user_perfil_id;
        while ($row=mysqli_fetch_array($query)){
            $menu_descripcion=$row['menu_descripcion'];
            $menu_item_descripcion=$row['menu_item_descripcion'];
            $menu_item_url=$row['menu_item_url'];
            $menu_item_icono=$row['menu_item_icono'];
            $menu_item_tipo=$row['menu_item_tipo'];
            if ($corte_menu<>$menu_descripcion)
              {
                if ($uno==1)
                { 
                  $uno=2;
                }
                else
                {
                  ?> 
                  </ul>
                      </li>
                      <?php
                }
                ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu_descripcion?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
              <?php
              $corte_menu=$menu_descripcion;
              }
            ?>
                  <li>
                    <a href="<?php echo $menu_item_url;?>" target="<?php echo $menu_item_tipo == 1 ? '_blank ':'_self';?>" >
                      <i class='<?php echo $menu_item_icono; ?>'></i> <?php echo $menu_item_descripcion?>
                    </a>
                  </li>
            <?php
          }
          ?>
      </ul>
    </li>

    <hr>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">

        <?php 

          if ($_SESSION['user_password_set']==1 ) {
            ?>

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuario: <?php echo utf8_decode($user_nombre.' '.$user_apellido); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="get_user_id2('<?php echo $id;?>');" data-toggle="modal" data-target="#myModal3"><span class="icon-candado"></span> Cambiar Contraseña</a></li> 
            </ul>

            <?php
          }
          else { 

            ?>

              <a href="#" >Usuario: <?php echo utf8_decode($user_nombre.' '.$user_apellido); ?> / CE: <?php echo $nombre_ce ?></a>

            <?php

          }
        ?>
      <li><a href="login.php?logout"><span class="icon-entrar"></span> </i> Salir</a></li>
    </ul>
    

  </div>

</nav>

  <?php
    }
  ?>
<script type="text/javascript">
  
$( "#editar_password2" ).submit(function( event ) {
  $('#actualizar_datos3').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/001002editar_password.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax3").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax3").html(datos);
      $('#actualizar_datos3').attr("disabled", false);
      load(1);
      }
  });
  event.preventDefault();
})

  function get_user_id2(id){
    $("#user_id_mod").val(id);
  }

</script>