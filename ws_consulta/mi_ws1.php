<?php
 // incluimos la libreria ó toolkit nusoap que descargamos previamente
require_once('lib/nusoap.php');
include('funciones.php');

// Vamos a crear la instancia del servidor.
$server = new nusoap_server();	

$server->configureWSDL('ConsultasPnc', 'urn:ConsultasPnc');


// Parametros de entrada
$server->wsdl->addComplexType(  'datos_persona_entrada', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('nombre'   => array('name' => 'nombre','type' => 'xsd:string'),
                                      'email'    => array('name' => 'email','type' => 'xsd:string'),
                                      'telefono' => array('name' => 'telefono','type' => 'xsd:string'),
                                      'ano_nac'  => array('name' => 'ano_nac','type' => 'xsd:int'))
);

// Parametros de Salida
$server->wsdl->addComplexType(  'datos_persona_salidad', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('mensaje'   => array('name' => 'mensaje','type' => 'xsd:string'))
);

#Funcion de Ejemplo
$server->register(  'calculo_edad', // nombre del metodo o funcion
                    array('datos_persona_entrada' => 'tns:datos_persona_entrada'), // parametros de entrada
                    array('return' => 'tns:datos_persona_salidad'), // parametros de salida
                    'urn:mi_ws1', // namespace
                    'urn:hellowsdl2#calculo_edad', // soapaction debe ir asociado al nombre del metodo
                    'rpc', // style
                    'encoded', // use
                    'La siguiente funcion recibe los parametros de la persona y calcula la Edad' // documentation
);


/********************************/

// Parametros de entrada Delitos Sexuales
$server->wsdl->addComplexType(  'filtros_delitos_sexuales', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('fecha_inicio'   => array('name' => 'fecha_inicio','type' => 'xsd:string'),
                                      'fecha_fin'    => array('name' => 'fecha_fin','type' => 'xsd:string'),
                                      'id_tipo_hecho' => array('name' => 'id_tipo_hecho','type' => 'xsd:int'))
);




// Parametros de Salida de Delitos Sexuales
$server->wsdl->addComplexType(  'delitos_sexuales_salida', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('respuesta'   => array('name' => 'respuesta','type' => 'xsd:string'))
);






#Funcion para Obtener Delitos Sexuales
$server->register('trae_delitos_sexuales',
                  array('filtros_delitos_sexuales' =>'tns:filtros_delitos_sexuales'),
                  array('return' =>'tns:delitos_sexuales_salida'),
                  'urn:mi_ws1', // namespace
                'urn:hellowsdl2#trae_delitos_sexuales', // soapaction debe ir asociado al nombre del metodo
                'rpc', // style
                'encoded', // use
                'La siguiente funcion recibe los parametros de fechas para poder filtrar delitos sexuales de DB Novedades' // documentation

);




/*************************************************************************/


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>