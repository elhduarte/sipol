<div class="row-fluid">
	<div class="form-inline span6" align="left" style="padding:1%; padding-bottom:5px;">
		<label class="checkbox" for="ckUserenap" id="LabelckUserenap">
	      <input type="checkbox" id="ckUserenap" checked> Buscar con RENAP
	    </label>
	</div>
	<div class="form-inline span6" style="padding:1%; padding-bottom:5px;" align="right" id="DivPersonaAsoc">
		<label class="radio" id="label_es_persona"  data-toggle="tooltip" title="Seleccione si el denunciante es una persona">
			<input id="es_persona" type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
		Persona
		</label>
		<label class="radio"  style ="padding-left:20px;" id="label_es_asociacion"  data-toggle="tooltip" title="Seleccione si el denunciante es una empresa, asociación o entidad">
			<input id="es_asociacion" type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
		Asociación
		</label>
	</div>
</div>

<form id="select_renap" action='<?php echo Yii::app()->createUrl('Denuncia/Procesa_renap'); ?>'>
	<div class="well">
		<div id="datos_asociacion" style="display:none;">
			<legend style="font-size:14px;"><span class="campotit2">Datos de la Empresa / Entidad / Asociación</span></legend>
			<div class="row-fluid">
				<div class="span3">
					<div class="span12"><p class="campotit">Razón Social</p></div>
					<input type="text" id="asoc_rSocial" class="span12" placeholder="Razón Social">
				</div>
				<div class="span3">
					<div class="span12"><p class="campotit">Nombre Comercial</p></div>
					<input type="text" id="asoc_nComercial" class="span12" placeholder="Nombre Comercial">
				</div>
				<div class="span3">
					<div class="span12"><p class="campotit">Dirección</p></div>
					<input type="text" id="asoc_dir" class="span12" placeholder="Dirección">
				</div>
				<div class="span3">
					<div class="span12"><p class="campotit">Teléfono</p></div>
					<input type="text" id="asoc_tel" class="span12" placeholder="Teléfono">
				</div>
			</div>
			<legend style="font-size:14px; padding-top:25px;"><span class="campotit2">Datos del Representante Legal</span></legend>
		</div>
		<div class="row-fluid">
			<div class="span2">
				<div class="span12"><p class="campotit">Primer Nombre</p></div>
				<input type="text" id="renap_nombre1" class="span12" placeholder="Primer Nombre">
			</div>
			<div class="span2">
				<div class="span12"><p class="campotit">Segundo Nombre</p></div>
				<input type="text" id="renap_nombre2" class="span12" placeholder="Segundo Nombre">
			</div>
			<div class="span2">
				<div class="span12"><p class="campotit">Primer Apellido</p></div>
				<input type="text" id="renap_apellido1" class="span12" placeholder="Primer Apellido">
			</div>
			<div class="span2">
				<div class="span12"><p class="campotit">Segundo Apellido</p></div>
				<input type="text" id="renap_apellido2" class="span12" placeholder="Segundo Apellido">
			</div>

			<div class="span2" style="padding-left:1%; padding-right:1%; border-right: 1px solid rgb(227, 227, 227); border-left: 1px solid rgb(227, 227, 227);">
				<div class="span12"><p class="campotit">DPI</p></div>
				<input type="text" id="renap_dpi" class="span12 validaCampoNumerico" placeholder="DPI" maxlength="13">
			</div>
			<div class="span2">
				<div class="span12">
					<div class="pull-right">
						<img src="images/info_icon.png" data-placement="left" id="ayuda_denunciante">
	    			</div>
				</div>
				<center>
					<div class="row-fluid">
						<div class="span2" style="padding-top:4%;">
							<i class="icon-remove-circle" style="cursor: pointer; opacity:.6;" id="limpiarCampos"></i>
						</div>
						<div class="span7">
							<button type="submit" class="btn btn-primary span12 searchPersonaBtn" id="renap_buscar_btn">
								<i class="icon-search icon-white"></i> Buscar
							</button>
						</div>
						
					</div>
					<!-- a href="#">limpiar datos</a-->
				</center>
			</div>
		</div>
		<div class="alert alert-info" style="margin-bottom: 0px; margin-top:5px;">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<b>¡Importante! </b>Buscar por DPI devuelve resultados de manera más precisa y con mayor rapidez. 
		</div>
	</div>
</form>

