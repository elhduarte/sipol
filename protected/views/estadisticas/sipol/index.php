<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/lib/highcharts/Highstock/js/highstock.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/lib/highcharts/modules/exporting.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/lineas.js"></script>
<style>
	#datosextravio{
		display: none;
	}
	#datosincidencia{
		display: none;
	}
</style>
<div class="cuerpo-estadistica">
<div class="row-fluid">
  <div class="span12">
  	<!--Parte de la Vista titulo y tipo de grafica-->
    <div class="row-fluid">
      <div class="span12">
      	<legend style="margin-bottom: 2%;"><img style="" src="images/icons/glyphicons_040_stats.png"  alt=""> Estadisticas SIPOL
      		  <div  class="pull-right">
					<label class="radio inline radioInline">
					<input type="radio" id ="tipo" name="tipo" value="1" checked> Denuncia
					</label>
					<label class="radio inline radioInline">
					<input type="radio" id ="tipo" name="tipo" value="2"> Extravío
					</label>
					<label class="radio inline radioInline">
					<input type="radio" id ="tipo" name="tipo" value="3">Incidencia
					</label>
      			</div>
      	</legend>     
      </div>
    
    </div>
    <!--Termina la vista de titulo y tipo de graficas-->

     	<!--Parte de la Vista titulo y tipo de grafica-->
    <div class="row-fluid">
      <div class="span6">
          <blockquote>
			    <p>
			    	<i class="icon-calendar"></i> Rango de Fechas
			    	  	<label  class="checkbox pull-right">
	                  		<input class ="" id="visualizarfechas" type="checkbox"> Rangos de Fechas
	             		</label>
			    </p>	
		    </blockquote>
		    
	<div id="rangosfechas">
          <div id="botonesfechas">
            <center>            
                <button class="btn" id="grafica_denuncia_unmes">1 Mes</button> 
                <button class="btn" id="grafica_denuncia_dossemana">2 Semanas</button> 
                <button class="btn" id="grafica_denuncia_unasemana">1 Semanas</button>     
                <button class="btn" id="grafica_denuncia_ayer">Ayer</button>   
                <button class="btn" id="grafica_denuncia_hoy" >Hoy</button>               
            </center>
          </div>
          <div id="inputfechas" style="display:none;">
              <div class="row-fluid">
              <div class ="span6">
              <label class ="campotit">Fecha Inicial</label>
              <input class="span11" type="text" value="<?php echo $hoy = date("d/m/Y");   ?>"  id="fecha1" required>
              <i class="icon-calendar" style="margin: -3px 0 0 -26px; pointer-events: none; position: relative;"></i>
              </div>
              <div class ="span6">
              <label class ="campotit">Fecha Final</label>
              <input class="span11" type="text" value="<?php echo $hoy = date("d/m/Y");   ?>" id="fecha2" required>
              <i class="icon-calendar" style="margin: -3px 0 0 -26px; pointer-events: none; position: relative;"></i>
              </div>
            </div>
          </div>
        </div>  
		</div>    
      <div  class="span6">
			<blockquote>
			<p><i class="icon-globe"></i> Ubicación De Los Hechos</p>	
			</blockquote>

      	
		 <div class ="row-fluid">
    <div class ="span6">
      <label class ="campotit">Departamento</label>
      <select class ="span12" name="cmb_depto" id="cmb_depto">
      <?php
      $Criteria = new CDbCriteria();
      $Criteria->order ='departamento ASC';
      $data=CatDepartamentos::model()->findAll($Criteria);
      $data=CHtml::listData($data,'cod_depto','departamento');
      echo '<option value="Todos">Todos</option>';
      foreach($data as $value=>$name)
      {
      echo '<option value="'.$value.'">'.$name.'</option>';
      }
      ?>
      </select>
      </div>
    <div class ="span6">
      <label class ="campotit">Municipios</label>
      <select disabled ="yes" class="span12" id="cmb_mupio" name ="cmb_mupio">
      </select>
    </div>
    </div>

      </div>
    </div>
    
    <!--Termina la vista de titulo y tipo de graficas-->

  </div>
</div>




</div>




