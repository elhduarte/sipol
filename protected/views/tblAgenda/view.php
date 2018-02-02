<?php
/* @var $this TblAgendaController */
/* @var $model TblAgenda */

$this->breadcrumbs=array(
	'Tbl Agendas'=>array('index'),
	$model->id_agenda,
);

$this->menu=array(
	array('label'=>'List TblAgenda', 'url'=>array('index')),
	array('label'=>'Create TblAgenda', 'url'=>array('create')),
	array('label'=>'Update TblAgenda', 'url'=>array('update', 'id'=>$model->id_agenda)),
	array('label'=>'Delete TblAgenda', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_agenda),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TblAgenda', 'url'=>array('admin')),
);
?>

<h1>View TblAgenda #<?php echo $model->id_agenda; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_agenda',
		'id_usuario',
		'titulo',
		'descripcion',
		'fecha',
		'clase',
		'url',
		'inicio',
		'final',
	),
)); ?>
