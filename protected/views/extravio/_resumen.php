<?php

if(isset($_POST['idEvento']) && !empty($_POST['idEvento']) && $_POST['denX'] !=='0' && $_POST['ubiX'] !=='0' && $_POST['detX'] !=='0' && $_POST['relX'] !=='0')
{

		$idEvento = $_POST['idEvento'];
		//$idEvento = "1353";
		$reportes = new Reportes;
		$decrypt = new Encrypter;
		$encabezado = $reportes->Encabezado($idEvento);
		$denunciante = $reportes->getDenunciante($idEvento);
		$ubicacion = $reportes->getUbicacionDiv($idEvento);
		$objetos_extraviados = $reportes->getExtraviosDiv($idEvento);
		$objetos_extraviados = str_replace('_',' ',$objetos_extraviados);
		$relatoUnificado = $reportes->getRelato($idEvento);
		$relato = $decrypt->decrypt($relatoUnificado['Relato']);
		$destinatario = $relatoUnificado['Destinatario'];
		//print_r($relatoUnificado);
?>

<div class="row-fluid">
	<div class="span6">
		<hr>
			<h4 style="font-size:21px; padding-left:5%;">Resumen del Extravío</h4>
		<hr>
	</div>
	<div class="span6 cuerpo-small">
		<div class="row-fluid">
			<div class="span6" style="border-right: 1px solid rgb(227, 227, 227);">
				<div>Tipo de Evento: 
					<b><?php echo $encabezado['tipo_evento']?></b>
				</div>
				<div>Número de Evento: 
					<b><?php echo $encabezado['evento_num']?></b>
				</div>
				<div>Fecha del Evento: 
					<b><?php echo $encabezado['fecha_ingreso']?></b>
				</div>
				<div>Hora del Evento: 
					<b><?php echo $encabezado['hora_ingreso']?></b>
				</div>
			</div>
			<div class="span6">
				<div>Usuario: 
					<b><?php echo $encabezado['usuario']?></b>
				</div>
				<div>Nombre del Usuario: 
					<b><?php echo $encabezado['nombre_usuario']?></b>
				</div>
				<div>Entidad: 
					<b><?php echo $encabezado['nombre_entidad']?></b>
				</div>
				<div>Sede: 
					<b><?php echo $encabezado['nombre_sede']?></b>
				</div>
			</div>
		</div>
	</div><!-- Fin del span6-->
</div><!-- Fin del fluid -->

<div class="cuerpo-small">
	<legend>Datos del Destinatario
		<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconEditDestinatario">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>

	</legend>
	<div>a: 
		<b>
			<?php echo $destinatario; ?>
		</b>
	</div>
</div>

<div class="row-fluid">
	<div class="span8 cuerpo-small">
		<legend>Datos del Ciudadano
			<div class="pull-right">
	    		<button class="BotonClose" style="margin-top:6px;" id="iconEditDenuncia">
	    			<img src="images/icons/glyphicons_150_edit.png">
	    		</button>
		    </div>
		</legend>
		<div class="row-fluid">
			<div class="span6" style="border-right: 1px solid rgb(227, 227, 227);">
				<div>Nombre: 
					<b><?php echo $denunciante['Nombre_Completo']; ?></b>
				</div>
				<div>Documento de Identificación: 
					<b><?php echo $denunciante['Tipo_identificacion'].": ".$denunciante['Numero_identificacion']; ?></b>
				</div>
				<div>Fecha de Nacimiento: 
					<b><?php echo $denunciante['Fecha_de_Nacimiento']; ?></b>
				</div>
				<div>Edad: 
					<b><?php echo $denunciante['Edad']; ?> años</b>
				</div>
				<div>Género: 
					<b><?php echo $denunciante['Genero']; ?></b>
				</div>
			</div>
			<div class="span6">
				<div>Teléfono de Contacto: 
					<b><?php echo $denunciante['r_telefono_cnt']; ?></b>
				</div>
				<div>Dirección de Contacto: 
					<b><?php echo $denunciante['Direccion_de_contacto']; ?></b>
				</div>
				<div>Nombre del Padre: 
					<b><?php echo $denunciante['Nombre_del_Padre']; ?></b>
				</div>
				<div>Nombre de la Madre: 
					<b><?php echo $denunciante['Nombre_de_la_Madre']; ?></b>
				</div>
			</div>
		</div>


	</div>
	<div class="span4 cuerpo-small">
		<legend>Ubicación del Evento
			<div class="pull-right">
	    		<button class="BotonClose" style="margin-top:6px;" id="iconEditUbicacion">
	    			<img src="images/icons/glyphicons_150_edit.png">
	    		</button>
		    </div>
		</legend>
		<?php echo $ubicacion; ?>
	</div>
</div><!-- Fin del fluid -->
<div class="cuerpo-small">
	<legend>Objetos Extraviados
		<div class="pull-right">
			<button class="BotonClose" style="margin-top:6px;" id="iconEditHechos">
				<img src="images/icons/glyphicons_150_edit.png">
			</button>
		</div>
	</legend>
	<?php echo $objetos_extraviados;?>
</div>

<div class="cuerpo-small">
	<legend>Relato del Extravio
		<div class="pull-right">
			<button class="BotonClose" style="margin-top:6px;" id="iconEditRelato">
				<img src="images/icons/glyphicons_150_edit.png">
			</button>
		</div>
	</legend>
	<?php echo $relato;?>
</div>


<div class="row-fluid" style="padding-top:2%;">
	<div class="span6" align="left">
		<b>Tamaño de Papel</b>
		<select id="tamano_papel">
			<option value="1">Carta</option>
			<option value="225">Oficio</option>
		</select>

	</div>
	<div class="span6" align="right">
		<button class="btn btn-info" type="button" id="previewDenuncia">Vista Preliminar</button>
		<button class="btn" type="button" id="cancelarExtravio">Cancelar</button>
		<button class="btn btn-primary" type="submit" id="confirmarExtravio" target="_blank">Confirmar Extravio</button>
	</div>
</div>

<?php 
} //fin de la condicion general
else
{


	echo "<div class='well'><h4>Debe Completar la denuncia antes de continuar</h4></div>";
}
?>

