
<form class="form-signin well well-small" method="POST" action="" id="solicitud" style="margin-top:2%;">
  <div class="row-fluid" style="margin-bottom:20px;">
  <div class="span4" align="center"> 
    <img class="img_login" src="<?php echo Yii::app()->request->baseUrl."/images/inicio.png"; ?>" >   
  </div>
  <div class="span8">
  <h1 style="line-height: 30px;">SIPOL</h1>
  Envío de Eventos
  </div>

<div style="margin-bottom: 10px;">
    <legend class="legend"></legend>
    <p class="comentario-fit">Los campos con <span class="required">*</span> son obligatorios.</p>
  </div>



	<div class="control-group">
    <label class="control-label" for="numerodpi">Numero DPI</label>
    <div class="controls">
      <input type="text" id="numerodpi"  maxlength="13" class="input-block-level" required placeholder="Numero DPI">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Correo</label>
    <div class="controls">
      <input type="email" id="inputEmail"  class="input-block-level" required placeholder="Correo Electronico">
    </div>
  </div>
  <div class="control-group" align="center">
    <button class="btn btn-large btn-primary" type="submit">Solicitar</button>
  </div>
   <div id="resultadocorreo"></div>

</form>
<script type="text/javascript">
$(document).ready(function(){

	 

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
	$('#numerodpi').validCampoFranz('0123456789');



	$('#solicitud').submit(function(){
		//e.preventDefault();
		var correo = $('#inputEmail').val();
		var numerodpi = $('#numerodpi').val();		
		 $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("correo/correo"); ?>',
        data:{
        	correo:correo,
        	numerodpi:numerodpi,
              },
        beforeSend: function(responder)
        {
        	$('#resultadocorreo').html('<img src="images/loading.gif" alt="Cargando" style="height: auto;max-width: 10%;">');
          
        },
        success: function(responder)
        {
        	$('#resultadocorreo').html(responder);
        	$('#inputEmail').val('');
		  	$('#numerodpi').val('');
        }
        
      });
		 return false;

	});
});  
</script>


 <?php 
/*
  $id_evento="2";
  $envio = new EnvioCorreo;
  echo $envio->EnviarIdEvento($id_evento);	*/
?>

