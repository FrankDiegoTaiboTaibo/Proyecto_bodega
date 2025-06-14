<?php
/*-------------------------
  Autor: Frank Taibo
  Cod Menu: 001
  Cod Item Menu:005
  ---------------------------*/
include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

//Valido si el menú contiene correspondencia con otra tabla, en caso de que no existan se borra
if (isset($_GET['id'])) {
  $menu_id = intval($_GET['id']);
  $sql = "SELECT * FROM menu INNER JOIN menu_item ON menu.menu_id = menu_item.menu_id WHERE menu.menu_id = '" . $menu_id . "'";
  $query = mysqli_query($con, $sql);
  $count = mysqli_num_rows($query);
  if ($count == 0) {

    //Cambio de orden en los menus superiores
    $query = mysqli_query($con, "SELECT menu_orden FROM menu WHERE menu_id = '" . $menu_id . "'");
    $fila = mysqli_fetch_array($query);
    $ex_orden = $fila['menu_orden'];
    $sql_orden = mysqli_query($con, "SELECT * FROM menu WHERE menu_orden > '" . $ex_orden . "'");

    while ($rows = mysqli_fetch_array($sql_orden)) {
      $pos = $rows['menu_orden'];
      $sql_update = "UPDATE menu SET menu_orden='" . ($pos - 1) . "' WHERE menu_id='" . $rows['menu_id'] . "'";
      $query_update = mysqli_query($con, $sql_update);
    }

    //Eliminación del menú
    if ($delete1 = mysqli_query($con, "DELETE FROM menu WHERE menu_id='" . $menu_id . "'")) {
?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>¡Aviso!</strong> Datos eliminados exitosamente.
      </div>
    <?php
    } else {
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
      <strong>¡Error!</strong> No se pudo eliminar el Menú. Existe correspondencia vinculada a Menú.
    </div>
  <?php
  }
}
if ($action == 'ajax') {
  // escaping, additionally removing everything that could be (html/javascript-) code
  $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
  $aColumns = array('menu_descripcion'); //Columnas de busqueda
  $sTable = "menu";
  $sWhere = "";
  if ($_GET['q'] != "") {
    $sWhere = "WHERE (";
    for ($i = 0; $i < count($aColumns); $i++) {
      $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
  }
  $sWhere .= " order by menu_orden";
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
  $reload = './001002ce.php';
  //main query to fetch the data
  $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
  $query = mysqli_query($con, $sql);
  //loop through fetched data
  if ($numrows > 0) {

  ?>
    <div class="table-responsive">
      <table class="table">
        <tr class="info">
          <th>Orden</th>
          <th>Nombre Menú</th>
          <th>Estado</th>
          <th>Código</th>

          <th class='text-right'>Acciones</th>

        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
          $menu_id = $row['menu_id'];
          $menu_descripcion = $row['menu_descripcion'];
          $menu_cod = $row['menu_cod'];
          $menu_orden = $row['menu_orden'];
          $menu_estado = $row['menu_estado'];
          //$date_added= date('d/m/Y', strtotime($row['date_added']));

        ?>
          <tr>

            <td><?php echo $menu_orden; ?></td>
            <td><?php echo $menu_descripcion; ?></td>
            <td><?php

                if ($menu_estado == 1)
                  echo '<p class="text-success">Activado</p>';
                else
                  echo '<p class="text-danger">Desactivado</p>';

                ?></td>
            <td><?php echo $menu_cod; ?></td>

            <td class='text-right'>
              <a href="#" class='btn btn-default' title='Editar Menú' data-id='<?php echo $menu_id; ?>' data-nombre='<?php echo $menu_descripcion; ?>' data-estado='<?php echo $menu_estado ?>' data-codigo='<?php echo $menu_cod; ?>' data-orden='<?php echo $menu_orden; ?>' data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
              <a href="#" class='btn btn-default' title='Borrar Menú' onclick="eliminar('<?php echo $menu_id; ?>', '<?php echo $menu_descripcion; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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