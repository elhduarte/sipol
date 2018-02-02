<?php 
    $id_usuario ='';
    $variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
    $id_usuario = $variable_datos_usuario[0]->id_usuario;
 ?>
<div class="well well-small">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />
  <style type="text/css">
      .iconoaceptar
    {
      background: url(images/icons/glyphicons_206_ok_2.png);
      background-position: 145px 4px;
      background-repeat: no-repeat;
      background-color: blue;
    }
    .iconocancelar
    {
      background: url(images/icons/glyphicons_207_remove_2.png);
      background-position: 145px 4px;
      background-repeat: no-repeat;
    }
  </style>
<form action="" id="guardar_usuario_sipol">
<div class="row-fluid">
  <div class="span12">
      <legend>Información Personal</legend>
          <div class="row-fluid">
              <div class="span2">
                <label class="campotit">DPI</label>
                <input type="text" class ="span12 validadpinumero" id="dpi"  maxlength="13"  placeholder="Numero DPI">
              </div>
              <div class="span2">
                <label class="campotit">Primer Nombre</label>
                <input type="text" required class ="span12" id="primer_nombre"  value="">
              </div>
              <div class="span2">
                <label class="campotit">Segundo Nombre</label>
                <input type="text" class ="span12" id="segundo_nombre"  value="">
              </div>
              <div class="span2">
                <label class="campotit">Primer Apellido</label>
                <input type="text" required class ="span12" id="primer_apellido"  value="">
              </div>
              <div class="span2">
                <label class="campotit">Segundo Apellido</label>
                <input type="text" class ="span12" id="segundo_apellido"   value="">
              </div>
              <div class="span2">
                <label class="campotit">Genero</label>
                  <select class ="span12" name="genero" id="genero">
                    <option value="0">Femenino</option>
                    <option value="1">Masculino</option>             
                </select>      
              </div>
          </div>
          <div class="row-fluid">
              <div class="span2">
                <label class="campotit">Fecha Nacimiento</label>
                <div class="input-append date" id="dp3" data-date-format="yyyy-mm-dd">
                  <input class="span10" size="16"  required id="fecha_nacimiento" type="text" value="" ><span class="add-on"><i class="icon-th"></i></span>
                    <script type="text/javascript">
                      $('#dp3').datepicker
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
                <label class="campotit">Departamento Nacimiento</label>
                  <select  class="span12" required name="cmb_depto" id="cmb_depto">
                    <?php
                      $Criteria = new CDbCriteria();
                      $Criteria->order ='departamento ASC';
                      $data=CatDepartamentos::model()->findAll($Criteria);
                      $data=CHtml::listData($data,'cod_depto','departamento');
                      $contador = '0';
                      foreach($data as $value=>$name)
                      {
                        echo '<option value="'.$value.'">'.$name.'</option>';
                      }
                      
                    ?>
                </select>
              </div>
              <div class="span2">
                <label class="campotit">Municipio Nacimiento</label>
                  <select class="span12"  required name="cmb_mupio" id="cmb_mupio">
                    <?php
                      
                      $Criteria = new CDbCriteria();
                      $Criteria->order ='municipio ASC';
                      $Criteria->condition = "cod_depto=16";
                      $data=CatMunicipios::model()->findAll($Criteria);
                      $data=CHtml::listData($data,'cod_mupio','municipio');
                      $contador = '0';
                      foreach($data as $value=>$name)
                      {
                        echo '<option value="'.$value.'">'.$name.'</option>';
                      }
                      
                    ?>
                </select>
              </div>
              <div class="span2">
                <label class="campotit">Numero Celular</label>
                <input required type="text" class ="span12" id="numeroregistro"  value="">             
              </div>
              <div class="span4">
                <label class="campotit">Correo Electronico</label>
                  <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input required type="email" class ="span11"  id="email" placeholder="Correo Electronico">
                </div>            
              </div>
          </div>

          <div class="row-fluid">
            <div class="span12">
              <label class="campotit">Dirección</label>
                <textarea class="input-block-level" id="direccion" required  type="text" placeholder="Dirección / Ubicacion de la Vivienda" rows="3" cols="15">
                </textarea>
            </div>
          </div>
  </div>
</div>
</div><!--fin del well para informacion de persona-->
<div class="well well-small">
<div class="row-fluid">
    <div class="span12">
      <legend>Información de Sistema</legend>
         <div class="row-fluid">
                  <div class="span2">
                    <label class="campotit">Comisaria</label>
                      <select  required  class="span12" name="entidad" id="entidad">
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
                      <select required  class="span12" name="tipo_sede" id="tipo_sede">
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
                      <select required  disabled class="span12" name="sede" id="sede">
                      <option value="" style="display:none;">Seleccione una Sede</option>
                      </select>
                  </div>

                   <div class="span2">
                    <label class="campotit">Tipo De Rol</label>
                      <select required   class="span12" name="role" id="role">
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
                    <button class="btn btn-large btn-primary" id="manualboot" style="margin-top: 10px"  disabled type="submit">Guardar</button>
                </center>
              </div>    
          </div>
    </div>
</div>
</div><!--fin del well para informacion de persona-->
 <input type="text" name="fotografia" style="display:none;" id="fotografia" src=''>
