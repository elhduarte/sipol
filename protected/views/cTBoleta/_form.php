<?php
/* @var $this CTBoletaController */
/* @var $model mTBoleta */
/* @var $form CActiveForm */
?>
<div class ="cuerpo">
<div id="novedadesboleta"></div>

  <div class="">
    <?php
      $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'novedades',
       // 'action'=>Yii::app()->createUrl('cTblEvento/filtros'), //metodo en el controlador
        'type'=>'in-line',
        'method'=>'POST',

      )); 
      ?>

     <div id ="laboleta" class="row-fluid">
      <div class="span6">
        <legend>Informacion General</legend>

        <?php 
         echo $form->textFieldRow($model, 'titulo',
          array('class'=>'span12','hint'=>'','labelOptions'=>array('label'=>'Titulo','class'=>'campotit'),)); 
        ?>   
        


  <div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6">
          <?php
            $criterio = new CDbCriteria;
            #$criterio->order = '
            $modela = new mTComisaria;
            echo $form->dropDownListRow($modela,'nombre_comisaria',
            CHtml::listData(mTComisaria::model()->findAll(array('order'=>'numero_comisaria')),'numero_comisaria','nombre_comisaria'),
            array('class'=>'span12','id'=>'comisaria','name'=>'a',
           'labelOptions'=>array('label'=>'Comisaria','class'=>'campotit'),
            ));
        ?>         
      </div><!--fin de la opcion para comisaria-->
      <div class="span6">
         <?php
                  $criterio = new CDbCriteria;
                  #$criterio->order = '
                  $modela = new MDivisionPnc;
                  echo $form->dropDownListRow($modela,'nombre_division',
                  CHtml::listData(MDivisionPnc::model()->findAll(array('order'=>'id_division')),'id_division','nombre_division'),
               array('class'=>'span12','maxlength'=>12, 'id'=>'division','name'=>'a',
                    'labelOptions'=>array('label'=>'Division','class'=>'campotit'),
                  ));
          ?>
      </div><!--fin para la opcion de divicion-->
    </div><!--fin para la opcion row-fluid-->
  </div><!--fin para la opcion span12-->
</div><!--fin para la opcion row-fluid-->



  <div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6">
        <label for="fecha" class="campotit">Fecha</label>
        <input class ='span11' id ='fecha'type="text" placeholder="Click Para Seleccionar Una Fecha">
        <span class="add-on"><i class="icon-calendar"></i></span>     
              
              
      </div><!--fin de la opcion para comisaria-->
      <div class="span6">
                <?php 
                  echo $form->timepickerRow($model, 'hora', 
                  array(
                  'class'=>'span11',
                  'append'=>'<i class="icon-time" style="cursor:pointer"></i>',
                  'labelOptions'=>array('label'=>'Hora','class'=>'campotit'),
                ));
            ?>
      </div><!--fin para la opcion de divicion-->
    </div><!--fin para la opcion row-fluid-->
  </div><!--fin para la opcion span12-->
</div><!--fin para la opcion row-fluid-->

