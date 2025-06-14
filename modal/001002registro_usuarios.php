    <?php
        if (isset($con))
        {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo usuario</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">
            <div id="resultados_ajax"></div>
              <div class="form-group">
                <label for="firstname" class="col-sm-4 control-label">Nombres</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombres" required>
                </div>
              </div>
              <div class="form-group">
                <label for="lastname" class="col-sm-4 control-label">Apellidos</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellidos" required>
                </div>
              </div>
              <div class="form-group">
                <label for="user_name" class="col-sm-4 control-label">Usuario</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
                </div>
              </div>
              <div class="form-group">
                <label for="user_rut" class="col-sm-4 control-label">Rut</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="user_rut" name="user_rut" placeholder="Rut" title="Rut">
                </div>
              </div>
              <div class="form-group">
                <label for="user_email" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo electrónico" required>
                </div>
              </div>
              
                <div class="form-group">
                <label class="col-sm-4 control-label">Seleccionar Perfil </label>
                    <div class="col-sm-8">
                        <select class='form-control' name='id_perfil' id='id_perfil' ;">
                            <option value="">Sel. Perfil</option>
                            <?php 
                            $query_ce=mysqli_query($con,"select * from perfil order by perfil_descripcion");
                            while($rw=mysqli_fetch_array($query_ce))    {
                                ?>
                            <option value="<?php echo $rw['perfil_id'];?>"><?php echo $rw['perfil_descripcion'];?></option>         
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

              <div class="form-group">
                <label for="user_password_new" class="col-sm-4 control-label">Contraseña</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="user_password_new" name="user_password_new" placeholder="Contraseña" pattern=".{5,}" title="Contraseña ( min . 5 caracteres)" required>
                </div>
              </div>
              <div class="form-group">
                <label for="user_password_repeat" class="col-sm-4 control-label">Repite contraseña</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Repite contraseña" pattern=".{5,}" required>
                </div>
              </div>

              <div class="form-group">
                <label for="user_password_set" class="col-sm-4 control-label" >Cambio contraseña</label>
                <div class="col-sm-8">
                  <label><input type="checkbox" class="form-check-input" id="user_password_set" name="user_password_set" checked> Habilitado</label>
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