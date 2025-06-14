  <?php
    if (isset($con))
    {
  ?>
  <!-- Modal -->
  <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="myModalLabel4">
            <i class='glyphicon glyphicon-duplicate'></i> Duplicar perfil y sus accesos
          </h4>
        </div>
        <form class="form-horizontal" method="post" id="duplicar_perfil" name="guardar_perfil">
          <div class="modal-body">
            
            <!-- boton -->
            <div id="resultados_ajax4"></div>
            <div class="form-group">
              <label for="perfil_descripcion_duplicar" class="col-sm-3 control-label">Perfil Descripción</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="perfil_descripcion_duplicar" name="perfil_descripcion_duplicar" placeholder="Perfil" required maxlength="50">
              </div>
            </div>
          </div>

          <input type="hidden" name="duplicar_id" id="duplicar_id">

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="duplicar_datos">Guardar datos</button>
          </div>

        </form>
      </div>
    </div>
  </div>
  <?php
    }
  ?>