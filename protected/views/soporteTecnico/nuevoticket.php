<div class="cuerpo">
  
    <div class="row-fluid">
      <div class="span12">
        <div class="row-fluid">
          <div class="span3">
          </div>
          <div class="span3">
            <center>
                <h3>Soporte técnico de SIPOL </h3> 
                <p>Póngase en contacto con agente de soporte</p>   
                <a href="#myModal" class="btn btn-primary" role="button" class="btn" data-toggle="modal"><img src="images/chat.png" style="height: 33px; width: 31px;" alt="">    Chat Soporte</a>
            </center>
          </div>
          <div class="span3">    
              <img  class="chaticono" style="height: auto;max-width: 60%;" src="images/soporte.jpg" alt="">       
          </div>
          <div class="span3">
          </div>
        </div>
      </div>
    </div>
    <hr>

      <div class="row-fluid">
      <div class="span12">
        <div class="row-fluid">
          <div class="span5">
            <center>
             <img class="pull-right" style="padding: 20px;" src="images/soport.png" alt="">
           </center>
          </div>
    <div class="span7">
<hr>
      <h6><img style ="padding-right:15px; padding-bottom: 0px;" src="images/icons/glyphicons_169_phone.png">Teléfono: <b>30249817</h6></b>
      <h6><img style ="padding-right:15px; padding-bottom: 0px;" src="images/icons/glyphicons_127_message_flag.png">Correo: <b>soportesipol@pnc.gob.gt</h6></b>
      <a href="images/ManualSIPOL.pdf"  TARGET="_blank"><h5>Manual De Usuario SIPOL</h5></a>
      <legend>
      <small><strong>Disponible 24 Horas</strong></small>
      </legend>
    </div>
        </div>
      </div>
    </div>

   

    


  


<div id="procesoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div id="result_procesoModal">
    <div class="modal-body">
      <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>Estamos Procesando su petición...</h4>
    </div>
  </div>
</div>
<script type="text/javascript">

	$(document).ready(function(){


		$('#abrirchat').submit(function(){
				var id_aplicacion = $('#idaplicaciones').val();
				var id_modulo = $('#idmodulo').val(); 
				var id_prioridad = $('#idprioridad').val(); 
				var inconveniente =$('#mensajepeticion').val();
				var telefono =$('#telefono').val();
			//var id_denuncia = $('#identificador_denuncia').val();
			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("SoporteTecnico/AbrirTicket"); ?>',
				data:{id_prioridad:id_prioridad,inconveniente:inconveniente,telefono:telefono},
				beforeSend:function()
				{
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
					$('#procesoModal').modal('show'); 

				},
				success:function(response)
				{
					$('#procesoModal').modal('hide'); 
					window.location.replace('<?php echo CController::createUrl("SoporteTecnico/NuevoTicket"); ?>');
					window.open(response,'_blank','top=30px,left=50px,width=540px,height=660px');				
					//window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
				},
			});//fin del ajax
			return false;
		});//fin del click del botón extravio

	});//Fin del ready
	
</script>

<!-- Button to trigger modal -->

<!-- Modal -->
<form class="form-horizontal" id="abrirchat" name="abrirchat">
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><img src="images/chat.png" style="height: auto; max-width: 5%;" alt="">  Inicio de Soporte</h3>
  </div>
  <div class="modal-body">  	

  
   <div class="control-group">
    <label class="control-label" for="inputEmail">Prioridad</label>
    <div class="controls">
         <select   name="idprioridad" id="idprioridad" required>
              <?php
                  $Criteria = new CDbCriteria();
                  $Criteria->order ='id_prioridad ASC';
                  $data=CatPrioridad::model()->findAll($Criteria);
                  $data=CHtml::listData($data,'id_prioridad','nombre_prioridad');
                  $contador = '0';
                  foreach($data as $value=>$name)
                  {
                  echo '<option value="'.$value.'">'.$name.'</option>';
                  }
              ?>
          </select>
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="inputEmail">Mensaje de Inicio</label>
    <div class="controls">
      <textarea rows="5" id="mensajepeticion"  required placeholder="Ingrese un mensaje para iniciar soporte"></textarea>
    </div>
  </div>
    <div class="control-group">
    <label class="control-label" for="Telefono">Numero Telefono</label>
    <div class="controls">
    	<input type="text" name="telefono" id="telefono" required>
    </div>
  </div>

   
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" type="submit" aria-hidden="true">Cerrar</button>
    <button class="btn btn-primary">Iniciar Chat</button>
  </div>
</div>
</form>

</div>
