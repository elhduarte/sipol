<?php
require_once('lib/reportpdf/fpdf.php');	
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
			$qrdenuncia = $funciones->generarqrdenuncias($id_evento);
			$_SESSION['qr'] = $qrdenuncia;
			$denunciante = $reportes->getDenunciantepdf($idEvento);
			$ubicacion = $reportes->getUbicacionDivpdf($idEvento);
			$hechos = $reportes->getHechosDivpdf($idEvento);
			$relatoUnificado = $reportes->getRelatopdf($idEvento);
			$relato = $decrypt->decrypt($relatoUnificado['Relato']);
			

			$relatohugo = $reportes->traeRelato($idEvento);
			$relatohugo = utf8_decode($relatohugo);
			//$relaton = strtoupper($relaton);

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
$bodydescripcionBruto =strtoupper(utf8_decode("EL INFRASCRITO AGENTE DE PNC IDENTIFICADO COMO ".$nombre_policia.", OFICINISTA DE LA ".$encabezado['nombre_entidad'].", HACE CONSTAR QUE EL DÍA ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')." SIENDO LAS ". $strinhoralestras.", A ESTA OFICINA DE ATENCIÓN CIUDADANA, VOLUNTARIAMENTE, SE PRESENTÓ LA SIGUIENTE PERSONA QUIEN SE IDENTIFICÓ COMO:"));

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
		if(!empty($denunciante['Nombre_de_la_Madre'])) $nombreMadre = ", NOMBRE DE LA MADRE: ".str_replace(",", "", $denunciante['Nombre_de_la_Madre']);
	
		$bodydenunciante = strtoupper(("".$denunciante['Nombre_Completo'].", DE ".$denunciante['Edad']." AÑOS, GÉNERO ".$denunciante['Genero'].", ESTADO CIVIL ".$denunciante['Estado_Civil'].$profesion.", NACIDO EN EL PAÍS ".$denunciante['Pais_de_Nacimiento'].$departamento.$municipio.", CON DOMICILIO ACTUAL ".$denunciante['Direccion_de_contacto'].', TELÉFONO ACTUAL: '.$denunciante['r_telefono_cnt'].$ide.$identificacionTipo.$numeroIdentificacion.$identificacionLetras.$nombrePadre.$nombreMadre."."));
		$bodyresponsables = strtoupper(("SE LE EXTIENDE LA PRESENTE CONSTANCIA EN UNA HOJA DE PAPEL BOND, MEMBRETADA, SELLADA Y FIRMADA EL DÍA  ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')."; ASIGNADA CON EL CODIGO UNICO DE DENUNCIA ".$encabezado['evento_num']." (".$variabledenuncialetras.")."));
		$ubicacion = strtoupper(('DENUNCIANDO QUE EN LA UBICACIÓN SIGUIENTE: '.$ubicacion."."));
		//$ubicacion = strtoupper(htmlentities('DENUNCIANDO QUE EN LA UBICACIÓN SIGUIENTE: '.$ubicacion."."));
		$bodydenunciante = utf8_decode($funciones->re_tildes($bodydenunciante));
		$bodyresponsables =utf8_decode($funciones->re_tildes($bodyresponsables));
		$ubicacion = utf8_decode($funciones->re_tildes($ubicacion));
class PDF extends FPDF
{
	var $B;
	var $I;
	var $U;
	var $HREF;
	var $numerodenuncia = "";
		function Header()
		{

			   $this->Image('images/logo_puntos.jpg',10,10,60);
			   $this->Image('images/pncbw.jpg',180,5,25);
			  // $this->Image($_SESSION['qr'],180,5,25);
			   $this->SetFont('Courier','',9);
			   $this->Cell(0,0,'POLICIA NACIONAL CIVIL',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,'GUATEMALA',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,$_SESSION['entidad'],0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,$_SESSION['sede'],0,0,'C');
			   	     	   
			   $this->SetFont('Courier','',8);
			   $this->Text(10,40, 'DENUNCIA NO. '.$_SESSION['NUMERO_DENUNCIA'].'');
			   $fecha1=$_SESSION['FECHA_DENUNCIA'];
			   $horax = str_replace('{','', $_SESSION['hora_denuncia']);
			   $horay = str_replace('}','',  $horax);
			   $fecha2=date("d-m-Y",strtotime($fecha1));
			   $this->Text(150,40, 'FECHA/HORA: '.$fecha2."  ".$horay.'');
			   $this->Line(10, 36, 204, 36);  
			   $this->Ln(15);
		}
		function Footer()
		{
		    $this->SetY(-15);
			 $this->SetFont('Courier','',8);
		    $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
		    $hora_bruta = date("H:i:s");
		    $this->Ln(3);
		    $this->Cell(40,10,utf8_decode($_SESSION['denunciaMP']),0,1,'L');
		    $this->Cell(0,-10,date('d/m/Y')."  ".$hora_bruta,0,1,'R');
		    
		}
		function PDF($orientation='P',$unit='mm',$format='A4')
		{
			$this->FPDF($orientation,$unit,$format);
			$this->B=0;
			$this->I=0;
			$this->U=0;
			$this->HREF='';
		}
		function WriteHTML($html)
		{
			$html=str_replace("\n",' ',$html);
			$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
			foreach($a as $i=>$e)
			{
				if($i%2==0)
				{
					if($this->HREF)
						$this->PutLink($this->HREF,$e);
					else
						$this->Write(5,$e);
				}
				else
				{
					if($e[0]=='/')
						$this->CloseTag(strtoupper(substr($e,1)));
					else
					{
						$a2=explode(' ',$e);
						$tag=strtoupper(array_shift($a2));
						$attr=array();
						foreach($a2 as $v)
						{
							if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
								$attr[strtoupper($a3[1])]=$a3[2];
						}
						$this->OpenTag($tag,$attr);
					}
				}
			}
		}
		function OpenTag($tag,$attr)
		{
			if($tag=='B' || $tag=='I' || $tag=='U')
				$this->SetStyle($tag,true);
			if($tag=='A')
				$this->HREF=$attr['HREF'];
			if($tag=='BR')
				$this->Ln(5);
		}
		function CloseTag($tag)
		{
			if($tag=='B' || $tag=='I' || $tag=='U')
				$this->SetStyle($tag,false);
			if($tag=='A')
				$this->HREF='';
		}
		function SetStyle($tag,$enable)
		{
			$this->$tag+=($enable ? 1 : -1);
			$style='';
			foreach(array('B','I','U') as $s)
			{
				if($this->$s>0)
					$style.=$s;
			}
			$this->SetFont('',$style);
		}
		function PutLink($URL,$txt)
		{
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}
}

$pdf=new PDF('p','mm',$papel);
$pdf->SetTitle('Reporte Sipol');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('Courier','B',12);
$pdf->Ln(5);
$pdf->Cell(0,0,'DENUNCIA',0,0,'C');
$pdf->Ln(5);
if(isset($destinatario) && !empty($destinatario))
{
	
	$pdf->Ln(2);
	$pdf->SetFont('Courier','',10);
	$destinatario=$fun->amayuscula($destinatario);
	$pdf->MultiCell(0, 5,strip_tags($pdf->WriteHTML(utf8_decode($destinatario.":"))), 0, "J", 0);
	$pdf->Ln(3);
}
$pdf->SetFont('Courier','',10);
$pdf->MultiCell(0, 5,$bodydescripcion, 0, "J", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','B',10);
$pdf->MultiCell(0, 5,$bodydenunciante, 0, "J", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','',10);
$ubicacion=utf8_encode($ubicacion);
$ubicacion=$fun->amayuscula($ubicacion);
$pdf->MultiCell(0, 5, utf8_decode($ubicacion), 0, "J", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','B',10);
$pdf->MultiCell(0, 5,'OCURRIERON LOS HECHOS SIGUIENTES', 0, "C", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','',10);
$hechosnuevos = explode("-----", $hechos);
$titulo = array();
$hechoClean = array();
$relatoHtml = strip_tags(str_replace("&nbsp;", "", utf8_decode($relato)));
//$relatoHtml = strtoupper($relatoHtml);
$hugo = $relatoHtml;
//$hugo = utf8_decode(strtoupper($relato));





foreach ($hechosnuevos as $key => $value) 
{
		$titPersonas = "";
		$salto = "0";
		$titulo = explode("||",$value);
		$pdf->SetFont('Courier','B',10);
		$pdf->MultiCell(0, 5,strtoupper(utf8_decode($titulo[0])), 0, "J", 0);
		$nuevo = strtoupper(utf8_decode(str_replace($titulo[0]."||", "", $value)));
		$hechoClean = explode("|~|", $nuevo);
		$hechoPrint = $hechoClean[0]."~!";
		$hechoPrint = str_replace("~!", "", $hechoPrint);
		$personas = strtoupper(str_replace($hechoClean[0]."|~|", "", $nuevo));
		if(!empty($personas)) 
		{	$titPersonas = "PERSONAS IMPLICADAS: ";
			$salto = "3";
		}
		$pdf->SetFont('Courier','',10);
		
		$hechoPrint = str_replace('_',' ',$hechoPrint);
		$titPersonas = str_replace('_',' ',$titPersonas);
		$personas = str_replace('_',' ',$personas);

		//$fun->amayusculaed es con terminacion ed por encode decode
		$hechoPrint=$fun->amayusculaed($hechoPrint);
		$titPersonas=$fun->amayusculaed($titPersonas);
		$personas=$fun->amayusculaed($personas);

		$pdf->MultiCell(0, 5,$hechoPrint."------".$titPersonas.$personas, 0, "J", 0);
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
$pdf->Ln(5);

$relatohugo=$fun->amayuscula($relatoHtml);
$pdf->MultiCell(0, 5,$pdf->WriteHTML($relatohugo), 0, "J", 0);
$pdf->Ln(3);
$pdf->SetFont('Courier','B',10);
$pdf->MultiCell(0, 5,strip_tags ($bodyresponsables), 0, "J", 0);
//$pdf->Ln(15);
$pdf->SetFont('Courier','',10);


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
$pdf->MultiCell(0, 5,utf8_decode('AMPLIACIÓN DE DENUNCIA '), 0, "C", 0);
$pdf->Ln(5);
$pdf->SetFont('Courier','',10);
$pdf->MultiCell(0, 5,utf8_decode(strtoupper('SE REALIZÓ UNA AMPLIACIÓN DE ÉSTA DENUNCIA, EL DÍA: '.$funciones->fechaATexto($fecha,'u').' A LAS:'.$funciones->horaALetras($hora))), 0, "J", 0);
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
		$titPersonas = "";
		$salto = "0";
		$titulo = explode("||",$value);
		$pdf->SetFont('Courier','B',11);
		$pdf->MultiCell(0, 5,strtoupper(utf8_decode($titulo[0])), 0, "J", 0);
		$nuevo = strtoupper(utf8_decode(str_replace($titulo[0]."||", "", $value)));
		$hechoClean = explode("|~|", $nuevo);
		$hechoPrint = $hechoClean[0]."~!";
		$hechoPrint = str_replace("~!", "", $hechoPrint);
		$personas = strtoupper(str_replace($hechoClean[0]."|~|", "", $nuevo));
		if(!empty($personas)) 
		{	$titPersonas = "PERSONAS IMPLICADAS: ";
			$salto = "3";
		}
		$pdf->SetFont('Courier','',10);
		

		$pdf->MultiCell(0, 5,$hechoPrint."".$titPersonas.$personas, 0, "J", 0);
		#$pdf->Ln($salto);
		#$pdf->SetFont('Courier','B',12);
		#$pdf->MultiCell(0, 0,$titPersonas, 0, "J", 0);
		#$pdf->Ln($salto);
		#$pdf->SetFont('Courier','',12);
		#$pdf->MultiCell(0, 5,$personas, 0, "J", 0);
		$pdf->Ln(2);
}
$pdf->Ln(-10);

		$pdf->Ln(5);
		$pdf->MultiCell(0, 0,$pdf->WriteHTML('<b>RELATO:</b>'), 0, "J", 0);
		$pdf->Ln(5);
		$pdf->SetFont('Courier','',10);
		//extencion de realtos relatos2
		$relatos = strip_tags(str_replace(".&nbsp;", "", utf8_decode($relatos)));
		$realatos=utf8_encode($relatos);
		$relatos =mb_convert_case($relatos, MB_CASE_UPPER, "UTF-8");



		$pdf->MultiCell(0, 5,utf8_decode(strip_tags ($relatos)), 0, "J", 0);
}

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
$pdf->Cell(0,0,$pdf->Line(18,$y+2,100,$y+2),0,0,'L');
//$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Courier','',10);
$pdf->Cell(0,0,utf8_decode(strip_tags($denunciante['Nombre_Completo'])),0,0,'L'); 
$pdf->Ln(5);
$pdf->Cell(0,0,'DENUNCIANTE',0,0,'L'); 
$pdf->Ln(15);
//$pdf->SetFont('Courier','',12);
//$pdf->Cell(0,0,'AGENTE DE POLICIA',0,0,'C');
//$pdf->Ln(15);
$y = $pdf->GetY();
$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode($nombrecompleto),0,0,'C');
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