/**** 
Author - Laurent Vaïsse - lvaisse at gmail dot com  - lenchosig.blogspot.com
LICENSE   Attribution-NonCommercial-ShareAlike 3.0 Unported (CC BY-NC-SA 3.0)
YOU ARE FREE:
    to Share — to copy, distribute and transmit the work
    to Remix — to adapt the work
UNDER THE FOLLOWING CONDITIONS:
    ATTRIBUTION — You must attribute the work in the manner specified by the author or licensor (but not in any way that suggests that they endorse you or your use of the work).
    NONCOMMERCIAL — You may not use this work for commercial purposes.
    SHARE ALIKE — If you alter, transform, or build upon this work, you may distribute the resulting work only under the same or similar license to this one. 
	
	FULL LICENSE AT   http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode
**/


Ext.namespace('guate.widgets','guate.widgets.lencho');

guate.widgets.lencho.editMapaPanel = Ext.extend(Ext.Panel, {

 /**
	 **	Jaw tu iuse el widget **
	 *   WE ASSUME THAT WE USE THE BASE MAP IN EPSG:900913 PROJECTION
	 *
	      { xtype: 'editMapa',				 
			title: 'Titulo',                 // Title on top of MapPanel
			layers: [array,of,layers],		 // Waiting for an array of layer previously declared on the code REQUIRED!!               new OpenLayers.Layers.WMS()  etc..
			geoType: 'Point',                // Waiting for geometry type  REQUIRED!!                                                  Point Line o Polygon
			formaType: 'wkt',                // Waiting for geometry format REQUIRED!!                                                 wkt geojson georss kml
			outputProjection: 'EPSG:4326',   // Waiting for output projection REQUIRED!!                                               4326 o 900913
			inputProjection: 'EPSG:4326',    // Waiting for intput projection  in case of an update of geom                            4326 o 900913  (default 900913)
			geomReceived: 'POINT(-90.5 14)', // Waiting for a geometry  in case of an update of geom
												// The geom may be received in the same format that declared formaType
		    height: 495,					 //height of mapPanel
            width: 715						 //width of mapPanel
			}	
	*
	*
	***/

    /**
     * Property: titulo, tamaño del widget 
     */
	title: null,
    height: null,
	width: null,
	layers: null,
    /**
     * Property: Proyecciones y formatos
     */
	geoType: null,
    inputProjection: null,
    outputProjection: null,
    formaType: null,	
	geomReceived: null,
    /**
     * Method: initComponent
     * Inicializa el componente
     */
    initComponent: function() {
        if (!this.outputProjection) {
            alert("opcion outputProjection falta para el widget mapa");
        }
		if (!this.geoType) {
            alert("opcion geoType falta para el widget mapa");
        }
		if (!this.formaType) {
            alert("opcion formaType falta para el widget mapa");
        }
		if (!this.layers) {
            alert("opcion layers falta para el widget mapa");
        }
		
		this.add(this.createMapa());
	
	},
	
	 /**
     * Method: createMapa
     * Crear el mapa
     *
     * Retorna:
     * {GeoExt.MapPanel}
     */
    createMapa: function() {
	
	/**VARIABLES RECIBIDAS DEL WIDGET**/
	
    var capas = this.layers;
	var GeoType;
if (this.geoType == 'Point'){
  GeoType = OpenLayers.Handler.Point
  }
if (this.geoType == 'MultiPoint'){
  GeoType = OpenLayers.Handler.Point
  }
if (this.geoType == 'Polygon'){
  GeoType = OpenLayers.Handler.Polygon
  }
if (this.geoType == 'Line'){
  GeoType = OpenLayers.Handler.Path
  }
    var outputProjection = this.outputProjection;
	var inputProjection = this.inputProjection;
	var formaType = this.formaType;
	var element = this.geomReceived;
	
	/** MAP Options **/
	
	 var mapOptions = {
	     id: "mapito",
         projection: new OpenLayers.Projection("EPSG:900913"),
         displayProjection: new OpenLayers.Projection("EPSG:4326"),
         units: "m",
		 resolutions:[2445.98490478516,1222.99245239258,611.496226196289,305.748113098145,152.874056549072,76.4370282745361,38.2185141372681,19.109257068634,9.55462853431702,4.77731426715851,2.38865713357925,1.19432856678963,0.597164283394815],
		allOverlays: false,
        theme: null // poner nulo sino OpenLayers trata de cargar el tema default que es mas feo
    };
 var map = new OpenLayers.Map(mapOptions);
 var layer_switcher = new OpenLayers.Control.LayerSwitcher();
	 map.addControl(layer_switcher);
	 layer_switcher.maximizeControl();
	 
	   
    map.addLayers(capas);
	
	
/***Formatos y Proyecciones - Esa funcion, se retomo de los ejemplos de Openlayers, formatos vectores **/
 var formats;
 function updateFormats() {
            var in_options = {
                'internalProjection': map.baseLayer.projection,
                'externalProjection': new OpenLayers.Projection(inputProjection)
            };   
            var out_options = {
                'internalProjection': map.baseLayer.projection,
                'externalProjection': new OpenLayers.Projection(outputProjection)
            };
          
            var kmlOptionsIn = OpenLayers.Util.extend(
                {extractStyles: true}, in_options);
				
            formats = {
              'in': {
                wkt: new OpenLayers.Format.WKT(in_options),
                geojson: new OpenLayers.Format.GeoJSON(in_options),
                georss: new OpenLayers.Format.GeoRSS(in_options),
				gpx: new OpenLayers.Format.GPX(in_options)
              },
              'out': {
                wkt: new OpenLayers.Format.WKT(out_options),
                geojson: new OpenLayers.Format.GeoJSON(out_options),
                georss: new OpenLayers.Format.GeoRSS(out_options),
                kml: new OpenLayers.Format.KML(out_options),
				gpx: new OpenLayers.Format.GPX(out_options)
              }
            };
        };
		
	updateFormats();
	
/******************EDICION****************/
	var vectorLayer; // declaro aqui la capa vector editable
    var selectFeature = null;
    var drawFeature = null;

    var activate = function() {
        map.addLayer(vectorLayer);
        map.addControl(drawFeature);
		drawFeature.activate();
    };

    var deactivate = function() {

        drawFeature.deactivate();
        map.removeControl(drawFeature);

        if (OpenLayers.Util.indexOf(map.layers, vectorLayer) >= 0) {
        }
    };


	 /**  BEGIN control Escribe geometria  */
	function serialize(feature) {
            var str = formats['out'][formaType].write(feature);
			Ext.getCmp('outputgeom').setValue(str);
        }
		
	/** BEGIN control que lee y agrega la geometria**/
	function deserialize() {
            var features = formats['in'][formaType].read(element);
            if(features) {
				map.addLayer(vectorLayer);
                vectorLayer.addFeatures(features);
            } else {
		   alert('Bad Input my friend, revisa tu geometria');
            }
        }
		
		/** Estilos de mi capa vector editable **/
var styleSelect = OpenLayers.Util.applyDefaults({
        graphicName: 'square',
		pointRadius: 12,
        strokeColor: '#FF0000',
        fillColor: '#FFFF00'
    }, OpenLayers.Feature.Vector.style['select']);
	
 var styleDefault = OpenLayers.Util.applyDefaults({
        graphicName: 'square',
		pointRadius: 10,
        strokeColor: '#FF0000',
        fillColor: '#0000FF'
    }, OpenLayers.Feature.Vector.style['default']);
	
	/** CAPA vector **/
    vectorLayer = new OpenLayers.Layer.Vector("vector", {
		displayInLayerSwitcher: false,
		styleMap: new OpenLayers.StyleMap({
            'select': styleSelect,
			'default':styleDefault
        }),
        eventListeners: {
            beforefeatureadded: function(e) {
                var feature = e.feature;
                if (feature.fid == null) {

                    vectorLayer.destroyFeatures();
                    selectFeature.select(e.feature);
					serialize(e.feature);
				}
            }
        }
    });

    /***Creando el select y draw controls.**/
    selectFeature = new OpenLayers.Control.SelectFeature(vectorLayer);
    drawFeature = new OpenLayers.Control.DrawFeature(vectorLayer, GeoType);
  
			
/**Botonazos**/
var editButton = new Ext.Button({
            text: 'Mapear Elemento',
            iconCls: 'editing',
			enableToggle: true,
			toggleHandler: function (button, state) {    if (state == true) {
					activate();
					   }
					   if (state == false) {
					 deactivate();
					   }
			},
			allowDepress: true		
        });
			
		
var destroyPoint = new Ext.Button({
	iconCls: 'cancel',
	text: "Borrar Elemento",
    tooltip: "Eliminar el objeto dibujado",
    allowDepress: false,
    handler: function(){
	      Ext.Msg.confirm(
                'Aviso!',
                'Desea borrar el elemento existente?',
                function(btn, text){
                    if (btn == "yes") {
					vectorLayer.destroyFeatures();
					Ext.getCmp('outputgeom').setValue('');
                    } else {
                       // no hace nada, retorna al estado inicial
                    }
                });
			  		
    }
    });
	
/** El MAPPANEL geoext final **/
   var mapPanel = new GeoExt.MapPanel({
        title: this.title,
        stateId: "mappanel",
		extent: OpenLayers.Bounds.fromString("-10392342,1525163,-9756385,2025367"),
        height: this.height,
        width: this.width,
        map: map,
		tbar: new Ext.Toolbar({
		    height: 35,
			items: [editButton,destroyPoint,'->',{xtype:"textfield",
id:'outputgeom',
disabled: true,
width:250,
height: 25,
name:"outputgeom",
emptyText:""}]
		})
    });
	
	/** Si la geometria recibida no es nula, que se escriba en el campo de texto disable, y que la agregue al mapa con el deserialize **/
	if(this.geomReceived != null){
	     Ext.getCmp('outputgeom').setValue(this.geomReceived);
		deserialize();
	}
        return mapPanel;
    }
	
	
});


Ext.reg('editMapa', guate.widgets.lencho.editMapaPanel);



