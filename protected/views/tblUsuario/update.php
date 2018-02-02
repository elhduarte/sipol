<div class="cuerpo">


  <ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#home">Usuario</a></li>
  <li><a href="#idsedeopciones">Opciones de Sede</a></li>
  <li><a href="#idrolopciones">Opciones de Rol</a></li>
  <li><a href="#idcambios">Contraseñas</a></li>
</ul>

<h3>Actualizar Usuario: <?php echo $model->primer_nombre." ".$model->segundo_nombre." ".$model->primer_apellido." ".$model->segundo_apellido; ?></h3>
<hr>

<div class="tab-content">
  <div class="tab-pane active well" id="home">

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>



  </div><!--termina el tab para el usuario-->
  <div class="tab-pane well" id="idsedeopciones">

    <?php
$idusuario =$model->id_usuario;
$sql="SELECT 
u.*,
depto.departamento as nombredepartamento,
mupio.municipio as nombremunicipio, 
r.nombre_rol as nombrerol, 
e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as nombrecomisaria
FROM sipol_usuario.tbl_rol_usuario ru
LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
WHERE u.id_usuario = ".$idusuario."";


      $resultado = Yii::app()->db->createCommand($sql)->queryAll();
      $trasfomacionusuario = $resultado[0];
      $trasfomacionusuario = json_encode($trasfomacionusuario);
       $usuariodatos = json_decode($trasfomacionusuario);


  $puesto = $usuariodatos->puesto;
  $usuario = $usuariodatos->usuario;
  $password = $usuariodatos->password;
  $email = $usuariodatos->email;
  $no_oficio_solicitud = $usuariodatos->no_oficio_solicitud;
  $id_usuario_crea = $usuariodatos->id_usuario_crea;
  $fecha_crea = $usuariodatos->fecha_crea;
  $estado = $usuariodatos->estado;
  $primer_nombre = $usuariodatos->primer_nombre;
  $segundo_nombre = $usuariodatos->segundo_nombre;
  $primer_apellido = $usuariodatos->primer_apellido;
  $segundo_apellido = $usuariodatos->segundo_apellido;
  $fecha_nacimiento = $usuariodatos->fecha_nacimiento;
  $dpi = $usuariodatos->dpi;
  $no_orden = $usuariodatos->no_orden;
  $direccion = $usuariodatos->direccion;
  $departamento = $usuariodatos->departamento;
  $municipio = $usuariodatos->municipio;
  $sexo = $usuariodatos->sexo;
  $no_registro = $usuariodatos->no_registro;
  $foto = $usuariodatos->foto;
  $proceso = $usuariodatos->proceso;
  $nombredepartamento = $usuariodatos->nombredepartamento;
  $nombremunicipio = $usuariodatos->nombremunicipio;
  $nombrerol = $usuariodatos->nombrerol;
  $nombrecomisaria = $usuariodatos->nombrecomisaria;

     //echo $nombrerol;


?>



         <legend>Cambio de Sede</legend>
         
<form action="" id="actualizarformulariomensaje">  
 <div class="row-fluid">
  <div class="span12">  
      <h5>Actualización de Sede, Seleccione  Ubicacion Actual.</h5> 
    <div class="row-fluid">
      <div class="span6">
         <h5>Seleccione Comisaria:</h5>
          <select required name="entidad_ingreso" id="entidad_ingreso" >
            <option value="" style="display:none" >Seleccione Comisaria</option>
            <option value="1">MINGOB</option>
          <option value="2">Comisaria 11</option>
            <option value="3">Comisaria 12</option>
            <option value="4">Comisaria 13</option>
            <option value="5">Comisaria 14</option>
            <option value="6">Comisaria 15</option>
            <option value="7">Comisaria 16</option>
            <option value="8">Comisaria 21</option>
            <option value="9">Comisaria 22</option>
            <option value="10">Comisaria 23</option>
            <option value="11">Comisaria 24</option>
            <option value="12">Comisaria 31</option>
            <option value="13">Comisaria 32</option>
            <option value="14">Comisaria 33</option>
            <option value="15">Comisaria 34</option>
            <option value="16">Comisaria 41</option>
            <option value="17">Comisaria 42</option>
            <option value="18">Comisaria 43</option>
            <option value="19">Comisaria 44</option>
            <option value="20">Comisaria 51</option>
            <option value="21">Comisaria 52</option>
            <option value="22">Comisaria 53</option>
            <option value="23">Comisaria 61</option>
            <option value="24">Comisaria 62</option>
            <option value="25">Comisaria 71</option>
            <option value="26">Comisaria 72</option>
            <option value="27">Comisaria 73</option>
            <option value="28">Comisaria 74</option>
          </select>
          </div>
      <div class="span6">
         <h5>Seleccione Tipo de Sede:</h5>
      <select required name="tipo_sede_ingreso" id="tipo_sede_ingreso">      
        <option value="1">Administrativa</option>
        <option value="2">Serenazgo</option>
        <option value="3">Sub Estación </option>
        <option value="4">Estacion Modelo</option>
        <option value="5">Comisaria Central</option>
        <option value="6">Estacion</option>
      </select>
      </div>
    </div>
      <div class="row-fluid">
            <div class="span6">
              <h5>Seleccione Sede:</h5>
              <select required  disabled name="sede_ingreso" id="sede_ingreso">
                <option value="" style="display:none;">Seleccione una Sede</option>
              </select>
            </div>
          <div class="span6 well well-small">
          <h5>Información!</h5>
           Estos seran los datos de ubicacion registrados para el usuario.
          </div>
      </div>
       <div class="row-fluid">
            <div class="span12"> 
              <button class="btn btn-large btn-primary pull-right"  id="actualizarbutton" type="button">Actualizar Datos</button>
            </div>
      </div>  
  </div>
