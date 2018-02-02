<?php
//require_once('lib/reportpdf/fpdf.php');
require_once('lib/reportpdf/tcpdf_import.php');	

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
						$cordenada_papel = 400;
					}//fin termina el valor de tipo de papel
				}else{
					$papel = "letter";
					$cordenada_papel = 205;
				}


			$id_evento = $_GET['par'];
			$variableencript = new Encrypter;
			$idEvento = $variableencript->descompilarget($id_evento);
			$reportes = new Reportes;
			$decrypt = new Encrypter;
			$funciones = new Funcionesp;
			$encabezado = $reportes->Encabezadopdf($idEvento);
			$denunciante = $reportes->getDenunciantepdf($idEvento);
			$ubicacion = $reportes->getUbicacionDivpdf($idEvento);
			$hechos = $reportes->getHechosDivpdf($idEvento);
			$objetos_extraviados = $reportes->getExtraviosPdf($idEvento);
			$relatoUnificado = $reportes->getRelatopdf($idEvento);
			$relato = $decrypt->decrypt($relatoUnificado['Relato']);

			$relatohugo = $reportes->traeRelato($idEvento);
			$relatohugo = 	$relatohugo = ($relatohugo);

			//$objetos = $relatoUnificado['Objetos'];
			//$objetos = $reportes->getObjetosDivpdf($objetos);
			$destinatario = "";
			if(isset($relatoUnificado['Destinatario'])) $destinatario = $relatoUnificado['Destinatario'];
			$nombre_policia = $encabezado['nombre_usuario'];
			$hora_ingreso = $encabezado['hora_ingreso'];
			$horaletras =  array();
			$horaletras = explode(":", $hora_ingreso);	
			$_SESSION['NUMERO_DENUNCIA'] = $encabezado['evento_num'];
			$_SESSION['FECHA_DENUNCIA'] = $encabezado['fecha_ingreso'];
			$_SESSION['hora_denuncia'] = $encabezado['hora_ingreso'];
			$nombreentidad = $encabezado['nombre_entidad'];	
			$_SESSION['sede'] = $encabezado['nombre_sede'];			
			$_SESSION['entidad'] = $nombreentidad;
			$strinhoralestras = $funciones->horaALetras($encabezado['hora_ingreso']);
			$str = $encabezado['evento_num'];
			$numerodenuncialetras = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
			$variabledenuncialetras = "";
		foreach ($numerodenuncialetras as $posicion => $valordenuncia) 
		{
				$variabledenuncialetras = $variabledenuncialetras.$funciones->numeroletrasdigito($valordenuncia).", ";
		}


