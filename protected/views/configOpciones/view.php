<?php
/* @var $this ConfigOpcionesController */
/* @var $model ConfigOpciones */

$this->breadcrumbs=array(
	'Config Opciones'=>array('index'),
	$model->id_opciones,
);

$this->menu=array(
	array('label'=>'List ConfigOpciones', 'url'=>array('index')),
	array('label'=>'Create ConfigOpciones', 'url'=>array('create')),
	array('label'=>'Update ConfigOpciones', 'url'=>array('update', 'id'=>$model->id_opciones)),
	array('label'=>'Delete ConfigOpciones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_opciones),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConfigOpciones', 'url'=>array('admin')),
);
?>

<h1>View ConfigOpciones #<?php echo $model->id_opciones; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_opciones',
		'qr_tbl_evento',
		'png_web_dir_tbl_evento',
		'urldenuncia_tbl_evento',
		'body_letter_user',
		'observations_letter_user',
		'mensaje_ingreso',
		'estado_mensaje',
	),
)); ?>
