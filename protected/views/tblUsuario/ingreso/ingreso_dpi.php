<?php 
    $id_usuario ='';
    $variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
    $id_usuario = $variable_datos_usuario[0]->id_usuario;


    
 ?>
<style type="text/css">  
    .iconoaceptar
    {
        background: url(images/icons/glyphicons_206_ok_2.png);
         background-position: 300px 4px;
        background-repeat: no-repeat;
    }
    .iconocancelar
    {
        background: url(images/icons/glyphicons_207_remove_2.png);
         background-position: 300px 4px;
        background-repeat: no-repeat;
    }
</style>

<form action="" id="dpiguardar_usuario_sipol">
  <div class="row-fluid">
    <div class="span10 well well-small">
      <legend>Información Personal</legend>
          <div class="row-fluid">
              <div class="span2">
                <label class="campotit">DPI</label>
                <input type="text" readonly disabled  class ="span12 validadpinumero" id="dpidpi"  maxlength="13"  placeholder="Numero DPI" value="<?php echo $dpi; ?>">
              </div>
              <div class="span2">
                <label class="campotit">Primer Nombre</label>
                <input type="text" readonly disabled  required class ="span12" id="dpiprimer_nombre"  value="<?php echo $primer_nombre; ?>">
              </div>
              <div class="span2">
                <label class="campotit">Segundo Nombre</label>
                <input type="text" readonly disabled  class ="span12" id="dpisegundo_nombre"  value="<?php echo $segundo_nombre; ?>">
              </div>
              <div class="span2">
                <label class="campotit">Primer Apellido</label>
                <input type="text" readonly disabled  required class ="span12" id="dpiprimer_apellido"  value="<?php echo $primer_apellido; ?>">
              </div>
              <div class="span2">
                <label class="campotit">Segundo Apellido</label>
                <input type="text" readonly disabled  class ="span12" id="dpisegundo_apellido"   value="<?php echo $segundo_apellido; ?>">
              </div>
              <div class="span2">
                <label class="campotit">Genero</label>
                 <input type="text" readonly disabled  class ="span12" id="dpigenero"   value="<?php echo $genero; ?>">     
              </div>
          </div>
          <div class="row-fluid">
              <div class="span2">
                <label class="campotit">Fecha Nacimiento</label>
                <div class="input-append date" readonly disabled  id="dpidp3" data-date-format="yyyy-mm-dd">
                  <input class="span10" size="16"  value="<?php echo $nacimiento; ?>" required id="dpifecha_nacimiento" type="text" value="" ><span class="add-on"><i class="icon-th"></i></span>
                    <script type="text/javascript">
                      $('#dpidp3').datepicker
                      ({
                          todayBtn: true,
                          language: "es",
                          orientation: "auto left",
                          keyboardNavigation: false,
                          autoclose: true
                        });
                    </script>
                  </div>
              </div>
              <div class="span2">
                <label class="campotit">Departamento</label>

                <input type="text" class ="span11"  name="cmb_depto"  readonly disabled id="dpicmb_depto" value="<?php echo $departamento_renap; ?>">
                 
              </div>
              <div class="span3">
                <label class="campotit">Municipio</label>                 
                    <input type="text" class ="span11" name="cmb_mupio" readonly disabled id="dpicmb_mupio"value="<?php echo $municipio_renap; ?>">              
              </div>
              <div class="span2">
                <label class="campotit">Numero Celular</label>
                <input required type="text" class ="span12" id="dpinumeroregistro"  value="">           
              </div>
              <div class="span3">
                <label class="campotit">Correo Electronico</label>
                  <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input required type="email" class ="span11"  id="dpiemail" placeholder="Correo Electronico">
                </div>            
              </div>
          </div>

          <div class="row-fluid">
            <div class="span12">
              <label class="campotit">Dirección</label>
                <textarea class="input-block-level" id="dpidireccion" required  type="text" placeholder="Dirección / Ubicacion de la Vivienda" rows="3" cols="15">
                </textarea>
            </div>
          </div> 
    </div><!--Termina la condicion para el contenedor de la informacion personal-->
    <div class="span2">
      <label class="campotit">Fotografia</label>
       <center><img class="imagen_renap" src='<?php echo $foto; ?>'/></center>
        <input type="text" name="fotografia"  id="dpifotografia" style="display:none" src='<?php echo $nuevafoto; ?>'>
    </div><!--Termina la condicion para el contenedor de la informacion fotografia-->
  </div>

<?php 
   # $this->renderPartial('informacion_sistema');
?>

