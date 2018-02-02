<?php
 require_once('lib/soap/nusoap.php');
class EnvioCorreo
{
	
	public function SolicitudDenuncia($correo,$numerodpi)
	{
		try {

       /* $sql = "select  fecha_ingreso as fecha ,id_evento as evento, evento_num as numerodenuncia from sipol.tbl_evento where 
        id_evento in(select id_evento from sipol.tbl_evento_detalle where
         id_evento_detalle in (select id_evento_detalle from sipol.tbl_persona_detalle 
         where id_persona in(select id_persona from sipol.tbl_persona where correo = '".$correo."' and cui= '".$numerodpi."') 
         and id_tipo_evento = 1)) and estado = 't'";*/

$sql="select  fecha_ingreso as fecha ,id_evento as evento, evento_num as numerodenuncia 
from sipol.tbl_evento 
where 
	id_evento in
	(
	select id_evento from 
	sipol.tbl_evento_detalle 
	where  id_evento_detalle in 
	(
		select id_evento_detalle 
		from sipol.tbl_persona_detalle 
		where id_persona in
		(
			select id_persona 
			from sipol.tbl_persona 
			where correo = '".$correo."' and cui= '".$numerodpi."'
		) 
		
	)
) 
 and estado = 't' and  id_tipo_evento = 1";
        $resultado = Yii::app()->db->createCommand($sql)->queryAll();
        $variablearray = "";
        if(count($resultado)==0)
        {
            //echo "No tienen resultado con la consulta";
                    return '<div class="alert alert-error">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <h4>Informacionfff!</h4>
                      El correo no se encuentra en el sistema: <b>'.$correo.'</b>
                    </div>';
        }else
        {
        	$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
			<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
            $listadenuncia = $listadenuncia."<h3>PNC SIPOL - LISTADO DE DENUNCIAS</h3><hr>";
            //echo count($resultado);
                    //var_dump($resultado);
            $variableeventoencriptada = new Encrypter;
                foreach($resultado as $key => $value)
                    {
                        $valor = json_encode($value);
                        $nuevo = json_decode($valor);
                        $variablecorreurl = $variableeventoencriptada->compilarget("'".$nuevo->evento."'");
                        $listadenuncia = $listadenuncia."<b>Fecha: </b>".$nuevo->fecha."<b> - Número de Denuncia: </b>".$nuevo->numerodenuncia." - <a href='".$_SERVER['SERVER_NAME']."/sipol_denuncia/index.php?r=Reportespdf/denuncia&par=".$variablecorreurl."'  target='_blank'> Ver Denuncia</a><br><br>";
                    }
                    	$destinatario = $correo; 
                        $asunto = "Solicitud de Denuncias - SIPOL"; 
                        $footercorreo = "<br><br><h2>¡Gracias por usar SIPOL!</h2><br>No responder a este email.<hr> 
¿Has recibido este mensaje en tu carpeta de Spam? Añade notificaciones@mingob.gob.gt.com a tu lista de contactos. ";


                        $cuerpo = $listadenuncia.$footercorreo; 

           
        //realizo el consumo del servicio
        $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
        
        $err = $cliente->getError();
        if ($err) {        
                echo '{"error_connect":"' . $err . '"}';        
        }
        
        $resultado = $cliente->call(
                "EnvioEmail", 
                array(
                        'usuario' => 'U$rM1ng0b',
                        'contrasena' => 'S1st3m@s2014',
                        'destinatarios' => $destinatario,
                        'motivo' => $asunto,
                        'contenido' => $cuerpo
                )
        );        
    

						return '<div class="alert alert-info">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4>Informacion!</h4>
						  La informacion fue envia al correo: <b>'.$correo.'</b>
						</div>';
		}//fin del if para hacer el proceso de denuncia		

			
		} catch (Exception $e) {
			return "Error en la consulta";			
		}		
	}//fin de la funcion solicitar correo con DPI y Correo


