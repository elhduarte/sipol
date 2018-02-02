<?php
//require_once('lib/reportpdf/fpdf.php');	
require_once('lib/reportpdf/tcpdf_import.php');		
$fun =new Funcionesp;	
if(isset($id_evento))
{		
	Yii::log('',CLogger::LEVEL_ERROR,$ruta." - ".$tamano_papel);
try {

	//$idEvento = '2911';
	$papel = "letter";
	$cordenada_papel = "";
	$validador_ger =  isset($tamano_papel) ? $tipo_papel=$tamano_papel : false ;
		

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

	$reportes = new Reportes;
	$decrypt = new Encrypter;
	$Funcionesp = new Funcionesp;
	
	$idEvento = $id_evento;
	//$idEvento = $decrypt->descompilarget($idEvento);

	$encabezado = $reportes->Encabezado($idEvento);
	$ubicacion = $reportes->getUbicacionDivpdf($idEvento);
	$tipoIncidencia = $reportes->getTipoIncidencia($idEvento);
	$relatoEnco = $reportes->getRelato($idEvento);
	$relato = $decrypt->decrypt($relatoEnco['Relato']);



	$relatohugo = $reportes->traeRelato($idEvento);


	$implicados = $reportes->getImplicadosTable($relatoEnco['Implicados']);
	$agentes = $reportes->getAgentes($idEvento);
	$destinatario = $relatoEnco['Destinatario'];
	//strip_tags(str_replace("&nbsp", "", utf8_decode($des)));
	$generales = $reportes->getGeneralesIncidencia($idEvento);
	$getPersonas = $reportes->getPersonasIncidencia($idEvento);
	(!empty($getPersonas)) ? $personasRelacionadas = $getPersonas : $personasRelacionadas = "No hay Personas relacionadas a ésta Incidencia";
	$getObjetos = $reportes->getObjetosIncidencia($idEvento);
	$consignados = $reportes->getConsignadosDos($idEvento);

	$_SESSION['NUMERO_DENUNCIA'] = $encabezado['evento_num'];
	$sesionUsuario = json_decode($_SESSION['ID_ROL_SIPOL']);
	$user = $sesionUsuario[0];
	$fechaLetras = date("d")." de ".$Funcionesp->mes(date("m"))." de ".date("Y");

	$horaLetrasComplete = $Funcionesp->horaALetras(date("H:i"));

	$agentesBruto = $reportes->getAgentesPdf($idEvento);
	$agentes = explode("~", $agentesBruto);
	$agentesPrint = "YO, EL SUSCRITO AGENTE DE LA POLICÍA NACIONAL CIVIL, ".$agentes[0];
	$prurales = "PROCEDO";
	$agentesConsignan = "YO ".$agentes[0];
	$pru_agente = "YO EL COMPARECIENTE DOY";

	if($agentes[1] > 1){
		$agentesPrint = "NOSOTROS, LOS SUSCRITOS AGENTES DE LA POLICÍA NACIONAL CIVIL, ".$agentes[0];
		$prurales = "PROCEDEMOS";
		$pru_agConsigna = "NOSOTROS";
		$agentesConsignan = "NOSOTROS ".$agentes[0];
		$pru_agente = "NOSOTROS LOS COMPARECIENTES DAMOS";
	}
	$agentesFirma = explode(", ", $agentes[0]);

	$contenidoBase = strtoupper($agentesPrint." EN CUMPLIMIENTO A LO DISPUESTO EN EL ARTÍCULO 304 DEL CÓDIGO PROCESAL PENAL, DECRETO NÚMERO 51-92 DEL CONGRESO DE LA REPÚBLICA DE GUATEMALA, ".$prurales." A INFORMARLE DETALLADAMENTE DE LO SIGUIENTE: ");
	$relatoHtml = strip_tags(str_replace("&nbsp", "", utf8_decode($relato)));
	$relatoHtml = strtoupper($relatoHtml);

	Yii::log('bug',CLogger::LEVEL_ERROR,$relatoHtml);

	$_SESSION['NUMERO_DENUNCIA'] = $encabezado['evento_num'];
	$_SESSION['FECHA_DENUNCIA'] = $encabezado['fecha_ingreso'];
	$_SESSION['hora_denuncia'] = $encabezado['hora_ingreso'];
	$nombreentidad = $encabezado['nombre_entidad'];			
	$_SESSION['entidad'] = $nombreentidad;
	$_SESSION['sede'] = $encabezado['nombre_sede'];
	$nombre_policia = $encabezado['nombre_usuario'];
		

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf=new PDF('p','mm',$papel);
$pdf->SetTitle('Reporte Sipol');
$pdf->SetHeaderData(null, PDF_HEADER_LOGO_WIDTH, null, null);
$pdf->SetMargins(PDF_MARGIN_LEFT, 44, PDF_MARGIN_RIGHT);
$pdf->AddPage();
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('courier','B',12);
$pdf->Ln(0);
$pdf->Cell(0,0,utf8_decode('PREVENCION POLICIAL'),0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('courier','',10);
$cuerpo  ="No. ".$encabezado['evento_num'];
$pdf->Cell(0,0,utf8_decode($cuerpo),0,0,'R');
$pdf->Ln(4);
$cuerpo = strtoupper($user->ubicacion." ".$fechaLetras);
$pdf->Cell(0,0,utf8_decode($cuerpo),0,0,'R');
$pdf->Ln(4);
$cuerpo  ="HORA: ".date("H:i");
$pdf->Cell(0,0,utf8_decode($cuerpo),0,0,'R');
$pdf->Ln(10);
//$pdf->Cell(0,0,utf8_decode($destinatario),0,0,'L');
$destinatario=$fun->amayuscula($destinatario);
$pdf->WriteHTML(utf8_decode($destinatario));
$pdf->Ln(3);
///tratamiento para imprimir html en tcpdf
$cuerpo=$fun->outhtml($contenidoBase);
//fin tratamiento para imprimir tcpdf
$pdf->writeHTML($contenidoBase);
//$pdf->MultiCell(0, 5,utf8_decode($contenidoBase), 0, "J", 0);
$pdf->Ln(5);
$pdf->SetFont('courier','B',10);
//$relatohugo=$fun->amayusculaed($relatohugo);



///tratamiento para imprimir html en tcpdf
$relatohugo=$fun->outhtml($relatohugo);
//fin tratamiento para imprimir tcpdf
//$pdf->writeHTML($relatohugo);
$pdf->MultiCell(0, 5,$pdf->WriteHTML($relatohugo), 0, "J", 0);
$pdf->Ln(5);
$pdf->SetFont('courier','',10);

if(count($consignados) >= 1 ){

	foreach ($consignados as $valor) {
		$valor = (object) $valor;
		$cuerpo = "POR LO CUAL PROCEDEMOS A LA APREHENSIÓN DE ".$valor->persona.", SEGÚN EL ACTA QUE A CONTINUACIÓN CONSIGNAMIOS.";
		$pdf->SetFont('courier','',10);
		$cuerpoconsigna=$fun->outhtml($cuerpo);
		$pdf->writeHTML($cuerpoconsigna);
		//$pdf->MultiCell(0, 5,$cuerpoconsigna, 0, "J", 0);
		$pdf->Ln(10);
		$pdf->SetFont('courier','B',12);
	$pdf->MultiCell(0, 5,$fun->amayuscula('ACTA DE APREHENSIÓN'), 0, "C", 0);
		$pdf->Ln(8);

		$cuerpo = "EN EL MUNICIPIO DE ".$valor->mupio_juzgado.", DEL DEPARTAMENTO DE ".$valor->depto_juzgado.", SE PUSO A DISPOSICIÓN DEL ".$valor->nombre_juzgado.", SIENDO LAS ".$valor->hora_letras.", DEL DÍA ".$valor->fecha_letras.", ".$agentesConsignan." EN EL ".$ubicacion.
		", LUGAR AL CUAL NOS HEMOS HECHO PRESENTES POR ".$generales->Motivo." POR LO CUAL PROCEDIMOS DE LA SIGUIENTE MANERA: PRIMERO: EN CUMPLIMIENTO ".$relatoHtml.". SEGUNDO: CONFORME A LA RELACIÓN DE LOS HECHOS DESCRITOS EN EL PUNTO ANTERIOR, PROCEDIMOS CONFORME A LA LEY A LA APREHENSIÓN DE: ".
		$valor->persona.", A QUIEN SE LE HACE SABER SUS DERECHOS SEGÚN LO ESTABLECEN LOS ARTÍCULOS 6, 7, 8 Y 9 DE LA CONSTITUCIÓN POLITICA DE LA REPÚBLICA DE GUATEMALA. ".$pru_agente." POR TERMINADA LA PRESENTE DILIGENCIA DE APREHENSIÓN; Y DE QUE FINALIZA LA PRESENTE ACTA DE APREHENSIÓN QUE QUEDA CONTENIDA EN HOJAS MEMBRETADAS DE PAPEL BOND, LAS CUALES NUMERAMOS, SELLAMOS Y FIRMAMOS CUANDO SON LAS ".
		$horaLetrasComplete.", EN EL MISMO LUGAR Y FECHA AL PRINCIPIO CONSIGNADOS";

		$pdf->SetFont('courier','',10);

		

$cuerpo=$fun->outhtml($cuerpo);

$pdf->writeHTML($cuerpo);
		//$pdf->MultiCell(0, 5,(($cuerpo)), 0, "J", 0);
		$pdf->Ln(10);
	}
}

if(count($getObjetos)>=1)
{

	$pdf->WriteHTML($fun->outhtml($getObjetos));
}


foreach ($agentesFirma as $value) {
	$pdf->Ln(8);
	$y = $pdf->GetY();
	$pdf->SetFont('courier','',10);
	$pdf->Cell(0,0,'(F)',0,0,'L'); 
	$pdf->Cell(0,0,$pdf->Line(18,$y+4,100,$y+4),0,0,'L');
	$pdf->Ln(5);
		$newdatapoli=explode(":",$value);
	$datospoli = str_replace("CON NIP:", "CON NIP:<br>", $value);
	$datospoli = trim(str_replace("(", "<br>(", $datospoli));
	$nombrepoli=$newdatapoli[0].":";
	$nippoli=explode("(",$newdatapoli[1]);
	$nipnum=$nippoli[0];
	$nipletra='('.$nippoli[1];
	$pdf->WriteHTML($fun->outhtml($nombrepoli));
	$pdf->WriteHTML($fun->outhtml($nipletra.$nipnum));
	$pdf->Ln(20);
}
/*
	$y = $pdf->GetY();
	$pdf->SetFont('courier','',10);
	$pdf->Cell(0,0,'(F)',0,0,'L'); 
	$pdf->Cell(0,0,$pdf->Line(18,$y+2,100,$y+2),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(0,0,utf8_decode($nombre_policia." - DIGITADOR PNC"),0,0,'L');
	$pdf->Ln(20);
	*/

$pdf->Output($ruta.'.pdf','F');
echo "1~";

//$pdf->Output();

			} catch (Exception $e) {
		//var_dump($e);
		echo "0~";
		Yii::log('',CLogger::LEVEL_ERROR,'trycatch');
	}
}
else{
	echo "0~";
	Yii::log('',CLogger::LEVEL_ERROR,'false');
}


?>