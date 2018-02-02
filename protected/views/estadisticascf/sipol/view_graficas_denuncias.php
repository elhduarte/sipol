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


$condicion_tipo_hecho="";
switch ($tipo_hecho) {
    case 'Todos':
    $condicion_tipo_hecho="AND h.id_hecho_denuncia = h.id_hecho_denuncia";
        
        break;
    
    default:
     $condicion_tipo_hecho="AND h.id_hecho_tipo = ".$tipo_hecho."";        
        break;
}



$condicion_hecho="";
switch ($hechosdenuncia) {
    case 'Seleccione un Hecho':
    $condicion_hecho="";  
    $condicionhechoglobal="";      
        break;    
    default:
         $condicion_hecho="AND chd.nombre_hecho like '%".$hechosdenuncia."%'";
         $condicionhechoglobal =" AND h.nombre_hecho like '%".$hechosdenuncia."%'";
              
     break;
}


$sql = "
select  b.descripcion_evento ,count(a.id_evento) 
from sipol.tbl_evento a, sipol_catalogos.cat_tipo_evento b
where a.id_tipo_evento =  b.id_tipo_evento and estado = 't'
group by  b.descripcion_evento;

";



$datos1 =   array();
$contado1 = 0;
$datos2 =   array();
$contado2 = 0;
$resultado = Yii::app()->db->createCommand($sql)->queryAll(); 
foreach ($resultado as $key => $value) 
{
    foreach ($value as $keyy => $valuee) {
        if ($keyy =="descripcion_evento")
        {
            $datos1[$contado1] = $valuee;
            $contado1 = $contado1 + 1;
        }else if ($keyy=="count")
        {
             $datos2[$contado2] = $valuee;
            $contado2 = $contado2 + 1;
        }
        
    }
}
$expresion_enviar = "";
$contador_guia= 0;
foreach ($datos1 as $key => $valueo) {
    
    if ($contador_guia == 1)
    {
        $expresion_enviar = $expresion_enviar."{
                                name: '$valueo',
                                y: ".$datos2[$contador_guia].",
                                sliced: true,
                                selected: true
                            },"; 
                            $contador_guia = $contador_guia +1;
    }else{
        // echo $valueo;
    $expresion_enviar = $expresion_enviar."['$valueo',".$datos2[$contador_guia]."],"; 
    $contador_guia = $contador_guia +1;
    }
}
$variable_catalogos = "";
$valores_catalogos="";
$sql = "SELECT th.tipo, th.id_hecho_tipo, count(ed.id_evento_detalle) 
                FROM sipol.tbl_evento_detalle ed 
                LEFT JOIN sipol_catalogos.cat_hecho_denuncia h ON ed.id_hecho_denuncia = h.id_hecho_denuncia 
                LEFT JOIN sipol_catalogos.cat_hecho_tipo th ON h.id_hecho_tipo = th.id_hecho_tipo 
                WHERE ed.id_evento IN ( 
                SELECT e.id_evento
                FROM sipol.tbl_evento e, 
                sipol_usuario.tbl_rol_usuario ru, 
                catalogos_publicos.tbl_sede s, 
                catalogos_publicos.cat_entidad ce, 
                sipol.tbl_evento_detalle tbd, 
                sipol_catalogos.cat_hecho_denuncia chd, 
                sipol_usuario.tbl_usuario tblus 
                WHERE ru.id_usuario = e.id_usuario
                AND ru.id_sede = s.id_sede
                AND s.id_cat_entidad = ce.id_cat_entidad
                AND e.fecha_ingreso 
                BETWEEN '$fecha_inicio_denuncia'
                AND '$fecha_final_denuncia'
                AND e.estado = 't'
                AND e.id_tipo_evento = 1
                AND chd.id_hecho_denuncia = tbd.id_hecho_denuncia
            ". $departamento_completo."   
            ".$municipio_completo." 
            ".$region_completo."
            ".$comisaria_completo."
            ".$tipo_sede_completo."
            ".$sede_completo."
            ".$condicion_hecho."
                ) 
                ".$condicionhechoglobal."
                ".$condicion_tipo_hecho." 
                 GROUP BY th.tipo, th.id_hecho_tipo;";


echo $sql;

$arrayName = array();
$resultado = Yii::app()->db->createCommand($sql)->queryAll();



