<?php
/* @var $this CTBoletaController */
/* @var $model mTBoleta */

$this->breadcrumbs=array(
	'M Tboletas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List mTBoleta', 'url'=>array('index')),
	array('label'=>'Create mTBoleta', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('m-tboleta-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage M Tboletas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'m-tboleta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_boleta',
		'detalle',
		'hora',
		'fecha',
		'id_usuario',
		'id_comisaria',
		/*
		'estado',
		'id_departamento',
		'id_municipio',
		'id_zona',
		'kmreferencia',
		'ruta',
		'calle_avenida',
		'colonia_barrio',
		'casa_lote',
		'the_geom',
		'division_pnc',
		'hora_registro',
		'titulo',
		'hora2',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
