<?php
$geoserver = 'https://sistemas.mingob.gob.gt/geoserver/';
?>
<div class="well">
<legend>Seleccione la Ubicación del Hecho</legend>
  <div class="row-fluid">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'geo',
    //type'=>'horizontal',
    'htmlOptions'=>array('name'=>'geo'),
    )); ?>


    <div class="span3">
      <p class="campotit">Departamento</p>
      <?php
               //$criterio = new CDbCriteria;
               $model = new CatDepartamentos;
                 echo $form->dropDownListRow($model,'cod_depto',
                  CHtml::listData(CatDepartamentos::model()->findAll(array('order'=>'departamento ASC')),'cod_depto','departamento'),
                    array(  'class'=>'span12',
              'required'=>'true',
              'maxlength'=>12,
              'id'=>'cmb_depto',
              'labelOptions'=>array('label'=>'',),
              'prompt'=>'Seleccione un Departamento',
              //'onChange'=>'actualizaMupio(this.value); mapZoom(this.value,"deptos");'
                        )
                    
                 );
            ?>
    </div>
    <div class="span3">
      <p class="campotit">Municipio</p>
      <?php
              $modelo = new CatMunicipios;
                $dropdown = $form->dropDownListRow($modelo,'cod_mupio',
                  array('0' => 'Seleccione un Municipio'),
                  array(
                    'class'=>'span12',
                    'labelOptions'=>array('label'=>'',), 
                    /*'id'=>'cmb_mupio',*/ 
                    'required'=>'true',
                    'maxlength'=>12,
                    'id'=>'cmb_mupio',
                    'name'=>'cmb_mupio',
                    'disabled'=>'true',
                    //'onChange'=>'mapZoom(this.value,"mupios");'
                    ));
                echo utf8_decode($dropdown);
            ?>
    </div>
    <div class="span3">
      <p class="campotit">Zona</p>
      <select name="zona" id="geo_zona" class="span12">
              <option value='' disabled selected style='display:none;'>Seleccione una Opcion</option>
              <option value="1">Zona 1</option>
              <option value="2">Zona 2</option>
              <option value="3">Zona 3</option>
              <option value="4">Zona 4</option>
              <option value="5">Zona 5</option>
              <option value="6">Zona 6</option>
              <option value="7">Zona 7</option>
              <option value="8">Zona 8</option>
              <option value="9">Zona 9</option>
              <option value="10">Zona 10</option>
              <option value="11">Zona 11</option>
              <option value="12">Zona 12</option>
              <option value="13">Zona 13</option>
              <option value="14">Zona 14</option>
              <option value="15">Zona 15</option>
              <option value="16">Zona 16</option>
              <option value="17">Zona 17</option>
              <option value="18">Zona 18</option>
              <option value="19">Zona 19</option>
              <option value="20">Zona 20</option>
              <option value="21">Zona 21</option>
              <option value="22">Zona 22</option>
              <option value="23">Zona 23</option>
              <option value="24">Zona 24</option>
              <option value="25">Zona 25</option>
          </select>
    </div>
    <div class="span3">
      <p class="campotit">Colonia</p>
      <input class="span12" type="text" id="geo_colonia">
    </div>
  </div>
  <div class="row-fluid">
    <div class="span6">
      <p class="campotit">Dirección</p>
      <input class="span12" type="text" id="geo_direccion">
    </div>
    <div class="span6">
      <p class="campotit">Referencia</p>
      <input class="span12" type="text" id="geo_referencia">
    </div>
  </div>
</div>
<div class="rowfluid">
  <input type="text" class="span12" id="outputWKTs" style="display:" readonly>
</div>
<?php $this->endWidget(); ?>

