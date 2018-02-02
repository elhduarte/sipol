
<legend>Vista de Graficas y Mapas</legend>
<?php 
 /**
* Autor:Lester Hazael Gudiel Villamar
* Lugar: Ministerio de Gobernacion Guatemala, Guatemala
* Fecha: 02-08-2013
* Correo: mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com
* Site: www.lgudiel.com
*/

/*
echo "Estado Es =".$_POST['estado'];
echo "<br>";
echo "Tipo Es =".$_POST['tipo'];
echo "<br>";
echo "Departamento Es =".$_POST['departamento'];
echo "<br>";
echo "Municipio Es =".$_POST['municipio'];
echo "<br>";
echo "Tipo de Grafica Es =".$_POST['graficatipo'];
echo "<br>";
echo "El evento  Es =".$_POST['evento'];
echo "<br>";
echo "El Tiempo =".$_POST['tiempo'];
echo "<br>";

*/
 ?>

 <div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6 well">
    


<legend>Vista de Graficas</legend>
<?php 
 /**
* Autor:Lester Hazael Gudiel Villamar
* Lugar: Ministerio de Gobernacion Guatemala, Guatemala
* Fecha: 02-08-2013
* Correo: mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com
* Site: www.lgudiel.com
*/

function denunciagrafica($departamento,$municipio,$tiempo,$comisaria)
{
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
$sql = "select  b.descripcion_evento ,count(a.id_evento) 
from sipol_2.tbl_evento a, sipol_2.tbl_tipo_evento b
where a.id_tipo_evento =  b.id_tipo_evento and estado = 't'
group by  b.descripcion_evento;";

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

$sql = "SELECT 
th.tipo, th.id_tipo_hecho, count(ed.id_evento_detalle)
FROM 
sipol_2.tbl_evento_detalle ed
LEFT JOIN 
sipol_2.tbl_hecho h ON ed.id_hecho = h.id_hecho
LEFT JOIN 
sipol_2.tbl_tipo_hecho th ON h.id_hecho_tipo = th.id_tipo_hecho
WHERE 
ed.id_evento IN (
select 
id_evento 
from sipol_2.tbl_evento e, sipol_usuario.tbl_usuario u
WHERE u.id_usuario = e.id_usuario 
AND fecha_ingreso 
BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia' 
AND e.estado = 't'
AND id_tipo_evento ='1'  
". $departamento_completo."    
".$municipio_completo."  
)
AND h.id_hecho IS NOT NULL
GROUP BY th.tipo, th.id_tipo_hecho;";

//echo $sql;

$arrayName = array();
$resultado = Yii::app()->db->createCommand($sql)->queryAll();



if(count($resultado)=="0")
{

    echo "<center><div class='page-header'>
  <h3>Información del Sistema! <small>No se tienen Graficas Registradas...</small></h3>
</div></center>";

}else{
$campos="";
$conteo_color=5;
$value_column =0;
$nombre_colmn="";
$nombre_bruto="";
$id_tipo_hecho =0;
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
                    else if($keyy == "id_tipo_hecho")
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
foreach ($arraytipo_hecho as $key => $value) 
{


$sql2 = " SELECT h.nombre_hecho, count(ed.id_evento_detalle)
FROM sipol_2.tbl_evento_detalle ed
LEFT JOIN sipol_2.tbl_hecho h ON ed.id_hecho = h.id_hecho
WHERE h.id_hecho_tipo IN(".$value.")
AND ed.id_evento IN (
select 
id_evento 
from sipol_2.tbl_evento e, sipol_usuario.tbl_usuario u
WHERE u.id_usuario = e.id_usuario 
AND e.estado = 't'
AND fecha_ingreso 
BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia'
AND id_tipo_evento ='1'
". $departamento_completo."   
".$municipio_completo."  
)
GROUP BY ed.id_hecho, h.nombre_hecho;";


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
echo "<script type='text/javascript'>
$( document ).ready(function() {

$(function () {
    
        var colors = Highcharts.getOptions().colors,
            categories = [$variable_catalogos],
            name = 'Tipos',
            data = [$html_conc];
    
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
                text: 'Rango de fechas (<b>$fecha1 - $fecha2</b>)'
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
                                    setChart(name, categories, data);
                                }
                            }
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

";


}//fin de funcion para hacer el count de las graficas
}//fin de la funcion de denuncia

function incidenciagrafica($departamento,$municipio,$tiempo,$comisaria)
{


switch ($tiempo) 
{
        case '1':
           $fecha = date('Y-m-j');
            $fecha_inicio_incidencias = $fecha;    
            $fecha_final_incidencias =$fecha;
            $comisaria_incidencias ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_incidencias));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_incidencias));
            break;
        
      case '2':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_incidencias =  $fecha22;  
        $fecha_final_incidencias =$fecha;
        $comisaria_incidencias ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_incidencias));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_incidencias));
        
        break;
         case '3':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_incidencias =  $fecha22;  
        $fecha_final_incidencias =$fecha;
        $comisaria_incidencias ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_incidencias));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_incidencias));
        
        break;
         case '4':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-14 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_incidencias =  $fecha22;  
        $fecha_final_incidencias =$fecha;
        $comisaria_incidencias ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_incidencias));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_incidencias));
        
        break;
         case '5':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_incidencias =  $fecha22;  
        $fecha_final_incidencias =$fecha;
        $comisaria_incidencias ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_incidencias));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_incidencias));
        
        break;
         case '6':
             $fecha = date('Y-m-j');
            $fecha_inicio_incidencias = $fecha;    
            $fecha_final_incidencias =$fecha;
            $comisaria_incidencias ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_incidencias));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_incidencias));
        
        break;
    

}


