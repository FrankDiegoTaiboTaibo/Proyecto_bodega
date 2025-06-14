<?php

  require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
  include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  if($action == 'ajax'){

    if(!isset($_POST['id']) || empty($_POST['id'])){
      $errores[] = "La solicitud no cuenta con un id.";
    }
    else{

      $perfil_descripcion = '';

      if(!isset($_POST['perfil_descripcion']) || empty($_POST['perfil_descripcion'])){
        $errores[] = "Perfil vacío.";
      }
      else{

        

        if( strlen($_POST['perfil_descripcion']) < 2 )
          $errores[] = "La descripción perfil es demasiado corta. Largo mínimo 3 caracteres.";

        if( strlen($_POST['perfil_descripcion']) > 50 )
          $errores[] = "La descripción perfil es demasiado corta. Largo máximo 50 caracteres.";

      }

      if (!isset($errores)){

        $perfil_id = $_POST['id'];
        $perfil_descripcion = $_POST['perfil_descripcion']; 

        $sql_perfil = "SELECT perfil_descripcion
                       FROM perfil
                       WHERE perfil_id = '$perfil_id'";

        $query_perfil = mysqli_query($con,$sql_perfil);

        if(!$query_perfil || mysqli_num_rows($query_perfil) == 0 ){
          $errores[] = "El perfil seleccionado no se ha encontrado en el sistema.";
        }
        else{

          $sql_perfil_descripcion = "SELECT perfil_descripcion
                                     FROM perfil
                                     WHERE perfil_descripcion = '$perfil_descripcion'";

          $query_perfil = mysqli_query($con,$sql_perfil_descripcion);

          if( mysqli_num_rows($query_perfil) != 0 ){
            $errores[] = "La descripción perfil ya existe. Utilice otro.";
          }
          else{

            $insertar_perfil = "INSERT INTO perfil (perfil_descripcion) VALUES('$perfil_descripcion');";
            $query_perfil = mysqli_query($con, $insertar_perfil);

            $nuevo_id_perfil = mysqli_insert_id($con);

            if( $nuevo_id_perfil == 0)
              $errores[] = "No se logró duplicar el perfil.";
            else{

              $sql_accesos = "SELECT t2.menu_item_id
                              FROM acceso t1
                              INNER JOIN menu_item t2 ON t1.menu_item_id = t2.menu_item_id
                              WHERE t1.perfil_id = '$perfil_id'";

              $query_accesos = mysqli_query($con, $sql_accesos);

              while( $fila_acceso = mysqli_fetch_array($query_accesos) ){

                $menu_item_id = $fila_acceso['menu_item_id'];

                $insert_acceso = "INSERT INTO acceso(perfil_id, menu_item_id) VALUES ('$nuevo_id_perfil','$menu_item_id')";
                $query_insert_acceso = mysqli_query($con, $insert_acceso);

                if(!$query_insert_acceso){
                  $errores[] = "Perfil duplicado pero con problema en uno o más de sus accesos.";
                  break;
                }

              }

              if (!isset($errores))
                $messages[] = "El perfil fue duplicado con sus respectivos accesos.";

            }

          }

        }

      }

    }

  }
  else{
    $errores[] = "Solicitud inválida.";
  }

  if (isset($errores)){
  ?>
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Error!</strong> 
        <?php
          foreach ($errores as $error)
            echo $error;
        ?>
    </div>
  <?php
  }
  if (isset($messages)){
  ?>
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>¡Bien hecho!</strong>
      <?php
        foreach ($messages as $message)
          echo $message;
        ?>
    </div>
  <?php

  }

?>
