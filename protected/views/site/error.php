<?php
/* @var $this SiteController */
/* @var $error array */
/*
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);*/
?>
<?php //echo $code; 
//$code
//echo "error en la base de datos";
?>
<div class="row-fluid">
  <div class="span12">
<center>
   <div class="jumbotron">
	        <h1>Mantenimiento en el Sistema</h1>
	        <p class="lead"> Estimado usuario en este momento el sistema esta en mantenimiento regrese pronto
			</p>
 		</div>
</center>
    <div class="row-fluid">
      <div class="span3">

      </div>
      <div class="span6">
          <center>
      			<img src="images/mantenimiento.png" alt="" style="height: auto; max-width: 30%;">
      			<br>
      				<br>
      			<button class="btn btn-large btn-primary" type="button">Reportar el Mantenimiento</button>
      			<br>
      				<br>
      				<br>
      				<br>
      				<br>
      				<br>
       	</center>
      </div>
        <div class="span3">
      </div>
    </div>
  </div>
</div>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>