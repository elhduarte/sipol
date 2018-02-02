<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	public $verifyCode;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
        {
                return array(
                        // username and password are required
                        array('username, password', 'required'),
                        // rememberMe needs to be a boolean
                        // password needs to be authenticated
                        array('password', 'authenticate'),
                        // add these lines below                    
array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on'=>'captchaRequired'),
                );
        }

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Recordarme la próxima vez',
			'verifyCode'=>'Verificación de codigo',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password',$this->_identity->errorMessageX);
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	public function inicio_conexion_query($idUsuario)
 	{
 		$connection=Yii::app()->db;
				$sql="SELECT u.id_usuario,
				r.id_rol,
				r.nombre_rol,
				r.permisos,
				u.estado,
				u.email,
				u.primer_nombre||' '||u.segundo_nombre||' '||u.primer_apellido||' '||u.segundo_apellido as nombre_completo,
				u.foto as fotografia,
				u.usuario,
				e.id_cat_entidad,
				e.nombre_entidad,
				s.id_tipo_sede,
				ts.descripcion as tipo_sede,
				s.id_sede,
				s.nombre as nombre_sede,
				s.referencia as referencia_sede,
				s.cod_depto,
				s.cod_mupio,
				depto.departamento||', '||mupio.municipio as ubicacion,
				e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as nombre_sede_completa
			FROM sipol_usuario.tbl_rol_usuario ru
			LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
			LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
			LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
			LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
			LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
			LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
			LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
			WHERE u.id_usuario = ".$idUsuario."";
			 $command=$connection->createCommand($sql);
	 		$dataReader=$command->query();
	 		return  $dataReader;
 	}
 	public function validar_estado_usuario($idUsuario)
 	{
 		$connection=Yii::app()->db;
 		$sql = "select id_usuario from sipol_usuario.tbl_usuario where id_usuario = ".$idUsuario." AND ESTADO = 1 AND PROCESO = 1;";
			 $command=$connection->createCommand($sql);
	 		$resultado=$command->queryAll();
		return $resultado;
 	}
 	public function ingreso_session($idusuario,$ip,$origen,$id_sede)
 	{
 		$connection=Yii::app()->db;
 		$upd = "INSERT INTO sipol_usuario.tbl_session_usuario  (id_usuario,ip_ingreso,origen,id_sede)VALUES (".$idusuario.", '".$ip."','".$origen."',".$id_sede.");";
		 $command=$connection->createCommand($upd);
	 		$resultado=$command->execute();  
		return $resultado; 

 	}
 	public function validar_mensaje_sistema($id_usuario)
 	{
 		$connection=Yii::app()->db;
 		$sql = "select estado_mensaje from sipol_catalogos.config_opciones";
			 $command=$connection->createCommand($sql);
	 		$resultado=$command->queryAll();
	 		 foreach($resultado as $row)
			 	{
					$estado_mensaje = $row['estado_mensaje'];
				}

				if($estado_mensaje==1)
				{
					$sql2 = "select estado_mensaje from sipol_usuario.tbl_usuario where id_usuario = ".$id_usuario."";
					 $command=$connection->createCommand($sql2);
			 		$resultado2=$command->queryAll();
			 		 foreach($resultado2 as $row)
					 	{
							$estado_mensaje2 = $row['estado_mensaje'];
						}

				}else{

					$estado_mensaje2 = 0;

			}			
		return $estado_mensaje2;
 	}
 	public function validar_mensaje_sistema_pass($id_usuario)
 	{
 		$connection=Yii::app()->db;
 		
		
					$sql2 = "select estatuspass from sipol_usuario.tbl_usuario where id_usuario = ".$id_usuario."";
					 $command=$connection->createCommand($sql2);
			 		$resultado2=$command->queryAll();
			 		 foreach($resultado2 as $row)
					 	{
							$estado_mensaje2 = $row['estatuspass'];
						}
		
		return $estado_mensaje2;
 	}
public function mensaje_ingreso()
	{
		$sql = "select mensaje_ingreso from sipol_catalogos.config_opciones;";
        $resultado = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($resultado)==0)
        {          
        }else
        {
                foreach($resultado as $key => $value)
                    {
                        $valor = json_encode($value);
                        $nuevo = json_decode($valor);                       
                    } 
                   		return $nuevo->mensaje_ingreso;
        }
	}

	public function mensaje_ingreso_pass()
	{
		$sql = "select mensaje_pass from sipol_catalogos.config_opciones;";
        $resultado = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($resultado)==0)
        {          
        }else
        {
                foreach($resultado as $key => $value)
                    {
                        $valor = json_encode($value);
                        $nuevo = json_decode($valor);                       
                    } 
                   		return $nuevo->mensaje_pass;
        }
	}


	public function actualizar_estado_mensaje_usuario()
	{

	}
}
