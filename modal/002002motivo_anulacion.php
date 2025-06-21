<?php
if (isset($con)) {
?>
  <!-- Modal -->
  <div class="modal fade" id="motivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="form-horizontal" method="post" id="motivo_anula" name="motivo_anula">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Motivo Anulación</h4>
          </div>
          <div class="modal-body">

            <div id="resultados_ajax_motivo"></div>

            <input type="text" id="id_ingreso_motivo">
             <input type="text" id="page_motivo">

            <div class="form-group">
                      <label for="descMotivo" class="col-sm-5 control-label">Motivo de Anulación o Activación</label>
                      <div class="col-sm-7">
                        <textarea id="descMotivo" class="form-control" name="descMotivo" placeholder="Ej: Estado ." cols="34" style="resize: vertical;" maxlength="150"></textarea>
                        <span></span>
                      </div>
                    </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="guardar_motivo">Guardar datos</button>
          </div>

        </form>

      </div>
    </div>
  </div>
<?php
}
?>