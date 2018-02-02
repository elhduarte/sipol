<?php 
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$comisaria = $variable_datos_usuario[0]->nombre_entidad;
$nombre_completo  = $variable_datos_usuario[0]->nombre_completo;

?>
<style type="text/css" media="screen">
 .jumbotron {
        margin: 0% 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 45px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }	

      .ipuntdiseno{
      	padding: 7px;
font-size: 17px;
      }
</style>
<?php 
	$idusuarioingresado = $variable_datos_usuario[0]->id_usuario;
								$descompilar = new Encrypter;
								$variableusuario = $descompilar->compilarget("'".$idusuarioingresado."'");	
?>

<div class="cuerpo">
<legend class="legend">Tipo de Evento</legend>
<p class="comentario" font-size="6px">Seleccione el tipo de Evento a registrar</p>
   <div class="jumbotron">
	        <p style="font-size: 16px;"><h4>Bienvenido, <?php echo $nombre_completo; ?><h5> <?php echo $variable_datos_usuario[0]->nombre_entidad.", ".$variable_datos_usuario[0]->nombre_sede; ?></h5></h4>
			<a id ="cambia" name="cambia" href='<?php echo CController::createUrl("TblUsuario/CambioSede&perfil=$variableusuario"); ?>'>Cambiar Sede</a>
			</p>
 		</div>
<div class = "row-fluid">
	<div class = "span2 offset5 sipolIconDiv">
		<a href="<?php echo Yii::app()->createUrl('denuncia/'); ?>">
			<img class="SipolIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/iconos/denuncia.png"/>
		</a>  
	</div>

</div><!--Fin del Row-Fluid -->

</div>