	public function SolicitudPasswordgenerarpass($id_usuario)
	{
		try {

		$variableencript = new Encrypter;

		$key='mingob$2013SIPOL';

	

        $sql = "select usuario , password, email from sipol_usuario.tbl_usuario where id_usuario = '".$id_usuario."' and estado = 1 and proceso = 1";
        $resultado = Yii::app()->db->createCommand($sql)->queryAll();
        $variablearray = "";
        if(count($resultado)==0)
        {
            //echo "No tienen resultado con la consulta";
                    return '<div class="alert alert-error">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <h4>Informacion!</h4>
                      Éste usuario no se encuentra registrado en el sistema: <b>'.$id_usuario.'</b>
                    </div>';
        }else
        {
				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
				<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
				$listadenuncia = $listadenuncia."<h3>PNC SIPOL - SOLICITUD DE CONTRASEÑA</h3><hr>";
                foreach($resultado as $key => $value)
                    {
                        $valor = json_encode($value);
                        $nuevo = json_decode($valor);                       
                    }
                   		$destinatario = $nuevo->email;
                   		 $asunto = "Solicitud de usuario y Contraseña - SIPOL"; 
                   		 $passwordnuevo = $variableencript->decrypt($nuevo->password,$key);
                        $cuerpo ="<b>Usuario: </b>".$nuevo->usuario."<b><br>Contraseña: </b>".$passwordnuevo;

                        $cuerpoSend = $listadenuncia.$cuerpo;

                   		if($destinatario=="")
                   		{
                   			$resultadocorreo = "<b>No tiene correo Asignado con el Sistema</b>";

                   		}else{
                   			    $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
						        $err = $cliente->getError();
						        if ($err) {        
						                echo '{"error_connect":"' . $err . '"}';        
						        }        
						        $resultado = $cliente->call(
						                "EnvioEmail", 
						                array(
						                        'usuario' => 'U$rM1ng0b',
						                        'contrasena' => 'S1st3m@s2014',
						                        'destinatarios' => $destinatario,
						                        'motivo' => $asunto,
						                        'contenido' => $cuerpoSend
						                )
						            );  

						            $resultadocorreo = "La informacion fue envia al correo: <b>".$destinatario."</b>";  

                   		}
                      

        				return '<div class="alert alert-info">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4>Informacion!</h4>
						  <br>'.$cuerpo.'<br>'.$resultadocorreo.'					 
						</div>';
		}//fin del if para hacer el proceso de denuncia		

			
		} catch (Exception $e) {
			return '<div class="alert alert-error">
		                      <button type="button" class="close" data-dismiss="alert">&times;</button>
		                      <h4>Informacion!</h4>
		                      Error en la consulta
		                    </div>';			
		}		
	}//fin de la funcion solicitar correo con DPI y Correo



	public function SolicitudPassword($numerousuario,$numerodpi)
	{
		try {

		$variableencript = new Encrypter;

		$key='mingob$2013SIPOL';

	

        $sql = "select usuario , password, email from sipol_usuario.tbl_usuario where usuario = '".$numerousuario."' and dpi = '".$numerodpi."' and estado = 1 and proceso = 1";
        $resultado = Yii::app()->db->createCommand($sql)->queryAll();
        $variablearray = "";
        if(count($resultado)==0)
        {
            //echo "No tienen resultado con la consulta";
                    return '<div class="alert alert-error">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <h4>Informacion!</h4>
                      Éste usuario no se encuentra registrado en el sistema: <b>'.$numerousuario.'</b>
                    </div>';
        }else
        {
				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
				<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
				$listadenuncia = $listadenuncia."<h3>PNC SIPOL - SOLICITUD DE CONTRASEÑA</h3><hr>";
                foreach($resultado as $key => $value)
                    {
                        $valor = json_encode($value);
                        $nuevo = json_decode($valor);                       
                    }
                   		$destinatario = $nuevo->email;
                   		 $asunto = "Solicitud de usuario y Contraseña - SIPOL"; 
                   		 $passwordnuevo = $variableencript->decrypt($nuevo->password,$key);
                        $cuerpo ="<b>Usuario: </b>".$nuevo->usuario."<b><br>Contraseña: </b>".$passwordnuevo;

                        $cuerpoSend = $listadenuncia.$cuerpo;

                   		if($destinatario=="")
                   		{
                   			$resultadocorreo = "<b>No tiene correo Asignado con el Sistema</b>";

                   		}else{
                   			    $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
						        $err = $cliente->getError();
						        if ($err) {        
						                echo '{"error_connect":"' . $err . '"}';        
						        }        
						        $resultado = $cliente->call(
						                "EnvioEmail", 
						                array(
						                        'usuario' => 'U$rM1ng0b',
						                        'contrasena' => 'S1st3m@s2014',
						                        'destinatarios' => $destinatario,
						                        'motivo' => $asunto,
						                        'contenido' => $cuerpoSend
						                )
						            );  

						            $resultadocorreo = "La informacion fue envia al correo: <b>".$destinatario."</b>";  

                   		}
                      

        				return '<div class="alert alert-info">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4>Informacion!</h4>
						  <br>'.$cuerpo.'<br>'.$resultadocorreo.'					 
						</div>';
		}//fin del if para hacer el proceso de denuncia		

			
		} catch (Exception $e) {
			return '<div class="alert alert-error">
		                      <button type="button" class="close" data-dismiss="alert">&times;</button>
		                      <h4>Informacion!</h4>
		                      Error en la consulta
		                    </div>';			
		}		
	}//fin de la funcion solicitar correo con DPI y Correo

