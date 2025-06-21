<!-- Modal -->
<div class="modal fade" id="logIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <form class="form-horizontal" id="formulario_log" name="formulario_log">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class='glyphicon glyphicon-edit'></i> Log Ingreso</h4>
        </div>

        <div class="modal-body">

          <div class="container-fluid">

            <div class="row">
              <div class="col-sm-12" id="resultados_ajax" class="text-left"></div>

              <!-- Panel 1: Datos del Vehículo -->
              <div class="col-sm-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5><strong>Datos del Ingreso</strong></h5>
                  </div>
                  <div class="panel-body">

                         <form class="form-horizontal" role="form">
            <input type="hidden" id="id_historial">
          
          <div class="row">
            <div class="col-md-12">
              <span id="loader_historial"></span>
              <span id="msg_historial"></span>
            </div>
          </div>
          
        </form>

        <div id="resultados_ajax_historial" class="text-left"></div>


                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5><strong>Registros del Ingreso</strong></h5>
                  </div>
                  <div class="panel-body">

            
          
          <div class="row">
            <div class="col-md-12">
              <span id="loader_historial_motivo"></span>
              <span id="msg_historial_motivo"></span>
            </div>
          </div>
          
      

        <div id="resultados_ajax_historial_motivo" class="text-left"></div>

                  </div>
                </div>
              </div>

            </div>

          </div>

        </div>

      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_guardar">Guardar</button>
      </div>

    </div>
  </div>
</div>
