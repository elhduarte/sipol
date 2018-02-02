
<?php

class TblEventoController extends Controller
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

				'actions'=>array('index','view','Index_filtros','grid','getTipo','getComisaria','sispe'),
				'users'=>array('*','developer'),

				'actions'=>array('index','view','Index_filtros','grid','getTipo','getComisaria','sispe'),
				'users'=>array('*','developer','supervisor_comisaria'),

			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/*public function actionIndex_filtros()
	{
		$this->render('index_filtros');
	}*/
public function actionSispe()
	{
		
		$this->renderPartial('sispe');
	}
	public function actionIndex_filtros()
	{
		if(isset($_POST['band']))
		{
			$this->renderPartial('grid');
		}
		else
		{
			$this->render('index_filtros');
		}
	}   
public function actionGrid()
	{
		$this->renderPartial('grid');
	}
		public function actiongetTipo()
	{

		$Criteria = new CDbCriteria();
		$Criteria->condition = 'tipo_hecho='.$_POST['param'];
		$Criteria->order ='nombre_denuncia ASC';

			$data=CatDenuncia::model()->findAll($Criteria);

	       $data=CHtml::listData($data,'id_cat_denuncia','nombre_denuncia');
	       $contador = '0';
	       foreach($data as $value=>$name)
	       {
	           if($contador =='0')
	           {
	           	echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Hecho'),true);
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }else
	           {
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }
	        $contador = 1;
	       }
	}




	public function actiongetComisaria()
	{

		$Criteria = new CDbCriteria();
		$Criteria->condition = 'distrito='.$_POST['distrito'];
		$Criteria->order ='nombre_entidad ASC';

			$data=CatEntidad::model()->findAll($Criteria);

	       $data=CHtml::listData($data,'id_cat_entidad','nombre_entidad');
	       $contador = '0';
	       foreach($data as $value=>$name)
	       {
	           if($contador =='0')
	           {
	           	echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione una Comisaria'),true);
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }else
	           {
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }
	        $contador = 1;
	       }
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TblEvento;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblEvento']))
		{
			$model->attributes=$_POST['TblEvento'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_evento));
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

		if(isset($_POST['TblEvento']))
		{
			$model->attributes=$_POST['TblEvento'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_evento));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TblEvento');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TblEvento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TblEvento']))
			$model->attributes=$_GET['TblEvento'];

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
		$model=TblEvento::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbl-evento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
