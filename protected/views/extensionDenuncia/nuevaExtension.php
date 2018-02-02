<div class="modal-backdrop fade in" id="backdrop"></div>
<div class="modal" id="modal_cargando">
    <div class="modal-body">
      <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>La ampliación de Denuncia está cargando...</h4>
    </div>
</div>

<div class="cuerpo">
  <div class="form-inline well" hidden>
    <label class="campotit" for="identificador_denuncia">idEvento</label>
    <input class="input-mini" type="text" value="<?php echo $idEvento; ?>" id="identificador_denuncia" readonly>
    <label class="campotit" for="nuevoIdEvento">nuevoIdEvento</label>
    <input class="input-mini" type="text" value="empty" id="nuevoIdEvento" readonly>
    <label class="campotit" for="denX">Bandera</label>
    <input class="input-mini" type="text" value="extension" id="denX" readonly>
  </div>
  
  <h3 style="text-align:center; margin-top:0px; margin-right:5px; line-height:40px;">Ampliación Denuncia</h3>

  <div class="tabbable tabs-left">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#extResumen" data-toggle="tab" id="aextResumen"><i class="icon-print" style="margin-right:10px;"></i> Resumen</a></li>
      <li><a href="#extRelato" data-toggle="tab" id="aextRelato"><i class="icon-bullhorn" style="margin-right:10px;"></i> Ampliar Relato</a></li>
      <li class="disabled" id="liextHechos"><a href="javascript: void(0)" data-toggle="tab" id="aextHechos"><i class="icon-th-list BotonClose" style="margin-right:10px;" id="iextHechos"></i> Agregar Hechos</a></li>
      <li class="disabled" id="liextCommit"><a href="javascript: void(0)" data-toggle="tab" id="aextCommit"><i class="icon-ok-sign BotonClose" style="margin-right:10px;" id="iextCommit"></i> Confirmar Ampliación</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="extResumen">
        <div class="accordion-inner">
          <?php $this->renderPartial('resumen',array('idEvento'=>$idEvento)); ?>
        </div>
      </div>
      <div class="tab-pane" id="extRelato">
        <?php $this->renderPartial('relato',array('idEvento'=>$idEvento)); ?>
      </div>
      <div class="tab-pane" id="extHechos">
        <?php $this->renderPartial('hechos',array('idEvento'=>$idEvento)); ?>
      </div>
      <div class="tab-pane" id="extCommit">
        <div id="commit" class="acordion-inner">
          <?php $this->renderPartial('commit'); ?>
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
  
$(window).load(function(){

  $('#modal_cargando').hide(250);
  $('#backdrop').attr('class', 'modal-backdrop fade');
  $('#backdrop').hide();

}); // Fin del window load

</script>