<!--Esta es la parte del titulo-->
  
      </div>
      <div class="span6">
      	<legend>Detalle de la Novedad</legend>
         <?php 
         /*echo $form->html5EditorRow($model, 'detalle',
          array('class'=>'span4', 'rows'=>5, 'height'=>'100', 
            'options'=>array('color'=>true))); */

         echo $form->html5EditorRow($model, 'detalle', array(
                                'rows'=>10, 
                                //'id'=>'html5editor_'.$model->id,
                                'width'=>'99%',
                                'height'=>'250', 
                                'options'=>array(
                                    'color'=>false,
                                    'font-styles'=>true,
                                    'image'=>false,
                                    )));
         ?>


      </div><!--fin del modulo para el relato-->
    </div>

    <hr>

     <div class="row-fluid">
      <div class="span6">
          <legend>Hechos\Eventos</legend>


                <div class="row-fluid">
                  <div class="span12">
                    <div class="row-fluid">
                      <div class="span6">
                                
                                      <?php
                                        $criterio = new CDbCriteria;
                                        #$criterio->order = '
                                        $modela = new mTHecho;
                                          echo $form->dropDownListRow($modela,'nombre_hecho',
                                          CHtml::listData(mTHecho::model()->findAll(array('order'=>'id_hecho')),'id_hecho','nombre_hecho'),
                                          array('class'=>'span12','maxlength'=>12, 'id'=>'hecho_select','name'=>'a','prompt'=>'Seleccione Un Hecho',
                                          'labelOptions'=>array('label'=>'Hechos','class'=>'campotit'),

                                          )
                                        );
                                      ?>      
                              </div><!--fin de la opcion para comisaria-->
                              <div class="span6">
                                    <?php
                                      $criterio = new CDbCriteria;
                                      #$criterio->order = '
                                      $modela = new mTEvento;
                                      echo $form->dropDownListRow($modela,'nombre_evento',
                                      CHtml::listData(mTEvento::model()->findAll(array('order'=>'id_evento')),'id_evento','nombre_evento'),
                                      array('class'=>'span12','disabled'=>'true','maxlength'=>12, 'id'=>'evento','name'=>'evento',
                                      'prompt'=>'Todos','labelOptions'=>array('label'=>'Eventos','class'=>'campotit'),
                                      ));
                                    ?> 
                              </div><!--fin para la opcion de divicion-->
                            </div><!--fin para la opcion row-fluid-->
                          </div><!--fin para la opcion span12-->
                        </div><!--fin para la opcion row-fluid-->



                                          <div class="row-fluid">
                                            <div class="span12">
                                              <div class="row-fluid">
                                                <div class="span6">
                                                       <?php 
                                                            $mim = new mTTotalEventos;
                                                            echo $form->textFieldRow($mim, 'complemento', array('class'=>'span12','labelOptions'=>array('label'=>'Complemento','class'=>'campotit')));
                                                        ?>     
                                                </div><!--fin de la opcion para comisaria-->
                                                <div class="span6">
                                                      <?php 
                                                          echo $form->textFieldRow($mim, 'cantidad', array('class'=>'span12  validaCampoNumerico','labelOptions'=>array('label'=>'Cantidad','class'=>'campotit'))); 
                                                      ?> 
                                                </div><!--fin para la opcion de divicion-->
                                              </div><!--fin para la opcion row-fluid-->
                                            </div><!--fin para la opcion span12-->
                                          </div><!--fin para la opcion row-fluid-->
 
                                        <div style="text-align:right;">
                                             <?php
                                         $this->widget('bootstrap.widgets.TbButton', array(
                                          'id'=>'boton_evento',
                                          'label'=>'Agregar',
                                          'type'=>'primary',
                                          
                                        ))
                                        ?>
                                        </div>                   


       
      </div>

      <div id ='evento_detalle' class="span6 tablanovedades">
          <table class="table table-striped table-bordered tabla_eventos_hechos">
                           <thead>
                           <tr>
                             <th>Hechos</th>
                             <th>Evento</th>
                             <th>Complemento</th>
                             <th>Cantidad</th>
                             <th>Eliminar</th>
                           </tr>
                         </thead>
                         <tbody>
                         
                         </tbody>
                        </table>    
          
    </div>
  </div>


  <legend style="padding-top:2%;"></legend>
    <div align="right">
           <?php
       $this->widget('bootstrap.widgets.TbButton', 
        array(
        'id'=>'siguiente',
        'label'=>'Siguiente',
        'type'=>'primary',
        
      ))
      ?>


    </div>

  </div><!--div de detalle de boleta-->



</div>

<?php $this->endWidget(); ?> 

         
<script type="text/javascript">



function borrar(cual) {
 
 $("tr.natanael"+cual).remove();
  return false;
  $("#laboleta").get(0).scrollIntoView();
}
</script>


<script type="text/javascript">

$(document).ready(function(){
  $('#feeeha').datepicker({
  format: "yyyy-mm-dd",
  todayBtn: "linked",
  language:"es",
}); 

$('#fecha').datepicker({
    format: "yyyy-mm-dd",
    todayBtn: "linked",
    language: "es"
});  



 //   $('#mTTotalEventos_cantidad').validaCampo('0123456789'); 



  $("#novedadesboleta").get(0).scrollIntoView();

$('#timepicker').timepicker({
    showPeriod: true,
    showLeadingZero: true
});

  $('#hecho_select').change(function(){
    var id_hecho = $('#hecho_select').val();
    $('#mTComisaria_distrito').val('');
    $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('CTBoleta/evento')."'"; ?>,
          data: {id_hecho:id_hecho,},
          success: function(result)
          {
            $('#evento').html('');
            $('#evento').removeAttr('disabled');
            $('#evento').html(result);
          


          }

        });

  });

  $('#boton_evento').click(function(){
    
    var hecho = $('#hecho_select option:selected').text();
    var evento = $('#evento option:selected').text();
    var complemento = $('#mTTotalEventos_complemento').val();
    var cantidad = $('#mTTotalEventos_cantidad').val();
 
 /*
 else if (evento  ='Todos') {
  alert('Seleccione Un Evento')
 }else 
{
  */
function mitrim(cadena)
{
var valor = cadena;
var vse = valor.replace(/ /gi,'');
vse = vse.replace('(','');
vse = vse.replace(')','');
vse = vse.replace(',','');
return vse;
}

var a = mitrim(hecho);
var b = mitrim(evento);
var c = mitrim(complemento);
var d = mitrim(cantidad);

if (cantidad == '')
 {
 alert ("Ingrese Una Cantidad Valida");
 
 }else if(evento == 'Todos')
 {
  alert("Seleccione Un Evento...")
} else
{
$('.tabla_eventos_hechos').append("<tr class=natanael"+a+b+c+d+"><td >"+hecho+"</td><td>"+evento+"</td><td>"+complemento+"</td><td>"+cantidad+"</td><td><a  onclick='borrar("+'"'+a+b+c+d+'"'+");'><i class='icon-remove-sign'></i></a></td></tr>");
$('#mTTotalEventos_complemento').val('');
$('#mTTotalEventos_cantidad').val('');
}
  });

$('#siguiente').click(function(){
  
  $('#nav_novedades li:eq(1) a').tab('show');
  $('#tab1').hide(500);
      $('#tab2').show(500);

});
 


});

</script>