<!-- INICIO DE LA BUSQUEDA AVANZADA -->
<div class="well">
  <div id="advancedSearchHeader"> 
    <span class="tituloN">
      <i class="icon-plus onlyTitle" style="margin-top:0.3%; margin-right:1%" id="extendIcon" estado="max"></i>
      <span class="onlyTitle">Busqueda Avanzada</span>
      <div class="pull-right">
        <img src="images/info_icon.png"
        data-placement="left"
        id="ayuda_ad">
      </div>
    </span>
  </div>

    <div id="advancedSearchDetails" hidden>
      <legend style="margin-top:0.5%;"></legend>
      <div class="row-fluid">
      <div class="span6">
        <div class="row-fluid">
          <div class="span10" style="padding-top: 0.4%;">
            <input type="text" class="span12" placeholder="Palabra Clave" id="advanced_search">
          </div>
          <div class="span2">
            <button type="button" class="btn btn-info span12" id="btn_advanced_search">Buscar</button>
          </div>
        </div>
      </div>
      <div class="span6">
          <select id="select_resultado" data-placement="left" multiple="multiple" class="span12" size="9" 
          data-toggle="tooltip" data-content="Al seleccionar un elemento de la lista, el mapa se acercará para facilitar su busqueda..." 
          data-original-title="Seleccione un elemento" disabled style="margin-bottom: 3px;">
            <option value="">Realice una busqueda</option>
          </select>
          <div class="pull-right" id="contador_coincidencias" style="padding-right:5%;"></div>
      </div>
    </div> <!-- Fin del fluid -->
  </div><!--Fin del div advancedSearchDetails -->
</div>
<!-- FIN DE LA BUSQUEDA AVANZADA -->

<div id="map" class="map"></div>

<legend style="padding-top:1%;"></legend>
<div align="right">
  <button class="btn btn-primary" type="button" id="submitMapBtn">Guardar Ubicación</button>
</div>




<script type="text/javascript">

