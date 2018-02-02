
<div class="cuerpo">
<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Ingreso por DPI</a></li>
    <li><a href="#tab2" data-toggle="tab">Ingreso Manual</a></li>

  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
      <div id="busqueda_dpi">
      <?php 
		$this->renderPartial('buscardpi');
	 ?>
   </div>
    </div>
    <div class="tab-pane" id="tab2">
       <?php 
		$this->renderPartial('ingreso/ingreso_manual');
	 	?>
    </div>
    
  </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $('#dpipedido').submit(function(){
    var numerodpi = $('#numerodpi').val();    
     $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('TblUsuario/busquedadpi'); ?>',
        data:{
          numerodpi:numerodpi
              },
        beforeSend: function(responder)
        {
          $('#modalprocesando').modal({
                  show: true,
                  keyboard: false,
                  backdrop: "static"
              });
        },
        success: function(responder)
        {
           $('#modalprocesando').modal('hide');
          $('#resultadonumerodepi').html(responder);
          $('#numerodpi').val('');
          $('#formulariobusquedadpi').html('');
        }        
      });
     return false;
  }); 
}); 

</script>
