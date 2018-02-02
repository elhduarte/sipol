<div class="alert alert-info">
<b><h4><i class="icon-filter"></i> Descripción Filtros de Busqueda:</h4></b>
<div id="titutlo" style="margin-left: 1.5%;">
        <b>Rango de Fechas </b> 
       <br>
       <b>Ubicación de los Hechos ( </b> Departamento: <i><?php echo $departamento; ?></i>, Municipio: <i><?php echo $municipio; ?></i><b> )</b> 
       <br>
       <b>Lugar de Emisión: ( </b> Region: <i><?php echo $region; ?></i>, Comisaria: <i><?php echo $comisaria; ?></i>, Tipo de Sede: <i><?php echo $tipo_sede; ?></i>, Sede: <i><?php echo $sede; ?></i><b> )</b> 
       <br>
       <b>Tipo de Hecho: </b>
</div>
</div>

<?php 

switch ($tiempo) 
{
        case '1':
           $fecha = date('Y-m-j');
            $fecha_inicio_denuncia = $fecha;    
            $fecha_final_denuncia =$fecha;
            $comisaria_denuncia ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
            break;
        
      case '2':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '3':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '4':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-14 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '5':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '6':
             $fecha = date('Y-m-j');
            $fecha_inicio_denuncia = $fecha;    
            $fecha_final_denuncia =$fecha;
            $comisaria_denuncia ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
}

if($estadofecha=='1')
{
    $fecha_inicio_denuncia = $fechainicio;
    $fecha_final_denuncia = $fechafinal;

}

$departamento_completo="";
switch ($departamento) {
    case 'Todos':
    $departamento_completo="";
        
        break;
    
    default:
     $departamento_completo="AND e.direccion like '%\"Departamento\":\"".$departamento."%'";

        
        break;
}

$municipio_completo="";
switch ($municipio) {
    case 'Todos':
    $municipio_completo="";
        
        break;
       
        case 'Seleccione un Municipio':
    $municipio_completo="";
        
        break;
    
    default:
     $municipio_completo="AND e.direccion LIKE '%\"Municipio\":\"".$municipio."%'";

        
        break;
}

$region_completo="";
switch ($region) {
    case 'Todos':
    $region_completo="";
        
        break;
    
    default:
     $region_completo="AND ce.region = '".$region."'";        
        break;
}

$comisaria_completo="";
switch ($comisaria) {
    case 'Todos':
    $comisaria_completo="";
        
        break;
    
    default:
     $comisaria_completo="AND ce.id_cat_entidad  = ".$comisaria."";        
        break;
}

$tipo_sede_completo="";
switch ($tipo_sede) {
    case 'Todos':
    $tipo_sede_completo="";
        
        break;
    
    default:
     $tipo_sede_completo="AND s.id_tipo_sede = ".$tipo_sede."";        
        break;
}

$sede_completo="";
switch ($sede) {
    case 'Todos':
    $sede_completo="";
        
        break;
    
    default:
     $sede_completo="AND ru.id_sede = ".$sede."";        
        break;
}

$condicion_hechos="";
switch ($tipo_hecho) {
    case 'Todos':
    $condicion_hechos="AND h.id_hecho_denuncia IS NOT NULL";
        
        break;
    
    default:
     $condicion_hechos="AND h.id_hecho_tipo = ".$tipo_hecho."";        
        break;
}



$sql ="SELECT h.nombre_extravio, count(ed.id_evento_detalle) 
FROM sipol.tbl_evento_detalle ed 
LEFT JOIN sipol_catalogos.cat_extravios h ON ed.id_hecho_denuncia = h.id_extravio
WHERE ed.id_evento IN 
(
 SELECT e.id_evento 
 FROM sipol.tbl_evento e, sipol_usuario.tbl_rol_usuario ru, catalogos_publicos.tbl_sede s, catalogos_publicos.cat_entidad ce 
WHERE ru.id_usuario = e.id_usuario 
AND ru.id_sede = s.id_sede 
AND s.id_cat_entidad = ce.id_cat_entidad 
AND e.fecha_ingreso BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia'
AND e.estado = 't'
AND e.id_tipo_evento = 3
". $departamento_completo."   
".$municipio_completo." 
".$region_completo."
".$comisaria_completo."
".$tipo_sede_completo."
".$sede_completo."
) 
AND h.nombre_extravio is not null
 GROUP BY ed.id_hecho_denuncia, h.nombre_extravio";

#echo $sql;

$arrayName = array();
$resultado = Yii::app()->db->createCommand($sql)->queryAll();

#var_dump($resultado);

if(count($resultado)=="0")
{
        echo "<center><div class='page-header'>
  <h3>Información del Sistema! <small>No se tienen Graficas Registradas...</small></h3>
</div></center>";


}else{
//var_dump($resultado);
$catalogos ="[";
$serie = "[";

$tablaextravio = "<legend>Tabla Extravio</legend><table class='table table-hover'>
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Conteo</th>
    </tr>
  </thead>
  <tbody>";

          $cabezatabla = "";
    
        $cabezatabla = $cabezatabla."</tbody></table>";


$seriegrafica = "[";
foreach ($resultado as $key => $value) {

$catalogos  = $catalogos ."'".$value['nombre_extravio']."',";

$serie = $serie. "{
                name: '".$value['nombre_extravio']."',
                data: [".$value['count']."]    
            },";
        $seriegrafica = $seriegrafica."".$value['count'].",";

            $tablaextravio = $tablaextravio."<tr class='lisextravio' nomhecho='".$value['nombre_extravio']."'><td>".$value['nombre_extravio']."</td><td>".$value['count']."</td><tr>";

   
   
}
 $tablaextravio = $tablaextravio."</tbody></table>";


$catalogos = $catalogos."]";
$serie = $serie."]";
$seriegrafica =$seriegrafica. "]";



?>

<script type='text/javascript'>
$( document ).ready(function() {

    console.log(<?php echo $catalogos; ?>);
$(function () {
        $('#extraviografica').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Extravios Registrados'
            },
            subtitle: {
                text: 'Sistema De Información Policial'
            },
            xAxis: {
                categories: <?php echo $catalogos; ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cantidad'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0

                }
            },
            series:<?php echo $serie; ?>
        });
    });
console.log(<?php echo $seriegrafica; ?>);

$(function () {
        $('#divprueba').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: 'Extravios Registrados'
            },
            xAxis: {
                categories: <?php echo $catalogos; ?>,
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cantidad de Extravios'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Extravios SIPOL</b>',
            },
            series: [{
                name: 'Population',
                data: <?php echo $seriegrafica; ?>,
                dataLabels: {
                    enabled: true,
                    rotation: -0,
                    color: '#000000',
                    align: 'right',
                    x: 5,
                    y: 5,
                    style: {
                        fontSize: '16px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });
    });
    



});
    

        </script>




<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
      <!--Imprime el contedo de los objetos-->
    <?php echo $tablaextravio;?>
    </div>
    <div id="resumenesporhechos">
    <div class="span9">

        <div  id="extraviografica"> </div>
        <div  id="divprueba"> </div>

    </div>
    </div>
  </div>
</div>


<?php


}

?>





