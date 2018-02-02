<?php
class ReportesPdfController  extends Controller
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
				 'actions'=>array('Preview_incidencia','preview_extravio','preview_denuncia','DenunciaEstadistica','extravio','DenunciaGet','ExtravioGet','Reportesession','ExtensionGet','DenunciaTblEvento','DenunciaTblEventoGet','Extension','preview_extension'),
				 'users'=>array('root','oficinista','developer','supervisor_comisaria'),
				 ),
				 array('allow', // allow authenticated user to perform 'create' and 'update' actions
				 'actions'=>array('index',),
				 'users'=>array('@'),
				 ),
				  array('allow', // allow authenticated user to perform 'create' and 'update' actions
				 'actions'=>array('denuncia','incidencia','extravio','usuario'),
				 'users'=>array('*'),
				 ),		
				 array('deny', // deny all users
				 'users'=>array('*'),
				 ),
			 );
}	
	public function actionExtravioGet()
	{
		$decrypt = new Encrypter;
		$idEvento = $_POST['idEvento'];
		$tamano_papel = $_POST['tamano_papel'];
		$idEventoP = $decrypt->compilarget($idEvento);
		
		$command = Yii::app()->db->createCommand();
		$com = $command->update('sipol.tbl_evento',
		array('estado'=>'1',
		),
		'id_evento=:id',array(':id'=>$idEvento)
		);
		//error_log($idEventoP);
		$envio = new EnvioCorreo;
	  	$res = $envio->EnviarIdEventoExtravio($idEvento);	
		$url = CController::createUrl("Reportespdf/extravio&par=".$idEventoP."&nat=".$tamano_papel);
		echo $url;

	}
	public function actionDenunciaEstadistica()
	{
		$this->renderPartial('estadisticadenuncia');	
	}
	public function actionUsuario()
	{
		$this->renderPartial('usuario');	
	}

	public function actionDenunciaGet()
	{
		$decrypt = new Encrypter;
		$reportes = new Reportes;
		$idEvento = $_POST['idEvento'];
		$tamano_papel = $_POST['tamano_papel'];
		$idEventoP = $decrypt->compilarget($idEvento);
		$urlPgn = 'empty';

		if(isset($_POST['nuevoIdEvento']))
		{
			$nuevoIdEvento = $_POST['nuevoIdEvento'];
			$command = Yii::app()->db->createCommand();
			$com = $command->update('sipol.tbl_evento',
			array('estado'=>'1',
			),
			'id_evento=:id',array(':id'=>$nuevoIdEvento)
			);
		}else
		{
			$command = Yii::app()->db->createCommand();
			$com = $command->update('sipol.tbl_evento',
			array('estado'=>'1',
			),
			'id_evento=:id',array(':id'=>$idEvento)
			);
		}

	  	$envio = new EnvioCorreo;
	  	$res = $envio->EnviarIdEvento($idEvento);		
		$url = CController::createUrl("Reportespdf/denuncia&par=".$idEventoP."&nat=".$tamano_papel);
		//echo $url.'~'.$urlPgn;
		echo $url;
	}
	public function actionExtensionGet()
	{
		$decrypt = new Encrypter;
		$reportes = new Reportes;
		$idEvento = $_POST['idEvento'];
		$tamano_papel = $_POST['tamano_papel'];
		$idEventoP = $decrypt->compilarget($idEvento);
		$urlPgn = 'empty';

		if(isset($_POST['nuevoIdEvento']))
		{
			$nuevoIdEvento = $_POST['nuevoIdEvento'];
			$command = Yii::app()->db->createCommand();
			$com = $command->update('sipol.tbl_evento',
			array('estado'=>'1',
			),
			'id_evento=:id',array(':id'=>$nuevoIdEvento)
			);
		}else
		{
			$command = Yii::app()->db->createCommand();
			$com = $command->update('sipol.tbl_evento',
			array('estado'=>'1',
			),
			'id_evento=:id',array(':id'=>$idEvento)
			);
		}

	  	$envio = new EnvioCorreo;
	  	$res = $envio->EnviarIdEvento($idEvento);		
		$url = CController::createUrl("Reportespdf/extension&par=".$idEventoP."&nat=".$tamano_papel);
		//echo $url.'~'.$urlPgn;
		echo $url;
	}

	public function actionExtravio()
	{
		$this->renderPartial('extravio');
	}
	public function actionDenuncia()
	{
		$this->renderPartial('denuncia');

		}

	public function actionExtension()
	{
		$this->renderPartial('extension');

	

	}
	public function actionPreview_denuncia()
	{
		$id_evento = $_POST['idEvento'];
		$tamano_papel = $_POST['tamano_papel'];
		$idEvento = md5($id_evento);

		$dir = Yii::getPathOfAlias('webroot')."/temp/denuncias/";
		$ruta = dirname($dir)."/denuncias".DIRECTORY_SEPARATOR;
		$ruta = $ruta.$idEvento;

		$a = Yii::app()->createAbsoluteUrl('');
		$direccion = str_replace("index.php", "", $a);
		$direccion = $direccion."temp/denuncias/".$idEvento;

		$peticion = $this->renderPartial('preview_denuncia',array('ruta'=>$ruta,'id_evento'=>$id_evento,'tamano_papel'=>$tamano_papel));
		echo $direccion.".pdf";

	}
