<div class ="cuerpo">
<h3 style="text-align:center; margin-top:0px; margin-right:5px; line-height:40px;">Ingreso de Boleta</h3>
<div class="tabbable  ">
 <ul class="nav nav-tabs" id="nav_novedades">
   <li id="li_tab1" class="active"><a href="#tab1" data-toggle="tab"><i class="icon-user" style="margin-right:10px;"></i> Boleta</a> </li>
   <li id="li_tab2"><a href="#tab2" data-toggle="tab"><i class="icon-map-marker" style="margin-right:10px;"></i> Ubicación del Evento</a></li>
    </ul>
 <div class="tab-content">
   <div class="tab-pane active" id="tab1">
       <?php
        $modelo = new mTBoleta;
      $this->renderPartial('_form',array(
      'model'=>$modelo,
    ));
    //$this->renderPartial('test');
    ?>
   </div>
   <div class="tab-pane active" id="tab2">
       
       <?php 
             $this->renderPartial('_map')?>
   </div>
 </div>
</div>
</div>
<script type="text/javascript">
  
  $(document).ready(function(){
    $('#tab2').attr('style','display:none;');

    $('#li_tab1').click(function(){
      $('#tab2').hide(500);
      $('#tab1').show(500);
    });

    $('#li_tab2').click(function(){
      $('#tab1').hide(500);
      $('#tab2').show(500);
    });

  });
 
</script>