$departamento_completo="";
switch ($departamento) {
    case 'Todos':
    $departamento_completo="";
        
        break;
    
    default:
     $departamento_completo="AND c.direccion like '%\"Departamento\":\"".$departamento."%'";

        
        break;
}

$municipio_completo="";
switch ($municipio) {
    case 'Todos':
    $municipio_completo="";
        
        break;
    
    default:
     $municipio_completo="AND c.direccion LIKE '%\"Municipio\":\"".$municipio."%'";

        
        break;
}

$variable_catalogos = "";
$valores_catalogos="";

$sql ="select 
    b.tipo_incidencia as tipo, 
    b.id_tipo_incidencia as id_tipo_hecho,
    count(a.id_tipo_incidencia)
from 
    sipol_2.tbl_evento_detalle as a, sipol_2.tbl_tipo_incidencia as b, sipol_2.tbl_evento as c  
where 
    a.id_tipo_incidencia IN(
        select id_tipo_incidencia  from  sipol_2.tbl_tipo_incidencia
        )
    and a.id_tipo_incidencia = b.id_tipo_incidencia
    and c.id_evento = a.id_evento
    and c.fecha_ingreso BETWEEN '$fecha_inicio_incidencias'
AND '$fecha_final_incidencias'
    and c.estado = 't'
    ".$departamento_completo."  
 ".$municipio_completo."
