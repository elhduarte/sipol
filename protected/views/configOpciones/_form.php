<?php
/* @var $this ConfigOpcionesController */
/* @var $model ConfigOpciones */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-opciones-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'qr_tbl_evento'); ?>
		<?php echo $form->textField($model,'qr_tbl_evento',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'qr_tbl_evento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'png_web_dir_tbl_evento'); ?>
		<?php echo $form->textField($model,'png_web_dir_tbl_evento',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'png_web_dir_tbl_evento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'urldenuncia_tbl_evento'); ?>
		<?php echo $form->textField($model,'urldenuncia_tbl_evento',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'urldenuncia_tbl_evento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body_letter_user'); ?>
		<?php echo $form->textArea($model,'body_letter_user',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body_letter_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'observations_letter_user'); ?>
		<?php echo $form->textArea($model,'observations_letter_user',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'observations_letter_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mensaje_ingreso'); ?>
		<?php echo $form->textArea($model,'mensaje_ingreso',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'mensaje_ingreso'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado_mensaje'); ?>
		<?php echo $form->textField($model,'estado_mensaje'); ?>
		<?php echo $form->error($model,'estado_mensaje'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->