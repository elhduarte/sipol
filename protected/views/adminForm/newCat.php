<link href="lib/jqueryui/adminhechos/pagina.css" rel="stylesheet" type="text/css" media="all">

<?php
	$catEventos = new CatTipoEvento;
	$eventos = $catEventos->getEventos();
?>

<div class="cuerpo">
	<legend>Agregar un Catálogo</legend>
	<div class="form-inline well" hidden>
		<label for="idCampoSave">IdCampoSave</label>
		<input id="idCampoSave" type="text" disabled/>
		<label for="nombreModeloSave">Modelo</label>
		<input id="nombreModeloSave" type="text" disabled/>
		
	</div>
	<form id="addCatalogo">
		<div class="row-fluid">
			<div class="span10">
				<div class="row-fluid">
					<div class="span3">
						<label class="campotit" for="tipoEvento">Evento</label>
						<select id="tipoEvento" class="span12" required>
							<?php echo $eventos; ?>
						</select>
					</div>
					<div class="span3">
						<label class="campotit" for="tipoSeccion">Sección</label>
						<select id="tipoSeccion" class="span12" disabled required>
							<option value ="" disabled selected style='display:none;'>Seleccione una Sección</option>
						</select>
					</div>
					<div class="span3">
						<label class="campotit" for="hechoPadre" id="hechoPadreLabel">--</label>
						<select id="hechoPadre" class="span12" disabled required>
							<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						</select>
					</div>
					<div class="span3">
						<label class="campotit" for="nombreCatalogo">Nombre 
							<i class="icon-ban-circle" id="iconNameWarning" style="display:none;"></i>
						</label>
						<input id="nombreCatalogo" class="span12" type="text" placeholder="Nombre del Catálogo" required>
					</div>
				</div>
			</div>
			<div class="span2">
				<button class="btn btn-primary span12" type="submit" style="margin-top: 12%;" id="addCatalogoSubmit">Crear Catálogo</button>
			</div>
		</div>
	</form>

	<div class="alert alert-error" id="resultadoAlerta" hidden></div>

	<div id="constructorInputs" hidden>
		<legend style="margin-bottom:0px; margin-top:2%;"></legend>
		<div class="row-fluid">
			<div id="nuevoCampoForm" class="span6" style="padding-right:3%; border-right: 1px solid rgb(227, 227, 227);">
				<legend>Nuevo Campo</legend>
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label campotit" for="tipoCampo">Tipo de Campo</label>
						<div class="controls">
							<select id="tipoCampo" class="span12">
								<option value="" disabled selected style='display:none;'>Seleccione una Opción</option>
								<option value="textarea">Area de Texto</option>
								<option value="button">Botón para añadir Persona</option>
								<option value="input">Campo de texto</option>
								<option value="select">Lista Desplegable</option>
							</select>
						</div>
					</div>
					<div id="formType"></div>
				</div>
			</div>
			<div class="span6">
				<legend>Campos del Catálogo</legend>
				<div id="catalogosList" align="center">
					No se han agregado Campos a éste Formulario
				</div>
			</div>
		</div>
	</div> <!-- Fin del constructor de campos-->


</div><!-- Fin del Well principal -->

<div id="previewFather" class="cuerpo" hidden>
	<legend>Previsualización del Catálogo</legend>
	<div id="previewCatalogo"></div>
</div>

<script type="text/javascript">

