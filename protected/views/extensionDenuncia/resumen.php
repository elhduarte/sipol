<?php
		$reportes = new Reportes;
		$decrypt = new Encrypter;
		$encabezado = $reportes->Encabezado($idEvento);
		$denunciante = $reportes->getDenunciante($idEvento);
		$ubicacion = $reportes->getUbicacionDiv($idEvento);
		$hechos = $reportes->getHechosDiv($idEvento);
		$relatoUnificado = $reportes->getRelato($idEvento);
		$relato = $decrypt->decrypt($relatoUnificado['Relato']);
		$objetos = $relatoUnificado['Objetos'];
		$objetos = str_replace('_',' ',$objetos);
		$objetos = (!empty($objetos)) ? $reportes->getObjetosDiv($objetos) : "Sin registros";
		$destinatario = $relatoUnificado['Destinatario'];
?>


<div class="row-fluid">
	<div class="span5">
		<hr>
			<h4 style="font-size:21px; padding-left:5%;">Resumen de la Denuncia</h4>
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
	<legend>Datos del Destinatario</legend>
	<div>a: 
		<b>
			<?php echo $destinatario; ?>
		</b>
	</div>
</div>

<div class="row-fluid">
	<div class="span8 cuerpo-small">
		<legend>Datos del Denunciante</legend>
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
				<div>Estado Civil: 
					<b><?php echo $denunciante['Estado_Civil']; ?></b>
				</div>
				<div>Profesión: 
					<b><?php echo $denunciante['Profesion']; ?></b>
				</div>
			</div>
			<div class="span6">
				<div>Teléfono de Contacto: 
					<b><?php echo $denunciante['r_telefono_cnt']; ?></b>
				</div>
				<div>Dirección de Contacto: 
					<b><?php echo $denunciante['Direccion_de_contacto']; ?></b>
				</div>
				<div>Departamento Nacimiento: 
					<b><?php echo $denunciante['Departamento_de_Nacimiento']; ?></b>
				</div>
				<div>Municipio Nacimiento: 
					<b><?php echo $denunciante['Municipio_de_Nacimiento']; ?></b>
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
		<legend>Ubicación del Evento</legend>
		<?php echo $ubicacion; ?>
	</div>
</div><!-- Fin del fluid -->
<div class="cuerpo-small">
	<legend>Hechos de la Denuncia</legend>
	<?php 
	$hechos = str_replace('_',' ',$hechos);
	echo $hechos;?>
</div>
<div class="cuerpo-small">
	<legend>Relato de la Denuncia</legend>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $relato; ?>
		</div>
		<div class="span6">

			<div class="cuerpo-small">
				<legend class="campotit2 legendfit"> Objetos Implicados</legend>
				<?php 
				$objetos = str_replace('_',' ',$objetos);
				echo $objetos; ?>
			</div>
		</div>
	</div>
</div>
<div align="right" style="padding-top:2%;">
	<button class="btn btn-primary" type="button" id="continueResumen" target="_blank">Continuar</button>
</div>

<script type="text/javascript">

$(document).ready(function(){
	
	$('#continueResumen').click(function(){
		$('#aextRelato').click();
	});

});//Fin del document Ready
	

</script>