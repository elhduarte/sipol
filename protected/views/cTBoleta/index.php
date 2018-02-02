<?php
/* @var $this CTBoletaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'M Tboletas',
);

$this->menu=array(
	array('label'=>'Create mTBoleta', 'url'=>array('create')),
	array('label'=>'Manage mTBoleta', 'url'=>array('admin')),
);
?>

<h1>M Tboletas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
