<?php 
$idhecho = $_POST['idhecho'];
$comisaria = $_POST['identidad'];
$fechainicio = $_POST['fecha_inicio'];
$fechafin = $_POST['fecha_fin'];


$Estadisticas = new Estadisticas;

  $variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
  //$id_cat_entidad=$variable_datos_usuario[0]->id_cat_entidad;

$id_cat_entidad=$comisaria;
$nombre=  $Estadisticas->getNombreCatDenuncia($idhecho);
$nombre = $nombre[0]['nombre_denuncia'];




$conteos = $Estadisticas->getConteoSede2($id_cat_entidad,$idhecho,$fechainicio,$fechafin);
$suma = $Estadisticas->getSumaSede2($id_cat_entidad,$idhecho,$fechainicio,$fechafin);
foreach ($suma as $key => $value) 
{
 $jsonsum = json_encode($value);
 $jsonsum = json_decode($jsonsum);

}


 ?>

<input id="in_hecho" name="in_hecho" value="<?php echo $idhecho?>"  style="display:none">
<input id="fechainicio" name="fechainicio" value="<?php echo $idhecho?>"  style="display:none">
<input id="fechafin" name="fechafin" value="<?php echo $idhecho?>"  style="display:none">
<div class="row-fluid">
  <div class="span12">
    <legend><?php echo $nombre; ?> </legend>
    <div class="row-fluid">
          <div class="span4"><center><h4>NOMBRE DE SEDE</h4></center></div>
          <div class="span4"><center><h4>CANTIDAD</h4></center></div>
          <div class="span4"><center><h4>VER</h4></center></div>
    </div>
    <hr>
 <?php

foreach ($conteos as $key => $value) 
{
 $json = json_encode($value);
 $json = json_decode($json);
 $count = $json->count;
echo ' <div class="row-fluid">
        <div class="span4"><center><strong>'.htmlspecialchars($json->nombre).'</strong></center></div>
        <div class="span4"><center><strong>'.$json->count.'</strong></center></div>
        <div class="span4"><center><i data-idsede = "'.$json->id_sede.'"class="icon-eye-open"></i></center></div>
    </div>
    <hr style ="margin:2px;">';
}
  $url =Yii::app()->createUrl('Estadisticas/snivelcomisaria');
?>
    <div class="row-fluid">
     <div class="span4"><center><strong>TOTAL</strong></center></div>
     <div class="span4"><center><h4><?php echo $jsonsum->sum; ?></h4></center></div>
      <div class=" span4"><button style =" position: relative; left: 27%; top=10px;" id="regresa" name="regresa" class="btn btn-success span6" type="button"><i class="icon-white icon-repeat"></i> Atras</button></div>
    </div>

   </div>
  </div>


<script type="text/javascript">


 $('.icon-eye-open').click(function(e){
  e.stopImmediatePropagation();


  var idsede = $(this).data('idsede');
  var idhecho = $('#in_hecho').val();
  var fechainicio= '<?php echo $fechainicio;?>';
  var fechafin=  '<?php echo $fechafin;?>';
 

        $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticas/snivelcomisaria"); ?>',
          data:{
          idhecho:idhecho,
          idsede:idsede,
          fechainicio: fechainicio,
          fechafin: fechafin
       
        },
        beforeSend:function()
        {
        
        },
        success:function(responde)
        { 
    $('#primernivel').hide(1000);
    $('.primernivel').hide('fast');
    $('#segundonivel').show(1000);
    $('.segundonivel').show('fast');
    $('#segundonivel').html(responde);

        },
      });//fin del ajax

});

  $('#regresa').click(function(){
    $('#primernivel').hide(1000);
    $('.primernivel').hide('fast');
    $('#segundonivel').hide(1000);
    $('.segundonivel').hide('fast');
    $('#tabla').show();
    $('.tabla').show('fast');

  });



</script>