<div class="well well-small">
<div class="row-fluid">
    <div class="span12">
      <legend>Información de Sistema</legend>
         <div class="row-fluid">
                  <div class="span2">
                    <label class="campotit">Comisaria</label>
                      <select  required class="span12" name="dpientidad" id="dpientidad">
                        <?php                        
                          $variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
                          $id_rol = $variable_datos_usuario[0]->id_rol; 
                          $id_cat_entidad = $variable_datos_usuario[0]->id_cat_entidad;                                                
                          $data=CatEntidad::model()->crearcomboentidad($id_rol,$id_cat_entidad);  
                          echo '<option value="" style="display:none;">Seleccione Entidad</option>';
                          foreach($data as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                 
                        ?>
                      </select>
                  </div>

                    <div class="span2">
                    <label class="campotit">Tipo de Sede</label>
                      <select required class="span12" name="dpitipo_sede" id="dpitipo_sede">
                        <?php                        
                          $Criteria = new CDbCriteria();
                          $Criteria->order ='id_tipo_sede ASC';
                          $data=CatTipoSede::model()->findAll($Criteria);
                          $data=CHtml::listData($data,'id_tipo_sede','descripcion');                         
                          foreach($data as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                        
                        ?>
                      </select>
                  </div>

                    <div class="span2">
                    <label class="campotit">Sede Asignada</label>
                      <select required class="span12" name="dpisede" id="dpisede">
                      <option value="" style="display:none;">Seleccione Entidad</option>
                      </select>
                  </div>

                   <div class="span2">
                    <label class="campotit">Tipo De Rol</label>
                      <select required class="span12" name="dpirole" id="dpirole">
                      <?php    
                         $variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
                          $id_rol = $variable_datos_usuario[0]->id_rol;
                          $datarol=CatRol::model()->crearcomborol($id_rol);  
                          echo '<option value="" style="display:none;">Seleccione Rol</option>';              
                          foreach($datarol as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                      
                        ?>                
                      </select>
                  </div>


                  <div class="span2">
                    <label class="campotit">Puesto</label>
                    <input type="text" required class ="span12"  id="dpipuesto">   
                  </div>

                    <div class="span2">
                  <label class="campotit">Numero de Oficio</label>
                  <input type="text" class ="span12" id="dpioficio">
              </div>    
          </div>
          <div class="row-fluid">
            
              <div class="span2">
                <label class="campotit">Usuario/NIP</label>
                <input type="text" required class ="span12" id="dpiusuario" required>
              </div>
              <div class="span2">
                <label class="campotit">Contraseña</label>
                <input type="text" required class ="span12" id="dpipassword" required>
              </div>
              <div class="span2">
                 <label class="campotit">Estado</label>
                  <select class="span12" name="dpiestado" id="dpiestado">
                    <option value="1">Activado</option>
                    <option value="2">Desactivado</option>
                  </select>
              </div>
              <div class="span6">
                <center>
                    <button class="btn btn-large" id="limpiar" style="margin-top: 10px" type="button">Limpiar</button>
                    <button class="btn btn-large btn-primary" id="dpibot" style="margin-top: 10px"  disabled type="submit">Guardar</button>
                </center>
              </div>    
          </div>
    </div>
</div>

</div><!--fin del well para informacion de persona-->






<div id="dpifotografia" style="display:none;"></div>
</form>

<script type="text/javascript">
$(document).ready(function(){
  $('#dpilimpiar').click(function(){
  });

  $('#dpiusuario').keyup(function(){
     var dpicantidad = $('#dpiusuario').val();
      var dpicordenada = dpicantidad.length;
      if(dpicordenada >= 4)
      {        
      $('#dpibot').removeAttr( "disabled" );
        $.ajax({
          type: 'POST',
          url: '<?php echo Yii::app()->createUrl('TblUsuario/usuariovalidador'); ?>',
          data:
          { 
            usuario:$(this).val(),
          },
         beforeSend: function(html)
          {
            
          },//fin beforesend
          success: function(response)
          {
            if(response=='0')
            {

               $('#dpibot').removeAttr( "disabled" );
               $("#dpiusuario").removeClass("span12 iconocancelar").addClass("span12 iconoaceptar");
               $("#dpiusuario").removeClass("span12 iconocancelar").addClass("span12 iconoaceptar");
            }else{
        
              $('#dpibot').attr('disabled', 'enabled');
              $("#dpiusuario").removeClass("span12 iconoaceptar").addClass("span12 iconocancelar");
              $("#dpiusuario").removeClass("span12 iconocancelar").addClass("span12 iconocancelar");
            }
            
          },
        });
   return false;   
      }else{

        $('#dpibot').attr('disabled', 'enabled');
        $("#dpiusuario").removeClass("span12 iconoaceptar").addClass("span12 iconocancelar");
              $("#dpiusuario").removeClass("span12 iconocancelar").addClass("span12 iconocancelar");
      }
     
    
  });

 $.fn.validCampoFranz = function(cadena) {
      $(this).on({
      keypress : function(e){
          var dpikey = e.which,
            keye = e.keyCode,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = cadena;
          if(letras.indexOf(tecla)==-1 && keye!=9&& (key==37 || keye!=37)&& (keye!=39 || key==39) && keye!=8 && (keye!=46 || key==46) || key==161){
            e.preventDefault();
          }
      }
    });
  };
  $('#dpidpi').validCampoFranz('0123456789');
function dpiactualizaMupio(recibe)
{

  var depto = recibe;
  //var dpidepto = $('#dpicmb_depto').val();
  $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('CatMunicipios/getMupios')."'"; ?>,
          data: {param:depto},
          beforeSend: function(html)
          {
             $('#modalprocesando').modal({
                      show: true,
                      keyboard: false,
                      backdrop: "static"
                  });
          },//fin beforesend
          success: function(result)
          {
            $('#modalprocesando').modal('hide');
            $("#dpicmb_mupio").empty();
            $("#dpicmb_mupio").html(result);
            $("#dpicmb_mupio").removeAttr('disabled');
            
          }

        });
}
function dpiactualizaSede(entidad,tipo_sede)
{

  var dpientidad = entidad;
   var dpitipo_sede = tipo_sede;
  //var dpientidad = $('#dpicmb_entidad').val();
  $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('TblSede/getsede')."'"; ?>,
          data: {
            entidad:entidad,
            tipo_sede:tipo_sede
          },
          beforeSend: function(html)
            {
               $('#modalprocesando').modal({
                        show: true,
                        keyboard: false,
                        backdrop: "static"
                    });
            },//fin beforesend
          success: function(result)
          {
            $('#modalprocesando').modal('hide');
            $("#dpisede").empty();
            $("#dpisede").html(result);
            $("#sede").removeAttr('disabled');
            
          }

        });
}


$('#dpientidad').change(function(){
var dpientidad = $('#dpientidad').val();
var dpitipo_sede = $('#dpitipo_sede').val();
dpiactualizaSede(dpientidad,dpitipo_sede);
});

$('#dpitipo_sede').change(function(){
var dpientidad = $('#dpientidad').val();
var dpitipo_sede = $('#dpitipo_sede').val();
dpiactualizaSede(dpientidad,dpitipo_sede);
});


$('#dpiguardar_usuario_sipol').submit(function(){
 
      /*Informacion Personal*/      
      var dpidpi = $('#dpidpi').val();
      var dpiprimer_nombre = $('#dpiprimer_nombre').val();
      var dpisegundo_nombre = $('#dpisegundo_nombre').val();
      var dpiprimer_apellido = $('#dpiprimer_apellido').val();
      var dpisegundo_apellido = $('#dpisegundo_apellido').val();     
      var dpigenero = $('#dpigenero').val();

      var dpifecha_nacimiento = $('#dpifecha_nacimiento').val();      
      var dpicmb_depto = $('#dpicmb_depto').val();

      var dpicmb_mupio = $('#dpicmb_mupio').val();
      var dpinumeroregistro  = $('#dpinumeroregistro').val();
       var dpiemail = $('#dpiemail').val();

      var dpidireccion = $('#dpidireccion').val();

      /*Informacion de Sistema*/
      
      var dpientidad = $('#dpientidad').val();
      var dpitipo_sede = $('#dpitipo_sede').val();
      var dpisede = $('#dpisede').val();
      var dpirole = $('#dpirole').val();
      var dpipuesto = $('#dpipuesto').val();
      var dpioficio = $('#dpioficio').val();
      var dpiusuario = $('#dpiusuario').val();
      var dpipassword = $('#dpipassword').val();
      var dpiestado = $('#dpiestado').val();
      var dpifotografia = $('#dpifotografia').val();
    
    
      $.ajax({
      type: 'POST',
      url: '<?php echo Yii::app()->createUrl('TblUsuario/guardarusuariodpi'); ?>',
      data: {            
            dpi: dpidpi,
            primer_nombre: dpiprimer_nombre,
            segundo_nombre: dpisegundo_nombre,
            primer_apellido: dpiprimer_apellido,
            segundo_apellido: dpisegundo_apellido,
            genero: dpigenero,
            fecha_nacimiento: dpifecha_nacimiento,            
            cmb_depto: dpicmb_depto,
            cmb_mupio: dpicmb_mupio,
            numeroregistro: dpinumeroregistro,
            email: dpiemail,
            direccion: dpidireccion,            
            entidad: dpientidad,
            tipo_sede: dpitipo_sede,
            sede: dpisede,
            role: dpirole,
            puesto: dpipuesto,
            oficio: dpioficio,
            usuario: dpiusuario,
            password: dpipassword,
            estado: dpiestado, 
            fotografia:dpifotografia,
            idusuarioingresa: '<?php echo $id_usuario; ?>',        
            
          },
      beforeSend: function(html)
      {
         $('#modalprocesando').modal({
                  show: true,
                  keyboard: false,
                  backdrop: "static"
              });
      },//fin beforesend
      success: function(html)
      {

        console.log(html);
       
        $('#modalprocesando').modal('hide');
         window.open('index.php?r=TblUsuario/carta&carta='+html,'_blank');
        $(location).attr('href',"index.php?r=TblUsuario/crear_usuario"); 
        
        },// fin de success

    });//fin de la funcion ajax
    return false;
    });
});
</script>
<div id="dpirespuesta_ingreso"></div>






