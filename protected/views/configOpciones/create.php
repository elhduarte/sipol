<?php
/* @var $this ConfigOpcionesController */
/* @var $model ConfigOpciones */

$this->breadcrumbs=array(
	'Config Opciones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConfigOpciones', 'url'=>array('index')),
	array('label'=>'Manage ConfigOpciones', 'url'=>array('admin')),
);
?>

<h1>Create ConfigOpciones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>