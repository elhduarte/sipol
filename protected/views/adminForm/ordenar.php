<link href="lib/jqueryui/adminhechos/pagina.css" rel="stylesheet" type="text/css" media="all">

<?php 
	$ConstructorJson = new ConstructorJson;
	$params = json_decode($ConstructorJson->getTabla($modelo));
	$tabla = $params->tabla;
	$key = $params->key;
	$lista = $ConstructorJson->getCampos($idTabla,$tabla,$key);
?>


<ul id="lista" class="ui-sortable">
	<?php echo $lista; ?>
</ul>
	<script src="lib/jqueryui/adminhechos/1.7.1jquery.min.js"></script>
	<script src="lib/jqueryui/adminhechos/1.8.16jquery-ui.min.js"></script>
	<script>
		$(function()
		{
			var formulario = $('#formulario'), ordenando = false, lista = $('#lista'),
			elementos = lista.find('li');
				lista.sortable({
						update: function(event,ui)
						{
							var ordenPuntos = $(this).sortable('toArray').toString();
							var cont = parseInt(1);
							var query = "";
							$.each(ordenPuntos.split(','), function(){
							query = query + 'h'+cont+'='+this+',';
							cont = parseInt(cont) +1;
							});
							query = query +'&';
							var idTabla = $('#idCampoSave').val();
							var modelo = $('#nombreModeloSave').val();

							$.ajax({
								type:'POST',
								url:'<?php echo CController::createUrl("AdminForm/SortCampos"); ?>',
								data:{
									query:query,
									idTabla:idTabla,
									modelo:modelo
								},
								beforeSend:function()
								{


								},
								success:function(response)
								{	
									console.log(response);
									refreshCatalogo();			

								},
							});//fin del ajax
					}
				});
			lista.sortable('enable');
		});
	</script>