<?php

class FuncionespController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','actualizarestadomensaje','Updaterelato'),
				'users'=>array('root', 'developer','supervisor_comisaria'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','ActualizarUbicacion','InformacionSede'),
				'users'=>array('@'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('captcha'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionUpdaterelato()
	{
		$this->render('update_relato');
	}

	public function actionCaptcha()
	{
		$this->renderPartial('captcha');
	}
	public function actionActualizarestadomensaje()
	{
		$usuario = $_POST['idusuario'];
		$estado = 0;

			$command = Yii::app()->db->createCommand();
			$relatoSave = $command->update('sipol_usuario.tbl_usuario',
			array('estado_mensaje'=>$estado,
			),
				'id_usuario=:id',array(':id'=>$usuario)
		);

		//$this->renderPartial('captcha');
	}
	public function actionActualizarUbicacion()
	{
		$usuario = $_POST['idusuario'];
		$sede = $_POST['sede_ingreso'];

		$command = Yii::app()->db->createCommand();
		$relatoSave = $command->update('sipol_usuario.tbl_rol_usuario',
		array('id_sede'=>$sede,
		),
		'id_usuario=:id',array(':id'=>$usuario)
		);
		$estado = 0;
		$command = Yii::app()->db->createCommand();
		$relatoSave = $command->update('sipol_usuario.tbl_usuario',
		array('estado_mensaje'=>$estado,
		),
		'id_usuario=:id',array(':id'=>$usuario)
		);
	}
	public function actionInformacionSede()
		{
			$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
			$nombre_sede_completa = $variable_datos_usuario[0]->nombre_sede_completa;
			$nombre_completo = $variable_datos_usuario[0]->nombre_completo;
			echo "<span style='font-size: 14px;''><b>¡Bienvenido a Sipol!</b></span><b>  ".$nombre_completo ."</b><br>
			<span style='font-size: 12px;''><b>Ubicación Actual Registrada en el Sistema:</b></span> ".$nombre_sede_completa."";
			
			/*echo "<legend>¡Bienvenido a Sipol! ".$nombre_completo ." </legend>
			<p><b><h5>Ubicación Actual Registrada en el Sistema:</h5></b>".$nombre_sede_completa."</p>";*/
		}
}

	