$(document).ready(function(){

	var optionClean = '<option value ="" disabled selected style="display:none;">Seleccione una Opción</option>';
	$('#nombreCatalogo').popover({html:true, 
				title:"<i class=' icon-exclamation-sign'></i> Nombre Inválido",
				content:"Ya exíste en la base de datos un formulario con éste nombre, debe reemplazarlo",
				trigger: 'manual',
				placement: 'bottom',
			});
	

	$('#nombreCatalogo').keyup(function(){
		var evento = $('#tipoEvento').val();
		var seccion = $('#tipoSeccion').val();
		var nombreCampo = $(this).val();
		var longitudCampo = nombreCampo.length;

		if(longitudCampo == 4){

		} // Fin de la condición del campo

		if(longitudCampo > 3){

			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("AdminForm/ValidarCampo"); ?>',
				data:{
					evento:evento,
					seccion:seccion,
					nombreCampo:nombreCampo
				},
				beforeSend:function(){

				},
				error:function(xhr, status, error){

				},
				success:function(response){
					if(response == '1'){
						colorearCampoNombre('1');
					}
					else{
						colorearCampoNombre('0');
					}
				}
			});

			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("AdminForm/ValidarPalabra") ?>',
				data:{
					evento:evento,
					seccion:seccion,
					nombreCampo:nombreCampo
				},
				beforeSend:function(){

				},
				error:function(xhr,status,error){

				},
				success:function(response){
					if(response !== 'empty'){
						$('#resultadoAlerta').html(response);
						$('#resultadoAlerta').show(500);
					}
					else{
						$('#resultadoAlerta').hide(500);
					}
					
				}
			}); // Fin del ajax
		}
		else{
			$('#resultadoAlerta').hide(500);
			$('#resultadoAlerta').html('');
			//$('#addCatalogoSubmit').attr('disabled','true');
			$('#iconNameWarning').attr('style','display:none;');
			$('#nombreCatalogo').removeClass('campoInvalido');
			$('#nombreCatalogo').removeAttr('valido');

		}
		
	}); //Fin del keypress del nombreCatálogo

	colorearCampoNombre = function(param){
		if(param == '1'){
			//$('#addCatalogoSubmit').removeAttr('disabled');
			$('#iconNameWarning').removeClass('icon-ban-circle');
			$('#iconNameWarning').addClass('icon-ok-circle');
			$('#iconNameWarning').removeAttr('style');
			$('#nombreCatalogo').removeClass('campoInvalido');
			$('#nombreCatalogo').attr('valido','1');
			$('#nombreCatalogo').popover('hide');
		}
		else if(param == '0'){
			//$('#addCatalogoSubmit').attr('disabled','true');
			$('#iconNameWarning').removeClass('icon-ok-circle');
			$('#iconNameWarning').addClass('icon-ban-circle');
			$('#iconNameWarning').removeAttr('style');
			$('#nombreCatalogo').addClass('campoInvalido');
			$('#nombreCatalogo').attr('valido','0');
			$('#nombreCatalogo').popover('show');
		}
	}

	$('#tipoEvento').change(function(){
		var evento = $(this).val();

		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("AdminForm/OptionSeccion"); ?>',
			data: {
				evento:evento
			},
			beforeSend:function(){
				$('#tipoSeccion').empty();
				$('#tipoSeccion').attr('disabled','true');
				$('#hechoPadreLabel').html('--');
				$('#hechoPadre').attr('disabled','true');
				$('#hechoPadre').empty();
				$('#hechoPadre').html(optionClean);
			},
			error:function(error){
				alert('Ocurrió un error, por favor intentelo nuevamente...');
			},
			success:function(response){
				$('#tipoSeccion').empty();
				$('#tipoSeccion').html(response);
				$('#tipoSeccion').removeAttr('disabled');
			}
		});

	}); // fin del change tipoEvento

	$('#tipoSeccion').change(function(){
		var evento = $('#tipoEvento').val();
		var seccion = $(this).val();
		var ara = new Array();

		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("AdminForm/OptionPadres"); ?>',
			data:{
				evento:evento,
				seccion:seccion
			},
			beforeSend:function(){
				$('#hechoPadreLabel').html('--');
				$('#hechoPadre').attr('disabled','true');
			},
			error:function(e){
				alert('Ocurrió un error, por favor intentelo nuevamente...');
			},
			success:function(response){
				ara = response.split('|~|');

				if(ara[0] !== 'nulo'){
					$('#hechoPadreLabel').html(ara[0]);
					$('#hechoPadre').empty();
					$('#hechoPadre').html(ara[1]);
					$('#hechoPadre').removeAttr('disabled');
				}
			}
		});


	}); //fin del change tipoSeccion

	$('#addCatalogo').submit(function(evento){
		evento.preventDefault();
		var evento = $('#tipoEvento').val();
		var seccion = $('#tipoSeccion').val();
		var padre = $('#hechoPadre').val();
		var name = $('#nombreCatalogo').val();
		var nameValid = $('#nombreCatalogo').attr('valido');
		var a = new Array();

		if(nameValid == '1'){
			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("AdminForm/AddForm"); ?>',
				data:{
					evento:evento,
					seccion:seccion,
					padre:padre,
					nombreCampo:name
				},
				beforeSend: function(){

				},
				error:function(xhr,status,error){

				},
				success:function(resp){
					a = resp.split('|~|');
					$('#idCampoSave').val(a[0]);
					$('#nombreModeloSave').val(a[1]);
					$('#constructorInputs').show(500);

					$('#addCatalogo').find(':input').each(function(){
						$(this).attr('disabled','true');
					});
				}
			});
		}
		else{
			$('#nombreCatalogo').popover('show');
		}

	});//Fin del submit addCatalogo

	$('#tipoCampo').change(function(){
		//alert($(this).val());
		var type = $(this).val();
		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("AdminForm/getForm"); ?>',
			data: { type:type },
			beforeSend:function()
			{
				$('#formType').html('');
				$('#formType').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error:function()
			{
				$('#formType').html('');
				$('#formType').html('<h4>Ha ocurrido un error, por favor intentelo nuevamente...</h4>');
			},
			success:function(json)
			{
				$('#formType').html('');
				$('#formType').html(json);
				$('#formType').show(500);
			}
		});
	}); //Fin del change tipoCampo

}); //Fin del Document ready
</script>