<?php
$host ="172.21.68.202";
$dbname ="novedades";
$user ="hduarte";
$password ="1234567";

$dbconn = pg_connect("host=$host  dbname=$dbname user=$user password=$password")
 or die('No se ha podido conectar: ' . pg_last_error());

?>