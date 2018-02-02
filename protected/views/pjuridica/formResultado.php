 <?php
$WSConsulta = new WSConsulta;

$alerta = '<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>¡Aviso!</strong> No se Obtienen datos de RENAP
</div>';

$r_primer_nombre = "";
$r_segundo_nombre = "";
$r_primer_apellido = "";
$r_segundo_apellido = "";
$r_genero = "";
$r_nacimiento = "";
$r_pais_nacimiento = "";
$pj_r_dpi = "";
$r_departamento = "";
$r_municipio = "";
$r_ecivil = "";
$r_nacionalidad = "";
$r_npadre = "";
$r_nmadre = "";
$r_foto = "images/noimagen.png";
$r_orden_cedula = "";
$r_registro_cedula = "";
$llave_clean = "";
$cui_clean = "";
$foto_clean = "";
$read_only = "";
$resultado = "";
$OrdenCaptura = "";
$pintaContacto = 0;
$pintaCaracteristicas = 0;
$tipoDocumento = "Sin Documento";
$sinId = 0;
$hiddenContacto = "";
$required = "required";


if(isset($_POST['pintaCaracteristicas']) && !empty($_POST['pintaCaracteristicas'])) $pintaCaracteristicas = $_POST['pintaCaracteristicas'];
if(isset($_POST['pintaContacto']) && !empty($_POST['pintaContacto'])) $pintaContacto = $_POST['pintaContacto'];

if(isset($_POST['tipoRender']))
{
	switch ($_POST['tipoRender']) 
	{
		case 'llave':
			$llave = $_POST['llave'];
			$resultado = $WSConsulta->ConsultaLlave($llave);
		break;

		case 'dpi':
			$dpi = $_POST['dpi'];
			$resultado = $WSConsulta->ConsultaDpi($dpi);
			$llave="";
		break;

		case 'sinRenap':
			$alerta = "";
		break;

		case 'sinIdentificacion':
			$sinId = '1';
			$alerta = "";
			$hiddenContacto = "style='display:none;'";
			$required = "";
			//echo "No va a mostrar el contacto";
	}
}


if(!empty($resultado))
{
	$alerta = "";
	$resultado = json_decode($resultado);

	foreach ($resultado->registros as $value)
	{
		$r_primer_nombre = $value->PRIMER_NOMBRE;
		$r_segundo_nombre = $value->SEGUNDO_NOMBRE;
		$r_primer_apellido = $value->PRIMER_APELLIDO;
		$r_segundo_apellido = $value->SEGUNDO_APELLIDO;
		$r_genero = $value->GENERO;
		$r_nacimiento = $value->FECHA_NACIMIENTO;
		$r_pais_nacimiento = $value->PAIS_NACIMIENTO;
		$pj_r_dpi = $value->CUI;
		$r_departamento = $value->DEPTO_NACIMIENTO;
		$r_municipio = $value->MUNIC_NACIMIENTO;
		$r_ecivil = $value->ESTADO_CIVIL;
		$r_nacionalidad = $value->NACIONALIDAD;
		$r_npadre = $value->NOMBRE_PADRE;
		$r_nmadre = $value->NOMBRE_MADRE;
		$r_foto = $value->FOTO;
		$r_orden_cedula = $value->ORDEN_CEDULA;
		$r_registro_cedula = $value->REGISTRO_CEDULA;
		
		if($r_genero=="M")
		{
			$r_genero = "MASCULINO";
		}
		else
		{
			$r_genero = "FEMENINO";
		}

		$r_nacimiento = substr($r_nacimiento, 0, 10);
		$h = array();
		$h = explode("-", $r_nacimiento);
		$r_nacimiento = $h[2]."/".$h[1]."/".$h[0];

		if(empty($pj_r_dpi))
		{
			$cui_clean = "";
		}
		else
		{
			$cui_clean = $pj_r_dpi;
		}


		if($r_ecivil=="C")
		{
			$r_ecivil = "CASADO";
		}
		else
		{
			$r_ecivil = "SOLTERO";
		}

		if(empty($r_foto))
		{
			$r_foto = "images/noimagen.png";
			$foto_clean = "";
		}
		else
		{
			$r_foto = "data:image/jpg;base64,".$r_foto;
			$foto_clean = $value->FOTO;
		}

		if(!empty($pj_r_dpi))
		{
			$OrdenCaptura = $WSConsulta->OrdenesCapturaDpi($pj_r_dpi);

			if(!empty($OrdenCaptura)) $OrdenCaptura = "<div style='font-size:18px; font-weight:700;' class='alert alert-error' id='conOrden'>
				 Éste DPI reporta al menos una Órden de Captura pendiente.</div>";
		}

		$llave_clean=$llave;
		$read_only = "readonly disabled";

	}

}

