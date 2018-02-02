<pre>
<?php
 
    require_once('lib/nusoap.php');
     
    $cliente = new nusoap_client('http://localhost/ws_consulta/mi_ws1.php');
    //print_r($cliente);
     
    $tipo_hecho =1;
    $fh_evento = 'a';
 
   $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                    'nombre'    => "Mauricio A.",
                                                                    'email'     => "ealpizar@ticosoftweb.com",
                                                                    'telefono'  => "8700-5455",
                                                                    'ano_nac'   => 1980)
                                                                    );
 

    $resultado = $cliente->call('calculo_edad',$datos_persona_entrada);


      $filtros_delitos_sexuales = array( "filtros_delitos_sexuales" => array(    
                                                                    'fecha_inicio'    =>'2017-04-01',
                                                                    'fecha_fin'     => "2017-05-01",
                                                                    'id_tipo_hecho'   => '')
                                                                    );
 

    $resultadodl = $cliente->call('trae_delitos_sexuales',$filtros_delitos_sexuales);




     
    print_r($resultadodl);
     
?>
</pre>