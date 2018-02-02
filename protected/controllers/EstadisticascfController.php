<?php
class estadisticascfController  extends Controller
{

public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
			public function accessRules()
			{
			 return array(
				 array('allow', // allow all users to perform 'index' and 'view' actions
				 'actions'=>array('dibujagraficatipoevento','Graficatipoevento','Graficatipoevento2','snivel','pnivel','IndexRender','procesatimeline','AltoMando','EventoComisaria','mostrarexcelfiltros','noticias','mostrarexcel','correoenviotablaglobal','cuadroglobal','correoenviotabla','tabaldashoboarsede','mapacomisaria','nuevodashboard','comisariafiltros','comisariafiltrosweb','sedes','EnvioDashboard','ResumenHechosListado','ResumenDenuncia','HechoSeleccionado','GraficaTiempoDenuncias','select','indexsipol','graficassipol','mapassipol','graficasmapassipol','ErrorSipol','indexnovedades','graficasnovedades','mapasnovedades','graficasmapasnovedades','ErrorNovedades','MapaGeneral'),
				 'users'=>array('root', 'developer','supervisor_comisaria','supervisor_general'),
				 ),
				 array('allow', // allow authenticated user to perform 'create' and 'update' actions
				 'actions'=>array('index','graficasdenuncias','Dashboard','AltoMando'),
				 'users'=>array('@'),
				 ),
				
				 array('deny', // deny all users
				 'users'=>array('*'),
				 ),
			 );
}

public function actionProcesaTimeLine()
{
	$codigo=json_encode($_POST['codigo']);

	$this->renderPartial('procesatimeline',array('codigo'=>$codigo));


}

public function actionGraficatipoevento()
{
	$fechaIniGral4= $_POST['fechaIniGral4'];
	$fechaFinGral4 = $_POST['fechaFinGral4'];
	$tipo_evento = $_POST['tipo_evento'];
	$estado = $_POST['estado'];
	$this->renderPartial('dibujagraficatipoevento');

}
public function actionGraficatipoevento2()
{
	$fechaIniGral4= $_POST['fechaIniGral4'];
	$fechaFinGral4 = $_POST['fechaFinGral4'];
	$tipo_evento = $_POST['tipo_evento'];
	$estado = $_POST['estado'];
	$this->renderPartial('dibujagraficatipoevento');

}


public function actionMostrarexcel()
{
	$this->render('mostrarexcel');

}
public function actionAltoMando()
{
	$this->render('altomando');

}
public function actionIndexRender()
{
	$this->renderPartial('index_render');

}
public function actionMostrarexcelfiltros()
{
	$this->render('mostrarexcelfiltros');

}

public function actionEventoComisaria()
{
	$this->render('evento-comisaria');

}



public function actionNoticias()
{
	$this->render('noticias');

}



public function actionCorreoenviotablaglobal()
{
	$tipoevento = $_POST['tipoevento'];
	$comisaria = $_POST['comisaria'];
	$correoentrante = $_POST['correo'];

function llamarhoy($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
	and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarayer($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -1 AND 'now'::text::date -1
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarunasemana($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -7 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy
function llamardossemana($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -14 AND 'now'::text::date -7
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy
function llamarunmes($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -30 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy


function llamarmesanterior($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -61 AND 'now'::text::date -30
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
	
}//fin del proceso mes anterior

function procesafila($nombrehecho,$id_hecho,$comisaria,$contador)
{
	$hoy = llamarhoy($id_hecho,$comisaria);
	$ayer = llamarayer($id_hecho,$comisaria);
	$unasaemana = llamarunasemana($id_hecho,$comisaria);
	$dossemanas = llamardossemana($id_hecho,$comisaria);
	$unmes = llamarunmes($id_hecho,$comisaria);
	$mesanterior = llamarmesanterior($id_hecho,$comisaria);
	//echo $nombrehecho."-".$hoy."-".$ayer."-".$unasaemana."-".$unmes;
	//echo "<br>";
$restaanailizhoy = 0;
	$testorestahoy='';

	if($hoy > $ayer)
	{
		$restaanailizhoy = $hoy - $ayer;
		$testorestahoy = '<span class="badge badge-important">'.$restaanailizhoy.'</span>';
	}else if($hoy<$ayer)
	{
		$restaanailizhoy = $ayer - $hoy;
		$testorestahoy = '<span class="badge badge-success">'.$restaanailizhoy.'</span>';
	}else{
		$testorestahoy = '<span class="badge badge-warning">'.$restaanailizhoy.'</span>';
	}


	$restaanaillizsemana = 0;
	$restadossemanas="";
if($unasaemana > $dossemanas)
	{
		$restaanaillizsemana = $unasaemana - $dossemanas;
		$restadossemanas = '<span class="badge badge-important">'.$restaanaillizsemana.'</span>';
	}else if($unasaemana<$dossemanas)
	{
		$restaanaillizsemana = $dossemanas - $unasaemana;
		$restadossemanas = '<span class="badge badge-success">'.$restaanaillizsemana.'</span>';
	}else{
		$restadossemanas = '<span class="badge badge-warning">'.$restaanaillizsemana.'</span>';
	}


		$restaanalizames = 0;
	$restadosmeses="";
if( $unmes > $mesanterior)
	{
		$restaanalizames = $unmes - $mesanterior; 
		$restadosmeses = '<span class="badge badge-important">'.$restaanalizames.'</span>';
	}else if($unmes < $mesanterior )
	{
		$restaanalizames = $mesanterior - $unmes;
		$restadosmeses = '<span class="badge badge-success">'.$restaanalizames.'</span>';
	}else{
		$restadosmeses = '<span class="badge badge-warning">'.$restaanalizames.'</span>';
	}
	$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);


	$salidatexto ="  <tr>
      <td>".$nombrehecho."</td>
       <td>".$variable_datos_usuario[0]->nombre_entidad."</td>
      <td><center>".$ayer."</center></td>
      <td><center>".$hoy."</center></td>
      <td><center>".$testorestahoy."</center></td>
      <td><center>".$unasaemana."</center></td>
      <td><center>".$dossemanas."</center></td>
      <td><center>".$restadossemanas."</center></td>
      <td><center>".$mesanterior."</center></td>
      <td><center>".$unmes."</center></td>
    </tr>";

    return $salidatexto;
}//fin del proceso de fila

$tabla = '<table border="1">
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Comisaria</th>
       <th><center>Ayer</center></th>
       <th><center>Hoy</center></th>
        <th></th>
       <th><center>Semana Anterior</center></th>
        <th><center>Semana Actual</center></th>
       <th></th>
        <th><center>Mes Anterior</center></th>
       <th><center>Mes Actual</center></th>
      
    </tr>
  </thead>
  <tbody>';
       $query = "SELECT id_cat_denuncia, nombre_denuncia  FROM sipol_catalogos.cat_denuncia order by nombre_denuncia";
$resultado = Yii::app()->db->createCommand($query)->queryAll();
$contador = 0;
foreach ($resultado as $key => $value) {
	$tabla .= procesafila($value['nombre_denuncia'],$value['id_cat_denuncia'],$comisaria,$contador);
	$contador = $contador +1;
}
 $tabla .='</tbody></table>';
//echo $tabla;

$correo = new EnvioCorreo;
$envio = $correo->tablaestadistica($correoentrante,$tabla);

echo '<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4>Información!</h4>
  Enviado con exito al correo '.$correoentrante.'
</div>';
}


public function actionCorreoenviotabla()
{
	$tipoevento = $_POST['tipoevento'];
	$tiposede = $_POST['tiposede'];
	$sedes = $_POST['sedes'];
	$correoentrante = $_POST['correo'];
	$comisaria = $_POST['comisaria'];
	$condicion= "";


	if(empty($tiposede) || $tiposede =="00"){
		$condicion.= "";
		}else
	{
		$condicion.= " and ts.id_tipo_sede = ".$tiposede;
		//echo $condicion;
	}
	if($sedes==" " || $sedes =="00" || empty($sedes)){
		$condicion.= "";
	} else
	{			
		$condicion.= " and ts.id_sede = ".$sedes;
	
	}
	
function llamarhoy($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
	and ts.id_cat_entidad = ".$comisaria." "
	.$condicion."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}


		Yii::log('', CLogger::LEVEL_ERROR, $querydos);
}//fin del proceso de hoy

function llamarayer($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -1 AND 'now'::text::date -1
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
    .$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarunasemana($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -7 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
	.$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamardossemana($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -14 AND 'now'::text::date -7
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
	.$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarunmes($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -30 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
	.$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarmesanterior($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -61 AND 'now'::text::date -30
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." ".$condicion."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
	
}//fin del proceso mes anterior

function procesafila($nombrehecho,$id_hecho,$tiposede,$sedes,$comisaria,$contador,$condicion)
{
	$hoy = llamarhoy($id_hecho,$condicion,$comisaria);
	$ayer = llamarayer($id_hecho,$condicion,$comisaria);
	$unasaemana = llamarunasemana($id_hecho,$condicion,$comisaria);
	$dossemanas = llamardossemana($id_hecho,$condicion,$comisaria);
	$unmes = llamarunmes($id_hecho,$condicion,$comisaria);
	$mesanterior = llamarmesanterior($id_hecho,$condicion,$comisaria);


$restaanailizhoy = 0;
	$testorestahoy='';

	if($hoy > $ayer)
	{
		$restaanailizhoy = $hoy - $ayer;
		$testorestahoy = '<span class="badge badge-important">'.$restaanailizhoy.'</span>';
	}else if($hoy<$ayer)
	{
		$restaanailizhoy = $ayer - $hoy;
		$testorestahoy = '<span class="badge badge-success">'.$restaanailizhoy.'</span>';
	}else{
		$testorestahoy = '<span class="badge badge-warning">'.$restaanailizhoy.'</span>';
	}


	$restaanaillizsemana = 0;
	$restadossemanas="";
if($unasaemana > $dossemanas)
	{
		$restaanaillizsemana = $unasaemana - $dossemanas;
		$restadossemanas = '<span class="badge badge-important">'.$restaanaillizsemana.'</span>';
	}else if($unasaemana<$dossemanas)
	{
		$restaanaillizsemana = $dossemanas - $unasaemana;
		$restadossemanas = '<span class="badge badge-success">'.$restaanaillizsemana.'</span>';
	}else{
		$restadossemanas = '<span class="badge badge-warning">'.$restaanaillizsemana.'</span>';
	}

	$restaanalizames = 0;
	$restadosmeses="";
if( $unmes > $mesanterior)
	{
		$restaanalizames = $unmes - $mesanterior; 
		$restadosmeses = '<span class="badge badge-important">'.$restaanalizames.'</span>';
	}else if($unmes < $mesanterior )
	{
		$restaanalizames = $mesanterior - $unmes;
		$restadosmeses = '<span class="badge badge-success">'.$restaanalizames.'</span>';
	}else{
		$restadosmeses = '<span class="badge badge-warning">'.$restaanalizames.'</span>';
	}


	$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
	$comisaria=$variable_datos_usuario[0]->nombre_entidad;
	$estadistica = new Estadisticas;
	if(isset($_SESSION['ID_ENTIDAD_E']))
		{
			$id_cat_entidad = $_SESSION['ID_ENTIDAD_E'];
			$nombre = $estadistica->getEntidad($id_cat_entidad);
			$comisaria = $nombre[0]['nombre_entidad'];
		}

	$salidatexto ="  <tr>
      <td >".$nombrehecho."</td>
       <td>".$comisaria."</td>
       <td><center>".$ayer."</center></td>
      <td><center>".$hoy."</center></td>
      <td><center>".$testorestahoy."</center></td>
      <td><center>".$unasaemana."</center></td>
      <td><center>".$dossemanas."</center></td>
      <td><center>".$restadossemanas."</center></td>
      <td><center>".$mesanterior."</center></td>
      <td><center>".$unmes."</center></td>
      <td><center>".$restadosmeses."</center></td>
    </tr>";

    return $salidatexto;
}//fin del proceso de fila

 
$tabla = '<table border="1">
  <thead>
    <tr>
  	  <th>Hecho</th>
      <th>Comisaria</th>
       <th><center>Ayer</center></th>
       <th><center>Hoy</center></th>
        <th></th>
       <th><center>Semana Anterior</center></th>
        <th><center>Semana Actual</center></th>
       <th></th>
        <th><center>Mes Anterior</center></th>
       <th><center>Mes Actual</center></th>
    </tr>
  </thead>
  <tbody>';
       $query = "SELECT id_cat_denuncia, nombre_denuncia  FROM sipol_catalogos.cat_denuncia order by nombre_denuncia";
$resultado = Yii::app()->db->createCommand($query)->queryAll();
$contador = 0;
foreach ($resultado as $key => $value) {
	$tabla .= procesafila($value['nombre_denuncia'],$value['id_cat_denuncia'],$tiposede,$sedes,$comisaria,$contador,$condicion);
	$contador = $contador +1;
}
 $tabla .='</tbody></table>';
//echo $tabla;

$correo = new EnvioCorreo;
$envio = $correo->tablaestadistica($correoentrante,$tabla);

echo '<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4>Información!</h4>
  Enviado con exito al correo '.$correoentrante.'
</div>';
}

public function actionSedes()
{

	$this->render('sedes');
}

public function actionTabaldashoboarsede()
{
	$tipoevento = $_POST['tipoevento'];
	$tiposede = $_POST['tiposede'];
	$sedes = $_POST['sedes'];
	$comisaria = $_POST['comisaria'];
	$condicion= "";


	if(empty($tiposede) || $tiposede =="00"){
		$condicion.= "";
		}else
	{
		$condicion.= " and ts.id_tipo_sede = ".$tiposede;
	//	echo $condicion;
	}
	if($sedes==" " || $sedes =="00" || empty($sedes)){
		$condicion.= "";
	} else
	{			
		$condicion.= " and ts.id_sede = ".$sedes;
	
	}
	
function llamarhoy($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
	and ts.id_cat_entidad = ".$comisaria." "
	.$condicion."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}


		Yii::log('', CLogger::LEVEL_ERROR, $querydos);
}//fin del proceso de hoy

function llamarayer($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -1 AND 'now'::text::date -1
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
    .$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarunasemana($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -7 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
	.$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy
function llamardossemana($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -14 AND 'now'::text::date -7
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
	.$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy
function llamarunmes($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -30 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
	.$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd,id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarmesanterior($id_hecho,$condicion,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -61 AND 'now'::text::date -30
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria." "
	.$condicion." 
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
	
}//fin del proceso mes anterior

function procesafila($nombrehecho,$id_hecho,$tiposede,$sedes,$comisaria,$contador,$condicion)
{
	$hoy = llamarhoy($id_hecho,$condicion,$comisaria);
	$ayer = llamarayer($id_hecho,$condicion,$comisaria);
	$unasaemana = llamarunasemana($id_hecho,$condicion,$comisaria);
	$dossemanas = llamardossemana($id_hecho,$condicion,$comisaria);
	$unmes = llamarunmes($id_hecho,$condicion,$comisaria);
	$mesanterior = llamarmesanterior($id_hecho,$condicion,$comisaria);
	//echo $nombrehecho."-".$hoy."-".$ayer."-".$unasaemana."-".$unmes;
	//echo "<br>";
$restaanailizhoy = 0;
	$testorestahoy='';

	if($hoy > $ayer)
	{
		$restaanailizhoy = $hoy - $ayer;
		$testorestahoy = '<span class="badge badge-important">'.$restaanailizhoy.'</span>';
	}else if($hoy<$ayer)
	{
		$restaanailizhoy = $ayer - $hoy;
		$testorestahoy = '<span class="badge badge-success">'.$restaanailizhoy.'</span>';
	}else{
		$testorestahoy = '<span class="badge badge-warning">'.$restaanailizhoy.'</span>';
	}


	$restaanaillizsemana = 0;
	$restadossemanas="";
if($unasaemana > $dossemanas)
	{
		$restaanaillizsemana = $unasaemana - $dossemanas;
		$restadossemanas = '<span class="badge badge-important">'.$restaanaillizsemana.'</span>';
	}else if($unasaemana<$dossemanas)
	{
		$restaanaillizsemana = $dossemanas - $unasaemana;
		$restadossemanas = '<span class="badge badge-success">'.$restaanaillizsemana.'</span>';
	}else{
		$restadossemanas = '<span class="badge badge-warning">'.$restaanaillizsemana.'</span>';
	}
	$url =Yii::app()->createUrl('estadisticascf/pnivel');
	$salidagrafica ="
    <script type='text/javascript'>
  
		
	$('.ttip_hecho').tooltip({title:'Click en el Nombre Hecho Para Ver Detalle'});
	
	$('.hola').click(function(e){
		
	e.stopImmediatePropagation();
	var idhecho = $(this).data('idhecho');
	var tiposede = $('#tiposede').val();
	var sedes = $('#sedes').val();

      $.ajax({
        type:'POST',
        url:'$url',
          data:{
          idhecho:idhecho,
          tiposede: tiposede,
          sedes: sedes
       
        },
        beforeSend:function()
        {
        
        },
        success:function(responde)
        { 

        $('#filtros').hide(1000);
		$('.filtros').hide('fast');

        $('#in_hecho').val(idhecho);
        $('#respuestaajax').hide(1000);
		$('.respuestaajax').hide('fast');
		$('#primernivel').html('');
		$('#primernivel').html(responde);
		$('#primernivel').show(1000);
		$('.primernivel').show('fast');


        },
      });//fin del ajax

});

    </script>";
	$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
	$comisaria=$variable_datos_usuario[0]->nombre_entidad;
	$estadistica = new Estadisticas;
	if(isset($_SESSION['ID_ENTIDAD_E']))
		{
			$id_cat_entidad = $_SESSION['ID_ENTIDAD_E'];
			$nombre = $estadistica->getEntidad($id_cat_entidad);
			$comisaria = $nombre[0]['nombre_entidad'];
		}


	$salidatexto ="  <tr>
  <td><div id='ola' class='hola' data-idhecho =".$id_hecho.">".$nombrehecho."</div></td>
      <td>".$comisaria."</td>
       <td><center>".$ayer."</center></td>
      <td><center>".$hoy."</center></td>
      <td><center>".$testorestahoy."</center></td>
      <td><center>".$unasaemana."</center></td>
      <td><center>".$dossemanas."</center></td>
      <td><center>".$restadossemanas."</center></td>
      <td><center>".$mesanterior."</center></td>
      <td><center>".$unmes."</center></td>
      <td><center>".$restadosmeses."</center></td>
     
    </tr>";

    return $salidatexto.$salidagrafica;
}//fin del proceso de fila


$tabla = '<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Comisaria</th>
       <th><center>Ayer</center></th>
       <th><center>Hoy</center></th>
        <th></th>
       <th><center>Semana Anterior</center></th>
        <th><center>Semana Actual</center></th>
       <th></th>
        <th><center>Mes Anterior</center></th>
       <th><center>Mes Actual</center></th>
      
    </tr>
  </thead>
  <tbody>';
       $query = "SELECT id_cat_denuncia, nombre_denuncia  FROM sipol_catalogos.cat_denuncia order by nombre_denuncia";
$resultado = Yii::app()->db->createCommand($query)->queryAll();
$contador = 0;
foreach ($resultado as $key => $value) {
	$tabla .= procesafila($value['nombre_denuncia'],$value['id_cat_denuncia'],$tiposede,$sedes,$comisaria,$contador,$condicion);
	$contador = $contador +1;
}
 $tabla .='</tbody></table>';
echo '	<div id="exportarBotones" align="right"> 
		<a href="#myModal" role="button" class="btn btn-large btn-primary" data-toggle="modal">CORREO</a> 
		<a href="index.php?r=estadisticascf/mostrarexcelfiltros&nuevo='.$comisaria.'&tipoevento='.$tipoevento.'&tiposede='.$tiposede.'&sedes='.$sedes.'"  role="button" class="btn btn-large btn-success" data-toggle="modal">EXCEL</a>  
	</div><br>'.$tabla;
}




public function actionCuadroglobal()
{
	$tipoevento = $_POST['tipoevento'];
	$comisaria = $_POST['comisaria'];
function llamarhoy($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
	and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";




	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarayer($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -1 AND 'now'::text::date -1
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy

function llamarunasemana($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -7 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy
function llamardossemana($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -14 AND 'now'::text::date -7
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy
function llamarunmes($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -30 AND 'now'::text::date
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
}//fin del proceso de hoy





function llamarmesanterior($id_hecho,$comisaria)
{
	$querydos ="SELECT count(ed.id_evento) as conteo
	FROM sipol.tbl_evento_detalle ed
	INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
	INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
	INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
	where ed.fecha_evento  BETWEEN 'now'::text::date -61 AND 'now'::text::date -30
	and e.estado = 't'
	and e.id_tipo_evento = 1
	and ed.atributos IS NOT NULL
		and ts.id_cat_entidad = ".$comisaria."
	AND cd.id_cat_denuncia = ".$id_hecho."
	GROUP BY cd.id_cat_denuncia";
	$resultadodos = Yii::app()->db->createCommand($querydos)->queryScalar();
	$salida = 0;
		if($resultadodos)
		{
			$salida =$resultadodos;
			return $salida;
		}else{
			$salida = "0";
			return $salida;
	}
	
}//fin del proceso mes anterior

function procesafila($nombrehecho,$id_hecho,$comisaria,$contador)
{
	$hoy = llamarhoy($id_hecho,$comisaria);
	$ayer = llamarayer($id_hecho,$comisaria);
	$unasaemana = llamarunasemana($id_hecho,$comisaria);
	$dossemanas = llamardossemana($id_hecho,$comisaria);
	$mesanterior = llamarmesanterior($id_hecho,$comisaria);
	$unmes = llamarunmes($id_hecho,$comisaria);
	//echo $nombrehecho."-".$hoy."-".$ayer."-".$unasaemana."-".$unmes;
	//echo "<br>";
$restaanailizhoy = 0;
	$testorestahoy='';

	if($hoy > $ayer)
	{
		$restaanailizhoy = $hoy - $ayer;
		$testorestahoy = '<span class="badge badge-important">'.$restaanailizhoy.'</span>';
	}else if($hoy<$ayer)
	{
		$restaanailizhoy = $ayer - $hoy;
		$testorestahoy = '<span class="badge badge-success">'.$restaanailizhoy.'</span>';
	}else{
		$testorestahoy = '<span class="badge badge-warning">'.$restaanailizhoy.'</span>';
	}


	$restaanaillizsemana = 0;
	$restadossemanas="";
if($unasaemana > $dossemanas)
	{
		$restaanaillizsemana = $unasaemana - $dossemanas;
		$restadossemanas = '<span class="badge badge-success">'.$restaanaillizsemana.'</span>';
	}else if($unasaemana<$dossemanas)
	{
		$restaanaillizsemana = $dossemanas - $unasaemana;
		$restadossemanas = '<span class="badge badge-important">'.$restaanaillizsemana.'</span>';
	}else{
		$restadossemanas = '<span class="badge badge-warning">'.$restaanaillizsemana.'</span>';
	}

			$restaanalizames = 0;
	$restadosmeses="";
if( $unmes > $mesanterior)
	{
		$restaanalizames = $unmes - $mesanterior; 
		$restadosmeses = '<span class="badge badge-important">'.$restaanalizames.'</span>';
	}else if($unmes < $mesanterior )
	{
		$restaanalizames = $mesanterior - $unmes;
		$restadosmeses = '<span class="badge badge-success">'.$restaanalizames.'</span>';
	}else{
		$restadosmeses = '<span class="badge badge-warning">'.$restaanalizames.'</span>';
	}
	$url =Yii::app()->createUrl('Estadisticascf/pnivel');
	$salidagrafica ="
    <script type='text/javascript'>
		
	$('.ttip_hecho').tooltip({title:'Click en el Nombre Hecho Para Ver Detalle'});
	
	$('.hola').click(function(e){
		
	e.stopImmediatePropagation();
	var idhecho = $(this).data('idhecho');
	var tiposede = $('#tiposede').val();
	var sedes = $('#sedes').val();

      $.ajax({
        type:'POST',
        url:'$url',
          data:{
          idhecho:idhecho,
          tiposede: tiposede,
          sedes: sedes
       
        },
        beforeSend:function()
        {
        
        },
        success:function(responde)
        { 

        $('#filtros').hide(1000);
		$('.filtros').hide('fast');

        $('#in_hecho').val(idhecho);
        $('#respuestaajax').hide(1000);
		$('.respuestaajax').hide('fast');
		$('#primernivel').html('');
		$('#primernivel').html(responde);
		$('#primernivel').show(1000);
		$('.primernivel').show('fast');


        },
      });//fin del ajax

});


    </script>";
	$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
	$comisaria=$variable_datos_usuario[0]->nombre_entidad;
	$estadistica = new Estadisticas;
	if(isset($_SESSION['ID_ENTIDAD_E']))
		{
			$id_cat_entidad = $_SESSION['ID_ENTIDAD_E'];
			$nombre = $estadistica->getEntidad($id_cat_entidad);
			$comisaria = $nombre[0]['nombre_entidad'];
		}

	$salidatexto ="  <tr>
      <td><div id='ola' class='hola' data-idhecho =".$id_hecho.">".$nombrehecho."</div></td>
      <td>".$comisaria."</td>
       <td><center>".$ayer."</center></td>
      <td><center>".$hoy."</center></td>

      <td><center>".$testorestahoy."</center></td>
      <td><center>".$unasaemana."</center></td>
      <td><center>".$dossemanas."</center></td>
      <td><center>".$restadossemanas."</center></td>
      <td><center>".$mesanterior."</center></td>
      <td><center>".$unmes."</center></td>
       <td><center>".$restadosmeses."</center></td>

    </tr>";

    return $salidatexto.$salidagrafica;
}//fin del proceso de fila


$tabla = '<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Comisaria</th>
       <th><center>Ayer</center></th>
       <th><center>Hoy</center></th>
        <th></th>
       <th><center>Semana Anterior</center></th>
        <th><center>Semana Actual</center></th>
       <th></th>
        <th><center>Mes Anterior</center></th>
       <th><center>Mes Actual</center></th>
   
    </tr>
  </thead>
  <tbody>';
       $query = "SELECT id_cat_denuncia, nombre_denuncia  FROM sipol_catalogos.cat_denuncia order by nombre_denuncia";
$resultado = Yii::app()->db->createCommand($query)->queryAll();
$contador = 0;
foreach ($resultado as $key => $value) {
	$tabla .= procesafila($value['nombre_denuncia'],$value['id_cat_denuncia'],$comisaria,$contador);
	$contador = $contador +1;
}
 $tabla .='</tbody></table>';
echo '	<div id="exportarBotones" align="right"> 
		<a href="#modaltablaglobal" role="button" class="btn btn-large btn-primary" data-toggle="modal">CORREO</a> 
		<a href="index.php?r=estadisticascf/mostrarexcel&nuevo='.$comisaria.'&tipoevento='.$tipoevento.'"  role="button" class="btn btn-large btn-success" data-toggle="modal">EXCEL</a>  
	</div><br>'.$tabla;
}

















public function actionNuevodashboard()
{
	$this->render('nuevodashboard');
}

public function actionMapacomisaria()
{
	$this->render('general');
}
public function actionMapaGeneral()
{
	$this->renderPartial('mapa_general');
}
public function actionComisariafiltrosweb()
{
    $tipoevento = $_POST['tipoevento'];
    $tiposede = $_POST['tiposede'];
    $sedes = $_POST['sedes'];
    $tiempo = $_POST['tiempo'];
    $comisaria = $_POST['comisaria'];
    $subqueryfecha="";
    $textevento = $_POST['textevento'];
    $textotiposede = $_POST['textotiposede'];
    $textosedes = $_POST['textosedes'];
    $textotiempo="";
    $encriptar = new Encrypter;

    $condicion="";
    $bandera="";                            

                                

                                    if(empty($tiposede) || $tiposede =="00")
                                    {
                                        //$condicion.= "and ts.id_tipo_sede =  ts.id_tipo_sede";
                                        $condicion.= " ";
                                        $bandera =0;
                                        
                                    }  else
                                    {
                                        //$condicion.= "and ts.id_tipo_sede = '".$tiposede."'";

                                        $condicion.= "and ts.id_tipo_sede = '".$tiposede."' ";
                                        $bandera=1;
                                    }  

                                    if(empty($sedes) || $sedes =="00")
                                    {
                                        
                                        $condicion.= "";
                                        $bandera =0;

                                    }  else
                                    {
                                        $condicion.= "and  ts.id_sede = '".$sedes."'";
                                        $bandera =1;

                                    }  

        switch ($tiempo) {
            case '1':
                # code...
            $subqueryfecha = "where ed.fecha_evento  = ('now'::text::date)";
            $textotiempo="Hoy";
            //ed.fecha_evento BETWEEN 'now'::text::date -60 AND 'now'::text::date
        break;
            case '2':
                # code...
            $subqueryfecha = "where ed.fecha_evento  BETWEEN 'now'::text::date -1 AND 'now'::text::date";
            $textotiempo="Ayer";
            //ed.fecha_evento BETWEEN 'now'::text::date -60 AND 'now'::text::date
        break;
            case '3':
                # code...
            $subqueryfecha = "where ed.fecha_evento  BETWEEN 'now'::text::date -7 AND 'now'::text::date";
            $textotiempo="1 Semana Atras";
        break;

            case '5':
                # code...
            $subqueryfecha = "where ed.fecha_evento  BETWEEN 'now'::text::date -30 AND 'now'::text::date";
            $textotiempo="1 Mes Atras";
        break;
            
            default:
                # code...
                $subqueryfecha =  "where ed.fecha_evento  = ('now'::text::date)";
                $textotiempo="Hoy";
                break;
        }




  if($tipoevento==1)
{
      $sql="SELECT  cd.id_cat_denuncia,
cd.nombre_denuncia, count(ed.id_evento)
FROM sipol.tbl_evento_detalle ed
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
  ".$subqueryfecha. "
and e.estado = 't'
and e.id_tipo_evento = 1
and ed.atributos IS NOT NULL
and ts.id_cat_entidad = ".$comisaria."
".$condicion."
GROUP BY cd.nombre_denuncia , cd,id_cat_denuncia
ORDER BY 3 DESC";
} else if ($tipoevento==3)
{
      $sql="SELECT  ex.id_extravio as id_cat_denuncia, ex.nombre_extravio as nombre_denuncia, count(ed.id_evento)
FROM sipol.tbl_evento_detalle ed
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
INNER JOIN sipol_catalogos.cat_extravios ex ON ed.id_hecho_denuncia = ex.id_extravio
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
  ".$subqueryfecha. "
and e.estado = 't'
and e.id_tipo_evento = 3
and ed.atributos IS NOT NULL
and ts.id_cat_entidad = ".$comisaria."
 ".$condicion."

GROUP BY ex.id_extravio, ex.nombre_extravio 
ORDER BY 3 DESC";
}


//echo $sql;
    $resultado = Yii::app()->db->createCommand($sql)->queryAll();



if(count($resultado)>=1)
    {


        echo '<div class="row-fluid">
  <div class="span6 offset3">';


        echo "<br>";

        echo '<div class="alert alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Información de Filtros Seleccionados!</h4>
              ';
              echo "<strong>Tipo Evento:</strong> ".$textevento.",  <strong>Tipo Sede: </strong>".$textotiposede.",  <strong>Nombre Sede: </strong> ".$textosedes.",  <strong>Filtro de Fecha: </strong>".$textotiempo;

            echo '</div>';
        
$tabla = '<table class="table table-bordered">
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Cantidad</th>
      <th></th>
    </tr>
  </thead> <tbody>';


        foreach ($resultado as $key => $value) {
         $tabla .= '<tr>
      <td>'.$value['nombre_denuncia'].'</td>
   <td>'.$value['count'].'</td>
    <td>
    <a href="index.php?r=estadisticascf/Mapassipol&geo='.$encriptar->compilarget(trim($tipoevento)).','.$encriptar->compilarget(trim($tiposede)).','.$encriptar->compilarget(trim($sedes)).','.$encriptar->compilarget(trim($tiempo)).','.$encriptar->compilarget(trim($comisaria)).','.$encriptar->compilarget(trim($value['id_cat_denuncia'])).','.$encriptar->compilarget(trim($bandera)).'"  class="btn btn-mini btn-primary" target="_blank" >Analizar Hecho</a></td>

    </tr>';
        
        }//fin del for principal
        $tabla .='</tbody></table>';
        echo "<br>";
        echo $tabla;

         echo '</div>
</div>';
    }else{
        echo '<center>
               <div class="jumbotron">
                        <h1>Información del Sistema</h1>
                        <p class="lead">No se encuentran eventos registrados con esos filtros
                        </p>
                     </div>
            </center>';
    }
}


public function actionComisariafiltros()
{
	$tipoevento = $_POST['tipoevento'];
	$tiposede = $_POST['tiposede'];
	$sedes = $_POST['sedes'];
	$tiempo = $_POST['tiempo'];
	$comisaria = $_POST['comisaria'];
	$subqueryfecha="";
	$textevento = $_POST['textevento'];
	$textotiposede = $_POST['textotiposede'];
	$textosedes = $_POST['textosedes'];
	$textotiempo="";
	$fecha1_sede= $_POST['fecha1_sede'];
	$fecha2_sede= $_POST['fecha2_sede']; 
	$bandera= $_POST['bandera']; 
		//$bandera= "0"; 
	if($bandera =="0")
	{
							$encriptar = new Encrypter;


								switch ($tiempo) {
									case '1':
										# code...
									$subqueryfecha = "where e.fecha_ingreso  = ('now'::text::date)";
									$textotiempo="Hoy";
									//e.fecha_ingreso BETWEEN 'now'::text::date -60 AND 'now'::text::date
								break;
									case '2':
										# code...
									$subqueryfecha = "where e.fecha_ingreso  BETWEEN 'now'::text::date -1 AND 'now'::text::date";
									$textotiempo="Ayer";
									//e.fecha_ingreso BETWEEN 'now'::text::date -60 AND 'now'::text::date
								break;
									case '3':
										# code...
									$subqueryfecha = "where e.fecha_ingreso  BETWEEN 'now'::text::date -7 AND 'now'::text::date";
									$textotiempo="Una Semana";
								break;

									case '5':
										# code...
									$subqueryfecha = "where e.fecha_ingreso  BETWEEN 'now'::text::date -30 AND 'now'::text::date";
									$textotiempo="Un Mes";
								break;
									
									default:
										# code...
										$subqueryfecha =  "where e.fecha_ingreso  = ('now'::text::date)";
										break;
								}

								$condicion="";
								

								

									if(empty($tiposede) || $tiposede =="00")
									{
										//$condicion.= "and ts.id_tipo_sede =  ts.id_tipo_sede";
										$condicion.= " ";
										

									}  else
									{
										//$condicion.= "and ts.id_tipo_sede = '".$tiposede."'";
										

										$condicion.= "and ts.id_tipo_sede = '".$tiposede."' ";

									}  


									if(empty($sedes) || $sedes =="00")
									{
										

										$condicion.= "";



									}  else
									{
										$condicion.= "and  ts.id_sede = '".$sedes."'";

									}  






								if (empty($textevento)) {
									 $textevento="Denuncia";
								}
								if (empty($textotiposede)) {
									$textotiposede="Todos";
										}
								if ($textosedes=="Todos") {
									$textosedes="Todos";
										}
							
						if($tipoevento==1)
						{ 

							  $sql="SELECT  cd.id_cat_denuncia,
						cd.nombre_denuncia, count(ed.id_evento)
						FROM sipol.tbl_evento_detalle ed
						INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
						INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
						INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
						  ".$subqueryfecha. "
						and e.estado = 't'
						and e.id_tipo_evento = 1
						and ed.atributos IS NOT NULL "
						.$condicion."
						and ts.id_cat_entidad = '".$comisaria."'
						GROUP BY cd.nombre_denuncia , cd.id_cat_denuncia
						ORDER BY 3 DESC";
						} else if ($tipoevento==3)
						{
							  $sql="SELECT  ex.id_extravio as id_cat_denuncia, ex.nombre_extravio as nombre_denuncia, count(ed.id_evento)
						FROM sipol.tbl_evento_detalle ed
						INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
						INNER JOIN sipol_catalogos.cat_extravios ex ON ed.id_hecho_denuncia = ex.id_extravio
						INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
						  ".$subqueryfecha. "
						and e.estado = 't'
						and e.id_tipo_evento = 3
						and ed.atributos IS NOT NULL  "
						.$condicion."
						GROUP BY ex.id_extravio, ex.nombre_extravio 
						ORDER BY 3 DESC";
						}

						  
							$resultado = Yii::app()->db->createCommand($sql)->queryAll();
							if(count($resultado)>=1)
							{
								$variabledata ="[";
								$contadordeDow = 0;

								foreach ($resultado as $key => $value) {

									if($contadordeDow <= 9)
									{
											$variabledata .="{
									name: '".$value['nombre_denuncia']."',
									y: ".$value['count'].",
									
									},";


									}else{
									break;
									}
									$contadordeDow = $contadordeDow +1;
								}//fin del for principal
								$variabledata .="]";
								echo "<script>// Internationalization
								Highcharts.setOptions({
								lang: {
								drillUpText: '◁ Regresar'
								}
								});


								var options = {

								chart: {
								height: 300
								},

								title: {
								text: 'Grafica Comparativa de Hechos'
								},
								  
								
								xAxis: {
								categories: true,
							  		},
							
								

								drilldown: {
								series:[]
								},

								legend: {
								enabled: false
								},
plotOptions: 
{
	series: 
	{
		dataLabels: 
		{
			enabled: true,
		}, 
		shadow: false
	},
	pie: 
	{
		allowPointSelect: true,
		cursor: 'pointer',
		dataLabels: 
		{
			enabled: true,
			format: '{point.percentage:.1f} %',
			style: {
				color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			},
			connectorColor: 'silver'
		}
	}
},

						   
								series: [{
								name: 'Cantidad',
								colorByPoint: true,
								data: ".$variabledata."
								}]
								};

								// Column chart
								options.chart.renderTo = 'container1';
								options.chart.type = 'column';
								var chart1 = new Highcharts.Chart(options);

								options.chart.renderTo = 'container2';
								options.chart.type = 'pie';
								//options.{point.percentage:.0f}%;
								var chart2 = new Highcharts.Chart(options);
								</script>   
								";

								echo "<br>";

								echo '<div class="row-fluid">
						  <div class="span6 offset3">';


								echo "<br>";

								echo '<div class="alert alert-info">
									  <button type="button" class="close" data-dismiss="alert">&times;</button>
									  <h4>Información de Filtros Seleccionados!</h4>
									  ';
									  echo "<strong>Tipo Evento:</strong> ".$textevento.",  <strong>Tipo Sede: </strong>".$textotiposede.",  <strong>Nombre Sede: </strong> ".$textosedes.",  <strong>Filtro de Fecha: </strong>".$textotiempo;

									echo '</div>';
								echo "<legend> Ubicacion Geografica del Hecho </legend>";
						$tabla = '<table class="table table-bordered">
						  <thead>
						    <tr>
						      <th>Hecho</th>
						      <th>Cantidad</th>
						      <th></th>
						    </tr>
						  </thead> <tbody>'; 

								foreach ($resultado as $key => $value) {
								 $tabla .= '<tr>
						      <td>'.$value['nombre_denuncia'].'</td>
						    <td>'.$value['count'].'</td>
						    <td><a href="index.php?r=estadisticascf/Mapassipol&geo='.$encriptar->compilarget(trim($tipoevento)).','.$encriptar->compilarget(trim($tiposede)).','.$encriptar->compilarget(trim($sedes)).','.$encriptar->compilarget(trim($tiempo)).','.$encriptar->compilarget(trim($comisaria)).','.$encriptar->compilarget(trim($value['id_cat_denuncia'])).','.$encriptar->compilarget(trim($bandera)).'"  class="btn btn-mini btn-primary" target="_blank" >Ver Mapa</a></td>
						    </tr>';
								
								}//fin del for principal

								$tabla .='</tbody></table>';
								echo "<br>";
								echo $tabla;

								 echo '</div>
						</div>';
							}else{
								echo '<center>
									   <div class="jumbotron">
										        <h1>Información del Sistema</h1>
										        <p class="lead">No se encuentran eventos registrados con esos filtros
												</p>
									 		</div>
									</center>';
							}

}else{



$invertirfechauno = explode("/",$fecha1_sede); 
$fechauno = $invertirfechauno[2]."/".$invertirfechauno[1]."/".$invertirfechauno[0]; 

$invertirfechados = explode("/",$fecha2_sede); 
$fechados = $invertirfechados[2]."/".$invertirfechados[1]."/".$invertirfechados[0]; 


$subqueryfecha = "where e.fecha_ingreso  BETWEEN '".$fechauno."' AND '".$fechados."'";
			$textotiempo="Rangos de Fechas Seleccioandas de ".$fecha1_sede." hasta ".$fecha2_sede." ";





	$encriptar = new Encrypter;


		$condicion="";
		

		

			if(empty($tiposede) || $tiposede =="00")
			{
				//$condicion.= "and ts.id_tipo_sede =  ts.id_tipo_sede";
				$condicion.= " ";
				

			}  else
			{
				//$condicion.= "and ts.id_tipo_sede = '".$tiposede."'";
				

				$condicion.= "and ts.id_tipo_sede = '".$tiposede."' ";

			}  


			if(empty($sedes) || $sedes =="00")
			{
				

				$condicion.= "";



			}  else
			{
				$condicion.= "and  ts.id_sede = '".$sedes."'";

			}  






		if (empty($textevento)) {
			 $textevento="Denuncia";
		}
		if (empty($textotiposede)) {
			$textotiposede="Todos";
				}
		if ($textosedes=="Todos") {
			$textosedes="Todos";
				}
	
if($tipoevento==1)
{ 

	  $sql="SELECT  cd.id_cat_denuncia,
cd.nombre_denuncia, count(ed.id_evento)
FROM sipol.tbl_evento_detalle ed
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
  ".$subqueryfecha. "
and e.estado = 't'
and e.id_tipo_evento = 1
and ed.atributos IS NOT NULL "
.$condicion."
and ts.id_cat_entidad = '".$comisaria."'
GROUP BY cd.nombre_denuncia , cd.id_cat_denuncia
ORDER BY 3 DESC";

//echo $sql;
} else if ($tipoevento==3)
{
	  $sql="SELECT  ex.id_extravio as id_cat_denuncia, ex.nombre_extravio as nombre_denuncia, count(ed.id_evento)
FROM sipol.tbl_evento_detalle ed
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
INNER JOIN sipol_catalogos.cat_extravios ex ON ed.id_hecho_denuncia = ex.id_extravio
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
  ".$subqueryfecha. "
and e.estado = 't'
and e.id_tipo_evento = 3
and ed.atributos IS NOT NULL  "
.$condicion."
GROUP BY ex.id_extravio, ex.nombre_extravio 
ORDER BY 3 DESC";
}

  
	$resultado = Yii::app()->db->createCommand($sql)->queryAll();
	if(count($resultado)>=1)
	{
		$variabledata ="[";
		$contadordeDow = 0;

		foreach ($resultado as $key => $value) {

			if($contadordeDow <= 9)
			{
					$variabledata .="{
			name: '".$value['nombre_denuncia']."',
			y: ".$value['count'].",
			
			},";


			}else{
			break;
			}
			$contadordeDow = $contadordeDow +1;
		}//fin del for principal
		$variabledata .="]";
		echo "<script>// Internationalization
		Highcharts.setOptions({
		lang: {
		drillUpText: '◁ Regresar'
		}
		});

		var options = {

		chart: {
		height: 300
		},

		title: {
		text: 'Grafica Comparativa de Hechos'
		},

		//tooltip: {

         //   pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        //},

		xAxis: {
		categories: true,
	  		},
	
		

		drilldown: {
		series:[]
		},

		legend: {
		enabled: false
		},

	plotOptions: 
{
	series: 
	{
		dataLabels: 
		{
			enabled: true,
		}, 
		shadow: false
	},
	pie: 
	{
		allowPointSelect: true,
		cursor: 'pointer',
		dataLabels: 
		{
			enabled: true,
			format: '{point.percentage:.1f} %',
			style: {
				color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			},
			connectorColor: 'silver'
		}
	}
},

  
   
		series: [{
		name: 'Cantidad',
		colorByPoint: true,
		data: ".$variabledata."
		}]
		};

		// Column chart
		options.chart.renderTo = 'container1';
		options.chart.type = 'column';
		var chart1 = new Highcharts.Chart(options);

		options.chart.renderTo = 'container2';
		options.chart.type = 'pie';
		var chart2 = new Highcharts.Chart(options);
		</script>   
		";

		echo "<br>";

		echo '<div class="row-fluid">
  <div class="span6 offset3">';


		echo "<br>";

		echo '<div class="alert alert-info">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <h4>Información de Filtros Seleccionados!</h4>
			  ';
			  echo "<strong>Tipo Evento:</strong> ".$textevento.",  <strong>Tipo Sede: </strong>".$textotiposede.",  <strong>Nombre Sede: </strong> ".$textosedes.",  <strong>Filtro de Fecha: </strong>".$textotiempo;

			echo '</div>';
		echo "<legend> Ubicacion Geografica del Hecho </legend>";
$tabla = '<table class="table table-bordered">
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Cantidad</th>
      <th></th>
    </tr>
  </thead> <tbody>'; 

		foreach ($resultado as $key => $value) 
		{
			$tabla .= '<tr>
			<td>'.$value['nombre_denuncia'].'</td>
			<td>'.$value['count'].'</td>
			<td><a href="index.php?r=estadisticascf/Mapassipol&geo='.$encriptar->compilarget(trim($tipoevento)).','.$encriptar->compilarget(trim($tiposede)).','.$encriptar->compilarget(trim($sedes)).','.$encriptar->compilarget(trim($tiempo)).','.$encriptar->compilarget(trim($comisaria)).','.$encriptar->compilarget(trim($value['id_cat_denuncia'])).','.$encriptar->compilarget(trim($bandera)).','.$encriptar->compilarget(trim($fechauno)).','.$encriptar->compilarget(trim($fechados)).'"  class="btn btn-mini btn-primary" target="_blank" >Ver Mapa</a></td>
			</tr>';
		
		}//fin del for principal

		$tabla .='</tbody></table>';
		echo "<br>";
		echo $tabla;

		 echo '</div>
</div>';
	}else{
		echo '<center>
			   <div class="jumbotron">
				        <h1>Información del Sistema</h1>
				        <p class="lead">No se encuentran eventos registrados con esos filtros
						</p>
			 		</div>
			</center>';
	}


}//fil del else

	

}//fin de la accion


public function actionDashboard()
{

	$this->render('dashboard_estadistica');
}

public function actionEnvioDashboard()
{
	$evento = $_POST['evento'];
	$tiempo = $_POST['tiempo'];
	$this->renderPartial('sipol/view_center_dashboard',array('evento'=>$evento,'tiempo'=>$tiempo));
}

public function actionResumenHechosListado()
{
	$hechosdenuncia = $_POST['hechosdenuncia'];
	$tipo = $_POST['tipo'];
	$departamento = $_POST['departamento'];
	$municipio = $_POST['municipio'];
	$region = $_POST['region'];
	$comisaria = $_POST['comisaria'];
	$tipo_sede = $_POST['tipo_sede'];
	$sede = $_POST['sede'];
	/*post sobre el metodo de denuncia*/
	$tipo_hecho = $_POST['tipo_hecho'];
	$tiempo = $_POST['tiempo'];
	$estadofecha= $_POST['estadofecha'];
	$fechainicio= $_POST['fechainicio'];
	$fechafinal= $_POST['fechafinal'];
    if ($_POST['hechosdenuncia'] =="")
    {    	
    	$hechosdenuncia = "Seleccione un Hecho";
    }else{
    	$hechosdenuncia = $_POST['hechosdenuncia'];    	
    }
    
$this->renderPartial('sipol/resumen_por_hecho',
	array(
			'hechosdenuncia'=>$hechosdenuncia,
			'tipo'=>$tipo,
			'tiempo'=>$tiempo,
			'departamento'=>$departamento,
			'municipio'=>$municipio,
			'region'=>$region,
			'comisaria'=>$comisaria,
			'tipo_sede'=>$tipo_sede,
			'sede'=>$sede,
			'tipo_hecho'=>$tipo_hecho,
			'estadofecha'=>$estadofecha,
			'fechainicio'=>$fechainicio,
			'fechafinal'=>$fechafinal
		));
}	

public function actionResumenDenuncia()
{
	$hechosdenuncia = $_POST['hechosdenuncia'];
	$tipo = $_POST['tipo'];
	$departamento = $_POST['departamento'];
	$municipio = $_POST['municipio'];
	$region = $_POST['region'];
	$comisaria = $_POST['comisaria'];
	$tipo_sede = $_POST['tipo_sede'];
	$sede = $_POST['sede'];
	/*post sobre el metodo de denuncia*/
	$tipo_hecho = $_POST['tipo_hecho'];
	$tiempo = $_POST['tiempo'];
	$estadofecha= $_POST['estadofecha'];
	$fechainicio= $_POST['fechainicio'];
	$fechafinal= $_POST['fechafinal'];

	if(!empty($fechainicio)){
		$h = array();
		$h = explode("/", $fechainicio);
		$fechainicio = $h[2]."-".$h[1]."-".$h[0];	
	}

	if(!empty($fechafinal)){
		$i = array();
		$i = explode("/", $fechafinal);
		$fechafinal = $i[2]."-".$i[1]."-".$i[0];
	}

    if ($_POST['hechosdenuncia'] =="")
    {    	
    	$hechosdenuncia = "Seleccione un Hecho";
    }else{
    	$hechosdenuncia = $_POST['hechosdenuncia'];    	
    }
    
$this->renderPartial('sipol/ResumenTablaDenuncia',
	array(
			'hechosdenuncia'=>$hechosdenuncia,
			'tipo'=>$tipo,
			'tiempo'=>$tiempo,
			'departamento'=>$departamento,
			'municipio'=>$municipio,
			'region'=>$region,
			'comisaria'=>$comisaria,
			'tipo_sede'=>$tipo_sede,
			'sede'=>$sede,
			'tipo_hecho'=>$tipo_hecho,
			'estadofecha'=>$estadofecha,
			'fechainicio'=>$fechainicio,
			'fechafinal'=>$fechafinal
		));
}	


public function actionHechoSeleccionado()
{
	$hecho = $_POST['hecho'];
	$tipo = $_POST['tipo'];
	$departamento = $_POST['departamento'];
	$municipio = $_POST['municipio'];
	$region = $_POST['region'];
	$comisaria = $_POST['comisaria'];
	$tipo_sede = $_POST['tipo_sede'];
	$sede = $_POST['sede'];
	/*post sobre el metodo de denuncia*/

	$tipo_hecho = $_POST['tipo_hecho'];
	$tiempo = $_POST['tiempo'];

	$estadofecha= $_POST['estadofecha'];
	$fechainicio= $_POST['fechainicio'];
	$fechafinal= $_POST['fechafinal'];
$this->renderPartial('sipol/view_hecho_seleccionado',
	array(
			'hecho'=>$hecho,
			'tipo'=>$tipo,
			'tiempo'=>$tiempo,
			'departamento'=>$departamento,
			'municipio'=>$municipio,
			'region'=>$region,
			'comisaria'=>$comisaria,
			'tipo_sede'=>$tipo_sede,
			'sede'=>$sede,
			'tipo_hecho'=>$tipo_hecho,
			'estadofecha'=>$estadofecha,
			'fechainicio'=>$fechainicio,
			'fechafinal'=>$fechafinal
		));

}	
public function actionGraficaTiempoDenuncias()
{
	$hecho = $_POST['hecho'];
	$tipo = $_POST['tipo'];
	$departamento = $_POST['departamento'];
	$municipio = $_POST['municipio'];
	$region = $_POST['region'];
	$comisaria = $_POST['comisaria'];
	$tipo_sede = $_POST['tipo_sede'];
	$sede = $_POST['sede'];
	/*post sobre el metodo de denuncia*/

	$tipo_hecho = $_POST['tipo_hecho'];
	$tiempo = $_POST['tiempo'];

	$estadofecha= $_POST['estadofecha'];
	$fechainicio= $_POST['fechainicio'];
	$fechafinal= $_POST['fechafinal'];


$this->renderPartial('sipol/view_grafica_tiempo_hecho_denuncia',
	array(
			'hecho'=>$hecho,
			'tipo'=>$tipo,
			'tiempo'=>$tiempo,
			'departamento'=>$departamento,
			'municipio'=>$municipio,
			'region'=>$region,
			'comisaria'=>$comisaria,
			'tipo_sede'=>$tipo_sede,
			'sede'=>$sede,
			'tipo_hecho'=>$tipo_hecho,
			'estadofecha'=>$estadofecha,
			'fechainicio'=>$fechainicio,
			'fechafinal'=>$fechafinal
		));




}	
	public function actionGraficasDenuncias()
	{
			$url = CController::createUrl('estadisticascf/GraficaTiempoDenuncias');
			$tipo = $_POST['tipo'];
			$departamento = $_POST['departamento'];
			$municipio = $_POST['municipio'];
			$region = $_POST['region'];
			$comisaria = $_POST['comisaria'];
			$tipo_sede = $_POST['tipo_sede'];
			$sede = $_POST['sede'];
			/*post sobre el metodo de denuncia*/

			$tipo_hecho = $_POST['tipo_hecho'];
			$tiempo = $_POST['tiempo'];
			$estadofecha= $_POST['estadofecha'];
			$fechainicio= $_POST['fechainicio'];
			$fechafinal= $_POST['fechafinal'];
            if (isset($_POST['hechosdenuncia']))
            {
            	$hechosdenuncia = $_POST['hechosdenuncia'];
            }else{

            	$hechosdenuncia = "";

            }
            

	if($tipo == 1)
      {   
      $tipo="Denuncia";  

		$this->renderPartial('sipol/view_graficas_denuncias',
			array(
				'tipo'=>$tipo,
				'tiempo'=>$tiempo,
				'departamento'=>$departamento,
				'municipio'=>$municipio,
				'region'=>$region,
				'comisaria'=>$comisaria,
				'tipo_sede'=>$tipo_sede,
				'sede'=>$sede,
				'tipo_hecho'=>$tipo_hecho,
				'estadofecha'=>$estadofecha,
				'fechainicio'=>$fechainicio,
				'fechafinal'=>$fechafinal,
				'url'=>$url,
				'hechosdenuncia'=> $hechosdenuncia
				));

      }else if($tipo == 2){

      	 	$this->renderPartial('sipol/view_graficas_extravios',
			array(
				'tipo'=>$tipo,
				'tiempo'=>$tiempo,
				'departamento'=>$departamento,
				'municipio'=>$municipio,
				'region'=>$region,
				'comisaria'=>$comisaria,
				'tipo_sede'=>$tipo_sede,
				'sede'=>$sede,
				'tipo_hecho'=>$tipo_hecho,
				'estadofecha'=>$estadofecha,
				'fechainicio'=>$fechainicio,
				'fechafinal'=>$fechafinal
				));
 
      }else{
      	 $tipo="Incidencia"; 
         	
      }

		
	}
	public function actionIndexSipol()
	{
		$this->render('sipol/index');
	}
	public function actionSelect()
	{
		$this->render('select');
	}
	public function actionGraficasSipol()
	{
		$this->renderPartial('sipol/view_graficas');
	}

public function actionMapasSipol()
	{
		$this->render('sipol/view_mapas');
	}

public function actionGraficasMapasSipol()
	{
		$this->renderPartial('sipol/view_graficas_mapas');
	}

public function actionErrorSipol()
	{
		$this->renderPartial('sipol/errorsipol');
	}

	public function actionIndexNovedades()
	{
		$this->render('novedades/index');
	}
	public function actionGraficasNovedades()
	{
		$this->renderPartial('novedades/view_graficas');
	}

public function actionMapasNovedades()
	{
		$this->renderPartial('novedades/view_mapas');
	}

public function actionGraficasMapasNovedades()
	{
		$this->renderPartial('novedades/view_graficas_mapas');
	}

public function actionErrorNovedades()
	{
		$this->render('novedades/errornovedades');
	}

	public function actionPnivel()
	{
		$this->renderPartial('primer_nivel');
	}
public function actionSnivel()
	{
		$this->renderPartial('segundo_nivel');
	}

	public function actionIndex()
	{
		$this->render('index');
	}


}