<div class="row-fluid">
  <div class="span12 cuerpo-estadistica">
    <div class="row-fluid">
      <div class="span8">
        <blockquote>
          <p><i class="icon-map-marker"></i> Lugar De Emisión</p> 
        </blockquote>
        <div class="row-fluid">
          <div class="span3">
            <label class="campotit">Region</label>
            <select  required  class="span12" name="region" id="region">
                 <option value="0">Todos</option>
                 <option value="8">MINGOB</option>
                    <option value="1">Region Central</option>
                    <option value="2">Region Oriente</option>
                    <option value="3">Region Nororiente</option>
                    <option value="4">Region Occidente</option>
                    <option value="5">Region Noroccidente</option>
                    <option value="6">Region Sur</option>
                    <option value="7">Region Norte</option>
                  </select>  
            </div><!--termina region-->
          <div class="span3">
            <label class="campotit">Comisaria</label>
             <select  required  class="span12" name="entidad" id="entidad">
               <?php 
                 $variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
                 $id_rol = $variable_datos_usuario[0]->id_rol; 
                 $id_cat_entidad = $variable_datos_usuario[0]->id_cat_entidad;                                                
                 $data=CatEntidad::model()->crearcomboentidad($id_rol,$id_cat_entidad);  
                 echo '<option value="" style="display:none;">Seleccione Entidad</option>';
                 foreach($data as $value=>$name)
                 {
                 echo '<option value="'.$value.'">'.$name.'</option>';
                 }                 
               ?>
             </select>
          </div><!--termina comisaria-->
          <div class="span3">
            <label class="campotit">Tipo de Sede</label>
               <select required  class="span12" name="tipo_sede" id="tipo_sede">
                  <?php                        
                   $Criteria = new CDbCriteria();
                   $Criteria->order ='id_tipo_sede ASC';
                   $data=CatTipoSede::model()->findAll($Criteria);
                   $data=CHtml::listData($data,'id_tipo_sede','descripcion');                         
                   echo '<option value="0">Todos</option>'; 
                   foreach($data as $value=>$name)
                   {
                   
                   echo '<option value="'.$value.'">'.$name.'</option>';
                   }                        
                 ?>
                </select>
          </div><!--tipo de sede-->
          <div class="span3">
              <label class="campotit">Sede </label>
                <select required  disabled class="span12" name="sede" id="sede">
                      <option value="" style="display:none;">Seleccione una Sede</option>
                </select> 
          </div><!--termina sede-->
        </div>
      </div><!--fin del row para las sedes-->
      <div class="span4">

        <div id="cathechosdenuncia">
        <blockquote>
            <p><i class="icon-map-marker"></i> Hechos Denuncia</p> 
        </blockquote>
        <div class="row-fluid">
          <div class="span6">
              <label class ="campotit">Tipo de Hecho</label>
                <select class ="span12" name="tipo_hecho" id="tipo_hecho">
                <?php
                $Criteria = new CDbCriteria();
                $Criteria->order ='tipo ASC';
                $data=CatHechoTipo::model()->findAll($Criteria);
                $data=CHtml::listData($data,'id_hecho_tipo','tipo');
                echo '<option value="Todos">Todos</option>';
                foreach($data as $value=>$name)
                {
                echo '<option value="'.$value.'">'.$name.'</option>';
                }
                ?>
                </select>
          </div>
          <div class="span6">
              <label class ="campotit">Hecho</label>
              <select disabled ="yes" class="span12" id="hecho_denuncia" name ="hecho_denuncia">
              </select>
          </div>
        </div>
          </div>

            <div id="cathechosextravios" style="display:none;">
        <blockquote>
            <p><i class="icon-map-marker"></i> Hechos Extravio</p> 
        </blockquote>  
              <label class ="campotit">Tipo de Hecho</label>
                <select class ="span12" name="tipo_hecho" id="tipo_hecho">
                <?php
                $Criteria = new CDbCriteria();
                $Criteria->order ='nombre_extravio ASC';
                $data=CatExtravios::model()->findAll($Criteria);
                $data=CHtml::listData($data,'id_extravio','nombre_extravio');
                echo '<option value="Todos">Todos</option>';
                foreach($data as $value=>$name)
                {
                echo '<option value="'.$value.'">'.$name.'</option>';
                }
                ?>
                </select>         
       
       
          </div>



      </div><!--fin del row para los tipos de hechos sobre denuncia-->
    </div>
  </div>
</div>

<div id="datosdenuncia" class="cuerpo-estadistica">
  <div id="resumendenuncia">

    <?php 
$this->renderPartial("sipol/global_resumen");
    ?>   
  </div><!--Este es el final de la resumen de sipol-->
</div>
  <!-- Modal -->
<div id="modalpdfdenuncia" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
   <h4 id="myModalLabel">Vista Previa Denuncia</h4>
 </div>
 <div class="modal-body">
         <div id="iframedenuncia">
        </div>
 </div>
 <div class="modal-footer">
   <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
 </div>
