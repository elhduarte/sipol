<?php
if(isset($_GET['par']))
	{		
			require_once('lib/reportpdf/fpdf.php');
			include "lib/codigoqr/qrlib.php"; 
			$id_evento = $_GET['par'];
			$variableencript = new Encrypter;
			$idEvento = $variableencript->descompilarget($id_evento);
			/*$id_evento = 'nUyaKs6n2UQo+h0NlqwVQJbJ9b3KH4y2kahXuqj4DBQ=';			
			$variableencript = new Encrypter;
			$idEvento = $variableencript->decrypt($id_evento);
			$idEvento = $variableencript->decrypt($id_evento);
			echo "<br>";
			echo $idEvento;*/
			$variablesalidaqr = $variableencript->encrypt($id_evento);
			$reportes = new Reportes;
			$decrypt = new Encrypter;
			$funciones = new Funcionesp;
			$encabezado = $reportes->Encabezadopdf($idEvento);
			//var_dump($encabezado);
			$denunciante = $reportes->getDenunciantepdf($idEvento);
			$ubicacion = $reportes->getUbicacionDivpdf($idEvento);
			$hechos = $reportes->getHechosDivpdf($idEvento);
			$relatoUnificado = $reportes->getRelatopdf($idEvento);
			$relato = $decrypt->decrypt($relatoUnificado['Relato']);
			$objetos = $relatoUnificado['Objetos'];
			$objetos = $reportes->getObjetosDivpdf($objetos);
			//$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
			//$nombre_policia = $variable_datos_usuario[0]->nombre_completo;
		
			$nombre_policia = $encabezado['nombre_usuario'];

			$hora_ingreso = $encabezado['hora_ingreso'];
			$horaletras =  array();
			$horaletras = explode(":", $hora_ingreso);	
			$_SESSION['NUMERO_DENUNCIA'] = $encabezado['evento_num'];
			$_SESSION['FECHA_DENUNCIA'] = $encabezado['fecha_ingreso'];
			$_SESSION['hora_denuncia'] = $encabezado['hora_ingreso'];
			//$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
			//$nombreentidad = $variable_datos_usuario[0]->entidad;
			$nombreentidad = $encabezado['nombre_entidad'];			
			$_SESSION['entidad'] = $nombreentidad;
			$strinhoralestras = $funciones->horaALetras($encabezado['hora_ingreso']);
			$str = $encabezado['evento_num'];
			$numerodenuncialetras = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
			$variabledenuncialetras = "";
		foreach ($numerodenuncialetras as $posicion => $valordenuncia) {
				$variabledenuncialetras = $variabledenuncialetras.$funciones->numeroletrasdigito($valordenuncia).", ";
		}

$idencriptado = $decrypt->encrypt($idEvento);
$variabledenuncialetras = substr($variabledenuncialetras, 0, -2);  // devuelve "abcde"
$bodydescripcion =strtoupper(utf8_decode("EN INFRASCRITO AGENTE DE P.N.C. CON NOMBRE ".$nombre_policia." OFICINISTA DE LA COMISARIA ".$encabezado['nombre_entidad'].", CERTIFICA QUE EL DIA  ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')." SIENDO LAS ". $strinhoralestras.", A ESTA OFICINA DE ATENCION CIUDADANA VOLUNTARIAMENTE SE PRESENTO LA SIGUIENTE PERSONA QUIEN DIJO SER:"));
$num= $denunciante['DPI'];
$primerasec="";
$segundasec="";
$tercersec="";
$cadenacuidpi=$denunciante['DPI'];
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
		$cuiletras = $funciones->numtoletras($primerasec).", ".$funciones->numtoletras($segundasec).", ".$funciones->numtoletras($tercersec).".";
		$bodydenunciante = strtoupper(utf8_decode("".$denunciante['Nombre_Completo'].": de ".$denunciante['Edad']." años de edad,  Genero ".$denunciante['Genero'].", estado civil,".$denunciante['Estado_Civil'].", instruido ".$denunciante['Profesion'].", Pais de Nacimiento ".$denunciante['Pais_de_Nacimiento'].", Departamento ".$denunciante['Departamento_de_Nacimiento'].", Municipio ".$denunciante['r_municipio'].", y con domicilio actual ".$denunciante['Direccion_de_contacto'].",Documento de Identificacion DPI.".$denunciante['DPI']." En letras ".$cuiletras." Nombre del Padre:".$denunciante['Nombre_del_Padre'].", Nombre de la Madre:".$denunciante['Nombre_de_la_Madre']."."));
		$bodyresponsables = strtoupper(utf8_decode("SE LE EXTIENDE LA PRESENTE CONSTANCIA EN UNA HOJA DE PAPEL BOND, MEMBRETADA, SELLADA Y FIRMADA EL DIA  ".$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u')."; ASIGNADA CON UN CODIGO UNICO DE DENUNCIA ".$encabezado['evento_num']." EN LETRAS(".$variabledenuncialetras.")."));
		$enviourl = "&par=".$variablesalidaqr;
		$PNG_TEMP_DIR="";
		$PNG_TEMP_DIR = dirname('C:\wamp\apps\repositorios\sipol_vNueva\lib\codigoqr').'\codigoqr\temp'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = 'http://192.168.0.190/sipol/lib/codigoqr/temp/';
		if (!file_exists($PNG_TEMP_DIR))
		mkdir($PNG_TEMP_DIR);
		$filename = $PNG_TEMP_DIR.'test.png';
		$errorCorrectionLevel = 'H';
		$matrixPointSize = 9;
		$urldenuncia = 'http://192.168.0.190/sipol/index.php?r=correo/reporte'.$enviourl."";    
    if (isset($urldenuncia)) {           
        $filename = $PNG_TEMP_DIR.'test'.md5($urldenuncia.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($urldenuncia, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
$_SESSION['qr'] = $PNG_WEB_DIR.basename($filename);

class PDF extends FPDF
{
	var $B;
	var $I;
	var $U;
	var $HREF;
	var $numerodenuncia = "";
		function Header()
		{

			   $this->Image('images/logo_mingob.jpg',10,10,50);
			   $this->Image('images/pnc.jpg',155,5,20);
			   $this->Image($_SESSION['qr'],180,5,25);
			   $this->SetFont('Arial','',11);
			   $this->Cell(0,0,'POLICIA NACIONAL CIVIL',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,'GUATEMALA',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,'COMISARIA '.$_SESSION['entidad'],0,0,'C');
			      $this->Ln(8);		     	   
			   $this->SetFont('Arial','B',11);
			   $this->Text(10,35, 'DENUNCIA No.'.$_SESSION['NUMERO_DENUNCIA'].'');
			   $fecha1=$_SESSION['FECHA_DENUNCIA'];
			   $horax = str_replace('{','', $_SESSION['hora_denuncia']);
			   $horay = str_replace('}','',  $horax);
			   $fecha2=date("d-m-Y",strtotime($fecha1));
			   $this->Text(140,35, 'Fecha/hora: '.$fecha2."  ".$horay.'');
			   $this->Line(10, 37, 200, 37);  
			   $this->Ln(20);
		}
		function Footer()
		{
		    $this->SetY(-20);
			 $this->SetFont('courier','',8);
		    $this->Cell(0,10,'Pagina'.$this->PageNo().'/{nb}',0,0,'C');
		    $hora_bruta = date("H:i:s",time()-21600);
		    $this->Ln(5);
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
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('courier','B',15);
$pdf->Cell(0,0,'CONSTANCIA DE DENUNCIA',0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('courier','',13);
$pdf->MultiCell(0, 5,$bodydescripcion, 0, "J", 0);
$pdf->Ln(5);
$pdf->SetFont('courier','B',13);
$pdf->MultiCell(0, 5,$bodydenunciante, 0, "J", 0);
$pdf->Ln(5);
$pdf->SetFont('courier','',13);
$pdf->MultiCell(0, 0,$pdf->WriteHTML('<b>DENUNCIANDO:</b>'), 0, "J", 0);
$pdf->Ln(5);
$pdf->MultiCell(0, 5,'EN LA UBICACION DEL '.$ubicacion.'', 0, "J", 0);
$pdf->Ln(5);
$pdf->SetFont('courier','B',13);
$pdf->MultiCell(0, 10,'SE TIENEN LOS SIGUIENTES HECHOS:', 0, "C", 0);
$pdf->SetFont('courier','',13);
$hechosnuevos = explode("-----", $hechos);
$titulo = array();
foreach ($hechosnuevos as $key => $value) 
{
	$titulo = explode("||",$value);
		$pdf->SetFont('courier','B',13);
		$pdf->MultiCell(0, 5,$titulo[0], 0, "J", 0);
		$pdf->Ln(1);
		$nuevo = str_replace($titulo[0]."||", "", $value);
		$pdf->SetFont('courier','',13);
		$pdf->MultiCell(0, 5,$nuevo, 0, "J", 0);
		$pdf->Ln(3);
}

$pdf->MultiCell(0, 0,$pdf->WriteHTML('<b>RELATO:</b>'), 0, "J", 0);
$pdf->Ln(5);
$pdf->MultiCell(0, 5,strip_tags ($relato), 0, "J", 0);
$pdf->Ln(5);
$pdf->SetFont('courier','B',13);
$pdf->MultiCell(0, 5,strip_tags ($bodyresponsables), 0, "J", 0);
$pdf->SetFont('courier','',13);

$pdf->Ln(10);
$y = $pdf->GetY();
if($y >=199)
{
	$pdf->AddPage();
}
//$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$nombrecompleto = $nombre_policia; 
$pdf->SetFont('courier','',12);
$pdf->Cell(0,0,'AGENTE DE POLICIA',0,0,'C');
$pdf->Ln(15);
$y = $pdf->GetY();
$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode($nombrecompleto),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,'OFICINISTA DE TURNO',0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('courier','BI',9);
$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
$pdf->Ln(5);
$pdf->Output();
}//fin del get isset
?>