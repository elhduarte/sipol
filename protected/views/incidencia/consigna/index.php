esta es la incidencia
<?php 

$este= '{
    "Relato": "Este es el relato  sobre la denuncia en especifico",

    "objetos": [
        {
            "Arma de Fuego": "Este es el texto del arma de fuego",
            "Arma Blanca": "Este es el objeto y la descripcion del arma blanca"
        }
    ]
}';

var_dump($este);
$primera = json_decode($este);
//print_r($primera);

echo $primera->Relato;
echo "<br>";

print_r($primera->objetos);


//$this->renderPartial('vista');
?>