GROUP BY b.tipo_incidencia, b.id_tipo_incidencia";
$arrayName = array();
$resultado = Yii::app()->db->createCommand($sql)->queryAll();
if(count($resultado)=="0")
{
echo "<center><div class='page-header'>
  <h3>Información del Sistema! <small>No se tienen Graficas Registradas...</small></h3>
</div></center>";

}else{
$campos="";
$conteo_color=5;
$value_column =0;
$nombre_colmn="";
$nombre_bruto="";
$id_tipo_hecho =0;
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
                    else if($keyy == "id_tipo_hecho")
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
foreach ($arraytipo_hecho as $key => $value) 
{

$sql2 ="select 
b.motivo_incidencia as motivo,  count(a.id_motivo_incidencia) 
from sipol_2.tbl_evento_detalle as a, sipol_2.tbl_motivo_incidencia as b, sipol_2.tbl_evento as c  
where a.id_motivo_incidencia IN(select id_motivo_incidencia  from  sipol_2.tbl_motivo_incidencia)
and a.id_motivo_incidencia = b.id_motivo_incidencia
and a.id_tipo_incidencia = $value
and c.id_evento = a.id_evento
    and c.fecha_ingreso BETWEEN '$fecha_inicio_incidencias'
AND '$fecha_final_incidencias'
    and c.estado = 't'
    ".$departamento_completo."  
 ".$municipio_completo."
GROUP BY b.motivo_incidencia";
                                $resultado2 = Yii::app()->db->createCommand($sql2)->queryAll();
                                foreach ($resultado2 as $keyy => $valuey) 
                                {
                                    foreach ($valuey as $keyyy => $valueyy) 
                                    {
                                      
                                        if ($keyyy=="motivo") 
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
    $color2 = $color +1;
    $html_conc = $html_conc ."{
                    y: $valory,
                    color: colors[".$color."],
                    drilldown: {
                        name: '[$array_catalogo2[$contador_cordenadas]]',
                        categories: [$array_posiciones_conteo[$contador_cordenadas]],
                        data: [$total_array_posiciones_conteo[$contador_cordenadas]],
                        color: colors[".$color2."]
                    }},"; 
    $contador_cordenadas= $contador_cordenadas +1;
 }
echo "<script type='text/javascript'>
$( document ).ready(function() {
$(function () {
        var colors = Highcharts.getOptions().colors,
            categories = [$variable_catalogos],
            name = 'Tipos',
            data = [$html_conc];
    
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
    
        var chart = $('#incidencias_2').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Estadistica sobre incidencias'
            },
            subtitle: {
                text: 'Rango de fechas (<b>$fecha1 - $fecha2</b>)'
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
                                    setChart(name, categories, data);
                                }
                            }
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
                        s = this.x +':<b>'+ this.y +' incidencias</b><br/>';
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

";

}//fin del else cuando la consulta no tiene datos
}//fin de la funcion de incidencia

?>
<div id="container_hoy_denuncia"></div>
<div id="incidencias_2"></div>
<?php

/*
echo "Tipo Es =".$_POST['tipo'];
echo "<br>";
echo "Departamento Es =".$_POST['departamento'];
echo "<br>";
echo "Municipio Es =".$_POST['municipio'];
echo "<br>";
echo "Tipo de Grafica Es =".$_POST['graficatipo'];
echo "<br>";
echo "El evento  Es =".$_POST['evento'];
echo "<br>";
echo "El Tiempo =".$_POST['tiempo'];
echo "<br>";
echo "<br>";
echo "La Comisaria =".$_POST['comisaria'];
echo "<br>";*/
if($_POST['tipo'] =="1")
{
denunciagrafica($_POST['departamento'],$_POST['municipio'],$_POST['tiempo'],$_POST['comisaria']);
}else{
    incidenciagrafica($_POST['departamento'],$_POST['municipio'],$_POST['tiempo'],$_POST['comisaria']);
}//condificion de tipo

?>

<div id="container_hoy_denuncia"></div>
<div id="consignaciones_2"></div>













<?php
/*
echo "Estado Es =".$_POST['estado'];
echo "<br>";
echo "Tipo Es =".$_POST['tipo'];
echo "<br>";
echo "Departamento Es =".$_POST['departamento'];
echo "<br>";
echo "Municipio Es =".$_POST['municipio'];
echo "<br>";
echo "Tipo de Grafica Es =".$_POST['graficatipo'];
echo "<br>";
echo "El evento  Es =".$_POST['evento'];
echo "<br>";
echo "El Tiempo =".$_POST['tiempo'];
echo "<br>";

echo "<br>";
echo "La Comisaria =".$_POST['comisaria'];
echo "<br>";

*/


if($_POST['tipo'] =="1")
{
denunciagrafica($_POST['departamento'],$_POST['municipio'],$_POST['tiempo'],$_POST['comisaria']);


}else{
    //echo "esta es una incidencia";

    incidenciagrafica($_POST['departamento'],$_POST['municipio'],$_POST['tiempo'],$_POST['comisaria']);
}//condificion de tipo

 
    

	

?>

















      </div><!--fin de div para las garficas-->
      <div class="span6 well">

      	<legend>Vista de Mapa</legend>







<?php 
/*
echo "Tipo Es =".$_POST['tipo'];
echo "<br>";
echo "Departamento Es =".$_POST['departamento'];
echo "<br>";
echo "Municipio Es =".$_POST['municipio'];
echo "<br>";
echo "Tipo de Grafica Es =".$_POST['graficatipo'];
echo "<br>";
echo "El evento  Es =".$_POST['evento'];
echo "<br>";
echo "El tiempo  Es =".$_POST['tiempo'];
echo "<br>";*/
 ?>
<link rel="stylesheet" type="text/css" src = "http://181.114.21.10/base/js/openlayers/theme/default/style.css"/>
<script type = "text/javascript" src = "http://181.114.21.10/base/js/openlayers/OpenLayers.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/mapaingreso.js"></script>
<script src="/base/js/jquery-ui.js"></script>

<style type="text/css" media="screen">                      
    .map { width:620px; height:500px;}
    .map img { max-width:none; }
    .ui-dialog  { z-index: 5000; border-radius: 15px;}
</style>


<div class="row-fluid">
  <div class="span12">
  
    <div id ='map' class='map span12'>
  </div>
</div>
<div id="dialog_info">
</div>




      
<script type="text/javascript">
  $(document).ready(function() {
var map;
    map = new OpenLayers.Map({
        div: "map",
        "projection": new OpenLayers.Projection('EPSG:900913'),
        "displayProjection": new OpenLayers.Projection('EPSG:4326'),
            "units": "m",
      "maxExtent": new OpenLayers.Bounds(
            -128 * 156543.0339,
            -128 * 156543.0339,
            128 * 156543.0339,
            128 * 156543.0339
        ),
      "allOverlays": false,
        layers: [

          new OpenLayers.Layer.WMS( 'Plan IGN',
        'http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?',
        {layers: 'plan', format: 'image/png',
        transparent: "TRUE"
        },
        {isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
        encodeBBOX:false,projection:'EPSG:900913'},
        {tileSize:new OpenLayers.Size(256,256)})
        ,/*
      new OpenLayers.Layer.WMS( 'Fotos Aereas IGN',
       'http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?',
        {layers: 'hybrid', format: 'image/png',
        transparent: "TRUE"
        },
        {numZoomLevels: 20,isBaseLayer: true, alpha: true, visibility: true, displayInLayerSwitcher: true,
        encodeBBOX:false,projection:'EPSG:900913'},
        {tileSize:new OpenLayers.Size(256,256)})
        ,
        new OpenLayers.Layer.WMS("Hojas Cartograficas IGN",
        "http://sistemas.mingob.gob.gt/cgibin/mapserv?map=/home/wms/hojas_carto2012.map",
        {layers:'hojas_cartograficas_2012',
        format:'image/jpeg',
        transparent: "FALSE",
        SRS:'EPSG:900913'},
        {isBaseLayer:true,ratio:1,transitionEffect:'resize',encodeBBOX:false,projection:'EPSG:900913',visible:false,displayInLayerSwitcher: true},
        {tileSize:new OpenLayers.Size(256,256)})
        ,*/
        new OpenLayers.Layer.OSM("OpenStreetMap", null, { //Layer OSM
        transitionEffect: 'resize'
        })
     
            ]
    });
  var sipol_layer = new OpenLayers.Layer.WMS( "estadistica_denuncia_mapa",
  "http://sistemas.mingob.gob.gt/geoserver/wms?",
  {layers: 'sipol:estadistica_denuncia_mapa', format: 'image/png',
  transparent: "TRUE"
  },
  {isBaseLayer: false, alpha: true,singleTile: true, visibility: true, displayInLayerSwitcher: true,
  encodeBBOX:false,projection:'EPSG:900913'});
/*
  var sipol_layer = new OpenLayers.Layer.WMS("vista_mapa",
 "http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?",
 {layers: 'sipol:tbl_evento',
 format: 'image/png',
 transparent: "TRUE"
      },
  {isBaseLayer: false, alpha: true, visibility: true, singleTile: true, displayInLayerSwitcher: true,
     encodeBBOX:false,projection:'EPSG:900913'},
{tileSize:new OpenLayers.Size(256,256)});

  
*/

  var layer_switcher = new OpenLayers.Control.LayerSwitcher( );
  map.addControl(layer_switcher);
  layer_switcher.maximizeControl();
  map.addControl(new OpenLayers.Control.Navigation());
  map.addControl(new OpenLayers.Control.MousePosition());
  map.addControl(new OpenLayers.Control.ScaleLine());
  map.addControl(new OpenLayers.Control.PanZoomBar());
  //map.setCenter(new OpenLayers.LonLat(-90.5, 16).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 7);
  map.setCenter(new OpenLayers.LonLat(-90.5, 16).transform(new OpenLayers.Projection("EPSG:4326"),map.getProjectionObject()), 7);
  map.addLayer(sipol_layer);



var control_feature=new OpenLayers.Control.WMSGetFeatureInfo(
      {url:"http://sistemas.mingob.gob.gt/geoserver/gwc/service/wms?",
      queryVisible:true,
      vendorParams:{format:"image/png",
      request:"GetFeatureInfo"
      }
      });

      control_feature.events.register("getfeatureinfo",this,show);
      map.addControl(control_feature);
      control_feature.activate();

  function show(evt){

      var match=evt.text.match(/<body>([\s\S]*)<\/body>/);
      var html;
      if(match&&!match[1].match(/^\s*$/))
      {
      $( "#dialog_info" ).dialog({
      //autoOpen: false,
      width: '600',
      height: '250',
      show: {
      effect: "fold",
      duration: 300
      },
      hide: {
      effect: "fold",
      duration: 300
      }
      });
      $("#dialog_info").empty();
      $("#dialog_info").append(evt.text);
      $('#dialog_info li').accordion({
      heightStyle: "content",
      autoHeight: false ,
      create: function() {
        $(this).css("top", 5);
      }
      });
      $( "#dialog_info" ).dialog( "open" );
      }
  
  }


function format_fecha(f_fecha)
{
    var mm = f_fecha.getMonth() + 1;
    mm = (mm < 10) ? '0' + mm : mm;
    var dd = f_fecha.getDate();
    dd = (dd < 10) ? '0' + dd : dd;
    var yyyy = f_fecha.getFullYear();
  f_fecha =  mm + '/' + dd + '/' + yyyy;
  return f_fecha;
}

function agregaCapa(text,evt){
     //$( "#effect" ).removeClass( "first_class", 1200 ,agregaCapa_aux(text,evt));
   //alert(1);
     $("#effect").show(1500);
   agregaCapa_aux(text,evt);
}

function toggleDate() 
{

var Tiempo = '<?php echo $_POST['tiempo']; ?>';
var Type = '<?php echo $_POST['tipo']; ?>';
var Depto = '<?php echo $_POST['departamento']; ?>';
var Mupio = '<?php echo $_POST['municipio']; ?>';


    var f_ini,f_fin;
    var CQL ="";
        switch(Tiempo)
        {
        case "1"://hoy
          f_ini= format_fecha(new Date());
          f_fin= format_fecha(new Date());
           CQL = "fecha_ingreso >= '" + f_ini + "' and fecha_ingreso <= '" + f_fin + "'";
          break;
        case "2"://ayer
          var aux_date = new Date();
          aux_date.setDate(aux_date.getDate()-1);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
           CQL = "fecha_ingreso >= '" + f_ini + "' and fecha_ingreso <= '" + f_fin + "'";
          break;
        case "3"://una semana
          var aux_date = new Date();
          aux_date.setDate(aux_date.getDate()-7);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
          CQL = "fecha_ingreso >= '" + f_ini + "' and fecha_ingreso <= '" + f_fin + "'";
          break;
        case "4"://dos semanas
          var aux_date = new Date();
          aux_date.setDate(aux_date.getDate()-14);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
           CQL = "fecha_ingreso >= '" + f_ini + "' and fecha_ingreso <= '" + f_fin + "'";
          break;
        case "5"://un mes
          var aux_date = new Date();
          aux_date.setMonth(aux_date.getMonth()-1);
          f_ini= format_fecha(aux_date);
          f_fin= format_fecha(new Date());
          CQL = "fecha_ingreso >= '" + f_ini + "' and fecha_ingreso <= '" + f_fin + "'";
          break;
        default://hoy
          f_ini= format_fecha(new Date());
          f_fin= format_fecha(new Date());
          CQL = "fecha_ingreso >= '" + f_ini + "' and fecha_ingreso <= '" + f_fin + "'";
          break;
        }

        /*switch(State)
        {
        case "confirmado"://confirmados
           CQL = CQL.concat(" AND estado = 'true' ");
          break;
        case "pendiente"://no confirmados
          CQL =  CQL.concat(" AND estado = 'false' ");
          break;
        default://Todos
          break;
        }*/

        switch(Type)
        {
        case "1"://denuncias
           CQL = CQL.concat(" AND id_tipo_evento = 1 ");
          break;
        case "2"://incidencias
          CQL =  CQL.concat(" AND id_tipo_evento = 2 ");
          break;
        default://Todos
          break;
        }

        switch(Depto)
        {
        case "Todos"://confirmados
          break;
        default://Todos
          CQL =  CQL.concat('AND direccion like \'%"Departamento":"'+Depto+'"%\'');
          break;
        }

        switch(Mupio)
        {
        case "Todos"://confirmados
          break;
        default://Todos
          CQL =  CQL.concat('AND direccion like \'%"Municipio":"'+Mupio+'"%\'');
          break;
        }


          console.log(CQL);

         //CQL='';
        
          map.getLayersByName('estadistica_denuncia_mapa')[0].mergeNewParams({
          'cql_filter': CQL},{
          singleTile: true
          });
          map.getLayersByName('estadistica_denuncia_mapa')[0].redraw(true);

}





toggleDate();
});
</script>






  
 
 


  
 
 





      </div>
    </div>
  </div>
</div>
