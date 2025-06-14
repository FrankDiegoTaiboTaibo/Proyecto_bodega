<?php
    include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
    header('Content-Type: application/json');
    //____________________________________________Connect To Database
    require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

    //Código de validación de datos
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : ''; //--determina si una variable está definida y no es NULL.
    $datos = array();
    //Validaciones
    if ($action == 'ajax') {

        $user_id = $_SESSION['user_id'];

        //Validar nombreArticulo
        if (!isset($_POST['nombreArticulo']) ||  empty($_POST['nombreArticulo'])) {
            $datos['errores']['nombreArticulo'] = 'El campo <b>Nombre Artículo</b> está vacio.';
        } else {
            $nombreArticulo = trim($_POST['nombreArticulo']);
        }

        //Validar codigo isp
        if (!isset($_POST['codigoIsp']) ||  empty($_POST['codigoIsp'])) {
            $datos['errores']['codigoIsp'] = 'El campo <b>Código</b> está vacio.';
        } else {
            $codigoIsp = trim($_POST['codigoIsp']);
        }

          //Validar codigo barra
        if (!isset($_POST['codigoBarra']) ||  empty($_POST['codigoBarra'])) {
            $datos['errores']['codigoBarra'] = 'El campo <b>Código bodega</b> está vacio.';
        } else {
            $codigoBarra = trim($_POST['codigoBarra']);
        }

              //Validar concentración
        if (!isset($_POST['concentracion']) ||  empty($_POST['concentracion'])) {
            $datos['errores']['concentracion'] = 'El campo <b>Concentración</b> está vacio.';
        } else {
            $concentracion = trim($_POST['concentracion']);
        }

        //Validar dosis
        if (!isset($_POST['formaFarmaceutica']) ||  empty($_POST['formaFarmaceutica'])) {
            $datos['errores']['formaFarmaceutica'] = 'El campo <b>Forma farmaceutica</b> está vacio.';
        } else {
            $formaFarmaceutica = trim($_POST['formaFarmaceutica']);
        }

        //Validar Via administración
        if (!isset($_POST['viaAdministracion']) ||  empty($_POST['viaAdministracion'])) {
            $datos['errores']['viaAdministracion'] = 'El campo <b>Vía de administración</b> está vacio.';
        } else {
            $viaAdministracion = trim($_POST['viaAdministracion']);
        }

             //Validar Unidad de medida
        if (!isset($_POST['unidadMedida']) ||  empty($_POST['unidadMedida'])) {
            $datos['errores']['unidadMedida'] = 'El campo <b>Unidad de medida</b> está vacio.';
        } else {
            $unidadMedida = trim($_POST['unidadMedida']);
        }
    
                     //Validar Presentacion
        if (!isset($_POST['presentacion']) ||  empty($_POST['presentacion'])) {
            $datos['errores']['presentacion'] = 'El campo <b>presentacion</b> está vacio.';
        } else {
            $presentacion = trim($_POST['presentacion']);
        }

                 //Validar Laboratorio
        if (!isset($_POST['laboratorio']) ||  empty($_POST['laboratorio'])) {
            $datos['errores']['laboratorio'] = 'El campo <b>Laboratorio</b> está vacio.';
        } else {
            $laboratorio = trim($_POST['laboratorio']);
        }
       

                     //Validar Tipo de articulo
        if (!isset($_POST['tipoArticulo']) ||  empty($_POST['tipoArticulo'])) {
            $datos['errores']['tipoArticulo'] = 'El campo <b>Tipo de artículo</b> está vacio.';
        } else {
            $tipoArticulo = trim($_POST['tipoArticulo']);
        }

        //Validar Stock minimo
        if (!isset($_POST['stockMinimo'])) {
            $datos['errores']['stockMinimo'] = 'El campo <b>Stock minimo</b> es inválido.';
        } else {
            $stockMinimo = trim($_POST['stockMinimo']);
            if (!is_numeric($stockMinimo) || intval($stockMinimo) < 0)
                $datos['errores']['stockMinimo'] = 'El campo <b>Stock minimo</b> es inválido. El valor debe ser de tipo numérico mayor a cero.';
        }
       

        if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

              
          $sql_exist = "SELECT * 
                   FROM articulos
                   WHERE nombre_articulo  = '$nombreArticulo' 
                   AND codigo_isp = '$codigoIsp' 
                   AND codigo_barra = '$codigoBarra'
                   AND concentracion = '$concentracion'";

        $query_exist = mysqli_query($con, $sql_exist);
        

        if (mysqli_num_rows($query_exist) > 0) {
          $datos['errores']['sql'] = "Ya existe el articulo con esa dosis";

        } else {

               $sql_insert = "INSERT INTO articulos (nombre_articulo,
                                                                 codigo_isp,
                                                                  codigo_barra, 
                                                                  concentracion, 
                                                                  forma_farmaceutica,
                                                                  via_administracion,
                                                                  unidad_medida,
                                                                  presentacion,
                                                                  laboratorio,
                                                                  tipo_articulo,
                                                                  stock_minimo,
                                                                  activo,
                                                                  fecha_creacion,
                                                                  usuario_creador_id)
                                  VALUES('$nombreArticulo',
                                          '$codigoIsp',
                                          '$codigoBarra',
                                          '$concentracion',
                                          '$formaFarmaceutica',
                                          '$viaAdministracion',
                                          '$unidadMedida',
                                          '$presentacion',
                                          '$laboratorio',
                                          '$tipoArticulo',
                                          '$stockMinimo',
                                          1,
                                          CURRENT_TIMESTAMP, 
                                          '$user_id')";

          $query_insert = mysqli_query($con, $sql_insert);

          if (!$query_insert)
            $datos['errores']['sql'] = "Error en la carga.";
          else {
            $datos['exito'] = "El Artículo fue creado con éxito.";
          }



        }
        }
    }

    echo json_encode($datos);
?>