<style>
  .label-obligatorio::after {
    content: " *";
    color: red;
  }
</style>

<div class="modal fade" id="editarIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <form class="form-horizontal" id="editar_ingreso" name="editar_ingreso">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class='glyphicon glyphicon-edit'></i> Editar Ingreso</h4>
        </div>

        <div class="modal-body">
    

          <div class="container-fluid">

            <div class="row flex">

              <div class="col-sm-12" id="resultados_ajax_ingreso" class="text-left"></div>
  <input type="hidden" id="id_ingreso">
              <div class="col-sm-6">

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5><strong>Datos del Artículo</strong></h5>
                  </div>
                  <div class="panel-body">

                    <div class="form-group">
                      <label for="desArticulo_mod" class="col-sm-3 control-label">Artículo</label>
                      <div class="col-sm-9">
                        <select id="desArticulo_mod" name="desArticulo_mod" class="selectpicker form-control" data-live-search="true" title="Seleccione un artículo..." disabled>
                          <?php
                          $sql_grupo = "SELECT * 
                                     FROM  articulos WHERE estado_articulo = 1";

                          $query_grupo = mysqli_query($con, $sql_grupo);

                          while ($fila_grupo = mysqli_fetch_array($query_grupo)) {
                            $id_articulo = $fila_grupo['id_articulo'];
                            $nombre_articulo = $fila_grupo['nombre_articulo'];
                            $concentracion = $fila_grupo['concentracion'];

                          ?>
                            <option value="<?php echo $id_articulo; ?>"><?php echo  $nombre_articulo . ' | ' . $concentracion; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="viaAdmin_mod" class="col-sm-3 control-label">Vía Administración</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="viaAdmin_mod" name="viaAdmin_mod" readonly disabled>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="lab_mod" class="col-sm-3 control-label">Laboratorio</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="lab_mod" name="lab_mod" readonly disabled>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="codIsp_mod" class="col-sm-3 control-label">Código ISP</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="codIsp_mod" name="codIsp_mod" readonly disabled>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="codBarra_mod" class="col-sm-3 control-label">Código Barra</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="codBarra_mod" name="codBarra_mod" readonly disabled>
                        <span></span>
                      </div>
                    </div>

                  </div>

                </div>

              </div>

              <div class="col-sm-6">

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5><strong>Datos del Ingreso</strong></h5>
                  </div>
                  <div class="panel-body">

                    <div class="form-group">
                      <label for="cantidad_mod" class="col-sm-5 control-label label-obligatorio">Cantidad</label>
                      <div class="col-sm-7">
                        <input type="number" class="form-control" id="cantidad_mod" name="cantidad_mod" placeholder="Ej: 120 unidades." required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="lote_mod" class="col-sm-5 control-label">Lote</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="lote_mod" name="lote_mod" placeholder="Ej: LOTE-PRC-2458." readonly disabled>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="fechaVencimiento_mod" class="col-sm-5 control-label label-obligatorio">Fecha Vencimiento</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="fechaVencimiento_mod" name="fechaVencimiento_mod" placeholder="Ej: Fecha de vencimiento del lote." required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="tipoIngreso_mod" class="col-sm-5 control-label label-obligatorio">Tipo de Ingreso</label>
                      <div class="col-sm-7">
                        <select class="form-control selectpicker" id="tipoIngreso_mod" name="tipoIngreso_mod" required>
                          <option value="">Seleccione una opción</option>
                          <option value="Compra">Compra</option>
                          <option value="Donación">Donación</option>
                          <option value="Devolución">Devolución</option>
                          <option value="Traspaso interno">Traspaso interno</option>
                          <option value="Ajuste por inventario">Ajuste por inventario</option>
                          <option value="Otro">Otro</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="proveedor_mod" class="col-sm-5 control-label label-obligatorio">Proveedor</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="proveedor_mod" name="proveedor_mod" placeholder="Nombre de la empresa o institución." required>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="observacion_mod" class="col-sm-5 control-label">Observacion</label>
                      <div class="col-sm-7">
                        <textarea id="observacion_mod" class="form-control" name="observacion_mod" placeholder="Ej: Estado del embalaje, diferencias." cols="34" style="resize: vertical;" maxlength="150"></textarea>
                        <span></span>
                      </div>
                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="actualizar_datos">Guardar</button>
      </div>

    </div>
  </div>
</div>
