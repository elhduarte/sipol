<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />

<?php 
	//$value = 4;
	$value = $_POST['hechos_dw'];


	$ConstructorHechos = new ConstructorHechos;
		$consumoVehiculos = "";

	if($value == 2)
	{
		$consumoVehiculos = $ConstructorHechos->consumoVehiculos();
		echo $consumoVehiculos;
	}

	$nombreHecho = $ConstructorHechos->nombreHechoCon($value); //Obtiene el nombre del hecho de la DB
	$formulario = $ConstructorHechos->obtenerCamposCon($value); //Obtiene el formulario ya construído de la base de datos
	
	$form_id = "frmHecho".$value;
	//echo "acá se construyen los hechos, el id que se está generando es: ".$value." y éste es: ".$nombreHecho;
?>

<div style="margin-bottom:1%;">
	<legend style="line-height: 60px;"><?php echo $nombreHecho; ?>
		<div class="form-inline pull-right">
			<div class="row-fluid">
				<div class="span6">
					<label for="fecha_hecho_ob" class="campotit" style="margin-right:10px;">Fecha</label>
					<input class="span8" type="text" value=""  id="fecha_hecho_ob" required>
					<i class="icon-calendar" style="margin: 6px 0 0 -26px; pointer-events: none; position: relative;"></i>
				</div>
				<div class="span6 bootstrap-timepicker">
					<label for="hora_hecho_ob" class="campotit" style="margin-right:10px; margin-left:20px;">Hora</label>
					<!-- <div class="bootstrap-timepicker">-->
						<input id="hora_hecho_ob" type="text" value="" class="bootstrap-timepicker span8" placeholder="Hora del Evento" required>
						<i class="icon-time" style="margin: 6px 0 0 -26px; pointer-events: none; position: relative;"></i>
					<!-- </div> -->
				</div>
			</div>
		</div>
	</legend>
	<div id="tipo_con">
		<div class="row-fluid">
			<?php
				echo $formulario;
			?>
		</div>
	</div><!-- Fin del hecho Construído -->
		<div id="resultPersonaJ" style="margin-top:3%;" hidden></div>
		<div id="resultPersonaJListado" class="well well-small" style="margin-top:3%; display:none;">acá van las personas listadas</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

		$('#fecha_hecho_ob').datepicker({
	
		   weekStart: 0,
		    endDate: "setStartDate",
		    format: "dd/mm/yyyy",
		    language: "es",
		    orientation: "top auto",
		    keyboardNavigation: false,
		    forceParse: false,
		    autoclose: true
	});

	//$('#hora_hecho_ob').timepicker();

	   $('#hora_hecho_ob').timepicker({
                //minuteStep: 1,
                //secondStep: 5,
                showInputs: false,
                //template: 'modal',
                modalBackdrop: true,
               // showSeconds: true,
                showMeridian: false
            });



	$('#motivo_dw').change(function(){
	$("#save_button").removeAttr("disabled");
	idmotivo = $('#motivo_dw').val();

		$.ajax({
				type:'POST',
				url: <?php echo "'".CController::createUrl('Consignacion/Construye_motivo')."'"; ?>,
				data:
				{
				idMotivo:idmotivo
				},
				beforeSend:function()
				{
					$('#resultadoSelect2').html('');
					$('#resultadoSelect2').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
				error:function()
				{
					$('#resultadoSelect2').html('');
					$('#resultadoSelect2').html('Ha ocurrido un error, su petición no puede ser procesada');
				},
				success:function(respuesta)
				{
				$('#resultadoSelect2').html('');
				$('#resultadoSelect2').html(respuesta);                                                      

				}

		});
	});// fin de funcion construye motivo 

	$('.addPersonaJuridica').click(function(){
		var personaJ = $(this).attr('personaJ');
		var pcontact = $(this).attr('pcontact');
		var pcaract = $(this).attr('pcaract');
		var idEvento = $('#identificador_incidencia').val();
		//alert('Estás en la clase de addPersonaJuridica '+personaJ);

		$.ajax({
			type:'POST',
			url:'<?php echo Yii::app()->createUrl("Pjuridica/AddPersonI"); ?>',
			data:
			{
				personaJuridica: personaJ,
				pintaCaracteristicas: pcontact,
				pintaContacto: pcaract,
				idEvento:idEvento
			},
			beforeSend:function()
			{
				$('#resultPersonaJ').html('');
				$('#resultPersonaJ').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				$('#resultPersonaJ').show(500);
			},
			success:function(resultado)
			{
				$('#resultPersonaJ').html('');
				$('#resultPersonaJ').html(resultado);
			}
		});
	});	//Fin clase addPersonaJuridica
}); //Fin del document Ready
</script>
<div align="center" class="form-horizontal well" style="margin-bottom: 0px;">
<?php
$valor = $_POST['hechos_dw'];
 ?>
<span class="campotit"> Motivo de la Consignación </span>
<select class ="span6" name="motivo_dw" id="motivo_dw">
<?php 
		$Criteria = new CDbCriteria();
		$Criteria->condition = "id_cat_consignados=".$valor;
        $data=CatMotivoConsignados::model()->findAll($Criteria);
        $data=CHtml::listData($data,'id_motivo_consignados','nombre_motivo_consignados');
        $contador = '0';
        	   echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione una Opción'),true);
           foreach($data as $value=>$name)
           {
           echo '<option value="'.$value.'">'.$name.'</option>';
          }    
?>
    </select>
</div>


