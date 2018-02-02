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
$r_dpi = "";
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
$tipoDocumento = "Sin Documento";

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

	}
}


if(!empty($resultado))
{
	$alerta = "";
		
		$r_primer_nombre = $resultado['primer_nombre'];
		$r_segundo_nombre = $resultado['segundo_nombre'];
		$r_primer_apellido = $resultado['primer_apellido'];
		$r_segundo_apellido = $resultado['segundo_apellido'];
		$r_genero = $resultado['genero'];
		$r_nacimiento = $resultado['fecha_nacimiento'];
		$r_pais_nacimiento = $resultado['pais_nacimiento'];
		$r_dpi = $resultado['dpi'];
		$r_departamento = $resultado['depto_nacimiento'];
		$r_municipio = $resultado['munic_nacimiento'];
		$r_ecivil = $resultado['estado_civil'];
		$r_nacionalidad = $resultado['nacionalidad'];
		$r_npadre = $resultado['nombre_padre'];
		$r_nmadre = $resultado['nombre_madre'];
		$r_foto = $resultado['foto'];
		$r_orden_cedula = $resultado['orden_cedula'];
		$r_registro_cedula = $resultado['registro_cedula'];
		
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

		if(empty($r_dpi))
		{
			$cui_clean = "";
		}
		else
		{
			$cui_clean = $r_dpi;
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
			$foto = foto_base64_clean($r_foto);
			$r_foto = "data:image/jpg;base64,".$foto;
			$foto_clean = $resultado['foto'];
		}
		if ($resultado['solvente']==1) {
			 $OrdenCaptura = "<div style='font-size:18px; text-align:center; font-weight:700;' class='alert alert-error' id='conOrden'> Éste DPI reporta  Órden(es) de Captura Vigentes.</div>";

			# code...
		}else{

			 $OrdenCaptura = "<div style='font-size:18px; text-align:center; font-weight:700;' class='alert alert-success' id=''>
		No Tiene Ordenes de Captura Vigentes.</div>";
		}

	/*	
		if(!empty($r_dpi))
		{
			
		$OrdenCapturaRes = $WSConsulta->ObtenerNumeroCapturasDpi($r_dpi);
		//$OrdenCapturaRes=array();
		
		if($OrdenCaptura && $OrdenCapturaRes>0)
		{
			 $OrdenCaptura = "<div style='font-size:18px; font-weight:700;' class='alert alert-error' id='conOrden'>
		Éste DPI reporta ".$OrdenCapturaRes." Órden(es) de Captura Vigentes.</div>";
		}
		
		}*/

		$llave_clean=$llave;
		$read_only = "readonly disabled";

	

}


function foto_base64_clean($foto='')
{

    if(isset($foto) && !empty($foto) && strlen($foto)>300){
        $xml = new SimpleXMLElement($foto);
        $newdataset = $xml->children();
        $objetos = get_object_vars($newdataset);
        $fotica=$objetos['PortraitImage'];
        $a=$fotica;
    }
    else{
        $a = NULL;
    }
    return $a;
}


?>

<div class="row-fluid">
					
					
					<div class="span12">
						<br>
						<?php echo $OrdenCaptura; ?>
					</div>
				</div>
<div class="well" style="display:none;">
	<div class="row-fluid">
		<div class="span4">
			<p class="campotit">Llave</p>
			<input class="span12" type="text" id="llave_renap_clean" value="<?php echo $llave_clean; ?>">
		</div>
		<div class="span4">
			<p class="campotit">CUI</p>
			<input class="span12" type="text" id="cui_renap_clean" value="<?php echo $cui_clean; ?>">
		</div>
		<div class="span4">
			<p class="campotit">Foto</p>
			<input class="span12" type="text" id="foto_renap_clean" value="<?php echo $foto_clean; ?>">
		</div>

	</div>
</div>

