
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
	      	<option value="3">Extravios</option>
	      	</select>
      </div>
        <div class="span2">
           <center><label class="text-info">Tipo de Sede</label></center>
	      <select  required class="span12" name="tiposede" id="tiposede" >
	       <option value="" style="display:none;">Todas</option>
			    <option value="2">Serenazgo</option>
			    <option value="3">Sub Estación </option>
			    <option value="4">Estacion Modelo</option>
			    <option value="6">Estacion</option>
			</select>
      </div>
        <div class="span2">
           <center><label class="text-info">Nombre Sede</label></center>
	      <select  required class="span12"  disabled name="sedes" id="sedes" >
		
			</select>
      </div>
      <div class="span4">
        <center><label class="text-info">Filtros de Fechas</label></center>
		<div id="bonotesfechas">
		 <center>
			<button name="boton1" id="boton1"  dia="1" class="btn btn-large btn-primary eventodia" type="button">HOY</button>
			<button name="boton2" id="boton2"  dia="2" class="btn btn-large btn-primary eventodia" type="button">AYER</button>
			<button name="boton3" id="boton3"  dia="3" class="btn btn-large btn-primary eventodia" type="button">1 SEM</button>
			<button name="boton5" id="boton5"  dia="5" class="btn btn-large btn-primary eventodia" type="button">1 MES</button>
		 </center>
		</div>
     </div>
      <div class="span2">
       <center>
      	<button type="submit" name="boton5" id="boton5"  dia="5" class="btn btn-large btn-primary eventodia" style="margin-top: 11%;">Generar Grafica</button>
       </center>
      </div>
    </div>
  </div>
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
          textosedes:textosedes
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
 }); 


    var tiempo = "5";
    var tipoevento = "1";
    var tiposede ="";
    var sedes = "";
    //var comisaria ="";
    var comisaria =$('#idcomisaria').val();
    var textevento="";
    var textotiposede="";
    var textosedes="";

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
          textosedes:textosedes
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






 }); 
</script>