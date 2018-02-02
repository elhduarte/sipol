
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/lib/highcharts/modules/drilldown.js"></script>
<?php

	$fechaIniGral4= $_POST['fechaIniGral4'];
	$fechaFinGral4 = $_POST['fechaFinGral4'];
	$tipo_evento = $_POST['tipo_evento'];
	$estado = $_POST['estado'];
if (empty($fechaIniGral4) || empty($fechaFinGral4)) {
                echo"<br>";
                                    echo"<div class=\"alert alert-error\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                                    <h4>Advertencia!</h4>El rango de fechas proporcinado esta vacio, debe de ingresar fechas...
                                    </div>";
                                  // $condicion5='';
                                   
            } else
            {

$query = new Estadisticas;
$data = $query->obtenerConsultasPorEvento($fechaIniGral4, $fechaFinGral4, $tipo_evento, $estado);
//$data2= $query->obtenerConsultasPorEvento2($fechaIniGral4, $fechaFinGral4, $tipo_evento, $estado,$id_cat_entidad);

$data3= json_decode($data);
//$data4= json_decode($data2);

//var_dump($data4);


$contador=0;
$entidad="";
$val="";
foreach ($data3 as $key => $value) {
	$id_cat_entidad= $value->id;
	$entidad.= "'" .$value->name."',";
	$cantidad= $value->data;


$val.=" {
                    y: ".$cantidad.",
                    color: colors[".$contador."],
                    drilldown: {";
                        

 			$data2= $query->obtenerConsultasPorEvento2($fechaIniGral4, $fechaFinGral4, $tipo_evento, $estado,$id_cat_entidad);
 			$val.=$data2;
 			$val.="color: colors[".$contador."]
                    }
                }, ";

                $contador++;
          
                
          
    }



$val=substr($val, 0, -2);
$val= "[". $val."];";
$entidad=substr($entidad, 0, -1);
$entidad ="[".$entidad."],";

//echo $val;
?>

<script>
  $(document).ready(function(){

$(function () {
    var chart,
        colors = Highcharts.getOptions().colors;
    
    function setChart(name, categories, data, color) {
        chart.xAxis[0].setCategories(categories);
        chart.series[0].remove();
        chart.addSeries({
            name: name,
            data: data,
            color: color || 'white'
        });
    }
    
    $(document).ready(function() {
    
        var categories = <?php echo $entidad; ?>
            name = 'Comisarias',
            data =  <?php echo $val; ?>
                                      
    
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: 'GRAFICA EVENTO COMISARIA'
            },
            subtitle: {
                text: 'Haga Click sobre la columna para ver eventos. Click de nuevo para regresar'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Total de eventos por comisaria'
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
                            return this.y;
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +':<b>'+ this.y +' Eventos</b><br/>';
                    if (point.drilldown) {
                        s += 'Click  para ver '+ point.category +' eventos por comisaria';
                    } else {
                        s += 'Click regresar a las comisarias';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: 'white'
            }],
            exporting: {
                enabled: false
            }
        });
    });
    
    
});
 }); 
</script>
<?php }?>