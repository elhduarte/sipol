<?php 
	
	$WSConsulta = new WSConsulta;

	$primerNombre = "";
	$segundoNombre = "";
	$primerApellido = "";
	$segundoApellido = "";
	$codEmpleado = "";
	$puestoFuncional = "";
	$puestoNominal = "";
	$estado = "";
	$nacimiento = "";
	$dpi = "";
	$nit = "";
	$nip = "";
	$foto = "images/noimagen.png";
	$style = " style='max-width: 60%;'";
	$readonly = "";
	$poli = "";
	$alerta = '<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Aviso!</strong> No se encontraron datos con éste NIP
				</div>';
	$titulo = "Datos del Agente";

	if(isset($_POST['nip']))
	{
		$nip = $_POST['nip'];
		$poli = $WSConsulta->ConsultaPersonalPNC($nip);
	}
	

	if(!empty($poli))
	{
		$poli = json_decode($poli);
		$poli = (array) $poli;
		$primerNombre = $poli['PRIMER_NOMBRE'];
		$segundoNombre = $poli['SEGUNDO_NOMBRE'];
		$primerApellido = $poli['PRIMER_APELLIDO'];
		$segundoApellido = $poli['SEGUNDO_APELLIDO'];
		$codEmpleado = $poli['COD_EMPLEADO'];
		$puestoFuncional = $poli['PUESTO_FUNCIONAL'];
		$puestoNominal = $poli['PUESTO_NOMINAL'];
		$estado = $poli['SIT_ADMIN'];
		$nacimiento = $poli['FECHA_NACIMIENTO'];
		$dpi = $poli['CUI'];
		$nit = $poli['NIT'];
		$nip = $poli['NIP'];
		$foto = $poli['BYTES'];
		$alerta = "";
		$titulo = "Datos del Agente NIP: ".$nip;
		$style = "";
		//$readonly = " readonly";
	}

	
function formatofechaagente($date)
{
	$dia = substr($date, -2); 
	$mes = substr($date, -4, 2); 
	$ano = substr($date, 0, 4); 
	return $dia.'-'.$mes.'-'.$ano;

}
?>
<legend><?php echo $titulo; ?></legend>
<form id="addAgente">
	<?php echo $alerta; ?>
	<div id="DatosAgente">
		<div class="row-fluid">
			<div class="span10">
				<div class="row-fluid">
					<div class="span3">
						<label class="campotit" for="AG_primerNombre">Primer Nombre</label>
						<input type="text" class="span12" id="AG_primerNombre" <?php echo $readonly;?> value="<?php echo $primerNombre; ?>" nombre="Primer_Nombre">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_segundoNombre">Segundo Nombre</label>
						<input type="text" class="span12" id="AG_segundoNombre" <?php echo $readonly;?> value="<?php echo $segundoNombre; ?>" nombre="Segundo_Nombre">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_pirmerApellido">Primer Apellido</label>
						<input type="text" class="span12" id="AG_pirmerApellido" <?php echo $readonly;?> value="<?php echo $primerApellido; ?>" nombre="Primer_Apellido">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_segundoApellido">Segundo Apellido</label>
						<input type="text" class="span12" id="AG_segundoApellido" <?php echo $readonly;?> value="<?php echo $segundoApellido; ?>" nombre="Segundo_Apellido">	
					</div>
				</div>

				<div class="row-fluid">
					<div class="span3">
						<label class="campotit" for="AG_codEmpleado">Código de Empleado</label>
						<input type="text" class="span12" id="AG_codEmpleado" <?php echo $readonly;?> value="<?php echo $codEmpleado; ?>" nombre="Código_de_Empleado">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_puestoFuncional">Puesto Funcional</label>
						<input type="text" class="span12" id="AG_puestoFuncional" <?php echo $readonly;?> value="<?php echo $puestoFuncional; ?>" nombre="Puesto_Funcional">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_puestoNominal">Puesto Nominal</label>
						<input type="text" class="span12" id="AG_puestoNominal" <?php echo $readonly;?> value="<?php echo $puestoNominal; ?>" nombre="Puesto_Nominal">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_Estado">Estado</label>
						<input type="text" class="span12" id="AG_Estado" <?php echo $readonly;?> value="<?php echo $estado; ?>" nombre="Estado">	
					</div>
				</div>

				<div class="row-fluid">
					<div class="span3">
						<label class="campotit" for="AG_nacimiento">Fecha de Nacimiento</label>
						<input type="text" class="span12" id="AG_nacimiento" <?php echo $readonly;?> value="<?php echo formatofechaagente($nacimiento); ?>" nombre="Nacimiento">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_dpi">DPI</label>
						<input type="text" class="span12" id="AG_dpi" <?php echo $readonly;?> value="<?php echo $dpi; ?>" nombre="Dpi">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_nit">NIT</label>
						<input type="text" class="span12" id="AG_nit" <?php echo $readonly;?> value="<?php echo $nit; ?>" nombre="Nit">	
					</div>
					<div class="span3">
						<label class="campotit" for="AG_nip">NIP</label>
						<input type="text" class="span12" id="AG_nip" <?php echo $readonly;?> value="<?php echo $nip; ?>" nombre="Nip">	
					</div>
				</div>
			</div>
			<div class="span2" align="center">
				<br>
				<img class="imagen_renap" src="data:image/jpg;base64,<?php echo $foto; ?> <?php echo $style; ?>">
			</div>
		</div>
	</div>
	<legend style="padding-top:20px;"></legend>
	<div align="right">
		<button type="submit" class="btn btn-primary">Añadir Agente</button>
	</div>
</form>

<script type="text/javascript">
	
	$(document).ready(function(){

		$('#addAgente').submit(function(e){
			e.preventDefault();
			var JoinAgente = new Array();
			var count = 0;
			//var idIncidencia = '66'; //Fines de prueba
			var idIncidencia = $('#identificador_incidencia').val();

			$('#DatosAgente').find(':input').each(function(){
				var element = this;
				var value = $(element).val();
				var id = $(element).attr('nombre');
				//alert(id+ " ~ "+value);
				JoinAgente[count] = id+'~'+value;
				count = count+1;
			});//fin del each

			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl("Incidencia/AddAgente");?>',
				data:
				{
					DatosAgente:JoinAgente.join('|'),
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
					
					$(this).MostrarAgentes(idIncidencia);
		
					$('#AgeX').val('1');
					$('#AgenteNip').val('');
					$('#resultadoAgente').html('');
					$('#AG_segundoNombre').val('asdf');
					$('#resultadoAgente').hide(500);
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
							'<h4>El Agente se ha registrado Correctamente</h4></div><div class=\"modal-footer\">'+
							'<button id=\"AgenteContinuar\" class=\"btn\">Continuar</button>'+
							'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Ingresar Otro Agente o Patrulla</button></div>'
							);

					$('#aTab3').attr('href','#tab3');
					$('#ili_ubicacion').attr('class','enabled');
					$('#i_ubicacion').removeClass('BotonClose'); 

						$('#AgenteContinuar').click(function(){
							$('#tab2').hide(500);
							$('#tab3').show(500);
							$('#nav_incidencia li:eq(2) a').tab('show');
							$('#procesoModal').modal('hide'); 
						});//Fin de función AgenteContinuar
					$(this).actualizaResumen();
				}
			});//Fin Ajax



		});//Fin del submit de addAgente

	});//Fin del document ready

</script>