<?php 
  $tblusuario = new TblUsuario;
  $id_usuario_crea=3;
  $resultadosistemasquery = $tblusuario->consulta_usuario_completo($id_usuario_crea);
  echo '<pre>';
print_r($resultadosistemasquery);
echo '</pre>';
?>




<?php
/*
$dpi = '1912936602207';
$dpi = '2618201920101';
#$dpi = '2081588981401';
#$dpi = '2203233930314';
#$dpi= '2081588981401';
$llave ='001001161682';
$numero ='2081588981401';#Alis
$WSConsulta = new WSConsulta;
$pn = 'alejandra';
$sn = '';
$pa = 'garc_a';
$sa = 'farf_n';


//echo $sa;
$nip = '56524';
$resultado = $WSConsulta->ConsultaPersonalPNC($nip);

$procesa = json_decode($resultado);
echo '<pre>';
print_r($procesa);
echo '</pre>';
*/

?>
<?php
/*
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
									'id_tipo_evento'=>'1',
									'estado' => '0',
									'fecha_ingreso'=>$hoy,
									'hora_ingreso'=>$hora,
									'id_usuario'=>$id_usuario_viene,
									'id_sede'=>$id_sede,
									'ip_guarda'=>'Selmy',
									);
			$m_eventos->save(); // Se guardan los datos en la tabla de eventos
		//	$correl = nextval('sipol.tbl_evento_id_evento_seq'::regclass); //Obtiene el id que se guardó

		$lastId=Yii::app()->db->getLastInsertID('tbl_evento_id_seq');

	echo '<pre>';

	print_r($m_eventos->id_evento);
	echo '</pre>';
*/
?>