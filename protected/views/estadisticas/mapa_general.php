<?php
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$id_cat_entidad = $variable_datos_usuario[0]->id_cat_entidad;

  $tiposede = '';
  $tipoevento = '';
  $sedes ='';
  $tiempo =0;
  $comisaria = $id_cat_entidad;


if(isset($_POST['tipoevento']))$tipoevento = $_POST['tipoevento'];
if(isset($_POST['tiposede']))$tiposede = $_POST['tiposede'];
if(isset($_POST['sedes']))$sedes = $_POST['sedes'];
if(isset($_POST['tiempo']))$tiempo = $_POST['tiempo'];
if(isset($_POST['comisaria']))$comisaria = $_POST['comisaria'];
  
  /*
$comisaria= 2;
$sedes= 34;
$tiempo= 5;
$tipoevento = 1;
$tiposede =  2;
*/
switch ($tiempo) {
case '0':
$subqueryfecha = " AND e.fecha_ingreso  = ('now'::text::date)";
$textotiempo="Hoy";
//e.fecha_ingreso BETWEEN 'now'::text::date -60 AND 'now'::text::date
break;
case '1':
$subqueryfecha = "AND e.fecha_ingreso  = ('now'::text::date)";
$textotiempo="Hoy";
//e.fecha_ingreso BETWEEN 'now'::text::date -60 AND 'now'::text::date
break;
case '2':
$subqueryfecha = "AND e.fecha_ingreso  BETWEEN 'now'::text::date -1 AND 'now'::text::date";
$textotiempo=" Ayer y  Hoy";
//e.fecha_ingreso BETWEEN 'now'::text::date -60 AND 'now'::text::date
break;
case '3':
$subqueryfecha = "AND e.fecha_ingreso  BETWEEN 'now'::text::date -7 AND 'now'::text::date";
$textotiempo=" Hoy y 1 Semana Atras";
break;

case '5':
$subqueryfecha = "AND e.fecha_ingreso  BETWEEN 'now'::text::date -30 AND 'now'::text::date";
$textotiempo=" Hoy y 1 Mes Atras";
break;

default:
$subqueryfecha =  "AND e.fecha_ingreso  = ('now'::text::date)";
$textotiempo="Hoy";
break;
}

if($tipoevento =='')
{
  $subquerytipoevento = '';
}else
{
  $subquerytipoevento= "and e.id_tipo_evento = ".$tipoevento." ";
}

if($tiposede =='' || $tiposede =='00')
{
  $subquerytiposede = '';
}else
{
  $subquerytiposede= "and ts.id_tipo_sede = ".$tiposede." ";
}
if($sedes =='' || $sedes=='00')
{
  $subquerysedes = '';
}else
{
  $subquerysedes= "and ts.id_sede = ".$sedes." ";
}

$sql="SELECT  cd.id_cat_denuncia, POINT(st_transform(e.the_geom,4326)) as punto ,  e.fecha_ingreso, cd.nombre_denuncia,e.relato,dep.departamento,mupio.municipio
FROM sipol.tbl_evento_detalle ed
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
INNER JOIN catalogos_publicos.cat_departamentos dep ON e.id_depto = dep.cod_depto
INNER JOIN catalogos_publicos.cat_municipios mupio ON e.id_mupio = mupio.cod_mupio
where e.estado = 't'
".$subqueryfecha."
".$subquerytipoevento."
and ed.atributos IS NOT NULL
and e.the_geom IS NOT NULL
and ts.id_cat_entidad = ".$comisaria."
".$subquerytiposede."
ORDER BY 3 DESC";
//echo $sql;
$resultado = Yii::app()->db->createCommand($sql)->queryAll();
$resultadomapa = "";

foreach ($resultado as $key => $value) {
$puntonuevo = str_replace("(", "", $value['punto']);
$puntonuevo = str_replace(")", "",  $puntonuevo);
$puntoarray =array();
$puntoarray = explode(",", $puntonuevo);


$nuevarelato =htmlspecialchars(strip_tags($value["relato"]));





$relatos =$value["relato"];

          $relatos= str_replace("'", '"', $relatos);
          $relatos = str_replace("\n", "<br>", $relatos);
          $relatos=nl2br ($relatos);
          $relatos=mb_convert_case($relatos, MB_CASE_UPPER, "UTF-8");
          $relatos= str_replace("&NBSP;", '', $relatos);
          //echo '|'.str_pad($relatos, 20, ' ')."|\n"; 
          $relatos = str_replace('"','', $relatos);
          $relatos = strip_tags($relatos);

          $resultadomapa .='

          popupContentHTML ="<h5>Nombre del Evento: '.$value["nombre_denuncia"].'</h5><br><strong>Fecha Registrada: </strong> '.$value["fecha_ingreso"].'<br><strong>Departamento: </strong> '.$value["departamento"].'<br><strong>Municipio: </strong> '.$value["municipio"].'<center> <h5>RELATO REGISTRADO </h5></center> <p>'.$relatos.'</p><hr>";
                  feature = new OpenLayers.Feature.Vector(
                    new OpenLayers.Geometry.Point( '.$puntoarray[0].', '.$puntoarray[1].' ).transform("EPSG:4326", "EPSG:3857"),
                    {
                      description: popupContentHTML
                    }
                  );
                  vector.addFeatures(feature);';
          }



$querydos="SELECT 
 te.descripcion_evento as nombre, count(e.id_evento) 
