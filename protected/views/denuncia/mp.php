<h1>Informacion enviada para el MP</h1>
<h3>Esta data sera envia al mp por medio de RabbitMQ</h3>
<h3>Formato tipo Json</h3>
<!--Creado por Lester Gudiel 24-09-2015-->
<?php

//$idEvento = "76081";
//$idEvento = "76010";
//$idEvento = "75908";
$idEvento = $_GET['id'];
		$reportes = new Reportes;
		$decrypt = new Encrypter;
		$encabezado = $reportes->Encabezado($idEvento);
		$denunciante = $reportes->getDenunciante($idEvento);
		$ubicacion = $reportes->getUbicacionDiv($idEvento);
		$hechos = $reportes->getHechosDiv($idEvento);
		$relatoUnificado = $reportes->getRelato($idEvento);
		$relato = $decrypt->decrypt($relatoUnificado['Relato']);
		$objetos = $relatoUnificado['Objetos'];
		$objetos = (!empty($objetos)) ? $reportes->getObjetosDiv($objetos) : "Sin registros";
		$destinatario = $relatoUnificado['Destinatario'];
		$salidamp = array();
		$salidamp[0] = $encabezado;
		$salidamp[1] = $denunciante;
		$salidamp[2] = $ubicacion;
		$salidamp[3] = $hechos;
		$salidamp[4] = $relato;
		$salidamp[5] = $objetos;
		$salidacodificada = json_encode($salidamp);
		$salidacodificada=strip_tags($salidacodificada);
		echo "<prev>";
		print_r($salidacodificada);
		echo "</prev>";
?>