<script src="lib/js/bootstrap-progressbar.js"></script>
<?php 
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$fotografia = $variable_datos_usuario[0]->fotografia;
$nombre_completo = $variable_datos_usuario[0]->nombre_completo;
$email_usuario = $variable_datos_usuario[0]->email;
$id_usuario = $variable_datos_usuario[0]->id_usuario;

if (strlen($fotografia) == 0 )
{
	$foto_fin = "<div align='center'><img src='images/noimagen.png'   width='66px' height='82px'></div>";
}else{
 	$foto_fin = "<div align='center'><img src='data:image/jpg;base64,".$fotografia."'   width='66px' height='82px'></div>";
}
?>

    <style type="text/css">
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
.iconoaceptar
{
    background: url(images/aceptar.png);
     background-position: 260px 0px;
    background-repeat: no-repeat;
}
.iconocancelar
{
    background: url(images/cancelar.png);
     background-position: 260px 0px;
    background-repeat: no-repeat;
}

    </style>
   


</head>
<body>
 
 
<script>
  $(document).ready(function(){

  $( "#unoinput" )
  .keyup(function() {
    $("#dosinput").removeClass("input-block-level iconoaceptar").addClass("input-block-level");
      $("#dosinput").removeClass("input-block-level iconocancelar").addClass("input-block-level");
      $("#dosinput").val('');
    var value = $(this).val();
    var conteo = value.length;
    if(conteo <= 3){
        $("#unoinput").removeClass("input-block-level iconoaceptar").addClass("input-block-level");           
            $('.titulodeseguridad').text('(No Recomendable)');
    }else if(conteo <= 6){
          $("#unoinput").removeClass("input-block-level").addClass("input-block-level iconoaceptar");
          $('.titulodeseguridad').text('(Bajo)');
    }else if(conteo <= 9){
           $('.titulodeseguridad').text('(Recomendable)');
    }else if(conteo >= 13){
           $('.titulodeseguridad').text('(Alto)');
    }
  });


 $( "#dosinput" )
  .keyup(function() {
    var value = $( this ).val();
    var dosinput = $('#unoinput').val();
    if(value == dosinput)
    {
      $("#dosinput").removeClass("input-block-level iconocancelar").addClass("input-block-level iconoaceptar");
    }else{
      $("#dosinput").removeClass("input-block-level iconoaceptar").addClass("input-block-level iconocancelar");
      $("#dosinput").removeClass("input-block-level").addClass("input-block-level iconocancelar");
    }
  });
  });
  </script>

  <script type="text/javascript">
  $(document).ready(function(){
    $('#modalformulario').submit(function(){
       var correonuevo = $('#correonuevo').val();
      //alert(correonuevo);
         $.ajax({
         	type: 'POST',
         	url: '<?php echo Yii::app()->createUrl('TblUsuario/cambiocorreo'); ?>',
          data:
          { 
            correonuevo:correonuevo,
            usuario:<?php echo $id_usuario; ?>,
         
          },
          beforeSend: function(response)
          {
          
            //$('#select').html('Ingresando Proceso');
            
          },
          success: function(response)
          {
              
                $('#correousuario').html(response);  
                $('#correonuevo').val('');
               $('#modalcorreo').modal('hide')

          },
        });
   return false;
     


    });

   $('#frmcambiopassword').submit(function(){
      
    var unoinput = $('#unoinput').val();
    var dosinput = $('#dosinput').val();
    var cantidad = $('#unoinput').val();
    var cordenada = cantidad.length;
    
    if(cordenada>=4)
    {
    	
    	if(unoinput == dosinput)
		    {	
		    	$.ajax({
         	type: 'POST',
         	url: '<?php echo Yii::app()->createUrl('TblUsuario/cambiarpassword'); ?>',
          data:
          { 
            passwordnuevo:unoinput,
            usuario:<?php echo $id_usuario; ?>,
         
          },
          beforeSend: function(response)
          {
          
            //$('#select').html('Ingresando Proceso');
            
          },
          success: function(response)
          {          	
          	$(location).attr('href','<?php echo Yii::app()->createUrl("site/login"); ?>'); 

          },
        });
   return false;

		     /* $("#dosinput").removeClass("input-block-level iconocancelar").addClass("input-block-level iconoaceptar");*/
		    }else{
		    	    $("#dosinput").removeClass("input-block-level iconoaceptar").addClass("input-block-level iconocancelar");
      				$("#dosinput").removeClass("input-block-level").addClass("input-block-level iconocancelar");
		    	return false;
		    }//fin del if cuando son validos
    }else{
    	alert('Ingrese un minio de 4 Caracteres');
    	return false;
    }//fin de la cantidad de caracters
    
    });


  });
</script>
    <div class="container">
      <form class="form-signin" id="frmcambiopassword">
        <h4 class="form-signin-heading">Configuración nueva contraseña </h4>
      <div class="row-fluid">
          <div class="span12">
            <div class="row-fluid">
              <div class="span4">
                <div class="pull-right">
                  <?php 
                    
                    echo $foto_fin;
                   ?>
                </div>
              </div>
              <div class="span8">
                <strong>Informacion Usuario</strong>
                <div class="row-fluid">
                  <div class="span12">
                    <?php echo $nombre_completo; ?>
                    <div id="correousuario"><i><?php echo $email_usuario; ?></i></div>
                    <a href="#modalcorreo" data-toggle="modal">Cambiar o Agregar Correo</a>
                  </div>
                </div>
              </div>
            </div>
            <hr>
          </div>
        </div>
            <label for="unoinput">Nueva:</label>
            <input type="password"  class="input-block-level"  id="unoinput" value="">
            <label for="dosinput">Vuelve a escribir la contraseña nueva:</label>
            <input type="password" class="input-block-level"  id="dosinput" value="">
            <center><label for="baruno"><strong>Nivel de Seguridad <id class="titulodeseguridad"></id></strong></label></center>
           
            <center>
          
        <button class="btn btn-primary" type="submit">Hacer Cambios</button>
        </center>
      </form>
<div id='resultado'style="display:none;"></div>
    <!-- Modal -->
<div id="modalcorreo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalcorreoLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="modalcorreoLabel">Cambiar o Agregar Correo Electronico</h3>
  </div>
  <div class="modal-body">
    <div id="correomodal" class="form-signin">  
    <form action="" id="modalformulario">
    	
  
    <label for="correonuevo">Correo Electronico</label>
    <input type="email" id="correonuevo"  class="input-block-level" required placeholder="Correo Electronico">
      
  </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Terminar</button>
    <button id="modalformulario" type="submit" class="btn btn-primary">Guardar Cambio</button>
  </div>
   </form>

   </div> <!-- /container -->
</div>