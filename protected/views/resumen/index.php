

<!DOCTYPE html>
<html>
  <head>
    <title>Resumen Global</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->

    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false">
</script>
    

  </head>
  <body>
    <style type="text/css">
     .map img 
    { 
        max-width:none;
    }

    .map
    {
        height:700px;
    }
</style>





<div class="row-fluid">
  <div class="span12">
    Fluid 12
    <div class="row-fluid">
      <div class="span10">
       <div class="map" id="map"></div>
       
      </div>
      <div class="span2">

         <div  id="caja"></div>
      </div>
    </div>
  </div>
</div>















    
    <script src="lib/bootstrap/js/jquery.js"></script>
    <script src="lib/js/jquery.timer.js"></script>
     <script type = "text/javascript" src = "/base/js/openlayers/OpenLayers.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>



  </body>




  



  <script type="text/javascript">
  
$(document).ready(function(){


/*********MAPAS**********/
var getLayers = function() {



    /* var hybrid = new OpenLayers.Layer.WMS( "Foto Aerea",
 "http://192.168.0.218/geoserver/gwc/service/wms?",
 {layers: 'hybrid', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
     encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});
*/
   /*var zonas = new OpenLayers.Layer.WMS( "Referencias",
 "http://192.168.0.218/geoserver/wms?",
 {layers: 'fondo:zonas,fondo:colonias', format: 'image/png',
                 transparent: "TRUE"
      },
      {isBaseLayer: false, alpha: true, visibility: true, displayInLayerSwitcher: false});*/
  /*  
var desplie_pnc = new OpenLayers.Layer.WMS( "Despliegue PNC",
 "http://192.168.0.218/geoserver/wms?",
 {layers: 'segu_fuerzas_seguridad:despliegue_pnc',
 format: 'image/png',
 transparent: "TRUE"
      },
  {isBaseLayer: false, alpha: true, visibility: true, singleTile: false, displayInLayerSwitcher: true,
     encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});*/

    


resumendenuncia = new OpenLayers.Layer.WMS( "Denuncias","http://sistemas.mingob.gob.gt/geoserver/sipol_desa/wms?",
 {layers: 'sipol_desa:mapa_resumen_denuncia',
 format: 'image/png',
 transparent: "true"
      },
  {isBaseLayer: false, alpha: true, visibility: true, singleTile: true, displayInLayerSwitcher: false,
     encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});


zonas = new OpenLayers.Layer.WMS( "zonas","http://sistemas.mingob.gob.gt/geoserver/fondo/wms?",
 {layers: 'fondo:zonas',
 format: 'image/png',
 transparent: "true"
      },
  {isBaseLayer: false, alpha: true, visibility: true, singleTile: true, displayInLayerSwitcher: false,
     encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});


despliegue_pnc = new OpenLayers.Layer.WMS( "pnc","http://sistemas.mingob.gob.gt/geoserver/sipol_desa/wms?",
 {layers: 'sipol_desa:sipol_despliegue_pnc',
 format: 'image/png',
 transparent: "true"
      },
  {isBaseLayer: false, alpha: true, visibility: true, singleTile: true, displayInLayerSwitcher: false,
     encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});



openstreamp = new OpenLayers.Layer.OSM("OpenStreetMap", null, { //Layer OSM
        transitionEffect: 'resize'
        });
var hybrid = new OpenLayers.Layer.Google(
                  "Google Hybrid",
                  {type: google.maps.MapTypeId.HYBRID,numZoomLevels: 20}
                  );
            var satellite = new OpenLayers.Layer.Google(
                  "Google satellite",
                  {type: google.maps.MapTypeId.SATELLITE,numZoomLevels: 20}
                  );
            var roadmap = new OpenLayers.Layer.Google(
                  "Google RoadMap",
                  {type: google.maps.MapTypeId.ROADMAP,numZoomLevels: 20}
                  );
            var terrain = new OpenLayers.Layer.Google(
                  "Google Terrain",
                  {type: google.maps.MapTypeId.TERRAIN,numZoomLevels: 20}
                  );


        //return [plan,hybrid,zonas,novedades_hoy];
        return [openstreamp,despliegue_pnc,resumendenuncia];
    };//fin del get layer con las funciones de las capas.

      var highlight = new OpenLayers.Layer.Vector("Highlighted Features", {
            displayInLayerSwitcher: false, 
            isBaseLayer: false 
        });



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

  map.addLayers(getLayers());
  //map.addControl(new OpenLayers.Control.LayerSwitcher());
 map.addControl(new OpenLayers.Control.MousePosition());
  //map.addControl(new OpenLayers.Control.ScaleLine());
   //map.addLayer(highlight);
  //map.setCenter(new OpenLayers.LonLat(-10068367, 1709717), 8);
  map.setCenter(new OpenLayers.LonLat(-90.5, 15.9).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 8);
  var contador = 0;


  $.timer(5000, function(){

    $("#caja").append(contador + '-');

    //map.zoomToExtent(bounds_map);
   // map.setCenter(new OpenLayers.LonLat(-90.55503, 14.63050).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 17);
    contador = contador +1;
    //alert('hola mundo');
      /*var idticket = $('#get').val();
      var idusuario = $('#usuarioget').val();*/
      
      /*$.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("SoporteTecnico/VerChat"); ?>',
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
      });//fin del ajax*/
    });




 
});

</script>
  


</html>
