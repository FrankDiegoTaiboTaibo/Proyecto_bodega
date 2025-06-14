<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
}		

      require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			

				// escaping, additionally removing everything that could be (html/javascript-) code
        $perfil_id=$_GET['perfil'];
        $user_id=$_GET['id'];
        $name=$_GET['name'];
        $des_perfil=$_GET['des_perfil'];
        
            
        $sql_acceso = "SELECT menu_item.menu_item_descripcion AS Descripcion_item, menu_item.menu_id AS menu, menu.menu_descripcion AS descripcion_menu
          FROM menu_item
          INNER JOIN acceso ON menu_item.menu_item_id = acceso.menu_item_id 
          INNER JOIN perfil ON acceso.perfil_id = perfil.perfil_id 
          INNER JOIN users ON perfil.perfil_id = users.perfil_id
          INNER JOIN menu ON menu.menu_id = menu_item.menu_id 
          where perfil.perfil_id = $perfil_id and users.user_id = $user_id ORDER BY menu ASC";

        $sql = "SELECT usersxce.id_ce AS id, CONCAT(ce.descripcion_ce,' ',ce.nombre_ce) AS nombre
          FROM usersxce
          INNER JOIN users ON usersxce.user_id = users.user_id
          INNER JOIN ce ON usersxce.id_ce = ce.id_ce
          where usersxce.user_id = $user_id";

        $acceso_result = mysqli_query($con,$sql_acceso);
        $sql_result = mysqli_query($con,$sql);        
    
      //  $numero_acceso = mysqli_num_rows($acceso_result);
     //   echo 'Acesos'.$numero_acceso.' -- '; 
        ?>


        <div class="table-responsive table-bordered">
        <table class="table">
          <thead>
            <tr class="success">
              <th colspan="2">Perfil</th>
            </tr>
            <tr>
              <td colspan="2"><?php echo $des_perfil;?></td>
            </tr>
            <tr class="success">
              <th>Accesos</th>
             
            </tr>
          </thead>
          <tbody>
            <td>
              <?php $id_anterior = 0;
                   while ($row_acceso=mysqli_fetch_array($acceso_result)){
                      $descripcion_item=$row_acceso['Descripcion_item'];
                      $menu_id=$row_acceso['menu'];
                      $menu_des=$row_acceso['descripcion_menu']; 
                      if($menu_id <> $id_anterior){
                        ?> <p><strong> <?php echo $menu_des; ?> </strong> </p> 
                          <p> <?php echo $descripcion_item; ?></p>
                        <?php
                      }else{  ?> 
                        <p> <?php echo $descripcion_item; ?></p> <?php }        
                      ?>     
                 
                   <?php 
                   $id_anterior = $menu_id;
                   }
                   ?>
             
              </td>

            
          </tr>
        </tbody>
      </table>
    </div>




 <?php

?>