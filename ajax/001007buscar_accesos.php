<?php
/*-------------------------
  Autor: Frank Taibo
  Cod Menu: 001
  Cod Item Menu:007
  ---------------------------*/
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {
  // escaping, additionally removing everything that could be (html/javascript-) code
  $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
  $aColumns = array('perfil_descripcion'); //Columnas de busqueda
  $sTable = "acceso AS T1 
		            JOIN perfil AS T2 ON T1.perfil_id = T2.perfil_id 
		            JOIN menu_item AS T3 ON T1.menu_item_id = T3.menu_item_id ";
  $sWhere = "";
  if ($_GET['q'] != "") {
    $sWhere = "WHERE (";
    for ($i = 0; $i < count($aColumns); $i++) {
      $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
  }
  include 'pagination.php'; //include pagination file
  //pagination variables
  $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
  $per_page = 10; //how much records you want to show
  $adjacents  = 4; //gap between pages after number of adjacents
  $offset = ($page - 1) * $per_page;
  //Count the total number of row in your table*/
  $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM perfil");
  $row = mysqli_fetch_array($count_query);
  $numrows = $row['numrows'];
  $total_pages = ceil($numrows / $per_page);
  $reload = './001007accesos.php';
  //main query to fetch the data
  $sql = "SELECT * FROM  perfil $sWhere LIMIT $offset,$per_page";
  $query = mysqli_query($con, $sql);
  //loop through fetched data
  if ($numrows > 0) {

?>
    <div class="table-responsive">
      <table class="table">
        <tr class="info">
          <th>Nombre Perfil</th>
          <th>Menú Ítems</th>
          <th class='text-right'>Acciones</th>

        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
          $nombre_perfil = $row['perfil_descripcion'];
          $id_perfil = $row['perfil_id'];
          //$date_added= date('d/m/Y', strtotime($row['date_added']));
        ?>

          <tr>
            <td><?php echo $nombre_perfil; ?></td>
            <td>

              <?php

              $menu_item_ids = "";
              $sql_menu = "SELECT * FROM menu ORDER BY menu_orden ASC";
              $query_menu = mysqli_query($con, $sql_menu);

              while ($row_menu = mysqli_fetch_array($query_menu)) {

                $menu_id = $row_menu['menu_id'];

                //Verifica que solo muestre los menus que esten asociados al perfil
                $sql_count_menu = "SELECT COUNT(*) AS filas FROM acceso AS T1 JOIN menu_item AS T2 ON T1.menu_item_id = T2.menu_item_id JOIN menu AS T3 ON T2.menu_id = T3.menu_id WHERE T3.menu_id = $menu_id AND T1.perfil_id = $id_perfil";

                $sql_query_menu = mysqli_query($con, $sql_count_menu);
                $cantidad_menus = mysqli_fetch_array($sql_query_menu);
                $cantidad_filas = $cantidad_menus['filas'];

                if ($cantidad_filas > 0) {
              ?>
                  <b><u><?php echo $row_menu['menu_descripcion'] ?></u></b>
                  </br>
                <?php
                }

                //Consulta de los menu_items pertenecientes al perfil de su respectivo menu
                $sql_menu_items = "SELECT * FROM $sTable WHERE T1.perfil_id = $id_perfil and T3.menu_id = $menu_id ORDER BY T3.menu_id ASC, T3.menu_item_orden ASC";
                $query_items = mysqli_query($con, $sql_menu_items);

                $menu_item_descripcion = "";

                while ($row_item = mysqli_fetch_array($query_items)) {

                  $menu_item_descripcion = $row_item['menu_item_descripcion'];
                  $menu_item_icono = $row_item['menu_item_icono'];

                ?>
                  <p><i class='<?php echo $menu_item_icono; ?>'></i> <?php echo $menu_item_descripcion ?></p>
              <?php
                  //Almacenos los ids de sus menu_items para su visualizacion en editar
                  $menu_item_ids .= $row_item['menu_item_id'] . ",";
                }
              }

              $menu_item_ids = substr($menu_item_ids, 0, -1);


              ?>
            </td>

            <td class='text-right'>
              <a href="#" class='btn btn-default' title='Editar Acceso' data-id_perfil='<?php echo $id_perfil; ?>' data-nombre_perfil='<?php echo $nombre_perfil; ?>' data-items_ids="<?php echo $menu_item_ids; ?>" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
            </td>

          </tr>
        <?php
        }
        ?>
        <tr>
          <td colspan=8><span class="pull-right">
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