<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<?php


if (isset($_GET['valor']))
{
	require('fpdf.php');
	include "conexion.php";
	include "../codigoqr/qrlib.php";  

	$enviourl = "index.php?valor=".$_GET['valor'];

	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../codigoqr/temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = '../codigoqr/temp/';
    //include "../codigoqr/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR.'test.png';
    $errorCorrectionLevel = 'H';
    $matrixPointSize = 9;
    $urldenuncia = "reportpdf/".$enviourl."";
    if (isset($urldenuncia)) {           
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($urldenuncia.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($urldenuncia, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }     
   // echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  


session_start();
$_SESSION['NUMERO_DENUNCIA'] = "Pendiente";
$_SESSION['FECHA_DENUNCIA'] = "Pendiente";
$_SESSION['atributos_2'] = "";
$_SESSION['nombrehecho_2'] = "";
$_SESSION['relatodenuncia'] = "";
$_SESSION['hora_denuncia'] = "";
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



    //  
 




//$_SESSION['qr']


    $this->Image('pnc.jpg',10,5,25);
     $this->Image($_SESSION['qr'],175,5,25);
    $this->SetFont('Arial','',11);
      $this->Cell(0,0,'POLICIA NACIONAL CIVIL',0,0,'C');
      $this->Ln(5);
       $this->Cell(0,0,'GUATEMALA,GUATEMALA',0,0,'C');
        $this->Ln(5);
       $this->Cell(0,0,'COMISARIA 13',0,0,'C');
       
       //$this->Cell(0,50,'GUATEMALA,GUATEMALA',0,0,'C');
    //$this->Text(85, 10, 'POLICIA NACIONAL CIVIL');
    $this->SetFont('Arial','',11);
    //$this->Text(82, 15, 'GUATEMALA,GUATEMALA');
    $this->SetFont('Arial','',11);
    //$this->Text(95,20, '');
    $this->SetFont('Arial','B',13);
    //$this->Text(95,30, 'CONSTANCIA');
    $this->SetFont('Arial','B',11);
    $this->Text(10,40, 'No.'.$_SESSION['NUMERO_DENUNCIA'].'');
    $fecha1=$_SESSION['FECHA_DENUNCIA'];
    $horax = str_replace('{','', $_SESSION['hora_denuncia']);
    $horay = str_replace('}','',  $horax);
	$fecha2=date("d-m-Y",strtotime($fecha1));
    $this->Text(140,40, 'Fecha/hora: '.$fecha2."  ".$horay.'');
    $this->Line(10, 42, 200, 42);  
    $this->Ln(30);


		

}
function Footer()
{

		$hoy = date("Y-m-d");
	$month = date("m");
	$year = date("Y");
	$date = getDate();
	$hora = $date['hours'] -6 .":".$date['minutes'].":".$date['seconds'];

    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Pagina'.$this->PageNo().'/{nb}',0,0,'C');
    $this->Ln(5);
    $this->Cell(40,10,date('d/m/Y')."  ".$hora,0,1,'L');








}


function PDF($orientation='P',$unit='mm',$format='A4')
{
	//Llama al constructor de la clase padre
	$this->FPDF($orientation,$unit,$format);
	//Iniciación de variables
	$this->B=0;
	$this->I=0;
	$this->U=0;
	$this->HREF='';
}

function WriteHTML($html)
{
	//Intérprete de HTML
	$html=str_replace("\n",' ',$html);
	$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			//Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else
				$this->Write(5,$e);
		}
		else
		{
			//Etiqueta
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				//Extraer atributos
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
	//Etiqueta de apertura
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,true);
	if($tag=='A')
		$this->HREF=$attr['HREF'];
	if($tag=='BR')
		$this->Ln(5);
}

function CloseTag($tag)
{
	//Etiqueta de cierre
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF='';
}

function SetStyle($tag,$enable)
{
	//Modificar estilo y escoger la fuente correspondiente
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
	//Escribir un hiper-enlace
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}
}





$conn=conectar_bd();
$datospersonales ="";
 $numerodenuncia ="";

	$sql = "SELECT e.fecha_ingreso, 
