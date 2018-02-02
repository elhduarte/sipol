<?php
//require_once('lib/reportpdf/fpdf.php');		
require_once('lib/reportpdf/tcpdf_import.php');	
require_once('lib/reportpdf/class.html2text/class.html2text.inc');	

$fun =new Funcionesp;	


if(isset($_GET['par']))
	{	
		try {
			//$tipo_papel =$_GET['nat'];
			$papel = "letter";
			$cordenada_papel = "";
			$validador_ger =  isset($_GET['nat']) ? $tipo_papel=$_GET['nat'] : false ;
		
				if($validador_ger== true)
				{
					if($tipo_papel=="1"){
						$papel = "letter";
						$cordenada_papel = 205;

					}else{
						$papel = "legal";
						$cordenada_papel = 315;
					}//fin termina el valor de tipo de papel
				}else{
					$papel = "letter";
					$cordenada_papel = 205;
				}

		
					
			$id_evento = $_GET['par'];

			$variableencript = new Encrypter;
			$idEvento = $variableencript->descompilarget($id_evento);
			$variablesalidaqr = $variableencript->encrypt($id_evento);
			$reportes = new Reportes;
			$decrypt = new Encrypter;
			$funciones = new Funcionesp;
			$encabezado = $reportes->Encabezadopdf($idEvento);

			//var_dump($encabezado);	
			//$qrdenuncia = $funciones->generarqrdenuncias($id_evento);
			//$_SESSION['qr'] = $qrdenuncia;
			$denunciante = $reportes->getDenunciantepdf($idEvento);
			$ubicacion = $reportes->getUbicacionDivpdf($idEvento);
			$hechos = $reportes->getHechosDivpdf($idEvento);
			$relatoUnificado = $reportes->getRelatopdf($idEvento);

			$relato = $decrypt->decrypt($relatoUnificado['Relato']);
			

			$relatohugo = $reportes->traeRelato($idEvento);
			$relatohugo = $relatohugo;
			//$relaton = strtoupper($relaton);

			$destinatario = "";
			if(isset($relatoUnificado['Destinatario'])) $destinatario = $relatoUnificado['Destinatario'];

			$pad_me = "Test String"; 
			//$destinatario='<div style="text-align:justify">'.$destinatario."</div>";
			//fin tratamiento para imprimir tcpdf




			$nombre_policia = $encabezado['nombre_usuario'];
			$hora_ingreso = $encabezado['hora_ingreso'];

		
			$horaletras =  array();
			$horaletras = explode(":", $hora_ingreso);	
			$_SESSION['NUMERO_DENUNCIA'] = $encabezado['evento_num'];
			$_SESSION['FECHA_DENUNCIA'] = $encabezado['fecha_ingreso'];
			$_SESSION['hora_denuncia'] = $encabezado['hora_ingreso'];
			$nombreentidad = $encabezado['nombre_entidad'];			
			$_SESSION['entidad'] = $nombreentidad;
			
			$_SESSION['sede'] = $encabezado['nombre_sede'];
			$strinhoralestras = $funciones->horaALetras($encabezado['hora_ingreso']);
			$str = $encabezado['evento_num'];
			$numerodenuncialetras = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
			$variabledenuncialetras = "";
			$denunciaMP = "";
			if($encabezado['denuncia_mp'] !== "P") $denunciaMP = "REF. MINISTERIO PÚBLICO: ".$encabezado['denuncia_mp'];
			$_SESSION['denunciaMP'] = $denunciaMP;


		foreach ($numerodenuncialetras as $posicion => $valordenuncia) 
		{

				$variabledenuncialetras = $variabledenuncialetras.$funciones->numeroletrasdigito($valordenuncia).", ";

		}

$idencriptado = $decrypt->encrypt($idEvento);

$variabledenuncialetras = substr($variabledenuncialetras, 0, -2);

$bodydescripcionBruto ="EL INFRASCRITO AGENTE DE PNC IDENTIFICADO COMO ".$nombre_policia.", OFICINISTA DE LA ".$encabezado['nombre_entidad'].", HACE CONSTAR QUE EL DÍA ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')." SIENDO LAS ". $strinhoralestras.", A ESTA OFICINA DE ATENCIÓN CIUDADANA, VOLUNTARIAMENTE, SE PRESENTÓ LA SIGUIENTE PERSONA QUIEN SE IDENTIFICÓ COMO:";

$buscarEsto  = array('ñ', 'á', 'é', 'í', 'ó', 'ú');
$reemplazarCon = array('~', 'Á', 'É', 'Í', 'Ó', 'Ú');
$bodydescripcion = $fun->amayuscula($bodydescripcionBruto);


$primerasec="";
$segundasec="";
$tercersec="";
$cadenacuidpi=$denunciante['Numero_identificacion'];
$identificacionTipo = $denunciante['Tipo_identificacion'];
$ide = ", SE IDENTIFICA CON ";
$numeroIdentificacion = "";
$identificacionLetras = "";

if($identificacionTipo =='DPI')
{
	for($i=0 ; $i<=12; $i++)
	{ 
		if($i<= 3)
		{
			$primerasec=$primerasec.$cadenacuidpi[$i]; 
		}else if($i <= 8)
		{
			$segundasec=$segundasec.$cadenacuidpi[$i]; 
		}else if($i <= 12)
		{
			$tercersec=$tercersec.$cadenacuidpi[$i]; 
		}
	}

	$resultadodpisegmentado = $primerasec." ".$segundasec." ".$tercersec;
	$numeroIdentificacion = $resultadodpisegmentado;

	$cuiGeneral = explode(" ", $resultadodpisegmentado);
	$cuiLetra = "";

	foreach ($cuiGeneral as $key => $value) 
	{
		if($value<1000) $cuiLetra = $cuiLetra."CERO, ";
		if($value< 100) $cuiLetra = $cuiLetra."CERO, CERO ";
		if($key == 1)
		{
			if($value<10000) $cuiLetra = $cuiLetra."CERO, ";
			if($value<1000) $cuiLetra = $cuiLetra."CERO, CERO ";
		}
		$cuiLetra = $cuiLetra.$funciones->numtoletras($value)."~";
	}

	$cuiLetra = $cuiLetra."|";
	$cuiLetra = str_replace("~|", "", $cuiLetra);
	$cuiLetra = str_replace("~", ", ", $cuiLetra);
	$identificacionLetras = " (".$cuiLetra.")";
	$identificacionTipo = $identificacionTipo.": ";
}// Fin de la condición del DPI

if($identificacionTipo =='Pasaporte')
{
	$n = $denunciante['Numero_identificacion'];
	$ne = str_split($n);
	$NumeroLetras = "";

	foreach ($ne as $posicion => $valPasaporte) 
	{
		$NumeroLetras = $NumeroLetras.$funciones->numeroletrasdigito($valPasaporte).", ";
	}

	$numeroIdentificacion = $denunciante['Numero_identificacion'];
	$NumeroLetras = $NumeroLetras."|";
	$NumeroLetras = str_replace(", |", "", $NumeroLetras);
	$identificacionLetras = " (".$NumeroLetras.")";
	$identificacionTipo = $identificacionTipo.": ";
}

if($identificacionTipo =='Sin Documento')
{
	$identificacionTipo = "";
	$ide = ", QUIEN NO PRESENTÓ DOCUMENTO DE IDENTIFICACIÓN";
}


		$profesion="";
		if(!empty($denunciante['Profesion'])) $profesion = ", PROFESIÓN:".$denunciante['Profesion'];
		$departamento = "";
		if(!empty($denunciante['Departamento_de_Nacimiento'])) $departamento = ", DEPARTAMENTO ".$denunciante['Departamento_de_Nacimiento'];
		$municipio = "";
		if(!empty($denunciante['r_municipio'])) $municipio = ", MUNICIPIO ".$denunciante['r_municipio'];
		$nombrePadre = "";
		if(!empty($denunciante['Nombre_del_Padre'])) $nombrePadre = ", NOMBRE DEL PADRE: ".str_replace(",", "", $denunciante['Nombre_del_Padre']);
		$nombreMadre = ""; 
		if(!empty($denunciante['Nombre_de_la_Madre'])) $nombreMadre = " NOMBRE DE LA MADRE: ".str_replace(",", "", $denunciante['Nombre_de_la_Madre']);
	

		$bodydenunciante = (("".$denunciante['Nombre_Completo'].", DE ".$denunciante['Edad']." AÑOS, GÉNERO ".$denunciante['Genero'].", ESTADO CIVIL ".$denunciante['Estado_Civil'].$profesion.", NACIDO EN EL PAÍS ".$denunciante['Pais_de_Nacimiento'].$departamento.$municipio.", CON DOMICILIO ACTUAL ".$denunciante['Direccion_de_contacto'].', TELÉFONO ACTUAL: '.$denunciante['r_telefono_cnt'].$ide.$identificacionTipo.$numeroIdentificacion.$identificacionLetras.$nombrePadre.$nombreMadre."."));
		$bodyresponsables = (("SE LE EXTIENDE LA PRESENTE CONSTANCIA EN UNA HOJA DE PAPEL BOND, MEMBRETADA, SELLADA Y FIRMADA EL DÍA  ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')."; ASIGNADA CON EL CODIGO UNICO DE DENUNCIA ".$encabezado['evento_num']." (".$variabledenuncialetras.")."));

		$ubicacion = (('DENUNCIANDO QUE EN LA UBICACIÓN SIGUIENTE: '.$ubicacion."."));
		//$ubicacion = strtoupper(htmlentities('DENUNCIANDO QUE EN LA UBICACIÓN SIGUIENTE: '.$ubicacion."."));
		$bodydenunciante = ($fun->amayuscula ($bodydenunciante));
		$bodyresponsables =($fun->amayuscula($bodyresponsables));
		$ubicacion = $fun->amayuscula($ubicacion);




$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf=new PDF('p','mm',$papel);
$pdf->SetTitle('Reporte Sipol');
$pdf->SetHeaderData(null, PDF_HEADER_LOGO_WIDTH, null, null);
$pdf->SetMargins(PDF_MARGIN_LEFT, 44, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(0);
$pdf->AddPage();
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('Courier','B',12);
$pdf->Ln(0);
$pdf->Cell(0,0,'DENUNCIA',0,0,'C');
$pdf->Ln(2);
if(isset($destinatario) && !empty($destinatario))
{
	
	$pdf->Ln(2);
	$pdf->SetFont('Courier','',10);
	$pdf->MultiCell(0, 5,$pdf->WriteHTML($destinatario.":"), 0, "J", 0);
	$pdf->Ln(-2);
}
$pdf->SetFont('Courier','',10);
//$pdf->MultiCell(0, 5,$bodydescripcion, 0, "J", 0);

$pdf->writeHTML('<div style="text-align:justify">'.$bodydescripcion.'</div>', 0, "J", 0);

$pdf->Ln(3);
$pdf->SetFont('Courier','B',10);
$pdf->writeHTML('<div style="text-align:justify">'.$bodydenunciante.'</div>', 0, "J", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','',10);
$pdf->MultiCell(0, 5,$ubicacion, 0, "J", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','B',10);
$pdf->MultiCell(0, 5,'OCURRIERON LOS HECHOS SIGUIENTES', 0, "C", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','',10);
$hechosnuevos = explode("-----", $hechos);
$titulo = array();
$hechoClean = array();
$relatoHtml = strip_tags(str_replace("&nbsp", "", utf8_decode($relato)));
//$relatoHtml = strtoupper($relatoHtml);
$hugo = $relatoHtml;

//$hugo = utf8_decode(strtoupper($relato));





foreach ($hechosnuevos as $key => $value) 
{
		$titPersonas = "";
		$salto = "0";
		$titulo = explode("||",$value);
		$pdf->SetFont('Courier','B',10);
		$pdf->writeHTML('<div style="text-align:justify">'.strtoupper(utf8_decode($titulo[0])).'</div>', 0, "J", 0);
		$nuevo = str_replace($titulo[0]."||", "", $value);
		$hechoClean = explode("|~|", $nuevo);
		$hechoPrint = $hechoClean[0]."~!";
		$hechoPrint = str_replace("~!", "", $hechoPrint);
		$personas = (str_replace($hechoClean[0]."|~|", "", $nuevo));
		if(!empty($personas)) 
		{	$titPersonas = "PERSONAS IMPLICADAS: ";
			$salto = "3";
		}
		$hechoPrint = str_replace('_',' ',$hechoPrint);
		$titPersonas = str_replace('_',' ',$titPersonas);
		$personas = str_replace('_',' ',$personas);
		//var_dump($hechoPrint);
		$pdf->SetFont('Courier','',10);
		$pdf->writeHTML('<div style="text-align:justify">'.$fun->amayuscula($hechoPrint)."".$fun->amayuscula($titPersonas).$fun->amayuscula($personas).'</div>', 0, "J", 0);
		//$pdf->MultiCell(0, 5,$personas, 0, "J", 0);
		#$pdf->Ln($salto);
		#$pdf->SetFont('Courier','B',12);
		#$pdf->MultiCell(0, 0,$titPersonas, 0, "J", 0);
		#$pdf->Ln($salto);
		#$pdf->SetFont('Courier','',12);
		#$pdf->MultiCell(0, 5,$personas, 0, "J", 0);
		$pdf->Ln(2);
}
$pdf->Ln(-10);
$pdf->MultiCell(0, 0,$pdf->WriteHTML('<b>RELATO:</b>'), 0, "J", 0);
$pdf->Ln(-5);

///tratamiento para imprimir html en tcpdf
#$relatohugo= str_replace("'", '"', $relatohugo);
#$relatohugo = str_replace("\n", "<br>", $relatohugo);
#$relatohugo=nl2br ($relatohugo);
#$relatohugo=mb_convert_case($relatohugo, MB_CASE_UPPER, "UTF-8");
#$relatohugo= str_replace("&NBSP;", '', $relatohugo);
$pad_me = "Test String"; 
$relatohugo='<div style="text-align:justify">'.$relatohugo."</div>";

//fin tratamiento para imprimir tcpdf
$pdf->writeHTML($relatohugo);



//$relatohugo=$relatohugo;
//$pdf->MultiCell(0, 5,$relatohugo, 0, "J", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','B',10);
$pdf->writeHTML('<div style="text-align:justify">'.$bodyresponsables.'</div>', 0, "J", 0);
//$pdf->Ln(15);
$pdf->SetFont('Courier','',10);

/*
function crearextensiondenuncia($pdf,$id_evento,$fecha,$hora)
{
$funciones = new Funcionesp;
$reportess = new Reportes;
$hechoss = $reportess->getHechosDivpdf($id_evento);
$decryptt = new Encrypter;
$relatoUnificados = $reportess->getRelatopdf($id_evento);

$relatos = $decryptt->decrypt($relatoUnificados['Relato']);

$relatoUnificados = $reportess->getRelatopdf($id_evento);


$pdf->Ln(12);
$pdf->SetFont('Courier','B',12);

$pdf->MultiCell(0, 5,('AMPLIACIÓN DE DENUNCIA '), 0, "C", 0);
$pdf->Ln(5);
$pdf->SetFont('Courier','',10);

$fechayhora=('SE REALIZÓ UNA AMPLIACIÓN DE ÉSTA DENUNCIA, EL DÍA: '.$funciones->fechaATexto($fecha,'u').' A LAS:'.$funciones->horaALetras($hora));
$fechayhora=mb_convert_case($fechayhora, MB_CASE_UPPER, "UTF-8");
$pdf->MultiCell(0, 5,$fechayhora, 0, "J", 0);
$pdf->Ln(5);
$pdf->SetFont('Courier','B',10);
$pdf->MultiCell(0, 5,'OCURRIERON LOS HECHOS SIGUIENTES', 0, "C", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','',10);
$hechosnuevos="";
$hechosnuevos = explode("-----", $hechoss);
$titulo = array();
$hechoClean = array();
foreach ($hechosnuevos as $key => $value) 
{
	$fun =new Funcionesp;	
		$titPersonas = "";
		$salto = "0";
		$titulo = explode("||",$value);
		$pdf->SetFont('Courier','B',10);
		$pdf->writeHTML('<div style="text-align:justify">'.strtoupper(utf8_decode($titulo[0])).'</div>', 0, "J", 0);
		$nuevo = str_replace($titulo[0]."||", "", $value);
		$hechoClean = explode("|~|", $nuevo);
		$hechoPrint = $hechoClean[0]."~!";
		$hechoPrint = str_replace("~!", "", $hechoPrint);
		$personas = (str_replace($hechoClean[0]."|~|", "", $nuevo));
		if(!empty($personas)) 
		{	$titPersonas = "PERSONAS IMPLICADAS: ";
			$salto = "3";
		}
		$hechoPrint = str_replace('_',' ',$hechoPrint);
		$titPersonas = str_replace('_',' ',$titPersonas);
		$personas = str_replace('_',' ',$personas);
		//var_dump($hechoPrint);
		$pdf->SetFont('Courier','',10);
		$pdf->writeHTML('<div style="text-align:justify">'.$fun->amayuscula($hechoPrint)."".$fun->amayuscula($titPersonas).$fun->amayuscula($personas).'</div>', 0, "J", 0);
		//$pdf->MultiCell(0, 5,$personas, 0, "J", 0);
		#$pdf->Ln($salto);
		#$pdf->SetFont('Courier','B',12);
		#$pdf->MultiCell(0, 0,$titPersonas, 0, "J", 0);
		#$pdf->Ln($salto);
		#$pdf->SetFont('Courier','',12);
		#$pdf->MultiCell(0, 5,$personas, 0, "J", 0);
		$pdf->Ln(2);
}
$pdf->Ln(-10);

		//$pdf->Ln(5);
		$pdf->MultiCell(0, 0,$pdf->WriteHTML('<b>RELATO:</b>'), 0, "J", 0);
		$pdf->Ln(-5);
		$pdf->SetFont('Courier','',10);


// Instantiate a new instance of the class. Passing the string
// variable automatically loads the HTML for you.

/////tratamiento para que el tcpdf reconozca el html		
$relatos= str_replace("'", '"', $relatos);
$relatos = str_replace("\n", "<br>", $relatos);
$relatos=nl2br ($relatos);
$relatos=mb_convert_case($relatos, MB_CASE_UPPER, "UTF-8");
$relatos= str_replace("&NBSP;", '', $relatos);
//echo '|'.str_pad($relatos, 20, ' ')."|\n"; 
$relatos='<div style="text-align:justify">'.$relatos."</div>";
//fin del tratamiento para que el tcpdf reconozca el html



	//$pdf->writeHTML($relatos, 10, false, false, false, '');
	$pdf->writeHTML($relatos);
//writeHTMLCell(w, h, x, y, html = '', border = 0, ln = 1, fill = 0);
//$pdf->writeHTMLCell(0, 10, '', '', $relatos, 'LRTB', 1, 0, true, 'R', true);
}*/

/*
$sql="select id_evento, fecha_ingreso, hora_ingreso from sipol.tbl_evento
where id_evento_extiende is not null
and estado = 't'
and id_evento_extiende =  '".$idEvento ."';";
$resultado = Yii::app()->db->createCommand($sql)->queryAll();
$variablearray = "";
    foreach($resultado as $key => $value)
      {
		 $codifica = json_encode($value);
          $codifica = json_decode($codifica);
      	crearextensiondenuncia($pdf,$codifica->id_evento,$codifica->fecha_ingreso,$codifica->hora_ingreso);
      }

*/
$y = $pdf->GetY();
//$pdf->Cell(0,0,$y ,0,0,'L');
if($y >=$cordenada_papel)
{
	$pdf->AddPage();
}
$nombrecompleto = $nombre_policia;
$pdf->Ln(20);
$y = $pdf->GetY();
$pdf->SetFont('Courier','',10);
$pdf->Cell(0,0,'(F)',0,0,'L'); 
$pdf->Cell(0,0,$pdf->Line(18,$y+4,100,$y+4),0,0,'L');
//$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Courier','',10);
$pdf->Cell(0,0,$denunciante['Nombre_Completo'],0,0,'L'); 
$pdf->Ln(5);
$pdf->Cell(0,0,'DENUNCIANTE',0,0,'L'); 
$pdf->Ln(15);
//$pdf->SetFont('Courier','',12);
//$pdf->Cell(0,0,'AGENTE DE POLICIA',0,0,'C');
//$pdf->Ln(15);
$y = $pdf->GetY();
$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,$nombrecompleto,0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,'OFICINISTA DE TURNO - PNC',0,0,'C');
$pdf->Ln(4);
$pdf->SetFont('Courier','BI',8);
//$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
//$pdf->Ln(5);
$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,$nombreentidad,0,0,'C');
$pdf->Ln(4);

$pdf->Cell(0,0,$encabezado['nombre_sede'],0,0,'C');

$pdf->Ln(4);
//$pdf->Ln(5);
//$pdf->Cell(0,0,$encabezado['nombre_sede'],0,0,'C');
$pdf->Ln(5);
$pdf->Output();

			} catch (Exception $e) {
		echo "No puede hacer esta consulta";
	}
}else{
	echo "no se tiene registro del envio";
}
?>
