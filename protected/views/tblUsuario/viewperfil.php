
<?php 
if(isset($_GET['perfil']))
{
  $cartausuario = $_GET['perfil'];

  $descompilar = new Encrypter;
  $variableusuario = $descompilar->descompilarget($_GET['perfil']);
  $idusuario = $variableusuario; 


 /*$idusuario = $model->id_usuario; */


 function validarcampo($valor)
 {
  $salida = "";
   if(empty($valor))
      {
         $salida = "Sin Registro"; 
      }else{
          $salida = $valor;
      }
    return $salida;
 }

  function validarestado($valor)
 {
  $salida = "";
   if($valor == "1")
      {
         $salida ='<strong><font color="blue">Activo</font> </strong>';
      }else{
          $salida = '<strong><font color="red">Desactivado</font> </strong>';
      }
    return $salida;
 }
  function validarsexo($valor)
 {
  $salida = "";
   if($valor == "1")
      {
         $salida ='<strong>HOMBRE</strong>';
      }else{
          $salida = '<strong>MUJER</strong>';
      }
    return $salida;
 }
   function validarestadosistema($valor)
 {
  $salida = "";
   if($valor == "1")
      {
         $salida ='<strong><font color="blue">Activo</font> </strong>';
      }else{
          $salida = '<strong><font color="red">Eliminado</font> </strong>';
      }
    return $salida;
 }









/*$sql= "SELECT a.fecha_ingreso, count(*) FROM sipol_usuario.tbl_session_usuario as a, sipol_usuario.tbl_rol_usuario as b, sipol_usuario.tbl_rol as c
WHERE a.id_usuario = b.id_usuario and b.id_rol = c.id_rol and a.id_usuario = ".$idusuario." and a.fecha_ingreso 
BETWEEN CAST ('1970-01-01' AS DATE) AND CAST ( now() AS DATE) GROUP BY a.fecha_ingreso ORDER BY a.fecha_ingreso asc";
*/
$sql ="SELECT (a.fecha_ingreso)::date, count(*) 
FROM 
sipol_usuario.tbl_session_usuario as a, 
sipol_usuario.tbl_rol_usuario as b, 
sipol_usuario.cat_rol as c
WHERE 
a.id_usuario = b.id_usuario 
AND b.id_rol = c.id_rol 
AND a.id_usuario = ".$idusuario." 
AND (a.fecha_ingreso)::date 
BETWEEN CAST ('1970-01-01' AS DATE) AND CAST ( now() AS DATE) 
GROUP BY (a.fecha_ingreso)::date 
ORDER BY (a.fecha_ingreso)::date asc";


      $resultadoconteovisitas = Yii::app()->db->createCommand($sql)->queryAll();
     // var_dump($resultadoconteovisitas);

      $graficausuarios = "[";

      foreach ($resultadoconteovisitas as $key => $value) 
      {
           $primernivelgrafica = json_encode($value);
            $jsonusuariografica = json_decode($primernivelgrafica);
            $fechajson = $jsonusuariografica->fecha_ingreso;
            $fechagrafica = new DateTime($fechajson);
            $conteojson = $jsonusuariografica->count;
            $graficausuarios = $graficausuarios."[".$fechagrafica->getTimestamp()."000,".$conteojson."],";         
        # code...
      }
        $graficausuarios = $graficausuarios."&]";
        $graficausuarios = str_replace(",&", "", $graficausuarios);
      //echo $graficausuarios;


 
/*Query que busca el total de visitas en el sistema*/
      $filavisitas = "<table class='table table-striped'><tbody>";
      $sql= "select fecha_ingreso, hora_ingreso  from sipol_usuario.tbl_session_usuario where id_usuario  = ".$idusuario."
      ORDER BY fecha_ingreso DESC, hora_ingreso DESC limit 10 ";
      $resultado = Yii::app()->db->createCommand($sql)->queryAll();
      $variablearray = "";
      $hora_ingreso_session = array();
      foreach ($resultado as $key => $value) 
      {
          $hora_ingreso_session= explode(".", $value['hora_ingreso']);
          $fecha2=date("d-m-Y",strtotime($value['fecha_ingreso']));
          $filavisitas = $filavisitas." <tr><td>".$fecha2."</td><td>".$hora_ingreso_session['0']."</td></tr>";
      }
      $filavisitas = $filavisitas."</tbody></table>"; 
/*************************************************************************/
/*Query que busca el la informacion de los usuarios*/
      /*$sql= "select a.*, b.departamento as nombredepartamento, b.municipio as nombremunicipio, c.nombre_rol as nombrerol, e.nombre_entidad as nombrecomisaria
from sipol_usuario.tbl_usuario a, dg_pnc_novedades.cat_municipios_333 b, sipol_usuario.tbl_rol c, sipol_usuario.tbl_rol_usuario d, sipol_usuario.tbl_entidad e 
where a.id_usuario = ".$idusuario."
and c.id_rol = d.id_rol
and a.id_usuario = d.id_usuario
and d.id_entidad = e.id_entidad
and b.cod_mupio = a.municipio;";*/

$sql="SELECT 
u.*,
depto.departamento as nombredepartamento,
mupio.municipio as nombremunicipio, 
r.nombre_rol as nombrerol, 
e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as nombrecomisaria
FROM sipol_usuario.tbl_rol_usuario ru
LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
WHERE u.id_usuario = ".$idusuario."";


      $resultado = Yii::app()->db->createCommand($sql)->queryAll();
      $trasfomacionusuario = $resultado[0];
      $trasfomacionusuario = json_encode($trasfomacionusuario);
       $usuariodatos = json_decode($trasfomacionusuario);


  $puesto = $usuariodatos->puesto;
  $usuario = $usuariodatos->usuario;
  $password = $usuariodatos->password;
  $email = $usuariodatos->email;
  $no_oficio_solicitud = $usuariodatos->no_oficio_solicitud;
  $id_usuario_crea = $usuariodatos->id_usuario_crea;
  $fecha_crea = $usuariodatos->fecha_crea;
  $estado = $usuariodatos->estado;
  $primer_nombre = $usuariodatos->primer_nombre;
  $segundo_nombre = $usuariodatos->segundo_nombre;
  $primer_apellido = $usuariodatos->primer_apellido;
  $segundo_apellido = $usuariodatos->segundo_apellido;
  $fecha_nacimiento = $usuariodatos->fecha_nacimiento;
  $dpi = $usuariodatos->dpi;
  $no_orden = $usuariodatos->no_orden;
  $direccion = $usuariodatos->direccion;
  $departamento = $usuariodatos->departamento;
  $municipio = $usuariodatos->municipio;
  $sexo = $usuariodatos->sexo;
  $no_registro = $usuariodatos->no_registro;
  $foto = $usuariodatos->foto;
  $proceso = $usuariodatos->proceso;
  $nombredepartamento = $usuariodatos->nombredepartamento;
   $nombremunicipio = $usuariodatos->nombremunicipio;
    $nombrerol = $usuariodatos->nombrerol;
     $nombrecomisaria = $usuariodatos->nombrecomisaria;


          if(empty($foto))
        {
          $fotografia = "images/noimagen.png";
          
        }
        else
        {
          
          $fotografia = "data:image/jpg;base64,".$foto;
          
        }


/*************************************************************************/

$sqlconteo = "select denuncia_true.denuncia_true,  denuncia_false.denuncia_false, incidencia_true.incidencia_true, incidencia_false.incidencia_false,
extravio_true.extravio_true, extravio_false.extravio_false
from (select count(*)denuncia_true from sipol.tbl_evento where id_usuario = ".$idusuario." and id_tipo_evento = 1 and estado = 't') denuncia_true,
(select count(*) denuncia_false from sipol.tbl_evento where id_usuario = ".$idusuario." and id_tipo_evento = 1 and estado = 'f')  denuncia_false,
(select count(*)incidencia_true from sipol.tbl_evento where id_usuario = ".$idusuario." and id_tipo_evento = 2 and estado = 't')  incidencia_true,
(select count(*) incidencia_false from sipol.tbl_evento where id_usuario = ".$idusuario." and id_tipo_evento = 2 and estado = 'f')  incidencia_false,
(select count(*) extravio_true from sipol.tbl_evento where id_usuario = ".$idusuario." and id_tipo_evento = 3 and estado = 't')  extravio_true,
(select count(*) extravio_false from sipol.tbl_evento where id_usuario = ".$idusuario." and id_tipo_evento = 3 and estado = 'f')  extravio_false;";
  $resultadoconteo = Yii::app()->db->createCommand($sqlconteo)->queryAll();

  //var_dump($resultadoconteo);

  $trasresultadoconteo = $resultadoconteo[0];

      $trasresultadoconteo = json_encode($trasresultadoconteo);
       $conteoevento = json_decode($trasresultadoconteo);
    //   var_dump($conteoevento);

  $denuncia_true=$conteoevento->denuncia_true; 
  $denuncia_false=$conteoevento->denuncia_false; 
  $incidencia_true=$conteoevento->incidencia_true; 
  $incidencia_false=$conteoevento->incidencia_false; 
  $extravio_true=$conteoevento->extravio_true; 
  $extravio_false=$conteoevento->extravio_false;



/*
$sqlsistema = "SELECT 
tbl_entidad.nombre_entidad as entidad,
tbl_rol.nombre_rol,
tbl_rol_usuario.id_usuario,
tbl_usuario.primer_nombre || ' ' ||tbl_usuario.segundo_nombre || ' ' ||tbl_usuario.primer_apellido || ' ' ||tbl_usuario.segundo_apellido as nombre_completo,
tbl_entidad.municipio || ',' ||tbl_entidad.departamento as ubicacion
FROM 
sipol_usuario.tbl_rol,
sipol_usuario.tbl_rol_usuario,
sipol_usuario.tbl_usuario,
sipol_usuario.tbl_entidad
WHERE 
tbl_rol.id_rol = tbl_rol_usuario.id_rol
AND tbl_rol_usuario.id_usuario= tbl_usuario.id_usuario
AND tbl_entidad.id_entidad = tbl_rol_usuario.id_entidad 
and tbl_rol_usuario.id_usuario =".$id_usuario_crea."
ORDER BY tbl_rol.id_sistema";*/

$sqlsistema = " SELECT 
e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as entidad,
r.nombre_rol as nombre_rol, 
u.id_usuario,
u.primer_nombre || ' ' || u.segundo_nombre || ' ' || u.primer_apellido || ' ' ||u.segundo_apellido as nombre_completo,
mupio.municipio || ',' ||depto.departamento as ubicacion
FROM sipol_usuario.tbl_rol_usuario ru
LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
WHERE u.id_usuario = ".$id_usuario_crea."";


  $resultadosistemas = Yii::app()->db->createCommand($sqlsistema)->queryAll();

  //var_dump($resultadosistemas);

  $trasresultadosistemas = $resultadosistemas[0];

      $trasresultadosistemas = json_encode($trasresultadosistemas);
       $resultadosistemasquery = json_decode($trasresultadosistemas);
    //   var_dump($resultadosistemasquery);

  $sistemaentidad=$resultadosistemasquery->entidad; 
  $sistemanombre_rol=$resultadosistemasquery->nombre_rol; 
  $sistemaid_usuario=$resultadosistemasquery->id_usuario; 
  $sistemanombre_completo=$resultadosistemasquery->nombre_completo; 
  $sistemaubicacion=$resultadosistemasquery->ubicacion; 


  


 ?>
<style type="text/css">
	.estiloborder
	{

		border: 1px solid #e3e3e3;
		border-top-color: rgb(227, 227, 227);
		border-top-style: solid;
		border-top-width: 1px;
		border-right-color: rgb(227, 227, 227);
		border-right-style: solid;
		border-right-width: 1px;
		border-bottom-color: rgb(227, 227, 227);
		border-bottom-style: solid;
		border-bottom-width: 1px;
		border-left-color: rgb(227, 227, 227);
		border-left-style: solid;
		border-left-width: 1px;
		padding: 5px;
 /*box-shadow: 5px 5px 5px #888888;*/
		/*box-shadow: 5px 5px 5px #888888;*/
	}

	.vista_imagen
{
	margin: 1px;
    width: auto; 
    max-width:50%; 
    border-radius: 15px 15px 15px 15px; 
   
}
.iconos_estadistica
{
	height: auto;
	max-width: 50%;
}

hr{
	margin: 5px 0;
border: 0;
border-top: 1px solid #eee;
border-bottom: 1px solid #fff;

}

footer{
	font:14px/1.3 'Segoe UI',Arial, sans-serif;
	background-color: #FFFFFF;
	bottom: 0;
	box-shadow: 0 -1px 2px rgba(0,0,0,0.4);
	height: 10%;
	left: 0;
	position: fixed;
	width: 100%;
	z-index: 100000;
}









</style>
<div id="personalinformacion">
<div class="row-fluid">
  <div class="span12 cuerpo">
 <legend><img style="padding-top: 0.5%;" src="images/icons/glyphicons_024_parents.png" class="" alt="">  Información de Usuario:  <?php  echo $primer_nombre." ".$segundo_nombre ." ".$primer_apellido ." ".$segundo_apellido;   ?> </legend>
    <div class="row-fluid">
      <div class="span10">    	
 <h4>Información Personal</h4>
 <hr>
      	 <div class="row-fluid">
          <div class="span3  ">
          	<p>
			  <strong>Nombre Completo:</strong><br>
			<?php
      echo $primer_nombre." ".$segundo_nombre ." ".$primer_apellido ." ".$segundo_apellido; 
       ?>
			</p>         
          </div>
           <div class="span2  ">
           	  	<p>
				  <strong>Numero DPI:</strong><br>
				<?php echo validarcampo($dpi); ?>
				</p>           	
           </div>
            <div class="span2 ">
            		<p>
					  <strong>Fecha Nacimiento:</strong><br>            
					<?php 
          $fecha_nacimiento_ingreso = date("d-m-Y H:i:s",strtotime($fecha_nacimiento));
          echo validarcampo($fecha_nacimiento_ingreso); 
          ?>
					</p>        
            </div>
             <div class="span2 ">
            		<p>
					  <strong>Departamento:</strong><br>
            <?php echo validarcampo($nombredepartamento); ?>
					</p>        
            </div>
             <div class="span2 ">
            		<p>
					  <strong>Municipio:</strong><br>
             <?php echo validarcampo($nombremunicipio); ?>
					</p>        
            </div>
            <div class="span1 ">
            		<p>
					  <strong>Genero:</strong><br>
						<?php echo validarsexo($sexo); ?>
					</p>        
            </div>
        </div>
        <hr>
          <div class="row-fluid">
          <div class="span2  ">
          	<p>
			  <strong>No Registro:</strong><br>
        <?php echo validarcampo($no_registro); ?>
			</p>         
          </div>
           <div class="span2  ">
           	  	<p>
				  <strong>No Celular:</strong><br>
				<?php echo validarcampo($no_orden); ?>
				</p>           	
           </div>
            <div class="span8 ">
            		<p>
					  <strong>Direccion:</strong><br>
            <?php echo validarcampo($direccion); ?>
					</p>        
            </div>
          
           
        </div>
      </div>
       <div class="span2">
       <p>
		
     <center><img class="vista_imagen"  src='<?php echo $fotografia; ?>'/></center>
		
		</p> 
       
       
      </div>
    </div>
  </div>
</div>
</div><!--fin de la informacion personal-->
<div class="row-fluid">
  <div class="span12 cuerpo">
    <div class="row-fluid">
      <div class="span12">
      	
 <h4><img style="" src="images/icons/glyphicons_089_building.png"  alt=""> Información Del Sistema </h4>
 <hr>
      	 <div class="row-fluid">
          <div class="span2">
          	<p>
			  <strong>Puesto:</strong><br>
			<?php echo validarcampo($puesto); ?>
			</p>         
          </div>
           <div class="span2">
           	  	<p>
				  <strong>Usuario:</strong><br>
				<?php echo validarcampo($usuario); ?>
				</p>           	
           </div>
            <div class="span2 ">
            		<p>
					  <strong>Correo:</strong><br>
					<?php echo validarcampo($email); ?>
					</p>        
            </div>
             <div class="span2">
            		<p>
					  <strong>Comisaria:</strong><br>
					<?php echo $nombrecomisaria; ?>
					</p>        
            </div>   
              <div class="span2">
            		<p>
					  <strong>No Solicitud:</strong><br>
					<?php echo validarcampo($no_oficio_solicitud); ?>
					</p>        
            </div>     
            <div class="span2">
            		<p>
					  <strong>Fecha Ingreso:</strong><br>
          <?php 
          $fecha_nacimiento_crea = date("d-m-Y H:i:s",strtotime($fecha_crea));
          echo validarcampo($fecha_nacimiento_crea); 
          ?>
					</p>        
            </div>      
        </div>
        <hr>
          <div class="row-fluid">
          <div class="span2">
          	<p>
			  <strong>Estado Del Usuario:</strong><br>
				<?php echo validarestado($estado); ?>
			</p>         
          </div>
           <div class="span2">
           	  	<p>
				  <strong>Tipo de Usuario:</strong><br>
			<?php echo $nombrerol; ?>
				</p>           	
           </div>
           <div class="span2">
           	  	<p>
				  <strong>Estado Del Sistema:</strong><br>
          <?php echo validarestadosistema($proceso); ?>
				</p>           	
           </div>
            <div class="span2">
           	  	<p>
				  <strong>Sistema:</strong><br>
				Sipol
				</p>           	
           </div>
            <div class="span2">
           	  	<p>
				  <strong>Usuario Responsable:</strong><br>    
          <?php echo $sistemanombre_completo; ?>				
				</p>           	
           </div>   
           <div class="span2">
           	  	<p>
				  <strong>Carta de Responsabilidad:</strong><br>
				  <center>
                <?php echo "<a href='index.php?r=tblUsuario/carta&carta=".$cartausuario."' target='_blank'><i class='icon-print'></i></a>"; ?>        
				</center>
				</p>           	
           </div>    
        </div>
      </div>
  
      </div>
    </div>
  </div>

  <div class="row-fluid">
  <div class="span12 cuerpo">
    <div class="row-fluid">
      <div class="span12">
      	
 <h4><img style="" src="images/icons/glyphicons_042_pie_chart.png"  alt=""> Estadistica de Usuario con el Sistema </h4>
 <hr>
      	 <div class="row-fluid">
          <div class="span2">
          	<center>
          	<p>
          		<strong>Activas</strong><br>
				   <img class="iconos_estadistica" src="images/iconos/denuncia.png">
				   <br>	
				  		
				</p>  
        <span class="badge badge-info">  <strong><?php echo $denuncia_true; ?></strong>  </span>    
           
          	</center>      
          </div>
          <div class="span2">
          	<center>
          	<p>
          		<strong>Inactivas</strong><br>
				   <img class="iconos_estadistica" src="images/iconos/denuncia_rojo.png">
				   <br>	
				  			
				</p>   
         <span class="badge badge-info"> <strong><?php echo $denuncia_false; ?></strong>   </span> 
          	 
          	</center>      
          </div>
           <div class="span2">
           	<center>
          	<p>
          		<strong>Activas</strong><br>
				   <img class="iconos_estadistica" src="images/iconos/extravio.png">
				   <br>	
				  			
				</p> 
         <span class="badge badge-info"> <strong><?php echo $extravio_true; ?></strong>  </span>   
           
          	</center>   	
           </div>
            <div class="span2">
           	<center>
          	<p>
          		<strong>Inactivas</strong><br>
				   <img class="iconos_estadistica" src="images/iconos/extravio_rojo.png">
				   <br>	
				   			
				</p>  
        <span class="badge badge-info"> <strong><?php echo $extravio_false; ?></strong>  </span>  
          	  
          	</center>   	
           </div>   
              <div class="span2">
           	<center>
          	<p>
          		<strong>Activas</strong><br>
			
				    <img class="iconos_estadistica" src="images/iconos/incidencia.png"> 
				   <br>	
				  			
				</p>  
         <span class="badge badge-info"> <strong><?php echo $incidencia_true; ?></strong>  </span>  
          	 
          	</center>   	
           </div>   
              <div class="span2">
           	<center>
          	<p>
          		<strong>Inactivas</strong><br>			
				        <img class="iconos_estadistica" src="images/iconos/incidencia_rojo.png"> 
				      <br>					        	
				    </p>   
            <span class="badge badge-info"> <strong><?php echo $incidencia_false; ?></strong> </span>  
            
          	</center>   	
           </div>     


   

    </div>
      </div>
    </div>
  </div>


  <div class="row-fluid">
  <div class="span12 cuerpo">
  	 <h4><img style="" src="images/icons/glyphicons_040_stats.png" class="" alt=""> Grafica de Ingreso Sistema </h4>
<hr>
     <?php 
     if(count($resultadoconteovisitas)==0)
     {
      echo '
      <div class="alert alert-error">
  <h4>Información</h4>
  El Usuario no tiene ingresos al sistema sipol desde  <strong>'.validarcampo($fecha_crea).'</strong></div>';

     }else{

     ?>
    <div class="row-fluid">
	      <div class="span10">

<?php 
echo "
 <script type='text/javascript'>
$(function() {
    // Create the chart
    var data = $graficausuarios;
    $('#container').highcharts('StockChart', {
      

      rangeSelector : {
        selected : 1
      },

      title : {
        text : 'Grafica Ingreso de Usuario '
      },
      
      series : [{
        name : 'Total de Visitas',
        data : data,
        marker : {
          enabled : true,
          radius : 3
        },
        shadow : true,
        tooltip : {
          valueDecimals : 0
        }
      }]
    });
});


    </script>";
 ?>


          <!--script src="lib/highcharts/highcharts.js"></script-->


      <script src="lib/highcharts/Highstock-1.3.5/js/highstock.js"></script>

      <script src="lib/highcharts/Highstock-1.3.5/js/modules/exporting.js"></script>
      <div id="container" style="height: 500px; min-width: 500px"></div>


	      </div><!--fin del modulo de Graficas-->
	      <div class="span2 estiloborder">
	      	<h4>Ultimos 10 Ingresos</h4>
           <?php echo $filavisitas; ?>

            <?php 
              $variablenumeros = new Encrypter;
              $idenvioips = $variablenumeros->compilarget("'".$idusuario."'");
           ?>
            <?php echo "<a target='_blank' href='index.php?r=reportespdf/reportesession&par=".$idenvioips."'>Resumen de Ingresos</a>"; ?>  
	      </div>
     </div>

     <?php
     }

    
     ?>
    </div>
  </div>


<?php


}else{
  echo "lester gudiel 1545";
}
 ?>







  