</div>
</div>
<script type="text/javascript">
 $(document).ready(function()
 {
    $("#grafica_denuncia_hoy").click(function() {
    $('#grafica_denuncia_hoy').removeClass(); 
    $('#grafica_denuncia_hoy').addClass("btn  btn-primary");   
    $('#grafica_denuncia_ayer').removeClass();  
    $('#grafica_denuncia_ayer').addClass("btn "); 
    $('#grafica_denuncia_unasemana').removeClass();
    $('#grafica_denuncia_unasemana').addClass("btn ");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn "); 
    $('#grafica_denuncia_unmes').removeClass(); 
    $('#grafica_denuncia_unmes').addClass("btn ");   
    $(this).validarrequeridos();
  });//fin de la funcion de click para el boton de 1 mes

  $("#grafica_denuncia_ayer").click(function() {
    $('#grafica_denuncia_hoy').removeClass(); 
    $('#grafica_denuncia_hoy').addClass("btn");   
    $('#grafica_denuncia_ayer').removeClass();  
    $('#grafica_denuncia_ayer').addClass("btn btn-primary");  
    $('#grafica_denuncia_unasemana').removeClass();
    $('#grafica_denuncia_unasemana').addClass("btn");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn"); 
    $('#grafica_denuncia_unmes').removeClass(); 
    $('#grafica_denuncia_unmes').addClass("btn"); 
    $(this).validarrequeridos();    
  });//fin de la funcion de click para el boton de 1 mes
  $("#grafica_denuncia_unasemana").click(function() {
    $('#grafica_denuncia_hoy').removeClass(); 
    $('#grafica_denuncia_hoy').addClass("btn");   
    $('#grafica_denuncia_ayer').removeClass();  
    $('#grafica_denuncia_ayer').addClass("btn"); 
    $('#grafica_denuncia_unasemana').removeClass();
    $('#grafica_denuncia_unasemana').addClass("btn btn-primary");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn"); 
    $('#grafica_denuncia_unmes').removeClass(); 
    $('#grafica_denuncia_unmes').addClass("btn"); 
    $('#graficador').html('');
    $(this).validarrequeridos();
  });//fin de la funcion de click para el boton de 1 mes
  $("#grafica_denuncia_dossemana").click(function() {
    $('#grafica_denuncia_hoy').removeClass(); 
    $('#grafica_denuncia_hoy').addClass("btn");   
    $('#grafica_denuncia_ayer').removeClass();  
    $('#grafica_denuncia_ayer').addClass("btn"); 

    $('#grafica_denuncia_unasemana').removeClass();
    $('#grafica_denuncia_unasemana').addClass("btn");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn btn-primary");  
    $('#grafica_denuncia_unmes').removeClass(); 
    $('#grafica_denuncia_unmes').addClass("btn"); 
    $('#graficador').html('');
    $(this).validarrequeridos();    
  });//fin de la funcion de click para el boton de 1 mes
  $("#grafica_denuncia_unmes").click(function() {
    $('#grafica_denuncia_hoy').removeClass(); 
    $('#grafica_denuncia_hoy').addClass("btn");   
    $('#grafica_denuncia_ayer').removeClass();  
    $('#grafica_denuncia_ayer').addClass("btn"); 
    $('#grafica_denuncia_unasemana').removeClass();
    $('#grafica_denuncia_unasemana').addClass("btn");     
    $('#grafica_denuncia_dossemana').removeClass(); 
    $('#grafica_denuncia_dossemana').addClass("btn"); 
    $('#grafica_denuncia_unmes').removeClass(); 
    $('#grafica_denuncia_unmes').addClass("btn btn-primary");  
    $('#graficador').html('');
    $(this).validarrequeridos();    
  });//fin de la funcion de click para el boton de 1 mes    
  function actualizaMupio(recibe)
  {

  var depto = recibe;
  $.ajax({
    type: "POST",
    url: <?php echo "'".CController::createUrl('CatMunicipios/getMupios')."'"; ?>,
    data: {param:depto},
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
      $("#cmb_mupio").empty();
      $("#cmb_mupio").html(result);
      $("#cmb_mupio").removeAttr('disabled');            
    }
  });
  }//FIN ACTUALIZA LOS MUNICIPIOS

function actualizaTipo(recibe)
{
  var hecho_tipo = recibe;
  if(hecho_tipo == '')
  {
    $("#cmb_tipo").empty();
    $("#cmb_tipo").attr('disabled','true')
  }
  else
  {
  //var depto = $('#cmb_depto').val();
    $.ajax({
      type: "POST",
      url: <?php echo "'".CController::createUrl('Evento/getTipo')."'"; ?>,
      data: {param:hecho_tipo},
      success: function(result)
      {
        
        $("#cmb_tipo").empty();
        $("#cmb_tipo").html(result);
        $("#cmb_tipo").removeAttr('disabled');
        //alert(result); 
      }
    });
  }
} 
function actualizaSede(entidad,tipo_sede)
{
 var entidad = entidad;
  var tipo_sede = tipo_sede;
 $.ajax({
         type: "POST",
         url: <?php echo "'".CController::createUrl('TblSede/getsede')."'"; ?>,
         data: {
           entidad:entidad,
           tipo_sede:tipo_sede
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
           $("#sede").empty();
           $("#sede").html(result);
           $("#sede").removeAttr('disabled');            
         }
       });
}
function actualizaEntidad(regionn)
{
 var region = regionn;
 $.ajax({
         type: "POST",
         url: <?php echo "'".CController::createUrl('CatEntidad/getentidad')."'"; ?>,
         data: {
           region:region
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
           $("#entidad").empty();
           $("#entidad").html(result);
           $("#entidad").removeAttr('disabled');            
         }
       });
}

function actualizaHechos(tipo_hecho)
{
 var tipo_hechos = tipo_hecho;
 $.ajax({
         type: "POST",
         url: <?php echo "'".CController::createUrl('CatHechoDenuncia/gethechos')."'"; ?>,
         data: {
           id_hecho_tipo:tipo_hechos
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
           $("#hecho_denuncia").empty();
           $("#hecho_denuncia").html(result);
           $("#hecho_denuncia").removeAttr('disabled');            
         }
       });
}
/*Termina filtros de Ubicacion de los Hechos*/
 //Funcion para change del departamento
$('#cmb_depto').change(function()
{
  //limpia los valores del objeto municpio
  $('#cmb_mupio').val('');
  //obtenemos el valor de departamento
  var departamento = $('#cmb_depto').val();
  //llamamos la funcion de validacion para hacer los campos requeridos
  $(this).validarrequeridos();
  //actualiza los mucipio con respecto al codigo del municipo
  actualizaMupio(departamento);
  
});
$('#cmb_mupio').change(function()
{
  $(this).validarrequeridos(); 
});



/*Termina filtros de Ubicacion de los Hechos*/

/*Inicia filtros de lugar de emision para metodos change*/
 $('#region').change(function(){

  $('#entidad').val('');
  $('#tipo_sede').val('');
  $('#sede').val('');

    var regionn = $('#region option:selected').text();
    actualizaEntidad(regionn);
    $(this).validarrequeridos(); 
  });

 $('#entidad').change(function(){
   $('#tipo_sede').val('');
  $('#sede').val('');
    var comisaria =  $('#entidad').val();  
    var tipo_sede = $('#tipo_sede').val();
    actualizaSede(comisaria,tipo_sede);
    $(this).validarrequeridos(); 
  });
$('#tipo_sede').change(function(){
  $('#sede').val('');
    var entidad = $('#entidad').val();
    var tipo_sede = $('#tipo_sede').val();

     if(entidad == '' || entidad == 'Seleccione Entidad' || entidad == 0)
      {
        //alert('esta vacio comisaria');
        alert('Seleccione una Entidad');
      }else{
    actualizaSede(entidad,tipo_sede);
     $(this).validarrequeridos(); 
      }
  });
  $('#sede').change(function(){
    var sede = $('#sede').val();
    $(this).validarrequeridos(); 
  });
/*Termina filtros de lugar de emision para metodos change*/
/*funciones de Change para consulta sobre denuncia*/
  $('#tipo_hecho').change(function(){
    $('#hecho_denuncia').val('');
    var tipo_hecho =  $('#tipo_hecho').val();
      actualizaHechos(tipo_hecho);
       $(this).validarrequeridos();
  });

   $('#hecho_denuncia').change(function(){
    
    var hecho =  $('#hecho_denuncia option:selected').text();
       $(this).validarrequeridos();
       //$(this).validarhechoseleccionado(hecho);
  });



$('#fecha1').change(function()
{
  $(this).validarrequeridos(); 
});

   $('#fecha2').change(function()
{
  $(this).validarrequeridos(); 
});
//funcion que valida los requeridos
$.fn.validarrequeridos = function()
{
var fechainicio = '';
var fechafinal = '';
var estadofecha = 0;
var hechosdenuncia = $('#hecho_denuncia option:selected').text();
//alert(hechosdenuncia);
  /*Consulta el tiempo seleccionado*/
    var grafica_denuncia_hoy = $('#grafica_denuncia_hoy').attr('class');
    var grafica_denuncia_ayer = $('#grafica_denuncia_ayer').attr('class');
    var grafica_denuncia_unasemana = $('#grafica_denuncia_unasemana').attr('class');
    var grafica_denuncia_dossemana = $('#grafica_denuncia_dossemana').attr('class');
    var grafica_denuncia_unmes = $('#grafica_denuncia_unmes').attr('class');
    var tiempo = "";
    if(grafica_denuncia_hoy == "btn" && grafica_denuncia_ayer == "btn" && grafica_denuncia_unasemana == "btn" 
     &&  grafica_denuncia_dossemana == "btn"  && grafica_denuncia_unmes == "btn"  )
    {
      //alert("todos los campos son iguales");
      tiempo="6";
    }else{
      if(grafica_denuncia_hoy == "btn btn-primary")
      {
        tiempo="1";
      }else if(grafica_denuncia_ayer == "btn btn-primary")
      {
        tiempo="2";
      }else if(grafica_denuncia_unasemana == "btn btn-primary")
      {
        tiempo="3";
      }else if(grafica_denuncia_dossemana == "btn btn-primary")
      {
        tiempo="4";
      }else if(grafica_denuncia_unmes == "btn btn-primary")
      {
        tiempo="5";
      }
    }
  if($("#visualizarfechas").is(':checked')) {  
            //alert("Está activado");
            fechainicio = $('#fecha1').val();
            fechafinal = $('#fecha2').val();
            estadofecha = 1;
        } else {  
           // alert("No está activado");  
           estadofecha = 0;
        }  
      var departamento = $('#cmb_depto option:selected').text();
      var municipio = $('#cmb_mupio option:selected').text();
      var region = $('#region option:selected').text();
      var comisaria = $('#entidad').val();
      var tipo_sede = $('#tipo_sede').val();
      var sede = $('#sede').val();
      /*Filtros para denuncia*/
      var tipo_hecho = $('#tipo_hecho').val();
      if(departamento == '' || departamento == 'Todos' || departamento == 0)
      {
        //alert('esta vacio departamento');
        departamento ="Todos";
      }
      if(municipio == '' || municipio == 'Seleccione un Municipio' || municipio == 0 || municipio == 'Todos los Municipios')
      {
        //alert('esta vacio municipio');
        municipio ="Todos";
      }
      if(region == '' || region == 'Todos' || region == 0)
      {
        //alert('esta vacio region');
        region ="Todos";
      }
      if(comisaria == '' || comisaria == 'Seleccione Entidad' || comisaria == 0)
      {
        //alert('esta vacio comisaria');
        comisaria ="Todos";
      }
      if(tipo_sede == '' || tipo_sede == 'Todos' || tipo_sede == 0)
      {
       // alert('esta vacio tipo_sede');
        tipo_sede ="Todos";
      }
       if(sede == '' || sede == 'seleccione una Sede' || sede == 0)
      {
        //alert('esta vacio sede');
        sede ="Todos";
      }
      if(tipo_hecho == '' || tipo_hecho == 'Todos'  || tipo_hecho == 0)
      {
        //alert('esta vacio sede');
        tipo_hecho ="Todos";
      }
       var tipo = $('input:radio[name=tipo]:checked').val();
       if(tipo == 1)
      {      
       // $('#datosextravio').hide(500);
        //$('#datosincidencia').hide(500);
        //$('#datosdenuncia').show(500);
          $(this).Enviardenuncia(tipo,tiempo,departamento,municipio,region,comisaria,tipo_sede,sede,tipo_hecho,estadofecha,fechainicio,fechafinal,hechosdenuncia);           
      }else if(tipo == 2){
        $(this).Enviarextravio(tipo,tiempo,departamento,municipio,region,comisaria,tipo_sede,sede,tipo_hecho,estadofecha,fechainicio,fechafinal); 
        //$('#datosdenuncia').hide(500);
        //$('#datosincidencia').hide(500);        
        //$('#datosextravio').show(500);
      }else{
        $(this).Enviarincidencia();
        //$('#datosdenuncia').hide(500);
        //$('#datosextravio').hide(500);
        //$('#datosincidencia').show(500);        
      }
}//fin de la consuta validador de datos
//funcion que valida los requeridos


//funcion que valida los requeridos
$.fn.validarrequeridoslistahechos = function(valorhecho)
{
var fechainicio = '';
var fechafinal = '';
var estadofecha = 0;
//var hechosdenuncia = $('#hecho_denuncia option:selected').text();
var hechosdenuncia = valorhecho;

//alert(hechosdenuncia);
  /*Consulta el tiempo seleccionado*/
    var grafica_denuncia_hoy = $('#grafica_denuncia_hoy').attr('class');
    var grafica_denuncia_ayer = $('#grafica_denuncia_ayer').attr('class');
    var grafica_denuncia_unasemana = $('#grafica_denuncia_unasemana').attr('class');
    var grafica_denuncia_dossemana = $('#grafica_denuncia_dossemana').attr('class');
    var grafica_denuncia_unmes = $('#grafica_denuncia_unmes').attr('class');
    var tiempo = "";
    if(grafica_denuncia_hoy == "btn" && grafica_denuncia_ayer == "btn" && grafica_denuncia_unasemana == "btn" 
     &&  grafica_denuncia_dossemana == "btn"  && grafica_denuncia_unmes == "btn"  )
    {
      //alert("todos los campos son iguales");
      tiempo="6";
    }else{
      if(grafica_denuncia_hoy == "btn btn-primary")
      {
        tiempo="1";
      }else if(grafica_denuncia_ayer == "btn btn-primary")
      {
        tiempo="2";
      }else if(grafica_denuncia_unasemana == "btn btn-primary")
      {
        tiempo="3";
      }else if(grafica_denuncia_dossemana == "btn btn-primary")
      {
        tiempo="4";
      }else if(grafica_denuncia_unmes == "btn btn-primary")
      {
        tiempo="5";
      }
    }
  if($("#visualizarfechas").is(':checked')) {  
            //alert("Está activado");
            fechainicio = $('#fecha1').val();
            fechafinal = $('#fecha2').val();
            estadofecha = 1;
        } else {  
           // alert("No está activado");  
           estadofecha = 0;
        }  
      var departamento = $('#cmb_depto option:selected').text();
      var municipio = $('#cmb_mupio option:selected').text();
      var region = $('#region option:selected').text();
      var comisaria = $('#entidad').val();
      var tipo_sede = $('#tipo_sede').val();
      var sede = $('#sede').val();
      /*Filtros para denuncia*/
      var tipo_hecho = $('#tipo_hecho').val();
      if(departamento == '' || departamento == 'Todos' || departamento == 0)
      {
        //alert('esta vacio departamento');
        departamento ="Todos";
      }
      if(municipio == '' || municipio == 'Seleccione un Municipio' || municipio == 0 || municipio == 'Todos los Municipios')
      {
        //alert('esta vacio municipio');
        municipio ="Todos";
      }
      if(region == '' || region == 'Todos' || region == 0)
      {
        //alert('esta vacio region');
        region ="Todos";
      }
      if(comisaria == '' || comisaria == 'Seleccione Entidad' || comisaria == 0)
      {
        //alert('esta vacio comisaria');
        comisaria ="Todos";
      }
      if(tipo_sede == '' || tipo_sede == 'Todos' || tipo_sede == 0)
      {
       // alert('esta vacio tipo_sede');
        tipo_sede ="Todos";
      }
       if(sede == '' || sede == 'seleccione una Sede' || sede == 0)
      {
        //alert('esta vacio sede');
        sede ="Todos";
      }
      if(tipo_hecho == '' || tipo_hecho == 'Todos'  || tipo_hecho == 0)
      {
        //alert('esta vacio sede');
        tipo_hecho ="Todos";
      }
       var tipo = $('input:radio[name=tipo]:checked').val();
       if(tipo == 1)
      {      
        //$('#datosextravio').hide(500);
        //$('#datosincidencia').hide(500);
        //$('#datosdenuncia').show(500);
          $(this).Enviardenunciados(tipo,tiempo,departamento,municipio,region,comisaria,tipo_sede,sede,tipo_hecho,estadofecha,fechainicio,fechafinal,hechosdenuncia);           
      }else if(tipo == 2){
        $(this).Enviarextravio(tipo,tiempo,departamento,municipio,region,comisaria,tipo_sede,sede,tipo_hecho,estadofecha,fechainicio,fechafinal); 
        //$('#datosdenuncia').hide(500);
        //$('#datosincidencia').hide(500);        
        //('#datosextravio').show(500);
      }else{
        $(this).Enviarincidencia();
        //$('#datosdenuncia').hide(500);
       // $('#datosextravio').hide(500);
        //$('#datosincidencia').show(500);        
      }
}//fin de la consuta validador de datos
//funcion que valida los requeridos


$.fn.Enviardenuncia = function(tipo,tiempo,departamento,municipio,region,comisaria,tipo_sede,sede,tipo_hecho,estadofecha,fechainicio,fechafinal,hechosdenuncia)
    {
      //alert('soy Enviardenuncia');
     /* $(this).validarrequeridos();*/

       $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('estadisticas/ResumenDenuncia')."'"; ?>,
          data: {
            tipo:tipo,
            tiempo:tiempo,
            departamento:departamento,
            municipio:municipio,
            region:region,
            comisaria:comisaria,
            tipo_sede:tipo_sede,
            sede:sede,
            tipo_hecho:tipo_hecho,
            estadofecha: estadofecha,
            fechainicio: fechainicio,
            fechafinal:fechafinal,
            hechosdenuncia:hechosdenuncia
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
              // $("#graficasdenuncias").html(''); 
               //$("#graficatiemposporhechos").html('');                 
              $("#resumendenuncia").html(result);               
     
         }

        });

     
    }
    $.fn.Enviardenunciados = function(tipo,tiempo,departamento,municipio,region,comisaria,tipo_sede,sede,tipo_hecho,estadofecha,fechainicio,fechafinal,hechosdenuncia)
    {
      //alert('soy Enviardenuncia');
     /* $(this).validarrequeridos();*/

       $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('estadisticas/ResumenHechosListado')."'"; ?>,
          data: {
            tipo:tipo,
            tiempo:tiempo,
            departamento:departamento,
            municipio:municipio,
            region:region,
            comisaria:comisaria,
            tipo_sede:tipo_sede,
            sede:sede,
            tipo_hecho:tipo_hecho,
            estadofecha: estadofecha,
            fechainicio: fechainicio,
            fechafinal:fechafinal,
            hechosdenuncia:hechosdenuncia
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
               $("#resumenesporhechos").html(''); 
               //$("#graficatiemposporhechos").html('');                 
              $("#resumenesporhechos").html(result);               
     
         }

        });

     
    }
    $.fn.Enviarextravio = function(tipo,tiempo,departamento,municipio,region,comisaria,tipo_sede,sede,tipo_hecho,estadofecha,fechainicio,fechafinal)
    {

          $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('estadisticas/graficasdenuncias')."'"; ?>,
          data: {
            tipo:tipo,
            tiempo:tiempo,
            departamento:departamento,
            municipio:municipio,
            region:region,
            comisaria:comisaria,
            tipo_sede:tipo_sede,
            sede:sede,
            tipo_hecho:tipo_hecho,
            estadofecha: estadofecha,
            fechainicio: fechainicio,
            fechafinal:fechafinal
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
              $("#resumendenuncia").html('');   
              $("#resumendenuncia").html(result);       
         }

        });

     //alert('soy Enviarextravio');
    }


