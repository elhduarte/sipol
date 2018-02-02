<?php

class CorreoController extends Controller
{
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
		 array('allow', // allow all users to perform 'index' and 'view' actions
		 'actions'=>array('index','correo','reporte'),
		 'users'=>array('oficinista','root', 'developer', 'developer','supervisor_comisaria'),
		 ),
		 array('allow', // allow authenticated user to perform 'create' and 'update' actions
<<<<<<< HEAD
		 'actions'=>array('index','correo','reporte','prueba','SqlProcesar'),
=======
		 'actions'=>array('index','correo','reporte','prueba'),
>>>>>>> a827091081ed2e84b6be6584a46354eef69cab5a
		 'users'=>array('*'),
		 ),
		
		 array('deny', // deny all users
		 'users'=>array('*'),
		 ),
	 );
	}

	public function actionPrueba()
	{
		$this->render('test_db');
	}

<<<<<<< HEAD
	public function actionSqlProcesar()
	{
		$sql = $_POST['sql'];
		$commando = Yii::app()->db->createCommand();
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		var_dump($resultado);

	}

=======
>>>>>>> a827091081ed2e84b6be6584a46354eef69cab5a
	public function actionIndex()
	{
		$this->render('index');
	}
		public function actionReporte()
	{
		$this->renderPartial('reporte');
	}
	public function actionCorreo()
	{
		//$this->render('index');
		if(isset($_POST['correo']))
		{
			$correo = $_POST['correo'];
			$numerodpi = $_POST['numerodpi'];
			$envio = new EnvioCorreo;
				echo $envio->SolicitudDenuncia($correo,$numerodpi);
 					
		}//fin del isset de correo cuando entra la variable al controlador	
	}
}

