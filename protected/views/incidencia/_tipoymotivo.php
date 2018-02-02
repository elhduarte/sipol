<legend>Seleccione un Tipo y un Motivo de la Incidencia
	<div class="pull-right">
		<img src="images/info_icon.png" data-placement="left" id="ayuda_tipoMotivo">
	</div>
</legend>

<form id="frmTipoyMotivo">

	<div class="row-fluid">
		<div class="span4 labelform">
			<label class="campotitform" for="tipoIncidencia">Tipo de Incidencia</label>
		</div>
		<div class="span8">
			<select id="tipoIncidencia" class="span8" required>
			<?php

				$Criteria = new CDbCriteria();
				$Criteria->order ='tipo_incidencia ASC';
				$data=CatTipoIncidencia::model()->findAll($Criteria);
				$data=CHtml::listData($data,'id_tipo_incidencia','tipo_incidencia');

				echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione una Opción'),true);
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
			<label class="campotitform" for="motivoIncidencia">Origen del Parte Policial</label>
		</div>
		<div class="span8">
			<select id="motivoIncidencia" class="span8" required>
			<?php

				$Criteria = new CDbCriteria();
				$Criteria->order ='motivo_incidencia ASC';
				$data=CatMotivoIncidencia::model()->findAll($Criteria);
				$data=CHtml::listData($data,'id_motivo_incidencia','motivo_incidencia');

				echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione una Opción'),true);
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
			<label class="campotitform">Detalles Adicionales</label>
		</div>
		<div class="span8">
			<textarea placeholder="Detalles relevantes de por qué razón se presentó al lugar de la incidencia" 
			class="span8" id="detallesAdicionales" rows="5"></textarea>
		</div>
	</div>

	<legend style="margin-top:10px;"></legend>
	<div align="right">
		<button type="submit" class="btn btn-primary">Guardar</button>
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){

	$('#ayuda_tipoMotivo').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white">'+
		'</i> IMPORTANTE</legend><p style="line-height: 175%; text-align: justify;">Ingrese el motivo de la incidencia así '+
		'como el motivo por el que se dirigió al lugar en las listas. Si tiene información adicional que considere relevante,'+
		' por favor indíquela en el campo "Detalles Adicionales".</p>'});

	$('#frmTipoyMotivo').submit(function(e){
		e.preventDefault();
		var idTipo = $('#tipoIncidencia').val();
		var idMotivo = $('#motivoIncidencia').val();
		var tipo = $('#tipoIncidencia option:selected').text();
		var motivo = $('#motivoIncidencia option:selected').text();
		var detalles = $('#detallesAdicionales').val();

		$.ajax({
			type:'POST',
			url:"<?php echo Yii::app()->createUrl('Incidencia/Save_TipoyMotivo'); ?>",
			data:
			{
				tipo:tipo,
				motivo:motivo,
				detalles:detalles,
				idTipo:idTipo,
				idMotivo:idMotivo
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
				$('#tipX').val('1');
				$('#identificador_incidencia').val(idEvento);

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

}); //fin del document ready
</script>


