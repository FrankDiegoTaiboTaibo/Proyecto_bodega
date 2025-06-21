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
        $fil_tipo = trim($_GET['fil_tipo']);
        $fil_estado = trim($_GET['fil_estado']);

        // Construye la consulta SQL base para contar registros
        $sql = "SELECT COUNT(*) AS numrows
                FROM articulos t1
                WHERE t1.nombre_articulo LIKE '%$q%'";

        if ($_GET['fil_estado'] != "") {
            $sql .= " AND t1.estado_articulo = '$fil_estado' ";
        }

        if ($_GET['fil_tipo'] != "") {
            $sql .= " AND t1.tipo_articulo = '$fil_tipo' ";
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
        $reload = './002001articulo.php';

        // Modifica la consulta SQL para seleccionar los datos de la tabla con paginación
        $sql = str_replace('COUNT(*) AS numrows', '*', $sql);
        $sql .=  " ORDER BY t1.id_articulo DESC LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);

        // Tabla de resultados
        if ($numrows > 0) {
    ?>
        <div class="small">
            <div class="table-responsive ">
                <table class="table table-hover table-small">
                    <thead>
                        <tr class="info">
                            <th>Descripción Arículo</th>
                            <th>Tipo</th>
                            <th>Via Administración</th>
                            <th>Laboratorio</th>
                            <th>Código ISP</th>
                            <th>Código Barra</th>
                            <th>Stock Mínimo</th>

                            <th class='text-right'>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                            // Extrae datos de cada fila
                            $id_articulo = $row['id_articulo'];
                            $nombre_articulo = $row['nombre_articulo'];
                            $codigo_isp = $row['codigo_isp'];
                            $codigo_barra = $row['codigo_barra'];
                            $concentracion = $row['concentracion'];
                            $forma_farmaceutica = $row['forma_farmaceutica'];
                            $via_administracion = $row['via_administracion'];
                            $unidad_medida = $row['unidad_medida'];
                            $laboratorio = $row['laboratorio'];
                            $tipo_articulo = $row['tipo_articulo'];
                            $stock_minimo = $row['stock_minimo'];
                            $estado_articulo = $row['estado_articulo'];
                            $fecha_creacion = $row['fecha_creacion'];
                            $usuario_creador_id = $row['usuario_creador_id'];

                        ?>
                            <tr>
                                <td><?php echo $nombre_articulo . ' ' . $concentracion; ?></td>
                                <td><?php echo $tipo_articulo; ?></td>
                                <td><?php echo $forma_farmaceutica . ' ' . $via_administracion; ?></td>
                                <td><?php echo $laboratorio; ?></td>
                                <td><?php echo $codigo_isp; ?></td>
                                <td><?php echo $codigo_barra; ?></td>
                                <td><?php echo $stock_minimo; ?></td>
                                <?php
                                ?>
                                <td class='text-right'>
                                    <a href="#" class="btn btn-default <?php echo $estado_articulo == 1 ? 'btn-success' : 'btn-danger'; ?>" title="Activar/Desactivar" onclick="cambiar_estado('<?php echo $id_articulo; ?>','<?php echo $page; ?>');"><i class="icon-switch"></i></a>
                                    <a href="#" class='btn btn-default' title='Editar Registro' data-id_articulo='<?php echo $id_articulo; ?>' data-nombre_articulo='<?php echo $nombre_articulo; ?>' data-codigo_isp='<?php echo $codigo_isp; ?>' data-codigo_barra='<?php echo $codigo_barra; ?>' data-concentracion='<?php echo $concentracion; ?>' data-forma_farmaceutica='<?php echo $forma_farmaceutica; ?>' data-via_administracion='<?php echo $via_administracion; ?>' data-unidad_medida='<?php echo $unidad_medida; ?>' data-laboratorio='<?php echo $laboratorio; ?>' data-tipo_articulo='<?php echo $tipo_articulo; ?>' data-stock_minimo='<?php echo $stock_minimo; ?>' data-toggle="modal" data-target="#editarArticulo"><i class="glyphicon glyphicon-edit"></i></a>
                                    <a href="#" class='btn btn-danger' title='Borrar Registro' onclick="eliminar('<?php echo $id_articulo; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan=12>
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