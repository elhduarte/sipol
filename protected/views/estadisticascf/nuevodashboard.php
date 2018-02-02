<?php
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);

$id_cat_entidad = $variable_datos_usuario[0]->id_cat_entidad;

if(isset($_SESSION['ID_ENTIDAD_E']))$id_cat_entidad = $_SESSION['ID_ENTIDAD_E'];


$estadistica = new Estadisticas;
$nombre = $estadistica->getEntidad($id_cat_entidad);

$comisaria = $nombre[0]['nombre_entidad'];

echo '<input type="text" id="idcomisaria" name="idcomisaria" value="'.$id_cat_entidad.'" style="display:none;">';
?>
<script src="lib/highcharts/highcharts.js"></script>
<script src="lib/highcharts/modules/exporting.js"></script>
<script src="lib/highcharts/modules/drilldown.src.js"></script>
<script type="text/javascript" src="lib/sparline/jquery.sparkline.js"></script>
<style>
hr{
margin: 0px 0;
margin: 2%;
}
</style>


<div id="filtros" name ="filtros" class="row-fluid cuerpo">
  <div class="span12">
    <legend>Informacíon de la Comisaria: <?php echo $comisaria;?></legend>
    <div class="row-fluid">
      <form class="form-horizontal" id="generargraficasubmit" name="generargraficasubmit">
      <div class="span2 ">
        <center><label class="text-info">Tipo de Evento</label></center>
        <select  required class="span12" name="tipoevento" id="tipoevento" >
        <option value="1">Denuncias</option>
        <option value="3">Extravios</option>
        </select>
      </div>
      <div class="span2 ">
        <center><label class="text-info">Tipo de Sede</label></center>
        <select  required class="span12" name="tiposede" id="tiposede" >
        <option value="00" style="display:none;">Todas</option>
        <option value="2">Serenazgo</option>
        <option value="3">Sub Estación </option>
        <option value="6">Estacion</option>
        </select>
      </div>
      <div class="span2 ">
        <center><label class="text-info">Nombre Sede</label></center>
        <select  class="span12"  disabled name="sedes" id="sedes" >
        <option value="00">Seleccione Sede</option>
        </select>
      </div>
      <div class="span4">
        <center><label class="text-info">Acciones</label></center>
        <div class="row-fluid">              
           <div class="span6 ">
            <button class="btn btn-large btn-block btn-primary" type="submit"><i class="icon-search icon-white"></i>Aplicar Filtro</button>
          </div>
           <div class="span6">    
          <button type="button"  name="gomenu" id="gomenu" class="btn btn-large btn-block btn-success"><i class="icon-white icon-arrow-left"></i> Ir al Menu</button>
          </div>
        </div>
      </div>
      </form>

      <div class="span2">
        <div id="cargargifprocesando" hidden>
          <center>
          <img src="images/cargando.gif" alt="" style="height: auto; max-width: 10%;">Procesando su petición, <strong>Esto Puede Tardar de 5 a 15 Segundos </strong>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<input ; id="in_hecho" name ="inhecho" type ="hidden"></input> 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">ENVIAR POR CORREO</h3>
  </div>
  <div class="modal-body">
    <label>Ingresa Correo Electronico</label>
    <input type="email" name="correoelectronico"  class="span4" value="" id="correoelectronico" required>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <button class="btn btn-primary" type="button" id="envioporcorreo">Enviar Correo</button>
  </div>
</div>

<div id="modaltablaglobal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">ENVIAR POR CORREO</h3>
  </div>
  <div class="modal-body">
    <label>Ingresa Correo Electronico</label>
    <input type="email" name="correoelectronicoglobal"  class="span4" value="" id="correoelectronicoglobal" required>
      <div id="cargargifprocesandocorreotabla" hidden>
      <center>
      <img src="images/cargando.gif" alt="" style="height: auto; max-width: 10%;">Procesando su petición, <strong>Esto Puede Tardar de 5 a 15 Segundos </strong>
      </center>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <button class="btn btn-primary" type="button" id="envioporcorreomodaltablaglobal">Enviar Correo</button>
  </div>
</div>


<hr>
<div class ="cuerpo" id="segundonivel" style="display:none";>
</div> 
<div id="correorespuesta"></div>
<div class ="cuerpo" id="respuestaajax">
  <img src="images/cargando.gif" class="img-circle">
</div>  
<div class ="cuerpo" id="primernivel" style="display:none";>

<div id="counter">
  
</div>




