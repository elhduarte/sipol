<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'customer-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->searchusuario($id),
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
            'template'=>'{view}',
            'header'=>'Acciones',

            'buttons'=>array
            (
                'view' => array
                (
                    'label'=>'Ver usuario',
                    'icon'=>'eye-open',
                     'url'=>'Yii::app()->createUrl("tblUsuario/view", array("id"=>$data->id_usuario))',
                    'options'=>array(
                        //'class'=>'btn btn-small',
                        'style'=>'margin:40%;'
                    ),
                ),
            ),
            'htmlOptions'=>array(
                'style'=>'width: 20px;',
                'align'=>'center',
            ),
        ) 
    ),
));
?>
