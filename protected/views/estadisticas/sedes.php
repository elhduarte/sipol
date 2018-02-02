<?php
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


<form class="form-horizontal" id="generargraficasubmit" name="generargraficasubmit">
<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span2">
      <center><label class="text-info">Tipo de Evento</label></center>
	      <select  required class="span12" name="tipoevento" id="tipoevento" >
	      	<option value="1">Denuncias</option>
		      	</select>
      </div>
        <div class="span2">
           <center><label class="text-info">Tipo de Sede</label></center>
	      <select  required class="span12" name="tiposede" id="tiposede" >
	       <option value="00">Todas</option>
			    <option value="2">Serenazgo</option>
			    <option value="3">Sub Estación </option>
			    <option value="4">Estacion Modelo</option>
			    <option value="6">Estacion</option>
			</select>
      </div>
        <div class="span2">
           <center><label class="text-info">Nombre Sede</label></center>
	      <select   class="span12"   name="sedes" id="sedes" >
        <option value="00">Todos</option>
		
			</select>
      </div>
      <div class="span4">
          

        <div class="form-inline" align="left" style="padding:1%; padding-bottom:5px;">
            <center>
        <label class="text-info">Filtro Para Gráficas</label>
            </center>
        <center>
        
          <label class="checkbox" for="calendariorango" id="Labelcalendariorango">
              <input type="checkbox" id="calendariorango" > Mostrar Rango de Fechas
          </label>
        </center>
        </div>
 


      <div id="rangofechadas" class="" hidden>
          <div class="row-fluid" >
          <div class="span12">
            <div class="row-fluid" style="padding:2%">
                <div class="span6">
                    <label class ="campotit">Fecha Inicial</label>
                    <input class="span11" type="text"  id="fecha1_sede">
                    <i class="icon-calendar" style="margin: -3px 0 0 -26px; pointer-events: none; position: relative;"></i>
                </div>
                <div class="span6">
                     <label class ="campotit">Fecha Final</label>
                    <input class="span11" type="text"  id="fecha2_sede">
                    <i class="icon-calendar" style="margin: -3px 0 0 -26px; pointer-events: none; position: relative;"></i>
                </div>
            </div> 
          </div>
          </div>
      </div>


       <div id="rangoglobal" class="">
          <div id="bonotesfechas">
          <center>

          <button name="boton1" id="boton1"  dia="1" class="btn btn-large btn-primary eventodia" type="button">HOY</button>
          <button name="boton2" id="boton2"  dia="2" class="btn btn-large btn-primary eventodia" type="button">AYER</button>
          <button name="boton3" id="boton3"  dia="3" class="btn btn-large btn-primary eventodia" type="button">1 SEM</button>
          <button name="boton5" id="boton5"  dia="5" class="btn btn-large btn-primary eventodia" type="button">1 MES</button>
          </center>
          </div>
       </div>
        
	
     </div>
      <div class="span2">
       <center>
        <a href="index.php?r=Estadisticas/index" role="button" class="btn btn-large btn-success" data-toggle="modal">
            <i class=" icon-arrow-left icon-white"></i> Ir al Menu </a>
        
          <button type="submit" name="boton5" id="boton5"  dia="5" class="btn btn-large btn-primary eventodia" style="margin-top: 11%;">Generar Grafica</button>
         
       </center>
      </div>
    </div>
  </div>

  <!-- INICIO DEL RANGO DE FECHA -->
  <hr>

  <!-- FIN DEL RANGO DE FECHA -->
</div>

</form>

<hr>
<div class="row-fluid">
  <div class="span12">
   <div id="cargargifprocesando" hidden>
   <center>
        <img src="images/cargando.gif" alt="" style="height: auto; max-width: 5%;">Procesando su petición
        </center>
  </div>
    <div class="row-fluid">
      <div class="span7">
      <div id="respuestaajax"></div>
      <div id="container1"></div>
     </div>
    
      <div class="span5">
      <div id="container2"></div>
     
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
       <div id="respuestaweb"></div>
      </div>
    </div>
    


<hr>
<div id="exportarBotones" align="right"> 

<!--<button class="btn btn-large btn-primary"   id="botonweb"   >WEB</button>-->
  <a href="#myModalexcel" role="button" class="btn btn-large btn-success"   id="excelbottonhabilitado"   data-toggle="modal">EXCEL</a>    
  
</div>

