<?php

$WSConsulta = new WSConsulta;
$modelo_tilde = new SeparadorSilabas;


	if($_POST['numero'] == 'empty' || !isset($_POST['numero']))
	{
		$numero = "empty";
		if(empty($_POST['primer_nombre']) || $_POST['primer_nombre']=="empty" || !isset($_POST['primer_nombre']))
		{
			$primer_nombre = "";
		}
		else
		{
			$primer_nombre = trim($_POST['primer_nombre']);
			$primer_nombre = $modelo_tilde->dividePalabra($primer_nombre);
		}

		if(empty($_POST['segundo_nombre']) || $_POST['segundo_nombre']=="empty" || !isset($_POST['segundo_nombre']))
		{
			$segundo_nombre = "";
		}
		else
		{
			$segundo_nombre = trim($_POST['segundo_nombre']);
			$segundo_nombre = $modelo_tilde->dividePalabra($segundo_nombre);
		}

		if(empty($_POST['primer_apellido']) || $_POST['primer_apellido']=="empty" || !isset($_POST['primer_apellido']))
		{
			$primer_apellido = "";
		}
		else
		{
			$primer_apellido = trim($_POST['primer_apellido']);
			$primer_apellido = $modelo_tilde->dividePalabra($primer_apellido);
		}

		if(empty($_POST['segundo_apellido']) || $_POST['segundo_apellido']=="empty" || !isset($_POST['segundo_apellido']))
		{
			$segundo_apellido = "";
		}
		else
		{
			$segundo_apellido = trim($_POST['segundo_apellido']);
			$segundo_apellido = $modelo_tilde->dividePalabra($segundo_apellido);
		}
	}
	else
	{
		$primer_nombre = "";
		$segundo_nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";
		$numero = $_POST['numero'];
	}

$resultado = $WSConsulta->ConsultaLicencia($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$numero);
$resultado = json_decode($resultado);
#print_r($resultado);

?>
<div class="row-fluid">
<select class="span12" name="Pj_lista_llave_renap" size="7" id="Pj_lista_llave_renap" data-toggle="tooltip" data-original-title="Seleccione un elemento de la lista">

<?php
	$contador = 0;
	
	foreach ($resultado->registros as $value) 
	{
		echo "<option value='".$value->NUMERO_LICENCIA."~".$value->TIPO_LICENCIA."'>".$value->NOMBRE." - TIPO: ".$value->TIPO_LICENCIA."</option>";	
		$contador = $contador+1;
	}
?>
</select>

</div>
<div class="row-fluid">
	<div class="pull-right" style="padding-bottom:1%; padding-right:2%">
		Total de coincidencias: <strong><?php echo $contador; ?></strong>
	</div>
</div>


<div id="Pj_explotaRenap" style="display:none;">
	este es el div explota Renap
</div>


<script type="text/javascript">

$(document).ready(function(){

	$('#Pj_lista_llave_renap').tooltip('show');

	ops = $("select#Pj_lista_llave_renap option");
	ops.sort(function (a,b) {
	  return ( $(a).html().toUpperCase() < $(b).html().toUpperCase() ) ? -1 : ( $(a).html().toUpperCase() > $(b).html().toUpperCase() ) ? 1 : 0;
	});
	html="";
	for(i=0;i<ops.length;i++)
	{
	  html += "<option value='" + $(ops[i]).val() + "'>" + $(ops[i]).html() + "</option>";	
	}
	$("select#Pj_lista_llave_renap").html(html);
	$("select option:even").addClass("zebra");

	$('#Pj_lista_llave_renap').change(function(){
		selected = $('#Pj_lista_llave_renap').val();

		//$('#llave_renap_clean').val(selected);
		$.ajax({
			type:'POST',
			url: '<?php echo Yii::app()->createUrl("Pjuridica/FormResultadoLicencia"); ?>',
			data:
			{
				numero:selected,
				tipoRender:'numero',

			},
			beforeSend: function(response)
			{
				$('#Pj_explotaRenap').show(50);
				$('#Pj_explotaRenap').html('');
				$('#Pj_explotaRenap').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				
			},
			error: function()
			{
				$('#Pj_explotaRenap').html('');
				$('#Pj_explotaRenap').hide(500);
				$('#MsgErrorLicencia').html('');
				$('#MsgErrorLicencia').html('Ocurrió un error, por favor intentelo de nuevo...');
				$('#MsgErrorLicencia').show(500);
			},
			success: function(response)
			{
				$('#Pj_explotaRenap').html('');
				$('#Pj_explotaRenap').html(response);
				$("#Pj_lista_llave_renap").get(0).scrollIntoView();
			},
		});
		
	});
}); //Fin del document ready
</script>