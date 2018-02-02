<div class="cuerpo">
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">


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

  <label class="campotit">Sede </label>
                <select required  disabled class="span12" name="sede" id="sede">
                      <option value="" style="display:none;">Seleccione una Sede</option>
                </select> 



    </div><!--termino los filtros del span2-->
    <div class="span10">

		 <div class="row-fluid">
		  <div class="span12">
		    <div class="row-fluid">

      <?php

      $usuario = new TblUsuario;
      $resultado = $usuario->estadisticausuariofoto();
      $contador = 1;
      foreach ($resultado as $key => $value) {


      	if(fmod($contador,12) == 0)
			{

				$json = json_encode($value);
			    $json = json_decode($json);
			    

			    if($json->foto=="")
			    {
			    	echo "<div class='span1'><img class='' src='images/noimagen.png'/> </div>";
					echo "</div>";
					echo "<div class='row-fluid'>";

			    }else{

			    	echo "<div class='span1'><img class='' src='data:image/jpg;base64,".$json->foto."'/> </div>";
					echo "</div>";
					echo "<div class='row-fluid'>";
			    }

				

			}
			else
			{

				$json = json_encode($value);
			    $json = json_decode($json);


			     if($json->foto=="")
			    {
			    	echo "<div class='span1'><img class='' src='images/noimagen.png'/> </div>";

			    }else{
					 echo "<div class='span1'><img class='' src='data:image/jpg;base64,".$json->foto."'/> </div>";

			    }


			    
			}//fin del if

			$contador = $contador+1;
      }


      ?>
 			</div>
      	  </div>
		</div>

		








    </div>
  </div>
</div>
</div>

<script type="text/javascript">
 $(document).ready(function()
 {
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
	/*Termina filtros de Ubicacion de los Hechos*/
	/*Inicia filtros de lugar de emision para metodos change*/
	 $('#region').change(function(){
		$('#entidad').val('');
		$('#tipo_sede').val('');
		$('#sede').val('');
	    var regionn = $('#region option:selected').text();
	    actualizaEntidad(regionn);
	    /*$(this).validarrequeridos(); */
	  });
	$('#entidad').change(function(){
		$('#tipo_sede').val('');
		$('#sede').val('');
	var comisaria =  $('#entidad').val();  
	var tipo_sede = $('#tipo_sede').val();
	actualizaSede(comisaria,tipo_sede);
	/*$(this).validarrequeridos(); */
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
	    /* $(this).validarrequeridos(); */
	      }
	  });
	  $('#sede').change(function(){
	    var sede = $('#sede').val();
	    /*$(this).validarrequeridos(); */
	  });
	/*Termina filtros de lugar de emision para metodos change*/
	/*funciones de Change para consulta sobre denuncia*/
	  $('#tipo_hecho').change(function(){
	    $('#hecho_denuncia').val('');
	    var tipo_hecho =  $('#tipo_hecho').val();
	      actualizaHechos(tipo_hecho);
	      /* $(this).validarrequeridos();*/
	  });
});
</script>