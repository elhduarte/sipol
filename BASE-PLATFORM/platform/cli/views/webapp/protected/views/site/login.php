

<?php
/* @var $this SiteController */
/* @var $model LoginForm */	
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
	'heading'=>'Login',
)); ?>

<p>Por favor complete el siguiente formulario con sus credenciales de inicio de sesión:</p>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<div class="row-fluid">
  <div class="span3"> <img class="imagen" src="<?php echo Yii::app()->request->baseUrl."/images/inicio.png"; ?>" >   </div>
 
  <div class="span9">



  	<?php echo $form->textFieldRow($model, 'username', array('class'=>'span4')); ?>
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span4')); ?>
	<?php echo $form->checkboxRow($model, 'rememberMe'); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary','size'=>'large','label'=>'Login')); ?>
	<?php $this->endWidget(); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php $this->endWidget(); ?>

</div>
</div>

