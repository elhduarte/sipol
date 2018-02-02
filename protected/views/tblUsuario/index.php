<div class="cuerpo">
<div class="row-fluid">
  <div class="span12">
   <legend><img style="" src="images/icons/glyphicons_040_stats.png"  alt=""> Estadistica Ingreso de Usuarios</legend>    
   <div class="row-fluid">
      <div class="span12">
          <?php 
$tbl_usuario = new TblUsuario;
$mandografica = array();
$resultadoqueryusuario = $tbl_usuario->perfil_usuario();
$graficaroot = "[";
$contadorgrafica = 0;
$graficacuerpo ="";
$nameeventos = "";
      foreach ($resultadoqueryusuario as $key => $value) 
      {
           $primernivelusuario = json_encode($value);
            $jsonusuariografica = json_decode($primernivelusuario);
            $fechajson = $jsonusuariografica->id;
             $nameeventos =  $nameeventos."'".$jsonusuariografica->usuario."',";
             $usuariotitulo = $jsonusuariografica->usuario;
          $resultadoconteovisitas = $tbl_usuario->perfil_resumen_ingreso($fechajson);

      $graficaroot = "[";
      foreach ($resultadoconteovisitas as $key => $value) 
      {
           $primernivelgrafica = json_encode($value);
            $jsonusuariografica = json_decode($primernivelgrafica);
            $fechajson = $jsonusuariografica->fecha_ingreso;
            //$fechagrafica = new DateTime($fechajson);
            $conteojson = $jsonusuariografica->count;

            $fecha=strtotime($fechajson)*1000000;
             $fecha=$fechajson*1000000;
                echo $fecha."--".$fechajson."<hr>";
            $graficaroot = $graficaroot."[".$fecha.",".$conteojson."],";         
      }
        $graficaroot = $graficaroot."&]";
        $graficaroot = str_replace(",&", "", $graficaroot);
array_push($mandografica,$graficaroot);
 $graficaroot ="";

 $graficacuerpo = $graficacuerpo. "
 seriesOptions[$contadorgrafica] = {
                name: '".$usuariotitulo."',
                data: $mandografica[$contadorgrafica],
                 color: colors[$contadorgrafica]
            };
            createChart();";

            $contadorgrafica = $contadorgrafica +1;
      }
 ?>
<script src="lib/highcharts/Highstock-1.3.5/js/highstock.js"></script>
<script src="lib/highcharts/Highstock-1.3.5/js/modules/exporting.js"></script>
<div id="container" style="height: 500px; min-width: 500px"></div>
<?php 
$nameeventos = "[".$nameeventos."&]";
$nameeventos = str_replace(",&", "", $nameeventos);
 echo "
    <script type='text/javascript'>
$(function() {
    var seriesOptions = [],
        yAxisOptions = [],
        seriesCounter = 0,
        names = ".$nameeventos.",
        colors = Highcharts.getOptions().colors;
        ".$graficacuerpo."
    function createChart() {

        $('#container').highcharts('StockChart', {
            chart: {
            },

            rangeSelector: {
                selected: 4
            },

            yAxis: {
                labels: {
                    formatter: function() {
                        return (this.value > 0 ? '+' : '') + this.value + '%';
                    }
                },
                plotLines: [{
                    value: 5,
                    width: 10,
                    color: 'silver'
                }]
            },
            
            plotOptions: {
                series: {
                    compare: 'percent'
                }
            },
            
            tooltip: {
                pointFormat: '<span style=\"color:{series.color}\">{series.name}</span>: <b>{point.y}</b><br/>',
                valueDecimals: 0
            },
            
            series: seriesOptions
        });
    }
});
 </script>
 ";   

 echo $nameeventos;
 echo "<br>";   

  echo $graficacuerpo;
 ?>
      </div>
    </div>
  </div>
</div>

<?php 
/*
$resultadousuarioscompletos = $tbl_usuario->perfil_resumen_ingreso_dos();
      $graficaeventos = "[";
      $usuarioanterior ="";
      $usuarionuevo = "";
      foreach ($resultadousuarioscompletos as $key => $value) 
      {
           $primernivelgrafica = json_encode($value);
            $jsonusuariografica = json_decode($primernivelgrafica);
            $fechajson = $jsonusuariografica->fecha_ingreso;
            $fechagrafica = new DateTime($fechajson);
            $conteojson = $jsonusuariografica->count;
            $idusuariocompletos = $jsonusuariografica->id_usuario;
            $usuarioanterior =$usuarionuevo;
            if($usuarioanterior==$idusuariocompletos)
            {

              $graficaeventos = $graficaeventos."[".$fechagrafica->getTimestamp()."000,".$conteojson."],";  
              $usuarionuevo =$idusuariocompletos;

            }else{
              $graficaeventos="";
            }
            $graficaeventos = $graficaeventos."[".$fechagrafica->getTimestamp()."000,".$conteojson."],";         
      }*/
  ?>
</div>