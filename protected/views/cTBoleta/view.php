<style type="text/css" media="screen">                      

    .map { width:620px; height:500px;}
    .map img { max-width:none; }
</style>

<div class="row-fluid">
  <div class="span12">
    <legend>Resumen Novedad </legend>
    <div class="row-fluid">
   <div class="span6 well">
<?php $id_boleta = $model->id_boleta;?>
     
<legend> Boleta No. <?php echo $id_boleta;?></legend>

<input style ="display:none;" type="text" value =' <?php echo $model->puntomapa($id_boleta);?>' name="geom" id="geom">
<?php

$arraysale = $model->dataresumen();
//print_r($arraysale);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model->detnove($id_boleta),
	 'attributes'=>array(
	    array('name'=>'comisaria', 'label'=>'Comisaria'),
	    array('name'=>'fecha', 'label'=>'Fecha'),
	    array('name'=>'hora', 'label'=>'Hora Del Hecho'),
      array(
        'name'=>'Detalle:',
        'header'=>'Detalle',                  
        'value'=>htmlspecialchars_decode($model->detalle),
        'type'=>'html',
            ), 
	    array('name'=>'departamento', 'label'=>'Departamento'),
	    array('name'=>'municipio', 'label'=>'Municipio'),
	    array('name'=>'usuario', 'label'=>'Usuario'),
    ),

)); ?>
  <?php $this->widget('bootstrap.widgets.TbGridView', array(
  'dataProvider'=>$model->eventoresumen($id_boleta),
   'columns'=>array(
    array('name'=>'evento', 'header'=>'Nombre del Evento'),
    array('name'=>'cantidad', 'header'=>'Cantidad'),)
));?>
</div>
      <div id="mapvisualizacion" class="map span6 well">
        
      </div>
    </div>
    
  </div>
</div>

<div class="row-fluid">
  <div class="span6">

  </div>
  <div align="right" class="span6 ">
    <hr></hr>
  <button id ="regresa" class="btn btn-large" type="button">Regresar </button> 
  <button id = "envia" class="btn btn-large btn-primary" type="button">Cambiar Estado</button>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-body">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4>La Boleta: <?php echo $id_boleta;?>
      Se Cambió Con Éxito</h4>
  </div>
  <div class="modal-footer">
    <button id = "aceptamodal" class="btn" data-dismiss="modal" aria-hidden="true">Aceptar</button>
    
  </div>
</div>


<script type="text/javascript">


$(document).ready(function(){

          $('#regresa').click(function(){
          var parametro = 'vacio';
          var  url= "<?php echo Yii::app()->createUrl('cTBoleta/Vconsulta'); ?>";   
          $(location).attr('href',url);
          });

          $('#envia').click(function(){
         var id_boleta = '<?php echo $id_boleta;?>';

       $.ajax({
       type: 'POST',
       url: '<?php echo Yii::app()->createUrl("cTBoleta/actualizaestado"); ?>',
       data:
       {        
               id_boleta:id_boleta
       },
       beforeSend: function(response)
       {
               //alert('beforeSend');       

       },
       success: function(response)
       {
         $('#myModal').modal('show'); 
         $('#aceptamodal').click(function(){
                var  url= "<?php echo Yii::app()->createUrl('cTBoleta/Vconsulta'); ?>";   
         $(location).attr('href',url);

         });
   
       },
    });
      return false;
    });
          
          


});
var vectorLayervisu,optionsvisu;




function deserializevisu(wkt) {
          
          	var element =  document.getElementById('wktvisu');
          	var temporal_hugardo = $('#geom').val();
            var features = new OpenLayers.Format.WKT('EPSG:900913').read(temporal_hugardo);

            if(features) {
				map.addLayer(vectorLayervisu);
                vectorLayervisu.addFeatures(features);
                map.setCenter(new OpenLayers.LonLat(features.geometry.x,features.geometry.y), 9);

            } else {
                element.value = 'Bad input ';
            }
        }
		



 var styleDefault = OpenLayers.Util.applyDefaults({
        graphicName: 'square',
		//rotation: 45,
		pointRadius: 12,
        strokeColor: '#FF0000',
        fillColor: '#FFFF00'
    }, 

    OpenLayers.Feature.Vector.style['default']);

