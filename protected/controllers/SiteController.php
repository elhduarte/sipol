<?php
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $attempts = 5; // allowed 5 attempts
public $counter;
private function captchaRequired()
        {           
                return Yii::app()->session->itemAt('captchaRequired') >= $this->attempts;
        }
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
        {
                $model = $this->captchaRequired()? new LoginForm('captchaRequired') : new LoginForm;
 
                // if it is ajax validation request
                if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
                {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }
 
                // collect user input data
                if(isset($_POST['LoginForm']))
                {
                        $model->attributes=$_POST['LoginForm'];
                        // validate user input and redirect to the previous page if valid
                        if($model->validate() && $model->login())
                        {

$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$ruta = $variable_datos_usuario[0]->id_rol;
switch ($ruta) {
case '1':
//$this->redirect(Yii::app()->createUrl('Estadisticas/Dashbosard'));
//$this->redirect('index.php?r=denuncia/selector');
$this->redirect(Yii::app()->createUrl('Estadisticas/index'));
break;
case '9':
$this->redirect(Yii::app()->createUrl('Estadisticascf/altomando'));
break;
default:
$this->redirect(Yii::app()->createUrl('denuncia/selector'));
break;
	}
}else{
            $this->counter = Yii::app()->session->itemAt('captchaRequired') + 1;
            Yii::app()->session->add('captchaRequired',$this->counter);
   }
}
                // display the login form
                $this->render('login',array('model'=>$model));
        }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	


}
?>