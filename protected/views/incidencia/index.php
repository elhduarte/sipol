<?php
	$tt_tipo= "'"."El tipo de Incidencia que reporta y el motivo por el que acudió a el lugar"."'";
	$tt_ubicacion= "'"."El lugar donde ocurrieron los hechos"."'";
	$tt_agente= "'"."Seleccione a los agentes y patrullas que participaron en la incidencia"."'";
	$tt_relato= "'"."El relato hablado que detalla el Agente"."'";
	$tt_resumen= "'"."Verifique los datos e imprima la Incidencia"."'";
  $tt_consignados= "'"."Ingrese los datos de los consignados dentro de la incidencia si los hubieran"."'";
  $tt_personas = "Ingrese a las personas relacionadas con ésta incidencia";
  $tt_objetos = "Objetos o evidencia que estén relacionados con ésta incidencia";
?>


<div class="modal-backdrop fade in" id="backdrop"></div>
<div class="modal" id="modal_cargando">
    <div class="modal-body">
      <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>El ingreso de la Incidencia está cargando...</h4>
    </div>
</div>

<div class="cuerpo">
  <h3 style="text-align:center; margin-top:0px; margin-right:5px; line-height:40px;">Ingreso de Incidencia</h3>
  <div class="well well-small form-inline" hidden>
    <label for="identificador_incidencia" class="campotit" style="margin:5px;">ID Incidencia </label>
    <input type="text" id="identificador_incidencia" value="empty" readonly class="input-mini">
    <label for="tipX" class="campotit" style="margin:5px;">tipX </label>
    <input type="text" id="tipX" value="0" readonly class="input-mini">
    <label for="AgeX" class="campotit" style="margin:5px;">AgeX </label>
    <input type="text" id="AgeX" value="0" readonly class="input-mini">
    <label for="ubiX" class="campotit" style="margin:5px;">ubiX </label>
    <input type="text" id="ubiX" value="0" readonly class="input-mini">
    <label for="relX" class="campotit" style="margin:5px;">relX </label>
    <input type="text" id="relX" value="0" readonly class="input-mini">
    <label for="perX" class="campotit" style="margin:5px;">perX </label>
    <input type="text" id="perX" value="0" readonly class="input-mini">
    <label for="Objx" class="campotit" style="margin:5px;">Objx </label>
    <input type="text" id="Objx" value="0" readonly class="input-mini">
    <label for="conX" class="campotit" style="margin:5px;">conX </label>
    <input type="text" id="conX" value="0" readonly class="input-mini">
  </div>


  <div class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="nav_incidencia">
      <li class="active" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_tipo; ?> id="ili_tipoM">
        <a href="#tab1" data-toggle="tab" id="aTab1"><i class="icon-flag" style="margin-right:10px;"></i> Datos Generales</a> 
  	  </li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_agente; ?> id="ili_agentes">
        <a id="aTab2" href="javascript: void(0)" data-toggle="tab"><i id="i_agentes" class="icon-bell BotonClose" style="margin-right:10px;"></i> Agentes Relacionados</a>
    	</li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_ubicacion; ?> id="ili_ubicacion">
        <a id="aTab3" href="javascript: void(0)" data-toggle="tab"><i id="i_ubicacion" class="icon-map-marker BotonClose" style="margin-right:10px;"></i> Ubicación del Evento</a>
    	</li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_relato; ?> id="ili_relato">
        <a id="aTab4" href="javascript: void(0)" data-toggle="tab"><i id="i_relato" class="icon-th-list BotonClose" style="margin-right:10px;"></i> Relato del Evento</a>
    	</li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_personas; ?> id="ili_personas">
        <a id="aTab5" href="javascript: void(0)" data-toggle="tab"><i id="i_personas" class="icon-user BotonClose" style="margin-right:10px;"></i> Personas Relacionadas</a>
      </li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_objetos; ?> id="ili_objetos">
        <a id="aTab6" href="javascript: void(0)" data-toggle="tab"><i id="i_objetos" class="icon-briefcase BotonClose" style="margin-right:10px;"></i> Objetos Relacionadas</a>
      </li>

     <!-- <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_consignados; ?> id="ili_consigna">
        <a id="aTab7" href="javascript: void(0)" data-toggle="tab"><i id="i_consignaciones" class="icon-asterisk BotonClose" style="margin-right:10px;"></i> Consignaciones</a>
    	</li>-->

    	<li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_resumen; ?> id="ili_resumen">
        <a id="aTab8" href="javascript: void(0)" data-toggle="tab"><i id="i_resumen" class="icon-print BotonClose" style="margin-right:10px;"></i> Resumen del Evento</a>
    	</li>
    </ul>
    <div class="tab-content">

      <div class="tab-pane active" id="tab1">
      	<div class="accordion-inner">
        	<?php $this->renderPartial('datosGenerales'); ?>
        </div>
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
          <?php $this->renderPartial('add_persona'); ?>
        </div>
      </div>

      <div class="tab-pane active" id="tab6">
        <div class="accordion-inner">
          <?php $this->renderPartial('add_objetos'); ?>
        </div>
      </div>