<!-- Modal -->
<div id="modalPreview" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  '<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Vista Previa de Extravio</h3>
  </div>
  <div class="modal-body">
    <div id="modalPreview_proceso">
      <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>Estamos Procesando su petición...</h4>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>'

</div>
<!-- Fin Modal -->

<script type="text/javascript">

	$(document).ready(function(){
		$('#iconEditDenuncia').tooltip({placement:'left', title:'Editar los datos del Ciudadano'});
		$('#iconEditUbicacion').tooltip({placement:'left', title:'Editar los datos de la Ubicación'});
		$('#iconEditHechos').tooltip({placement:'left', title:'Editar Hechos de ésta Denuncia'});
		$('#iconEditRelato').tooltip({placement:'left', title:'Editar El Relato o los objetos Implicados'});

		$('#iconEditDenuncia').click(function(){
			$('#tab5').hide(500);
			$('#tab1').show(500);
			$('#nav_denuncia li:eq(0) a').tab('show');
		});

		$('#iconEditUbicacion').click(function(){
			$('#tab5').hide(500);
			$('#tab2').show(500);
			$('#nav_denuncia li:eq(1) a').tab('show');
		});

		$('#iconEditHechos').click(function(){
			$('#tab5').hide(500);
			$('#tab3').show(500);
			$('#nav_denuncia li:eq(2) a').tab('show');
		});

		$('#iconEditRelato').click(function(){
			$('#tab5').hide(500);
			$('#tab4').show(500);
			$('#nav_denuncia li:eq(3) a').tab('show');
		});

		$.fn.actualizaResumen = function()
		{
			var idEvento = $('#identificador_denuncia').val();
			var denX = $('#denX').val();
			var ubiX = $('#ubiX').val();
			var detX = $('#detX').val();
			var relX = $('#relX').val();

			if(idEvento !== 'empty')
			{
				$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("Extravio/Show_resumen"); ?>',
				data:
				{
					idEvento: idEvento,
					denX:denX,
					ubiX:ubiX,
					detX:detX,
					relX:relX
				},
				beforeSend:function()
				{
					$('#tab5').html('');
					$('#tab5').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
				success:function(resumen)
				{
					$('#tab5').html('');
					$('#tab5').html(resumen);
				}

				});//fin del ajax
			}//Fin del if
		}//Fin fe funcion actualiza resumen

		$('#confirmarExtravio').click(function(){
			var id_denuncia = $('#identificador_denuncia').val();
			var tamano_papel = $('#tamano_papel').val();

			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("Reportespdf/extravioGet"); ?>',
				data:{idEvento:id_denuncia,
					tamano_papel:tamano_papel
				},
				beforeSend:function()
				{
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
					$('#procesoModal').modal('show'); 
				},
				success:function(response)
				{
					window.open(response,'_blank');
					window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
				},
			});//fin del ajax
		});//fin del click del botón extravio

		$('#cancelarExtravio').click(function(){


			$('#result_procesoModal').html('');
			$('#result_procesoModal').html('<div class=\"modal-body\">'+
					'<h4>¿Está seguro que desea descartar éste extravío?</h4></div><div class=\"modal-footer\">'+
					'<button id=\"descarta\" class=\"btn\">Descartar</button>'+
					'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button></div>');
			$('#procesoModal').modal('show');

			$('#descarta').click(function(){
				window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
			});

		});//fin del click del botón extravio

		$('#previewDenuncia').click(function(){
			//alert('vista previa');
			var id_denuncia = $('#identificador_denuncia').val();
			var tamano_papel = $('#tamano_papel').val();
			//id_denuncia = '1080';

			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("Reportespdf/preview_extravio"); ?>',
				data: { 
					idEvento: id_denuncia,
					tamano_papel:tamano_papel
					 },
				beforeSend: function(){
					$('#modalprocesando').modal('show');

				},
				error: function(){

				},
				success:function(ruta){
					$('#modalprocesando').modal('hide');
					r = ruta.split('~');
					if(r[0] == '1'){
						$('#modalPreview_proceso').html('');
						$('#modalPreview_proceso').html('<iframe src="'+r[1]+'" width="800px" height="600px" style="border: none;"></iframe>');
						$('#modalPreview').modal('show');
						//alert(r[1]);
					}
					else{
						$('#modalPreview_proceso').html('');
						$('#modalPreview_proceso').html('Ha ocurrido un error...');
						$('#modalPreview').modal('show');
					}
				}
			});

		});

	});//Fin del ready
	
</script>

