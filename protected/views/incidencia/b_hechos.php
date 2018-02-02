<div class="well" id="hecho_prin">

<?php 

	$model = new MTblConsignados;

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'form_select_hecho',
		'type'=>'vertical',
		'method' => 'post',
		'action' => Yii::app()->createUrl('Denuncia/ProcesaHechos'),
		'htmlOptions'=>array('class'=>'form-inline','name'=>'form_select_hecho','style'=>'margin-bottom:0px;',),
	)); 
?>
	<div align="center">
	<span class="campotit"> Seleccione un Tipo De Consignado </span>
	    <?php 
	    $criteria = new CDbCriteria;
	    $criteria->order = 'nombre_consignado asc';
	    echo $form->dropDownListRow($model,'id_consignado',
	        CHtml::listData(MTblConsignados::model()->findAll($criteria),'id_consignado','nombre_consignado'),
			array('class'=>'span6',
				'method'=>'post',
				'labelOptions'=>array('label'=>'',),
				'maxlength'=>12,
				'name'=>'hechos_dw',
				'id'=>'hechos_dw'));
		?>
		<button type="submit" class="btn  btn-primary" id="submit_hecho_select">Seleccionar</button>
		<div class="pull-right">
			<img src="images/info_icon.png" data-placement="left" id="ayuda_hechos_select">
		</div>
	</div>

<?php $this->endWidget(); ?>
</div> <!-- fin del div hecho_prin well -->



<div class="well" style="display:none;" id="hechos_resumen_well">
	<legend>Hechos contenidos en ésta Denuncia:</legend>
	<div id="hechos_resumen"></div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#ayuda_hechos_select').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> AYUDA</legend><p style="line-height: 175%; text-align: justify;">Seleccione un hecho de la lista para llenar los datos que corresponden al mismo.</p>'});

		$('#form_select_hecho').submit(function(e){
			e.preventDefault();
			$.ajax({
				type:'POST',
				url:$(this).attr('action'),
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#resultadoSelect1').html('');
					$('#resultadoSelect1').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
				success:function(response)
				{
					$('#resultadoSelect1').html('');
					$('#resultadoSelect1').html(response);
				},
			});

		});
		$('#motivo_dw').change(function(e){
		e.preventDefault();
		 $("#save_button").removeAttr("disabled");
		idmotivo = $('#motivo_dw').val();
		

		$.ajax({
			type:'POST',
			url: <?php echo "'".CController::createUrl('incidencia/Construye_motivo')."'"; ?>,
			data:
			{
				idMotivo:idmotivo
			},
			beforeSend:function()
			{
			},
			error:function()
			{
				alert('tronitos');
			},
			success:function(respuesta)
			{
				$('#resultadoSelect2').html('');
				$('#resultadoSelect2').html(respuesta);                                                      
				
			}
		
		});
	});


	}); //Fin del document ready
</script>