</div>
</form> 
<script type="text/javascript">  
  $(document).ready(function(){
     /* $.ajax({
        type:'POST',
        url:'/sipolnuevo/index.php?r=Funcionesp/InformacionSede',
        beforeSend:function()
        {
        },
        success:function(response)
        { 
          $('.infousuario').html(response);
        },
      })*/;//fin del ajax

    $('#actualizarbutton').click(function(){
      var url = window.location.pathname+"?r=Funcionesp/actualizarubicacion";
      var urll = window.location.pathname+"?r=site/login";
          var comisaria =  $('#entidad_ingreso').val();  
   // alert(comisaria);
    var tipo_sede = $('#tipo_sede_ingreso').val();
    //alert(tipo_sede);
      var sede_ingreso =  $('#sede_ingreso').val();
      //alert(sede_ingreso);
      if(comisaria == ''){
        alert('Seleccine una Comisaria');
      }else if(tipo_sede == ''){
        alert('Seleccine tipo de sede');
      }else if(sede_ingreso == ''){
        alert('Seleccine sede');
      }else{
          var idusuario =  $('#codigousuario').val();
      $.ajax({
        type:'POST',
        url:url,
        data:{idusuario:idusuario,sede_ingreso:sede_ingreso},
        beforeSend:function()
        {
          //$('#cargandosugerencia').show();
        },
        success:function(response)
        { 
          $('#modalmensajesingreso').modal('hide')
          $('#modalmensajesingreso').html('');    
          $('#modalmensajesingreso').hide();
          alert('Gracias por actualizar ubicacion'+ response);
          $(location).attr('href',urll); 
        },
      });//fin del ajax
      return false;

      }
    });
   $('#entidad_ingreso').change(function()
   {
     $('#tipo_sede_ingreso').val('');
     $('#sede_ingreso').val('');
      var comisaria =  $('#entidad_ingreso').val();  
      var tipo_sede = $('#tipo_sede_ingreso').val();
        actualizaSede_ingreso(comisaria,tipo_sede);    
    });
   $('#tipo_sede_ingreso').change(function()
   {
    // $('#tipo_sede_ingreso').val('');
      $('#sede_ingreso').val('');
      var comisaria =  $('#entidad_ingreso').val();  
      var tipo_sede = $('#tipo_sede_ingreso').val();
      if(comisaria =='')
      {
        alert('Seleccione una Comisaria');
      }else{
        actualizaSede_ingreso(comisaria,tipo_sede);
      }    
    });
     function actualizaSede_ingreso(entidad,tipo_sede)
    {
     var entidad = entidad;
      var tipo_sede = tipo_sede;
      var url = window.location.pathname+"?r=TblSede/getsede";
     $.ajax({
             type: "POST",
             url: url,
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
             },
             success: function(result)
             {            
                  $('#modalprocesando').modal('hide');
               $("#sede_ingreso").empty();
               $("#sede_ingreso").html(result);
               $("#sede_ingreso").removeAttr('disabled');            
             }
           });
    }
  });
</script>









  </div><!--termina el tab para el tipo de sede-->
  <div class="tab-pane well" id="idrolopciones">


