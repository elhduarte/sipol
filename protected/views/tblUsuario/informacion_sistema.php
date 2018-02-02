<div class="well well-small">
<div class="row-fluid">
    <div class="span12">
      <legend>Información de Sistema</legend>
         <div class="row-fluid">
                  <div class="span2">
                    <label class="campotit">Comisaria</label>
                      <select  required class="span12" name="entidad" id="entidad">
                        <?php                        
                          $Criteria = new CDbCriteria();
                          $Criteria->order ='id_cat_entidad ASC';
                          $data=CatEntidad::model()->findAll($Criteria);
                          $data=CHtml::listData($data,'id_cat_entidad','nombre_entidad');
                          $contador = '0';
                          foreach($data as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                        
                        ?>
                      </select>
                  </div>

                    <div class="span2">
                    <label class="campotit">Tipo de Sede</label>
                      <select required class="span12" name="tipo_sede" id="tipo_sede">
                         <?php                        
                          $Criteria = new CDbCriteria();
                          $Criteria->order ='id_tipo_sede ASC';
                          $data=CatTipoSede::model()->findAll($Criteria);
                          $data=CHtml::listData($data,'id_tipo_sede','descripcion');
                          $contador = '0';
                          foreach($data as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                        
                        ?>
                      </select>
                  </div>

                    <div class="span2">
                    <label class="campotit">Sede Asignada</label>
                      <select required class="span12" name="sede" id="sede">
                      <option value="" style="display:none;">Seleccione Entidad</option>
                      </select>
                  </div>

                   <div class="span2">
                    <label class="campotit">Tipo De Rol</label>
                      <select required class="span12" name="role" id="role">
                        <?php                        
                          $Criteria = new CDbCriteria();
                          $Criteria->order ='id_rol ASC';
                          $data=CatRol::model()->findAll($Criteria);
                          $data=CHtml::listData($data,'id_rol','nombre_rol');
                          $contador = '0';
                          foreach($data as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                        
                        ?>               
                      </select>
                  </div>


                  <div class="span2">
                    <label class="campotit">Puesto</label>
                    <input type="text" required class ="span12"  id="puesto">   
                  </div>

                    <div class="span2">
                  <label class="campotit">Numero de Oficio</label>
                  <input type="text" class ="span12" id="oficio">
              </div>    
          </div>
          <div class="row-fluid">
            
              <div class="span2">
                <label class="campotit">Usuario/NIP</label>
                <input type="text" required class ="span12" id="usuario" required>
              </div>
              <div class="span2">
                <label class="campotit">Contraseña</label>
                <input type="text" required class ="span12" id="password" required>
              </div>
              <div class="span2">
                 <label class="campotit">Estado</label>
                  <select class="span12" name="estado" id="estado">
                    <option value="1">Activado</option>
                    <option value="2">Desactivado</option>
                  </select>
              </div>
              <div class="span6">
                <center>
                    <button class="btn btn-large" id="limpiar" style="margin-top: 10px" type="button">Limpiar</button>
                    <button class="btn btn-large btn-primary" id="bot" style="margin-top: 10px"  disabled type="submit">Guardar</button>
                </center>
              </div>    
          </div>
    </div>
</div>

</div><!--fin del well para informacion de persona-->