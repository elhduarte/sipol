
<meta http-equiv="refresh" content="120;URL=./index.php?r=cTBoleta/Mnovedades" >
<?php

setlocale(LC_TIME, 'spanish');
$afecha = strftime("   %A %#d de %B del %Y",time()-21600);
$afecha=(string)$afecha ;
$fecha=  utf8_encode ($afecha);
$hora = date("h:i A",time()-21600);
$model = new mTBoleta;

$arraysale = $model->dataresumen();
#var_dump($arraysale);

$homicidios_resul  = 0;
$lesionados_resul  = 0;
$homicidios_html = ""; 
$lesionados_html="";
$detenidos_resul =0;
$detenidos_html ="";


foreach ($arraysale as $key => $value) 
{
	# code...
	//print_r($value);
	$entrar = json_encode($value);
	$entrar = json_decode($entrar);
	//echo $entrar->id_evento;
	//echo $entrar->tipo;	
	//echo $entrar->cantidad;	
	//echo ordenar($entrar->id_evento,$entrar->cantidad,$entrar->tipo);
	$id = $entrar->id_evento;
		
	
	$cantidad = $entrar->cantidad;
	
	if ($id=='32' or $id=='33' or $id=='34') 
	{
		# code...
		$titulo = str_replace("HOMICIDIOS POR", "", $entrar->tipo);
		$imagen = str_replace(" ","",$entrar->tipo );
		//echo "<br>";
		$homicidios_resul = $homicidios_resul + $cantidad;
		$homicidios_html = $homicidios_html. '<div>
						<img class="imagen_novedades" style = "height: auto; max-width: 15%;"  src="images/novedades/'.$imagen.'.png" ><span class="nove_cant">'.$cantidad.'</span>
						<span class="nove_desc">'.$titulo.'</span>
					</div>';



	}elseif ($id=='43' or $id=='44' or $id=='45') {
		# code...
		//echo trim($entrar->tipo);
		$titulo = str_replace("LESIONADOS POR", "", $entrar->tipo);
		$imagen = str_replace(" ","",$entrar->tipo );
		//echo $imagen."<br>";
		#echo $imagen;
		$lesionados_resul = $lesionados_resul + $cantidad;
		
			$lesionados_html = $lesionados_html. '<div>
						<img class="imagen_novedades" style = "height: auto; max-width: 15%;" src="images/novedades/'.$imagen.'.png" ><span class="nove_cant">'.$cantidad.'</span>
						<span class="nove_desc">'.$titulo.'</span>
					</div>';
	}else{
		
		$titulo = str_replace("DETENIDOS POR", "", $entrar->tipo);
		$imagen = str_replace(" ","",$entrar->tipo);
		$detenidos_resul = $detenidos_resul + $cantidad;
		
			$detenidos_html = $detenidos_html. '<div>
						<img class="imagen_novedades" style = "height: auto; max-width: 15%;" src="images/novedades/'.$imagen.'.png" ><span class="nove_cant">'.$cantidad.'</span>
						<span class="nove_desc">'.$titulo.'</span>
					</div>';
		# code...
	}

	


	
	//echo $entrar->tipo;
	//echo "<br>";
}


/*
$tipo = $arraysale['tipo'];
$cantidad = $arraysale['cantidad'];
$contador = 0;
//$nuevoArray = array();
//print_r($tipo);

$codificar = json_encode($arraysale);
$codifcador = json_decode($codificar);
//echo $codifcador;
print_r($codifcador->cantidad);
echo "<br>";
$contenido = "";

foreach ($codifcador->cantidad as $key => $value) 
{
	# code...

		$contenido  = $contenido.'<div class="well well-small">
					<legend>Detenidos
						<div class="pull-right">
							<span class="badge badge-info"><?php echo $detenidos; ?></span>
						</div>
					</legend>
					<div>
						<img class="imagen_novedades" src="images/novedades/lesion_fuegoHom.png" ><span class="nove_cant"><?php echo $lesion_fuegoHom; ?></span>
						<span class="nove_desc">Masculino</span>
					</div>
				
				</div>';



}

*/


//print_r($codificar->tipo);


/*
foreach ($tipo as $t) 
{
	echo $t."~".$cantidad[$contador]."<br>";
	$nuevoArray[$contador] =  $t."~".$cantidad[$contador];
	$contador = $contador+1;
}*/
//print_r($nuevoArray);


