<?php

$tipo = "empty";
$fecha_ini ="empty";
$fecha_fin ="empty";
$estado ="";
$depto ="";
$mupio ="";
$comisaria ="";
$evento_num ="";
$tipo_sede ="";
$sede ="";
$tipo_hecho ="";
$hecho ="";
$distrito ="";

if(isset($_POST['tipo']))$tipo = $_POST['tipo'];
if(isset($_POST['fecha_ini']))$fecha_ini = $_POST['fecha_ini'];
if(isset($_POST['fecha_fin']))$fecha_fin = $_POST['fecha_fin'];
if(isset($_POST['estado']))$estado = $_POST['estado'];
if(isset($_POST['depto']))$depto = $_POST['depto'];
if(isset($_POST['mupio']))$mupio = $_POST['mupio'];
if(isset($_POST['comisaria'])) $comisaria = $_POST['comisaria'];
if(isset($_POST['num_evento'])) $evento_num = $_POST['num_evento'];
if(isset($_POST['tipo_sede'])) $tipo_sede = $_POST['tipo_sede'];
if(isset($_POST['sede'])) $sede = $_POST['sede'];
if(isset($_POST['tipo_hecho'])) $tipo_hecho = $_POST['tipo_hecho'];
if(isset($_POST['hecho'])) $hecho = $_POST['hecho'];
if(isset($_POST['distrito'])) $distrito = $_POST['distrito'];

if ($tipo == 1)
{

echo '<legend>Listado de Denuncias</legend>';
$model=new TblEvento;
$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->fgrid($tipo,$fecha_ini,$fecha_fin,$estado,$depto,$mupio,$comisaria,$evento_num,$tipo_sede,$sede,$tipo_hecho,$hecho,$distrito),
'responsiveTable' => true,
//'dataProvider'=>$search(),
//'template'=>"{items}\n{pager}",

'columns'=>array(

array('name'=>'evento_num', 'header'=>'Numero De Evento'),
array('name'=>'id_tipo_evento', 'header'=>'Tipo De Evento'),
array('name'=>'fecha_ingreso', 'header'=>'Fecha de Ingreso'),
array('name'=>'id_usuario', 'header'=>'Usuario'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),
array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}{Extender}',
   'header'=>'Acciones',
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/denuncia", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:10%;'),
   ),
  'Extender' => array(
  'icon'=>'icon-share ',
  'url'=>'Yii::app()->controller->createUrl("ExtensionDenuncia/NuevaExtension", array("id"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:10%;'),

   ),
  ),
  ),
    
),
));
} elseif ($tipo == 2)
{
  echo '<legend>Listado de Incidencias</legend>';
$model=new TblEvento;
$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->fgrid($tipo,$fecha_ini,$fecha_fin,$estado,$depto,$mupio,$comisaria,$evento_num,$tipo_sede,$sede,$tipo_hecho,$hecho,$distrito),
'responsiveTable' => true,
//'dataProvider'=>$search(),
//'template'=>"{items}\n{pager}",

'columns'=>array(

array('name'=>'evento_num', 'header'=>'Numero De Evento'),
array('name'=>'id_tipo_evento', 'header'=>'Tipo De Evento'),
array('name'=>'fecha_ingreso', 'header'=>'Fecha de Ingreso'),
array('name'=>'id_usuario', 'header'=>'Usuario'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),
//array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}',
   'header'=>'Acciones',
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/incidencia", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank'),
   ),
  ),
  ),
    
),
));

}elseif ($tipo == 3) {
  echo '<legend>Listado de Extravios</legend>';
$model=new TblEvento;
$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->fgrid($tipo,$fecha_ini,$fecha_fin,$estado,$depto,$mupio,$comisaria,$evento_num,$tipo_sede,$sede,$tipo_hecho,$hecho,$distrito),
'responsiveTable' => true,
//'dataProvider'=>$search(),
//'template'=>"{items}\n{pager}",

'columns'=>array(

array('name'=>'evento_num', 'header'=>'Numero De Evento'),
array('name'=>'id_tipo_evento', 'header'=>'Tipo De Evento'),
array('name'=>'fecha_ingreso', 'header'=>'Fecha de Ingreso'),
array('name'=>'id_usuario', 'header'=>'Usuario'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),
//array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}',
   'header'=>'Acciones',
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/extravio", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank'),
   ),
  ),
  ),
    
),
));  
}else
{
  echo '<legend>Listado de Denuncias</legend>';
$model=new TblEvento;
$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->fgrid($tipo,$fecha_ini,$fecha_fin,$estado,$depto,$mupio,$comisaria,$evento_num,$tipo_sede,$sede,$tipo_hecho,$hecho,$distrito),
'responsiveTable' => true,
//'dataProvider'=>$search(),
//'template'=>"{items}\n{pager}",

'columns'=>array(

array('name'=>'evento_num', 'header'=>'Numero De Evento'),
array('name'=>'id_tipo_evento', 'header'=>'Tipo De Evento'),
array('name'=>'fecha_ingreso', 'header'=>'Fecha de Ingreso'),
array('name'=>'id_usuario', 'header'=>'Usuario'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),
array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}{Extender}',
   'header'=>'Acciones',
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/denuncia", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:10%;'),
   ),
  'Extender' => array(
  'icon'=>'icon-share ',
  'url'=>'Yii::app()->controller->createUrl("ExtensionDenuncia/NuevaExtension", array("id"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:10%;'),

   ),
  ),
  ),
    
),
));
}
?>

<script type="text/javascript">
$(document).ready(function()
{ 

$(".pagination a").click(function(e){ 
  e.preventDefault(); 
  //obtengo la url del link 
  var url = $(this).attr('href');
   //realizo la llamada de ajax 
  var fecha1 = $('#fecha1').val();
  $.ajax({ 
    url: url,
    data: 
    {
       band : 1,
       tipo:"<?php echo $tipo; ?>",
       fecha_ini:"<?php echo $fecha_ini; ?>",
       fecha_fin:"<?php echo $fecha_fin; ?>",
       estado:"<?php echo $estado; ?>",
       depto:"<?php echo $depto; ?>",
       mupio:"<?php echo $mupio; ?>"
    },
    type:'POST',
    beforeSend:function(){ 
     //btn.button('loading'); 
    },
    success:function(data){ 
       $("#resultado").html(''); 
       $("#resultado").html(data); 
    }, 
    error:function(){ }, 
    complete:function(){ 
       //btn.button('reset');
    } 
  }); 


});  

});
</script>