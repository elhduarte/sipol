 
 var situacional;
 var social;
 var puntos_rojos;
 
/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Namespace: mapfish.Util
 * Utility functions
 */
mapfish.Util = {};

/**
 * APIFunction: sum
 * Return the sum of the elements of an array.
 */
mapfish.Util.sum = function(array) {
    for (var i=0, sum=0; i < array.length; sum += array[i++]);
    return sum;
};

/**
 * APIFunction: max
 * Return the max of the elements of an array.
 */
mapfish.Util.max = function(array) {
    return Math.max.apply({}, array);
};

/**
 * APIFunction: min
 * Return the min of the elements of an array.
 */
mapfish.Util.min = function(array) {
    return Math.min.apply({}, array);
};

/**
 * Function: getIconUrl
 * Builds the URL for a layer icon, based on a WMS GetLegendGraphic request.
 *
 * Parameters:
 * wmsUrl - {String} The URL of a WMS server.
 * options - {Object} The options to set in the request:
 *                    'layer' - the name of the layer for which the icon is requested (required)
 *                    'rule' - the name of a class for this layer (this is set to the layer name if not specified)
 *                    'format' - "image/png" by default
 *                    ...
 *
 * Returns:
 * {String} The URL at which the icon can be found.
 */
mapfish.Util.getIconUrl = function(wmsUrl, options) {
    if (!options.layer) {
        OpenLayers.Console.warn(
            'Missing required layer option in mapfish.Util.getIconUrl');
        return '';
    }
    if (!options.rule) {
        options.rule = options.layer;
    }
    if (wmsUrl.indexOf("?") < 0) {
        //add a ? to the end of the url if it doesn't
        //already contain one
        wmsUrl += "?";
    } else if (wmsUrl.lastIndexOf('&') != (wmsUrl.length - 1)) {
        //if there was already a ? , assure that the parameters
        //are ended with an &, except if the ? was at the last char
        if (wmsUrl.indexOf("?") != (wmsUrl.length - 1)) {
            wmsUrl += "&";
        }
    }
    var options = OpenLayers.Util.extend({
        layer: "",
        rule: "",
        service: "WMS",
        version: "1.1.1",
        request: "GetLegendGraphic",
        format: "image/png",
        width: 16,
        height: 16
    }, options);
    options = OpenLayers.Util.upperCaseObject(options);
    return wmsUrl + OpenLayers.Util.getParameterString(options);
};


/**
 * APIFunction: arrayEqual
 * Compare two arrays containing primitive types.
 *
 * Parameters:
 * a - {Array} 1st to be compared.
 * b - {Array} 2nd to be compared.
 *
 * Returns:
 * {Boolean} True if both given arrays contents are the same (elements value and type).
 */
mapfish.Util.arrayEqual = function(a, b) {
    if(a == null || b == null)
        return false;
    if(typeof(a) != 'object' || typeof(b) != 'object')
        return false;
    if (a.length != b.length)
        return false;
    for (var i = 0; i < a.length; i++) {
        if (typeof(a[i]) != typeof(b[i]))
            return false;
        if (a[i] != b[i])
            return false;
    }
    return true;
};

/**
 * Function: isIE7
 *
 * Returns:
 * {Boolean} True if the browser is Internet Explorer V7
 */
mapfish.Util.isIE7 = function () {
    var ua = navigator.userAgent.toLowerCase();
    return ua.indexOf("msie 7") > -1;
};

/**
 * APIFunction: relativeToAbsoluteURL
 *
 * Parameters:
 * source - {String} the source URL
 *
 * Returns:
 * {String} An absolute URL
 */
mapfish.Util.relativeToAbsoluteURL = function(source) {
    if (/^\w+:/.test(source) || !source) {
        return source;
    }

    var h = location.protocol + "//" + location.host;
    if (source.indexOf("/") == 0) {
        return h + source;
    }

    var p = location.pathname.replace(/\/[^\/]*$/, '');
    return h + p + "/" + source;
};

/**
 * Function: fixArray
 *
 * In some fields, OpenLayers allows to use a coma separated string instead
 * of an array. This method make sure we end up with an array.
 *
 * Parameters:
 * subs - {String/Array}
 *
 * Returns:
 * {Array}
 */
mapfish.Util.fixArray = function(subs) {
    if (subs == '' || subs == null) {
        return [];
    } else if (subs instanceof Array) {
        return subs;
    } else {
        return subs.split(',');
    }
};

/**
 * Function formatURL
 * If mapfish.PROXY_HOST is defined format the passed URL so that
 * the resource this URL references is accessed through the
 * http-proxy script mapfish.PROXY_HOST references.
 *
 * Parameters:
 * url - {String} The URL to format.
 *
 * Returns:
 * {String} The formatted URL string.
 */
 /*
mapfish.Util.formatURL = function(url) {
    var proxy = mapfish.PROXY_HOST;
    if(proxy && (url.indexOf("http") == 0)) {
        var str = url;
        // get protocol from URL
        var protocol = str.match(/https?:\/\//)[0].split(':')[0];
        str = str.slice((protocol + '://').length);
        // get path from URL
        var path = undefined;
        var pathSeparatorIndex = str.indexOf('/');
        if (pathSeparatorIndex != -1) {
            path = str.substring(pathSeparatorIndex);
            str = str.slice(0, pathSeparatorIndex);
        }
        // get host and port from URL
        var host_port = str.split(":");
        var host = host_port[0];
        var port = host_port.length > 1 ? host_port[1] : undefined;
        // build URL
        url = protocol + ',' + host;
        url += (port == undefined ? '' : ',' + port);
        url += (path == undefined ? '' : path);
        if(proxy.lastIndexOf('/') != proxy.length - 1) {
            url = '/' + url;
        }
        url = proxy + url;
    }
    return url;
};
*/

/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

Ext.namespace('mapfish.widgets.toolbar');

/**
 * Class: mapfish.widgets.toolbar.Toolbar
 * A toolbar shows a set of OpenLayers Controls and handle activating them.
 *
 * Simple example usage:
 * (start code)
 * var toolbar = new mapfish.widgets.toolbar.Toolbar({map: map});
 * toolbar.render('buttonbar');
 * toolbar.addControl(
 *     new OpenLayers.Control.ZoomBox({title: 'Zoom in'}), 
 *     {iconCls: 'zoomin', toggleGroup: 'navigation'});
 * toolbar.addControl(
 *     new OpenLayers.Control.DragPan({title: 'Drag or pan', isDefault: true}), 
 *     {iconCls: 'pan', toggleGroup: 'navigation'});
 * toolbar.activate();
 * (end)
 *
 * Some attributes from the control are used by the toolbar:
 *  - isDefault: true for the default button of the given group.
 *  - title: will be used for the tooltip.
 *
 * On the Ext button side (second parameter of addControl), some options are of
 * interest:
 *  - toggleGroup: Name of the toggle group the button is member of.
 *  - iconCls: The CSS class for displaying the button.
 *
 * Inherits from:
 * - {Ext.Toolbar}
 */

/**
 * Constructor: mapfish.widgets.toolbar.Toolbar
 * Create a new Toolbar
 *
 * Parameters:
 * config - {Object} Config object
 */

mapfish.widgets.toolbar.Toolbar = function(config) {
    Ext.apply(this, config);
    mapfish.widgets.toolbar.Toolbar.superclass.constructor.call(this);
};

