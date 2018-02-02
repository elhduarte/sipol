<?php
include('conexion.php');
function consulta_novedades($tipo_hecho,$fh_evento){

	
	#$tipo_hecho = $datos['tipo_hecho'];

/*
	$query ="
		select 
			ev.id_evento,
			ori.descripcion as comisaria,
			ev.fh_evento,
		  tp.descripcion as nombre_hecho,
			hd.descripcion as nombre_evento,
			ev.descripcion as relato, 	  
			ev.latitud, 
			ev.longitud, 
			ev.rpt_tipo_hecho_detalle, 
			 
			tp.id_tipo_hecho
			
		from 
			nov.evento ev
		LEFT JOIN 
			nov.origen ori ON ev.cod_origen = ori.id_origen
		LEFT JOIN 
			nov.tipo_hecho_detalle hd ON ev.rpt_tipo_hecho_detalle =  hd.id_tipo_hecho_detalle
		LEFT JOIN	
			nov.tipo_hecho tp ON hd.id_tipo_hecho = tp.id_tipo_hecho
		WHERE 
			EXTRACT(YEAR FROM ev.fh_evento) = '2017' limit 10";

	#print_r($query);
	$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

	$arr = pg_fetch_all($result);
	$arr = json_encode($arr);
	*/
return array('respuesta'=>$tipo_hecho);

}

function calculo_edad($datos) { 
    $edad_actual = date('Y') - $datos['ano_nac'];
    $msg = 'Hola, ' . $datos['nombre'] . '. Hemos procesado la siguiente informacion ' . $datos['email'] . ', telefono'. $datos['telefono'].' y su Edad actual es: ' . $edad_actual . '.'; 

    return array('mensaje' => $msg);
}


function trae_delitos_sexuales($datos) {

	
	$fecha_inicio = $datos['fecha_inicio'];
	$fecha_fin = $datos['fecha_fin'];
	$id_tipo_hecho = $datos['id_tipo_hecho'];  

	if (empty($fecha_inicio)|| empty($fecha_fin)) {
		$salida_fecha = 'fh_evento::date = now()::date';
		# code...
	}else{
		$salida_fecha = "ev.fh_evento::date BETWEEN '$fecha_inicio' and '$fecha_fin'";
	}
	if (empty($id_tipo_hecho)) {
		$salida_tipo_hecho = '';
	}else{
		$salida_tipo_hecho ='AND tp.id_tipo_hecho IN ('.$id_tipo_hecho.')';
	}



$query = 'SELECT 
			ev.id_evento,
			ori.descripcion as comisaria,
			ev.fh_evento::date,
		  tp.descripcion as nombre_hecho,
			hd.descripcion as nombre_evento,
			ev.descripcion as relato, 	  
			ev.latitud, 
			ev.longitud, 
			ev.rpt_tipo_hecho_detalle, 
			 
			tp.id_tipo_hecho
			
		FROM 
			nov.evento ev
		LEFT JOIN 
			nov.origen ori ON ev.cod_origen = ori.id_origen
		LEFT JOIN 
			nov.tipo_hecho_detalle hd ON ev.rpt_tipo_hecho_detalle =  hd.id_tipo_hecho_detalle
		LEFT JOIN	
			nov.tipo_hecho tp ON hd.id_tipo_hecho = tp.id_tipo_hecho
		WHERE			
			hd.id_tipo_hecho_detalle in (283, 74, 130, 86)
		AND 
			'.$salida_fecha.'
			'.$salida_tipo_hecho.'
		
		order by 1 asc';


$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

$rows = pg_num_rows($result);

	if ($rows == 0) 
	{
		$arr = array('Sin Registros' =>'0');
		# code...
	}else{
		$arr = pg_fetch_all($result);
		
	}
	

	$arr = json_encode($arr);
	
	
    return array('respuesta' => $arr);
}


?>