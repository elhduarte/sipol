

<?php 
	//$value = 4;
	$ConstructorHechos = new ConstructorHechos;
	
	$consumoVehiculos = "";

	if($value == 3)
	{
		$consumoVehiculos = $ConstructorHechos->consumoVehiculos();
		echo $consumoVehiculos;
	}

	$nombreHecho = $ConstructorHechos->nombreObjeto($value); //Obtiene el nombre del hecho de la DB
	$formulario = $ConstructorHechos->getFormObjetos($value); //Obtiene el formulario ya construído de la base de datos
	$form_id = "frmObjeto".$value;
	//echo "acá se construyen los hechos, el id que se está generando es: ".$value." y éste es: ".$nombreHecho;
?>
<!--legend style="margin-top:20px;margin-bottom: 0px;"></legend-->

<form id='<?php echo $form_id; ?>' style="margin-bottom:0px;">
	<legend style="line-height: 60px;"><?php echo $nombreHecho; ?></legend>
	<div id="divObjetoBuil">
		<div class="row-fluid">
			<?php
				echo $formulario;
			?>
		</div>
	</div><!-- Fin del hecho Construído -->

	<div align="right">
		<button type="button" class="btn" id="cancelFrmObjeto">Cancelar</button>
		<button type="submit" class="btn btn-primary"id="submitFrmObjeto">Guardar Objeto</button>
	</div>
</form>

<script type="text/javascript">

