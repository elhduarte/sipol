<link href="lib/jqueryui/adminhechos/pagina.css" rel="stylesheet" type="text/css" media="all">

<?php
	$catEventos = new CatTipoEvento;
	$eventos = $catEventos->getEventos();
?>
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'geo',
    //type'=>'horizontal',
    'htmlOptions'=>array('name'=>'geo'),
    )); ?>
<div class="cuerpo">
	<legend>Agregar una Sede </legend>

	<form id="addCatalogo">
		<div class="row-fluid">
			<div class="span12">
				<div class="row-fluid">
					<div class="span2">
						<label class="campotit" for="entidad">Comisaria</label>
						<select id="entidad" class="span12" required>
							<option value ="" selected>Seleccione una Sección</option>
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
					</div>
					<div class="span2">
						<label class="campotit" for="tipo_sede">Tipo De Sede</label>
						<select id="tipo_sede" class="span12" required>
							<option value ="" selected>Seleccione una Sección</option>
						  <?php                        
                          $Criteria = new CDbCriteria();
                          $Criteria->order ='id_tipo_sede ASC';
                          $data=CatTipoSede::model()->findAll($Criteria);
                          $data=CHtml::listData($data,'id_tipo_sede','descripcion');
                          $contador = '0';
                          foreach($data as $value=>$name)
                          {
                          echo '<option value="'.$value.'">'.$name.'</option>';
                          }                        
                        ?>
						</select>
					</div>
					<div class="span2">
						<label class="campotit" for="departamento" id="departamentoLabel">Departamento</label>
						     <?php
               //$criterio = new CDbCriteria;
               $model = new CatDepartamentos;
                 echo $form->dropDownListRow($model,'cod_depto',
                  CHtml::listData(CatDepartamentos::model()->findAll(array('order'=>'departamento ASC')),'cod_depto','departamento'),
                    array(  'class'=>'span12',
              'required'=>'true',
              'maxlength'=>12,
              'id'=>'cmb_depto',
              'labelOptions'=>array('label'=>'',),
              'prompt'=>'Seleccione un Departamento',
              //'onChange'=>'actualizaMupio(this.value); mapZoom(this.value,"deptos");'
                        )
                    
                 );
            ?>
					</div>
					<div class="span2">
						<label class="campotit" for="mupio">Municipio 
							<i class="icon-ban-circle" id="iconNameWarning" style="display:none;"></i>
						</label>
						   <?php
              $modelo = new CatMunicipios;
                $dropdown = $form->dropDownListRow($modelo,'cod_mupio',
                  array('0' => 'Seleccione un Municipio'),
                  array(
                    'class'=>'span12',
                    'labelOptions'=>array('label'=>'',), 
                    /*'id'=>'cmb_mupio',*/ 
                    'required'=>'true',
                    'maxlength'=>12,
                    'id'=>'cmb_mupio',
                    'name'=>'cmb_mupio',
                    'disabled'=>'true',
                    //'onChange'=>'mapZoom(this.value,"mupios");'
                    ));
                echo utf8_decode($dropdown);
            ?>
					</div>
					<div class="span2">
						<label class="campotit" for="nombresede">Nombre de Sede</label>
						    <input id="nombresede" type="text" placeholder="Nombre de la Sede" required>
					</div>
						<div class="span2">
						<label class="campotit" for="referencia">Referencia</label>
					    <input id="referencia" type="text" placeholder="Referencia de Ubicacion de la Sede">
							
					</div>
				</div>
					<div class="row-fluid">
					<div class="span4 offset8">
					<button class="btn btn-primary span12" type="button" style="margin-top: 9%;" id="savesede">Crear Sede</button>
					</div>
				
				</div>
			</div>

			
		</div>
	
	</form>

<?php $this->endWidget(); ?>
</div><!-- Fin del Well principal -->


<script type="text/javascript">

$(document).ready(function(){
  $('#cmb_depto').change(function(band){
  

     var depto = $('#cmb_depto').val();
  
    $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('Mapa/getMupios')."'"; ?>,
          data: {param:depto},
          beforeSend: function()
          {
            $("#cmb_mupio").empty();
            $("#cmb_mupio").attr('disabled', 'true');
          },
          success: function(result)
          {
            $("#cmb_mupio").empty();
            $("#cmb_mupio").html(result);
            $("#cmb_mupio").removeAttr('disabled');
          }
        });
  });


$('#savesede').click(function(){     
  var entidad = $('#entidad').val();
    var tipo_sede = $('#tipo_sede').val();
    var depto = $('#cmb_depto').val();
    var mupio = $('#cmb_mupio').val();
    var nombresede = $('#nombresede').val();
    var referencia = $('#referencia').val();
    

   $.ajax({
          type: "POST",
          url: <?php echo "'".CController::createUrl('AdminForm/SaveSede')."'"; ?>,
          data: {
          	entidad: entidad,
          	tipo_sede: tipo_sede,
          	depto: depto,
          	mupio: mupio,
          	nombresede: nombresede,
          	referencia: referencia
          },
          beforeSend: function()
          {
         //alert('ya va');
          },
           error: function()
          {
         //alert('ya va');
          },
          success: function(result)
          {
           alert(result);
           location.reload();
          }
        });


});

}); //Fin del Document ready
</script>