<<<<<<< HEAD
<select id="querys">
	<option value="SELECT ce.descripcion_evento as Tipo_evento, e.direccion->>'Departamento' as Depto, e.direccion->>'Municipio' as Mupio 
		FROM sipol.tbl_evento e, sipol_catalogos.cat_tipo_evento ce
		WHERE e.direccion IS NOT NULL
		AND e.direccion->>'Departamento' ilike '%guate%' 
		/*AND e.id_tipo_evento = 1*/
		AND e.id_tipo_evento = ce.id_tipo_evento ">Primero</option>
		<option value="SELECT ce.descripcion_evento as Tipo_evento, e.direccion->>'Departamento' as Depto, e.direccion->>'Municipio' as Mupio 
		FROM sipol.tbl_evento e, sipol_catalogos.cat_tipo_evento ce
		WHERE e.direccion IS NOT NULL
		AND e.direccion->>'Departamento' ilike '%guate%' 
		/*AND e.id_tipo_evento = 1*/
		AND e.id_tipo_evento = ce.id_tipo_evento ">segundo</option>
</select>
<form class="cuerpo" id="executeQuery">
	<div class="horizontal-form">
		<label class="campotit2">Ingrese una consulta</label>
		<textarea class="span12" placeholder="query" rows="6" id="queryCon"></textarea>
	</div>
	<div class="controls">
		<button type="submit" class="btn btn-primary">Execute</button>
	</div>
</form>
<div id="resultadoConsulta"></div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#querys').change(function(e){
			//alert('ola');
			 $('#queryCon').val($('#querys').val());
		

		});
		
		$('#executeQuery').submit(function(e){
			e.preventDefault();
			var sql = $('#queryCon').val();

			$.ajax({
				type:'POST',
				url:"<?php echo Yii::app()->createUrl('Correo/sqlProcesar'); ?>",
				data:{
					sql:sql
				},
				beforeSend:function(){
					$('#resultadoConsulta').html('');
					$('#resultadoConsulta').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>');
				},
				error:function(){
					$('#resultadoConsulta').html('<h4>Ocurrió un error para procesar la consulta, por favor verifique la sintaxis...</h4>');
				},
				success:function(e){
					$('#resultadoConsulta').html('');
					$('#resultadoConsulta').html(e);
				}
			});//Fin del ajax
		});

	}); //Fin del ready
</script>

<?php 

$commando = Yii::app()->db->createCommand();

$sql = "SELECT ce.descripcion_evento as Tipo_evento, e.direccion->>'Departamento' as Depto, e.direccion->>'Municipio' as Mupio 
		FROM sipol.tbl_evento e, sipol_catalogos.cat_tipo_evento ce
		WHERE e.direccion IS NOT NULL
		AND e.direccion->>'Departamento' ilike '%guate%' 
		/*AND e.id_tipo_evento = 1*/
		AND e.id_tipo_evento = ce.id_tipo_evento ";

$resultado = Yii::app()->db->createCommand($sql)->queryAll();

//var_dump($resultado);

?>
=======
<div class="cuerpo">

<?php

	$commando = Yii::app()->db->createCommand();
	$sql = " select direccion->>'Referencia' AS departamento from sipol.tbl_evento 
where 
direccion IS NOT NULL
AND direccion->>'Municipio' = 'Mixco';";

	$resultado = Yii::app()->db->createCommand($sql)->queryAll();


	var_dump($resultado);

?>

</div>
>>>>>>> a827091081ed2e84b6be6584a46354eef69cab5a
