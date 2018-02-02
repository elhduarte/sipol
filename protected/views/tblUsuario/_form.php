<?php
/* @var $this TblUsuarioController */
/* @var $model TblUsuario */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbl-usuario-form',
	'enableAjaxValidation'=>false,
)); ?>
<style type="text/css">
	.desactivados{
		display: none;
	}
</style>

		<?php echo $form->errorSummary($model); ?>


<div class="row-fluid">
  <div class="span12">
<legend>Modificación de Usuario</legend>
    <div class="row-fluid">
      <div class="span2">
      	<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'usuario'); ?>
    
      </div>
      <div class="span2">
      	<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'password'); ?>
      	
      </div>
        <div class="span2">
        <?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
      	
      </div>
        <div class="span2">
        	<?php echo $form->labelEx($model,'primer_nombre'); ?>
		<?php echo $form->textField($model,'primer_nombre'); ?>
		<?php echo $form->error($model,'primer_nombre'); ?>
      
      	
      </div>
        <div class="span2">
        		<?php echo $form->labelEx($model,'segundo_nombre'); ?>
		<?php echo $form->textField($model,'segundo_nombre'); ?>
		<?php echo $form->error($model,'segundo_nombre'); ?>
        		
      </div>
        <div class="span2">
        	  	<?php echo $form->labelEx($model,'fecha_crea'); ?>
		<?php echo $form->textField($model,'fecha_crea',array('disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'fecha_crea'); ?>
        	
      	
      </div>
    </div>
        <div class="row-fluid">
      <div class="span2">

    

     <?php echo $form->labelEx($model,'estado'); ?>
        <?php echo CHtml::activeDropDownList($model,'estado',array("1" => "ACTIVADO", "0" => "DESACTIVADO")); ?>
        <?php echo $form->error($model,'estado'); ?>
      </div>
      <div class="span2">
      	 	<?php echo $form->labelEx($model,'primer_apellido'); ?>
		<?php echo $form->textField($model,'primer_apellido'); ?>
		<?php echo $form->error($model,'primer_apellido'); ?>
      			
      	
      </div>
        <div class="span2">
        			<?php echo $form->labelEx($model,'segundo_apellido'); ?>
		<?php echo $form->textField($model,'segundo_apellido'); ?>
		<?php echo $form->error($model,'segundo_apellido'); ?>
        		
      	
      </div>
        <div class="span2">
        	<?php echo $form->labelEx($model,'fecha_nacimiento'); ?>
		<?php echo $form->textField($model,'fecha_nacimiento',array('disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'fecha_nacimiento'); ?>
      	
       
      	
      </div>
        <div class="span2">
        	      		<?php echo $form->labelEx($model,'dpi'); ?>
		<?php echo $form->textField($model,'dpi'); ?>
		<?php echo $form->error($model,'dpi'); ?>
        
      	
      </div>
        <div class="span2">
        	<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion'); ?>
		<?php echo $form->error($model,'direccion'); ?>
        	
      </div>
    </div>
        <div class="row-fluid">
      <div class="span2">


      
    <?php echo $form->labelEx($model,'no_orden'); ?>
    <?php echo $form->textField($model,'no_orden'); ?>
    <?php echo $form->error($model,'no_orden'); ?>
    
    
      </div>
      <div class="span2">

        
     
      	
      </div>
        <div class="span2">

        		
      	
      </div>
        <div class="span2">

        
        	<div class="desactivados">
              <?php echo $form->labelEx($model,'no_oficio_solicitud'); ?>
            <?php echo $form->textField($model,'no_oficio_solicitud',array('size'=>60,'maxlength'=>60)); ?>
            <?php echo $form->error($model,'no_oficio_solicitud'); ?>
            <?php echo $form->labelEx($model,'municipio'); ?>
            <?php echo $form->textField($model,'municipio'); ?>
            <?php echo $form->error($model,'municipio'); ?>
            <?php echo $form->labelEx($model,'departamento'); ?>
            <?php echo $form->textField($model,'departamento'); ?>
            <?php echo $form->error($model,'departamento'); ?>
            <?php echo $form->labelEx($model,'id_usuario_crea'); ?>
            <?php echo $form->textField($model,'id_usuario_crea'); ?>
            <?php echo $form->error($model,'id_usuario_crea'); ?>
            <?php echo $form->labelEx($model,'sexo'); ?>
            <?php echo $form->textField($model,'sexo'); ?>
            <?php echo $form->error($model,'sexo');   ?>
            <?php echo $form->labelEx($model,'no_registro'); ?>
            <?php echo $form->textField($model,'no_registro'); ?>
            <?php echo $form->error($model,'no_registro'); ?>
            
        	</div>
      </div>
      <div class="span2">
      </div>
        <div class="span2">
      	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Guardar',array('class' => 'btn btn-large btn-primary' )); ?>
      </div>
    </div>

  </div>
</div>

  
      	


<?php $this->endWidget(); ?>
