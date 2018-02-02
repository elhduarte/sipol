<?php 
	$WSConsulta = new WSConsulta;

	$nip = '35205';
	$poli = $WSConsulta->ConsultaPersonalPNC($nip);
	#echo "el resultado es: ";
	//var_dump(json_decode($poli));
	


?>
<legend>Seleccione los Agentes Relacionados</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="well well-small">
				<legend>Agregar Agente
					<div class="pull-right">
						<img src="images/info_icon.png" data-placement="left" id="ayuda_agente">
					</div>
				</legend>
				<form class="form-inline" id="frmBuscaAgente" align="center">
					<label class="campotit" for="AgenteNip" style="margin-right:1%;">NIP del Agente</label>
					<input type="text" id="AgenteNip" required class="span4 validaCampoNumerico">
					<button type="submit" class="btn btn-info">Buscar Agente</button>
				</form>
			</div>
		</div>
		<div class="span6">
			<div class="well well-small">
				<legend>Agregar Patrulla
					<div class="pull-right">
						<img src="images/info_icon.png" data-placement="left" id="ayuda_patrulla">
					</div>
				</legend>
				<form class="form-inline" id="frmBuscaPatrulla" align="center">
					<label class="campotit" for="patrullaNombre" style="margin-right:1%;">Nombre de la Patrulla</label>
					<input type="text" id="patrullaNombre" required class="span4">
					<button type="submit" class="btn btn-info">Buscar Patrulla</button>
				</form>
				<!--form id="addPatrulla">
					<div class="form-inline" align="center">
						<label class="campotit" style="padding-right:1%;" for="NumeroPatrulla">No. Patrulla</label>
						<input type="text" class="input-small" id="NumeroPatrulla" required>
						<label class="campotit" style="padding-right:1%; padding-left:2%;" for="EntidadPatrulla">Entidad Asignada</label>
						<input type="text" class="input-medium" id="EntidadPatrulla" required>
						<button type="submit" class="btn btn-primary" style="margin-left:2%;">Añadir Patrulla</button>
					</div>
				</form-->
			</div>
		</div>
	</div>
	<div id="resultadoAgente" style="display:none;" class="cuerpo-small"></div>

<div id="AgentesPatrullasSave" hidden>
	<legend>Agentes y Patrullas Relacionados</legend>
	<div id="MostrarAgentesP"></div>
</div>

<script type="text/javascript">

