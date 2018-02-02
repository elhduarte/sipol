<?php
/* @var $this ConfigOpcionesController */
/* @var $data ConfigOpciones */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_opciones')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_opciones), array('view', 'id'=>$data->id_opciones)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qr_tbl_evento')); ?>:</b>
	<?php echo CHtml::encode($data->qr_tbl_evento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('png_web_dir_tbl_evento')); ?>:</b>
	<?php echo CHtml::encode($data->png_web_dir_tbl_evento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('urldenuncia_tbl_evento')); ?>:</b>
	<?php echo CHtml::encode($data->urldenuncia_tbl_evento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('body_letter_user')); ?>:</b>
	<?php echo CHtml::encode($data->body_letter_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observations_letter_user')); ?>:</b>
	<?php echo CHtml::encode($data->observations_letter_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mensaje_ingreso')); ?>:</b>
	<?php echo CHtml::encode($data->mensaje_ingreso); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('estado_mensaje')); ?>:</b>
	<?php echo CHtml::encode($data->estado_mensaje); ?>
	<br />

	*/ ?>

</div>