$det="16";
$duelo_hom="7";
$duelo_fem="0";
$duelo_blanca="0";
$lesion_fuegoHom="4";
$lesion_fuegoFem="0";
$lesion_blanca="2";

$detenidos = $det;
$homicidios = $duelo_hom+$duelo_fem+$duelo_blanca;
$lesionados = $lesion_fuegoHom+$lesion_fuegoFem+$lesion_blanca;

?>
<div align="center" style="margin-bottom:1%;">
	<h3 style="margin-bottom:0px;">Renumen Novedades PNC</h3>
</div>

<div id="informe">
	


<div class="row-fluid">
	<div class=" span12">
		<div class="row-fluid">
			<div class="span4 well well-small">
				<div class="well well-small">
					<legend>Detenidos
						<div class="pull-right">
							<span class="badge badge-info"><h4><?php echo  $detenidos_resul; ?></h4></span>
						</div>
					</legend>

					<?php echo $detenidos_html; ?>
					

				</div>

				<div class="well well-small">
					<legend>Homicidios
						<div class="pull-right">
							<span class="badge badge-info"><h4><?php echo $homicidios_resul; ?></h4></span>
						</div>
					</legend>
					<?php echo $homicidios_html; ?>
				
					
					
				</div>
					<div class="well well-small">
						<legend>Lesionados
							<div class="pull-right">
								<span class="badge badge-info "><h4><?php echo  $lesionados_resul; ?></h4></span>
							</div>
						</legend>
					<?php echo $lesionados_html; ?>				
				</div>
				



		
			</div>
			<div class="span8 well">
				<div class="pull-right"><span class="comentario-fit"><?php echo $fecha.", ".$hora; ?></span></div>
				<div class="map" id="map"></div>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	
$(document).ready(function(){
 $("#informe").get(0).scrollIntoView();


});

</script>































<script type="text/javascript">

$(document).ready(function(){

 
/*********MAPAS**********/
var getLayers = function() {

	   var plan = new OpenLayers.Layer.WMS( "Plan",
 "http://192.168.0.218/geoserver/gwc/service/wms?",
 {layers: 'plan', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
	   encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});

	   var hybrid = new OpenLayers.Layer.WMS( "Foto Aerea",
 "http://192.168.0.218/geoserver/gwc/service/wms?",
 {layers: 'hybrid', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
	   encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});

   var zonas = new OpenLayers.Layer.WMS( "Referencias",
 "http://192.168.0.218/geoserver/wms?",
 {layers: 'fondo:zonas,fondo:colonias', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: false, alpha: true, visibility: true, displayInLayerSwitcher: false});
	  
var desplie_pnc = new OpenLayers.Layer.WMS( "Despliegue PNC",
 "http://192.168.0.218/geoserver/wms?",
 {layers: 'segu_fuerzas_seguridad:despliegue_pnc',
 format: 'image/png',
 transparent: "TRUE"
      },
  {isBaseLayer: false, alpha: true, visibility: true, singleTile: false, displayInLayerSwitcher: true,
	   encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});

	  
novedades_hoy = new OpenLayers.Layer.WMS( "Novedades Mapeadas Hoy",
 "http://192.168.0.218/geoserver/wms?",
 {layers: 'pnc_novedades:resumen_diario_novedades',
 format: 'image/png',
 transparent: "TRUE"
      },
  {isBaseLayer: false, alpha: true, visibility: true, singleTile: true, displayInLayerSwitcher: false,
	   encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});


        return [plan,hybrid,zonas,novedades_hoy];
    };

 map = new OpenLayers.Map({
		div: "map",
		"projection": new OpenLayers.Projection('EPSG:900913'),
		"displayProjection": new OpenLayers.Projection('EPSG:4326'),
		"units": "m",
		"maxExtent": new OpenLayers.Bounds(
		-128 * 156543.0339,
		-128 * 156543.0339,
		128 * 156543.0339,
		128 * 156543.0339
		),
		"allOverlays": false
    });

	//map.addLayers(getLayers());
	map.addControl(new OpenLayers.Control.LayerSwitcher());
	map.addControl(new OpenLayers.Control.MousePosition());
	map.addControl(new OpenLayers.Control.ScaleLine());
	//map.setCenter(new OpenLayers.LonLat(-10068367, 1709717), 8);
	map.setCenter(new OpenLayers.LonLat(-90.5, 15.9).transform(
new OpenLayers.Projection("EPSG:4326"),
map.getProjectionObject()
), 8);

}); //Fin del ready


</script>
