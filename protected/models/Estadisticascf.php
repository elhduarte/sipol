<?php
class Estadisticas
{

public function obtenerConsultasPorEvento($fechaIniGral4, $fechaFinGral4, $tipo_evento, $estado)
		{
			//armo las condiciones
			$retorno = array();
			$condiciones = array();
			$condicion = '';
				if (empty($fechaIniGral4) || empty($fechaFinGral4)) {
				echo"<br>";
			                        echo"<div class=\"alert alert-error\">
			                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			                        <h4>Advertencia!</h4>El rango de fechas proporcinado esta vacio, debe de ingresar fechas...
			                        </div>";
			                      // $condicion5='';
			                       
			} else
			{


				if (empty($tipo_evento)) 
				{
					$condicion .= ' ';
				}
				elseif ($tipo_evento =='t')
				{
					$condicion .="";
				}
				else 
				{
						$condicion .= " and e.id_tipo_evento = '".$tipo_evento."'";
				}

			
			if (empty($estado)) 
				{
					$condicion .= ' ';
				}

				if ($estado=='f')
				{
					$condicion .=" AND e.estado='".$estado."'";
				}

				elseif ($estado ==2)
				{
					$condicion .="";
				}elseif ($estado ==0) {
					$condicion .=" AND e.estado='f'";
					# code...
				}
				else 
				{
							$condicion .=" AND e.estado='".$estado."'";
				}
			
			$fechaIniGral4 = "'". $fechaIniGral4 . "'";
			$fechaFinGral4 = "'". $fechaFinGral4 . "'";
			$condicion.=' and e.fecha_ingreso  BETWEEN '.$fechaIniGral4.' and '.$fechaFinGral4;
				$SQL="SELECT en.id_cat_entidad, en.nombre_entidad entidad, count(e.*) FROM
					sipol.tbl_evento e, catalogos_publicos.tbl_sede s, catalogos_publicos.cat_entidad en, catalogos_publicos.cat_tipo_sede ts
					where en.id_cat_entidad = s.id_cat_entidad
					and ts.id_tipo_sede = s.id_tipo_sede
					and e.id_sede = s.id_sede".$condicion."
					group by en.id_cat_entidad, en.nombre_entidad order by en.id_cat_entidad";


			  //echo $SQL;
			  Yii::log('', CLogger::LEVEL_ERROR, $SQL);

			  $Response = Yii::app()->db->createCommand($SQL)->queryAll();
				

			$retorno = array();
		
			//ahora recorro los registros y genero la respuesta

					foreach ($Response as $registro) 
					{
						$retorno [] = array(
							'id'=>$registro['id_cat_entidad'],
							'name'=>$registro['entidad'],
							'data'=>$registro['count']
						);

					}

					
					//Yii::log('', CLogger::LEVEL_ERROR, CVarDumper::dumpAsString($retorno));
			}// FIN ELSE
			return json_encode($retorno);
			
		} // fin funcion public obtener  consultas por evento


public function obtenerConsultasPorEvento2($fechaIniGral4, $fechaFinGral4, $tipo_evento, $estado,$id_cat_entidad)
		{
			//armo las condiciones
			
			$condiciones = array();
			$condicion = '';
				if (empty($fechaIniGral4) || empty($fechaFinGral4)) {
				echo"<br>";
			                        echo"<div class=\"alert alert-error\">
			                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			                        <h4>Advertencia!</h4>El rango de fechas proporcinado esta vacio, debe de ingresar fechas...
			                        </div>";
			                      // $condicion5='';
			                       
			} else
			{


				if (empty($tipo_evento)) 
				{
					$condicion .= ' ';
				}
				else if ($tipo_evento =='t')
				{
					$condicion .="";
				}
				else 
				{
						$condicion .= " and e.id_tipo_evento = '".$tipo_evento."'";
				}

			
			if (empty($estado)) 
				{
					$condicion .= ' ';
				}
					if ($estado=='f')
				{
					$condicion .=" AND e.estado='".$estado."'";
				}
				
				else if ($estado ==2)
				{
					$condicion .="";
				} elseif ($estado==0) {
					# code...
					$condicion .=" AND e.estado='f'";
				}
				else 
				{
							$condicion .=" AND e.estado='".$estado."'";
				}
			
			$fechaIniGral4 = "'". $fechaIniGral4 . "'";
			$fechaFinGral4 = "'". $fechaFinGral4 . "'";
			$condicion.=' and e.fecha_ingreso  BETWEEN '.$fechaIniGral4.' and '.$fechaFinGral4;
				
			  	$SQL1="SELECT en.id_cat_entidad, count(en.*), en.nombre_entidad entidad, s.nombre sede FROM
						sipol.tbl_evento e, catalogos_publicos.tbl_sede s, catalogos_publicos.cat_entidad en, catalogos_publicos.cat_tipo_sede ts
						where en.id_cat_entidad = s.id_cat_entidad
						and ts.id_tipo_sede = s.id_tipo_sede
						and e.id_sede = s.id_sede ".$condicion."
						and en.id_cat_entidad= ".$id_cat_entidad."
						group by en.nombre_entidad, ts.descripcion, s.nombre,en.id_cat_entidad
						order by en.id_cat_entidad";


			  //echo $SQL1;
			  //Yii::log('', CLogger::LEVEL_ERROR, $SQL);

			    $Response1 = Yii::app()->db->createCommand($SQL1)->queryAll();	

		
			
			//ahora recorro los registros y genero la respuesta
				$data= "";
				$nombre_s= "";
				$cantidad= "";
				
					foreach ($Response1 as $registro) 
					{	
						$entidad= $registro['entidad'];
						$nombre_s.="'". $registro['sede']."',";	
						$cantidad.= $registro['count'].",";	
								
					}
					$nombre_s=substr($nombre_s, 0, -1);
					$cantidad=substr($cantidad, 0, -1);
						$data.=" 
						name: '".$entidad."',
                        categories: [".$nombre_s."],
                        data: [".$cantidad."],";
							
					//Yii::log('', CLogger::LEVEL_ERROR, CVarDumper::dumpAsString($retorno));
			}// FIN ELSE
			return $data;
			
		} // fin funcion public obtener  consultas por evento






