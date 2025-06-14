<?php
  include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
  /* Connect To Database*/
  require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
  
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  if($action == 'ajax'){
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id = mysqli_real_escape_string($con,(strip_tags($_REQUEST['id'], ENT_QUOTES)));

    $sql_usuarios = "SELECT t2.menu_item_id,
                            t2.menu_item_descripcion,
                            t2.menu_item_icono,
                            t2.menu_id,
                            t3.menu_descripcion
                     FROM acceso t1
                     INNER JOIN menu_item t2 ON t1.menu_item_id = t2.menu_item_id
                     INNER JOIN menu t3 ON t2.menu_id = t3.menu_id
                     WHERE t1.perfil_id = '$id'
                     ORDER BY t2.menu_id ASC, t2.menu_item_id ASC";

    $query = mysqli_query($con, $sql_usuarios);
    $numrows = mysqli_num_rows($query);

    if ($numrows>0){
      
      ?>
      <div class="table-responsive">
        <table class="table">
        <?php

        $menu_id = 0;

        while ($row=mysqli_fetch_array($query)){

            if($menu_id != $row['menu_id']){

              $menu_id = $row['menu_id'];
              $menu_descripcion = $row['menu_descripcion'];

              ?>

                <tr  class="success">
                  <th><?php echo $menu_descripcion;?></th>
                </tr>

              <?php

            }

            $menu_item_icono = $row['menu_item_icono'];
            $menu_item_descripcion = $row['menu_item_descripcion'];

          ?>
          <tr>
            
            <td><i class='<?php echo $menu_item_icono; ?>'></i><?php echo ' '.$menu_item_descripcion;?></td>
          
          </tr>
          <?php
        }
        ?>
        </table>
      </div>
      <?php
    }
    else{

      echo "Sin accesos";

    }


  }
?>