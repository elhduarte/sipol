<?php
require_once('lib/reportpdf/fpdf.php');		
	
		try {

		
class PDF extends FPDF
{
	var $B;
	var $I;
	var $U;
	var $HREF;
	var $numerodenuncia = "";
	var $imagenqr = "";

		function Header()
		{
			$this->Image('images/extravio.jpg',10,6,100);
			$this->Ln(4);
			//$this->Image($_SESSION['qr'],180,4,25);
			$this->Ln(3);
			$this->SetFont('Arial','B',8);
			$this->Text(10,28, 'PREVENCION POLICIAL No. 0022221515');
			//$fecha1=$_SESSION['FECHA_DENUNCIA'];
		   //$horax = str_replace('{','', $_SESSION['hora_denuncia']);
		   //$horay = str_replace('}','',  $horax);
		   //$fecha2=date("d-m-Y",strtotime($fecha1));
		   ///$this->Text(160,34, 'Fecha/hora: '.$fecha2."  ".$horay.'');
		   $this->Line(10, 30, 204, 30);  
		   $this->Ln(20); 
		}
/*
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
			   $this->Cell(0,0,$_SESSION['entidad'],0,0,'C');
			   $this->Ln(8);		     	   
			   $this->SetFont('Arial','B',11);
			   $this->Text(10,35, 'EXTRAVIO NO.'.$_SESSION['NUMERO_DENUNCIA'].'');
			   $fecha1=$_SESSION['FECHA_DENUNCIA'];
			   $horax = str_replace('{','', $_SESSION['hora_denuncia']);
			   $horay = str_replace('}','',  $horax);
			   $fecha2=date("d-m-Y",strtotime($fecha1));
			   $this->Text(140,35, 'Fecha/hora: '.$fecha2."  ".$horay.'');
			   $this->Line(10, 37, 200, 37);  
			   $this->Ln(20);
		}*/
		function Footer()
		{
		    $this->SetY(-20);
			 $this->SetFont('courier','',8);
		    //$this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
		    $hora_bruta = date("H:i:s");
		    $this->Ln(5);
		    //$this->Cell(40,10,date('d/m/Y')."  ".$hora_bruta,0,1,'L');
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

$pdf=new PDF('p','mm','letter');
$pdf->SetTitle('Reporte Sipol');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('courier','B',12);
$pdf->Cell(0,0,utf8_decode('PREVENCION POLICIAL'),0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('courier','',9);
$cuerpo  ="No. Correlativo Automatico ";
$pdf->Cell(0,0,utf8_decode($cuerpo),0,0,'R');
$pdf->Ln(4);
$cuerpo  ="Guatemala, fecha de mes de año ID06  ";
$pdf->Cell(0,0,utf8_decode($cuerpo),0,0,'R');
$pdf->Ln(4);
$cuerpo  ="Hora: hh:mm ID07  ";
$pdf->Cell(0,0,utf8_decode($cuerpo),0,0,'R');
$pdf->Ln(20);

$cuerpo  ="SEÑOR  ID09 cargo de la autoridad a quien se informa ";
$pdf->Cell(0,0,utf8_decode($cuerpo),0,0,'L');
$pdf->Ln(10);

$cuerpo  = "Nosotros los suscritos agentes de Policía Nacional Civil, ID10 nombre e identificación del agente de procedimiento y sus compañeros acompañantes, en cumplimiento a lo dispuesto en el artículo 304 del Código Procesal Penal, Decreto Número 51-92 del Congreso de la República de Guatemala, precedemos a informarle detalladamente de lo siguiente: ID18 relación de los hechos y si se hizo alguna investigación…(*)";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo), 0, "J", 0);
$pdf->Ln(10);

$cuerpo_dos="Nombre Agente(s) de Procedimiento y número de NIP ID22";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(10);


$cuerpo_dos="(f) ___________________________________ firmas necesarias";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(10);


$cuerpo_dos="La Prevención Policial iría sola en el caso de 'Incidentes'
Si hubieren aprehensiones se continúa con lo siguiente y se firma al final del acta…";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(10);


$cuerpo_dos="…(*), por lo cual procedimos a la aprehensión de ID22 nombre (s) de (l) (los) aprehendido (s) según el acta que acontinuación consignamos.";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(10);


$pdf->SetFont('courier','B',12);
$pdf->Cell(0,0,'ACTA DE APREHENSION',0,0,'C');

$pdf->Ln(20);

$pdf->SetFont('courier','',9);
$cuerpo_dos="En el Municipio nombre del municipio (JUZGADO donde se facciona el acta y se pone a disposición) del departamento de nombre del departamento (JUZGADO donde se facciona el acta y se pone a disposición),  siendo las hora en letras (en que se facciona el acta y se pone a disposición)  horas, con minutos en letras minutos, del día fecha en letras de mes del año año en letras, nosotros, ID10 nombre, cargo e identificación de los agentes (en el caso de ser un particular el que aprehende, se identifica primero), en ID16, ID14, ID15, ID13, ID12, ID17 lugar de la aprehensión, lugar al cual nos hemos hecho presentes por ID3 razón de su presencia , por lo que procedimos de la siguiente manera: PRIMERO: en cumplimiento ID18 descripción de los antecedentes y relación de los hechos (modo, tiempo, lugar)  SEGUNDO: conforme la relación de los hechos descritos en el punto anterior, procedimos conforme a la ley  a la aprehensión de: ID22 identificación de los aprehendidos a quienes se les hace saber sus derechos según lo establecen los artículos 6, 7, 8 y 9 de la Constitución Política de la República de Guatemala. Nosostros los comparecientes damos por terminada la presente diligencia de aprehensión; y de que finaliza la presente Acta de aprehensión, que queda contenida en número en letras hojas membretadas de papel bond, impresas las primeras número en letras en ambos lados y esta última únicamente en el anverso, las cuales numeramos, sellamos y firmamos, cuando son las hora en letra horas con minutos en letras minutos, en el mismo lugar y fecha al principio consignados.";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(20);

$cuerpo_dos="Nombre Agente(s) captor(es) y número de NIP ID22";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(20);



$cuerpo_dos="Nombre Agente Digitador Juzgado de Turno Usuario Sistema";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(20);


$cuerpo_dos="(f) ___________________________________ firmas necesarias";
$pdf->MultiCell(0, 5,utf8_decode($cuerpo_dos), 0, "J", 0);
$pdf->Ln(20);

//nombrecompleto = $nombre_policia; 
//$y = $pdf->GetY();
//$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
//$pdf->Ln(3);
//$pdf->Cell(0,0,utf8_decode($nombrecompleto),0,0,'C');
//$pdf->Ln(5);
//$pdf->Cell(0,0,'OFICINISTA DE TURNO - PNC',0,0,'C');
//$pdf->Ln(5);
//$pdf->SetFont('courier','BI',8);
//$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
//$pdf->Ln(5);
//$pdf->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
//$pdf->Ln(4);
//$pdf->Cell(0,0,$nombreentidad,0,0,'C');
//$pdf->Ln(4);
//$pdf->Cell(0,0,$encabezado['nombre_sede'],0,0,'C');
//$pdf->Ln(4);

//$pdf->Ln(5);
$pdf->Output();

			} catch (Exception $e) {
		echo "No puede hacer esta consulta";
	}


?>