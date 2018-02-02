<?php
if(empty($_POST['param']))
{
	$param='vacio';
}
else
{
	$param = $_POST['param'];
}

$model= new mTBoleta;

$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'dataProvider'=>$model->griddata($param),
 'responsiveTable' => true,
 'template'=>"{items}\n{pager}",
'columns'=>array(
array('name'=>'id_boleta', 'header'=>'Numero Boleta'),
array('name'=>'fecha', 'header'=>'Fecha'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'titulo', 'header'=>'Titulo'),
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
'template'=>'{view}',
'buttons'=>array(       
'view' => array(
'url'=>'Yii::app()->controller->createUrl("cTBoleta/view",array("id"=>$data["id_boleta"]))',
'label'=>'Ver Novedad',
),
),
),

),
));

?>