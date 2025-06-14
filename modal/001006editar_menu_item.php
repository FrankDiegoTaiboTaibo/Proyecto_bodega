<?php
    if (isset($con))
    {
  ?>
  <!-- Modal -->
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Menú Ítem</h4>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" method="post" id="editar_menu_item" name="editar_menu_item">
      <div id="resultados_ajax2"></div>
      
      <div class="form-group">
        <label for="item_descripcion2" class="col-sm-2 control-label">Descripción</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="item_descripcion2" name="item_descripcion2" placeholder="Nombres" required>
          <input type="hidden" id="mod_id" name="mod_id">
        </div>
        </div>

       <div class="form-group">
          <label for="menu_id2" class="col-sm-2 control-label">Menú</label>
            <div class="col-sm-10">
            <select class='form-control' name='menu_id2' id='menu_id2' ;">
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
        <label for="item_url2" class="col-sm-2 control-label">URL</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="item_url2" name="item_url2" placeholder="URL"  required> 
        </div>
        </div>

        <div class="form-group">
          <label for="item_tipo2" class="col-sm-2 control-label">Redirecciona</label>
          <div class="col-sm-10">
            <input type="checkbox" class="form-check-input" id="item_tipo2" name="item_tipo2">
          </div>
        </div>  

        <div class="form-group">
          <label for="item_estado2" class="col-sm-2 control-label">Estado</label>
          <div class="col-sm-10">
            <input type="checkbox" class="form-check-input" id="item_estado2" name="item_estado2">
          </div>
        </div>  

        <div class="form-group">
          <label for="item_interno2" class="col-sm-2 control-label">Interno</label>
          <div class="col-sm-10">
            <input type="checkbox" class="form-check-input" id="item_interno2" name="item_interno2">
          </div>
        </div>  

        <div class="form-group">
        <label for="item_codigo2" class="col-sm-2 control-label">Código</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="item_codigo2" name="item_codigo2" placeholder="Codigo" required>
        </div>
        </div>

          <div class="form-group">
        <label for="item_orden2" class="col-sm-2 control-label">Orden</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="item_orden2" name="item_orden2" placeholder="Orden" required>
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
                            <input type="radio" value="<?php echo $fila['icono_id'];?>" name="item_icono2" id=<?php echo $fila['icono_id'];?>><span class="<?php echo $fila['icono'];?>"></span>
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
      <button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
      </div>
      </form>
    </div>
    </div>
  </div>
  <?php
    }
  ?>