<?php

class ConstructorJson
{
	public function ConstruyeInput($activado,$id,$name,$type,$placeholder,$required,$sizeMax,$sizeMin)
	{
		$arrayGeneral = array();
		$arrayTipo = array();
		$tipo = "";
		$title = "";
		$pattern = "";
		$class = "";

		switch ($type) {
			case 'dpi':
					$tipo = "text";
					$title = "Ingrese un número de DPI válido, sin guiones ni espacios";
					$class = "span12 validaCampoNumerico";
					$pattern = "[0-9]{13}";
				break;
			case 'email':
					$tipo = "email";
					$title = "";
					$class = "span12";
					$pattern = "";
				break;
			case 'number':
					$tipo = "text";
					$title = "";
					$class = "span12 validaCampoNumerico";
					$pattern = "";
				break;
			case 'url':
					$tipo = "url";
					$title = "";
					$class = "span12";
					$pattern = "";
				break;
			case 'text':
					$tipo = "text";
					$title = "";
					$class = "span12";
					$pattern = "";
				break;
			case 'tel':
					$tipo = "text";
					$title = "Ingrese un número de telefono válido, sin guiones ni espacios";
					$class = "span12 validaCampoNumerico";
					$pattern = "[0-9]{8}";
				break;
		}

		$arrayTipo['indice'] = "input";
		$arrayTipo['type'] = $tipo;
		$arrayTipo['id'] = $id;
		$arrayTipo['name'] = $name;
		$arrayTipo['placeholder'] = $placeholder;
		$arrayTipo['required'] = $required;
		$arrayTipo['class'] = $class;
		$arrayTipo['title'] = $title;
		$arrayTipo['pattern'] = $pattern;
		$arrayTipo['max'] = $sizeMax;
		$arrayTipo['min'] = $sizeMin;

		$arrayGeneral['estado'] = $activado;
		$arrayGeneral['nombre'] = $name;
		$arrayGeneral['catalogo'] = 0;
		$arrayGeneral['tipo'] = $arrayTipo;
		$arrayGeneral['datos'] = '["sin opciones":"Sin opciones"]';

		$retorna = json_encode($arrayGeneral);

		return $retorna;

	}

	public function getEmptyColumn($idTabla,$tabla,$key)
	{
		$resultado = array();

		$sql = "SELECT * FROM ".$tabla." WHERE ".$key." = '".$idTabla."';";
		$consulta = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($consulta as $key => $value) {
			$resultado = $value;
		}

		$devolver = $this->columnNumber($resultado);
		$devolver = "h".$devolver;
		return $devolver;
	}

	public function columnNumber($consulta)
	{
		$contador = 1;
		foreach ($consulta as $key => $value) 
		{
			if($key !== "id_hecho_denuncia" && $key !== "id_hecho_tipo" && $key !== "nombre_hecho" && $key !== "id_extravio" 
				&& $key !== "nombre_extravio" && $key !== "id_cat_consignados" && $key !== "nombre_consignado" 
				&& $key !== "id_motivo_consignados" && $key !== "nombre_motivo_consignados" 
				&& $key !== "id_lugar_remision" && $key !== "nombre_lugar" )
			{
				$exit = json_decode($value);

				if($exit->estado == "0"){
					break;
				}
				else{
					$contador = $contador+1;
				}
			}
		}//Fin del foreach
		
		return $contador;
	}

	public function getTabla($modelo)
	{
		$a = array();
		$schema = "sipol_catalogos.";

		switch ($modelo) {
			case 'CatHechoDenuncia':
				$tabla = 'cat_hecho_denuncia';
				$key = 'id_hecho_denuncia';
				break;

			case 'CatExtravios':
				$tabla = 'cat_extravios';
				$key = 'id_extravio';
				break;
			case 'CatConsignados':
				$tabla = 'cat_consignados';
				$key = 'id_cat_consignados';
				break;

			case 'CatMotivoConsignados':
				$tabla = 'cat_motivo_consignados';
				$key = 'id_motivo_consignados';
				break;
			
			case 'CatLugarRemision':
				$tabla = 'cat_lugar_remision';
				$key = 'id_lugar_remision';
				break;
			
		}// Fin de la condición

		$a['tabla'] = $schema.$tabla;
		$a['key'] = $key;

		$b = json_encode($a);

		return $b;
	}

	public function getCampos($idTabla,$tabla,$key)
	{
		$resultado = array();
		$retorna = "";

		$sql = "SELECT * FROM ".$tabla." WHERE ".$key." = '".$idTabla."';";
		$consulta = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($consulta as $key => $value) {
			$resultado = $value;
		}

		foreach ($resultado as $key => $value) 
		{
			if($key !== "id_hecho_denuncia" && $key !== "id_hecho_tipo" && $key !== "nombre_hecho" && $key !== "id_extravio" 
				&& $key !== "nombre_extravio" && $key !== "id_cat_consignados" && $key !== "nombre_consignado" 
				&& $key !== "id_motivo_consignados" && $key !== "nombre_motivo_consignados" 
				&& $key !== "id_lugar_remision" && $key !== "nombre_lugar" )
			{
				$datos = json_decode($value);

				if($datos->estado == '1') {
					$retorna = $retorna.'<li id="'.$key.'" contenteditable="false">'.$datos->nombre.'</li>';
				}
			}
		} //Fin del foreach

		return $retorna;
	}
}

?>