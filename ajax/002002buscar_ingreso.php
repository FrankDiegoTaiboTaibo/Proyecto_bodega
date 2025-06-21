<?php
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos.
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos mysql.

include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado.
include 'pagination.php'; //incluir archivo de paginación.
mysqli_set_charset($con, "utf8");

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : ''; //token de acceso.

if ($action == 'ajax') {

    $q = trim($_GET['q']);
       $fil_fecha = $_GET['fil_fecha'];
  /*$fil_tipo = trim($_GET['fil_tipo']);
  $fil_estado = trim($_GET['fil_estado']); */

    $sql = "SELECT COUNT(*) AS numrows
          FROM ingreso t1
          LEFT JOIN articulos t2 ON t1.id_articulo = t2.id_articulo
          LEFT JOIN users t3 ON t1.usuario_creador_id = t3.user_id
          WHERE t2.nombre_articulo LIKE '%$q%'";

     $fecha = "";
  if (!empty($fil_fecha)) {

    $fecha = explode("/", $fil_fecha);
    $mes = $fecha[0];
    $anio = $fecha[1];

    $sql .= "AND MONTH(t1.fecha_ingreso) = '$mes' AND YEAR(t1.fecha_ingreso) = '$anio' ";
  }

 /* if ($_GET['fil_estado'] != "") {
    $sql .= " AND t1.estado_documento = '$fil_estado' ";
  }

  if ($_GET['fil_tipo'] != "") {
    $sql .= " AND t1.id_documento_tipo = '$fil_tipo' ";
  } */

    //______________________________________Paginacion
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; // cuantos registros quieres mostrar
    $adjacents  = 4; // espacio entre páginas después del número de adyacentes
    $offset = ($page - 1) * $per_page;

    $query  = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    $numrows = $row['numrows'];

    $total_pages = ceil($numrows / $per_page);
    $reload = './002002ingresos.php';

    $sql = str_replace('COUNT(*) AS numrows', '*', $sql);
    $sql .=  " ORDER BY t1.id_ingreso DESC LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);

    //_______________________________________Tabla
    if ($numrows > 0) {
?>
        <div class="small">
            <div class="table-responsive ">
                <table class="table table-hover table-small">
                    <thead>
                        <tr class="info">
                            <th>Artículo</th>
                            <th>Código ISP</th>
                            <th>Código Barra</th>
                            <th>Cantidad</th>
                            <th>Lote</th>
                            <th>Tipo Ingrso</th>
                            <th>Proveedor</th>
                            <th>Fecha Vencimiento</th>
                            <th>Creador Ingreso</th>
                            <th>Fecha Ingreso</th>

                            <th class='text-right'>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($fila = mysqli_fetch_array($query)) {
                            $id_ingreso = $fila['id_ingreso'];
                            $nombre_articulo = $fila['nombre_articulo'];
                            $estado_articulo = $fila['estado_articulo'];
                            $cantidad = $fila['cantidad'];
                            $concentracion = $fila['concentracion'];
                            $codigo_isp = $fila['codigo_isp'];
                            $codigo_barra = $fila['codigo_barra'];
                            $lote = $fila['lote'];
                            $tipo_ingreso = $fila['tipo_ingreso'];
                            $proveedor = $fila['proveedor'];
                            $fecha_vencimiento = $fila['fecha_vencimiento'];
                            $user_name = $fila['user_name'];
                             $observacion = $fila['observacion'];
                              $id_articulo = $fila['id_articulo'];
                              $fecha_creacion = $fila['fecha_ingreso'];
                              $estado_ingreso = $fila['estado_ingreso'];

                            // Si el estado es 0, aplicamos clase 'table-warning'
                        ?>
                            <tr style="<?php echo ($estado_articulo == 0) ? 'background-color: #fff3cd;' : ''; ?>">
                                <td><?php echo $nombre_articulo . ' ' . $concentracion; ?></td>
                                <td><?php echo $codigo_isp; ?></td>
                                <td><?php echo $codigo_barra; ?></td>
                                <td><?php echo $cantidad; ?></td>
                                <td><?php echo $lote; ?></td>
                                <td><?php echo $tipo_ingreso; ?></td>
                                <td><?php echo $proveedor; ?></td>
                                <td style="border-left: 0px"><?php echo date('d/m/Y', strtotime($fecha_vencimiento)); ?></td>
                                <td><?php echo $user_name; ?></td>
                                <td style="border-left: 0px"><?php echo date('d/m/Y', strtotime($fecha_creacion)); ?></td>
                                <td class='text-right'>
                                    <?php if ($estado_articulo != 0) { ?>
                                        <a href="#" class='btn btn-default' title='Editar Registro' data-id_ingreso='<?php echo $id_ingreso; ?>' data-id_articulo='<?php echo $id_articulo; ?>' data-cantidad='<?php echo $cantidad; ?>' data-lote='<?php echo $lote; ?>' data-fecha_vencimiento='<?php echo date('d/m/Y', strtotime($fecha_vencimiento)); ?>'  data-tipo_ingreso='<?php echo $tipo_ingreso; ?>' data-proveedor='<?php echo $proveedor; ?>' data-observacion='<?php echo $observacion; ?>' data-toggle="modal" data-target="#editarIngreso">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                                        <a href="#" class='btn btn-default' title='Descargar Archivo' onclick="descargar('<?php echo $id_ingreso; ?>');">
                                            <i class="glyphicon glyphicon-download"></i>
                                        </a>
                                       <a href="#" class="btn btn-default " title="Log Ingreso"  data-id_ingreso='<?php echo $id_ingreso; ?>' data-toggle="modal" data-target="#logIngreso"><i class="icon-reloj-b"></i></a>
                                       <a href="#" class="btn btn-default <?php echo $estado_ingreso == 1 ? 'btn-success' : 'btn-danger'; ?>" title="Activar/Anular"  data-id_ingreso='<?php echo $id_ingreso; ?>' data-page='<?php echo $page; ?>' data-toggle="modal" data-target="#motivo"><i class="icon-switch"></i></a>

                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan=12><span class="pull-right">
                                    <?php
                                    echo paginate($reload, $page, $total_pages, $adjacents);
                                    ?></span>
                                <input type="hidden" name="pagina_actual" id="pagina_actual" value="<?php echo $page; ?>" />
                            </td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
<?php
    }
}
