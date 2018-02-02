<?php

class CTBoletaController extends Controller
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
	//public $estado = "ver";
	//echo $estado;
	public $estado = array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','prueba','view','evento','grid','crear','index2','mapa','Mnovedades','Vconsulta','ActualizarGrid','Actualizaestado','cuadro'),
				'users'=>array('root','developer','supervisor_comisaria'),
			);
	public function accessRules()
	{
		return array(
			$this->estado,
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
public function actionVconsulta()
	{
		$this->render('viewConsulta');
	}

	public function actionActualizarGrid()
	{
		$this->renderPartial('viewGrid');
	}
	public function actionCuadro()
	{
		$this->render('circunstanciado');
	}
	public function actionActualizaestado()
	{ 
		if(isset($_POST['id_boleta'])){
			$id_boleta= $_POST['id_boleta'];
			
			$command = Yii::app()->db->createCommand();		
			$estado = $command->update('dg_pnc_novedades.t_boleta', array(
	   		'estado'=>'Finalizada',
	    	),'id_boleta=:id',array(':id'=>$id_boleta));
	    	//echo "La Boleta:".$id_boleta." Ya Es Una Novedad.";
	    }else 
	    {
	    	echo "Falló";
	    }
	}    
	public function actionMnovedades()
	{
		$this->render('_map_novedades');
	}

	public function actionIndex2()
	{
		$this->render('index2');
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	
	public function actionCrear()
	{


function normalize_date($date){  
if(!empty($date)){ 
$var = explode('/',str_replace('-','/',$date)); return "$var[2]-$var[0]-$var[1]"; 
}  
} 
		$hora = date("H:i:s",time()-21600);
		$horan = "{".$hora."}";
		if(isset ($_POST['data']))
		{
		
			$data = $_POST['data'];
		
			$enc = explode('|',$data);

					//POINT(-10014051.271376 1740758.0212264)

			$coordinates = new CDbExpression("st_GeomFromEWKT('SRID=900913;".$enc[11]."')");
	$nfecha = normalize_date($enc[2]);
		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario = $variable_datos_usuario[0]->id_usuario;
		$m_boleta = new mTBoleta;
		$m_boleta->attributes=array(
     		'id_comisaria'=>$enc[0],
     		'division_pnc'=>$enc[1],
     		'fecha'=>"{".$enc[2]."}",
			'hora'=>"{".$enc[3]."}",
     		'titulo'=>$enc[4],
     		'id_departamento'=>$enc[6],
 			'id_municipio'=>$enc[7],
 			'id_zona'=>$enc[8],
 			'the_geom'=>$coordinates,
 			'detalle'=>htmlspecialchars($enc[5]),
     		'estado'=>'Preeliminar',
     		'id_usuario'=>'57',
     		'hora_registro'=>$horan,	     			
			);
			$m_boleta->save();
			$correl = $m_boleta->id_boleta;
			$eventos = $_POST['data_det'];
			//print_r($eventos);
		$contador_posiciones = 0;
		$variable_string = "";
			foreach ($eventos as $key => $value) {
				if($contador_posiciones == 4)
				{
					$variable_string = $variable_string."|";
					$contador_posiciones = 0;
				}else{
					$variable_string = $variable_string.$value.",";
					$contador_posiciones = $contador_posiciones  +1;
				}
				
				# code...
			}
			//var_dump($eventos);

			$insert_id = Yii::app()->db->getLastInsertId('dg_pnc_novedades.t_boleta_id_boleta_seq');	
			$pjoin = explode('|',$variable_string);
 			foreach ($pjoin as $value) 
 			{
 				$param = explode(',',$value);
 			$connection=Yii::app()->db;
			$sql1 = "
			select a.id_evento from dg_pnc_novedades.t_evento a, dg_pnc_novedades.t_hecho b
			where b.id_hecho =a.id_hecho 
			and b.nombre_hecho ='".$param[0]."'
			and a.nombre_evento ='".$param[1]."'			
			";
			$command=$connection->createCommand($sql1);
			$dataReader=$command->query();
			$acciones = "";
			
			foreach($dataReader as $row)
			{
			$id = $row['id_evento'];
			} 
				$reg_actividades = $command->insert('dg_pnc_novedades.t_total_eventos', array(
     				'id_boleta'=>$insert_id,
     				'id_evento'=>$id,
     				'cantidad'=>$param[3],
					'complemento'=>$param[2],
				));	


			}
			$modal = '

					<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4>Guardó El Preeliminar:  '.$correl.' </h4>
					</div> 
					';
		echo $modal;

			
		}
		
	}
	public function actionCreate()
	{
		$model=new mTBoleta;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['mTBoleta']))
		{
			$model->attributes=$_POST['mTBoleta'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_boleta));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	  public function actionEvento()
       {	
       	$id_hecho= $_POST['id_hecho'];
       	$contador =0;
				$Criteria = new CDbCriteria();
				$Criteria->condition = "id_hecho=".$id_hecho;
				$data=mTEvento::model()->findAll($Criteria);

               $data=CHtml::listData($data,'id_evento','nombre_evento');
               foreach($data as $value=>$name)
               {
               	    if($contador =='0')
						{

										
					}
               
               echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);	
               $contador = $contador +1;
               }
   

       }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionGrid()
	{
		$this->render('grid');
	}
	public function actionPrueba()
	{
		$this->render('pruebas');
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['mTBoleta']))
		{
			$model->attributes=$_POST['mTBoleta'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_boleta));
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
		$dataProvider=new CActiveDataProvider('mTBoleta');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new mTBoleta('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['mTBoleta']))
			$model->attributes=$_GET['mTBoleta'];

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
		$model=mTBoleta::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
		public function actionMapa()
	{
		$this->render('_map');
	}



	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='m-tboleta-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