public function actionPreview_extension()
	{
		$id_evento = $_POST['idEvento'];
		$tamano_papel = $_POST['tamano_papel'];
		$idEvento = md5($id_evento);

		$dir = Yii::getPathOfAlias('webroot')."/temp/denuncias/";
		$ruta = dirname($dir)."/denuncias".DIRECTORY_SEPARATOR;
		$ruta = $ruta.$idEvento;

		$a = Yii::app()->createAbsoluteUrl('');
		$direccion = str_replace("index.php", "", $a);
		$direccion = $direccion."temp/denuncias/".$idEvento;

		$peticion = $this->renderPartial('preview_extension',array('ruta'=>$ruta,'id_evento'=>$id_evento,'tamano_papel'=>$tamano_papel));
		echo $direccion.".pdf";

	}
	public function actionPreview_incidencia()
	{
		$id_evento = $_POST['idEvento'];
		$tamano_papel = $_POST['tamano_papel'];
		$idEvento = md5($id_evento);

		$dir = Yii::getPathOfAlias('webroot')."/temp/incidencia/";
		$ruta = dirname($dir)."/incidencia".DIRECTORY_SEPARATOR;
		$ruta = $ruta.$idEvento;

		$a = Yii::app()->createAbsoluteUrl('');
		$direccion = str_replace("index.php", "", $a);
		$direccion = $direccion."temp/incidencia/".$idEvento;

		$peticion = $this->renderPartial('preview_incidencia',array('ruta'=>$ruta,'id_evento'=>$id_evento,'tamano_papel'=>$tamano_papel));
		echo $direccion.".pdf";

	}

	public function actionPreview_extravio()
	{
		$id_evento = $_POST['idEvento'];
		$tamano_papel = $_POST['tamano_papel'];
		$idEvento = md5($id_evento);

		$dir = Yii::getPathOfAlias('webroot')."/temp/extravios/";
		$ruta = dirname($dir)."/extravios".DIRECTORY_SEPARATOR;
		$ruta = $ruta.$idEvento;

		$a = Yii::app()->createAbsoluteUrl('');
		$direccion = str_replace("index.php", "", $a);
		$direccion = $direccion."temp/extravios/".$idEvento;

		$peticion = $this->renderPartial('preview_extravio',array('ruta'=>$ruta,'id_evento'=>$id_evento,'tamano_papel'=>$tamano_papel));
		echo $direccion.".pdf";

	}

		public function actionReportesession()
	{
		$this->renderPartial('reportesession');
	}

	public function actionIncidencia()
	{
		$this->renderPartial('incidencia');
	}

}
