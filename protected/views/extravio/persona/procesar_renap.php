<?php

$WSConsulta = new WSConsulta;
$modelo_tilde = new SeparadorSilabas;

function calcular_edad($fecha)
{
$d = explode("-", $fecha, 3);
$a = $d[2]."-".$d[1]."-".$d[0];
$dias = explode("-", $a, 3);
$dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
$edad = (int)((time()-$dias)/31556926 );
return $edad;
}


	if(empty($_POST['primer_nombre']))
	{
		$primer_nombre = "";
	}
	else
	{
		$primer_nombre = trim($_POST['primer_nombre']);

		$primer_nombre = $modelo_tilde->dividePalabra($primer_nombre);
	}

	if(empty($_POST['segundo_nombre']))
	{
		$segundo_nombre = "";
	}
	else
	{
		$segundo_nombre = trim($_POST['segundo_nombre']);
		$segundo_nombre = $modelo_tilde->dividePalabra($segundo_nombre);
	}

	if(empty($_POST['primer_apellido']))
	{
		$primer_apellido = "";
	}
	else
	{
		$primer_apellido = trim($_POST['primer_apellido']);
		$primer_apellido = $modelo_tilde->dividePalabra($primer_apellido);
	}

	if(empty($_POST['segundo_apellido']))
	{
		$segundo_apellido = "";
	}
	else
	{
		$segundo_apellido = trim($_POST['segundo_apellido']);
		$segundo_apellido = $modelo_tilde->dividePalabra($segundo_apellido);
	}

$resultado = $WSConsulta->ConsultaNombre($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido);
$resultado = json_decode($resultado);

//var_dump($resultado);
?>
<div class="row-fluid">
<select class="span12" name="lista_llave_renap" size="7" id="lista_llave_renap" data-toggle="tooltip" data-original-title="Seleccione un elemento de la lista">
<?php
$contador = 0;
$e = " ";
$edad = "" ;

foreach ($resultado->registros as $value) 
{
	$edad = date($value->FECHA_EVENTO);
	$edad = substr($edad, 0, 10);
	#$edad = calcular_edad($edad);
	#$edad = $edad." años";
	echo "<option value=$value->LLAVE_CERTIFICADO >$value->PRIMER_NOMBRE$e$value->SEGUNDO_NOMBRE$e$value->PRIMER_APELLIDO$e$value->SEGUNDO_APELLIDO$e-$e$edad</option>";	
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


<div id="explota_renap" style="display:none;">
	este es el div explota Renap
</div>


<script type="text/javascript">

$(document).ready(function(){
	$('#lista_llave_renap').tooltip('show');
	var llamada;
	var dropCall = '<span style="padding-left: 3%; padding-right: 3%;">|</span>'+
					'<button class="btn btn-mini cancelCall" type="button">Cancelar Petición</button>';


	ops = $("select#lista_llave_renap option");
	ops.sort(function (a,b) {
	  return ( $(a).html().toUpperCase() < $(b).html().toUpperCase() ) ? -1 : ( $(a).html().toUpperCase() > $(b).html().toUpperCase() ) ? 1 : 0;
	});
	html="";
	for(i=0;i<ops.length;i++)
	{
	  html += "<option value='" + $(ops[i]).val() + "'>" + $(ops[i]).html() + "</option>";	
	}
	$("select#lista_llave_renap").html(html);
	$("select option:even").addClass("zebra");

	$('#lista_llave_renap').change(function(){
		selected = $('#lista_llave_renap').val();
		//$('#llave_renap_clean').val(selected);
		llamada = $.ajax({
			type:'POST',
			url: '<?php echo Yii::app()->createUrl("Extravio/Explota_renap"); ?>',
			data:
			{
				llave:selected,
				tipoRender:'llave',
			},
			beforeSend: function(response)
			{
				
				$('#explota_renap').show(50);
				$('#explota_renap').html('');
				$('#explota_renap').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
				$('.cancelCall').click(function(){ llamada.abort(); });
				$('#lista_llave_renap').val('');
			},

			error: function(xhr, status, error)
			{
				if(status === 'abort'){
					$('#explota_renap').hide(500);
					$('#explota_renap').html('');
				}
				else
				{
					$.ajax({
						type:'POST',
						url: "<?php echo Yii::app()->createUrl('Denuncia/Explota_renap'); ?>",
						success:function(response)
						{
							$('#explota_renap').html('');
							$('#explota_renap').html(response);
						},
					});
				}
			},
			success: function(response)
			{
				$('#explota_renap').html('');
				$('#explota_renap').html(response);
				$("#lista_llave_renap").get(0).scrollIntoView();
			},
		});
		
	});
}); //Fin del document ready

</script>