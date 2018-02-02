<?php

			$tipo = 'p';
			$placa = '194dpj';
			$usuario = 'hduarte';	
			$cliente = 'RVR';
			$url_rvr = 'http://172.21.5.5/ws_rvr/ws_rvr.php';
	


		$arreglo_cliente['placa'] =$placa;
		$arreglo_cliente['tipo'] =$tipo;
		$arreglo_cliente['motor'] ='';
		$arreglo_cliente['chasis'] ='';
		$arreglo_cliente['usuario'] ='webpage';
		$arreglo_cliente['cliente'] ='RVR';

			$ws_cliente = new SoapClient(null, array("location"=>$url_rvr, "uri"=>$url_rvr));
			//$data=$ws_cliente->BuscaRoboVehiculo($tipo,$placa);
			$data=$ws_cliente->BuscaRoboVehiculo($arreglo_cliente);

	echo '<pre>';
	print_r($data['datos_sat']);
	echo '</pre>';
	$a = $data['datos_sat']['datos_propietario'];
	#var_dump($a);

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
				print_r($propietarioa);