<!--
      <div class="tab-pane active" id="tab7">
        <div class="accordion-inner">
          <?php //$this->renderPartial('_consigna'); ?>
      	</div>
      </div>-->

      <div class="tab-pane active" id="tab8">
      	<div class="accordion-inner">
      		<?php echo "ola ke ase";
          $this->renderPartial('_resumen'); ?>
      	</div>
      </div>
      
    </div>
  </div>
</div>

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

	$('#ili_tipoM').tooltip();
	$('#ili_agentes').tooltip();
	$('#ili_ubicacion').tooltip();
	$('#ili_relato').tooltip();
  $('#ili_personas').tooltip();
  $('#ili_objetos').tooltip();
	$('#ili_consigna').tooltip();
	$('#ili_resumen').tooltip();

  $('#tab2').attr('style',"display:none;");
  $('#tab3').attr('style',"display:none;");
  $('#tab4').attr('style',"display:none;");
  $('#tab5').attr('style',"display:none;");
  $('#tab6').attr('style',"display:none;");
  $('#tab7').attr('style',"display:none;");
  $('#tab8').attr('style',"display:none;");

  $('#ili_tipoM').click(function(){
    $('#tab8').hide(500);
    $('#tab7').hide(500);
  	$('#tab6').hide(500);
    $('#tab5').hide(500);
    $('#tab4').hide(500);
    $('#tab3').hide(500);
    $('#tab2').hide(500);
    $('#tab1').show(500);
  });//fin del clic ili_tipoM

  $('#ili_agentes').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab8').hide(500);
      $('#tab7').hide(500);
      $('#tab6').hide(500);
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

  $('#ili_ubicacion').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab8').hide(500);
      $('#tab7').hide(500);
    	$('#tab6').hide(500);
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

  $('#ili_relato').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab8').hide(500);
      $('#tab7').hide(500);
    	$('#tab6').hide(500);
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

  $('#ili_personas').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab8').hide(500);
      $('#tab7').hide(500);
      $('#tab6').hide(500);
      $('#tab1').hide(500);
      $('#tab2').hide(500);
      $('#tab3').hide(500);
      $('#tab4').hide(500);
      $('#tab5').show(500);
    }
    else
    {
      alert('Para continuar, debe completar la sección anterior...');
    }
  });//fin del clic ili_personas

  $('#ili_objetos').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab8').hide(500);
      $('#tab7').hide(500);
      $('#tab1').hide(500);
      $('#tab2').hide(500);
      $('#tab3').hide(500);
      $('#tab4').hide(500);
      $('#tab5').hide(500);
      $('#tab6').show(500);
    }
    else
    {
      alert('Para continuar, debe completar la sección anterior...');
    }
  });//fin del clic ili_objetos

  $('#ili_consigna').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab7').hide(500);
      $('#tab1').hide(500);
    	$('#tab2').hide(500);
      $('#tab3').hide(500);
      $('#tab4').hide(500);
      $('#tab5').hide(500);
      $('#tab6').hide(500);
      $('#tab8').show(500);
    }
    else
    {
      alert('Para continuar, debe completar la sección anterior...');
    }
  });//fin del clic ili_consigna

  $('#ili_resumen').click(function(){
    var MyClass = $(this).attr('class');
    if(MyClass == 'active' || MyClass == 'enabled')
    {
      $('#tab1').hide(500);
      $('#tab2').hide(500);
      $('#tab3').hide(500);
      $('#tab4').hide(500);
      $('#tab5').hide(500);
      $('#tab6').hide(500);
      $('#tab7').hide(500);
      $('#tab8').show(500);
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