if(count($resultado)=="0")
{

    echo "<center><div class='page-header'>
  <h3>Información afd sadfdel Sistema! <small>No se saf tienen Graficas Registradas...</small></h3>
</div></center>";

}else{
$campos="";
$conteo_color=5;
$value_column =0;
$nombre_colmn="";
$nombre_bruto="";
$id_hecho_tipo =0;
$arraytipo_hecho =  array();
$con_tipo_hecho = 0;
$array_conteo =  array();
$con_conteo = 0;
$array_catalogo2=  array();
$con_conteo_catalogos = 0;
foreach($resultado as $key => $value)
{
        foreach ($value as $keyy => $valuee) 
        {
            if($keyy =="tipo")
            {
                $variable_catalogos =$variable_catalogos."'".$valuee."',";
                $array_catalogo2[$con_conteo_catalogos] = $valuee;
                $con_conteo_catalogos = $con_conteo_catalogos +1;
            }

            else if($keyy =="count")
            {
                $valores_catalogos =$valuee;
                $array_conteo[$con_conteo] =  $valuee; 
                    $con_conteo =  $con_conteo + 1;
             } 
            else if($keyy == "id_hecho_tipo")
            {

                $arraytipo_hecho[$con_tipo_hecho] =  $valuee; 
                    $con_tipo_hecho =  $con_tipo_hecho + 1;

            }                    

        }
}
$variableconcateneadanombres="";
$variableconcateneadatotales="";
$conteo_de_posisiones = 0;
$array_posiciones_conteo =  array();
$total_de_posisiones = 0;
$total_array_posiciones_conteo =  array();
$cabezatabla = "";
foreach ($arraytipo_hecho as $key => $value) 
{




$subquery = "SELECT e.id_evento
FROM sipol.tbl_evento e, sipol_usuario.tbl_rol_usuario ru, catalogos_publicos.tbl_sede s, catalogos_publicos.cat_entidad ce
WHERE ru.id_usuario = e.id_usuario
AND ru.id_sede = s.id_sede
AND s.id_cat_entidad = ce.id_cat_entidad
AND e.fecha_ingreso 
BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia'
AND e.estado = 't'
AND e.id_tipo_evento = 1
". $departamento_completo."   
".$municipio_completo." 
".$region_completo."
".$comisaria_completo."
".$tipo_sede_completo."
".$sede_completo."
";
$sql2 = "
SELECT h.nombre_hecho, count(ed.id_evento_detalle)
FROM sipol.tbl_evento_detalle ed
LEFT JOIN sipol_catalogos.cat_hecho_denuncia h ON ed.id_hecho_denuncia = h.id_hecho_denuncia
WHERE h.id_hecho_tipo IN(".$value.")
AND ed.id_evento IN ( ".$subquery.") 
".$condicionhechoglobal ."
GROUP BY ed.id_hecho_denuncia, h.nombre_hecho;";
 //echo $sql2;
 //echo "<hr>";


$resultado2 = Yii::app()->db->createCommand($sql2)->queryAll();
foreach ($resultado2 as $keyy => $valuey) 
{
    foreach ($valuey as $keyyy => $valueyy) 
    {
        if ($keyyy=="nombre_hecho") 
        {
             $variableconcateneadanombres = $variableconcateneadanombres."'".$valueyy."',";




        }elseif ($keyyy=="count") 
        {
            $variableconcateneadatotales=$variableconcateneadatotales."".$valueyy.",";
  
        }

    }
    $array_posiciones_conteo[$conteo_de_posisiones] = $variableconcateneadanombres;
    $total_array_posiciones_conteo[$total_de_posisiones] = $variableconcateneadatotales;
}
$variableconcateneadanombres ="";
$variableconcateneadatotales="";
$conteo_de_posisiones = $conteo_de_posisiones +1;
 $total_de_posisiones =  $total_de_posisiones + 1;



}//termina el foreach arraytipo de hecho

 $contador_cordenadas = 0;
 $html_conc = "";
 $color = rand(0, 10);
foreach ($array_conteo as $titulo => $valory) 
 {
    $color = $color+1;
    $html_conc = $html_conc ."{
                    y: $valory,
                    color: colors[".$color."],
                    drilldown: {
                        name: '[$array_catalogo2[$contador_cordenadas]]',
                        categories: [$array_posiciones_conteo[$contador_cordenadas]],
                        data: [$total_array_posiciones_conteo[$contador_cordenadas]],
                        color: colors[".rand(0, 10)."]
                    }},";
    $contador_cordenadas= $contador_cordenadas +1;
 }


?>
 <div class="cuerpo-estadistica" id="viewgraficadenuncia">
<div id="container_hoy_denuncia"></div>
</div>

<script type='text/javascript'>
$(document).ready(function(){
$(function () {
    
        var colors = Highcharts.getOptions().colors,
            categories = [<?php echo $variable_catalogos; ?>],
            name = 'Tipos',
            data = [<?php  echo $html_conc; ?>];
    
        function setChart(name, categories, data, color) {
            chart.xAxis[0].setCategories(categories, false);
            chart.series[0].remove(false);
            chart.addSeries({
                name: name,
                data: data,
                borderColor: '#303030',
                color: color || 'white'
            }, false);
            chart.redraw();
        }
    
        var chart = $('#container_hoy_denuncia').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Estadistica sobre Denuncias'
            },
            subtitle: {
                /*text: 'Rango de fechas (<b>$fecha1 - $fecha2</b>)'*/
                text: 'Rango de fechas'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Total en cantidades'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    //setChart(name, categories, data);
                                    $(this).validarrequeridostiempo(this.category);

                                }
                            }/*,mouseOver: function(){

                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    //setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    //setChart(name, categories, data);
                                   // $('#nuevagrafica').html(this.category);
                                    //actualizatiempodenuncia(this.category);
                                    $(this).actualizatiempodenuncia2(this.category);

                                   // console.log(this.category);
                                }

                            }*/
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y +'';
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +':<b>'+ this.y +' Denuncias</b><br/>';
                    if (point.drilldown) {
                        s += 'Click para ver '+ point.category +' version';
                    } else {
                        s += 'Click para retornar';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                borderColor: '#303030',
                color: 'white'
            }],
            exporting: {
                enabled: false
            }
        })
        .highcharts(); // return chart
    });
});
</script>

 <div class="cuerpo-estadistica" id="viewgraficamapadenuncia">
              <?php
        $this->renderPartial('sipol/view_mapas',array(
                'tipo'=>$tipo,
                'tiempo'=>$tiempo,
                'departamento'=>$departamento,
                'municipio'=>$municipio,
                'region'=>$region,
                'comisaria'=>$comisaria,
                'tipo_sede'=>$tipo_sede,
                'sede'=>$sede,
                'tipo_hecho'=>$tipo_hecho,
                'estadofecha'=>$estadofecha,
                'fechainicio'=>$fechainicio,
                'fechafinal'=>$fechafinal,
                'hechosdenuncia'=> $hechosdenuncia
                ));
      ?>
  </div>


<?php


     }//fin de funcion para hacer el count de las graficas*
?>
