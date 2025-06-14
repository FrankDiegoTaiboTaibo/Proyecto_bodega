	<?php
  if (isset($con)) {
  ?>
	  <!-- Modal -->
	  <div class="modal fade" id="ver_accesos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="myModalLabel"><i class='icon-barrera'></i> Accesos perfil</h4>
	        </div>
	        <div class="modal-body">
	          <div id="resultados_accesos"></div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        </div>
	      </div>
	    </div>
	  </div>
	<?php
  }
  ?>