	public function SolicitudPasswordCorreo($email,$nip)
	{
		try {

			$variableencript = new Encrypter;

			$key='mingob$2013SIPOL';

			$usuario = new TblUsuario;
			
			$usuarios = $usuario->findAllByAttributes(array('email'=>$email, 'estado'=>1, 'usuario'=>$nip));
			
			if(count($usuarios) > 0)
			{
				//ahora obtengo el primer usuario
				$usuario_destino = $usuarios[0];
				//obtengo el password
				$password = $variableencript->decrypt($usuario_destino -> password);
				
				$asunto = "Solicitud de usuario y Contraseña - SIPOL"; 
				
				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
					<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
					$listadenuncia = $listadenuncia."<h3>PNC SIPOL - SOLICITUD DE CONTRASEÑA</h3><hr>";
				$cuerpo ="<b>Usuario: </b>".$usuario_destino->usuario."<b><br>Contraseña: </b>".$password;
				
				$cuerpoSend = $listadenuncia.$cuerpo;
				
				$cliente = new SoapClient("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl");
		
				$resultado = $cliente->__soapCall(
						"EnvioEmail", 
						array(
								'usuario' => 'U$rM1ng0b',
								'contrasena' => 'S1st3m@s2014',
								'destinatarios' => $email,
								'motivo' => $asunto,
								'contenido' => $cuerpoSend
						)
					);  

					$resultadocorreo = "La informacion fue envia al correo: <b>".$email."</b>";  
					
				return '<div class="alert alert-info">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <h4>Informacion!</h4>
							  <br>'.$resultadocorreo.'					 
							</div>';
			}
			else
			{
				return '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <h4>Informacion!</h4>
					  Éste Correo electrónico no se encuentra registrado en el sistema
					</div>';
		}
			
		} catch (Exception $e) {
			return '<div class="alert alert-error">
		                      <button type="button" class="close" data-dismiss="alert">&times;</button>
		                      <h4>Informacion!</h4>
		                      Error en la consulta
		                    </div>';			
		}		
	}//fin de la funcion solicitar correo con DPI y Correo