$('#fecha1').datepicker({
weekStart: 0,
   endDate: "setStartDate",
    format: "dd/mm/yyyy",
   language: "es",
   orientation: "top auto",
   keyboardNavigation: false,
   forceParse: false,
   autoclose: true
});

  $('#fecha2').datepicker({
weekStart: 0,
   endDate: "setStartDate",
    format: "dd/mm/yyyy",
   language: "es",
   orientation: "top auto",
   keyboardNavigation: false,
   forceParse: false,
   autoclose: true
});

  $("#visualizarfechas").live("click", function(){
    var id = parseInt($(this).val(), 10);
    if($(this).is(":checked"))
    {
       $('#inputfechas').show(500);
    $('#botonesfechas').hide(500);
    $(this).validarrequeridos();
      //alert('esta check');
    } 
    else 
    {
       $('#inputfechas').hide(500);
    $('#botonesfechas').show(500);
    $(this).validarrequeridos();
    }
  }); 



  

   $("#tipo").live("click", function(){
    //var id = parseInt($(this).val(), 10);
    var posicion =  $(this).val();
    if(posicion == 1)
    {
      $('#cathechosextravios').hide();
        $('#cathechosdenuncia').show();      
      $(this).validarrequeridos();
    }else if (posicion == 2)
    {
      $('#cathechosdenuncia').hide();
      $('#cathechosextravios').show();
      $(this).validarrequeridos();
    }else
    {

    }   
   
 

  }); 