	public function EventoComisaria()
	{

$query ="
select * from crosstab(
  'SELECT ce.nombre_entidad::text, e.id_tipo_evento, count(*)::integer as conteo  FROM sipol.tbl_evento e, catalogos_publicos.tbl_sede ts, catalogos_publicos.cat_entidad ce
where ts.id_sede = e.id_sede
and ce.id_cat_entidad = ts.id_cat_entidad
and estado = ''t''
and e.fecha_ingreso between (now())::date-90 and now()
group by ce.nombre_entidad, e.id_tipo_evento 
order by 1',
  'select id_tipo_evento from sipol_catalogos.cat_tipo_evento where id_tipo_evento in(1,2,3)'
) as (
  entidad text,
  ". "\"Denuncia\"" . "integer,
  ". "\"Incidencia\"" . "integer,
  ". "\"Extravio\"" . "integer
);

";

$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;

	}




	public function TablaDenunciasActivas($id_evento, $tiempo)
	{


$query ="
select ReporteDash.* from crosstab(
'select (cat.nombre_entidad || '' - '' ||s.nombre) as sede,to_char(ev.fecha_ingreso,''mon'')::text as fecha, count(ev.id_sede)::integer As contador
from catalogos_publicos.tbl_sede as s
LEFT OUTER JOIN sipol.tbl_evento ev
ON ev.id_sede = s.id_sede
AND ev.estado = true
AND ev.id_tipo_evento = ".$id_evento."
AND ev.fecha_ingreso BETWEEN date ''".$tiempo."-01-01'' and date ''".$tiempo."-12-31''
INNER JOIN catalogos_publicos.cat_entidad  as cat 
ON S.id_cat_entidad = cat.id_cat_entidad
GROUP BY sede, fecha , ev.id_sede
ORDER BY  sede
','SELECT to_char(date ''2007-01-01'' + (n || '' month'')::interval, ''mon'') As meses_nombres 
    FROM generate_series(0,11) n') as  ReporteDash(nombre_hecho text, jan integer, feb integer, mar integer, 
      apr integer, may integer, jun integer, jul integer, 
      aug integer, sep integer, oct integer, nov integer, 
      dec integer)

";

$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;

	}

	public function TablaDenunciasInactivas($id_evento, $tiempo)
	{

$query ="
select ReporteDash.* from crosstab(
'select (cat.nombre_entidad || '' - '' ||s.nombre) as sede,to_char(ev.fecha_ingreso,''mon'')::text as fecha, count(ev.id_sede)::integer As contador
from catalogos_publicos.tbl_sede as s
LEFT OUTER JOIN sipol.tbl_evento ev
ON ev.id_sede = s.id_sede
AND ev.estado = false
AND ev.id_tipo_evento = ".$id_evento."
AND ev.fecha_ingreso BETWEEN date ''".$tiempo."-01-01'' and date ''".$tiempo."-12-31''
INNER JOIN catalogos_publicos.cat_entidad  as cat 
ON S.id_cat_entidad = cat.id_cat_entidad
GROUP BY sede, fecha , ev.id_sede
ORDER BY  sede
','SELECT to_char(date ''2007-01-01'' + (n || '' month'')::interval, ''mon'') As meses_nombres 
    FROM generate_series(0,11) n') as  ReporteDash(nombre_hecho text, jan integer, feb integer, mar integer, 
      apr integer, may integer, jun integer, jul integer, 
      aug integer, sep integer, oct integer, nov integer, 
      dec integer)

";

$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;

	}

