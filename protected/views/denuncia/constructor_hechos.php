<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />

<?php 
	//$value = 4;
	$value = $_POST['hechos_dw'];
	$ConstructorHechos = new ConstructorHechos;
	
	$consumoVehiculos = "";

	if($value == 25)
	{
		$consumoVehiculos = $ConstructorHechos->consumoVehiculos();
		echo $consumoVehiculos;
	}
	if($value == 22)
	{
		$consumoVehiculos = $ConstructorHechos->consumoVehiculos();
		echo $consumoVehiculos;
	}

	$nombreHecho = $ConstructorHechos->nombreHecho($value); //Obtiene el nombre del hecho de la DB
	$formulario = $ConstructorHechos->obtenerCampos($value); //Obtiene el formulario ya construído de la base de datos
	$form_id = "frmHecho".$value;
	//echo "acá se construyen los hechos, el id que se está generando es: ".$value." y éste es: ".$nombreHecho;
?>
<!--legend style="margin-top:20px;margin-bottom: 0px;"></legend-->
<form id='<?php echo $form_id; ?>' style="margin-bottom:0px;">
	<legend style="line-height: 60px;"><?php echo $nombreHecho; ?>
		<div class="form-inline pull-right">
			<div class="row-fluid">
				<div class="span6">
					<label for="fecha_hecho_ob" class="campotit" style="margin-right:10px;">Fecha</label>
					<input class="span8" type="text"  id="fecha_hecho_ob" nombre='fecha_evento' required>
					<i class="icon-calendar" style="margin: 6px 0 0 -26px; pointer-events: none; position: relative;"></i>
				</div>
				<div class="span6 bootstrap-timepicker">
					<label for="hora_hecho_ob" class="campotit" style="margin-right:10px; margin-left:20px;"value>Hora</label>
					<!-- <div class="bootstrap-timepicker">-->
						<input id="hora_hecho_ob" type="text" value="" class="bootstrap-timepicker span8" placeholder="Hora del Evento" nombre='hora_evento' required>
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
		<p style="margin-bottom:0px;"><strong>Debe de ingresar información de persona...</strong></p>
	</div>
	<div align="right">
		<button type="button" class="btn" id="cancelar_form">Cancelar</button>
		<button type="submit" class="btn btn-primary"id="SubmitFormhechos">Guardar Hecho</button>
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


$('#fecha_hecho_ob').tooltip({title:'Fecha Que Ocurrio El Hecho'});
$('#hora_hecho_ob').tooltip({title:'Hora Que Ocurrio El Hecho'});
//$('#cmb_depto').tooltip({title:'Seleccione Un Departamento'});
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
		$('#hechoInsert').val('I');
		$('#idEventoDetalleHecho').val('');
		$('#IdsPersonas').val('');

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
		var hechoInsert = $('#hechoInsert').val();
		var idEventoDetalleHecho = $('#idEventoDetalleHecho').val();
		var fecha = $('#fecha_hecho_ob').val();
		var hora = $('#hora_hecho_ob').val();
		var id_hecho = '<?php echo $value; ?>';
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
			var omiso = $(elemento).attr('omiso');

			if(typeInput !== 'button')
			{
				if(!omiso){
					hecho_construido[contador]= ident+ '~' +valor;   
	        		contador = contador +1;
				}
			}

		});//Fin del each
		//console.log(hecho_construido);
