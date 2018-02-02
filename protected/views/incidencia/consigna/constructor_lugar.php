
<?php 
	//$value = 4;
	$value = $_POST['id_lugar_con'];
	$ConstructorHechos = new ConstructorHechos;
	$nombreHecho = $ConstructorHechos->nombreHechoLu($value); //Obtiene el nombre del hecho de la DB
	$formulario = $ConstructorHechos->obtenerCamposLu($value); //Obtiene el formulario ya construído de la base de datos
	
	$form_id = "frmHecho".$value;
	//echo "acá se construyen los hechos, el id que se está generando es: ".$value." y éste es: ".$nombreHecho;
?>


<div style="margin-bottom:0px;">
	<legend style="line-height: 60px;"><?php echo $nombreHecho; ?>
		
	</legend>
	<div id="lugar_cona">
		
		<div class="row-fluid">
			<?php
				echo $formulario;
			?>
		</div>
	</div><!-- Fin del hecho Construído -->

</div>


<script type="text/javascript">
$(document).ready(function(){
	
	$.fn.MostrarHechos = function(valor)
	{
		//alert(valor);
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("Incidencia/Mostrar_hechos"); ?>',
			data: {id_evento:valor,},
			success: function(divs)
			{
				$('#hechos_resumen_well').show(500);
				$('#hechos_resumen').html('');
				$('#hechos_resumen').html(divs);

				$(".eliminar_hecho").click(function(){
					var id_eliminar = $(this).attr('id_evento_detalle');
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<div class=\"modal-body\">'+
						'<h4>¿Está seguro que desea eliminar éste hecho?</h4></div><div class=\"modal-footer\">'+
						'<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button>'+
						'<button id=\"confirmaEliminar\" class=\"btn btn-primary\" id_eliminar=\"'+id_eliminar+'\">Confirmar</button>'
						);
					$('#procesoModal').modal('show');

					$('#confirmaEliminar').click(function(){
						var id_eliminar = $(this).attr('id_eliminar');
						$.ajax({
						type:'POST',
						url:'<?php echo Yii::app()->createUrl("Extravio/Eliminar_hecho"); ?>',
						data:{id_eliminar: id_eliminar,},
						beforeSend: function()
						{
							$('#result_procesoModal').html('');
							$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');

						},
						success:function()
						{
							$('#procesoModal').modal('hide');
							$('#procesoModal').actualizaResumen();
								$('#hechoDiv'+id_eliminar).remove();
							//$('#result_procesoModal').html('');
							//$('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Hecho se eliminó correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
						},
						});
					});
				});//click de función de eliminar el hecho
				$(".eliminar_hecho").tooltip({title:"Eliminar éste Hecho"});
			},//fin del success
		});//fin del ajax
	}//fin de la función MostrarHechos
}); //Fin del document Ready



</script>

