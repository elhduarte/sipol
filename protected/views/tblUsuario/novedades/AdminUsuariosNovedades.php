<div class="cuerpo">

<link rel="stylesheet" media="all" href="css/computadora.css" />
<link rel="stylesheet" media="only screen and (max-width: 800px)" href="css/mobil.css"  />
<?php
$model = new TblUsuario;
//print_r($model->consulta_usuario_entidad_completo_usuario_novedades());


$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->consulta_usuario_entidad_completo_usuario_novedades(),

'responsiveTable' => true,
//'dataProvider'=>$search(),
//'template'=>"{items}\n{pager}",

'columns'=>array(

array('name'=>'nombre_completo', 'header'=>'Nombre de Usuario'),
array('name'=>'entidad', 'header'=>'Entidad'),
array('name'=>'nombre_rol', 'header'=>'Rol'),
array('name'=>'ubicacion', 'header'=>'Ubicacion'),
array('name'=>'id_usuario', 'header'=>'id_usuario','type'=>'raw'),

array(
  'class'=>'bootstrap.widgets.TbButtonColumn',

  'template'=>'{view}{Usuario}',
   'header'=>'Acciones ',

  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/denuncia", array("par"=>$data["id_usuario"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns generarPdf'),
   ),
 
    'Usuario' => array(
  'icon'=>'icon-user ',
  'url'=>'#cambio", array("id"=>$data["id_usuario"]))',
  'options'=>array('style'=>'padding:5%;','class'=>'buttonColumns pasar','valor'=>'$data["id_usuario"]'),

   ),
  ),
  'htmlOptions'=>array('style'=>'text-align: center; width:7%;'),
  ),
    
),
));
/*
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'customer-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->consulta_usuario_entidad_completo_usuario_novedades(),
    'filter'=>$model,
    'responsiveTable'=>true,
    'columns'=>array(
        	'id_usuario',
		//'nombre_completo',
		'entidad',
		'nombre_rol',
		'ubicacion',
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
?>


</div>

<div id ="cambio"> </div>

<div id="asignar_rol">

<select id="roles_novedades">
<option value="1">Administrador</option>
<option value="2">Ingreso Boletas</option>
<option value="3">Ver Boletas</option>
</select>
</div>

<script type="text/javascript">
$('.asignacion_rol').click(function(){
	var ver_valor = $(this).attr('valor');
	//alert(ver_valor);
	$('#cambio').html(ver_valor);
});
</script>