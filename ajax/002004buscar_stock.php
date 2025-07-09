<?php
// Incluye archivos necesarios
require_once("../config/db.php"); // Contiene las variables de configuración para conectar a la base de datos.
require_once("../config/conexion.php"); // Contiene función que conecta a la base de datos MySQL.
include('is_logged.php'); // Archivo que verifica que el usuario que intenta acceder a la URL está logueado.
include 'pagination.php'; // Incluir archivo de paginación.
// Obtiene el parámetro 'action' de la solicitud o establece una cadena vacía si no existe
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

// Si la acción es 'ajax', se asume que es una solicitud AJAX para filtrar y paginar resultados.
if ($action == 'ajax') {
    // Obtiene parámetros de filtrado
    $q = trim($_GET['q']);
    $fil_fecha = $_GET['fil_fecha'];

    // Construye la consulta SQL base para contar registros
    $sql = "SELECT COUNT(*) AS numrows
                FROM articulos t1
                LEFT JOIN ingreso t2 ON t1.id_articulo = t2.id_articulo
                WHERE t1.nombre_articulo LIKE '%$q%'";

                  $fecha = "";
  if (!empty($fil_fecha)) {

    $fecha = explode("/", $fil_fecha);
    $mes = $fecha[0];
    $anio = $fecha[1];

    $sql .= "AND MONTH(t2.fecha_ingreso) = '$mes' AND YEAR(t2.fecha_ingreso) = '$anio' ";
  }

    // Paginación
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; // Cantidad de registros a mostrar por página
    $adjacents  = 4; // Espacio entre páginas después del número de páginas adyacentes
    $offset = ($page - 1) * $per_page;

    // Ejecuta la consulta SQL para contar registros
    $query  = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    $numrows = $row['numrows'];

    $total_pages = ceil($numrows / $per_page);
    $reload = './002004stock_actual.php';

    // Modifica la consulta SQL para seleccionar los datos de la tabla con paginación
    $sql = str_replace('COUNT(*) AS numrows', '*', $sql);
    $sql .=  " ORDER BY t2.id_ingreso DESC LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    // Tabla de resultados

    if ($numrows > 0) {
?>
        <div class="small">
            <div class="table-responsive ">
                <table class="table table-hover table-small">
                    <thead>
                        <tr class="info">
                            <th>Lote</th>
                            <th>Artículo</th>
                            <th>Forma</th>
                            <th>Fecha Vencimiento</th>
                            <th>Stock Actual</th>
                            <th>Estado</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                            // Extrae datos de cada fila
                            $id_articulo = $row['id_articulo'];
                            $id_ingreso = $row['id_ingreso'];
                            $nombre_articulo = $row['nombre_articulo'];
                            $concentracion = $row['concentracion'];
                            $forma_farmaceutica = $row['forma_farmaceutica'];
                            $via_administracion = $row['via_administracion'];
                            $lote = $row['lote'];
                            $fecha_vencimiento = $row['fecha_vencimiento'];
                             $fecha_ingreso = $row['fecha_ingreso'];
                            $stock_minimo = $row['stock_minimo'];

                            // Calcular stock actual del lote (si no tienes tabla egreso, solo SUMA ingresos)
                            $sql_stock = "SELECT SUM(cantidad) AS stock_actual 
                                          FROM ingreso 
                                          WHERE id_articulo = '$id_articulo' 
                                          AND lote = '$lote' 
                                          AND id_ingreso = '$id_ingreso'";

                            $res_stock = mysqli_query($con, $sql_stock);
                            $stock_data = mysqli_fetch_assoc($res_stock);
                            $stock_actual = $stock_data['stock_actual'] ?? 0;

                            // Evaluar estado
                            $estado = "Normal";
                            $class_estado = "text-success";
                            $hoy = date("Y-m-d");

                            if ($stock_actual <= $stock_minimo) {
                                $estado = "Bajo stock";
                                $class_estado = "text-danger";
                            }

                            $dias_restantes = (strtotime($fecha_vencimiento) - strtotime($hoy)) / (60 * 60 * 24);

                            if ($dias_restantes < 0) {
                                $estado = "Vencido";
                                $class_estado = "text-danger";
                            } elseif ($dias_restantes <= 30) {
                                $estado = "Por vencer";
                                $class_estado = "text-warning";
                            }


                        ?>
                            <tr>
                                <td><?php echo $lote; ?></td>
                                <td><?php echo $nombre_articulo . ' ' . $concentracion; ?></td>
                                <td><?php echo $forma_farmaceutica . ' ' . $via_administracion; ?></td>
                                <td style="border-left: 0px"><?php echo date('d/m/Y', strtotime($fecha_vencimiento)); ?></td>
                                <td><?php echo $stock_actual; ?></td>
                                <td class="<?php echo $class_estado; ?>"><strong><?php echo $estado; ?></strong></td>

                                <?php
                                ?>
                              
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan=8>
                                <span class="pull-right">
                                    <?php
                                    echo paginate($reload, $page, $total_pages, $adjacents);
                                    ?>
                                </span>
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
?>