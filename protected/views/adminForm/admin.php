<div class="container-fluid cuerpo">
  <legend>Editar Catálogos</legend>
  <div class="row-fluid">
    <div class="span2">
      <label class="campotit" for="entidad">Comisaria</label>
            <select id="entidad" class="span12" required>
              <option value ="Todos" selected>Seleccione una Sección</option>
                   <?php                        
                          $Criteria = new CDbCriteria();
                          $Criteria->order ='id_cat_entidad ASC';
                          $data=CatEntidad::model()->findAll($Criteria);
                          $data=CHtml::listData($data,'id_cat_entidad','nombre_entidad');
                          $contador = '0';
                          foreach($data as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                        
                      ?>
            </select>
      <button class="btn btn-large btn-block btn-primary" id="envia" name ="envia" type="button">Consultar</button>
    </div>
    <div class="span10" id="grid" name="grid">
      
<?php 
$entidad = 2;
echo '<legend>Listado de Sedes</legend>';
$model=new TblSede;
$this->widget(
'bootstrap.widgets.TbGridView', 
array(
'type'=>'striped bordered condensed',
'id'=>'grid_tedst',
'ajaxUpdate' => FALSE,
'dataProvider'=>$model->fgrid($entidad),
'responsiveTable' => true,
//'dataProvider'=>$search(),
//'template'=>"{items}\n{pager}",

'columns'=>array(

array('name'=>'id_sede', 'header'=>'#'),
array('name'=>'region', 'header'=>'Tipo De Evento'),
array('name'=>'nombre_entidad', 'header'=>'Fecha de Ingreso'),
array('name'=>'descripcion', 'header'=>'Usuario','type'=>'raw'),
array('name'=>'nombre', 'header'=>'Departamento'),
array(
  'class'=>'bootstrap.widgets.TbButtonColumn',
  'template'=>'{Editar}',
   'header'=>'Acciones ',
   
  'buttons'=>array(       
  'Editar' => array(
  'icon'=>'icon-share ',
  'url'=>'Yii::app()->controller->createUrl("adminForm/editar", array("id"=>$data["id_sede"]))',
  'options'=>array('target'=>'_blank','style'=>'padding:5%;','class'=>'buttonColumns'),

   ),
  ),
  'htmlOptions'=>array('style'=>'text-align: center; width:7%;'),
  ),
    
),
));
 ?>
    </div>
  </div>
</div>
<script type="text/javascript">


$(document).ready(function(){
 $('#envia').click(function(){
  var entidad = $('#entidad').val();
  

      $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('adminForm/filtro')."'"; ?>,
          data: {entidad:entidad},
          beforeSend: function()
          {
           
          },
          success: function(result)
          {
           $('#grid').html('');
           $('#grid').html(result);

          }
        });
});

});
</script>