	public function TablaIngresosSistema($tiempo)
	{

$query=" SELECT ReporteDash.* from crosstab('select (cat.nombre_entidad || '' - '' || a.nombre) as sede , to_char(us.fecha_ingreso,''mon'')::text as fecha, count(us.id_sede) ::integer As contador
 from 
 catalogos_publicos.tbl_sede as a
LEFT OUTER JOIN sipol_usuario.tbl_session_usuario as us
ON us.id_sede = a.id_sede
AND us.fecha_ingreso BETWEEN date ''".$tiempo."-01-01'' and date ''".$tiempo."-12-31''
INNER JOIN catalogos_publicos.cat_entidad  as cat 
ON a.id_cat_entidad = cat.id_cat_entidad
group by sede,fecha
ORDER BY sede asc
','SELECT to_char(date ''2007-01-01'' + (n || '' month'')::interval, ''mon'') As meses_nombres 
    FROM generate_series(0,11) n') as  ReporteDash(nombre_hecho text, jan integer, feb integer, mar integer, 
      apr integer, may integer, jun integer, jul integer, 
      aug integer, sep integer, oct integer, nov integer, 
      dec integer)

";
$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;

	}



		public function TablaGraficauno($tiempo)
	{

	
$query = "select ReporteDash.* from crosstab(
'select i.nombre_denuncia::text as nombre_hecho ,to_char(if.fecha_evento,''mon'')::text as fecha, count(if.id_evento_detalle)::integer As contador
FROM sipol_catalogos.cat_denuncia As i 
INNER JOIN sipol.tbl_evento_detalle As if 
		ON i.id_cat_denuncia = if.id_hecho_denuncia
		And i.tipo_hecho = 1
		inner join sipol.tbl_evento as tbleve on tbleve.id_evento = if.id_evento
		and tbleve.id_tipo_evento = 1
		and tbleve.estado=''t''
		AND fecha_evento BETWEEN date ''".$tiempo."-01-01'' and date ''".$tiempo."-12-31''
	GROUP BY i.nombre_denuncia, to_char(if.fecha_evento, ''mon''), date_part(''month'', if.fecha_evento)
order by i.nombre_denuncia
','SELECT to_char(date ''2007-01-01'' + (n || '' month'')::interval, ''mon'') As meses_nombres 
		FROM generate_series(0,11) n') as  ReporteDash(nombre_hecho text, jan integer, feb integer, mar integer, 
			apr integer, may integer, jun integer, jul integer, 
			aug integer, sep integer, oct integer, nov integer, 
			dec integer)";

$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;


	}


		public function TablaGraficaDos($tiempo)
	{

	
$query = "select ReporteDash.* from crosstab(
'select i.nombre_denuncia::text as nombre_hecho ,to_char(if.fecha_evento,''mon'')::text as fecha, count(if.id_evento_detalle)::integer As contador
FROM sipol_catalogos.cat_denuncia As i 
INNER JOIN sipol.tbl_evento_detalle As if 
		ON i.id_cat_denuncia = if.id_hecho_denuncia
		And i.tipo_hecho = 2
		inner join sipol.tbl_evento as tbleve on tbleve.id_evento = if.id_evento
and tbleve.id_tipo_evento = 1
and tbleve.estado=''t''
		AND fecha_evento BETWEEN date ''".$tiempo."-01-01'' and date ''".$tiempo."-12-31''
	GROUP BY i.nombre_denuncia, to_char(if.fecha_evento, ''mon''), date_part(''month'', if.fecha_evento)
order by i.nombre_denuncia
','SELECT to_char(date ''2007-01-01'' + (n || '' month'')::interval, ''mon'') As meses_nombres 
		FROM generate_series(0,11) n') as  ReporteDash(nombre_hecho text, jan integer, feb integer, mar integer, 
			apr integer, may integer, jun integer, jul integer, 
			aug integer, sep integer, oct integer, nov integer, 
			dec integer)";

