<?php 

	$personaJuridica = $_POST['personaJuridica'];
	$pintaCaracteristicas = $_POST['pintaCaracteristicas'];
	$pintaContacto = $_POST['pintaContacto'];
	$yoSoy = "empty";
	$estadoFisico = "empty";
	if(isset($_POST['yoSoy'])) $yoSoy = $_POST['yoSoy'];
	if(isset($_POST['estadoFisico'])) $estadoFisico = $_POST['estadoFisico'];
	//$idEvento = $_POST['idEvento'];

/*
	$personaJuridica = 5;
	$pintaCaracteristicas = 1;
	$pintaContacto = 1;
	$idEvento = 2;*/
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
<!--div style="background-color: rgb(250, 250, 250);" class="well well-small"-->

	<div class="well well-small form-inline" style="display:none;">
	  <label for="personaJuricia" class="campotit" style="margin:5px;">ID Persona Juridica </label>
	  <input type="text" id="personaJuricia" value="<?php echo $personaJuridica; ?>" readonly class="input-mini">
	  <label for="pintaCaracteristicas" class="campotit" style="margin:5px;">Caracteristicas </label>
	  <input type="text" id="pintaCaracteristicas" value="<?php echo $pintaCaracteristicas; ?>" readonly class="input-mini">
	  <label for="pintaContacto" class="campotit" style="margin:5px;">Contacto </label>
	  <input type="text" id="pintaContacto" value="<?php echo $pintaContacto; ?>" readonly class="input-mini">
	  <label for="yoSoy" class="campotit" style="margin:5px;">Quien Soy: </label>
	  <input type="text" id="yoSoy" value="<?php echo $yoSoy; ?>" readonly class="input-mini">
	  <label for="estadoFisico" class="campotit" style="margin:5px;">Estado Físico: </label>
	  <input type="text" id="estadoFisico" value="<?php echo $estadoFisico; ?>" readonly class="input-mini">
	</div>
	
	<div id="buscarPersonaJ">

		<div class="row-fluid">
			<div class="form-inline span6" align="left" style="padding:1%; padding-bottom:5px;">
				<label class="checkbox" for="ckUserenap" id="LabelckUserenap">
			      <input type="checkbox" id="ckUserenap" checked> Buscar con RENAP
			    </label>
			    <label class="checkbox" for="chkSinId" id="LabelckUserenap">
			      <input type="checkbox" id="chkSinId" style="margin-left: 30px;"> Sin Identificación
			    </label>
			</div>	
		</div>

		<div class="well" id="frmSearch">
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

				<div class="span2" style="padding-left:1%; padding-right:1%; border-right: 1px solid rgb(227, 227, 227); border-left: 1px solid rgb(227, 227, 227);">
					<div class="span12"><p class="campotit">DPI</p></div>
					<input type="text" id="dpiPj<?php echo $personaJuridica; ?>" class="span12" placeholder="DPI">
				</div>
				<div class="span2">
					<div class="span12">
						<div class="pull-right">
							<img src="images/info_icon.png" data-placement="left" id="ayuda_denunciante">
		    			</div>
					</div>
					<!--center>
						<button type="button" class="btn btn-primary span10" id="renap_buscar_Show">
							<i class="icon-search icon-white"></i> Buscar
						</button>
					</center-->
					<center>
						<div class="row-fluid">
							<div class="span2" style="padding-top:4%;">
								<i class="icon-remove-circle" style="cursor: pointer; opacity:.6;" id="limpiarCampos"></i>
							</div>
							<div class="span7">
								<button type="submit" class="btn btn-primary span12 searchPersonaBtn" id="renap_buscar_Show">
									<i class="icon-search icon-white"></i> Buscar
								</button>
							</div>
							
						</div>
						<!-- a href="#">limpiar datos</a-->
					</center>

				</div>
			</div>
		</div>
		<div id="Pj_resultado"></div>
	</div>
<!--/div-->

<script type="text/javascript">

