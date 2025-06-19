<div class="modal fade" id="registroIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <form class="form-horizontal" id="formulario_guardar" name="formulario_guardar">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
              <label for="desArticulo" class="col-sm-3 control-label">Artículo</label>
              <div class="col-sm-9">
              <select id="desArticulo" class="selectpicker form-control" data-live-search="true" title="Seleccione un artículo...">
                  <?php
                    $sql_grupo = "SELECT * 
                                     FROM  articulos
                                     ";

                    $query_grupo = mysqli_query($con, $sql_grupo);

                    while ($fila_grupo = mysqli_fetch_array($query_grupo)) {
                      $id_articulo = $fila_grupo['id_articulo'];
                      $nombre_articulo = $fila_grupo['nombre_articulo'];
                      $concentracion = $fila_grupo['concentracion'];

                      ?>
                        <option  value="<?php echo $id_articulo; ?>"><?php echo  $nombre_articulo.' | '.$concentracion; ?></option>
                      <?php
                    }
                  ?>
                </select>                        
                <spam></spam>              
              </div>
            </div>

                      <div class="form-group">
                        <label for="viaAdmin" class="col-sm-3 control-label" >Vía Administración</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="viaAdmin" name="viaAdmin" readonly>
                          <span></span>
                        </div>                      
                      </div>

                      <div class="form-group">
                        <label for="lab" class="col-sm-3 control-label" >Laboratorio</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="lab" name="lab" readonly>
                          <span></span>
                        </div>                      
                      </div>

                      <div class="form-group">
                        <label for="codIsp" class="col-sm-3 control-label" >Código ISP</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="codIsp" name="codIsp" readonly>
                          <span></span>
                        </div>                      
                      </div>

                      <div class="form-group">
                        <label for="codBarra" class="col-sm-3 control-label" >Código Barra</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="codBarra" name="codBarra" readonly>
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
                                <label for="cantidad" class="col-sm-5 control-label">Cantidad</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ej: 120."  >
                                </div>
                            </div>

                      <div class="form-group">
                        <label for="lote" class="col-sm-5 control-label" >Lote</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="lote" name="lote"  placeholder='Ej: LOTE-PRC-2458.'>
                          <span></span>
                        </div>                      
                      </div>

                      <div class="form-group">
                        <label for="fechaVencimiento" class="col-sm-5 control-label" >Fecha Vencimiento</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="fechaVencimiento" name="fechaVencimiento" placeholder='Ej: Fecha de vencimiento del lote.' >
                          <span></span>
                        </div>                      
                      </div>

                        <div class="form-group">
                                <label for="tipoIngreso" class="col-sm-5 control-label">Tipo de Ingreso</label>
                                <div class="col-sm-7">
                                    <select class="form-control selectpicker" id="tipoIngreso" name="tipoIngreso" >
                                        <option value="">Seleccione una opción</option>
                                        <option value="Medicamento">Medicamento</option>
                                        <option value="Insumo Médico">Insumo Médico</option>
                                        <option value="Dispositivo Médico">Dispositivo Médico</option>
                                        <option value="Vacuna">Vacuna</option>
                                        <option value="Material de Curación">Material de Curación</option>
                                        <option value="Producto de Laboratorio">Producto de Laboratorio</option>
                                        <option value="Elemento de Protección Personal">Elemento de Protección Personal</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>

                      <div class="form-group">
                        <label for="proveedor" class="col-sm-5 control-label" >Proveedor</label >
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder="Nombre de la empresa o institución.">
                          <span></span>
                        </div>
                      </div>

                             <div class="form-group">
                        <label for="observacion" class="col-sm-5 control-label" >Observacion</label>
                        <div class="col-sm-7">
                          <textarea id="observacion" class="form-control" name="observacion" placeholder="Ej: Comentarios adicionales como estado del embalaje, diferencias." cols="34" style="resize: vertical;" maxlength="150"></textarea>
                          <span></span>
                        </div>                      
                      </div>

                                            <div class="form-group">
<label for="archivo" class="col-sm-5 control-label">Carga Documento</label>
<div class="col-sm-7">
  <input id="archivo" name="archivo" type="file" accept=".pdf" >
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