$(document).ready(function(){

	$('#patrullaNombre').tooltip({placement:'bottom',title:'Ingrese el nombre de la patrulla sin espacios ni guiones'});
	$('#AgenteNip').tooltip({placement:'bottom',title:'Ingrese unicamente el Número de Identificación Policial, sin espacios ni letras'});

	$('#ayuda_agente').tooltip({html:true,title:'<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> AYUDA</legend>'+
		'<p style="line-height: 175%; text-align: justify;">Ingrese el NIP del agente para realizar la búsqueda de éste y relacionarlo con ésta Consignación.</p>'});
	$('#ayuda_patrulla').tooltip({html:true,title:'<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> AYUDA</legend>'+
		'<p style="line-height: 175%; text-align: justify;">Ingrese los datos de la patrulla para relacionarla con ésta Consignación.</p>'});

	$('#frmBuscaAgente').submit(function(e){
		e.preventDefault();
		var nip = $('#AgenteNip').val();

		$.ajax({
			type:'POST',
			url:"<?php echo Yii::app()->createUrl('Consignacion/Procesa_agente'); ?>",
			data:{nip:nip},
			beforeSend:function()
			{
				$('#resultadoAgente').html('');
				$('#resultadoAgente').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				$('#resultadoAgente').show(500);
			},
			error:function()
			{
				$.ajax({
					type:'POST',
					url:"<?php echo Yii::app()->createUrl('Consignacion/Procesa_agente'); ?>",
					error:function()
					{
						$('#resultadoAgente').html('');
						$('#resultadoAgente').html('hubo un error');
					},
					success:function(resultado)
					{
						$('#resultadoAgente').html('');
						$('#resultadoAgente').html(resultado);
					}
				});//Fin del ajax del error
			},
			success:function(resultado)
			{
				$('#resultadoAgente').html('');
				$('#resultadoAgente').html(resultado);
			}
		});

	});//fin del submit searh Agente

	$('#frmBuscaPatrulla').submit(function(e){
		e.preventDefault();
		var patrullaNombre = $('#patrullaNombre').val();
		//alert(patrullaNombre);

		$.ajax({
			type:'POST',
			url:"<?php echo Yii::app()->createUrl('Consignacion/Procesa_patrulla'); ?>",
			data: {patrullaNombre: patrullaNombre},
			beforeSend:function()
			{
				$('#resultadoAgente').html('');
				$('#resultadoAgente').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				$('#resultadoAgente').show(500);
			},
			error:function()
			{
				$.ajax({
					type:'POST',
					url:"<?php echo Yii::app()->createUrl('Consignacion/Procesa_patrulla'); ?>",
					error:function()
					{
						$('#resultadoAgente').html('');
						$('#resultadoAgente').html('hubo un error');
					},
					success:function(resultado)
					{
						$('#resultadoAgente').html('');
						$('#resultadoAgente').html(resultado);
					}
				});//Fin del ajax del error
			},
			success:function(resultado)
			{
				$('#resultadoAgente').html('');
				$('#resultadoAgente').html(resultado);
			}
		});//Fin ajax

	}); // fin del submit search Patrulla

	$.fn.MostrarAgentes = function(valor)
	{
		//alert(valor);
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("Consignacion/ShowAgentes"); ?>',
			data: {idEvento:valor,},
			success: function(divs)
			{
				$('#AgentesPatrullasSave').show(500);
				$('#MostrarAgentesP').html('');
				$('#MostrarAgentesP').html(divs);

				$(".DeleteAgente").click(function(){
					var id_eliminar = $(this).attr('id_agente');
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>¿Está seguro que desea eliminar éste Agente?</h4></div><div class=\"modal-footer\">'+
						'<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button>'+
						'<button id=\"CommitDeleteAgente\" class=\"btn btn-primary\" id_eliminar=\"'+id_eliminar+'\">Confirmar</button>'
						);
					$('#procesoModal').modal('show');

					$('#CommitDeleteAgente').click(function(){
						var id_eliminar = $(this).attr('id_eliminar');
						$.ajax({
						type:'POST',
						url:'<?php echo Yii::app()->createUrl("Consignacion/DeleteAgente"); ?>',
						data:{id_eliminar: id_eliminar,},
						beforeSend: function()
						{
							$('#result_procesoModal').html('');
							$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
						},
						success:function()
						{
							$('#procesoModal').modal('hide');
							$(this).MostrarAgentes(valor);
							$('#procesoModal').actualizaResumen();
							//$('#result_procesoModal').html('');
							//$('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Hecho se eliminó correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
						},
						});
					});
				});//click de función de eliminar el Agente

				$(".DeletePatrulla").click(function(){
					var id_eliminar = $(this).attr('id_patrulla');
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>¿Está seguro que desea eliminar ésta Patrulla?</h4></div><div class=\"modal-footer\">'+
						'<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button>'+
						'<button id=\"CommitDeletePatrulla\" class=\"btn btn-primary\" id_eliminar=\"'+id_eliminar+'\">Confirmar</button>'
						);
					$('#procesoModal').modal('show');

					$('#CommitDeletePatrulla').click(function(){
						var id_eliminar = $(this).attr('id_eliminar');
						$.ajax({
						type:'POST',
						url:'<?php echo Yii::app()->createUrl("Consignacion/DeletePatrulla"); ?>',
						data:{id_eliminar: id_eliminar,},
						beforeSend: function()
						{
							$('#result_procesoModal').html('');
							$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
						},
						success:function(r)
						{
							$('#procesoModal').modal('hide');
							$(this).MostrarAgentes(valor);
							$('#procesoModal').actualizaResumen();
							//$('#result_procesoModal').html('');
							//$('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Hecho se eliminó correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
						},
						});
					});
				});//click de función de eliminar el Agente



				$(".DeleteAgente").tooltip({title:"Eliminar éste Agente"});
				$(".DeletePatrulla").tooltip({title:"Eliminar ésta Patrulla"});
			},//fin del success
		});//fin del ajax
	}//fin de la función MostrarHechos



}); //Fin del Document ready

</script>


