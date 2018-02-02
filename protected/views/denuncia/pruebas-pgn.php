<script type="text/javascript">

$(document).ready(function(){

	$(document).keydown(function(e){
		//Si el evento es keydown 8 backspace, previene el evento
		if(e.which == 8)
			e.preventDefault();
	});

}); //Fin del document ready



</script>

<?php
require_once('lib/reportpdf/fpdf.php');	

$idEvento = "1057";
$reportes = new Reportes;
$decrypt = new Encrypter;

$a='1';

if($a=='1')
{
	$pgn = $reportes->getLostChild($idEvento);
	$pgn = json_decode($pgn);
	print_r($pgn);

	if(empty($pgn)) 
	{
		echo 'no hay nada';
	}
		
}else
{


$funciones = new Funcionesp;
$encabezado = $reportes->Encabezadopdf($idEvento);
$denunciante = $reportes->getDenunciante($idEvento);
$ubicacion = $reportes->getUbicacionDivpdf($idEvento);
$hechos = $reportes->getLostChild($idEvento);
$relatoUnificado = $reportes->getRelato($idEvento);
$relato = $decrypt->decrypt($relatoUnificado['Relato']);
$objetos = $relatoUnificado['Objetos'];
$objetos = (!empty($objetos)) ? $reportes->getObjetosDiv($objetos) : "Sin registros";
$destinatario = $relatoUnificado['Destinatario'];


$_SESSION['entidad'] = $encabezado['nombre_entidad'];
$_SESSION['sede'] = $encabezado['nombre_sede'];
$_SESSION['dmupio'] = $encabezado['departamento'].", ".$encabezado['municipio'];
$hechos = json_decode($hechos);
$ubicacion = strtoupper(utf8_decode('LUGAR: '.$ubicacion."."));

$featuresFisicas = "";

if(!empty($hechos->nino_desaparecido->Tipo_de_Cabeza)) $featuresFisicas = $featuresFisicas."Tipo de cabeza: ".$hechos->nino_desaparecido->Tipo_de_Cabeza.", ";
if(!empty($hechos->nino_desaparecido->Tipo_de_Bigote)) $featuresFisicas = $featuresFisicas."tipo de bigote: ".$hechos->nino_desaparecido->Tipo_de_Bigote.", ";
if(!empty($hechos->nino_desaparecido->Tipo_de_Cejas)) $featuresFisicas = $featuresFisicas."tipo de cejas: ".$hechos->nino_desaparecido->Tipo_de_Cejas.", ";
if(!empty($hechos->nino_desaparecido->Tipo_de_Ojos)) $featuresFisicas = $featuresFisicas."tipo de ojos: ".$hechos->nino_desaparecido->Tipo_de_Ojos.", ";
if(!empty($hechos->nino_desaparecido->Color_de_Ojos)) $featuresFisicas = $featuresFisicas."color de ojos: ".$hechos->nino_desaparecido->Color_de_Ojos.", ";
if(!empty($hechos->nino_desaparecido->Peso)) $featuresFisicas = $featuresFisicas."peso aproximado: ".$hechos->nino_desaparecido->Peso." lbs, ";
if(!empty($hechos->nino_desaparecido->Estatura)) $featuresFisicas = $featuresFisicas."estatura aproximada: ".$hechos->nino_desaparecido->Estatura." mts, ";
if(!empty($hechos->nino_desaparecido->Color_de_Piel)) $featuresFisicas = $featuresFisicas."color de piel: ".$hechos->nino_desaparecido->Color_de_Piel.", ";
if(!empty($hechos->nino_desaparecido->Tipo_de_Cabello)) $featuresFisicas = $featuresFisicas."tipo de cabello: ".$hechos->nino_desaparecido->Tipo_de_Cabello.", ";
if(!empty($hechos->nino_desaparecido->Color_de_Cabello)) $featuresFisicas = $featuresFisicas."color de cabello: ".$hechos->nino_desaparecido->Color_de_Cabello.", ";
if(!empty($hechos->nino_desaparecido->Tipo_de_Nariz)) $featuresFisicas = $featuresFisicas."tipo de nariz: ".$hechos->nino_desaparecido->Tipo_de_Nariz.", ";
if(!empty($hechos->nino_desaparecido->Complexion_Fisica)) $featuresFisicas = $featuresFisicas."complexión física: ".$hechos->nino_desaparecido->Complexion_Fisica.", ";
if(!empty($hechos->nino_desaparecido->Usa_Lentes)) $featuresFisicas = $featuresFisicas."lentes: ".$hechos->nino_desaparecido->Usa_Lentes.", ";
if(!empty($hechos->nino_desaparecido->Tatuajes)) $featuresFisicas = $featuresFisicas."tatuajes: ".$hechos->nino_desaparecido->Tatuajes.", ";
if(!empty($hechos->nino_desaparecido->Caracteristicas_fisicas)) $featuresFisicas = $featuresFisicas."caracteristicas físicas: ".$hechos->nino_desaparecido->Caracteristicas_fisicas.", ";

$featuresFisicas = $featuresFisicas."||";
$featuresFisicas = str_replace(", ||", ".", $featuresFisicas);

$identificacion = "Sin Documento";
$identificacionDenun = "Sin Documento";

if($hechos->agresor->Tipo_identificacion !== "Sin Documento") $identificacion = $hechos->agresor->Tipo_identificacion.", NÚMERO: ".$hechos->agresor->Numero_identificacion;
if($denunciante['Tipo_identificacion'] !== "Sin Documento") $identificacionDenun = $denunciante['Tipo_identificacion'].", NÚMERO: ".$denunciante['Numero_identificacion'];

#var_dump($encabezado);
#var_dump($hechos->nino_desaparecido);
#print_r($hechos->nino_desaparecido);
/*
$a = json_decode($hechos);

var_dump($a);*/

class PROCURADORIA extends FPDF
{
	var $B;
	var $I;
	var $U;
	var $HREF;
	var $numerodenuncia = "";
		function Header()
		{
			$this->Image('images/extravio.jpg',10,6,100);
			   #$this->Image('images/logo_mingob.jpg',10,10,49);
			   #$this->Image('images/pnc.jpg',155,5,20);
			   //$this->Image($_SESSION['qr'],180,5,25);
			   $this->SetFont('Arial','',8);
			   $this->Cell(0,0,'POLICIA NACIONAL CIVIL',0,0,'R');
			   $this->Ln(4);
			   $this->Cell(0,0,$_SESSION['dmupio'],0,0,'R');
			   $this->Ln(4);
			  # $this->Cell(0,0,$_SESSION['entidad'],0,0,'C');
			   $this->Cell(0,0,$_SESSION['entidad'],0,0,'R');
			   

			   $this->Ln(4);
			   #$this->Cell(0,0,$_SESSION['sede'],0,0,'C');
			   $this->Cell(0,0,$_SESSION['sede'],0,0,'R');
			   //$this->Ln(5);		     	   
			   $this->SetFont('Arial','B',8);
			# $this->Text(10,31, 'DENUNCIA NO. '.$_SESSION['NUMERO_DENUNCIA'].'');
			  #$this->Text(10,31, 'DENUNCIA NO. 0112130256-001041');
			  
			   #$fecha1=$_SESSION['FECHA_DENUNCIA'];
			   #$horax = str_replace('{','', $_SESSION['hora_denuncia']);
			   #$horay = str_replace('}','',  $horax);
			  #$fecha2=date("d-m-Y",strtotime($fecha1));
			   #$this->Text(156,37, 'FECHA/HORA: '.$fecha2."  ".$horay.'');
			  #$this->Text(156,37, ' FECHA/HORA: 16-12-2013 09:52:17');
			
			   #$this->Line(10, 29, 210, 29); 
			  # $this->Line(10, 25, 205, 25);  
			   $this->Ln(5);
		}
		function Footer()
		{
		    $this->SetY(-15);
			$this->SetFont('courier','',8);
			$this->Cell(0,0,'OFICINISTA DE TURNO - PNC',0,0,'C');
			$this->Ln(3);
			$this->SetFont('courier','BI',8);
			$this->Cell(0,0,'"SOY POLICIA CON VALOR Y VIVO PARA SERVIR CON CONFIABILIDAD"',0,0,'C');
			$this->Ln(1);
		    $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
		    $hora_bruta = date("H:i:s");
		    $this->Ln(3);
		    #$this->Cell(40,10,utf8_decode($_SESSION['denunciaMP']),0,1,'L');
		   # $this->Cell(0,-10,date('d/m/Y')."  ".$hora_bruta,0,1,'R');
		    
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
$ancho = '196';
$pdf=new PROCURADORIA('p','mm','legal');
#$pdf->SetMargins(2, 2, 2);
$pdf->SetTitle('Reporte Sipol');
$pdf->AddPage();
$pdf->AliasNbPages();
#$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('Arial','',8);
//$pdf->Ln(0);
$pdf->Cell($ancho,10,'P.G.N.',0,0,'L');
$pdf->Ln(4);
$pdf->Cell($ancho,10,utf8_decode('TELÉFONO: 1546 / 2414-8787'),0,0,'L');
$pdf->Ln(4);
$pdf->Cell($ancho,10,utf8_decode('EXTENSIÓN 2014'),0,0,'L');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
//$pdf->Cell($ancho,-22,'DENUNCIA NO. '.$encabezado['evento_num'],0,0,'R');
$pdf->Cell($ancho,-22,'DENUNCIA NO. '.$encabezado['evento_num'],0,0,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Ln(10);
$titulo = utf8_decode('FORMULARIO DE DENUNCIA PARA NIÑOS, NIÑAS O ADOLESCENTES DESAPARECIDOS');
$pdf->Cell(0,0,$titulo,0,0,'C');
$pdf->Ln(5);
$titulo = utf8_decode('PROCURADORIA DE LA NIÑEZ Y LA ADOLESCENCIA');
$pdf->Cell(0,0,$titulo,0,0,'C');
$pdf->SetFont('courier','',9);
$pdf->Ln(3);
$pdf->Cell($ancho,10,'FECHA: '.$hechos->fecha.' HORA: '.$hechos->hora,0,0,'L');
$pdf->Ln(4);
$pdf->Cell($ancho,10,$ubicacion,0,0,'L');
$pdf->Ln(10);
/*---------------------------------------------------------------------*/
$pdf->SetFont('Arial','B',9);
$titulo = utf8_decode('DATOS DE LOS NIÑOS, NIÑAS DESAPARECIDOS');
$pdf->Cell($ancho,7,$titulo,1,1,'C');
/*---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('NOMBRE COMPLETO: '.$hechos->nino_desaparecido->Nombre_Completo);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*---------------------------------------------------------------------*/


/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('LUGAR Y FECHA DE NACIMIENTO: '.$hechos->nino_desaparecido->Pais_de_Nacimiento.", ".$hechos->nino_desaparecido->Departamento_de_Nacimiento.", ".$hechos->nino_desaparecido->Municipio_de_Nacimiento);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/


/*------------------------------------------------*/
$pdf->SetFont('courier','',8);
$titulo = utf8_decode('PARTIDAD DE NACIMIENTO:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('P.No');
$pdf->Cell(12,7,$titulo,1,0,'L');
$pdf->Cell(37,7,'',1,0,'L');
$titulo = utf8_decode('FOLIO');
$pdf->Cell(12,7,$titulo,1,0,'L');
$pdf->Cell(37,7,'',1,0,'L');
$titulo = utf8_decode('LIBRO');
$pdf->Cell(12,7,$titulo,1,0,'L');
$pdf->Cell(37,7,'',1,1,'L');
/*------------------------------------------------*/

/*------------------------------------------------*/
$pdf->SetFont('courier','',8);
$titulo = utf8_decode('MUNICIPALIDAD:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->nino_desaparecido->Municipio_de_Nacimiento);
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('DEPARTAMENTO:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->nino_desaparecido->Departamento_de_Nacimiento);
$pdf->Cell(49,7,$titulo,1,1,'L');
/*------------------------------------------------*/

/*------------------------------------------------*/
$pdf->SetFont('courier','',8);
$titulo = utf8_decode('EDAD:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->nino_desaparecido->Edad);
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('SEXO:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->nino_desaparecido->Genero);
$pdf->Cell(49,7,$titulo,1,1,'L');
/*------------------------------------------------*/

/*------------------------------------------------*/
$pdf->SetFont('courier','',8);
$titulo = utf8_decode('NACIONALIDAD:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->nino_desaparecido->Pais_de_Nacimiento);
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('RELIGION:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('');
$pdf->Cell(49,7,$titulo,1,1,'L');
/*------------------------------------------------*/


/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('DIRECCION ACTUAL: '.$hechos->nino_desaparecido->Direccion_de_contacto);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/


/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('TELÉFONO: '.$hechos->nino_desaparecido->r_telefono_cnt);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/


/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('NOMBRE DE LOS PADRES: '.$hechos->nino_desaparecido->Nombre_de_la_Madre." / ".$hechos->nino_desaparecido->Nombre_del_Padre);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('ETNIA: '.$hechos->nino_desaparecido->Etnia);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('CARACTERISTICAS FISICAS Y OTROS: '.$featuresFisicas.' DEFECTOS FISICOS: '.$hechos->nino_desaparecido->Amputaciones);
$pdf->MultiCell($ancho, 7, $titulo, 1,'J', 0);
/*----------------------------------------------------------*/

/*----------------------------------------------------------*/
$pdf->MultiCell($ancho, 7, utf8_decode('VESTIMENTA: '.$hechos->nino_desaparecido->Vestimenta), 1,'J', 0);

/*----------------------------------------------------------*/

/*---------------------------------------------------------------------*/
$pdf->SetFont('courier','B',12);
$titulo = utf8_decode('');
$pdf->Cell($ancho,7,$titulo,1,1,'C');
/*---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*/
$pdf->SetFont('Arial','B',10);
$titulo = utf8_decode('DATOS DEL PRESUNTO AGRESOR(A)');
$pdf->Cell($ancho,7,$titulo,1,1,'C');
/*---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('NOMBRE COMPLETO: '.$hechos->agresor->Nombre_Completo);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*---------------------------------------------------------------------*/



/*------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('EDAD:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->agresor->Edad);
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('SEXO:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->agresor->Genero);
$pdf->Cell(49,7,$titulo,1,1,'L');
/*------------------------------------------------*/

/*------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('ESTADO CIVIL:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->agresor->Estado_Civil);
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('NACIONALIDAD:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($hechos->agresor->Nacionalidad);
$pdf->Cell(49,7,$titulo,1,1,'L');
/*------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('PARENTESCO CON LA VICTIMA: '.$hechos->agresor->Parentesco_Agresor);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('DOCUMENTO DE IDENTIFICACION: '.$identificacion);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/



/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('DIRECCION ACTUAL: '.$hechos->agresor->Direccion_de_contacto);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/



/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('TELéFONO: '.$hechos->agresor->r_telefono_cnt);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/



/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('OBSERVACIONES: '.$hechos->agresor->observaciones);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('');
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/



/*---------------------------------------------------------------------*/
$pdf->SetFont('Arial','B',10);
$titulo = utf8_decode('DATOS DEL DENUNCIANTE');
$pdf->Cell($ancho,7,$titulo,1,1,'C');
/*---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('NOMBRE COMPLETO: '.$denunciante['Nombre_Completo']);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*---------------------------------------------------------------------*/



/*------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('EDAD:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($denunciante['Edad']);
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('SEXO:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($denunciante['Genero']);
$pdf->Cell(49,7,$titulo,1,1,'L');
/*------------------------------------------------*/

/*------------------------------------------------*/
$pdf->SetFont('courier','',8);
$titulo = utf8_decode('ESTADO CIVIL:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($denunciante['Estado_Civil']);
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode('NACIONALIDAD:');
$pdf->Cell(49,7,$titulo,1,0,'L');
$titulo = utf8_decode($denunciante['Nacionalidad']);
$pdf->Cell(49,7,$titulo,1,1,'L');
/*------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('PARENTESCO CON LA VICTIMA: '.$hechos->nino_desaparecido->Parentesco_Denunciante);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('DOCUMENTO DE IDENTIFICACION: '.$identificacionDenun);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('DIRECCION ACTUAL: '.$denunciante['Direccion_de_contacto']);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('DIRECCION TRABAJO:');
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('TELÉFONO: '.$denunciante['r_telefono_cnt']);
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('OBSERVACIONES:');
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/
/*---------------------------------------------------------------------------
$titulo = utf8_decode('');
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/




$pdf->Ln(30);


/*---------------------------------------------------------------------*/
$pdf->SetFont('Arial','B',10);
$titulo = utf8_decode('RELATO DEL HECHO');
$pdf->Cell($ancho,7,$titulo,1,1,'C');
/*---------------------------------------------------------------------*/


/*---------------------------------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode(strtoupper($relato));
$pdf->MultiCell($ancho, 7, $titulo, 1,'J', 0);
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------------*/
$titulo = utf8_decode('');
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*----------------------------------------------------------*/

/*---------------------------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('NOMBRE DE LA ABOGADA(0):');
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*---------------------------------------------------------------------*/


/*---------------------------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('NOMBRE DEL AUXILIAR:');
$pdf->Cell($ancho,7,$titulo,1,1,'L');
/*---------------------------------------------------------------------*/

	
$pdf->Ln(10);

/*---------------------------------------------------------------------*/
$pdf->SetFont('courier','',9);
$titulo = utf8_decode('GUATEMALA '.$funciones->fechaATexto($encabezado['fecha_ingreso'], 'u').' ('.$encabezado['hora_ingreso'].')');
$pdf->Cell(200,5,$titulo,0,0,'L');
/*---------------------------------------------------------------------*/

$pdf->Ln(25);

$y = $pdf->GetY();
$pdf->Cell(0,0,$pdf->Line(57,$y,158,$y),0,0,'C');
$pdf->Ln(3);
$pdf->Cell(0,0,utf8_decode($encabezado['puesto']),0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode($encabezado['nombre_usuario']),0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode($encabezado['nombre_entidad']),0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode($encabezado['nombre_sede']),0,0,'C');

$pdf->Output();
}

?>