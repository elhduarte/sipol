<?php
/* @var $this ConfigOpcionesController */
/* @var $model ConfigOpciones */

$this->breadcrumbs=array(
	'Config Opciones'=>array('index'),
	$model->id_opciones=>array('view','id'=>$model->id_opciones),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConfigOpciones', 'url'=>array('index')),
	array('label'=>'Create ConfigOpciones', 'url'=>array('create')),
	array('label'=>'View ConfigOpciones', 'url'=>array('view', 'id'=>$model->id_opciones)),
	array('label'=>'Manage ConfigOpciones', 'url'=>array('admin')),
);
?>

<h1>Update ConfigOpciones <?php echo $model->id_opciones; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>