<?php
require_once('lib/soap/nusoap.php');

class WSConsulta
{
	var $ws_user = 'U$rM1ng0b';
	var $ws_password = "S1st3m@s2014";
	var $ConsultaNombre = "ConsultaDPINombre"; //Método en el WS que consulta por nombres
	//var $ConsultaLlave = "ConsultaIndiceDPI"; //Método en el WS que consulta por la llave RENAP
	var $ConsultaLlave = "ConsultaIndiceDPICache"; //Método en el WS que consulta por la llave RENAP
	var $ConsultaDPI = "ConsultaDPI"; //Método en el WS que consulta por DPI
	//var $ConsultaDPI = "ConsultaDPICache"; //Método en el WS que consulta por DPI
	var $ConsultaOrdenCapturaDpi = "ConsultaOrdenCapturaNombre"; //Método en el WS que consulta ordenes de captura por DPI
	var $ConsultaLicenciaNombre = "ConsultaLicenciaNombre"; //Método en el WS que consulta por nombres la licencia
	var $ConsultaVehiculoPreliminar = "ConsultaVehiculoPreliminar"; //Método que consulta los antecedentes preliminares de vehiculos
	var $ConsultaVehiculoPlacaTransito = "ConsultaVehiculoPlacaTransito"; //Método que consulta los datos del vehículo
	var $ConsultaNovedades = "ConsultaNovedades"; //Método que consulta novedades relacionadas con la placa
	var $ConsultaPersonalPNC = "ConsultaPersonaPNC"; //Método para consultar a los agentes por NIP, DPI o Nombre
	var $ConsultaVehiculoPlaca = "ConsultaVehiculoPlaca"; //Método para consultar antecedentes de una placa.
	var $ConsultaEnvioSMS = "EnvioSMS"; //Método para envio de mensajes de texto.
	var $IngresoDenunciaMP = "IngresoDenunciaMP"; // Método para insertar en el MP los datos de la denuncia de SIPOL
	var $ConsultaPatrulla = "ConsultaPatrulla"; //Método para consultar las patrullas de PNC
	var $ObtenerNumeroCapturasDpi ='ObtenerNumeroCapturasDpi';//metodo para consultar Cantidad de Ordenes de Capturas
	

	

	public function getCliente()
	{
		try
		{
			$cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsMingob.php?wsdl", true);
			return $cliente;
		}
		catch (Exeption $e)
		{
			return "Error en el WS";
		}
		
	}

	public function logConsulta($metodo,$consulta)
	{
		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario_viene = $variable_datos_usuario[0]->id_usuario;

		$idServicio = Yii::app()->db->createCommand()
		->select('id_servicio')
		->from('sipol_catalogos.cat_servicios')
		->where('descripcion like :id', array(':id'=>$metodo))
		->queryRow();

		$dir = array(
		'url'=>Yii::app()->request->getUrl(),
		'controlador'=>Yii::app()->getController()->id,
		'accion'=>Yii::app()->getController()->getAction()->id		
		);

		$save = array(
			'id_servicio'=>$idServicio['id_servicio'],
			'origen'=>json_encode($dir),
			'id_usuario'=>$id_usuario_viene,
			'consulta'=>json_encode($consulta)
			);

		$TblLogConsulta = new TblLogConsulta;
		$TblLogConsulta->attributes=$save;
		$TblLogConsulta->save();
		return $save;
	}

	public function ConsultaNombre($pn='',$sn='',$pa='',$sa='')
	{

		$sale = json_decode($_SESSION['ID_ROL_SIPOL']);
		$usuario_sistema = $sale[0]->usuario;
		
			$data = "";
			$debug=false;
			$url_ws_bb = 'http://172.21.5.5/bumblebee_test/WS_Bumblebee.php';
			$fn	='';

			$cliente='SIPOLWEB';

			$data = "";
			$debug=false;
			$pn=strtolower($pn);
			$sn=strtolower($sn);
			$pa=strtolower($pa);
			$sa=strtolower($sa);
			$ws_cliente = new SoapClient(null, array("location"=>$url_ws_bb, "uri"=>$url_ws_bb));						
			$data = $ws_cliente->DatosServicioNombres_Renap($pn,$sn,$pa,$sa,$fn,$cliente,$usuario_sistema,$debug); // cliente es una constante en config.inc.php
			

		return $data;
	}

