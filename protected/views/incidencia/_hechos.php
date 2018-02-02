<div class="well" id="hecho_prin" style="margin-bottom: 0px;">
<input type="text" id="IdsPersonas" class="span4" style="display:none;">

<?php 

	$model = new CatConsignados;

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'form_select_hecho',
		//'type'=>'vertical',
		'method' => 'post',
		'action' => Yii::app()->createUrl('incidencia/ProcesaHechos'),
		'htmlOptions'=>array('class'=>'form-inline','name'=>'form_select_hecho','style'=>'margin-bottom:0px;',),
	)); 
?>
	<div align="center">
	<span class="campotit"> Seleccione un Tipo De Consignado</span>
	    <?php 
	   $Criteria = new CDbCriteria();
       $Criteria->order ='nombre_consignado ASC';
	    echo $form->dropDownListRow($model,'id_cat_consignados',
	        CHtml::listData(CatConsignados::model()->findAll($Criteria),'id_cat_consignados','nombre_consignado'),
			array('class'=>'span6',
				'method'=>'post',
				'labelOptions'=>array('label'=>'',),
				'prompt'=>'Seleccione un tipo de Consignado',
				'required'=>true,
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

<form id="FrmConsignados" style="margin-bottom:0px;">
	<div id="resultadoSelect1"></div>
	<div id="resultadoSelect2"></div>
	<div id="resultadoSelect3"></div>

	<div id="BotonesConsignacion" align="right" style="display:none;">
		<legend style="padding-top:1%"></legend>
		<button type="button" class="btn" id="cancelar_form">Cancelar</button>
		<button disabled type="submit" class="btn btn-primary " id ="save_button">Guardar Consignación</button>
	</div>
</form>


<input type="text" id="IdsPersonas" class="span4" style="display:none;">
<div style="display:none;" id="hechos_resumen_well">
	<legend style="padding-top:2%; margin-bottom:0px;"></legend>
	<legend>Objetos y/o Personas consignados en ésta Incidencia:</legend>
	<div id="hechos_resumen"></div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#ayuda_hechos_select').tooltip({html: true, title: '<legend class="legend_tt">'+
			'<i class="icon-question-sign icon-white"></i> AYUDA</legend><p style="line-height: 175%; text-align: justify;">'+
			'Seleccione un tipo de consignado de la lista para llenar los datos que corresponden al mismo.</p>'});

		$('#form_select_hecho').submit(function(e){
			e.preventDefault();
			$.ajax({
				type:'POST',
				url:$(this).attr('action'),
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#resultadoSelect1').html('');
					$('#resultadoSelect2').html('');
					$('#resultadoSelect3').html('');
					$('#resultadoSelect1').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
				success:function(response)
				{
					$('#resultadoSelect1').html('');
					$('#resultadoSelect2').html('');
					$('#resultadoSelect3').html('');
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

	$('#cancelar_form').click(function(){
		alert('cancelar');
		$('#result_procesoModal').html('');
		$('#result_procesoModal').html('<div class=\"modal-body\">'+
				'<h4>¿Está seguro que desea cancelar la Consignación?</h4></div><div class=\"modal-footer\">'+
				'<button id=\"CancelFormModal\" class=\"btn\">Descartar Consignación</button>'+
				'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button></div>'
				);
		$('#procesoModal').modal('show');

			$('#CancelFormModal').click(function(){
				$('#resultadoSelect1').html('');
				$('#resultadoSelect2').html('');
				$('#resultadoSelect3').html('');
				$('#BotonesConsignacion').hide(500);
				$('#procesoModal').modal('hide');
			});//
	}); //Cancel form

	$('#FrmConsignados').submit(function(e){
		e.preventDefault();
		var IdsPersonas = $('#IdsPersonas').val();
		var hecho_construido = new Array();
		var motivo_array = new Array();
		var motivo_lugar = new Array();
		var contador = 0;
		var contador2 = 0;
		var contador3 = 0;
		var fecha = $('#fecha_hecho_ob').val();
		var hora = $('#hora_hecho_ob').val();

		$('#tipo_con').find(':input').each(function(){
		var elemento = this;
		var valor = $(elemento).val();
		var ident = $(elemento).attr('nombre');

		hecho_construido[contador]= ident+ '~' +valor;   
		contador = contador +1;
		});//Fin del each

		$('#motivo_con').find(':input').each(function(){
		var elemento = this;
		var valor = $(elemento).val();
		var ident = $(elemento).attr('nombre');

		motivo_array[contador2]= ident+ '~' +valor;   
		contador2 = contador2 +1;
		});//Fin del each

		$('#lugar_cona').find(':input').each(function(){
		var elemento = this;
		var valor = $(elemento).val();
		var ident = $(elemento).attr('nombre');

		motivo_lugar[contador3]= ident+ '~' +valor;   
		contador3 = contador3 +1;
		});//Fin del each

		var idEvento = $('#identificador_incidencia').val();
		//var idEvento = '83';
		var id_hecho = $('#hechos_dw').val();
		var id_motivo = $('#motivo_dw').val();
		var id_lugar_con = $('#lugar_con').val();
		//alert(id_hecho);

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("Incidencia/Save_hechos"); ?>',
			data: 
			{
				hecho_construido: hecho_construido.join('|'),
				motivo_array: motivo_array.join('|'),
				motivo_lugar: motivo_lugar.join('|'),
				id_motivo : id_motivo,
				id_lugar_con: id_lugar_con,
				id_evento: idEvento,
				fecha: fecha,
				hora: hora,
				id_hecho: id_hecho,
				persona:IdsPersonas
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
			success: function(respuesta)
			{
				//alert(id_evento);
				$('#conX').val('1');
				$('#SinConsignaciones').attr('diabled','true');
				$('#FrmConsignados').MostrarHechos(idEvento);
				$('#FrmConsignados').actualizaResumen();
				$('#resultadoSelect1').html('');
				$('#resultadoSelect2').html('');
				$('#resultadoSelect3').html('');
				$('#BotonesConsignacion').hide(500);
				$('#IdsPersonas').val('');

				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>El consignado se ha registrado Correctamente</h4></div><div class=\"modal-footer\">'+
						'<button id=\"ConsignaContinua\" class=\"btn\">Continuar</button>'+
						'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Ingresar Otro Consignado</button></div>'
						);

				$('#aTab8').attr('href','#tab8');
				$('#ili_resumen').attr('class','enabled');
				$('#i_resumen').removeClass('BotonClose'); 

					$('#ConsignaContinua').click(function(){
						$('#tab7').hide(500);
						$('#tab8').show(500);
						$('#nav_incidencia li:eq(7) a').tab('show');
						$('#procesoModal').modal('hide'); 
					});//Fin de función ConsignaContinua

			},

		});//fin del ajax

	});// fin del submit


	}); //Fin del document ready
</script>