	public function SolicitudPasswordCorreoRestablecer($email,$nip)
	{
		try {

			$variableencript = new Encrypter;

			$key='mingob$2013SIPOL';

			$usuario = new TblUsuario;
			
			$usuarios = $usuario->findAllByAttributes(array('email'=>$email, 'estado'=>1, 'usuario'=>$nip));
			
			if(count($usuarios) > 0)
			{
				//ahora obtengo el primer usuario
				$usuario_destino = $usuarios[0];
				//obtengo el password
				$password = $variableencript->decrypt($usuario_destino -> password);
				
				$asunto = "Solicitud de usuario y Contraseña - SIPOL"; 
				
				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
					<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
					$listadenuncia = $listadenuncia."<h3>PNC SIPOL - SOLICITUD DE CONTRASEÑA</h3><hr>";
				$cuerpo ="<b>Usuario: </b>".$usuario_destino->usuario."<b><br>Contraseña: </b>".$password;
				
				$cuerpoSend = $listadenuncia.$cuerpo;
				
					    $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
						        $err = $cliente->getError();
						        if ($err) {        
						                echo '{"error_connect":"' . $err . '"}';        
						        }        
						        $resultado = $cliente->call(
						                "EnvioEmail", 
						                array(
						                        	'usuario' => 'U$rM1ng0b',
								'contrasena' => 'S1st3m@s2014',
								'destinatarios' => $email,
								'motivo' => $asunto,
								'contenido' => $cuerpoSend
						                )
						            );  

					$resultadocorreo = $email;  
					
				return $resultadocorreo;
			}
			else
			{
				return '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <h4>Informacion!</h4>
					  Éste Correo electrónico no se encuentra registrado en el sistema
					</div>';
		}
			
		} catch (Exception $e) {
			return '<div class="alert alert-error">
		                      <button type="button" class="close" data-dismiss="alert">&times;</button>
		                      <h4>Informacion!</h4>
		                      Error en la consulta
		                    </div>';			
		}		
	}//fin de la funcion solicitar correo con DPI y Correo



	
	public function EnviarIdEvento($id_evento)
	{
		try {
			 //	$variableencript = new Encrypter;
				$sql = "select a.fecha_ingreso as fecha, d.correo as correo, a.evento_num as numerodenuncia 
from sipol.tbl_evento as a, sipol.tbl_evento_detalle as b, 
		            sipol.tbl_persona_detalle as c, sipol.tbl_persona as d
		            where a.id_evento = b.id_evento
		            and c.id_evento_detalle = b.id_evento_detalle
		            and c.id_persona = d.id_persona
		            and a.id_evento = ".$id_evento."
		            and a.estado = 't'
		            and a.id_tipo_evento  = 1
		            group by d.correo, a.fecha_ingreso,a.evento_num;";
				$resultado = Yii::app()->db->createCommand($sql)->queryAll();
				$variablearray = "";
				if(count($resultado)==0)
				{
					//echo "No tienen resultado con la consulta";
				}else
				{
		      $correo= "";
		      $fecha_ingrso="";
		      $numerodenuncia="";
						foreach($resultado as $key => $value)
							{
								$valor = json_encode($value);
								$nuevo = json_decode($valor); 
					            $correo= $nuevo->correo;
					            $fecha_ingrso= $nuevo->fecha;
					            $numerodenuncia	= $nuevo->numerodenuncia;
							}

		           
		          $this->DenunciaCorreo($id_evento,$fecha_ingrso,$correo,$numerodenuncia);
		          return '<div class="alert alert-info">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4>Informacion!</h4>
						  La informacion fue envia al correo: <b>'.$correo.'</b>
						</div>';
				}//fin del if para hacer el proceso de denuncia		
		} catch (Exception $e) {
			return "Error en la consulta";			
		}		
	}//fin de la funcion solicitar correo confirmacion sobre denuncia
	public function EnviarIdEventoExtravio($id_evento)
	{
		try {
			 //	$variableencript = new Encrypter;
				$sql = "select a.fecha_ingreso as fecha, d.correo as correo, a.evento_num as numerodenuncia from sipol.tbl_evento as a, sipol.tbl_evento_detalle as b, 
		            sipol.tbl_persona_detalle as c, sipol.tbl_persona as d
		            where a.id_evento = b.id_evento
		            and c.id_evento_detalle = b.id_evento_detalle
		            and c.id_persona = d.id_persona
		            and a.id_evento = ".$id_evento."
		            and a.estado = 't'
		            and a.id_tipo_evento  = 3
		              group by d.correo, a.fecha_ingreso,a.evento_num;";
				$resultado = Yii::app()->db->createCommand($sql)->queryAll();
				$variablearray = "";
				if(count($resultado)==0)
				{
					//echo "No tienen resultado con la consulta";
				}else
				{
		      $correo= "";
		      $fecha_ingrso="";
		      $numerodenuncia="";
						foreach($resultado as $key => $value)
							{
								$valor = json_encode($value);
								$nuevo = json_decode($valor); 
					            $correo= $nuevo->correo;
					            $fecha_ingrso= $nuevo->fecha;
					            $numerodenuncia	= $nuevo->numerodenuncia;
							}
		           
		          $this->ExtravioCorreo($id_evento,$fecha_ingrso,$correo,$numerodenuncia);
		          return '<div class="alert alert-info">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4>Informacion!</h4>
						  La informacion fue envia al correo: <b>'.$correo.'</b>
						</div>';
				}//fin del if para hacer el proceso de denuncia		
		} catch (Exception $e) {
			return "Error en la consulta";			
		}		
	}//fin de la funcion solicitar correo confirmacion sobre denuncia

public function tablaestadistica($correo,$cuerpotabala)
	{
		try {

				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
			<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
            $listadenuncia = $listadenuncia."<h3>PNC SIPOL - Tabla Analisis</h3><hr>";
       
                    	$destinatario = $correo; 
                        $asunto = "Tabla Analisis Sipol - SIPOL"; 
                        $footercorreo = "<br><br><h2>¡Gracias por usar SIPOL!</h2><br>No responder a este email.<hr> 
¿Has recibido este mensaje en tu carpeta de Spam? Añade notificaciones@mingob.gob.com.gt a tu lista de contactos. ";
								//$destinatario = $correo; 
								$asunto = "Tabla Comisaria - SIPOL"; 
								$cuerpo = $listadenuncia.$cuerpotabala.$footercorreo; 
        //realizo el consumo del servicio
        $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
        
        $err = $cliente->getError();
        if ($err) {        
                echo '{"error_connect":"' . $err . '"}';        
        }
        
        $resultado = $cliente->call(
                "EnvioEmail", 
                array(
                        'usuario' => 'U$rM1ng0b',
                        'contrasena' => 'S1st3m@s2014',
                        'destinatarios' => $destinatario,
                        'motivo' => $asunto,
                        'contenido' => $cuerpo
                )
        );   

		} catch (Exception $e) {
			return "Error en la consulta";			
		}		
	}//fin de la funcion solicitar correo confirmacion sobre denuncia

