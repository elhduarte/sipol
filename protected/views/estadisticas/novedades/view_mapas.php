

<?php 
 /**
* Autor:Lester Hazael Gudiel Villamar
* Mapas: Bitzel Enrique Cortez Sic, bitzel30@gmail.com
* Lugar: Ministerio de Gobernacion Guatemala, Guatemala
* Fecha: 02-08-2013
* Correo: mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com
* Site: www.lgudiel.com
*/
/*
echo "Estado Es =".$_POST['estado'];
echo "<br>";
//echo "Tipo Es =".$_POST['tipo'];
echo "<br>";
echo "Departamento Es =".$_POST['departamento'];
echo "<br>";
echo "Municipio Es =".$_POST['municipio'];
echo "<br>";
echo "Tipo de Grafica Es =".$_POST['graficatipo'];
echo "<br>";
echo "El evento  Es =".$_POST['evento'];
echo "<br>";
echo "El Tiempo =".$_POST['tiempo'];
echo "<br>";
echo "La Comisaria =".$_POST['comisaria'];
*/
?>
<link rel="stylesheet" type="text/css" src = "/base/js/openlayers/theme/default/style.css"/>
<script type = "text/javascript" src = "/base/js/openlayers/OpenLayers.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/mapaingreso.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>

<style type="text/css" media="screen">                      
    .map { width:620px; height:500px;}
    .map img { max-width:none; }
    .ui-dialog  { z-index: 5000; border-radius: 15px;}
</style>


<div class="row-fluid">
  <div class="span12">
    <legend>Vista de Mapas</legend>
    <div id ='map' class='map span12'>
  </div>
</div>
<div id="dialog_info">
</div>


 
 <?php 


 echo '';

  ?>     
<script type="text/javascript">
  $(document).ready(function() {

  $("#map").get(0).scrollIntoView();

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
        layers: [
      new OpenLayers.Layer.WMS( "Plan IGN",
                  "http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?",
                  {layers: 'plan', format: 'image/png',
                  transparent: "TRUE"
                  },
                  {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
                  encodeBBOX:false,projection:'EPSG:900913'},
                  {tileSize:new OpenLayers.Size(256,256)})
    ,
      new OpenLayers.Layer.OSM("OpenStreetMap", 
                  null, { //Layer OSM
                  transitionEffect: 'resize'
                  })
     
            ]
    });

  
  var novedades_layer = new OpenLayers.Layer.WMS( "pnc_novedades:novedades_charts",
  "http://192.168.0.218/geoserver/wms?",
  {layers: 'pnc_novedades:novedades_charts', format: 'image/png',
  transparent: "TRUE"
  },
  {isBaseLayer: false, alpha: true,singleTile: true, visibility: true, displayInLayerSwitcher: true,
  encodeBBOX:false,projection:'EPSG:900913'});

  map.addControl(new OpenLayers.Control.Navigation());
  map.addControl(new OpenLayers.Control.MousePosition());
  map.addControl(new OpenLayers.Control.ScaleLine());
 // map.addControl(new OpenLayers.Control.PanZoomBar());
  map.setCenter(new OpenLayers.LonLat(-90.5, 16).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 7);
  map.addLayer(novedades_layer);



var control_feature=new OpenLayers.Control.WMSGetFeatureInfo(
      {url:"http://192.168.0.218/geoserver/wms?",
      queryVisible:true,
      vendorParams:{format:"image/png",
      request:"GetFeatureInfo"
      }
      });

      control_feature.events.register("getfeatureinfo",this,show);
      map.addControl(control_feature);
      control_feature.activate();

  function show(evt){

      var match=evt.text.match(/<body>([\s\S]*)<\/body>/);
      var html;
      if(match&&!match[1].match(/^\s*$/))
      {
      $( "#dialog_info" ).dialog({
      //autoOpen: false,
      width: '600',
      height: '250',
      show: {
      effect: "fold",
      duration: 300
      },
      hide: {
      effect: "fold",
      duration: 300
      }
      });
      $("#dialog_info").empty();
      $("#dialog_info").append(evt.text);
      $('#dialog_info li').accordion({
      heightStyle: "content",
      autoHeight: false ,
      create: function() {
        $(this).css("top", 5);
      }
      });
      $( "#dialog_info" ).dialog( "open" );
      }
  
  }


function format_fecha(f_fecha)
{
    var mm = f_fecha.getMonth() + 1;
    mm = (mm < 10) ? '0' + mm : mm;
    var dd = f_fecha.getDate();
    dd = (dd < 10) ? '0' + dd : dd;
    var yyyy = f_fecha.getFullYear();
  f_fecha =  mm + '/' + dd + '/' + yyyy;
  return f_fecha;
}

function agregaCapa(text,evt){
     //$( "#effect" ).removeClass( "first_class", 1200 ,agregaCapa_aux(text,evt));
   //alert(1);
     $("#effect").show(1500);
   agregaCapa_aux(text,evt);
}

function toggleDate() 
{


var Evento = '<?php echo $_POST['tiempo']; ?>';

var State = '<?php echo $_POST['estado']; ?>';
var Depto = '<?php echo $_POST['departamento']; ?>';
var Mupio = '<?php echo $_POST['municipio']; ?>';


    var f_ini,f_fin;
    var CQL ="";
        switch(Evento)
        {
        case '1'://hoy

          f_ini= format_fecha(new Date());
          f_fin= format_fecha(new Date());
           CQL = "fecha >= '" + f_ini + "' and fecha <= '" + f_fin + "'";
           
          break;
        case '2'://ayer
          var aux_date = new Date();
          aux_date.setDate(aux_date.getDate()-1);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
           CQL = "fecha >= '" + f_ini + "' and fecha <= '" + f_fin + "'";
           
          break;
        case '3'://una semana
          var aux_date = new Date();
          aux_date.setDate(aux_date.getDate()-7);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
          CQL = "fecha >= '" + f_ini + "' and fecha <= '" + f_fin + "'";
          
          break;
        case '4'://dos semanas
          var aux_date = new Date();
          aux_date.setDate(aux_date.getDate()-14);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
           CQL = "fecha >= '" + f_ini + "' and fecha <= '" + f_fin + "'";
          break;
        case '5'://un mes
          var aux_date = new Date();
          aux_date.setMonth(aux_date.getMonth()-1);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
          CQL = "fecha >= '" + f_ini + "' and fecha <= '" + f_fin + "'";
          break;
        default://hoy
          f_ini= format_fecha(new Date());
          f_fin= format_fecha(new Date());
          CQL = "fecha >= '" + f_ini + "' and fecha <= '" + f_fin + "'";
          break;
        }

        switch(State)
        {
        case "confirmado"://confirmados
           CQL = CQL.concat(" AND estado = 'true' ");
          break;
        case "pendiente"://no confirmados
          CQL =  CQL.concat(" AND estado = 'false' ");
          break;
        default://Todos
          break;
        }

       switch(Depto)
        {
        case "Todos"://confirmados
          break;
           default://Todos
          CQL =  CQL.concat('AND id_departamento='+Depto);
          break;
        }

        switch(Mupio)
        {
        case ""://confirmados
         break;
        default://Todos
          CQL =  CQL.concat('AND id_municipio = '+Mupio); 
          break;
        }


          //console.log(CQL);
         
          map.getLayersByName('pnc_novedades:novedades_charts')[0].mergeNewParams({
          'cql_filter': CQL},{
          singleTile: true
          });
          map.getLayersByName('pnc_novedades:novedades_charts')[0].redraw(true);

}





toggleDate();
});
</script>






  
 
 
