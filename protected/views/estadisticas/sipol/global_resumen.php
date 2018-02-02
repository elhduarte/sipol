
      <legend>Información Global sobre Denuncias Sipol</legend>



    <div class="row-fluid">
  <div class="span12">
    
    <div class="row-fluid">
      <div class="span6 cuerpo">

        <div id="viewcontralavida" class=""></div>
        <?php
$querycontralavida ="SELECT 
h.nombre_hecho, count(ed.id_evento_detalle) 
FROM sipol.tbl_evento_detalle ed LEFT JOIN sipol_catalogos.cat_hecho_denuncia h 
ON ed.id_hecho_denuncia = h.id_hecho_denuncia 
WHERE 
h.id_hecho_tipo IN(1) 
AND ed.id_evento IN ( 
SELECT e.id_evento 
FROM 
sipol.tbl_evento e 
 WHERE 
  e.estado = 't'
 and e.id_tipo_evento = 1 
 ) 
 GROUP BY ed.id_hecho_denuncia, h.nombre_hecho
  order by count(ed.id_evento_detalle)  DESC ;";

 $resul_contralavida = yii::app()->db->createCommand($querycontralavida)->queryAll();
 if(count($resul_contralavida)==0)
 {
  echo "No se completo la Grafica";
 }else{
  $cabezatabla ="";

         $cabezatabla = $cabezatabla."<legend>Delitos Contra la Vida</legend><table class='table table-hover'>
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Conteo</th>
    </tr>
  </thead>
  <tbody>";

$conteo = 1;
$creadodata_contravida = "[";
  foreach ($resul_contralavida as $key => $value) {

    $json_contralavida = json_encode($value);
    $json_contralavida = json_decode($json_contralavida);

        $cabezatabla = $cabezatabla."<tr class='lishechos' nomhecho='".$json_contralavida->nombre_hecho."'><td>".$json_contralavida->nombre_hecho."</td><td>".$json_contralavida->count."</td><tr>";
     


    if($conteo == 2)
    {

      $creadodata_contravida = $creadodata_contravida ." {
                        name: '".$json_contralavida->nombre_hecho."',
                        y: ".$json_contralavida->count.",
                        sliced: true,
                        selected: true
                    },";

    }else{

       $creadodata_contravida = $creadodata_contravida."['".$json_contralavida->nombre_hecho."',".$json_contralavida->count."],";

    //echo $json_contralavida->count;
    //echo $json_contralavida->nombre_hecho;
    # code...



    }//fin del contador para la dos

    

     $conteo = $conteo +1;
  }

  $cabezatabla = $cabezatabla."</tbody></table>";

  $creadodata_contravida =$creadodata_contravida . "]";

  $creadodata_contravida = str_replace("],]", "]]", $creadodata_contravida);
  //echo $creadodata_contravida;


  echo $cabezatabla;

 }//fin del else para hacer la grafica

 //echo  $creadodata_contravida;


        ?>

        <script type="text/javascript">

        $(function () {
      
      // Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
    
    // Build the chart
        $('#viewcontralavida').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: true
            },
            title: {
                text: 'Delitos Contra la Vida Registrados'
            },
            tooltip: {
              pointFormat: '{series.name}:<b>{point.percentage:.1f}%</b>'              
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                           // console.log(this.percentage);
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Hecho',
                data: <?php echo $creadodata_contravida; ?>
            }]

        });

    });



    

        </script>

        


      
       
      </div>
      <div class="span6 cuerpo">
        <div id="viewcontrapatrimonio" class=""></div>
       

       <?php
        $querycontralavida ="SELECT 
h.nombre_hecho, count(ed.id_evento_detalle) 
FROM sipol.tbl_evento_detalle ed LEFT JOIN sipol_catalogos.cat_hecho_denuncia h 
ON ed.id_hecho_denuncia = h.id_hecho_denuncia 
WHERE 
h.id_hecho_tipo IN(2) 
AND ed.id_evento IN ( 
SELECT e.id_evento 
FROM 
sipol.tbl_evento e 
 WHERE 
  e.estado = 't' 
  and e.id_tipo_evento = 1
 ) 
 GROUP BY ed.id_hecho_denuncia, h.nombre_hecho
  order by count(ed.id_evento_detalle)  DESC ;";

 $resul_contralavida = yii::app()->db->createCommand($querycontralavida)->queryAll();
 if(count($resul_contralavida)==0)
 {
  echo "No se completo la Grafica";
 }else{


    $cabezatabla ="";

         $cabezatabla = $cabezatabla."<legend>Delitos Contra la Vida</legend><table class='table table-hover'>
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Conteo</th>
    </tr>
  </thead>
  <tbody>";



$conteo = 1;
$creadodata_contravida = "[";
  foreach ($resul_contralavida as $key => $value) {

    $json_contralavida = json_encode($value);
    $json_contralavida = json_decode($json_contralavida);

       $cabezatabla = $cabezatabla."<tr class='lishechos' nomhecho='".$json_contralavida->nombre_hecho."'><td>".$json_contralavida->nombre_hecho."</td><td>".$json_contralavida->count."</td><tr>";
     

    if($conteo == 2)
    {

      $creadodata_contravida = $creadodata_contravida ." {
                        name: '".$json_contralavida->nombre_hecho."',
                        y: ".$json_contralavida->count.",
                        sliced: true,
                        selected: true
                    },";

    }else{

       $creadodata_contravida = $creadodata_contravida."['".$json_contralavida->nombre_hecho."',".$json_contralavida->count."],";

    //echo $json_contralavida->count;
    //echo $json_contralavida->nombre_hecho;
    # code...



    }//fin del contador para la dos

    

     $conteo = $conteo +1;
  }

    $cabezatabla = $cabezatabla."</tbody></table>";

  $creadodata_contravida =$creadodata_contravida . "]";

  $creadodata_contravida = str_replace("],]", "]]", $creadodata_contravida);
  //echo $creadodata_contravida;

    echo $cabezatabla;

 }//fin del else para hacer la grafica


        ?>

        <script type="text/javascript">

        $(function () {
      
      // Radialize the colors
 
    
    // Build the chart
        $('#viewcontrapatrimonio').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: true
            },
            title: {
                text: 'Delito Patrimonial Registrados'
            },
            tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                           // console.log(this.percentage);
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Hecho',
                data: <?php echo $creadodata_contravida; ?>
            }]
        });
    });
    

        </script>

        



      </div>
    </div>
  </div>
</div>