e.evento_num,
p.datos AS persona,
e.relato_denuncia,
e.hora_ingreso,
e.direccion
FROM sipol_2.tbl_persona_detalle pd
LEFT JOIN sipol_2.tbl_tipo_persona tp ON pd.id_calidad_juridica = tp.id_tipo_persona
LEFT JOIN sipol_2.tbl_persona p ON p.id_persona = pd.id_persona
LEFT JOIN sipol_2.tbl_evento_detalle ed ON ed.id_evento_detalle = pd.id_evento_detalle
LEFT JOIN sipol_2.tbl_evento e ON e.id_evento = ed.id_evento
WHERE pd.id_calidad_juridica = 1 AND pd.id_evento_detalle IN 
(SELECT id_evento_detalle 
FROM sipol_2.tbl_evento_detalle 
WHERE id_evento = ".$_GET['valor'].");";
	$res = pg_query($sql) or die(pg_last_error());
	
	    if (!$res) 
	    {
       			 echo "hoa";
   		}    
    	else
    	{       
        		$total=0;
        		while ($row = pg_fetch_row($res)) 
				{ 
					$fecha_denuncia = $row[0];
					$numerodenuncia  = $row[1];
					$datospersonales = $row[2];

					$_SESSION['relatodenuncia'] = $row[3];
					$_SESSION['hora_denuncia'] = $row[4];
					$direccion = $row[5];
        		}
   		 }
 $y = json_decode($datospersonales);
 $nombrecompleto ="";
 $identicacion = "";
 $estado = 0;
 foreach ($y as $key => $value) 
 {
 	foreach ($value as $keyy => $valuee) 
 	{
 		foreach ($valuee as $keyyy => $valueee)
 		{

 				if($keyyy =="CUI")
 				{

 					if(strlen($valueee) <= 1)
 					{
 						//$identicacion = $identicacion."No tiene DPI ".$valueee;	
 						$estado = 1;					

 					}else
 					{ 						
 						$identicacion = $identicacion."identificado con Numero DPI <b>".$valueee."</b>";	
 						$estado = 0;
 					}


 					
 				} 		

 			if($keyyy =="PRIMER_NOMBRE")
 				{
 					$nombrecompleto = $nombrecompleto." ".$valueee;
 				}
 				if ($keyyy =="SEGUNDO_NOMBRE")
 				 {
 				 	$nombrecompleto = $nombrecompleto." ".$valueee;
 					# code...
 				}
 				if ($keyyy =="PRIMER_APELLIDO")
 				 {
 				 	$nombrecompleto = $nombrecompleto." ".$valueee;
 					# code...
 				}
 				if ($keyyy =="SEGUNDO_APELLIDO")
 				 {
 				 	$nombrecompleto = $nombrecompleto." ".$valueee;
 					# code...
 				}



 				if($estado ==1)//no tiene cedula
 				{
 						if ($keyyy =="ORDEN_CEDULA")
 					{

 						$identicacion = $identicacion."identificado con Orden de Cedula <b>".$valueee."</b>";	
 						$estado = 1;					

 					}
 					if ($keyyy =="REGISTRO_CEDULA")
 					{

 						$identicacion = $identicacion.",Numero de Registro <b>".$valueee."</b>";	
 						$estado = 1;					

 					}

 				}
 		}
 	}
 }
$textodireccion ="";
 $u = json_decode($direccion);
 foreach ($u as $ti => $va) 
 {
 	if($va =="")
 	{

 	}else{
 		$textodireccion = $textodireccion." ".strtoupper($ti)." ".strtoupper($va).",";
 	}
 	# code...
 	
 }




 $_SESSION['NUMERO_DENUNCIA']= $numerodenuncia;
 $_SESSION['FECHA_DENUNCIA'] = $fecha_denuncia;





//**************************************************************************************************************

 $sql2 = "select a.atributos,c.nombre_hecho,a.id_evento_detalle
