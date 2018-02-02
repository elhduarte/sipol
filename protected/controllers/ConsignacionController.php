<?php

class ConsignacionController extends Controller
{
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
			{
			 return array(
				 array('allow', // allow all users to perform 'index' and 'view' actions
				 'actions'=>array('index','Procesa_agente','Save_TipoyMotivo','AddPatrulla',
					 'AddAgente','ShowAgentes','DeleteAgente','DeletePatrulla','SaveUbicacion','SaveRelato','ShowResumen',
					 'IncidenciaCommit','Mostrar_hechos','Save_consignados','ProcesaHechos','Construye_motivo','Construye_lugar',
					 'Construye_lugar','Consignado_motivo','procesa_patrulla','Save_incidencia',),
				 'users'=>array('oficinista', 'root','developer'),
				 ),
				 array('allow', // allow authenticated user to perform 'create' and 'update' actions
				 'actions'=>array('index','consigna','mapa','tipo','pruebas','agentes','relato','resumen'),
				 'users'=>array('developer'),
				 ),
				 /*
				 array('allow', // allow authenticated user to perform 'create' and 'update' actions
				 'actions'=>array(),
				 'users'=>array('@'),
				 ),*/
				
				 array('deny', // deny all users
				 'users'=>array('*'),
				 ),
			 );
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionProcesa_agente()
	{
		$this->renderPartial('agente_procesar');
	}

	public function actionProcesa_patrulla()
	{
		$this->renderPartial('patrulla_procesar');
	}

	public function actionSave_TipoyMotivo()
	{
		$datosSave = array();
		$datosSave['Tipo'] = $_POST['tipo'];
		$datosSave['Motivo'] = $_POST['motivo'];
		$datosSave['Detalles'] = $_POST['detalles'];
		$jSave = json_encode($datosSave);
		$idTipo = $_POST['idTipo'];
		$idMotivo = $_POST['idMotivo'];

		$hoy = 	date("Y-m-d");
		$hora = date("H:i:s");
		//$hoy = date("Y-m-d",time()-21600);
		//$hora = date("H:i:s",time()-21600);
		$hora = "{".$hora."}";
		$month = date("m");
		$year = date("y");

		//session_start();
		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario_viene = $variable_datos_usuario[0]->id_usuario;
		$id_sede = $variable_datos_usuario[0]->id_sede;

		$m_eventos = new TblEvento;
		$ip_guarda = $_SERVER['REMOTE_ADDR'];
		$m_eventos->attributes=array(
								'id_tipo_evento'=>'2',
								'estado' => '0',
								'fecha_ingreso'=>$hoy,
								'hora_ingreso'=>$hora,
								'id_usuario'=>$id_usuario_viene,
								'id_sede'=>$id_sede,
								'ip_guarda'=>$ip_guarda,
								'denuncia_mp'=>'NA',
								);
		$m_eventos->save(); // Se guardan los datos en la tabla de eventos
		$correl = $m_eventos->id_evento; //Obtiene el id que se guardó
		$i = str_pad($correl, 6, "0", STR_PAD_LEFT); //Antepone los ceros al numero que tiene la variable
		$e = str_pad($id_usuario_viene, 4, "0", STR_PAD_LEFT); //Antepone los ceros al numero que tiene la variable
		$identificador = "02".$month.$year.$e."-".$i; //Se concatenan los datos para crear en # de evento

		$commando = Yii::app()->db->createCommand();
		$evento_num = $commando->update('sipol.tbl_evento', 
		array('evento_num'=>$identificador),
				'id_evento=:id',array(':id'=>$correl)
				);

		$m_evento_det = new TblEventoDetalle;
		$m_evento_det->attributes=array(
			'id_evento'=>$correl,
			'atributos'=>$jSave,
			'id_tipo_incidencia'=>$idTipo,
			'id_motivo_incidencia'=>$idMotivo
			);
		$m_evento_det->save();
		$evento_detalle = $m_evento_det->id_evento_detalle;

		echo $correl; //devuelve el correlativo del evento para llenar el campo
	}

	public function actionAddPatrulla()
	{
		$CorrigeJson = New CorrigeJson;
		$datosPatrulla = $_POST['datosPatrulla'];
		$idIncidencia = $_POST['idEvento'];
		$datosPatrullaSave = $CorrigeJson->nuevoArray($datosPatrulla);

		$idEdConsulta = "SELECT id_evento_detalle 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idIncidencia." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

		foreach ($result as $key => $value) {
			foreach ($value as $llave => $valor) {}
		}

		$idEventoDetalle = $valor;

		$m_patrullas = new TblPatrullas;
		$m_patrullas->attributes=array(
				'id_evento_detalle'=>$idEventoDetalle,
				'patrulla'=>$datosPatrullaSave,
			);
		$m_patrullas->save();//Guarda los parametros enviados

		echo $datosPatrullaSave;
	}

	public function actionAddAgente()
	{
		$CorrigeJson = new CorrigeJson;
		$datosAgente = $_POST['DatosAgente'];
		$idEvento = $_POST['idEvento'];
		$datosAgenteSave = $CorrigeJson->nuevoArray($datosAgente);

		$idEdConsulta = "SELECT id_evento_detalle 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

		foreach ($result as $key => $value) {
			foreach ($value as $llave => $valor) {}
		}

		$idEventoDetalle = $valor;

		$m_agente = new TblAgente;
		$m_agente->attributes=array(
			'agente'=>$datosAgenteSave,
			'id_tipo_agente'=>'1',
			'id_evento_detalle'=>$idEventoDetalle
			);

		$m_agente->save();

		echo "listo, agente guardado";
	}

	public function actionShowAgentes()
	{
		$idEvento = $_POST['idEvento'];
		$r = "";

		$idEdConsulta = "SELECT id_evento_detalle 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

		foreach ($result as $key => $value) {
			foreach ($value as $llave => $valor) {}
		}
		$idEventoDetalle = $valor;

		$sql = "SELECT id_patrulla, patrulla
				FROM sipol.tbl_patrullas
				WHERE id_evento_detalle = ".$idEventoDetalle.";";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		$sql2 = "SELECT id_agente, agente
				FROM sipol.tbl_agente
				WHERE id_evento_detalle = ".$idEventoDetalle.";";

		$resultado2 = Yii::app()->db->createCommand($sql2)->queryAll();

		$primer_nombre = "";
		$segundo_nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";

		foreach ($resultado2 as $v) 
		{
			$id_agente = $v['id_agente'];
			$cerrar = "<div class='pull-right'><button type='button' class='close DeleteAgente' data-dismiss='alert' id_agente='".$id_agente."'><i class='icon-trash'></i></button></div>";
			$y = json_decode($v['agente']);
			$y = (array) $y;
		
			if(!empty($y['Primer_Nombre'])) $primer_nombre = $y['Primer_Nombre'];
			if(!empty($y['Segundo_Nombre'])) $segundo_nombre = $y['Segundo_Nombre'];
			if(!empty($y['Primer_Apellido'])) $primer_apellido = $y['Primer_Apellido'];
			if(!empty($y['Segundo_Apellido'])) $segundo_apellido = $y['Segundo_Apellido'];
			$e = " ";

			echo "<div class='well well-small'>";
			#echo $cerrar;
			echo "<legend class='legend'>Agente".$cerrar."</legend>";
			echo "NIP: <b>".$y['Nip']."</b> - Nombre Completo: <b>".$primer_nombre.$e.$segundo_nombre.$e.$primer_apellido.$e.$segundo_apellido."</b>";
			echo "</div>";
		}


		foreach ($resultado as $value) 
		{
			$id_patrulla = $value['id_patrulla'];
			$cerrar = "<div class='pull-right'><button type='button' class='close DeletePatrulla' data-dismiss='alert' id_patrulla='".$id_patrulla."'><i class='icon-trash'></i></button></div>";
			$r = json_decode($value['patrulla']);
			$r = (array) $r;
			echo "<div class='well well-small'>";
			#echo $cerrar;
			echo "<legend class='legend'>Patrulla".$cerrar."</legend>";
			echo "Patrulla: <b>".$r['Nombre_de_la_Patrulla'].
				"</b> - Tipo: <b>".$r['Tipo']."</b>".
				" - Color: <b>".$r['Color']."</b>";
			echo "</div>";
		}
	}

	public function actionDeleteAgente()
	{
		$id_eliminar = $_POST['id_eliminar'];

		$m_agente = new TblAgente;
		$m_agente->findByPk($id_eliminar)->delete();
	}

	public function actionDeletePatrulla()
	{
		$id_eliminar = $_POST['id_eliminar'];

		$m_pattrullas = new TblPatrullas;
		$m_pattrullas->findByPk($id_eliminar)->delete();
		echo "paso";
	}

	public function actionSaveUbicacion()
	{
		$idEvento = $_POST['idEvento'];

		$dataGeo = $_POST['data_geo'];
		$dataGeo = explode('|', $dataGeo);
		$S_dataGeo = array(
			'Departamento'=>$dataGeo[0],
			'Municipio'=>$dataGeo[1],
			'Zona'=>$dataGeo[2],
			'Colonia'=>$dataGeo[3],
			'Direccion'=>$dataGeo[4],
			'Referencia'=>$dataGeo[5],
			);
		
		$coordinates = new CDbExpression("st_GeomFromEWKT('SRID=900913;".$dataGeo[6]."')");

		$S_dataGeo = json_encode($S_dataGeo);
		$command = Yii::app()->db->createCommand();
		
		$geos = $command->update('sipol.tbl_evento',
			array('the_geom'=>$coordinates,
			'direccion'=>$S_dataGeo,
			),
				'id_evento=:id',array(':id'=>$idEvento)
		);
	}

	public function actionSaveRelato()
	{

		$encripta = new Encrypter;
		$idEvento = $_POST['idEvento'];
		$relato = $_POST['relato'];
		$relato = $encripta->encrypt($relato);
		$implicados = $_POST['implicados'];
		$destinatario = $_POST['destinatario'];
		$destinatario = str_replace(array("\r\n", "\r", "\n"), "<br>",$destinatario);

		$jsonSave = '{"Relato":"'.$relato.'","Implicados":'.$implicados.',"Destinatario":"'.$destinatario.'"}';

		$command = Yii::app()->db->createCommand();
		$relatoSave = $command->update('sipol.tbl_evento',
			array('relato_denuncia'=>$jsonSave,
			),
				'id_evento=:id',array(':id'=>$idEvento)
		);

		//echo $jsonSave;
	}

	public function actionShowResumen()
	{
		$this->renderPartial('_resumen');
	}

	public function actionIncidenciaCommit()
	{
		$decrypt = new Encrypter;
		$idEvento = $_POST['idEvento'];
		$idEventoP = $decrypt->compilarget($idEvento);

		$command = Yii::app()->db->createCommand();
		$com = $command->update('sipol.tbl_evento',
		array('estado'=>'1',
		),
		'id_evento=:id',array(':id'=>$idEvento)
		);

		//$idEvento="2";
	  	$envio = new EnvioCorreo;
	  	$res = $envio->EnviarIdEvento($idEvento);
		
		$url = CController::createUrl("Reportespdf/incidencia&par=".$idEventoP);

		echo $url;
	}

/* Funciones Consignación */

	public function actionMostrar_hechos()
	{
		$valor = $_POST['id_evento'];
		$reportes = new Reportes;

		$ConstructorHechos = new ConstructorHechos;
		
			$sql = "SELECT ed.id_evento_detalle, ed.id_hecho_denuncia, ed.fecha_evento, ed.hora_evento, ed.atributos, 
						ed.id_motivo_consignados, ed.motivo, ed.id_lugar_remision, ed.atributos_lugar_remision
				FROM sipol.tbl_evento_detalle ed
				where id_evento = '".$valor."';";
			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach ($resultado as $value) 
			{
				if(!empty($value['id_hecho_denuncia']))
				{
					$id_evento_detalle = $value['id_evento_detalle'];
					$idHecho = $value['id_hecho_denuncia'];
					$nombreHecho = $ConstructorHechos->nombreHechoCon($idHecho);
					$nombreMotivo = $value['id_motivo_consignados'];
					$nombreMotivo = $ConstructorHechos->nombreHechoMo($nombreMotivo);
					$motivo = $value['motivo'];
					$motivo = $ConstructorHechos->explotaJsonGuion($motivo);
					$nombreLugar = $value['id_lugar_remision'];
					$nombreLugar = $ConstructorHechos->nombreHechoLu($nombreLugar);
					$lugar = $value['atributos_lugar_remision'];
					$lugar = $ConstructorHechos->explotaJsonGuion($lugar);
					$fechaHecho = $value['fecha_evento'];
					$horaHecho = $value['hora_evento'];

					if($idHecho == 1)
					{
						$detalles = $reportes->ListaPersonajuridicaPDF($id_evento_detalle);
					}
					else
					{
						$detalles = $value['atributos'];
						$detalles = $ConstructorHechos->explotaJsonGuion($detalles);
					}
		
					$cerrar = "<div class='pull-right'><button id='eliminar_hecho' type='button' class='close eliminar_hecho' data-dismiss='alert' id_evento_detalle='".$id_evento_detalle."'><i class='icon-trash'></i></button></div>";
					//echo $id_evento_detalle;
					echo "<div class='well well-small'>";
					//echo $cerrar;
					echo "<legend class='legend'>".$cerrar."<h5 style='line-height:10px;'>".$nombreHecho."</h5></legend>";
					$fechaHechoreporte = date("d-m-Y",strtotime($fechaHecho));
					echo "Fecha del hecho: ".$fechaHechoreporte;
					echo " - hora: ".$horaHecho;
					echo "<br>";
					print_r($detalles);
					echo "<br> Motivo de la Consignación: <b>".$nombreMotivo."</b> - ";
					print_r($motivo);
					echo "<br> Lugar a donde se traslada: <b>".$nombreLugar."</b> - ";
					print_r($lugar);
					echo "</div>";
				}//fin del la condición
			}//fin del foreach
	}

	public function actionSave_incidencia()
	{
		$hoy = 	date("Y-m-d");
		$hora = date("H:i:s");
		$hora = "{".$hora."}";
		$month = date("m");
		$year = date("y");

		//session_start();
		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario_viene = $variable_datos_usuario[0]->id_usuario;
		$id_sede = $variable_datos_usuario[0]->id_sede;

		$m_eventos = new TblEvento;
		$ip_guarda = $_SERVER['REMOTE_ADDR'];
		$m_eventos->attributes=array(
								'id_tipo_evento'=>'5',
								'estado' => '0',
								'fecha_ingreso'=>$hoy,
								'hora_ingreso'=>$hora,
								'id_usuario'=>$id_usuario_viene,
								'id_sede'=>$id_sede,
								'ip_guarda'=>$ip_guarda,
								'denuncia_mp'=>'NA',
								);
		$m_eventos->save(); // Se guardan los datos en la tabla de eventos
		$correl = $m_eventos->id_evento; //Obtiene el id que se guardó
		$i = str_pad($correl, 6, "0", STR_PAD_LEFT); //Antepone los ceros al numero que tiene la variable
		$e = str_pad($id_usuario_viene, 4, "0", STR_PAD_LEFT); //Antepone los ceros al numero que tiene la variable
		$identificador = "05".$month.$year.$e."-".$i; //Se concatenan los datos para crear en # de evento

		$commando = Yii::app()->db->createCommand();
		$evento_num = $commando->update('sipol.tbl_evento', 
		array('evento_num'=>$identificador),
				'id_evento=:id',array(':id'=>$correl)
				);
		
		$m_evento_det = new TblEventoDetalle;
		$m_evento_det->attributes=array(
			'id_evento'=>$correl,
			'atributos'=>'[]',
			'id_tipo_incidencia'=>'',
			'id_motivo_incidencia'=>''
			);
		$m_evento_det->save();
		$evento_detalle = $m_evento_det->id_evento_detalle;

		echo $correl; //devuelve el correlativo del evento para llenar el campo
	}

	public function actionSave_consignados()
	{
		$CorrigeJson = new CorrigeJson;
		$datos_hecho = $_POST['hecho_construido'];
		$datos_motivo = $_POST['motivo_array'];
		$datos_motivo_lugar = $_POST['motivo_lugar'];		
		$fecha = $_POST['fecha'];
		$fecha=date("Y-m-d",strtotime($fecha));
		$persona = $_POST['persona'];

		$hora = $_POST['hora'];
		$id_evento = $_POST['id_evento'];
		$id_hecho = $_POST['id_hecho'];
		$id_motivo =$_POST['id_motivo'];
		$id_lugar_con =$_POST['id_lugar_con'];
		$datos_hecho_corregido = $CorrigeJson->nuevoArray($datos_hecho);
		$datos_motivo_corregido = $CorrigeJson->nuevoArray($datos_motivo);
		$datos_motivo_lugar_corregido = $CorrigeJson->nuevoArray($datos_motivo_lugar);

		$hora ="{".$hora."}";

		$m_evento_det = new TblEventoDetalle;
		$m_evento_det->attributes=array(
				'id_hecho_denuncia'=>$id_hecho,
				'id_evento'=>$id_evento,
				'motivo'=>$datos_motivo_corregido,
				'atributos_lugar_remision'=>$datos_motivo_lugar_corregido,
				'id_lugar_remision'=>$id_lugar_con,
				//'novedad_relacionada'=>$inser_novedad,					
				'atributos'=>$datos_hecho_corregido,
				'fecha_evento'=>$fecha,
				'hora_evento'=>$hora,
				'id_motivo_consignados'=>$id_motivo
				);
		$m_evento_det->save();
		$id_evento_detalle = $m_evento_det->id_evento_detalle;

		//echo $datos_motivo_corregido ."--a--".$datos_hecho_corregido;

		if(!empty($persona))
		{
			$upd = "UPDATE sipol.tbl_persona_detalle 
			SET id_evento_detalle = ".$id_evento_detalle." 
			WHERE id_persona_detalle IN (".$persona.")";
			$resultado = Yii::app()->db->createCommand($upd)->execute();
		}

		echo $id_evento_detalle;
	}

	public function actionProcesaHechos()
	{
		$this->renderPartial('consigna/constructor_hechos');
	}
	public function actionConstruye_motivo()
	{
		$this->renderPartial('consigna/constructor_motivo');
	}
	public function actionConstruye_lugar()
	{
		$this->renderPartial('consigna/constructor_lugar');
	}
	public function actionConsignado_motivo()
	{
		$this->renderPartial('consigna/consignacion_motivo');
	}



/* Fin Funciones Consignación */


/* vistas de prueba INICIO ++++++++++++++++++++++++++++++++++++ */

	public function actionTipo()
	{
		$this->render('_tipoymotivo');
	}

	public function actionAgentes()
	{
		$this->render('_agentes');
	}

	public function actionMapa()
	{
		$this->render('_map');
	}

	public function actionRelato()
	{
		$this->render('_relato');
	}

	public function actionConsigna()
	{
		$this->render('_consigna');
	}

	public function actionResumen()
	{
		$this->render('_resumen');
	}

	public function actionHechos()
	{
		$this->render('_hechos');
	}

	public function actionPruebas()
	{
		$this->render('pruebas');
	}


/* vistas de prueba INICIO ++++++++++++++++++++++++++++++++++++ */
}