$(document).ready(function(){
    $('#ayuda_ad').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i>  AYUDA</legend><p style="line-height: 175%; text-align: justify;">Escriba el nombre de un poblado, caserío, colonia o calle y haga clic en el botón "Buscar" para acercar el mapa y hacer más simple marcar un punto</p><legend class="legend_tt"></legend><p style="line-height: 175%; text-align: justify;">Ejemplo: <p style="padding-left:10%; line-height: 100%; text-align: left;">- pachalum</p><p style="padding-left:10%; line-height: 100%; text-align: left;">- Los Olivos</p></p>'});
    $('#select_resultado').popover({
    html:'true',
    title:'este es el titulo',
    content:'contenido',
    show:'true',
    placement:'left',
    trigger:'manual'
  });

$('#advancedSearchHeader').click(function(){

  icono = $('#extendIcon').attr('estado');
  if(icono == 'max'){
    $('#extendIcon').removeClass('icon-plus');
    $('#extendIcon').addClass('icon-minus');
    $('#advancedSearchDetails').show(500);
    $('#extendIcon').attr('estado','min');
  }
  else if(icono == 'min'){
    $('#extendIcon').removeClass('icon-minus');
    $('#extendIcon').addClass('icon-plus');
    $('#advancedSearchDetails').hide(500);
    $('#extendIcon').attr('estado','max');
  }
}); //Fin función advancedSearchHeader

$('#submitMapBtn').click(function(){
  $('#geo').submit();
});

$('#advanced_search').keypress(function(e){
  if(e.which == 13) $('#btn_advanced_search').click();
});
  //$('#ayuda_ad').tooltip('show');
  var path_geo= "<?php echo $geoserver;?>"

/*   Customize de puntos                  */
     // style the sketch fancy
            var sketchSymbolizers = {
                "Point": {
                    pointRadius: 30,
                    graphicName: "square",
                    fillColor: "white",
                    fillOpacity: 1,
                    strokeWidth: 1,
                    strokeOpacity: 1,
                    strokeColor: "#333333",
          externalGraphic: 'images/icons/pin_point.png'
                },
                "Line": {
                    strokeWidth: 3,
                    strokeOpacity: 1,
                    strokeColor: "#666666",
                    strokeDashstyle: "dash"
                },
                "Polygon": {
                    strokeWidth: 2,
                    strokeOpacity: 1,
                    strokeColor: "#666666",
                    fillColor: "white",
                    fillOpacity: 0.3
                }
            };
  var style = new OpenLayers.Style();
  style.addRules([
  new OpenLayers.Rule({symbolizer: sketchSymbolizers})
  ]);
  var styleMap = new OpenLayers.StyleMap({"default": style});

  var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
  renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;

/*   Customize de puntos                  */

 var pointLayer = new OpenLayers.Layer.Vector(
  "Capa Hecho",
  {
    preFeatureInsert: function(feature){
        pointLayer.removeFeatures(pointLayer.features);
        var wkt = new OpenLayers.Format.WKT();
      var out = wkt.write(feature);
      var depto = $("#cmb_depto").val();

        },
        layers: 'basic'
  },
  {
    displayInLayerSwitcher: false
  }
  );

 var   limites = new OpenLayers.Layer.WMS( "Limites Administrativos",
            path_geo+"gwc/service/wms?",
            {layers: 'fondo:limites_admin',
            format: 'image/png',
            transparent: "TRUE"
            },
            {isBaseLayer: false,
            visibility: true,
            encodeBBOX:false,
            projection:'EPSG:900913',
            displayInLayerSwitcher: false
            });
var zonas = new OpenLayers.Layer.WMS( "Zonas y Colonias",path_geo+"wms?",{
                                                                             layers: 'fondo:zonas,fondo:colonias',
                                                                              format: 'image/png',
                               transparent: "TRUE"
                                               },
                                               {
                                                               isBaseLayer: false,
                                                               alpha: true,
                                                               visibility: true,
                                                               displayInLayerSwitcher: false
                                               }
                               );

 vlayer = new OpenLayers.Layer.Vector( "Editable" );
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
        new OpenLayers.Control.Attribution(),
      ],
      layers: 
      [new OpenLayers.Layer.OSM("OpenStreetMap", null, { //Layer OSM
        transitionEffect: 'resize'
        }),
        new OpenLayers.Layer.WMS( "Plan IGN",
        path_geo+"gwc/service/wms?",
        {layers: 'plan', format: 'image/png',
        transparent: "TRUE"
        },
        {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
        encodeBBOX:false,projection:'EPSG:900913'},
        {tileSize:new OpenLayers.Size(256,256)})
        ,
        new OpenLayers.Layer.WMS( "Fotos Aereas IGN",
        path_geo+"gwc/service/wms?",
        {layers: 'hybrid', format: 'image/png',
        transparent: "TRUE"
        },
        {numZoomLevels: 20,isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
        encodeBBOX:false,projection:'EPSG:900913'},
        {tileSize:new OpenLayers.Size(256,256)})
        ,
        new OpenLayers.Layer.WMS("Hojas Cartograficas IGN",
        "https://sistemas.mingob.gob.gt/cgibin/mapserv?map=/home/wms/hojas_carto2012.map",
        {layers:'hojas_cartograficas_2012',
        format:'image/jpeg',
        transparent: "FALSE",
        SRS:'EPSG:900913'},
        {isBaseLayer:true,ratio:1,transitionEffect:'resize',encodeBBOX:false,projection:'EPSG:900913',visible:false,displayInLayerSwitcher: true},
        {tileSize:new OpenLayers.Size(256,256)})
        ,        
        pointLayer,
        zonas
            ]


    });
  var layer_switcher = new OpenLayers.Control.LayerSwitcher( );
  map.addControl(layer_switcher);
  map.addControl(new OpenLayers.Control.MousePosition());
  map.addControl(new OpenLayers.Control.PanZoomBar());  
  map.addControl(new OpenLayers.Control.ScaleLine());
  map.addControl(new OpenLayers.Control.DrawFeature(pointLayer,OpenLayers.Handler.Point));

  map.setCenter(new OpenLayers.LonLat(-90.5, 16).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 7);

  drawControls = {
        point: new OpenLayers.Control.DrawFeature(
          pointLayer,
          OpenLayers.Handler.Point,
          {
          handlerOptions: {
              persist:true,
                            layerOptions: {
                                renderers: renderer,
                                styleMap: styleMap
                            }
                        }
                    }
          )
  };


 function inicio ()
 {
   for(var key in drawControls) 
          {
                    map.addControl(drawControls[key]);
                }
 }

