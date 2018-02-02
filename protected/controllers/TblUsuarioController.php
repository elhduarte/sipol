<?php

class TblUsuarioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public static $primer_nombre = "";

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('restablecer','correo', 'solicitudPasswordCorreo','restablecerpass','cambiarpassworddos'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('CambioSede','cambiocorreo','boleta','usuariovalidador','guardarusuariodpi',
					'guardarusuariodpimanual','carta','busquedadpi','viewperfil','password','cambiarpassword','usuarioestadistica'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('adminusuariosnovedades','boleta','crear_usuario','index','admin','view','update','delete','ActualizarRol','ResumenGlobal','Responsabilidad','passrestaurar'),
				'users'=>array('crear_usuario','developer','root','supervisor_comisaria','soporte'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
public function actionBoleta()
	{
		$this->render('boleta1');
	}

	public function actionUsuarioEstadistica()
	{
		$this->render('estadistica/index');

	}
	public function actionRestablecer()
	{		
		$this->render('restablecer');
	}
	public function actionRestablecerPass()
	{		
		$emailmostrar ="";
		$celularmostrar="";
		//$this->render('restablecer');
		$nip = $_POST['nip'];
		$chech = $_POST['chech'];
		$chech = explode(",",$chech);
		if(count($chech) == 1)
		{
			echo '<div class="alert alert-info">
		                      <button type="button" class="close" data-dismiss="alert">&times;</button>
		                      <h4>Información!</h4>
		                      NO tiene ninguna seleccion para recuperar contraseña
		                    </div>';
		}else{
			$tblUsuario = new TblUsuario;
			if($tblUsuario->conteo_nip_usuario($nip)==1)
			{
			//echo "usuario si existe en la base de datos";
				/*generamos la contraseña nueva para ser validad*/
			$funcionesP = new Funcionesp;
			$password = $funcionesP->generarpass();
			$Encrypter = new Encrypter;
			$variablepassword= $Encrypter->encrypt($password);
			$upd = "UPDATE sipol_usuario.tbl_usuario
			SET password = '".$variablepassword."',estatuspass = 1
			WHERE usuario ='".$nip."'";
			$resultado = Yii::app()->db->createCommand($upd)->execute();
			/*termiana la configuaracion para contraseñann*/
					foreach ($chech as $value) 
					{						//echo $value;
						if($value =='1')
						{							//echo "<br>";
							$email = $tblUsuario->extraer_correo($nip);
							 
							if($email==""){
								//echo "NO TIENE CORREO REGISTRADO";
								$emailmostrar= 	"NO TIENE CORREO REGISTRADO";				
							}else{
									$envio = new EnvioCorreo;
									$respustaenvio =  $envio->SolicitudPasswordCorreoRestablecer($email,$nip);		
									$conteoemail = 	 strlen($respustaenvio);
									$emailmostrar = "";
									for ($i=0; $i <= $conteoemail-1; $i++) { 
										if($i <= 3)
										{
											$emailmostrar = $emailmostrar."*";
										}else{
											$emailmostrar = $emailmostrar.$respustaenvio[$i];
										}
									}//fin del for para concatenar el email.
									$emailmostrar = "Clave enviada al correo :  ".$emailmostrar ;
							}
						}else if($value =='2'){
							//echo "<br>";
							$celular = $tblUsuario->extraer_celular($nip);
							if($celular==""){
								//echo "NO TIENE TELEFONO CELULAR REGISTRADO";
								$celularmostrar = "NO TIENE TELEFONO CELULAR REGISTRADO";				
							}else{
								//echo "si tiene TELEFONO";	
								//echo "<br>";
									$usuario = new TblUsuario;
									$usuarios = $usuario->findAllByAttributes(array('usuario'=>$nip));
									$usuario_destino = $usuarios[0];


								$mensaje = "Usuario Que Solicita:".$usuario_destino->usuario." Clave temporal de ingreso sistema SIPOL:".$password;
								//echo $mensaje;
								//echo "<br>";
								$consumos = new WSConsulta;
								//echo $celular;
								$consumos->EnviarMensajeTexto($celular,$mensaje);
								$respustaenviocelular = (string)$celular;
								$conteoemail = 	 strlen($respustaenviocelular);
									$celularmostrar = "";
									for ($i=0; $i <= $conteoemail-1; $i++) { 
										if($i <= 3)
										{
											$celularmostrar = $celularmostrar."*";
										}else{
											$celularmostrar = $celularmostrar.$respustaenviocelular[$i];
										}
									}//fin del for para concatenar el email.
									//echo $celularmostrar;
									 $celularmostrar = "Clave enviada al Celular:  ".$celularmostrar;
								//echo $respustaenviocelular;	
							}//fin cuanto tiene el usuario
						}//fin del if para evaluar que evento es
						//echo "<br>";
					}//fin del forreach para recorer que selecciono el usuario
					echo '<div class="alert alert-info">
		                      <button type="button" class="close" data-dismiss="alert">&times;</button>
		                      <h4>Información!</h4>
		                      '.$celularmostrar."<br>".$emailmostrar.'
		                    </div>';
			}else{
					echo "usuario no existe en la base de datos";
			}
		}//fin cuando es 1
		//echo $nip."yo soy los chech".$chech;
	}

	public function actionPassRestaurar()
	{
			$codigousuario = $_POST['codigousuario'];
			$funcionesP = new Funcionesp;
			$consumos = new WSConsulta;
			$Encrypter = new Encrypter;
			$envio = new EnvioCorreo;
			$tblUsuario = new TblUsuario;
			$password = $funcionesP->generarpass();			
			$variablepassword= $Encrypter->encrypt($password);
			$upd = "UPDATE sipol_usuario.tbl_usuario
			SET password = '".$variablepassword."',estatuspass = 1
			WHERE id_usuario =".$codigousuario."";
			$resultado = Yii::app()->db->createCommand($upd)->execute();
			$respustaenvio =  $envio->SolicitudPasswordgenerarpass($codigousuario);
			$celular = $tblUsuario->extraer_celular_id_usuario($codigousuario);
			if($celular==""){
				//echo "NO TIENE TELEFONO CELULAR REGISTRADO";
				$celularmostrar = "NO TIENE TELEFONO CELULAR REGISTRADO";				
			}else{
					$mensaje = "Usuario Que Solicita: ".$codigousuario." Clave temporal de ingreso sistema SIPOL:  ".$password;
					$consumos->EnviarMensajeTexto($celular,$mensaje);
			}
			echo "Clave enviada Automaticamente";
	}
	public function actionAdminUsuariosNovedades()
	{
		$this->render('novedades/AdminUsuariosNovedades');
	}
	public function actionCambioSede()
	{
		$this->render('cambio_sede');
	}
	public function actionResumenGlobal()
	{
		$this->render('global_resumen');
	}
	public function actionCorreo()
	{
		if(isset($_POST['numerousaurio']))
		{
			$numerousaurio = $_POST['numerousaurio'];
			$numerodpi = $_POST['numerodpi'];
			$envio = new EnvioCorreo;
			echo $envio->SolicitudPassword($numerousaurio,$numerodpi);		
		}//fin del isset de correo cuando entra la variable al controlador	

	}
	
	public function actionSolicitudPasswordCorreo()
	{
		$email = $_POST['email'];		
		$envio = new EnvioCorreo;
		echo $envio->SolicitudPasswordCorreo($email);		
	}
	
	public function actionCambiocorreo()
	{
		if(isset($_POST['correonuevo'])){
			$correo = $_POST['correonuevo'];
			$usuario= $_POST['usuario'];
			$command = Yii::app()->db->createCommand();
			$relatoSave = $command->update('sipol_usuario.tbl_usuario',
			array('email'=>$correo,
			),
				'id_usuario=:id',array(':id'=>$usuario)
		);
			echo "<i>".$correo."</i>";


		}
	}

	public function actionPassword()
	{
		$this->render('password');
	}
	public function actionCambiarpassword()
	{
		if(isset($_POST['passwordnuevo'])){
			$password = $_POST['passwordnuevo'];
			$usuario= $_POST['usuario'];
			$Encrypter = new Encrypter;
			$variablepassword= $Encrypter->encrypt($password);
			$upd = "UPDATE sipol_usuario.tbl_usuario
					SET password = '".$variablepassword."'
					WHERE id_usuario =".$usuario."";
			$resultado = Yii::app()->db->createCommand($upd)->execute();
			echo "<i>".$password."</i>";
			session_unset(); 
			session_destroy();
		}

	}
	public function actionCambiarpassworddos()
	{
		if(isset($_POST['passwordnuevo'])){
			$password = $_POST['passwordnuevo'];
			$usuario= $_POST['usuario'];
			$Encrypter = new Encrypter;
			$variablepassword= $Encrypter->encrypt($password);
			$upd = "UPDATE sipol_usuario.tbl_usuario
					SET password = '".$variablepassword."' ,estatuspass = 0
					WHERE id_usuario =".$usuario."";
			$resultado = Yii::app()->db->createCommand($upd)->execute();
			echo "<i>".$password."</i>";
			session_unset(); 
			session_destroy();
		}
			//echo "hola soy la accion";
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionActualizarRol()
	{
		$codigousuario = $_POST['codigousuario'];
		$password= $_POST['password'];
		$role= $_POST['role'];
		$comparativa = "mingob123";
		$regreso = "";
				if($comparativa == $password)
				{
					if(isset($role))
					{
								$command = Yii::app()->db->createCommand();
								$relatoSave = $command->update('sipol_usuario.tbl_rol_usuario',
								array('id_rol'=>$role,
								),
									'id_usuario=:id',array(':id'=>$codigousuario)
							);
								//echo "Exito en la actualizacion";
								$regreso = "1";
								echo $regreso;
					}
				}else{

					//echo "No se puede Actualizar Necesita Contraseña del sistema";
					$regreso = "0";
					echo $regreso;

				}
	}
	public function actionViewperfil()
	{
		$this->render('viewperfil');
	}
	public function actionBusquedaDpi()
	{
		if(isset($_POST['numerodpi']))
		{	
			$id_usuario ='';
			$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
			$id_usuario = $variable_datos_usuario[0]->id_usuario;
			$numerodpi = $_POST['numerodpi'];
			$consulta_dpi = new TblUsuario;


			$respuesta = $consulta_dpi->consulta_dpi_existente($numerodpi);
			if($respuesta =="si")
			{

				$this->renderPartial('estado_usuario',array('numerodpi'=>$numerodpi));

			}else{
			

			$WSConsulta = new WSConsulta;
			$resultado = $WSConsulta->ConsultaDPI($numerodpi);
			function foto_base64_clean($foto='')
{

	if(isset($foto) && !empty($foto) && strlen($foto)>300){
		$xml = new SimpleXMLElement($foto);
		$newdataset = $xml->children();
		$objetos = get_object_vars($newdataset);
		$fotica=$objetos['PortraitImage'];
		$a=$fotica;
	}
	else{
		$a = NULL;
	}
	return $a;
}
			if (($resultado) == true)
			{
				//$resultado = json_decode($resultado);
		$r_primer_nombre = $resultado['primer_nombre'];
		$r_segundo_nombre = $resultado['segundo_nombre'];
		$r_primer_apellido = $resultado['primer_apellido'];
		$r_segundo_apellido = $resultado['segundo_apellido'];
		$r_genero = $resultado['genero'];
		$r_nacimiento = $resultado['fecha_nacimiento'];
		$r_pais_nacimiento = $resultado['pais_nacimiento'];
		$r_dpi = $resultado['dpi'];
		$r_departamento = $resultado['depto_nacimiento'];
		$r_municipio = $resultado['munic_nacimiento'];
		$r_ecivil = $resultado['estado_civil'];
		$r_nacionalidad = $resultado['nacionalidad'];
		$r_npadre = $resultado['nombre_padre'];
		$r_nmadre = $resultado['nombre_madre'];
		$r_foto = $resultado['foto'];
		$r_orden_cedula = $resultado['orden_cedula'];
		$r_registro_cedula = $resultado['registro_cedula'];
		
		if($r_genero=="M")
		{
			$r_genero = "MASCULINO";
		}
		else
		{
			$r_genero = "FEMENINO";
		}

		$r_nacimiento = substr($r_nacimiento, 0, 10);
		$h = array();
		$h = explode("-", $r_nacimiento);
		$r_nacimiento = $h[0]."-".$h[1]."-".$h[2];

		if(empty($r_dpi))
		{
			$cui_clean = "";
		}
		else
		{
			$cui_clean = $r_dpi;
		}


		if($r_ecivil=="C")
		{
			$r_ecivil = "CASADO";
		}
		else
		{
			$r_ecivil = "SOLTERO";
		}

		if(empty($r_foto))
		{
			$r_foto = "images/noimagen.png";
			$foto_clean = "";
		}
		else
		{
			$nuevafoto = $r_foto;
			$foto = foto_base64_clean($r_foto);
			$r_foto = "data:image/jpg;base64,".$foto;
			$foto_clean = $resultado['foto'];
		}



					
					//Renderiza la vista de ingreso por depi donde se encuentra la fotografia
					$this->renderPartial('ingreso/ingreso_dpi',array(
										'primer_nombre'=>$r_primer_nombre,
										'segundo_nombre'=>$r_segundo_nombre,										
										'primer_apellido'=>$r_primer_apellido,	
										'segundo_apellido'=>$r_segundo_apellido,
										'departamento_renap'=>$r_departamento,
										'municipio_renap'=>$r_municipio,										
										'genero'=>$r_genero,										
										'nacimiento'=>$r_nacimiento,										
										'dpi'=>$r_dpi,
										'foto'=>$r_foto,
										'orden_cedula'=>$r_orden_cedula,											
										'registro_cedula'=>$r_registro_cedula,
										'nuevafoto'=>$nuevafoto,								
										));
				}else {

						echo '
						<div class="alert">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4>Información del Sistema!</h4>
						  <blockquote>
							<small><cite title="Source Title">No se Encontraron Registros en Renap</cite></small>
							<small><cite title="Source Title">DPI Mal escrito</cite></small>
							<small><cite title="Source Title">Fallas con la conexion de internet</cite></small>
							<small><cite title="Source Title">Puedes ingresar al usuario Manual </cite></small>
							<small><cite title="Source Title">Intenta Buscar de Nuevo </cite></small>
							</blockquote>
						</div>
						';

						echo '<script type="text/javascript">
							$(document).ready(function(){
							  $("#formulariobusquedadpi").html("");
							  });';
					$this->renderPartial('buscardpi');
				}//fin si la consulta traje resultados



						}//termina la condifcion cuando el dpi ya se encuntra ingresado


				}//fin del isset de la post para el usuario

	}

	public function actionGuardarUsuarioDpi()
	{
				if(isset($_POST['primer_nombre']))
				{
					$dpi= $_POST['dpi'];
					$primer_nombre= $_POST['primer_nombre'];
					$segundo_nombre= $_POST['segundo_nombre'];
					$primer_apellido= $_POST['primer_apellido'];
					$segundo_apellido= $_POST['segundo_apellido'];
					$genero= $_POST['genero'];

					$fecha_nacimiento= $_POST['fecha_nacimiento'];            
					$cmb_depto= $_POST['cmb_depto'];
					$cmb_mupio= $_POST['cmb_mupio'];
					$numeroregistro=$_POST['numeroregistro'];
					$email= $_POST['email'];

					$direccion= $_POST['direccion'];            
					
					$entidad= $_POST['entidad'];
					$tipo_sede=$_POST['tipo_sede'];
					$sede=$_POST['sede'];
					$role= $_POST['role'];
					$puesto= $_POST['puesto'];
					$oficio= $_POST['oficio'];

					$usuario= $_POST['usuario'];
					$password= $_POST['password'];	
					$estado= $_POST['estado']; 
					$fotografia=$_POST['fotografia'];

					$idusuarioingresa=$_POST['idusuarioingresa'];        
           

						if($genero =="MASCULINO" || $genero =="1" )
						{
							$genero= "1";

						}else{

							$genero= "0";

						}
					$Encrypter = new Encrypter;
					$variablepassword= $Encrypter->encrypt($password);			
					$ingreso_usuario=new TblUsuario;
					$reportes = new Reportes;


					$deptoId = $reportes->getDeptoid($cmb_depto);
					$mupioId = $reportes->getMupioid($cmb_mupio,$deptoId);
					$cmb_depto =$deptoId;
					$cmb_mupio =$mupioId;
					

					$ingreso_usuario->attributes=array(
										'puesto'=>$puesto,
										'usuario' => $usuario,
										'password'=>$variablepassword,
										'email'=>$email,
										'no_oficio_solicitud'=>$oficio,
										'id_usuario_crea'=>$idusuarioingresa,
										//'fecha_crea'=>'1',
										'estado' => $estado,

										'primer_nombre'=>$primer_nombre,
										'segundo_nombre'=>$segundo_nombre,
										'primer_apellido'=>$primer_apellido,
										'segundo_apellido'=>$segundo_apellido,
										'fecha_nacimiento'=>$fecha_nacimiento,
										'dpi' => $dpi,
										'no_orden'=>$numeroregistro,
										'direccion'=>$direccion,
										'departamento'=>$cmb_depto,
										'municipio'=>$cmb_mupio,
										'sexo'=>$genero,
										//'no_registro' => $numeroregistro,
										'foto'=>$fotografia,			

										);
				$ingreso_usuario->save(); // Se guardan los datos en la tabla de oficinista

				$tblusrol = new TblRolUsuario;
				$tblusrol ->attributes=array(
				'id_usuario'=>$ingreso_usuario->id_usuario,
				'id_rol' => $role,
				'id_sede'=>$sede,							
				);
				$tblusrol ->save();
				$numero = $ingreso_usuario->id_usuario;
				$compilarclase = new Encrypter;
				$compilar = $compilarclase->compilarget($numero);
				
				echo  $compilar;
			
			}//fin del isset
	}//fin de la funcion que ingresa el usuario

	public function actionGuardarUsuarioDpiManual()
	{
				if(isset($_POST['primer_nombre']))
				{
					$dpi= $_POST['dpi'];
					$primer_nombre= $_POST['primer_nombre'];
					$segundo_nombre= $_POST['segundo_nombre'];
					$primer_apellido= $_POST['primer_apellido'];
					$segundo_apellido= $_POST['segundo_apellido'];
					$genero= $_POST['genero'];

					$fecha_nacimiento= $_POST['fecha_nacimiento'];            
					$cmb_depto= $_POST['cmb_depto'];
					$cmb_mupio= $_POST['cmb_mupio'];
					$numeroregistro=$_POST['numeroregistro'];
					$email= $_POST['email'];

					$direccion= $_POST['direccion'];            
					
					$entidad= $_POST['entidad'];
					$tipo_sede=$_POST['tipo_sede'];
					$sede=$_POST['sede'];
					$role= $_POST['role'];
					$puesto= $_POST['puesto'];
					$oficio= $_POST['oficio'];

					$usuario= $_POST['usuario'];
					$password= $_POST['password'];	
					$estado= $_POST['estado']; 
					$fotografia=$_POST['fotografia'];

					$idusuarioingresa=$_POST['idusuarioingresa'];        
           

						if($genero =="MASCULINO" || $genero =="1" )
						{
							$genero= "1";

						}else{

							$genero= "0";

						}
					$Encrypter = new Encrypter;
					$variablepassword= $Encrypter->encrypt($password);			
					$ingreso_usuario=new TblUsuario;
					$reportes = new Reportes;


					/*$deptoId = $reportes->getDeptoid($cmb_depto);
					$mupioId = $reportes->getMupioid($cmb_mupio,$deptoId);
					$cmb_depto =$deptoId;
					$cmb_mupio =$mupioId;*/

					$ingreso_usuario->attributes=array(
										'puesto'=>$puesto,
										'usuario' => $usuario,
										'password'=>$variablepassword,
										'email'=>$email,
										'no_oficio_solicitud'=>$oficio,
										'id_usuario_crea'=>$idusuarioingresa,
										//'fecha_crea'=>'1',
										'estado' => $estado,

										'primer_nombre'=>$primer_nombre,
										'segundo_nombre'=>$segundo_nombre,
										'primer_apellido'=>$primer_apellido,
										'segundo_apellido'=>$segundo_apellido,
										'fecha_nacimiento'=>$fecha_nacimiento,
										'dpi' => $dpi,
										'no_orden'=>$numeroregistro,
										'direccion'=>$direccion,
										'departamento'=>$cmb_depto,
										'municipio'=>$cmb_mupio,
										'sexo'=>$genero,
										//'no_registro' => $numeroregistro,
										'foto'=>$fotografia,			

										);
				$ingreso_usuario->save(); // Se guardan los datos en la tabla de oficinista

				$tblusrol = new TblRolUsuario;
				$tblusrol ->attributes=array(
				'id_usuario'=>$ingreso_usuario->id_usuario,
				'id_rol' => $role,
				'id_sede'=>$sede,							
				);
				$tblusrol ->save();
				$numero = $ingreso_usuario->id_usuario;
				$compilarclase = new Encrypter;
				$compilar = $compilarclase->compilarget($numero);
				echo  $compilar;

			}//fin del isset
	}//fin de la funcion que ingresa el usuario

	public function actionCarta()
	{
		$this->renderPartial('carta');
	}
	public function actionResponsabilidad()
	{
		$this->renderPartial('responsabilidad');
	}


	

	public function actionUsuariovalidador()
	{
			$usuario = $_POST['usuario'];
			$Criteria = new CDbCriteria();		
			$Criteria->condition = "usuario="."'".$usuario."'";
			$data=TblUsuario::model()->findAll($Criteria);
			$data=CHtml::listData($data,'id_usuario','usuario');			 
			 if(count($data) == 0)
			 {
			 	echo 0;

			 }else{
			 	echo 1;
			 }		
	}
	public function actionCrear_Usuario()
	{
		$this->render('crear_usuario');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TblUsuario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblUsuario']))
		{
			$model->attributes=$_POST['TblUsuario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_usuario));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblUsuario']))
		{
			$model->attributes=$_POST['TblUsuario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_usuario));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
 
				$upd = "UPDATE sipol_usuario.tbl_usuario
					SET proceso = 0, usuario ='eliminado_' || usuario, estado = 0
					WHERE id_usuario =".$id."";

			$resultado = Yii::app()->db->createCommand($upd)->execute();


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TblUsuario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TblUsuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TblUsuario']))
			$model->attributes=$_GET['TblUsuario'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TblUsuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbl-usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