Ext.extend(mapfish.widgets.toolbar.Toolbar, Ext.Toolbar, {
    //width: 350,
	//height: 30,
    /**
     * Property: controls
     * Array({<OpenLayers.Control>})
     */
    controls: null,

    /**
     * Property: state
     * Object
     */
    state: null,

    /**
     * Property: configurable
     * Boolean
     */
    configurable: false,
    
    /** 
     * Property: _buttons 
     * Array({<Ext.Toolbar.Button>}) 
     * "buttons" is not available (already used in Ext.Toolbar)
     */ 
    _buttons: null,

    // private
    initComponent: function() {
        mapfish.widgets.toolbar.Toolbar.superclass.initComponent.call(this);
        this.controls = [];
        this._buttons = [];
		//this.width = 400;
		this.height = 30;
	//   this.monitorResize = false;
        this.autoWidth = true;
        this.autoHeight = false;
        Ext.QuickTips.init();
    },

    /**
     * Method: addControl
     * Add a control to the toolbar, the control will be represented by a button
     *
     * Parameters:
     * control - {<OpenLayers.Control>}
     * options - the config object for the newly created Ext.Toolbar.Button
     *
     * Returns:
     * {<Ext.Toolbar.Button>} The added button instance
     */
     addControl: function (control, options) {
        control.visible = true;
        this.controls.push(control);
        if (!control.map) {
            this.map.addControl(control);
        }
        var button = new Ext.Toolbar.Button(options);
        if (!button.tooltip) {
            button.tooltip = control.title;
        }
        button.enableToggle = (control.type != OpenLayers.Control.TYPE_BUTTON);
        if (control.isDefault) {
            button.pressed = true;
        }
        if (control.type == OpenLayers.Control.TYPE_BUTTON) {
            button.on("click", control.trigger, control);
        } else {
            button.on("toggle", function(button, pressed) {
                this.toggleHandler(control, pressed);
            }, this);
            // make sure the state of the control and the state of the
            // button match
            control.events.on({
                "activate": this.onControlActivate,
                "deactivate": this.onControlDeactivate,
                scope: this
            });
        }
		
        this.add(button);
        this._buttons.push(button);
        return button;
    },
	
    /**
     * Method: removeControl
     * Remove a control from the toolbar.
     *
     * Parameters:
     * control - {<OpenLayers.Control>} The control to remove from
     *     the toolbar.
     */
    removeControl: function (control) {
        var button = this.getButtonForControl(control);

        button.destroy();
        OpenLayers.Util.removeItem(this._buttons, button);

        control.events.un({
            "activate": this.onControlActivate,
            "deactivate": this.onControlDeactivate,
            scope: this
        });
        this.map.removeControl(control);
        OpenLayers.Util.removeItem(this.controls, control);
		
	//	this.getTopToolbar().setWidth(300);	
    },

    /**
     * onControlActivate
     * Called when a control is activated.
     *
     * Parameters:
     * evt - {Object} An object with an object property referencing
     *     the control.
     */
    onControlActivate: function(evt) {
        var control = evt.object;
        var button = this.getButtonForControl(control);
        button.toggle(true);
    },

    /**
     * onControlDeactivate
     * Called when a control is deactivated.
     *
     * Parameters:
     * evt - {Object} An object with an object property referencing
     *     the control.
     */
    onControlDeactivate: function(evt) {
        var control = evt.object;
        var button = this.getButtonForControl(control);
        button.toggle(false);
        this.checkDefaultControl(button);
    },

    /**
     * Method: getControlByClassName
     * Pass in the CLASS_NAME of a control as a string and return the control itself
     *
     * Parameters: 
     * className - string
     *
     * Returns:
     * {<OpenLayers.Control>} The requested control.
     */
    getControlByClassName: function(className) {
        if (this.controls) {
            for (var i = 0;  i < this.controls.length; i++) {
                if (this.controls[i].CLASS_NAME == className) {
                    return this.controls[i];
                }
            }
        }
        return null;
    },

    /**
     * Method: getButtonForControl
     * Pass in a control and return the button attached to this control
     *
     * Parameters:
     * control - {<OpenLayers.Control>} A control which was previously added to the toolbar
     *
     * Returns:
     * {<Ext.Toolbar.Button>} The requested button.
     */
    getButtonForControl: function(control) { 
        if (this.controls) { 
            for (var i = 0;  i < this.controls.length; i++) { 
                if (this.controls[i] == control) { 
                    return this._buttons[i];
                } 
            } 
        } 
        return null;
    },

    /**
     * Method: activate
     * Activates the toolbar, either by restoring a given state (if configurable) or the default one.
     */
    activate: function() {
        if (this.configurable) {
            this.applyState(this.state);
            var mb = new Ext.Toolbar.Button({'text': '+'});
            mb.menu = new Ext.menu.Menu();
            for(var i = 0; i < this.controls.length; i++) {
                mb.menu.add({
                    'style': 'height:25px',
                    'text': '<div style="position: relative; left: 25px; top: -15px;" class="' + this._buttons[i].iconCls + '"/>',
                    checked: this.controls[i].visible,
                    scope: {
                        toolbar: this, 
                        button: this._buttons[i], 
                        control: this.controls[i]
                    },
                    checkHandler: function(item, checked) {
                        if (checked) {
                            this.control.visible = true;
                            if (this.control.isDefault) {
                                this.control.activate();
                            } 
                            this.button.show();
                        } else {
                            this.control.visible = false;
                            this.control.deactivate();
                            this.button.hide();
                        }
                        this.toolbar.saveState();
                    }
                });

            }
            this.add(mb);
        } else {
            for (var j = 0, c; j < this.controls.length; j++) {
                c = this.controls[j];
                if(c.isDefault) {
                    c.activate();

                }
            }
        }
    },

    /**
     * Method: deactivate
     * Deactivates all controls in this toolbar.
     */
    deactivate: function() {
        for(var i = 0; i < this.controls.length; i++) {
            this.controls[i].deactivate();
        }
    },

    /**
     * Method: applyState
     * Apply the state to the toolbar upon loading
     *
     * Parameters:
     * state - {<Object>}
     */
    applyState: function(state){
        if (!state) {
            return false;
        }
        this.state = state;
        var cs = state.controls;
        if (cs) {
            for(var i = 0, len = cs.length; i < len; i++) {
                var s = cs[i];
                var c = this.getControlByClassName(s.id);
                if (c) {
                    c.visible = s.visible;
                    if (!c.visible) {
                        this._buttons[i].hide();
                    }
                }
            }
        }
    },

    /**
     * Method: getState
     * Function that builds op the state of the toolbar and returns it
     */
    getState: function() {
        var o = {controls: []};
        for (var i = 0, c; i < this.controls.length; i++) {
            c = this.controls[i];
            o.controls[i] = {
                id: c.CLASS_NAME,
                visible: c.visible
            };
        }
        return o;
    },

    /**
     * Method: toggleHandler
     * Called when a button is toggled.
     *
     * Parameters:
     * button - {<Ext.Toolbar.Button>}
     * control - {<OpenLayers.Control>}
     */
    toggleHandler: function(control, pressed) {
        if(pressed != control.active) {
            if (pressed) {
                control.activate();
            } else {
                control.deactivate();
            }
        }
    },

    /**
     * Method: checkDefaultControl
     * Check if there is a control active in the button's group. If not,
     * activate the default one (if any).
     *
     * Parameters:
     * button - {<Ext.Toolbar.Button>}
     */
    checkDefaultControl: function(button) {
        var group = button.toggleGroup;
        if(group) {
            var defaultControl = null;
            for (var j = 0; j < this.controls.length; j++) {
                var curButton = this._buttons[j];
                if(curButton.toggleGroup == group) {
                    var control = this.controls[j];
                    if(control.active) {
                        //found one button active in the group => OK
                        return;
                    } else if(control.isDefault) {
                        defaultControl = control;
                    }
                }
            }

            if(defaultControl) {
                //no active control found, activate the group's default one
                defaultControl.activate();
            }
        }        
    }
});
Ext.reg('toolbar', mapfish.widgets.toolbar.Toolbar);


/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish
 *
 * MapFish is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with MapFish.  If not, see <http://www.gnu.org/licenses/>.
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.editing');

/**
 * Class: mapfish.widgets.editing.BaseProperty
 * Abstract base class for the properties object used in the layerConfig
 * property of the <mapfish.widgets.editing.FeatureEditingPanel> class.
 */
mapfish.widgets.editing.BaseProperty = function(config) {
    Ext.apply(this, config);
};

mapfish.widgets.editing.BaseProperty.prototype = {
    /**
     * Property: label
     * {String} - The label.
     */
    label: null,

    /**
     * Property: name
     * {String} - Name of the property. It is used as an identifier.
     */
    name: null,

    /**
     * Property: type
     * {String} - The type that is used for the building the record type of this
     *            property. See the documentation of Ext.data.Record.create for
     *            the available types.
     */
    type: null,

    /**
     * Property: showInGrid
     * {Boolean} - True to show this property in the columns of the grid of edited
     *             features.
     */
    showInGrid: false,

    /**
     * Property: defaultValue
     * {AnyType} - The default value to use when creating a new feature.
     */
    defaultValue: null,

    /**
     * Property: extFieldCfg
     * {Object} - The config object to pass to the constructor of the
     * underlying Ext field.
     */
    extFieldCfg: null,

    /**
     * Method: getRecordType
     *
     * Returns:
     * {Ext.data.Record} An Ext record type describing this property.
     */
    getRecordType: function() {
        return {
            name: this.name,
            type: this.type
        };
    },

    /**
     * Method: getExtField
     * Returns the Ext Field that will be shown in the attribute form panel.
     * This has to be overriden by specific subclasses.
     *
     * Returns:
     * {Ext.form.Field | Object} Ext Field or Object that is converted to a
     * Component.
     */
    getExtField: function() {
        OpenLayers.Console.error("Not implemented");
    }
};

/**
 * Class: mapfish.widgets.editing.SimpleProperty
 * Extends <mapfish.widgets.editing.BaseProperty> to show string or numeric
 * properties with an <Ext.form.TextField>. You shouldn't use this class
 * directly, but use one of the child.
 */
mapfish.widgets.editing.SimpleProperty = function(config) {
    mapfish.widgets.editing.SimpleProperty.superclass.constructor.call(this, config);
};

Ext.extend(mapfish.widgets.editing.SimpleProperty, mapfish.widgets.editing.BaseProperty, {
    /**
     * Method: getExtField
     * Return an object with a "textfield" xtype property.
     *
     * Returns:
     * {Object}
     */
    getExtField: function() {
        return OpenLayers.Util.applyDefaults({
            xtype: 'textfield',
            fieldLabel: this.label || this.name,
            name: this.name
        }, this.extFieldCfg);
    }
});

/**
 * Class: mapfish.widgets.editing.StringProperty
 * Extension of <mapfish.widgets.editing.BaseProperty> for string properties.
 */
mapfish.widgets.editing.StringProperty = function(config) {
    this.type = 'string';
    this.defaultValue = '';
    mapfish.widgets.editing.StringProperty.superclass.constructor.call(this, config);
};
Ext.extend(mapfish.widgets.editing.StringProperty, mapfish.widgets.editing.SimpleProperty);

/**
 * Class: mapfish.widgets.editing.IntegerProperty
 * Extension of <mapfish.widgets.editing.BaseProperty> for integer properties.
 */
mapfish.widgets.editing.IntegerProperty = function(config) {
    this.type = 'int';
    this.defaultValue = 0;
    mapfish.widgets.editing.IntegerProperty.superclass.constructor.call(this, config);
};
Ext.extend(mapfish.widgets.editing.IntegerProperty, mapfish.widgets.editing.SimpleProperty, {
    /**
     * Method: getExtField
     * Return an object with a "numberfield" xtype property.
     *
     * Returns:
     * {Object}
     */
    getExtField: function() {
        return OpenLayers.Util.applyDefaults({
            xtype: 'numberfield',
            allowDecimals: false,
            fieldLabel: this.label || this.name,
            name: this.name
        }, this.extFieldCfg);
    }
});

/**
 * Class: FloatProperty
 * Extension of <mapfish.widgets.editing.BaseProperty> for float properties.
 */
mapfish.widgets.editing.FloatProperty = function(config) {
    this.type = 'float';
    this.defaultValue = 0;
    mapfish.widgets.editing.FloatProperty.superclass.constructor.call(this, config);
};
Ext.extend(mapfish.widgets.editing.FloatProperty, mapfish.widgets.editing.SimpleProperty, {
    /**
     * Method: getExtField
     * Return an object with a "numberfield" xtype property.
     *
     * Returns:
     * {Object}
     */
    getExtField: function() {
        return OpenLayers.Util.applyDefaults({
            xtype: 'numberfield',
            fieldLabel: this.label || this.name,
            name: this.name
        }, this.extFieldCfg);
    }
});

