    <?php
        if (isset($con))
        {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="registroArticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-plus'></i> Agregar nuevo artículo</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardar_articulo" name="guardar_articulo">
            <div id="resultados_ajax"></div>
              <div class="form-group">
                <label for="nombreArticulo" class="col-sm-4 control-label">Nombre Artículo</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="nombreArticulo" name="nombreArticulo" placeholder="Ej: Paracetamol" >
                </div>
              </div>
              <div class="form-group">
                <label for="dosis" class="col-sm-4 control-label">Concentración/Dosis</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="dosis" name="dosis" placeholder="Ej: 500 mg" >
                </div>
              </div>
              <div class="form-group">
                <label for="presentacion" class="col-sm-4 control-label">Forma farmacéutica/Presentación</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="presentacion" name="presentacion" placeholder="Ej: Cápsulas, Jarabe,"  >
                </div>
              </div>
              <div class="form-group">
                <label for="cantidad" class="col-sm-4 control-label">Cantidad en stock/unidades disponibles</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Ej: 150 unidades">
                </div>
              </div>

              <div class="form-group">
                <label for="fechaVencimiento" class="col-sm-4 control-label">Fecha de vencimiento</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="fechaVencimiento" name="fechaVencimiento" placeholder="Ej: 01/01/2000" >
                </div>
              </div>

                <div class="form-group">
              <label for="observacion" class="col-sm-4 control-label">Observación</label>
              <div class="col-sm-7">
                <textarea class="form-control" id="observacion" name="observacion" style="resize: vertical;" maxlength="256" minlength="20" ></textarea>
                <span></span>
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