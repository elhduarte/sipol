<div class="container-fluid ">
<div class="row-fluid">
    
    <div id="resultado" class="span12">
      
<?php 
if(isset($_POST['entidad']))$entidad = $_POST['entidad'];
echo '<legend>Listado de Sedes</legend>';
$model=new TblSede;
$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->fgrid($entidad),
'responsiveTable' => true,
//'dataProvider'=>$search(),
//'template'=>"{items}\n{pager}",

'columns'=>array(

array('name'=>'id_sede', 'header'=>'#'),
array('name'=>'region', 'header'=>'Tipo De Evento'),
array('name'=>'nombre_entidad', 'header'=>'Fecha de Ingreso'),
array('name'=>'descripcion', 'header'=>'Usuario','type'=>'raw'),
array('name'=>'nombre', 'header'=>'Departamento'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{Ampliar}',
   'header'=>'Acciones ',
   
  'buttons'=>array(       
  'Ampliar' => array(
  'icon'=>'icon-share ',
  'url'=>'Yii::app()->controller->createUrl("adminForm/editar", array("id"=>$data["id_sede"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

   ),
  ),
  'htmlOptions'=>array('style'=>'text-align: center; width:7%;'),
  ),
    
),
));

?>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function()
{ 

$(".pagination a").click(function(e){ 
  e.preventDefault(); 
  //obtengo la url del link 
  var url = $(this).attr('href');
   //realizo la llamada de ajax 
   //alert('hey');

  $.ajax({ 
    url: url,
    data: 
    {
       band : 1,
       entidad:"<?php echo $entidad; ?>",

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