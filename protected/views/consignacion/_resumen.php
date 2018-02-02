<?php
$tst = '1';
//if($tst=='1')
if(isset($_POST['idEvento']) && !empty($_POST['idEvento']) && $_POST['conX'] && $_POST['AgeX'] && $_POST['ubiX'] && $_POST['relX'])
{
	//$idEvento = '2756';
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
	$consignados = $reportes->getConsignados($idEvento);

	//print_r($agentes);

?>



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

<div class="cuerpo-small">
	<legend>Consignaciones
		<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconConsignados">
    			<img src="images/icons/glyphicons_150_edit.png">
    		</a>
	    </div>
	</legend>
	<?php echo $consignados; ?>
</div>

<div class="row-fluid">
	<div class="span6 cuerpo-small">
		<legend>Patrullas y Agentes Implicados
			<div class="pull-right">
	    		<a class="BotonClose" style="margin-top:6px;" id="iconAgentes">
	    			<img src="images/icons/glyphicons_150_edit.png">
	    		</a>
		    </div>
		</legend>
		<?php echo $agentes; ?>
	</div>
	<div class="span6 cuerpo-small">
		<legend>Ubicación del Evento
			<div class="pull-right">
	    		<a class="BotonClose" style="margin-top:6px;" id="iconUbicacion">
	    			<img src="images/icons/glyphicons_150_edit.png">
	    		</a>
		    </div>
		</legend>
		<?php echo $ubicacion; ?>
	</div>
</div><!-- Fin del fluid -->

<div class="cuerpo-small">
	<legend>Relato de la Incidencia
		<div class="pull-right">
    		<a class="BotonClose" style="margin-top:6px;" id="iconRelato">
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

<div align="right" style="padding-top:1%;">
	<button class="btn" id="IncidenciaCancel">Cancelar</button>
	<button class="btn btn-primary" id="IncidenciaCommit">Confirmar</button>
</div>

<?php 
}// FIN de la condición general
else
{
	echo "<div class='well'><h4>Debe Completar la denuncia antes de continuar</h4></div>";
}
?>

<script type="text/javascript">
	
$(document).ready(function(){

	$('#iconEditTipo').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar los datos del tipo y motivo del parte policial</p>'});
	$('#iconAgentes').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar los datos de los Agentes'});
	$('#iconUbicacion').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar los datos de la Ubicación del Evento'});
	$('#iconRelato').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar el Relato y las entidades Implicadas'});
	$('#iconConsignados').tooltip({html:true, placement:'left', title:'<p style="line-height: 175%; text-align: justify;">'+
											'Editar a Las Personas u Objetos Consignados'});

	$('#iconConsignados').click(function(){
		$('#tab5').hide(500);
		$('#tab1').show(500)
		$('#nav_consignacion li:eq(0) a').tab('show');

	});// Fin Click Consignados

	$('#iconUbicacion').click(function(){
		$('#tab5').hide(500);
		$('#tab3').show(500)
		$('#nav_consignacion li:eq(2) a').tab('show');

	}); //Fin del click iconUbicacion

	$('#iconAgentes').click(function(){
		$('#tab5').hide(500);
		$('#tab2').show(500)
		$('#nav_consignacion li:eq(1) a').tab('show');

	}); //Fin del click iconAgentes

	$('#iconRelato').click(function(){
		$('#tab5').hide(500);
		$('#tab4').show(500)
		$('#nav_consignacion li:eq(3) a').tab('show');

	}); //Fin del click iconRelato
	

	$.fn.actualizaResumen = function()
	{
		var idEvento = $('#identificador_consignacion').val();
		var AgeX = $('#AgeX').val();
		var ubiX = $('#ubiX').val();
		var relX = $('#relX').val();
		var conX = $('#conX').val();

		if(idEvento !== 'empty')
		{
			$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("Consignacion/ShowResumen"); ?>',
			data:
			{
				idEvento: idEvento,
				conX:conX,
				AgeX:AgeX,
				ubiX:ubiX,
				relX:relX,
			},
			beforeSend:function()
			{
				$('#tab5').html('');
				$('#tab5').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error: function()
			{
				$('#tab5').html('tronitos');
			},
			success:function(resumen)
			{
				$('#tab5').html('');
				$('#tab5').html(resumen);
			}

			});//fin del ajax
		}
	}//Fin de la function actualizaResumen

	$('#IncidenciaCancel').click(function(){

		$('#result_procesoModal').html('');
		$('#result_procesoModal').html('<div class=\"modal-body\">'+
				'<h4>¿Está seguro que desea descartar esta Consignacion?</h4></div><div class=\"modal-footer\">'+
				'<button id=\"descarta\" class=\"btn\">Descartar</button>'+
				'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button></div>'
		);


		$('#descarta').click(function(){
			window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
		});

	});//fin del click del botón extravio

	$('#IncidenciaCommit').click(function(){

		var idEvento = $('#identificador_consignacion').val();
		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("Consignacion/IncidenciaCommit"); ?>',
			data:{idEvento:idEvento},
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
	});//fin del click IncidenciaCommit

});//Fin del document ready

</script>