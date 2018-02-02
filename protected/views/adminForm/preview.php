<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />

<?php 

	$ConstructorHechos = new ConstructorHechos;
	$consumoVehiculos = "";

	switch ($modelo) {
		case 'CatHechoDenuncia':
			$nombreHecho = $ConstructorHechos->nombreHecho($idTabla);
			$formulario = $ConstructorHechos->obtenerCampos($idTabla);
			$form_id = "frmHecho".$idTabla;
			if($idTabla == 28)
			{
				$consumoVehiculos = $ConstructorHechos->consumoVehiculos();
				echo $consumoVehiculos;
			}

			break;

		case 'CatExtravios':
			$nombreHecho = $ConstructorHechos->nombreHechoExt($idTabla);
			$formulario = $ConstructorHechos->obtenerCamposExt($idTabla);
			$form_id = "frmHecho".$idTabla;
			break;

		case 'CatConsignados':
			$nombreHecho = $ConstructorHechos->nombreHechoCon($idTabla);
			$formulario = $ConstructorHechos->obtenerCamposCon($idTabla);
			$form_id = "frmHecho".$idTabla;
			break;

		case 'CatMotivoConsignados':
			$nombreHecho = $ConstructorHechos->nombreHechoMo($idTabla);
			$formulario = $ConstructorHechos->obtenerCamposMo($idTabla);
			$form_id = "frmHecho".$idTabla;
			break;
		
		case 'CatLugarRemision':
			$nombreHecho = $ConstructorHechos->nombreHechoLu($idTabla);
			$formulario = $ConstructorHechos->obtenerCamposLu($idTabla);
			$form_id = "frmHecho".$idTabla;
			break;
			
	}

?>
<!--legend style="margin-top:20px;margin-bottom: 0px;"></legend-->
<form id='<?php echo $form_id; ?>' style="margin-bottom:0px;">
	<legend style="line-height: 60px;"><?php echo $nombreHecho; ?>
		<div class="form-inline pull-right">
			<div class="row-fluid">
				<div class="span6">
					<label for="fecha_hecho_ob" class="campotit" style="margin-right:10px;">Fecha</label>
					<input class="span8" type="text"  id="fecha_hecho_ob" required>
					<i class="icon-calendar" style="margin: 6px 0 0 -26px; pointer-events: none; position: relative;"></i>
				</div>
				<div class="span6 bootstrap-timepicker">
					<label for="hora_hecho_ob" class="campotit" style="margin-right:10px; margin-left:20px;">Hora</label>
					<!-- <div class="bootstrap-timepicker">-->
						<input id="hora_hecho_ob" type="text" value="" class="bootstrap-timepicker span8" placeholder="Hora del Evento" required>
						<i class="icon-time" style="margin: 6px 0 0 -26px; pointer-events: none; position: relative;"></i>
					<!-- </div> -->
				</div>
			</div>
		</div>
	</legend>
	<div id="hecho_construido">
		<div class="row-fluid">
			<?php
				echo $formulario;
			?>
		</div>
	</div><!-- Fin del hecho Construído -->
	<div id="resultPersonaJ" style="margin-top:3%;" hidden></div>
	<div id="resultPersonaJListado" class="well well-small" style="margin-top:3%; display:none;">acá van las personas listadas</div>
	<legend style="padding-top:1%;"></legend>
	<div class="alert alert-error" id="msgPersona">
		<p><strong>Debes ingresar la informacion de personas!!!.</strong></p>
	</div>
	<div align="right">
		<button type="submit" class="btn btn-primary"id="SubmitFormhechos">Probar</button>
	</div>
	</form>
	<!--<div id="resultPersonaJ" style="margin-top:3%;"></div>
	<div id="resultPersonaJListado" class="well well-small" style="margin-top:3%; display:none;">acá van las personas listadas</div>
	<legend style="padding-top:1%;"></legend>
	<div align="right">
		<button type="button" class="btn" id="cancelar_form">Cancelar</button>
		<button type="button" class="btn btn-primary"id="SubmitFormhechos">Guardar Hecho</button>
	</div>-->


