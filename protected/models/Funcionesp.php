<?php
include "lib/codigoqr/qrlib.php";
class Funcionesp
{

public function numeroextencion($numero) {
		$sql = " SELECT evento_num  FROM sipol.tbl_evento  where id_evento_extiende=".$numero." order by evento_num DESC limit 1 ;";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($resultado)==0)
		{}else
		{
			foreach($resultado as $key => $value)
			{
				$valor = $value;                       
			}                   		
			return $valor;
		}	
}

public function outhtml($cadena)
	{
	///tratamiento para imprimir html en tcpdf
$cadena= str_replace("'", '"', $cadena);
$cadena = str_replace("\n", "<br>", $cadena);
$cadena=nl2br ($cadena);
$cadena=mb_convert_case($cadena, MB_CASE_UPPER, "UTF-8");
$cadena= str_replace("&NBSP;", '', $cadena);
$pad_me = "Test String"; 
$cadena='<div style="text-align:justify">'.$cadena."</div>";
//fin tratamiento para imprimir tcpdf
return $cadena;
	}

	public function amayuscula($cadena)
	{
		$resp=strtoupper($cadena);
return $resp;
	}

	public function amayusculaed($cadena)
	{$cadena=utf8_encode($cadena);
		$resp=mb_convert_case($cadena, MB_CASE_UPPER, "UTF-8");
		$resp=utf8_decode($resp);
return $resp;
	}
	public function generarpass()
	{
		$DesdeLetra = "a"; 
		$HastaLetra = "z"; 
		$DesdeNumero = 1; 
		$HastaNumero = 9; 
		$PassFinal = "";
		$IndicadorInicio = 1;
		$IndicadorFinal = 2;
		$Indicador = 0;
		for ($i=1; $i <= 6 ; $i++) { 
			$Indicador = rand($IndicadorInicio, $IndicadorFinal); 
			if ($Indicador == 2) {
				$letraAleatoria = chr(rand(ord($DesdeLetra), ord($HastaLetra))); 
				$PassFinal =  $PassFinal.$letraAleatoria;
			}else{
				$numeroAleatorio = rand($DesdeNumero, $HastaNumero); 
				$PassFinal =  $PassFinal.$numeroAleatorio;
			}
		}
		return $PassFinal;
	}
	public function datostableopciones()
	{
		$sql = "select qr_tbl_evento as rutaservidor, png_web_dir_tbl_evento as imagen, urldenuncia_tbl_evento as urlqr from sipol_catalogos.config_opciones";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($resultado)==0)
		{

		}else
		{
			foreach($resultado as $key => $value)
			{
				$valor = json_encode($value);
				$nuevo = json_decode($valor);                       
			}                   		
			return $nuevo;
		}	
	}
	public function generarqrdenuncias($variablesalidaqr)
	{	
		$opcionestabla = $this->datostableopciones();
		$rutaservidor = trim($opcionestabla->rutaservidor);
		$imagen =	 trim($opcionestabla->imagen);                   		
		$urlqr = trim($opcionestabla->urlqr);
		$enviourl = "&par=".$variablesalidaqr;
		//$PNG_TEMP_DIR = dirname('/var/www/default/sipol_4/lib/codigoqr').'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		//$PNG_TEMP_DIR = dirname('C:\wamp\apps\repositorios\wsipol\lib\codigoqr').'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_TEMP_DIR = dirname($rutaservidor).'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = $imagen;

		$PNG_TEMP_DIR = Yii::getPathOfAlias('webroot').'/lib/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = Yii::app()->getBaseUrl(true).'/lib/codigoqr/temp/';

		//$PNG_WEB_DIR = 'http://localhost/sipol_desa/lib/codigoqr/temp/';
		if (!file_exists($PNG_TEMP_DIR))
			mkdir($PNG_TEMP_DIR);
		$filename = $PNG_TEMP_DIR.'sipol.png';
		$errorCorrectionLevel = 'H';
		$matrixPointSize = 9;
		$urldenuncia = $urlqr.'denuncia'.$enviourl."";
		//$urldenuncia = 'http://localhost/sipol_desa/index.php?r=Reportespdf/denuncia'.$enviourl."";    
		if (isset($urldenuncia)) {           
			$filename = $PNG_TEMP_DIR.'sipol'.md5($urldenuncia.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			QRcode::png($urldenuncia, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   

		} else {    
			QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		}  
		return $PNG_WEB_DIR.basename($filename);
	}
	public function generarqrincidencias($variablesalidaqr)
	{	
		$opcionestabla = $this->datostableopciones();
		$rutaservidor = trim($opcionestabla->rutaservidor);
		$imagen =	 trim($opcionestabla->imagen);                   		
		$urlqr = trim($opcionestabla->urlqr);
		$enviourl = "&par=".$variablesalidaqr;
		$PNG_TEMP_DIR="";		
		//$PNG_TEMP_DIR = dirname('C:\wamp\apps\repositorios\wsipol\lib\codigoqr').'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_TEMP_DIR = dirname($rutaservidor).'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = $imagen;
		//$PNG_WEB_DIR = 'http://localhost/wsipol/lib/codigoqr/temp/';
		if (!file_exists($PNG_TEMP_DIR))
			mkdir($PNG_TEMP_DIR);
		$filename = $PNG_TEMP_DIR.'sipol.png';
		$errorCorrectionLevel = 'H';
		$matrixPointSize = 9;
		$urldenuncia = $urlqr.'denuncia'.$enviourl."";
		//$urldenuncia = 'http://localhost/wsipol/index.php?r=Reportespdf/incidencia'.$enviourl."";    
		if (isset($urldenuncia)) {           
			$filename = $PNG_TEMP_DIR.'sipol'.md5($urldenuncia.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			QRcode::png($urldenuncia, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   

		} else {    
			QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		}  
		return $PNG_WEB_DIR.basename($filename);
	}
	public function generarqrextravios($variablesalidaqr)
	{	
		$opcionestabla = $this->datostableopciones();
		$rutaservidor = trim($opcionestabla->rutaservidor);
		$imagen =	 trim($opcionestabla->imagen);                   		
		$urlqr = trim($opcionestabla->urlqr);
		$enviourl = "&par=".$variablesalidaqr;
		//$PNG_TEMP_DIR = dirname('/var/www/default/sipol_4/lib/codigoqr').'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		//$PNG_TEMP_DIR = dirname('C:\wamp\apps\repositorios\wsipol\lib\codigoqr').'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_TEMP_DIR = dirname($rutaservidor).'/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = $imagen;

		$PNG_TEMP_DIR = Yii::getPathOfAlias('webroot').'/lib/codigoqr/temp'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = Yii::app()->getBaseUrl(true).'/lib/codigoqr/temp/';

		//$PNG_WEB_DIR = 'http://localhost/sipol_desa/lib/codigoqr/temp/';
		if (!file_exists($PNG_TEMP_DIR))
			mkdir($PNG_TEMP_DIR);
		$filename = $PNG_TEMP_DIR.'sipol.png';
		$errorCorrectionLevel = 'H';
		$matrixPointSize = 9;
		$urldenuncia = $urlqr.'denuncia'.$enviourl."";
		//$urldenuncia = 'http://localhost/sipol_desa/index.php?r=Reportespdf/denuncia'.$enviourl."";    
		if (isset($urldenuncia)) {           
			$filename = $PNG_TEMP_DIR.'sipol'.md5($urldenuncia.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			QRcode::png($urldenuncia, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   

		} else {    
			QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		}  
		return $PNG_WEB_DIR.basename($filename);
	}
	public function numeroletrasdigito($xcifra)
	{
		$devolver= "NUEVO";
		if($xcifra == '0')
		{
			$devolver=  "CERO";

		}else if($xcifra == '1')
		{
			$devolver=  "UNO";

		}else if($xcifra == '2')
		{
			$devolver=  "DOS";

		}else if($xcifra == '3')
		{
			$devolver=  "TRES";

		}else if($xcifra == '4')
		{
			$devolver=  "CUATRO";

		}else if($xcifra == '5')
		{
			$devolver=  "CINCO";

		}else if($xcifra == '6')
		{
			$devolver=  "SEIS";

		}else if($xcifra == '7')
		{
			$devolver=  "SIETE";

		}else if($xcifra == '8')
		{
			$devolver=  "OCHO";

		}else if($xcifra == '9')
		{
			$devolver=  "NUEVE";

		}else if($xcifra == '-')
		{
			$devolver=  "GUION";

		}

		return $devolver;
	}
	public function numtoletras($xcifra,$tipo='P')
	{
		$xarray = array(0 => "Cero", '00' => "Cero",
			1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
			"DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
			"VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
			100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
			);
		$xcifra = trim($xcifra);
		$xlength = strlen($xcifra);
		$xpos_punto = strpos($xcifra, ".");
		$xaux_int = $xcifra;
		$xdecimales = "00";
		if (!($xpos_punto === false)) {
			if ($xpos_punto == 0) {
				$xcifra = "0" . $xcifra;
				$xpos_punto = strpos($xcifra, ".");
			}
			$xaux_int = substr($xcifra, 0, $xpos_punto);
			$xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2);
		}
		$XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); 
	    //Yii::log('', CLogger::LEVEL_ERROR, $XAUX);
		$xcadena = "";
		for ($xz = 0; $xz < 3; $xz++) {
			$xaux = substr($XAUX, $xz * 6, 6);
			$xi = 0;
			$xlimite = 6; 
			$xexit = true; 
			while ($xexit) {
				if ($xi == $xlimite) {
					break; 
				}

				$x3digitos = ($xlimite - $xi) * -1; 
				$xaux = substr($xaux, $x3digitos, abs($x3digitos)); 
	            //Yii::log('', CLogger::LEVEL_ERROR, $xaux);
				for ($xy = 1; $xy < 4; $xy++) { 
					switch ($xy) {
						case 1:
						if (substr($xaux, 0, 3) < 100) { 

						} else {
							$key = (int) substr($xaux, 0, 3);
							if (TRUE === array_key_exists($key, $xarray)){  
								$xseek = $xarray[$key];
								$xsub = $this->subfijo($xaux); 
								if (substr($xaux, 0, 3) == 100)
									$xcadena = " " . $xcadena . " CIEN " . $xsub;
								else
									$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
								$xy = 3; 
							}
							else { 
								$key = (int) substr($xaux, 0, 1) * 100;
								$xseek = $xarray[$key]; 
								$xcadena = " " . $xcadena . " " . $xseek;
							} 
						} 
						break;
						case 2: 
						if (substr($xaux, 1, 2) < 10) {

						} else {
							$key = (int) substr($xaux, 1, 2);
							if (TRUE === array_key_exists($key, $xarray)) {
								$xseek = $xarray[$key];
								$xsub = $this->subfijo($xaux);
								if (substr($xaux, 1, 2) == 20)
									$xcadena = " " . $xcadena . " VEINTE " . $xsub;
								else
									$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
								$xy = 3;
							}
							else {
								$key = (int) substr($xaux, 1, 1) * 10;
								$xseek = $xarray[$key];
								if (20 == substr($xaux, 1, 1) * 10)
									$xcadena = " " . $xcadena . " " . $xseek;
								else
									$xcadena = " " . $xcadena . " " . $xseek . " Y ";
							} 
						} 
						break;
						case 3: 
	                    	//Yii::log('', CLogger::LEVEL_ERROR, 'case 3:'.substr($xaux, 2, 1));
						if (substr($xaux, 2, 1) < 1) { 

						} else {

							$key = (int) substr($xaux, 2, 1);
							$xseek = $xarray[$key]; 
							$xsub = $this->subfijo($xaux);
							$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
							if($tipo == 'H' && $xcifra == 1) $xcadena=trim($xcadena)."A";
	                            //Yii::log('', CLogger::LEVEL_ERROR, 'case 3:'.$xcadena);
						}
						break;
	                    /*default:
	                    	$xcadena = "UN";
	                    	break;*/
	                    }
	                } 
	                $xi = $xi + 3;
	            } 
	        //Yii::log('', CLogger::LEVEL_ERROR, 'case 3:'.$xcifra);
	            if (substr(trim($xcadena), -5, 5) == "ILLON") 
	            	$xcadena.= " DE";

	            if (substr(trim($xcadena), -7, 7) == "ILLONES") 
	            	$xcadena.= " DE";
	            if (trim($xaux) != "") {
	            	switch ($xz) {
	            		case 0:
	            		if (trim(substr($XAUX, $xz * 6, 6)) == "1")
	            			$xcadena.= "UN BILLON ";
	            		else
	            			$xcadena.= " BILLONES ";
	            		break;
	            		case 1:
	            		if (trim(substr($XAUX, $xz * 6, 6)) == "1")
	            			$xcadena.= "UN MILLON ";
	            		else
	            			$xcadena.= " MILLONES ";
	            		break;
	            		case 2:
	            		if ($xcifra < 1) {
	            			$xcadena = "";
	            		}
	            		if ($xcifra > 1 && $xcifra < 2) {
	                    	//Yii::log('', CLogger::LEVEL_ERROR, 'case if :'.$xcifra);
	            			$xcadena = "";
	            		}
	            		if ($xcifra >= 2) {
	            			$xcadena.= ""; 
	            		}
	            		break;
	            	} 
	            } 
	            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); 
	            $xcadena = str_replace("  ", " ", $xcadena); 
	            $xcadena = str_replace("UN UN", "UN", $xcadena); 
	            $xcadena = str_replace("  ", " ", $xcadena); 
	            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena);
	            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); 
	            $xcadena = str_replace("DE UN", "UN", $xcadena);
	        } 
	        $retorna = trim($xcadena);
	    //Yii::log('', CLogger::LEVEL_ERROR, $retorna);
	        if(substr($retorna, -2) == "UNO")
	        {
	        //$retorna = $retorna."O";
	        }
	        return $retorna;
	    }
	    public function subfijo($xx)
	    { 
	    	$xx = trim($xx);
	    	$xstrlen = strlen($xx);
	    	if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
	    		$xsub = "";
	    	if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
	    		$xsub = "MIL";
	    	return $xsub;
	    }
	    public function mes($num)
	    {
	    	$meses = array('Error', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
	    		'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	    	$num_limpio = $num >= 1 && $num <= 12 ? intval($num) : 0;
	    	return $meses[$num_limpio];
	    }
	    public function fechaATexto($fecha, $formato = 'c')
	    {
	    	$partes = array();
	    	$partes =explode('-', $fecha);
	    	$mes = ' de ' . $this->mes($partes[1]) . ' de ';
	    	if ($formato == 'u') {
	    		$mes = strtoupper($mes);
	    	} elseif ($formato == 'l')
	    	{
	    		$mes = strtolower($mes);
	    	}
	    	return $this->numtoletras($partes[2]).$mes.$this->numtoletras($partes[0]);
	    }
	    public function horaALetras($a)
	    {
	    	$salida = array();
	    	$bodytag = str_replace("{", "",$a);
	    	$bodytag = str_replace("}", "",$bodytag);

	    	$salida = explode(":", $bodytag);

	    	if(strcasecmp($salida[1], '00') == 0)
	    	{
	    		$minutos = "cero";
	    	}
	    	else
	    	{
	    		$minutos = $this->numtoletras($salida[1],'M');
	    	}


	    	if(strcasecmp($salida[0], '00') == 0)
	    	{
	    		$hora = "Cero";
	    	}
	    	else
	    	{
	    		$hora = $this->numtoletras($salida[0],'H');
	    	}



	    	$horaALetras = $hora." Hora(s) con ".$minutos." Minutos";

	    	return $horaALetras;
	    }
	    public function getPersonaJuridica($valor)
	    {
	    	$sql = "SELECT  descripcion_tipo_persona
	    	FROM sipol_catalogos.cat_tipo_persona
	    	WHERE id_tipo_persona = '".$valor."';";

	    	$resultado = Yii::app()->db->createCommand($sql)->queryAll();

	    	foreach($resultado as $key => $value)
	    	{
	    		foreach ($value as $llave => $valor) {
	    		}
	    	}

	    	return $valor;
	    }

	    public function getEstadoPersona($valor)
	    {
	    	$sql = "SELECT  estado_persona
	    	FROM sipol_catalogos.cat_estado_persona
	    	WHERE id_estado_persona = '".$valor."';";

	    	$resultado = Yii::app()->db->createCommand($sql)->queryAll();

	    	foreach($resultado as $key => $value)
	    	{
	    		foreach ($value as $llave => $valor) {
	    		}
	    	}

	    	return $valor;
	    }

	    public function ListPersonaJuridica($ids)
	    {
	    	$r = array();
	    	$cont = 0;
	    	$sql = "SELECT pd.id_persona_detalle, p.datos, pd.id_tipo_persona, pd.id_estado_persona, ep.estado_persona
	    	FROM sipol.tbl_persona_detalle pd
	    	LEFT JOIN sipol.tbl_persona p ON p.id_persona = pd.id_persona
	    	LEFT JOIN sipol_catalogos.cat_estado_persona ep ON pd.id_estado_persona = ep.id_estado_persona
	    	WHERE pd.id_persona_detalle IN (".$ids.");";

	    	$resultado = Yii::app()->db->createCommand($sql)->queryAll();

	    	foreach($resultado as $key => $value)
	    	{
	    		foreach ($value as $llave => $valor) {}

	    			$r[$cont] = $value;
	    		$cont = $cont+1;
	    	}
	    	return $r;
	    }
	    public function ListPersonaJuridicaXed($eventoDetalle)
	    {
	    	$r = array();
	    	$cont = 0;
	    	$sql = "SELECT pd.id_persona_detalle, p.datos, pd.id_tipo_persona, pd.id_estado_persona, p.datos_contacto
	    	FROM sipol.tbl_persona_detalle pd
	    	LEFT JOIN sipol.tbl_persona p ON p.id_persona = pd.id_persona
	    	WHERE pd.id_evento_detalle IN (".$eventoDetalle.");";

	    	$resultado = Yii::app()->db->createCommand($sql)->queryAll();

	    	foreach($resultado as $key => $value)
	    	{
	    		foreach ($value as $llave => $valor) {}

	    			$r[$cont] = $value;
	    		$cont = $cont+1;
	    	}
	    	return $r;
	    }
	    public function ExplotaDosNiveles($JsonExplota)
	    {
	    	$nivel_uno = json_decode($JsonExplota);
		foreach ($nivel_uno as $nivel_uno_titulo => $nivel_dos) {}//fin nivel 1	
		
		return $nivel_dos;
	}
	public function ListPJ_porEventoDet($eventoDetalle)
	{		
		//$funciones = new Funcionesp;
		$r = $this->ListPersonaJuridicaXed($eventoDetalle);
		$retorna = "";

		if(!empty($r))
		{
			$retorna = "<legend style='padding-top:1%; margin-bottom:0px;'></legend><div style='padding-left:2%; padding-right:2%'>";
			$retorna = $retorna."<legend class='legend'><h5 style='line-height:10px;'>PERSONAS RELACIONADAS EN ÉSTE HECHO</h5></legend>";
			
			$a = array();
			foreach ($r as $key => $value) 
			{
				$Primer_Nombre = "";
				$Segundo_Nombre = "";
				$Primer_Apellido = "";
				$Segundo_Apellido = "";
				$DatosDocumento = "";
				$id_persona_detalle = $value['id_persona_detalle'];
				$cerrar = "<button id='eliminar_hecho' type='button' 
				class='close eliminar_persona' data-dismiss='alert' id_persona_detalle='".$id_persona_detalle."'><i class='icon-trash'></i></button>";

				$persona = json_decode($value['datos']);
				$persona = (array) $persona;
				$cJuridica = $value['id_tipo_persona'];
				$cJuridica = $this->getPersonaJuridica($cJuridica);

				if(!empty($persona['Primer_Nombre'])) $Primer_Nombre = $persona['Primer_Nombre'];
				if(!empty($persona['Segundo_Nombre'])) $Segundo_Nombre = $persona['Segundo_Nombre'];
				if(!empty($persona['Primer_Apellido'])) $Primer_Apellido = $persona['Primer_Apellido'];
				if(!empty($persona['Segundo_Apellido'])) $Segundo_Apellido = $persona['Segundo_Apellido'];
				if(!empty($persona['Tipo_identificacion'])) $DatosDocumento = $persona['Tipo_identificacion'].": ".$persona['Numero_identificacion'];

				$nombreCompleto = ": ".$Primer_Nombre." ".$Segundo_Nombre." ".$Primer_Apellido." ".$Segundo_Apellido." - Identificación: ".$DatosDocumento.", ";

				//$retorna = $retorna.$cerrar;
				$retorna = $retorna."<b>".$cJuridica."</b>";
				$retorna = $retorna.$nombreCompleto;

			}

			$retorna = $retorna."~";
			$retorna = str_replace(", ~", "", $retorna);
			$retorna = $retorna."</div>";

		}//Fin de la condición

		return $retorna;
	}
	public function normalize_date($date)
	{  
		if(!empty($date))
		{ 
			$var = explode('/',str_replace('-','/',$date)); 
			return "$var[2]$var[1]$var[0]"; 
		}  
	}
	public function conteo_buzon_ingreso($id_usuario)
	{
		$sql = "select count(*) from soporte_aplicaciones.tbl_buzon where estado = 'true' and id_usuario =".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($resultado)==0)
		{

		}else
		{
			foreach($resultado as $key => $value)
			{
				$valor = json_encode($value);
				$nuevo = json_decode($valor);                       
			} 
			return $nuevo->count;
		}
	}
	public function re_tildes($cadena)
	{
		$search = array('&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&AACUTE;','&EACUTE;','&IACUTE;','&OACUTE;','&UACUTE;','&ntilde;','&Ntilde;','&NTILDE;','&nTILDE;' );
		$replace = array('Á','É','Í','Ó','Ú','Á','É','Í','Ó','Ú','Á','É','Í','Ó','Ú','Ñ','Ñ','Ñ','Ñ' );
		$cadena = str_replace($search , $replace, $cadena);
		return $cadena;
	}

	
	public function getAtributosObjeto($idObjeto)
	{
		$sql = "SELECT atributos
		FROM sipol.tbl_objetos
		WHERE id_objeto = ".$idObjeto;

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		$objeto = (object) $resultado[0];

		$atributos = json_decode($objeto->atributos);
		$atributos = (array) $atributos;

		foreach ($atributos as $key => $value) {
			$devuelve[$key] = $value;
		}

		return $devuelve;
	}




}
?>