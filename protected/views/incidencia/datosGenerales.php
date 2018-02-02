<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/validate_range_date.js"></script>

<?php
	$ttTipo = "Seleccione un tipo de incidencia Policial";
	$ttMotivo = 'El motivo por el que el agente se presentó al lugar de los hechos, si el motivo de su llegada
				no se encuentra en la lista, por favor seleccione la opción "Otros...';
	$ttRpi = "Escriba el número del RPI que ha llenado en papel";
	$ttMp = "Escriba el número del Caso del MP";
	$ttPnc = "Escriba el número del Caso de la PNC";
	$ttIniDate = "La fecha y hora en la que inició la incidencia policial";
	$ttFinDate = "La fecha y hora en la que finalizó la incidencia policial";
	$ttDetalles = "Si exíste algún detalle adicional que considere pertinente mencionar, por favor ingreselo en éste cuadro de texto";
	$ttDestinatario = "Si la incidencia va dirigida a alguna persona o entidad en específico, por favor detallelo en éste cuadro de texto";
?>

<!--div class="cuerpo"-->
	<legend>Datos Generales
		<div class="pull-right">
			<img src="images/info_icon.png" data-placement="left" id="help_datosGrales">
		</div>
	</legend>

	<form id="frmTipoyMotivo">

		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" for="tipoIncidencia" title="<?php echo $ttTipo; ?>">Tipo de Incidencia</label>
			</div>
			<div class="span5">
				<select id="tipoIncidencia" class="span12" required>
				<?php

					$Criteria = new CDbCriteria();
					$Criteria->order ='nombre_tipo_incidencia ASC';
					$data=CatTipoIncidencia::model()->findAll($Criteria);
					$data=CHtml::listData($data,'id_tipo_incidencia','nombre_tipo_incidencia');

					echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Tipo'),true);
					foreach($data as $value=>$name)
					{
						echo '<option value="'.$value.'">'.$name.'</option>';
					}

				?>
				</select>
			</div>
			<div class="span3" style="padding:5px;">
				<div id="procesandoTipoIncidencia" hidden>
					<img  height ="30px"  width="20px" src="images/loading.gif"/><small> Procesando...</small>
				</div>
			</div>
		</div>
		<div class="alert alert-info" id="resultIncidenciaTipo" hidden> acá se construye el formulario</div>

		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" for="motivoIncidencia" title="<?php echo $ttMotivo; ?>">Origen del Parte Policial</label>
			</div>
			<div class="span5">
				<select id="motivoIncidencia" class="span12" required>
				<?php

					$Criteria = new CDbCriteria();
					$Criteria->order ='motivo_incidencia ASC';
					$data=CatMotivoIncidencia::model()->findAll($Criteria);
					$data=CHtml::listData($data,'id_motivo_incidencia','motivo_incidencia');

					echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Origen'),true);
					foreach($data as $value=>$name)
					{
						echo '<option value="'.$value.'">'.$name.'</option>';
					}

				?>
				</select>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" title="<?php echo $ttRpi; ?>" for="rpiNumber">Número de RPI</label>
			</div>
			<div class="span5">
				<input class="span12" type="text" placeholder="Número de reporte de incidencia" id="rpiNumber">
			</div>
		</div>

		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" title="<?php echo $ttMp; ?>" for="rpiNumber">Número Caso MP</label>
			</div>
			<div class="span5">
				<input class="span12" type="text" placeholder="Número de caso MP" id="mpNumber">
			</div>
		</div>


		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" title="<?php echo $ttPnc; ?>" for="rpiNumber">Número de Caso PNC</label>
			</div>
			<div class="span5">
				<input class="span12" type="text" placeholder="Número de Caso PNC" id="rpiPnc">
			</div>
		</div>

		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" title="<?php echo $ttIniDate; ?>" for="fechaIniGral">Fecha de Inicio</label>
			</div>
			<div class="span5">
				<div class="row-fluid">
					<div class="span6">
						<input class="span12 dateGral from_date" type="text" required id="fechaIniGral">
						<i class="icon-calendar" style="margin: -32px 6px 0 0px; pointer-events: none; position: relative; float:right;" placeholder="Fecha de inicio"></i>
					</div>
					<div class="span6 bootstrap-timepicker">
						<input type="text" class="bootstrap-timepicker span12 timeGral" placeholder="Hora de inicio" required id="horaIniGral">
						<i class="icon-time" style="margin: -32px 6px 0 0px; pointer-events: none; position: relative; float:right;"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" title="<?php echo $ttFinDate; ?>" for="fechaFinGral">Fecha de Finalización</label>
			</div>
			<div class="span5">
				<div class="row-fluid">
					<div class="span6">
						<input class="span12 dateGral to_date" type="text" required id="fechaFinGral">
						<i class="icon-calendar" style="margin: -32px 6px 0 0px; pointer-events: none; position: relative; float:right;" placeholder="Fecha de Finalización"></i>
					</div>
					<div class="span6 bootstrap-timepicker">
						<input type="text" class="bootstrap-timepicker span12 timeGral" placeholder="Hora de inicio" required id="horaFinGral">
						<i class="icon-time" style="margin: -32px 6px 0 0px; pointer-events: none; position: relative; float:right;"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" title="<?php echo $ttDetalles; ?>">Detalles Adicionales</label>
			</div>
			<div class="span5">
				<textarea placeholder="Detalles relevantes de por qué razón se presentó al lugar de la incidencia" 
				class="span12" id="detallesAdicionales" rows="5"></textarea>
				<!--span class="iconClose" title="<?php //echo $ttDetalles; ?>"><i class="icon-info-sign"></i></span-->
			</div>
		</div>

		<legend style="margin-top:10px;"></legend>

		<div class="row-fluid">
			<div class="span4 labelform">
				<label class="campotitform ttLabel" title="<?php echo $ttDestinatario; ?>">Destinatario</label>
			</div>
			<div class="span5">
				<textarea placeholder="Nombre de la persona o institución a quien dirige la Incidencia" 
				class="span12" id="destinatarioGrales" rows="5" required></textarea>
				<!--span class="iconClose" title="<?php //echo $ttDetalles; ?>"><i class="icon-info-sign"></i></span-->
			</div>
		</div>

		<legend style="margin-top:10px;"></legend>
		<div align="right">
			<button type="submit" class="btn btn-primary">Guardar</button>
		</div>
	</form>
