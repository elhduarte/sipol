
<?php 
if(Yii::app()->user->isGuest == false)
{

	
	$this->redirect('index.php?r=denuncia/selector');
	

	
}else{

 ?>
	


<?php
/* @var $this SiteController */
/* @var $model LoginForm */	
/* @var $form CActiveForm  */
/*
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);*/
?>


<!--p>Por favor complete el siguiente formulario con sus credenciales de inicio de sesión:</p-->
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'form-signin cuerpo', 'style'=>'margin-top:2%;'),
)); ?>
<div class="row-fluid" style="margin-bottom:1px;">
  <div class="span12" align="center"> 
  	<img class="img_login" src="<?php echo Yii::app()->request->baseUrl."/images/LogoApolo.png"; ?>" style="max-width: 80%;" >   

  </div>


</div>
 
  <div>
	
	<div style="margin-bottom: 20px;">
		
		<p class="comentario-fit">Los campos con <span class="required">*</span> son obligatorios.</p>
	</div>

  	<?php echo $form->textFieldRow($model, 'username', array('class'=>'input-block-level','labelOptions'=> array('label'=>'Usuario/NIP'))); ?>
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'input-block-level','labelOptions'=> array('label'=>'Contraseña'))); ?>

	<?php if($model->scenario == 'captchaRequired'): ?>
	<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span12">
      	<div align="center">
      	
		<?php echo CHtml::activeLabelEx($model,'verifyCode'); ?>
		<?php $this->widget('CCaptcha'); ?>
		</div>    	
      </div>
    </div>
    <div class="row-fluid">
     <div class="span12">
     	<legend></legend>
        <div class="row-fluid">
          <div class="span10">
          	 <?php echo CHtml::activeTextField($model,'verifyCode',array('class'=>'input-block-level')); ?>
    
	
				<!--div class="hint">Por favor, introduzca las letras que se muestran en la imagen de arriba.
				<br/>Las letras no distinguen entre mayúsculas y minúsculas.</div-->
				<?php echo $form->error($model,'verifyCode'); ?>
				      

          </div>
          <div class="span2">
          		<img src="images/info_icon.png" data-placement="right" id="ayuda_denunciante" data-original-title="">
          </div>
        </div>
      </div>
    </div>
    <legend></legend>
  </div>
</div>
<?php endif; ?>






       

	<?php echo $form->checkboxRow($model, 'rememberMe'); ?>


	<div align="center">
	<a href="index.php?r=tblUsuario/restablecer">¿Olvidaste tu contraseña / Usuario?</a>
	</div>
	<br>


				


	




	<div align="center">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary','size'=>'large','label'=>'Ingresar')); ?>
	<?php $this->endWidget(); ?>
	</div>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	
<?php $this->endWidget(); ?>



<?php

}//fin de la condicion isGuest
 ?>



</div><!-- form -->

<!-- Button to trigger modal -->

<script type="text/javascript">

$(document).ready(function()
{
$('#ayuda_denunciante').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> IMPORTANTE</legend><p style="line-height: 175%; text-align: justify;">Por favor, introduzca las letras que se muestran en la imagen de arriba. Las letras no distinguen entre mayúsculas y minúsculas..</p>'});
}); //fin del document.ready

</script>

 
