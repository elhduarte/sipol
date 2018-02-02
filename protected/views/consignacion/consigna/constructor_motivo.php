<?php 
	//$value = 4;
	$value = $_POST['idMotivo'];
	$ConstructorHechos = new ConstructorHechos;
	$nombreHecho = $ConstructorHechos->nombreHechoMo($value); //Obtiene el nombre del hecho de la DB
	$formulario = $ConstructorHechos->obtenerCamposMo($value); //Obtiene el formulario ya construído de la base de datos
	
	$form_id = "frmHecho".$value;
	//echo "acá se construyen los hechos, el id que se está generando es: ".$value." y éste es: ".$nombreHecho;
?>
	
<div style="margin-bottom:1%;">
	<legend style="line-height: 60px;"><?php echo $nombreHecho; ?></legend>
	<div id="motivo_con">
		
		<div class="row-fluid">
			<?php
				echo $formulario;
			?>
		</div>
	</div><!-- Fin del hecho Construído -->

</div>
<script type="text/javascript">
$(document).ready(function(){

$('#lugar_con').change(function(){
		$('#BotonesConsignacion').show(50);
		$("#save_button").removeAttr("disabled");
		id_lugar_con = $('#lugar_con').val();


		$.ajax({
			type:'POST',
			url: <?php echo "'".CController::createUrl('Consignacion/Construye_lugar')."'"; ?>,
			data:
			{
			id_lugar_con:id_lugar_con
			},
			beforeSend:function()
			{
				$('#resultadoSelect3').html('');
				$('#resultadoSelect3').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error:function()
			{
				$('#resultadoSelect3').html('');
				$('#resultadoSelect3').html('Ha ocurrido un error, su petición no puede ser procesada');
			},
			success:function(respuesta)
			{
			$('#resultadoSelect3').html('');
			$('#resultadoSelect3').html(respuesta);                                                      

			}

			});
		});
}); //Fin del document Ready

</script>
<div align="center" class="form-horizontal well" style="margin-bottom: 0px;">
	<span class="campotit"> Lugares De Consignación </span>
	<select class ="span6" name="lugar_con" id="lugar_con">
	<?php 
			$Criteria = new CDbCriteria();
			
	        $data=CatLugarRemision::model()->findAll($Criteria);
	        $data=CHtml::listData($data,'id_lugar_remision','nombre_lugar');
	        $contador = '0';
	   				echo'<option value="" style="display:none;" selected>Seleccione una Opción</option>';           
	           foreach($data as $value=>$name)
	           {
	        		echo '<option value="'.$value.'">'.$name.'</option>';
	          }    
	?>
	</select>
</div>