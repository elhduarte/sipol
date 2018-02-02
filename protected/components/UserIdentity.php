<?php
 class Encrypter 
{ 
    public static $Key = "mingob$2013SIPOL";
 
    public static function encrypt ($input) 
    {
        $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))));
        return $output;
    }   
}
 class UserIdentity extends CUserIdentity
{
	const ERROR_USER_BANNED = 12 ; #or whateve int value you prefer
	public function getErrorMessageX() #or whatever method name
	{
	    switch ($this->errorCode)
	    {
	        case self::ERROR_USER_BANNED:
	            return 'Su cuenta esta Temporalmente Bloqueada'; # custom error msg

	        case self::ERROR_USERNAME_INVALID:
	            return 'El Usuario no se Encuentra';

	        case self::ERROR_PASSWORD_INVALID:
	            return 'La contraseña Se encuentra Incorrecta';
	    }
	}
	private $_id;
	public function authenticate()
	{	
		//Instanciamos la funcion de de usuarios creadas
		$funcion_conexion_usuario = new LoginForm();
		//Creamos la funcion para validar el modelo con el usuario Adquirimos el nombre de primero
		$user = TblUsuario::model()->findByAttributes(array('usuario'=>$this->username));	
		//validamos si el usuario esta ingresado en la base de datos
	if(isset($user->id_usuario))
	{
		
		//validamos si el usuario se encuentra activo
		$resultado = $funcion_conexion_usuario->validar_estado_usuario($user->id_usuario);
		//si el resultado del query trae mas de 1 quiere decir que el usuario se encuentra activo para iniciar session
		if(count($resultado)=="1")
		{
				//Igualamos la variable del usuario para ser usuado mas adelante
				$idUsuario =$user->id_usuario;
				//traemos el usuario
				$Usuario = $user->usuario;
				//igualamos la variables
     			$this->_id = $user->id_usuario;
     			//cramos la variable de ssesion con el id del usuario para ser utilizado mas adelante sin espacion
				Yii::app()->session['ID_USUARIO'] = trim($this->_id);
				//insertamos el id del usuario en una variable local
				$idUsuario= Yii::app()->session['ID_USUARIO'];	
				//traemos el data de la conezion con respecto al query de validadcion 
				$dataReader = $funcion_conexion_usuario->inicio_conexion_query($idUsuario);
				//creamos un contador para el array  de session
			 	$contador = 0;
			 //recoremos el data reade para extraer los datos de la conexion
			 foreach($dataReader as $row)
			 	{
				$id_usuario = $row['id_usuario'];
				$id_rol = $row['id_rol'];
				$nombre_rol = $row['nombre_rol'];
				$permisos = $row['permisos'];
				$estado = $row['estado'];
				$email = $row['email'];
				$nombre_completo = $row['nombre_completo'];
				$fotografia=$row['fotografia'];
				$usuario = $row['usuario'];
				$id_cat_entidad = $row['id_cat_entidad'];
				$nombre_entidad = $row['nombre_entidad'];
				$id_tipo_sede = $row['id_tipo_sede'];
				$tipo_sede  = $row['tipo_sede'];
				$id_sede  = $row['id_sede'];
				$nombre_sede  = $row['nombre_sede'];
				$referencia_sede  = $row['referencia_sede'];
				$cod_depto  = $row['cod_depto'];
				$cod_mupio  = $row['cod_mupio'];
				$ubicacion  = $row['ubicacion'];
				$nombre_sede_completa  = $row['nombre_sede_completa'];		
				$array_conexion_data[$contador] = array("id_usuario" => $id_usuario, 
														"id_rol"=>$id_rol,
														"nombre_rol" => $nombre_rol, 
														"permisos" => $permisos, 
														"estado" => $estado,
														"email" => $email, 
														"nombre_completo" => $nombre_completo, 
														"fotografia" => $fotografia,
														"usuario" => $usuario,
														"id_cat_entidad" => $id_cat_entidad,
														"nombre_entidad"=>$nombre_entidad,
														"id_tipo_sede"=>$id_tipo_sede,
														"tipo_sede"=>$tipo_sede,
														"id_sede"=>$id_sede,
														"nombre_sede"=>$nombre_sede,
														"referencia_sede"=>$referencia_sede,
														"cod_depto"=>$cod_depto,
														"cod_mupio"=>$cod_mupio,
														"ubicacion"=>$ubicacion,
														"nombre_sede_completa"=>$nombre_sede_completa,
				);
				//incrementamos el contador
				$contador = $contador + 1;
	  		}//fin del for
	 	$json =  json_encode($array_conexion_data);
	 	//variable que agrega el numero de mensaje asignado
	 	$notificacion = $funcion_conexion_usuario->validar_mensaje_sistema($user->id_usuario);
	 	$notificacion_pass = $funcion_conexion_usuario->validar_mensaje_sistema_pass($user->id_usuario); 
			$user = TblUsuario::model()->findByAttributes(array('usuario'=>$this->username));
			if(isset($user->id_usuario))
			{
				$idUsuario = $user->id_usuario;
				$Usuario = $user->usuario;
		    }
			else
			{
				$idUsuario = "";
			}			
				if ($user == null) 
				{ 
					$this->errorCode=self::ERROR_USERNAME_INVALID;
				} 
					else if (trim($user->password) !== Encrypter::encrypt($this->password))					
				{ 
					$this->errorCode=self::ERROR_PASSWORD_INVALID;
				} 
				else 
				{ 
					    $this->errorCode=self::ERROR_NONE;
						$this->_id = $user->id_usuario;
						$this->username = $user->usuario;
						Yii::app()->session['ID_ROL_SIPOL'] = trim($json);
						Yii::app()->session['ID_USUARIO'] = trim($this->_id);
						Yii::app()->session['USUARIO'] = trim($Usuario);
					    Yii::app()->session['PASSWORD'] = trim($this->password);
					    Yii::app()->session['notificacion'] =  $notificacion;
					     Yii::app()->session['notificacion_pass'] =  $notificacion_pass;
					    $idUsuario = $user->id_usuario;
					    //capturamos la ip
						$ip = $_SERVER['REMOTE_ADDR'];
						//capturamos el origen de ingreso
						$origen = $_SERVER['HTTP_USER_AGENT'];
						//Instanciamos la funcion de de usuarios creadas
						//$funcion_conexion_usuario = new LoginForm;
						//ingresa la ruta de la session del usuario
						$conteo_ingres = $funcion_conexion_usuario->ingreso_session($idUsuario,$ip,$origen,$id_sede);				   
				}
					return !$this->errorCode;
			}//fin del count para usuario
			else
			{			
				$this->errorCode=self::ERROR_USER_BANNED;
			}
		}
		else
		{
			$idUsuario = "";
			$idUsuario = "";
		}	
	}
}
?>
	