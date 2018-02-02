<?php

class PjuridicaController extends Controller
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
		 'actions'=>array('AddPersonaIncidencia','Save_PersonaJuridicaDenun','FormResultadoLicencia','SelectNombresLicencia','AddPersonI', 'index','AddPerson','SelectNombres','FormResultado','Save_PersonaJuridica','ListPersonaJuridica','DeletePersona'),
		 'users'=>array('@'),
		 ),
		
		 array('deny', // deny all users
		 'users'=>array('*'),
		 ),
	 );
	}

	public function actionAddPersonaIncidencia()
	{
		$this->render('persona_i');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionAddPerson()
	{
		$this->renderPartial('persona');
	}

	public function actionAddPersonI()
	{
		$this->renderPartial('persona_i');
	}

	public function actionSelectNombres()
	{
		$this->renderPartial('selectNombresRenap');
	}

	public function actionFormResultado()
	{
		$this->renderPartial('formResultado');
	}

	public function actionSelectNombresLicencia()
	{
		$this->renderPartial('licencia/selectNombres');
	}

	public function actionFormResultadoLicencia()
	{
		$this->renderPartial('licencia/formResultado');
	}

	public function actionSave_PersonaJuridica()
	{
			$CorrigeJson = new CorrigeJson;
			$datos_personales = $_POST['datos_personales'];
			$caracteristicas_fisicas = $_POST['caracteristicas_fisicas'];
			$datos_contacto = $_POST['datos_contacto'];
			$llave_renap = $_POST['llave'];
			$cui = $_POST['cui'];
			$foto = $_POST['foto'];
			$id_evento = $_POST['idEvento'];
			$calidadJuridica = $_POST['calidadJuridica'];
			$variablearray = "";
			$resultado = "empty";
			$quienSoy = "empty";
			if(isset($_POST['quienSoy'])) $quienSoy = $_POST['quienSoy'];

			if(!empty($cui))
			{
				$sql = "SELECT id_persona FROM sipol.tbl_persona where cui = '".$cui."';";
				$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			}

			$datos_personales = $CorrigeJson->nuevoArray($datos_personales);
			if(!empty($caracteristicas_fisicas)) $caracteristicas_fisicas = $CorrigeJson->nuevoArray($caracteristicas_fisicas);
			if(!empty($datos_contacto)) $datos_contacto = $CorrigeJson->nuevoArray($datos_contacto);


			if ($resultado !== "empty" && count($resultado) >= 1)//esta condicion evalua si tiene muchas coincidencias dentro de la tabla
			{
				foreach($resultado as $key => $value)
				{
					$variablearray = $value;
				}//este foreach recorre todas las posiciones de queryall
			
				while (list($clave, $valor) = each($variablearray))
				{
					$idPersona = $valor;
				}//este while trae el ultimo registro cuando se encuentran valores repetidos
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
									);
				$m_persona->save();
				$idPersona = $m_persona->id_persona;
			}// fin de la condición

		if($quienSoy == 'pRelacionadas'){

			/*$idEvento = $_POST['idEvento'];*/

			$idEdConsulta = "SELECT id_evento_detalle 
							FROM sipol.tbl_evento_detalle
							WHERE id_evento = ".$id_evento." AND id_hecho_denuncia IS NULL";
			$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

			foreach ($result as $key => $value) {
				foreach ($value as $llave => $valor) {}
			}

			$idEventoDetalle = $valor;

			$m_persona_d = new TblPersonaDetalle;
			$m_persona_d->attributes = array(
					'id_persona'=>$idPersona,
					'id_tipo_persona'=>$calidadJuridica,
					'id_evento_detalle'=>$idEventoDetalle,
					'id_estado_persona'=>$_POST['estadoFisico'],
					);
			$m_persona_d->save();
			$idPersonaDetalle = $m_persona_d->id_persona_detalle;
		}
		else{

			$m_persona_d = new TblPersonaDetalle;
			$m_persona_d->attributes = array(
					'id_persona'=>$idPersona,
					'id_tipo_persona'=>$calidadJuridica,
					);
			$m_persona_d->save();
			$idPersonaDetalle = $m_persona_d->id_persona_detalle;
		}
		
		echo $idPersonaDetalle;
	}

	public function actionSave_PersonaJuridicaDenun()
	{

		$idPersona = $_POST['idDenunciante'];
		$calidadJuridica = $_POST['calidadJuridica'];

		$m_persona_d = new TblPersonaDetalle;
		$m_persona_d->attributes = array(
				'id_persona'=>$idPersona,
				'id_tipo_persona'=>$calidadJuridica,
				);
		$m_persona_d->save();
		$idPersonaDetalle = $m_persona_d->id_persona_detalle;
		
		echo $idPersonaDetalle;

	}

	public function actionListPersonaJuridica()
	{
		$ids = $_POST['IdsPersonas'];
		
		$funciones = new Funcionesp;
		$r = $funciones->ListPersonaJuridica($ids);
		//var_dump($r);
		$a = array();
		echo '<h4>Personas Relacionadas en éste Hecho</h4>';
		foreach ($r as $key => $value) {
			$Primer_Nombre = "";
			$Segundo_Nombre = "";
			$Primer_Apellido = "";
			$Segundo_Apellido = "";
			$DatosDocumento = "";
			$encabezadoNombre = "";
			$counter = "empty";
			$id_persona_detalle = $value['id_persona_detalle'];
			$id_estado_persona = $value['id_estado_persona'];
			$estado_persona = $value['estado_persona'];
			$cerrar = "<button type='button' 
						class='BotonClose eliminar_persona' id_persona_detalle='".$id_persona_detalle."' style='float:right;'><i class='icon-trash'></i></button>";

			$persona = json_decode($value['datos']);
			$persona = (array) $persona;
			$cJuridica = $value['id_tipo_persona'];
			$cJuridica = $funciones->getPersonaJuridica($cJuridica);

			if(!empty($id_estado_persona)){
				$encabezadoNombre = "Calidad Jurídica: <b>".$cJuridica."</b> - Estado Físico: <b>".$estado_persona."</b>";
			}
			else{
				$encabezadoNombre = "Calidad Jurídica: <b>".$cJuridica."</b>";
			}

			if(!empty($persona['Primer_Nombre'])){
				$Primer_Nombre = $persona['Primer_Nombre']; 
				$counter = "counter";	
			} 
			if(!empty($persona['Segundo_Nombre'])){
				$Segundo_Nombre = $persona['Segundo_Nombre']; 
				$counter = "counter";
			} 
			if(!empty($persona['Primer_Apellido'])){
				$Primer_Apellido = $persona['Primer_Apellido'];	
				$counter = "counter";	
			} 
			if(!empty($persona['Segundo_Apellido'])){
				$Segundo_Apellido = $persona['Segundo_Apellido']; 
				$counter = "counter";
			} 
			if(!empty($persona['Tipo_identificacion'])) $DatosDocumento = $persona['Tipo_identificacion'].": ".$persona['Numero_identificacion'];
			
			$nombreConcatenado = $Primer_Nombre." ".$Segundo_Nombre." ".$Primer_Apellido." ".$Segundo_Apellido;

			if($counter == "empty"){
				$nombreConcatenado = "XX (Sin identificar)";
			}
			

			$nombreCompleto = "Nombre completo: <b>".$nombreConcatenado."</b> - Identificación: ".$DatosDocumento;

			echo "<div class='well well-small' id='personaDiv".$id_persona_detalle."'>";
			//echo $cerrar;
			echo "<legend class='legend'><label style='line-height:10px; margin-top:0.5%; font-size: 14px; height: 20px;'>".
			$encabezadoNombre.$cerrar."</label></legend>";
			echo $nombreCompleto;
			echo "</div>";

		}


	}

	public function actionDeletePersona()
	{
		$id_eliminar = $_POST['id_eliminar'];

		$m_persona_d = new TblPersonaDetalle;
		$m_persona_d->findByPk($id_eliminar)->delete();
		echo "lo borró";
	}


}

?>