/**
 * Class: BooleanProperty
 */
mapfish.widgets.editing.BooleanProperty = function(config) {
    this.type = 'boolean';
    this.defaultValue = false;
    mapfish.widgets.editing.FloatProperty.superclass.constructor.call(this, config);
};
Ext.extend(mapfish.widgets.editing.BooleanProperty, mapfish.widgets.editing.BaseProperty, {
    /**
     * Method: getExtField
     * Returns an Ext checkbox.
     *
     * Returns:
     * {Ext.form.Checkbox} The Ext checkbox.
     */
    getExtField: function() {
        return new Ext.form.Checkbox(OpenLayers.Util.applyDefaults({
            name: this.name,
            fieldLabel: this.label || this.name
        }, this.extFieldCfg));
    }
});

/**
 * Class: mapfish.widgets.editing.ComboProperty
 * A property that is shown as a combobox. The combobox values are retrieved
 * using Ajax lazyily. The url should be returned as JSON in the following format:

   {
     root: [
       {id: 1, label: 'My label 1'},
       {id: 2, label: 'My label 2'},
       {id: 3, label: 'My label 3'}
     ]
   }

 * This property will return the numerical identifier as a value (integer), and
 * will show the label in the combobox.
 */
mapfish.widgets.editing.ComboProperty = function(config) {
    this.type = 'int';
    mapfish.widgets.editing.ComboProperty.superclass.constructor.call(this, config);
};

Ext.extend(mapfish.widgets.editing.ComboProperty, mapfish.widgets.editing.BaseProperty, {
    /**
     * APIProperty: url
     * {String} - URL used for fetching the JSON data to fill the combobox. See
     *            the comment on the class for what format is expected.
     */
    url: null,

    /**
     * Method: getExtField
     * Return an Ext combo box whose content is retrieved through an
     * HTTP proxy configured with the "url" property.
     *
     * Returns:
     * {Ext.form.ComboBox} The Ext combo box.
     */
    getExtField: function() {
        var store = new Ext.data.Store({
            proxy: new Ext.data.HttpProxy({
                url: this.url,
                method: 'GET',
                disableCaching: false
            }),
            reader: new Ext.data.JsonReader({
                root: 'root'
            }, [
                {name: 'id', type: 'int'}, 'label'
            ])
        });
        var cfg = OpenLayers.Util.applyDefaults({
            fieldLabel: this.label || this.name,
            typeAhead: true,
            triggerAction: 'all',
            editable: false,
            displayField: 'label',
            valueField: 'id',
            name: this.name,
            store: store,
            // Load the store after the combobox is rendered. This way the
            // combobox shows the correct label when the record is loaded on
            // the form.
            listeners: {
                render: {
                    fn: function(combo) {
                        var params = {};
                        params[this.queryParam] = '';
                        this.store.load({
                            params: params
                        });
                    }
                }
            }
        }, this.extFieldCfg);
        return new Ext.form.ComboBox(cfg);
    }
});

/**
 * Class: mapfish.widgets.editing.DateProperty
 * A property that is shown as a date picker.
 *
 * This property will return a date string.
 */
mapfish.widgets.editing.DateProperty = function(config) {
    this.type = 'string';
    mapfish.widgets.editing.DateProperty.superclass.constructor.call(this, config);
};

Ext.extend(mapfish.widgets.editing.DateProperty, mapfish.widgets.editing.BaseProperty, {
    /**
     * Method: getExtField
     * Return an Ext date field.
     *
     * Returns:
     * {Ext.form.DateField} The Ext data field.
     */
    getExtField: function() {
        return new Ext.form.DateField(OpenLayers.Util.applyDefaults({
            fieldLabel: this.label || this.name,
            name: this.name
        }, this.extFieldCfg));
    }
});

/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish
 *
 * MapFish is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with MapFish.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @requires OpenLayers/Layer/Vector.js
 * @requires OpenLayers/Control/ModifyFeature.js
 * @requires OpenLayers/Strategy/BBOX.js
 * @requires core/Protocol/MapFish.js
 * @requires widgets/toolbar/Toolbar.js
 * @requires widgets/data/FeatureReader.js
 * @requires widgets/data/LayerStoreMediator.js
 * @requires widgets/editing/FeatureProperties.js
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.editing');

/**
 * Class: mapfish.widgets.editing.FeatureEditingPanel
 * This class provides a panel for editing features.
 *
 * Inherits from:
 * - {Ext.Panel}
 */

/**
 * Constructor: mapfish.widgets.editing.FeatureEditingPanel
 *
 * Parameters:
 * config - {Object} Config object, see the possible Ext.Panel
 *     config options, and those specific to this panel
 *     documented below.
 */
 
 
 	 var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"Espere por favor..."});
	 
