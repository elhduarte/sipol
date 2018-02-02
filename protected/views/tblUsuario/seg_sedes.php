<?php 
$modell = new TblSede;
$nuevo = $modell->loadModel($id_sede);
//print_r($nuevo->attributes['nombre']);
$nombre_sede = $nuevo->attributes['nombre'];
$nombre_referencia = $nuevo->attributes['referencia'];
/*$this->widget('zii.widgets.CDetailView', array(
  'data'=>$nuevo,
  'attributes'=>array(
    'nombre',
    'referencia',
  ),
));*/ 
?>
<div class="alert alert-info">
  <strong>Información!</strong> 
 <blockquote>
  <p>
   El Usuario asignado en la sede: <?php echo $nombre_sede." - ".$nombre_referencia; ?>
   <br>
   En la fecha <?php echo date("d-m-Y H:i:s",strtotime($fecha_inicio));  ?>  Hasta la fecha  <?php echo date("d-m-Y H:i:s",strtotime($fecha_final));  ?>.</p>
  <small>La información de la estadistica  sobre los consumos, esta activa desde marzo del 2014</small>
</blockquote>
</div>
<?php



//echo "La sede es la siguiente:".$id_sede;
/*echo "hola soy el usuario".$id_usuario;
echo "<br>";
//cho date_format("'".$fecha_inicio."'", 'd-m-Y H:i:s');
//$fecha =date("d-m-Y H:i:s",strtotime($fecha_inicio));
//echo $fecha;
echo "<br>";
echo "hola soy la fecha de inicio".$fecha_inicio;
echo "<br>";
echo "hola soy la fecha de final".$fecha_final;
echo "<br>";
echo "hola soy el contador".$contado_asignado;*/

$nombre_div = "contenedor".$contado_asignado;



$inicial =$fecha_inicio;
$final =$fecha_final;

$mensaje_error ="";

		$query ="select * from sipol_usuario.tbl_session_usuario 
			where fecha_ingreso between ('".$inicial."')::TIMESTAMP  and ('".$final."')::TIMESTAMP  AND id_usuario = ".$id_usuario ."";
			
     // echo $query;
      $resul = Yii::app()->db->createCommand($query)->queryAll();
			$con = count($resul);

			$conteo_sistema = $con;


$cuerpo_tabla = "";
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,1, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,2, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,3, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,4, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,5, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,6, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,7, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,8, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,9, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,10, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,11, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,12, $fecha_inicio, $fecha_final);
$cuerpo_tabla .= $modelo->procesar_consumo_servicios($id_usuario,13, $fecha_inicio, $fecha_final);

?>





<?php 

$sql = "select (a.fecha_ingreso)::date as fecha_ingreso, count(a.fecha_ingreso)  from 
sipol_usuario.tbl_session_usuario as a
WHERE a.id_usuario = ".$id_usuario."
AND a.fecha_ingreso between  ('".$inicial."')::date AND ('".$final."')::date
GROUP BY (a.fecha_ingreso)::date 
order by 1 asc";

