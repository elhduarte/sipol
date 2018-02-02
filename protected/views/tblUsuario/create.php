<?php
/* @var $this TblUsuarioController */
/* @var $model TblUsuario */

$this->breadcrumbs=array(
	'Tbl Usuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TblUsuario', 'url'=>array('index')),
	array('label'=>'Manage TblUsuario', 'url'=>array('admin')),
);
?>

<h1>Create TblUsuario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>