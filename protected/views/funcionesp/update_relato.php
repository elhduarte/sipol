<?php

	$decrypt = new Encrypter;
	$sql = "SELECT id_evento, relato_denuncia 
			FROM sipol.tbl_evento 
			--WHERE estado = TRUE 
			--AND id_tipo_evento = 1 
			WHERE relato_denuncia IS NOT NULL;";
	$resultado = Yii::app()->db->createCommand($sql)->queryAll();
	$relato = "";
	$commando = Yii::app()->db->createCommand();

	foreach ($resultado as $key => $value) {

		$relato = json_decode($value['relato_denuncia']);
		if(!empty($relato)){
			$relato = $relato->Relato;
			if(!empty($relato)){
				$relato = $decrypt->decrypt($relato);
				$relato = strip_tags(str_replace("&nbsp", "", $relato));



			$update_relato = $commando->update('sipol.tbl_evento', 
								array('relato'=>$relato),
								'id_evento=:id',array(':id'=>$value['id_evento'])
								);

				echo $value['id_evento']." -- ";
				print_r($relato);
				echo "<br>";
				echo "<br>";
			}
		}

		
		
	}

	//var_dump($resultado);

?>