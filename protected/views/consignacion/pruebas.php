<!--SELECT NAME=browser>
    <OPTGROUP LABEL="Firefox">
      <OPTION LABEL="2.0 or higher">
        Firefox 2.0 or higher
      </OPTION>
      <OPTION LABEL="1.5.x">Firefox 1.5.x</OPTION>
      <OPTION LABEL="1.0.x">Firefox 1.0.x</OPTION>
    </OPTGROUP>
    <OPTGROUP LABEL="Microsoft Internet Explorer">
      <OPTION LABEL="7.0 or higher">
        Microsoft Internet Explorer 7.0 or higher
      </OPTION>
      <OPTION LABEL="6.x">Microsoft Internet Explorer 6.x</OPTION>
      <OPTION LABEL="5.x">Microsoft Internet Explorer 5.x</OPTION>
      <OPTION LABEL="4.x">Microsoft Internet Explorer 4.x</OPTION>
    </OPTGROUP>
    <OPTGROUP LABEL="Opera">
      <OPTION LABEL="9.0 or higher">Opera 9.0 or higher</OPTION>
      <OPTION LABEL="8.x">Opera 8.x</OPTION>
      <OPTION LABEL="7.x">Opera 7.x</OPTION>
    </OPTGROUP>
    <OPTION>Safari</OPTION>
    <OPTION>Other</OPTION>
  </SELECT-->

<?php 

$WSConsulta = new WSConsulta;
$modelo_tilde = new SeparadorSilabas;
$numero = "empty";


$primer_nombre = "miguel";
$primer_nombre = $modelo_tilde->dividePalabra($primer_nombre);
$segundo_nombre = "augusto";
$segundo_nombre = $modelo_tilde->dividePalabra($segundo_nombre);
$primer_apellido = "gudiel";
$primer_apellido = $modelo_tilde->dividePalabra($primer_apellido);
$segundo_apellido = "";
$segundo_apellido = $modelo_tilde->dividePalabra($segundo_apellido);


$resultado = $WSConsulta->ConsultaLicencia($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$numero);
$resultado = json_decode($resultado);
print_r($resultado);

?>

<select class="span12" name="Pj_lista_llave_renap" size="7" id="Pj_lista_llave_renap" data-toggle="tooltip" data-original-title="Seleccione un elemento de la lista">

<?php
	$contador = 0;
	$e = " ";
	$edad = "";
	$tipoLicencia = "M";

	foreach ($resultado->registros as $value) 
	{
		#if($value->TIPO_LICENCIA == $tipoLicencia)
		#{
			echo "<option value='".$value->NUMERO_LICENCIA."~".$value->TIPO_LICENCIA."'>".$value->NOMBRE." - TIPO: ".$value->TIPO_LICENCIA."</option>";	
			$contador = $contador+1;
		#}
	}
?>
</select>

<?php 

	$expotado = array();
	$recibeNumero = "111703000203163~B";
	$explotado = explode("~", $recibeNumero);

	$numero = $explotado[0];
	$licenciaTipo = $explotado[1];
	$primer_nombre = "";
	$segundo_nombre = "";
	$primer_apellido = "";
	$segundo_apellido = "";

	$resultado = $WSConsulta->ConsultaLicencia($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$numero);
	$resultado = json_decode($resultado);
	print_r($resultado);
	$v = array();

	foreach ($resultado->registros as $key => $value) {
		if($value->TIPO_LICENCIA == $licenciaTipo)
		{
			$v = $value;
		}
	}
	
	$v = (array) $v;
	var_dump($v);

?>

<div class="well">
	<div class="row-fluid">
		<div class="span6">
			<label for="Lic_nombre_completo" class="campotit">Nombre Completo</label>
			<input type="text" class="span12" id="Lic_nombre_completo" value="<?php echo $v["NOMBRE"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_tipo_licencia" class="campotit">Tipo Licencia</label>
			<input type="text" class="span12" id="Lic_tipo_licencia" value="<?php echo $v["TIPO_LICENCIA"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_numero_licencia" class="campotit">Número de Licencia</label>
			<input type="text" class="span12" id="Lic_numero_licencia" value="<?php echo $v["NUMERO_LICENCIA"];?>" readonly>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span3">
			<label for="Lic_genero" class="campotit">Género</label>
			<input type="text" class="span12" id="Lic_genero" value="<?php echo $v["SEXO"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_nacimiento" class="campotit">Fecha de Nacimiento</label>
			<input type="text" class="span12" id="Lic_nacimiento" value="<?php echo $v["FECHA_NACIMIENTO"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_identificacion" class="campotit">Identificacion</label>
			<input type="text" class="span12" id="Lic_identificacion" value="<?php echo $v["NUMERO_DOCUMENTO"];?>" readonly>
		</div>
		<div class="span3">
			<label for="Lic_vencimiento" class="campotit">Fecha de Vencimiento</label>
			<input type="text" class="span12" id="Lic_vencimiento" value="<?php echo $v["FECHA_VENCIMIENTO"];?>" readonly>
		</div>
	</div>
	<legend style="margin-top:1%;"></legend>
	<div align="right">
		<button class="btn btn-info" type="button" id="UtilizarDatosLicencia">Utilizar Información</button>
	</div>
</div><!-- fin del well general -->