<input type="text" style="display:none;" id="codigousuario" value="<?php echo $model->id_usuario; ?>">




 <legend>Cambio de Rol</legend>
            <br>
            <strong>Información sobre los permisos en el sistema del usuario: </strong> <?php echo $model->primer_nombre." ".$model->segundo_nombre." ".$model->primer_apellido." ".$model->segundo_apellido; ?>
               <br>
            <strong>Permiso Asignado en el sistema:  <?php  echo strtoupper($nombrerol); ?></strong><br>
            <br>
            <span class="label label-inverse">Cambiar ROL</span>
             <br>
              <label class="radio inline radioInline">
              <input type="radio" id ="tipo" name="tipo" value="1" checked> No
              </label>
              <label class="radio inline radioInline">
              <input type="radio" id ="tipo" name="tipo" value="2"> Si
            </label>
            <br>
              


<div id="opciones" style="display:none;">
  <hr>
  <div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
       <div class="span6">
        <blockquote>
                <p><i class="icon-lock"></i> Protección del Sistema</p>
                <small>Unicamente los administradores del sistema tienen autorizacion para hacer este cambio <cite title="Source Title"></cite></small>
                  <small>Seleccione el rol que necesita para este usuario, Ingrese la contraseña del administrador <cite title="Source Title"></cite></small>
        </blockquote>

      </div>
      <form class="form-inline" id="actualiza_rol">
      <div class="span6">        
        <div class="row-fluid">       
          <div class="span6">
              <label>Tipo De Rol</label>
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
          <div class="span6">
             <label>Contraseña del sistema</label>
               <br>
            <input type="password" class="span8"  id="password" required placeholder="Contraseña">
            <button type="submit" class="btn btn-primary">Cambiar Rol</button>
          </div>
        </div>
      </div>
      </form>
     
    </div>
  </div>
</div>
</div>
  </div><!--termina el tab para el tipo de rol-->
  <div class="tab-pane well" id="idcambios">



<div id="opciones">
  <hr>
  <div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
       <div class="span6">
        <blockquote>
                <p><i class="icon-lock"></i> Protección del Sistema</p>
                <small>Unicamente los administradores del sistema tienen autorizacion para hacer este cambio <cite title="Source Title"></cite></small>
                  <small>Seleccione Generar Contraseña, Automaticamente se envia un correo y un mensaje telefonico con su clave temporal <cite title="Source Title"></cite></small>
        </blockquote>

      </div>
      <form class="form-inline" id="actualiza_pass">
      <div class="span6">        
        <div class="row-fluid">       
          <div class="span6">
  
               <button type="submit" class="btn btn-primary">Generar Contraseña</button>
                      
          </div>
          <div class="span6">
            <!--img src="images/icons/glyphicons_010_envelope.png">
             <img src="images/icons/glyphicons_169_phone.png"-->

            <?php

           /* $upd = "UPDATE sipol_usuario.tbl_usuario
      SET password = '".$variablepassword."'
      WHERE id_usuario =".$codigousuario."";
      $resultado = Yii::app()->db->createCommand($upd)->execute();*/


            ?>
          </div>
        </div>
      </div>
      </form>
     
    </div>
  </div>
</div>
</div>


  </div>
</div>
<script type="text/javascript">
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>




<hr>














	
</div>

<script type="text/javascript">
$(document).ready(function(){
$('#actualiza_rol').submit(function(){
var codigousuario = $('#codigousuario').val();
var password =$('#password').val();
var role =$('#role').val();

   $.ajax({
         type: "POST",
         url: <?php echo "'".CController::createUrl('tblUsuario/ActualizarRol')."'"; ?>,
         data: {
           codigousuario:codigousuario,
            password:password,
            role:role
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
              //alert(result);
              if(result=='0'){
                alert('No se puede Actualizar Necesita Contraseña del sistema');

              }else{
                alert('Exito en la actualización');
                 window.location.replace('<?php echo CController::createUrl("tblUsuario/admin"); ?>');   

              }
             
         }
       });
   return false;
});


$('#actualiza_pass').submit(function(){
var codigousuario = $('#codigousuario').val();

   $.ajax({
         type: "POST",
         url: <?php echo "'".CController::createUrl('tblUsuario/PassRestaurar')."'"; ?>,
         data: {
           codigousuario:codigousuario
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
              //alert(result);
             /* if(result=='0'){
                alert('No se puede Actualizar Necesita Contraseña del sistema');

              }else{
                alert('Exito en la actualización');
                 window.location.replace('<?php echo CController::createUrl("tblUsuario/admin"); ?>');   

              }*/
              alert(result);
             
         }
       });
   return false;
});


 $("#tipo").live("click", function(){
    //var id = parseInt($(this).val(), 10);
    var opcion =  $(this).val();
    if(opcion == 1)
    {
          $('#opciones').hide();
    }else
    {
        $('#opciones').show();  
    }   
  }); 
});
</script>

