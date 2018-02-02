<?php
/* @var $this ConfigOpcionesController */
/* @var $model ConfigOpciones */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_opciones'); ?>
		<?php echo $form->textField($model,'id_opciones'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qr_tbl_evento'); ?>
		<?php echo $form->textField($model,'qr_tbl_evento',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'png_web_dir_tbl_evento'); ?>
		<?php echo $form->textField($model,'png_web_dir_tbl_evento',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'urldenuncia_tbl_evento'); ?>
		<?php echo $form->textField($model,'urldenuncia_tbl_evento',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'body_letter_user'); ?>
		<?php echo $form->textArea($model,'body_letter_user',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'observations_letter_user'); ?>
		<?php echo $form->textArea($model,'observations_letter_user',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mensaje_ingreso'); ?>
		<?php echo $form->textArea($model,'mensaje_ingreso',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado_mensaje'); ?>
		<?php echo $form->textField($model,'estado_mensaje'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->