	public function DenunciaCorreo($id_evento,$fecha,$correo,$numerodenuncia)
	{
		try {

				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
			<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
            $listadenuncia = $listadenuncia."<h3>PNC SIPOL - DENUNCIA CONFIRMADA</h3><hr>";
            $variableeventoencriptada = new Encrypter;
                        $variablecorreurl = $variableeventoencriptada->compilarget("'".$id_evento."'");
                        $listadenuncia = $listadenuncia."<b>Fecha: </b>".$fecha."<b> - Número de Denuncia: </b>".$numerodenuncia." - <a href='".$_SERVER['SERVER_NAME']."/sipol/index.php?r=Reportespdf/denuncia&par=".$variablecorreurl."'  target='_blank'> Ver Denuncia</a><br><br>";
                    
                    	$destinatario = $correo; 
                        $asunto = "Solicitud de Denuncias - SIPOL"; 
                        $footercorreo = "<br><br><h2>¡Gracias por usar SIPOL!</h2><br>No responder a este email.<hr> 
¿Has recibido este mensaje en tu carpeta de Spam? Añade notificaciones@mingob.gob.com.gt a tu lista de contactos. ";
								$destinatario = $correo; 
								$asunto = "Denuncia Confirmada - SIPOL"; 
								$cuerpo = $listadenuncia.$footercorreo; 
        //realizo el consumo del servicio
        $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
        
        $err = $cliente->getError();
        if ($err) {        
                echo '{"error_connect":"' . $err . '"}';        
        }
        
        $resultado = $cliente->call(
                "EnvioEmail", 
                array(
                        'usuario' => 'U$rM1ng0b',
                        'contrasena' => 'S1st3m@s2014',
                        'destinatarios' => $destinatario,
                        'motivo' => $asunto,
                        'contenido' => $cuerpo
                )
        );   

		} catch (Exception $e) {
			return "Error en la consulta";			
		}		
	}//fin de la funcion solicitar correo confirmacion sobre denuncia

	public function ExtravioCorreo($id_evento,$fecha,$correo,$numerodenuncia)
	{
		try {

				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
			<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
            $listadenuncia = $listadenuncia."<h3>PNC SIPOL - EXTRAVIO CONFIRMADO</h3><hr>";
            $variableeventoencriptada = new Encrypter;
                        $variablecorreurl = $variableeventoencriptada->compilarget("'".$id_evento."'");
                        $listadenuncia = $listadenuncia."<b>Fecha: </b>".$fecha."<b> - Número de Extravio: </b>".$numerodenuncia." - <a href='http://sipol.mingob.gob.gt/sipol/index.php?r=Reportespdf/extravio&par=".$variablecorreurl."'  target='_blank'> Ver Constancia</a><br><br>";
                        $destinatario = $correo; 
                        $asunto = "Solicitud de Denuncias - SIPOL"; 
                        $footercorreo = "<br><br><h2>¡Gracias por usar SIPOL!</h2><br>No responder a este email.<hr> 
¿Has recibido este mensaje en tu carpeta de Spam? Añade notificaciones@mingob.gob.com.gt a tu lista de contactos. ";
								$destinatario = $correo; 
								$asunto = "Denuncia Confirmada - SIPOL"; 
								$cuerpo = $listadenuncia.$footercorreo; 
        //realizo el consumo del servicio
        $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
        
        $err = $cliente->getError();
        if ($err) {        
                echo '{"error_connect":"' . $err . '"}';        
        }
        
        $resultado = $cliente->call(
                "EnvioEmail", 
                array(
                        'usuario' => 'U$rM1ng0b',
                        'contrasena' => 'S1st3m@s2014',
                        'destinatarios' => $destinatario,
                        'motivo' => $asunto,
                        'contenido' => $cuerpo
                )
        );   

		} catch (Exception $e) {
			return "Error en la consulta";			
		}		
	}

