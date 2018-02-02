
<!doctype html>
<html lang="es">
<head>
  <meta name="viewport" content="charset=utf-8, width=device-width, initial-scale=1.0">

   <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<div style="background:url(images/header_little.png) top repeat-x">
		<img src="images/logo_mingob.png" alt="">
</div>
<link href="lib/textrich/index.css" rel="stylesheet">
<script src="lib/js/jquery-1.10.2.min.js"></script>
<script src="lib/js/jquery.timer.js"></script>
<script src="lib/textrich/bootstrap-wysiwyg.js"></script> 
<style type="text/css">
	.usuario{
		color:black;
	}
	.usuarioroot{
		color:blue;
	}
	.hora{
		color:black;
	}
	.mensaje{
		color:black;
	}
	.chaticono{
		height: auto;
		max-width: 100%;
	}
	.inputvalor{
		display: none;
	}
</style>
	<title>Chat Soporte Tecnico</title>
</head>
<body>

<?php 
if(isset($_GET['par']))
{



	try {


 $valor = $_GET['par'];
	 $decrypt = new Encrypter;			
	$valor = $decrypt->descompilarget($valor);	
	$id_usuario = 306;
	echo '<input style="display: none;" type="text" name="get" id="get" value="'.$valor.'">';
	echo '<input style="display: none;" type="text" name="usuarioget" id="usuarioget" value="'.$id_usuario.'">';
	

	$trasladoconversacion="";
$sql = "SELECT  a.*, b.primer_nombre || ' ' ||  b.primer_apellido as usuario
		FROM 
		soporte_aplicaciones.tbl_detalle_ticket as a, sipol_usuario.tbl_usuario as b
		WHERE 
		a.id_ticket = ".$valor." 
		and
		b.id_usuario = a.id_usuario
		order by a.id_detalle_ticket asc"; 
$resultado = Yii::app()->db->createCommand($sql)->queryAll();

if(count($resultado) == 0)
{

	echo '<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4>Informacion!</h4>
  Chat Terminado...
</div>';

}else{


		foreach($resultado as $key => $value)
			{
				$conversacion = json_encode($value);
				$conversacion = json_decode($conversacion);
				$hora_atencion = explode(".", $conversacion->hora_atencion);
				//$trasladoconversacion = $trasladoconversacion."<strong class='usuario'>".utf8_decode($conversacion->usuario).": </strong>"."<span class='hora'>".$hora_atencion[0]." Horas</span>"."<br>"."<span class='mensaje'>Mensaje:  ".$conversacion->seguimiento."</span>"."<br>";	
				$chatusuariocolor ="<strong class='usuario'>".$conversacion->usuario.": </strong>";
				$trasladoconversacion = $trasladoconversacion.'<blockquote>
		  <small><cite title="Source Title">'.$chatusuariocolor.'</cite></small>
		  <small><cite title="Source Title"><strong class="hora">'.$hora_atencion[0].'</strong>  '.$conversacion->seguimiento.'</cite></small>
		</blockquote>';
			}


		

 ?>
	<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
  
      <div class="span12">
       <h2><strong>Ministerio De Gobernación -PNC</strong><br></h2>

 <h4><img style ="padding-right:9px; padding-bottom: 7px;" src="images/icons/glyphicons_169_phone.png">Teléfono: <b>30249817</h4></b>
 <h4><img style ="padding-right:9px; padding-bottom: 7px;" src="images/icons/glyphicons_127_message_flag.png">Correo: <b>soportesipol@pnc.gob.gt</h4></b>
<legend>
<small><cite title="24 Horas"><strong>Disponible 24 Horas</strong></cite></small>
      </div>
    </div>

      <legend style="margin-bottom: 0px;"></legend>  
    <div class="row-fluid">   
	  <div class="span12">
	  	<h5 style="font-size: 12px;">Conversación:</h5>
	  	<div id="editor" style="margin-bottom:1%;">
	  		<?php echo $trasladoconversacion; ?>
	  	</div>
	  </div>
	</div>
<form action="" id="insertarsolicitud">
	<div class="row-fluid">
		  <div class="span10">
		  	<input type="text" class="span12"  required name="mensajeenviar" id="mensajeenviar">
		  </div>
		  <div class="span2">
		  	<button class="btn btn-primary"  type="submit">enviar</button>
		  </div>
	</div>
</form>
<div style="text-align:right"  >
	  <button class="btn  btn-danger" id="terminarchatticket" type="button">Terminar Chat</button>
	
</div>

  </div>
</div>


<?php


}//fin del else 

	} catch (Exception $e) {

		echo '<div class="alert alert-info">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <h4>Informacion!</h4>
			  Chat Terminado...
			</div>';
		
	}//fin del try antes del if de get
		
}//fin del get de validacion
?>

	</div>
</body>
</html>

<script>
	$(document).ready(function(){
		var numero = 510000;
			var numeroingremento = 510000; 
			var total= 0;

		$('#insertarsolicitud').submit(function(){
				var idticket = $('#get').val();
				var idusuario = $('#usuarioget').val();
				var inconveniente = $('#mensajeenviar').val();
			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("soporteTecnico/insertarmensaje"); ?>',
				data:{idticket:idticket,idusuario:idusuario,inconveniente:inconveniente},
				beforeSend:function()
				{
					//var editor = $('#editor').html();
					//$('#editor').html('cargando chat <br>'+ editor);
			total= numero + numeroingremento;
			$("#editor").scrollTop(total);

				},
				success:function(response)
				{
					total= numero + numeroingremento;
					$('#editor').html('');	
					$('#editor').html(response); 
					$('#mensajeenviar').val('');
					$("#editor").scrollTop(total);					
				
				},
			});//fin del ajax
			return false;


		});


		$('#terminarchatticket').click(function(){
				var idticket = $('#get').val();
				var idusuario = $('#usuarioget').val();
			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("soporteTecnico/terminarchat"); ?>',
				data:{idticket:idticket,idusuario:idusuario},
				beforeSend:function()
				{

				},
				success:function(response)
				{				
					window.close();
				},
			});//fin del ajax
			return false;


		});

		$.timer(5000, function(){
			var idticket = $('#get').val();
			var idusuario = $('#usuarioget').val();
			
			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("soporteTecnico/verchat"); ?>',
				data:{idticket:idticket,idusuario:idusuario},
				beforeSend:function()
				{
					//var editor = $('#editor').html();
					//$('#editor').html('cargando chat <br>'+ editor);	
					//$("#editor").scrollTop($("#editor").height());
					//$("#editor").scrollBottom();
					total= numero + numeroingremento;

					$("#editor").scrollTop(total);
			

				},
				success:function(response)
				{
					total= numero + numeroingremento;
					$('#editor').html('');	
					$('#editor').html(response); 
					//$("#editor").scrollTop($("#editor").height());
					//$("#editor").scrollTop(numero + 510000);
					$("#editor").scrollTop(total);
				},
			});//fin del ajax
		})
	});
	</script>
