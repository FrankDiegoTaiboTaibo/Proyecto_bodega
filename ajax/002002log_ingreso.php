<?php

    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos mysql
    include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
    $id = $_GET['id'];
    if ($action == 'ingreso') {

        $sql_formato = "SELECT *
                    FROM articulos t1
                    LEFT JOIN ingreso t2 ON t1.id_articulo = t2.id_articulo
                    LEFT JOIN users t3 ON t2.usuario_creador_id = user_id
                    WHERE t2.id_ingreso = '$id'";
        $query_formato = mysqli_query($con, $sql_formato);

    ?>

        <div class="table-responsive">
            <table class="table">
                <tr class="info">
                    <th>Id Ingreso</th>
                    <th>Nombre Artículo</th>
                    <th>Fecha Ingreso</th>
                    <th>Usuario Ingreso</th>
                    <th>Estado Ingreso</th>
                </tr>
                <?php

                while ($fila_cuentas = mysqli_fetch_array($query_formato)) {

                    $id_ingreso = $fila_cuentas['id_ingreso'];
                    $nombre_articulo = $fila_cuentas['nombre_articulo'];
                    $concentracion = $fila_cuentas['concentracion'];
                    $fecha_ingreso = $fila_cuentas['fecha_ingreso'];
                    $firstname = $fila_cuentas['firstname'];
                    $lastname = $fila_cuentas['lastname'];
                    $estado_ingreso = $fila_cuentas['estado_ingreso'];



                ?>

                    <tr>
                        <td><?php echo $id_ingreso; ?></td>
                        <td><?php echo $nombre_articulo . ' ' . $concentracion; ?></td>
                        <td style="border-left: 0px"><?php echo date('d/m/Y', strtotime($fecha_ingreso)); ?></td>
                        <td><?php echo $firstname . ' ' . $lastname; ?></td>
                        <td>
                            <?php echo ($estado_ingreso == 0) ? 'ANULADO' : 'ACTIVO'; ?>
                        </td>

                    </tr>

                <?php

                }

                ?>

            </table>
        </div>

    <?php
    }
    if ($action == 'motivo') {

        //OBTENER CONTRATOS
        $sql_formato = "SELECT COUNT(*) AS numrows
                    FROM ingreso_anulacion t1
                    LEFT JOIN users t2 ON t1.usuario_anulacion_id = t2.user_id
                    WHERE t1.id_ingreso = '$id'";

        include 'pagination_detalle.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 5; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;

        $query_formato  = mysqli_query($con, $sql_formato);
        $row = mysqli_fetch_array($query_formato);
        $numrows = $row['numrows'];

        $total_pages = ceil($numrows / $per_page);
        $futura_pagina = ceil(($numrows + 1) / $per_page);
        $reload = "./002002ingreso.php";
        //main query to fetch the data

        mysqli_set_charset($con, "utf8");

        $sql_formato = str_replace('COUNT(*) AS numrows', '*', $sql_formato);
        $sql_formato .=  " ORDER BY t1.id_anulacion LIMIT $offset,$per_page";
        $query_formato = mysqli_query($con, $sql_formato);

    ?>

        <div class="table-responsive">
            <table class="table">
                <tr class="info">
                    <th>Usuario Responsable</th>
                    <th>Fecha Anulación/Activación</th>
                    <th>Acción Realizada</th>
                    <th>Motivo Anulación/Activación</th>
                </tr>
                <?php

                while ($fila_cuentas = mysqli_fetch_array($query_formato)) {

                    $firstname = $fila_cuentas['firstname'];
                    $lastname = $fila_cuentas['lastname'];
                    $fecha_anulacion = $fila_cuentas['fecha_anulacion'];
                    $accion_motivo = $fila_cuentas['accion_motivo'];
                    $descripcion_motivo = $fila_cuentas['descripcion_motivo'];

       // Texto de acción
      if ($accion_motivo == 0) {
        $accion_texto = 'ANULACIÓN';
        $color_fila = 'background-color: #fff3cd;'; // Amarillo
      } elseif ($accion_motivo == 1) {
        $accion_texto = 'ACTIVACIÓN';
        $color_fila = 'background-color: #d4edda;'; // Verde
      } elseif ($accion_motivo == 2) {
        $accion_texto = 'EDITADO';
        $color_fila = ''; // Sin color
      } else {
        $accion_texto = 'DESCONOCIDO';
        $color_fila = '';
      }
    ?>
      <tr style="<?php echo $color_fila; ?>">
                        <td><?php echo $firstname . ' ' . $lastname; ?></td>
                        <td style="border-left: 0px"><?php echo date('d/m/Y', strtotime($fecha_anulacion)); ?></td>
                           <td><?php echo $accion_texto; ?></td>
                        <td><?php echo $descripcion_motivo; ?></td>

                    </tr>

                <?php

                }

                ?>
                <tr>
                    <td colspan=7>
                        <input type="hidden" name="pagina_nueva_agrupacion" id="pagina_nueva_agrupacion" value="<?php echo $futura_pagina; ?>">
                        <span class="pull-right">
                            <?php
                            echo paginate($reload, $page, $total_pages, $adjacents, 0);
                            ?>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    <?php
    }

?>