<?php 
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$comisaria = $variable_datos_usuario[0]->nombre_entidad;

$nombre_completo  = $variable_datos_usuario[0]->nombre_completo;
?>
<style type="text/css" media="screen">
 .jumbotron {
        margin: 2% 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 45px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      } 
      .boton_buscar{
        margin-bottom: 8px;
      }
      .ipuntdiseno{
        padding: 7px;
font-size: 17px;
      }
</style>

	
<div style ="max-width: 65%;"class ="form-signin  form-vertical" > 
  
    <div class="row-fluid cuerpo-small">
      <div class="span12  ">
        <div class="jumbotron">
        <p style="font-size: 25px;">Bienvenido <b><?php echo $nombre_completo; ?></b></p>
      </div>
      <hr>
        <div class="row-fluid">
          <div class="span6 ">
            <blockquote style ="text-align: right;">
              <p>Por Favor Seleccione La Comisaria Que Desea Analizar</p>
            </blockquote>
          </div>
          <div class="span4"> 
              <select required  class="span12" name="cat_entidad" id="cat_entidad">
                        <?php                        
                         $Criteria = new CDbCriteria();
                         $Criteria->order ='id_cat_entidad ASC';
                         $Criteria->condition ='id_cat_entidad !=1';
                         $data=CatEntidad::model()->findAll($Criteria);
                         $data=CHtml::listData($data,'id_cat_entidad','nombre_entidad');                         
                         foreach($data as $value=>$name)
                         {
                         
                         echo '<option value="'.$value.'">'.$name.'</option>';
                         }                        
                       ?>
                      </select>
          </div>
          <div class ="span2"><button id ="busca" name="busca" class="btn btn-block btn-info boton_buscar"><i style ="padding-left:4%;" class="icon-check icon-white"></i>Seleccionar</button></div>
        </div>
         <hr>
      </div>

      <div class ="" id="resultado" style ="display:none;">
</div>
    </div> 


</div>

<script type="text/javascript">


$('#busca').click(function(){

var id_entidad = $('#cat_entidad').val();
    $.ajax({
      type: "POST",
      url: <?php echo "'".CController::createUrl('Estadisticascf/indexRender')."'"; ?>,
      data:
      {
        id_entidad: id_entidad
            
      },
      beforeSend: function()
      {
          $('#resultado').html('');
          $('#resultado').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>'+
              'Procesando... Espere un momento por favor</h4>');
      },
      success: function(result)
      {
          $('#resultado').html('');
          $('#resultado').html(result);
          $('#resultado').show(500);;
      }
    }); 


});

</script>