$(document).ready(function()
{
	//$('#label_es_persona').tooltip();
	$('#label_es_asociacion').tooltip();
	$('#LabelckUserenap').tooltip({title:'Quite la selección para digitar los datos de la persona.'});
	$('#ayuda_denunciante').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> IMPORTANTE</legend><p style="line-height: 175%; text-align: justify;">Puede buscar a las personas por su nombre o DPI.</p>'});
	$('#nom1Pj<?php echo $personaJuridica;?>').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'Debe de completar al menos dos campos para buscar por nombre', placement:'top'});
	$('#dpiPj<?php echo $personaJuridica; ?>').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'El DPI debe de tener 13 dígitos', placement:'top'});
	var calltorenap;
	var dropCall = '<span style="padding-left: 3%; padding-right: 3%;">|</span>'+
					'<button class="btn btn-mini cancelCall" type="button">Cancelar Petición</button>';			

	$('#renap_buscar_Show').click(function(){
		$(this).PJbuscarRenap();
	}); //Fin de renap_buscar_Show

	$('#limpiarCampos').tooltip({html:true,title:'Limpiar los campos'});

	$('#limpiarCampos').click(function(){
		$('#nom1Pj<?php echo $personaJuridica;?>').val('');
		$('#nom2Pj<?php echo $personaJuridica;?>').val('');
		$('#ape1Pj<?php echo $personaJuridica;?>').val('');
		$('#ape2Pj<?php echo $personaJuridica;?>').val('');
		$('#dpiPj<?php echo $personaJuridica; ?>').val('');
	});


	$.fn.PJbuscarRenap = function()
	{
		$('#renap_buscar_Show').focus();

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
				calltorenap = $.ajax({
					type: 'POST',
					url: "<?php echo Yii::app()->createUrl('Pjuridica/SelectNombres'); ?>",
					timeout:30000,
					data:
					{	primer_nombre:primer_nombre,
						segundo_nombre:segundo_nombre,
						primer_apellido:primer_apellido, 
						segundo_apellido:segundo_apellido,
					},
					beforeSend: function(response)
					{
						$('#Pj_resultado').html('');
						$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
						$('.cancelCall').click(function(){ calltorenap.abort(); });
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
									pintaContacto:pintaContacto
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
				calltorenap = $.ajax({
					type: 'POST',
					url: "<?php echo Yii::app()->createUrl('Pjuridica/FormResultado'); ?>",
					data:
					{	
						dpi:dpi,
						tipoRender:'dpi',
						pintaCaracteristicas:pintaCaracteristicas,
						pintaContacto:pintaContacto
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
					beforeSend: function(response)
					{
						$('#Pj_resultado').show(5);
						$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
						$('.cancelCall').click(function(){ calltorenap.abort(); });
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

	$("#ckUserenap").live("click", function(){
		var pintaCaracteristicas = $('#pintaCaracteristicas').val();
		var pintaContacto = $('#pintaContacto').val();
        var id = parseInt($(this).val(), 10);
        if($(this).is(":checked")) {
            $('#DivPersonaAsoc').show(500);
			$('#frmSearch').show(500);
			$('#Pj_resultado').hide(500);
			$('#Pj_resultado').html('');
			$('#Pj_resultado').show(500);
        } 
        else 
        {
            calltorenap = $.ajax({
				type:'POST',
				url: "<?php echo Yii::app()->createUrl('Pjuridica/FormResultado'); ?>",
				data:{tipoRender:'sinRenap',
						pintaCaracteristicas:pintaCaracteristicas,
						pintaContacto:pintaContacto},
				beforeSend: function(response)
				{
					$('#Pj_resultado').show(500);
					$('#Pj_resultado').html('');
					$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
					$('.cancelCall').click(function(){ calltorenap.abort(); });
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
				success:function(response)
				{
					$('#DivPersonaAsoc').hide(500);
					$('#frmSearch').hide(500);
					$('#Pj_resultado').show(500);
					//$('#Pj_resultado').html('');
					$('#Pj_resultado').html(response);

				},
			});
        }
	}); // click en ckUserenap

	$("#chkSinId").live("click", function(){
		var pintaCaracteristicas = '1';
		var pintaContacto = '0';

        if($(this).is(":checked")) {

            calltorenap = $.ajax({
				type:'POST',
				url: "<?php echo Yii::app()->createUrl('Pjuridica/FormResultado'); ?>",
				data:{tipoRender:'sinIdentificacion',
						pintaCaracteristicas:pintaCaracteristicas,
						pintaContacto:pintaContacto},
				beforeSend: function(response)
				{
					$('#Pj_resultado').show(500);
					$('#Pj_resultado').html('');
					$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
					$('.cancelCall').click(function(){ calltorenap.abort(); });
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
				success:function(response)
				{
					$('#DivPersonaAsoc').hide(500);
					$('#frmSearch').hide(500);
					$('#Pj_resultado').show(500);
					//$('#Pj_resultado').html('');
					$('#Pj_resultado').html(response);
					$('#ckUserenap').attr('disabled', 'true');

				},
			});
        } 
        else 
        {
            $('#DivPersonaAsoc').show(500);
			$('#frmSearch').show(500);
			$('#Pj_resultado').hide(500);
			$('#Pj_resultado').html('');
			$('#Pj_resultado').show(500);
			$('#ckUserenap').removeAttr('disabled');
        }
	}); // click en chkSinId


	$("#ckUsarDenunciante").live("click", function(){
        if($(this).is(":checked")) 
        {
            $('#usarDenunciante').show(500);
			$('#buscarPersonaJ').hide(500);
        } 
        else 
        {
			$('#usarDenunciante').hide(500);
			$('#buscarPersonaJ').show(500);
        }
    }); //fin function click ckUsarDenunciante

    $('#usarDenuncianteSave').click(function(){
		var idDenunciante = $('#idDenunciantePJ').val();
		var calidadJuridica = $('#personaJuricia').val();
		//alert(idDenunciante+' '+calidadJuridica);

		$.ajax({
			type:'POST',
			url: "<?php echo Yii::app()->createUrl('Pjuridica/Save_PersonaJuridica'); ?>",
			data:
			{
				idDenunciante:idDenunciante,
				calidadJuridica:calidadJuridica
			},
			success:function(respuesta)
			{
		
				var IdsPersonas = $('#IdsPersonas').val();
				
				if(IdsPersonas == '')
				{
					$('#IdsPersonas').val(respuesta);
				}
				else
				{
					$('#IdsPersonas').val(IdsPersonas+","+respuesta);
				}
				//alert('saved');
				$('#resultPersonaJ').hide(500);
				$('#usarDenuncianteSave').showListadoPersonas();
				$('#usarDenuncianteSave').actualizaResumen();
				
			},
		});

    });//Fin de la función usarDenuncianteSave

    $.fn.showListadoPersonas = function()
	{
		var IdsPersonas = $('#IdsPersonas').val();
		
			if(IdsPersonas !== '')
			{
				$.ajax({
					type:'POST',
					url: "<?php echo Yii::app()->createUrl('Pjuridica/ListPersonaJuridica'); ?>",
					data:
					{
						IdsPersonas:IdsPersonas
					},
					success:function(resultado)
					{
						$('#resultPersonaJ').html('');
						$('#resultPersonaJ').show(1);
						$('#resultPersonaJListado').html('');
						$('#resultPersonaJListado').html(resultado);
						$('#resultPersonaJListado').show(500);
					

					$(".eliminar_persona").click(function(){
						var id_eliminar = $(this).attr('id_persona_detalle');
						$('#result_procesoModal').html('');
						$('#result_procesoModal').html('<div class=\"modal-body\">'+
							'<h4>¿Está seguro que desea eliminar ésta Persona?</h4></div><div class=\"modal-footer\">'+
							'<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button>'+
							'<button id=\"confirmaEliminar\" class=\"btn btn-primary\" id_eliminar=\"'+id_eliminar+'\">Confirmar</button>'
							);
						$('#procesoModal').modal('show');

						$('#confirmaEliminar').click(function(){
							var id_eliminar = $(this).attr('id_eliminar');
							$.ajax({
							type:'POST',
							url:'<?php echo Yii::app()->createUrl("Pjuridica/DeletePersona"); ?>',
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

								var identificadores = $('#IdsPersonas').val();
								identificadores = identificadores.replace(id_eliminar,"|");
								$('#IdsPersonas').val(identificadores);
								identificadores = identificadores.replace(",|,",",");
								$('#IdsPersonas').val(identificadores);
								identificadores = identificadores.replace("|,","");

								$('#IdsPersonas').val(identificadores);

								var mY = $('#IdsPersonas').val();

								if(mY == '|')
								{
									$('#IdsPersonas').val('');
								}
								//$('#result_procesoModal').html('');
								//$('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Hecho se eliminó correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
							},
							});
						});
					});//click de función de eliminar el hecho
					$(".eliminar_persona").tooltip({title:"Eliminar ésta Persona"});



					},//fin del success

				});
			}
	}//fin de la funcion showListadoPersonas

	$.fn.showListadoPersonasDos = function()
	{
		var IdsPersonas = $('#IdsPersonasApart').val();
		
			if(IdsPersonas !== '')
			{
				$.ajax({
					type:'POST',
					url: "<?php echo Yii::app()->createUrl('Pjuridica/ListPersonaJuridica'); ?>",
					data:
					{
						IdsPersonas:IdsPersonas
					},
					success:function(resultado)
					{
						$('#personasAddDiv').html('');
						$('#personasAddDiv').show(1);
						
						$('#personasRelacionadasIncidenciaList').html('');
						$('#personasRelacionadasIncidenciaList').html(resultado);
						$('#personasRelacionadasIncidenciaList').show(500);
					

					$(".eliminar_persona").click(function(){
						var id_eliminar = $(this).attr('id_persona_detalle');
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
							url:'<?php echo Yii::app()->createUrl("Pjuridica/DeletePersona"); ?>',
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

								var identificadores = $('#IdsPersonasApart').val();
								identificadores = identificadores.replace(id_eliminar,"|");
								$('#IdsPersonasApart').val(identificadores);
								identificadores = identificadores.replace(",|,",",");
								$('#IdsPersonasApart').val(identificadores);
								identificadores = identificadores.replace("|,","");

								$('#IdsPersonasApart').val(identificadores);

								var mY = $('#IdsPersonasApart').val();

								if(mY == '|')
								{
									$('#IdsPersonasApart').val('');
								}

								$('#personaDiv'+id_eliminar).remove();
								//$('#result_procesoModal').html('');
								//$('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Hecho se eliminó correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
							},
							});
						});
					});//click de función de eliminar el hecho
					$(".eliminar_persona").tooltip({title:"Eliminar ésta Persona"});



					},//fin del success

				});
			}
	}//fin de la funcion showListadoPersonas

}); //fin del document.ready

</script>