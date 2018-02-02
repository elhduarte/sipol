<?php

class VehiculosController extends Controller
{
	public function actionConsultaSAT()
	{
		$this->render('consultaSat');
	}

	public function actionConsultaSolvencias()
	{
		$tipo = $_POST['tipoPlaca'];
		$numero = $_POST['numeroPlaca'];
		$WSConsulta = new WSConsulta;
		$result = $WSConsulta->ConsultaVehiculoPreliminar($tipo,$numero);

		if(!empty($result))
		{
			foreach ($result as $key => $value) {}
			$a = (array) $value;

			if($a['RECUPERADO'] == "N")
			{
				echo "Este Vehiculo tiene reporte de robo con fecha: ".$a['FECHA_ROBO'];	
			}
		}
		
	}


	public function actionConsultaVehiculos()
	{
		$tipo = $_POST['tipoPlaca'];
		$numero = $_POST['numeroPlaca'];
		$numero = strtoupper ($numero);
		$WSConsulta = new WSConsulta;
		#$Solvencias = $WSConsulta->ConsultaVehiculoPreliminar($tipo,$numero);
		$data = $WSConsulta->ConsultaVehiculoSAT($tipo,$numero);
		$novedades =  $WSConsulta->ConsultaVehiculoNovedades($tipo,$numero);
		$SolvenciasLocal = $WSConsulta->ConsultaVehiculoAntecedentes($tipo,$numero);
		$devolover = "";
		$respuestaSat = "empty";
		$respuestaSolvencia = "empty";
		$respuestaNovedades = "empty";

		/*
		if(!empty($Solvencias))
		{
			foreach ($Solvencias as $key => $value) {}
			$a = (array) $value;

			if($a['RECUPERADO'] == "N")
			{
				$respuestaSolvencia = "La placa: <b>".$tipo." ".$numero."</b> 
				tiene al menos un reporte de robo pendiente con fecha: ".$a['FECHA_ROBO'].
				" - <b> Verifique en el sistema correspondiente</b>";	
			}
		}

		if(!empty($SolvenciasLocal))
		{
			foreach ($SolvenciasLocal as $k => $val) {}
			$e = (array) $val;

			if($e['ESTATUS'] == "robado")
			{
				$respuestaSolvencia = "La placa: <b>".$tipo." ".$numero."</b> 
				tiene al menos un reporte de robo pendiente: - 
				<b> Verifique en el sistema correspondiente</b>";	
			}
		}
	
		//var_dump($sat);
		*/

		if(isset($data['datos_sat']))
		{
			$a = $data['datos_sat']['datos_propietario'];
			$data = $data['datos_sat']['datos_generales'];

			$s['marca'] = $data['marca'];
			$s['color'] = $data['color'];
			$s['modelo'] = $data['modelo'];
			$s['linea'] = $data['linea'];
			$s['tipo'] = $data['tipo_vehiculo'];
			$s['chasis'] = $data['chasis'];
			$s['motor'] = $data['motor'];
			$s['estado']= $data['estado'];

			$a= $a['propietario'];
			$b = explode(',',$a);
				if(!isset($b[0]))
				{
					$b[0]= '';
				}
				if(!isset($b[1]))
				{
					$b[1]= '';
				}
				if(!isset($b[2]))
				{
					$b[2]= '';
				}
				if(!isset($b[3]))
				{
					$b[3]= '';
				}
				if(!isset($b[4]))
				{
					$b[4]= '';
				}
						
				$propietarioa = $b[3].' '.$b[4].' '.$b[0].' '.$b[1];

		$s['propietario'] = $propietarioa;

			$respuestaSat = json_encode($s);

		}

/*
		if($novedades !== "[]")
		{
			//$respuestaNovedades = htmlentities($novedades);
			$respuestaNovedades = utf8_decode($novedades);
			//$respuestaNovedades = json_decode($novedades);
			//$respuestaNovedades = json_encode($novedades);
		}else 
		{
			$respuestaNovedades = "[]";
		}
*/
		echo $devolover = $respuestaSat;
		//var_dump($sat);
		
	}

	public function actionConsumeLicencia()
	{
		$WSConsulta = new WSConsulta;
		$numero = $_POST['numero'];
		$primer_nombre = $_POST['primer_nombre'];
		$segundo_nombre = $_POST['segundo_nombre'];
		$primer_apellido = $_POST['primer_apellido'];
		$segundo_apellido = $_POST['segundo_apellido'];

		if($numero !== "empty")
		{
			$consulta = $WSConsulta->ConsultaLicenciaNumero($numero);
		}
		else
		{
			$consulta = $WSConsulta->ConsultaLicenciaNombre($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido);
		}

		echo $consulta;
	}

	public function actionConsumeRenap()
	{
		$WSConsulta = new WSConsulta;
		$dpi = $_POST['dpi'];
		$primer_nombre = $_POST['primer_nombre'];
		$segundo_nombre = $_POST['segundo_nombre'];
		$primer_apellido = $_POST['primer_apellido'];
		$segundo_apellido = $_POST['segundo_apellido'];

		if($dpi !== 'empty')
		{
			$consulta = $WSConsulta->ConsultaDpi($dpi);
		}
		else
		{
			$consulta = $WSConsulta->ConsultaNombre($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido);
		}

		echo $consulta;
	}
}