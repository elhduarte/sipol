<?php 
	/*
	$personaJuridica = $_POST['personaJuridica'];
	$pintaCaracteristicas = $_POST['pintaCaracteristicas'];
	$pintaContacto = $_POST['pintaContacto'];
	$idEvento = $_POST['idEvento'];*/


	$personaJuridica = "Extravio";
	$pintaCaracteristicas = 0;
	$pintaContacto = 
	$idEvento = 0;
/*
	$funciones = new Funcionesp;
	$nombrePj = $funciones->getPersonaJuridica($personaJuridica);
	$reportes = new Reportes;
	$denunciante = $reportes->getDenunciante($idEvento);
	//var_dump($denunciante);
	$denunciante = $denunciante['Nombre_Completo'];
	$idDenunciante = $reportes->getIdDenunciante($idEvento);
	//echo $idDenunciante;
*/
?>


	<div class="well well-small form-inline" style="display:none;">
	  <label for="personaJuricia" class="campotit" style="margin:5px;">ID Persona Juridica </label>
	  <input type="text" id="personaJuricia" value="<?php echo $personaJuridica; ?>" readonly>
	  <label for="pintaCaracteristicas" class="campotit" style="margin:5px;">Caracteristicas </label>
	  <input type="text" id="pintaCaracteristicas" value="<?php echo $pintaCaracteristicas; ?>" readonly>
	  <label for="pintaContacto" class="campotit" style="margin:5px;">Contacto </label>
	  <input type="text" id="pintaContacto" value="<?php echo $pintaContacto; ?>" readonly>
	</div>
	
	<div id="buscarPersonaJ">
		<!--div class="row-fluid">
			<div class="form-inline span6" align="left" style="padding:1%; padding-bottom:5px;">
				<label class="checkbox" for="ckUserenap" id="LabelckUserenap">
			      <input type="checkbox" id="ckUserenap" checked> Buscar con RENAP
			    </label>
			</div>	
		</div -->
		<div class="alert alert-info" id="frmSearch">
			<div class="row-fluid">
				<div class="span2">
					<div class="span12"><p class="campotit">Primer Nombre</p></div>
					<input type="text" id="nom1Pj<?php echo $personaJuridica;?>" class="span12" placeholder="Primer Nombre">
				</div>
				<div class="span2">
					<div class="span12"><p class="campotit">Segundo Nombre</p></div>
					<input type="text" id="nom2Pj<?php echo $personaJuridica;?>" class="span12" placeholder="Segundo Nombre">
				</div>
				<div class="span2">
					<div class="span12"><p class="campotit">Primer Apellido</p></div>
					<input type="text" id="ape1Pj<?php echo $personaJuridica;?>" class="span12" placeholder="Primer Apellido">
				</div>
				<div class="span2">
					<div class="span12"><p class="campotit">Segundo Apellido</p></div>
					<input type="text" id="ape2Pj<?php echo $personaJuridica;?>" class="span12" placeholder="Segundo Apellido">
				</div>

				<div class="span2" style="padding-left:1%; padding-right:1%; border-right: 1px solid rgba(143, 193, 207, 0.54); border-left: 1px solid rgba(143, 193, 207, 0.54);">
					<div class="span12"><p class="campotit">DPI</p></div>
					<input type="text" id="dpiPj<?php echo $personaJuridica; ?>" class="span12" placeholder="DPI">
				</div>
				<div class="span2">
					<div class="span12">
						<!--div class="pull-right">
							<img src="images/info_icon.png" data-placement="left" id="ayuda_denunciante">
		    			</div-->
					</div>
					<center><button type="button" class="btn btn-info span10" id="renap_buscar_Show"><i class="icon-search icon-white"></i> Buscar</button></center>
				</div>
			</div>
			<legend class="legendInfo"></legend>
			<p class="comentario-fit" style="color: rgb(58, 135, 173);"> * Puede buscar los datos del DPI extraviado en RENAP 
				por medio del nombre o el Número del DPI</p>
		</div>
		<div id="Pj_resultado"></div>
		<div class="alert alert-success" id="MensajeAutocomplete" style="display:none;"></div>
	</div>

<script type="text/javascript">

