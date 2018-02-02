<?php
require('lib/reportpdf/fpdf.php');
if(isset($_GET['nip']))
{
	try {
	$compilarclase = new Encrypter;
	$id = $compilarclase->descompilarget($_GET['nip']);
	$id_usuario = $id;
	$idusuario = $id_usuario ;
	$tblusuario = new TblUsuario;
	function validarcampo($valor)
 {
  $salida = "";
   if(empty($valor))
      {
         $salida = "Sin Registro"; 
      }else{
          $salida = $valor;
      }
    return $salida;
 }
  function validarestado($valor)
 {

  $salida = "";
   if($valor == "1")
      {
      	    $salida ="ACTIVO";
      
      }else{
          //$salida = '<strong><font color="red">Desactivado</font> </strong>';
       $salida ="DESACTIVADO";
      
      }
    return $salida;
 }
  function validarsexo($valor)
 {
  $salida = "";
   if($valor == "1")
      {
         $salida ='HOMBRE';
      }else{
          $salida = 'MUJER';
      }
    return $salida;
 }
   function validarestadosistema($valor)
 {
  $salida = "";
   if($valor == "1")
      {
         $salida ='Activo';
      }else{
          $salida = 'Eliminado';
      }
    return $salida;
 }


	$usuariodatos = $tblusuario->consulta_usuario_completo($idusuario);
	$puesto = $usuariodatos->puesto;
	$usuario = $usuariodatos->usuario;
	$password = $usuariodatos->password;
	$email = $usuariodatos->email;
	$no_oficio_solicitud = $usuariodatos->no_oficio_solicitud;
	$id_usuario_crea = $usuariodatos->id_usuario_crea;
	$fecha_crea = $usuariodatos->fecha_crea;
	$estado = $usuariodatos->estado;
	$primer_nombre = $usuariodatos->primer_nombre;
	$segundo_nombre = $usuariodatos->segundo_nombre;
	$primer_apellido = $usuariodatos->primer_apellido;
	$segundo_apellido = $usuariodatos->segundo_apellido;
	$fecha_nacimiento = $usuariodatos->fecha_nacimiento;
	$dpi = $usuariodatos->dpi;
	$no_orden = $usuariodatos->no_orden;
	$direccion = $usuariodatos->direccion;
	$departamento = $usuariodatos->departamento;
	$municipio = $usuariodatos->municipio;
	$sexo = $usuariodatos->sexo;
	$no_registro = $usuariodatos->no_registro;
	$foto = $usuariodatos->foto;
	$proceso = $usuariodatos->proceso;
	$nombredepartamento = $usuariodatos->nombredepartamento;
	$nombremunicipio = $usuariodatos->nombremunicipio;
	$nombrerol = $usuariodatos->nombrerol;
	$nombrecomisaria = $usuariodatos->nombrecomisaria;
         if(empty($foto))
        {
          $fotografia = "images/noimagen.png";
          
        }
        else
        {
          
          $fotografia = "data:image/jpg;base64,".$foto;
          
        }     
  $resultadosistemasquery = $tblusuario->consulta_usuario_entidad_completo_usuario_crea($id_usuario_crea);
  $sistemaentidad=$resultadosistemasquery->entidad; 
  $sistemanombre_rol=$resultadosistemasquery->nombre_rol; 
  $sistemaid_usuario=$resultadosistemasquery->id_usuario; 
  $sistemanombre_completo=$resultadosistemasquery->nombre_completo; 
  $sistemaubicacion=$resultadosistemasquery->ubicacion;   
/*CONSUMO DEL SISPE*/	
	$WSConsulta = new WSConsulta;
	$primerNombre = "";
	$segundoNombre = "";
	$primerApellido = "";
	$segundoApellido = "";
	$codEmpleado = "";
	$puestoFuncional = "";
	$puestoNominal = "";
	$estadosispe = "";
	$nacimiento = "";
	$nit = "";
	$nip = "";
	$foto = "images/noimagen.png";
	$poli = "";	
	$nip = validarcampo($usuario);
	$poli = $WSConsulta->ConsultaPersonalPNC($nip);
	if(!empty($poli))
	{
		$poli = json_decode($poli);
		$poli = (array) $poli;
		$nip = $poli['NIP'];
		if($nip== 0){		
			$codEmpleado = "Sin registro";
			$puestoFuncional = "Sin registro";
			$puestoNominal = "Sin registro";
			$estadosispe = "Sin registro";
			$nacimiento = "Sin registro";
			//$dpi = "Sin registro";
			$nit = "Sin registro";
			$nip = "Sin registro";
			$fotosispe = "Sin registro";
			$fotosispe = "images/noimagen.png";
		}else{
		$primerNombre = $poli['PRIMER_NOMBRE'];
		$segundoNombre = $poli['SEGUNDO_NOMBRE'];
		$primerApellido = $poli['PRIMER_APELLIDO'];
		$segundoApellido = $poli['SEGUNDO_APELLIDO'];
		$codEmpleado = $poli['COD_EMPLEADO'];
		$puestoFuncional = $poli['PUESTO_FUNCIONAL'];
		$puestoNominal = $poli['PUESTO_NOMINAL'];
		$estadosispe = $poli['SIT_ADMIN'];
		$nacimiento = $poli['FECHA_NACIMIENTO'];
		//$dpi = $poli['CUI'];
		$nit = $poli['NIT'];
		$nip = $poli['NIP'];
		$fotosispe = $poli['BYTES'];
			if(empty($fotosispe))
	        {
	          $fotosispe = "images/noimagen.png";          
	        }
	        else
	        {          
	          $fotosispe = "data:image/jpg;base64,".$fotosispe;          
	        }
		}		
	}
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
			   $this->SetFont('Arial','',10);
			   $this->Cell(0,0,'POLICIA NACIONAL CIVIL',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,'GUATEMALA',0,0,'C');
			   $this->Ln(5);
			   $this->Cell(0,0,'Reporte Global de Usuario',0,0,'C');
			   $this->Ln(5);		     	   
			   $this->SetFont('Arial','B',8);
			   $this->Line(10, 33, 204, 33);  
			   $this->Ln(15);
		}
		function Footer()
		{
		    $this->SetY(-15);
			 $this->SetFont('courier','',8);
		    $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
		    $hora_bruta = date("H:i:s");
		    $this->Ln(3);
		   // $this->Cell(40,10,utf8_decode($_SESSION['denunciaMP']),0,1,'L');
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
$pdf=new PDF('p','mm','letter');
$pdf->SetTitle('Reporte Sipol');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);  
$pdf->SetFont('courier','B',12);
$pdf->Cell(0,0,$primer_nombre." ".$segundo_nombre ." ".$primer_apellido ." ".$segundo_apellido,0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('courier','B',10);
$pdf->Cell(196,5,'Informacion de Usuario',1,1,'C');
$pdf->SetFont('courier','',10);
$pdf->Cell(49,5,'Numero CUI',1,0,'J');
$pdf->Cell(49,5,validarcampo($dpi),1,0,'J');
$pdf->Cell(49,5,'Fecha Nacimiento',1,0,'J');
$pdf->Cell(49,5,date("d-m-Y H:i:s",strtotime(validarcampo($fecha_nacimiento))),1,1,'J');
$pdf->Cell(49,5,'Departamento',1,0,'J');
$pdf->Cell(49,5,validarcampo($nombredepartamento),1,0,'J');
$pdf->Cell(49,5,'Municipio',1,0,'J');
$pdf->Cell(49,5,validarcampo($nombremunicipio),1,1,'J');
$pdf->Cell(24,5,'Genero',1,0,'J');
$pdf->Cell(25,5,validarsexo($sexo),1,0,'J');
$pdf->Cell(25,5,'Direccion',1,0,'J');
$pdf->SetFont('courier','B',8);
$pdf->Cell(122,5,validarcampo($direccion),1,1,'J');
$pdf->Ln(5);
$pdf->SetFont('courier','B',10);
$pdf->Cell(196,5,'Informacion usuario Sipol',1,1,'C');
$pdf->SetFont('courier','',10);
$pdf->Cell(38,5,'ROL',1,0,'J');
$pdf->Cell(60,5,$nombrerol,1,0,'J');
$pdf->Cell(38,5,'Puesto',1,0,'J');
$pdf->Cell(60,5,validarcampo($puesto),1,1,'J');
$pdf->Cell(38,5,'Usuario',1,0,'J');
$pdf->Cell(60,5,validarcampo($usuario),1,0,'J');
$pdf->Cell(38,5,'Correo',1,0,'J');
$pdf->Cell(60,5,validarcampo($email),1,1,'J');
$pdf->Cell(38,5,'Sede',1,0,'J');
$pdf->Cell(158,5,$nombrecomisaria,1,1,'J');
$pdf->Cell(38,5,'Registro',1,0,'J');
$pdf->Cell(60,5,validarcampo($no_oficio_solicitud),1,0,'J');
$pdf->Cell(38,5,'Ingreso',1,0,'J');
$pdf->Cell(60,5,date("d-m-Y H:i:s",strtotime(validarcampo($fecha_crea))),1,1,'J');
$pdf->Cell(38,5,'Sistema',1,0,'J');
$pdf->Cell(60,5,validarestadosistema($proceso),1,0,'J');
$pdf->Cell(38,5,'Estado Usuario',1,0,'J');
$pdf->Cell(60,5,validarestado($estado),1,1,'J');
$pdf->Ln(5);
$pdf->SetFont('courier','B',10);
$pdf->Cell(196,5,'Informacion usuario SISPE',1,1,'C');
$pdf->SetFont('courier','',10);
$pdf->Cell(38,5,'NIP',1,0,'J');
$pdf->Cell(60,5,$nip,1,0,'J');
$pdf->Cell(38,5,'Codigo Empleado',1,0,'J');
$pdf->Cell(60,5,$codEmpleado,1,1,'J');
$pdf->Cell(38,5,'Puesto Funcional',1,0,'J');
$pdf->Cell(60,5,$puestoFuncional,1,0,'J');
$pdf->Cell(38,5,'Puesto Nominal',1,0,'J');
$pdf->Cell(60,5,$puestoNominal,1,1,'J');
$pdf->Cell(38,5,'Estado',1,0,'J');
$pdf->Cell(60,5,$estadosispe,1,0,'J');
$pdf->Cell(38,5,'NIT',1,0,'J');
$pdf->Cell(60,5,$nit,1,1,'J');
$pdf->Ln(5);
$pdf->SetFont('courier','B',10);
$pdf->Cell(93,5,'INFORMACION SOBRE SISTEMA',1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell(93,5,'INFORMACION SOBRE CONSUMOS',1,1,'C');
$pdf->SetFont('courier','',10);
/*L: izquierda
T: superior
R: derecha
B: inferior*/
$a = 78;
$b = 15;
$pdf->Cell($a,5,'Total Ingresos Sistema',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_ingreso_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaDPINombre',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,1),1,1,'C');
$pdf->Cell($a,5,'Total de Tickets',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_ticket_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaIndiceDPI',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,2),1,1,'C');
$pdf->Cell($a,5,'Total de Sugerencias ',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_sugerencia_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaDPI',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,3),1,1,'C');
$pdf->Cell($a,5,'Total de Denuncias Activas',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_denuncia_activa_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaOrdenCapturaNombre',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,4),1,1,'C');
$pdf->Cell($a,5,'Total de Denuncias Inactivas ',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_denuncia_inactiva_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaLicenciaNombre',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,5),1,1,'C');
$pdf->Cell($a,5,'Total de Extravios Activos ',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_extravio_activa_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaVehiculoPreliminar',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,6),1,1,'C');
$pdf->Cell($a,5,'Total de Extravios Inactivos ',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_extravio_inactiva_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaVehiculoPlacaTransito',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,7),1,1,'C');
$pdf->Cell($a,5,'Total de Incidencias Activas ',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_incidencia_activa_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaNovedades',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,8),1,1,'C');
$pdf->Cell($a,5,'Total de Incidencias Inactivas ',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_incidencia_inactiva_sistema($id_usuario),1,0,'C');
$pdf->Cell(10,5,'','LR',0,'C');
$pdf->Cell($a,5,'ConsultaPersonaPNC',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,9),1,1,'C');
$pdf->Cell($a,5,'',0,0,'J');
$pdf->Cell($b,5,'',0,0,'C');
$pdf->Cell(10,5,'','R',0,'C');
$pdf->Cell($a,5,'ConsultaVehiculoPlaca',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,10),1,1,'C');
$pdf->Cell($a,5,'',0,0,'J');
$pdf->Cell($b,5,'',0,0,'C');
$pdf->Cell(10,5,'','R',0,'C');
$pdf->Cell($a,5,'EnvioSMS',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,11),1,1,'C');
$pdf->Cell($a,5,'',0,0,'J');
$pdf->Cell($b,5,'',0,0,'C');
$pdf->Cell(10,5,'','R',0,'C');
$pdf->Cell($a,5,'IngresoDenunciaMP',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,12),1,1,'C');
$pdf->Cell($a,5,'',0,0,'J');
$pdf->Cell($b,5,'',0,0,'C');
$pdf->Cell(10,5,'','R',0,'C');
$pdf->Cell($a,5,'ConsultaPatrulla',1,0,'J');
$pdf->Cell($b,5,$tblusuario->conteo_consumo_sistema($id_usuario,13),1,1,'C');
$pdf->Ln($b);
$pdf->Ln(5);
$pdf->Output();


	
} catch (Exception $e) {
		echo "No puede hacer esta consulta";
	}
	
}else{
	echo "no se tiene registro del envio";
}

?>
