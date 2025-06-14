	<?php
  if (isset($con)) {
  ?>
	  <!-- Modal -->
	  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Menú</h4>
	        </div>
	        <div class="modal-body">
	          <form class="form-horizontal" method="post" id="editar_menu" name="editar_menu">
	            <div id="resultados_ajax2"></div>

	            <div class="form-group">
	              <label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
	              <div class="col-sm-8">
	                <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" required>
	                <input type="hidden" name="mod_id" id="mod_id">
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="mod_estado" class="col-sm-3 control-label">Estado</label>
	              <div class="col-sm-8">
	                <label><input type="checkbox" class="form-check-input" id="mod_estado" name="mod_estado"> Activado <label>
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="mod_codigo" class="col-sm-3 control-label">Código</label>
	              <div class="col-sm-8">
	                <input type="text" class="form-control" id="mod_codigo" name="mod_codigo" minlength="3" maxlength="3" placeholder="Ej: 555" required>
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="mod_orden" class="col-sm-3 control-label">Orden</label>
	              <div class="col-sm-8">
	                <input type="text" class="form-control" id="mod_orden" name="mod_orden" pattern="^(\s*|\d+)$">
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