<div class="well">
	<?php echo $alerta; ?>

	<form id="frm_persona">
		<legend>Datos Personales</legend>
		<div id="explotados_renap">
			<div class="row-fluid">
				<div class="span10">
					<div class="row-fluid">
					<div class="span3">
						<p class="campotit">Primer Nombre</p>
						<input id="r_primer_nombre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_primer_nombre; ?>" required/>
					</div>
					<div class="span3">
						<p class="campotit">Segundo Nombre</p>
						<input id="r_segundo_nombre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_segundo_nombre; ?>">
					</div>
					<div class="span3">
						<p class="campotit">Primer Apellido</p>
						<input id="r_primer_apellido" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_primer_apellido; ?>" required/>
					</div>
					<div class="span3">
						<p class="campotit">Segundo Apellido</p>
						<input id="r_segundo_apellido" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_segundo_apellido; ?>">
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<p class="campotit">Género</p>
						<select required id ="r_genero" class ="span12"  <?php echo $read_only; ?>>
							<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
							<option value ="MASCULINO">MASCULINO</option>
							<option value ="FEMENINO">FEMENINO</option>
						</select>
					</div>
					<div class="span3">
						<?php 
							if(!empty($r_dpi)){
							$tipoDocumento = "DPI";
						?>
						<p class="campotit">DPI</p>
						<input id="r_dpi" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_dpi; ?>">
						<?php 
							}else{
						?>
						<div align="center">
							<div class="btn-group" align="left">
								<label class="dropdown-toggle campotit" data-toggle="dropdown" style="cursor: pointer;"><span id="LabelDocument">Sin Documento </span><i class="icon-chevron-down BotonClose"></i></label>
								<ul class="dropdown-menu">
							      <li><a class="cambiaElLabel">DPI</a></li>
							      <li><a class="cambiaElLabel">Pasaporte</a></li>
							      <li><a class="cambiaElLabel">Sin Documento</a></li>
							    </ul>
							</div>
						</div>
						<input id="r_dpi" class="span12" type="text" readonly value="--">
						<?php 
							}
						?>
						<input id="r_tipo_ident" class="span12" type="text" disabled value="<?php echo $tipoDocumento; ?>" style="display:none;">
					</div>
					<div class="span3">
						<p class="campotit">Fecha de Nacimiento</p>
						<input required id="r_nacimiento" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_nacimiento; ?>" placeholder="dd/mm/aaaa">
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
					<input required id="r_nacionalidad" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo $r_nacionalidad; ?>">
				</div>
				<div class="span3">
					<p class="campotit">Estado Civil</p>
					<select required id ="r_ecivil" class ="span12"  <?php echo $read_only; ?>>
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="SOLTERO">SOLTERO</option>
						<option value ="CASADO">CASADO</option>
					</select>
				</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						<p class="campotit">Nombre Padre</p>
						<input required id="r_npadre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo strtoupper($r_npadre); ?>">
					</div>
					<div class="span6">
						<p class="campotit">Nombre Madre</p>
						<input required id="r_nmadre" class="span12" type="text" <?php echo $read_only; ?> value="<?php echo strtoupper($r_nmadre); ?>">
					</div>
					
				</div>

			
				</div>

				<div class="span2">
					<center><img class="imagen_renap" src='<?php echo $r_foto; ?>'/></center>
				</div>
			</div>
		</div><!-- fin div explotados_renap --> 