</form>
<div id="respuesta_ingreso"></div>
<script type="text/javascript">
$(document).ready(function(){
  $('#usuario').keyup(function(){
     var cantidad = $('#usuario').val();
      var cordenada = cantidad.length;
      if(cordenada >= 4)
      {        
      $('#manualboot').removeAttr( "disabled" );
        $.ajax({
          type: 'POST',
          url: '<?php echo Yii::app()->createUrl('TblUsuario/usuariovalidador'); ?>',
          data:
          { 
            usuario:$(this).val(),
          },
          beforeSend: function(response)
          {
            //$('#select').html('Ingresando Procesosa          },
          },
          success: function(response)
          {
            if(response=='0')
            {
               $('#manualboot').removeAttr( "disabled" );
               $("#usuario").removeClass("span12 iconocancelar").addClass("span12 iconoaceptar");
               $("#usuario").removeClass("span12 iconocancelar").addClass("span12 iconoaceptar");
            }else{
              $('#manualboot').attr('disabled', 'enabled');
              $("#usuario").removeClass("span12 iconoaceptar").addClass("span12 iconocancelar");
              $("#usuario").removeClass("span12 iconocancelar").addClass("span12 iconocancelar");
            }            
          },
        });
   return false;   
      }else{
        $('#manualboot').attr('disabled', 'enabled');
        $("#usuario").removeClass("span12 iconoaceptar").addClass("span12 iconocancelar");
        $("#usuario").removeClass("span12 iconocancelar").addClass("span12 iconocancelar");
      }     
    
  });
 $.fn.validCampoFranz = function(cadena) {
      $(this).on({
      keypress : function(e){
          var key = e.which,
            keye = e.keyCode,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = cadena;
          if(letras.indexOf(tecla)==-1 && keye!=9&& (key==37 || keye!=37)&& (keye!=39 || key==39) && keye!=8 && (keye!=46 || key==46) || key==161){
            e.preventDefault();
          }
      }
    });
  };
  $('#dpi').validCampoFranz('0123456789');
function actualizaMupio(recibe)
{
  var depto = recibe;
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
            $("#cmb_mupio").empty();
            $("#cmb_mupio").html(result);
            $("#cmb_mupio").removeAttr('disabled');            
          }
        });
}
function actualizaSede(entidad,tipo_sede)
{
  var entidad = entidad;
   var tipo_sede = tipo_sede;
  //var entidad = $('#cmb_entidad').val();
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
            $("#sede").empty();
            $("#sede").html(result);
            $("#sede").removeAttr('disabled');            
          }
        });
}
$('#cmb_depto').change(function(){
var a = $('#cmb_depto').val();
actualizaMupio(a);
});
$('#entidad').change(function(){
var entidad = $('#entidad').val();
var tipo_sede = $('#tipo_sede').val();
actualizaSede(entidad,tipo_sede);
});
$('#tipo_sede').change(function(){
var entidad = $('#entidad').val();
var tipo_sede = $('#tipo_sede').val();
actualizaSede(entidad,tipo_sede);
});
$('#guardar_usuario_sipol').submit(function(){     
      /*Informacion Personal*/
      var dpi = $('#dpi').val();
      var primer_nombre = $('#primer_nombre').val();
      var segundo_nombre = $('#segundo_nombre').val();
      var primer_apellido = $('#primer_apellido').val();
      var segundo_apellido = $('#segundo_apellido').val();     
      var genero = $('#genero').val();
      var fecha_nacimiento = $('#fecha_nacimiento').val();      
      var cmb_depto = $("#cmb_depto").val(); 
      //alert(cmb_depto);
      var cmb_mupio = $('#cmb_mupio').val();
      var numeroregistro  = $('#numeroregistro').val();
       var email = $('#email').val();
      var direccion = $('#direccion').val();
      /*Informacion de Sistema*/
      var entidad = $('#entidad').val();
      var tipo_sede = $('#tipo_sede').val();
      var sede = $('#sede').val();
      var role = $('#role').val();
      var puesto = $('#puesto').val();
      var oficio = $('#oficio').val();
      var usuario = $('#usuario').val();
      var password = $('#password').val();
      var estado = $('#estado').val();
      var fotografia = $('#fotografia').val();     
      if(dpi=="")
      {
        dpi = "0";
      } 
      $.ajax({
      type: 'POST',
      url: '<?php echo Yii::app()->createUrl('TblUsuario/guardarusuariodpimanual'); ?>',
      data: {            
            dpi: dpi,
            primer_nombre: primer_nombre,
            segundo_nombre: segundo_nombre,
            primer_apellido: primer_apellido,
            segundo_apellido: segundo_apellido,
            genero: genero,
            fecha_nacimiento: fecha_nacimiento,            
            cmb_depto: cmb_depto,
            cmb_mupio: cmb_mupio,
            numeroregistro:numeroregistro,
            email: email,
            direccion: direccion,            
            entidad: entidad,
            tipo_sede: tipo_sede,
            sede: sede,
            role: role,
            puesto: puesto,
            oficio: oficio,
            usuario: usuario,
            password: password,
            estado: estado, 
            fotografia:fotografia,
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
           $('#modalprocesando').modal('hide');
       window.open('index.php?r=TblUsuario/carta&carta='+html,'_blank');
        $(location).attr('href',"index.php?r=TblUsuario/crear_usuario"); 
      },// fin de success
    });//fin de la funcion ajax
    return false;    
    });
});
</script>

<?php 


        #var_dump($data);
 
?>