?>

<div class="well" style="display:none;">
	<div class="row-fluid">
		<div class="span4">
			<p class="campotit">Llave</p>
			<input class="span12" type="text" id="llave_renap_clean_pj" value="<?php echo $llave_clean; ?>">
		</div>
		<div class="span4">
			<p class="campotit">CUI</p>
			<input class="span12" type="text" id="cui_renap_clean_pj" value="<?php echo $cui_clean; ?>">
		</div>
		<div class="span4">
			<p class="campotit">Foto</p>
			<input class="span12" type="text" id="foto_renap_clean_pj" value="<?php echo $foto_clean; ?>">
		</div>

	</div>
</div>
<div class="well">
	<?php echo $alerta; ?>

	<form id="frm_PersonaJuridica">
		<legend <?php echo $hiddenContacto;?>>Datos Personales</legend>
		<div id="explotados_renap_pj" <?php echo $hiddenContacto;?>>
			<div class="row-fluid">
				<div class="span10">
					<div class="row-fluid">
					<div class="span3">
						<p class="campotit">Primer Nombre</p>
						<input id="pj_r_primer_nombre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_primer_nombre; ?>">
					</div>
					<div class="span3">
						<p class="campotit">Segundo Nombre</p>
						<input id="pj_r_segundo_nombre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_segundo_nombre; ?>">
					</div>
					<div class="span3">
						<p class="campotit">Primer Apellido</p>
						<input id='pj_r_primer_apellido' class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_primer_apellido; ?>">
					</div>
					<div class="span3">
						<p class="campotit">Segundo Apellido</p>
						<input id="pj_r_segundo_apellido" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_segundo_apellido; ?>">
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<p class="campotit">Género</p>
						<select id ="pj_r_genero" class ="span12"  <?php echo $read_only; ?>>
							<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
							<option value ="MASCULINO">MASCULINO</option>
							<option value ="FEMENINO">FEMENINO</option>
						</select>
					</div>
					<div class="span3">
						<?php 
							if(!empty($pj_r_dpi)){
							$tipoDocumento = "DPI";
						?>
						<p class="campotit">DPI</p>
						<input id="pj_r_dpi" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $pj_r_dpi; ?>">
						<?php 
							}else{
						?>
						<div align="center">
							<div class="btn-group" align="left">
								<label class="dropdown-toggle campotit" data-toggle="dropdown" style="cursor: pointer;"><span id="pjLabelDocumento">Sin Documento </span><i class="icon-chevron-down BotonClose"></i></label>
								<ul class="dropdown-menu">
							      <li><a class="cambiaElLabel">DPI</a></li>
							      <li><a class="cambiaElLabel">Pasaporte</a></li>
							      <li><a class="cambiaElLabel">Sin Documento</a></li>
							    </ul>
							</div>
						</div>
						<input id="pj_r_dpi" class="span12" type="text" readonly value="--">
						<?php 
							}
						?>
						<input id="pj_r_tipo_ident" class="span12" type="text" disabled value="<?php echo $tipoDocumento; ?>" style="display:none;">
					</div>
					<div class="span3">
						<p class="campotit">Fecha de Nacimiento</p>
						<input id="pj_r_nacimiento" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_nacimiento; ?>" placeholder="dd/mm/aaaa">
					</div>
					<div class="span3">
						<p class="campotit">Pais de Origen</p>
						<select <?php echo $read_only; ?> class ="span12" id ="r_pais_nacimiento" name="r_pais_nacimiento">
							<?php 
							$modelo = new CatPaises;
							echo $modelo->combo();
							?>
						</select>
					</div>
				</div>


				<div class="row-fluid">
				<div class="span3">
					<p class="campotit">Departamento</p>
					<input id="r_departamento" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_departamento; ?>">
				</div>
				<div class="span3">
					<p class="campotit">Municipio</p>
					<input id="r_municipio" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_municipio; ?>">
				</div>
				<div class="span3">
					<p class="campotit">Nacionalidad</p>
					<input  id="r_nacionalidad" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_nacionalidad; ?>">
				</div>
				<div class="span3">
					<p class="campotit">Estado Civil</p>
					<select id ="r_ecivil" class ="span12"  <?php echo $read_only; ?>>
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="SOLTERO">SOLTERO</option>
						<option value ="CASADO">CASADO</option>
					</select>
				</div>
				</div>
				<div class="row-fluid">
					<div class="span4">
						<p class="campotit">Nombre Padre</p>
						<input  id="r_npadre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo strtoupper($r_npadre); ?>">
					</div>
					<div class="span4">
						<p class="campotit">Nombre Madre</p>
						<input  id="r_nmadre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo strtoupper($r_nmadre); ?>">
					</div>
					<div class="span4">
						<br>
						<?php echo $OrdenCaptura; ?>
					</div>
				</div>
				</div>

				<div class="span2">
					<center><img class="imagen_renap" src='<?php echo $r_foto; ?>'/></center>
				</div>
			</div>
		</div><!-- fin div explotados_renap --> 