inicio();

 var control = drawControls['point'];
 control.activate();
 
 var pointed=0;

 control.events.register('featureadded', drawControls['point'], function(f) {

    var wkt = new OpenLayers.Format.WKT();
    var out = wkt.write(f.feature);
    document.getElementById('outputWKTs').value =out;
    $.ajax({
      type: "POST",
      url: <?php echo "'".CController::createUrl('Mapa/PointDepto')."'"; ?>,
      data: {point:out},
      beforeSend: function()
      {
        $("#cmb_mupio").empty();
        $("#cmb_mupio").attr('disabled', 'true');
      },
      success: function(result)
      {
        //alert('a');
        var band = 1;
        var resul_array = result.split('|');
        $("#cmb_depto").val(resul_array[0]);
        $("#cmb_depto").change(band);
        $('#cmb_mupio').actualizaMupio(resul_array[0],resul_array[1],band);
      }
      });

    }
    );

  $('#cmb_depto').change(function(band){
    var depto = $('#cmb_depto').val();
    //alert('cambio ' + depto);
    if (band !== 1)
    {
      //alert('depto diferente de uno');
      var tzoom = 'deptos';
      $('#cmb_depto').mapZoom(tzoom, depto);
  
    }
    
    $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('Mapa/getMupios')."'"; ?>,
          data: {param:depto},
          beforeSend: function()
          {
            $("#cmb_mupio").empty();
            $("#cmb_mupio").attr('disabled', 'true');
          },
          success: function(result)
          {
            $("#cmb_mupio").empty();
            $("#cmb_mupio").html(result);
            $("#cmb_mupio").removeAttr('disabled');
          }
        });
  });

  $('#cmb_mupio').change(function(band){
    var mupio = $('#cmb_mupio').val();
    var tzoom = 'muoios';
    if (band !== 1)
    {
      //alert('diferente de uno en mupio');
      $('#cmb_mupio').mapZoom(tzoom,mupio);
        
    }
    
  });

  $.fn.mapZoom = function(tzoom, id_zoom)
  {
    var url;

    if(tzoom=='deptos')
    {
      url = "<?php echo CController::createUrl('Mapa/getBoundDepto'); ?>"
    }
    else
    {
      url = "<?php echo CController::createUrl('Mapa/getBoundMupio'); ?>"
    }

    $.ajax({ 
      type: "POST",
      url:  url,
      data: {data:id_zoom},
      success:  function (response) 
      {
      
      bounds = response.split(',');
        var bounds_map = new OpenLayers.Bounds(bounds[0],bounds[1],bounds[2],bounds[3]);
      map.zoomToExtent(bounds_map);

      },
      failure: function(errMsg) 
      {
        alert(errMsg);
      }
    });
  }

