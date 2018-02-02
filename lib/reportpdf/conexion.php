<?php
    define("db", "pti");
    define("user", "hduarte");
    define("password", "hduarte");
    define("host", "192.168.0.218");

    function conectar_bd(){
        $connection = pg_connect("dbname=".db." user=".user." password=".password." host=".host);
        if($connection){
            return $connection;
        }
        else{
            return "fail";
            echo "erro conexion";
        }
    }

  
?>