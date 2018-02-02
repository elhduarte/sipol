<?php


class AdminhechosController extends Controller
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
		 'actions'=>array('index','ordenar'),
		 'users'=>array('root','developer'),
		 ),
		 array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 'actions'=>array(''),
		 'users'=>array('@'),
		 ),
		  array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 'actions'=>array(''),
		 'users'=>array('*'),
		 ),			
		 array('deny', // deny all users
		 'users'=>array('*'),
		 ),
	 );
	}	
	public function actionIndex()
	{
			//$this->render('restablecer');
			$this->render('index');
	}
	public function actionOrdenar()
	{
			//$this->render('restablecer');
			//$this->render('index');

		$ordanamiento = $_POST['query'];
		$ordanamiento =  str_replace(",&", "", $ordanamiento);

		
		$query ="update  sipol_catalogos.cat_hecho_denuncia  set ".$ordanamiento." where id_hecho_denuncia = 28";
				/*$upd = "UPDATE sipol_usuario.tbl_usuario
					SET password = '".$variablepassword."'
					WHERE id_usuario =".$usuario."";*/

			$resultado = Yii::app()->db->createCommand($query)->execute();
			echo $query;


	}

	

}
