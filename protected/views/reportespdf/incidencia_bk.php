<?php
require_once('lib/reportpdf/fpdf.php');
if(isset($_GET['par']))
{
	
	$idEvento = $_GET['par'];
	$decrypt = new Encrypter;
	$idEvento = $decrypt->descompilarget($idEvento);
	$variablesalidaqr = $decrypt->encrypt($idEvento);
	$reportes = new Reportes;
	$funciones = new Funcionesp;
	$qrdenuncia = $funciones->generarqrincidencias($_GET['par']);
	$_SESSION['qr'] = $qrdenuncia;
	$encabezado = $reportes->Encabezadopdf($idEvento);
	$ubicacion = $reportes->getUbicacionDivpdf($idEvento);
	$tipoIncidencia = $reportes->getTipoIncidencia($idEvento);
	$relatoEnco = $reportes->getRelato($idEvento);
	$relato = $decrypt->decrypt($relatoEnco['Relato']);
	$implicados = $reportes->getImplicadosPdf($relatoEnco['Implicados']);
	$agentesBruto = $reportes->getAgentesPdf($idEvento);
	$patrullasBruto = $reportes->getPatrullasPdf($idEvento);
	$consignados = $reportes->getConsignadosPdf($idEvento);
	$agentes = explode("~", $agentesBruto);
	$agentesPrint = "REPORTA QUE EL AGENTE: ".$agentes[0];
	$patrullas = explode("~", $patrullasBruto);
	$ubicacionPrint = " SE PRESENTÓ EN LA UBICACIÓN SIGUIENTE: ".$ubicacion;
	$destinatario = "";
	if(isset($relatoEnco['Destinatario'])) $destinatario = $relatoEnco['Destinatario'];

	if($agentes[1] > 1) 
	{
		$agentesPrint = "REPORTA QUE LOS AGENTES: ".$agentes[0];
		$ubicacionPrint = " SE PRESENTARON EN LA UBICACIÓN SIGUIENTE: ".$ubicacion;
	}
	if($patrullas[0] == "empty")
	{
		$patrullasPrint = "";
	}
	else
	{
		$patrullasPrint = ", EN LA PATRULLA ".$patrullas[0];
		if($patrullas[1] > 1) $patrullasPrint = ", EN LAS PATRULLAS ".$patrullas[0];
	}
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
	foreach ($numerodenuncialetras as $posicion => $valordenuncia) 
	{
		$variabledenuncialetras = $variabledenuncialetras.$funciones->numeroletrasdigito($valordenuncia).", ";
	}
	$idencriptado = $decrypt->encrypt($idEvento);
	$variabledenuncialetras = substr($variabledenuncialetras, 0, -2);
	$bodydescripcion = strtoupper(utf8_decode("EL INFRASCRITO AGENTE DE PNC: ".$nombre_policia.", OFICINISTA DE ".$encabezado['nombre_entidad'].", ".$agentesPrint.$patrullasPrint."; ".$ubicacionPrint.". DEBIDO A: ".$tipoIncidencia['Motivo']));
	$bodyIncidencia = strtoupper(utf8_decode("REPORTA UNA INCIDENCIA DE TIPO: ".$tipoIncidencia['Tipo']."; CON LOS DETALLES SIGUIENTES: "));
	$bodyRelato = strtoupper(utf8_decode($relato));
	$headerImplicados =strtoupper(utf8_decode("AL LUGAR DEL EVENTO SE PRESENTARON LAS ENTIDADES SIGUIENTES: ")); 
	$bodyImplicados = strtoupper(utf8_decode($implicados));
	$headerConsignados =  strtoupper(utf8_decode("SE REALIZÓ LA CONSIGNACIÓN DE: "));
	$bodyConsignados = strtoupper(utf8_decode($consignados));
	$bodyFinal = strtoupper(utf8_decode("SE EXTIENDE LA PRESENTE CONSTANCIA EN UNA HOJA DE PAPEL BOND, MEMBRETADA, SELLADA Y FIRMADA EL DIA  ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')."; ASIGNADA CON EL SIGUIENTE CÓDIGO ÚNICO: ".$encabezado['evento_num']."(".$variabledenuncialetras.")."));
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
			   $this->Image($_SESSION['qr'],180,5,25);
			   $this->SetFont('Arial','',10);
			   $this->Cell(0,0,'POLICIA NACIONAL CIVIL',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,'GUATEMALA',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,$_SESSION['entidad'],0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,$_SESSION['sede'],0,0,'C');
			   //$this->Ln(5);		     	   
			   $this->SetFont('Arial','B',8);
			   $this->Text(10,41, 'INCIDENCIA NO. '.$_SESSION['NUMERO_DENUNCIA'].'');
			   $fecha1=$_SESSION['FECHA_DENUNCIA'];
			   $horax = str_replace('{','', $_SESSION['hora_denuncia']);
			   $horay = str_replace('}','',  $horax);
			   $fecha2=date("d-m-Y",strtotime($fecha1));
			   $this->Text(156,41, 'FECHA/HORA: '.$fecha2."  ".$horay.'');
			   $this->Line(10, 36, 204, 36);  
			   $this->Ln(15);
		} 
		function Footer()
		{
		    $this->SetY(-15);
			 $this->SetFont('courier','',8);
		    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		    $hora_bruta = date("H:i:s",time());
		    $this->Ln(3);
		    $this->Cell(40,10,date('d/m/Y')."  ".$hora_bruta,0,1,'L');
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
	$pdf=new PDF('p','mm','Letter');
	$pdf->SetTitle('Reporte Sipol');
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,20);  
	$pdf->SetFont('courier','B',12);
	$pdf->Cell(0,0,'INCIDENCIA POLICIAL',0,0,'C');
	$pdf->Ln(5);
	if(isset($destinatario) && !empty($destinatario))
	{	
		$pdf->Ln(-2);
		$pdf->SetFont('courier','',10);
		$pdf->MultiCell(0, 5,strip_tags($pdf->WriteHTML(strtoupper(utf8_decode($destinatario.":")))), 0, "J", 0);
		$pdf->Ln(2);
	}
	$pdf->SetFont('courier','',10);
	$pdf->MultiCell(0, 5,$bodydescripcion, 0, "J", 0);
	$pdf->Ln(5);
	$pdf->SetFont('courier','',10);
	$pdf->MultiCell(0, 5,$bodyIncidencia, 0, "J", 0);
	$pdf->Ln(5);
	$pdf->SetFont('courier','',10);
	$pdf->MultiCell(0, 5,$bodyRelato, 0, "J", 0);
	$pdf->Ln(5);
	$pdf->SetFont('courier','',10);
	$pdf->MultiCell(0, 5,$headerImplicados, 0, "J", 0);
	$pdf->Ln(5);
	$pdf->SetFont('courier','',10);
	$pdf->MultiCell(0, 5,$pdf->WriteHTML($bodyImplicados), 0, "J", 0);
	if(!empty($consignados))
	{
		$pdf->Ln(5);
		$pdf->SetFont('courier','',10);
		$pdf->MultiCell(0, 5,$headerConsignados, 0, "J", 0);
		$pdf->Ln(5);
		$pdf->SetFont('courier','',10);
		$pdf->MultiCell(0, 5,$pdf->WriteHTML($bodyConsignados), 0, "J", 0);
	}
	$pdf->SetFont('courier','',10);
	$pdf->MultiCell(0, 5,$bodyFinal, 0, "J", 0);
	$pdf->Ln(20);
	$y = $pdf->GetY();
	if($y >=215)
	{
		$pdf->AddPage();
	}
	$nombrecompleto = $nombre_policia;
	$y = $pdf->GetY();
	$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,0,utf8_decode($nombrecompleto),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,0,'OFICINISTA DE TURNO - PNC',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont('courier','BI',9);
	$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
	$pdf->Ln(5);
	$pdf->Output();
}
?>