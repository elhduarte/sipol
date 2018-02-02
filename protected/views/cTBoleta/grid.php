
<?php 

$model =new mTBoleta;

$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'template'=>"{items}",
	'columns'=>array(
		'id_boleta',
		//'detalle',
		'hora',
		'fecha',
		//'id_usuario',
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
		),)
));
?>

