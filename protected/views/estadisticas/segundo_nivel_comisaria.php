<?php 
if(isset($_POST['idsede']))$idsede = $_POST['idsede'];
if(isset($_POST['idhecho']))$idhecho = $_POST['idhecho'];
if(isset($_POST['fechainicio']))$fechainicio = $_POST['fechainicio'];
if(isset($_POST['fechafin']))$fechafin = $_POST['fechafin'];

$model= new Estadisticas;

$nombre_sede = $model->getSede($idsede);

$nombre= $nombre_sede[0]['nombre'];

echo '<legend>Listado de Denuncias de: '.$nombre.' </legend>';
$model=new Estadisticas;
$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->getGrid2($idsede,$idhecho,$fechainicio,$fechafin),
'responsiveTable' => true,
'columns'=>array(

array('name'=>'evento_num', 'header'=>'Numero De Evento'),
array('name'=>'fecha_ingreso', 'header'=>'Fecha de Ingreso'),
array('name'=>'hora_ingreso', 'header'=>'Hora Ingreso'),
array('name'=>'usuario', 'header'=>'Usuario','type'=>'raw'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),

array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}',
   'header'=>'Acciones ',
   
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/denuncia", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns generarPdf'),
   ),
  ),
  'htmlOptions'=>array('style'=>'text-align: center; width:7%;'),
  ),
    
),
));


 ?>
 
<div class="row-fluid">
  <div class="span12">
     <div class="row-fluid">
      <div class="span6">
           
      </div>
      <div class="span4"></div>
      <div class="span2"> <div class="span12"><button id="regresasnivel" name="regresasnivel" class="btn btn-success span12" type="button"><i class="icon-white icon-repeat"></i> Atras</button></div>
</div>
    </div>
  </div>
</div>


 <script type="text/javascript">


  $('#regresasnivel').click(function(){

    $('#primernivel').show(1000);
    $('.primernivel').show('fast');

    $('#segundonivel').hide(1000);
    $('.segundonivel').hide('fast');

  });
 </script>