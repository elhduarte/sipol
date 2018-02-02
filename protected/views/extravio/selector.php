

<legend class="legend">Tipo de Evento</legend>
<p class="comentario" font-size="6px">Seleccione el tipo de Evento a registrar</p>

<div class = "row-fluid">

	<div class = "span2 offset4" style = "text-align:center; padding:1%;">
		<a href="<?php echo Yii::app()->createUrl('denuncia/index'); ?>">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/denuncia.png"/>
		</a>  
	</div>
	<div class = "span2" style = "text-align:center; padding:1%;">
		<a href="<?php echo Yii::app()->createUrl('incidencia/index'); ?>">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/incidencia.png"/>
		</a>  
	</div>

</div><!--Fin del Row-Fluid -->