<?php

$id_evento = '2445'; 
$conteo = "SELECT COUNT(id_evento_detalle) 
				FROM sipol.tbl_evento_detalle
				WHERE id_evento = ".$id_evento."
				AND id_hecho_denuncia IS NOT NULL";

$result = Yii::app()->db->createCommand($conteo)->queryAll();

foreach ($result as $key => $value) {
	$value = (object) $value;
	$cuantos = $value->count;

	$Funcionesp = new Funcionesp;
	$variablesalidaqr = "23";
	$opcionestabla = $Funcionesp->datostableopciones();
	$rutaservidor = trim($opcionestabla->rutaservidor);
    $imagen =	 trim($opcionestabla->imagen);                   		
    $urlqr = trim($opcionestabla->urlqr);
	$enviourl = "&par=".$variablesalidaqr;
	$PNG_TEMP_DIR="";		
	//$PNG_TEMP_DIR = dirname('/var/www/default/sipol_4/lib/codigoqr').'/codigoqr/temp'.DIRECTORY_SEPARATOR;
	//$PNG_TEMP_DIR = dirname('C:\wamp\apps\repositorios\wsipol\lib\codigoqr').'/codigoqr/temp'.DIRECTORY_SEPARATOR;
	$PNG_TEMP_DIR = dirname($rutaservidor).'/codigoqr/temp'.DIRECTORY_SEPARATOR;
	$PNG_WEB_DIR = $imagen;

	echo "<br>";
	echo $PNG_TEMP_DIR;
	echo "<br>";
	echo $PNG_WEB_DIR;
	echo "<br>";
	echo $urlqr;

	echo "<br>";
	echo "<br>";
	echo Yii::getPathOfAlias('webroot').'/lib/codigoqr/temp'.DIRECTORY_SEPARATOR;
	echo "<br>";
	echo Yii::app()->getBaseUrl(true).'/lib/codigoqr/temp/';
}

//var_dump($result);
//var_dump($cuantos);

?>
<div class="row-fluid">
	<div class="span3">
		<label class="campotit">Label1</label>
		<input type="text" class="span12">
	</div>
	<div class="span3">
		<label class="campotit">Select2</label>
		<select class="span12 opcionotros" name="companiatelefonica" id="companiatelefonica" nombre="Compania Telefonica">
			<option value="" disabled="" selected="" style="display:none;">Seleccione una Opción</option>
			<option value="TIGO">TIGO</option>
			<option value="CLARO">CLARO</option>
			<option value="MOVISTAR">MOVISTAR</option>
			<option value="OTROS">OTROS</option>
			<option value="OTROSVALIDAR">OTROS</option>
		</select>
	</div>
	<div class="span3">
		<label class="campotit">Label3</label>
		<input type="text" class="span12">
	</div>
	<div class="span3">
		<label class="campotit">Label4</label>
		<input type="text" class="span12">
	</div>
</div>
<div class="row-fluid">
	<div class="span3">
		<label class="campotit">Label5</label>
		<input type="text" class="span12">
	</div>
	<div class="span3">
		<label class="campotit">Label6</label>
		<input type="text" class="span12">
	</div>
	<div class="span3">
		<label class="campotit">Label7</label>
		<input type="text" class="span12">
	</div>
	<div class="span3">
		<label class="campotit">Select2</label>
		<select type="select" class="span12 opcionotros" name="compa" id="compa" nombre="Compania Telefonica">
			<option value="" disabled="" selected="" style="display:none;">Seleccione una Opción</option>
			<option value="TIGO">TIGO</option>
			<option value="CLARO">CLARO</option>
			<option value="MOVISTAR">MOVISTAR</option>
			<option value="OTROS">OTROS</option>
			<option value="OTROSVALIDAR">OTROS</option>
		</select>
	</div>
</div>