<script type="text/javascript">
$(document).ready(function(){


$('#target').hide(); //muestro mediante id
$('.target').hide(
)

$('#gomenu').click(function(){
  var urlmenu ='';

  urlmenu = '<?php echo CController::createUrl("Estadisticascf/altomando"); ?>';
location.href=urlmenu;

});


$('#envioporcorreomodaltablaglobal').click(function(){
  var tiempo = "";
    var tipoevento = $('#tipoevento').val();
    var comisaria =$('#idcomisaria').val();
    var correo =$('#correoelectronicoglobal').val();
      $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticascf/Correoenviotablaglobal"); ?>',
        data:{
          tipoevento:tipoevento,
          comisaria:comisaria,
          correo:correo
        },
        beforeSend:function()
        {
      
           $('#correorespuesta').html('');
        },
        success:function(responde)
        { 
         $('#correorespuesta').html(responde);
          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
           $('#cargargifprocesandocorreotabla').hide();
           $('#modaltablaglobal').modal('hide');
        },
      });//fin del ajax
      return false;
});
$('#envioporcorreo').click(function(){
  var tiempo = "";
    var tipoevento = $('#tipoevento').val();
    var tiposede = $('#tiposede').val();
    var sedes = $('#sedes').val();
    var comisaria =$('#idcomisaria').val();
    var correo =$('#correoelectronico').val();

      $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticascf/Correoenviotabla"); ?>',
        data:{
          tipoevento:tipoevento,
          tiposede:tiposede,
          sedes:sedes,
          comisaria:comisaria,
          correo:correo
        },
        beforeSend:function()
        {
          $('#cargargifprocesando').show();
           $('#correorespuesta').html('');
        },
        success:function(responde)
        { 
         $('#correorespuesta').html(responde);
          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
           $('#cargargifprocesando').hide();
           $('#myModal').modal('hide');
        },
      });//fin del ajax
      return false;

});

function actualizaSede(entidad,tipo_sede)
{
  var entidad = entidad;
   var tipo_sede = tipo_sede;
  //var entidad = $('#cmb_entidad').val();
  $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('TblSede/getsede')."'"; ?>,
          data: {
            entidad:entidad,
            tipo_sede:tipo_sede
          },
           beforeSend: function(html)
          {
             
               $('#correorespuesta').html('');
             
          },//fin beforesend
          success: function(result)
          {            
            $('#cargargifprocesando').hide();
            $("#sedes").empty();
            $("#sedes").html(result);
            $("#sedes").removeAttr('disabled');  
             $('#correorespuesta').html('');          
          }
        });
}


$('#tiposede').change(function(){
var entidad = $('#idcomisaria').val();
var tipo_sede = $('#tiposede').val();
actualizaSede(entidad,tipo_sede);
});

    var tiempo = "";
    var tipoevento = $('#tipoevento').val();
    var comisaria =$('#idcomisaria').val();
      $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticascf/Cuadroglobal"); ?>',
        data:{
          tipoevento:tipoevento,
          comisaria:comisaria
        },
        beforeSend:function()
        {
          
          $('#correorespuesta').html('');


              $('#respuestaajax').html('<center><img src="images/cargando.gif" alt="" style="height: auto; max-width: 10%;">Procesando su petición, <strong>Esto Puede Tardar de 5 a 15 Segundos </strong></center>');

        },
        success:function(responde)
        { 
         $('#respuestaajax').html(responde);
          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
           $('#cargargifprocesando').hide();
            $('#correorespuesta').html('');
        },
      });//fin del ajax

$('#generargraficasubmit').submit(function(){
    //var tipoevento = $('#tipoevento').attr('class');
    var tiempo = "";
    var tipoevento = $('#tipoevento').val();
    var tiposede = $('#tiposede').val();
    var sedes = $('#sedes').val();
    var comisaria =$('#idcomisaria').val();
      $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticascf/tabaldashoboarsede"); ?>',
        data:{
          tipoevento:tipoevento,
          tiposede:tiposede,
          sedes:sedes,
          comisaria:comisaria
        },
        beforeSend:function()
        {
          
           $('#correorespuesta').html('');
           $('#respuestaajax').html('');
           $('#respuestaajax').html('<center><img src="images/cargando.gif" alt="" style="height: auto; max-width: 10%;">Procesando su petición, <strong>Esto Puede Tardar de 5 a 15 Segundos </strong></center>');
        },
        success:function(responde)
        { 
         $('#respuestaajax').html(responde);
          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
           $('#cargargifprocesando').hide();
            $('#correorespuesta').html('');
        },
      });//fin del ajax
      return false;
 }); 
 }); 
</script>