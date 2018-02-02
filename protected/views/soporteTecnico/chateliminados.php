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
<div class="cuerpo">
<?php 
if(isset($_GET['par']))
{

	try {

	 $valor = $_GET['par'];
	 $decrypt = new Encrypter;			
	$valor = $decrypt->descompilarget($valor);
	$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario = $variable_datos_usuario[0]->id_usuario;

		echo "<h3>Chat de Soporte Numero: ".$valor."</h3>";
	$trasladoconversacion="";
$sql = "SELECT  a.*, b.primer_nombre || ' ' ||  b.primer_apellido as usuario
		FROM 
		soporte_aplicaciones.tbl_detalle_ticket_delete as a, sipol_usuario.tbl_usuario as b
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


      <legend style="margin-bottom: 0px;"></legend>  
    <div class="row-fluid">   
	  <div class="span12">
	  	<h5 style="font-size: 12px;">Conversación:</h5>

	  		<?php echo $trasladoconversacion; ?>

	  </div>
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