<?php
	if(isset($pintaCaracteristicas) && $pintaCaracteristicas=='1')
	{
?>
		<legend>Características Físicas</legend>
		<div id="caracteristicas_fisicas_pj">
			<div class="row-fluid">
				<div class="span2">
					<p class="campotit">Tipo de Cabeza</p>
					<select id="r_cabeza_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Larga">Larga</option>
						<option value ="Ancha">Ancha</option>
						<option value ="Redonda">Redonda</option>
						<option value ="Cuadrada">Cuadrada</option>
						<option value ="De Forma Aplanada Atras">De Forma Aplanada Atras</option>
						<option value ="Alta En La Corona">Alta En La Corona</option>
						<option value ="En Forma De Huevo">En Forma De Huevo</option>
						<option value ="Plana En Su Parte Superior">Plana En Su Parte Superior</option>
					</select>
				</div>
				<div class="span2">
					<p class="campotit">Tipo de Bigote</p>
					<select id="r_bigote_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Sin Bigote">Sin Bigote</option>
						<option value ="Poblado">Poblado</option>
						<option value ="Regular">Regular</option>
						<option value ="Escaso">Escaso</option>
						<option value ="Corto">Corto</option>
						<option value ="Recto">Recto</option>
						<option value ="Curvo">Curvo</option>
						<option value ="Hacia Abajo">Hacia Abajo</option>
						<option value ="Hacia Arriba">Hacia Arriba</option>
						<option value ="Frondosos">Frondosos</option>
						<option value ="Cortos y Gruesos">Cortos y Gruesos</option>
					</select>
				</div>
				<div class="span2">
					<p class="campotit">Tipo de Cejas</p>
					<select id="r_cejas_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Rectas">Rectas</option>
						<option value ="Triangulares">Triangulares</option>
						<option value ="Arqueadas">Arqueadas</option>
						<option value ="Abundantes">Abundantes</option>
						<option value ="Escasas">Escasas</option>
						<option value ="Juntas">Juntas</option>
					</select>
				</div>
				<div class="span2">
					<p class="campotit">Tipo de Ojos</p>
					<select id="r_ojos_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Chinos">Chinos</option>
						<option value ="Alargados">Alargados</option>
						<option value ="Redondos">Redondos</option>
					</select>
				</div>
				<div class="span2">
					<p class="campotit">Color de Ojos</p>
					<input class="span12" id ="r_colorojos_cf" type="text" placeholder="Color de ojos">
				</div>
				<div class="span2">
					<p class="campotit">Peso</p>
					<div class="input-append">
						<input class="span10" id ="r_peso_cf"  type="text" >
						<span class="add-on">lbs</span>
					</div> 
				</div>
			</div>

			<!-- ************************* ****************************** ************************* -->
			<div class="row-fluid">
				<div class="span2">
					<p class="campotit">Estatura</p>
					<div class="input-append">
						<input class="span10" id ="r_estatura_cf"  type="text" >
						<span class="add-on">mts</span>
					</div> 
				</div>
				<div class="span2">
					<p class="campotit">Color de Piel</p>
					<input class="span12" id ="r_colorpiel_cf" type="text" placeholder="Color de Piel">
				</div>
				<div class="span2">
					<p class="campotit">Tipo de Cabello</p>
					<select id="r_tipocabello_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Crespo">Crespo</option>
						<option value ="Liso">Liso</option>
						<option value ="Rizado">Rizado</option>
					</select>
				</div>
				<div class="span2">
					<p class="campotit">Color de Cabello</p>
					<input class="span12" id ="r_colorcabello_cf" type="text" placeholder="Color de Cabello">
				</div>
				<div class="span2">
					<p class="campotit">Tipo de Nariz</p>
					<input class="span12" id ="r_tiponariz_cf" type="text" placeholder="Tipo de Nariz">
				</div>
				<div class="span2">
					<p class="campotit">Complexión</p>
					<select id="r_complexion_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Fornido">Fornido</option>
						<option value ="Delgado">Delgado</option>
						<option value ="Robusto">Robusto</option>
					</select>
				</div>
			</div>

			<!-- ************************* ****************************** ************************* -->
			<div class="row-fluid">
				<div class="span2">
					<p class="campotit">Usa Lentes</p>
					<div class="row-fluid">
						<div class="span4 offset2 dosOptions"><input type="radio" id="r_lentes_cf" name="r_lentes" value ="Si_Usa"/> <span>SI</span></div>
						<div class="span4 dosOptions"> <input type="radio" id="r_lentes_cf" name="r_lentes" value ="No_Usa"/> <span>NO</span></div>
					</div>
				</div>
				<div class="span2">
					<p class="campotit">Descripcion Tatuajes</p>
					<input class="span12" id ="r_tatuajes_cf"  type="text">
				</div>
				<div class="span2">
					<p class="campotit">Amputaciones</p>
					<input class="span12" id ="r_amputaciones_cf"  type="text">
				</div>
				<div class="span4">
					<p class="campotit">Características Físicas Visibles</p>
					<input class="span12" id ="r_cicatrices_cf"  type="text">
				</div>
			</div>
		</div>
<?php
}// fin del if caracteristicas físicas

