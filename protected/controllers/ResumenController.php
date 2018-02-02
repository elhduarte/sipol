<?php

class ResumenController extends Controller
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
		 'actions'=>array('index'),
		 'users'=>array('*'),
		 ),

		 array('allow', // allow all users to perform 'index' and 'view' actions
		 'actions'=>array(''),
		 'users'=>array('*'),
		 ),

		 array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 'actions'=>array('selector'),
		 'users'=>array('@'),
		 ),
		
		 array('deny', // deny all users
		 'users'=>array('*'),
		 ),
	 );
	}
	public function actionIndex()
	{
		$this->renderPartial('index');
	}

}