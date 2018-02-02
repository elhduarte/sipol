<?php
class estadisticasController  extends Controller
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
				 'actions'=>array('EnvioDashboard','ResumenHechosListado','ResumenDenuncia','HechoSeleccionado','GraficaTiempoDenuncias','select','indexsipol','graficassipol','mapassipol','graficasmapassipol','ErrorSipol','indexnovedades','graficasnovedades','mapasnovedades','graficasmapasnovedades','ErrorNovedades'),
				 'users'=>array('root', 'developer','supervisor_comisaria','supervisor_general'),
				 ),
				 array('allow', // allow authenticated user to perform 'create' and 'update' actions
				 'actions'=>array('index','graficasdenuncias','Dashboard'),
				 'users'=>array('@'),
				 ),
				
				 array('deny', // deny all users
				 'users'=>array('*'),
				 ),
			 );
}

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
			$url = CController::createUrl('estadisticas/GraficaTiempoDenuncias');
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
		$this->renderPartial('sipol/view_mapas');
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


	public function actionIndex()
	{
		$this->render('index');
	}


}
