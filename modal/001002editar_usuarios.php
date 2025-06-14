    <?php
        if (isset($con))
        {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar usuario</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="editar_usuario" name="editar_usuario">
            <div id="resultados_ajax2"></div>
            <div class="form-group">
                <label for="firstname2" class="col-sm-4 control-label">Nombres</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="firstname2" name="firstname2" placeholder="Nombres" required>
                  <input type="hidden" id="mod_id" name="mod_id">
                </div>
              </div>
              <div class="form-group">
                <label for="lastname2" class="col-sm-4 control-label">Apellidos</label> 
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="lastname2" name="lastname2" placeholder="Apellidos" required>
                </div>
              </div>
              <div class="form-group">
                <label for="user_name2" class="col-sm-4 control-label">Usuario</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="user_name2" name="user_name2" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
                </div>
              </div>
              <div class="form-group">
                <label for="user_rut2" class="col-sm-4 control-label">Rut</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="user_rut2" name="user_rut2" placeholder="Rut" title="Rut">
                </div>
              </div>
              <div class="form-group">
                <label for="user_email2" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="user_email2" name="user_email2" placeholder="Correo electrónico" required>
                </div>
              </div>
 
              <div class="form-group">
                 <label for="user_idperfil2" class="col-sm-4 control-label">Seleccionar Perfil </label>
                  <div class="col-sm-8">
                    <select class='form-control' name='user_idperfil2' id='user_idperfil2'>
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
                <label for="user_password_set2" class="col-sm-4 control-label" >Cambio contraseña</label>
                <div class="col-sm-8">
                  <label><input type="checkbox" class="form-check-input" id="user_password_set2" name="user_password_set2"> Habilitado</label>
                </div>
              </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <?php
        }
    ?>