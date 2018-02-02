
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Ejemplo Prueba</title>
        <link rel="stylesheet" type="text/css" src = "/base/js/openlayers/theme/default/style.css"/>

        <style type="text/css">
        /**
 * CSS Reset
 * From Blueprint reset.css
 * http://blueprintcss.googlecode.com
 */
html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, code, del, dfn, em, img, q, dl, dt, dd, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {margin:0;padding:0;border:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;}
body {line-height:1.5;}
table {border-collapse:separate;border-spacing:0;}
caption, th, td {text-align:left;font-weight:normal;}
table, td, th {vertical-align:middle;}
blockquote:before, blockquote:after, q:before, q:after {content:"";}
blockquote, q {quotes:"" "";}
a img {border:none;}

/**
 * Basic Typography
 */
body {
    font-family: "Lucida Grande", Verdana, Geneva, Lucida, Arial, Helvetica, sans-serif;
    font-size: 80%;
    color: #222;
    background: #fff;
    margin: 1em 1.5em;
}
pre, code {
    margin: 1.5em 0;
    white-space: pre;
}
pre, code {
    font: 1em 'andale mono', 'lucida console', monospace;
    line-height:1.5;
}
a[href] {
    color: #436976;
    background-color: transparent;
}
h1, h2, h3, h4, h5, h6 {
    color: #003a6b;
    background-color: transparent;
    font: 100% 'Lucida Grande', Verdana, Geneva, Lucida, Arial, Helvetica, sans-serif;
    margin: 0;
    padding-top: 0.5em;
}
h1 {
    font-size: 130%;
    margin-bottom: 0.5em;
    border-bottom: 1px solid #fcb100;
}
h2 {
    font-size: 120%;
    margin-bottom: 0.5em;
    border-bottom: 1px solid #aaa;
}
h3 {
    font-size: 110%;
    margin-bottom: 0.5em;
    text-decoration: underline;
}
h4 {
    font-size: 100%;
    font-weight: bold;
}
h5 {
    font-size: 100%;
    font-weight: bold;
}
h6 {
    font-size: 80%;
    font-weight: bold;
}

.olControlAttribution {
    bottom: 5px;
}

/**
 * Map Examples Specific
 */
.smallmap {
    width: 800px;
    height: 500px;
    border: 1px solid #ccc;
}
#tags {
    display: none;
}

#docs p {
    margin-bottom: 0.5em;
}
/* mobile specific */
@media only screen and (max-width: 600px) {
    body {
        height           : 100%;
        margin           : 0;
        padding          : 0;
        width            : 100%;
    }
    #map {
        background : #7391ad;
        width      : 100%;
    }
    #map {
        border : 0;
        height : 250px;
    }
    #title {
        font-size   : 1.3em;
        line-height : 2em;
        text-indent : 1em;
        margin      : 0;
        padding     : 0;
    }
    #docs {
        bottom     : 0;
        padding    : 1em;
    }
    #shortdesc {
        color      : #aaa;
        font-size  : 0.8em;
        padding    : 1em;
        text-align : right;
    }
    #tags {
        display : none;
    }
}
@media only screen and (orientation: landscape) and (max-width: 600px) {
    #shortdesc {
       float: right;
       width: 25%;
    }
    #map {
        width: 70%;
    }
    #docs {
        font-size: 12px;
    }
}
body {
    -webkit-text-size-adjust: none;
}

</style>
    </head>
    <body>
        <h1 id="title">Ejemplo de Prueba</h1>
 
        <div id="map" class="smallmap"></div>

        <script type = "text/javascript" src = "/base/js/openlayers/OpenLayers.js"></script>
        <script >
var map;
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
      "allOverlays": false,
        controls:[

      new OpenLayers.Control.Navigation({zoomWheelEnabled: false}),
      new OpenLayers.Control.PanZoom(),
    //  new OpenLayers.Control.EditingToolbar(vlayer)

      ],
        layers: [

         new OpenLayers.Layer.WMS( 'Plan IGN',
        'http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?',
        {layers: 'plan', format: 'image/png',
        transparent: "TRUE"
        },
        {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
        encodeBBOX:false,projection:'EPSG:900913'},
        {tileSize:new OpenLayers.Size(256,256)})
        ,
        

        new OpenLayers.Layer.OSM("OpenStreetMap", null, { //Layer OSM
        transitionEffect: 'resize'
        })
     
            ]
    });


  var sipol_layer = new OpenLayers.Layer.WMS( "denuncia_mapa",
  "http://sistemas.mingob.gob.gt/geoserver/sipol_desa/wms?",
  {layers: 'sipol_desa:sipol_despliegue_pnc', format: 'image/png',
  transparent: "TRUE"
  },
  {isBaseLayer: false, 
    alpha: true,
    singleTile: true, 
    visibility: true, 
    displayInLayerSwitcher: true,
  encodeBBOX:false,projection:'EPSG:900913'});







  var layer_switcher = new OpenLayers.Control.LayerSwitcher( );
  map.addControl(layer_switcher);
  layer_switcher.maximizeControl();

  map.setCenter(new OpenLayers.LonLat(-90.5, 16).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 7);
  
  map.addLayer(sipol_layer);

        </script>
    </body>
</html>