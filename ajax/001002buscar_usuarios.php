<?php
/*-------------------------
  Autor: Frank Taibo
  Cod Menu: 001
  Cod Item Menu:002
  ---------------------------*/
  require_once ("../config/db.php");
  require_once ("../config/conexion.php");
  include('is_logged.php');

  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  if (isset($_GET['id'])){

    $user_id=intval($_GET['id']);

    $sql_verificacion = "SELECT *
                         FROM users t2
                         WHERE t2.user_id = $user_id";

    $query_verificacion = mysqli_query($con, $sql_verificacion);
    $fila_verificacion = mysqli_fetch_array($query_verificacion);

      if ($user_id != 1 ){
        if ($delete1=mysqli_query($con,"DELETE FROM users WHERE user_id='".$user_id."'")){
        ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Aviso!</strong> Datos eliminados exitosamente..
          </div>
        <?php 
        }else {
        ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
          </div>
        <?php
        
      }
        
      } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>¡Error!</strong> No se puede borrar el usuario administrador. 
        </div> 
        <?php
      }

    }
    
  if($action == 'ajax'){

     $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
     $aColumns = array('firstname', 'lastname');//Columnas de busqueda
     $sTable = "users t1 
                LEFT JOIN perfil t3 ON t1.perfil_id=t3.perfil_id";
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

    if ($_SESSION['user_id'] != 1){ //Sólo el admin es capaz de verse en la búsqueda
      $sWhere.=" and t1.user_id <> 1";
    }
    
    $sWhere.=" order by user_id desc";

    include 'pagination.php'; 

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 10;
    $adjacents  = 4; 
    $offset = ($page - 1) * $per_page;
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row= mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    $reload = './001002usuarios.php';
   
    $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    
    if ($numrows>0){
      
      ?>
      <div class="table-responsive">
        <table class="table">
        <tr  class="info">
          <th>ID</th>
          <th>Nombres</th>
          <th>Usuario</th>
          <th>Rut</th>
          <th>Email</th>
          <th>Agregado</th>
          <th>Perfil</th>
          <th class='text-right'>Acciones</th>
          
        </tr>
        <?php

        while ($row=mysqli_fetch_array($query)){
            $user_id=$row['user_id'];
            $fullname=$row['firstname']." ".$row["lastname"];
            $user_name=$row['user_name'];
            $user_rut=$row['user_rut'];
            $user_email=$row['user_email'];
            $user_password_set=$row['user_password_set'];
            $perfil_id=$row['perfil_id'];
            $perfil_descripcion=$row['perfil_descripcion'];
            $date_added= date('d/m/Y', strtotime($row['date_added']));

          ?>
          
          <input type="hidden" value="<?php echo $row['firstname'];?>" id="nombres<?php echo $user_id;?>">
          <input type="hidden" value="<?php echo $row['lastname'];?>" id="apellidos<?php echo $user_id;?>">
          <input type="hidden" value="<?php echo $user_name;?>" id="usuario<?php echo $user_id;?>">
          <input type="hidden" value="<?php echo $user_rut;?>" id="userrut<?php echo $user_id;?>">
          <input type="hidden" value="<?php echo $user_email;?>" id="email<?php echo $user_id;?>">
          <input type="hidden" value="<?php echo $user_password_set;?>" id="user_password_set<?php echo $user_id;?>">
          <input type="hidden" value="<?php echo $perfil_id;?>" id="userperfilid<?php echo $user_id;?>">
          
          <tr title="Ver Usuario <?php echo $fullname; ?>" data-id="<?php echo $user_id; ?>"> 
            <td><?php echo $user_id; ?></td>
            <td><?php echo $fullname; ?></td>
            <td ><?php echo $user_name; ?></td>
            <td ><?php echo $user_rut; ?></td>
            <td ><?php echo $user_email; ?></td>
            <td><?php echo $date_added;?></td>
            <td><?php echo $perfil_descripcion;?></td>
            
          <td ><span class="pull-right">

          <a href="#" class='btn btn-default' title='Editar usuario' onclick="obtener_datos('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 

          <a href="#" class='btn btn-default' title='Cambiar contraseña' onclick="get_user_id('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal3"><i class="icon-candado"></i></a>

          <a href="#" class='btn btn-default' title='Ver usuario' onclick="obtener_mas_datos('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal4" data-id = "<?php echo $user_id; ?>" data-perfil = "<?php echo $perfil_id; ?>" data-name = "<?php echo $fullname; ?>" data-des_perfil = "<?php echo $perfil_descripcion; ?>"><i class="glyphicon glyphicon-search"></i></a>

          <a href="#" class='btn btn-danger' title='Borrar usuario' onclick="eliminar('<?php echo $user_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>

        </span></td>
            
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