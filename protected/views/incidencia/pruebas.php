<?php 
  $CatTipoPersona = new CatTipoPersona;
  $tipoPersona = $CatTipoPersona->getPersonasIncidencia();

  $CatEstadoPersona = new CatEstadoPersona;
  $estadoPersona = $CatEstadoPersona->getEstadoFisico();

  $SeparadorSilabas = new SeparadorSilabas;
  $nombre = $SeparadorSilabas->dividePalabra('SANCHEZ');

  var_dump($nombre);
?>

<legend>Añadir una persona</legend>

<div class="alert alert-info">
  <label class="checkbox">
    <input type="checkbox" id="SinPersonasRel" checked> Ésta incidencia no tiene personas relacionadas
  </label>
</div>

<div id="sinPersonasDiv">
  <div align="right">
    <legend></legend>
    <button type="button" class="btn btn-primary" id="nextSinPersonas">Continuar</button>
  </div>
</div>

<div id="contentPersonRela">
  <div class="well" id="hecho_prin" style="margin-bottom:0px;">
  <input type="text" id="IdsPersonasApart" class="span4" style="display:none;">
    <form id="form_calidad_juridica" style="margin-bottom:0px;">
      <div class="row-fluid">
        <div class="span3 offset1">
          <label class="campotit3" for="calidadJuridica_dw">Calidad Jurídica</label>
        </div>
        <div class="span5">
          <select class="span12" id="calidadJuridica_dw" required>
            <?php echo $tipoPersona; ?>
          </select>
        </div>
      </div>

      <div class="row-fluid">
        <div class="span3 offset1">
          <label class="campotit3" for="">Estado Físico</label>
        </div>
        <div class="span5">
          <select class="span12" required>
            <?php echo $estadoPersona; ?>
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

  <div id="personasAddDiv"></div>
  <div id="personasRelacionadasIncidenciaList"></div>

</div> <!-- Fin del contentObjectRela -->

<button class="btn btn-primary" id="cleanDw" type="button">Clean DW</button>



<script type="text/javascript">
$(document).ready(function(){

  $('#cleanDw').click(function(){
    //alert('click');
    $('#calidadJuridica_dw').val('');
    $('#calificacionObjeto').val('');
  }); //Fin del click cleanDw

  $('#ayuda_hechos_select').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> AYUDA</legend><p style="line-height: 175%; text-align: justify;">Seleccione un hecho de la lista para llenar los datos que corresponden al mismo.</p>'});

  $("#SinPersonasRel").live("click", function(){
    if($(this).is(":checked")) 
    {
      $('#sinPersonasDiv').show(500);
      $('#contentPersonRela').hide(500);
    }
    else
    {
      $('#contentPersonRela').show(500);
      $('#sinPersonasDiv').hide(500);
    }
  });

  $('#nextSinPersonas').click(function(){
    $('#tab5').hide(500);
        $('#tab6').show(500);
    $('#aTab6').attr('href','#tab6');
        $('#ili_objetos').attr('class','enabled');
        $('#i_objetos').removeClass('BotonClose');
        $('#nav_incidencia li:eq(5) a').tab('show');
  }); // fin de nextSinPersonas click

  $('#calidadJuridica_dw').change(function(){
    //$('#form_calidad_juridica').submit();
  });

  $('#form_calidad_juridica').submit(function(e){
    e.preventDefault();
    var idPersonaJuridica = $('#calidadJuridica_dw').val();
    //var idEvento = $('#identificador_incidencia').val();
    var idEvento = '2582';

    $.ajaxq('actionSubmit',{
      type:'POST',
      url:"<?php echo Yii::app()->createUrl('Pjuridica/AddPersonI'); ?>",
      data:{
        personaJuridica: idPersonaJuridica,
        pintaCaracteristicas: '1',
        pintaContacto: '1',
        yoSoy: 'pRelacionadas',
        idEvento:idEvento
      },
      beforeSend:function()
      {
        $('#personasAddDiv').html('');
        $('#personasAddDiv').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
      },
      success:function(response)
      {
        /*$('#hechoInsert').val('I');
        $('#idEventoDetalleHecho').val('');
        $('#IdsPersonas').val('');*/
        $('#personasAddDiv').html('');
        $('#personasAddDiv').html(response);
      },
    });
  });// Fin del Submit

}); //Fin de document ready
</script>

