<style>
  .label-obligatorio::after {
    content: " *";
    color: red;
  }
</style>

<div class="modal fade" id="registroIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <form class="form-horizontal" id="formulario_guardar" name="formulario_guardar">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Ingreso</h4>
        </div>

        <div class="modal-body">

          <div class="container-fluid">

            <div class="row flex">

              <div class="col-sm-12" id="resultados_ajax" class="text-left"></div>

              <div class="col-sm-6">

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5><strong>Datos del Artículo</strong></h5>
                  </div>
                  <div class="panel-body">

                    <div class="form-group">
                      <label for="desArticulo" class="col-sm-3 control-label label-obligatorio">Artículo</label>
                      <div class="col-sm-9">
                        <select id="desArticulo" class="selectpicker form-control" title="Seleccione un artículo..." required>
                          <?php
                          $sql_grupo = "SELECT t1.id_articulo, t1.nombre_articulo, t1.concentracion, t1.via_administracion, t1.forma_farmaceutica
                                        FROM articulos t1
                                        WHERE t1.estado_articulo = 1";

                          $query_grupo = mysqli_query($con, $sql_grupo);

                          while ($fila_grupo = mysqli_fetch_array($query_grupo)) {
                            $id_articulo = $fila_grupo['id_articulo'];
                            $nombre_articulo = $fila_grupo['nombre_articulo'];
                            $concentracion = $fila_grupo['concentracion'];
                            $via_administracion = $fila_grupo['via_administracion'];
                            $forma_farmaceutica = $fila_grupo['forma_farmaceutica'];

                          ?>
                            <option value="<?php echo $id_articulo; ?>"><?php echo  $nombre_articulo . '  ' . $concentracion.' | '.$forma_farmaceutica.' '.$via_administracion; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        <span></span>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="lab" class="col-sm-3 control-label">Laboratorio</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="lab" name="lab" readonly>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="codIsp" class="col-sm-3 control-label">Código ISP</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="codIsp" name="codIsp" readonly>
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
                      <label for="cantidad" class="col-sm-5 control-label label-obligatorio">Cantidad</label>
                      <div class="col-sm-7">
                        <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ej: 120 unidades." required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="lote" class="col-sm-5 control-label label-obligatorio">Lote</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="lote" name="lote" placeholder='Ej: LOTE-PRC-2458.' required>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="fechaVencimiento" class="col-sm-5 control-label label-obligatorio">Fecha Vencimiento</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="fechaVencimiento" name="fechaVencimiento" placeholder='Ej: Fecha de vencimiento del lote.' required>
                        <span></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="tipoIngreso" class="col-sm-5 control-label label-obligatorio">Tipo de Ingreso</label>
                      <div class="col-sm-7">
                        <select class="form-control selectpicker" id="tipoIngreso" name="tipoIngreso" >
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
                      <label for="proveedor" class="col-sm-5 control-label label-obligatorio">Proveedor</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder="Nombre de la empresa o institución." required>
                        <span></span>
                      </div>
                    </div>

                          <div class="form-group">
                      <label for="codigoBarra" class="col-sm-5 control-label label-obligatorio">Código de barras</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="codigoBarra" name="codigoBarra" placeholder="7800456789123." required>
                        <span></span>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="archivo" class="col-sm-5 control-label label-obligatorio">Carga Documento</label>
                      <div class="col-sm-7">
                        <input id="archivo" name="archivo" type="file" accept=".pdf">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="observacion" class="col-sm-5 control-label">Observacion</label>
                      <div class="col-sm-7">
                        <textarea id="observacion" class="form-control" name="observacion" placeholder="Ej: Estado del embalaje, diferencias." cols="34" style="resize: vertical;" maxlength="150"></textarea>
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
        <button type="button" class="btn btn-primary" id="btn_guardar">Guardar</button>
      </div>

    </div>
  </div>
</div>
