<?php
require('lib/reportpdf/fpdf.php');
if(isset($_GET['carta']))
{
	try {
	$compilarclase = new Encrypter;
	$id = $compilarclase->descompilarget($_GET['carta']);
	class PDF extends FPDF
	{
		var $B;
		var $I;
		var $U;
		var $HREF;
		var $numerodenuncia = "";
			function Header()
			{
	   		   $this->Image('images/logo_mingob.jpg',160,10,40);
			   $this->SetFont('Arial','',9);
			   $this->Cell(0,0,utf8_decode('Dirección de Informática'),0,0,'L');
			   $this->Ln(5);
			   $this->Cell(0,0,utf8_decode('Integración de Sistemas'),0,0,'L');
			   $this->Ln(5);
			   $this->SetFont('Arial','',15);
			   $this->Cell(0,0,'Carta de Responsabilidad',0,0,'C');
		       $this->SetFont('Arial','',11);
			   $this->Line(10, 30, 200, 30);  
			   $this->Ln(20);//sALTO DE LINEA.. 
			}
			
			function Footer()
			{
				$this->SetY(-15);
			    $this->SetFont('Arial','',9);
				$this->Cell(0,0,utf8_decode('6ª. Avenida 13-71 Zona 1, 3er. Nivel, Palacio de Gobernación'),0,0,'C');
				$this->Ln(5);
				$this->Cell(0,0,utf8_decode('PBX 2413-8888 Ext. -3201-'),0,0,'C');
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
	}//fin de la clase para los pdf

		$tbl_usuario = new TblUsuario;
		$resultado = $tbl_usuario->perfil_carta_usuario_cuerpo($id);
	$variablearray = "";
	foreach($resultado as $key => $value)
	{
		$variablearray = $value;
	}
	$body ="";
	$obervations = "";
	while (list($clave, $valor) = each($variablearray)) 
	{
		if($clave =="body")
		{
			$body = $valor;
		}
			else if($clave =="observaciones")
			{
				$obervations= $valor;
			}
	}




	$resultado = $tbl_usuario->perfil_carta_usuario($id);
	$decodificar1 =json_encode($resultado);
	$deco=json_decode($decodificar1);

	foreach ($deco as $key) 
	{
	    $usuario[0]=$key->usuario;
	    $password[1]=$key->password;
	    $N1[2]=$key->primer_nombre;
	    $N2[3]=$key->segundo_nombre;
	    $A1[4]=$key->primer_apellido;
	    $A2[5]=$key->segundo_apellido;
	    $fecha_crea[6]=$key->fecha_crea;
	    $nombre_entidad[7]=$key->nombre_entidad;
	    $nombre_rol[8]= $key->nombre_rol;
	    $nombre_sistema[9]='SIPOL';
	    $region[10]='';
	    $municipio[11]=$key->municipio;
	    $departamento[12]=$key->departamento;
	    $ubicacion[13] = $key->ubicacion;
	}
	//$key='mingob$2013SIPOL';
	//$nuevo_desencriptador = new Decrypter();
	//$texto_original = $compilarclase->decrypt($password[1],$key);
	$texto_original = $password[1];
	//var_dump($texto_original);
	//echo $texto_original;

	$pdf=new PDF('p','mm','Letter');
	$pdf->AddPage();
	$pdf->SetFont('Arial','',15);
	$pdf->Cell(0,0,utf8_decode($N1[2]." ".$N2[3]." ".$A1[4]." ".$A2[5]),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Sistema: "),0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,6,utf8_decode($nombre_sistema[9]),0);
	//$pdf->Ln();
	//$pdf->SetFont('Arial','B',9);
	//$pdf->Cell(30,6,utf8_decode("Región: "),0);
	//$pdf->SetFont('Arial','',9);
	//$pdf->Cell(30,6,utf8_decode($region[10]),0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Ubicacion: "),0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,6,utf8_decode($nombre_entidad[7]),0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Rol: "),0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,6,utf8_decode($nombre_rol[8]),0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Usuario: "),0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,6,utf8_decode($usuario[0]),0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Contraseña: "),0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,6,utf8_decode('************'),0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Fecha: "),0);
	$pdf->SetFont('Arial','',9);
	$fecha = date("d-m-Y H:i:s",strtotime($fecha_crea[6]));
	$pdf->Cell(30,6,utf8_decode($fecha ),0);
	$pdf->Ln();


	//$body= str_replace("USO Y ACCESO DE LA INFORMACION.", "<b>USO Y ACCESO DE LA INFORMACION.</b>", $body);
	//$body= str_replace("urgente", "<b><u>urgente</u></b>", $body);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Estimado Usuario:"),0);
	$pdf->Ln();
	$pdf->Ln();
	$valorbody = utf8_decode($body); 
	$pdf->SetFont('Arial','',9);
	$pdf->MultiCell(0, 5,$valorbody,0,"J",0);

	$obervations= str_replace("HELP DESK", "<b>HELP DESK</b>", $obervations);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,6,utf8_decode("Observaciones:"),0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->MultiCell(0,5,$pdf->WriteHTML(utf8_decode($obervations)),0,"J",0);
	$pdf->Ln(10);
	$pdf->Ln(30);
	$pdf->Cell(0,0,'_____________________________________________',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,0,'Firma, Funcionario Receptor',0,0,'C');
	$pdf->Ln(5);
	$pdf->Output();

	
} catch (Exception $e) {
		echo "No puede hacer esta consulta";
	}
	
}else{
	echo "no se tiene registro del envio";
}
	
?>