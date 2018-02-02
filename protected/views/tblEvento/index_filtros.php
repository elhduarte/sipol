<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" rel="stylesheet" />


<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/lib/highcharts/highcharts.js"></script>
<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/lib/highcharts/modules/exporting.js"></script>
<!--script type="text/javascript"src="<?php //echo Yii::app()->request->baseUrl; ?>/js/tooltips.js"></script-->



<style>
  #datosextravio{
    display: none;
  }
  #datosincidencia{
    display: none;
  }
</style>
<!--
  <div style ="padding-top : 1%; padding-right : 5%;" class=" pull-right">
    <label >
        <input id="buscar_evento" type="checkbox"> Deseo buscar un número de evento especifico
      </label>
  </div> -->
<?php 
    $sale = json_decode($_SESSION['ID_ROL_SIPOL']);
    #echo '<pre>';
    //print_r($sale[0]->id_cat_entidad);
    #echo '</pre>';
    $id_rol = $sale[0]->id_rol;
    
?>


<div id ="filtros_generales" >
<div class="cuerpo">
<div class="row-fluid">
  <div class="span12">
   
    <!--Parte de la Vista titulo y tipo de grafica-->
    <div class="row-fluid">
      <div class="span12">
        <legend style="margin-bottom: 2%;"><img style="" src="images/icons/glyphicons_156_show_thumbnails.png"  alt="">
         Administrador De Eventos           
        </legend>     
      </div>
    </div>
    </div>





    <!--Termina la vista de titulo y tipo de graficas-->

      <!--Parte de la Vista titulo y tipo de grafica-->
  
    <div class="row-fluid">
      <div class="span6">
          <blockquote>
          <p>
            <i class="icon-calendar"></i> Rango de Fechas
               
          </p>  

        </blockquote>
        
  <div id="rangosfechas">
        
          <div id="inputfechas">
              <div class="row-fluid">
              <div class ="span6">
              <label class ="campotit">Fecha Inicial</label>
              <input class="span11" type="text"  id="fecha1" required>
              <i class="icon-calendar" style="margin: -3px 0 0 -26px; pointer-events: none; position: relative;"></i>
              </div>
              <div class ="span6">
              <label class ="campotit">Fecha Final</label>
              <input class="span11" type="text"  id="fecha2" required>
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
      echo '<option value="">Todos</option>';
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
     
    <!--Termina la vista de titulo y tipo de graficas-->

  </div>
</div>




</div>






<div class="row-fluid" id ='laUbicacion'>
  <div class="span12 cuerpo">
    <blockquote>
      <p><i class="icon-map-marker"></i> Lugar De Emisión</p> 
      </blockquote>

    <div class="row-fluid">
      <div class="span3">

     
<label class="campotit">Region</label>
           <select  required  class="span12" name="cmb_distrito" id="cmb_distrito">
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
        
      </div>
      <div class="span3">
        <label class="campotit">Comisaria</label>
                     <select disabled ="yes" required  class="span12" name="entidad" id="entidad">
                      
                     </select>


      </div>
      <div class="span3">

           <label class="campotit">Tipo de Sede</label>
                     <select disabled ="yes" required  class="span12" name="tipo_sede" id="tipo_sede">
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


        
      </div>
      <div class="span3">

        <label class="campotit">Sede </label>
                     <select required  disabled class="span12" name="sede" id="sede">
                     <option value="" style="display:none;">Seleccione una Sede</option>
                     </select>
        
      </div>
      
    </div>
  </div>
</div>


<div id="hechos" class="cuerpo">

<div  class="row-fluid">
  <div class="span12">
    <blockquote>
      <p> Hechos Denuncia</p> 
      </blockquote>

    <div class="row-fluid">
      <div class="span3">
  
    <label class ="campotit">Tipo de Hecho</label>
      <select class ="span12" name="cmb_hecho_tipo" id="cmb_hecho_tipo">
      <?php
      $Criteria = new CDbCriteria();
      $Criteria->order ='tipo ASC';
      $data=CatHechoTipo::model()->findAll($Criteria);
      $data=CHtml::listData($data,'id_hecho_tipo','tipo');
      echo '<option value="">Todos</option>';
      foreach($data as $value=>$name)
      {
      echo '<option value="'.$value.'">'.$name.'</option>';
      }
      ?>
      </select>



        
      </div>
      <div class="span3">
       <label class ="campotit">Hechos</label>
            <select disabled class ="span12" name="cmb_hecho" id="cmb_hecho">
            <?php
            $Criteria = new CDbCriteria();
            $Criteria->order ='id_cat_denuncia ASC';
            $data=CatDenuncia::model()->findAll($Criteria);
            $data=CHtml::listData($data,'id_cat_denuncia','nombre_denuncia');
            echo '<option value="">Todos</option>';
            foreach($data as $value=>$name)
            {
            echo '<option value="'.$value.'">'.$name.'</option>';
            }
            ?>
            </select>


      </div>
      
      
    </div>
  </div>
