<div class ="cuerpo">
<legend>Seleccione la Ubicación del Hecho</legend>
<div>
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
               $model = new MCatDepartamentos;
                 echo $form->dropDownListRow($model,'cod_depto',
                  CHtml::listData(MCatDepartamentos::model()->findAll(array('order'=>'departamento ASC')),'cod_depto','departamento'),
                    array( 	'class'=>'span12',
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
              $modelo = new MCatMunicipios;
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
	<div class="rowfluid">
		<input type="text" class="span12" id="outputWKTs" style = "display:none" readonly>
	</div>
	<legend style="margin-top:1%; margin-bottom:2%;"></legend>
	<div class="row-fluid">
		<div id="map" class="cuerpo span9 map">


	    </div>
	    <div class="span3 well" style="height:500px;">
	    	<legend>Busqueda Avanzada<div class="pull-right">
	    		<img src="images/info_icon.png"
	    		data-placement="left"
	    		id="ayuda_ad"
	    		style="margin-top: 6px;">
		    	</div>
		    </legend>
		    

	    	<input class="span12" type="text" id="advanced_search">
	    	<div align="right">
	    		<button class="btn btn btn-info" id="btn_advanced_search">Buscar</button>
	    	</div>
	    	<div class="" id="result_busqueda" style="padding-top:5%;">
	    		<div class="pull-right" id="contador_coincidencias" style="padding-right:5%;"></div>
	    		<select id="select_resultado" data-placement="bottom" multiple="multiple" class="span12" size="9" 
	    		data-toggle="tooltip" data-content="Al seleccionar un elemento de la lista, el mapa se acercará para facilitar su busqueda..." 
	    		data-original-title="Seleccione un elemento" disabled>
	    		<option value="">Realice una busqueda</option>
	    		</select>
	    	</div>
	    </div>
	</div>
	<legend></legend>
	<div align="right">
		<button class="btn btn-primary" type="button" id="guardar_novedad">Guardar Novedad</button>

		
	</div>

</div>


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div id ="modalbody"class="modal-body">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4>La Boleta: 
      Se Cambió Con Éxito</h4>
  </div>
  <div class="modal-footer">
    <button id = "aceptamodal" class="btn" data-dismiss="modal" aria-hidden="true">Aceptar</button>
    
  </div>
</div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

$(document).ready(function(){


	$('#ayuda_ad').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i>  AYUDA</legend><p style="line-height: 175%; text-align: justify;">Escriba el nombre de un poblado, caserío, colonia o calle y haga clic en el botón "Buscar" para acercar el mapa y hacer más simple marcar un punto</p><legend class="legend_tt"></legend><p style="line-height: 175%; text-align: justify;">Ejemplo: <p style="padding-left:10%; line-height: 100%; text-align: left;">- pachalum</p><p style="padding-left:10%; line-height: 100%; text-align: left;">- Los Olivos</p></p>'});
	//$('#ayuda_ad').tooltip('show');
 var pointLayer = new OpenLayers.Layer.Vector("Point Layer");
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
      {tileSize:new OpenLayers.Size(256,256)}),
      new OpenLayers.Layer.OSM("OpenStreetMap", null, { //Layer OSM
                transitionEffect: 'resize'
            }),
      pointLayer
            ]
    });

  map.addControl(new OpenLayers.Control.LayerSwitcher());
  map.addControl(new OpenLayers.Control.MousePosition());
  map.addControl(new OpenLayers.Control.ScaleLine());
  map.addControl(new OpenLayers.Control.DrawFeature(pointLayer,OpenLayers.Handler.Point));
  map.setCenter(new OpenLayers.LonLat(-10068367, 1709717), 7);
	 drawControls = {
	                    point: new OpenLayers.Control.DrawFeature(pointLayer,
	                        OpenLayers.Handler.Point)
	 };


 function inicio ()
 {
   for(var key in drawControls) {
                    map.addControl(drawControls[key]);
                }
 }

 inicio();

 var control = drawControls['point'];
 control.activate();
 
 var pointed=0;
 control.events.register('featureadded', drawControls['point'], function(f) {

    if(pointed == 0)
    {
    var wkt = new OpenLayers.Format.WKT();
    var out = wkt.write(f.feature);
    document.getElementById('outputWKTs').value =out;
    pointed++;
   }
    else
    {
      pointLayer.removeFeatures(pointLayer.features);
      pointed--;
    }
    }
    );

	$('#cmb_depto').change(function(){
		var depto = $('#cmb_depto').val();
		//alert('cambio ' + depto);
		var tzoom = 'deptos';
		$('#cmb_depto').mapZoom(tzoom, depto);

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

	$('#cmb_mupio').change(function(){
		var mupio = $('#cmb_mupio').val();
		var tzoom = 'muoios';
		$('#cmb_mupio').mapZoom(tzoom,mupio);
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

	console.log(myObject[i]["bbox"]);
	result += '<option class="span12" value = '+myObject[i]["bbox"]+'|'+myObject[i]["departamento"]+'|'+myObject[i]["mupio"]+' >';
	result += myObject[i]["campo_busq"];
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
		$('#select_resultado').actualizaMupio(depto,mupio);
		//var combo1 = document.getElementById('cmb_depto');
		//combo1.selectedIndex=depto;
		document.getElementById('cmb_depto').value=depto;
		//document.getElementById('MCatMunicipios_cod_mupio').value=mupio;
		}

		});

	});

	$.fn.actualizaMupio = function(recibe,mupio)
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
	            }

	          }

	        });
	}


$('#guardar_novedad').click(function(){
	
  //Parte uno
  var datadet = new Array();
  var hugo = new Array();
  var contador = 0;
  var contadordos = 0;
 $('#evento_detalle tr td').each(function(){

  if(contadordos == 4)
  {
      
      contador = contador +1;
      contadordos = 0;
    }else{
      datadet[contador] = $(this).text();
      contador = contador +1;
      contadordos = contadordos +1;
    }      
});

  var comisaria = $('#comisaria option:selected').val();
  var division = $('#division').val();
  var fecha = $('#fecha').val();
  var hora = $('#mTBoleta_hora').val();
  var titulo = $('#mTBoleta_titulo').val();
  var relato =  $('#mTBoleta_detalle').val();
var depto = $("#cmb_depto").val();
var mupio = $("#cmb_mupio").val();
var zona = $('#geo_zona').val();
var colonia = $('#geo_colonia').val();
var dir = $('#geo_direccion').val();
var referencia =  $('#geo_referencia').val();
var geom = $('#outputWKTs').val();

var aData = new Array();
  aData [0] = comisaria;
  aData [1] = division;
  aData [2] = fecha;
  aData [3] = hora;
  aData [4] = titulo;
  aData [5] = relato;
  aData [6] = depto;
  aData [7] = mupio;
  aData [8] = zona;
  aData [9] = colonia;
  aData [10] = dir;
  aData [11] = geom;
  
  //var data = $("#novedades").serialize();


$.ajax({
            type: "POST",
            url: "<?php echo CController::createUrl('CTBoleta/crear'); ?>",
            data: {
            	data:aData.join('|'),
                data_det: datadet,
                  },
                   success: function(data){ 
        		$('#modalbody').html(data); 
        		$('#myModal').modal('show'); 
        		 $('#aceptamodal').click(function(){
                var  url= "<?php echo Yii::app()->createUrl('cTBoleta/index2	'); ?>";   
         		$(location).attr('href',url);

         });           	
				}
			
        });


});


}); //Fin del ready


</script>