mapfish.widgets.editing.FeatureEditingPanel = Ext.extend(Ext.Panel, {

    /**
     * Constant: COMBO_NONE_VALUE
     * The value of the none entry in the combo.
     */
    COMBO_NONE_VALUE: "__combo_none_value__",

    /**
     * Constant: COMBO_NONE_NAME
     * The name (label) of the none entry in the combo.
     */
    COMBO_NONE_NAME: '--Ninguna Capa Editable--',//OpenLayers.i18n("mf.editing.comboNoneName"),

    /**
     * APIProperty: map
     * {<OpenLayers.Map>} OpenLayers Map object.
     */
    map: null,

    /**
     * APIProperty: layerConfig
     * {Object} Hash of layers with config parameters.
     *
     * Example:
     * (code start)
     * {
     *     campfacilities: {
     *         text: "Camps",
     *         protocol: new mapfish.Protocol.MapFish({url: "camps"}),
     *         featuretypes: {
     *             geometry: {
     *                 type: OpenLayers.Geometry.MultiPolygon
     *             },
     *             // See the documentation in the
     *             // mapfish.widgets.editing.FeatureProperties classes for more
     *             // details
     *             properties: [
     *                 new mapfish.widgets.editing.StringProperty(
     *                     {name: 'comment'}),
     *                 new mapfish.widgets.editing.IntegerProperty(
     *                     {name: 'status'}),
     *                 new mapfish.widgets.editing.ComboProperty(
     *                     {name: '_type', url: 'campfacilitytypes'}),
     *                 new mapfish.widgets.editing.IntegerProperty(
     *                     {name: 'name', showInGrid: true}),
     *                 new mapfish.widgets.editing.FloatProperty(
     *                     {name: 'camp_id'})
     *             ]
     *         }
     *     },
     *     refugees: {
     *         ...
     *     }
     * }
     * (end)
     */
    layerConfig: null,

    /**
     * Property: combo
     * {Ext.form.ComboBox} The combo box to select the layer to edit.
     */
    combo: null,

    /**
     * APIProperty: comboConfig
     * {Object} Optional config parameters for layer selection combo
     */
    comboConfig: null,

    /**
     * Property: form
     * {Ext.FormPanel} The form to edit attributes.
     */
    form: null,

    /**
     * Property: store
     * {Ext.data.Store} The feature store for the grid.
     */
    store: null,

    /**
     * Property: layerStoreMediator
     * {<mapfish.widgets.data.LayerStoreMediator>} The layer store
     * mediator, it updates the store each time features are modified,
     * added to or removed from the layer.
     */
    layerStoreMediator: null,

    /**
     * Property: grid
     * {Ext.grid.GridPanel} The grid to store the edited features.
     */
    grid: null,

    /**
     * Property: menu
     * {Ext.menu.Menu} Context menu.
     */
    menu: null,

    /**
     * Property: layer
     * {<OpenLayers.Layer.Vector>} The vector layer.
     */
    layer: null,

    /**
     * Property: currentLayerId
     * {String} The identifier of the current edited layer.
     */
    currentLayerId: null,

    /**
     * Property: modifyControl
     * {<OpenLayers.Control.ModifyFeature>}  The modify feature
     * control.
     */
    modifyFeatureControl: null,

    /**
     * Property: drawFeatureControl
     * {<OpenLayers.Control.DrawFeature>} The draw feature control.
     */
    drawFeatureControl: null,

    /**
     * Property: importBtn
     * {Ext.Button} The import button.
     */
    importBtn: null,

    /**
     * Property: commitBtn
     * {Ext.Button} Rhe commit button.
     */
    commitBtn: null,

    /**
     * Property: deleteBtn
     * {Ext.Button} The delete button.
     */
    deleteBtn: null,

    /**
     * Property: attributesFormDefaults
     * {Ext.data.Record} A record representing default attributes
     * in the form.
     */
    attributesFormDefaults: null,

    /**
     * Method: initComponent
     * Initialize the component.
	 			//	this.refreshFeatures();  //ok pero falla en update
				setTimeout(function(){	
		const_abandonada.redraw(true);
				},1000);
     */
    initComponent: function() {
        if (!this.map) {
            OpenLayers.Console.error(
                "map option for FeatureEditingPanel missing");
        }
        if (!this.layerConfig) {
            OpenLayers.Console.error(
                "layerConfig option for FeatureEditingPanel missing");
        }

        this.layout = 'form';
        this.tbar = this.createToolbar();

        mapfish.widgets.editing.FeatureEditingPanel.superclass.initComponent.apply(this);

        this.add(this.createLayerCombo());

        this.on("destroy", this.destroyResources, this);

        this.on("enable", this.setUp, this);
        this.on("disable", this.tearDown, this);

        // for accordion
        this.on('expand', this.setUp, this);
        this.on('collapse', this.tearDown, this);

        // for tabs
        this.on('activate', this.setUp, this);
        this.on('deactivate', this.tearDown, this);

        this.addEvents('beforecommit', 'commit');
    },


    /**
     * Method: createToolbar
     * Create the toolbar with the editing tools.
     *
     * Returns:
     * {<mapfish.widgets.toolbar.Toolbar>} MapFish toolbar.
     */
	 
 
    createToolbar: function() {
        this.importBtn = new Ext.Button({
            text: 'Refrescar Mapa',//OpenLayers.i18n("mf.editing.import"),
            tooltip: 'Anular los cambios realizados',//OpenLayers.i18n("mf.editing.importTooltip"),
            disabled: true,
            handler: function() {
                this.refreshFeatures();
            },
            scope: this
        });
       /* this.commitBtn = new Ext.Button({
            text: 'Guardar',//OpenLayers.i18n("mf.editing.commit"),
            iconCls: 'save',
			tooltip: 'Guardar Cambios Realizados',//OpenLayers.i18n("mf.editing.commitTooltip"),
            disabled: true,
            handler: function() {
			    myMask.show();
                this.commitFeatures();
				
            },
            scope: this
        });*/
        this.deleteBtn = new Ext.Button({
            text: 'Borrar',//OpenLayers.i18n("mf.editing.delete"),
			iconCls: 'delete',
            tooltip: 'Borrar Seleccion',//OpenLayers.i18n("mf.editing.deleteTooltip"),
            disabled: true,
            handler: function() {
                         this.deleteFeatures();
                         this.commitFeatures();
            },
            scope: this
        });
        var buttons = [
            this.importBtn
        
         //  , this.commitBtn
        , '-',
            this.deleteBtn
        ];
        return new mapfish.widgets.toolbar.Toolbar({
		  //  width: 300,
            items: buttons,
            map: this.map
        });
    },

    /**
     * Method: refreshFeatures
     * Refresh the vector layor.
     */
     refreshFeatures: function() {
        // we created the layer ourself so we're assured there's
        // only one strategy configured into it
    //   this.layer.strategies[0].update();
	//	this.layer.strategies[0].refresh({force: true});
	 this.layer.refresh();
	//	this.destroyLayer();
	//	this.createLayer();
		situacional.redraw(true);
		social.redraw(true);
		puntos_rojos.redraw(true);
		
		this.form.setDisabled(true);
		

    },

    /**
     * Method: commitFeatures
     * Commit the modified features.
     */
    commitFeatures: function() {
        this.layer.protocol.commit(this.layer.features, {
        		callback: function () { 			
                    this.refreshFeatures();
					myMask.hide();
			    },
                scope: this
        });
    },

    /**
     * Method: deleteFeatures
     * Delete the features that are in the selected features array of the layer.
     */
   deleteFeatures: function() {
        var feature;
        for (var i = this.layer.selectedFeatures.length - 1; i >= 0; i--) {
            feature = this.layer.selectedFeatures[i];
            // if the modify feature control has a selected feature,
            // and it is the current feature, unselect it
            if (this.modifyFeatureControl.feature == feature) {
                this.modifyFeatureControl.selectControl.unselect(feature);
            }
            if (feature.state == OpenLayers.State.INSERT) {
                // feature was created as part of the current "transaction",
                // so just destroy it right away
                this.layer.destroyFeatures([feature]);
            } else {
                feature.state = OpenLayers.State.DELETE;
                // add it to the store
                this.layerStoreMediator.featureStoreMediator.addFeatures(feature);
                // and redraw it so it gets the proper styling
                this.layer.drawFeature(feature);
            }
        }
    },

    /**
     * Method: createLayerCombo
     * Create a combobox to let user choose the layer to edit.
     *
     * Returns:
     * {Ext.form.ComboxBox} A combobox
     */
    createLayerCombo: function() {
        var data = [[this.COMBO_NONE_VALUE, this.COMBO_NONE_NAME]];
        for (var i in this.layerConfig) {
            data.push([i, this.layerConfig[i].text]);
        }
        var store = new Ext.data.SimpleStore({
            fields: ['value', 'text'],
            data : data
        });
        var comboConfig = OpenLayers.Util.applyDefaults({
            fieldLabel: 'Escoger Capa Editable',//OpenLayers.i18n("mf.editing.comboLabel"),
			width: 230,
            name: "editingLayer",
            hiddenName: "editingLayer",
            displayField: "text",
            valueField: "value",
            mode: "local",
            triggerAction: "all",
            editable: false,
            store: store,
            listeners: {
                select: function(combo, record, index) {
                    this.prepareSwitchLayer(record.data.value);
                },
                scope: this
            }
        }, this.comboConfig);
        this.combo = new Ext.form.ComboBox(comboConfig);
        return this.combo;
    },

    /**
     * Method: prepareSwitchLayer
     * Called when the user selects a layer in the combobox.
     *
     * Parameters:
     * id - {String} The layer id (key in layerConfig)
     */
    prepareSwitchLayer: function(id) {
        if (this.isDirty()) {
            Ext.Msg.confirm(
                'Aviso!',//OpenLayers.i18n("mf.editing.confirmMessageTitle"),
                'Desea Guardar cambios antes de cambiar de capa editable?',//OpenLayers.i18n("mf.editing.confirmMessage"),
                function(btn, text){
                    if (btn == "yes") {
					  this.commitFeatures();
                        this.switchLayer(id);
                    } else {
					   this.switchLayer(id);
                       // this.combo.setValue(this.currentLayerId);
                    }
                },
                this
            );
        } else {
            this.switchLayer(id);
        }
    },

    /**
     * Method: switchLayer
     *
     * Parameters:
     * id - {String} The layer id (key in layerConfig)
     */
    switchLayer: function(id) {
        if (id != this.COMBO_NONE_VALUE) {
		this.destroyAllResources();  // resfrescando
            var config = this.layerConfig[id];
            this.configureLayer(config);
            this.createStore(config);
            this.createModifyFeatureControl();
            this.createDrawFeatureControl(config);
            this.createLayerStoreMediator();
            this.importBtn.enable();
            this.createForm(config);
          //  this.createGrid(config);
			this.getTopToolbar().syncSize();
			//importar capa editable al entrar
			myMask.show();
            this.refreshFeatures();
			
        } else {
            this.destroyAllResources();
        }
        this.currentLayerId = id;
    },

    /**
     * Method: configureLayer
     *
     * Parameters:
     * config - {Object} The layer configuration.
     */
    configureLayer: function(config) {
        var layer = this.layer;
        if (!layer) {
            layer = this.layer = this.createLayer();
        }
        // we don't want to destroy the protocol when the layer
        // is destroyed
        config.protocol.autoDestroy = false;
        layer.protocol = config.protocol;
        if (OpenLayers.Util.indexOf(this.map.layers, layer) < 0) {
            this.map.addLayer(layer);
        }
        layer.destroyFeatures();
    },

    /**
     * Method: createLayer
     * Create the vector layer.
     */
    createLayer: function() {
        var layer = new OpenLayers.Layer.Vector(
            OpenLayers.Util.createUniqueID("mf.ediding"), {
            strategies: [this.createStrategy()],
            styleMap: this.createStyleMap(),
            displayInLayerSwitcher:false
        });
		layer.events.register(
            "loadend", this, function(){
			myMask.hide();
		});
        layer.events.register(
            "featureselected", this, this.onFeatureselected
        );
        layer.events.register(
            "featureunselected", this, this.onFeatureunselected
        );
        layer.events.register(
            "featureremoved", this, this.onFeatureremoved
         );
        layer.events.register(
            "featuremodified", this, this.onFeaturemodified
        );
        return layer;
    },

    /**
     * Method: destroyLayer
     * Destroy the vector layer.
     */
    destroyLayer: function() {
        var layer = this.layer;
        if (layer) {
            layer.destroy();
            this.layer = null;
        }
    },

    /**
     * Method: createStyleMap
     * Create a style map for the vector layer.
     *
     * Returns:
     * {<OpenLayer.StyleMap>} The style map.
     */
    createStyleMap: function() {
        var styleMap = new OpenLayers.StyleMap();
        // create a styleMap for the vector layer so that features
        // have different styles depending on their state
        var context = function(feature) {
            return {
                state: feature.state || OpenLayers.State.UNKNOWN
            };
        };
        var lookup = {};
			
        lookup[OpenLayers.State.UNKNOWN] = {
		graphicName: 'square',
        strokeColor: '#555',
        fillColor: '#555'
        };
        lookup[OpenLayers.State.UPDATE] = {
            fillColor: "green",
            strokeColor: "green"
        };
        lookup[OpenLayers.State.DELETE] = {
            fillColor: "red",
            strokeColor: "red",
            fillOpacity: 0.2,
            strokeOpacity: 0.3,
            display: ""
        };
        lookup[OpenLayers.State.INSERT] = {
            fillColor: "green",
            strokeColor: "green"
        };
        styleMap.addUniqueValueRules("default", "state", lookup, context);
        styleMap.addUniqueValueRules("delete", "state", lookup, context);
        return styleMap;
    },

    /**
     * Method: createStrategy
     * Create a BBOX strategy for the vector layer.
     *
     * Returns:
     * {<OpenLayers.Strategy.BBOX>}
     */
    createStrategy: function() {
	 return new OpenLayers.Strategy.Fixed();
      /*  return new OpenLayers.Strategy.BBOX({
            autoActivate: false
        });
		*/
		/*
		return new OpenLayers.Strategy.Refresh({
            force: true
		});*/
		
    },

    /**
     * Method: onFeatureselected
     *
     * Parameters:
     * obj - {Object} Object with a feature property
     */
    onFeatureselected: function(obj) {
        var f = obj.feature;
        this.deleteBtn.enable();
        this.selectInGrid(f);
        this.editAttributes(f);
    },

    /**
     * Method: onFeatureunselected
     *
     * Parameters:
     * obj - {Object} Object with a feature property
     */
    onFeatureunselected: function(obj) {
        this.deleteBtn.disable();
        this.unselectInGrid();
        this.form.getForm().reset();
        this.form.setDisabled(true);
    },

    /**
     * Method: createStore
     * Create the store containing the edited features.
     */
    createStore: function(config) {
        this.destroyStore();
        var fields = [];
        var properties = config.featuretypes.properties;
        for (var i = 0; i < properties.length; i++) {
            fields.push(properties[i].getRecordType());
        }
        var store = new Ext.data.GroupingStore({
            reader: new mapfish.widgets.data.FeatureReader(
                {}, fields
            ),
            groupField: "state"
        });
     //   store.on("add", this.updateCommitBtnState, this);
  //      store.on("remove", this.updateCommitBtnState, this);
    //    store.on("clear", this.updateCommitBtnState, this);
        store.on("load", this.updateGridSelection, this);
        this.store = store;
    },

    /**
     * Method: destroyStore
     * Destroy the feature store.
     */
    destroyStore: function() {
        var store = this.store;
        if (store) {
            // for unknown reason this method is in Ext's API
            // doc, use it anyway as it's the safest method to
            // unregister listeners registered in the store
            store.destroy();
            this.store = null;
        }
    },

    /**
     * Method: updateCommitBtnState
     * Enable or disable the commit button based on whether there
     * are records or store in the store.
     */
    updateCommitBtnState: function(store) {
        this.commitBtn.setDisabled(!(store.getCount() > 0));
    },

    /**
     * Method: updateGridSelection
     * Make the selection in the grid reflect what's selected in
     * the layer.
     */
    updateGridSelection: function(store, records, options) {
        for (var i = 0; i < records.length; i++) {
            var feature = records[i].data.feature;
            if (OpenLayers.Util.indexOf(
                    this.layer.selectedFeatures, feature) >= 0) {
                this.selectInGrid(feature);
            }
        }
    },

    /**
     * Method: createModifyFeatureControl
     * Create a modify feature control.
	var selectFeature = new OpenLayers.Control.SelectFeature(vectorLayer);
    var drawFeature = new OpenLayers.Control.DrawFeature(
        vectorLayer, OpenLayers.Handler.Point);
		
     */
	 
    createModifyFeatureControl: function() {
     	this.destroyModifyFeatureControl();
        var ctrl = new OpenLayers.Control.ModifyFeature(this.layer, {
            mode: OpenLayers.Control.ModifyFeature.RESHAPE |
                  OpenLayers.Control.ModifyFeature.DRAG,
            title: 'Seleccionar y Modificar Elemento'//OpenLayers.i18n("mf.editing.selectModifyFeature")
        });
       this.getTopToolbar().addControl(ctrl, {
            iconCls: 'edit-modify',
			text: 'Modificar',
            scale:'medium',
            iconAlign:'left',
            toggleGroup: this.getId() + 'map'
        });
        ctrl.deactivate();
        this.modifyFeatureControl = ctrl;
    },

    /**
     * Method: destroyModifyFeatureControl
     * Destroy the modify feature control.
     */
    destroyModifyFeatureControl: function() {
        var ctrl = this.modifyFeatureControl;
        if (ctrl) {
            this.getTopToolbar().removeControl(ctrl);
            ctrl.destroy();
            this.modifyFeatureControl = null;
        }
    },

    /**
     * Method: onFeatureremoved
     *
     * Parameters:
     * obj - {Object} Object with a feature property
     */
    onFeatureremoved: function(obj) {
        if (this.modifyFeatureControl &&
            obj.feature == this.modifyFeatureControl.feature) {
            this.modifyFeatureControl.feature = null;
        }
    },

    /**
     * Method: onFeaturemodified
     *
     * Parameters:
     * obj - {Object} Object with a feature property
     */
     onFeaturemodified: function(obj) {
         var feature = obj.feature;
         if (feature.state != OpenLayers.State.INSERT) {
             feature.state = OpenLayers.State.UPDATE;
         }
     },

    /**
     * Method: createDrawFeatureControl
     * Create a modify feature control.
     *
     * Parameters:
     * config -  {Object} A layer config object.
     */
    createDrawFeatureControl: function(config) {
        this.destroyDrawFeatureControl();
        var title, handler, multi = false, iconCls;
        switch (config.featuretypes.geometry.type) {
            case OpenLayers.Geometry.MultiPoint:
                multi = true;
            case OpenLayers.Geometry.Point:
                title = 'Dibujar Nuevo Punto';//OpenLayers.i18n("mf.editing.drawPointTitle");
                handler = OpenLayers.Handler.Point;
                iconCls = "edit-add";
                break;
            case OpenLayers.Geometry.MultiPolygon:
                multi = true;
            case OpenLayers.Geometry.Polygon:
                title = 'Dibujar Nuevo Poligono';//OpenLayers.i18n("mf.editing.drawPolygonTitle");
                handler = OpenLayers.Handler.Polygon;
                iconCls = "edit-add";
                break;
            case OpenLayers.Geometry.MultiLineString:
                multi = true;
            case OpenLayers.Geometry.LineString:
                title = 'Dibujar Nueva Linea';//OpenLayers.i18n("mf.editing.drawLineTitle");
                handler = OpenLayers.Handler.Path;
                iconCls = "edit-add";
                break;
        }
        var ctrl =  new OpenLayers.Control.DrawFeature(this.layer, handler, {
            title: title,
            featureAdded: OpenLayers.Function.bind(this.onFeatureadded, this),
            handlerOptions: {
                multi: multi
            }
        });
        this.getTopToolbar().addControl(ctrl, {
            iconCls: iconCls,
			text: 'Dibujar',
			 scale:'medium',
            iconAlign:'left',
            toggleGroup: this.getId() + 'map'
        });
        this.drawFeatureControl = ctrl;
		ctrl.activate();
    },

    /**
     * Method: destroyDrawFeatureControl
     * Destroy the draw feature control.
     */
    destroyDrawFeatureControl: function() {
        var ctrl = this.drawFeatureControl;
        if (ctrl) {
            this.getTopToolbar().removeControl(ctrl);
            ctrl.destroy();
            this.drawFeatureControl = null;
        }
    },

    /**
     * Method: onFeatureadded
     *
     * Parameters:
     * feature - {<OpenLayers.Feature.Vector>}
     */
    onFeatureadded: function(feature) {
        feature.state = OpenLayers.State.INSERT;
        // HACK: at this point "featuresadded" has alreay been triggered,
        // so for the layer store mediator to see the INSERT state of
        // that feature we trigger "featuresadded" again
        this.layer.events.triggerEvent("featuresadded", {
            features: [feature]
        });
        this.modifyFeatureControl.selectControl.select(feature);
        this.form.getForm().loadRecord(
            this.attributesFormDefaults
        );
        this.modifyFeatureControl.activate();
    },

    /**
     * Method: createLayerStoreMediator
     * Create the layer store mediator.
     */
    createLayerStoreMediator: function() {
        this.destroyLayerStoreMediator();
        var lsm = new mapfish.widgets.data.LayerStoreMediator({
            store: this.store,
            layer: this.layer,
            filter: function(feature) {
                return feature.state != null &&
                       feature.state != OpenLayers.State.UNKNOWN;
            }
        });
        lsm.activate();
        this.layerStoreMediator = lsm;
    },

    /**
     * Method: destroyLayerStoreMediator
     * Destroy the layer store mediator.
     */
    destroyLayerStoreMediator: function() {
        var lsm = this.layerStoreMediator;
        if (lsm) {
            lsm.deactivate();
            this.layerStoreMediator = null;
        }
    },

    /**
     * Method: destroyAllResources
     * Called when "None" is select in the combo.
     */
    destroyAllResources: function() {
        this.destroyResources();
        this.destroyForm();
        this.destroyGrid();
    },

    /**
     * Method: destroyResources
     * Called when the feature editing panel is destroyed, takes care
     * of destroying all the resources that aren't destroyed by the
     * Ext.Panel destroy method.
     */
    destroyResources: function() {
        // note: the components that are actually added to the feature
        // editing panel are destroyed in the destroy method of
        // Ext.Panel
        this.destroyStore();
        this.destroyModifyFeatureControl();
        this.destroyDrawFeatureControl();
        this.destroyLayerStoreMediator();
        this.destroyLayer();
    },

    /**
     * Method: setUp
     * Set up the feature editing panel.
     */
    setUp: function() {
        if (this.layer &&
            this.currentLayerId != this.COMBO_NONE_VALUE) {
            this.map.addLayer(this.layer)
        }
        if (this.modifyFeatureControl) {
            this.modifyFeatureControl.activate();
        }
    },

    /**
     * Method: tearDown
     * Tear down the feature editing panel.
     */
    tearDown: function() {
        if (this.modifyFeatureControl) {
            this.modifyFeatureControl.deactivate();
        }
        if (this.drawFeatureControl) {
            this.drawFeatureControl.deactivate();
        }
        var layer = this.layer;
        if (layer &&
            OpenLayers.Util.indexOf(this.map.layers, layer) >= 0) {
            this.map.removeLayer(layer)
        }
    },

    /**
     * Method: createForm
     * Create the feature attributes form for a given layer.
     *
     * Parameters:
     * config - {Object} The layer config object.
     */
    createForm: function(config) {
        if (!config.featuretypes) {
            OpenLayers.Console.error(
                "no featuretypes exist for the given layer"
            );
            return;
        }
        var form = this.form;
        if (!form) {
            var form = new Ext.FormPanel({
                title: 'Atributos del Objeto Seleccionado',//OpenLayers.i18n("mf.editing.formTitle"),
                disabled: true,
                items: [{}], // hack to avoid JS errors if no items are provided
                trackResetOnLoad: true, // to detect attributes updates
                bodyStyle: 'padding: 5px',
                buttons: [{
                    text: 'Guardar Punto',
                    handler: function() {
                        if (!this.currentlyEditedFeature ||
                            !this.form.getForm().isDirty()) {
                            return;
                        }
                        this.updateFeatureAttributes(this.currentlyEditedFeature);
						 myMask.show();
                this.commitFeatures();
                    },
                    scope: this
                }]
            });
            this.add(form);
            this.form = form;
            this.doLayout();
        }
        // clear current form (remove all items)
        var items = this.form.items.items
        for (var i = items.length - 1; i >=0; --i) {
            var field = items[i];
            form.getForm().remove(field);
            form.remove(field);
        }
        var properties = config.featuretypes.properties;
        var defaults = {};
        for (i = 0; i < properties.length; i++) {
            var property = properties[i];
            form.add(property.getExtField());
            defaults[property.name] = property.defaultValue;
        }
        form.doLayout();
        this.attributesFormDefaults = new Ext.data.Record(defaults);
        form.getForm().loadRecord(this.attributesFormDefaults);
    },

    /**
     * Method: destroyForm
     * Destroy the feature attributes form.
     */
    destroyForm: function() {
        var form = this.form;
        if (form) {
            form.destroy();
            this.form = null;
        }
    },

    /**
     * Method: updateFeatureAttributes
     * Loops into the attributes form and updates the OL feature
     *     attributes and data properties
     *
     * Parameters:
     * feature - {<OpenLayers.Feature>} The feature whose attributes are
     *     to be updated
     */
    updateFeatureAttributes: function(feature) {
        var item, value, i, items = this.form.items.items;
        for (i = 0; i < items.length; i++) {
            item = items[i];
            if (!item.getValue) {
                // prevent errors if this is not a form field
                continue;
            }
            if (item.isDirty && item.isDirty()) {
                value = item.getValue();
                feature.attributes[item.name] = value;
                feature.data[item.name] = value;
            }
        }
        if (feature.state != OpenLayers.State.INSERT) {
            feature.state = OpenLayers.State.UPDATE;
        }
        var fsm = this.layerStoreMediator.featureStoreMediator;
        fsm.addFeatures([feature]);
    },

    /**
     * Method: createGrud
     * Create a feature grid for the given layer.
     *
     * Parameters:
     * config - {Object} Layer config object.
     */
    createGrid: function(config) {
        var grid = this.grid;
        if (grid) {
            this.destroyGrid();
        }
        if (!config.featuretypes) {
            OpenLayers.Console.error(
                "no featuretypes exist for the given layer");
            return;
        }
        if (!config.featuretypes.properties) {
            OpenLayers.Console.error(
                "no featuretypes properties are given for layer");
            return;
        }
        var columns = [{
            header: 'Identificador', //OpenLayers.i18n("mf.editing.gridIdHeader"),
            dataIndex: "fid"
        }];
        Ext.each(config.featuretypes.properties, function(property) {
            if (property.showInGrid) {
                columns.push({
                    // FIXME it should use i18n instead of using the text property
                    header: property.label || property.name,
                    dataIndex: property.name
                });
            }
        });
        columns.push({
            header: 'Estado', //OpenLayers.i18n("mf.editing.gridStateHeader"),
            dataIndex: "state"
        });
        grid = new Ext.grid.GridPanel({
            title: 'Bitacora de cambios',//OpenLayers.i18n("mf.editing.gridTitle"),
            height: 200,
            store: this.store,
            view: new Ext.grid.GroupingView({
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Features" : "Feature"]})'
            }),
            columns: columns
        });
        grid.on("rowcontextmenu", this.onContextClick, this);
        this.add(grid);
        this.doLayout();
        this.grid = grid;
    },

    /**
     * Method: destroyGrid
     * Destroy the feature grid.
     */
    destroyGrid: function() {
        if (this.grid) {
            this.grid.destroy();
            this.grid = null;
        }
    },

    /**
     * Method: selectInGrid
     * Selects and focuses on the row of a given feature in the featureGrid
     *
     * Parameters:
     * feature - {<OpenLayers.Feature>}
     */
    selectInGrid: function(feature) {
        if (this.store && this.grid) {
            var index = this.store.findBy(function(rec, id) {
                return rec.get("feature") == feature;
            });
            var record = this.store.getAt(index);
            this.grid.getSelectionModel().selectRecords([record]);
            if (index != -1) {
                this.grid.getView().focusRow(index);
            }
        }
    },

    /**
     * Method: unselectInGrid
     */
    unselectInGrid: function() {
        if (this.grid) {
            this.grid.getSelectionModel().clearSelections();
        }
    },

    /**
     * Method: editAttributes
     * Shows/enable the editing attributes form and loads the
     *     feature attributes in the corresponding fields
     *
     * Parameters
     * feature - {<OpenLayers.Feature.Vector>}
     */
    editAttributes: function(feature) {
        this.currentlyEditedFeature = feature;
        this.form.getForm().reset();

        // use the feature store read to get a record object corresponding
        // to the edited feature
        var obj = this.store.reader.readRecords([feature]);
        var record = obj.records[0];

        this.form.getForm().loadRecord(record);
        this.form.enable();
    },

    /**
     * Method: onContextClick
     * Is called when user right clicks on a feature grid row
     *     Shows a contextual menu
     *
     * Parameters
     * grid - {<Ext.grid.GridPanel>}
     * index - {<Ext.Record>}
     * e - {<Ext.Event>}
     */
    onContextClick: function(grid, index, e) {
        var menu = this.menu;
        if (!menu) { // create context menu on first right click
            menu = new Ext.menu.Menu({
                id: 'grid-ctx',
                items: [{
                    text: OpenLayers.i18n('mf.editing.onContextClickMessage'),
                    scope: this,
                    handler: function() {
                        this.modifyFeatureControl.selectControl.unselectAll();
                        var feature = this.ctxRecord.data.feature;
                        this.modifyFeatureControl.selectControl.select(feature);
                        this.modifyFeatureControl.activate();
                    }
                }]
            });
            menu.on('hide', this.onContextHide, this);
            this.menu = menu;
        }
        e.stopEvent();
        if (this.ctxRow) {
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        this.ctxRow = grid.view.getRow(index);
        this.ctxRecord = grid.store.getAt(index);
        Ext.fly(this.ctxRow).addClass('x-node-ctx');
        menu.showAt(e.getXY());
    },

    /**
     * Method: onContextHide
     * Hides the context menu
     */
    onContextHide : function(){
        if(this.ctxRow) {
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
    },

    /**
     * Method: isDirty
     * Checks for unsaved (uncommited) changes
     *
     * Returns
     * {Boolean} - true is there are no unsaved changes
     */
    isDirty: function() {
        return (this.store &&
                this.store.getCount() > 0);
    },

    /**
     * APIMethod: setWindowOnbeforeunload
     * Convenience method that sets window.onbeforeunload so that
     * when going away from the page a confirm window is displayed
     * if the store includes uncommitted changes.
     */
    setWindowOnbeforeunload: function() {
        window.onbeforeunload = OpenLayers.Function.bind(
            function(e) {
                if (this.isDirty()) {
                    return OpenLayers.i18n("mf.editing.onBeforeUnloadMessage");
                }
            },
            this
        );
    }
});

Ext.reg('featureediting', mapfish.widgets.editing.FeatureEditingPanel);


/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.data');

/**
 * Class: mapfish.widgets.data.FeatureReader
 *      FeatureReader is a specific Ext.data.DataReader. When records are
 *      added to the store using this reader, specific fields like
 *      feature, state and fid are available.
 *
 * Deprecated:
 * This widget is deprecated and will be removed in next mapfish version.
 * Please use <http://geoext.org/lib/GeoExt/data/FeatureReader.html> instead.
 *
 * Typical usage in a store:
 * (start code)
 *         var store = new Ext.data.Store({
 *             reader: new mapfish.widgets.data.FeatureReader({}, [
 *                 {name: 'name', type: 'string'},
 *                 {name: 'elevation', type: 'float'}
 *             ])
 *         });
 * (end)
 *
 * Inherits from:
 *  - {Ext.data.DataReader}
 */

/**
 * Constructor: mapfish.widgets.data.FeatureReader
 *      Create a feature reader. The arguments passed are similar to those
 *      passed to {Ext.data.DataReader} constructor.
 */
mapfish.widgets.data.FeatureReader = function(meta, recordType){
    meta = meta || {};
    mapfish.widgets.data.FeatureReader.superclass.constructor.call(
        this, meta, recordType || meta.fields
    );
};

Ext.extend(mapfish.widgets.data.FeatureReader, Ext.data.DataReader, {

    /**
     * APIProperty: totalRecords
     * {Integer}
     */
    totalRecords: null,

    /**
     * APIMethod: read
     * This method is only used by a DataProxy which has retrieved data.
     *
     * Parameters:
     * response - {<OpenLayers.Protocol.Response>}
     *
     * Returns:
     * {Object} An object with two properties. The value of the property "records"
     *      is the array of records corresponding to the features. The value of the
     *      property "totalRecords" is the number of records in the array.
     */
    read: function(response) {
        return this.readRecords(response.features);
    },

    /**
     * APIMethod: readRecords
     *      Create a data block containing Ext.data.Records from
     *      an array of features.
     *
     * Parameters:
     * features - {Array{<OpenLayers.Feature.Vector>}}
     *
     * Returns:
     * {Object} An object with two properties. The value of the property "records"
     *      is the array of records corresponding to the features. The value of the
     *      property "totalRecords" is the number of records in the array.
     */
    readRecords : function(features) {
        var records = [];

        if (features) {
            var recordType = this.recordType, fields = recordType.prototype.fields;
            var i, lenI, j, lenJ, feature, values, field, v;
            for (i = 0, lenI = features.length; i < lenI; i++) {
                feature = features[i];
                values = {};
                if (feature.attributes) {
                    for (j = 0, lenJ = fields.length; j < lenJ; j++){
                        field = fields.items[j];
                        v = feature.attributes[field.mapping || field.name] ||
                            field.defaultValue;
                        v = field.convert(v);
                        values[field.name] = v;
                    }
                }
                values.feature = feature;
                values.state = feature.state;
                values.fid = feature.fid;

                records[records.length] = new recordType(values, feature.id);
            }
        }

        return {
            records: records,
            totalRecords: this.totalRecords != null ? this.totalRecords : records.length
        };
    }
});
/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @requires widgets/data/FeatureReader.js
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.data');

/**
 * Class: mapfish.widgets.data.FeatureStore
 * Helper class to ease creating stores of features. An instance of this
 * class is pre-configured with a <mapfish.widgets.data.FeatureReader>.
 *
 * Typical usage in a store:
 * (start code)
 *         var store = new Ext.data.FeatureStore({
 *             fields: [
 *                 {name: 'name', type: 'string'},
 *                 {name: 'elevation', type: 'float'}
 *             ]
 *         });
 *         store.loadData(features);
 * (end)
 *
 * Inherits from:
 *  - {Ext.data.Store}
 */

/**
 * Constructor: mapfish.widgets.data.FeatureStore
 * Create a feature store, the options passed in the config object are
 * similar to those passed to an Ext.data.Store constructor; in addition
 * the config object must include a "fields" property referencing an Array
 * of field definition objects as passed to Ext.data.Record.create, or a
 * Record constructor created using Ext.data.Record.create.
 *
 * Parameters:
 * config {Object} The config object.
 *
 * Returns:
 * {<mapfish.widgets.data.FeatureStore>} The feature store.
 */
mapfish.widgets.data.FeatureStore = function(config) {
    mapfish.widgets.data.FeatureStore.superclass.constructor.call(this, {
        reader:  new mapfish.widgets.data.FeatureReader(
            config, config.fields
        )
    });
};
Ext.extend(mapfish.widgets.data.FeatureStore, Ext.data.Store, {
    /**
     * APIProperty: fields
     * {Object} An Array of field definition objects as passed to
     * Ext.data.Record.create, or a Record constructor created using
     * Ext.data.Record.create.
     */
    fields: null
});
/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @requires widgets/data/FeatureReader.js
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.data');

/**
 * Class: mapfish.widgets.data.FeatureStoreMediator
 * This class is to be used when one wants to insert features in a store.
 *
 * Usage example:
 * (start code)
 * var store = new Ext.data.Store({
 *     reader: new mapfish.widgets.data.FeatureReader(
 *         {}, [{name: "name", type: "string"}]
 *     )
 * });
 * var mediator = new mapfish.widgets.data.FeatureStoreMediator({
 *     store: store,
 *     append: false,
 *     filter: function(feature) {
 *         return feature.state != OpenLayers.State.UNKNOWN;
 *     }
 * });
 * (end)
 */

/**
 * Constructor: mapfish.widgets.data.FeatureStoreMediator
 * Create an instance of mapfish.widgets.data.FeatureStoreMediator
 *
 * Parameters:
 * config - {Object} A config object used to set the feature
 *     store mediator's properties, see below for the list
 *     of supported properties.
 *
 * Returns:
 * {<mapfish.widgets.data.FeatureStoreMediator>}
 */
mapfish.widgets.data.FeatureStoreMediator = function(config){
    Ext.apply(this, config);
    if (!this.store) {
        OpenLayers.Console.error(
            "store is missing in the config");
    }
    if (!(this.store.reader instanceof mapfish.widgets.data.FeatureReader ||
          this.store.reader instanceof GeoExt.data.FeatureReader)) {
        OpenLayers.Console.error(
            "store does not use a FeatureReader");
    }
};

mapfish.widgets.data.FeatureStoreMediator.prototype = {
    /**
     * APIProperty: store
     * {Ext.data.Store} An Ext data store
     */
    store: null,

    /**
     * APIProperty: append
     * {Boolean} False if the store must be cleared before adding new
     * features into it, false otherwise; defaults to true.
     */
    append: true,

    /**
     * APIProperty: filter
     * {Function} a filter function called for each feature to be
     * inserted, the feature is passed as an argument to the function,
     * if it returns true the feature is inserted into the store,
     * otherwise the feature is not inserted.
     */
    filter: null,

    /**
     * APIMethod: addFeatures
     *      Add features to the store.
     * 
     * Parameters:
     * features - {<OpenLayers.Feature.Vector>} or
     *     {Array{<OpenLayers.Feature.Vector>}} A feature or an
     *     array of features to add to the store.
     * config - a config object which can include the properties
     *     "append" and "filter", if set these properties will
     *     override that set in the object.
     */
    addFeatures: function(features, config) {
        if (!Ext.isArray(features)) {
            features = [features];
        }
        config = OpenLayers.Util.applyDefaults(config,
            {append: this.append, filter: this.filter});
        var toAdd = features;
        if (config.filter) {
            toAdd = [];
            var feature;
            for (var i = 0, len = features.length; i < len; i++) {
                feature = features[i];
                if (config.filter(feature)) {
                    toAdd.push(feature);
                }
            }
        }
        // because of a bug in Ext if config.append is false we clean
        // the store ourself and always pass true to loadData, there
        // are cases where passing false to loadData results in Ext
        // trying to dereference an undefined value, see the unit
        // tests test_ExtBug and text_addFeatures_ExtBug for 
        // concrete examples
        if (!config.append) {
            this.store.removeAll();
        }
        this.store.loadData(toAdd, true);
    },

    /**
     * APIMethod: removeFeatures
     *      Remove features from the store.
     *
     * Parameters:
     * features - {<OpenLayers.Feature.Vector>} or
     *      {Array{<OpenLayers.Feature.Vector>}} A feature or an
     *      array of features to remove from the store. If null
     *      all the features in the store are removed.
     */
    removeFeatures: function(features) {
        if (!features) {
            this.store.removeAll();
        } else {
            if (!Ext.isArray(features)) {
                features = [features];
            }
            for (var i = 0, len = features.length; i < len; i++) {
                var feature = features[i];
                var r = this.store.getById(feature.id);
                if (r !== undefined) {
                    this.store.remove(r);
                }
            }
        }
    }
};
/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @requires widgets/data/FeatureStoreMediator.js
 * @requires OpenLayers/Layer/Vector.js
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.data');

/**
 * Class: mapfish.widgets.data.LayerStoreMediator
 *
 * This class is to be used when one wants to insert, remove, and
 * update features in a grid as a result of features being inserted,
 * removed, modified in a vector layer.
 *
 * Deprecated:
 * This widget is deprecated and will be removed in next mapfish version.
 * Please use <http://geoext.org/lib/GeoExt/data/FeatureReader.html> instead.
 *
 * Usage example:
 * (start code)
 * var layer = new OpenLayers.Layer.Vector("vector");
 * var store = new Ext.data.Store({
 *     reader: new mapfish.widgets.data.FeatureReader(
 *         {}, [{name: "name", type: "string"}]
 *     )
 * });
 * var mediator = new mapfish.widgets.data.LayerStoreMediator({
 *     store: store,
 *     layer: layer,
 *     filter: function(feature) {
 *         return feature.state != OpenLayers.State.UNKNOWN;
 *     }
 * });
 * (end)
 */

/**
 * Constructor: mapfish.widgets.data.LayerStoreMediator
 * Create an instance of mapfish.widgets.data.LayerStoreMediator.
 *
 * Parameters:
 * config - {Object} A config object used to set the layer
 *     store mediator's properties (see below for the list
 *     of supported properties), and configure it with the
 *     Ext store; see the usage example above.
 *
 * Returns:
 * {<mapfish.widgets.data.LayerStoreMediator>}
 */
mapfish.widgets.data.LayerStoreMediator = function(config){
    var store = config.store;
    // no need to place the store in the instance
    delete config.store;
    Ext.apply(this, config);
    if (!this.layer) {
        OpenLayers.Console.error(
            "layer is missing in config");
    }
    this.featureStoreMediator = new mapfish.widgets.data.FeatureStoreMediator({
        store: store
    });
    if (this.autoActivate) {
        this.activate();
    }
};

mapfish.widgets.data.LayerStoreMediator.prototype = {
    /**
     * APIProperty: layer
     * {<OpenLayers.Layer.Vector>} The vector layer.
     */
    layer: null,

    /**
     * APIProperty: filter
     * {Function} a filter function called for each feature to be
     * inserted, the feature is passed as an argument to the function,
     * if it returns true the feature is inserted into the store,
     * otherwise the feature is not inserted.
     */
    filter: null,

    /**
     * APIProperty: autoActivate
     * {Boolean} True if the mediator must be activated as part of
     * its creation, false otherwise; if false then the mediator must
     * be explicitely activate using the activate method; defaults
     * to true.
     */
    autoActivate: true,

    /**
     * Property: active
     * {Boolean}
     */
    active: false,

    /**
     * Property: featureStoreMediator
     * {<mapfish.widgets.data.featureStoreMediator>} An internal
     * feature store mediator for manually adding features to the
     * Ext store.
     */
    featureStoreMediator: null,

    /**
     * APIMethod: activate
     * Activate the mediator.
     *
     * Returns:
     * {Boolean} - False if the mediator was already active, true
     * otherwise.
     */
    activate: function() {
        if (!this.active) {
            this.layer.events.on({
                featuresadded: this.update,
                featuresremoved: this.update,
                featuremodified: this.update,
                scope: this
            });
            this.active = true;
            return true;
        }
        return false;
    },

    /**
     * APIMethod: deactivate
     * Deactivate the mediator.
     *
     * Returns:
     * {Boolean} - False if the mediator was already deactive, true
     * otherwise.
     */
    deactivate: function() {
        if (this.active) {
            this.layer.events.un({
                featuresadded: this.update,
                featuresremoved: this.update,
                featuremodified: this.update,
                scope: this
            });
            return true;
        }
        return false;
    },

    /**
     * Method: update
     *      Called when features are added, removed or modified. This
     *      function empties the store, loops over the features in
     *      the layer, and for each feature calls the user-defined
     *      filter function, if the return value of the filter function
     *      evaluates to true the feature is added to the store.
     */
    update: function() {
        this.featureStoreMediator.addFeatures(
            this.layer.features,
            {append: false, filter: this.filter});
    }
};
/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @requires widgets/data/FeatureStoreMediator.js
 * @requires core/Protocol/TriggerEventDecorator.js
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.data');

/**
 * Class: mapfish.widgets.data.SearchStoreMediator
 * This class is to be used when one wants to insert search results (features)
 * in a store; it works by listening to "crudfinished" and "clear" events 
 * triggered by a <mapfish.Protocol.TriggerEvent> protocol.
 *
 * Usage example:
 * (start code)
 * var protocol = new mapfish.Protocol.TriggerEventDecorator({
 *     protocol: new mapfish.Protocol.MapFish({
 *         url: "web_service_url"
 *     })
 * });
 * var store = new Ext.data.Store({
 *     reader: new mapfish.widgets.data.FeatureReader(
 *         {}, [{name: "name", type: "string"}]
 *     )
 * });
 * var mediator = new mapfish.widgets.data.SearchStoreMediator({
 *     store: store,
 *     protocol: protocol,
 *     filter: function(feature) {
 *         return feature.state != OpenLayers.State.UNKNOWN;
 *     },
 *     append: false // store is cleared before new features are added into it
 * });
 * (end)
 */

/**
 * Constructor: mapfish.widgets.data.SearchStoreMediator
 * Create an instance of mapfish.widgets.data.SearchStoreMediator.
 *
 * Parameters:
 * config - {Object} A config object used to set the search
 *     store mediator's properties (see below for the list
 *     of supported properties), and configure it with the
 *     Ext store; see the usage example above.
 *
 * Returns:
 * {<mapfish.widgets.data.SearchStoreMediator>}
 */
mapfish.widgets.data.SearchStoreMediator = function(config){
    var store = config.store;
    // no need to place the store in the instance
    delete config.store;
    Ext.apply(this, config);
    if (!this.protocol) {
        OpenLayers.Console.error(
            "config does not include a protocol property");
    }
    if (this.protocol.CLASS_NAME != "mapfish.Protocol.TriggerEventDecorator") {
        OpenLayers.Console.error(
            "the protocol config property does not reference a " +
            "TriggerEventDecorator protocol");
    }
    this.featureStoreMediator = new mapfish.widgets.data.FeatureStoreMediator({
        store: store
    });
    if (this.autoActivate) {
        this.activate();
    }
};

mapfish.widgets.data.SearchStoreMediator.prototype = {
    /**
     * APIProperty: protocol
     * {<mapfish.Protocol.TriggerEventDecorator>} The trigger event decorator
     * protocol.
     */
    protocol: null,

    /**
     * APIProperty: append
     * {Boolean} False if the store must be cleared before adding new
     * features into it, false otherwise; defaults to true.
     */
    append: true,

    /**
     * APIProperty: filter
     * {Function} a filter function called for each feature to be
     * inserted, the feature is passed as an argument to the function,
     * if it returns true the feature is inserted into the store,
     * otherwise the feature is not inserted.
     */
    filter: null,

    /**
     * APIProperty: autoActivate
     * {Boolean} True if the mediator must be activated as part of
     * its creation, false otherwise; if false then the mediator must
     * be explicitely activate using the activate method; defaults
     * to true.
     */
    autoActivate: true,

    /**
     * Property: active
     * {Boolean}
     */
    active: false,

    /**
     * Property: featureStoreMediator
     * {<mapfish.widgets.data.featureStoreMediator>} An internal
     * feature store mediator for manually adding features to the
     * Ext store.
     */
    featureStoreMediator: null,

    /**
     * APIMethod: activate
     * Activate the mediator.
     *
     * Returns:
     * {Boolean} - False if the mediator was already active, true
     * otherwise.
     */
    activate: function() {
        if (!this.active) {
            this.protocol.events.on({
                crudfinished: this.onSearchfinished,
                clear: this.onClear,
                scope: this
            });
            this.active = true;
            return true;
        }
        return false;
    },

    /**
     * APIMethod: deactivate
     * Deactivate the mediator.
     *
     * Returns:
     * {Boolean} - False if the mediator was already deactive, true
     * otherwise.
     */
    deactivate: function() {
        if (this.active) {
            this.protocol.events.un({
                crudfinished: this.onSearchfinished,
                clear: this.onClear,
                scope: this
            });
            this.active = false;
            return true;
        }
        return false;
    },

    /**
     * Method: onSearchfinished
     * Called when the {<mapfish.SearchMediator>} gets a search response.
     *
     * Parameters:
     * result - {OpenLayers.Protocol.Response} The protocol response.
     */
    onSearchfinished: function(response) {
        if (response.requestType == "read" && response.success()) {
            var features = response.features;
            if (features) {
                this.featureStoreMediator.addFeatures(features, {
                    append: this.append, filter: this.filter
                });
            }
        }
    },

    /**
     * Method: onClear
     *      Called by the {<mapfish.SearchMediator>} when the result should be
     *      cleared.
     */
    onClear: function() {
        this.featureStoreMediator.removeFeatures();
    }
};
/*
 * Copyright (C) 2009  Camptocamp
 *
 * This file is part of MapFish Client
 *
 * MapFish Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MapFish Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MapFish Client.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @requires OpenLayers/Control/SelectFeature.js
 */

Ext.namespace('mapfish.widgets', 'mapfish.widgets.data');

/**
 * Class: mapfish.widgets.data.GridRowFeatureMediator
 * A mediator for selecting feature on grid row selection and
 * vice-vera.
 *
 * Usage example:
 * (start code)
 * var mediator = new mapfish.widgets.data.GridRowFeatureMediator({
 *     grid: grid,
 *     selectControl: selectFeatureControl
 * });
 * (end)
 */

/**
 * Constructor: mapfish.widgets.data.GridRowFeatureMediator
 * Create an instance of mapfish.widgets.data.GridRowFeatureMediator.
 *
 * Parameters:
 * config - {Object}
 *
 * Returns:
 * {<mapfish.widgets.data.GridRowFeatureMediator>}
 */
mapfish.widgets.data.GridRowFeatureMediator = function(config) {
    Ext.apply(this, config);
    if (!this.grid) {
        OpenLayers.Console.error(
            "no Ext.grid.GridPanel provided");
        return;
    }
    if (!this.selectControl ||
        this.selectControl.CLASS_NAME != "OpenLayers.Control.SelectFeature") {
        OpenLayers.Console.error(
            "no OpenLayers.Control.SelectFeature provided");
        return;
    }
    this.selectModel = this.grid.getSelectionModel();
    if (this.autoActivate) {
        this.activate();
    }
};

mapfish.widgets.data.GridRowFeatureMediator.prototype = {
    /**
     * APIProperty: autoActivate
     * {Boolean} The instance is activated at creation time, defaults
     *     to true.
     */
    autoActivate: true,

    /**
     * APIProperty: selectControl
     * {<OpenLayers.Control.SelectFeature>} The select feature control.
     */
    selectControl: null,

    /**
     * APIProperty: grid
     * {Ext.grid.GridPanel} The grid panel.
     */
    grid: null,

    /**
     * Property: selectModel
     * {Ext.grid.RowSelectionModel} The row selection model attached to
     *     the grid panel.
     */
    selectModel: null,

    /**
     * Property: active
     * {Boolean}
     */
    active: false,

    /**
     * APIMethod: activate
     * Activate the mediator.
     *
     * Returns:
     * {Boolean} - False if the mediator was already active, true
     * otherwise.
     */
    activate: function() {
        if (!this.active) {
            this.featureEventsOn();
            this.rowEventsOn();
            this.active = true;
            return true;
        }
        return false;
    },

    /**
     * APIMethod: deactivate
     * Deactivate the mediator.
     *
     * Returns:
     * {Boolean} - False if the mediator was already deactive, true
     * otherwise.
     */
    deactivate: function() {
        if (this.active) {
            this.featureEventsOff();
            this.rowEventsOff();
            this.active = false;
            return true;
        }
        return false;
    },

    /**
     * Method: featureSelected
     *
     * Parameters:
     * o - {Object} An object with a feature property referencing
     *     the selected feature.
     */
    featureSelected: function(o) {
        var r = this.grid.store.getById(o.feature.id);
        if (r) {
            this.rowEventsOff();
            this.selectModel.selectRecords([r]);
            this.rowEventsOn();

            // focus the row in the grid to ensure the row is visible
            this.grid.getView().focusRow(this.grid.store.indexOf(r));
        }
    },

    /**
     * Method: featureUnselected
     *
     * Parameters:
     * o - {Object} An object with a feature property referencing
     *     the selected feature.
     */
    featureUnselected: function(o) {
        var r = this.grid.store.getById(o.feature.id);
        if (r) {
            this.rowEventsOff();
            this.selectModel.deselectRow(this.grid.store.indexOf(r));
            this.rowEventsOn();
        }
    },

    /**
     * Method: rowSelected
     *
     * Parameters:
     * s - {Ext.grid.RowSelectModel} The row select model.
     * i - {Number} The row index.
     * r - {Ext.data.Record} The record.
     */
    rowSelected: function(s, i, r) {
        var layers = this.selectControl.layers || [this.selectControl.layer], f;
        for (var i = 0, len = layers.length; i < len; i++) {
            f = layers[i].getFeatureById(r.id);
            if (f) {
                this.featureEventsOff();
                this.selectControl.select(f);
                this.featureEventsOn();
                break;
            }
        }
    },

    /**
     * Method: rowDeselected
     *
     * Parameters:
     * s - {Ext.grid.RowSelectModel} The row select model.
     * i - {Number} The row index.
     * r - {Ext.data.Record} The record.
     */
    rowDeselected: function(s, i, r) {
        var layers = this.selectControl.layers || [this.selectControl.layer], f;
        for (var i = 0, len = layers.length; i < len; i++) {
            f = layers[i].getFeatureById(r.id);
            if (f) {
                this.featureEventsOff();
                this.selectControl.unselect(f);
                this.featureEventsOn();
            }
        }
    },

    /**
     * Method: rowEventsOff
     * Turn off the row events.
     */
    rowEventsOff: function() {
        this.selectModel.un("rowselect", this.rowSelected, this);
        this.selectModel.un("rowdeselect", this.rowDeselected, this);
    },

    /**
     * Method: rowEventsOn
     * Turn on the row events.
     */
    rowEventsOn: function() {
        this.selectModel.on("rowselect", this.rowSelected, this);
        this.selectModel.on("rowdeselect", this.rowDeselected, this);
    },

    /**
     * Method: featureEventsOff
     * Turn off the feature events.
     */
    featureEventsOff: function() {
        var layers = this.selectControl.layers || [this.selectControl.layer];
        for (var i = 0, len = layers.length; i < len; i++) {
            layers[i].events.un({
                featureselected: this.featureSelected,
                featureunselected: this.featureUnselected,
                scope: this
            });
        }
    },

    /**
     * Method: featureEventsOn
     * Turn on the feature events.
     */
    featureEventsOn: function() {
        var layers = this.selectControl.layers || [this.selectControl.layer];
        for (var i = 0, len = layers.length; i < len; i++) {
            layers[i].events.on({
                featureselected: this.featureSelected,
                featureunselected: this.featureUnselected,
                scope: this
            });
        }
    }
};
