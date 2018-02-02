<?php 

	$personaJuridica = $_POST['personaJuridica'];
	$pintaCaracteristicas = $_POST['pintaCaracteristicas'];
	$pintaContacto = $_POST['pintaContacto'];
	$idEvento = $_POST['idEvento'];
/*
	$personaJuridica = 5;
	$pintaCaracteristicas = 0;
	$pintaContacto = 1;*/
	#$idEvento = 2;

	$funciones = new Funcionesp;
	$nombrePj = $funciones->getPersonaJuridica($personaJuridica);
	$reportes = new Reportes;
	$denunciante = $reportes->getDenunciante($idEvento);
	//var_dump($denunciante);
	$denunciante = $denunciante['Nombre_Completo'];
	$idDenunciante = $reportes->getIdDenunciante($idEvento);
	//echo $idDenunciante;

?>
<div class="cuerpo">

	<div class="well well-small form-inline" style="display:none;">
	  <label for="personaJuricia" class="campotit" style="margin:5px;">ID Persona Juridica </label>
	  <input type="text" id="personaJuricia" value="<?php echo $personaJuridica; ?>" readonly>
	  <label for="pintaCaracteristicas" class="campotit" style="margin:5px;">Caracteristicas </label>
	  <input type="text" id="pintaCaracteristicas" value="<?php echo $pintaCaracteristicas; ?>" readonly>
	  <label for="pintaContacto" class="campotit" style="margin:5px;">Contacto </label>
	  <input type="text" id="pintaContacto" value="<?php echo $pintaContacto; ?>" readonly>
	</div>

	<legend>Ingreso de Persona Relacionada: <b><?php echo $nombrePj; ?></b></legend>

<label class="checkbox" for="ckUsarDenunciante">
	<input type="checkbox" id="ckUsarDenunciante" checked>
	Deseo Utilizar los datos del denunciante
</label>

<div id="usarDenunciante">
	<div class="alert alert-info">
		Denunciante: <b><?php echo $denunciante; ?></b>
		<input class="input-small" id="idDenunciantePJ" value="<?php echo $idDenunciante; ?>" readonly style="display:none;">
	</div>
	<legend></legend>
	<div align="right">
		<button type="button" class="btn btn-primary" id="usarDenuncianteSave">Guardar persona</button>
	</div>
</div>

	<div id="buscarPersonaJ" style="display:none;">
		<legend class="legend"></legend>
		<div class="row-fluid">
			<div class="form-inline span6" align="left" style="padding:1%; padding-bottom:5px;">
				<label class="checkbox" for="pjCkUseRenap" id="LabelpjCkUseRenap">
			      <input type="checkbox" id="pjCkUseRenap" checked> Buscar con RENAP
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
					<input type="text" id="dpiPj<?php echo $personaJuridica; ?>" class="span12 validaCampoNumerico" placeholder="DPI" maxlength="13">
				</div>
				<div class="span2">
					<div class="span12">
						<div class="pull-right">
							<img src="images/info_icon.png" data-placement="left" id="helpDenunciantePj">
		    			</div>
					</div>
					<center>
						<div class="row-fluid">
							<div class="span2" style="padding-top:4%;">
								<i class="icon-remove-circle" style="cursor: pointer; opacity:.6;" id="cleanValuesPJ"></i>
							</div>
							<div class="span7">
								<!--<button type="submit" class="btn btn-primary span12" id="renap_buscar_btn"><i class="icon-search icon-white"></i> Buscar</button>-->
								<button type="button" class="btn btn-primary span12" id="renap_buscar_Show"><i class="icon-search icon-white"></i> Buscar</button>
							</div>
						</div>
					</center>
				</div>
			</div>
		</div>
		<div id="Pj_resultado"></div>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function()
{
	//$('#label_es_persona').tooltip();
	$('#label_es_asociacion').tooltip();
	$('#LabelpjCkUseRenap').tooltip({title:'Quite la selección para digitar los datos de la persona.'});
	$('#helpDenunciantePj').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> IMPORTANTE</legend><p style="line-height: 175%; text-align: justify;">Puede buscar a las personas por su nombre o DPI.</p>'});
	$('#nom1Pj<?php echo $personaJuridica;?>').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'Debe de completar al menos dos campos para buscar por nombre', placement:'top'});
	$('#dpiPj<?php echo $personaJuridica; ?>').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'El DPI debe de tener 13 dígitos', placement:'top'});
	
	$('#cleanValuesPJ').tooltip({html:true,title:'Limpiar los campos'});

	$('#cleanValuesPJ').click(function(){
		$('#nom1Pj<?php echo $personaJuridica;?>').val('');
		$('#nom2Pj<?php echo $personaJuridica;?>').val('');
		$('#ape1Pj<?php echo $personaJuridica;?>').val('');
		$('#ape2Pj<?php echo $personaJuridica;?>').val('');
		$('#dpiPj<?php echo $personaJuridica; ?>').val('');
	});


	$('#renap_buscar_Show').click(function(){
		$(this).PJbuscarRenap();
	}); //Fin de renap_buscar_Show

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
				$.ajax({
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
						$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
					},
					error: function()
					{
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
				$.ajax({
					type: 'POST',
					url: "<?php echo Yii::app()->createUrl('Pjuridica/FormResultado'); ?>",
					data:
					{	
						dpi:dpi,
						tipoRender:'dpi',
						pintaCaracteristicas:pintaCaracteristicas,
						pintaContacto:pintaContacto
					},
					beforeSend: function(response)
					{
						$('#Pj_resultado').show(5);
						$('#Pj_resultado').html('');
						$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
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

	$("#pjCkUseRenap").live("click", function(){
		var pintaCaracteristicas = $('#pintaCaracteristicas').val();
		var pintaContacto = $('#pintaContacto').val();
        var id = parseInt($(this).val(), 10);
        if($(this).is(":checked")) {
            $('#DivPersonaAsoc').show(500);
			$('#frmSearch').show(500);
			$('#Pj_resultado').hide(500);
			$('#Pj_resultado').html('');
        } 
        else 
        {
            $.ajax({
				type:'POST',
				url: "<?php echo Yii::app()->createUrl('Pjuridica/FormResultado'); ?>",
				data:{tipoRender:'sinRenap',
						pintaCaracteristicas:pintaCaracteristicas,
						pintaContacto:pintaContacto},
				beforeSend: function(response)
				{
					$('#Pj_resultado').show(500);
					$('#Pj_resultado').html('');
					$('#Pj_resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
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
	});


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
			url: "<?php echo Yii::app()->createUrl('Pjuridica/Save_PersonaJuridicaDenun'); ?>",
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

				$('#resultPersonaJ').hide(500);
				$('#usarDenuncianteSave').showListadoPersonas();
				
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

								var identificadores = $('#IdsPersonas').val();
								identificadores = identificadores.replace(id_eliminar,"|");
								identificadores = identificadores.replace(",|,",",");
								identificadores = identificadores.replace("|,","");
								identificadores = identificadores.replace("|","");
								$('#personaDiv'+id_eliminar).remove();

								$('#IdsPersonas').val(identificadores);
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