from  sipol_2.tbl_evento_detalle a, sipol_2.tbl_evento b, sipol_2.tbl_hecho c 
where
b.id_evento = a.id_evento
and
c.id_hecho = a.id_hecho
and   b.evento_num = '".$_SESSION['NUMERO_DENUNCIA']."'";
$campo = "";
	$res2 = pg_query($sql2) or die(pg_last_error());
	
	    if (!$res2) 
	    {
       			 echo "hoa";
   		}    
    	else
    	{       
        		$total=0;
        		while ($row2 = pg_fetch_row($res2)) 
				{ 
					//var_dump($row2[0]);
				
				//$_SESSION['atributos_2']  = json_decode($row2[0]);
					$pruebas  = json_decode($row2[0]);

				$_SESSION['nombrehecho_2'] = $row2[1];
				$_SESSION['id_evento_detalle_2'] = $row2[2];

				foreach ($pruebas as $key => $value)
				 {
				
					if ($value == "")
					{

					}else{	
						$_SESSION['atributos_2'] = $_SESSION['atributos_2']."".$key." <i>".$value."</i>, ";

					}					
				}
						$pruebas ="";
						$a = array('-','_');
						//$a =("1", "2", "3");
						$b = array(' ',' ', '', '','','','','','','','');
						//$b = ('', '', '');
						 $remplazo = str_replace($a, $b, $_SESSION['atributos_2']);

						$campo = $campo."-<b>".strtoupper($_SESSION['nombrehecho_2'])."</b><br>".strtoupper($remplazo)."<br><br>";

$estado2 = 0;
						$sql3 = "SELECT pd.id_evento_detalle, 
p.datos as datos_persona,
tp.descripcion_tipo_persona as calidad_juridica,
ed.id_hecho, h.nombre_hecho
FROM sipol_2.tbl_persona_detalle pd
LEFT JOIN sipol_2.tbl_persona p ON p.id_persona = pd.id_persona
LEFT JOIN sipol_2.tbl_evento_detalle ed ON ed.id_evento_detalle = pd.id_evento_detalle
LEFT JOIN sipol_2.tbl_tipo_persona tp ON pd.id_calidad_juridica = tp.id_tipo_persona
LEFT JOIN sipol_2.tbl_hecho h ON h.id_hecho = ed.id_hecho
WHERE ed.id_evento IN (SELECT e.id_evento
FROM sipol_2.tbl_evento e
WHERE e.evento_num = '".$_SESSION['NUMERO_DENUNCIA']."') and pd.id_evento_detalle = ".$_SESSION['id_evento_detalle_2']."";
									$res3 = pg_query($sql3) or die(pg_last_error());
									
									    if (!$res3) 
									    {
								       			 echo "hoa";
								   		}    
								    	else
								    	{       
								        		$total=0;
								        		while ($row = pg_fetch_row($res3)) 
												{ 
													//$fecha_denuncia = $row[0];
													//$numerodenuncia  = $row[1];
													$datospersonaleshechos = $row[1];
															$XX = json_decode($datospersonaleshechos);
															 $nombrecompletohecho ="";
															 $identificaiconhecho = "";
															 foreach ($XX as $key => $value) 
															 {
															 	foreach ($value as $keyy => $valuee) 
															 	{
															 		foreach ($valuee as $keyyy => $valueee)
															 		{

															 				/*if($keyyy =="CUI")
															 				{
															 					$identificaiconhecho = $identificaiconhecho." ".$valueee;
															 				} 		*/




															 				if($keyyy =="CUI")
																		 				{

																		 					if(strlen($valueee) <= 1)
																		 					{
																		 						//$identicacion = $identicacion."No tiene DPI ".$valueee;	
																		 						$estado2 = 1;					

																		 					}else
																		 					{ 						
																		 						//$identicacion = $identicacion."DPI <b>".$valueee."</b>";	
																		 						$identificaiconhecho = $identificaiconhecho."DPI <b>".$valueee."</b>";
																		 						$estado2 = 0;
																		 					}


																		 					
																		 				} 		


															 			if($keyyy =="PRIMER_NOMBRE")
															 				{
															 					$nombrecompletohecho = $nombrecompletohecho." ".$valueee;
															 				}
															 				if ($keyyy =="SEGUNDO_NOMBRE")
															 				 {
															 				 	$nombrecompletohecho = $nombrecompletohecho." ".$valueee;
															 					# code...
															 				}
															 				if ($keyyy =="PRIMER_APELLIDO")
															 				 {
															 				 	$nombrecompletohecho = $nombrecompletohecho." ".$valueee;
															 					# code...
															 				}
															 				if ($keyyy =="SEGUNDO_APELLIDO")
															 				 {
															 				 	$nombrecompletohecho = $nombrecompletohecho." ".$valueee;
															 					# code...
															 				}

															 					if($estado2 ==1)//no tiene cedula
																 				{
																 						if ($keyyy =="ORDEN_CEDULA")
																 					{

																 						//$identicacion = $identicacion."Orden<b>".$valueee."</b>";	
																 						$estado2 = 1;	
																 						$identificaiconhecho = $identificaiconhecho."Orden Cedula <b>".$valueee."</b>";	
																		 										

																 					}
																 					if ($keyyy =="REGISTRO_CEDULA")
																 					{
																 						$identificaiconhecho = $identificaiconhecho.",Registro <b>".$valueee."</b>";	

																 						//$identicacion = $identicacion.",Registro <b>".$valueee."</b>";	
																 						$estado2 = 1;					

																 					}

																 				}





													//$campo = $campo."<b>-".$row[2].":</b><br>Nombre Completo:".$nombrecompletohecho."<br>Identificacion: ".$identificaiconhecho."<br>";
								        	
															 		}
															 	}
															 }


													$campo = $campo."<b>-".$row[2].":</b><br>Nombre Completo:".$nombrecompletohecho."<br>Identificacion: ".$identificaiconhecho."<br>";
								        		}




						
















								   		 }//fin del if cuando no encuentra nada en la conexion de base de datos

								   		  







											$campo = $campo."<br>";













						$_SESSION['atributos_2'] = "";
        		}
   		 }
