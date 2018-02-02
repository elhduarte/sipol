<?php
date_default_timezone_set('America/Guatemala');

$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$id_cat_entidad = $variable_datos_usuario[0]->id_cat_entidad;
echo '<input type="text" id="idcomisaria" name="idcomisaria" value="'.$id_cat_entidad.'" style="display:none;">';
?>

<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/Highstock1310/js/highstock.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/Highstock1310/js/modules/exporting.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/Highstock1310/js/modules/drilldown.js"></script>

<style>

hr{
margin: 0px 0;
margin: 2%;
}

</style>
<div class="cuerpo">
<legend> GRAFICA EVENTO COMISARIA </legend>
    <div class="row-fluid" >

      <div class="span6">
            <blockquote>
                <p><i class="icon-calendar"></i>  Rango de Fechas</p> 
            </blockquote>
            <div class="row-fluid">
                <div class="span6">
                    <label class="campotit">Desde</label>
                    <input class="dateGral from_date span12"    type="text"  id="fechaIniGral4"  placeholder="Fecha Inicio" required>
                </div>
                <div class="span6">
                    <label class="campotit">Hasta</label>
                    <input class="dateGral to_date span12"  type="text"  id="fechaFinGral4"  placeholder="Fecha Fin" required>
                </div>
            </div>
        </div>
       <div class="span6">
            <blockquote>
                <p><i class="icon-bell"></i> Tipo Evento / Estado Evento </p> 
            </blockquote>

            <div class="row-fluid">
                <div class="span6">
                    <label class="campotit">Tipo Evento</label>
                    <?php
                    echo " <select  class='span12' name='descripcion_evento' id='tipo_evento' required>
                    <option selected value='t' >Seleccione un tipo de evento</option>";
                    $Criteria = new CDbCriteria();
                    $Criteria->order ='descripcion_evento ASC';
                    $data=CatTipoEvento::model()->findAll($Criteria);
                    $data=CHtml::listData($data,'id_tipo_evento','descripcion_evento');

                    foreach($data as $value=>$name)
                    {

                    echo '<option value="'.$value.'">'.$name.'</option>';
                    }
                    echo " </select>"; 
                    ?>
                </div>  <!-- fin span6-->
                
                <div class="span6">
                       <label class ="campotit">Eventos con estado</label>
                            <select  required  class="span12" name="estado" id="estado">
                                <option value="2">Todos</option>
                                <option value="1">Finalizado</option>
                                <option value="f">Pendiente</option>
                                
                            </select> 
                </div>
            </div>    <!-- fin rowfluid-->
        </div> <!-- fin span6-->
    </div> <!-- fin rowfluid-->
   

    <div id="hechos">
      
                <div class="row-fluid">
                 
                     <div class="span12">
                        <div align="RIGHT">
                            <button type="button" id="consultar" class="btn btn-primary">Consultar</button> 
                        </div>
                    </div>

                </div><!-- fin rowfluid-->
            </div> <!--fin span12-->
 
    </div> <!-- fin cuerpo hechos-->
    <div class="row-fluid">
        
    </div>  
</div> <!-- fin cuerpo-->


<div id="container";>

</div><!--fin del class cuerpo-->

<!-- Modal -->
<div id="myModalWeb" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Procesando Información</h3>
  </div>
  <div class="modal-body">
    <p> <img src="images/cargando.gif" alt="" style="height: auto; max-width: 5%;"> Esto puede Tardar unos minutos</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<?php 
$EventoComisaria = new Estadisticas;

$resultado= $EventoComisaria->EventoComisaria();
$entidades="";  
$denuncia="";  
$incidencia="";  
$extravio="";  

$entidades .= "[";
$denuncia .="[";
$incidencia .="[";
$extravio .="[";

function validarconteo($entrada)
{
if($entrada == "")
{
  return "0";
}else{
 //$entrada ="<strong>".$entrada."</strong>";
  return $entrada;
}
}
foreach ($resultado as $key => $value) 
{
 $json = json_encode($value);
 $json = json_decode($json);

  $entidades.="'".$json->entidad."',";
  $denuncia .= validarconteo($json->Denuncia).",";
  $incidencia .= validarconteo($json->Incidencia).",";
  $extravio .= validarconteo($json->Extravio).",";

}
$entidades .="]";
$denuncia .="]";
$incidencia .="]";
$extravio .="]";


/*
echo $denuncia;
echo "<br>";
echo $incidencia;
echo "<br>";
echo $extravio;
*/

?>


<script>
  $(document).ready(function(){
    var startDate = new Date('01/01/2012');
    var FromEndDate = new Date();
    var ToEndDate = new Date();

        ToEndDate.setDate(ToEndDate.getDate()+365);

        $('.from_date').datepicker({
            weekStart: 1,
            format: 'yyyy-mm-dd',
            startDate: '01/01/2012',
            endDate: FromEndDate, 
            autoclose: true
        })

        .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

            $('.to_date').datepicker('setStartDate', startDate);
        })

        $('.to_date').datepicker({
            weekStart: 1,
            startDate: startDate,
            format: 'yyyy-mm-dd',
            endDate: ToEndDate,
            autoclose: true
        })

        .on('changeDate', function(selected){
            FromEndDate = new Date(selected.date.valueOf());
            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
            $('.from_date').datepicker('setEndDate', FromEndDate);
        });


        $('#consultar').click(function(){

            var fechaIniGral4 = $('#fechaIniGral4').val();
            var fechaFinGral4 = $('#fechaFinGral4').val();
            var tipo_evento = $('#tipo_evento').val();
            var estado = $('#estado').val();
            console.log(fechaIniGral4+","+fechaFinGral4+","+tipo_evento+","+estado);
            console.log('entrando al ajax');

                    $.ajax({
                        url: '<?php echo Yii::app()->createUrl("Estadisticas/Graficatipoevento"); ?>',
                        type: 'POST',
                        data: {fechaIniGral4: fechaIniGral4,
                        fechaFinGral4:fechaFinGral4,
                        tipo_evento: tipo_evento,
                        estado:estado
                        },
                        beforeSend: function()
                        {
                        $('#procesoModal').modal('show');

                        },
                        error: function()
                        {
                        //  alert('ERROR')
                        },
                        success: function(response)
                        {
                        //alert(fechaIniGral4);
                       
                        $('#procesoModal').modal('hide');
                        $("#container").html('');
                        $("#container").html(response);
                       // $('#container').show(1000);
                        }
                    });//fin del ajax
            ///console.log('saliendo del ajax');
        }); // fin consultar 


    /*$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Eventos Por Comisaria'
        },
        xAxis: {
            categories: <?php echo $entidades; ?>
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Eventos Ingresados En Comisarias'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -70,
            verticalAlign: 'top',
            y: 30,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black, 0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: 'DENUNCIA',
            data: <?php echo $denuncia; ?>
        }, {
            name: 'INCIDENCIA',
            data: <?php echo $incidencia; ?>
        }, {
            name: 'EXTRAVIO',
            data: <?php echo $extravio; ?>
        }]
    });
});*/

 }); 
</script>