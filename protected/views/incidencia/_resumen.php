<?php
$tst = '1';
//if($tst=='1')
if(isset($_POST['idEvento']) && !empty($_POST['idEvento']) && $_POST['tipX'] && $_POST['AgeX'] && $_POST['ubiX'] && $_POST['relX'])
{
	//$idEvento = '2911';
	$idEvento = $_POST['idEvento'];
	$reportes = new Reportes;
	$decrypt = new Encrypter;

	$encabezado = $reportes->Encabezado($idEvento);
	$ubicacion = $reportes->getUbicacionIncidencia($idEvento);
	$tipoIncidencia = $reportes->getTipoIncidencia($idEvento);
	$relatoEnco = $reportes->getRelato($idEvento);
	$relato = $decrypt->decrypt($relatoEnco['Relato']);
	$implicados = $reportes->getImplicadosTable($relatoEnco['Implicados']);
	$agentes = $reportes->getAgentes($idEvento);
	$destinatario = $relatoEnco['Destinatario'];
	$generales = $reportes->getGeneralesIncidencia($idEvento);
	$getPersonas = $reportes->getPersonasIncidencia($idEvento);
	(!empty($getPersonas)) ? $personasRelacionadas = $getPersonas : $personasRelacionadas = "No hay Personas relacionadas a ésta Incidencia";
	$getObjetos = $reportes->getObjetosIncidencia($idEvento);
	(!empty($getObjetos)) ? $objetosRelacionados = $getObjetos : $objetosRelacionados = "No hay Objetos relacionadas a ésta Incidencia";
	//session_start();
	//$consignados = $reportes->getConsignadosDos($idEvento);

	//var_dump($consignados);

?>

<style type="text/css">
	.legendResumen{
		font-size: 18px;
		line-height: 30px;
		margin-bottom: 10px;
	}
	.contenidoResumen{
		padding-left: 12px;
		padding-right: 12px;
	}
</style>

<div class="row-fluid">
	<div class="span5">
		<hr>
			<h4 style="font-size:21px; padding-left:5%;">Resumen de la Incidencia</h4>
		<hr>
	</div>
	<div class="span7 cuerpo-small">
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
	<legend class="legendResumen">Datos del Destinatario
		<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconEditDestinatario">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>
	</legend>
	<div class="contenidoResumen">
		<div>a: 
			<b>
				<?php echo $destinatario; ?>
			</b>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6 cuerpo-small">
		<legend class="legendResumen">Datos Generales de la Incidencia
			<div class="pull-right">
	    		<a class="BotonClose" style="margin-top:6px;" id="iconEditGenerales">
	    			<img src="images/icons/glyphicons_150_edit.png">
	    		</a>
		    </div>
		</legend>
		<div class="contenidoResumen">
			<div>
				Tipo de Incidencia:<b>
				<?php
					echo $generales->Tipo;
				?>
				</b>
			</div>
			<div>
				Origen del Parte Policial:<b>
				<?php
					echo $generales->Motivo;
				?>
				</b>
			</div>
			<div>
				Fecha/Hora Incio:<b>
				<?php
					echo $generales->Fecha_Inicio." - ".$generales->Hora_Inicio;
				?>
				</b>
			</div>
			<div>
				Fecha/Hora Finalización:<b>
				<?php
					echo $generales->Fecha_Fin." - ".$generales->Hora_Fin;
				?>
				</b>
			</div>
			<div>
				Detalles Adicionales:<b>
				<?php
					echo (!empty($generales->Detalles)) ? $generales->Detalles : '** Sin Datos';		
				?>
				</b>
			</div>
		</div>
	</div><!-- Fin del span6 -->
	<div class="span6 cuerpo-small">
		<legend class="legendResumen">Ubicación del Evento
			<div class="pull-right">
	    		<a class="BotonClose" style="margin-top:6px;" id="iconEditUbicacion">
	    			<img src="images/icons/glyphicons_150_edit.png">
	    		</a>
		    </div>
		</legend>
		<div class="contenidoResumen">
			<?php echo $ubicacion; ?>
		</div>
	</div><!-- Fin del span6 -->
</div>

<div class="cuerpo-small">
	<legend class="legendResumen" style="margin-bottom:20px;">Patrullas y Agentes Relacionados
		<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconEditAgentes">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>
	</legend>
	<div class="contenidoResumen">
		<?php echo $agentes; ?>
	</div>
</div>

<div class="cuerpo-small">
	<legend class="legendResumen">Relato de la Incidencia
		<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconEditRelato">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>
	</legend>
	<div class="row-fluid">
		<div class="span6" align="justify">
			<?php echo $relato; ?>
		</div>
		<div class="span6">
			<h5>Entidades Relacionadas</h5>
			<?php echo $implicados; ?>
		</div>
	</div><!-- Fin del Fluid -->
</div>

<div class="row-fluid">
	<div class="span6 cuerpo-small">
		<legend class="legendResumen" style="margin-bottom:20px;">Personas Relacionadas
			<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconEditPersonasRelacionadas">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>
		</legend>
		<div class="cuerpoResumen">
			<?php echo $personasRelacionadas; ?>
		</div>
	</div>
	<div class="span6 cuerpo-small">
		<legend class="legendResumen" style="margin-bottom:20px;">Objetos Relacionados
			<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconEditObjetosRelacionados">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>
		</legend>
		<div class="cuerpoResumen">
			<?php echo $objetosRelacionados; ?>
		</div>
	</div>
</div>

<?php 
//if($tst=='1')
if(isset($_POST['conX']) && $_POST['conX']==1)
{ 
	$consignados = $reportes->getConsignados($idEvento);
?>
<div class="cuerpo-small">
	<legend class="legendResumen" style="margin-bottom:20px;">Consignaciones
		<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconEditConsignados">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>
	</legend>
	<div class="contenidoResumen">
		<?php echo $consignados; ?>
	</div>
</div>

<?php } //Fin de la condición de Consignación ?>

<div class="row-fluid" style="padding-top:2%;">

	<div class="span6 form-inline" align="left">
		
		<b>Tamaño de Papel</b>
		<select id="tamano_papel">
			<option value="1">Carta</option>
			<option value="225">Oficio</option>
		</select>	
	
	</div>
	<div class="span6" align="right">	
		<button class="btn btn-info" type="button" id="previewIncidencia">Vista Preliminar</button>	
		<button class="btn" id="IncidenciaCancel">Cancelar</button>
		<button class="btn btn-primary" id="IncidenciaCommit">Confirmar</button>
	</div>
</div>

<!--div align="right" style="padding-top:1%;">
	<button class="btn" id="IncidenciaCancel">Cancelar</button>
	<button class="btn btn-primary" id="IncidenciaCommit">Confirmar</button>
</div-->

<!-- Modal -->
<div id="modalPreview" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Vista Previa de Incidencia</h3>
  </div>
  <div class="modal-body">
    <div id="modalPreview_proceso">
      <h4><img  height ='30px'  width='30px' src='images/loading.gif' style="padding:10px;"/>Estamos Procesando su petición...</h4>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>

</div>
<!-- Fin Modal -->

<?php 
}// FIN de la condición general
else
{
	echo "<div class='well'><h4>Debe Completar la denuncia antes de continuar</h4></div>";
}
?>

