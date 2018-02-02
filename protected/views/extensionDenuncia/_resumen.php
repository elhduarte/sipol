

<div align="right" style="margin-top:2%">
	<button class="btn btn-primary" type="submit" id="confirmarExtension" target="_blank" disabled>Confirmar Ampliación</button>
</div>



 <script type="text/javascript">
	$(document).ready(function(){


		$('#iconEditHechos').click(function(){
			$('#tab5').hide(500);
			$('#tab3').show(500);
			$('#nav_denuncia li:eq(2) a').tab('show');
		});

		$('#iconEditRelato').click(function(){
			$('#tab5').hide(500);
			$('#tab4').show(500);
			$('#nav_denuncia li:eq(3) a').tab('show');
		});

		$.fn.actualizaResumen = function()
		{
			
		}


		$('#confirmarExtension').click(function(){
			var id_denuncia = $('#identificador_denuncia').val();

			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("Reportespdf/extensionGet"); ?>',
				data:{idEvento:id_denuncia},
				beforeSend:function()
				{
					$('#result_procesoModal').html('');
					$('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
					$('#procesoModal').modal('show'); 

				},
				success:function(response)
				{
					window.open(response,'_blank');
					window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
				},
			});//fin del ajax
		});//fin del click del botón extravio

		$('#cancelarExtravio').click(function(){


			$('#result_procesoModal').html('');
			$('#result_procesoModal').html('<div class=\"modal-body\">'+
					'<h4>¿Está seguro que desea descartar esta Ampliación De Denuncia?</h4></div><div class=\"modal-footer\">'+
					'<button id=\"descarta\" class=\"btn\">Descartar</button>'+
					'<button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Cancelar</button></div>'
			);


			$('#descarta').click(function(){
				window.location.replace('<?php echo CController::createUrl("Denuncia/Selector"); ?>');
			});

		});//fin del click del botón extravio


	});//Fin del ready
	
</script>

