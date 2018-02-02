
<form class="form-signin  cuerpo" method="POST" action="" id="solicitud" style="margin-top:2%;">
  <div class="row-fluid" style="margin-bottom:20px;">
  <div class="span4" align="center" style="padding-bottom:5%"> 
    <img class="img_login" src="<?php echo Yii::app()->request->baseUrl."/images/inicio.png"; ?>" style="max-width: 43%;">   
  </div>
  <div class="span8">
  <h1 style="line-height: 30px;">SIPOL</h1>
  Recuperación de Contraseña
  </div>
<div style="margin-bottom: 10px;">
    <legend class="legend"></legend>
    <p class="comentario-fit">Por favor ingresa el NIP/USUARIO.</p>
  </div>
  
<div style="margin-bottom: 10px;">
    <legend class="legend"></legend>
    <p class="comentario-fit">Los campos con <span class="required">*</span> son obligatorios.</p>
  </div>

</div>

  <div class="control-group">
    <label class="control-label" for="nip"><span class="required">* </span>NIP/USUARIO </label>
    <div class="controls">
      <input type="text"  id="nip" required class="input-block-level" placeholder="NIP">
    </div>
  </div>




<div class="row-fluid">
  <div class="span8 offset2">
    <div class="row-fluid">
      <div class="span12">
        <div class="row-fluid">
          <div class="span2"><img src="images/icons/glyphicons_010_envelope.png"></div>
          <div class="span9"><input type="checkbox" id="correo" name="opciones1" checked value="1"> Correo</div>
        </div>
      </div>
    </div>
     <div class="row-fluid">
      <div class="span12">
        <div class="row-fluid">
          <div class="span2 "><img src="images/icons/glyphicons_163_iphone.png"></div>
          <div class="span9"> <input type="checkbox" id="telefono" name="opciones2" value="2"> Mensajito</div>
        </div>
      </div>
    </div>
  </div>
</div>




  <div class="control-group" align="center">
    <button id ="regresa" class="btn " type="button">Regresar </button> 
    <button class="btn btn-primary" type="submit">Solicitar</button>
  </div>
   <div id="resultadorestablecer"></div>

</form>
<script type="text/javascript">
$(document).ready(function(){



    $('#regresa').click(function(){
          var  url= "<?php echo Yii::app()->createUrl('site/login'); ?>";   
          $(location).attr('href',url);
          });

  $('#solicitud').submit(function(){
    //e.preventDefault();

     var chech = "";
    $("input:checkbox:checked").each(function(){
        //cada elemento seleccionado
        chech = $(this).val()  + "," + chech  ;
        //alert($(this).val());
      });
    


    var nip = $('#nip').val();
     $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("TblUsuario/RestablecerPass"); ?>',
        data:{
          nip:nip,
          chech:chech
              },
        beforeSend: function(responder)
        {
          $('#resultadorestablecer').html('<img src="images/loading.gif" alt="Cargando" style="height: auto;max-width: 10%;">');
          
        },
        success: function(responder)
        {
          $('#resultadorestablecer').html(responder);
          $('#numerousaurio').val('');
        $('#numerodpi').val('');
        }
        
      });
     return false;

  });
});  
</script>