$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;

	}

		public function getEntidad($id_entidad)
	{

	
$query = "SELECT nombre_entidad FROM catalogos_publicos.cat_entidad
where id_cat_entidad =".$id_entidad;

$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;

	}


		public function getNombreCatDenuncia($id_cat_denuncia)
	{
	
$query = "SELECT nombre_denuncia FROM sipol_catalogos.cat_denuncia 
where id_cat_denuncia = ".$id_cat_denuncia;

$resultado = yii::app()->db->createCommand($query)->queryAll();
return $resultado;

	}


		public function getConteoSede($id_cat_entidad,$id_hecho_denuncia)
	{
	
$query = "SELECT ts.id_sede,ts.nombre,count(*) FROM sipol.tbl_evento e, sipol.tbl_evento_detalle ed, catalogos_publicos.tbl_sede ts, catalogos_publicos.cat_entidad ce
 where ed.fecha_evento  BETWEEN 'now'::text::date -30 AND 'now'::text::date
and e.estado = 't' 
and ed.id_evento = e.id_evento
and ce.id_cat_entidad = ts.id_cat_entidad
and ts.id_sede = e.id_sede
and e.id_tipo_evento = 1
and ts.id_cat_entidad = ".$id_cat_entidad."
and ed.atributos is not null
and id_hecho_denuncia = ".$id_hecho_denuncia."
GROUP BY ts.nombre, ts.id_sede
 ";

$resultado = yii::app()->db->createCommand($query)->queryAll();


return $resultado;

	}	

		public function getSumaSede($id_cat_entidad,$id_hecho_denuncia)
	{
	
$query = "SELECT SUM(count) FROM
(
SELECT ts.nombre,count(*) FROM sipol.tbl_evento e, sipol.tbl_evento_detalle ed, catalogos_publicos.tbl_sede ts, catalogos_publicos.cat_entidad ce
 where ed.fecha_evento  BETWEEN 'now'::text::date -30 AND 'now'::text::date
and e.estado = 't' 
and ed.id_evento = e.id_evento
and ce.id_cat_entidad = ts.id_cat_entidad
and ts.id_sede = e.id_sede
and e.id_tipo_evento = 1
and ts.id_cat_entidad = ".$id_cat_entidad."
and ed.atributos is not null
and id_hecho_denuncia = ".$id_hecho_denuncia."
GROUP BY ts.nombre
) AS TABLA
 ";

$resultado = yii::app()->db->createCommand($query)->queryAll();


return $resultado;

	}	



	public function getGrid($idsede,$idhecho)
	{
	
$sql = "SELECT e.id_evento, e.evento_num, e.fecha_ingreso, e.hora_ingreso, us.usuario, mu.departamento, mu.municipio
 FROM sipol.tbl_evento e, sipol.tbl_evento_detalle ed, catalogos_publicos.tbl_sede ts, catalogos_publicos.cat_entidad ce, sipol_usuario.tbl_usuario us, catalogos_publicos.cat_municipios mu
where ed.fecha_evento between (now())::date-30 and now()
and e.estado = 't' 
and ed.id_evento = e.id_evento
and mu.cod_mupio = e.id_mupio
and us.id_usuario = e.id_usuario
and ce.id_cat_entidad = ts.id_cat_entidad
and ts.id_sede = e.id_sede
and e.id_tipo_evento = 1
and ed.atributos is not null
and ed.id_hecho_denuncia = ".$idhecho."
and ts.id_sede = ".$idsede."
 ";
	$connection=Yii::app()->db;
		

		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$a=array();
		$num = "1";

			foreach($dataReader as $row)
		{
			$id_evento = $row['id_evento'];
			$evento_num = $row['evento_num'];
			$fecha_ingreso  = $row['fecha_ingreso'];
			$hora_ingreso = $row['hora_ingreso'];
			$departamento = $row['departamento'];
			$municipio= $row['municipio'];
			$usuario = $row['usuario'];
			
			$encrip = new Encrypter;
		$id_evento1 = $encrip->compilarget("'".$id_evento."'");
		$a[]=array(
			"num"=>$num++, 
			"id_evento"=>$id_evento1,
			"evento_num"=>$evento_num,
			"usuario"=>$usuario,
			"departamento"=>$departamento,
			"municipio"=>$municipio,
			"fecha_ingreso"=>$fecha_ingreso, 
			"hora_ingreso"=>$hora_ingreso,
		
			);		

		}


	return new CArrayDataProvider($a, array(
		'id'=>'grid_snivel',
		'keyField' => 'id_evento',
		'pagination'=>array(
			'pageSize'=>10,
			//'route'=>'CTblEvento/grilla_incidencia&ajax=grid_tedst'

			),
		));

	}	
	


}