</div>
</div>
</div>
</div>
  <div align ="right"> <button id ="resetbt" name ="resetbt" class="btn btn-large btn-primary" type="button">Reiniciar Filtros</button></div>
<div class ="cuerpo-small" id="resultado">
     <?php echo $this->renderPartial('grid');?>
</div>
  
</div>
  



<script type="text/javascript">

 $(document).ready(function(){

var elrol = <?php echo $id_rol;?>;
$('#laUbicacion').hide();

$('#resetbt').click(function() {
   location.reload();
});
   $("#visualizarfechas").live("click", function(){
    var id = parseInt($(this).val(), 10);
    if($(this).is(":checked"))
    {
       $('#inputfechas').show(500);
    $('#botonesfechas').hide(500);
      //alert('esta check');
    } 
    else 
    {
       $('#inputfechas').hide(500);
    $('#botonesfechas').show(500);
    }
  });

    $('#filtrar_evento_num').click(function(){
      
     var tipo = 1;
      var fecha_ini  = '';
      var fecha_fin = '';
      var estado = '';
      var depto = 'Todos';
      var mupio = '';
      var comisaria = '';
      var num_evento = $('#input_evento_num').val(); 
    
    $.ajax({
      type: "POST",
      url: <?php echo "'".CController::createUrl('TblEvento/grid')."'"; ?>,
      data:
      {
        tipo:tipo,
        fecha_ini : fecha_ini,
        fecha_fin : fecha_fin,
        estado : estado,
        depto : depto,
        mupio : mupio,
        comisaria : comisaria,
        num_evento : num_evento
        
      },
      beforeSend: function()
      {
      
      },
      success: function(grilla)
      {
   
        $('#resultado').html('');
        $('#resultado').html(grilla);
   
      }
    }); 
    });


     
      $('input:radio').click(function(){
      $(this).EnviarFiltros();
      var tipo = $('input:radio[name=tipo]:checked').val();
      //alert(tipo);
      if(tipo == 1)
      {
        $('#hechos').show(500);
       
       $('#acciones').addClass('span6');
        
        $('#acciones').removeClass('span11');
      //  
 
      }else
      {

        //$("#cmb_hecho").attr('disabled','true')
        $('#hechos').hide(500);
        $('#acciones').removeClass('span6');
        $('#acciones').addClass('span11');
      }

      });
  $("#buscar_evento").live("click", function(){
    var id = parseInt($(this).val(), 10);
    if($(this).is(":checked"))
    {
      var flip = 0 ;
      $('#por_evento').show(200);
      $('#filtros_generales').hide(200);
      //alert('esta check');
    } 
    else 
    {
      $('#por_evento').hide(200);
      $('#filtros_generales').show(200);
      $(this).EnviarFiltros();
      //alert('no esta check');
    }
  });
      $('#fecha1').change(function(){

      var fecha_ini = $('#fecha1').val();
      var fecha_fin = $('#fecha2').val();
      var fecha_hoy = '<?php echo date("d/m/Y"); ?>';
    if(fecha_fin=='')
      {
        $('#fecha2').val(fecha_hoy);
        
      }
      $(this).EnviarFiltros();

      });

      $('#fecha2').change(function(){
      $(this).EnviarFiltros();
      });
      $('#cmb_mupio').change(function(){
      $(this).EnviarFiltros();
      });


     $('#cmb_hecho_tipo').change(function(){
     
    var hecho_tipo =  $('#cmb_hecho_tipo').val();
    
    actualizaTipo(hecho_tipo);
    $(this).EnviarFiltros();
  });
    $('#cmb_hecho').change(function(){
    $(this).EnviarFiltros();
  });
        


     $('#cmb_depto').change(function(){
     
    var cod_depto =  $('#cmb_depto').val();
    
    actualizaMupio(cod_depto);
    $(this).EnviarFiltros();
  });


  $('#entidad').change(function(){
    var comisaria =  $('#entidad').val();  
    var tipo_sede = $('#tipo_sede').val();
    actualizaSede(comisaria,tipo_sede);
    
    $(this).EnviarFiltros();
  });

  $('#tipo_sede').change(function(){
    var entidad = $('#entidad').val();
    var tipo_sede = $('#tipo_sede').val();
    actualizaSede(entidad,tipo_sede);
    $(this).EnviarFiltros();
  });



  $('#sede').change(function(){
    var sede = $('#sede').val();
    $(this).EnviarFiltros();
  });





   $('#cmb_distrito').change(function(){
    var distrito = $('#cmb_distrito').val();
    
    $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('TblEvento/getComisaria')."'"; ?>,
          data: {distrito:distrito},
                beforeSend: function()
          {
              $("#entidad").val('');
          },
          success: function(result)
          {
             $('#tipo_sede').val('');     
            
           //alert(result);
    $("#entidad").empty();
        $("#entidad").html(result);
        $("#entidad").removeAttr('disabled');
          }

        });
          $(this).EnviarFiltros();
  });






  function actualizaTipo(recibe)
{
  var hecho_tipo = recibe;
  if(hecho_tipo == '')
  {
    $("#cmb_hecho").empty();
    $("#cmb_hecho").attr('disabled','true')
  }
  else
  {
  //var depto = $('#cmb_depto').val();
    $.ajax({
      type: "POST",
      url: <?php echo "'".CController::createUrl('TblEvento/getTipo')."'"; ?>,
      data: {param:hecho_tipo},
      success: function(result)
      {
        
        $("#cmb_hecho").empty();
        $("#cmb_hecho").html(result);
        $("#cmb_hecho").removeAttr('disabled');
        //alert(result); 
      }
    });
}

} 


  function actualizaMupio(recibe)
{
  var depto = recibe;
  if(depto == '')
  {
    $("#cmb_mupio").empty();
    $("#cmb_mupio").attr('disabled','true')
  }
  else
  {
  //var depto = $('#cmb_depto').val();
    $.ajax({
      type: "POST",
      url: <?php echo "'".CController::createUrl('Mapa/getMupios')."'"; ?>,
      data: {param:depto},
      success: function(result)
      {
        
        $("#cmb_mupio").empty();
        $("#cmb_mupio").html(result);
        $("#cmb_mupio").removeAttr('disabled');
        //alert(result); 
      }
    });
}

} 
    var fecha = $('#fecha_ini').val();

    $.fn.EnviarFiltros = function()
    {
      var tipo = $('input:radio[name=tipo]:checked').val();
      var fecha_ini  = $('#fecha1').val();
      var fecha_fin = $('#fecha2').val();
      var estado = $('#SelectEstado').val();
      var depto = $('#cmb_depto option:selected').text();
      var mupio = $('#cmb_mupio option:selected').text();
      var comisaria = $('#entidad').val();
      var tipo_sede = $('#tipo_sede').val();
      var sede = $('#sede').val();
      var tipo_hecho = $('#cmb_hecho_tipo').val();
      var hecho = $('#cmb_hecho').val();
      var num_evento =''; 
      var distrito = $('#cmb_distrito').val();
    
    $.ajax({
      type: "POST",
      url: <?php echo "'".CController::createUrl('TblEvento/grid')."'"; ?>,
      data:
      {
        tipo:tipo,
        fecha_ini : fecha_ini,
        fecha_fin : fecha_fin,
        estado : estado,
        depto : depto,
        mupio : mupio,
        comisaria : comisaria,
        num_evento : num_evento,
        tipo_sede : tipo_sede,
        sede : sede,
        tipo_hecho : tipo_hecho,
        hecho : hecho,
        distrito : distrito
        
      },
      beforeSend: function()
      {
        //$('#div_grilla').html('');
        //$('#div_grilla').html('<h4>Procesando</h4>');
      },
      success: function(grilla)
      {
        //alert(grilla);
        $('#resultado').html('');
        $('#resultado').html(grilla);
        //$('#div_grilla').get(0).scrollIntoView();
        //$.fn.yiiGridView.update('grid_test');
      }
    }); 
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
            $("#tipo_sede").removeAttr('disabled');            
           $("#sede").removeAttr('disabled');            
         }
       });
}




});
</script>

