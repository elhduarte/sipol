
<?php 
$estadistica = new Estadisticas;

$id_entidad ="";
if(isset($_POST['id_entidad']))$id_entidad = $_POST['id_entidad'];


$_SESSION['ID_ENTIDAD_E'] = $id_entidad;
$nombre = $estadistica->getEntidad($id_entidad);

$comisaria = $nombre[0]['nombre_entidad'];

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
<div class="">
	

<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span10 offset1">
    
<div class="row-fluid">
  <div class="span12">
         <legend>Información Sobre: <?php echo $comisaria;?></legend>
    <div class="row-fluid">
      <div class="span3">
      <center>

      <a href="index.php?r=Estadisticascf/nuevodashboard"><img class ="disabled" src="images/dashoards.jpg" alt="" style="height: auto; max-width: 50%;"></a>
      <p style="padding-top: 7%;"><h4>Tablero</h4></p>
      </center>
      </div>
      <div class="span3">
          <center>
      <a href="index.php?r=Estadisticascf/sedes"><img src="images/estadistica.jpg" alt="" style="height: auto; max-width: 50%; padding-top: 3%;"></a>
       <p style="padding-top: 9%;"><h4>Estadisticas</h4></p>
       </center>
      </div>
        <div class="span3">
            <center>
        <a href="index.php?r=Estadisticascf/Mapacomisaria"><img src="images/mapa.jpg" alt="" style="height: auto; max-width: 50%;"></a>
        <p style="padding-top: 4%;"> <h4>Mapa</h4></p>
         </center>
      </div>
        <div class="span3">
            <center>
        <a href="index.php?r=Estadisticascf/noticias"><img src="images/noticias.jpg" alt="" style="height: auto; max-width: 50%;"></a>
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