if(isset($pintaContacto) && $pintaContacto=='1')
{
?>


		<legend style="padding-top:2%;">Datos de Contacto</legend>
		<div id="datos_contacto_pj">
			<div class="row-fluid">
				<div class="span2">
					<p class="campotit">Teléfono</p>
					<input id="r_telefono_cnt" class="span12" type="text" placeholder="Teléfono de contacto">
				</div>
				<div class="span2">
					<p class="campotit">Email</p>
					<input id="r_email_cnt" class="span12" type="email" placeholder="Email de Contacto">
				</div>
				<div class="span2">
					<p class="campotit">Profesión</p>
					<input id="r_profesion_cnt" class="span12" type="text" placeholder="Profesión">
				</div>
				<div class="span2">
					<p class="campotit">Lugar de trabajo</p>
					<input id="r_lugar_trabajo_cnt" class="span12" type="text" placeholder="Lugar de Trabajo">
				</div>
				<div class="span4">
					<p class="campotit">Dirección</p>
					<input id="r_dirección_cnt" class="span12" type="text" placeholder="Dirección de Contacto">
				</div>
			</div>
		</div>
<?php 
} //Fin del if $pintaContacto
?>

		<legend style="padding-top:2%;"></legend>
		<div align="right">
			<?php 

			if(isset($_POST['esExtravio']) && $_POST['esExtravio'])
			{ 
			?>

			<button type="button" class="btn btn-info" id="UtilizarDatosExtravio">Utilizar Datos</button>
			
			<?php 
			} 
			else
			{

			?>
			<button type="submit" class="btn btn-primary">Guardar Persona</button>
			<?php } //Fin del else para el botón ?>
		</div>
	</form>
