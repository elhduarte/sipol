/*

Copyright (c) 2008-2010, The Open Source Geospatial Foundation
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice,
      this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the Open Source Geospatial Foundation nor the names
      of its contributors may be used to endorse or promote products derived
      from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.

*/

Ext.namespace('GeoExt');GeoExt.LegendImage=Ext.extend(Ext.BoxComponent,{url:null,defaultImgSrc:null,imgCls:null,initComponent:function(){GeoExt.LegendImage.superclass.initComponent.call(this);if(this.defaultImgSrc===null){this.defaultImgSrc=Ext.BLANK_IMAGE_URL;}
this.autoEl={tag:"img","class":(this.imgCls?this.imgCls:""),src:this.defaultImgSrc};},setUrl:function(url){this.url=url;var el=this.getEl();if(el){el.un("error",this.onImageLoadError,this);el.on("error",this.onImageLoadError,this,{single:true});el.dom.src=url;}},onRender:function(ct,position){GeoExt.LegendImage.superclass.onRender.call(this,ct,position);if(this.url){this.setUrl(this.url);}},onDestroy:function(){var el=this.getEl();if(el){el.un("error",this.onImageLoadError,this);}
GeoExt.LegendImage.superclass.onDestroy.apply(this,arguments);},onImageLoadError:function(){this.getEl().dom.src=this.defaultImgSrc;}});Ext.reg('gx_legendimage',GeoExt.LegendImage);
Ext.namespace("GeoExt");GeoExt.LayerOpacitySlider=Ext.extend(Ext.Slider,{layer:null,complementaryLayer:null,delay:5,changeVisibilityDelay:5,aggressive:false,changeVisibility:false,value:null,inverse:false,constructor:function(config){if(config.layer){this.layer=this.getLayer(config.layer);this.bind();this.complementaryLayer=this.getLayer(config.complementaryLayer);if(config.inverse!==undefined){this.inverse=config.inverse;}
config.value=(config.value!==undefined)?config.value:this.getOpacityValue(this.layer);delete config.layer;delete config.complementaryLayer;}
GeoExt.LayerOpacitySlider.superclass.constructor.call(this,config);},bind:function(){if(this.layer&&this.layer.map){this.layer.map.events.on({changelayer:this.update,scope:this});}},unbind:function(){if(this.layer&&this.layer.map){this.layer.map.events.un({changelayer:this.update,scope:this});}},update:function(evt){if(evt.property==="opacity"&&evt.layer==this.layer){this.setValue(this.getOpacityValue(this.layer));}},setLayer:function(layer){this.unbind();this.layer=this.getLayer(layer);this.setValue(this.getOpacityValue(layer));this.bind();},getOpacityValue:function(layer){var value;if(layer&&layer.opacity!==null){value=parseInt(layer.opacity*(this.maxValue-this.minValue));}else{value=this.maxValue;}
if(this.inverse===true){value=(this.maxValue-this.minValue)-value;}
return value;},getLayer:function(layer){if(layer instanceof OpenLayers.Layer){return layer;}else if(layer instanceof GeoExt.data.LayerRecord){return layer.getLayer();}},initComponent:function(){GeoExt.LayerOpacitySlider.superclass.initComponent.call(this);if(this.changeVisibility&&this.layer&&(this.layer.opacity==0||(this.inverse===false&&this.value==this.minValue)||(this.inverse===true&&this.value==this.maxValue))){this.layer.setVisibility(false);}
if(this.complementaryLayer&&((this.layer&&this.layer.opacity==1)||(this.inverse===false&&this.value==this.maxValue)||(this.inverse===true&&this.value==this.minValue))){this.complementaryLayer.setVisibility(false);}
if(this.aggressive===true){this.on('change',this.changeLayerOpacity,this,{buffer:this.delay});}else{this.on('changecomplete',this.changeLayerOpacity,this);}
if(this.changeVisibility===true){this.on('change',this.changeLayerVisibility,this,{buffer:this.changeVisibilityDelay});}
if(this.complementaryLayer){this.on('change',this.changeComplementaryLayerVisibility,this,{buffer:this.changeVisibilityDelay});}
this.on("beforedestroy",this.unbind,this);},changeLayerOpacity:function(slider,value){if(this.layer){value=value/(this.maxValue-this.minValue);if(this.inverse===true){value=1-value;}
this.layer.setOpacity(value);}},changeLayerVisibility:function(slider,value){var currentVisibility=this.layer.getVisibility();if((this.inverse===false&&value==this.minValue)||(this.inverse===true&&value==this.maxValue)&&currentVisibility===true){this.layer.setVisibility(false);}else if((this.inverse===false&&value>this.minValue)||(this.inverse===true&&value<this.maxValue)&&currentVisibility==false){this.layer.setVisibility(true);}},changeComplementaryLayerVisibility:function(slider,value){var currentVisibility=this.complementaryLayer.getVisibility();if((this.inverse===false&&value==this.maxValue)||(this.inverse===true&&value==this.minValue)&&currentVisibility===true){this.complementaryLayer.setVisibility(false);}else if((this.inverse===false&&value<this.maxValue)||(this.inverse===true&&value>this.minValue)&&currentVisibility==false){this.complementaryLayer.setVisibility(true);}},addToMapPanel:function(panel){this.on({render:function(){var el=this.getEl();el.setStyle({position:"absolute",zIndex:panel.map.Z_INDEX_BASE.Control});el.on({mousedown:this.stopMouseEvents,click:this.stopMouseEvents});},scope:this});},removeFromMapPanel:function(panel){var el=this.getEl();el.un({mousedown:this.stopMouseEvents,click:this.stopMouseEvents,scope:this});this.unbind();},stopMouseEvents:function(e){e.stopEvent();}});Ext.reg('gx_opacityslider',GeoExt.LayerOpacitySlider);
Ext.namespace('GeoExt');GeoExt.LayerLegend=Ext.extend(Ext.Container,{layerRecord:null,showTitle:true,legendTitle:null,labelCls:null,layerStore:null,initComponent:function(){GeoExt.LayerLegend.superclass.initComponent.call(this);this.autoEl={};this.add({xtype:"label",text:this.getLayerTitle(this.layerRecord),cls:'x-form-item x-form-item-label'+
(this.labelCls?' '+this.labelCls:'')});if(this.layerRecord&&this.layerRecord.store){this.layerStore=this.layerRecord.store;this.layerStore.on("update",this.onStoreUpdate,this);}},onStoreUpdate:function(store,record,operation){if(record===this.layerRecord&&this.items.getCount()>0){var layer=record.getLayer();this.setVisible(layer.getVisibility()&&layer.calculateInRange()&&layer.displayInLayerSwitcher&&!record.get('hideInLegend'));this.update();}},update:function(){var title=this.getLayerTitle(this.layerRecord);if(this.items.get(0).text!==title){this.items.get(0).setText(title);}},getLayerTitle:function(record){var title=this.legendTitle||"";if(this.showTitle&&!title){if(record&&!record.get("hideTitle")){title=record.get("title")||record.get("name")||record.getLayer().name||"";}}
return title;},beforeDestroy:function(){this.layerStore&&this.layerStore.un("update",this.onStoreUpdate,this);GeoExt.LayerLegend.superclass.beforeDestroy.apply(this,arguments);}});GeoExt.LayerLegend.getTypes=function(layerRecord,preferredTypes){var types=(preferredTypes||[]).concat();var goodTypes=[];for(var type in GeoExt.LayerLegend.types){if(GeoExt.LayerLegend.types[type].supports(layerRecord)){types.indexOf(type)==-1&&goodTypes.push(type);}else{types.remove(type);}}
return types.concat(goodTypes);};GeoExt.LayerLegend.supports=function(layerRecord){};GeoExt.LayerLegend.types={};
Ext.namespace('GeoExt');GeoExt.VectorLegend=Ext.extend(GeoExt.LayerLegend,{layerRecord:null,layer:null,rules:null,symbolType:null,untitledPrefix:"Untitled ",clickableSymbol:false,clickableTitle:false,selectOnClick:false,enableDD:false,bodyBorder:false,feature:null,selectedRule:null,currentScaleDenominator:null,initComponent:function(){GeoExt.VectorLegend.superclass.initComponent.call(this);if(this.layerRecord){this.layer=this.layerRecord.getLayer();if(this.layer.map){this.currentScaleDenominator=this.layer.map.getScale();this.layer.map.events.on({"zoomend":this.onMapZoom,scope:this});}}
if(!this.symbolType){if(this.feature){this.symbolType=this.symbolTypeFromFeature(this.feature);}else if(this.layer){if(this.layer.features.length>0){var feature=this.layer.features[0].clone();feature.attributes={};this.feature=feature;this.symbolType=this.symbolTypeFromFeature(this.feature);}else{this.layer.events.on({featuresadded:this.onFeaturesAdded,scope:this});}}}
if(this.layer&&this.feature&&!this.rules){this.setRules();}
this.rulesContainer=new Ext.Container({autoEl:{}});this.add(this.rulesContainer);this.addEvents("titleclick","symbolclick","ruleclick","ruleselected","ruleunselected","rulemoved");this.update();},onMapZoom:function(){this.setCurrentScaleDenominator(this.layer.map.getScale());},symbolTypeFromFeature:function(feature){var match=feature.geometry.CLASS_NAME.match(/Point|Line|Polygon/);return(match&&match[0])||"Point";},onFeaturesAdded:function(){this.layer.events.un({featuresadded:this.onFeaturesAdded,scope:this});var feature=this.layer.features[0].clone();feature.attributes={};this.feature=feature;this.symbolType=this.symbolTypeFromFeature(this.feature);if(!this.rules){this.setRules();}
this.update();},setRules:function(){var style=this.layer.styleMap&&this.layer.styleMap.styles["default"];if(!style){style=new OpenLayers.Style();}
if(style.rules.length===0){this.rules=[new OpenLayers.Rule({symbolizer:style.createSymbolizer(this.feature)})];}else{this.rules=style.rules;}},setCurrentScaleDenominator:function(scale){if(scale!==this.currentScaleDenominator){this.currentScaleDenominator=scale;this.update();}},getRuleEntry:function(rule){return this.rulesContainer.items.get(this.rules.indexOf(rule));},addRuleEntry:function(rule,noDoLayout){this.rulesContainer.add(this.createRuleEntry(rule));if(!noDoLayout){this.doLayout();}},removeRuleEntry:function(rule,noDoLayout){var ruleEntry=this.getRuleEntry(rule);if(ruleEntry){this.rulesContainer.remove(ruleEntry);if(!noDoLayout){this.doLayout();}}},selectRuleEntry:function(rule){var newSelection=rule!=this.selectedRule;if(this.selectedRule){this.unselect();}
if(newSelection){var ruleEntry=this.getRuleEntry(rule);ruleEntry.body.addClass("x-grid3-row-selected");this.selectedRule=rule;this.fireEvent("ruleselected",this,rule);}},unselect:function(){this.rulesContainer.items.each(function(item,i){if(this.rules[i]==this.selectedRule){item.body.removeClass("x-grid3-row-selected");this.selectedRule=null;this.fireEvent("ruleunselected",this,this.rules[i]);}},this);},createRuleEntry:function(rule){var applies=true;if(this.currentScaleDenominator!=null){if(rule.minScaleDenominator){applies=applies&&(this.currentScaleDenominator>=rule.minScaleDenominator);}
if(rule.maxScaleDenominator){applies=applies&&(this.currentScaleDenominator<rule.maxScaleDenominator);}}
return{xtype:"panel",layout:"column",border:false,hidden:!applies,bodyStyle:this.selectOnClick?{cursor:"pointer"}:undefined,defaults:{border:false},items:[this.createRuleRenderer(rule),this.createRuleTitle(rule)],listeners:{render:function(comp){this.selectOnClick&&comp.getEl().on({click:function(comp){this.selectRuleEntry(rule);},scope:this});if(this.enableDD==true){this.addDD(comp);}},scope:this}};},createRuleRenderer:function(rule){var types=[this.symbolType,"Point","Line","Polygon"];var type,haveType;var symbolizers=rule.symbolizers;if(!symbolizers){var symbolizer=rule.symbolizer;for(var i=0,len=types.length;i<len;++i){type=types[i];if(symbolizer[type]){symbolizer=symbolizer[type];haveType=true;break;}}
symbolizers=[symbolizer];}else{var Type;outer:for(var i=0,ii=types.length;i<ii;++i){type=types[i];Type=OpenLayers.Symbolizer[type];if(Type){for(var j=0,jj=symbolizers.length;j<jj;++j){if(symbolizers[j]instanceof Type){haveType=true;break outer;}}}}}
return{xtype:"gx_renderer",symbolType:haveType?type:this.symbolType,symbolizers:symbolizers,style:this.clickableSymbol?{cursor:"pointer"}:undefined,listeners:{click:function(){if(this.clickableSymbol){this.fireEvent("symbolclick",this,rule);this.fireEvent("ruleclick",this,rule);}},scope:this}};},createRuleTitle:function(rule){return{cls:"x-form-item",style:"padding: 0.2em 0.5em 0;",bodyStyle:Ext.applyIf({background:"transparent"},this.clickableTitle?{cursor:"pointer"}:undefined),html:this.getRuleTitle(rule),listeners:{render:function(comp){this.clickableTitle&&comp.getEl().on({click:function(){this.fireEvent("titleclick",this,rule);this.fireEvent("ruleclick",this,rule);},scope:this});},scope:this}};},addDD:function(component){var ct=component.ownerCt;var panel=this;new Ext.dd.DragSource(component.getEl(),{ddGroup:ct.id,onDragOut:function(e,targetId){var target=Ext.getCmp(targetId);target.removeClass("gx-ruledrag-insert-above");target.removeClass("gx-ruledrag-insert-below");return Ext.dd.DragZone.prototype.onDragOut.apply(this,arguments);},onDragEnter:function(e,targetId){var target=Ext.getCmp(targetId);var cls;var sourcePos=ct.items.indexOf(component);var targetPos=ct.items.indexOf(target);if(sourcePos>targetPos){cls="gx-ruledrag-insert-above";}else if(sourcePos<targetPos){cls="gx-ruledrag-insert-below";}
cls&&target.addClass(cls);return Ext.dd.DragZone.prototype.onDragEnter.apply(this,arguments);},onDragDrop:function(e,targetId){panel.moveRule(ct.items.indexOf(component),ct.items.indexOf(Ext.getCmp(targetId)));return Ext.dd.DragZone.prototype.onDragDrop.apply(this,arguments);},getDragData:function(e){var sourceEl=e.getTarget(".x-column-inner");if(sourceEl){var d=sourceEl.cloneNode(true);d.id=Ext.id();return{sourceEl:sourceEl,repairXY:Ext.fly(sourceEl).getXY(),ddel:d}}}});new Ext.dd.DropTarget(component.getEl(),{ddGroup:ct.id,notifyDrop:function(){return true;}});},update:function(){GeoExt.VectorLegend.superclass.update.apply(this,arguments);if(this.symbolType&&this.rules){if(this.rulesContainer.items){var comp;for(var i=this.rulesContainer.items.length-1;i>=0;--i){comp=this.rulesContainer.getComponent(i);this.rulesContainer.remove(comp,true);}}
for(var i=0,ii=this.rules.length;i<ii;++i){this.addRuleEntry(this.rules[i],true);}
this.doLayout();if(this.selectedRule){this.getRuleEntry(this.selectedRule).body.addClass("x-grid3-row-selected");}}},updateRuleEntry:function(rule){var ruleEntry=this.getRuleEntry(rule);if(ruleEntry){ruleEntry.removeAll();ruleEntry.add(this.createRuleRenderer(rule));ruleEntry.add(this.createRuleTitle(rule));ruleEntry.doLayout();}},moveRule:function(sourcePos,targetPos){var srcRule=this.rules[sourcePos];this.rules.splice(sourcePos,1);this.rules.splice(targetPos,0,srcRule);this.update();this.fireEvent("rulemoved",this,srcRule);},getRuleTitle:function(rule){var title=rule.title||rule.name||"";if(!title&&this.untitledPrefix){title=this.untitledPrefix+(this.rules.indexOf(rule)+1);}
return title;},beforeDestroy:function(){if(this.layer){if(this.layer.events){this.layer.events.un({featuresadded:this.onFeaturesAdded,scope:this});}
if(this.layer.map&&this.layer.map.events){this.layer.map.events.un({"zoomend":this.onMapZoom,scope:this});}}
delete this.layer;delete this.rules;GeoExt.VectorLegend.superclass.beforeDestroy.apply(this,arguments);}});GeoExt.VectorLegend.supports=function(layerRecord){return layerRecord.getLayer()instanceof OpenLayers.Layer.Vector;};GeoExt.LayerLegend.types["gx_vectorlegend"]=GeoExt.VectorLegend;Ext.reg("gx_vectorlegend",GeoExt.VectorLegend);
Ext.namespace('GeoExt');GeoExt.WMSLegend=Ext.extend(GeoExt.LayerLegend,{defaultStyleIsFirst:true,useScaleParameter:true,baseParams:null,initComponent:function(){GeoExt.WMSLegend.superclass.initComponent.call(this);var layer=this.layerRecord.getLayer();this._noMap=!layer.map;layer.events.register("moveend",this,this.onLayerMoveend);this.update();},onLayerMoveend:function(e){if((e.zoomChanged===true&&this.useScaleParameter===true)||this._noMap){delete this._noMap;this.update();}},getLegendUrl:function(layerName,layerNames){var rec=this.layerRecord;var url;var styles=rec&&rec.get("styles");var layer=rec.getLayer();layerNames=layerNames||[layer.params.LAYERS].join(",").split(",");var styleNames=layer.params.STYLES&&[layer.params.STYLES].join(",").split(",");var idx=layerNames.indexOf(layerName);var styleName=styleNames&&styleNames[idx];if(styles&&styles.length>0){if(styleName){Ext.each(styles,function(s){url=(s.name==styleName&&s.legend)&&s.legend.href;return!url;});}else if(this.defaultStyleIsFirst===true&&!styleNames&&!layer.params.SLD&&!layer.params.SLD_BODY){url=styles[0].legend&&styles[0].legend.href;}}
if(!url){url=layer.getFullRequestString({REQUEST:"GetLegendGraphic",WIDTH:25,HEIGHT:25,EXCEPTIONS:"application/vnd.ogc.se_xml",LAYER:layerName,LAYERS:null,STYLE:(styleName!=='')?styleName:null,STYLES:null,SRS:null,FORMAT:null});}
if(this.useScaleParameter===true&&url.toLowerCase().indexOf("request=getlegendgraphic")!=-1){var scale=layer.map.getScale();url=Ext.urlAppend(url,"SCALE="+scale);}
var params=this.baseParams||{};Ext.applyIf(params,{FORMAT:'image/png'/*,*/});if(url.indexOf('?')>0){url=Ext.urlEncode(params,url);}
return url;},update:function(){var layer=this.layerRecord.getLayer();if(!(layer&&layer.map)){return;}
GeoExt.WMSLegend.superclass.update.apply(this,arguments);var layerNames,layerName,i,len;layerNames=[layer.params.LAYERS].join(",").split(",");var destroyList=[];var textCmp=this.items.get(0);this.items.each(function(cmp){i=layerNames.indexOf(cmp.itemId);if(i<0&&cmp!=textCmp){destroyList.push(cmp);}else if(cmp!==textCmp){layerName=layerNames[i];var newUrl=this.getLegendUrl(layerName,layerNames);if(!OpenLayers.Util.isEquivalentUrl(newUrl,cmp.url)){cmp.setUrl(newUrl);}}},this);for(i=0,len=destroyList.length;i<len;i++){var cmp=destroyList[i];this.remove(cmp);cmp.destroy();}
for(i=0,len=layerNames.length;i<len;i++){layerName=layerNames[i];if(!this.items||!this.getComponent(layerName)){this.add({xtype:"gx_legendimage",url:this.getLegendUrl(layerName,layerNames),itemId:layerName});}}
this.doLayout();},beforeDestroy:function(){if(this.useScaleParameter===true){var layer=this.layerRecord.getLayer()
layer&&layer.events&&layer.events.unregister("moveend",this,this.onLayerMoveend);}
GeoExt.WMSLegend.superclass.beforeDestroy.apply(this,arguments);}});GeoExt.WMSLegend.supports=function(layerRecord){return layerRecord.getLayer()instanceof OpenLayers.Layer.WMS;};GeoExt.LayerLegend.types["gx_wmslegend"]=GeoExt.WMSLegend;Ext.reg('gx_wmslegend',GeoExt.WMSLegend);
Ext.namespace("GeoExt");GeoExt.Action=Ext.extend(Ext.Action,{control:null,map:null,uScope:null,uHandler:null,uToggleHandler:null,uCheckHandler:null,constructor:function(config){this.uScope=config.scope;this.uHandler=config.handler;this.uToggleHandler=config.toggleHandler;this.uCheckHandler=config.checkHandler;config.scope=this;config.handler=this.pHandler;config.toggleHandler=this.pToggleHandler;config.checkHandler=this.pCheckHandler;var ctrl=this.control=config.control;delete config.control;if(ctrl){if(config.map){config.map.addControl(ctrl);delete config.map;}
if((config.pressed||config.checked)&&ctrl.map){ctrl.activate();}
ctrl.events.on({activate:this.onCtrlActivate,deactivate:this.onCtrlDeactivate,scope:this});}
arguments.callee.superclass.constructor.call(this,config);},pHandler:function(cmp){var ctrl=this.control;if(ctrl&&ctrl.type==OpenLayers.Control.TYPE_BUTTON){ctrl.trigger();}
if(this.uHandler){this.uHandler.apply(this.uScope,arguments);}},pToggleHandler:function(cmp,state){this.changeControlState(state);if(this.uToggleHandler){this.uToggleHandler.apply(this.uScope,arguments);}},pCheckHandler:function(cmp,state){this.changeControlState(state);if(this.uCheckHandler){this.uCheckHandler.apply(this.uScope,arguments);}},changeControlState:function(state){if(state){if(!this._activating){this._activating=true;this.control.activate();this._activating=false;}}else{if(!this._deactivating){this._deactivating=true;this.control.deactivate();this._deactivating=false;}}},onCtrlActivate:function(){var ctrl=this.control;if(ctrl.type==OpenLayers.Control.TYPE_BUTTON){this.enable();}else{this.safeCallEach("toggle",[true]);this.safeCallEach("setChecked",[true]);}},onCtrlDeactivate:function(){var ctrl=this.control;if(ctrl.type==OpenLayers.Control.TYPE_BUTTON){this.disable();}else{this.safeCallEach("toggle",[false]);this.safeCallEach("setChecked",[false]);}},safeCallEach:function(fnName,args){var cs=this.items;for(var i=0,len=cs.length;i<len;i++){if(cs[i][fnName]){cs[i].rendered?cs[i][fnName].apply(cs[i],args):cs[i].on({"render":cs[i][fnName].createDelegate(cs[i],args),single:true});}}}});
Ext.namespace("GeoExt");GeoExt.MapPanel=Ext.extend(Ext.Panel,{map:null,layers:null,center:null,zoom:null,prettyStateKeys:false,extent:null,stateEvents:["aftermapmove","afterlayervisibilitychange","afterlayeropacitychange"],initComponent:function(){if(!(this.map instanceof OpenLayers.Map)){this.map=new OpenLayers.Map(Ext.applyIf(this.map||{},{allOverlays:true}));}
var layers=this.layers;if(!layers||layers instanceof Array){this.layers=new GeoExt.data.LayerStore({layers:layers,map:this.map.layers.length>0?this.map:null});}
if(typeof this.center=="string"){this.center=OpenLayers.LonLat.fromString(this.center);}else if(this.center instanceof Array){this.center=new OpenLayers.LonLat(this.center[0],this.center[1]);}
if(typeof this.extent=="string"){this.extent=OpenLayers.Bounds.fromString(this.extent);}else if(this.extent instanceof Array){this.extent=OpenLayers.Bounds.fromArray(this.extent);}
GeoExt.MapPanel.superclass.initComponent.call(this);this.addEvents("aftermapmove","afterlayervisibilitychange","afterlayeropacitychange");this.map.events.on({"moveend":this.onMoveend,"changelayer":this.onLayerchange,scope:this});},onMoveend:function(){this.fireEvent("aftermapmove");},onLayerchange:function(e){if(e.property){if(e.property==="visibility"){this.fireEvent("afterlayervisibilitychange");}else if(e.property==="opacity"){this.fireEvent("afterlayeropacitychange");}}},applyState:function(state){this.center=new OpenLayers.LonLat(state.x,state.y);this.zoom=state.zoom;var i,l,layer,layerId,visibility,opacity;var layers=this.map.layers;for(i=0,l=layers.length;i<l;i++){layer=layers[i];layerId=this.prettyStateKeys?layer.name:layer.id;visibility=state["visibility_"+layerId];if(visibility!==undefined){visibility=(/^true$/i).test(visibility);if(layer.isBaseLayer){if(visibility){this.map.setBaseLayer(layer);}}else{layer.setVisibility(visibility);}}
opacity=state["opacity_"+layerId];if(opacity!==undefined){layer.setOpacity(opacity);}}},getState:function(){var state;if(!this.map){return;}
var center=this.map.getCenter();state={x:center.lon,y:center.lat,zoom:this.map.getZoom()};var i,l,layer,layerId,layers=this.map.layers;for(i=0,l=layers.length;i<l;i++){layer=layers[i];layerId=this.prettyStateKeys?layer.name:layer.id;state["visibility_"+layerId]=layer.getVisibility();state["opacity_"+layerId]=layer.opacity==null?1:layer.opacity;}
return state;},updateMapSize:function(){if(this.map){this.map.updateSize();}},renderMap:function(){var map=this.map;map.render(this.body.dom);this.layers.bind(map);if(map.layers.length>0){if(this.center||this.zoom!=null){map.setCenter(this.center,this.zoom);}else if(this.extent){map.zoomToExtent(this.extent);}else{map.zoomToMaxExtent();}}},afterRender:function(){GeoExt.MapPanel.superclass.afterRender.apply(this,arguments);if(!this.ownerCt){this.renderMap();}else{this.ownerCt.on("move",this.updateMapSize,this);this.ownerCt.on({"afterlayout":{fn:this.renderMap,scope:this,single:true}});}},onResize:function(){GeoExt.MapPanel.superclass.onResize.apply(this,arguments);this.updateMapSize();},onBeforeAdd:function(item){if(typeof item.addToMapPanel==="function"){item.addToMapPanel(this);}
GeoExt.MapPanel.superclass.onBeforeAdd.apply(this,arguments);},remove:function(item,autoDestroy){if(typeof item.removeFromMapPanel==="function"){item.removeFromMapPanel(this);}
GeoExt.MapPanel.superclass.remove.apply(this,arguments);},beforeDestroy:function(){if(this.ownerCt){this.ownerCt.un("move",this.updateMapSize,this);}
if(this.map&&this.map.events){this.map.events.un({"moveend":this.onMoveend,"changelayer":this.onLayerchange,scope:this});}
if(!this.initialConfig.map||!(this.initialConfig.map instanceof OpenLayers.Map)){if(this.map&&this.map.destroy){this.map.destroy();}}
delete this.map;GeoExt.MapPanel.superclass.beforeDestroy.apply(this,arguments);}});GeoExt.MapPanel.guess=function(){return Ext.ComponentMgr.all.find(function(o){return o instanceof GeoExt.MapPanel;});};Ext.reg('gx_mappanel',GeoExt.MapPanel);
Ext.namespace("GeoExt");GeoExt.PrintMapPanel=Ext.extend(GeoExt.MapPanel,{sourceMap:null,printProvider:null,printPage:null,previewScales:null,center:null,zoom:null,extent:null,currentZoom:null,initComponent:function(){if(this.sourceMap instanceof GeoExt.MapPanel){this.sourceMap=this.sourceMap.map;}
if(!this.map){this.map={};}
Ext.applyIf(this.map,{projection:this.sourceMap.getProjection(),maxExtent:this.sourceMap.getMaxExtent(),maxResolution:this.sourceMap.getMaxResolution(),units:this.sourceMap.getUnits()});if(!(this.printProvider instanceof GeoExt.data.PrintProvider)){this.printProvider=new GeoExt.data.PrintProvider(this.printProvider);}
this.printPage=new GeoExt.data.PrintPage({printProvider:this.printProvider});this.previewScales=new Ext.data.Store();this.previewScales.add(this.printProvider.scales.getRange());this.layers=[];var layer;Ext.each(this.sourceMap.layers,function(layer){var clone=layer.clone();layer.getVisibility()===true&&this.layers.push(clone);},this);this.extent=this.sourceMap.getExtent();GeoExt.PrintMapPanel.superclass.initComponent.call(this);this.printProvider.on("layoutchange",this.syncSize,this);this.printPage.on("change",this.fitZoom,this);this.map.events.register("moveend",this,this.updatePage);},afterRender:function(){GeoExt.PrintMapPanel.superclass.afterRender.apply(this,arguments);this.syncSize();if(this.initialConfig.limitScales===true){if(!this.ownerCt){this.calculatePreviewScales();}else{this.ownerCt.on({"afterlayout":{fn:this.calculatePreviewScales,scope:this,single:true}});}
this.on("resize",this.calculatePreviewScales,this);}},adjustSize:function(width,height){var printSize=this.printProvider.layout.get("size");var ratio=printSize.width/printSize.height;var ownerCt=this.ownerCt;var targetWidth=(ownerCt&&ownerCt.autoWidth)?0:(width||this.initialConfig.width);var targetHeight=(ownerCt&&ownerCt.autoHeight)?0:(height||this.initialConfig.height);if(targetWidth){height=targetWidth/ratio;if(targetHeight&&height>targetHeight){height=targetHeight;width=height*ratio;}else{width=targetWidth;}}else if(targetHeight){width=targetHeight*ratio;height=targetHeight;}
return{width:width,height:height};},fitZoom:function(){if(!this._updating&&this.printPage.scale){this._updating=true;var printBounds=this.printPage.getPrintExtent(this.map);this.currentZoom=this.map.getZoomForExtent(printBounds);this.map.zoomToExtent(printBounds);delete this._updating;}},updatePage:function(){if(!this._updating){var zoom=this.map.getZoom();this._updating=true;if(zoom===this.currentZoom){this.printPage.setCenter(this.map.getCenter());}else{this.printPage.fit(this.map);}
delete this._updating;this.currentZoom=zoom;}},calculatePreviewScales:function(){this.previewScales.removeAll();this.printPage.suspendEvents();var scale=this.printPage.scale;var viewSize=this.map.getSize();var scalesByZoom={};var zooms=[];this.printProvider.scales.each(function(rec){this.printPage.setScale(rec);var extent=this.printPage.getPrintExtent(this.map);var zoom=this.map.getZoomForExtent(extent);var idealResolution=Math.max(extent.getWidth()/viewSize.w,extent.getHeight()/viewSize.h);var resolution=this.map.getResolutionForZoom(zoom);var diff=Math.abs(idealResolution-resolution);if(!(zoom in scalesByZoom)||scalesByZoom[zoom].diff>diff){scalesByZoom[zoom]={rec:rec,diff:diff};zooms.indexOf(zoom)==-1&&zooms.push(zoom);}},this);for(var i=0,ii=zooms.length;i<ii;++i){this.previewScales.add(scalesByZoom[zooms[i]].rec);}
scale&&this.printPage.setScale(scale);this.printPage.resumeEvents();if(scale&&this.previewScales.getCount()>0){var maxScale=this.previewScales.getAt(0);var minScale=this.previewScales.getAt(this.previewScales.getCount()-1);if(scale.get("value")<minScale.get("value")){this.printPage.setScale(minScale);}else if(scale.get("value")>maxScale.get("value")){this.printPage.setScale(maxScale);}}
this.fitZoom();},print:function(options){this.printProvider.print(this.map,[this.printPage],options);},beforeDestroy:function(){this.map.events.unregister("moveend",this,this.updatePage);this.printPage.un("change",this.fitZoom,this);this.printProvider.un("layoutchange",this.syncSize,this);GeoExt.PrintMapPanel.superclass.beforeDestroy.apply(this,arguments);}});
Ext.reg('gx_printmappanel',GeoExt.PrintMapPanel);
Ext.namespace("GeoExt.form");GeoExt.form.toFilter=function(form,logicalOp,wildcard){if(form instanceof Ext.form.FormPanel){form=form.getForm();}
var filters=[],values=form.getValues(false);for(var prop in values){var s=prop.split("__");var value=values[prop],type;if(s.length>1&&(type=GeoExt.form.toFilter.FILTER_MAP[s[1]])!==undefined){prop=s[0];}else{type=OpenLayers.Filter.Comparison.EQUAL_TO;}
if(type===OpenLayers.Filter.Comparison.LIKE){switch(wildcard){case GeoExt.form.ENDS_WITH:value='.*'+value;break;case GeoExt.form.STARTS_WITH:value+='.*';break;case GeoExt.form.CONTAINS:value='.*'+value+'.*';break;default:break;}}
filters.push(new OpenLayers.Filter.Comparison({type:type,value:value,property:prop}));}
return new OpenLayers.Filter.Logical({type:logicalOp||OpenLayers.Filter.Logical.AND,filters:filters});};GeoExt.form.toFilter.FILTER_MAP={"eq":OpenLayers.Filter.Comparison.EQUAL_TO,"ne":OpenLayers.Filter.Comparison.NOT_EQUAL_TO,"lt":OpenLayers.Filter.Comparison.LESS_THAN,"le":OpenLayers.Filter.Comparison.LESS_THAN_OR_EQUAL_TO,"gt":OpenLayers.Filter.Comparison.GREATER_THAN,"ge":OpenLayers.Filter.Comparison.GREATER_THAN_OR_EQUAL_TO,"like":OpenLayers.Filter.Comparison.LIKE};GeoExt.form.ENDS_WITH=1;GeoExt.form.STARTS_WITH=2;GeoExt.form.CONTAINS=3;GeoExt.form.recordToField=function(record){var type=record.get("type");if(typeof type==="object"&&type.xtype){return type;}
var field;var name=record.get("name");var label=record.get("label");var restriction=record.get("restriction")||{};if(label==null){label=name;}
type=type.split(":").pop();var r=GeoExt.form.recordToField.REGEXES;if(type.match(r["text"])){var maxLength=restriction["maxLength"]!==undefined?parseFloat(restriction["maxLength"]):undefined;var minLength=restriction["minLength"]!==undefined?parseFloat(restriction["minLength"]):undefined;field={xtype:"textfield",name:name,fieldLabel:label,maxLength:maxLength,minLength:minLength};}else if(type.match(r["number"])){var maxValue=restriction["maxInclusive"]!==undefined?parseFloat(restriction["maxInclusive"]):undefined;var minValue=restriction["minInclusive"]!==undefined?parseFloat(restriction["minInclusive"]):undefined;field={xtype:"numberfield",name:name,fieldLabel:label,maxValue:maxValue,minValue:minValue};}else if(type.match(r["boolean"])){field={xtype:"checkbox",name:name,boxLabel:label};}else if(type.match(r["date"])){field={xtype:"datefield",fieldLabel:label,name:name};}
return field;}
GeoExt.form.recordToField.REGEXES={"text":new RegExp("^(text|string)$","i"),"number":new RegExp("^(number|float|decimal|double|int|long|integer|short)$","i"),"boolean":new RegExp("^(boolean)$","i"),"date":new RegExp("^(dateTime)$","i")};
Ext.namespace("GeoExt");GeoExt.ZoomSlider=Ext.extend(Ext.Slider,{map:null,baseCls:"gx-zoomslider",aggressive:false,updating:false,initComponent:function(){GeoExt.ZoomSlider.superclass.initComponent.call(this);if(this.map){if(this.map instanceof GeoExt.MapPanel){this.map=this.map.map;}
this.bind(this.map);}
if(this.aggressive===true){this.on('change',this.changeHandler,this);}else{this.on('changecomplete',this.changeHandler,this);}
this.on("beforedestroy",this.unbind,this);},onRender:function(){GeoExt.ZoomSlider.superclass.onRender.apply(this,arguments);this.el.addClass(this.baseCls);},afterRender:function(){Ext.Slider.superclass.afterRender.apply(this,arguments);this.update();},addToMapPanel:function(panel){this.on({render:function(){var el=this.getEl();el.setStyle({position:"absolute",zIndex:panel.map.Z_INDEX_BASE.Control});el.on({mousedown:this.stopMouseEvents,click:this.stopMouseEvents});},afterrender:function(){this.bind(panel.map);},scope:this});},stopMouseEvents:function(e){e.stopEvent();},removeFromMapPanel:function(panel){var el=this.getEl();el.un("mousedown",this.stopMouseEvents,this);el.un("click",this.stopMouseEvents,this);this.unbind();},bind:function(map){this.map=map;this.map.events.on({zoomend:this.update,changebaselayer:this.initZoomValues,scope:this});if(this.map.baseLayer){this.initZoomValues();this.update();}},unbind:function(){if(this.map){this.map.events.un({zoomend:this.update,changebaselayer:this.initZoomValues,scope:this});}},initZoomValues:function(){var layer=this.map.baseLayer;if(this.initialConfig.minValue===undefined){this.minValue=layer.minZoomLevel||0;}
if(this.initialConfig.maxValue===undefined){this.maxValue=layer.minZoomLevel==null?layer.numZoomLevels-1:layer.maxZoomLevel;}},getZoom:function(){return this.getValue();},getScale:function(){return OpenLayers.Util.getScaleFromResolution(this.map.getResolutionForZoom(this.getValue()),this.map.getUnits());},getResolution:function(){return this.map.getResolutionForZoom(this.getValue());},changeHandler:function(){if(this.map&&!this.updating){this.map.zoomTo(this.getValue());}},update:function(){if(this.rendered&&this.map){this.updating=true;this.setValue(this.map.getZoom());this.updating=false;}}});Ext.reg('gx_zoomslider',GeoExt.ZoomSlider);
Ext.namespace("GeoExt");GeoExt.Popup=Ext.extend(Ext.Window,{anchored:true,map:null,panIn:true,unpinnable:true,location:null,animCollapse:false,draggable:false,shadow:false,popupCls:"gx-popup",ancCls:null,initComponent:function(){if(this.map instanceof GeoExt.MapPanel){this.map=this.map.map;}
if(!this.map&&this.location instanceof OpenLayers.Feature.Vector&&this.location.layer){this.map=this.location.layer.map;}
if(this.location instanceof OpenLayers.Feature.Vector){this.location=this.location.geometry;}
if(this.location instanceof OpenLayers.Geometry){if(typeof this.location.getCentroid=="function"){this.location=this.location.getCentroid();}
this.location=this.location.getBounds().getCenterLonLat();}else if(this.location instanceof OpenLayers.Pixel){this.location=this.map.getLonLatFromViewPortPx(this.location);}
if(this.anchored){this.addAnchorEvents();}
this.baseCls=this.popupCls+" "+this.baseCls;this.elements+=',anc';GeoExt.Popup.superclass.initComponent.call(this);},onRender:function(ct,position){GeoExt.Popup.superclass.onRender.call(this,ct,position);this.ancCls=this.popupCls+"-anc";this.createElement("anc",this.el.dom);},initTools:function(){if(this.unpinnable){this.addTool({id:'unpin',handler:this.unanchorPopup.createDelegate(this,[])});}
GeoExt.Popup.superclass.initTools.call(this);},show:function(){GeoExt.Popup.superclass.show.apply(this,arguments);if(this.anchored){this.position();if(this.panIn&&!this._mapMove){this.panIntoView();}}},maximize:function(){if(!this.maximized&&this.anc){this.unanchorPopup();}
GeoExt.Popup.superclass.maximize.apply(this,arguments);},setSize:function(w,h){if(this.anc){var ancSize=this.anc.getSize();if(typeof w=='object'){h=w.height-ancSize.height;w=w.width;}else if(!isNaN(h)){h=h-ancSize.height;}}
GeoExt.Popup.superclass.setSize.call(this,w,h);},position:function(){if(this._mapMove===true){var visible=this.map.getExtent().containsLonLat(this.location);if(visible!==this.isVisible()){this.setVisible(visible);}}
if(this.isVisible()){var centerPx=this.map.getViewPortPxFromLonLat(this.location);var mapBox=Ext.fly(this.map.div).getBox();var anc=this.anc;var dx=anc.getLeft(true)+anc.getWidth()/2;var dy=this.el.getHeight();this.setPosition(centerPx.x+mapBox.x-dx,centerPx.y+mapBox.y-dy);}},unanchorPopup:function(){this.removeAnchorEvents();this.draggable=true;this.header.addClass("x-window-draggable");this.dd=new Ext.Window.DD(this);this.anc.remove();this.anc=null;this.tools.unpin.hide();},panIntoView:function(){var mapBox=Ext.fly(this.map.div).getBox();var popupPos=this.getPosition(true);popupPos[0]-=mapBox.x;popupPos[1]-=mapBox.y;var panelSize=[mapBox.width,mapBox.height];var popupSize=this.getSize();var newPos=[popupPos[0],popupPos[1]];var padding=this.map.paddingForPopups;if(popupPos[0]<padding.left){newPos[0]=padding.left;}else if(popupPos[0]+popupSize.width>panelSize[0]-padding.right){newPos[0]=panelSize[0]-padding.right-popupSize.width;}
if(popupPos[1]<padding.top){newPos[1]=padding.top;}else if(popupPos[1]+popupSize.height>panelSize[1]-padding.bottom){newPos[1]=panelSize[1]-padding.bottom-popupSize.height;}
var dx=popupPos[0]-newPos[0];var dy=popupPos[1]-newPos[1];this.map.pan(dx,dy);},onMapMove:function(){this._mapMove=true;this.position();delete this._mapMove;},addAnchorEvents:function(){this.map.events.on({"move":this.onMapMove,scope:this});this.on({"resize":this.position,"collapse":this.position,"expand":this.position,scope:this});},removeAnchorEvents:function(){this.map.events.un({"move":this.onMapMove,scope:this});this.un("resize",this.position,this);this.un("collapse",this.position,this);this.un("expand",this.position,this);},beforeDestroy:function(){if(this.anchored){this.removeAnchorEvents();}
GeoExt.Popup.superclass.beforeDestroy.call(this);}});Ext.reg('gx_popup',GeoExt.Popup);
Ext.namespace('GeoExt');GeoExt.LegendPanel=Ext.extend(Ext.Panel,{dynamic:true,layerStore:null,preferredTypes:null,filter:function(record){return true;},initComponent:function(){GeoExt.LegendPanel.superclass.initComponent.call(this);},onRender:function(){GeoExt.LegendPanel.superclass.onRender.apply(this,arguments);if(!this.layerStore){this.layerStore=GeoExt.MapPanel.guess().layers;}
this.layerStore.each(function(record){this.addLegend(record);},this);if(this.dynamic){this.layerStore.on({"add":this.onStoreAdd,"remove":this.onStoreRemove,"clear":this.onStoreClear,scope:this});}},recordIndexToPanelIndex:function(index){var store=this.layerStore;var count=store.getCount();var panelIndex=-1;var legendCount=this.items?this.items.length:0;var record,layer;for(var i=count-1;i>=0;--i){record=store.getAt(i);layer=record.getLayer();var types=GeoExt.LayerLegend.getTypes(record);if(layer.displayInLayerSwitcher&&types.length>0&&(store.getAt(i).get("hideInLegend")!==true)){++panelIndex;if(index===i||panelIndex>legendCount-1){break;}}}
return panelIndex;},getIdForLayer:function(layer){return this.id+"-"+layer.id;},onStoreAdd:function(store,records,index){var panelIndex=this.recordIndexToPanelIndex(index+records.length-1);for(var i=0,len=records.length;i<len;i++){this.addLegend(records[i],panelIndex);}
this.doLayout();},onStoreRemove:function(store,record,index){this.removeLegend(record);},removeLegend:function(record){if(this.items){var legend=this.getComponent(this.getIdForLayer(record.getLayer()));if(legend){this.remove(legend,true);this.doLayout();}}},onStoreClear:function(store){this.removeAllLegends();},removeAllLegends:function(){this.removeAll(true);this.doLayout();},addLegend:function(record,index){if(this.filter(record)===true){var layer=record.getLayer();index=index||0;var legend;var types=GeoExt.LayerLegend.getTypes(record,this.preferredTypes);if(layer.displayInLayerSwitcher&&!record.get('hideInLegend')&&types.length>0){this.insert(index,{xtype:types[0],id:this.getIdForLayer(layer),layerRecord:record,hidden:!((!layer.map&&layer.visibility)||(layer.getVisibility()&&layer.calculateInRange()))});}}},onDestroy:function(){if(this.layerStore){this.layerStore.un("add",this.onStoreAdd,this);this.layerStore.un("remove",this.onStoreRemove,this);this.layerStore.un("clear",this.onStoreClear,this);}
GeoExt.LegendPanel.superclass.onDestroy.apply(this,arguments);}});Ext.reg('gx_legendpanel',GeoExt.LegendPanel);
Ext.namespace('GeoExt');GeoExt.FeatureRenderer=Ext.extend(Ext.BoxComponent,{feature:undefined,symbolizers:[OpenLayers.Feature.Vector.style["default"]],symbolType:"Polygon",resolution:1,minWidth:20,minHeight:20,renderers:["SVG","VML","Canvas"],rendererOptions:null,pointFeature:undefined,lineFeature:undefined,polygonFeature:undefined,renderer:null,initComponent:function(){GeoExt.FeatureRenderer.superclass.initComponent.apply(this,arguments);Ext.applyIf(this,{pointFeature:new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Point(0,0)),lineFeature:new OpenLayers.Feature.Vector(new OpenLayers.Geometry.LineString([new OpenLayers.Geometry.Point(-8,-3),new OpenLayers.Geometry.Point(-3,3),new OpenLayers.Geometry.Point(3,-3),new OpenLayers.Geometry.Point(8,3)])),polygonFeature:new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Polygon([new OpenLayers.Geometry.LinearRing([new OpenLayers.Geometry.Point(-8,-4),new OpenLayers.Geometry.Point(-6,-6),new OpenLayers.Geometry.Point(6,-6),new OpenLayers.Geometry.Point(8,-4),new OpenLayers.Geometry.Point(8,4),new OpenLayers.Geometry.Point(6,6),new OpenLayers.Geometry.Point(-6,6),new OpenLayers.Geometry.Point(-8,4)])]))});if(!this.feature){this.setFeature(null,{draw:false});}
this.addEvents("click");},initCustomEvents:function(){this.clearCustomEvents();this.el.on("click",this.onClick,this);},clearCustomEvents:function(){if(this.el&&this.el.removeAllListeners){this.el.removeAllListeners();}},onClick:function(){this.fireEvent("click",this);},onRender:function(ct,position){if(!this.el){this.el=document.createElement("div");this.el.id=this.getId();}
if(!this.renderer||!this.renderer.supported()){this.assignRenderer();}
this.renderer.map={getResolution:(function(){return this.resolution;}).createDelegate(this)};GeoExt.FeatureRenderer.superclass.onRender.apply(this,arguments);this.drawFeature();},afterRender:function(){GeoExt.FeatureRenderer.superclass.afterRender.apply(this,arguments);this.initCustomEvents();},onResize:function(w,h){this.setRendererDimensions();GeoExt.FeatureRenderer.superclass.onResize.apply(this,arguments);},setRendererDimensions:function(){var gb=this.feature.geometry.getBounds();var gw=gb.getWidth();var gh=gb.getHeight();var resolution=this.initialConfig.resolution;if(!resolution){resolution=Math.max(gw/this.width||0,gh/this.height||0)||1;}
this.resolution=resolution;var width=Math.max(this.width||this.minWidth,gw/resolution);var height=Math.max(this.height||this.minHeight,gh/resolution);var center=gb.getCenterPixel();var bhalfw=width*resolution/2;var bhalfh=height*resolution/2;var bounds=new OpenLayers.Bounds(center.x-bhalfw,center.y-bhalfh,center.x+bhalfw,center.y+bhalfh);this.renderer.setSize(new OpenLayers.Size(Math.round(width),Math.round(height)));this.renderer.setExtent(bounds,true);},assignRenderer:function(){for(var i=0,len=this.renderers.length;i<len;++i){var Renderer=OpenLayers.Renderer[this.renderers[i]];if(Renderer&&Renderer.prototype.supported()){this.renderer=new Renderer(this.el,this.rendererOptions);break;}}},setSymbolizers:function(symbolizers,options){this.symbolizers=symbolizers;if(!options||options.draw){this.drawFeature();}},setSymbolType:function(type,options){this.symbolType=type;this.setFeature(null,options);},setFeature:function(feature,options){this.feature=feature||this[this.symbolType.toLowerCase()+"Feature"];if(!options||options.draw){this.drawFeature();}},drawFeature:function(){this.renderer.clear();this.setRendererDimensions();var Symbolizer=OpenLayers.Symbolizer;var Text=Symbolizer&&Symbolizer.Text;var symbolizer,feature,geomType;for(var i=0,len=this.symbolizers.length;i<len;++i){symbolizer=this.symbolizers[i];feature=this.feature;if(!Text||!(symbolizer instanceof Text)){if(Symbolizer&&(symbolizer instanceof Symbolizer)){symbolizer=symbolizer.clone();if(!this.initialConfig.feature){geomType=symbolizer.CLASS_NAME.split(".").pop().toLowerCase();feature=this[geomType+"Feature"];}}else{symbolizer=Ext.apply({},symbolizer);}
this.renderer.drawFeature(feature.clone(),symbolizer);}}},update:function(options){options=options||{};if(options.feature){this.setFeature(options.feature,{draw:false});}else if(options.symbolType){this.setSymbolType(options.symbolType,{draw:false});}
if(options.symbolizers){this.setSymbolizers(options.symbolizers,{draw:false});}
this.drawFeature();},beforeDestroy:function(){this.clearCustomEvents();if(this.renderer){this.renderer.destroy();}}});Ext.reg('gx_renderer',GeoExt.FeatureRenderer);
Ext.namespace('GeoExt');GeoExt.UrlLegend=Ext.extend(GeoExt.LayerLegend,{initComponent:function(){GeoExt.UrlLegend.superclass.initComponent.call(this);this.add(new GeoExt.LegendImage({url:this.layerRecord.get("legendURL")}));},update:function(){GeoExt.UrlLegend.superclass.update.apply(this,arguments);this.items.get(1).setUrl(this.layerRecord.get("legendURL"));}});GeoExt.UrlLegend.supports=function(layerRecord){return layerRecord.get("legendURL")!=null;};GeoExt.LayerLegend.types["gx_urllegend"]=GeoExt.UrlLegend;Ext.reg('gx_urllegend',GeoExt.UrlLegend);
Ext.namespace("GeoExt.form");GeoExt.form.FormPanel=Ext.extend(Ext.form.FormPanel,{protocol:null,createForm:function(){delete this.initialConfig.listeners;return new GeoExt.form.BasicForm(null,this.initialConfig);},search:function(options){this.getForm().search(options);}});Ext.reg("gx_formpanel",GeoExt.form.FormPanel);
Ext.namespace("GeoExt.form");GeoExt.form.BasicForm=Ext.extend(Ext.form.BasicForm,{protocol:null,prevResponse:null,autoAbort:true,doAction:function(action,options){if(action=="search"){options=Ext.applyIf(options||{},{protocol:this.protocol,abortPrevious:this.autoAbort});action=new GeoExt.form.SearchAction(this,options);}
return GeoExt.form.BasicForm.superclass.doAction.call(this,action,options);},search:function(options){return this.doAction("search",options);}});
Ext.namespace("GeoExt.form");GeoExt.form.SearchAction=Ext.extend(Ext.form.Action,{type:"search",response:null,constructor:function(form,options){GeoExt.form.SearchAction.superclass.constructor.call(this,form,options);},run:function(){var o=this.options;var f=GeoExt.form.toFilter(this.form,o.logicalOp,o.wildcard);if(o.clientValidation===false||this.form.isValid()){if(o.abortPrevious&&this.form.prevResponse){o.protocol.abort(this.form.prevResponse);}
this.form.prevResponse=o.protocol.read(Ext.applyIf({filter:f,callback:this.handleResponse,scope:this},o));}else if(o.clientValidation!==false){this.failureType=Ext.form.Action.CLIENT_INVALID;this.form.afterAction(this,false);}},handleResponse:function(response){this.form.prevResponse=null;this.response=response;if(response.success()){this.form.afterAction(this,true);}else{this.form.afterAction(this,false);}
var o=this.options;if(o.callback){o.callback.call(o.scope,response);}}});
Ext.namespace('GeoExt.grid');GeoExt.grid.FeatureSelectionModelMixin=function(){return{autoActivateControl:true,layerFromStore:true,selectControl:null,bound:false,superclass:null,constructor:function(config){config=config||{};if(config.selectControl instanceof OpenLayers.Control.SelectFeature){if(!config.singleSelect){var ctrl=config.selectControl;config.singleSelect=!(ctrl.multiple||!!ctrl.multipleKey);}}else if(config.layer instanceof OpenLayers.Layer.Vector){this.selectControl=this.createSelectControl(config.layer,config.selectControl);delete config.layer;delete config.selectControl;}
this.superclass=arguments.callee.superclass;this.superclass.constructor.call(this,config);},initEvents:function(){this.superclass.initEvents.call(this);if(this.layerFromStore){var layer=this.grid.getStore()&&this.grid.getStore().layer;if(layer&&!(this.selectControl instanceof OpenLayers.Control.SelectFeature)){this.selectControl=this.createSelectControl(layer,this.selectControl);}}
if(this.selectControl){this.bind(this.selectControl);}},createSelectControl:function(layer,config){config=config||{};var singleSelect=config.singleSelect!==undefined?config.singleSelect:this.singleSelect;config=OpenLayers.Util.extend({toggle:true,multipleKey:singleSelect?null:(Ext.isMac?"metaKey":"ctrlKey")},config);var selectControl=new OpenLayers.Control.SelectFeature(layer,config);layer.map.addControl(selectControl);return selectControl;},bind:function(obj,options){if(!this.bound){options=options||{};this.selectControl=obj;if(obj instanceof OpenLayers.Layer.Vector){this.selectControl=this.createSelectControl(obj,options.controlConfig);}
if(this.autoActivateControl){this.selectControl.activate();}
var layers=this.getLayers();for(var i=0,len=layers.length;i<len;i++){layers[i].events.on({featureselected:this.featureSelected,featureunselected:this.featureUnselected,scope:this});}
this.on("rowselect",this.rowSelected,this);this.on("rowdeselect",this.rowDeselected,this);this.bound=true;}
return this.selectControl;},unbind:function(){var selectControl=this.selectControl;if(this.bound){var layers=this.getLayers();for(var i=0,len=layers.length;i<len;i++){layers[i].events.un({featureselected:this.featureSelected,featureunselected:this.featureUnselected,scope:this});}
this.un("rowselect",this.rowSelected,this);this.un("rowdeselect",this.rowDeselected,this);if(this.autoActivateControl){selectControl.deactivate();}
this.selectControl=null;this.bound=false;}
return selectControl;},featureSelected:function(evt){if(!this._selecting){var store=this.grid.store;var row=store.findBy(function(record,id){return record.getFeature()==evt.feature;});if(row!=-1&&!this.isSelected(row)){this._selecting=true;this.selectRow(row,!this.singleSelect);this._selecting=false;this.grid.getView().focusRow(row);}}},featureUnselected:function(evt){if(!this._selecting){var store=this.grid.store;var row=store.findBy(function(record,id){return record.getFeature()==evt.feature;});if(row!=-1&&this.isSelected(row)){this._selecting=true;this.deselectRow(row);this._selecting=false;this.grid.getView().focusRow(row);}}},rowSelected:function(model,row,record){var feature=record.getFeature();if(!this._selecting&&feature){var layers=this.getLayers();for(var i=0,len=layers.length;i<len;i++){if(layers[i].selectedFeatures.indexOf(feature)==-1){this._selecting=true;this.selectControl.select(feature);this._selecting=false;break;}}}},rowDeselected:function(model,row,record){var feature=record.getFeature();if(!this._selecting&&feature){var layers=this.getLayers();for(var i=0,len=layers.length;i<len;i++){if(layers[i].selectedFeatures.indexOf(feature)!=-1){this._selecting=true;this.selectControl.unselect(feature);this._selecting=false;break;}}}},getLayers:function(){return this.selectControl.layers||[this.selectControl.layer];}};};GeoExt.grid.FeatureSelectionModel=Ext.extend(Ext.grid.RowSelectionModel,new GeoExt.grid.FeatureSelectionModelMixin);
Ext.namespace("GeoExt");GeoExt.SliderTip=Ext.extend(Ext.slider.Tip,{hover:true,minWidth:10,offsets:[0,-10],dragging:false,init:function(slider){GeoExt.SliderTip.superclass.init.apply(this,arguments);if(this.hover){slider.on("render",this.registerThumbListeners,this);}
this.slider=slider;},registerThumbListeners:function(){var thumb,el;for(var i=0,ii=this.slider.thumbs.length;i<ii;++i){thumb=this.slider.thumbs[i];el=thumb.tracker.el;(function(thumb,el){el.on({mouseover:function(e){this.onSlide(this.slider,e,thumb);this.dragging=false;},mouseout:function(){if(!this.dragging){this.hide.apply(this,arguments);}},scope:this})}).apply(this,[thumb,el]);}},onSlide:function(slider,e,thumb){this.dragging=true;return GeoExt.SliderTip.superclass.onSlide.apply(this,arguments);}});
Ext.namespace("GeoExt");GeoExt.ZoomSliderTip=Ext.extend(GeoExt.SliderTip,{template:'<div>Zoom Level: {zoom}</div>'+'<div>Resolution: {resolution}</div>'+'<div>Scale: 1 : {scale}</div>',compiledTemplate:null,init:function(slider){this.compiledTemplate=new Ext.Template(this.template);GeoExt.ZoomSliderTip.superclass.init.call(this,slider);},getText:function(thumb){var data={zoom:thumb.value,resolution:this.slider.getResolution(),scale:Math.round(this.slider.getScale())};return this.compiledTemplate.apply(data);}});
Ext.namespace("GeoExt");GeoExt.LayerOpacitySliderTip=Ext.extend(GeoExt.SliderTip,{template:'<div>{opacity}%</div>',compiledTemplate:null,init:function(slider){this.compiledTemplate=new Ext.Template(this.template);GeoExt.LayerOpacitySliderTip.superclass.init.call(this,slider);},getText:function(thumb){var data={opacity:thumb.value};return this.compiledTemplate.apply(data);}});
Ext.namespace("GeoExt.tree");GeoExt.tree.LayerContainer=Ext.extend(Ext.tree.AsyncTreeNode,{constructor:function(config){config=Ext.applyIf(config||{},{text:"Layers"});this.loader=config.loader instanceof GeoExt.tree.LayerLoader?config.loader:new GeoExt.tree.LayerLoader(Ext.applyIf(config.loader||{},{store:config.layerStore}));GeoExt.tree.LayerContainer.superclass.constructor.call(this,config);},recordIndexToNodeIndex:function(index){var store=this.loader.store;var count=store.getCount();var nodeCount=this.childNodes.length;var nodeIndex=-1;for(var i=count-1;i>=0;--i){if(this.loader.filter(store.getAt(i))===true){++nodeIndex;if(index===i||nodeIndex>nodeCount-1){break;}}}
return nodeIndex;},destroy:function(){delete this.layerStore;GeoExt.tree.LayerContainer.superclass.destroy.apply(this,arguments);}});Ext.tree.TreePanel.nodeTypes.gx_layercontainer=GeoExt.tree.LayerContainer;
Ext.namespace("GeoExt.tree");GeoExt.tree.BaseLayerContainer=Ext.extend(GeoExt.tree.LayerContainer,{constructor:function(config){config=Ext.applyIf(config||{},{text:"Base Layer",loader:{}});config.loader=Ext.applyIf(config.loader,{baseAttrs:Ext.applyIf(config.loader.baseAttrs||{},{iconCls:'gx-tree-baselayer-icon',checkedGroup:'baselayer'}),filter:function(record){var layer=record.getLayer();return layer.displayInLayerSwitcher===true&&layer.isBaseLayer===true;}});GeoExt.tree.BaseLayerContainer.superclass.constructor.call(this,config);}});Ext.tree.TreePanel.nodeTypes.gx_baselayercontainer=GeoExt.tree.BaseLayerContainer;
Ext.namespace("GeoExt.tree");GeoExt.tree.TreeNodeUIEventMixin=function(){return{constructor:function(node){node.addEvents("rendernode","rawclicknode");this.superclass=arguments.callee.superclass;this.superclass.constructor.apply(this,arguments);},render:function(bulkRender){if(!this.rendered){this.superclass.render.apply(this,arguments);this.fireEvent("rendernode",this.node);}},onClick:function(e){if(this.fireEvent("rawclicknode",this.node,e)!==false){this.superclass.onClick.apply(this,arguments);}}}};
Ext.namespace("GeoExt.tree");GeoExt.tree.OverlayLayerContainer=Ext.extend(GeoExt.tree.LayerContainer,{constructor:function(config){config=Ext.applyIf(config||{},{text:"Overlays"});config.loader=Ext.applyIf(config.loader||{},{filter:function(record){var layer=record.getLayer();return layer.displayInLayerSwitcher===true&&layer.isBaseLayer===false;}});GeoExt.tree.OverlayLayerContainer.superclass.constructor.call(this,config);}});Ext.tree.TreePanel.nodeTypes.gx_overlaylayercontainer=GeoExt.tree.OverlayLayerContainer;
Ext.namespace("GeoExt.tree");GeoExt.tree.LayerNodeUI=Ext.extend(Ext.tree.TreeNodeUI,{constructor:function(config){GeoExt.tree.LayerNodeUI.superclass.constructor.apply(this,arguments);},render:function(bulkRender){var a=this.node.attributes;if(a.checked===undefined){a.checked=this.node.layer.getVisibility();}
GeoExt.tree.LayerNodeUI.superclass.render.apply(this,arguments);var cb=this.checkbox;if(a.checkedGroup){var radio=Ext.DomHelper.insertAfter(cb,['<input type="radio" name="',a.checkedGroup,'_checkbox" class="',cb.className,cb.checked?'" checked="checked"':'','"></input>'].join(""));radio.defaultChecked=cb.defaultChecked;Ext.get(cb).remove();this.checkbox=radio;}
this.enforceOneVisible();},onClick:function(e){if(e.getTarget('.x-tree-node-cb',1)){this.toggleCheck(this.isChecked());}else{GeoExt.tree.LayerNodeUI.superclass.onClick.apply(this,arguments);}},toggleCheck:function(value){value=(value===undefined?!this.isChecked():value);GeoExt.tree.LayerNodeUI.superclass.toggleCheck.call(this,value);this.enforceOneVisible();},enforceOneVisible:function(){var attributes=this.node.attributes;var group=attributes.checkedGroup;if(group&&group!=="gx_baselayer"){var layer=this.node.layer;var checkedNodes=this.node.getOwnerTree().getChecked();var checkedCount=0;Ext.each(checkedNodes,function(n){var l=n.layer
if(!n.hidden&&n.attributes.checkedGroup===group){checkedCount++;if(l!=layer&&attributes.checked){l.setVisibility(false);}}});if(checkedCount===0&&attributes.checked==false){layer.setVisibility(true);}}},appendDDGhost:function(ghostNode){var n=this.elNode.cloneNode(true);var radio=Ext.DomQuery.select("input[type='radio']",n);Ext.each(radio,function(r){r.name=r.name+"_clone";});ghostNode.appendChild(n);}});GeoExt.tree.LayerNode=Ext.extend(Ext.tree.AsyncTreeNode,{layer:null,layerStore:null,constructor:function(config){config.leaf=config.leaf||!(config.children||config.loader);if(!config.iconCls&&!config.children){config.iconCls="gx-tree-layer-icon";}
if(config.loader&&!(config.loader instanceof Ext.tree.TreeLoader)){config.loader=new GeoExt.tree.LayerParamLoader(config.loader);}
this.defaultUI=this.defaultUI||GeoExt.tree.LayerNodeUI;Ext.apply(this,{layer:config.layer,layerStore:config.layerStore});if(config.text){this.fixedText=true;}
GeoExt.tree.LayerNode.superclass.constructor.apply(this,arguments);},render:function(bulkRender){var layer=this.layer instanceof OpenLayers.Layer&&this.layer;if(!layer){if(!this.layerStore||this.layerStore=="auto"){this.layerStore=GeoExt.MapPanel.guess().layers;}
var i=this.layerStore.findBy(function(o){return o.get("title")==this.layer;},this);if(i!=-1){layer=this.layerStore.getAt(i).getLayer();}}
if(!this.rendered||!layer){var ui=this.getUI();if(layer){this.layer=layer;if(layer.isBaseLayer){this.draggable=false;Ext.applyIf(this.attributes,{checkedGroup:"gx_baselayer"});}
if(!this.text){this.text=layer.name;}
ui.show();this.addVisibilityEventHandlers();}else{ui.hide();}
if(this.layerStore instanceof GeoExt.data.LayerStore){this.addStoreEventHandlers(layer);}}
GeoExt.tree.LayerNode.superclass.render.apply(this,arguments);},addVisibilityEventHandlers:function(){this.layer.events.on({"visibilitychanged":this.onLayerVisibilityChanged,scope:this});this.on({"checkchange":this.onCheckChange,scope:this});},onLayerVisibilityChanged:function(){if(!this._visibilityChanging){this.getUI().toggleCheck(this.layer.getVisibility());}},onCheckChange:function(node,checked){if(checked!=this.layer.getVisibility()){this._visibilityChanging=true;var layer=this.layer;if(checked&&layer.isBaseLayer&&layer.map){layer.map.setBaseLayer(layer);}else{layer.setVisibility(checked);}
delete this._visibilityChanging;}},addStoreEventHandlers:function(){this.layerStore.on({"add":this.onStoreAdd,"remove":this.onStoreRemove,"update":this.onStoreUpdate,scope:this});},onStoreAdd:function(store,records,index){var l;for(var i=0;i<records.length;++i){l=records[i].getLayer();if(this.layer==l){this.getUI().show();break;}else if(this.layer==l.name){this.render();break;}}},onStoreRemove:function(store,record,index){if(this.layer==record.getLayer()){this.getUI().hide();}},onStoreUpdate:function(store,record,operation){var layer=record.getLayer();if(!this.fixedText&&(this.layer==layer&&this.text!==layer.name)){this.setText(layer.name);}},destroy:function(){var layer=this.layer;if(layer instanceof OpenLayers.Layer){layer.events.un({"visibilitychanged":this.onLayerVisibilityChanged,scope:this});}
delete this.layer;var layerStore=this.layerStore;if(layerStore){layerStore.un("add",this.onStoreAdd,this);layerStore.un("remove",this.onStoreRemove,this);layerStore.un("update",this.onStoreUpdate,this);}
delete this.layerStore;this.un("checkchange",this.onCheckChange,this);GeoExt.tree.LayerNode.superclass.destroy.apply(this,arguments);}});Ext.tree.TreePanel.nodeTypes.gx_layer=GeoExt.tree.LayerNode;
Ext.namespace("GeoExt.tree");GeoExt.tree.LayerLoader=function(config){Ext.apply(this,config);this.addEvents("beforeload","load");GeoExt.tree.LayerLoader.superclass.constructor.call(this);};Ext.extend(GeoExt.tree.LayerLoader,Ext.util.Observable,{store:null,filter:function(record){return record.getLayer().displayInLayerSwitcher==true;},baseAttrs:null,uiProviders:null,load:function(node,callback){if(this.fireEvent("beforeload",this,node)){this.removeStoreHandlers();while(node.firstChild){node.removeChild(node.firstChild);}
if(!this.uiProviders){this.uiProviders=node.getOwnerTree().getLoader().uiProviders;}
if(!this.store){this.store=GeoExt.MapPanel.guess().layers;}
this.store.each(function(record){this.addLayerNode(node,record);},this);this.addStoreHandlers(node);if(typeof callback=="function"){callback();}
this.fireEvent("load",this,node);}},onStoreAdd:function(store,records,index,node){if(!this._reordering){var nodeIndex=node.recordIndexToNodeIndex(index+records.length-1);for(var i=0;i<records.length;++i){this.addLayerNode(node,records[i],nodeIndex);}}},onStoreRemove:function(store,record,index,node){if(!this._reordering){this.removeLayerNode(node,record);}},addLayerNode:function(node,layerRecord,index){index=index||0;if(this.filter(layerRecord)===true){var child=this.createNode({nodeType:'gx_layer',layer:layerRecord.getLayer(),layerStore:this.store});var sibling=node.item(index);if(sibling){node.insertBefore(child,sibling);}else{node.appendChild(child);}
child.on("move",this.onChildMove,this);}},removeLayerNode:function(node,layerRecord){if(this.filter(layerRecord)===true){var child=node.findChildBy(function(node){return node.layer==layerRecord.getLayer();});if(child){child.un("move",this.onChildMove,this);child.remove();node.reload();}}},onChildMove:function(tree,node,oldParent,newParent,index){this._reordering=true;var record=this.store.getByLayer(node.layer);if(newParent instanceof GeoExt.tree.LayerContainer&&this.store===newParent.loader.store){newParent.loader._reordering=true;this.store.remove(record);var newRecordIndex;if(newParent.childNodes.length>1){var searchIndex=(index===0)?index+1:index-1;newRecordIndex=this.store.findBy(function(r){return newParent.childNodes[searchIndex].layer===r.getLayer();});index===0&&newRecordIndex++;}else if(oldParent.parentNode===newParent.parentNode){var prev=newParent;do{prev=prev.previousSibling;}while(prev&&!(prev instanceof GeoExt.tree.LayerContainer&&prev.lastChild));if(prev){newRecordIndex=this.store.findBy(function(r){return prev.lastChild.layer===r.getLayer();});}else{var next=newParent;do{next=next.nextSibling;}while(next&&!(next instanceof GeoExt.tree.LayerContainer&&next.firstChild));if(next){newRecordIndex=this.store.findBy(function(r){return next.firstChild.layer===r.getLayer();});}
newRecordIndex++;}}
if(newRecordIndex!==undefined){this.store.insert(newRecordIndex,[record]);window.setTimeout(function(){newParent.reload();oldParent.reload();});}else{this.store.insert(oldRecordIndex,[record]);}
delete newParent.loader._reordering;}
delete this._reordering;},addStoreHandlers:function(node){if(!this._storeHandlers){this._storeHandlers={"add":this.onStoreAdd.createDelegate(this,[node],true),"remove":this.onStoreRemove.createDelegate(this,[node],true)};for(var evt in this._storeHandlers){this.store.on(evt,this._storeHandlers[evt],this);}}},removeStoreHandlers:function(){if(this._storeHandlers){for(var evt in this._storeHandlers){this.store.un(evt,this._storeHandlers[evt],this);}
delete this._storeHandlers;}},createNode:function(attr){if(this.baseAttrs){Ext.apply(attr,this.baseAttrs);}
if(typeof attr.uiProvider=='string'){attr.uiProvider=this.uiProviders[attr.uiProvider]||eval(attr.uiProvider);}
attr.nodeType=attr.nodeType||"gx_layer";return new Ext.tree.TreePanel.nodeTypes[attr.nodeType](attr);},destroy:function(){this.removeStoreHandlers();}});
Ext.namespace("GeoExt.tree");GeoExt.tree.LayerParamNode=Ext.extend(Ext.tree.TreeNode,{layer:null,param:null,item:null,delimiter:null,allItems:null,constructor:function(attributes){var config=attributes||{};config.iconCls=config.iconCls||"gx-tree-layerparam-icon";config.text=config.text||config.item;this.param=config.param;this.item=config.item;this.delimiter=config.delimiter||",";this.allItems=config.allItems;GeoExt.tree.LayerParamNode.superclass.constructor.apply(this,arguments);this.getLayer();if(this.layer){if(!this.allItems){this.allItems=this.getItemsFromLayer();}
if(this.attributes.checked==null){this.attributes.checked=this.layer.getVisibility()&&this.getItemsFromLayer().indexOf(this.item)>=0;}else{this.onCheckChange(this,this.attributes.checked);}
this.layer.events.on({"visibilitychanged":this.onLayerVisibilityChanged,scope:this});this.on({"checkchange":this.onCheckChange,scope:this});}},getLayer:function(){if(!this.layer){var layer=this.attributes.layer;if(typeof layer=="string"){var store=this.attributes.layerStore||GeoExt.MapPanel.guess().layers;var i=store.findBy(function(o){return o.get("title")==layer;});layer=i!=-1?store.getAt(i).getLayer():null;}
this.layer=layer;}
return this.layer;},getItemsFromLayer:function(){var paramValue=this.layer.params[this.param];return paramValue instanceof Array?paramValue:(paramValue?paramValue.split(this.delimiter):[]);},createParams:function(items){var params={};params[this.param]=this.layer.params[this.param]instanceof Array?items:items.join(this.delimiter);return params;},onLayerVisibilityChanged:function(){if(this.getItemsFromLayer().length===0){this.layer.mergeNewParams(this.createParams(this.allItems));}
var visible=this.layer.getVisibility();if(visible&&this.getItemsFromLayer().indexOf(this.item)!==-1){this.getUI().toggleCheck(true);}
if(!visible){this.layer.mergeNewParams(this.createParams([]));this.getUI().toggleCheck(false);}},onCheckChange:function(node,checked){var layer=this.layer;var newItems=[];var curItems=this.getItemsFromLayer();if(checked===true&&layer.getVisibility()===false&&curItems.length===this.allItems.length){curItems=[];}
Ext.each(this.allItems,function(item){if((item!==this.item&&curItems.indexOf(item)!==-1)||(checked===true&&item===this.item)){newItems.push(item);}},this);var visible=(newItems.length>0);visible&&layer.mergeNewParams(this.createParams(newItems));if(visible!==layer.getVisibility()){layer.setVisibility(visible);}
(!visible)&&layer.mergeNewParams(this.createParams([]));},destroy:function(){var layer=this.layer;if(layer instanceof OpenLayers.Layer){layer.events.un({"visibilitychanged":this.onLayerVisibilityChanged,scope:this});}
delete this.layer;this.un("checkchange",this.onCheckChange,this);GeoExt.tree.LayerParamNode.superclass.destroy.apply(this,arguments);}});Ext.tree.TreePanel.nodeTypes.gx_layerparam=GeoExt.tree.LayerParamNode;
Ext.namespace("GeoExt.tree");GeoExt.tree.LayerParamLoader=function(config){Ext.apply(this,config);this.addEvents("beforeload","load");GeoExt.tree.LayerParamLoader.superclass.constructor.call(this);};Ext.extend(GeoExt.tree.LayerParamLoader,Ext.util.Observable,{param:null,delimiter:",",load:function(node,callback){if(this.fireEvent("beforeload",this,node)){while(node.firstChild){node.removeChild(node.firstChild);}
var paramValue=(node.layer instanceof OpenLayers.Layer.HTTPRequest)&&node.layer.params[this.param];if(paramValue){var items=(paramValue instanceof Array)?paramValue.slice():paramValue.split(this.delimiter);Ext.each(items,function(item,index,allItems){this.addParamNode(item,allItems,node);},this);}
if(typeof callback=="function"){callback();}
this.fireEvent("load",this,node);}},addParamNode:function(paramItem,allParamItems,node){var child=this.createNode({layer:node.layer,param:this.param,item:paramItem,allItems:allParamItems,delimiter:this.delimiter});var sibling=node.item(0);if(sibling){node.insertBefore(child,sibling);}else{node.appendChild(child);}},createNode:function(attr){if(this.baseAttrs){Ext.apply(attr,this.baseAttrs);}
if(typeof attr.uiProvider=='string'){attr.uiProvider=this.uiProviders[attr.uiProvider]||eval(attr.uiProvider);}
attr.nodeType=attr.nodeType||"gx_layerparam";return new Ext.tree.TreePanel.nodeTypes[attr.nodeType](attr);}});
Ext.namespace("GeoExt.tree");GeoExt.tree.WMSCapabilitiesLoader=function(config){Ext.apply(this,config);GeoExt.tree.WMSCapabilitiesLoader.superclass.constructor.call(this);};Ext.extend(GeoExt.tree.WMSCapabilitiesLoader,Ext.tree.TreeLoader,{url:null,layerOptions:null,layerParams:null,requestMethod:'GET',getParams:function(node){return{'service':'WMS','request':'GetCapabilities'};},processResponse:function(response,node,callback,scope){var capabilities=new OpenLayers.Format.WMSCapabilities().read(response.responseXML||response.responseText);this.processLayer(capabilities.capability,capabilities.capability.request.getmap.href,node);if(typeof callback=="function"){callback.apply(scope||node,[node]);}},createWMSLayer:function(layer,url){if(layer.name){return new OpenLayers.Layer.WMS(layer.title,url,OpenLayers.Util.extend({formats:layer.formats[0],layers:layer.name},this.layerParams),OpenLayers.Util.extend({minScale:layer.minScale,queryable:layer.queryable,maxScale:layer.maxScale,metadata:layer},this.layerOptions));}else{return null;}},processLayer:function(layer,url,node){Ext.each(layer.nestedLayers,function(el){var n=this.createNode({text:el.title||el.name,nodeType:'node',layer:this.createWMSLayer(el,url),leaf:(el.nestedLayers.length===0)});if(n){node.appendChild(n);}
if(el.nestedLayers){this.processLayer(el,url,n);}},this);}});
Ext.namespace("GeoExt.data");GeoExt.data.PrintPage=Ext.extend(Ext.util.Observable,{printProvider:null,feature:null,center:null,scale:null,rotation:0,customParams:null,constructor:function(config){this.initialConfig=config;Ext.apply(this,config);if(!this.customParams){this.customParams={};}
this.addEvents("change");GeoExt.data.PrintPage.superclass.constructor.apply(this,arguments);this.feature=new OpenLayers.Feature.Vector(OpenLayers.Geometry.fromWKT("POLYGON((-1 -1,1 -1,1 1,-1 1,-1 -1))"));if(this.printProvider.capabilities){this.setScale(this.printProvider.scales.getAt(0));}else{this.printProvider.on({"loadcapabilities":function(){this.setScale(this.printProvider.scales.getAt(0));},scope:this,single:true});}
this.printProvider.on({"layoutchange":this.onLayoutChange,scope:this});},getPrintExtent:function(map){map=map instanceof GeoExt.MapPanel?map.map:map;return this.calculatePageBounds(this.scale,map.getUnits());},setScale:function(scale,units){var bounds=this.calculatePageBounds(scale,units);var geom=bounds.toGeometry();var rotation=this.rotation;if(rotation!=0){geom.rotate(-rotation,geom.getCentroid());}
this.updateFeature(geom,{scale:scale});},setCenter:function(center){var geom=this.feature.geometry;var oldCenter=geom.getBounds().getCenterLonLat();var dx=center.lon-oldCenter.lon;var dy=center.lat-oldCenter.lat;geom.move(dx,dy);this.updateFeature(geom,{center:center});},setRotation:function(rotation,force){if(force||this.printProvider.layout.get("rotation")===true){var geom=this.feature.geometry;geom.rotate(this.rotation-rotation,geom.getCentroid());this.updateFeature(geom,{rotation:rotation});}},fit:function(fitTo,options){options=options||{};var map=fitTo,extent;if(fitTo instanceof GeoExt.MapPanel){map=fitTo.map;}else if(fitTo instanceof OpenLayers.Feature.Vector){map=fitTo.layer.map;extent=fitTo.geometry.getBounds();}
if(!extent){extent=map.getExtent();if(!extent){return;}}
this._updating=true;var center=extent.getCenterLonLat();this.setCenter(center);var units=map.getUnits();var scale=this.printProvider.scales.getAt(0);var closest=Number.POSITIVE_INFINITY;var mapWidth=extent.getWidth();var mapHeight=extent.getHeight();this.printProvider.scales.each(function(rec){var bounds=this.calculatePageBounds(rec,units);if(options.mode=="closest"){var diff=Math.abs(bounds.getWidth()-mapWidth)+
Math.abs(bounds.getHeight()-mapHeight);if(diff<closest){closest=diff;scale=rec;}}else{var contains=options.mode=="screen"?!extent.containsBounds(bounds):bounds.containsBounds(extent);if(contains||(options.mode=="screen"&&!contains)){scale=rec;}
return contains;}},this);this.setScale(scale,units);delete this._updating;this.updateFeature(this.feature.geometry,{center:center,scale:scale});},updateFeature:function(geometry,mods){var f=this.feature;var modified=f.geometry!==geometry;geometry.id=f.geometry.id;f.geometry=geometry;if(!this._updating){for(var property in mods){if(mods[property]===this[property]){delete mods[property];}else{this[property]=mods[property];modified=true;}}
Ext.apply(this,mods);f.layer&&f.layer.drawFeature(f);modified&&this.fireEvent("change",this,mods);}},calculatePageBounds:function(scale,units){var s=scale.get("value");var f=this.feature;var geom=this.feature.geometry;var center=geom.getBounds().getCenterLonLat();var size=this.printProvider.layout.get("size");var units=units||(f.layer&&f.layer.map&&f.layer.map.getUnits())||"dd";var unitsRatio=OpenLayers.INCHES_PER_UNIT[units];var w=size.width/72/unitsRatio*s/2;var h=size.height/72/unitsRatio*s/2;return new OpenLayers.Bounds(center.lon-w,center.lat-h,center.lon+w,center.lat+h);},onLayoutChange:function(){if(this.printProvider.layout.get("rotation")===false){this.setRotation(0,true);}
this.scale&&this.setScale(this.scale);},destroy:function(){this.printProvider.un("layoutchange",this.onLayoutChange,this);}});
Ext.namespace("GeoExt.data");GeoExt.data.WMSDescribeLayerReader=function(meta,recordType){meta=meta||{};if(!meta.format){meta.format=new OpenLayers.Format.WMSDescribeLayer();}
if(!(typeof recordType==="function")){recordType=Ext.data.Record.create(recordType||meta.fields||[{name:"owsType",type:"string"},{name:"owsURL",type:"string"},{name:"typeName",type:"string"}]);}
GeoExt.data.WMSDescribeLayerReader.superclass.constructor.call(this,meta,recordType);};Ext.extend(GeoExt.data.WMSDescribeLayerReader,Ext.data.DataReader,{read:function(request){var data=request.responseXML;if(!data||!data.documentElement){data=request.responseText;}
return this.readRecords(data);},readRecords:function(data){if(typeof data==="string"||data.nodeType){data=this.meta.format.read(data);}
var records=[],description;for(var i=0,len=data.length;i<len;i++){description=data[i];if(description){records.push(new this.recordType(description));}}
return{totalRecords:records.length,success:true,records:records};}});
Ext.namespace("GeoExt.data");GeoExt.data.AttributeReader=function(meta,recordType){meta=meta||{};if(!meta.format){meta.format=new OpenLayers.Format.WFSDescribeFeatureType();}
GeoExt.data.AttributeReader.superclass.constructor.call(this,meta,recordType||meta.fields);if(meta.feature){this.recordType.prototype.fields.add(new Ext.data.Field("value"));}};Ext.extend(GeoExt.data.AttributeReader,Ext.data.DataReader,{read:function(request){var data=request.responseXML;if(!data||!data.documentElement){data=request.responseText;}
return this.readRecords(data);},readRecords:function(data){var attributes;if(data instanceof Array){attributes=data;}else{attributes=this.meta.format.read(data).featureTypes[0].properties;}
var feature=this.meta.feature;var recordType=this.recordType;var fields=recordType.prototype.fields;var numFields=fields.length;var attr,values,name,record,ignore,value,records=[];for(var i=0,len=attributes.length;i<len;++i){ignore=false;attr=attributes[i];values={};for(var j=0;j<numFields;++j){name=fields.items[j].name;value=attr[name];if(this.ignoreAttribute(name,value)){ignore=true;break;}
values[name]=value;}
if(feature){value=feature.attributes[values["name"]];if(value!==undefined){if(this.ignoreAttribute("value",value)){ignore=true;}else{values["value"]=value;}}}
if(!ignore){records[records.length]=new recordType(values);}}
return{success:true,records:records,totalRecords:records.length};},ignoreAttribute:function(name,value){var ignore=false;if(this.meta.ignore&&this.meta.ignore[name]){var matches=this.meta.ignore[name];if(typeof matches=="string"){ignore=(matches===value);}else if(matches instanceof Array){ignore=(matches.indexOf(value)>-1);}else if(matches instanceof RegExp){ignore=(matches.test(value));}}
return ignore;}});
Ext.namespace('GeoExt','GeoExt.data');GeoExt.data.ProtocolProxy=function(config){Ext.apply(this,config);GeoExt.data.ProtocolProxy.superclass.constructor.apply(this,arguments);};Ext.extend(GeoExt.data.ProtocolProxy,Ext.data.DataProxy,{protocol:null,abortPrevious:true,setParamsAsOptions:false,response:null,load:function(params,reader,callback,scope,arg){if(this.fireEvent("beforeload",this,params)!==false){var o={params:params||{},request:{callback:callback,scope:scope,arg:arg},reader:reader};var cb=OpenLayers.Function.bind(this.loadResponse,this,o);if(this.abortPrevious){this.abortRequest();}
var options={params:params,callback:cb,scope:this};Ext.applyIf(options,arg);if(this.setParamsAsOptions===true){Ext.applyIf(options,options.params);delete options.params;}
this.response=this.protocol.read(options);}else{callback.call(scope||this,null,arg,false);}},abortRequest:function(){if(this.response){this.protocol.abort(this.response);this.response=null;}},loadResponse:function(o,response){if(response.success()){var result=o.reader.read(response);this.fireEvent("load",this,o,o.request.arg);o.request.callback.call(o.request.scope,result,o.request.arg,true);}else{this.fireEvent("loadexception",this,o,response);o.request.callback.call(o.request.scope,null,o.request.arg,false);}}});
Ext.namespace("GeoExt.data");GeoExt.data.PrintProvider=Ext.extend(Ext.util.Observable,{url:null,capabilities:null,method:"POST",customParams:null,scales:null,dpis:null,layouts:null,dpi:null,layout:null,constructor:function(config){this.initialConfig=config;Ext.apply(this,config);if(!this.customParams){this.customParams={};}
this.addEvents("loadcapabilities","layoutchange","dpichange","beforeprint","print","printexception","beforeencodelayer","encodelayer");GeoExt.data.PrintProvider.superclass.constructor.apply(this,arguments);this.scales=new Ext.data.JsonStore({root:"scales",sortInfo:{field:"value",direction:"DESC"},fields:["name",{name:"value",type:"float"}]});this.dpis=new Ext.data.JsonStore({root:"dpis",fields:["name",{name:"value",type:"float"}]});this.layouts=new Ext.data.JsonStore({root:"layouts",fields:["name",{name:"size",mapping:"map"},{name:"rotation",type:"boolean"}]});if(config.capabilities){this.loadStores();}else{if(this.url.split("/").pop()){this.url+="/";}
this.initialConfig.autoLoad&&this.loadCapabilities();}},setLayout:function(layout){this.layout=layout;this.fireEvent("layoutchange",this,layout);},setDpi:function(dpi){this.dpi=dpi;this.fireEvent("dpichange",this,dpi);},print:function(map,pages,options){if(map instanceof GeoExt.MapPanel){map=map.map;}
pages=pages instanceof Array?pages:[pages];options=options||{};if(this.fireEvent("beforeprint",this,map,pages,options)===false){return;}
var jsonData=Ext.apply({units:map.getUnits(),srs:map.baseLayer.projection.getCode(),layout:this.layout.get("name"),dpi:this.dpi.get("value")},this.customParams);var pagesLayer=pages[0].feature.layer;var encodedLayers=[];Ext.each(map.layers,function(layer){if(layer!==pagesLayer&&layer.getVisibility()===true){var enc=this.encodeLayer(layer);enc&&encodedLayers.push(enc);}},this);jsonData.layers=encodedLayers;var encodedPages=[];Ext.each(pages,function(page){encodedPages.push(Ext.apply({center:[page.center.lon,page.center.lat],scale:page.scale.get("value"),rotation:page.rotation},page.customParams));},this);jsonData.pages=encodedPages;if(options.overview){var encodedOverviewLayers=[];Ext.each(options.overview.layers,function(layer){var enc=this.encodeLayer(layer);enc&&encodedOverviewLayers.push(enc);},this);jsonData.overviewLayers=encodedOverviewLayers;}
if(options.legend){var legend=options.legend;var rendered=legend.rendered;if(!rendered){legend=legend.cloneConfig({renderTo:document.body,hidden:true});}
var encodedLegends=[];legend.items.each(function(cmp){if(!cmp.hidden){var encFn=this.encoders.legends[cmp.getXType()];encodedLegends=encodedLegends.concat(encFn.call(this,cmp));}},this);if(!rendered){legend.destroy();}
jsonData.legends=encodedLegends;}
if(this.method==="GET"){var url=Ext.urlAppend(this.capabilities.printURL,"spec="+encodeURIComponent(Ext.encode(jsonData)));window.open(url);this.fireEvent("print",this,url);}else{Ext.Ajax.request({url:this.capabilities.createURL,jsonData:jsonData,success:function(response){var url=Ext.decode(response.responseText).getURL+
(Ext.isIE?"?inline=true":"");if(Ext.isOpera||Ext.isIE){window.open(url);}else{window.location.href=url;}
this.fireEvent("print",this,url);},failure:function(response){this.fireEvent("printexception",this,response);},params:this.initialConfig.baseParams,scope:this});}},loadCapabilities:function(){if(!this.url){return;}
var url=this.url+"info.json";Ext.Ajax.request({url:url,method:"GET",disableCaching:false,success:function(response){this.capabilities=Ext.decode(response.responseText);this.loadStores();},params:this.initialConfig.baseParams,scope:this});},loadStores:function(){this.scales.loadData(this.capabilities);this.dpis.loadData(this.capabilities);this.layouts.loadData(this.capabilities);this.setLayout(this.layouts.getAt(0));this.setDpi(this.dpis.getAt(0));this.fireEvent("loadcapabilities",this,this.capabilities);},encodeLayer:function(layer){var encLayer;for(var c in this.encoders.layers){if(OpenLayers.Layer[c]&&layer instanceof OpenLayers.Layer[c]){if(this.fireEvent("beforeencodelayer",this,layer)===false){return;}
encLayer=this.encoders.layers[c].call(this,layer);this.fireEvent("encodelayer",this,layer,encLayer);break;}}
return(encLayer&&encLayer.type)?encLayer:null;},getAbsoluteUrl:function(url){var a;if(Ext.isIE){a=document.createElement("<a href='"+url+"'/>");a.style.display="none";document.body.appendChild(a);a.href=a.href;document.body.removeChild(a);}else{a=document.createElement("a");a.href=url;}
return a.href;},encoders:{"layers":{"WMS":function(layer){var enc=this.encoders.layers.HTTPRequest.call(this,layer);
Ext.apply(enc,{type:'WMS',layers:[layer.params.LAYERS].join(",").split(","),format:layer.params.FORMAT,styles:[layer.params.STYLES].join(",").split(",")});var param;for(var p in layer.params){param=p.toLowerCase();if(!layer.DEFAULT_PARAMS[param]&&"layers,styles,width,height,srs".indexOf(param)==-1){if(!enc.customParams){enc.customParams={"authkey":"026b73a2-9341-4612-a07f-bfbb4ec5e8c8"};}
enc.customParams[p]=layer.params[p];}}
return enc;},"OSM":function(layer){var enc=this.encoders.layers.TileCache.call(this,layer);return Ext.apply(enc,{type:'OSM',baseURL:enc.baseURL.substr(0,enc.baseURL.indexOf("$")),extension:"png"});},"TMS":function(layer){var enc=this.encoders.layers.TileCache.call(this,layer);return Ext.apply(enc,{type:'TMS',format:layer.type});},"TileCache":function(layer){var enc=this.encoders.layers.HTTPRequest.call(this,layer);return Ext.apply(enc,{type:'TileCache',layer:layer.layername,maxExtent:layer.maxExtent.toArray(),tileSize:[layer.tileSize.w,layer.tileSize.h],extension:layer.extension,resolutions:layer.serverResolutions||layer.resolutions});},"KaMapCache":function(layer){var enc=this.encoders.layers.KaMap.call(this,layer);return Ext.apply(enc,{type:'KaMapCache',group:layer.params['g'],metaTileWidth:layer.params['metaTileSize']['w'],metaTileHeight:layer.params['metaTileSize']['h']});},"KaMap":function(layer){var enc=this.encoders.layers.HTTPRequest.call(this,layer);return Ext.apply(enc,{type:'KaMap',map:layer.params['map'],extension:layer.params['i'],group:layer.params['g']||"",maxExtent:layer.maxExtent.toArray(),tileSize:[layer.tileSize.w,layer.tileSize.h],resolutions:layer.serverResolutions||layer.resolutions});},"HTTPRequest":function(layer){return{baseURL:this.getAbsoluteUrl(layer.url instanceof Array?layer.url[0]:layer.url),opacity:(layer.opacity!=null)?layer.opacity:1.0,singleTile:layer.singleTile};},"Image":function(layer){return{type:'Image',baseURL:this.getAbsoluteUrl(layer.getURL(layer.extent)),opacity:(layer.opacity!=null)?layer.opacity:1.0,extent:layer.extent.toArray(),pixelSize:[layer.size.w,layer.size.h],name:layer.name};},"Vector":function(layer){if(!layer.features.length){return;}
var encFeatures=[];var encStyles={};var features=layer.features;var featureFormat=new OpenLayers.Format.GeoJSON();var styleFormat=new OpenLayers.Format.JSON();var nextId=1;var styleDict={};var feature,style,dictKey,dictItem,styleName;for(var i=0,len=features.length;i<len;++i){feature=features[i];style=feature.style||layer.style||layer.styleMap.createSymbolizer(feature,feature.renderIntent);dictKey=styleFormat.write(style);dictItem=styleDict[dictKey];if(dictItem){styleName=dictItem;}else{styleDict[dictKey]=styleName=nextId++;if(style.externalGraphic){encStyles[styleName]=Ext.applyIf({externalGraphic:this.getAbsoluteUrl(style.externalGraphic)},style);}else{encStyles[styleName]=style;}}
var featureGeoJson=featureFormat.extract.feature.call(featureFormat,feature);featureGeoJson.properties=OpenLayers.Util.extend({_gx_style:styleName},featureGeoJson.properties);encFeatures.push(featureGeoJson);}
return{type:'Vector',styles:encStyles,styleProperty:'_gx_style',geoJson:{type:"FeatureCollection",features:encFeatures},name:layer.name,opacity:(layer.opacity!=null)?layer.opacity:1.0};}},"legends":{"gx_wmslegend":function(legend){var enc=this.encoders.legends.base.call(this,legend);var icons=[];for(var i=1,len=legend.items.getCount();i<len;++i){icons.push(this.getAbsoluteUrl(legend.items.get(i).url));}
enc[0].classes[0]={name:"",icons:icons};return enc;},"gx_urllegend":function(legend){var enc=this.encoders.legends.base.call(this,legend);enc[0].classes.push({name:"",icon:this.getAbsoluteUrl(legend.items.get(1).url)});return enc;},"base":function(legend){return[{name:legend.items.get(0).text,classes:[]}];}}}});
Ext.namespace("GeoExt.data");GeoExt.data.FeatureStoreMixin=function(){return{layer:null,reader:null,featureFilter:null,constructor:function(config){config=config||{};config.reader=config.reader||new GeoExt.data.FeatureReader({},config.fields);var layer=config.layer;delete config.layer;if(config.features){config.data=config.features;}
delete config.features;var options={initDir:config.initDir};delete config.initDir;arguments.callee.superclass.constructor.call(this,config);if(layer){this.bind(layer,options);}},bind:function(layer,options){if(this.layer){return;}
this.layer=layer;options=options||{};var initDir=options.initDir;if(options.initDir==undefined){initDir=GeoExt.data.FeatureStore.LAYER_TO_STORE|GeoExt.data.FeatureStore.STORE_TO_LAYER;}
var features=layer.features.slice(0);if(initDir&GeoExt.data.FeatureStore.STORE_TO_LAYER){var records=this.getRange();for(var i=records.length-1;i>=0;i--){this.layer.addFeatures([records[i].getFeature()]);}}
if(initDir&GeoExt.data.FeatureStore.LAYER_TO_STORE){this.loadData(features,true);}
layer.events.on({"featuresadded":this.onFeaturesAdded,"featuresremoved":this.onFeaturesRemoved,"featuremodified":this.onFeatureModified,scope:this});this.on({"load":this.onLoad,"clear":this.onClear,"add":this.onAdd,"remove":this.onRemove,"update":this.onUpdate,scope:this});},unbind:function(){if(this.layer){this.layer.events.un({"featuresadded":this.onFeaturesAdded,"featuresremoved":this.onFeaturesRemoved,"featuremodified":this.onFeatureModified,scope:this});this.un("load",this.onLoad,this);this.un("clear",this.onClear,this);this.un("add",this.onAdd,this);this.un("remove",this.onRemove,this);this.un("update",this.onUpdate,this);this.layer=null;}},getRecordFromFeature:function(feature){var record=null;if(feature.state!==OpenLayers.State.INSERT){record=this.getById(feature.id);}else{var index=this.findBy(function(r){return r.getFeature()===feature;});if(index>-1){record=this.getAt(index);}}
return record;},onFeaturesAdded:function(evt){if(!this._adding){var features=evt.features,toAdd=features;if(this.featureFilter){toAdd=[];var i,len,feature;for(var i=0,len=features.length;i<len;i++){feature=features[i];if(this.featureFilter.evaluate(feature)!==false){toAdd.push(feature);}}}
this._adding=true;this.loadData(toAdd,true);delete this._adding;}},onFeaturesRemoved:function(evt){if(!this._removing){var features=evt.features,feature,record,i;for(i=features.length-1;i>=0;i--){feature=features[i];record=this.getRecordFromFeature(feature);if(record!==undefined){this._removing=true;this.remove(record);delete this._removing;}}}},onFeatureModified:function(evt){if(!this._updating){var feature=evt.feature;var record=this.getRecordFromFeature(feature);if(record!==undefined){record.beginEdit();var attributes=feature.attributes;if(attributes){var fields=this.recordType.prototype.fields;for(var i=0,len=fields.length;i<len;i++){var field=fields.items[i];var key=field.mapping||field.name;if(key in attributes){record.set(field.name,field.convert(attributes[key]));}}}
record.set("state",feature.state);record.set("fid",feature.fid);record.setFeature(feature);this._updating=true;record.endEdit();delete this._updating;}}},addFeaturesToLayer:function(records){var i,len,features;features=new Array((len=records.length));for(i=0;i<len;i++){features[i]=records[i].getFeature();}
if(features.length>0){this._adding=true;this.layer.addFeatures(features);delete this._adding;}},onLoad:function(store,records,options){if(!options||options.add!==true){this._removing=true;this.layer.removeFeatures(this.layer.features);delete this._removing;this.addFeaturesToLayer(records);}},onClear:function(store){this._removing=true;this.layer.removeFeatures(this.layer.features);delete this._removing;},onAdd:function(store,records,index){if(!this._adding){this.addFeaturesToLayer(records);}},onRemove:function(store,record,index){if(!this._removing){var feature=record.getFeature();if(this.layer.getFeatureById(feature.id)!=null){this._removing=true;this.layer.removeFeatures([record.getFeature()]);delete this._removing;}}},onUpdate:function(store,record,operation){if(!this._updating){var defaultFields=new GeoExt.data.FeatureRecord().fields;var feature=record.getFeature();if(record.fields){var cont=this.layer.events.triggerEvent("beforefeaturemodified",{feature:feature});if(cont!==false){var attributes=feature.attributes;record.fields.each(function(field){var key=field.mapping||field.name;if(!defaultFields.containsKey(key)){attributes[key]=record.get(field.name);}});this._updating=true;this.layer.events.triggerEvent("featuremodified",{feature:feature});delete this._updating;if(this.layer.getFeatureById(feature.id)!=null){this.layer.drawFeature(feature);}}}}}};};GeoExt.data.FeatureStore=Ext.extend(Ext.data.Store,new GeoExt.data.FeatureStoreMixin);GeoExt.data.FeatureStore.LAYER_TO_STORE=1;GeoExt.data.FeatureStore.STORE_TO_LAYER=2;
Ext.namespace("GeoExt","GeoExt.data");GeoExt.data.LayerReader=function(meta,recordType){meta=meta||{};if(!(recordType instanceof Function)){recordType=GeoExt.data.LayerRecord.create(recordType||meta.fields||{});}
GeoExt.data.LayerReader.superclass.constructor.call(this,meta,recordType);};Ext.extend(GeoExt.data.LayerReader,Ext.data.DataReader,{totalRecords:null,readRecords:function(layers){var records=[];if(layers){var recordType=this.recordType,fields=recordType.prototype.fields;var i,lenI,j,lenJ,layer,values,field,v;for(i=0,lenI=layers.length;i<lenI;i++){layer=layers[i];values={};for(j=0,lenJ=fields.length;j<lenJ;j++){field=fields.items[j];v=layer[field.mapping||field.name]||field.defaultValue;v=field.convert(v);values[field.name]=v;}
values.layer=layer;records[records.length]=new recordType(values,layer.id);}}
return{records:records,totalRecords:this.totalRecords!=null?this.totalRecords:records.length};}});
Ext.namespace("GeoExt.data");GeoExt.data.FeatureRecord=Ext.data.Record.create([{name:"feature"},{name:"state"},{name:"fid"}]);GeoExt.data.FeatureRecord.prototype.getFeature=function(){return this.get("feature");};GeoExt.data.FeatureRecord.prototype.setFeature=function(feature){if(feature!==this.data.feature){this.dirty=true;if(!this.modified){this.modified={};}
if(this.modified.feature===undefined){this.modified.feature=this.data.feature;}
this.data.feature=feature;if(!this.editing){this.afterEdit();}}};GeoExt.data.FeatureRecord.create=function(o){var f=Ext.extend(GeoExt.data.FeatureRecord,{});var p=f.prototype;p.fields=new Ext.util.MixedCollection(false,function(field){return field.name;});GeoExt.data.FeatureRecord.prototype.fields.each(function(f){p.fields.add(f);});if(o){for(var i=0,len=o.length;i<len;i++){p.fields.add(new Ext.data.Field(o[i]));}}
f.getField=function(name){return p.fields.get(name);};return f;};
Ext.namespace("GeoExt.data");
GeoExt.data.WMSCapabilitiesStore=function(c){c=c||{};
GeoExt.data.WMSCapabilitiesStore.superclass.constructor.call(this,Ext.apply(c,
                                            {proxy:c.proxy||(!c.data?new Ext.data.HttpProxy({
									            url:c.url,
												disableCaching:false,
												method:"GET"}):undefined),
												reader:new GeoExt.data.WMSCapabilitiesReader(c,
												 c.fields)}
												 ));
};
Ext.extend(GeoExt.data.WMSCapabilitiesStore,Ext.data.Store);
Ext.namespace("GeoExt.data");GeoExt.data.AttributeStoreMixin=function(){return{constructor:function(c){c=c||{};arguments.callee.superclass.constructor.call(this,Ext.apply(c,{proxy:c.proxy||(!c.data?new Ext.data.HttpProxy({url:c.url,disableCaching:false,method:"GET"}):undefined),reader:new GeoExt.data.AttributeReader(c,c.fields||["name","type","restriction"])}));if(this.feature){this.bind();}},bind:function(){this.on({"update":this.onUpdate,"load":this.onLoad,"add":this.onAdd,scope:this});var records=[];this.each(function(record){records.push(record);});this.updateFeature(records);},onUpdate:function(store,record,operation){this.updateFeature([record]);},onLoad:function(store,records,options){if(!options||options.add!==true){this.updateFeature(records);}},onAdd:function(store,records,index){this.updateFeature(records);},updateFeature:function(records){var feature=this.feature,layer=feature.layer;var i,len,record,name,value,oldValue,dirty;for(i=0,len=records.length;i<len;i++){record=records[i];name=record.get("name");value=record.get("value");oldValue=feature.attributes[name];if(oldValue!==value){dirty=true;}}
if(dirty&&layer&&layer.events&&layer.events.triggerEvent("beforefeaturemodified",{feature:feature})!==false){for(i=0,len=records.length;i<len;i++){record=records[i];name=record.get("name");value=record.get("value");feature.attributes[name]=value;}
layer.events.triggerEvent("featuremodified",{feature:feature});layer.drawFeature(feature);}}};};GeoExt.data.AttributeStore=Ext.extend(Ext.data.Store,GeoExt.data.AttributeStoreMixin());
Ext.namespace("GeoExt.data");
GeoExt.data.WMSCapabilitiesReader=function(meta,recordType){meta=meta||{};if(!meta.format){meta.format=new OpenLayers.Format.WMSCapabilities();}
if(typeof recordType!=="function"){recordType=GeoExt.data.LayerRecord.create(recordType||meta.fields||[{name:"name",type:"string"},{name:"title",type:"string"},{name:"abstract",type:"string"},{name:"queryable",type:"boolean"},{name:"opaque",type:"boolean"},{name:"noSubsets",type:"boolean"},{name:"cascaded",type:"int"},{name:"fixedWidth",type:"int"},{name:"fixedHeight",type:"int"},{name:"minScale",type:"float"},{name:"maxScale",type:"float"},{name:"prefix",type:"string"},{name:"formats"},{name:"styles"},{name:"srs"},{name:"dimensions"},{name:"bbox"},{name:"llbbox"},{name:"attribution"},{name:"keywords"},{name:"identifiers"},{name:"authorityURLs"},{name:"metadataURLs"}]);}
GeoExt.data.WMSCapabilitiesReader.superclass.constructor.call(this,meta,recordType);};Ext.extend(GeoExt.data.WMSCapabilitiesReader,Ext.data.DataReader,{attributionCls:"gx-attribution",read:function(request){var data=request.responseXML;if(!data||!data.documentElement){data=request.responseText;}
return this.readRecords(data);},serviceExceptionFormat:function(formats){if(OpenLayers.Util.indexOf(formats,"application/vnd.ogc.se_inimage")>-1){return"application/vnd.ogc.se_inimage";}
if(OpenLayers.Util.indexOf(formats,"application/vnd.ogc.se_xml")>-1){return"application/vnd.ogc.se_xml";}
return formats[0];},imageFormat:function(layer){var formats=layer.formats;if(layer.opaque&&OpenLayers.Util.indexOf(formats,"image/jpeg")>-1){return"image/jpeg";}
if(OpenLayers.Util.indexOf(formats,"image/png")>-1){return"image/png";}
if(OpenLayers.Util.indexOf(formats,"image/png; mode=24bit")>-1){return"image/png; mode=24bit";}
if(OpenLayers.Util.indexOf(formats,"image/gif")>-1){return"image/gif";}
return formats[0];},imageTransparent:function(layer){return layer.opaque==undefined||!layer.opaque;},readRecords:function(data){if(typeof data==="string"||data.nodeType){data=this.meta.format.read(data);}
var version=data.version;var capability=data.capability||{};var url=capability.request&&capability.request.getmap&&capability.request.getmap.href;var layers=capability.layers;var formats=capability.exception?capability.exception.formats:[];var exceptions=this.serviceExceptionFormat(formats);var records=[];if(url&&layers){var fields=this.recordType.prototype.fields;var layer,values,options,params,field,v;for(var i=0,lenI=layers.length;i<lenI;i++){layer=layers[i];if(layer.name){values={};for(var j=0,lenJ=fields.length;j<lenJ;j++){field=fields.items[j];v=layer[field.mapping||field.name]||field.defaultValue;v=field.convert(v);values[field.name]=v;}
options={attribution:layer.attribution?this.attributionMarkup(layer.attribution):undefined,minScale:layer.minScale,maxScale:layer.maxScale};if(this.meta.layerOptions){Ext.apply(options,this.meta.layerOptions);}
params={layers:layer.name,exceptions:exceptions,format:this.imageFormat(layer),transparent:this.imageTransparent(layer),version:version};if(this.meta.layerParams){Ext.apply(params,this.meta.layerParams);}
values.layer=new OpenLayers.Layer.WMS(layer.title||layer.name,url,params,options);records.push(new this.recordType(values,values.layer.id));}}}
return{totalRecords:records.length,success:true,records:records};},attributionMarkup:function(attribution){var markup=[];if(attribution.logo){markup.push("<img class='"+this.attributionCls+"-image' "
+"src='"+attribution.logo.href+"' />");}
if(attribution.title){markup.push("<span class='"+this.attributionCls+"-title'>"
+attribution.title
+"</span>");}
if(attribution.href){for(var i=0;i<markup.length;i++){markup[i]="<a class='"
+this.attributionCls+"-link' "
+"href="
+attribution.href
+">"
+markup[i]
+"</a>";}}
return markup.join(" ");}});
Ext.namespace("GeoExt.data");GeoExt.data.WMCReader=function(meta,recordType){meta=meta||{};if(!meta.format){meta.format=new OpenLayers.Format.WMC();}
if(!(typeof recordType==="function")){recordType=GeoExt.data.LayerRecord.create(recordType||meta.fields||[{name:"abstract",type:"string"},{name:"metadataURL",type:"string"},{name:"queryable",type:"boolean"},{name:"formats"},{name:"styles"}]);}
GeoExt.data.WMCReader.superclass.constructor.call(this,meta,recordType);};Ext.extend(GeoExt.data.WMCReader,Ext.data.DataReader,{read:function(request){var data=request.responseXML;if(!data||!data.documentElement){data=request.responseText;}
return this.readRecords(data);},readRecords:function(data){var format=this.meta.format;if(typeof data==="string"||data.nodeType){data=format.read(data);}
var layersContext=data?data.layersContext:undefined;var records=[];if(layersContext){var recordType=this.recordType,fields=recordType.prototype.fields;var i,lenI,j,lenJ,layerContext,values,field,v;for(i=0,lenI=layersContext.length;i<lenI;i++){layerContext=layersContext[i];values={};for(j=0,lenJ=fields.length;j<lenJ;j++){field=fields.items[j];v=layerContext[field.mapping||field.name]||field.defaultValue;v=field.convert(v);values[field.name]=v;}
values.layer=format.getLayerFromContext(layerContext);records.push(new this.recordType(values,values.layer.id));}}
return{totalRecords:records.length,success:true,records:records};}});
Ext.namespace("GeoExt.data");GeoExt.data.WMSDescribeLayerStore=function(c){c=c||{};GeoExt.data.WMSDescribeLayerStore.superclass.constructor.call(this,Ext.apply(c,{proxy:c.proxy||(!c.data?new Ext.data.HttpProxy({url:c.url,disableCaching:false,method:"GET"}):undefined),reader:new GeoExt.data.WMSDescribeLayerReader(c,c.fields)}));};Ext.extend(GeoExt.data.WMSDescribeLayerStore,Ext.data.Store);
Ext.namespace("GeoExt.data");GeoExt.data.LayerRecord=Ext.data.Record.create([{name:"layer"},{name:"title",type:"string",mapping:"name"}]);GeoExt.data.LayerRecord.prototype.getLayer=function(){return this.get("layer");};GeoExt.data.LayerRecord.prototype.setLayer=function(layer){if(layer!==this.data.layer){this.dirty=true;if(!this.modified){this.modified={};}
if(this.modified.layer===undefined){this.modified.layer=this.data.layer;}
this.data.layer=layer;if(!this.editing){this.afterEdit();}}};GeoExt.data.LayerRecord.prototype.clone=function(id){var layer=this.getLayer()&&this.getLayer().clone();return new this.constructor(Ext.applyIf({layer:layer},this.data),id||layer.id);};GeoExt.data.LayerRecord.create=function(o){var f=Ext.extend(GeoExt.data.LayerRecord,{});var p=f.prototype;p.fields=new Ext.util.MixedCollection(false,function(field){return field.name;});GeoExt.data.LayerRecord.prototype.fields.each(function(f){p.fields.add(f);});if(o){for(var i=0,len=o.length;i<len;i++){p.fields.add(new Ext.data.Field(o[i]));}}
f.getField=function(name){return p.fields.get(name);};return f;};
Ext.namespace("GeoExt.data");GeoExt.data.ScaleStore=Ext.extend(Ext.data.Store,{map:null,constructor:function(config){var map=(config.map instanceof GeoExt.MapPanel?config.map.map:config.map);delete config.map;config=Ext.applyIf(config,{reader:new Ext.data.JsonReader({},["level","resolution","scale"])});GeoExt.data.ScaleStore.superclass.constructor.call(this,config);if(map){this.bind(map);}},bind:function(map,options){this.map=(map instanceof GeoExt.MapPanel?map.map:map);this.map.events.register('changebaselayer',this,this.populateFromMap);if(this.map.baseLayer){this.populateFromMap();}else{this.map.events.register('addlayer',this,this.populateOnAdd);}},unbind:function(){if(this.map){this.map.events.unregister('addlayer',this,this.populateOnAdd);this.map.events.unregister('changebaselayer',this,this.populateFromMap);delete this.map;}},populateOnAdd:function(evt){if(evt.layer.isBaseLayer){this.populateFromMap();this.map.events.unregister('addlayer',this,this.populateOnAdd);}},populateFromMap:function(){var zooms=[];var resolutions=this.map.baseLayer.resolutions;var units=this.map.baseLayer.units;for(var i=resolutions.length-1;i>=0;i--){var res=resolutions[i];zooms.push({level:i,resolution:res,scale:OpenLayers.Util.getScaleFromResolution(res,units)});}
this.loadData(zooms);},destroy:function(){this.unbind();GeoExt.data.ScaleStore.superclass.destroy.apply(this,arguments);}});
Ext.namespace('GeoExt','GeoExt.data');GeoExt.data.FeatureReader=function(meta,recordType){meta=meta||{};if(!(recordType instanceof Function)){recordType=GeoExt.data.FeatureRecord.create(recordType||meta.fields||{});}
GeoExt.data.FeatureReader.superclass.constructor.call(this,meta,recordType);};Ext.extend(GeoExt.data.FeatureReader,Ext.data.DataReader,{totalRecords:null,read:function(response){return this.readRecords(response.features);},readRecords:function(features){var records=[];if(features){var recordType=this.recordType,fields=recordType.prototype.fields;var i,lenI,j,lenJ,feature,values,field,v;for(i=0,lenI=features.length;i<lenI;i++){feature=features[i];values={};if(feature.attributes){for(j=0,lenJ=fields.length;j<lenJ;j++){field=fields.items[j];if(/[\[\.]/.test(field.mapping)){try{v=new Function("obj","return obj."+field.mapping)(feature.attributes);}catch(e){v=field.defaultValue;}}
else{v=feature.attributes[field.mapping||field.name]||field.defaultValue;}
if(field.convert){v=field.convert(v);}
values[field.name]=v;}}
values.feature=feature;values.state=feature.state;values.fid=feature.fid;var id=(feature.state===OpenLayers.State.INSERT)?undefined:feature.id;records[records.length]=new recordType(values,id);}}
return{records:records,totalRecords:this.totalRecords!=null?this.totalRecords:records.length};}});
Ext.namespace("GeoExt.data");GeoExt.data.WFSCapabilitiesStore=function(c){c=c||{};GeoExt.data.WFSCapabilitiesStore.superclass.constructor.call(this,Ext.apply(c,{proxy:c.proxy||(!c.data?new Ext.data.HttpProxy({url:c.url,disableCaching:false,method:"GET"}):undefined),reader:new GeoExt.data.WFSCapabilitiesReader(c,c.fields)}));};Ext.extend(GeoExt.data.WFSCapabilitiesStore,Ext.data.Store);
Ext.namespace("GeoExt.data");GeoExt.data.LayerStoreMixin=function(){return{map:null,reader:null,constructor:function(config){config=config||{};config.reader=config.reader||new GeoExt.data.LayerReader({},config.fields);delete config.fields;var map=config.map instanceof GeoExt.MapPanel?config.map.map:config.map;delete config.map;if(config.layers){config.data=config.layers;}
delete config.layers;var options={initDir:config.initDir};delete config.initDir;arguments.callee.superclass.constructor.call(this,config);if(map){this.bind(map,options);}},bind:function(map,options){if(this.map){return;}
this.map=map;options=options||{};var initDir=options.initDir;if(options.initDir==undefined){initDir=GeoExt.data.LayerStore.MAP_TO_STORE|GeoExt.data.LayerStore.STORE_TO_MAP;}
var layers=map.layers.slice(0);if(initDir&GeoExt.data.LayerStore.STORE_TO_MAP){this.each(function(record){this.map.addLayer(record.getLayer());},this);}
if(initDir&GeoExt.data.LayerStore.MAP_TO_STORE){this.loadData(layers,true);}
map.events.on({"changelayer":this.onChangeLayer,"addlayer":this.onAddLayer,"removelayer":this.onRemoveLayer,scope:this});this.on({"load":this.onLoad,"clear":this.onClear,"add":this.onAdd,"remove":this.onRemove,"update":this.onUpdate,scope:this});this.data.on({"replace":this.onReplace,scope:this});},unbind:function(){if(this.map){this.map.events.un({"changelayer":this.onChangeLayer,"addlayer":this.onAddLayer,"removelayer":this.onRemoveLayer,scope:this});this.un("load",this.onLoad,this);this.un("clear",this.onClear,this);this.un("add",this.onAdd,this);this.un("remove",this.onRemove,this);this.data.un("replace",this.onReplace,this);this.map=null;}},onChangeLayer:function(evt){var layer=evt.layer;var recordIndex=this.findBy(function(rec,id){return rec.getLayer()===layer;});if(recordIndex>-1){var record=this.getAt(recordIndex);if(evt.property==="order"){if(!this._adding&&!this._removing){var layerIndex=this.map.getLayerIndex(layer);if(layerIndex!==recordIndex){this._removing=true;this.remove(record);delete this._removing;this._adding=true;this.insert(layerIndex,[record]);delete this._adding;}}}else if(evt.property==="name"){record.set("title",layer.name);}else{this.fireEvent("update",this,record,Ext.data.Record.EDIT);}}},onAddLayer:function(evt){if(!this._adding){var layer=evt.layer;this._adding=true;this.loadData([layer],true);delete this._adding;}},onRemoveLayer:function(evt){if(this.map.unloadDestroy){if(!this._removing){var layer=evt.layer;this._removing=true;this.remove(this.getById(layer.id));delete this._removing;}}else{this.unbind();}},onLoad:function(store,records,options){if(!Ext.isArray(records)){records=[records];}
if(options&&!options.add){this._removing=true;for(var i=this.map.layers.length-1;i>=0;i--){this.map.removeLayer(this.map.layers[i]);}
delete this._removing;var len=records.length;if(len>0){var layers=new Array(len);for(var j=0;j<len;j++){layers[j]=records[j].getLayer();}
this._adding=true;this.map.addLayers(layers);delete this._adding;}}},onClear:function(store){this._removing=true;for(var i=this.map.layers.length-1;i>=0;i--){this.map.removeLayer(this.map.layers[i]);}
delete this._removing;},onAdd:function(store,records,index){if(!this._adding){this._adding=true;var layer;for(var i=records.length-1;i>=0;--i){layer=records[i].getLayer();this.map.addLayer(layer);if(index!==this.map.layers.length-1){this.map.setLayerIndex(layer,index);}}
delete this._adding;}},onRemove:function(store,record,index){if(!this._removing){var layer=record.getLayer();if(this.map.getLayer(layer.id)!=null){this._removing=true;this.removeMapLayer(record);delete this._removing;}}},onUpdate:function(store,record,operation){if(operation===Ext.data.Record.EDIT){if(record.modified&&record.modified.title){var layer=record.getLayer();var title=record.get("title");if(title!==layer.name){layer.setName(title);}}}},removeMapLayer:function(record){this.map.removeLayer(record.getLayer());},onReplace:function(key,oldRecord,newRecord){this.removeMapLayer(oldRecord);},getByLayer:function(layer){var index=this.findBy(function(r){return r.getLayer()===layer;});if(index>-1){return this.getAt(index);}},destroy:function(){this.unbind();GeoExt.data.LayerStore.superclass.destroy.call(this);}};};GeoExt.data.LayerStore=Ext.extend(Ext.data.Store,new GeoExt.data.LayerStoreMixin);GeoExt.data.LayerStore.MAP_TO_STORE=1;GeoExt.data.LayerStore.STORE_TO_MAP=2;
Ext.namespace("GeoExt.data");GeoExt.data.WFSCapabilitiesReader=function(meta,recordType){meta=meta||{};if(!meta.format){meta.format=new OpenLayers.Format.WFSCapabilities();}
if(!(typeof recordType==="function")){recordType=GeoExt.data.LayerRecord.create(recordType||meta.fields||[{name:"name",type:"string"},{name:"title",type:"string"},{name:"namespace",type:"string",mapping:"featureNS"},{name:"abstract",type:"string"}]);}
GeoExt.data.WFSCapabilitiesReader.superclass.constructor.call(this,meta,recordType);};Ext.extend(GeoExt.data.WFSCapabilitiesReader,Ext.data.DataReader,{read:function(request){var data=request.responseXML;if(!data||!data.documentElement){data=request.responseText;}
return this.readRecords(data);},readRecords:function(data){if(typeof data==="string"||data.nodeType){data=this.meta.format.read(data);}
var featureTypes=data.featureTypeList.featureTypes;var fields=this.recordType.prototype.fields;var featureType,values,field,v,parts,layer,values;var layerOptions,protocolOptions;var protocolDefaults={url:data.capability.request.getfeature.href.post};var records=[];for(var i=0,lenI=featureTypes.length;i<lenI;i++){featureType=featureTypes[i];if(featureType.name){values={};for(var j=0,lenJ=fields.length;j<lenJ;j++){field=fields.items[j];v=featureType[field.mapping||field.name]||field.defaultValue;v=field.convert(v);values[field.name]=v;}
protocolOptions={featureType:featureType.name,featureNS:featureType.featureNS};if(this.meta.protocolOptions){Ext.apply(protocolOptions,this.meta.protocolOptions,protocolDefaults);}else{Ext.apply(protocolOptions,{},protocolDefaults);}
layerOptions={protocol:new OpenLayers.Protocol.WFS(protocolOptions),strategies:[new OpenLayers.Strategy.Fixed()]};if(this.meta.layerOptions){Ext.apply(layerOptions,this.meta.layerOptions);}
values.layer=new OpenLayers.Layer.Vector(featureType.title||featureType.name,layerOptions);records.push(new this.recordType(values,values.layer.id));}}
return{totalRecords:records.length,success:true,records:records};}});
Ext.namespace("GeoExt.plugins");GeoExt.plugins.TreeNodeComponent=Ext.extend(Ext.util.Observable,{constructor:function(config){Ext.apply(this.initialConfig,Ext.apply({},config));Ext.apply(this,config);GeoExt.plugins.TreeNodeComponent.superclass.constructor.apply(this,arguments);},init:function(tree){tree.on({"rendernode":this.onRenderNode,scope:this});},onRenderNode:function(node){var rendered=node.rendered;var attr=node.attributes;var component=attr.component||this.component;if(!rendered&&component){var elt=Ext.DomHelper.append(node.ui.elNode,[{"tag":"div"}]);if(typeof component=="function"){component=component(node,elt);}else if(typeof component=="object"&&typeof component.fn=="function"){component=component.fn.apply(component.scope,[node,elt]);}
if(typeof component=="object"&&typeof component.xtype=="string"){component=Ext.ComponentMgr.create(component);}
if(component instanceof Ext.Component){component.render(elt);node.component=component;}}},destroy:function(){tree.un("rendernode",this.onRenderNode,this);}});Ext.preg&&Ext.preg("gx_treenodecomponent",GeoExt.plugins.TreeNodeComponent);
Ext.namespace("GeoExt.plugins");GeoExt.plugins.TreeNodeRadioButton=Ext.extend(Ext.util.Observable,{constructor:function(config){Ext.apply(this.initialConfig,Ext.apply({},config));Ext.apply(this,config);this.addEvents("radiochange");GeoExt.plugins.TreeNodeRadioButton.superclass.constructor.apply(this,arguments);},init:function(tree){tree.on({"rendernode":this.onRenderNode,"rawclicknode":this.onRawClickNode,"beforedestroy":this.onBeforeDestroy,scope:this});},onRenderNode:function(node){var a=node.attributes;if(a.radioGroup&&!a.radio){a.radio=Ext.DomHelper.insertBefore(node.ui.anchor,['<input type="radio" class="gx-tree-radio" name="',a.radioGroup,'_radio"></input>'].join(""));}},onRawClickNode:function(node,e){var el=e.getTarget('.gx-tree-radio',1);if(el){el.defaultChecked=el.checked;this.fireEvent("radiochange",node);return false;}},onBeforeDestroy:function(tree){tree.un("rendernode",this.onRenderNode,this);tree.un("rawclicknode",this.onRenderNode,this);tree.un("beforedestroy",this.onBeforeDestroy,this);}});Ext.preg("gx_treenoderadiobutton",GeoExt.plugins.TreeNodeRadioButton);
Ext.namespace("GeoExt.plugins");GeoExt.plugins.PrintProviderField=Ext.extend(Ext.util.Observable,{target:null,constructor:function(config){this.initialConfig=config;Ext.apply(this,config);GeoExt.plugins.PrintProviderField.superclass.constructor.apply(this,arguments);},init:function(target){this.target=target;var onCfg={scope:this,"render":this.onRender,"beforedestroy":this.onBeforeDestroy};onCfg[target instanceof Ext.form.ComboBox?"select":"valid"]=this.onFieldChange;target.on(onCfg);},onRender:function(field){var printProvider=this.printProvider||field.ownerCt.printProvider;if(field.store===printProvider.layouts){field.setValue(printProvider.layout.get(field.displayField));printProvider.on({"layoutchange":this.onProviderChange,scope:this});}else if(field.store===printProvider.dpis){field.setValue(printProvider.dpi.get(field.displayField));printProvider.on({"dpichange":this.onProviderChange,scope:this});}else if(field.initialConfig.value===undefined){field.setValue(printProvider.customParams[field.name]);}},onFieldChange:function(field,record){var printProvider=this.printProvider||field.ownerCt.printProvider;var value=field.getValue();this._updating=true;if(record){switch(field.store){case printProvider.layouts:printProvider.setLayout(record);break;case printProvider.dpis:printProvider.setDpi(record);}}else{printProvider.customParams[field.name]=value;}
delete this._updating;},onProviderChange:function(printProvider,rec){if(!this._updating){this.target.setValue(rec.get(this.target.displayField));}},onBeforeDestroy:function(){this.target.un("beforedestroy",this.onBeforeDestroy,this);this.target.un("render",this.onRender,this);this.target.un("select",this.onFieldChange,this);this.target.un("valid",this.onFieldChange,this);this.printProvider.un("layoutchange",this.onProviderChange,this);this.printProvider.un("dpichange",this.onProviderChange,this);}});
Ext.preg("gx_printproviderfield",GeoExt.plugins.PrintProviderField);
Ext.namespace("GeoExt.plugins");GeoExt.plugins.PrintExtent=Ext.extend(Ext.util.Observable,{initialConfig:null,printProvider:null,map:null,layer:null,control:null,pages:null,page:null,constructor:function(config){config=config||{};Ext.apply(this,config);this.initialConfig=config;if(!this.printProvider){this.printProvider=this.pages[0].printProvider;}
if(!this.pages){this.pages=[];}
this.addEvents("selectpage");GeoExt.plugins.PrintExtent.superclass.constructor.apply(this,arguments);},print:function(options){this.printProvider.print(this.map,this.pages,options);},init:function(mapPanel){this.map=mapPanel.map;mapPanel.on("destroy",this.onMapPanelDestroy,this);if(!this.layer){this.layer=new OpenLayers.Layer.Vector(null,{displayInLayerSwitcher:false});}
this.createControl();for(var i=0,len=this.pages.length;i<len;++i){this.addPage(this.pages[i]);}
this.show();},addPage:function(page){page=page||new GeoExt.data.PrintPage({printProvider:this.printProvider});if(this.pages.indexOf(page)===-1){this.pages.push(page);}
this.layer.addFeatures([page.feature]);page.on("change",this.onPageChange,this);this.page=page;var map=this.map;if(map.getCenter()){this.fitPage();}else{map.events.register("moveend",this,function(){map.events.unregister("moveend",this,arguments.callee);this.fitPage();});}
return page;},removePage:function(page){this.pages.remove(page);if(page.feature.layer){this.layer.removeFeatures([page.feature]);}
page.un("change",this.onPageChange,this);},selectPage:function(page){this.control.active&&this.control.setFeature(page.feature);},show:function(){this.map.addLayer(this.layer);this.map.addControl(this.control);this.control.activate();if(this.page&&this.map.getCenter()){this.updateBox();}},hide:function(){var map=this.map;var control=this.control;if(control&&control.events){control.deactivate();if(map&&map.events&&control.map){map.removeControl(control);}}
var layer=this.layer;if(!this.initialConfig.layer&&map&&map.events&&layer&&layer.map){map.removeLayer(layer);}},onMapPanelDestroy:function(){var map=this.map;for(var len=this.pages.length-1,i=len;i>=0;i--){this.removePage(this.pages[i]);}
this.hide();var control=this.control;if(map&&map.events&&control&&control.events){control.destroy();}
var layer=this.layer;if(!this.initialConfig.layer&&map&&map.events&&layer&&layer.events){layer.destroy();}
delete this.layer;delete this.control;delete this.page;this.map=null;},createControl:function(){this.control=new OpenLayers.Control.TransformFeature(this.layer,{preserveAspectRatio:true,eventListeners:{"beforesetfeature":function(e){for(var i=0,len=this.pages.length;i<len;++i){if(this.pages[i].feature===e.feature){this.page=this.pages[i];e.object.rotation=-this.pages[i].rotation;break;}}},"setfeature":function(e){for(var i=0,len=this.pages.length;i<len;++i){if(this.pages[i].feature===e.feature){this.fireEvent("selectpage",this.pages[i]);break;}}},"beforetransform":function(e){this._updating=true;var page=this.page;if(e.rotation){if(this.printProvider.layout.get("rotation")){page.setRotation(-e.object.rotation);}else{e.object.setFeature(page.feature);}}else if(e.center){page.setCenter(OpenLayers.LonLat.fromString(e.center.toShortString()));}else{page.fit(e.object.box,{mode:"closest"});var minScale=this.printProvider.scales.getAt(0);var maxScale=this.printProvider.scales.getAt(this.printProvider.scales.getCount()-1);var boxBounds=e.object.box.geometry.getBounds();var pageBounds=page.feature.geometry.getBounds();var tooLarge=page.scale===minScale&&boxBounds.containsBounds(pageBounds);var tooSmall=page.scale===maxScale&&pageBounds.containsBounds(boxBounds);if(tooLarge===true||tooSmall===true){this.updateBox();}}
delete this._updating;return false;},"transformcomplete":this.updateBox,scope:this}});},fitPage:function(){if(this.page){this.page.fit(this.map,{mode:"screen"});}},updateBox:function(){var page=this.page;this.control.active&&this.control.setFeature(page.feature,{rotation:-page.rotation});},onPageChange:function(page,mods){if(!this._updating){this.control.active&&this.control.setFeature(page.feature,{rotation:-page.rotation});}}});
Ext.preg("gx_printextent",GeoExt.plugins.PrintExtent);
Ext.namespace("GeoExt.plugins");GeoExt.plugins.PrintPageField=Ext.extend(Ext.util.Observable,{printPage:null,target:null,constructor:function(config){this.initialConfig=config;Ext.apply(this,config);GeoExt.plugins.PrintPageField.superclass.constructor.apply(this,arguments);},init:function(target){this.target=target;var onCfg={"beforedestroy":this.onBeforeDestroy,scope:this};var eventName=target instanceof Ext.form.ComboBox?"select":target instanceof Ext.form.Checkbox?"check":"valid";onCfg[eventName]=this.onFieldChange;target.on(onCfg);this.printPage.on({"change":this.onPageChange,scope:this});this.printPage.printProvider.on({"layoutchange":this.onLayoutChange,scope:this});this.setValue(this.printPage);},onFieldChange:function(field,record){var printProvider=this.printPage.printProvider;var value=field.getValue();this._updating=true;if(field.store===printProvider.scales||field.name==="scale"){this.printPage.setScale(record);}else if(field.name=="rotation"){!isNaN(value)&&this.printPage.setRotation(value);}else{this.printPage.customParams[field.name]=value;}
delete this._updating;},onPageChange:function(printPage){if(!this._updating){this.setValue(printPage);}},onLayoutChange:function(printProvider,layout){var t=this.target;t.name=="rotation"&&t.setDisabled(!layout.get("rotation"));},setValue:function(printPage){var t=this.target;t.suspendEvents();if(t.store===printPage.printProvider.scales||t.name==="scale"){if(printPage.scale){t.setValue(printPage.scale.get(t.displayField));}}else if(t.name=="rotation"){t.setValue(printPage.rotation);}
t.resumeEvents();},onBeforeDestroy:function(){this.target.un("beforedestroy",this.onBeforeDestroy,this);this.target.un("select",this.onFieldChange,this);this.target.un("valid",this.onFieldChange,this);this.printPage.un("change",this.onPageChange,this);this.printPage.printProvider.un("layoutchange",this.onLayoutChange,this);}});
Ext.preg("gx_printpagefield",GeoExt.plugins.PrintPageField);
Ext.namespace("GeoExt.plugins");GeoExt.plugins.AttributeForm=function(config){Ext.apply(this,config);};GeoExt.plugins.AttributeForm.prototype={attributeStore:null,formPanel:null,init:function(formPanel){this.formPanel=formPanel;if(this.attributeStore instanceof Ext.data.Store){this.fillForm();this.bind(this.attributeStore);}
formPanel.on("destroy",this.onFormDestroy,this);},bind:function(store){this.unbind();store.on({"load":this.onLoad,scope:this});this.attributeStore=store;},unbind:function(){if(this.attributeStore){this.attributeStore.un("load",this.onLoad,this);}},onLoad:function(){if(this.formPanel.items){this.formPanel.removeAll();}
this.fillForm();},fillForm:function(){this.attributeStore.each(function(record){var field=GeoExt.form.recordToField(record);if(field){this.formPanel.add(field);}},this);this.formPanel.doLayout();},onFormDestroy:function(){this.unbind();}};Ext.preg("gx_attributeform",GeoExt.plugins.AttributeForm);
Ext.namespace("GeoExt.state");GeoExt.state.PermalinkProvider=function(config){GeoExt.state.PermalinkProvider.superclass.constructor.apply(this,arguments);config=config||{};var url=config.url;delete config.url;Ext.apply(this,config);this.state=this.readURL(url);};Ext.extend(GeoExt.state.PermalinkProvider,Ext.state.Provider,{encodeType:true,readURL:function(url){var state={};var params=OpenLayers.Util.getParameters(url);var k,split,stateId;for(k in params){if(params.hasOwnProperty(k)){split=k.split("_");if(split.length>1){stateId=split[0];state[stateId]=state[stateId]||{};state[stateId][split.slice(1).join("_")]=this.encodeType?this.decodeValue(params[k]):params[k];}}}
return state;},getLink:function(base){base=base||document.location.href;var params={};var id,k,state=this.state;for(id in state){if(state.hasOwnProperty(id)){for(k in state[id]){params[id+"_"+k]=this.encodeType?unescape(this.encodeValue(state[id][k])):state[id][k];}}}
OpenLayers.Util.applyDefaults(params,OpenLayers.Util.getParameters(base));var paramsStr=OpenLayers.Util.getParameterString(params);var qMark=base.indexOf("?");if(qMark>0){base=base.substring(0,qMark);}
return Ext.urlAppend(base,paramsStr);}});
(function(){var createComplete=function(fn,cb){return function(request){if(cb&&cb[fn]){cb[fn].call(cb.scope||window,{responseText:request.responseText,responseXML:request.responseXML,argument:cb.argument});}};};Ext.apply(Ext.lib.Ajax,{request:function(method,uri,cb,data,options){options=options||{};method=method||options.method;var hs=options.headers;if(options.xmlData){if(!hs||!hs["Content-Type"]){hs=hs||{};hs["Content-Type"]="text/xml";}
method=method||"POST";data=options.xmlData;}else if(options.jsonData){if(!hs||!hs["Content-Type"]){hs=hs||{};hs["Content-Type"]="application/json";}
method=method||"POST";data=typeof options.jsonData=="object"?Ext.encode(options.jsonData):options.jsonData;}
if((method&&method.toLowerCase()=="post")&&(options.form||options.params)&&(!hs||!hs["Content-Type"])){hs=hs||{};hs["Content-Type"]="application/x-www-form-urlencoded";}
return OpenLayers.Request.issue({success:createComplete("success",cb),failure:createComplete("failure",cb),method:method,headers:hs,data:data,url:uri});},isCallInProgress:function(request){return true;},abort:function(request){request.abort();}});})();

/**
 * Copyright (c) 2008-2009 The Open Source Geospatial Foundation
 *
 * Published under the BSD license.
 * See http://svn.geoext.org/core/trunk/geoext/license.txt for the full text
 * of the license.
 */

Ext.namespace("GeoExt.ux");

/*
 * @include GeoExt/data/AttributeStore.js
 * @include GeoExt/widgets/form.js
 */

/** api: (define)
 *  module = GeoExt.ux
 *  class = FeatureEditorGrid
 *  base_link = `Ext.grid.EditorGridPanel <http://www.dev.sencha.com/deploy/dev/docs/?class=Ext.grid.EditorGridPanel>`_
 */

/** api: constructor
 *  .. class:: FeatureEditorGrid(config)
 *
 *  A grid including the attributes of a feature and making the feature
 *  editable, using an ``OpenLayers.Control.ModifyFeature``.
 */
GeoExt.ux.FeatureEditorGrid = Ext.extend(Ext.grid.EditorGridPanel, {

    /* begin i18n */
    /** api: config[deleteMsgTitle] ``String`` i18n */
    deleteMsgTitle: "Delete Feature?",
    /** api: config[deleteMsg]
     *  ``String`` i18n for the delete confirmation, no confirmation message
     *  will appear if not provided.
     */
    deleteMsg: "Are you sure you want to delete this feature?",
    /** api: config[deleteButtonText] ``String`` i18n */
    deleteButtonText: "Delete",
    /** api: config[deleteButtonTooltip] ``String`` i18n */
    deleteButtonTooltip: "Delete this feature",
    /** api: config[cancelMsgTitle] ``String`` i18n */
    cancelMsgTitle: "Cancel Editing?",
    /** api: config[cancelMsg]
     *  ``String`` i18n for the cancel confirmation,  no confirmation message
     *  will appear if not provided.
     */
    cancelMsg: "There are unsaved changes. Are you sure you want to cancel?",
    /** api: config[cancelButtonText] ``String`` i18n */
    cancelButtonText: "Cancel",
    /** api: config[cancelButtonTooltip] ``String`` i18n */
    cancelButtonTooltip: "Stop editing, discard changes",
    /** api: config[saveButtonText] ``String`` i18n */
    saveButtonText: "Save",
    /** api: config[saveButtonTooltip] ``String`` i18n */
    saveButtonTooltip: "Save changes",
    /** api: config[nameHeader] ``String`` i18n */
    nameHeader: "Name",
    /** api: config[valueHeader] ``String`` i18n */
    valueHeader: "Value",
    /* end i18n */

    /** api: config[feature]
     *  ``OpenLayers.Feature.Vector`` The feature to edit and display. This
     *  option ignored if a store is provided. Either this option or the
     *  "store" option should be set.
     */

    /** api: config[nameField]
     *  ``String`` The name of the store field associated to the "Name"
     *  column in the grid. Default is "name".
     */
    /** private: property[nameField]
     *  ``String``
     */
    nameField: "name",

    /** api: config[store]
     *  ``Ext.data.Store`` A store of records representing attributes,
     *  typically an :class:`GeoExt.data.AttributeStore` object with
     *  a vector feature set into it. If not provided one will be
     *  created based on the attributes of the provided feature.
     *  So either this option or the "feature" option should be set.
     */
    /** api: property[store]
     *  ``Ext.data.Store`` The attribute store. Read-only.
     */
    store: undefined,

    /** api: config[allowDelete]
     *  ``Boolean`` Set to true to provide a Delete button for deleting the
     *  feature. Default is false.
     */
    allowDelete: false,

    /** api: config[allowSave]
     *  ``Boolean`` Set to true to provide a Save button for saving the
     *  feature. Default is true.
     */
    allowSave: true,

    /** api: config[allowCancel]
     *  ``Boolean`` Set to true to provide a Cancel button for canceling
     *  the editing of feature. Default is true.
     */
    allowCancel: true,

    /** api: config[extraColumns]
     *  ``Array`` Extra columns to use in this grid's column model.
     */
    extraColumns: undefined,

    /** private: property[modifyControl]
     *  ``OpenLayers.Control.ModifyFeature`` the control for geometry editing.
     */
    modifyControl: undefined,

    /** private: property[featureInfo]
     *  ``Object`` Where we store the original state (in a broad sense) of
     *   the feature, so we can undo changes if necessary.
     */
    featureInfo: undefined,

    /** private: property[cancelButton]
     *  ``Ext.Button``
     */
    cancelButton: undefined,

    /** private: property[saveButton]
     *  ``Ext.Button``
     */
    saveButton: undefined,

    /** private: property[deleteButton]
     *  ``Ext.Button``
     */
    deleteButton: undefined,

    /** public: property[dirty]
     *  ``Boolean`` This property is used by this grid to track
     *  whether the feature is modified. Read-only.
     */
    dirty: false,

    /** private: method[initComponent]
     */
    initComponent: function() {
        this.addEvents(

            /** api: events[cancel]
             *  Fires when the user cancels editing by clicking on the
             *  "Cancel" button.
             *
             *  Listener arguments:
             *  * panel - :class:`GeoExt.ux.FeatureEditorGrid` This grid.
             *  * e - ``Object`` An object with two properties: "feature",
             *    referencing the feature being edited, and "modified", a
             *    ``Boolean`` value specifying if the feature has been
             *    modified.
             */
            "cancel",

            /** api: events[done]
             *  Fires when the user finishes the editing either by clicking the
             *  "Save" button or when he clicks "Yes" in the modification
             *  cancel confirm dialog.
             *
             *  Listener arguments:
             *  * panel - :class:`GeoExt.ux.FeatureEditorGrid` This grid.
             *  * e - ``Object`` An object with two properties: "feature",
             *    referencing the feature being edited, and "modified", a
             *    ``Boolean`` value specifying if the feature has been
             *    modified.
             */
            "done"
        );

        // create an attribute store if none is provided
        if(!this.store) {
            var data = [], attributes = this.feature.attributes;
            for(var a in attributes) {
                if(attributes.hasOwnProperty(a)) {
                    data.push({
                        "name": a,
                        "type": typeof attributes[a]
                    });
                }
            }
            this.store = new GeoExt.data.AttributeStore({
                feature: this.feature,
                data: data
            });
        }

        delete this.feature;

        // create bottom bar
        this.deleteButton = new Ext.Button({
            text: this.deleteButtonText,
            tooltip: this.deleteButtonTooltip,
            iconCls: "delete",
            hidden: !this.allowDelete,
            handler: this.deleteHandler,
            scope: this
        });
        this.cancelButton = new Ext.Button({
            text: this.cancelButtonText,
            tooltip: this.cancelButtonTooltip,
            iconCls: "cancel",
            hidden: !this.allowCancel,
            handler: this.cancelHandler,
            scope: this
        });
        this.saveButton = new Ext.Button({
            text: this.saveButtonText,
            tooltip: this.saveButtonTooltip,
            iconCls: "save",
            hidden: !this.allowSave,
            handler: this.saveHandler,
            scope: this
        });
        this.bbar = new Ext.Toolbar({
            items: [
                '->',
                this.deleteButton,
                this.saveButton,
                this.cancelButton
            ]
        });

        // create column model
        var columns = [
            { header: this.nameHeader, dataIndex: this.nameField },
            new Ext.grid.Column({
                header: this.valueHeader,
                dataIndex: "value",
                editable: true,
                getEditor: this.getEditor.createDelegate(this)
            })
        ];
        if(this.extraColumns) {
            columns = columns.concat(this.extraColumns);
        }
        this.colModel = new Ext.grid.ColumnModel({
            columns: columns
        });

        // call parent to finish the initialization of the component
        GeoExt.ux.FeatureEditorGrid.superclass.initComponent.call(this);

        var feature = this.store.feature;

        // store the initial state of the feature
        this.featureInfo = {
            geometry: feature.geometry.clone(),
            attributes: Ext.apply({}, feature.attributes),
            state: feature.state
        };

        // create modify feature control
        this.modifyControl = new OpenLayers.Control.ModifyFeature(
            feature.layer,
            {standalone: true}
        );
        feature.layer.map.addControl(this.modifyControl);
        this.modifyControl.activate();
        this.modifyControl.selectFeature(feature);

        // register a featuremodified listener on the layer
        feature.layer.events.on({
            featuremodified: this.onFeaturemodified,
            scope: this
        });

        // register an afteredit listener to change the
        // feature state
        this.on({
            "afteredit": function() {
                this.setFeatureState(this.getDirtyState());
            }
        });
    },

    /** private: method[onFeaturemodified]
     *  :param e: ``Object`` The event.
     *
     *  Called when a feature is modified in the layer.
     */
    onFeaturemodified: function(e) {
        if(e.feature === this.store.feature) {
            this.dirty = true;
        }
    },

    /** private: method[getEditor]
     *  :param rowIndex: ``Number``
     *  :return: ``Ext.grid.GridEditor``
     *
     *  Return a GridEditor object for a given row in the grid.
     */
    getEditor: function(rowIndex) {
        var record = this.store.getAt(rowIndex), config;
        var field = (config = GeoExt.form.recordToField(record)) ?
            Ext.ComponentMgr.create(config) : new Ext.form.TextField();
        return new Ext.grid.GridEditor(field);
    },

    /** private: method[getDirtyState]
     *  :return: ``Number`` The feature state.
     *
     *  Get the appropriate OpenLayers.State value to indicate a dirty feature.
     *  We don't cache this value because the popup may remain open through
     *  several state changes.
     */
    getDirtyState: function() {
        return this.store.feature.state === OpenLayers.State.INSERT ?
            this.store.feature.state : OpenLayers.State.UPDATE;
    },

    /** private: method[cancelHandler]
     *  :param e: {Object} Properties defined in this object are set in the
     *  "cancel" event.
     *
     *  Called when the "Cancel" button is clicked.
     */
    cancelHandler: function(e) {

        var _cancel = function() {
            e = Ext.applyIf({
                feature: this.store.feature,
                modified: this.dirty
            }, e);
            if(this.fireEvent("cancel", this, e) !== false) {
                this.cancel();
            }
        }.createDelegate(this);

        if(this.cancelMsg && this.dirty) {
            Ext.Msg.show({
                title: this.cancelMsgTitle,
                msg: this.cancelMsg,
                buttons: Ext.Msg.YESNO,
                icon: Ext.MessageBox.QUESTION,
                fn: function(button) {
                    if(button === "yes") {
                        _cancel();
                    }
                }
            });
        } else {
            _cancel();
        }
    },

    /** public: method[cancel]
     *  Undo changes, gets the initial geometry, attributes and
     *  state back in the feature.
     */
    cancel: function() {
        var feature = this.store.feature, layer = feature.layer;

        // a bit of a hack here: we're about to set a new geometry
        // in the feature, and we cannot just do it and redraw the
        // feature as this will cause the renderer to draw two
        // shapes. So we force the renderer to unrender the shape
        // by using display: "none" in the style.

        layer.drawFeature(feature, {display: "none"});

        feature.geometry = this.featureInfo.geometry;
        feature.attributes = this.featureInfo.attributes;
        feature.state = this.featureInfo.state;

        layer.drawFeature(feature);
    },

    /** private: method[deleteHandler]
     *  :param e: {Object} Properties defined in this object are set in the
     *  "done" event.
     *
     *  Called when the "Delete" button is clicked.
     */
    deleteHandler: function(e) {

        var _delete = function() {
            this.setFeatureState(OpenLayers.State.DELETE);
            e = Ext.applyIf({
                feature: this.store.feature,
                modified: this.dirty
            }, e);
            this.fireEvent("done", this, e);
        }.createDelegate(this);

        if(this.deleteMsg) {
            Ext.Msg.show({
                title: this.deleteMsgTitle,
                msg: this.deleteMsg,
                buttons: Ext.Msg.YESNO,
                icon: Ext.MessageBox.QUESTION,
                fn: function(button) {
                    if(button === "yes") {
                        _delete();
                    }
                }
            });
        } else {
            _delete();
        }
    },

    /** private: method[saveHandler]
     *  :param e: {Object} Properties defined in this object are set in the
     *  "done" event.
     *
     *  Called when the "Save" button is clicked.
     */
    saveHandler: function(e) {
        e = Ext.applyIf({
            feature: this.store.feature,
            modified: this.dirty
        }, e);
        this.fireEvent("done", this, e);
    },

    /** private: method[setFeatureState]
     *  :param state: ``String`` The new state.
     *
     *  Set the state of the feature and trigger a featuremodified
     *  event on the layer.
     */
    setFeatureState: function(state) {
        var feature = this.store.feature, layer = feature.layer;
        feature.state = state;
        if(layer && layer.events) {
            layer.events.triggerEvent("featuremodified", {
                feature: feature
            });
            layer.drawFeature(feature);
        }
    },

    /** private: method[beforeDestroy]
     * Private method called during the destroy sequence.
     */
    beforeDestroy: function() {
        GeoExt.ux.FeatureEditorGrid.superclass.beforeDestroy.apply(
            this, arguments);

        var layer = this.store.feature.layer;
        if(layer && layer.events) {
            layer.events.un({
                featuremodified: this.onFeaturemodified,
                scope: this
            });
        }

        // remove the line below when
        // http://trac.openlayers.org/ticket/2210 is fixed.
        this.modifyControl.deactivate();
        this.modifyControl.destroy();

        if(!this.initialConfig.store) {
            this.store.destroy();
        }
    }
});

/** api: xtype = gxux_featureeditorgrid */
Ext.reg("gxux_featureeditorgrid", GeoExt.ux.FeatureEditorGrid);

/**
 * Copyright (c) 2008-2010 The Open Source Geospatial Foundation
 * 
 * Published under the BSD license.
 * See http://svn.geoext.org/core/trunk/geoext/license.txt for the full text
 * of the license.
 */

Ext.namespace("GeoExt.ux");

/** api: (define)
 *  module = GeoExt.ux
 *  class = FeatureBrowser
 *  base_link = `Ext.Panel <http://dev.sencha.com/deploy/dev/docs/?class=Ext.Panel>`_
 */

/** api: constructor
 *  .. class:: FeatureBrowser(config)
 *      
 *      Creates a Panel to browse in a features list,
 *  show attributes for each using templates.
 */
GeoExt.ux.FeatureBrowser = Ext.extend(Ext.Panel, {

    /* begin i18n */
    /** api: config[counterText]
     *  ``String`` i18n, The counter message to display (defaults to "{0} of
     *  {1}). Note that this string is formatted using {0} as a token for index
     *  and {1} as a token for total. These tokens should be preserved when
     *  overriding this string if showing those values is desired.
     */
    counterText: "{0} of {1} features",

    /** api: config[elseTpl]
     *  ``Ext.Template`` | ``Ext.XTemplate`` Ext.Template or Ext.XTemplate
     *  to be used for features which don't match any of the tpl keys.
     *  Will be taken into account only if tpl is an Object. Optional.
     */
    elseTpl: null, 

    /** api: config[tpl]
     * ``Ext.Template`` | ``Ext.XTemplate`` | ``Object`` | ``Function``
     *  Ext.Template or Ext.XTemplate to be applied for each feature with
     *  feature.attributes as context. If provided as an Object, each key
     *  may correspond to the value for the tplFeatureAttribute key in the
     *  feature attributes. The corresponding value has to be a valid template.
     *  Optional.
     */
    tpl: undefined,

    /** api: config[tplFeatureAttribute]
     *  ``String`` | ``Number``
     *  The attribute which value is to be compared with one of the tpl members
     *  when provided as an Object. Mandatory is tpl is a Object. Optional.
     */
    tplFeatureAttribute: null,

    /** api: config[skippedFeatureAttributes]
     *  ``Array(String)``
     *  Specifies the feature attributes to skip in the default Ext.Template
     *  created by this component. Only applies when the ``tpl`` option is
     *  not set. Optional.
     */
    skippedFeatureAttributes: null,
    
    /** api: config[features]
     *  ``Array`` Array of ``OpenLayers.Feature.Vector`` to build the
     *  FeatureBrowser with. Required.
     */
    features: null,

    /** private: method[initComponent]
     */
    initComponent: function() {

        this.layout = "card";

        var nbFeatures = this.features.length;

        this.items = [];
        var feature, tpl;
        for (var i = 0; i < nbFeatures; i++) {
            feature = this.features[i];
            tpl = this.getTemplateForFeature(feature);
            
            this.items.push(new Ext.BoxComponent({
                id: 'card-'+ this.id + i,
                html: tpl.apply(feature.attributes)
            }));
        }

        if (nbFeatures > 1) {
            this.bbar = [
                {xtype: 'tbtext', id: 'counter-' + this.id},
                '->',
                {
                    id: 'move-prev' + this.id,
                    iconCls: "x-tbar-page-prev",
                    handler: this.navHandler.createDelegate(this, 
                        [-1, nbFeatures, this.features]),
                    disabled: true,
                    listeners: {
                        click: function(button, e) {
                            e.stopEvent();
                        }
                    }
                },
                {
                    id: 'move-next' + this.id,
                    iconCls: "x-tbar-page-next",
                    handler: this.navHandler.createDelegate(this, 
                        [1, nbFeatures, this.features]),
                    listeners: {
                        click: function(button, e) {
                            e.stopEvent();
                        }
                    }
                }
            ];
        }
        this.activeItem = 0;

        GeoExt.ux.FeatureBrowser.superclass.initComponent.apply(this, arguments);

        // add custom events
        this.addEvents(
        
            /** api: events[featureselected]
             *  Fires when a feature is displayed in the FeatureBrowser.
             *  Application may use this to highlight it on the map, for
             *  example.
             *
             *  Listener arguments:
             *  * panel - :class:`GeoExt.ux.FeatureBrowser` This panel.
             *  * feature - ``OpenLayers.Feature.Vector`` The selected feature
             */
            'featureselected'
        );
        this.fireEvent('featureselected', this, this.features[0]);

        var counter = Ext.getCmp('counter-' + this.id);
        counter && counter.setText(
            String.format(this.counterText, 1, nbFeatures)
        );
    },

    /** private: method[navHandler]
     *  The navigation handler method. Called when navigation buttons 
     *  (next or previous) are clicked
     */
    navHandler: function(direction, total, features) {
        var lay = this.getLayout();
        var i = lay.activeItem.id.split('card-' + this.id)[1];
        var next = parseInt(i, 10) + direction;
        lay.setActiveItem(next);
        this.fireEvent('featureselected', this, features[next]);
        Ext.getCmp('move-prev' + this.id).setDisabled(next === 0);
        Ext.getCmp('move-next' + this.id).setDisabled(next == total - 1);

        var counter = Ext.getCmp('counter-' + this.id);
        counter && counter.setText(
            String.format(this.counterText, next + 1, total)
        );
    },

    /** private: method[getTemplateForFeature]
     *  Returns a template for the given feature.
     *
     *  :param feature: ``OpenLayers.Feature.Vector`` The feature to create
     *      a template with.
     *
     *  :return: ``Ext.Template`` | ``Ext.XTemplate`` The created template.
     */
    getTemplateForFeature: function(feature) {
        var tpl,
            attributes = feature.attributes;

        if (this.tpl instanceof Ext.Template) {
            tpl = this.tpl;
        } else if (typeof this.tpl === 'object') {
            tpl = this.tpl[attributes[this.tplFeatureAttribute]] ||
                  this.elseTpl;
        } else if (typeof this.tpl === 'function') {
            // currently unsupported
        }

        // create a default template with key/value pairs
        if (!tpl) {
            var templateString = '';
            for (var k in attributes) {
                if (attributes.hasOwnProperty(k) &&
                    (this.skippedFeatureAttributes == null ||
                     this.skippedFeatureAttributes.indexOf(k) === -1)) {

                    templateString += '<div>' +
                                      '<b>' + k + ': </b>' +
                                      '{' + k + '}' +
                                      '</div>';
                }
            }
            tpl = new Ext.Template(templateString);
        }

        return tpl;
    }
});
