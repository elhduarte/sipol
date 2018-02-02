<div class="form-inline" hidden>
	<label class="campotit" for="hechoInsert">Insert/Update</label>
	<input id="hechoInsert" type="text" value="I" class="input-mini">
	<label class="campotit" for="idEventoDetalleHecho">ID EventoDetalle</label>
	<input id="idEventoDetalleHecho" type="text" value="" class="input-mini">
</div>

<div align="center" id="divAddOtroHecho" hidden>
	<legend></legend>
	<button type="button" class="btn btn-primary btn-large" id="addOtroHecho">
		<i class="icon-plus icon-white"></i> 
		Añadir otro Hecho
	</button>
	<legend style="margin-top:20px;"></legend>
</div>

<div class="well" id="hecho_prin" style="margin-bottom:0px;">
<input type="text" id="IdsPersonas" class="span4" style="display:none;">

<?php 

	$model = new CatDenuncia;

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'form_select_hecho',
		'type'=>'vertical',
		'method' => 'post',
		'action' => Yii::app()->createUrl('Denuncia/ProcesaHechos'),
		'htmlOptions'=>array('class'=>'form-inline','name'=>'form_select_hecho','style'=>'margin-bottom:0px;',),
	)); 
?>
	<div align="center">
	<span class="campotit"> Seleccione un Hecho</span>
	    <?php 
	    $criteria = new CDbCriteria;
	    $criteria->order = 'nombre_denuncia asc';
	    echo $form->dropDownListRow($model,'id_cat_denuncia',
	        CHtml::listData(CatDenuncia::model()->findAll($criteria),'id_cat_denuncia','nombre_denuncia'),
			array('class'=>'span6',
				'method'=>'post',
				'labelOptions'=>array('label'=>'',),
				'maxlength'=>12,
				'prompt'=>'Seleccione una opción',
				'required'=>'true',
				'name'=>'hechos_dw',
				'id'=>'hechos_dw'));
		?>
		<!--button type="submit" class="btn  btn-primary" id="submit_hecho_select">Seleccionar</button-->
		<div class="pull-right">
			<img src="images/info_icon.png" data-placement="left" id="ayuda_hechos_select">
		</div>
	</div>
</div> <!-- fin del div hecho_prin well -->
<?php $this->endWidget(); ?>

<div id="hecho_formulario" style="padding:0% 1%;">
</div>

<div id="hechos_resumen_well" style="margin-top: 2%; display:none;">
	<h4 style="margin-left:2%;">Hechos Contenidos en ésta Denuncia:</h4>
	<div id="hechos_resumen"></div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#ayuda_hechos_select').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> AYUDA</legend><p style="line-height: 175%; text-align: justify;">Seleccione un hecho de la lista para llenar los datos que corresponden al mismo.</p>'});

		$('#hechos_dw').change(function(){
			$('#form_select_hecho').submit();
		});

		$('#form_select_hecho').submit(function(e){
			e.preventDefault();
			$.ajaxq('actionSubmit',{
				type:'POST',
				url:$(this).attr('action'),
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#hecho_formulario').html('');
					$('#hecho_formulario').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
				success:function(response)
				{
					$('#hechoInsert').val('I');
					$('#idEventoDetalleHecho').val('');
					$('#IdsPersonas').val('');
					$('#hecho_formulario').html('');
					$('#hecho_formulario').html(response);
				},
			});

		});

		$('#addOtroHecho').click(function(){
			$('#divAddOtroHecho').hide(500);
			$('#hecho_prin').show(500);
		}); // Fin del click addOtroHecho

	}); //Fin del document ready
</script>