	public function ConsultaLlave($sede)
	{
			$sale = json_decode($_SESSION['ID_ROL_SIPOL']);
			$usuario = $sale[0]->usuario;
			$resultado = "";
			$dpi ='';			
			$no_cache=false;
			$debug=false;
			$url_ws_op = 'http://172.21.5.5/optimus2/WS_OptimusPrime.php';
			$cliente = 'SIPOLWEB';
			$ws_cliente = new SoapClient(null, array("location"=>$url_ws_op, "uri"=>$url_ws_op));						
			$resultado = $ws_cliente->DatosCiudadanoDPI_Renap($dpi,$cliente,$sede,$no_cache,$usuario,$debug); // cliente es una constante en config.inc.php
		return $resultado;
	}
		public function ConsultaDPI($dpi)
	{
			$sale = json_decode($_SESSION['ID_ROL_SIPOL']);
			$usuario = $sale[0]->usuario;
			$resultado = "";
			$sede ='';			
			$no_cache=false;
			$debug=false;
			$url_ws_op = 'http://172.21.5.5/optimus2/WS_OptimusPrime.php';
			$cliente = 'SIPOLWEB';
			$ws_cliente = new SoapClient(null, array("location"=>$url_ws_op, "uri"=>$url_ws_op));						
			$resultado = $ws_cliente->DatosCiudadanoDPI_Renap($dpi,$cliente,$sede,$no_cache,$usuario,$debug); // cliente es una constante en config.inc.php
		return $resultado;
	}

	public function ConsultaDpiCaptura($dpi)
	{
			
			$sede = '';
			$sale = json_decode($_SESSION['ID_ROL_SIPOL']);
			$usuario_sistema = $sale[0]->usuario;
		
			$data = "";			
			$no_cache=false;
			$debug=false;
			$url_ws_op = 'http://172.21.5.27/starscream/ws_starscream.php';
			$cliente = 'SIPOLWEB';
			$ws_cliente = new SoapClient(null, array("location"=>'http://172.21.5.27/starscream/ws_starscream.php', "uri"=>'http://172.21.5.27/starscream/ws_starscream.php'));
			$resultado = $ws_cliente->CapturasDpiDetalleRojos($dpi,'SIPOLWEB',$usuario_sistema);						
			
		return $resultado;
	}

	public function OrdenesCapturaDpi($dpi)
	{
		$consulta = array(
			'usuario' => $this->ws_user,
			'contrasena' => $this->ws_password,
			'cui' => $dpi,
			);

		//$this->logConsulta($this->ConsultaOrdenCapturaDpi,$consulta);

		$i = $this->getCliente();
		$resultado = $i->call($this->ConsultaOrdenCapturaDpi,$consulta);

		$r = json_decode($resultado);
		$r = (array) $r;
		$rr = $r['registros'];

		if(!empty($rr))
		{
			foreach ($rr as $key => $value) {}
			
			$rrr = (array) $value;
			
			$rrr = json_encode($rrr);

			return $rrr;
		}
	}


	public function ObtenerNumeroCapturasDpi($dpi)
	{
		$consulta = array(
			'usuario'=>$this->ws_user,
			'password'=>$this->ws_password,
			'dpi'=>$dpi,
			);
		$i = $this->getCliente();
		$resultado = $i->call($this->ObtenerNumeroCapturasDpi,$consulta);
		$r = json_decode($resultado);
		$r = (array) $r;
		if(isset($r['ordenes_vigentes'])){
			return $r['ordenes_vigentes'];
		}
		else{
			return false;
		}
	}

	public function ConsultaLicencia($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$numero)
	{
		$numero ='2081588981401';
		$consulta = array(
			'usuario' => $this->ws_user,
			'contrasena' => $this->ws_password,
			'primerNombre' => $primer_nombre,
			'segundoNombre' => $segundo_nombre,
			'primerApellido' => $primer_apellido,
			'segundoApellido' => $segundo_apellido,
			'tercerApellido'=>'',
			'orden_cedula'=>'',
			'registro_cedula'=>'',
			'cui'=>'',
			'licencia'=>$numero,
			'nit'=>''
			);

		$this->logConsulta($this->ConsultaLicenciaNombre,$consulta);

		$i = $this->getCliente();

		if($numero == "empty")
		{
			$numero = "";
		}
		else
		{
			$primer_nombre = "";
			$segundo_nombre = "";
			$primer_apellido = "";
			$segundo_apellido = "";
		}

		$resultado = $i->call($this->ConsultaLicenciaNombre,$consulta);

		return $resultado;
	}

	public function ConsultaVehiculoPreliminar($ptipo,$pnumero)
	{
		$pnumero = "0".$pnumero;
		$placa = $ptipo.$pnumero;
		$Funcionesp = new Funcionesp;

		$consulta = array(
			'usuario' => $this->ws_user,
			'contrasena' => $this->ws_password,				
			'placa' => $placa,										
			);

		//$this->logConsulta($this->ConsultaVehiculoPreliminar,$consulta);

		$i = $this->getCliente();
		$resultado = $i->call($this->ConsultaVehiculoPreliminar,$consulta);

		return $Funcionesp->ExplotaDosNiveles($resultado);
	}//fin de la funcion consultar vehiculo

