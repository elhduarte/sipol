<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/lib/highcharts/Highstock/js/highstock.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/lib/highcharts/modules/exporting.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/lineas.js"></script>
<div class="row-fluid cuerpo">
  <div class="span12">
     <h3>SIPOL Dashboard Estatus 
        <button id="aniocuatro" class="btn btn-small btn-primary pull-right"  style="margin-left: 0.5%;" type="button">2014</button> 
        <button id="aniotres" class="btn btn-small  pull-right"  style="margin-left: 0.5%;" type="button">2013</button>
        <select id="tipo_evento" style="margin-top: 0.2%;" class="span2 pull-right">
          <option>Denuncias</option>
          <option>Extravios</option>
          <option>Incidencias</option>
          <option>Usuarios</option>
        </select></h3>
          <div class="row-fluid">
          <div class="span6">
             <p>En esta página se proporciona información sobre la estadistica y rendimiento de los servicios de Sipol. A menos que se indique lo contrario, esta información  se refiere a los servicios para usuarios (Administradores,Comisarios) y a los servicios para organizaciones que utilizan SIPOL.</p>
          </div>
        </div>

        <div id="centroenvio">
          <?php 
          $evento = "Denuncias";
          $tiempo = "2014";
          $this->renderPartial('sipol/view_center_dashboard',array('evento'=>$evento,'tiempo'=>$tiempo));
  ?>
        </div>

        <?php  //$this->renderPartial('sipol/view_center_dashboard');?>

  </div>
</div>


<style type="text/css">
.table-bordered td{
  vertical-align: middle;
  padding: 2px;
  text-align: center;
  font: normal 9pt Arial,Helvetica,sans-serif
}
.table-bordered th{
  vertical-align: middle;
  text-align: center;
  padding: 2px;
  font-weight:bold;
  font: normal 9pt Arial,Helvetica,sans-serif
}
</style>



    

<script>
 $('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>

<script type="text/javascript">
$(document).ready(function(){
 // Enviodatos();

  $("#aniocuatro").click(function() {
    $('#aniocuatro').removeClass(); 
    $('#aniocuatro').addClass("btn btn-small btn-primary pull-right");   
    $('#aniotres').removeClass();  
    $('#aniotres').addClass("btn btn-small  pull-right"); 
    Enviodatos();
  });//fin de la funcion de click para el boton de 1 mes

  $("#aniotres").click(function() {
    $('#aniocuatro').removeClass(); 
    $('#aniocuatro').addClass("btn btn-small  pull-right");   
    $('#aniotres').removeClass();  
    $('#aniotres').addClass("btn btn-small btn-primary pull-right");  
    Enviodatos();
  });//fin de la funcion de click para el boton de 1 mes
  $('#tipo_evento').change(function(){
     Enviodatos();

  });



function Enviodatos()
{
  //alert('hola estoy cargando');
 var evento = $('#tipo_evento').val();

 var aniocuatro = $('#aniocuatro').attr('class');
    var aniotres = $('#aniotres').attr('class');
    var tiempo = "";
    //alert(aniocuatro);
     // alert(aniotres);


      if(aniocuatro == "btn btn-small btn-primary pull-right")
      {
        tiempo = "2014";
        //alert('es igual');
      }else if(aniotres == "btn btn-small btn-primary pull-right")
      {
        tiempo="2013";
      }
    
//alert(tiempo);

 $.ajax({
         type: "POST",
         url: <?php echo "'".CController::createUrl('estadisticas/EnvioDashboard')."'"; ?>,
         data: {
           evento:evento,
           tiempo:tiempo
         },
          beforeSend: function(html)
         {
            $('#modalprocesando').modal({
                     show: true,
                     keyboard: false,
                     backdrop: "static"
                 });
         },//fin beforesend
         success: function(result)
         {            
              $('#modalprocesando').modal('hide');
          // $("#centroenvio").empty();
           $("#centroenvio").html(result);
          // $("#centroenvio").removeAttr('disabled');            
         }
       });
}



});

</script>