/*
		if(($.trim(IdsPersonas) != '' && agregaPersonas >0) ||($.trim(IdsPersonas) == '' && agregaPersonas ==0))
		{*/
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
					IdsPersonas:IdsPersonas,
					hechoInsert:hechoInsert,
					idEventoDetalleHecho:idEventoDetalleHecho

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
					$('#hechoInsert').val('I');
					$('#idEventoDetalleHecho').val('');
					$('#<?php echo $form_id; ?>').actualizaResumen();
					$('#<?php echo $form_id; ?>').MostrarHechos(id_denuncia);
					$('#hecho_prin').hide(500);
					$('#divAddOtroHecho').show(500);
					$('#hechos_dw').val('');
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
							'<h4>El Hecho se ha registrado Correctamente</h4></div><div class=\"modal-footer\">'+
							'<button id=\"otroHecho\" class=\"btn\">Continuar</button>'/*+
							'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Ingresar Otro Hecho</button></div>'*/
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
		/*}//valida si hay personas agregadas
		else
		{
			$("#msgPersona").show();
		}*/
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
						var id_evento = valor;
						$.ajax({
							type:'POST',
							url:'<?php echo Yii::app()->createUrl("Denuncia/Eliminar_hecho"); ?>',
							data:{
								id_eliminar: id_eliminar,
								id_evento:id_evento
							},
							beforeSend: function()
							{
								$('#result_procesoModal').html('');
								$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');

							},
							success:function(response)
							{
								$('#hechoDiv'+id_eliminar).remove();
								//console.log(response);
								if(response == 'empty'){
									$('#detX').val('0');
								}
								$('#procesoModal').modal('hide');
								$('#procesoModal').actualizaResumen();
							},
						});
					});
				});//click de función de eliminar el hecho
				$(".eliminar_hecho").tooltip({html: true, title:"Eliminar éste Hecho", placement:'left'});

				$('.editFact').click(function(){
					var idEventoDetalle = $(this).attr('id_evento_detalle');
					var idHecho = $(this).attr('id_hecho');
					var formulario = '#frmHecho'+idHecho;
					$('#hechos_dw').val(idHecho);
					$('#form_select_hecho').submit();
										
					$.ajaxq('actionSubmit',{
						type:'POST',
						url: '<?php echo Yii::app()->createUrl("Denuncia/Update_hecho"); ?>',
						data:{
							idEventoDetalle:idEventoDetalle
						},
						beforeSend:function(){
							$('#hechoInsert').val('U');
							$('#idEventoDetalleHecho').val(idEventoDetalle);
						},
						success:function(resultado){
							var campos = $.parseJSON(resultado);
							console.log(campos);
							
							$(formulario).find(':input').each(function(){
								var tipo = $(this).attr('type');
								if(tipo !== 'button' && tipo !=='submit'){
									var id = $(this).attr('id');
									var nombre = $(this).attr('nombre');
									var tipo_objeto = document.getElementById(id).tagName;
									if(tipo_objeto=="INPUT"){
										$(this).val(campos[nombre]);
									}
									else if(tipo_objeto=="SELECT"){
										var idSelect = $(this).attr('id');
										var flag = '0';
										$('#'+idSelect+' option').each(function(){
											var valor = $(this).val();
											if(valor == campos[nombre]){
												$('#'+idSelect).val(campos[nombre]);
												flag = '1';
											}
										}); // Fin del each
										if(flag == '0')	$("#"+id).append('<option value="'+campos[nombre]+'" selected >'+campos[nombre]+'</option>');
									}//fin del if								
								}
							});// Fin del each al formulario 
						}
					});


					$.ajaxq('actionSubmit',{
						type:'POST',
						url:'<?php echo Yii::app()->createUrl("Denuncia/Get_personas"); ?>',
						data:{
							idEventoDetalle:idEventoDetalle
						},
						success:function(response){
							if(response!=='empty'){
								$('#IdsPersonas').val(response);
								$(this).showListadoPersonas();
							}
						}
					}); //Fin de la función que añade personas
				}); //editFact FIN
				$(".editFact").tooltip({html: true, title:"Modificar la Información de éste Hecho", placement:'left'});
			},//fin del success
		});//fin del ajax
	}//fin de la función MostrarHechos

	$('.addPersonaJuridica').click(function(){
		$('#msgPersona').hide();
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

	$('.withchilds').change(function(){
			var id = this.id;
			var hijos = $('#'+id+' option:selected').attr('hijos');
			var idChild = id+'Child';
			var esRequerido = $('#'+id+' option:selected').attr('esrequerido');
			var nombreCampo = $('#'+id+' option:selected').attr('nombreCampo');
			var opcionotros = $('#'+id+' option:selected').attr('opcionotros');
			if(hijos == "true")
			{
				//('#'+id+'Child').remove();

				var atributos = $('#'+id+' option:selected').attr('mychilds');

				$.ajax({
					type:'POST',
					url:'<?php echo Yii::app()->createUrl("Incidencia/Build_childs"); ?>',
					data:{
						atributos:atributos,
						idChild:idChild,
						esRequerido:esRequerido,
						nombreCampo:nombreCampo,
						opcionotros:opcionotros
					},
					beforeSend:function(){
						$('#divSelChild').html('');
					},
					error:function(error){
						$('#divSelChild').html('');
						console.log(error);
					},
					success:function(selectChild){
						$('#divSelChild'+id).html(selectChild);
						//$('#elNuevo').html('');
						//$('#elNuevo').html(response);

						$('.opcionotros').change(function(){
						//alert('la clase');
							var value = $(this).val();
							var identificador = $(this).attr('id');
							var nombre = $(this).attr('nombre');
							var input = '<input type="text" class="span12" placeholder="Ingrese el dato" id="input'+identificador+'" opcion_otros="option_otros" nombre="'+nombre+'">';
							console.log(input);
							console.log(value);
							if(value == 'OTROS'){
								$(this).attr('omiso','true');
								$('#'+identificador).after(input);
							}
							else
							{
								$(this).removeAttr('omiso');
								$('#input'+identificador).remove();
							}
						});// Fin de la opción otros
					}
				});
			}
			else
			{
				$('#'+id+'Child').remove();	
			}
			//console.log(hijos);
					//obtener propiedades html lester gudiel
					/*var nuevo =  $(this).prop("selectedIndex");
					console.log($(this));
					var propiedades  = $(this).context[nuevo];
					var estado = propiedades.attributes[1].nodeValue;
					//console.log(propiedades.attributes[1].nodeValue);
					if(estado == "true")
					{
					alert('Quien es tu padre.');
					}*/
		});

		$('.opcionotros').change(function(){
						//alert('la clase');
							var value = $(this).val();
							var identificador = $(this).attr('id');
							var nombre = $(this).attr('nombre');
							var input = '<input type="text" class="span12" placeholder="Ingrese el dato" id="input'+identificador+'" opcion_otros="option_otros" nombre="'+nombre+'">';
							console.log(input);
							console.log(value);
							if(value == 'OTROS'){
								$(this).attr('omiso','true');
								$('#'+identificador).after(input);
							}
							else
							{
								$(this).removeAttr('omiso');
								$('#input'+identificador).remove();
							}
						});// Fin de la opción otros

}); //Fin del document Ready
</script>