	public function ticketchat($mensaje)
	{
		try {

				$listadenuncia = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
			<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
            $listadenuncia = $listadenuncia."<h3>PNC SIPOL - Soporte Tecnico</h3><hr>".$mensaje;

               $destinatario = "mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com;lgudiel@mingob.gob.gt"; 
                       
                        $footercorreo = "<br><br><h2>¡Gracias por usar SIPOL!</h2><br>No responder a este email.<hr> 
¿Has recibido este mensaje en tu carpeta de Spam? Añade notificaciones@mingob.gob.com.gt a tu lista de contactos. ";
								//$destinatario = $correo; 
								 $asunto = "Soporte Tecnico SIPOL-"; 
								$cuerpo = $listadenuncia.$footercorreo; 
        //realizo el consumo del servicio
        $cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
        
        $err = $cliente->getError();
        if ($err) {        
                echo '{"error_connect":"' . $err . '"}';        
        }
        
        $resultado = $cliente->call(
                "EnvioEmail", 
                array(
                        'usuario' => 'U$rM1ng0b',
                        'contrasena' => 'S1st3m@s2014',
                        'destinatarios' => $destinatario,
                        'motivo' => $asunto,
                        'contenido' => $cuerpo
                )
        );   

		} catch (Exception $e) {
			return "Error en la consulta";			
		}		
	}


	public function terminachatcabeza($id_ticket, $idusuario)
	{
		$trasladoconversacion = '';
		$valor =$id_ticket; 
		$usuariologin = $idusuario; 

		$sql = "select 
ti.id_ticket as numeroticket,
us.primer_nombre||' '||us.segundo_nombre||' '||us.primer_apellido||' '||us.segundo_apellido as usuariosolicita,
e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as nombre_entidad,
us.puesto as puesto,
us.email as correo, 
ti.fecha_ingreso as fechaticket, 
ti.hora_ingreso as horaticket,  
pi.nombre_prioridad as prioridad, 
ti.inconveniente as titulo ,
ti.telefono as telefono
from 
soporte_aplicaciones.tbl_ticket ti,
soporte_aplicaciones.cat_prioridad pi,
sipol_usuario.tbl_usuario us,
sipol_usuario.tbl_rol_usuario rolus,
sipol_usuario.cat_rol rol,
catalogos_publicos.tbl_sede s,
catalogos_publicos.cat_entidad e,
catalogos_publicos.cat_tipo_sede ts
where ti.id_prioridad = pi.id_prioridad
and us.id_usuario = ti.id_usuario
and rolus.id_usuario = us.id_usuario
and rolus.id_rol = rol.id_rol
and s.id_sede = rolus.id_sede
and ts.id_tipo_sede = s.id_tipo_sede
and e.id_cat_entidad = s.id_cat_entidad
and ti.id_ticket = ".$valor."  
order by ti.id_ticket desc";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		$variablearray = "";
		$chatusuariocolor ="";
		foreach($resultado as $key => $value)
			{
				$cabezaticket = json_encode($value);
				$cabezaticket = json_decode($cabezaticket);
							
			}
$numeroticket = $cabezaticket->numeroticket;
$usuariosolicita = $cabezaticket->usuariosolicita;
$nombre_entidad = $cabezaticket->nombre_entidad;
$puesto  = $cabezaticket->puesto;
$correo = $cabezaticket->correo;
$fechaticket = $cabezaticket->fechaticket;
$horaticket = $cabezaticket->horaticket;
$horaticket = explode(".", $cabezaticket->horaticket);	
$prioridad = $cabezaticket->prioridad;
$titulo = $cabezaticket->titulo;
$telefono= $cabezaticket->telefono;

$salida ="Ticket con numero:#<b>".$numeroticket."</b> solicitado por el usuario:<b>".$usuariosolicita."</b> Asignado en <b>".$nombre_entidad."</b>
 con el cargo de <b> ". $puesto."</b>, inscrito con el correo:<b>".$correo."</b>. Genero una solicitud de soporte en la fecha: <b>".$fechaticket."</b>
 en la hora: <b>".$horaticket[0]."</b>,  para la aplicacion denominada <b>SIPOL</b>,  con prioridad <b>".$prioridad."</b>.<br>
 <b>Mensaje de soporte:</b> ".$titulo.".<b>Telefono  del usuario </b>".$telefono."";

$soportecabeza = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
$soportecabeza = $soportecabeza."<h3>PNC SIPOL - Soporte Tecnico</h3><hr>".$salida;
$destinatario = "mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com"; 

$cuerpocabeza = $soportecabeza; 

	$cuerpodelchat = "";
		$valor =$id_ticket; 
		$usuariologin = $idusuario; 
		$sqllistadochat = "SELECT  a.*, b.primer_nombre || ' ' ||  b.primer_apellido as usuario
		FROM 
		soporte_aplicaciones.tbl_detalle_ticket as a, sipol_usuario.tbl_usuario as b
		WHERE 
		a.id_ticket = ".$valor." 
		and
		b.id_usuario = a.id_usuario
		order by a.id_detalle_ticket asc";
		$resultado = Yii::app()->db->createCommand($sqllistadochat)->queryAll();
		$variablearray = "";
		$chatusuariocolor ="";
		foreach($resultado as $key => $value)
			{
				$conversacion = json_encode($value);
				$conversacion = json_decode($conversacion);
				$hora_atencion = explode(".", $conversacion->hora_atencion);
				if($conversacion->id_usuario==$usuariologin){
					$chatusuariocolor ="<strong class='usuarioroot'>".$conversacion->usuario.": </strong>";

				}else{
					$chatusuariocolor ="<strong class='usuario'>".$conversacion->usuario.": </strong>";
				}	
	$cuerpodelchat = $cuerpodelchat.'<blockquote>
		   <small><cite title="Source Title">'.$chatusuariocolor.'</cite></small>
		  <small><cite title="Source Title"><strong class="hora">'.$hora_atencion[0].'</strong> '.$conversacion->seguimiento.'</cite></small>
		</blockquote>';
			}
			//echo $trasladoconversacion;

$footercorreo = "<br><br><h2>¡Gracias por usar SIPOL!</h2><br>No responder a este email.<hr> 
¿Has recibido este mensaje en tu carpeta de Spam? Añade notificaciones@mingob.gob.com.gt a tu lista de contactos. ";
$asunto = "Soporte Tecnico SIPOL-"; 

$cuerpocorreo = "<div style='background-color:#f5f5f5;'>".$cuerpocabeza."<br><h4>conversación de Soporte:</h4>".$cuerpodelchat.$footercorreo."</div>";








$cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);

$err = $cliente->getError();
if ($err) {        
echo '{"error_connect":"' . $err . '"}';        
}

$resultado = $cliente->call(
"EnvioEmail", 
array(
'usuario' => 'U$rM1ng0b',
'contrasena' => 'S1st3m@s2014',
'destinatarios' => $destinatario,
'motivo' => $asunto,
'contenido' => $cuerpocorreo
)
);  



