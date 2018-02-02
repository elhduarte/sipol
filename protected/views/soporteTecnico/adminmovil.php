
<!DOCTYPE html>
<html>
  <head>
  	<div style="background:url(images/header_little.png) top repeat-x">
		<img src="images/logo_mingob.png" alt="">
	</div>
    <title>Admin Movil</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
   <link rel="apple-touch-icon" href="images/iconos/estadistica-sipol.png" />
   <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!-- Bootstrap -->
    
  </head>
  <body>







<?php 

/*
require_once('lib/soap/nusoap.php');
        $cliente = new nusoap_client("http://sistemas.mingob.gob.gt/servicios_mingob/wsMg-dev.php?wsdl", true);
        $err = $cliente->getError();
	if ($err) {	
		echo '{"error_connect":"' . $err . '"}';	
	}
	try
	{
  	$resultado = $cliente->call(
  	           "EnvioSMS",
  	           array(
					"usuario" =>"wsMg",
					"contrasena" =>"W&m2013",
					"celular" => "56931272",
					"mensaje" => "Ticket Nuevo 195. Ingresa: http://172.17.46.77/sipol/index.php?r=soportetecnico/adminmovil"
					)
          );
		  echo $resultado;
        }
        catch(Exception $e)
        {
             print_r($e);
        }
*/

 ?>

	<?php 





			$decrypt = new Encrypter;			
			
	$sql = "select 
ti.id_ticket as numeroticket,
us.primer_nombre||' '||us.segundo_nombre||' '||us.primer_apellido||' '||us.segundo_apellido as usuariosolicita,
e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as nombre_entidad,
us.puesto as puesto,
rol.nombre_rol as nombre_rol,
ti.fecha_ingreso as fechaticket, 
ti.hora_ingreso as horaticket,  
pi.nombre_prioridad as prioridad, 
ti.inconveniente as titulo ,
ti.telefono as telefono
from 
soporte_aplicaciones.tbl_ticket ti,
soporte_aplicaciones.cat_prioridad pi,
sipol_usuario.tbl_usuario us,
sipol_usuario.tbl_rol_usuario rolus,
sipol_usuario.cat_rol rol,
catalogos_publicos.tbl_sede s,
catalogos_publicos.cat_entidad e,
catalogos_publicos.cat_tipo_sede ts
where ti.id_prioridad = pi.id_prioridad
and us.id_usuario = ti.id_usuario
and rolus.id_usuario = us.id_usuario
and rolus.id_rol = rol.id_rol
and s.id_sede = rolus.id_sede
and ts.id_tipo_sede = s.id_tipo_sede
and e.id_cat_entidad = s.id_cat_entidad
order by ti.id_ticket desc
";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		foreach($resultado as $key => $value)
			{



				$conversacion = json_encode($value);
				$conversacion = json_decode($conversacion);
				$chatencriptado = $decrypt->compilarget("'".$conversacion->numeroticket."'");	
				$horaticket = explode(".", $conversacion->horaticket);	

				$colorboton = "";
				if($conversacion->prioridad=="BAJA")
				{

					$colorboton = "btn-primary"; 

				}else 	if($conversacion->prioridad=="MEDIA")
				{

					$colorboton = "btn-success"; 

				}else 	if($conversacion->prioridad=="ALTA")
				{

					$colorboton = "btn-inverse"; 

				}else{
					$colorboton = "btn-danger"; 

				}

				$fecha=date("d-m-Y",strtotime($conversacion->fechaticket));
				echo '<div class="span3 well well-small" >
					<center>
						<blockquote>
							<p>'. $conversacion->nombre_entidad.'/ '. $conversacion->puesto.'</p>
							<small>Usuario:<cite title="Source Title">'.$conversacion->usuariosolicita.'</cite></small>
							<small>'.$fecha.':<cite title="Source Title"> '.$horaticket[0].'</cite></small>
						</blockquote>
								<p><a class="btn btn-large '.$colorboton.'"  href="index.php?r=soporteTecnico/chatmsn&par='.$chatencriptado.'" target="_new">Ver Tiket #'.$conversacion->numeroticket.'</a></p>
						<blockquote>
							<p><small>Telefono:<cite title="Telefono"><a href="tel:'.$conversacion->telefono.'">'.$conversacion->telefono.'</a></cite></small></p>

						</blockquote>
							</center>
								
					</center>
				</div>';


		/*	

echo '<td id="numeroticket">'.$conversacion->numeroticket.'</td>';
echo '<td>'.$conversacion->usuariosolicita.'</td>';
echo '<td>'. $conversacion->nombre_entidad.'</td>';
echo '<td>'. $conversacion->puesto.'</td>';
echo '<td>'.$conversacion->correo.'</td>';
echo '<td>'. $conversacion->fechaticket.'</td>';
$horaticket = explode(".", $conversacion->horaticket);	
echo '<td>'.$horaticket[0].'</td>';
echo '<td>'.$conversacion->aplicacion.'</td>';
echo '<td>'.$conversacion->modulo.'</td>';
echo '<td>'.$conversacion->prioridad.'</td>';
echo '<td>'.$conversacion->titulo.'</td>';
echo '<td>'.$conversacion->telefono.'</td>';
echo '<td><a href="index.php?r=soportetecnico/chat&par='.$chatencriptado.'" target="_new"><button class="btn btn-mini btn-primary" type="button">Chat</button></a></td>';
echo '<td><button  id="terminarchatticket" class="btn btn-mini btn-danger"  onclick="mi_funcion('.$conversacion->numeroticket.')" type="button">Cerrar </button></td>';

echo '<td><a href="index.php?r=soportetecnico/chat&par='.$chatencriptado.'" target="_new"><button class="btn btn-mini btn-success" type="button">Encargado</button></a></td>';

				echo '</tr>';*/
			}

 ?>


    <script src="lib/js/jquery-1.10.2.min.js"></script>
  </body>
</html>



