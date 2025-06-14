<?php
  include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
  /* Connect To Database*/
  require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
  
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  if($action == 'ajax'){
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id = mysqli_real_escape_string($con,(strip_tags($_REQUEST['id'], ENT_QUOTES)));

    $sql_usuarios = "SELECT t2.user_id, t2.firstname, t2.lastname, t2.user_name
                     FROM perfil t1 INNER JOIN users t2 ON t1.perfil_id = t2.perfil_id
                     WHERE t1.perfil_id = $id";

    $query = mysqli_query($con, $sql_usuarios);
    $numrows = mysqli_num_rows($query);

    if ($numrows>0){
      
      ?>
      <div class="table-responsive">
        <table class="table">
        <tr  class="success">
          <th>Id</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Usuario</th>
        </tr>
        <?php
        while ($row=mysqli_fetch_array($query)){
            $user_id = $row['user_id'];
            $nombre = $row['firstname'];
            $apellido = $row['lastname'];
            $user_name= $row['user_name'];
          ?>
          <tr>
            
            <td><?php echo $user_id;?></td>
            <td><?php echo $nombre;?></td>
            <td><?php echo $apellido;?></td>
            <td><?php echo $user_name;?></td>
            
          </tr>
          <?php
        }
        ?>
        </table>
      </div>
      <?php
    }
  }
?>