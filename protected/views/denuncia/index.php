<?php
	$tt_denunciante= "'"."Los datos de la persona que está realizando la denuncia"."'";
	$tt_ubicacion= "'"."El lugar donde ocurrieron los hechos"."'";
	$tt_hechos= "'"."Uno o más hechos occuridos durante el evento"."'";
	$tt_relato= "'"."El relato hablado que detalla el Denunciante"."'";
	$tt_resumen= "'"."Verifique los datos e imprima la denuncia"."'";
?>



<div class="modal-backdrop fade in" id="backdrop"></div>
  <div class="modal" id="modal_cargando">
      <div class="modal-body">
        <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>El ingreso de Denuncia está cargando...</h4>
      </div>
  </div>

  <div class="cuerpo">
  <h3 style="text-align:center; margin-top:0px; margin-right:5px; line-height:40px;">Ingreso de Denuncia</h3>

  <div class="well well-small form-inline" style="display:none;">
    <label for="identificador_denuncia" class="campotit" style="margin:5px;">ID Denuncia </label>
    <input type="text" id="identificador_denuncia" value="empty" readonly class="input-mini">
    <label for="denX" class="campotit" style="margin:5px;">denX </label>
    <input type="text" id="denX" value="0" readonly class="input-mini">
    <label for="ubiX" class="campotit" style="margin:5px;">ubiX </label>
    <input type="text" id="ubiX" value="0" readonly class="input-mini">
    <label for="detX" class="campotit" style="margin:5px;">detX </label>
    <input type="text" id="detX" value="0" readonly class="input-mini">
    <label for="relX" class="campotit" style="margin:5px;">relX </label>
    <input type="text" id="relX" value="0" readonly class="input-mini">
  </div>

  <div id="menu_denuncia" class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="nav_denuncia">
      <li class="active" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_denunciante; ?> id="dli_denunciante">
        <a href="#tab1" data-toggle="tab"><i class="icon-user" style="margin-right:10px;"></i> Denunciante</a> </li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_ubicacion; ?> id="dli_ubicacion">
        <a id="aTab2" href="javascript: void(0)" data-toggle="tab"><i id="i_ubicacion" class="icon-map-marker BotonClose" style="margin-right:10px;"></i> Ubicación del Evento</a></li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_hechos; ?> id="dli_hechos">
        <a id="aTab3" href="javascript: void(0)" data-toggle="tab"><i id="i_hechos" class="icon-th-list BotonClose" style="margin-right:10px;"></i> Detalles de Hechos</a></li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_relato; ?> id="dli_relato">
        <a id="aTab4" href="javascript: void(0)" data-toggle="tab"><i id="i_relato" class="icon-bullhorn BotonClose" style="margin-right:10px;"></i> Relato del Evento</a></li>
      <li class="disabled" data-toggle="tooltip" data-placement="right" title= <?php echo $tt_resumen; ?> id="dli_resumen">
        <a id="aTab5" href="javascript: void(0)" data-toggle="tab"><i id="i_resumen" class="icon-print BotonClose" style="margin-right:10px;"></i> Resumen del Evento</a></li>
    </ul>
    <div class="tab-content">

      <div class="tab-pane active" id="tab1">
      	<div class="accordion-inner">
        	<?php $this->renderPartial('_index_persona'); ?>
        </div>
      </div>

      <div class="tab-pane active" id="tab2">
       	<?php $this->renderPartial('_map'); ?>
      </div>

      <div class="tab-pane active" id="tab3">
        <?php $this->renderPartial('_hechos'); ?>
      </div>

      <div class="tab-pane active" id="tab4">
        <div class="accordion-inner">
          <?php $this->renderPartial('_relato'); ?>
        </div>
      </div>

      <div class="tab-pane active accordion-inner" id="tab5">
          <?php $this->renderPartial('_resumen'); ?>
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
	$('#dli_denunciante').tooltip();
	$('#dli_ubicacion').tooltip();
	$('#dli_hechos').tooltip();
	$('#dli_relato').tooltip();
	$('#dli_resumen').tooltip();

  $('#tab2').attr('style',"display:none;");
  $('#tab3').attr('style',"display:none;");
  $('#tab4').attr('style',"display:none;");
  $('#tab5').attr('style',"display:none;");

  $('#dli_denunciante').click(function(){
    $('#tab5').hide(500);
    $('#tab4').hide(500);
    $('#tab3').hide(500);
    $('#tab2').hide(500);
    $('#tab1').show(500);
  });//fin del clic dli_denunciante

  $('#dli_ubicacion').click(function(){
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
  });//fin del clic dli_ubicacion

  $('#dli_hechos').click(function(){
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
  });//fin del clic dli_hechos

  $('#dli_relato').click(function(){
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
  });//fin del clic dli_relato

  $('#dli_resumen').click(function(){
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
  });//fin del clic dli_resumen

  $(document).keydown(function(e){
    //Si el evento es keydown 8 backspace, previene el evento
    var elid = $(document.activeElement).is("input:focus, textarea:focus, #editor"); 
    if (e.keyCode === 8 && !elid) {
        e.preventDefault();
    };
  });

});//Fin del document ready

$(window).load(function(){

  $('#modal_cargando').hide(250);
  $('#backdrop').attr('class', 'modal-backdrop fade');
  $('#backdrop').hide();

}); // Fin del window load

</script>