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
array('name'=>'usuario', 'header'=>'Usuario','type'=>'raw'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),
array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}{Ampliar}{Usuario}',
   'header'=>'Acciones ',
   
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/denuncia", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns generarPdf'),
   ),
  'Ampliar' => array(
  'icon'=>'icon-share ',
  'url'=>'Yii::app()->controller->createUrl("ExtensionDenuncia/NuevaExtension", array("id"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

   ),
    'Usuario' => array(
  'icon'=>'icon-user ',
  'url'=>'Yii::app()->controller->createUrl("tblUsuario/view", array("id"=>$data["id_usuario"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

   ),
  ),
  'htmlOptions'=>array('style'=>'text-align: center; width:7%;'),
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
array('name'=>'usuario', 'header'=>'Usuario','type'=>'raw'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),
//array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}{Usuario}',
   'header'=>'Acciones',
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/incidencia", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),
   ),

   'Usuario' => array(
  'icon'=>'icon-user ',
  'url'=>'Yii::app()->controller->createUrl("tblUsuario/view", array("id"=>$data["id_usuario"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

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
array('name'=>'usuario', 'header'=>'Usuario','type'=>'raw'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),

//array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}{Usuario}',
   'header'=>'Acciones',
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/extravio", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns generarPdf'),
   ),
    'Usuario' => array(
  'icon'=>'icon-user ',
  'url'=>'Yii::app()->controller->createUrl("tblUsuario/view", array("id"=>$data["id_usuario"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

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
array('name'=>'usuario', 'header'=>'Usuario','type'=>'raw'),
array('name'=>'departamento', 'header'=>'Departamento'),
array('name'=>'municipio', 'header'=>'Municipio'),
array('name'=>'estado', 'header'=>'Estado'),
array('name'=>'comisaria', 'header'=>'Comisaria'),
array('name'=>'sede', 'header'=>'Sede'),
array('name'=>'hechos', 'header'=>'Hechos'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{view}{Ampliar}{Usuario}',
   'header'=>'Acciones ',
   
  'buttons'=>array(       
  'view' => array(
  'url'=>'Yii::app()->controller->createUrl("Reportespdf/denuncia", array("par"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns generarPdf'),
   ),
  'Ampliar' => array(
  'icon'=>'icon-share ',
  'url'=>'Yii::app()->controller->createUrl("ExtensionDenuncia/NuevaExtension", array("id"=>$data["id_evento"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

   ),
    'Usuario' => array(
  'icon'=>'icon-user ',
  'url'=>'Yii::app()->controller->createUrl("tblUsuario/view", array("id"=>$data["id_usuario"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

   ),
  ),
  'htmlOptions'=>array('style'=>'text-align: center; width:7%;'),
  ),
    
),
));
}
?>



<script type="text/javascript">
$(document).ready(function()
{

   $('.generarPdf').click(function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    $('#miHrefPdf').val(href);
    $('#modalSelectPaperSize').modal('show');
  });

  $('.getPaperSize').click(function(){
    var href = $('#miHrefPdf').val();
    var size = $(this).attr('size_paper');

    if(size == 'C'){
      href = href+'&nat=1';
    } 
    if(size == 'O'){
      href = href+'&nat=oficio';
    }
    window.open(href, '_blank');
    $('#modalSelectPaperSize').modal('hide');

  });// Fin de la funcion getPaperSize
 
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
       mupio:"<?php echo $mupio; ?>",
       comisaria:"<?php echo $comisaria; ?>",
       evento_num:"<?php echo $evento_num; ?>",
       tipo_sede:"<?php echo $tipo_sede; ?>",
       sede:"<?php echo $sede; ?>",
       tipo_hecho:"<?php echo $tipo_hecho; ?>",
       hecho:"<?php echo $hecho; ?>",
       distrito:"<?php echo $distrito; ?>"
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

$('.vmodal').click(function(){
var nip = $(this).attr('usuario');
//alert(nip);
$.ajax({
  type :"post", 
  url:'<?php echo CController::createUrl("TblEvento/sispe"); ?>',
  data :{
          nip : nip
        },
  beforeSend: function(){
  $('#cuerpo_infopoli').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>')
  },
  success: function(result){
  $('#cuerpo_infopoli').html(result)
  },
  error: function(){
  $('#cuerpo_infopoli').html('<h4>Error...</h4>')
  },
  });
});



</script>

 
<!-- Modal -->
<div id="infopoli" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Información del Agente</h3>
  </div>
  <div class="modal-body" id ="cuerpo_infopoli">

  </div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    
  </div>
</div>

<!--Modal para Seleccionar el tamaño de papel-->
  <div id="modalSelectPaperSize" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header" style="border-bottom: 0px;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body" id="modalPublicoBody">
      <div id="selectPapelSize">
        <legend>Seleccione el Tamaño de papel para ver el Reporte</legend>
        <div class="row-fluid">
          <div class="span3 offset3">
            <button type="button" class="btn btn-large btn-info span12 getPaperSize" size_paper="C">Carta</button>
          </div>
          <div class="span3">
            <button type="button" class="btn btn-large btn-info span12 getPaperSize" size_paper="O">Oficio</button>
          </div>
        </div>
        <div class="form-inline" hidden>
          <label for="miHrefPdf" class="campotit">Dir</label>
          <input id="miHrefPdf" type="text">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
  </div>
