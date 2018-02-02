
<legend>Consignaciones</legend>


<div class="alert alert-info">
	<label class="checkbox">
		<input type="checkbox" id="SinConsignaciones" checked> Ésta incidencia no contiene consignaciones
	</label>
</div>

<div id="SinConsignacionesDiv">
	<div align="right">
		<legend></legend>
		<button type="button" class="btn btn-primary" id="NextSinConsigna">Continuar</button>
	</div>
</div>

<div id="ConsignacionesDiv" style="display:none;">
	<?php $this->renderPartial('_hechos'); ?>
</div>

<script type="text/javascript">

$(document).ready(function(){

	$('#NextSinConsigna').click(function(){
		$('#tab7').hide(500);
        $('#tab8').show(500);
        $('#aTab8').attr('href','#tab8');
		$('#ili_resumen').attr('class','enabled');
		$('#i_resumen').removeClass('BotonClose');     
        $('#nav_incidencia li:eq(7) a').tab('show');
	});//Fin click NextSinConsigna


	$("#SinConsignaciones").live("click", function(){
	var id = parseInt($(this).val(), 10);
	if($(this).is(":checked")) 
	{
		$('#SinConsignacionesDiv').show(500);
		$('#ConsignacionesDiv').hide(500);
	}
	else
	{
		$('#SinConsignacionesDiv').hide(500);
		$('#ConsignacionesDiv').show(500);
	}
	});

});// Fin del Document ready
	

</script>