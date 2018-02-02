<div class="cuerpo">
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tbl-usuario-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h3><img src="images/icons/glyphicons_136_cogwheel.png" alt="Administrar"> Administrador de Usuario</h3>
<hr>
<?php 
/*
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'customer-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'responsiveTable'=>true,
    'columns'=>array(
        	'puesto',
		'usuario',
		'email',
		'primer_nombre',
		'segundo_nombre',
		'primer_apellido',
		'segundo_apellido',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view} {update} {delete}',
            'header'=>'Acciones',

            'buttons'=>array
            (
                'view' => array
                (
                    'label'=>'Ver usuario',
                    'icon'=>'eye-open',
                     'url'=>'Yii::app()->createUrl("tblUsuario/ResumenGlobal", array("id"=>$data->id_usuario))',
                    'options'=>array(
                        //'class'=>'btn btn-small',
                        'style'=>'margin:4%;'
                    ),
                ),
                'update' => array
                (
                    'label'=>'Actualizar Usuario',
                    'icon'=>'pencil ',
                  'url'=>'Yii::app()->createUrl("tblUsuario/update", array("id"=>$data->id_usuario))',
                    'options'=>array(
                        //'class'=>'btn btn-small',
                        'style'=>'margin:4%;'
                    ),
                ),
                'delete' => array
                (
                    'label'=>'Elimiar Usuario',
                    'icon'=>'trash ',
                    'url'=>'Yii::app()->createUrl("tblUsuario/delete", array("id"=>$data->id_usuario))',
                    'options'=>array(
                       // 'class'=>'btn btn-small',
                    	'style'=>'margin:4%;'
                    ),
                ),
             
            ),
            'htmlOptions'=>array(
                'style'=>'width: 75px;',
                'align'=>'center',
            ),
        ) 
    ),
));

*/
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'customer-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'responsiveTable'=>true,
    'columns'=>array(
            'puesto',
        'usuario',
        'email',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view} {update}',
            'header'=>'Acciones',

            'buttons'=>array
            (
                'view' => array
                (
                    'label'=>'Ver usuario',
                    'icon'=>'eye-open',
                     'url'=>'Yii::app()->createUrl("tblUsuario/ResumenGlobal", array("id"=>$data->id_usuario))',
                    'options'=>array(
                        //'class'=>'btn btn-small',
                        'style'=>'margin:10%;'
                    ),
                ),
                'update' => array
                (
                    'label'=>'Actualizar Usuario',
                    'icon'=>'pencil ',
                  'url'=>'Yii::app()->createUrl("tblUsuario/update", array("id"=>$data->id_usuario))',
                    'options'=>array(
                        //'class'=>'btn btn-small',
                        'style'=>'margin:10%;'
                    ),
                ),
             
            ),
            'htmlOptions'=>array(
                'style'=>'width: 60px;',
                'align'=>'center',
            ),
        ) 
    ),
));
?>
</div>