<?php
if(isset($_GET['par']))
	{

			require_once('lib/reportpdf/fpdf.php');
			include "lib/codigoqr/qrlib.php"; 
			$id_evento = $_GET['par'];
			$variableencript = new Encrypter;
			$idusuario = $variableencript->descompilarget($id_evento);



      $sql= "select fecha_ingreso, hora_ingreso, ip_ingreso, origen  from sipol_usuario.tbl_session_usuario where id_usuario  = ".$idusuario."
      ORDER BY fecha_ingreso DESC, hora_ingreso DESC ";
      $resultado = Yii::app()->db->createCommand($sql)->queryAll();
      $variablearray = "";
      $hora_ingreso_session = array();
      


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
			   #$this->Image($_SESSION['qr'],180,5,25);
			   $this->SetFont('Arial','',11);
			   $this->Cell(0,0,'Ministerio de Gobernacion',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,'GUATEMALA',0,0,'C');
			   $this->Ln(5);
			  # $this->Cell(0,0,'COMISARIA '.$_SESSION['entidad'],0,0,'C');
			      $this->Ln(8);		     	   
			   $this->SetFont('Arial','B',11);
			   #$this->Text(10,35, 'DENUNCIA No.'.$_SESSION['NUMERO_DENUNCIA'].'');
			   #$fecha1=$_SESSION['FECHA_DENUNCIA'];
			  # $horax = str_replace('{','', $_SESSION['hora_denuncia']);
			   #$horay = str_replace('}','',  $horax);

			   /*$fecha2=date("d-m-Y",strtotime($fecha1));
			   $this->Text(140,35, 'Fecha/hora: '.$fecha2."  ".$horay.'');*/
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
$pdf->Cell(0,0,'Resumen de Ingresos Sistema',0,0,'C');

$pdf->Ln(5);
$pdf->SetFont('courier','B',11);
     $pdf->Cell(30,8,'Fecha',1,0,'L');
           $pdf->Cell(25,8,'Hora',1,0,'L');
            $pdf->Cell(35,8,'IP',1,0,'L');
            $pdf->Cell(106,8,'Origen',1,1,'L');

            $pdf->Ln(5);
$pdf->SetFont('courier','',11);
foreach ($resultado as $key => $value) 
      {
          $hora_ingreso_session= explode(".", $value['hora_ingreso']);
          $fecha2=date("d-m-Y",strtotime($value['fecha_ingreso']));
          $ip_ingreso = $value['ip_ingreso'];
          $ingreso =  $value['origen'];
          //$filavisitas = $filavisitas." <tr><td>".$fecha2."</td><td>".$hora_ingreso_session['0']."</td></tr>";
          $pdf->Cell(30,8,$fecha2,1,0,'L');
           $pdf->Cell(25,8,$hora_ingreso_session['0'],1,0,'L');
            $pdf->Cell(35,8,$ip_ingreso,1,0,'L');
            $pdf->MultiCell(0, 5,$ingreso, 1, "J", 0);
            $pdf->Ln(5);
             //$pdf->Cell(70,8,$ingreso,1,1,'L');
      }



$pdf->Output();
}//fin del get isset
?>
