
<div class="cuerpo">
<?php
$usuario = "";
$validador_get =  isset($_GET['perfil']) ? $usuario=$_GET['perfil'] : false ;
if($validador_get == true)
{

	$numero = new Encrypter;
$usuario = $numero->descompilarget($usuario);
if($usuario == false){
	echo '
		<div class="alert alert-info">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Información del Sistema!</h4>
		  <blockquote>
			<small><cite title="Source Title">Restricción de SIPOL</cite></small>
			</blockquote>
		</div>
		';
}else{


?>
<input type="text" style="display:none"  id="codigousuario" value="<?php echo $usuario; ?>">
<legend>Cambio de Sede</legend>
<form action="" id="actualizarformulariomensaje">  


<div class="row-fluid">
  <div class="span12 well">
  	 <h5>Actualización de Sede, Seleccione  Ubicacion Actual.</h5> 
    <div class="row-fluid">
      <div class="span12">
      	  <h5>Información!</h5>
           <img src="images/icons/glyphicons_280_settings.png">  Actualmente se encuentra registrado en la sede 
           <?php 
            $tblusuario = new TblUsuario;
            $usuariodatos = $tblusuario->consulta_usuario_completo($usuario);
            $nombrecomisaria = $usuariodatos->nombrecomisaria;
            echo "<b>".$nombrecomisaria."</b>";
            ?>
        <div class="row-fluid">
          <div class="span3">
           <h5>Seleccione Comisaria:</h5>
          <select required name="entidad_ingreso" id="entidad_ingreso" >
            <option value="" style="display:none" >Seleccione Comisaria</option>
            <option value="1">MINGOB</option>
          <option value="2">Comisaria 11</option>
            <option value="3">Comisaria 12</option>
            <option value="4">Comisaria 13</option>
            <option value="5">Comisaria 14</option>
            <option value="6">Comisaria 15</option>
            <option value="7">Comisaria 16</option>
            <option value="8">Comisaria 21</option>
            <option value="9">Comisaria 22</option>
            <option value="10">Comisaria 23</option>
            <option value="11">Comisaria 24</option>
            <option value="12">Comisaria 31</option>
            <option value="13">Comisaria 32</option>
            <option value="14">Comisaria 33</option>
            <option value="15">Comisaria 34</option>
            <option value="16">Comisaria 41</option>
            <option value="17">Comisaria 42</option>
            <option value="18">Comisaria 43</option>
            <option value="19">Comisaria 44</option>
            <option value="20">Comisaria 51</option>
            <option value="21">Comisaria 52</option>
            <option value="22">Comisaria 53</option>
            <option value="23">Comisaria 61</option>
            <option value="24">Comisaria 62</option>
            <option value="25">Comisaria 71</option>
            <option value="26">Comisaria 72</option>
            <option value="27">Comisaria 73</option>
            <option value="28">Comisaria 74</option>
          </select>
      </div>
          <div class="span3">
				<h5>Seleccione Tipo de Sede:</h5>
					<select required name="tipo_sede_ingreso" id="tipo_sede_ingreso">      
						<option value="1">Administrativa</option>
						<option value="2">Serenazgo</option>
						<option value="3">Sub Estación </option>
						<option value="4">Estacion Modelo</option>
						<option value="5">Comisaria Central</option>
						<option value="6">Estacion</option>
					</select>
			</div>
          <div class="span3">
          	<h5>Seleccione Sede:</h5>
              <select required  disabled name="sede_ingreso" id="sede_ingreso">
                <option value="" style="display:none;">Seleccione una Sede</option>
              </select>
          </div>
          <div class="span3">  
          	<button class="btn btn-large btn-primary" style="margin-top: 10%"  id="actualizarbutton1" type="button">Actualizar Datos</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>



</form> 
<script type="text/javascript">  
  $(document).ready(function(){
     /* $.ajax({
        type:'POST',
        url:'/sipolnuevo/index.php?r=Funcionesp/InformacionSede',
        beforeSend:function()
        {
        },
        success:function(response)
        { 
          $('.infousuario').html(response);
        },
      })*/;//fin del ajax

    $('#actualizarbutton1').click(function(){
      var url = window.location.pathname+"?r=Funcionesp/actualizarubicacion";
      var urll = window.location.pathname+"?r=site/logout";
          var comisaria =  $('#entidad_ingreso').val();  
   // alert(comisaria);
    var tipo_sede = $('#tipo_sede_ingreso').val();
    //alert(tipo_sede);
      var sede_ingreso =  $('#sede_ingreso').val();
      //alert(sede_ingreso);
      if(comisaria == ''){
        alert('Seleccione una Comisaria');
      }else if(tipo_sede == ''){
        alert('Seleccione tipo de sede');
      }else if(sede_ingreso == ''){
        alert('Seleccione sede');
      }else{
          var idusuario =  $('#codigousuario').val();
      $.ajax({
        type:'POST',
        url:url,
        data:{idusuario:idusuario,sede_ingreso:sede_ingreso},
        beforeSend:function()
        {
          //$('#cargandosugerencia').show();
        },
        success:function(response)
        { 
          $('#modalmensajesingreso').modal('hide')
          $('#modalmensajesingreso').html('');    
          $('#modalmensajesingreso').hide();
          alert('Su Sede Fue Actualizada.');
          $(location).attr('href',urll); 
        },
      });//fin del ajax
      return false;

      }
    });
   $('#entidad_ingreso').change(function()
   {
     $('#tipo_sede_ingreso').val('');
     $('#sede_ingreso').val('');
      var comisaria =  $('#entidad_ingreso').val();  
      var tipo_sede = $('#tipo_sede_ingreso').val();
        actualizaSede_ingreso(comisaria,tipo_sede);    
    });
   $('#tipo_sede_ingreso').change(function()
   {
    // $('#tipo_sede_ingreso').val('');
      $('#sede_ingreso').val('');
      var comisaria =  $('#entidad_ingreso').val();  
      var tipo_sede = $('#tipo_sede_ingreso').val();
      if(comisaria =='')
      {
        alert('Seleccione una Comisaria');
      }else{
        actualizaSede_ingreso(comisaria,tipo_sede);
      }    
    });
     function actualizaSede_ingreso(entidad,tipo_sede)
    {
     var entidad = entidad;
      var tipo_sede = tipo_sede;
      var url = window.location.pathname+"?r=TblSede/getsede";
     $.ajax({
             type: "POST",
             url: url,
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
             },
             success: function(result)
             {            
                  $('#modalprocesando').modal('hide');
               $("#sede_ingreso").empty();
               $("#sede_ingreso").html(result);
               $("#sede_ingreso").removeAttr('disabled');            
             }
           });
    }
  });
</script>
<?php

	#echo "tiene para ser modificado";
}//fin del validador para poder ser modificado

}else{
	echo '
		<div class="alert alert-info">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Información del Sistema!</h4>
		  <blockquote>
			<small><cite title="Source Title">Restricción de SIPOL</cite></small>
			</blockquote>
		</div>
		';
}
?>
</div>