<!--<div id="respuestaweb">
	
</div> -->


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





<script>
  $(document).ready(function(){
/* $("#comisaria").select2({
    closeOnSelect:true
  });*/


$("#calendariorango").live("click", function(){
var id = parseInt($(this).val(), 10);
  if($(this).is(":checked")) {
    $('#rangofechadas').show(500);
    $('#rangoglobal').hide();
  } 
  else 
  {
    $('#rangoglobal').show(500);
    $('#rangofechadas').hide();
  }
});


function actualizaSede(entidad,tipo_sede)
{
  var entidad = entidad;
   var tipo_sede = tipo_sede;
  //var entidad = $('#cmb_entidad').val();
  $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('TblSede/getsede')."'"; ?>,
          data: {
            entidad:entidad,
            tipo_sede:tipo_sede
          },
           beforeSend: function(html)
          {
              $('#cargargifprocesando').show();
          },//fin beforesend
          success: function(result)
          {            
                $('#cargargifprocesando').hide();
            $("#sedes").empty();
            $("#sedes").html(result);
            $("#sedes").removeAttr('disabled');            
          }
        });
}


$('#tiposede').change(function(){
var entidad = $('#idcomisaria').val();
var tipo_sede = $('#tiposede').val();
actualizaSede(entidad,tipo_sede);
});

  $("#botonweb").click(function() {
  	$('#myModalWeb').modal('show');

  	var textevento = $("#tipoevento option:selected").html();
  	var textotiposede = $("#tiposede option:selected").html();
  	var textosedes = $("#sedes option:selected").html();
  	var tipoevento = $('#tipoevento').attr('class');
    var boton2 = $('#boton2').attr('class');
    var boton3 = $('#boton3').attr('class');
    var boton5 = $('#boton5').attr('class');
    var tiempo = "";
    var tipoevento = $('#tipoevento').val();
    var tiposede = $('#tiposede').val();
    var sedes = $('#sedes').val();
    var comisaria =$('#idcomisaria').val();
    if(boton1 == "btn btn-large btn-primary eventodia" && boton2 == "btn btn-large btn-primary eventodia" && boton3 == "btn btn-large btn-primary eventodia" 
     && boton5 == "btn btn-large btn-primary eventodia"  )
    {
      //alert("todos los campos son iguales");
      tiempo="1";
    }else{
      if(boton1 == "btn btn-large btn-danger eventodia")
      {
        tiempo="1";
      }else if(boton2 == "btn btn-large btn-danger eventodia")
      {
        tiempo="2";
      }else if(boton3 == "btn btn-large btn-danger eventodia")
      {
        tiempo="3";
      }else if(boton5 == "btn btn-large btn-danger eventodia")
      {
        tiempo="5";
      }else{
      	tiempo="1";
      }
    }
  	      $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticas/comisariafiltrosweb"); ?>',
        data:{
          tipoevento:tipoevento,
          tiposede:tiposede,
          sedes:sedes,
          tiempo:tiempo,
          comisaria:comisaria,
          textevento:textevento,
          textotiposede:textotiposede,
          textosedes:textosedes
        },
        beforeSend:function()
        {
         // $('#cargargifprocesando').show();
        },
        success:function(responde)
        { 
        	//$('#container1').html('');
        	//$('#container2').html('');
         $('#respuestaweb').html(responde);
         $('#myModalWeb').modal('hide');

          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
          // $('#cargargifprocesando').hide();

          
        },
      });//fin del ajax
      return false;


   // $(this).validarrequeridos();    
  });//fin de la funcion de click para el boton de 1 mes  






 $("#boton1").click(function() {
    $('#boton1').removeClass(); 
    $('#boton1').addClass("btn btn-large btn-danger eventodia");   
    $('#boton2').removeClass();  
    $('#boton2').addClass("btn btn-large btn-primary eventodia"); 
    $('#boton3').removeClass();
    $('#boton3').addClass("btn btn-large btn-primary eventodia");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn btn-large btn-primary eventodia"); 
    $('#boton5').removeClass(); 
    $('#boton5').addClass("btn btn-large btn-primary eventodia");   
    //$(this).validarrequeridos();
  });//fin de la funcion de click para el boton de 1 mes

  $("#boton2").click(function() {
    $('#boton1').removeClass(); 
    $('#boton1').addClass("btn btn-large btn-primary eventodia");   
    $('#boton2').removeClass();  
    $('#boton2').addClass("btn btn-large btn-danger eventodia");  
    $('#boton3').removeClass();
    $('#boton3').addClass("btn btn-large btn-primary eventodia");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn btn-large btn-primary eventodia"); 
    $('#boton5').removeClass(); 
    $('#boton5').addClass("btn btn-large btn-primary eventodia"); 
    //$(this).validarrequeridos();    
  });//fin de la funcion de click para el boton de 1 mes
  $("#boton3").click(function() {
    $('#boton1').removeClass(); 
    $('#boton1').addClass("btn btn-large btn-primary eventodia");   
    $('#boton2').removeClass();  
    $('#boton2').addClass("btn btn-large btn-primary eventodia"); 
    $('#boton3').removeClass();
    $('#boton3').addClass("btn btn-large btn-danger eventodia");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn btn-large btn-primary eventodia"); 
    $('#boton5').removeClass(); 
    $('#boton5').addClass("btn btn-large btn-primary eventodia"); 
    $('#graficador').html('');
    //$(this).validarrequeridos();
  });//fin de la funcion de click para el boton de 1 mes

  $("#boton5").click(function() {
    $('#boton1').removeClass(); 
    $('#boton1').addClass("btn btn-large btn-primary eventodia");   
    $('#boton2').removeClass();  
    $('#boton2').addClass("btn btn-large btn-primary eventodia"); 
    $('#boton3').removeClass();
    $('#boton3').addClass("btn btn-large btn-primary eventodia");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn btn-large btn-primary eventodia"); 
    $('#boton5').removeClass(); 
    $('#boton5').addClass("btn btn-large btn-danger eventodia");  
    $('#graficador').html('');
   // $(this).validarrequeridos();    
  });//fin de la funcion de click para el boton de 1 mes  


  $('#generargraficasubmit').submit(function(){

     if($("#calendariorango").is(':checked')) {  
            

    var tipoevento = $('#tipoevento').attr('class');
    var boton2 = $('#boton2').attr('class');
    var boton3 = $('#boton3').attr('class');
    var boton5 = $('#boton5').attr('class');
    var tiempo = "";
    var tipoevento = $('#tipoevento').val();
    var tiposede = $('#tiposede').val();
    var sedes = $('#sedes').val();
    var comisaria =$('#idcomisaria').val();
    var textoevento = $("#tipoevento option:selected").html();
    var textotiposede = $("#tiposede option:selected").html();
    var textosedes =  $("#sedes option:selected").html();
    var comisaria =$('#idcomisaria').val();

     var fecha1_sede = $('#fecha1_sede').val();
    var fecha2_sede = $('#fecha2_sede').val();

    var bandera = "1";
    if(boton1 == "btn btn-large btn-primary eventodia" && boton2 == "btn btn-large btn-primary eventodia" && boton3 == "btn btn-large btn-primary eventodia" 
     && boton5 == "btn btn-large btn-primary eventodia"  )
    {
      //alert("todos los campos son iguales");
      tiempo="1";
    }else{
      if(boton1 == "btn btn-large btn-danger eventodia")
      {
        tiempo="1";
      }else if(boton2 == "btn btn-large btn-danger eventodia")
      {
        tiempo="2";
      }else if(boton3 == "btn btn-large btn-danger eventodia")
      {
        tiempo="3";
      }else if(boton5 == "btn btn-large btn-danger eventodia")
      {
        tiempo="5";
      }else{
        tiempo="1";
      }
    }
console.log(sedes);
      $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticas/comisariafiltros"); ?>',
        data:{
          tipoevento:tipoevento,
          tiposede:tiposede,
          sedes:sedes,
          tiempo:tiempo,
          comisaria:comisaria,
          textevento:textevento,
          textotiposede:textotiposede,
          textosedes:textosedes,
          bandera:bandera,
          fecha1_sede:fecha1_sede,
          fecha2_sede:fecha2_sede
        },
        beforeSend:function()
        {
          $('#cargargifprocesando').show();
          $('#respuestaweb').html('');
          $('#container1').html('');
          $('#container2').html('');
        },
        success:function(responde)
        { 
         $('#respuestaweb').html('');
         $('#respuestaweb').html(responde);
         
          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
           $('#cargargifprocesando').hide();
           
        },
      });//fin del ajax
      return false;









        } else {  
            

              var tipoevento = $('#tipoevento').attr('class');
    var boton2 = $('#boton2').attr('class');
    var boton3 = $('#boton3').attr('class');
    var boton5 = $('#boton5').attr('class');
    var tiempo = "";
    var tipoevento = $('#tipoevento').val();
    var tiposede = $('#tiposede').val();
    var sedes = $('#sedes').val();
    var comisaria =$('#idcomisaria').val();
    var textoevento = $("#tipoevento option:selected").html();
    var textotiposede = $("#tiposede option:selected").html();
    var textosedes =  $("#sedes option:selected").html();
    var comisaria =$('#idcomisaria').val();

     var fecha1_sede = $('#fecha1_sede').val();
    var fecha2_sede = $('#fecha2_sede').val();

    var bandera = "0";
    if(boton1 == "btn btn-large btn-primary eventodia" && boton2 == "btn btn-large btn-primary eventodia" && boton3 == "btn btn-large btn-primary eventodia" 
     && boton5 == "btn btn-large btn-primary eventodia"  )
    {
      //alert("todos los campos son iguales");
      tiempo="1";
    }else{
      if(boton1 == "btn btn-large btn-danger eventodia")
      {
        tiempo="1";
      }else if(boton2 == "btn btn-large btn-danger eventodia")
      {
        tiempo="2";
      }else if(boton3 == "btn btn-large btn-danger eventodia")
      {
        tiempo="3";
      }else if(boton5 == "btn btn-large btn-danger eventodia")
      {
        tiempo="5";
      }else{
        tiempo="1";
      }
    }
console.log(sedes);
      $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticas/comisariafiltros"); ?>',
        data:{
          tipoevento:tipoevento,
          tiposede:tiposede,
          sedes:sedes,
          tiempo:tiempo,
          comisaria:comisaria,
          textevento:textevento,
          textotiposede:textotiposede,
          textosedes:textosedes,
          bandera:bandera,
          fecha1_sede:fecha1_sede,
          fecha2_sede:fecha2_sede
        },
        beforeSend:function()
        {
          $('#cargargifprocesando').show();
          $('#respuestaweb').html('');
          $('#container1').html('');
          $('#container2').html('');
        },
        success:function(responde)
        { 
         $('#respuestaweb').html('');
         $('#respuestaweb').html(responde);
         
          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
           $('#cargargifprocesando').hide();
           
        },
      });//fin del ajax
      return false;



        }  //fin si el check esta activo
   
  
 }); 


    var tiempo = "5";
    var tipoevento = "1";
    var tiposede ="00";
    var sedes = "00";
    //var comisaria ="";
    var comisaria =$('#idcomisaria').val();
    var textevento="";
    var textotiposede="";
    var textosedes="";

    var bandera = "0";
    var fecha1_sede = $('#fecha1_sede').val();
    var fecha2_sede = $('#fecha2_sede').val();

       $.ajax({
        type:'POST',
        url:'<?php echo CController::createUrl("Estadisticas/comisariafiltros"); ?>',
        data:{
          tipoevento:tipoevento,
          tiposede:tiposede,
          sedes:sedes,
          tiempo:tiempo,
          comisaria:comisaria,
          textevento:textevento,
          textotiposede:textotiposede,
          textosedes:textosedes,
          bandera:bandera,
          fecha1_sede:fecha1_sede,
          fecha2_sede:fecha2_sede
        },
        beforeSend:function()
        {
          $('#cargargifprocesando').show();
          $('#respuestaweb').html('');
          $('#container1').html('');
          $('#container2').html('');
        },
        success:function(responde)
        {          
           $('#respuestaweb').html('');
           $('#respuestaweb').html(responde);
         
          //window.open(response,'_blank');
         //$('#informacionsolicitante').hide();
           $('#cargargifprocesando').hide();
        },
      });//fin del ajax


$('#fecha1_sede').datepicker({
weekStart: 0,
   endDate: "setStartDate",
  format: "dd/mm/yyyy",
   language: "es",
   orientation: "top auto",
   keyboardNavigation: false,
   forceParse: false,
   autoclose: true
});

  $('#fecha2_sede').datepicker({
weekStart: 0,
   endDate: "setStartDate",
    format: "dd/mm/yyyy",
   language: "es",
   orientation: "top auto",
   keyboardNavigation: false,
   forceParse: false,
   autoclose: true
});




 }); 
</script>