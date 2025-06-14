  <?php
    if (isset($con))
    {
  ?>
  <!-- Modal -->
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Accesos</h4>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" method="post" id="editar_accesos" name="editar_accesos">
      <div id="resultados_ajax2"></div>

        <div class="form-group row">
          <label for="mod_nombre_perfil" class="col-sm-3 control-label">Nombre Perfil</label>
          <div class="col-sm-8">
            <input type="text" readonly class="form-control" id="mod_nombre_perfil" name="mod_nombre_perfil"  required></p>
            <input type="hidden" name="mod_id_perfil" id="mod_id_perfil">
            <input type="hidden" name="mod_nombres_checkboxs" id="mod_nombres_checkboxs">
          </div>
        </div>

        <div class="form-group row">
          <label for="mod_nombre_perfil" class="col-sm-3 control-label">Acciones</label>
          <div class="col-sm-8">
            <input id="btn_todos" class="btn btn-default" type="button" value="Seleccionar Todos">
            <input id="btn_ninguno" class="btn btn-default" type="button" value="Deseleccionar Todos">
          </div>
        </div>
        
        <div class="form-group">
            <label for="mod_item" class="col-sm-3 control-label">Menú Items</label>
            <div class="col-sm-8">

              <?php 

                $sql_menu = "SELECT * FROM menu ORDER BY menu_orden ASC";
                $query_menu=mysqli_query($con, $sql_menu);

                while($row=mysqli_fetch_array($query_menu)) {

                $menu_id = $row['menu_id'];
                $menu_descripcion = $row['menu_descripcion'];

              ?>
                <b class="menu_checkboxs" href="#" data-id='<?php echo $menu_id;?>' data-checks='0'><?php echo $menu_descripcion?></b>
              <?php


                $sql = "SELECT * FROM menu_item WHERE menu_id =".$menu_id." ORDER BY menu_item_orden ASC";
                $query=mysqli_query($con, $sql);
                while($row=mysqli_fetch_array($query))  {
                  

              ?>        
              <div class="checkbox">
                  <label><input type="checkbox"  class="form-check-input checkboxs menu_checkboxs_<?php echo $row['menu_id']; ?>" id="mod_item_<?php echo $row['menu_item_id'];?>" name="mod_item_<?php echo $row['menu_item_id'];?>" ><i class='<?php echo $row['menu_item_icono']; ?>'></i> <?php echo $row["menu_item_descripcion"];?></label>
                </div>

              <?php 
                    } 
                ?>
                <br />
              <?php
                  }
              ?>
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