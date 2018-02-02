<?php
$z = '1';
#if($z == '1')
if(isset($_POST['idEventonuevo']) && !empty($_POST['idEventonuevo']) && $_POST['idEventonuevo']!=='empty')
{
		#$idEvento = "";
		$idEvento = $_POST['idEventonuevo'];
		$reportes = new Reportes;
		$decrypt = new Encrypter;
		$encabezado = $reportes->Encabezado($idEvento);
		$hechos = $reportes->getHechosDiv($idEvento);
		$relatoUnificado = $reportes->getRelato($idEvento);
		$relato = $decrypt->decrypt($relatoUnificado['Relato']);
		$objetos = $relatoUnificado['Objetos'];
		$objetos = (!empty($objetos)) ? $reportes->getObjetosDiv($objetos) : "Sin registros";

?>


<div class="row-fluid">
	<div class="span5">
		<hr>
			<h4 style="font-size:21px; padding-left:5%;">Resumen de Ampliación</h4>
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
	<legend>Relato de la Denuncia</legend>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $relato; ?>
		</div>
		<div class="span6">

			<div class="cuerpo-small">
				<legend class="campotit2 legendfit"> Objetos Implicados</legend>
				<?php echo $objetos; ?>
			</div>
		</div>
	</div>
</div>
<div class="cuerpo-small">
	<legend>Hechos de la Denuncia</legend>
	<?php
	$hechos = str_replace('_',' ', $hechos);
	 echo $hechos;?>
</div>

<div style="padding-top:2%;">
	<div class="row-fluid">
		<div class="span6 form-inline" align="left">
		<b>Tamaño de Papel</b>
			<select id="tamano_papel">
				<option value="1">Carta</option>
				<option value="225">Oficio</option>
			</select>	
			
		</div>
		<div class="span6" align="right">
			<button class="btn btn-info" type="button" id="previewDenuncia">Vista Preliminar</button>	
			<button class="btn" type="button" id="declinarResumen" target="_blank">Cancelar</button>
			<button class="btn btn-primary" type="button" id="confirmaExtension" target="_blank">Confirmar Extensión</button>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="modalPreview" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Vista Previa de Ampliacion</h3>
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

}
else
{
	echo "No ha terminado";
}

?>

<script type="text/javascript">

$(document).ready(function(){
	
	$('#confirmaExtension').click(function(){
		var idEvento = $('#identificador_denuncia').val();
		var nuevoIdEvento = $('#nuevoIdEvento').val();
		var tamano_papel = $('#tamano_papel').val();
		//alert(idEvento);
		var tipo_reporte = 'ext';
		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("Reportespdf/ExtensionGet"); ?>',
			data:{
				idEvento:idEvento,
				nuevoIdEvento:nuevoIdEvento,
				tamano_papel:tamano_papel,
			
			},
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
				//alert("Success fn commit");
				window.open(response,'_blank');
				window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
			},
		});//fin del ajax

	});//Fin del click

	$('#previewDenuncia').click(function(){
		//alert('vista previa');
		var id_denuncia = $('#identificador_denuncia').val();
		var tamano_papel = $('#tamano_papel').val();
		//id_denuncia = '1080';
		var tipo_reporte = 'ext';
		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("Reportespdf/preview_extension"); ?>',
			data: { 
				idEvento: id_denuncia,
				tamano_papel:tamano_papel,
			 tipo_reporte: tipo_reporte
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

		$('#declinarResumen').click(function(){


			$('#result_procesoModal').html('');
			$('#result_procesoModal').html('<div class=\"modal-body\">'+
					'<h4>¿Está seguro que desea descartar esta Ampliacion ?</h4></div><div class=\"modal-footer\">'+
					'<button id=\"descarta\" class=\"btn\">Descartar</button>'+
					'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button></div>');
			$('#procesoModal').modal('show');

			$('#descarta').click(function(){
				window.close();
			});

		});//fin del click del botón extravio

});//Fin del document Ready
	

</script>