<script type="text/javascript">
	
$(document).ready(function(){

	$('#iconEditDestinatario').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
								'Editar a quien va dirigida ésta incidencia</p>'});
	$('#iconEditGenerales').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar los datos del tipo y motivo del parte policial</p>'});
	$('#iconEditUbicacion').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar los datos de la Ubicación del Evento'});
	$('#iconEditAgentes').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar los datos de los Agentes'});
	$('#iconEditRelato').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar el Relato y las entidades Relacionadas'});
	$('#iconEditPersonasRelacionadas').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar a las personas Relacionadas'});
	$('#iconEditObjetosRelacionados').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar los Objetos Relacionados'});
	$('#iconEditConsignados').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar a Las Personas u Objetos Consignados'});

	$('#iconEditDestinatario').click(function(){
		$('#aTab1').click();
	});//Fin del click para editar el destinatario

	$('#iconEditGenerales').click(function(){
		$('#aTab1').click();
	});//Fin del click para editar el destinatario

	$('#iconEditUbicacion').click(function(){
		$('#aTab3').click();
	}); //Fin del click iconEditUbicacion

	$('#iconEditAgentes').click(function(){
		$('#aTab2').click();
	}); //Fin del click iconEditAgentes

	$('#iconEditRelato').click(function(){
		$('#aTab4').click();
	}); //Fin del click iconEditRelato

	$('#iconEditPersonasRelacionadas').click(function(){
		$('#aTab5').click();
	}); //Fin del click iconEditPersonasRelacionadas

	$('#iconEditObjetosRelacionados').click(function(){
		$('#aTab6').click();
	}); //Fin del click iconEditPersonasRelacionadas

	$('#iconEditConsignados').click(function(){
		$('#aTab7').click();
	});// Fin Click Consignados

	$.fn.actualizaResumen = function()
	{
		var idEvento = $('#identificador_incidencia').val();
		var tipX = $('#tipX').val();
		var AgeX = $('#AgeX').val();
		var ubiX = $('#ubiX').val();
		var relX = $('#relX').val();
		var conX = $('#conX').val();

		if(idEvento !== 'empty')
		{
			$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("Incidencia/ShowResumen"); ?>',
			data:
			{
				idEvento: idEvento,
				tipX:tipX,
				AgeX:AgeX,
				ubiX:ubiX,
				relX:relX,
				conX:conX
			},
			beforeSend:function()
			{
				$('#tab8').html('');
				$('#tab8').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error: function()
			{
				$('#tab8').html('Ha Ocurrido un error');
			},
			success:function(resumen)
			{
				$('#tab8').html('');
				$('#tab8').html(resumen);
			}

			});//fin del ajax
		}
	}//Fin de la function actualizaResumen

	$('#IncidenciaCancel').click(function(){

		$('#result_procesoModal').html('');
		$('#result_procesoModal').html('<div class=\"modal-body\">'+
				'<h4>¿Está seguro que desea descartar esta Incidencia?</h4></div><div class=\"modal-footer\">'+
				'<button id=\"descarta\" class=\"btn\">Descartar</button>'+
				'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button></div>');
		$('#procesoModal').modal('show'); 

		$('#descarta').click(function(){
			window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
		});

	});//fin del click del botón extravio

	$('#IncidenciaCommit').click(function(){

		var idEvento = $('#identificador_incidencia').val();
		var tamano_papel = $('#tamano_papel').val();
		$('#result_procesoModal').html('');
		$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
		$('#procesoModal').modal('show'); 

		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("Incidencia/IncidenciaCommit"); ?>',
			data:{
				idEvento:idEvento,
				tamano_papel:tamano_papel},
			beforeSend:function()
			{
				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
				$('#procesoModal').modal('show'); 

			},
			error:function()
			{
				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<h4>Ha ocurrido un error al procesar su petición...</h4>');

			},
			success:function(response)
			{
				window.open(response,'_blank');
				window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
			},
		});//fin del ajax
	});//fin del click IncidenciaCommit

$('#previewIncidencia').click(function(){
		//alert('vista previa');
		var idEvento = $('#identificador_incidencia').val();
		var tamano_papel = $('#tamano_papel').val();
		//id_denuncia = '1080';

		$.ajax({
		type:'POST',
		url:'<?php echo CController::createUrl("Reportespdf/preview_incidencia"); ?>',
		data: { 
			idEvento: idEvento,
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

});//Fin del document ready

</script>