	public function ConsultaVehiculoSAT($ptipo,$pnumero)
	{
		$pnumero = $pnumero;
		$ptipo = $ptipo;
	
			$usuario = 'hduarte';	
			$cliente = 'RVR';
			$url_rvr = 'http://172.21.5.5/ws_rvr/ws_rvr.php';
	


		$arreglo_cliente['placa'] =$pnumero;
		$arreglo_cliente['tipo'] =$ptipo;
		$arreglo_cliente['motor'] ='';
		$arreglo_cliente['chasis'] ='';
		$arreglo_cliente['usuario'] ='webpage';
		$arreglo_cliente['cliente'] ='RVR';

			$ws_cliente = new SoapClient(null, array("location"=>$url_rvr, "uri"=>$url_rvr));
			//$data=$ws_cliente->BuscaRoboVehiculo($tipo,$placa);
			$data=$ws_cliente->BuscaRoboVehiculo($arreglo_cliente);
			$resultado = $data;

		return $resultado;
	}//fin de la funcion consultar vehiculo

	public function ConsultaVehiculoNovedades($ptipo,$pnumero)
	{
		try {

		$placa_completa = $ptipo."-".$pnumero;

		$consulta = array(
			'usuario' => $this->ws_user,
			'password' => $this->ws_password,	
			'placa' => $placa_completa,
			);

		//$this->logConsulta($this->ConsultaNovedades,$consulta);

		$i = $this->getCliente();
		$ConsultaVehiculoNovedades = $i->call($this->ConsultaNovedades,$consulta);
		Yii::log('debug', CLogger::LEVEL_ERROR, $ConsultaVehiculoNovedades);
		return $ConsultaVehiculoNovedades;			
		} catch (Exception $e) {
			return "Error en la consulta";			 
		}		
	}//fin de la funcion consultar vehiculo

	public function ConsultaPersonalPNC($nip)
	{
		$url_servicio='http://172.21.68.22/sispe/ws_sispe.php';
		 try {
            $cliente = new SoapClient(null,array("location"=>$url_servicio,"uri"=>$url_servicio));
            $nip=intval($nip);
            $mensaje=$cliente->datos_personales($nip);

        }
        catch (SoapFault $sf) {
            $mensaje['error_codigo']=100;
            $mensaje['error_texto']="NIP invalido";
        }
        catch (Exception $e) {
            $mensaje['error_codigo']=200;
            $mensaje['error_texto']="Problema en el servicio";
        }
        $res=json_encode($mensaje);
        return $res;	
	}

	public function ConsultaVehiculoAntecedentes($ptipo,$pnumero)
	{
		$consulta = array(
			'usuario' => $this->ws_user,
			'contrasena' => $this->ws_password,	
			'tipo'=> $ptipo, 			
			'placa' => $pnumero									
			);

		//$this->logConsulta($this->ConsultaVehiculoPlaca,$consulta);

		$i = $this->getCliente();
		$Funcionesp = new Funcionesp;
		$ptipo = strtoupper($ptipo);
		$pnumero = strtoupper($pnumero);

		$resultado = $i->call($this->ConsultaVehiculoPlaca,$consulta);

		return $Funcionesp->ExplotaDosNiveles($resultado);
	}

	public function EnviarMensajeTexto($celular,$mensaje)
	{
		try
		{
			$consulta = array(
						"usuario" =>$this->ws_user,
						"contrasena" =>$this->ws_password,
						"celular" => $celular,
						"mensaje" => $mensaje
						);

			//$this->logConsulta($this->ConsultaEnvioSMS,$consulta);

			$i = $this->getCliente();
			$resultado = $i->call($this->ConsultaEnvioSMS,$consulta);
			
		return $resultado;
        }
        catch(Exception $e)
        {
             return $e;
        }
	}

