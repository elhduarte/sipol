<div  class ="cuerpo">
<legend>Listado de Novedades</legend>

<div class="well">
	<form  id='formconsulta' class="form-inline">
		<strong>Ingrese Numero De Boleta   </strong><input class="input-medium" type="text" id="parametro">
		<button type="submit" class="btn btn-primary">Consultar</button>
		<button type="button" id = "limpia" class="btn btn-primary">limpia</button>
	</form>
</div>

<div id="grid"> 
  <?php
 $this->renderPartial("viewGrid"); ?>
</div>
</div>
<script type="text/javascript">


	$(document).ready(function(){

$('#limpia').click(function(){
var parametro = 'vacio';

	$.ajax({
		   type: 'POST',
		   url: '<?php echo Yii::app()->createUrl("cTBoleta/actualizarGrid"); ?>',
		   data:
		   {        
		           param:parametro
		   },
		   beforeSend: function(response)
		   {
		           //alert('beforeSend');        
		   },
		   success: function(response)
		   {
		   	        $('#grid').html('hola');
		           $('#grid').html(response);
		           $('#parametro').val('');

		   },
		});
		return false;

});

		$('#formconsulta').submit(function(){
			var parametro = $('#parametro').val();

		$.ajax({
		   type: 'POST',
		   url: '<?php echo Yii::app()->createUrl("cTBoleta/actualizarGrid"); ?>',
		   data:
		   {        
		           param:parametro
		   },
		   beforeSend: function(response)
		   {
		           //alert('beforeSend');        
		   },
		   success: function(response)
		   {
		   	        $('#grid').html('hola');
		           $('#grid').html(response);

		   },
		});
			return false;
		});

	});
</script>