var getTbarItems = function(mapPanelvisu, layer) {

        var defaults = {
            enableToggle: true,
            toggleGroup: 'mode'
        };
	  
        return [];

    };



var getLayers = function() {

	
	   var plan = new OpenLayers.Layer.WMS( "Plan",
 "http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?",
 {layers: 'plan', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
	   encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});

	   var hybrid = new OpenLayers.Layer.WMS( "Foto Aerea",
 "http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?",
 {layers: 'hybrid', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
	   encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});

	var hojas = new OpenLayers.Layer.WMS( "Hojas Cartograficas IGN",
 "http://sistemas.mingob.gob.gt/geoserver/wms?",
 {layers: 'fondo:hojas_cartograficas_2012', format: 'image/jpeg',
                 transparent: "true"},
      {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
	   encodeBBOX:false,projection:'EPSG:900913'},{tileSize:new OpenLayers.Size(256,256)});

	  	  /* var zonas = new OpenLayers.Layer.WMS( "Zonas y Colonias",
 "http://sistemas.mingob.gob.gt/geoserver/wms?",
 {layers: 'fondo:zonas,fondo:colonias', format: 'image/png',
                 transparent: "TRUE"
      }, {isBaseLayer: false, alpha: true, visibility: true, displayInLayerSwitcher: false});
	  
	   var pnc = new OpenLayers.Layer.WMS( "PNC",
 "http://sistemas.mingob.gob.gt/geoserver/wms?",
 {layers: 'segu_fuerzas_seguridad:despliegue_pnc', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: false, alpha: true, visibility: true, displayInLayerSwitcher: true});
	  
        return [plan,hybrid,hojas,zonas,pnc];*/
         return [plan,hybrid,hojas];
    };
	

    var mapOptions = {
	     div: "mapvisualizacion",
        projection: new OpenLayers.Projection("EPSG:900913"),
            displayProjection: new OpenLayers.Projection("EPSG:4326"),
            units: "m",
			maxExtent: new OpenLayers.Bounds(
            -128 * 156543.0339,
            -128 * 156543.0339,
            128 * 156543.0339,
            128 * 156543.0339
        ),
		   resolutions:[/*156543.03390625,78271.516953125,39135.7584765625,19567.8792382813,9783.93961914063,9783.93961914063,4891.96980957031,*/2445.98490478516,1222.99245239258,611.496226196289,305.748113098145,152.874056549072,76.4370282745361,38.2185141372681,19.109257068634,9.55462853431702,4.77731426715851,2.38865713357925,1.19432856678963,0.597164283394815],
		allOverlays: false,
        theme: null, // or OpenLayers will attempt to load it default theme
        controls: [
            new OpenLayers.Control.Navigation(),
			new OpenLayers.Control.PanZoomBar(),
            new OpenLayers.Control.ScaleLine(),
			new OpenLayers.Control.MousePosition()
        ]
    };
    var map = new OpenLayers.Map(mapOptions);
	var layer_switcher = new OpenLayers.Control.LayerSwitcher();
	// map.addControl(layer_switcher);
     map.addLayers(getLayers());


			/******************EDICION****************/
	
	
	
    vectorLayervisu = new OpenLayers.Layer.Vector("vector", {
		displayInLayerSwitcher: false,
		styleMap: new OpenLayers.StyleMap({
            'default': styleDefault
        }),
        eventListeners: {
            beforefeatureadded: function(e) {
                var feature = e.feature;
                if (feature.fid == null) {
                    vectorLayervisu.destroyFeatures();
				}
            },
            beforefeatureselected: function(e) {
            },
            featureunselected: function(e) {
            }
        }
    });

    deserializevisu();


</script>
<?php
	
	$wkt=0;
	/*$query ="SELECT astext(the_geom) as wkt FROM dg_pnc_novedades.t_boleta Where id_boleta = ".$codigo_boleta.";";	
	$resultDetalle = pg_query($conn,$query);
	$rows = pg_num_rows($resultDetalle);	
	if($rows>0){		
		while ($row = pg_fetch_row($resultDetalle)) {				
			$wkt = $row[0];
		}
	}
	pg_free_result($resultDetalle);*/
	echo '<input type="hidden" value="'.$wkt.'" id="wktvisu" />';
	
	//echo '';
?>