$texto = utf8_decode("El suscrito receptor de la Oficina de Atencion al Ciudadano de la Policia Nacional Civil, hace constar que, El (La) Señor (a)<b> $nombrecompleto</b>,  $identicacion, se hizo presente en esta oficina con el objeto de denunciar un hecho ocurrido $textodireccion:");
$texto2 = utf8_decode("Descripción del(os) Objeto(s):");
$traductorresporte = utf8_decode($campo);
$text3 = "No siendo mas el objeto de la presente diligencia, se da por terminada, luego de leida y aprobada por quienes en ella intervinieron.";
$pdf=new PDF('p','mm','Letter');
$pdf->AddPage();
//$pdf=new FPDF('L','pt','Legal');

$pdf->AliasNbPages();
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,'CONSTANCIA',0,0,'C');
$pdf->Ln(5);

//$pdf->SetFont('Arial','',9);
//$pdf->MultiCell(0, 5,$texto, 0, "J", 0);

$pdf->SetFont('Arial','',8);
$pdf->WriteHTML(html_entity_decode($texto));
$pdf->Ln(10);

$pdf->SetFont('Arial','',10);
$pdf->WriteHTML(html_entity_decode($texto2));
$pdf->Ln(10);

/*$pdf->SetFont('Arial','',10);
$pdf->WriteHTML(html_entity_decode($textodireccion));
$pdf->Ln(10);*/



$pdf->SetFont('Arial','',8);
$pdf->WriteHTML(html_entity_decode($traductorresporte));
$pdf->Ln(10);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,'RELATO DENUNCIA',0,0,'C');
$pdf->Ln(10);
$valoresrelato = strip_tags($_SESSION['relatodenuncia']); 
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0, 5,$valoresrelato, 0, "J", 0);

 $pdf->Ln(30);

 //$pdf->Ln; 
//$pdf->Ln; 
//$x=$pdf->GetX(); 
//$y=$pdf->GetY(); 
//$pdf->Line($x+60,$y+1,$x+100,$y+1); 
//$pdf->SetLineWidth(5); 
//$pdf->Ln(5);
 $pdf->Cell(0,0,'_____________________________________________',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,'Firma y Sello, Funcionario Receptor PNC',0,0,'C');
$pdf->Ln(5);

//$x=$pdf->GetX(); 
//$y=$pdf->GetY(); 
//$pdf->Line($x+60,$y+1,$x+100,$y+1); 

//$pdf->Image($_SESSION['qr'],$x,$y,30);
//$pdf->Ln(10);
//$pdf->Ln(10);
//$pdf->Ln(10);



//$pdf->Line(0, 0, 200, 10);  
//$pdf->Ln(30);


$pdf->Output();

}else{

	Echo "No esta hecho esta hecho";


}

?>
