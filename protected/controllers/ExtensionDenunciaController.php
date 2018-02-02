<?php

class ExtensionDenunciaController extends Controller
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
		 array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 	'actions'=>array('nuevaExtension','saveRelato','resumenExtension'),
		 	'users'=>array('oficinista','root','developer','supervisor_comisaria'),
		 	),

		 array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 	'actions'=>array('pruebas','hechos','soloCommit'),
		 	'users'=>array('developer'),
		 	),

		 array('deny', // deny all users
		 	'users'=>array('*'),
		 	),


		 );
	}

	public function actionResumenExtension()
	{
		$this->renderPartial('commit');
	}

	public function actionSoloCommit()
	{
		$this->render('commit');
	}

	public function actionNuevaExtension($id)
	{
		//$idEvento = "ojoqtfuntfun";
		$idEvento=$id;
		$Encrypter = new Encrypter;
		$idLimpio = $Encrypter->descompilarget($idEvento);

		$this->render('nuevaExtension', array('idEvento'=>$idLimpio));
	}

	public function actionHechos()
	{
		$this->render('hechos');
	}

	public function actionPruebas()
	{
		$this->render('prueba');
	}


	public function actionSave_Relato()
	{
		$modelo_evento = new mTblEvento;
		$encripta = new Encrypter;
		$id_denuncia = $_POST['id_denuncia'];
		$relato = $_POST['relato'];
		$relato = $encripta->encrypt($relato);
		$objetos = $_POST['objetos'];
		$jsonSave = '{"Relato":"'.$relato.'","Objetos":'.$objetos."}";
		$modelo_evento->save();
		$id_denuncia_nueva = $modelo_evento->id_evento;
		session_start();
		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario_viene = $variable_datos_usuario[0]->id_usuario;
		$comisaria = $variable_datos_usuario[0]->id_comisaria;
		$sql = "UPDATE  sipol_2.tbl_evento   SET  id_evento_extiende = ".$id_denuncia .",id_usuario = ".$id_usuario_viene.", id_comisaria = ".$comisaria.", id_tipo_evento = 1, estado = false  WHERE id_evento =".$id_denuncia_nueva.";";
		$resultado = Yii::app()->db->createCommand($sql)->execute();
		$command = Yii::app()->db->createCommand();
		$relatoSave = $command->update('sipol_2.tbl_evento',
			array('relato_denuncia'=>$jsonSave,
				),
			'id_evento=:id',array(':id'=>$id_denuncia_nueva)
			);
		echo $id_denuncia_nueva;
	}

	public function actionSaveRelato()
	{
		$TblEvento = new TblEvento;
		$Encrypter = new Encrypter;
		$idEvento = $_POST['id_denuncia'];
		//$relato = $Encrypter->encrypt($_POST['relato']);
		$relato = $_POST['relato'];
		
		$destinatario = $_POST['destinatario'];
		$objetos = $_POST['objetos'];
		$hoy = 	date("Y-m-d");
		$hora = date("H:i:s");
		$hora = "{".$hora."}";
		$month = date("m");
		$year = date("y");

/////
//formato a relato
$relatoClean = str_replace("&nbsp;", "", $relato);
$relatoClean = strtoupper($relatoClean);
$busca = array('á','é','í','ó','ú');
$reemplaza = array('Á','É','Í','Ó','Ú');
$relatoClean  = str_replace($busca,$reemplaza,$relatoClean);
$relato = $Encrypter->encrypt($relato);
$objetos = $_POST['objetos'];
$destinatario = str_replace(array("\r\n", "\r", "\n"), "<br>",$destinatario);
//Fin formato a realato

		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario_viene = $variable_datos_usuario[0]->id_usuario;
		$id_sede = $variable_datos_usuario[0]->id_sede;

		$jsonSave = '{"Relato":"'.$relato.'","Objetos":'.$objetos.', "Destinatario":"'.$destinatario.'"}';

		$TblEvento->attributes = array(
			'id_tipo_evento'=>'4',
			'relato_denuncia'=>$jsonSave,
			'estado'=>'0',
			'fecha_ingreso'=>$hoy,
			'hora_ingreso'=>$hora,
			'relato'=>$relatoClean,
			'id_usuario'=>$id_usuario_viene,
			'id_sede'=>$id_sede,
			'id_evento_extiende'=>$idEvento,

			);

		$TblEvento->save();
		$idEventoExtienede = $TblEvento->id_evento;

		$e = str_pad($id_usuario_viene, 4, "0", STR_PAD_LEFT);
		$i = str_pad($idEventoExtienede, 6, "0", STR_PAD_LEFT);
		$identificador = "04".$month.$year.$e."-".$i;
		$commando = Yii::app()->db->createCommand();
		$evento_num = $commando->update('sipol.tbl_evento', 
			array(
				'evento_num'=>$identificador),
			'id_evento=:id',
			array(':id'=>$idEventoExtienede)
			);

		echo $idEventoExtienede;
	}
	
	public function actionSave_hechos()
	{
		$CorrigeJson = new CorrigeJson;
		$datos_hecho = $_POST['hecho_construido'];
		$fecha = $_POST['fecha'];
		$fecha=date("Y-m-d",strtotime($fecha));
		$hora = $_POST['hora'];
		$id_evento = $_POST['id_denuncia'];
		$id_hecho = $_POST['id_hecho'];
		$IdsPersonas = $_POST['IdsPersonas'];
		$command = Yii::app()->db->createCommand();

		$datos_hecho = $CorrigeJson->nuevoArray($datos_hecho);
		$hora ="{".$hora."}";

		$m_evento_det = new MTblEventoDetalle;
		$m_evento_det->attributes=array(
			'id_hecho'=>$id_hecho,
			'id_evento'=>$id_evento,
				//'novedad_relacionada'=>$inser_novedad,					
			'atributos'=>$datos_hecho,
			'fecha_evento'=>$fecha,
			'hora_evento'=>$hora,
			);
		$m_evento_det->save();
		$id_evento_detalle = $m_evento_det->id_evento_detalle;

		if(!empty($IdsPersonas))
		{
			$upd = "UPDATE sipol_2.tbl_persona_detalle 
			SET id_evento_detalle = ".$id_evento_detalle." 
			WHERE id_persona_detalle IN (".$IdsPersonas.")";

			$resultado = Yii::app()->db->createCommand($upd)->execute();
		}

		echo $id_evento_detalle;

	}

}//Fin de la clase ExtensionDenunciaController

?>