	public function IngresoDenunciaMP($idEvento)
	{

			$reportes = New Reportes;
			$decrypt = New Encrypter;
			$encabezado = $reportes->Encabezado($idEvento);
			$denunciante = $reportes->getDenuncianteArray($idEvento);
			$ubicacion = $reportes->getUbicacionArray($idEvento);
			$rep = $reportes->getRelato($idEvento);
			$relato = $decrypt->decrypt($rep['Relato']);
			$cliente = new SoapClient("http://192.168.0.214/serviciosExternos/wsMingob.php?wsdl");
			//$objetos = $reportes->getObjetos($rep['Objetos']);
			//$objetos = json_encode($objetos);

			$dpi = "";
			$pasaporte = "-1";
			$identificacion = "";
			if(empty($ubicacion['Zona'])) $ubicacion['Zona'] = "-1";
			if(empty($denunciante['Profesion'])) $denunciante['Profesion'] = "-1";
			if($denunciante['Tipo_identificacion'] == "DPI") $dpi = $denunciante["Numero_identificacion"];
			if($denunciante['Tipo_identificacion'] == "Pasaporte"){
				$pasaporte = $denunciante["Tipo_identificacion"];
				$identificacion = $denunciante["Numero_identificacion"];
			} 

			$consulta =  array(
					"usuario" =>$this->ws_user,
					"contrasena" =>$this->ws_password,
					"noOficioSipol" =>$encabezado['evento_num'],
					"fechaOficioSipol" =>$encabezado['fecha_ingreso'],
					"comisariaSipol" =>$encabezado['nombre_entidad'],
					"aliasCaso" =>$encabezado['evento_num'],
					"narracionBreveHecho" =>$relato,
					"nombre" =>$denunciante['Primer_Nombre']." ".$denunciante['Segundo_Nombre'],
					"primerApellido" =>$denunciante['Primer_Apellido'],
					"segundoApellido" =>$denunciante['Segundo_Apellido'],
					"apellidoCasada"=>"",
					"denunciante" =>"1",
					"numeroCalle"=>"",
					"numeroAvenida"=>"",
					"apartado" =>"-1",
					"numeroCasa"=>"",
					"zona" =>$ubicacion['Zona'],
					"colonia"=>$ubicacion['Colonia'],
					"departamentoDomicilio" =>$ubicacion['Departamento'],
					"municipioDomicilio" =>'-1'/*$ubicacion['Municipio']*/,
					"direccion"=>$denunciante['Direccion_de_contacto'],
					"telefono"=>$denunciante['r_telefono_cnt'],
					"cedulaOrden" =>"-1",
					"cedulaRegistro"=>"",
					"cedulaMunicipioExte"=>"-1",
					"sexo" =>$denunciante['Genero'][0],
					"estadoCivil" =>$denunciante['Estado_Civil'][0],
					"cuiNumeroDpi"=>"",
					"cuiVerificadorDpi"=>"",
					"cuiDeptoDpi"=>$denunciante['Id_Depto'],
					"cuiMupioDpi"=>$denunciante['Id_Mupio'],
					"otroDocumentoIdentificacion" =>$pasaporte,
					"numIdentificacion"=>$identificacion,
					"nacionalidad" =>"-1",
					"etnia" =>"-1",
					"fechaNacimiento"=>$denunciante['Fecha_de_Nacimiento'],
					"edadAnos"=>$denunciante['Edad'],
					"religion" =>"-1",
					"escolaridad" =>"-1",
					"ocupacion" =>$denunciante['Profesion'],
					"lugarTrabajo"=>$denunciante['Lugar_de_Trabajo'],
					"telefonoTrabajo"=>"",
					"direccionTrabajo"=>"",
					"oficio" =>$denunciante['Profesion'],
					"cargo" =>"-1",
					"idioma" =>"-1",
					"interprete" =>"-1",
					"correo"=>$denunciante['Email_contacto'],
					"partidapn"=>"",
					"aniopn"=>"",
					"foliopn"=>"",
					"municipioPn" =>"-1"
					);
				/* CAMPOS CON PROBLEMAS AL INSERTAR
				"cuiNumeroDpi"=>$dpi,
				"cuiVerificadorDpi"=>$denunciante['Llave_Renap'],
				"nacionalidad" =>$denunciante['Nacionalidad'],*/

			$this->logConsulta($this->IngresoDenunciaMP,$consulta);

			try {
				$resultado = $cliente->__soapCall($this->IngresoDenunciaMP,$consulta);
				return $resultado;
			} catch (Exception $e) {
				return $cliente->__getLastResponse();
			}
			
	}

	public function ConsultaPatrulla($nombrePatrulla)
	{
		$i = $this->getCliente();
		$Funcionesp = new Funcionesp;

		$consulta = array(
			'usuario' => $this->ws_user,
			'contrasena' => $this->ws_password,	
			'nombre_vehiculo' =>$nombrePatrulla,
            'anio' => '',
            'modelo' => '',
            'marca' => '',
            'tipo' => ''								
			);

		$this->logConsulta($this->ConsultaPatrulla,$consulta);

		$resultado = $i->call($this->ConsultaPatrulla,$consulta);

		$n = json_decode($resultado);
		$n = (array) $n;

		if(!empty($n['registros']))
		{
			$a = $n['registros'];
			foreach ($a as $key => $value) {}
			$devolver = (array) $value;
			$devolver = json_encode($devolver);

			return $devolver;
		}		
	}

}

?>