<div id="resultado_renap"></div>

<script type="text/javascript">

$(document).ready(function()
{
	$('#label_es_asociacion').tooltip();
	$('#renap_nombre1').tooltip({title:'Ingrese El Primer Nombre Del Denunciante.'});
	$('#renap_nombre2').tooltip({title:'Ingrese El Segundo Nombre Del Denunciante.'});
	$('#renap_apellido1').tooltip({title:'Ingrese El Primer Apellido Del Denunciante.'});
	$('#renap_apellido2').tooltip({title:'Ingrese El Segundo Apellido Del Denunciante.'});
	$('#renap_dpi').tooltip({title:'Ingrese El DPI Del Denunciante.'});

	$('#LabelckUserenap').tooltip({title:'Quite la selección para digitar los datos de la persona.'});
	$('#ayuda_denunciante').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> IMPORTANTE</legend><p style="line-height: 175%; text-align: justify;">Puede buscar a las personas por su nombre o DPI.</p>'});
	$('#renap_nombre1').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'Debe de completar al menos dos campos para buscar por nombre', placement:'top'});
	$('#renap_dpi').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'El DPI debe de tener 13 dígitos', placement:'top'});
	var llamada;
	var dropCall = '<span style="padding-left: 3%; padding-right: 3%;">|</span>'+
					'<button class="btn btn-mini cancelCall" type="button">Cancelar Petición</button>';			

	$("#es_persona").live("click", function(){
	        var id = parseInt($(this).val(), 10);
	        if($(this).is(":checked")) {
	            $('#datos_asociacion').hide(500);
	           	$('#asoc_rSocial').removeAttr('required');
	            $('#asoc_dir').removeAttr('required');
	            $('#asoc_tel').removeAttr('required');
	        }
	});

	$('#limpiarCampos').tooltip({html:true,title:'Limpiar los campos'});

	$('#limpiarCampos').click(function(){
		$('#renap_nombre1').val('');
		$('#renap_nombre2').val('');
		$('#renap_apellido1').val('');
		$('#renap_apellido2').val('');
		$('#renap_dpi').val('');
	});

	$("#es_asociacion").live("click", function(){
	        var id = parseInt($(this).val(), 10);
	        if($(this).is(":checked")) {
	            $('#datos_asociacion').show(500);
	            $('#asoc_rSocial').attr('required','true');
	            $('#asoc_dir').attr('required','true');
	            $('#asoc_tel').attr('required','true');
	        }
	});

	$('#select_renap').submit(function(e){
		e.preventDefault();
		
		$('#renap_dpi').popover('hide');
		$('#renap_dpi').removeAttr('style');
		$('#renap_nombre1').popover('hide');
		$('#renap_nombre1').removeAttr('style');

		var error = 0;
		var dpi = $('#renap_dpi').val();
		var primer_nombre = $('#renap_nombre1').val();
		var segundo_nombre = $('#renap_nombre2').val();
		var primer_apellido = $('#renap_apellido1').val();
		var segundo_apellido = $('#renap_apellido2').val();

		if(dpi == '')
		{
			if(primer_nombre=='') error = error+1;
			if(segundo_nombre=='') error = error+1;
			if(primer_apellido=='') error = error+1;
			if(segundo_apellido=='') error = error+1;

			if(error >= 3)
			{
				$('#renap_nombre1').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'Debe de completar al menos dos campos para buscar por nombre', placement:'top'});
				$('#renap_nombre1').popover('show');
				$('#renap_nombre1').css('border','1px solid red');
			}
			else
			{
				llamada = $.ajax({
					type: 'POST',
					url: "<?php echo Yii::app()->createUrl('Denuncia/Procesa_renap'); ?>",
					data:
					{	primer_nombre:primer_nombre,
						segundo_nombre:segundo_nombre,
						primer_apellido:primer_apellido, 
						segundo_apellido:segundo_apellido,
					},
					timeout: 35000,
					beforeSend: function(response)
					{
						$('#resultado_renap').show(5);
						$('#resultado_renap').html('');
						$('#resultado_renap').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
						$('.cancelCall').click(function(){ llamada.abort(); });
					},
					error: function(xhr, status, error)
					{
						if(status === 'abort'){
							$('#resultado_renap').hide(500);
							$('#resultado_renap').html('');
						}
						else{
							$.ajax({
								type:'POST',
								url: "<?php echo Yii::app()->createUrl('Denuncia/Explota_renap'); ?>",
								success:function(response)
								{
									$('#resultado_renap').html('');
									$('#resultado_renap').html(response);
								},
							});
						}
					},
					success: function(response)
					{
						$('#resultado_renap').html('');
						$('#resultado_renap').html(response);
					},
				});
			}

		}
		else
		{
			if(dpi.length !== 13)
			{
				$('#renap_dpi').popover({trigger:'manual',html:true,title:'<i class="icon-warning-sign BotonClose"></i> Advertencia',content:'El DPI debe de tener 13 dígitos', placement:'top'});
				$('#renap_dpi').popover('show');
				$('#renap_dpi').css('border','1px solid red');				
			}
			else
			{
				llamada = $.ajax({
					type: 'POST',
					url: "<?php echo Yii::app()->createUrl('Denuncia/Explota_renap'); ?>",
					timeout: 35000,
					data:
					{	
						dpi:dpi,
						tipoRender:'dpi',
					},
					beforeSend: function(response)
					{
						$('#resultado_renap').show(5);
						$('#resultado_renap').html('');
						$('#resultado_renap').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
							'Procesando... Espere un momento por favor'+dropCall+'</h4>');
						$('.cancelCall').click(function(){ llamada.abort(); });
					},
					error: function(xhr, status, error)
					{
						if(status === 'abort'){
							$('#resultado_renap').hide(500);
							$('#resultado_renap').html('');
						}
						else{
							$('#resultado_renap').html('');
							$('#resultado_renap').html('<h4>Ha ocurrido un error, por favor realice la consulta nuevamente...</h4>');
						}
					},
					success: function(response)
					{
						$('#resultado_renap').html('');
						$('#resultado_renap').html(response);
					},
				});
			}
		}
		

	});


	$('#renap_nombre1').keypress(function(e) {
	             
	            //32 es el código del espacio
	            if(e.which == 32) {
	                $('#renap_nombre2').focus();
	            }
	 
	      }); 
	$('#renap_nombre2').keypress(function(e) {
             
            //32 es el código del espacio
            if(e.which == 32) {
                $('#renap_apellido1').focus();
            }
 
      });
	
	$('#renap_apellido1').keypress(function(e) {
	             
	            //32 es el código del espacio
	            if(e.which == 32) {
	                $('#renap_apellido2').focus();
	            }
	 
	      });

	$('#renap_apellido2').keypress(function(e) {
	             
	            //32 es el código del espacio
	            if(e.which == 32) {
	                $('#renap_buscar_btn').focus();
	            }
	 
	      });

	$('#renap_nombre1').focus(function() {
		$('#renap_nombre1').popover('hide');
		$('#renap_nombre1').removeAttr('style')
	 
	});


	$('#renap_dpi').focus(function() {
		$('#renap_dpi').popover('hide');
		$('#renap_dpi').removeAttr('style')
	 
	});

	$("#ckUserenap").live("click", function(){
        var id = parseInt($(this).val(), 10);
        if($(this).is(":checked")) {
            $('#DivPersonaAsoc').show(500);
			$('#select_renap').show(500);
			$('#resultado_renap').hide(500);
			$('#resultado_renap').html('');
			$('#resultado_renap').show(500);
        } 
        else 
        {
            // checkbox is not checked -> do something different
            llamada = $.ajax({
				type:'POST',
				url: "<?php echo Yii::app()->createUrl('Denuncia/Explota_renap'); ?>",
				data:{tipoRender:'sinRenap',},
				timeout: 35000,
				beforeSend: function(response)
				{
					$('#resultado_renap').show(500);
					$('#resultado_renap').html('');
					$('#resultado_renap').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
				error: function(xhr, status, error)
				{
					if(status === 'abort'){
						$('#resultado_renap').hide(500);
						$('#resultado_renap').html('');
					}
					else{
						$('#resultado_renap').html('');
						$('#resultado_renap').html('<h4>Ha ocurrido un error, por favor realice la consulta nuevamente...</h4>');
					}
				},
				success:function(response)
				{
					$('#DivPersonaAsoc').hide(500);
					$('#select_renap').hide(500);
					$('#resultado_renap').show(500);
					//$('#resultado_renap').html('');
					$('#resultado_renap').html(response);

				},
			});
        }
	});

}); //fin del document.ready

</script>