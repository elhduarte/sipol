<?php session_start(); ?>
<h1>Variables de Session para el sistema</h1>
Variable id de Usuario Base de datos: <?php if(isset($_SESSION['ID_USUARIO'])){	echo "<b>".$_SESSION['ID_USUARIO']."</b>"; echo "<br>";}else{	echo "<b>Variable no Esta Instanciada</b>";echo "<br>";}?>
Variable ID_ROL de Usuario Base de datos: <?php if(isset($_SESSION['ID_ROL_SIPOL'])){	echo "<b>".$_SESSION['ID_ROL_SIPOL']."</b>"; echo "<br>";}else{ echo "<b>Variable no Esta Instanciada</b>";echo "<br>";}?>
Variable notificaciones de session de estado mensaje: <?php if(isset($_SESSION['notificacion'])){	echo "<b>".$_SESSION['notificacion']."</b>"; echo "<br>";}else{ echo "<b>Variable no Esta Instanciada</b>";echo "<br>";}?>

<?php 
//session_unset();
 ?>