</div>


<script type="text/javascript">

$(document).ready(function(){

	var pn = '<?php echo $r_pais_nacimiento; ?>';

	if(pn ==''){
		$('#r_pais_nacimiento').val('GUATEMALA');
	}else{
		$('#r_pais_nacimiento').val(pn);	
	}

	var g = '<?php echo $r_genero; ?>';
	$('#pj_r_genero').val(g);

	var civil = '<?php echo $r_ecivil; ?>';
	$('#r_ecivil').val(civil);

	$('#pj_r_nacimiento').datepicker({
	    format: "dd/mm/yyyy",
	    todayBtn: "linked",
	    language: "es"
	});

	$('.cambiaElLabel').click(function(){
		var valorNuevo = $(this).text();
		$('#pj_r_dpi').removeAttr('readonly');
		$('#pj_r_dpi').removeAttr('value');
		if(valorNuevo == "Sin Documento")
		{
			$('#pj_r_dpi').attr('readonly','true');
			$('#pj_r_dpi').attr('value', '--');
		}
			$('#pj_r_tipo_ident').val(valorNuevo);
			$('#pjLabelDocumento').text(valorNuevo+" ");
	});

	$('#conOrden').tooltip({html:true,title:'Verifique ésta persona con el Sistema de Antecedentes para determinar su captura',placement:'bottom'});
	$('#conOrden').tooltip('show');

	$('#explotados_renap_pj').find(':input').each(function() {
	var elemento = this;
	var valor = elemento.value;
	var ident = elemento.id;

	if( valor =='' || valor ==' ')
	{
		$("#"+ident).removeAttr("readonly");
	}
		//alert('elemento.id='+ elemento.id + ', elemento.value=' + elemento.value); 
	}); //fin del each

	$('#frm_PersonaJuridica').submit(function(e){
		e.preventDefault();
		var llave_clean = $('#llave_renap_clean_pj').val();
		var cui_clean = $('#cui_renap_clean_pj').val();
		var foto_clean = $('#foto_renap_clean_pj').val();
		var contador = 0;
		var contador1 = 0;
		var contador2 = 0;
		var contador3 = 0;
		var datos_asociacion = new Array();
		var explotados_renap = new Array();
		var caracteristicas_fisicas = new Array();
		var datos_contacto = new Array();
		//var idEvento = $('#identificador_incidencia').val();
		var inup = $('#denX').val();
		var idEvento = "empty";
		var pintaCaracteristicas = "<?php echo $pintaCaracteristicas; ?>";
		var pintaContacto = "<?php echo $pintaContacto; ?>";
		var calidadJuridica = $('#personaJuricia').val();
		var quienSoy = $('#yoSoy').val();
		var estadoFisico = 'empty';


		$('#explotados_renap_pj').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;

			if(ident == 'pj_r_nacimiento'){
				var h = new Array();
				h = valor.split('/');
				valor = h[2]+"-"+h[1]+"-"+h[0];
			}
			
			explotados_renap[contador]= ident+ '~' +valor;   
	        contador = contador +1;
	        //alert('elemento.id='+ident+ ', elemento.value=' +valor);
		});
		
		if(pintaCaracteristicas == '1')
		{
			$('#caracteristicas_fisicas_pj').find(':input').each(function(){
				var elemento = this;
				var valor = elemento.value;
				var ident = elemento.id;
				
				caracteristicas_fisicas[contador1]= ident+ '~' +valor;   
		        contador1 = contador1 +1;
			});
		}

		if(pintaContacto == '1')
		{
			$('#datos_contacto_pj').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;
			
			datos_contacto[contador2]= ident+ '~' +valor;   
	        contador2 = contador2 +1;
			});
		}

		if(quienSoy == 'pRelacionadas'){
			idEvento = $('#identificador_incidencia').val();
			estadoFisico = $('#estadoFisico').val();
		}

		if(inup == '1'){
			idEvento = $('#identificador_denuncia').val();
		}

		//alert(llave_clean);
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("Pjuridica/Save_PersonaJuridica"); ?>',
			data: 
			{
				datos_personales: explotados_renap.join('|'),
				caracteristicas_fisicas: caracteristicas_fisicas.join('|'),
				datos_contacto: datos_contacto.join('|'),
				llave:llave_clean,
				cui:cui_clean,
				foto:foto_clean,
				idEvento:idEvento,
				calidadJuridica:calidadJuridica,
				quienSoy:quienSoy,
				estadoFisico:estadoFisico
			},
			error: function()
			{
			$('#personasAddDiv').html('');
	        $('#personasAddDiv').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
			beforeSend: function()
			{
			$('#personasAddDiv').html('');
	        $('#personasAddDiv').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			success: function(id_persona_detalle)
			{	
			
				if(quienSoy == 'pRelacionadas'){

					$('#aTab6').attr('href','#tab6');
					$('#ili_objetos').attr('class','enabled');
					$('#i_objetos').removeClass('BotonClose');

					$('#calidadJuridica_dw').val('');
					$('#estadoFisico').val(''); 

					var IdsPersonas = $('#IdsPersonasApart').val();
			
					if(IdsPersonas == ''){
						$('#IdsPersonasApart').val(id_persona_detalle);
					}
					else{
						$('#IdsPersonasApart').val(IdsPersonas+","+id_persona_detalle);
					}
					$('#personasAddDiv').hide(500);
					$('#frm_PersonaJuridica').showListadoPersonasDos();
					$('#result_procesoModal').html('');
		            $('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>La persona ha sido guardada con éxito...</h4></div><div class=\"modal-footer\">'+
						'<button class=\"btn\" id=\"continuePersonButton\">Continuar</button>'+
						'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Ingresar otra persona</button>'
						);
					$('#procesoModal').modal('show');

					$('#continuePersonButton').click(function(){
						$('#tab5').hide(500);
						$('#tab6').show(500);
						$('#nav_incidencia li:eq(5) a').tab('show');
						$('#procesoModal').modal('hide'); 
					});

				}
				else{
					var IdsPersonas = $('#IdsPersonas').val();
				
					if(IdsPersonas == ''){
						$('#IdsPersonas').val(id_persona_detalle);
					}
					else{
						$('#IdsPersonas').val(IdsPersonas+","+id_persona_detalle);
					}
					$('#resultPersonaJ').hide(500);
					$('#frm_PersonaJuridica').showListadoPersonas();


				}
							$('#frm_PersonaJuridica').actualizaResumen();	
			},
		});
	}); //fin del submit del frm_PersonaJuridica

	$('#UtilizarDatosExtravio').click(function(){
		var dpi = $('#pj_r_dpi').val();
		var primer_nombre = $('#pj_r_primer_nombre').val();
		var segundo_nombre = $('#pj_r_segundo_nombre').val();
		var primer_apellido = $('#pj_r_primer_apellido').val();
		var segundo_apellido = $('#pj_r_segundo_apellido').val();
		var genero = $('#pj_r_genero').val();
		var nacimiento = $('#pj_r_nacimiento').val();

		$('#No_dpi').val(dpi);
		$('#primer_nombre').val(primer_nombre);
		$('#segundo_nombre').val(segundo_nombre);
		$('#primer_apellido').val(primer_apellido);
		$('#segundo_apellido').val(segundo_apellido);
		$('#genero').val(genero);
		$('#nacimiento').val(nacimiento);

		$('#Pj_resultado').hide(500);
		$('#Pj_resultado').html('');
		$('#MensajeAutocomplete').show(500);
		$('#MensajeAutocomplete').html('Los datos del formulario se han completado con la información de: <b>'+
					primer_nombre+' '+segundo_nombre+' '+primer_apellido+' '+segundo_apellido+'</b>, obtenidos de RENAP. '+
					'Verifique que la información sea correcta y continue.');

	});

}); //Fin del document.ready

</script>