$('#btn_advanced_search').click(function() {
  var valor = $('#advanced_search').val();
  //alert(texto2);
  var request = $.ajax({
  type: "POST",
  url: <?php echo "'".CController::createUrl('Mapa/Busca_lugar')."'"; ?>,
  data: {name: valor},
  success : function(text)
  {
  var myObject = JSON.parse(text);

  var result = '';
  //result += '<select onchange="zoomBusca(this)" multiple="multiple" class="span10">';
  var conta = 0;
  for (var i = 0  ; i < myObject.length; i++) 
  {

  var dm;
  var d = myObject[i]["departamento"];
  var m = ", "+myObject[i]["mupio"];

  if(d === null) d = "";
  if(myObject[i]["mupio"] === null) m = "";

  dm = d+m;

  title="Municipio: "+ myObject[i]["mupio"]+" - Departamento: "+ myObject[i]["departamento"];

  //alert(title);
  console.log(myObject[i]["bbox"]);
  result += '<option class="span12 tooltipAdvancedSearch" value = '+myObject[i]["bbox"]+'|'+myObject[i]["departamento"]+'|'+myObject[i]["mupio"]+' title= "'+title+'">';
  result += myObject[i]["campo_busq"]+" - "+dm;
  result += '</option>';
  conta = conta+1;
  }
  //result += '</select>'
  //document.getElementById('result_busqueda').innerHTML = result;
  $('#contador_coincidencias').html('');
  $('#contador_coincidencias').html('<span class="comentario-fit">Existen: '+conta+' resultados de: "'+valor+'"</span>');
  $('#select_resultado').html(result);
  $("select option:even").addClass("zebra");
  $("#select_resultado").removeAttr("disabled");
  $('#select_resultado').popover('show');

  //$('.tooltipAdvancedSearch').tooltip();
  }
  });


  request.fail(function (jqXHR, textStatus, errorThrown){
  alert(
  "Error al consultar busqueda avanzada"+
  textStatus, errorThrown
  );
  });

  return false;

  });

  $('#select_resultado').change(function(){


  objetos = this.value.split('|');
  bounds =objetos[0].split(',');
  var bounds_map = new OpenLayers.Bounds(bounds[0],bounds[1],bounds[2],bounds[3]);
  map.zoomToExtent(bounds_map);
  depto = objetos[1];
  mupio =  objetos[2];

  //alert(depto);
  //alert(mupio);
    $.ajax({
    type: 'POST',
    url: <?php echo "'".CController::createUrl('Mapa/BuscarDepto')."'"; ?>,
    data: {depto:depto, mupio:mupio},
    success: function(response)
    {
    //alert(response);
    var json_trae = JSON.parse(response);
    var depto = '';
    var mupio = '';
    if(json_trae.length != 0)
    {
    depto = json_trae[0]["cod_depto"];
    mupio = json_trae[0]["cod_mupio"];
    }
    //alert(depto+"+"+mupio);
    $('#select_resultado').actualizaMupio(depto,mupio,0);
    //var combo1 = document.getElementById('cmb_depto');
    //combo1.selectedIndex=depto;
    document.getElementById('cmb_depto').value=depto;
    //document.getElementById('CatMunicipios_cod_mupio').value=mupio;
    }

    });

  });

  $.fn.actualizaMupio = function(recibe,mupio,band)
  {
    var depto = recibe;
    //var depto = $('#cmb_depto').val();
    $.ajax({
            type: "POST",
            url: <?php echo "'".CController::createUrl('Mapa/getMupios')."'"; ?>,
            data: {param:depto},
            success: function(result)
            {
              $("#cmb_mupio").html(result);
              //alert(result);  
              if(mupio!=undefined)
              {
                //alert(mupio);
                document.getElementById('cmb_mupio').value=mupio;
                $('#cmb_mupio').removeAttr('disabled');
                $('#cmb_mupio').change(band);
              }

            }

          });
  }

  $('#geo').submit(function(e){
    e.preventDefault();

    var geo_save = Array();
    var depto = $("#cmb_depto option:selected").text();
    var mupio = $("#cmb_mupio option:selected").text();
    var zona = $('#geo_zona').val();
    var colonia = $('#geo_colonia').val();
    var dir = $('#geo_direccion').val();
    var referencia =  $('#geo_referencia').val();
    var geom = $('#outputWKTs').val();
    var id_denuncia = $('#identificador_denuncia').val();
    var idDepto = $('#cmb_depto').val();
    var idMupio = $('#cmb_mupio ').val();

    if(geom=='')
    {
      alert('Seleccione un punto en el mapa para continuar...');
    }
    else
    {
      geo_save[0]=depto;
      geo_save[1]=mupio;
      geo_save[2]=zona;
      geo_save[3]=colonia;
      geo_save[4]=dir;
      geo_save[5]=referencia;
      geo_save[6]=geom;
      geo_save[7]=idDepto;
      geo_save[8]=idMupio;

      $.ajax({
        type:'POST',
        url: '<?php echo CController::createUrl("Denuncia/Save_Ubicacion"); ?>',
        data:
        {
          data_geo: geo_save.join('|'),
          id_denuncia: id_denuncia,
        },
        beforeSend: function()
        {
          $('#result_procesoModal').html('');
          $('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
          $('#procesoModal').modal('show'); 
        },
        success: function(response)
        {
          $('#ubiX').val('1');
          $('#geo').actualizaResumen();
          $('#result_procesoModal').html('');
          $('#result_procesoModal').html('<div class=\"modal-body\"><h4>Los datos de la Ubicación se han registrado correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
          $('#aTab3').attr('href','#tab3');
          $('#dli_hechos').attr('class','enabled');
          $('#i_hechos').removeClass('BotonClose');                     
          $('#tab2').hide(50);
          $('#tab3').show(50);
          $('#nav_denuncia li:eq(2) a').tab('show');
        }
      });
    }
  }); //fin submit #geo


}); //Fin del ready


</script>