<?php

/*-------------------------
  Autor: Frank Taibo
  Cod Menu: 002
  Cod Item Menu:001
  ---------------------------*/
  /* Connect To Database*/
  require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
  include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 
  
  if($action == 'ajax'){
    // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
     $aColumns = array('nombre_articulo');//Columnas de busqueda
     $sTable = "articulos t1";
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
   
    
    $sWhere.=" order by id_articulo asc";

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
    $reload = './002001articulo.php';
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
          <th>Descripción Arículo</th>
          <th>Via Administración</th>
        <th>Laboratorio</th>
          <th>Código ISP</th>
          <th>Código Barra</th>
          <th>Stock Mínimo</th>
          <th>Creador</th>
          <th><span class="pull-right">Acciones</span></th>       
        </tr>
        <?php
        while 
         ($row=mysqli_fetch_array($query)){
            $id_articulo=$row['id_articulo'];
            $nombre_articulo=$row['nombre_articulo'];
             $codigo_isp=$row['codigo_isp'];
              $codigo_barra=$row['codigo_barra'];
               $concentracion=$row['concentracion'];
                $forma_farmaceutica=$row['forma_farmaceutica'];
                 $via_administracion=$row['via_administracion'];
                  $unidad_medida=$row['unidad_medida'];
                    $laboratorio=$row['laboratorio'];
                     $tipo_articulo=$row['tipo_articulo'];
                      $stock_minimo=$row['stock_minimo'];
                       $activo=$row['activo'];
                        $fecha_creacion=$row['fecha_creacion'];
                         $usuario_creador_id=$row['usuario_creador_id'];

                         $select_user = "SELECT user_name 
                                         FROM users 
                                         WHERE user_id = '$usuario_creador_id'";
                        $query_user = mysqli_query($con, $select_user);

                      $row_nombre = mysqli_fetch_array($query_user);
                  $nombre_creador = $row_nombre['user_name'];
          ?>
          <tr>
             <td><?php echo $id_articulo;?></td>
            <td><?php echo $nombre_articulo.' '.$forma_farmaceutica.' '.$concentracion ; ?></td>
            <td><?php echo $tipo_articulo.' '.$via_administracion;?></td>
            <td><?php echo $laboratorio;?></td>
            <td><?php echo $codigo_isp;?></td>
            <td><?php echo $codigo_barra;?></td>
            <td><?php echo $stock_minimo;?></td>
             <td><?php echo $nombre_creador;?></td>
       
            
          <td ><span class="pull-right">
            <a href="#" class="btn btn-default <?php echo $activo == 1 ? 'btn-success':'btn-danger'; ?>" title="Activar/Desactivar" onclick="cambiar_estado('<?php echo $id_articulo; ?>','<?php echo $page; ?>');"><i class="icon-switch"></i></a>

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
