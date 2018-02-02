<?php
/* @var $this CTBoletaController */
/* @var $model mTBoleta */

$this->breadcrumbs=array(
	'M Tboletas'=>array('index'),
	$model->id_boleta=>array('view','id'=>$model->id_boleta),
	'Update',
);

$this->menu=array(
	array('label'=>'List mTBoleta', 'url'=>array('index')),
	array('label'=>'Create mTBoleta', 'url'=>array('create')),
	array('label'=>'View mTBoleta', 'url'=>array('view', 'id'=>$model->id_boleta)),
	array('label'=>'Manage mTBoleta', 'url'=>array('admin')),
);
?>

<h1>Update mTBoleta <?php echo $model->id_boleta; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>