$idencriptado = $decrypt->encrypt($idEvento);
$variabledenuncialetras = substr($variabledenuncialetras, 0, -2);
$bodydescripcionBruto =(("EL INFRASCRITO AGENTE DE PNC IDENTIFICADO COMO ".$nombre_policia.", OFICINISTA DE LA ".$encabezado['nombre_entidad'].", HACE CONSTAR QUE EL DÍA ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')." SIENDO LAS ". $strinhoralestras.", A ESTA OFICINA DE ATENCIÓN CIUDADANA, VOLUNTARIAMENTE, SE PRESENTÓ LA SIGUIENTE PERSONA QUIEN SE IDENTIFICÓ COMO:"));

$buscarEsto  = array('ñ', 'á', 'é', 'í', 'ó', 'ú');
$reemplazarCon = array('~', 'Á', 'É', 'Í', 'Ó', 'Ú');
$bodydescripcion = str_replace('ñ', 'Ñ', $bodydescripcionBruto);


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
}
// Fin de la condición del DPI

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
	$ide = ", QUIEN NO PRESENTÓ DOCUMENTO D E IDENTIFICACIÓN";
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
		if(!empty($denunciante['Nombre_de_la_Madre'])) $nombreMadre = ", NOMBRE DE LA MADRE: ".str_replace(",", "", $denunciante['Nombre_de_la_Madre']);



		$bodydenunciante = (("".$denunciante['Nombre_Completo'].", DE ".$denunciante['Edad']." AÑOS, GÉNERO ".$denunciante['Genero'].", ESTADO CIVIL ".$denunciante['Estado_Civil'].$profesion.", NACIDO EN EL PAÍS ".$denunciante['Pais_de_Nacimiento'].$departamento.$municipio.", CON DOMICILIO ACTUAL ".$denunciante['Direccion_de_contacto'].$ide.$identificacionTipo.$numeroIdentificacion.$identificacionLetras.$nombrePadre.$nombreMadre."."));

		$bodyresponsables = (("DE Y PARA EL USO QUE EL INTERESADO (A) CONVENGA, SE EXTIENDE LA PRESENTE CONSTANCIA EN UNA HOJA DE PAPEL BOND, MEMBRETADA, SELLADA Y FIRMADA EL DIA ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')."; ASIGNADA CON EL CODIGO UNICO DE EXTRAVIO ".$encabezado['evento_num']."; EXCLUSIVAMENTE PARA TRAMITE DE REPOSICIÓN. EL EXTRAVÍO NO CONSTITUYE UNA PERSECUCIÓN PENAL."));

		$ubicacion = (('DENUNCIANDO QUE EN LA UBICACIÓN SIGUIENTE: '.$ubicacion."."));
		//$ubicacion = (htmlentities('DENUNCIANDO QUE EN LA UBICACIÓN SIGUIENTE: '.$ubicacion."."));
		


		#$bodydenunciante = (htmlentities("".$denunciante['Nombre_Completo'].", DE ".$denunciante['Edad']." AÑOS, GÉNERO ".$denunciante['Genero'].", ESTADO CIVIL ".$denunciante['Estado_Civil'].$profesion.", NACIDO EN EL PAÍS ".$denunciante['Pais_de_Nacimiento'].$departamento.$municipio.", CON DOMICILIO ACTUAL ".$denunciante['Direccion_de_contacto'].', TELÉFONO ACTUAL: '.$denunciante['r_telefono_cnt'].$ide.$identificacionTipo.$numeroIdentificacion.$identificacionLetras.$nombrePadre.$nombreMadre."."));
		#$bodyresponsables = (htmlentities("PARA EL USO QUE AL INTERESADO(A) CONVENGA, SE LE EXTIENDE LA PRESENTE CONSTANCIA EN UNA HOJA DE PAPEL BOND, MEMBRETADA, SELLADA Y FIRMADA EL DÍA  ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')."; ASIGNADA CON EL CODIGO UNICO DE DENUNCIA ".$encabezado['evento_num']." (".$variabledenuncialetras.")."));
		#$ubicacion = (htmlentities('DENUNCIANDO QUE EN LA UBICACIÓN SIGUIENTE: '.$ubicacion."."));
		$bodydenunciante = ($funciones->re_tildes($bodydenunciante));

		$bodyresponsables =($funciones->re_tildes($bodyresponsables));
		
		$ubicacion = ($funciones->re_tildes($ubicacion));
		var_dump($ubicacion); exit();


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetTitle('Reporte Sipol');
$pdf->SetHeaderData(null, PDF_HEADER_LOGO_WIDTH, null, null);
$pdf->SetMargins(PDF_MARGIN_LEFT, 44, PDF_MARGIN_RIGHT);
$pdf->AddPage();
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('courier','B',12);
$pdf->Ln(1);
$pdf->Cell(0,0,'CONSTANCIA DE EXTRAVIO',0,0,'C');
$pdf->Ln(8);
if(isset($destinatario) && !empty($destinatario))
{
	$pdf->Ln(2);
	$pdf->SetFont('courier','',10);
	$destinatario=$fun->outhtml($destinatario);
$pdf->WriteHTML($destinatario);
	$pdf->Ln(3);
}
$pdf->SetFont('courier','',10);
//$bodydescripcion=$fun->amayuscula($bodydescripcion);
$bodydescripcion=$fun->outhtml($bodydescripcion);
$pdf->WriteHTML($bodydescripcion);


$pdf->Ln(3);
$pdf->SetFont('courier','B',10);

$bodydenunciante=$fun->outhtml($bodydenunciante);
$pdf->WriteHTML($bodydenunciante);



$pdf->Ln(3);
$pdf->SetFont('courier','',10);

$ubicacion=$fun->outhtml($ubicacion);
$pdf->WriteHTML($ubicacion);

$pdf->Ln(3);
$pdf->SetFont('courier','B',10);
$pdf->MultiCell(0, 5,$fun->amayuscula('OCURRIÓ EL EXTRAVÍO DE LOS OBJETOS SIGUIENTES'), 0, "C", 0);
$pdf->Ln(2);
$obExtExplode = explode("||~||",$objetos_extraviados);
$objeto = array();
foreach ($obExtExplode as $key => $value) 
{
	$objeto = explode("|°|",$value);
	$pdf->SetFont('courier','B',10);


$obj1=$fun->outhtml($objeto[0]);
$pdf->WriteHTML($obj1);
	//$pdf->MultiCell(0, 3,(($objeto[0])), 0, "J", 0);
	$pdf->SetFont('courier','',10);
	$detallesObjetos = str_replace($objeto[0]."|°| ","", $value);

	$detallesObjetos = str_replace('_',' ',$detallesObjetos);
$detallesObjetos=$fun->outhtml($detallesObjetos);
$pdf->WriteHTML($detallesObjetos);


	$pdf->Ln(3);
}
//$hechosnuevos = explode("-----", $hechos);
$titulo = array();
$hechoClean = array();
#$relatoHtml = strip_tags(str_replace("&nbsp", "", ($relato)));
$relatoHtml = ($relatoHtml);
$pdf->Ln(-8);
$pdf->MultiCell(0, 0,$pdf->WriteHTML('<b>RELATO:</b>'), 0, "J", 0);
$pdf->Ln(-2);
$relatohugo=$fun->outhtml($relatohugo);
$pdf->WriteHTML($relatohugo);
$pdf->Ln(3);
$pdf->SetFont('courier','B',10);

$bodyresponsables=$fun->outhtml($bodyresponsables);
$pdf->WriteHTML($bodyresponsables);

$pdf->SetFont('courier','',10);

$y = $pdf->GetY();
if($y >=$cordenada_papel)
{
	$pdf->AddPage();
}

$pdf->Ln(10);
$y = $pdf->GetY();
$pdf->SetFont('courier','',10);
$pdf->Cell(0,0,'(F)',0,0,'L'); 

$pdf->Cell(0,0,$pdf->Line(18,$y+4,100,$y+4),0,0,'L');
//$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('courier','',10);
$pdf->Cell(0,0,($denunciante['Nombre_Completo']),0,0,'L'); 
$pdf->Ln(5);
$pdf->Cell(0,0,'CIUDADANO (A)',0,0,'L'); 
$pdf->Ln(15);


$nombrecompleto = $nombre_policia; 
$y = $pdf->GetY();
$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(3);
$pdf->Cell(0,0,($nombrecompleto),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,'OFICINISTA DE TURNO - PNC',0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('courier','BI',8);
//$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
//$pdf->Ln(5);
$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,$nombreentidad,0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,$encabezado['nombre_sede'],0,0,'C');
$pdf->Ln(4);

///$pdf->Ln(5);
$pdf->Output();

			} catch (Exception $e) {
		echo "No puede hacer esta consulta";
	}
}
else
{
	echo "no se tiene registro del envio";
}
?> 