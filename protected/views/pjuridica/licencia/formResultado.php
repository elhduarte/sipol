<?php
$WSConsulta = new WSConsulta;

$expotado = array();
$recibeNumero = $_POST['numero'];
$explotado = explode("~", $recibeNumero);

$numero = $explotado[0];
$licenciaTipo = $explotado[1];
$primer_nombre = "";
$segundo_nombre = "";
$primer_apellido = "";
$segundo_apellido = "";

$resultado = $WSConsulta->ConsultaLicencia($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$numero);
$resultado = json_decode($resultado);
$v = array();

foreach ($resultado->registros as $key => $value) {

	if($value->TIPO_LICENCIA == $licenciaTipo)
	{
		$v = $value;
	}
}

$v = (array) $v;

?>
<div class="well">
	<div class="row-fluid">
		<div class="span6">
			<label for="Lic_nombre_completo" class="campotit">Nombre Completo</label>
			<input type="text" class="span12" id="Lic_nombre_completo" value="<?php echo $v["NOMBRE"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_tipo_licencia" class="campotit">Tipo Licencia</label>
			<input type="text" class="span12" id="Lic_tipo_licencia" value="<?php echo $v["TIPO_LICENCIA"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_numero_licencia" class="campotit">Número de Licencia</label>
			<input type="text" class="span12" id="Lic_numero_licencia" value="<?php echo $v["NUMERO_LICENCIA"];?>" readonly>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span3">
			<label for="Lic_genero" class="campotit">Género</label>
			<input type="text" class="span12" id="Lic_genero" value="<?php echo $v["SEXO"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_nacimiento" class="campotit">Fecha de Nacimiento</label>
			<input type="text" class="span12" id="Lic_nacimiento" value="<?php echo $v["FECHA_NACIMIENTO"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_identificacion" class="campotit">Identificacion</label>
			<input type="text" class="span12" id="Lic_identificacion" value="<?php echo $v["NUMERO_DOCUMENTO"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_vencimiento" class="campotit">Fecha de Vencimiento</label>
			<input type="text" class="span12" id="Lic_vencimiento" value="<?php echo $v["FECHA_VENCIMIENTO"];?>" readonly>
		</div>
	</div>
	<legend style="margin-top:1%;"></legend>
	<div align="right">
		<button class="btn btn-info" type="button" id="UtilizarDatosLicencia">Utilizar Información</button>
	</div>
</div><!-- fin del well general -->


<script type="text/javascript">

$(document).ready(function(){

	$('#UtilizarDatosLicencia').click(function(){
		var nombreCompleto = $('#Lic_nombre_completo').val();
		var licenciaTipo = $('#Lic_tipo_licencia').val();
		var licenciaNumero = $('#Lic_numero_licencia').val();
		var genero = $('#Lic_genero').val();
		var nacimiento = $('#Lic_nacimiento').val();
		var identificacion = $('#Lic_identificacion').val();
		var vencimiento = $('#Lic_vencimiento').val();

		$('#nombre_completo').val(nombreCompleto);
		$('#tipo_licencia').val(licenciaTipo);
		$('#numero_licencia').val(licenciaNumero);
		$('#genero').val(genero);
		$('#nacimiento').val(nacimiento);
		$('#identificacion').val(identificacion);
		$('#vencimiento').val(vencimiento);

		$('#Pj_resultado').hide(500);
		$('#Pj_resultado').html('');
		$('#MensajeAutocomplete').show(500);
		$('#MensajeAutocomplete').html('Los datos del formulario se han completado con la información de: <b>'+nombreCompleto+
			'</b>, obtenidos de PNC. '+
					'Verifique que la información sea correcta y continue.');

	});

}); //Fin del document.ready

</script>