FROM 
sipol.tbl_evento_detalle ed 
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento 
INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia 
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede 
INNER JOIN sipol_catalogos.cat_tipo_evento te ON e.id_tipo_evento = te.id_tipo_evento
where e.estado = 't'
".$subqueryfecha."

".$subquerytipoevento."
and ed.atributos IS NOT NULL
and e.the_geom IS NOT NULL
and ts.id_cat_entidad = ".$comisaria."
".$subquerytiposede."
GROUP BY  te.descripcion_evento ORDER BY 1 DESC
";

//echo $querydos;
$resultadodos = Yii::app()->db->createCommand($querydos)->queryAll();

$salidagrafica ="[";

            foreach ($resultadodos as $key => $value) {
              $salidagrafica .= " ['".$value['nombre']."',  ".$value['count']."],";
              }
$salidagrafica .= "]";

?>

<div class="cuerpo">

<?php 
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$nombre_entidad = $variable_datos_usuario[0]->nombre_entidad;
echo "<legend> Información ".$nombre_entidad." Rango de Fechas: ".$textotiempo."</legend>";
?>

<div class="row-fluid">
<div class="span8">
<h4>Estadistica Georeferenciada</h4>
<div style ="padding-bottom:2%;">

  <div id="radio" class="form-inline pull-right">
      <input style ="margin: 10px;" type="radio" id="radio1" name="radio" value="point" onclick="toggleControl(this);"checked="checked" />
<label title="Marcar Punto" for="radio1"><img width="10px" height="20px" src="images/icons/glyphicons_238_pin.png"/></label>
    <input style ="margin: 10px;" type="radio" id="radio2" name="radio" value="zoomin" onclick="toggleControl(this); " /><label title="Acercar Vista" for="radio2"><img width="20px" height="20px" src="images/icons/glyphicons_236_zoom_in.png"/></label>
    <input  style ="margin: 10px;" type="radio" id="radio3" name="radio" value="zoomout" onclick="toggleControl(this);" /><label title="Alejar Vista" for="radio3"><img width="20px" height="20px" src="images/icons/glyphicons_237_zoom_out.png"/></label>
    <input style ="margin: 10px;" type="radio" id="radio4" name="radio" value="navigation" onclick="toggleControl(this);" /><label title="Mover Mapa" for="radio4"><img width="20px" height="20px" src="images/icons/glyphicons_186_move.png"/></label>
  </div>
</div>

<div id ='map' class='map'></div>
<div id="dialog_info"></div>
</div>
<div class="span4">
<br>
<br>
<br>
  
  <h4>Información Punto Geográfico</h4>

  <br>
  <br>

<div id="descripcion"> 
  <blockquote>
  <p>Al hacer Click en el punto, usted podrá obtener la información relacionada con el evento seleccionado.</p>
</blockquote>


</div>

<div id="grafica"></div>
</div>
</div>
</div>
<script type="text/javascript">
var map;
 function toggleControl (element)
  {

  for(key in drawControls) {

      var control = drawControls[key];

      if(element.value == key && element.checked) {
        
        map.addControl(drawControls[key]);
        control.activate();

      } else {

        control.deactivate();

      }

  }
  
}


  drawControls = {
      
         zoomin: new OpenLayers.Control.ZoomBox({
                displayClass:'zoomInBoox',
                out: false
                }),
          zoomout: new OpenLayers.Control.ZoomBox({
                displayClass:'zoomOutBoox',
                out: true
                }),
          navigation: new OpenLayers.Control.Navigation()
  };





var map;
var fromProjection = new OpenLayers.Projection("EPSG:900913");      // Transformar from WGS 1984
        var toProjection = new OpenLayers.Projection("EPSG:4326");
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
      ],
        layers: [
        new OpenLayers.Layer.OSM("OpenStreetMap", null, { //Layer OSM
        transitionEffect: 'resize'
        })
     
            ]
    });
  var layer_switcher = new OpenLayers.Control.LayerSwitcher( );
 // map.addControl(layer_switcher);
  //layer_switcher.maximizeControl();
map.setCenter(new OpenLayers.LonLat(-90.5, 16).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 7);
//map.setCenter(new OpenLayers.LonLat(-90.507729, 14.643491).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 7);
      var vector = new OpenLayers.Layer.Vector("My Layer", {
        styleMap: new OpenLayers.StyleMap({
          externalGraphic: 'images/flag.png',
          graphicWidth: 20, graphicHeight: 24, graphicYOffset: -24,
          title: '${tooltip}'
        })
      });
      map.addLayer(vector);
      var controls = {
        selector: new OpenLayers.Control.SelectFeature(vector, {
            onSelect: createPopup,
            onUnselect: destroyPopup
          }
        )
      };
      map.addControl(controls.selector);
      controls.selector.activate();
      var popupContentHTML, feature;
        <?php
        echo $resultadomapa;
        ?>
      //The create popup function
      function createPopup(feature) {
        $('#descripcion').html(feature.attributes.description);
      }
      
      function destroyPopup(feature) {
    
      }

/***********************************************************************************/

 function inicio ()
 {
  alert('en el inicio');
   for(var key in drawControls) 
          {
              
                    map.addControl(drawControls[key]);
                }
 }



$(document).ready(function() {


$(function () {

    // Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });

    // Build the chart
    $('#grafica').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Sedes Relacionadas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje Relacionado',
            data: <?php echo $salidagrafica; ?>
        }]
    });
});


});
</script>