<!--/div> Fin del cuerpo -->

<script type="text/javascript">

$(document).ready(function(){

	$('#help_datosGrales').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white">'+
		'</i> IMPORTANTE</legend><p style="line-height: 175%; text-align: justify;">Ingrese la información básica relacionada con la '+
		'incicencia. Si tiene información adicional que considere relevante,'+
		' por favor indíquela en el campo "Detalles Adicionales".</p>'});

	$('.ttLabel').tooltip({html:true, placement:'right'});

	$('.dateGral').datepicker({
		   weekStart: 0,
		    endDate: "setStartDate",
		    format: "dd/mm/yyyy",
		    language: "es",
		    orientation: "top auto",
		    keyboardNavigation: false,
		    forceParse: false,
		    autoclose: true
	});

	$('.timeGral').timepicker({
        showInputs: false,
        modalBackdrop: true,
        showMeridian: false
    });

	var startDate = new Date('01/01/2012');
	var FromEndDate = new Date();
	var ToEndDate = new Date();

	ToEndDate.setDate(ToEndDate.getDate()+365);

	$('.from_date').datepicker({
		weekStart: 1,
		startDate: '01/01/2012',
		endDate: FromEndDate, 
		autoclose: true
	})

	.on('changeDate', function(selected){
		startDate = new Date(selected.date.valueOf());
		startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

		$('.to_date').datepicker('setStartDate', startDate);
	})

	$('.to_date')
		.datepicker({
		weekStart: 1,
		startDate: startDate,
		endDate: ToEndDate,
		autoclose: true
	})

	.on('changeDate', function(selected){
		FromEndDate = new Date(selected.date.valueOf());
		FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));

		$('.from_date').datepicker('setEndDate', FromEndDate);
	});

	$('#tipoIncidencia').change(function(){
		//var miValue = $(this).val();
		//alert('es un change '+ miValue);
		$.ajax({
			type:'POST',
			url:"<?php echo Yii::app()->createUrl('Incidencia/Construye_tipo_incidencia'); ?>",
			data:{
				idForm: $(this).val()
			},
			beforeSend:function(){
				$('#procesandoTipoIncidencia').show(250);
				//$('#resultIncidenciaTipo').fadeTo( "slow", 1 );
				//$('#resultIncidenciaTipo').html('');
				//$('#resultIncidenciaTipo').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
			},
			error:function(error){
				console.log(error);
				$('#resultIncidenciaTipo').html('');
				$('#resultIncidenciaTipo').html('<h4>Ocurrió un error, por favor intentelo de nuevo...</h4>');
			},
			success:function(response){
				if(response == 'empty'){
					$('#resultIncidenciaTipo').slideUp(500);
					$('#procesandoTipoIncidencia').hide(150);
					$('#resultIncidenciaTipo').html(response);
				}
				else{
					$('#procesandoTipoIncidencia').hide(150);
					$('#resultIncidenciaTipo').html('');
					$('#resultIncidenciaTipo').html(response);
					$('#resultIncidenciaTipo').slideDown(500);
				}
			}
		});//Fin del ajax

	}); // tipoIncidencia change FIN

	$('#frmTipoyMotivo').submit(function(e){
		e.preventDefault();
		var idTipo = $('#tipoIncidencia').val();
		var idMotivo = $('#motivoIncidencia').val();
		var tipo = $('#tipoIncidencia option:selected').text();
		var rpi = $('#rpiNumber').val();
		var motivo = $('#motivoIncidencia option:selected').text();
		var detalles = $('#detallesAdicionales').val();
		var fechaini = $('#fechaIniGral').val();
		var fechafin = $('#fechaFinGral').val();
		var horaini = $('#horaIniGral').val();
		var horafin = $('#horaFinGral').val();
		var detallesIncidenciaTipoContent = new Array();
		var contador = 0;
		var detallesIncidenciaTipo = $('#resultIncidenciaTipo').html();
		var idEvento = $('#identificador_incidencia').val();
		$('#contenidoDestinatario').val($('#destinatarioGrales').val());
		//console.log(detallesIncidenciaTipo);

		if(detallesIncidenciaTipo !== 'empty'){

			$('#resultIncidenciaTipo').find(':input').each(function(){
				var elemento = this;
				var typeInput = $(elemento).attr('type');
				var valor = $(elemento).val();
				var ideelemento = this.id;
				var ident = $(elemento).attr('nombre');
				var omiso = $(elemento).attr('omiso');

				if(typeInput !== 'button')
				{
					if(!omiso){
						detallesIncidenciaTipoContent[contador]= ident+ '~' +valor;   
		        		contador = contador +1;
					}
				}
			});// Fin del recorrido

		}

		$.ajax({
			type:'POST',
			url:"<?php echo Yii::app()->createUrl('Incidencia/Save_TipoyMotivo'); ?>",
			data:
			{
				tipo:tipo,
				motivo:motivo,
				detalles:detalles,
				idTipo:idTipo,
				idMotivo:idMotivo,
				rpi:rpi,
				fechaini:fechaini,
				fechafin:fechafin,
				horaini:horaini,
				horafin:horafin,
				idEvento:idEvento,
				contenidoTipo:detallesIncidenciaTipoContent.join('|')
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
			success:function(idEvento)
			{
				if(idEvento == 'UPD'){
					console.log('Update');
					var relatoStatus = $('#relX').val();
					console.log(relatoStatus);
					if(relatoStatus == '1'){
						fnSaveRelato('general');
					}
				}
				else{
					$('#tipX').val('1');
					$('#identificador_incidencia').val(idEvento);
				}

				$('#frmTipoyMotivo').actualizaResumen();
				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<div class=\"modal-body\"><h4>El tipo de incidencia se ha registrado con éxito...'+
					'</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
				$('#aTab2').attr('href','#tab2');
				$('#ili_agentes').attr('class','enabled');
				$('#i_agentes').removeClass('BotonClose');                   
				$('#tab1').hide(50);
				$('#tab2').show(50);
				$('#nav_incidencia li:eq(1) a').tab('show');
			}
		}); //Fin del ajax
	}); //fin del submit del frmTipoyMotivo

});//Fin del Document ready

</script>
