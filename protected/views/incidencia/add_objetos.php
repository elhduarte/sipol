<?php 
  $CatObjetoIncidencia = new CatObjetoIncidencia;
  $CatCalificacionObjeto = new CatCalificacionObjeto;

  $tipoObjeto = $CatObjetoIncidencia->getObjetos();
  $calificacionObjeto = $CatCalificacionObjeto->getCalificaciones();
?>

<legend>Añadir un Objeto</legend>

<div class="alert alert-info">
  <label class="checkbox">
    <input type="checkbox" id="SinObjetosRel" checked> Ésta incidencia no tiene objetos Relacionados
  </label>
</div>

<div id="sinEvidenciaDiv">
  <div align="right">
    <legend></legend>
    <button type="button" class="btn btn-primary" id="nextSinEvidencia">Continuar</button>
  </div>
</div>

<div class="well form-inline" hidden>
  <label class="campotit" for="evidenciaTipoAccion">Insert/Update</label>
  <input type="text" class="input-mini" id="evidenciaTipoAccion" value="I" readonly>
  <label class="campotit" for="idTblObjeto">idTblObjeto</label>
  <input type="text" class="input-mini" id="idTblObjeto" value="empty" readonly>
</div>


<div id="contentObjectRela" hidden>
  <div class="well" id="objetos_relacionados_div" style="margin-bottom:0px;">
    <form id="form_objeto_incidencia" style="margin-bottom:0px;">
      <div class="row-fluid">
        <div class="span3 offset1">
          <label class="campotit3" for="objeto_incidencia_dw">Tipo de Objeto</label>
        </div>
        <div class="span5">
          <select class="span12" id="objeto_incidencia_dw" required>
            <?php echo $tipoObjeto; ?>
          </select>
        </div>
      </div>

      <div class="row-fluid">
        <div class="span3 offset1">
          <label class="campotit3" for="calificacionObjeto">Calificación</label>
        </div>
        <div class="span5">
          <select class="span12" id="calificacionObjeto" required>
            <?php echo $calificacionObjeto; ?>
          </select>
        </div>
      </div>
      
      <div class="row-fluid">
        <div class="span5 offset4" align="right">
          <button class="btn btn-primary" type="submit">Seleccionar</button>
        </div>
      </div>
    </form>
  </div>

  <div id="formResultadoObjetos"></div>
  <div id="resumenEvidencias"></div>
</div> <!-- Fin del contentObjectRela -->



<script type="text/javascript">
$(document).ready(function(){

  $("#SinObjetosRel").live("click", function(){
    if($(this).is(":checked")){
      $('#sinEvidenciaDiv').show(500);
      $('#contentObjectRela').hide(500);
    }
    else{
      $('#contentObjectRela').show(500);
      $('#sinEvidenciaDiv').hide(500);
    }
  });

  $('#nextSinEvidencia').click(function(){
    $('#tab6').hide(500);
        $('#tab8').show(500);
    $('#aTab8').attr('href','#tab8');
    $('#ili_resumen').attr('class','enabled');
    $('#i_resumen').removeClass('BotonClose');
    ///devuelve la anterior a su color para que la siguiente se mire como seleccionada
    $('#nav_incidencia li:eq(6) a').tab('show');
  });

  $('#objeto_incidencia_dw').change(function(){
    //$('#form_objeto_incidencia').submit();
  }); //Fin del change

  $('#form_objeto_incidencia').submit(function(e){
    e.preventDefault();
    var idObjeto = $('#objeto_incidencia_dw').val();

    $.ajaxq('submitDwEvidencia',{
      type:'POST',
      url:"<?php echo Yii::app()->createUrl('Incidencia/ProcesaObjetos'); ?>",
      data:{objeto_incidencia_dw:idObjeto},
      error:function(error){
        console.log(error);
        $('#formResultadoObjetos').html('');
        $('#formResultadoObjetos').html('<h4>Ocurrió un error al construír el formulario, por favor intentelo nuevamente</h4>');
      },
      beforeSend:function(){
        $('#formResultadoObjetos').html('');
        $('#formResultadoObjetos').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
        $('#formResultadoObjetos').show(500);
      },
      success:function(response){
        $('#formResultadoObjetos').html('');
        $('#formResultadoObjetos').html(response);
      }
    });//Fin del ajax
  });//Fin del submit

}); //Fin de document ready
</script>
