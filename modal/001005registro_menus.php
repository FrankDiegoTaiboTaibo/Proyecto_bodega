	<?php
  if (isset($con)) {
  ?>
	  <!-- Modal -->
	  <div class="modal fade" id="nuevoMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Menú</h4>
	        </div>
	        <div class="modal-body">
	          <form class="form-horizontal" method="post" id="guardar_menu" name="guardar_menu">
	            <div id="resultados_ajax"></div>

	            <div class="form-group">
	              <label for="nombre" class="col-sm-3 control-label">Nombre</label>
	              <div class="col-sm-8">
	                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del menú" required>
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="id_cod" class="col-sm-3 control-label">Código</label>
	              <div class="col-sm-8">
	                <input type="text" class="form-control" id="id_cod" name="id_cod" minlength="3" maxlength="3" placeholder="Ej: 555" required>
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="estado" class="col-sm-3 control-label">Estado</label>
	              <div class="col-sm-8">
	                <label><input type="checkbox" class="form-check-input" id="estado" name="estado"> Activado</label>
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="orden" class="col-sm-3 control-label">Orden</label>
	              <div class="col-sm-8">
	                <input type="text" class="form-control" id="orden" name="orden" placeholder="Por defecto será el último si no ingresa valor" pattern="^(\s*|\d+)$">
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