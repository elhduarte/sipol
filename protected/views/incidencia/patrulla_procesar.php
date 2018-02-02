<?php 
	
	$WSConsulta = new WSConsulta;

	$identificador = "";
	$nombre = "";
	$tipo = "";
	$color = "";
	$marca = "";
	$modelo = "";
	$anio = "";
	$imei = "";
	$estado = "";
	$readonly = "";
	$patrulla = "";
	$alerta = '<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Aviso!</strong> No se encontraron datos con éste Nombre de Patrulla
				</div>';
	$titulo = "Datos de la Patrulla";

	if(isset($_POST['patrullaNombre']))
	{
		$patrullaNombre = $_POST['patrullaNombre'];
		$patrulla = $WSConsulta->ConsultaPatrulla($patrullaNombre);
	}
	
	if(!empty($patrulla))
	{
		$patrulla = json_decode($patrulla);
		$patrulla = (array) $patrulla;
		$identificador = $patrulla['ID'];
		$nombre = $patrulla['NOMBRE'];
		$tipo = $patrulla['TIPO'];
		$color = $patrulla['COLOR'];
		$marca = $patrulla['MARCA'];
		$anio = $patrulla['ANIO'];
		$modelo = $patrulla['MODELO'];
		$imei = $patrulla['IMEI'];
		$estado = $patrulla['ESTADO'];
		if($estado == "A") $estado = "ACTIVO";

		$alerta = "";
		$titulo = "Datos de la Patrulla: ".$nombre;
		$style = "";
		//$readonly = " readonly";
	}

?>

<legend><?php echo $titulo; ?></legend>
<form id="addPatrullaConsumo">
	<?php echo $alerta; ?>
	<div id="datosPatrulla">
		<div class="row-fluid">
			<div class="span3">
				<label class="campotit" for="">Nombre Patrulla</label>
				<input type="text" class="span12" id="PT_nombre_patrulla" nombre="Nombre_de_la_Patrulla" value="<?php echo $nombre; ?>" required>
			</div>
			<div class="span3">
				<label class="campotit" for="">Tipo</label>
				<input type="text" class="span12" id="PT_tipo" nombre="Tipo" value="<?php echo $tipo; ?>" required>
			</div>
			<div class="span3">
				<label class="campotit" for="">Color</label>
				<input type="text" class="span12" id="PT_color" nombre="Color" value="<?php echo $color; ?>" required>
			</div>
			<div class="span3">
				<label class="campotit" for="">Marca</label>
				<input type="text" class="span12" id="PT_marca" nombre="Marca" value="<?php echo $marca; ?>" required>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3">
				<label class="campotit" for="">Modelo</label>
				<input type="text" class="span12" id="PT_modelo" nombre="Modelo" value="<?php echo $anio; ?>">
			</div>
			<div class="span3">
				<label class="campotit" for="">Línea</label>
				<input type="text" class="span12" id="PT_linea" nombre="Linea" value="<?php echo $modelo; ?>">
			</div>
			<div class="span3">
				<label class="campotit" for="">IMEI</label>
				<input type="text" class="span12" id="PT_imei" nombre="Imei" value="<?php echo $imei; ?>">
			</div>
			<div class="span3">
				<label class="campotit" for="">Estado</label>
				<input type="text" class="span12" id="PT_estado" nombre="Estado" value="<?php echo $estado; ?>">
			</div>
		</div>
	</div>
	<legend style="padding-top:20px;"></legend>
	<div align="right">
		<button type="submit" class="btn btn-primary">Añadir Patrulla</button>
	</div>
</form>

<script type="text/javascript">
	
	$(document).ready(function(){

		$('#addPatrullaConsumo').submit(function(e){
			e.preventDefault();
			var joinPatrulla = new Array();
			var count = 0;
			var idIncidencia = $('#identificador_incidencia').val();

			$('#datosPatrulla').find(':input').each(function(){
				var elemento = $(this);
				var valor = $(elemento).val();
				var name = $(elemento).attr('nombre');

				joinPatrulla[count] = name+'~'+valor;
				count++;
			});//fin del each

			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl("Incidencia/AddPatrulla");?>',
				data:
				{
					datosPatrulla:joinPatrulla.join('|'),
					idEvento:idIncidencia
				},
				beforeSend:function()
				{
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
					$('#procesoModal').modal('show'); 
				},
				error:function()
				{
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\"><h4>Ha ocurrido un error, por favor intente realizar la acción de nuevo'+
						'</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
					$('#procesoModal').modal('show'); 
				},
				success:function(respuesta)
				{
					$('#resultadoAgente').html('');
					$('#resultadoAgente').hide(500);
					$(this).MostrarAgentes(idIncidencia);
					var hayAgente = $('#AgeX').val();
					$('#patrullaNombre').val('');

					if(hayAgente == 0)
					{
							$('#result_procesoModal').html('');
							$('#result_procesoModal').html('<div class=\"modal-body\"><h4>La Patrulla se ha registrado con éxito...'+
								'</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
					}
					else
					{
						$('#result_procesoModal').html('');
						$('#result_procesoModal').html('<div class=\"modal-body\">'+
								'<h4>La Patrulla se ha registrado Correctamente</h4></div><div class=\"modal-footer\">'+
								'<button id=\"PatrullaContinuar\" class=\"btn\">Continuar</button>'+
								'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Ingresar Otro Agente o Patrulla</button></div>'
								);

						$('#PatrullaContinuar').click(function(){
							$('#tab2').hide(500);
							$('#tab3').show(500);
							$('#nav_incidencia li:eq(2) a').tab('show');
							$('#procesoModal').modal('hide'); 
						});//Fin de función PatrullaContinuar

					}//Fin de la condición
					$(this).actualizaResumen();
				}//Fin del Success
			});

		});// Fin del submit addPatrullaConsumo

	}); //Fin del document ready

</script>