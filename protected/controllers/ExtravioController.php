<?php

class ExtravioController extends Controller
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
		 'actions'=>array('Update_hecho','index','procesa_renap','explota_renap','Save_denunciante','Save_Ubicacion','ProcesaHechos','Save_hechos','Mostrar_hechos','Eliminar_hecho','Save_Relato','Show_Resumen'),
		 'users'=>array('oficinista','root','developer','supervisor_comisaria'),
		 ),
		 array('allow', // allow all users to perform 'index' and 'view' actions
		 'actions'=>array('pruebas','resumen','relato','hechos','mapa','persona'),
		 'users'=>array('developer'),
		 ),
		 array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 'actions'=>array('selector'),
		 'users'=>array('@'),
		 ),
		
		 array('deny', // deny all users
		 'users'=>array('*'),
		 ),
	 );
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSelector()
	{
		$this->render('selector');
	}

	public function actionProcesa_renap()
	{
		$this->renderPartial('persona/procesar_renap');
	}

	public function actionExplota_renap()
	{
		$this->renderPartial('persona/explota_renap');
	}
	
	public function actionSave_denunciante()
	{
		$CorrigeJson = new CorrigeJson;
		$reportes = new Reportes;
		$datos_asociacion = $_POST['datos_asociacion'];
		$datos_personales = $_POST['datos_personales'];
		$caracteristicas_fisicas = $_POST['caracteristicas_fisicas'];
		$datos_contacto = $_POST['datos_contacto'];
		$llave_renap = $_POST['llave'];
		$cui = $_POST['cui'];
		$foto = $_POST['foto'];
		$idEvento = $_POST['idEvento'];
		$email = $_POST['email'];
		$resultado = "empty";
		$variablearray = "";
		$commando = Yii::app()->db->createCommand();

		if(!empty($cui))
			{
				$sql = "SELECT id_persona FROM sipol.tbl_persona where cui = '".$cui."';";
				$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			}

		$datos_personales = $CorrigeJson->nuevoArray($datos_personales);
		$caracteristicas_fisicas = $CorrigeJson->nuevoArray($caracteristicas_fisicas);
		$datos_contacto = $CorrigeJson->nuevoArray($datos_contacto);

		if ($resultado !== "empty" && count($resultado) >= 1)//esta condicion evalua si tiene muchas coincidencias dentro de la tabla
		{
			foreach($resultado as $key => $value)
			{
				$variablearray = $value;
			}//este foreach recorre todas las posiciones de queryall
		
			while (list($clave, $valor) = each($variablearray))
			{

				$id_persona = $valor;
				
			}//este while trae el ultimo registro cuando se encuentran valores repetidos
		
			$update_persona = $commando->update('sipol.tbl_persona', 
							array(	'llave_renap'=>$llave_renap,
									'cui'=>$cui,
									'datos'=>$datos_personales,
									'caracteristicas'=>$caracteristicas_fisicas,
									'datos_contacto'=>$datos_contacto,
									'foto'=>$foto,
									'correo'=>$email,
									),
							'id_persona=:id',array(':id'=>$id_persona)
							);
		}
		else
		{

			$m_persona = new TblPersona;
			$m_persona->attributes=array('llave_renap'=>$llave_renap,
									'cui'=>$cui,
									'datos'=>$datos_personales,
									'caracteristicas'=>$caracteristicas_fisicas,
									'datos_contacto'=>$datos_contacto,
									'foto'=>$foto,
									'correo'=>$email,
								);
			$m_persona->save();
			$id_persona = $m_persona->id_persona;

		}// fin de la condición


		if(!empty($datos_asociacion))
		{
			$datos_asociacion = $CorrigeJson->nuevoArray($datos_asociacion);
			$m_asociacion = new TblAsociacion;
			$m_asociacion->attributes=array('datos_asociacion'=>$datos_asociacion,
										'id_persona'=>$id_persona
										);
			$m_asociacion->save();	
		}

		if($idEvento == "empty")
		{
			$hoy = 	date("Y-m-d");
			$hora = date("H:i:s");
			$hora = "{".$hora."}";
			$month = date("m");
			$year = date("y");

			$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
			$id_usuario_viene = $variable_datos_usuario[0]->id_usuario;
			$id_sede = $variable_datos_usuario[0]->id_sede;
			
			$ip_guarda = $_SERVER['REMOTE_ADDR'];
			
			$m_eventos = new TblEvento;
			$m_eventos->attributes=array(
									'id_tipo_evento'=>'3',
									'estado' => '0',
									'fecha_ingreso'=>$hoy,
									'hora_ingreso'=>$hora,
									'id_usuario'=>$id_usuario_viene,
									'id_sede'=>$id_sede,
									'ip_guarda'=>$ip_guarda,
									);
			$m_eventos->save(); // Se guardan los datos en la tabla de eventos
			$correl = $m_eventos->id_evento; //Obtiene el id que se guardó
			$i = str_pad($correl, 6, "0", STR_PAD_LEFT); //Antepone los ceros al numero que tiene la variable
			$e = str_pad($id_usuario_viene, 4, "0", STR_PAD_LEFT); //Antepone los ceros al numero que tiene la variable
			$identificador = "01".$month.$year.$e."-".$i; //Se concatenan los datos para crear en # de evento

			$evento_num = $commando->update('sipol.tbl_evento', 
			array('evento_num'=>$identificador),
					'id_evento=:id',array(':id'=>$correl)
					);

			$m_evento_det = new TblEventoDetalle;
			$m_evento_det->attributes=array('id_evento'=>$correl,);
			$m_evento_det->save();
			$evento_detalle = $m_evento_det->id_evento_detalle;


			

			$m_persona_detalle = new TblPersonaDetalle;
			$m_persona_detalle->attributes=array('id_persona'=>$id_persona,
									'id_tipo_persona'=>'1',
									'id_evento_detalle'=>$evento_detalle
									);

			$m_persona_detalle->save();

			echo $correl; //devuelve el correlativo del evento para llenar el campo
		}//Condición que termina el insert
		else
		{
			$idPersonaDetalle = $reportes->getDenuncianteIpd($idEvento);

			$updatePersona = $commando->update('sipol.tbl_persona_detalle',
				array('id_persona'=>$id_persona),
				'id_persona_detalle=:id', array(':id'=>$idPersonaDetalle['id_persona_detalle'])
			);

			if(isset($_POST['personasHechos']) && !empty($_POST['personasHechos'])){
				$personasHechos = $_POST['personasHechos'];

				$upd = "UPDATE sipol.tbl_persona_detalle 
						SET id_persona = ".$id_persona." 
						WHERE id_persona_detalle IN (".$personasHechos.")";

				$resultado = Yii::app()->db->createCommand($upd)->execute();
			}

			echo $idEvento;
		}// Termina la condición del update
	}


	public function actionSave_Ubicacion()
	{
		$id_denuncia = $_POST['id_denuncia'];

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
		$s_geom = $dataGeo[6];
		$idDepto = $dataGeo[7];
		$idMupio = $dataGeo[8];

		$S_dataGeo = json_encode($S_dataGeo);
		//$S_dataGeo = json_encode($S_dataGeo,JSON_UNESCAPED_UNICODE);
		$command = Yii::app()->db->createCommand();

		if(empty($s_geom))
		{
			$geos = $command->update('sipol.tbl_evento',
			array('direccion'=>$S_dataGeo,
				'id_depto'=>$idDepto,
				'id_mupio'=>$idMupio
			),
				'id_evento=:id',array(':id'=>$id_denuncia)
			);
		}
		else
		{
			$s_geom = new CDbExpression("st_GeomFromEWKT('SRID=900913;".$s_geom."')");
			$geos = $command->update('sipol.tbl_evento',
			array('the_geom'=>$s_geom,
			'direccion'=>$S_dataGeo,
			'id_depto'=>$idDepto,
			'id_mupio'=>$idMupio
			),
				'id_evento=:id',array(':id'=>$id_denuncia)
			);
		}

	}

	public function actionProcesaHechos()
	{
		$this->renderPartial('constructor_hechos');
	}

	public function actionSave_hechos()
	{
		$CorrigeJson = new CorrigeJson;
		$funciones = new Funcionesp;
		$datos_hecho = $_POST['hecho_construido'];
		$fecha = $funciones->normalize_date($_POST['fecha']);
		$hora = $_POST['hora'];
		$id_evento = $_POST['id_denuncia'];
		$id_hecho = $_POST['id_hecho'];
		$command = Yii::app()->db->createCommand();
		$hechoInsert = $_POST['hechoInsert'];
		$datos_hecho = $CorrigeJson->nuevoArray($datos_hecho);
		$hora ="{".$hora."}";

		if($hechoInsert == 'I'){
			
			$m_evento_det = new TblEventoDetalle;
			$m_evento_det->attributes=array(
					'id_hecho_denuncia'=>$id_hecho,
					'id_evento'=>$id_evento,
					//'novedad_relacionada'=>$inser_novedad,					
					'atributos'=>$datos_hecho,
					'fecha_evento'=>$fecha,
					'hora_evento'=>$hora,
					);
			$m_evento_det->save();
			$id_evento_detalle = $m_evento_det->id_evento_detalle;
			echo $id_evento_detalle;
		}
		else if($hechoInsert == 'U'){
			$idEventoDetalle = $_POST['idEventoDetalleHecho'];

			$upd = "UPDATE sipol.tbl_evento_detalle
					SET atributos = '".$datos_hecho."',
					fecha_evento = '".$fecha."',
					hora_evento = '".$hora."'
					WHERE id_evento_detalle = ".$idEventoDetalle.";";

			$resultado = Yii::app()->db->createCommand($upd)->execute();

			echo $idEventoDetalle;

		}
	}

	public function actionMostrar_hechos()
	{
		$valor = $_POST['id_evento'];
		$ConstructorHechos = new ConstructorHechos;
		$reportes = new Reportes;
		
			$sql = "SELECT ed.id_evento_detalle, ed.id_hecho_denuncia, ed.fecha_evento, ed.hora_evento, ed.atributos 
				FROM sipol.tbl_evento_detalle ed
				where id_evento = '".$valor."';";
			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach ($resultado as $value) 
			{
				if(!empty($value['id_hecho_denuncia']))
				{
					$id_evento_detalle = $value['id_evento_detalle'];
					$nombreHecho = $value['id_hecho_denuncia'];
					$nombreHecho = $ConstructorHechos->nombreHechoExt($nombreHecho);
					$fechaHecho = $value['fecha_evento'];
					$horaHecho = $value['hora_evento'];
					$detalles = $value['atributos'];
					$detalles = $ConstructorHechos->explotaJsonGuion($detalles);
					$idTipoHecho = $reportes->getHechoId($id_evento_detalle);
					$cerrar = "<button id='eliminar_hecho' type='button' class='BotonClose eliminar_hecho hechosButtons' id_evento_detalle='".$id_evento_detalle."'><i class='icon-trash'></i></button>";
					//$cerrar = "<button id='eliminar_hecho' type='button' class='close eliminar_hecho' data-dismiss='alert' id_evento_detalle='".$id_evento_detalle."'><i class='icon-trash'></i></button>";
					$editBtn = "<button type='button' class='BotonClose editFact hechosButtons' id_evento_detalle='".$id_evento_detalle."' id_hecho='".$idTipoHecho."'><i class='icon-pencil'></i></button>";

					//echo $id_evento_detalle;
					echo "<div class='well well-small' id='hechoDiv".$id_evento_detalle."'>";
					//echo $cerrar;
					echo "<legend class='legend'><h5 style='line-height:10px;'>".$nombreHecho.$editBtn.$cerrar."</h5></legend>";
					echo "Fecha del hecho: ".$fechaHecho;
					echo " - hora: ".$horaHecho;
					echo "<br>";
					$detalles = str_replace('_',' ',$detalles);
					print_r($detalles);
					echo "</div>";
				}//fin del la condición
			}//fin del foreach
	}

	public function actionEliminar_hecho()
	{
		$id_eliminar = $_POST['id_eliminar'];

		$m_evento_det = new TblEventoDetalle;
		$m_evento_det->findByPk($id_eliminar)->delete();

	}

	public function actionSave_Relato()
	{
		$encripta = new Encrypter;
		$id_denuncia = $_POST['id_denuncia'];
		$relato = $_POST['relato'];



		$relatoClean = str_replace("&nbsp;", "", $relato);
		

		$relatoClean = strtoupper($relatoClean);
		$busca = array('á','é','í','ó','ú');
		$reemplaza = array('Á','É','Í','Ó','Ú');
		$relatoClean  = str_replace($busca,$reemplaza,$relatoClean);
		
		$relato = $encripta->encrypt($relato);
		$objetos = $_POST['objetos'];
		$destinatario = $_POST['destinatario'];
		$destinatario = str_replace(array("\r\n", "\r", "\n"), "<br>",$destinatario);

		$jsonSave = '{"Relato":"'.$relato.'","Destinatario":"'.$destinatario.'"}';

		$command = Yii::app()->db->createCommand();
		$relatoSave = $command->update('sipol.tbl_evento',
			array('relato_denuncia'=>$jsonSave,
					'relato'=>$relatoClean,
			),
				'id_evento=:id',array(':id'=>$id_denuncia)
		);
	}

	public function actionShow_Resumen()
	{
		$this->renderPartial('_resumen');
	}

	public function actionUpdate_hecho()
	{
		$idEventoDetalle = $_POST['idEventoDetalle'];
		$reportes = new Reportes;

		$atributosHechos = json_encode($reportes->getAtributrosHecho($idEventoDetalle));

		print_r($atributosHechos);
	}



/* ******************* VISTAS PARA PRUEBAS ******************* */
	public function actionPruebas()
	{
		$this->render('pruebas');
	}

	public function actionPersona()
	{
		$this->render('_index_persona');
	}

	public function actionExplota()
	{
		$this->render('persona/explota_renap');
	}

	public function actionMapa()
	{
		$this->render('_map');
	}

	public function actionHechos()
	{
		$this->render('_hechos');
	}

	public function actionRelato()
	{
		$this->render('_relato');
	}

	public function actionInstanciar()
	{
		$json = '{"campo1": "JUAN","campo2": "FERNANDO","campo3": "SANCHEZ","campo4": "VILLATORO"}';

		$json = json_decode($json);
		
		print_r($json);
	}

	public function actionHechosConstru()
	{
		$this->render('constructor_hechos');
	}

	public function actionResumen()
	{
		$this->render('_resumen');
	}

/* ******************* FIN VISTAS PARA PRUEBAS ******************* */

}