<!--
		<legend>Características Físicas</legend>
		<div id="caracteristicas_fisicas">
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
					<select id="r_colorojos_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Verdes">Verdes</option>
						<option value ="Marron Obscuro">Marron Obscuro</option>
						<option value ="Castaño">Castaño</option>
						<option value ="Azul Verdoso">Azul Verdoso</option>
						<option value ="Gris">Gris</option>
						<option value ="Negro">Negro</option>
					</select>
				</div>
				<div class="span2">
					<p class="campotit">Peso</p>
					<div class="input-append">
						<input class="span10" title="Este campo es de tipo numerico" id ="r_peso_cf"  type="text" pattern="([0-9]+)+(\.[0-9]+)?$">
						<span class="add-on">lbs</span>
					</div> 
				</div>
			</div>

			< ************************* ****************************** ************************>
			<div class="row-fluid">
				<div class="span2">
					<p class="campotit">Estatura</p>
					<div class="input-append">
						<input class="span10" title="Este campo es de tipo numerico" id ="r_estatura_cf"  type="text" pattern="([0-9]+)+(\.[0-9]+)?$">
						<span class="add-on">mts</span>
					</div> 
				</div>
				<div class="span2">
					<p class="campotit">Color de Piel</p>
					<select id="r_colorpiel_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Blanca">Blanca</option>
						<option value ="Negra">Negra</option>
						<option value ="Marron">Marron</option>
						<option value ="Marron Claro">Marron Claro</option>
						<option value ="Marron Obscuro">Marron Obscuro</option>
					</select>
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
					<select id="r_tiponariz_cf" class="span12">
						<option value ="" disabled selected style='display:none;'>Seleccione una Opción</option>
						<option value ="Alargada">Alargada</option>
						<option value ="Pequeña">Pequeña</option>
						<option value ="Grande y ancha">Grande y ancha</option>
						<option value ="Respingona">Respingona</option>
						<option value ="Corta">Corta</option>}
						<option value ="Huesuda">Huesuda</option>
						<option value ="Chata">Chata</option>
					</select>
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

			< ************************* ****************************** ************************* >
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
-->
		<legend style="padding-top:2%;">Datos de Contacto</legend>
		<div id="datos_contacto">
			<div class="row-fluid">
				<div class="span2">
					<p class="campotit">Teléfono</p>
					<input id="r_telefono_cnt" title="Ingresa un numero de telefono valido, sin guiones ni espacios. Ej:45678912" class="span12 validaCampoNumerico" type="text" placeholder="Teléfono de contacto" pattern="[0-9]{8}" >
				</div>
				<div class="span2">
					<p class="campotit">Email</p>
					<input id="r_email_cnt" title="Ingrese El Correo Electronico Ej:correo@email.com" class="span12" type="email" placeholder="Email de Contacto">
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
					<input id="r_dirección_cnt" class="span12" type="text" placeholder="Dirección de Contacto" required>
				</div>
			</div>
		</div>

		<legend style="padding-top:2%;"></legend>
		<div align="right">
			<button type="submit" class="btn btn-primary">Guardar Denunciante</button>
		</div>
	</form>
</div>


<script type="text/javascript">

