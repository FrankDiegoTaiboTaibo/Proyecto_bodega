<?php

/*-------------------------
  Autor: Frank Taibo
  Cod Menu: 001
  Cod Item Menu:004
  ---------------------------*/
  /* Connect To Database*/
  require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
  include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
  if (isset($_GET['id'])){
    $perfil_id=intval($_GET['id']);

    //$sql_acceso = ("select * from acceso where perfil_id='".$perfil_id."'");
    $perfil_acceso = mysqli_query($con, "select * from acceso where perfil_id='".$perfil_id."'");
    $count_acceso=mysqli_num_rows($perfil_acceso);
    //$sql_users = ("select * from users where perfil_id='".$perfil_id."'");
    $perfil_users = mysqli_query($con, "select * from users where perfil_id='".$perfil_id."'");
    $count_users=mysqli_num_rows($perfil_users);
    
    if ($perfil_id!=1 && $count_users<1 && $count_acceso<1){


      if ($delete1=mysqli_query($con,"DELETE FROM perfil WHERE perfil_id='".$perfil_id."'")){
      ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso!</strong> Datos eliminados exitosamente..
      </div>
      <?php 
    }else {
      
      ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
      </div>
      <?php
      
    }
      
      } if ($perfil_id<=1){
      ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> No se puede borrar el usuario administrador. 
        </div>
      <?php
      } if($count_users>0) {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> Este perfil esta en uso. 
        </div>
      <?php
      } if($count_acceso>0) {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> Este perfil esta con accesos abiertos. 
        </div>
      <?php
      } 
    }
    
    
    
  
  if($action == 'ajax'){
    // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
     $aColumns = array('perfil_descripcion');//Columnas de busqueda
     $sTable = "perfil t1";
     $sWhere = "";
    if ( $_GET['q'] != "" )
    {
      $sWhere = "WHERE (";
      for ( $i=0 ; $i<count($aColumns) ; $i++ )
      {
        $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
      }
      $sWhere = substr_replace( $sWhere, "", -3 );
      $sWhere .= ')';
    }
    if ( $_GET['q'] == "" ) {
      $sWhere.=" where t1.perfil_id=t1.perfil_id"; 
    }
    else {
      $sWhere.=" and t1.perfil_id=t1.perfil_id"; 
      }
    
    $sWhere.=" order by perfil_id asc";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 10; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row= mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    $reload = './001004perfiles.php';
    //main query to fetch the data
    $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows>0){
      
      ?>
      <div class="table-responsive">
        <table class="table">
        <tr  class="info">
          <th>ID</th>
          <th>Nombre Perfil</th>
          <th><span class="pull-right">Acciones</span></th>       
        </tr>
        <?php
        while 
         ($row=mysqli_fetch_array($query)){
            $perfil_id=$row['perfil_id'];
            $perfil_descripcion=$row['perfil_descripcion'];
          ?>
          <input type="hidden" value="<?php echo $row['perfil_descripcion'];?>" id="perfil<?php echo $perfil_id;?>">
          <tr>
            <td><?php echo $perfil_id; ?></td>
            <td><?php echo $perfil_descripcion;?></td>
            
          <td ><span class="pull-right">
          <a href="#" class='btn btn-default' title='Ver usuarios' data-id="<?php echo $perfil_id; ?>" data-toggle="modal" data-target="#ver_usuarios"><i class="icon-usuarios"></i></a>
          <a href="#" class='btn btn-default' title='Ver accesos' data-id="<?php echo $perfil_id; ?>" data-toggle="modal" data-target="#ver_accesos"><i class="icon-barrera"></i></a> 
          <a href="#" class='btn btn-default' title='Editar perfiles' onclick="obtener_datos('<?php echo $perfil_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
          <a href="#" class='btn btn-default' title='Duplicar perfil y accesos' data-id="<?php echo $perfil_id; ?>"  data-descripcion="<?php echo $perfil_descripcion.' COPIA'; ?>" data-toggle="modal" data-target="#myModal4"><i class="glyphicon glyphicon-duplicate"></i></a> 
          <a href="#" class='btn btn-default' title='Borrar perfil' onclick="eliminar('<?php echo $perfil_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
            
          </tr>
          <?php
        }
        ?>
        <tr>
          <td colspan=9><span class="pull-right">
          <?php
           echo paginate($reload, $page, $total_pages, $adjacents);
          ?></span></td>
        </tr>
        </table>
      </div>
      <?php
    }
  }
?>
