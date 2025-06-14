<?php
/*-------------------------
	Autor: Frank Taibo
	Cod Menu: 001
	Cod Item Menu:006
	---------------------------*/
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
  $menu_item_id = intval($_GET['id']);
  //echo "select * from users where user_id='".$user_id."'";
  $query = mysqli_query($con, "select * from menu_item where menu_item_id='" . $menu_item_id . "'");
  $rw_menu_item = mysqli_fetch_array($query);
  $count = $rw_menu_item['menu_item_id'];

  $quesry_acceso = mysqli_query($con, "select * from acceso where menu_item_id='" . $menu_item_id . "'");
  $count_acceso = mysqli_num_rows($quesry_acceso);

  if ($menu_item_id != 1 && $count_acceso < 1) {
    //echo "DELETE FROM users WHERE user_id='".$user_id."'";
    if ($delete1 = mysqli_query($con, "DELETE FROM menu_item WHERE menu_item_id='" . $menu_item_id . "'")) {
?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso!</strong> Datos eliminados exitosamente..
      </div>
    <?php
    } else {
    ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
      </div>
    <?php

    }
  } else {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong> No se puede borrar este item ya que se esta dando acceso.
    </div>
  <?php
  }
}
if ($action == 'ajax') {
  // escaping, additionally removing everything that could be (html/javascript-) code
  $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
  $aColumns = array('menu_item_descripcion', 'menu_item_url'); //Columnas de busqueda
  $sTable = "menu_item t1";
  $sWhere = "";
  if ($_GET['q'] != "") {
    $sWhere = "WHERE (";
    for ($i = 0; $i < count($aColumns); $i++) {
      $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
  }
  if ($_GET['q'] == "") {
    $sWhere .= " where t1.menu_item_id=t1.menu_item_id";
  } else {
    $sWhere .= " and t1.menu_item_id=t1.menu_item_id";
  }

  $sWhere .= " order by menu_item_id asc";

  include 'pagination.php'; //include pagination file
  //pagination variables
  $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
  $per_page = 10; //how much records you want to show
  $adjacents  = 4; //gap between pages after number of adjacents
  $offset = ($page - 1) * $per_page;
  //Count the total number of row in your table*/
  $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
  $row = mysqli_fetch_array($count_query);
  $numrows = $row['numrows'];
  $total_pages = ceil($numrows / $per_page);
  $reload = './001006menu_item.php';
  //main query to fetch the data
  $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
  //echo $sql;
  $query = mysqli_query($con, $sql);
  //loop through fetched data
  if ($numrows > 0) {

  ?>
    <div class="table-responsive">
      <table class="table">
        <tr class="info">
          <th>ID</th>
          <th>Descripción</th>
          <th>Menú Descripción</th>
          <th>URL</th>
          <th>Estado</th>
          <th>Interno</th>
          <th>Código Ítem</th>
          <th>Orden</th>
          <th>Icono</th>
          <th><span class="pull-right">Acciones</span></th>

        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
          $menu_item_id = $row['menu_item_id'];
          $menu_item_descripcion = $row['menu_item_descripcion'];
          $menu_id = $row['menu_id'];
          $menu_item_url = $row['menu_item_url'];
          $menu_item_tipo = $row['menu_item_tipo'];
          $menu_item_estado = $row['menu_item_estado'];
          $menu_item_interno = $row['menu_item_interno'];
          $menu_item_cod = $row['menu_item_cod'];
          $menu_item_orden = $row['menu_item_orden'];
          $menu_item_icono = $row['menu_item_icono'];



          $sql_2 = "SELECT DISTINCT( t1.menu_descripcion ) FROM menu AS t1 JOIN menu_item AS t2 ON t1.menu_id = t2.menu_id where t2.menu_id = $menu_id";
          $query2 = mysqli_query($con, $sql_2);
          $sql_descripcion = mysqli_fetch_array($query2);
          $sql_descripcion_row = $sql_descripcion['menu_descripcion'];

          //echo "ID USER".$user_id;
        ?>
          <?php  //echo "select icono from icono where icono ='".$menu_item_icono."';";	
          $sql_icono = mysqli_query($con, "select icono_id from icono where icono ='" . $menu_item_icono . "';");
          $row_icon = mysqli_fetch_array($sql_icono);
          $hola = $row_icon['icono_id'];    ?>
          <input type="hidden" value="<?php echo $menu_item_descripcion; ?>" id="descripcion_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $menu_id; ?>" id="menu_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $menu_item_url; ?>" id="url_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $menu_item_tipo; ?>" id="tipo_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $menu_item_estado; ?>" id="estado_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $menu_item_interno; ?>" id="interno_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $menu_item_cod; ?>" id="codigo_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $menu_item_orden; ?>" id="orden_i<?php echo $menu_item_id; ?>">
          <input type="hidden" value="<?php echo $hola; ?>" id="icono_i<?php echo $menu_item_id; ?>">
          <tr>
            <td><?php echo $menu_item_id; ?></td>
            <td><?php echo $menu_item_descripcion; ?></td>
            <td><?php echo $sql_descripcion_row; ?></td>
            <td><?php echo $menu_item_url; ?></td>
            <td><?php echo $menu_item_estado; ?></td>
            <td><?php echo $menu_item_interno; ?></td>
            <td><?php echo $menu_item_cod; ?></td>
            <td><?php echo $menu_item_orden; ?></td>
            <td><i class="<?php echo  $menu_item_icono; ?>"></i></td>

            <td><span class="pull-right">
                <a href="#" class='btn btn-default' title='Editar usuario' onclick="obtener_datos('<?php echo $menu_item_id; ?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>

                <a href="#" class='btn btn-default' title='Borrar usuario' onclick="eliminar('<?php echo $menu_item_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

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