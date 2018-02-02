<?php
/* @var $this CTBoletaController */
/* @var $data mTBoleta */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_boleta')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_boleta), array('view', 'id'=>$data->id_boleta)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detalle')); ?>:</b>
	<?php echo CHtml::encode($data->detalle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora')); ?>:</b>
	<?php echo CHtml::encode($data->hora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->id_usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_comisaria')); ?>:</b>
	<?php echo CHtml::encode($data->id_comisaria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_departamento')); ?>:</b>
	<?php echo CHtml::encode($data->id_departamento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_municipio')); ?>:</b>
	<?php echo CHtml::encode($data->id_municipio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_zona')); ?>:</b>
	<?php echo CHtml::encode($data->id_zona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kmreferencia')); ?>:</b>
	<?php echo CHtml::encode($data->kmreferencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruta')); ?>:</b>
	<?php echo CHtml::encode($data->ruta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('calle_avenida')); ?>:</b>
	<?php echo CHtml::encode($data->calle_avenida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('colonia_barrio')); ?>:</b>
	<?php echo CHtml::encode($data->colonia_barrio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('casa_lote')); ?>:</b>
	<?php echo CHtml::encode($data->casa_lote); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('the_geom')); ?>:</b>
	<?php echo CHtml::encode($data->the_geom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('division_pnc')); ?>:</b>
	<?php echo CHtml::encode($data->division_pnc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_registro')); ?>:</b>
	<?php echo CHtml::encode($data->hora_registro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('titulo')); ?>:</b>
	<?php echo CHtml::encode($data->titulo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora2')); ?>:</b>
	<?php echo CHtml::encode($data->hora2); ?>
	<br />

	*/ ?>

</div>