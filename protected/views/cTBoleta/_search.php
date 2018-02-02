<?php
/* @var $this CTBoletaController */
/* @var $model mTBoleta */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_boleta'); ?>
		<?php echo $form->textField($model,'id_boleta'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'detalle'); ?>
		<?php echo $form->textArea($model,'detalle',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora'); ?>
		<?php echo $form->textField($model,'hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_usuario'); ?>
		<?php echo $form->textField($model,'id_usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_comisaria'); ?>
		<?php echo $form->textField($model,'id_comisaria'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_departamento'); ?>
		<?php echo $form->textField($model,'id_departamento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_municipio'); ?>
		<?php echo $form->textField($model,'id_municipio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_zona'); ?>
		<?php echo $form->textField($model,'id_zona'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kmreferencia'); ?>
		<?php echo $form->textField($model,'kmreferencia',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ruta'); ?>
		<?php echo $form->textField($model,'ruta',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'calle_avenida'); ?>
		<?php echo $form->textField($model,'calle_avenida',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'colonia_barrio'); ?>
		<?php echo $form->textField($model,'colonia_barrio',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'casa_lote'); ?>
		<?php echo $form->textField($model,'casa_lote'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'the_geom'); ?>
		<?php echo $form->textField($model,'the_geom'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'division_pnc'); ?>
		<?php echo $form->textField($model,'division_pnc',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora_registro'); ?>
		<?php echo $form->textField($model,'hora_registro'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'titulo'); ?>
		<?php echo $form->textField($model,'titulo',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora2'); ?>
		<?php echo $form->textField($model,'hora2'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->