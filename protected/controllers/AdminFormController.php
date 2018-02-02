<?php
class AdminFormController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionNuevoCatalogo()
	{
		$this->render('newCat');
	}
public function actionComisarias()
	{
		$this->render('comisarias');
	}
public function actionEditar()
	{
		$this->render('editar');
	}
	public function actionFiltro()
	{

		
			$this->renderPartial('admin2');
		
	}

	public function actionAdminComisarias()
	{
		$this->render('admincomisarias');
	}

	public function actionGetForm()
	{
		$this->renderPartial('inputType');
	}

	public function actionInputType()
	{
		$this->render('inputType');
	}
	public function actionUpdateSede()
	{

		 	$id_cat_entidad= $_POST['entidad'];
          	$id_tipo_sede= $_POST['tipo_sede'];
          	$cod_depto= $_POST['depto'];
          	$cod_mupio= $_POST['mupio'];
          	$nombre= $_POST['nombresede'];
          	$referencia= $_POST['referencia'];
          	$id_sede= $_POST['id_sede'];
	$commando = Yii::app()->db->createCommand();
          		$update_persona = $commando->update('catalogos_publicos.tbl_sede', 
							array(	'id_cat_entidad'=>$id_cat_entidad,
									'id_tipo_sede'=>$id_tipo_sede,
									'cod_depto'=>$cod_depto,
									//'caracteristicas'=>$caracteristicas_fisicas,
									'cod_mupio'=>$cod_mupio,
									'nombre'=>$nombre,
									'referencia'=>$referencia,
									),
							'id_sede=:id',array(':id'=>$id_sede)
							);



	}
	public function actionSaveSede()
	{
	
          	$entidad= $_POST['entidad'];
          	$tipo_sede= $_POST['tipo_sede'];
          	$depto= $_POST['depto'];
          	$mupio= $_POST['mupio'];
          	$nombresede= $_POST['nombresede'];
          	$referencia= $_POST['referencia'];

			$sede = new TblSede;
			$sede->attributes=array('id_cat_entidad'=>$entidad,
									'id_tipo_sede'=>$tipo_sede,
									'cod_depto'=>$depto,
									'cod_mupio'=>$mupio,
									'nombre'=>$nombresede,
									'referencia'=>$referencia,
									
								);
			$sede->save();
			$nombre_sede = $sede->nombre;
				
		echo 'Se Insertó Con Exito: '.$nombre_sede;
	}
	public function actionSaveCampo()
	{
		$tipo = $_POST['tipo'];
		$ConstructorJson = new ConstructorJson;
		$json = "";
		$idTabla = $_POST['idTabla'];
		$modelo = $_POST['modelo'];
		$params = json_decode($ConstructorJson->getTabla($modelo));
		$tabla = $params->tabla;
		$key = $params->key;

		$columna = $ConstructorJson->getEmptyColumn($idTabla,$tabla,$key);

		switch ($tipo) 
		{
			case 'input':
				$json = $ConstructorJson->ConstruyeInput(
					$_POST['activado'],
					$_POST['id'],
					$_POST['name'],
					$_POST['type'],
					$_POST['placeholder'],
					$_POST['required'],
					$_POST['sizeMax'],
					$_POST['sizeMin']);
				break;

			case 'textarea':
				$json = $ConstructorJson->ConstruyeTextarea(
					$_POST['activado'],
					$_POST['id'],
					$_POST['name'],
					$_POST['filasNum'],
					$_POST['placeholder'],
					$_POST['required'],
					$_POST['sizeMax'],
					$_POST['sizeMin']);
			break;

			case 'button':
				$json = $ConstructorJson->ConstruyeButton(
					$_POST['personaJuridica'],
					$_POST['activado'],
					$_POST['name'],
					$_POST['id'],
					$_POST['required'],
					$_POST['fisicas'],
					$_POST['contact']);
				break;

			case 'select':
				$json = $ConstructorJson->ConstruyeSelect(
					$_POST['activado'],
					$_POST['name'],
					$_POST['id'],
					$_POST['required'],
					$_POST['opciones']);
				break;
		}


		$command = Yii::app()->db->createCommand();
		$guardarCampo = $command->update($tabla,
		array($columna=>$json),
			$key.'=:id',array(':id'=>$idTabla)
		);

		$this->renderPartial('ordenar',array('idTabla'=>$idTabla,'modelo'=>$modelo));

		//echo $columna."-".$json;
		//echo $columna;
	}

	public function actionOrdenar()
	{
		$idTabla = "37";
		$modelo = "CatHechoDenuncia";
		
		$this->render('ordenar',array('idTabla'=>$idTabla,'modelo'=>$modelo));
	}

	public function actionPreview()
	{	
		$idTabla = $_POST['idTabla'];
		$modelo = $_POST['modelo'];
		
		#$idTabla = '37';
		#$modelo = 'CatHechoDenuncia';

		$this->renderPartial('preview',array('idTabla'=>$idTabla,'modelo'=>$modelo));
	}

	public function actionOptionSeccion()
	{
		$idTipoEvento = $_POST['evento'];
		$secciones = CHtml::tag('option', array('value'=>'','style'=>'display:none;'),CHtml::encode('Seleccione una Sección'),true);

		switch ($idTipoEvento) {
			case '1':
				$secciones = $secciones.CHtml::tag('option', array('value'=>'hechos'),CHtml::encode('Plantilla'),true);
				break;
			case '2':
				$secciones = $secciones.CHtml::tag('option', array('value'=>'tipo'),CHtml::encode('Tipo de Consignado'),true);
				$secciones = $secciones.CHtml::tag('option', array('value'=>'motivo'),CHtml::encode('Motivo de Consignación'),true);
				$secciones = $secciones.CHtml::tag('option', array('value'=>'lugar'),CHtml::encode('Lugar de Remisión'),true);
				break;
			case '6':
				$secciones = $secciones.CHtml::tag('option', array('value'=>'objetos'),CHtml::encode('Plantilla'),true);
				break;
		}

		echo $secciones;
	}

	public function actionOptionPadres()
	{
		$idTipoEvento = $_POST['evento'];
		$seccion = $_POST['seccion'];
		$d = "nulo|~|";
		$secciones = CHtml::tag('option', array('value'=>'','style'=>'display:none;'),CHtml::encode('Seleccione una opción'),true);

		switch ($idTipoEvento) {
			case '1':
				if($seccion == 'hechos'){
					$a = "Tipo de Hecho";
					$CatHechoTipo = new CatHechoTipo;
					$d = $CatHechoTipo->getHechosTipo();
					$d = $a."|~|".$d;
				}

				break;

			case '2':
				if($seccion == "motivo"){
					$a = "Tipo de Consignado";
					$CatConsignados = new CatConsignados;
					$d = $CatConsignados->getConsignados();
					$d = $a."|~|".$d;
				}

				break;
		}

		echo $d;
	}

	public function actionValidarCampo()
	{
		$idTipoEvento = $_POST['evento'];
		$seccion =  $_POST['seccion'];
		$nombreCampo = $_POST['nombreCampo'];
		$tabla = "";

		switch ($idTipoEvento) {
			case '1':
				if($seccion == 'hechos'){
					$tabla = "sipol_catalogos.cat_hecho_denuncia";
					$sql = "SELECT nombre_hecho FROM ".$tabla." WHERE nombre_hecho LIKE '".$nombreCampo."'";
					$result = Yii::app()->db->createCommand($sql)->queryAll();
					if(count($result) == 0){
						$tabla = "1";
					}
				}	
				break;

			case '2':
				switch ($seccion) {
					case 'tipo':
						$tabla = "sipol_catalogos.cat_consignados";
						$sql = "SELECT nombre_consignado FROM ".$tabla." WHERE nombre_consignado LIKE '".$nombreCampo."'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						if(count($result) == 0){
							$tabla = "1";
						}
						break;
					
					case 'motivo':
						$tabla = "sipol_catalogos.cat_motivo_consignados";
						$sql = "SELECT nombre_motivo_consignados FROM ".$tabla." WHERE nombre_motivo_consignados LIKE '".$nombreCampo."'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						if(count($result) == 0){
							$tabla = "1";
						}
						break;

					case 'lugar':
						$tabla = "sipol_catalogos.cat_lugar_remision";
						$sql = "SELECT nombre_lugar FROM ".$tabla." WHERE nombre_lugar LIKE '".$nombreCampo."'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						if(count($result) == 0){
							$tabla = "1";
						}
						break;
				}

				break;

			case '3':
				if($seccion == 'objetos'){
					$tabla = "sipol_catalogos.cat_extravios";
					$sql = "SELECT nombre_extravio FROM ".$tabla." WHERE nombre_extravio LIKE '".$nombreCampo."'";
					$result = Yii::app()->db->createCommand($sql)->queryAll();
					if(count($result) == 0){
						$tabla = "1";
					}
				}
				break;
		}//Fin de la condición de $idTipoEvento

		echo $tabla;
	}

	public function actionAddForm()
	{
		$idTipoEvento = $_POST['evento'];
		$seccion = $_POST['seccion'];
		$idPadre = $_POST['padre'];
		$nombreCampo = $_POST['nombreCampo'];

		switch ($idTipoEvento) {
			case '1':
				if($seccion == 'hechos'){

					$nombreModelo = 'CatHechoDenuncia';
					$modelo = new $nombreModelo;
					$modelo->attributes=array(
											'id_hecho_tipo'=>$idPadre,
											'nombre_hecho'=>$nombreCampo
											);
					$modelo->save();
					$return = $modelo->id_hecho_denuncia;
				}	
				break;
/*
			case '2':
				switch ($seccion) {
					case 'tipo':
						$tabla = "sipol_catalogos.cat_consignados";
						$sql = "SELECT nombre_consignado FROM ".$tabla." WHERE nombre_consignado LIKE '".$nombreCampo."'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						if(count($result) == 0){
							$tabla = "1";
						}
						break;
					
					case 'motivo':
						$tabla = "sipol_catalogos.cat_motivo_consignados";
						$sql = "SELECT nombre_motivo_consignados FROM ".$tabla." WHERE nombre_motivo_consignados LIKE '".$nombreCampo."'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						if(count($result) == 0){
							$tabla = "1";
						}
						break;

					case 'lugar':
						$tabla = "sipol_catalogos.cat_lugar_remision";
						$sql = "SELECT nombre_lugar FROM ".$tabla." WHERE nombre_lugar LIKE '".$nombreCampo."'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						if(count($result) == 0){
							$tabla = "1";
						}
						break;
				}

				break;30290940  
			case '3':
				if($seccion == 'objetos'){
					$tabla = "sipol_catalogos.cat_extravios";
					$sql = "SELECT nombre_extravio FROM ".$tabla." WHERE nombre_extravio LIKE '".$nombreCampo."'";
					$result = Yii::app()->db->createCommand($sql)->queryAll();
					if(count($result) == 0){
						$tabla = "1";
					}
				}
				break;*/
		}//Fin de la condición de $idTipoEvento
		echo $return."|~|".$nombreModelo;
	}

	public function actionSortCampos()
	{
		$ConstructorJson = new ConstructorJson;
		$ordanamiento = $_POST['query'];
		$ordanamiento =  str_replace(",&", "", $ordanamiento);

		$idTabla = $_POST['idTabla'];
		$modelo = $_POST['modelo'];
		$params = json_decode($ConstructorJson->getTabla($modelo));
		$tabla = $params->tabla;
		$key = $params->key;

		$query ="UPDATE ".$tabla." SET ".$ordanamiento." WHERE ".$key." = ".$idTabla;
		$resultado = Yii::app()->db->createCommand($query)->execute();

		echo $query;
	}

	public function actionValidarPalabra()
	{
		$idTipoEvento = $_POST['evento'];
		$seccion =  $_POST['seccion'];
		$nombreCampo = $_POST['nombreCampo'];
		$tabla = "";
		$coincidencia = '<h5>Existen catalogos similares en Base de Datos...</h5>';
		$count = 1;

		switch ($idTipoEvento) {
			case '1':
				if($seccion == 'hechos'){
					$tabla = "sipol_catalogos.cat_hecho_denuncia";
					$sql = "SELECT nombre_hecho FROM ".$tabla." WHERE nombre_hecho iLIKE '%".$nombreCampo."%'";
					$result = Yii::app()->db->createCommand($sql)->queryAll();
					$countResult = count($result);
					if($countResult !== 0)
					{
						foreach ($result as $key => $value) {
							$value = (object) $value;
							$coincidencia = $coincidencia.$value->nombre_hecho;
							if($count !== $countResult) $coincidencia = $coincidencia.', ';
							$count = $count+1;
						}
					}
					else{
						$coincidencia = "empty";
					}
				}	
				break;

			case '2':
				switch ($seccion) {
					case 'tipo':
						$tabla = "sipol_catalogos.cat_consignados";
						$sql = "SELECT nombre_consignado FROM ".$tabla." WHERE nombre_consignado iLIKE '%".$nombreCampo."%'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						$countResult = count($result);
						if($countResult !== 0)
						{
							foreach ($result as $key => $value) {
								$value = (object) $value;
								$coincidencia = $coincidencia.$value->nombre_hecho;
								if($count !== $countResult) $coincidencia = $coincidencia.', ';
								$count = $count+1;
							}
						}
						else{
							$coincidencia = "empty";
						}
						break;
					
					case 'motivo':
						$tabla = "sipol_catalogos.cat_motivo_consignados";
						$sql = "SELECT nombre_motivo_consignados FROM ".$tabla." WHERE nombre_motivo_consignados iLIKE '%".$nombreCampo."%'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						$countResult = count($result);
						if($countResult !== 0)
						{
							foreach ($result as $key => $value) {
								$value = (object) $value;
								$coincidencia = $coincidencia.$value->nombre_hecho;
								if($count !== $countResult) $coincidencia = $coincidencia.', ';
								$count = $count+1;
							}
						}
						else{
							$coincidencia = "empty";
						}
						break;

					case 'lugar':
						$tabla = "sipol_catalogos.cat_lugar_remision";
						$sql = "SELECT nombre_lugar FROM ".$tabla." WHERE nombre_lugar iLIKE '%".$nombreCampo."%'";
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						$countResult = count($result);
						if($countResult !== 0)
						{
							foreach ($result as $key => $value) {
								$value = (object) $value;
								$coincidencia = $coincidencia.$value->nombre_hecho;
								if($count !== $countResult) $coincidencia = $coincidencia.', ';
								$count = $count+1;
							}
						}
						else{
							$coincidencia = "empty";
						}
						break;
				}

				break;

			case '3':
				if($seccion == 'objetos'){
					$tabla = "sipol_catalogos.cat_extravios";
					$sql = "SELECT nombre_extravio FROM ".$tabla." WHERE nombre_extravio iLIKE '%".$nombreCampo."%'";
					$result = Yii::app()->db->createCommand($sql)->queryAll();
					$countResult = count($result);
					if($countResult !== 0)
					{
						foreach ($result as $key => $value) {
							$value = (object) $value;
							$coincidencia = $coincidencia.$value->nombre_hecho;
							if($count !== $countResult) $coincidencia = $coincidencia.', ';
							$count = $count+1;
						}
					}
					else{
						$coincidencia = "empty";
					}
				}
				break;
		}//Fin de la condición de $idTipoEvento

		echo $coincidencia;
	}

	public function actionAdmin()
	{
		if(isset($_POST['band']))
		{
			$this->renderPartial('admin2');
		}
		else
		{
			$this->render('admin');
		}
	}   


}

?>