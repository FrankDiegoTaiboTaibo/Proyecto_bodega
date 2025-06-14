	<?php
  if (isset($con)) {

  ?>
	  <!-- Modal -->
	  <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Ver Accesos de
	            <strong><span id=name> </span></strong>
	          </h4>
	        </div>
	        <div class="modal-body">
	          <form class="form-horizontal" method="post" id="ver_usuarios" name="ver_usuarios">
	            <div id="ver_ajax_usuario"></div>




	        </div>
	        <div class="modal-footer">

	        </div>
	        </form>
	      </div>
	    </div>
	  </div>
	<?php
  }
  ?>