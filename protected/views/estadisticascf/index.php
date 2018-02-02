
<?php 
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$comisaria = $variable_datos_usuario[0]->nombre_entidad;

$nombre_completo  = $variable_datos_usuario[0]->nombre_completo;
?>
<style type="text/css" media="screen">
 .jumbotron {
        margin: 2% 0;
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
<div class="cuerpo">
	

<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span10 offset1">
        <div class="jumbotron">
	        <h2>Información General <?php echo $comisaria; ?> </h2>
	        <p style="font-size: 16px;">Bienvenido Comisario <?php echo $nombre_completo; ?>, Puede elegir el metodo de analisis para la toma de decisiones.
			</p>
 		</div>
<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span3">
      <center>
     
      <a href="index.php?r=Estadisticas/nuevodashboard"><img src="images/dashoards.jpg" alt="" style="height: auto; max-width: 50%;"></a>
      <p style="padding-top: 7%;"><h4>Tablero</h4></p>
      </center>
      </div>
      <div class="span3">
          <center>
      <a href="index.php?r=Estadisticas/sedes"><img src="images/estadistica.jpg" alt="" style="height: auto; max-width: 50%; padding-top: 3%;"></a>
       <p style="padding-top: 9%;"><h4>Estadisticas</h4></p>
       </center>
      </div>
        <div class="span3">
            <center>
        <a href="index.php?r=Estadisticas/Mapacomisaria"><img src="images/mapa.jpg" alt="" style="height: auto; max-width: 50%;"></a>
        <p style="padding-top: 4%;"> <h4>Mapa</h4></p>
         </center>
      </div>
        <div class="span3">
            <center>
        <a href="index.php?r=Estadisticas/noticias"><img src="images/noticias.jpg" alt="" style="height: auto; max-width: 50%;"></a>
        <p style="padding-top: 11%;"> <h4>Noticias</h4></p>
         </center>
      </div>
    </div>
  </div>
</div>
      </div>
    
    </div>
  </div>
</div>