//funcion que valida los requeridos
$.fn.validarrequeridostiempo = function(hecho)
{
  var fechainicio = '';
  var fechafinal = '';
  var estadofecha = 0;
  /*Consulta el tiempo seleccionado*/
    var grafica_denuncia_hoy = $('#grafica_denuncia_hoy').attr('class');
    var grafica_denuncia_ayer = $('#grafica_denuncia_ayer').attr('class');
    var grafica_denuncia_unasemana = $('#grafica_denuncia_unasemana').attr('class');
    var grafica_denuncia_dossemana = $('#grafica_denuncia_dossemana').attr('class');
    var grafica_denuncia_unmes = $('#grafica_denuncia_unmes').attr('class');
    var tiempo = "";
    if(grafica_denuncia_hoy == "btn" && grafica_denuncia_ayer == "btn" && grafica_denuncia_unasemana == "btn" 
     &&  grafica_denuncia_dossemana == "btn"  && grafica_denuncia_unmes == "btn"  )
    {
      //alert("todos los campos son iguales");
      tiempo="6";

    }else{
      if(grafica_denuncia_hoy == "btn btn-primary")
      {
        tiempo="1";
      }else if(grafica_denuncia_ayer == "btn btn-primary")
      {
        tiempo="2";
      }else if(grafica_denuncia_unasemana == "btn btn-primary")
      {
        tiempo="3";
      }else if(grafica_denuncia_dossemana == "btn btn-primary")
      {
        tiempo="4";
      }else if(grafica_denuncia_unmes == "btn btn-primary")
      {
        tiempo="5";
      }
    }
  if($("#visualizarfechas").is(':checked')) {  
            //alert("Está activado");
            fechainicio = $('#fecha1').val();
            fechafinal = $('#fecha2').val();
            estadofecha = 1;

        } else {  
           // alert("No está activado");  
           estadofecha = 0;
        }  
      var departamento = $('#cmb_depto option:selected').text();
      var municipio = $('#cmb_mupio option:selected').text();
      var region = $('#region option:selected').text();
      var comisaria = $('#entidad').val();
      var tipo_sede = $('#tipo_sede').val();
      var sede = $('#sede').val();
      /*Filtros para denuncia*/
      var tipo_hecho = $('#tipo_hecho').val();
      if(departamento == '' || departamento == 'Todos' || departamento == 0)
      {
        //alert('esta vacio departamento');
        departamento ="Todos";
      }
      if(municipio == '' || municipio == 'Seleccione un Municipio' || municipio == 0 || municipio == 'Todos los Municipios')
      {
        //alert('esta vacio municipio');
        municipio ="Todos";
      }
      if(region == '' || region == 'Todos' || region == 0)
      {
        //alert('esta vacio region');
        region ="Todos";
      }

      if(comisaria == '' || comisaria == 'Seleccione Entidad' || comisaria == 0)
      {
        //alert('esta vacio comisaria');
        comisaria ="Todos";
      }
      if(tipo_sede == '' || tipo_sede == 'Todos' || tipo_sede == 0)
      {
       // alert('esta vacio tipo_sede');
        tipo_sede ="Todos";
      }
       if(sede == '' || sede == 'seleccione una Sede' || sede == 0)
      {
        //alert('esta vacio sede');
        sede ="Todos";
      }
      if(tipo_hecho == '' || tipo_hecho == 'Todos'  || tipo_hecho == 0)
      {
        //alert('esta vacio sede');
        tipo_hecho ="Todos";
      }  
       var tipo = $('input:radio[name=tipo]:checked').val();

       if(tipo == 1)
      {      
        $('#datosextravio').hide(500);
        $('#datosincidencia').hide(500);
        $('#datosdenuncia').show(500);

         $.ajax({
         type: "POST",
         url: <?php echo "'".CController::createUrl('estadisticas/GraficaTiempoDenuncias')."'"; ?>,
         data: {
           hecho:hecho,
            tipo:tipo,
            tiempo:tiempo,
            departamento:departamento,
            municipio:municipio,
            region:region,
            comisaria:comisaria,
            tipo_sede:tipo_sede,
            sede:sede,
            tipo_hecho:tipo_hecho,
            estadofecha: estadofecha,
            fechainicio: fechainicio,
            fechafinal:fechafinal
         },
          beforeSend: function(html)
         {
            /*$('#modalprocesando').modal({
                     show: true,
                     keyboard: false,
                     backdrop: "static"
                 });*/
         },//fin beforesend
         success: function(result)
         {            
              $('#modalprocesando').modal('hide');
           $("#graficatiemposporhechos").empty();
           $("#graficatiemposporhechos").html(result);      
         }
       });
      }
}//fin de la consuta validador de datos    
      


});
</script>