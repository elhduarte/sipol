




<div class="cuerpo">

<div class="row-fluid">
  <div class="span12">
<legend><img src="images/icons/glyphicons_127_message_flag.png" alt=""> Listado de Sugerencias</legend> 

<div class="row-fluid">
      <div class="span12">   
    	<?php 
		
			
	$sql = "select a.id_sugerencia, b.usuario, a.fecha_ingreso, a.sugerencia, a.url_sugerencia, a.id_usuario, a.hora_ingreso
 from
  soporte_aplicaciones.tbl_sugerencia a,
	sipol_usuario.tbl_usuario b
	where a.id_usuario = b.id_usuario
 order by fecha_ingreso  desc, hora_ingreso desc";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($resultado)== 0)
		{
					echo '<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<h4>Información!</h4>
					No se tienen Sugerencias en el Sistema...
					</div>';
		}else{


		foreach($resultado as $key => $value)
			{
				$conversacion = json_encode($value);
				$conversacion = json_decode($conversacion);

?>


<div class="row-fluid ">
  <div class="span12 cuerpo">
    <div class="row-fluid">
      <div class="span3">
      	<b>Numero Sugerencia: </b> <?php echo $conversacion->id_sugerencia;?>
      </div>
      <div class="span3">
      	<b>Fecha Ingreso: </b><?php echo  $conversacion->fecha_ingreso;?>
      </div>
      <div class="span3">
      	<b>Hora Ingreso: </b><?php echo  $conversacion->hora_ingreso;?>
      </div>
      <div class="span3">
      	<b>Ver Usuario: <?php echo $conversacion->usuario; ?></b>  <a href="index.php?r=tblUsuario/view&id=<?php echo $conversacion->id_usuario; ?>" target="_blank"><i class="icon-eye-open"></i></a>
      </div>
    </div>

     <div class="row-fluid">
      <div class="span12 well">
      	<b>Texto Sugerencia:</b> 
      	<br>
      	<?php echo  $conversacion->sugerencia;?> 

      </div>
    </div>
  
      <div class="row-fluid">
      <div class="span12">
      	<b>Url de Sugerencia: </b> <?php echo  $conversacion->url_sugerencia;?>     	
      </div>
    </div>
  </div>
</div>


	


<?php
	}

	}//fin del contador de sugerencias
 ?>


      </div>
    </div>
  </div>
</div>



<?php echo "
<script>
	function mi_funcion(nuevo)
	{
			var idticket = nuevo;
				var idusuario = $('#usuarioget').val();

		
		$.ajax({
				type:'POST',
				url:'index.php?r=soporteTecnico/terminarchat',
				data:{idticket:idticket,idusuario:idusuario},
				beforeSend:function()
				{

				},
				success:function(response)
				{				
					location.reload();
				},
			});//fin del ajax
			return false;



	}
	


	</script>";;



 ?>
</div>