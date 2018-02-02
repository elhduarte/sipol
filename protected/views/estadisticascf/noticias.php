<?php
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
#$id_cat_entidad = $variable_datos_usuario[0]->id_cat_entidad;
$nombre_entidad = $variable_datos_usuario[0]->nombre_entidad;
?>

<style type="text/css" media="screen">
  .oculta { display: none; }
</style>


<div class="container cuerpo">
      <div class="row-fluid">
            <div class="span4">
                <legend> <?php echo $nombre_entidad ?></legend>
            </div>
            <div class="span4">
              <div align="center"><legend><h6>Seleccione Ultimos Eventos Registrados En Su Comisaria</h6></legend></div>
                <select multiple id="comboTimeline"  class="span12"> 
                <option selected value="1">Denuncia</option>
                <option value="3">Extravio</option>
                <option value="2">Incidencia</option>
                </select>
                <!--este div esta oculto-->
             </div>

            <div class="span4">
             <div align="center"><legend><h4>Los 20 Mas Importantes</h4></legend></div>
            <button type="button"  name="gomenu" id="gomenu" class="btn btn-large pull-right btn-success"><i class="icon-white icon-arrow-left"></i> Ir al Menu</button>
            </div>
      </div>
</div>
<div id="resutlado" class="timeline"></div>
<script type="text/javascript">
$(document).ready(function()
{

  var timeline2 =1;
     $.ajax({
          type:'POST',
          url:'<?php echo Yii::app()->createUrl("Estadisticas/ProcesaTimeLine"); ?>',                                              
          data: { codigo:timeline2
           },
          beforeSend: function()
          {
             $('#resutlado').html('<img height ="30px" width="30px" src="images/cargando.gif" style="padding:10px;"/>Procesando Información...');
          },
          error: function()
          {
            alert('hubo un error');
          },
          success: function(response)
          {
            
              $('#resutlado').html('');             
              $('#resutlado').html(response);
            
          }
        }); // Fin del ajax
        


$('#gomenu').click(function(){
  var urlmenu ='';

  urlmenu = '<?php echo CController::createUrl("Estadisticas/altomando"); ?>';
location.href=urlmenu;

});

  
  $('#comboTimeline').select2({
     placeholder: 'Seleccione Un Evento',
  });

  $('clickTimeline').show(); 

  $('#comboTimeline').change(function(event)
  {
  
  var timeline2 = $('#comboTimeline').val();   
  if(timeline2== null)
  {
    timeline2 = 1;
  }
  
    console.log(timeline2);
     $.ajax({
          type:'POST',
          url:'<?php echo Yii::app()->createUrl("Estadisticas/ProcesaTimeLine"); ?>',                                              
          data: { codigo:timeline2
           },
          beforeSend: function()
          {
             $('#resutlado').html('<img height ="30px" width="30px" src="images/cargando.gif" style="padding:10px;"/>Procesando Información...');
          },
          error: function()
          {
            alert('hubo un error');
          },
          success: function(response)
          {
            
              $('#resutlado').html('');             
              $('#resutlado').html(response);
            
          }
        }); // Fin del ajax
        


  });//fin de la funcion change


 });//fin del document ready
</script>

