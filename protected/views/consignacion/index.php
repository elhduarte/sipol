<?php
  $tt_consignados= "'Ingrese los datos de los consignados'";
	$tt_ubicacion= "'El lugar donde ocurrieron los hechos'";
	$tt_agente= "'Seleccione a los agentes y patrullas que participaron en la consignación'";
	$tt_relato= "'El relato hablado que detalla el Agente'";
	$tt_resumen= "'Verifique los datos e imprima la Consignación'";
?>


<div class="modal-backdrop fade in" id="backdrop"></div>
<div class="modal" id="modal_cargando">
    <div class="modal-body">
      <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>El ingreso de la Consignación está cargando...</h4>
    </div>
</div>

<div class="cuerpo">
  <h3 style="text-align:center; margin-top:0px; margin-right:5px; line-height:40px;">Ingreso de Consignación</h3>
  <div class="well well-small form-inline" hidden>
    <label for="identificador_consignacion" class="campotit" style="margin:5px;">ID Consigna </label>
    <input type="text" id="identificador_consignacion" value="empty" readonly class="input-mini">
    <label for="conX" class="campotit" style="margin:5px;">conX </label>
    <input type="text" id="conX" value="0" readonly class="input-mini">
    <label for="AgeX" class="campotit" style="margin:5px;">AgeX </label>
    <input type="text" id="AgeX" value="0" readonly class="input-mini">
    <label for="ubiX" class="campotit" style="margin:5px;">ubiX </label>
    <input type="text" id="ubiX" value="0" readonly class="input-mini">
    <label for="relX" class="campotit" style="margin:5px;">relX </label>
    <input type="text" id="relX" value="0" readonly class="input-mini">
  </div>


  <div class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="nav_consignacion">
      <li class="active" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_consignados; ?> id="cli_consigna">
        <a id="aTab1" href="#tab1" data-toggle="tab"><i id="i_consignaciones" class="icon-asterisk" style="margin-right:10px;"></i> Consignaciones</a>
      </li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_agente; ?> id="cli_agentes">
        <a id="aTab2" href="javascript: void(0)" data-toggle="tab"><i id="i_agentes" class="icon-user BotonClose" style="margin-right:10px;"></i> Agentes Relacionados</a>
      </li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_ubicacion; ?> id="cli_ubicacion">
        <a id="aTab3" href="javascript: void(0)" data-toggle="tab"><i id="i_ubicacion" class="icon-map-marker BotonClose" style="margin-right:10px;"></i> Ubicación del Evento</a>
      </li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_relato; ?> id="cli_relato">
        <a id="aTab4" href="javascript: void(0)" data-toggle="tab"><i id="i_relato" class="icon-th-list BotonClose" style="margin-right:10px;"></i> Relato del Evento</a>
      </li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_resumen; ?> id="cli_resumen">
        <a id="aTab5" href="javascript: void(0)" data-toggle="tab"><i id="i_resumen" class="icon-print BotonClose" style="margin-right:10px;"></i> Resumen del Evento</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane active" id="tab1">
        <?php $this->renderPartial('_consignados'); ?>
      </div>

      <div class="tab-pane active" id="tab2">
        <div class="accordion-inner">
          <?php $this->renderPartial('_agentes'); ?>
        </div>
      </div>

      <div class="tab-pane active" id="tab3">
        <?php $this->renderPartial('_map'); ?>
      </div>

      <div class="tab-pane active" id="tab4">
        <div class="accordion-inner">
          <?php $this->renderPartial('_relato'); ?>
        </div>
      </div>

      <div class="tab-pane active" id="tab5">
        <div class="accordion-inner">
          <?php $this->renderPartial('_resumen'); ?>
        </div>
      </div>

    </div><!-- Fin del tab content -->
  </div><!-- Fin de las tabs tabbable -->
</div><!-- Fin del Cuerpo -->

<!-- Modal -->
<div id="procesoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div id="result_procesoModal">
    <div class="modal-body">
      <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>Estamos Procesando su petición...</h4>
    </div>
  </div>
</div>
<!-- Fin Modal -->

<script type="text/javascript">

$(document).ready(function(){
	$('#cli_agentes').tooltip();
	$('#cli_ubicacion').tooltip();
	$('#cli_relato').tooltip();
	$('#cli_consigna').tooltip();
	$('#cli_resumen').tooltip();

  $('#tab2').attr('style',"display:none;");
  $('#tab3').attr('style',"display:none;");
  $('#tab4').attr('style',"display:none;");
  $('#tab5').attr('style',"display:none;");

  $('#cli_consigna').click(function(){
    $('#tab5').hide(500);
    $('#tab4').hide(500);
    $('#tab3').hide(500);
    $('#tab2').hide(500);
    $('#tab1').show(500);
  });//fin del clic ili_tipoM

  $('#cli_agentes').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab5').hide(500);
      $('#tab4').hide(500);
      $('#tab3').hide(500);
      $('#tab1').hide(500);
      $('#tab2').show(500);
    }
    else
    {
      alert('Para continuar, debe completar la sección anterior...');
    }
  });//fin del clic ili_agentes

  $('#cli_ubicacion').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab5').hide(500);
      $('#tab4').hide(500);
      $('#tab2').hide(500);
      $('#tab1').hide(500);
      $('#tab3').show(500);
    }
    else
    {
      alert('Para continuar, debe completar la sección anterior...');
    }
  });//fin del clic ili_ubicacion

  $('#cli_relato').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab5').hide(500);
      $('#tab2').hide(500);
      $('#tab1').hide(500);
      $('#tab3').hide(500);
      $('#tab4').show(500);
    }
    else
    {
      alert('Para continuar, debe completar la sección anterior...');
    }
  });//fin del clic ili_relato

  $('#cli_resumen').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab2').hide(500);
      $('#tab1').hide(500);
      $('#tab3').hide(500);
      $('#tab4').hide(500);
      $('#tab5').show(500);
    }
    else
    {
      alert('Para continuar, debe completar la sección anterior...');
    }
  });//fin del clic ili_resumen

});//Fin del document ready

$(window).load(function(){

  $('#modal_cargando').hide(250);
  $('#backdrop').attr('class', 'modal-backdrop fade');
  $('#backdrop').hide();

}); // Fin del window load

</script>