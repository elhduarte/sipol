<?php
	//echo "este es el index";
?>
<legend>Administrador de Catálogos</legend>
acá debería de ir un grid o un listado de los catálogos que hay...
<legend style="padding-top:2%;"></legend>
<div align="right">
	<?php
		echo CHtml::submitButton('Crear Nuevo', array(
		'submit'=>Yii::app()->controller->createUrl('adminForm/NuevoCatalogo') ,
		'class'=>'btn btn-primary'     // or simply      'submit'=>'mycontroller/myaction' 
		)); 
	?>
</div>


