<?php #index de la persona Juridica ?>

<input type="text" id="IdsPersonas" class="span4">

<?php 
/*	
	$ids = "11,12";

	$funciones = new Funcionesp;
	$r = $funciones->ListPersonaJuridica($ids);
	//var_dump($r);
	$a = array();

	foreach ($r as $key => $value) {
		$Primer_Nombre = "";
		$Segundo_Nombre = "";
		$Primer_Apellido = "";
		$Segundo_Apellido = "";
		$DPI = "";
		$id_persona_detalle = $value['id_persona_detalle'];
		$cerrar = "<button id='eliminar_hecho' type='button' 
					class='close eliminar_hecho' data-dismiss='alert' id_persona_detalle='".$id_persona_detalle."'><i class='icon-trash'></i></button>";

		$persona = json_decode($value['datos']);
		$persona = (array) $persona;
		$cJuridica = $value['id_calidad_juridica'];
		$cJuridica = $funciones->getPersonaJuridica($cJuridica);

		if(!empty($persona['Primer_Nombre'])) $Primer_Nombre = $persona['Primer_Nombre'];
		if(!empty($persona['Segundo_Nombre'])) $Segundo_Nombre = $persona['Segundo_Nombre'];
		if(!empty($persona['Primer_Apellido'])) $Primer_Apellido = $persona['Primer_Apellido'];
		if(!empty($persona['Segundo_Apellido'])) $Segundo_Apellido = $persona['Segundo_Apellido'];
		if(!empty($persona['DPI'])) $DPI = $persona['DPI'];

		$nombreCompleto = "Nombre completo: <b>".$Primer_Nombre." ".$Segundo_Nombre." ".$Primer_Apellido." ".$Segundo_Apellido."</b> - DPI: ".$DPI;

		echo "<div class='well well-small'>";
		echo $cerrar;
		echo "<legend class='legend'><h5 style='line-height:10px;'>".$cJuridica."</h5></legend>";
		echo $nombreCompleto;
		echo "</div>";

	}*/


	//$this->renderPartial('persona');

?>

<div class="row-fluid">
	<div class="well well-small span3" align="center">
		<button type="button" class="addPersonaJuridica btn btn-success" personaJ="5" pcontact="0" pcaract="1">Add Testigo</button>
	</div>
	<div class="well well-small span3" align="center">
		<button type="button" class="addPersonaJuridica btn btn-success" personaJ="2" pcontact="1" pcaract="0">Add Propietario del Vehiculo</button>
	</div>
	<div class="well well-small span3" align="center">
		<button type="button" class="addPersonaJuridica btn btn-success" personaJ="3" pcontact="1" pcaract="0">Add Conductor del Vehículo</button>
	</div>
	<div class="well well-small span3" align="center">
		<button type="button" class="addPersonaJuridica btn btn-success" personaJ="4" pcontact="0" pcaract="0">Add Agraviado</button>
	</div>
</div>

<div class="well" id="resultPersonaJ">Resultaod de persona Juridica</div>

<script type="text/javascript">

	$('.addPersonaJuridica').click(function(){
		var personaJ = $(this).attr('personaJ');
		var pcontact = $(this).attr('pcontact');
		var pcaract = $(this).attr('pcaract');
		alert('Estás en la clase de addPersonaJuridica '+personaJ);

		$.ajax({
			type:'POST',
			url:'<?php echo Yii::app()->createUrl("Pjuridica/AddPerson"); ?>',
			data:
			{
				personaJuridica: personaJ,
				pintaCaracteristicas: pcontact,
				pintaContacto: pcaract,
			},
			beforeSend:function()
			{
				$('#resultPersonaJ').html('');
				$('#resultPersonaJ').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			success:function(resultado)
			{
				$('#resultPersonaJ').html('');
				$('#resultPersonaJ').html(resultado);
			}
		});

	});

</script>