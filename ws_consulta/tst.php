<?php
include('conexion.php');
$salida_fecha = 'fh_evento::date = now()::date';

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
			AND tp.id_tipo_hecho IN (1)
		
		AND 
			'.$salida_fecha.'
			
		
		order by 1 asc';
#echo $query;

$result = pg_query($dbconn,$query) or die('La consulta fallo: ' . pg_last_error());

$rows = pg_num_rows($result);

#echo $rows;

	if ($rows == 0) 
	{
		$arr = array('Sin Registros' =>'0');
		# code...
	}else{
		$arr = pg_fetch_all($result);
		
	}

	$arr = json_encode($arr);
	
	echo '<pre>'.$arr.'</pre>';	

?>