//echo $sql;





      $resultadoconteovisitas = Yii::app()->db->createCommand($sql)->queryAll();


      $graficausuarios = "[";

      foreach ($resultadoconteovisitas as $key => $value) 
      {
           $primernivelgrafica = json_encode($value);
            $jsonusuariografica = json_decode($primernivelgrafica);
            $fechajson = $jsonusuariografica->fecha_ingreso;
            $fecha_nueva = explode(" ", $fechajson);
            $fechajson = $fecha_nueva[0];
            $fechagrafica = new DateTime($fechajson);
            $conteojson = $jsonusuariografica->count;
            $graficausuarios = $graficausuarios."[".$fechagrafica->getTimestamp()."000,".$conteojson."],";         
      }
        $graficausuarios = $graficausuarios."&]";
        $graficausuarios = str_replace(",&", "", $graficausuarios);

        /*Query que busca el total de visitas en el sistema*/
      $filavisitas = "<table class='table table-striped'><tbody>";
      $sql= "select fecha_ingreso, hora_ingreso  from sipol_usuario.tbl_session_usuario where id_usuario  = ".$id_usuario."
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

     if(count($resultadoconteovisitas)==0)
     {


      $mensaje_error = '
      <div class="alert alert-error">
  <h4>Información</h4>
  El Usuario no tiene ingresos al sistema SIPOL desde la fecha  <strong>'.date("d-m-Y H:i:s",strtotime($inicial)).'</strong></div>';



     }else{

       $mensaje_error ="";


echo "
 <script type='text/javascript'>
$(function() {
    // Create the chart
    var data = $graficausuarios;
    $('#".$nombre_div."').highcharts('StockChart', {
      

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


     }

     ?>





<div class="container-fluid">
  <div class="row-fluid">
    <div class="span6">
            <!--Body content-->
      <?php

echo '<div id="'.$nombre_div.'">'.$mensaje_error .'</div>';

?>
    </div>
    <div class="span6">



  <div class='row-fluid'>
    <div class='span12'>
      <legend>Sistema</legend>  

       <div class='row-fluid'>
            
        <div class='span8'>
                <img src='images/icons/glyphicons_003_user.png'> Sistema
        </div>
              <div class='span2'><span class="label label-inverse"><?php echo $conteo_sistema; ?></span></div> 
        </div>
            <div class='row-fluid'>       
              <div class='span8'>
                <img src='images/icons/glyphicons_065_tag.png'> Sugerencias
              </div>
              <div class='span2'><span class="label label-inverse"><?php echo $conteo_sistema; ?></span></div> 
        </div>
                <div class='row-fluid'>       
              <div class='span8'>
                <img src='images/icons/glyphicons_309_comments.png'> Chat
              </div>
              <div class='span2'><span class="label label-inverse"><?php echo $conteo_sistema; ?></span></div> 
        </div>
        <hr>

        <div class='row-fluid'>
           <div class='span10'>

     <table class='table table-bordered'>  
     <thead>
        <tr>
          <th>Consumo</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
         <?php echo $cuerpo_tabla; ?>
      </tbody>
    </table>
  </div> 

    </div>
      <!--Sidebar content-->
    </div>
    <!--div class='span6'>
      <div class='row-fluid'>
      <div class='span12'>
        <div class='row-fluid'>       
              <div class='span6'>
                <img src='images/icons/glyphicons_003_user.png'> Sistema
              </div>
              <div class='span6'><?php //echo $conteo_sistema; ?></div> 
        </div>

         <div class='row-fluid'>       
              <div class='span6'>
                <img src='images/icons/glyphicons_309_comments.png'> Chat
              </div>
              <div class='span6'>55</div> 
        </div>

          <div class='row-fluid'>       
              <div class='span6'>
                <img src='images/icons/glyphicons_065_tag.png'> Sugerencias
              </div>
              <div class='span6'>6</div> 
        </div>



        <div class='row-fluid'>       
              <div class='span6'>
              <img src='images/icons/glyphicons_355_bullhorn.png'> Denuncias Activas</div>
              <div class='span6'>105</div> 
        </div>

          <div class='row-fluid'>       
              <div class='span6'>
               <img src='images/icons/glyphicons_355_bullhorn.png'> Denuncias Inactivas
               </div>
              <div class='span6'>55</div> 
        </div>

          <div class='row-fluid'>       
              <div class='span6'>
               <img src='images/icons/glyphicons_341_briefcase.png'> Extravios Activos
               </div>
              <div class='span6'>55</div> 
        </div>
         <div class='row-fluid'>       
              <div class='span6'>
               <img src='images/icons/glyphicons_341_briefcase.png'> Extravios Inactivos
               </div>
              <div class='span6'>55</div> 
        </div>
         <div class='row-fluid'>       
              <div class='span6'>
               <img src='images/icons/glyphicons_034_old_man.png'> Incidencias Activas
               </div>
              <div class='span6'>55</div> 
        </div>
         <div class='row-fluid'>       
              <div class='span6'>
               <img src='images/icons/glyphicons_034_old_man.png'> Incidencias Inactivas
               </div>
              <div class='span6'>55</div> 
        </div>



        


      </div>
    </div>

    </div-->
  </div>


      </div>
  </div>
</div>



<hr>