<script type="text/javascript">
$(document).ready(function(){

	$("#msgPersona").hide();
	$('#fecha_hecho_ob').datepicker({
	
		   weekStart: 0,
		    endDate: "setStartDate",
		    format: "dd/mm/yyyy",
		    language: "es",
		    orientation: "top auto",
		    keyboardNavigation: false,
		    forceParse: false,
		    autoclose: true
	});

	//$('#hora_hecho_ob').timepicker();
	  /* $('#hora_hecho_ob').timepicker({
                minuteStep: 1,
                template: 'modal',
                appendWidgetTo: 'body',
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
            });*/

	      $('#hora_hecho_ob').timepicker({
                //minuteStep: 1,
                //secondStep: 5,
                showInputs: false,
                //template: 'modal',
                modalBackdrop: true,
               // showSeconds: true,
                showMeridian: false
            });


		
	$('#cancelar_form').click(function(){
		$('#hecho_formulario').hide(500);
		$('#hecho_formulario').html('');
		$('#hecho_formulario').show(1);
	});

	$('#SubmitFormhechos').click(function()
	{
		//$('#<?php echo $form_id; ?>').submit();
		$("#msgPersona").hide();
	});

	$('#<?php echo $form_id; ?>').submit(function(e){
		e.preventDefault();
		var hecho_construido = new Array();
		var contador = 0;
		var fecha = $('#fecha_hecho_ob').val();
		var hora = $('#hora_hecho_ob').val();
		var id_hecho = '<?php echo $idTabla; ?>';
		var id_denuncia = $('#identificador_denuncia').val();
		var IdsPersonas = $('#IdsPersonas').val();
		var agregaPersonas = 0;
		agregaPersonas = $('.addPersonaJuridica').length;
		var flag = $('#denX').val();
		if(flag=='extension')
		{
			id_denuncia = $('#nuevoIdEvento').val();
		}
		
		$('#hecho_construido').find(':input').each(function(){
			var elemento = this;
			var typeInput = $(elemento).attr('type');
			var valor = $(elemento).val();
			var ideelemento = this.id;
			var ident = $(elemento).attr('nombre');
			if(typeInput == 'button')
			{
				
			}else if(typeInput == undefined)
			{
				valor =   $('#'+ideelemento+ ' option:selected').text();
				hecho_construido[contador]= ident+ '~' +valor;   
	        	contador = contador +1;

			}else{
				hecho_construido[contador]= ident+ '~' +valor;   
	        	contador = contador +1;
			}
		});//Fin del each
		if(($.trim(IdsPersonas) != '' && agregaPersonas >0) ||($.trim(IdsPersonas) == '' && agregaPersonas ==0))
		{
			$.ajax({
				type: 'POST',
				url: '<?php echo Yii::app()->createUrl("Denuncia/Save_hechos"); ?>',
				data: 
				{
					hecho_construido: hecho_construido.join('|'),
					fecha: fecha,
					hora: hora,
					id_hecho: id_hecho,
					id_denuncia: id_denuncia,
					IdsPersonas:IdsPersonas
				},
				beforeSend: function()
				{
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
					$('#procesoModal').modal('show'); 
				},
				success: function(response)
				{
					$('#hecho_formulario').html('');
					$('#detX').val('1');
					$('#IdsPersonas').val('');
					$('#<?php echo $form_id; ?>').actualizaResumen();
					$('#<?php echo $form_id; ?>').MostrarHechos(id_denuncia);
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
							'<h4>El Hecho se ha registrado Correctamente</h4></div><div class=\"modal-footer\">'+
							'<button id=\"otroHecho\" class=\"btn\">Continuar</button>'+
							'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Ingresar Otro Hecho</button></div>'
							);

				$('#aTab4').attr('href','#tab4');
				$('#dli_relato').attr('class','enabled');
				$('#i_relato').removeClass('BotonClose'); 

					$('#otroHecho').click(function(){
							//$('#aTab4').attr('href','#tab4');
							//$('#liTab4').attr('class','enabled'); 
						$('#tab3').hide(50);
						$('#tab4').show(50);
						$('#nav_denuncia li:eq(3) a').tab('show');
						$('#procesoModal').modal('hide'); 
					});//Fin de la función otroHecho
				},
			});//fin del ajax
		}//valida si hay personas agregadas
		else
		{
			$("#msgPersona").show();
		}
	});// fin del submit del form

	$.fn.MostrarHechos = function(valor)
	{
		//alert(valor);
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("Denuncia/Mostrar_hechos"); ?>',
			data: {id_evento:valor,},
			success: function(divs)
			{
				$('#hechos_resumen_well').show(500);
				$('#hechos_resumen').html('');
				$('#hechos_resumen').html(divs);

				$(".eliminar_hecho").click(function(){
					var id_eliminar = $(this).attr('id_evento_detalle');
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>¿Está seguro que desea eliminar éste hecho?</h4></div><div class=\"modal-footer\">'+
						'<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button>'+
						'<button id=\"confirmaEliminar\" class=\"btn btn-primary\" id_eliminar=\"'+id_eliminar+'\">Confirmar</button>'
						);
					$('#procesoModal').modal('show');

					$('#confirmaEliminar').click(function(){
						var id_eliminar = $(this).attr('id_eliminar');
						$.ajax({
						type:'POST',
						url:'<?php echo Yii::app()->createUrl("Denuncia/Eliminar_hecho"); ?>',
						data:{id_eliminar: id_eliminar,},
						beforeSend: function()
						{
							$('#result_procesoModal').html('');
							$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');

						},
						success:function()
						{
							$('#procesoModal').modal('hide');
							$('#procesoModal').actualizaResumen();
							//$('#result_procesoModal').html('');
							//$('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Hecho se eliminó correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
						},
						});
					});
				});//click de función de eliminar el hecho
				$(".eliminar_hecho").tooltip({title:"Eliminar éste Hecho"});
			},//fin del success
		});//fin del ajax
	}//fin de la función MostrarHechos

	$('.addPersonaJuridica').click(function(){
		var personaJ = $(this).attr('personaJ');
		var pcontact = $(this).attr('pcontact');
		var pcaract = $(this).attr('pcaract');
		var idEvento = $('#identificador_denuncia').val();
		//alert('Estás en la clase de addPersonaJuridica '+personaJ);

		$.ajax({
			type:'POST',
			url:'<?php echo Yii::app()->createUrl("Pjuridica/AddPerson"); ?>',
			data:
			{
				personaJuridica: personaJ,
				pintaCaracteristicas: pcontact,
				pintaContacto: pcaract,
				idEvento:idEvento
			},
			error:function()
			{
				$('#resultPersonaJ').html('');
				$('#resultPersonaJ').html('<h4>Ha ocurrido un error, su solicitud no puede ser procesada</h4>');
			},
			beforeSend:function()
			{
				$('#resultPersonaJ').html('');
				$('#resultPersonaJ').show(500);
				$('#resultPersonaJ').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			success:function(resultado)
			{
				$('#resultPersonaJ').html('');
				$('#resultPersonaJ').html(resultado);
			}
		});
	});	//Fin clase addPersonaJuridica

}); //Fin del document Ready
</script>
