
<legend>Vista de Graficas</legend>
<?php 
 /**
* Autor:Lester Hazael Gudiel Villamar
* Lugar: Ministerio de Gobernacion Guatemala, Guatemala
* Fecha: 02-08-2013
* Correo: mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com
* Site: www.lgudiel.com
*/

try {



function graficanovedades($estado,$departamento,$municipio,$tiempo,$comisaria)
{


switch ($tiempo) 
{
        case '1':
           $fecha = date("Y-m-d",time()-21600);
           //$fecha = date('Y-m-j')-21600;
            $fecha_inicio_denuncia = $fecha;    
            $fecha_final_denuncia =$fecha;
            $comisaria_denuncia ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
            break;
        # code...
      case '2':
      $fecha = date("Y-m-d",time()-21600);
           //$fecha = date('Y-m-j')-21600;
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        # code...
        break;
         case '3':
       $fecha = date("Y-m-d",time()-21600);
           //$fecha = date('Y-m-j')-21600;
        $nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        # code...
        break;
         case '4':
  $fecha = date("Y-m-d",time()-21600);
           //$fecha = date('Y-m-j')-21600;
        $nuevafecha = strtotime ( '-14 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        # code...
        break;
         case '5':
     $fecha = date("Y-m-d",time()-21600);
           //$fecha = date('Y-m-j')-21600;
        $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        # code...
        break;
         case '6':
       $fecha = date("Y-m-d",time()-21600);
           //$fecha = date('Y-m-j')-21600;
            $fecha_inicio_denuncia = $fecha;    
            $fecha_final_denuncia =$fecha;
            $comisaria_denuncia ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        # code...
        break;
    

}





$estados_variable = "";
switch ($estado) {
    case 'todos':  
        $estados_variable ="and b.estado IN('Preeliminar','Finalizada')";
        break;
     case '1':
        $estados_variable =" and b.estado IN('Preeliminar')";
        break;
         case '2':
          $estados_variable =" and b.estado IN ('Finalizada')";
     
        break;
}
$departamento_completo="";
switch ($departamento) {
    case 'Todos':
    $departamento_completo="";
        # code...
        break;
    
    default:
     $departamento_completo="AND b.id_departamento = ".$departamento."";

        # code...
        break;
}

$municipio_completo="";
    switch ($municipio) 
    {
        case 'Todos':
        $municipio_completo="";
            break; 
            case '':
        $municipio_completo="";
            break;    
        default:
         $municipio_completo="AND b.id_municipio=".$municipio."";
            break;
    }



//$romper_cadena = str_replace("and e", "and a.e", $cadena_tipo);

//and estado = 't' ";

    $sql = "select  b.descripcion_evento ,count(a.id_evento) 
from sipol_2.tbl_evento a, sipol_2.tbl_tipo_evento b
where a.id_tipo_evento =  b.id_tipo_evento and estado = 't'
group by  b.descripcion_evento;";

 $sql = "SELECT suma.estado as descripcion_evento, SUM(suma.total)as count FROM 
(SELECT b.estado, SUM (a.cantidad) as total
      FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
WHERE a.id_boleta = b.id_boleta
and a.id_evento = c.id_evento
and c.id_hecho in (1,3,4)
and b.estado IN ('Preeliminar')
GROUP BY  b.estado) as suma
GROUP BY  suma.estado;";

$datos1 =   array();
$contado1 = 0;
$datos2 =   array();
$contado2 = 0;
$resultado = Yii::app()->db->createCommand($sql)->queryAll(); 


foreach ($resultado as $key => $value) 
{
    //ar_dump($value);
    foreach ($value as $keyy => $valuee) {
        //echo "--".$valuee."<br>";
        if ($keyy =="descripcion_evento")
        {
            $datos1[$contado1] = $valuee;
            $contado1 = $contado1 + 1;

        }else if ($keyy=="count")
        {
             $datos2[$contado2] = $valuee;
            $contado2 = $contado2 + 1;
        }
        # code...
    }
}
$expresion_enviar = "";
$contador_guia= 0;
foreach ($datos1 as $key => $valueo) {
    # code...
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

$sql ="SELECT  suma.nombre_hecho as tipo, suma.id_hecho as id_tipo_hecho,SUM(suma.total) as count FROM 
(SELECT  d.nombre_hecho,d.id_hecho, SUM (a.cantidad) as total
      FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_hecho d
WHERE a.id_boleta = b.id_boleta
and a.id_evento = c.id_evento
and d.id_hecho = c.id_hecho
and c.id_hecho in (1,4,5)
". $departamento_completo."  
--and b.id_comisaria = '".$comisaria."'
".$municipio_completo."  
 ".$estados_variable."
and b.fecha 
BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia' 
GROUP BY  d.nombre_hecho, d.id_hecho, a.cantidad) as suma
GROUP BY suma.nombre_hecho,suma.id_hecho;";




/*$sql = "SELECT 
th.tipo, th.id_tipo_hecho, count(ed.id_evento_detalle)
FROM 
sipol_2.tbl_evento_detalle ed
LEFT JOIN 
sipol_2.tbl_hecho_temp h ON ed.id_hecho = h.id_hecho
LEFT JOIN 
sipol_2.tbl_tipo_hecho th ON h.id_tipo_hecho = th.id_tipo_hecho
WHERE 
ed.id_evento IN (
select 
id_evento 
from sipol_2.tbl_evento e, sipol_usuario.tbl_usuario u
WHERE u.id_usuario = e.id_usuario 
AND fecha_ingreso 
BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia' 
 ".$estados_variable."
AND id_tipo_evento ='1'  
". $departamento_completo."    
".$municipio_completo."  
--AND e.id_comisaria = '".$comisaria."'
)
AND h.id_hecho IS NOT NULL
GROUP BY th.tipo, th.id_tipo_hecho;";*/

//echo $sql;

$arrayName = array();
$resultado = Yii::app()->db->createCommand($sql)->queryAll();

if(count($resultado)=="0")
{

    echo "<div class='row-fluid'>
  <div class='span12'>
    <div class='row-fluid'>
      <div class='span2'>
        <img src='images/informacion.png'  class='span12'>
      </div>
      <div class='span10'>
        <div class='alert alert-info'>
          <button type='button' class='close' data-dismiss='alert'>&times;</button>
              <h4>Información del Sistema!</h4>
             No se tienen Graficas Registradas.....
        </div>
      </div>
    </div>
  </div>
</div>";

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

                                /*$sql2 = "SELECT h.nombre_hecho, count(ed.id_evento_detalle)
                                FROM sipol_2.tbl_evento_detalle ed
                                LEFT JOIN sipol_2.tbl_hecho_temp h ON ed.id_hecho = h.id_hecho
                                WHERE h.id_tipo_hecho = $value
                                AND ed.id_evento IN (select id_evento from sipol_2.tbl_evento
                                WHERE fecha_ingreso BETWEEN '$fecha_inicio_denuncia'
                                AND '$fecha_final_denuncia'  ".$cadena_tipo."
                                and id_ingreso = $comisaria_denuncia
                                and id_tipo_evento = 1)
                                GROUP BY ed.id_hecho, h.nombre_hecho;";*/



                  
$sql2 = "SELECT  suma.nombre_evento as nombre_hecho, SUM(suma.total) as count FROM 
(SELECT c.nombre_evento, SUM (a.cantidad) as total
      FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
WHERE a.id_boleta = b.id_boleta
and a.id_evento = c.id_evento
and c.id_hecho in (".$value.")
". $departamento_completo."  
--and b.id_comisaria = '".$comisaria."'

".$municipio_completo." 
".$estados_variable."
and b.fecha  
BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia'
GROUP BY c.nombre_evento, a.cantidad) as suma
GROUP BY  suma.nombre_evento 
order by 2 desc;";

/*$sql2 = " SELECT h.nombre_hecho, count(ed.id_evento_detalle)
FROM sipol_2.tbl_evento_detalle ed
LEFT JOIN sipol_2.tbl_hecho_temp h ON ed.id_hecho = h.id_hecho
WHERE h.id_tipo_hecho IN(".$value.")
AND ed.id_evento IN (
select 
id_evento 
from sipol_2.tbl_evento e, sipol_usuario.tbl_usuario u
WHERE u.id_usuario = e.id_usuario 
AND fecha_ingreso 
BETWEEN '$fecha_inicio_denuncia'
AND '$fecha_final_denuncia'
 ".$estados_variable."
AND id_tipo_evento ='1'
". $departamento_completo."   
".$municipio_completo."  
--AND e.id_comisaria = '".$comisaria."'
)
                               GROUP BY ed.id_hecho, h.nombre_hecho;";*/


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
                text: 'Estadistica sobre Novedades Comisaria($comisaria_denuncia)'
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
                        s = this.x +':<b>'+ this.y +' Novedades</b><br/>';
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


?>
<div id="container_hoy_denuncia"></div>
<div id="consignaciones_2"></div>













<?php
/*
echo "Estado Es =".$_POST['estado'];
echo "<br>";
//echo "Tipo Es =".$_POST['tipo'];
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
echo "La Comisaria =".$_POST['comisaria'];*/
echo "<br>";
graficanovedades($_POST['estado'],$_POST['departamento'],$_POST['municipio'],$_POST['tiempo'],$_POST['comisaria']);
} catch (Exception $e) {
   // echo "mensjae de error".$e;
    $this->renderPartial('errornovedades');
}
?>