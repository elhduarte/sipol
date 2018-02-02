<?php

	$ConstructorHechos = new ConstructorHechos;
	$idForm = $_POST['idForm'];

	$formulario = $ConstructorHechos->getCamposTipoIncidencia($idForm);
	//var_dump($formulario);

	if(!empty($formulario)){

?>

<div class="row-fluid">
	<?php echo $formulario; ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('.withchilds').change(function(){
			var id = this.id;
			var hijos = $('#'+id+' option:selected').attr('hijos');
			var idChild = id+'Child';
			var esRequerido = $('#'+id+' option:selected').attr('esrequerido');
			var nombreCampo = $('#'+id+' option:selected').attr('nombreCampo');
			var opcionotros = $('#'+id+' option:selected').attr('opcionotros');
			if(hijos == "true")
			{
				//('#'+id+'Child').remove();

				var atributos = $('#'+id+' option:selected').attr('mychilds');

				$.ajax({
					type:'POST',
					url:'<?php echo Yii::app()->createUrl("Incidencia/Build_childs"); ?>',
					data:{
						atributos:atributos,
						idChild:idChild,
						esRequerido:esRequerido,
						nombreCampo:nombreCampo,
						opcionotros:opcionotros
					},
					beforeSend:function(){
						$('#divSelChild').html('');
					},
					error:function(error){
						$('#divSelChild').html('');
						console.log(error);
					},
					success:function(selectChild){
						$('#divSelChild'+id).html(selectChild);
						//$('#elNuevo').html('');
						//$('#elNuevo').html(response);

						$('.opcionotros').change(function(){
						//alert('la clase');
							var value = $(this).val();
							var identificador = $(this).attr('id');
							var nombre = $(this).attr('nombre');
							var input = '<input type="text" class="span12" placeholder="Ingrese el dato" id="input'+identificador+'" opcion_otros="option_otros" nombre="'+nombre+'">';
							console.log(input);
							console.log(value);
							if(value == 'OTROS'){
								$(this).attr('omiso','true');
								$('#'+identificador).after(input);
							}
							else
							{
								$(this).removeAttr('omiso');
								$('#input'+identificador).remove();
							}
						});// Fin de la opción otros
					}
				});
			}
			else
			{
				$('#'+id+'Child').remove();	
			}
			//console.log(hijos);
					//obtener propiedades html lester gudiel
					/*var nuevo =  $(this).prop("selectedIndex");
					console.log($(this));
					var propiedades  = $(this).context[nuevo];
					var estado = propiedades.attributes[1].nodeValue;
					//console.log(propiedades.attributes[1].nodeValue);
					if(estado == "true")
					{
					alert('Quien es tu padre.');
					}*/
		});
		$('.opcionotros').change(function(){
						alert('la clase');
							var value = $(this).val();
							var identificador = $(this).attr('id');
							var nombre = $(this).attr('nombre');
							var input = '<input type="text" class="span12" placeholder="Ingrese el dato" id="input'+identificador+'" opcion_otros="option_otros" nombre="'+nombre+'">';
							console.log(input);
							console.log(value);
							if(value == 'OTROS'){
								$(this).attr('omiso','true');
								$('#'+identificador).after(input);
							}
							else
							{
								$(this).removeAttr('omiso');
								$('#input'+identificador).remove();
							}
						});// Fin de la opción otros

	});//Fin del ready
</script>
<?php 

	}//Fin del if general
	else{
		echo "empty";
	}
?>