$(document).ready(function()
{
	//$('#label_es_persona').tooltip();
	$('#label_es_asociacion').tooltip();
	$('#LabelckUserenap').tooltip({title:'Quite la selección para digitar los datos de la persona.'});
	//$('#ayuda_denunciante').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> IMPORTANTE</legend><p style="line-height: 175%; text-align: justify;">Puede buscar a las personas por su nombre o DPI.</p>'});
	$('#nom1Pj<?php echo $personaJuridica;?>').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'Debe de completar al menos dos campos para buscar por nombre', placement:'top'});
	$('#dpiPj<?php echo $personaJuridica; ?>').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'El DPI debe de tener 13 dígitos', placement:'top'});
							
	$('#renap_buscar_Show').click(function(){
		$(this).PJbuscarRenap();
	}); //Fin de renap_buscar_Show

	var llamada;
	var dropCall = '<span style="padding-left: 3%; padding-right: 3%;">|</span>'+
					'<button class="btn btn-mini cancelCall" type="button">Cancelar Petición</button>';

	$.fn.PJbuscarRenap = function()
	{
		$('#renap_buscar_Show').focus();
		$('#MensajeAutocomplete').hide(500);

		var error = 0;
		var dpi = $('#dpiPj<?php echo $personaJuridica; ?>').val();
		var primer_nombre = $('#nom1Pj<?php echo $personaJuridica;?>').val();
		var segundo_nombre = $('#nom2Pj<?php echo $personaJuridica;?>').val();
		var primer_apellido = $('#ape1Pj<?php echo $personaJuridica;?>').val();
		var segundo_apellido = $('#ape2Pj<?php echo $personaJuridica;?>').val();
		var pintaCaracteristicas = $('#pintaCaracteristicas').val();
		var pintaContacto = $('#pintaContacto').val();

		if(dpi == '')
		{
			if(primer_nombre=='') error = error+1;
			if(segundo_nombre=='') error = error+1;
			if(primer_apellido=='') error = error+1;
			if(segundo_apellido=='') error = error+1;

			if(error >= 3)
			{
				$('#nom1Pj<?php echo $personaJuridica;?>').popover('show');
				$('#nom1Pj<?php echo $personaJuridica;?>').css('border','1px solid red');
			}
			else
			{
				llamada = $.ajax({
					type: 'POST',
					url: "<?php echo Yii::app()->createUrl('Pjuridica/SelectNombres'); ?>",
					timeout:35000,
					data:
					{	primer_nombre:primer_nombre,
						segundo_nombre:segundo_nombre,
						primer_apellido:primer_apellido, 
						segundo_apellido:segundo_apellido,
						esExtravio:'1'
					},
					beforeSend: function(response)
					{
						$('#Pj_resultado').html('');
						$('#Pj_resultado').show(500);
						//$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
						$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
						$('.cancelCall').click(function(){ llamada.abort(); });
					},
					error: function(xhr, status, error)
					{
						if(status === 'abort'){
							$('#Pj_resultado').hide(500);
							$('#Pj_resultado').html('');
						}
						else{
							$.ajax({
								type:'POST',
								url: "<?php echo Yii::app()->createUrl('Pjuridica/FormResultado'); ?>",
								data:{
									pintaCaracteristicas:pintaCaracteristicas,
									pintaContacto:pintaContacto,

								},
								success:function(response)
								{
									$('#Pj_resultado').html('');
									$('#Pj_resultado').html(response);
								},
							});
						}
					},
					success: function(response)
					{
						$('#Pj_resultado').html('');
						$('#Pj_resultado').html(response);
					},
				});
			}

		}
		else
		{
			if(dpi.length !== 13)
			{
				$('#dpiPj<?php echo $personaJuridica; ?>').popover('show');
				$('#dpiPj<?php echo $personaJuridica; ?>').css('border','1px solid red');				
			}
			else
			{
				llamada = $.ajax({
					type: 'POST',
					url: "<?php echo Yii::app()->createUrl('Pjuridica/FormResultado'); ?>",
					timeout: 35000,
					data:
					{	
						dpi:dpi,
						tipoRender:'dpi',
						pintaCaracteristicas:pintaCaracteristicas,
						pintaContacto:pintaContacto,
						esExtravio:'1'
					},
					beforeSend: function(response)
					{
						$('#Pj_resultado').show(5);
						$('#Pj_resultado').html('');
						$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
						$('.cancelCall').click(function(){ llamada.abort(); });
					},
					error: function(xhr, status, error)
					{
						if(status === 'abort'){
							$('#Pj_resultado').hide(500);
							$('#Pj_resultado').html('');
						}
						else{
							$('#Pj_resultado').html('');
							$('#Pj_resultado').html('<h4>Ha ocurrido un error, por favor realice la consulta nuevamente...</h4>');
						}
					},
					success: function(response)
					{
						$('#Pj_resultado').html('');
						$('#Pj_resultado').html(response);
					},
				});
			}
		}
		

	} //fin de la funcion PJbuscarRenap


	$('#nom1Pj<?php echo $personaJuridica;?>').keypress(function(e) {
	            //32 = KEYPRESS de espacio, 13 KEYPRESS de Enter
	            if(e.which == 32) $('#nom2Pj<?php echo $personaJuridica;?>').focus();
	            if(e.which == 13) $(this).PJbuscarRenap();
	      }); 

	$('#nom2Pj<?php echo $personaJuridica;?>').keypress(function(e) {
            //32 = KEYPRESS de espacio, 13 KEYPRESS de Enter
            if(e.which == 32) $('#ape1Pj<?php echo $personaJuridica;?>').focus();
 			if(e.which == 13) $(this).PJbuscarRenap();
      });
	
	$('#ape1Pj<?php echo $personaJuridica;?>').keypress(function(e) {
	            //32 = KEYPRESS de espacio, 13 KEYPRESS de Enter
	            if(e.which == 32) $('#ape2Pj<?php echo $personaJuridica;?>').focus();
	 			if(e.which == 13) $(this).PJbuscarRenap();
	      });

	$('#ape2Pj<?php echo $personaJuridica;?>').keypress(function(e) {
	            //32 = KEYPRESS de espacio, 13 KEYPRESS de Enter
	            //if(e.which == 32) $('#renap_buscar_btn').focus();
	            if(e.which == 13) $(this).PJbuscarRenap();
	      });

	$('#dpiPj<?php echo $personaJuridica; ?>').keypress(function(e) {
	            //32 = KEYPRESS de espacio, 13 KEYPRESS de Enter
	            if(e.which == 13) $(this).PJbuscarRenap();
	      });

	$('#nom1Pj<?php echo $personaJuridica;?>').focus(function() {
		$('#nom1Pj<?php echo $personaJuridica;?>').popover('hide');
		$('#nom1Pj<?php echo $personaJuridica;?>').removeAttr('style')
	 
	});


	$('#dpiPj<?php echo $personaJuridica; ?>').focus(function() {
		$('#dpiPj<?php echo $personaJuridica; ?>').popover('hide');
		$('#dpiPj<?php echo $personaJuridica; ?>').removeAttr('style');
	 
	});

}); //fin del document.ready

</script>