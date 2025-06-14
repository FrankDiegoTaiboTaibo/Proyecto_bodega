  <?php
    if (isset($con))
    {
  ?>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Agregar nuevo Ítem Menú</h4>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" method="post" id="guardar_menu_item" name="guardar_menu_item">
      <div id="resultados_ajax"></div>


        <div class="form-group">
        <label for="descripcion_i" class="col-sm-3 control-label">Descripción</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Descripcion" required>
        </div>
        </div>

       <div class="form-group">
          <label for="menu_i" class="col-sm-3 control-label">Menú</label>
            <div class="col-sm-8">
            <select class='form-control' name='menu_i' id='menu_i' ;">
              <option value="">Seleccione un menú...</option>
              <?php 
              $query_ce=mysqli_query($con,"select * from menu order by menu_descripcion");
              while($rw=mysqli_fetch_array($query_ce))  {
                ?>
              <option value="<?php echo $rw['menu_id'];?>"><?php echo $rw['menu_descripcion'];?></option>     
                <?php
              }
              ?>
            </select> 
          </div>
        </div>

       <div class="form-group">
        <label for="url_i" class="col-sm-3 control-label">URL</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="url_i" name="url_i" placeholder="URL" required>
        </div>
        </div>

        <div class="form-group">
          <label for="tipo_i" class="col-sm-3 control-label">Redirecciona</label>
          <div class="col-sm-8">
            <input type="checkbox" class="form-check-input" id="tipo_i" name="tipo_i">
          </div>
        </div>

        <div class="form-group">
          <label for="estado_i" class="col-sm-3 control-label">Estado</label>
          <div class="col-sm-8">
            <input type="checkbox" class="form-check-input" id="estado_i" name="estado_i">
          </div>
        </div>
        
          <div class="form-group">
          <label for="interno_i" class="col-sm-3 control-label">Interno</label>
          <div class="col-sm-8">
            <input type="checkbox" class="form-check-input" id="interno_i" name="interno_i">
          </div>
        </div>  

        <div class="form-group">
        <label for="codigo_i" class="col-sm-3 control-label">Código</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="codigo_i" name="codigo_i" placeholder="Codigo" required>
        </div>
        </div>
        
          <div class="form-group">
        <label for="orden_i" class="col-sm-3 control-label">Orden</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="orden_i" name="orden_i" placeholder="Orden" required>
        </div>
        </div>   


        <div class="form-group">
          <label  class="col-sm-2 control-label">Icono</label>
          <div class="col-sm-10">
            <table class="table table-bordered">
              <body>

                <?php
                  $count_icono = mysqli_query($con,"SELECT COUNT(*) AS num_rows FROM icono");
                  $fila=mysqli_fetch_array($count_icono);
                  $total_iconos = $fila['num_rows'];
                  $iconos_x_filas = 14;
                  $total_filas = ceil($total_iconos/$iconos_x_filas);

                  for ( $i=0; $i < $total_filas; $i++ ) {
                ?>

                    <tr>

                      <?php 
                        $inicio_fila = $i * $iconos_x_filas;

                        $sql_icono = mysqli_query($con,"SELECT * FROM icono LIMIT $inicio_fila,$iconos_x_filas");
                        while(  $fila=mysqli_fetch_array($sql_icono)  ){
                        ?>

                        <td>
                        <div class="radio">
                          <label>
                            <input type="radio" value="<?php echo $fila['icono_id'];?>" name="icono_i" id=<?php echo substr($fila['icono'], 5);?>><span class="<?php echo $fila['icono'];?>"></span>
                          </label>
                        </div>
                        </td>

                       <?php
                        }

                      ?>

                    </tr>

                <?php
                  }
                ?>
              </body>
            </table>
          </div>
        </div>
              

       
       
      
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
      </div>
      </form>
    </div>
    </div>
  </div>
  <?php
    }
  ?>