$(document).ready(function(){

	$('#r_telefono_cnt').tooltip();
	$('#r_email_cnt').tooltip();
	$('#r_profesion_cnt').tooltip({title:'Ingrese la Profesión del Denunciante'});
	$('#r_lugar_trabajo_cnt').tooltip({title:'Lugar Donde Labora El Denunciante'});
	$('#r_dirección_cnt').tooltip({title:'Direccion Donde Reside El Denunciante'});


	var pn = '<?php echo $r_pais_nacimiento; ?>';

	if(pn ==''){
		$('#r_pais_nacimiento').val('GUATEMALA');
	}else{
		$('#r_pais_nacimiento').val(pn);	
	}

	var g = '<?php echo $r_genero; ?>';
	$('#r_genero').val(g);

	var civil = '<?php echo $r_ecivil; ?>';
	$('#r_ecivil').val(civil);

	$('#r_nacimiento').datepicker({
	    format: "dd/mm/yyyy",
	    todayBtn: "linked",
	    language: "es"
	});  


	$('.cambiaElLabel').click(function(){
		var valorNuevo = $(this).text();
		$('#r_dpi').removeAttr('readonly');
		$('#r_dpi').removeAttr('value');
		if(valorNuevo == "Sin Documento")
		{
			$('#r_dpi').attr('readonly','true');
			$('#r_dpi').attr('value', '--');
		}
			$('#r_tipo_ident').val(valorNuevo);
			$('#LabelDocument').text(valorNuevo+" ");
	});

	$('#conOrden').tooltip({html:true,title:'Verifique ésta persona con el Sistema de Antecedentes para determinar su captura',placement:'bottom'});
	$('#conOrden').tooltip('show');

	$('#explotados_renap').find(':input').each(function() {
	var elemento = this;
	var valor = elemento.value;
	var ident = elemento.id;

	if( valor =='' || valor ==' ')
	{
		$("#"+ident).removeAttr("readonly");
		$("#"+ident).removeAttr("disabled");
	}
		//alert('elemento.id='+ elemento.id + ', elemento.value=' + elemento.value); 
	}); //fin del each

	$('#frm_persona').submit(function(e){
		e.preventDefault();
		var llave_clean = $('#llave_renap_clean').val();
		var cui_clean = $('#cui_renap_clean').val();
		var foto_clean = $('#foto_renap_clean').val();
		var contador = 0;
		var contador1 = 0;
		var contador2 = 0;
		var contador3 = 0;
		var datos_asociacion = new Array();
		var explotados_renap = new Array();
		var caracteristicas_fisicas = new Array();
		var datos_contacto = new Array();
		var inup = $('#denX').val();
		var hayHechos = $('#detX').val();
		var idEvento = "empty";
		var email = $('#r_email_cnt').val();
		
		if($("#es_asociacion").is(":checked"))
		{
			//alert('esta es una asoc');
			
			$('#datos_asociacion').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;
			
			datos_asociacion[contador3]= ident+ '~' +valor;   
	        contador3 = contador3 +1;
	        //alert('elemento.id='+ident+ ', elemento.value=' +valor);
			});

		}

		$('#explotados_renap').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;

			if(ident == 'r_nacimiento'){
				var h = new Array();
				h = valor.split('/');
				valor = h[2]+"-"+h[1]+"-"+h[0];
			}

			explotados_renap[contador]= ident+ '~' +valor;   
	        contador = contador +1;
	        //alert('elemento.id='+ident+ ', elemento.value=' +valor);
		});

		$('#caracteristicas_fisicas').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;
			
			caracteristicas_fisicas[contador1]= ident+ '~' +valor;   
	        contador1 = contador1 +1;
		});

		$('#datos_contacto').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;
			
			datos_contacto[contador2]= ident+ '~' +valor;   
	        contador2 = contador2 +1;
		});

		if(inup == '1'){
			idEvento = $('#identificador_denuncia').val();

			if(hayHechos == '1'){
				//Confirma si hay hechos vinculados con el denunciante
				$.ajax({
					type:'POST',
					url: '<?php echo Yii::app()->createUrl("Denuncia/Verify_update_denunciante"); ?>',
					data:{
						idEvento:idEvento
					},
					success:function(res){
						if(res == "empty"){
							saveDenunciante(datos_asociacion,explotados_renap,caracteristicas_fisicas,datos_contacto,llave_clean,cui_clean,foto_clean,idEvento,email);
						}
						else{
							$('#result_procesoModal').html('');
							$('#result_procesoModal').html(res);
							$('#procesoModal').modal('show'); 
						}
					}
				})
			}
			else{
				saveDenunciante(datos_asociacion,explotados_renap,caracteristicas_fisicas,datos_contacto,llave_clean,cui_clean,foto_clean,idEvento,email);
			}

		}
		else{
			saveDenunciante(datos_asociacion,explotados_renap,caracteristicas_fisicas,datos_contacto,llave_clean,cui_clean,foto_clean,idEvento,email);
		}
	}); //fin del submit del frm_persona

	saveDenunciante = function(datos_asociacion,explotados_renap,caracteristicas_fisicas,datos_contacto,llave_clean,cui_clean,foto_clean,idEvento,email,personasHechos)
	{
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("Denuncia/Save_denunciante"); ?>',
			data: 
			{
				datos_asociacion: datos_asociacion.join('|'),
				datos_personales: explotados_renap.join('|'),
				caracteristicas_fisicas: caracteristicas_fisicas.join('|'),
				datos_contacto: datos_contacto.join('|'),
				llave:llave_clean,
				cui:cui_clean,
				foto:foto_clean,
				idEvento:idEvento,
				email:email,
				personasHechos:personasHechos
			},
			beforeSend: function()
			{
				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
				$('#procesoModal').modal('show'); 
			},
			success: function(id_denuncia)
			{
				$('#denX').val('1');
				$('#frm_persona').actualizaResumen();
				$('#identificador_denuncia').val(id_denuncia);
				$('#result_procesoModal').html('');
				$('#result_procesoModal').html('<div class=\"modal-body\"><h4>Los datos del denunciante se han registrado correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
				$('#aTab2').attr('href','#tab2');
				$('#dli_ubicacion').attr('class','enabled');
				$('#i_ubicacion').removeClass('BotonClose');                      
				$('#tab1').hide(50);
				$('#tab2').show(50);
				$('#nav_denuncia li:eq(1) a').tab('show');
			},
		}); //Fin del ajax
	}

}); //Fin del document.ready

</script>