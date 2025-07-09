    <style>
  .label-obligatorio::after {
    content: " *";
    color: red;
  }
</style>

<?php
    if (isset($con)) {
    ?>

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
                                <label for="nombreArticulo" class="col-sm-4 control-label label-obligatorio">Nombre Artículo</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="nombreArticulo" name="nombreArticulo" placeholder="Ej: Paracetamol">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="codigoIsp" class="col-sm-4 control-label label-obligatorio">Código ISP</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="codigoIsp" name="codigoIsp" placeholder="Ej: F-2145/22">
                                </div>
                            </div>
                  
                            <div class="form-group">
                                <label for="concentracion" class="col-sm-4 control-label label-obligatorio">Concentración</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="concentracion" name="concentracion" placeholder="Ej: 500mg">
                                </div>
                            </div>

                            <div class="form-group">
    <label for="formaFarmaceutica" class="col-sm-4 control-label label-obligatorio">Forma Farmacéutica</label>
    <div class="col-sm-7">
        <select class="form-control selectpicker" id="formaFarmaceutica" name="formaFarmaceutica" data-live-search="true" >
            <option value="">Seleccione una opción</option>
            <option value="Comprimido">Comprimido</option>
            <option value="Cápsula">Cápsula</option>
            <option value="Tableta">Tableta</option>
            <option value="Jarabe">Jarabe</option>
            <option value="Solución">Solución</option>
            <option value="Suspensión">Suspensión</option>
            <option value="Emulsión">Emulsión</option>
            <option value="Crema">Crema</option>
            <option value="Ungüento">Ungüento</option>
            <option value="Gel">Gel</option>
            <option value="Inyectable">Inyectable</option>
            <option value="Supositorio">Supositorio</option>
            <option value="Aerosol">Aerosol</option>
            <option value="Parches">Parches</option>
            <option value="Polvo">Polvo</option>
            <option value="Enema">Enema</option>
            <option value="Solución Oftálmica">Solución Oftálmica</option>
            <option value="Solución Nasal">Solución Nasal</option>
            <option value="Colirio">Colirio</option>
        </select>
    </div>
</div>



                            <div class="form-group">
                                <label for="viaAdministracion" class="col-sm-4 control-label label-obligatorio">Vía de Administración</label>
                                <div class="col-sm-7">
                                    <select class="form-control selectpicker" id="viaAdministracion" name="viaAdministracion" >
                                        <option value="">Seleccione una opción</option>
                                        <option value="Oral">Oral</option>
                                        <option value="Tópica">Tópica</option>
                                        <option value="Intravenosa">Intravenosa</option>
                                        <option value="Intramuscular">Intramuscular</option>
                                        <option value="Subcutánea">Subcutánea</option>
                                        <option value="Rectal">Rectal</option>
                                        <option value="Vaginal">Vaginal</option>
                                        <option value="Sublingual">Sublingual</option>
                                        <option value="Oftálmica">Oftálmica</option>
                                        <option value="Nasal">Nasal</option>
                                        <option value="Inhalatoria">Inhalatoria</option>
                                        <option value="Otica">Ótica</option>
                                        <option value="Transdérmica">Transdérmica</option>
                                        <option value="Epidural">Epidural</option>
                                        <option value="Intradérmica">Intradérmica</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unidadMedida" class="col-sm-4 control-label label-obligatorio">Unidad de Medida</label>
                                <div class="col-sm-7">
                                    <select class="form-control selectpicker" id="unidadMedida" name="unidadMedida" >
                                        <option value="">Seleccione una opción</option>
                                        <option value="Unidad">Unidad</option>
                                        <option value="Caja">Caja</option>
                                        <option value="Blíster">Blíster</option>
                                        <option value="Frasco">Frasco</option>
                                        <option value="Ampolla">Ampolla</option>
                                        <option value="Tubo">Tubo</option>
                                        <option value="Pote">Pote</option>
                                        <option value="Bolsa">Bolsa</option>
                                        <option value="Sobre">Sobre</option>
                                        <option value="Paquete">Paquete</option>
                                        <option value="Lata">Lata</option>
                                        <option value="mL">mL (mililitro)</option>
                                        <option value="L">L (litro)</option>
                                        <option value="g">g (gramo)</option>
                                        <option value="mg">mg (miligramo)</option>
                                        <option value="mcg">mcg (microgramo)</option>
                                        <option value="UI">UI (Unidad Internacional)</option>
                                        <option value="cm³">cm³ (centímetro cúbico)</option>
                                        <option value="cc">cc (equivalente a cm³)</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="laboratorio" class="col-sm-4 control-label label-obligatorio">Laboratorio</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="laboratorio" name="laboratorio" placeholder="Ej: Laboratorio Chile">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tipoArticulo" class="col-sm-4 control-label label-obligatorio">Tipo de Artículo</label>
                                <div class="col-sm-7">
                                    <select class="form-control selectpicker" id="tipoArticulo" name="tipoArticulo" >
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
                                <label for="stockMinimo" class="col-sm-4 control-label label-obligatorio">Stock Mínimo</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" id="stockMinimo" name="stockMinimo" placeholder="Ej: 10" min="0" >
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