		return $trasladoconversacion;
	}

	public function terminachatfooter($id_ticket, $idusuario)
	{

	}

	public function terminachatcuerpo($id_ticket, $idusuario)
	{

		$trasladoconversacion = '<style type="text/css">
	.usuario{
		color:black;
	}
	.usuarioroot{
		color:blue;
	}
	.hora{
		color:black;
	}
	.mensaje{
		color:black;
	}
	.chaticono{
		height: auto;
		max-width: 100%;
	}
	.inputvalor{
		display: none;
	}
</style>';
		$valor =$id_ticket; 
		$usuariologin = $idusuario; 
		$sql = "SELECT  a.*, b.primer_nombre || ' ' ||  b.primer_apellido as usuario
		FROM 
		soporte_aplicaciones.tbl_detalle_ticket as a, sipol_usuario.tbl_usuario as b
		WHERE 
		a.id_ticket = ".$valor." 
		and
		b.id_usuario = a.id_usuario
		order by a.id_detalle_ticket asc";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		$variablearray = "";
		$chatusuariocolor ="";
		foreach($resultado as $key => $value)
			{
				$conversacion = json_encode($value);
				$conversacion = json_decode($conversacion);
				$hora_atencion = explode(".", $conversacion->hora_atencion);
				if($conversacion->id_usuario==$usuariologin){
					$chatusuariocolor ="<strong class='usuarioroot'>".$conversacion->usuario.": </strong>";

				}else{
					$chatusuariocolor ="<strong class='usuario'>".$conversacion->usuario.": </strong>";
				}	
	$trasladoconversacion = $trasladoconversacion.'<blockquote>
		   <small><cite title="Source Title">'.$chatusuariocolor.'</cite></small>
		  <small><cite title="Source Title"><strong class="hora">'.$hora_atencion[0].'</strong> '.$conversacion->seguimiento.'</cite></small>
		</blockquote>';
			}
			// $trasladoconversacion;

			 		/*$correoticket = new EnvioCorreo;
			$correoticket->ticketchat($trasladoconversacion);*/
			
			return $trasladoconversacion;
	}
	public function correoSoporteTecnico($destinatario, $asunto, $cuerpocorreo)
	{
		$cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
		$err = $cliente->getError();
		if ($err) {
        		echo '{"error_connect":"' . $err . '"}';
        	}
       		 $resultado = $cliente->call(
                        "EnvioEmail",
                                array(
                                'usuario' => 'U$rM1ng0b',
                                'contrasena' => 'S1st3m@s2014',
                                'destinatarios' => $destinatario,
                                'motivo' => $asunto,
                                'contenido' => $cuerpocorreo
                                )
        	);
	}

	public function enviarsugerencia($sugerencia,$id_usuario)
{
		$trasladoconversacion = '';
		$valor =$sugerencia; 
		$usuariologin = $id_usuario; 
		$sql = "select 
us.primer_nombre||' '||us.segundo_nombre||' '||us.primer_apellido||' '||us.segundo_apellido as usuariosolicita,
e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as nombre_entidad,
us.puesto as puesto,
us.email as correo
from 
sipol_usuario.tbl_usuario us,
sipol_usuario.tbl_rol_usuario rolus,
sipol_usuario.cat_rol rol,
catalogos_publicos.tbl_sede s,
catalogos_publicos.cat_entidad e,
catalogos_publicos.cat_tipo_sede ts
where rolus.id_usuario = us.id_usuario
and rolus.id_rol = rol.id_rol
and s.id_sede = rolus.id_sede
and ts.id_tipo_sede = s.id_tipo_sede
and e.id_cat_entidad = s.id_cat_entidad
and us.id_usuario = ".$usuariologin."
order by us.id_usuario desc;";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		$variablearray = "";
		$chatusuariocolor ="";
		foreach($resultado as $key => $value)
			{
				$cabezaticket = json_encode($value);
				$cabezaticket = json_decode($cabezaticket);							
			}
$usuariosolicita = $cabezaticket->usuariosolicita;
$nombre_entidad = $cabezaticket->nombre_entidad;
$puesto  = $cabezaticket->puesto;
$correo = $cabezaticket->correo;
$salida ="<b>Sugerencia/Reporte</b> solicitado por el usuario:<b>".$usuariosolicita."</b> Asignado en <b>".$nombre_entidad."</b>
 con el cargo de <b> ". $puesto."</b>, inscrito con el correo:<b>".$correo."</b>. Genero una Sugerencia/Reporte:";
$soportecabeza = '<div style="background:url(http://sipol.mingob.gob.gt/sipol/images/header_little.png) top repeat-x;">
<img src="http://sipol.mingob.gob.gt/sipol/images/logo_mingob.png" alt=""></div>';
$soportecabeza = $soportecabeza."<h3>PNC SIPOL - Idea,Sugerencia,Reporte</h3><hr>".$salida;
$destinatario = "mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com"; 
$cuerpocabeza = $soportecabeza; 
$footercorreo = "<br><br><h2>¡Gracias por usar SIPOL!</h2><br>No responder a este email.<hr> 
¿Has recibido este mensaje en tu carpeta de Spam? Añade notificaciones@mingob.gob.com.gt a tu lista de contactos. ";
$asunto = "Sugerencias/Reporte Sistema SIPOL-".$usuariosolicita; 
$cuerpocorreo = "<div style='background-color:#f5f5f5;'>".$cuerpocabeza."<br><h4>Texto:</h4>".$sugerencia.$footercorreo."</div>";
$cliente = new nusoap_client("http://192.168.0.214/serviciosExternos/wsEnvioEmail.php?wsdl", true);
$err = $cliente->getError();
if ($err) {        
	echo '{"error_connect":"' . $err . '"}';        
	}
	$resultado = $cliente->call(
			"EnvioEmail", 
				array(
				'usuario' => 'U$rM1ng0b',
				'contrasena' => 'S1st3m@s2014',
				'destinatarios' => $destinatario,
				'motivo' => $asunto,
				'contenido' => $cuerpocorreo
				)
	);  
	return $trasladoconversacion;
}


}
?>
