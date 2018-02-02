<?php 
require_once('lib/PHPExcel-develop/Classes/PHPExcel.php');	
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
$tipoevento = $_GET['tipoevento'];
$comisariaentrada = $_GET['nuevo'];
$tiposede = $_GET['tiposede'];
$sedes = $_GET['sedes'];

$condicion= "";


	if(empty($tiposede) || $tiposede =="00"){
		$condicion.= "";
		}else
	{
		$condicion.= " and ts.id_tipo_sede = ".$tiposede;
	//	echo $condicion;
	}
	if(empty($sedes) || $sedes =="00" || $sedes==""){
		$condicion.= "";
	} else
	{			
		$condicion.= " and ts.id_sede = ".$sedes;
	}

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


// Set document properties
$objPHPExcel->getProperties()->setCreator("Mingob")
							 ->setLastModifiedBy("Mingob")
							 ->setTitle("Sipol Mingob")
							 ->setSubject("Mingob")
							 ->setDescription("Mingob")
							 ->setKeywords("Mingob")
							 ->setCategory("Mingob");

///header
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'POLICIA NACIONAL CIVIL DE GUATEMALA COMISARIA ')
			->setCellValue('A2', 'REPORTE')
			->setCellValue('A3', '')
			->setCellValue('A4', '')
			->setCellValue('A5', '');



		function llamarhoy($id_hecho,$comisariaentrada,$condicion)
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
	and ts.id_cat_entidad = ".$comisariaentrada."".$condicion."
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

function llamarayer($id_hecho,$comisariaentrada,$condicion)
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
		and ts.id_cat_entidad = ".$comisariaentrada."".$condicion."
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

function llamarunasemana($id_hecho,$comisariaentrada,$condicion)
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
		and ts.id_cat_entidad = ".$comisariaentrada."".$condicion."
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
function llamardossemana($id_hecho,$comisariaentrada,$condicion)
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
		and ts.id_cat_entidad = ".$comisariaentrada."".$condicion."
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
function llamarunmes($id_hecho,$comisariaentrada,$condicion)
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
		and ts.id_cat_entidad = ".$comisariaentrada."".$condicion."
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


function llamarmesanterior($id_hecho,$comisariaentrada,$condicion)
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
		and ts.id_cat_entidad = ".$comisariaentrada."".$condicion."
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


function procesafila($nombrehecho,$id_hecho,$comisariaentrada,$contador,$objPHPExcel,$tiposede,$sedes,$condicion)
{
	$hoy = llamarhoy($id_hecho,$comisariaentrada,$condicion);
	$ayer = llamarayer($id_hecho,$comisariaentrada,$condicion);
	$unasaemana = llamarunasemana($id_hecho,$comisariaentrada,$condicion);
	$dossemanas = llamardossemana($id_hecho,$comisariaentrada,$condicion);
	$unmes = llamarunmes($id_hecho,$comisariaentrada,$condicion);
	$mesanterior = llamarmesanterior($id_hecho,$comisariaentrada,$condicion);
	//echo $nombrehecho."-".$hoy."-".$ayer."-".$unasaemana."-".$unmes;
	//echo "<br>";
	
	$restaanailizhoy = 0;
	$testorestahoy='';

	if($hoy > $ayer)
	{
		$restaanailizhoy = $hoy - $ayer;
		$testorestahoy = $restaanailizhoy;
	}else if($hoy<$ayer)
	{
		$restaanailizhoy = $ayer - $hoy;
		$testorestahoy = $restaanailizhoy;
	}else{
		$testorestahoy = $restaanailizhoy;
	}


	$restaanaillizsemana = 0;
	$restadossemanas="";
if($unasaemana > $dossemanas)
	{
		$restaanaillizsemana = $unasaemana - $dossemanas;
		$restadossemanas = $restaanaillizsemana;
	}else if($unasaemana<$dossemanas)
	{
		$restaanaillizsemana = $dossemanas - $unasaemana;
		$restadossemanas =$restaanaillizsemana;
	}else{
		$restadossemanas = $restaanaillizsemana;
	}


	$restaanalizames = 0;
	$restadosmeses="";
if( $unmes > $mesanterior)
	{
		$restaanalizames = $unmes - $mesanterior; 
		$restadosmeses = $restaanalizames;
	}else if($unmes < $mesanterior )
	{
		$restaanalizames = $mesanterior - $unmes;
		$restadosmeses = $restaanalizames;
	}else{
		$restadosmeses = $restaanalizames;
	}


$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);

	/*$salidatexto ="  <tr>
      <td>".$nombrehecho."</td>
      <td>".$variable_datos_usuario[0]->nombre_entidad."</td>
      <td><center>".$hoy."</center></td>
      <td><center>".$ayer."</center></td>
      <td><center>".$testorestahoy."</center></td>
      <td><center>".$unasaemana."</center></td>
      <td><center>".$dossemanas."</center></td>
      <td><center>".$restadossemanas."</center></td>
      <td><center>".$unmes."</center></td>
    </tr>";*/

    $objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$contador, $nombrehecho)
            ->setCellValue('B'.$contador, $variable_datos_usuario[0]->nombre_entidad)
            ->setCellValue('C'.$contador, $ayer)
            ->setCellValue('D'.$contador, $hoy)
            ->setCellValue('E'.$contador, $testorestahoy)
            ->setCellValue('F'.$contador, $unasaemana)
            ->setCellValue('G'.$contador, $dossemanas)
            ->setCellValue('H'.$contador, $restadossemanas)
            ->setCellValue('I'.$contador, $mesanterior)
             ->setCellValue('J'.$contador, $unmes)
 			->setCellValue('K'.$contador, $restadosmeses);

    //return $salidatexto;
}//fin del proceso de fila

$query = "SELECT id_cat_denuncia, nombre_denuncia  FROM sipol_catalogos.cat_denuncia order by nombre_denuncia";
$resultado = Yii::app()->db->createCommand($query)->queryAll();
$contador = 8;
foreach ($resultado as $key => $value) {
	procesafila($value['nombre_denuncia'],$value['id_cat_denuncia'],$comisariaentrada,$contador,$objPHPExcel,$tiposede,$sedes,$condicion);
	$contador = $contador +1;
}
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A7', 'HECHO')
            ->setCellValue('B7', $variable_datos_usuario[0]->nombre_entidad)
            ->setCellValue('C7', 'AYER')
            ->setCellValue('D7', 'HOY')
            ->setCellValue('E7', 'DIF')
             ->setCellValue('F7', 'SEMANA ANTERIOR')
             ->setCellValue('G7', 'SEMANA ACTUAL')
            ->setCellValue('H7', 'DIF')
            ->setCellValue('I7', 'MES ANTERIOR')
             ->setCellValue('J7', 'MES ACTUAL')
             ->setCellValue('K7', 'DIF');

$xls_string = array('type'=>'string');

//combinar celdas
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:F5');

//centrar el titulo
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//ajustar el ancho de la primer columna
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

// Miscellaneous glyphs, UTF-8


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="informe.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;