$(document).ready(function(){
	

	

	$('#<?php echo $form_id; ?>').submit(function(e){
		e.preventDefault();
		var contenido = new Array();
		var idTipoObjeto = '<?php echo $value; ?>';
		var calificacionObjeto = $('#calificacionObjeto').val();
		var idEvento = $('#identificador_incidencia').val();
		//var idEvento = '2617';
		var tipoAccion = $('#evidenciaTipoAccion').val();
		var idObjeto = $('#idTblObjeto').val();
		var count = 0;

		$('#divObjetoBuil').find(':input').each(function(){
			var typeInput = $(this).attr('type');
			var valor = $(this).val();
			var identificador = $(this).attr('nombre');
			var omiso = $(this).attr('omiso');

			if(typeInput !== 'button'){
				if(!omiso){
					contenido[count] = identificador+'~'+valor;
					count = count + 1;
				}
			}
		}); //Fin del each para el form

		$.ajax({
			type:'POST',
			url:'<?php echo Yii::app()->createUrl("Incidencia/Save_evidencia"); ?>',
			data:{
				contenido:contenido.join('|'),
				idEvento:idEvento,
				idTipoObjeto:idTipoObjeto,
				tipoAccion:tipoAccion,
				idObjeto:idObjeto,
				calificacionObjeto:calificacionObjeto
			},
			beforeSend:function(){
				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
				$('#procesoModal').modal('show'); 
			},
			error:function(e){
				console.log(e);
			},
			success:function(response){
				//$('#procesoModal').modal('hide');
				//alert('listo');
				$('#evidenciaTipoAccion').val('I');
				$('#idTblObjeto').val('empty');
				$('#objeto_incidencia_dw').val('');
    			$('#calificacionObjeto').val('');
    			$('<?php echo $form_id; ?>').mostrarEvidencia(idEvento);
				$('#formResultadoObjetos').html('');
				$('#formResultadoObjetos').hide(500);
				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>El Objeto se ha registrado correctamente</h4></div><div class=\"modal-footer\">'+
						'<button id=\"objetosContinue\" class=\"btn\">Continuar</button>'+
						'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Ingresar Otro Objeto</button></div>');

				$('#aTab8').attr('href','#tab8');
    $('#ili_resumen').attr('class','enabled');
    $('#i_resumen').removeClass('BotonClose'); 

					$('#objetosContinue').click(function(){
						$('#tab6').hide(500);
						$('#tab8').show(500);
						$('#nav_incidencia li:eq(6) a').tab('show');
						$('#procesoModal').modal('hide'); 
					});//Fin de función AgenteContinuar
			}
		});// Fin de la asíncrona

	}); //Fin del submit del form

	$('#cancelFrmObjeto').click(function(){
		$('#formResultadoObjetos').hide(500);
		$('#formResultadoObjetos').html('');
		$('#formResultadoObjetos').show(1);
		/*$('#hechoInsert').val('I');
		$('#idEventoDetalleHecho').val('');
		$('#IdsPersonas').val('');*/

	});

	$.fn.mostrarEvidencia = function(idEvento)

	{
		$.ajax({
			type:'POST',
			url:'<?php echo Yii::app()->createUrl("Incidencia/Mostrar_evidencia"); ?>',
			data: {
				idEvento:idEvento
			},
			error:function(error){
				$('#resumenEvidencias').html('');
				console.log(error);
			},
			beforeSend:function(){
				$('#resumenEvidencias').html('');
				$('#resumenEvidencias').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
			},
			success:function(response){
				$(this).actualizaResumen();
				$('#resumenEvidencias').html('');
				$('#resumenEvidencias').html(response);

				$('.borrarObjeto').live('click',function(e){

					e.preventDefault();
					var idObjetoDelete = $(this).attr('id_objeto');

					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>¿Está seguro que desea eliminar éste Objeto?</h4></div><div class=\"modal-footer\">'+
						'<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button>'+
						'<button id=\"commitDeleteEvidence\" class=\"btn btn-primary\">Confirmar</button>');
					$('#procesoModal').modal('show');

					$('#commitDeleteEvidence').live('click',function(){
						

						$.ajax({
							type:'POST',
							url:'<?php echo Yii::app()->createUrl("Incidencia/Delete_evidencia"); ?>',
							data:{
								idObjetoDelete:idObjetoDelete
							},
							beforeSend:function(){
								$('#result_procesoModal').html('');
								$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición Borrar...</h4>');
							},
							error:function(error){
								$('#result_procesoModal').html('');
								$('#result_procesoModal').html('Ha ocurrido un error, por favor intentelo nuevamente...</h4>');
								console.log(error);
							},
							success:function(response){
								$('#evidenciaDiv'+idObjetoDelete).remove();
							$('#procesoModal').modal('hide');
							var idEvento = $('#identificador_incidencia').val();
							
							$("#procesoModal").actualizaResumen();
							$("#procesoModal").mostrarEvidencia(idEvento);	

												
							//alert(idEvento);
							}
						});// Fin del ajax


					}); //Fin del click confirmar eliminar evidencia
				});// Fin del click que elimina la evidencia







		$(".editarObjeto").click(function(e){
			e.preventDefault();
					
					var idTipoObjeto = $(this).attr('id_tipo_objeto');
					var idCalificacion = $(this).attr('id_calificacion');
					var idObjeto = $(this).attr('id_objeto');
					var frm = '#frmObjeto'+idTipoObjeto;
					$('#objeto_incidencia_dw').val(idTipoObjeto);
					$('#calificacionObjeto').val(idCalificacion);
					$('#form_objeto_incidencia').submit();

					
					$.ajaxq('submitDwEvidencia',{
						type:'POST',
						url:'<?php echo Yii::app()->createUrl("Incidencia/Update_evidencia"); ?>',
						data:{
							idObjeto:idObjeto
						},
						beforeSend:function(){
							$('#evidenciaTipoAccion').val('U');
							$('#idTblObjeto').val(idObjeto);
						},
						error:function(error){
							console.log(error);
						},
						success:function(resultado){
							var campos = $.parseJSON(resultado);
							console.log(campos);

							$(frm).find(':input').each(function(){
								var tipo = $(this).attr('type');
								if(tipo !== 'button' && tipo !=='submit'){
									var id = $(this).attr('id');
									var nombre = $(this).attr('nombre');
									var tipo_objeto = document.getElementById(id).tagName;

									if(tipo_objeto=="INPUT" || tipo_objeto=='TEXTAREA'){
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
									}//fin del else if								
								}
							});// Fin del each al formulario 
							
						}// fin del success del ajaxq
					});//Fin del ajaxq

				});//Fin de la función para editar la evidencia






			


				$(".borrarObjeto").tooltip({html: true, title:"Eliminar éste Objeto", placement:'left'});
				$(".editarObjeto").tooltip({html: true, title:"Editar éste Objeto", placement:'left'});


					

			}//Fin del Success Principal
		});//Fin del ajax principal

	} //Fin de la fn mostrarEvidencia



			



			
});//Fin del document ready

</script>



