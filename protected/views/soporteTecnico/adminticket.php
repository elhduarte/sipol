
<div class="cuerpo">
	<script type="text/javascript">
	$(document).ready(function(){
		$('#resfres').click(function(){
			location.reload();

		});

	});
</script>

<div class="row-fluid">
  <div class="span12">
<legend><img src="images/icons/glyphicons_244_conversation.png" alt=""> Listado de Ticket Activos <img id="resfres" class="pull-right" src="images/icons/glyphicons_229_retweet_2.png" style="height: auto; max-width: 3%; padding-bottom: 50px; " alt=""></legend> 

<div class="row-fluid">
      <div class="span12">

      	<table class="table table-striped">
  <thead>
    <tr>

      <th># Ticket</th>
      <th>Usuario</th>
      <th>Entidad</th>
      <th>Puesto</th>
      <th>Rol</th>
      <th>Fecha</th>
      <th>Hora</th>
      <th>Prioridad</th>
      <th>Titulo</th>
      <th>Telefono</th>
      <th>Chat</th>
    </tr>
  </thead>
  <tbody>    
    	<?php 



    		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario = $variable_datos_usuario[0]->id_usuario;
	echo '<input style="display: none;" type="text" name="usuarioget" id="usuarioget" value="'.$id_usuario.'">';


			$decrypt = new Encrypter;			
			
	$sql = "
select 
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
				//$hora_atencion = explode(".", $conversacion->hora_ingreso);
				$chatencriptado = $decrypt->compilarget("'".$conversacion->numeroticket."'");	
echo '<tr>';
echo '<td id="numeroticket">'.$conversacion->numeroticket.'</td>';
echo '<td>'.$conversacion->usuariosolicita.'</td>';
echo '<td>'. $conversacion->nombre_entidad.'</td>';
echo '<td>'. $conversacion->puesto.'</td>';
echo '<td>'.$conversacion->nombre_rol.'</td>';
echo '<td>'. $conversacion->fechaticket.'</td>';
$horaticket = explode(".", $conversacion->horaticket);	
echo '<td>'.$horaticket[0].'</td>';
echo '<td>'.$conversacion->prioridad.'</td>';
echo '<td>'.$conversacion->titulo.'</td>';
echo '<td>'.$conversacion->telefono.'</td>';
echo '<td><a href="index.php?r=soporteTecnico/chat&par='.$chatencriptado.'" target="_new"><button class="btn btn-mini btn-primary" type="button">Chat</button></a></td>';
echo '<td><button  id="terminarchatticket" class="btn btn-mini btn-danger"  onclick="mi_funcion('.$conversacion->numeroticket.')" type="button">Cerrar </button></td>';
echo '</tr>';
			}

 ?>
  </tbody>
</table>



      </div>
    </div>
  </div>
</div>



<?php echo "
<script>
	function mi_funcion(nuevo)
	{
			var idticket = nuevo;
				var idusuario = $('#usuarioget').val();

		
		$.ajax({
				type:'POST',
				url:'index.php?r=soporteTecnico/terminarchat',
				data:{idticket:idticket,idusuario:idusuario},
				beforeSend:function()
				{

				},
				success:function(response)
				{				
					location.reload();
				},
			});//fin del ajax
			return false;



	}
	


	</script>";;



 ?>
</div>