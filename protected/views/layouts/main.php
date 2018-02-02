<?php date_default_timezone_set("America/Guatemala");?>
<!doctype html>

<html lang="es">
<head>
	<meta charset="UTF-8" />
	<title>Apolo Denuncias</title>
	<link rel="shortcut icon" href="images/pnchead.png" type="image/x-icon">


	  	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sipol_propietario.css" />
	  	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sipol_estilos.css" />
	  	<link rel="stylesheet" type="text/css" src = "/BASE-PLATFORM/js/openlayers/theme/default/style.css"/>
		<script type = "text/javascript" src = "BASE-PLATFORM/js/openlayers/OpenLayers.js"></script>
			<!--script type = "text/javascript" src = "/BASE-PLATFORM/js/openlayers/OpenLayers.js"></script-->

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/select2/select2.css" />

		<script src="<?php echo Yii::app()->request->baseUrl; ?>/lib/select2/select2.js" type="text/javascript"></script>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/datepicker.css" />
		<script type = "text/javascript" src = "<?php echo Yii::app()->request->baseUrl; ?>/lib/datepicker/bootstrap-datepicker.js"></script>
		<script type = "text/javascript" src = "<?php echo Yii::app()->request->baseUrl; ?>/lib/js/validador.js"></script>
		<script type = "text/javascript" src = "<?php echo Yii::app()->request->baseUrl; ?>/js/ajaxq.js"></script>


		
</head>

<body>
<!--
	<div id="header" >
		<div id="encabezado" style="background:url(<?php echo Yii::app()->request->baseUrl; ?>/images/encabezadonuevo.png) top repeat-x;">
			<img style ="height: auto; max-width: 400px;" src="<?php echo Yii::app()->request->baseUrl."/images/logo-cuarto.png"; ?>" alt="" /></div>
		</div>
	</div> header -->
	<?php
if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) 
{
?>
		<div class="row-fluid">
		  <div class="span12">
		    <legend>Seleccione un Explorador</legend>
		    <div class="row-fluid">
						      <div class="span3"><center><a href="http://www.google.com/intl/es-419/chrome/"><img src="images/browsers/chrome.jpg" alt="" style="width: auto; max-width: 30%;"/></a>
						      	<H3>Google Chrome</H3>
						      	</center>
						       </div>
					      <div class="span3"><center><a href="http://support.apple.com/kb/DL1531?viewlocale=es_ES"><img src="images/browsers/safari.png" alt=""style="width: auto; max-width: 30%;" /></a> 
					      	<H3>Safari</H3>
					      	</center>
					      </div>
				       <div class="span3"><center><a href="http://www.opera.com/es-419/"><img src="images/browsers/opera.jpg" alt="" style="width: auto; max-width: 30%;" /></a>
							<H3>Opera</H3>
				      	</center>
				       </div>
			        <div class="span3"><center><a href="http://www.mozilla.org/es-ES/firefox/new/"><img src="images/browsers/firefox.png" alt="" style="width: auto; max-width: 30%;"/></a> 
					<H3>Mozilla Firefox</H3>
			      	</center>
			        </div>
		    </div>
		  </div>
		</div>
<?php
} else {
?>
<?php 
	if(Yii::app()->user->isGuest== false)
		{
 			?>
 				<?php
					if(isset($_SESSION['ID_ROL_SIPOL']))
						{
							//var_dump($_SESSION['ID_ROL_SIPOL']);
							$validador = json_decode($_SESSION['ID_ROL_SIPOL']);
							if($validador==true)
							{		
								$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
								$fotografia = $variable_datos_usuario[0]->fotografia;
								$id_usuario_ingreso = "<div align='center'><img src='data:image/jpg;base64,".$fotografia."'  width='48px' height='64px'></div>";
								$usuario_id = $variable_datos_usuario[0]->id_usuario; 
								$nombre_rol = $validador[0]->nombre_rol;
								$idusuarioingresado = $variable_datos_usuario[0]->id_usuario;
								$descompilar = new Encrypter;
								$variableusuario = $descompilar->compilarget("'".$idusuarioingresado."'");							
								/*funcion para comenzar hacer el conteo de buzon para los usuarios*/
								$conteobuzon = new Funcionesp;
								//$conteo_descripcion = $conteobuzon->conteo_buzon_ingreso($idusuarioingresado);
								 $mensaje_sistema = new LoginForm;
								$mensaje_ingreso_data = $mensaje_sistema->mensaje_ingreso();
								$mensaje_ingreso_data_pass = $mensaje_sistema->mensaje_ingreso_pass();
								Yii::app()->user->name = $nombre_rol;
								$colorusuario="";

								if($nombre_rol=="root")
								{
									
									$colorusuario ="success"; 
								}else if($nombre_rol=="developer")
								{
									$colorusuario ="primary"; 

								}
							}							
						}else{
								echo "Variable id rol no esta definida";
								}//fin de variable de isser con ID Rol
				?>
						<div id="mainmenu">
							<?php
					   			$nuevo = array();
					      		$validador = json_decode($_SESSION['ID_ROL_SIPOL']);
					      		$asignacion = $validador[0]->permisos;
					   			$permisos =  json_decode($validador[0]->permisos);
			   						if($permisos == null)
			   								{
			   									echo "No se puede completar el asistente de menu error en la base de datos";
										$this->widget(
											'bootstrap.widgets.TbNavbar', 
											array(
													'brand' =>'Menu',
													//'brandUrl'=>array('denuncia/selector'),
													'fixed' => false,
													'type' => 'null',
													'collapse'=>true, // requires bootstrap-responsive.css
													'items' =>  
													array(
															array(
																	'class' => 'bootstrap.widgets.TbMenu',
																	//'items' => $nuevo
																),
																	array(
																			'class' => 'bootstrap.widgets.TbButtonGroup',
																			'htmlOptions'=>
																				array('class'=>'pull-right'),
																						'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
																						'buttons'=>
																						array(
																								array('label'=>'Usuario: '.Yii::app()->session['USUARIO'] .'','visible'=>!Yii::app()->user->isGuest,
																								'items'=>
																										array(
																												array('label'=>'Cambiar Contraseña', 'url'=>array('cCUsuario/update&id=')),
																												array('label'=>'Creación de Usuario', 'url'=>array('cCUsuario/usuarios')),
																												array('label'=>'Cerrar Sesión', 'url'=>array('/site/logout')),
																											)),
																								),
																		),
														),

												)
										);

			   			}else{


		$menu = array();
		$menudos= array();
foreach ($permisos as $key => $value) 
{
	if($value->tipo == "0")
	{
		foreach ($value->item as $key => $value)
		 {
		array_push($menu,array('label'=>$key, 'url'=>array($value)));
		}
	}else{
		$titulodos = $value->titulo;
		$items = array();
		foreach ($value->item as $key => $value)
		{
				array_push($items,array('label'=>$key, 'url'=>array($value)));
		}
		$menudos=  array('label'=>$titulodos, 'url'=>'#', 
                	'items'=>$items
                	);
	}

	array_push($menu,$menudos);
	//var_dump($menu);
}
$this->widget('bootstrap.widgets.TbNavbar', array(
   'brand' => '<img style =" height: auto;max-width: 15%;" src="images/pnchead.png">  '.Yii::app()->user->name,
	'fixed' => false,
	'type' => 'null',
	'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>$menu,
        ),
array(
			'class' => 'bootstrap.widgets.TbButtonGroup',
			'encodeLabel'=>false,
			'htmlOptions'=>
				array('class'=>'pull-right'),
						'type'=>$colorusuario, // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'buttons'=>
						array(
								array('label'=>''.Yii::app()->session['USUARIO'] .'','visible'=>!Yii::app()->user->isGuest,
								'items'=>
										array(
												array('label'=>'Soporte Tecnico','url'=>array('SoporteTecnico/NuevoTicket'),'linkOptions'=>(array('target'=>'_blank'))),	
												array('label'=>'Ver Perfil', 'url'=>array('TblUsuario/ViewPerfil&perfil='.$variableusuario)),
												array('label'=>'Cambiar Sede', 'url'=>array('TblUsuario/CambioSede&perfil='.$variableusuario)),
												array('label'=>'Cambiar Contraseña', 'url'=>array('TblUsuario/password')),
												array('label'=>'Cerrar Sesión', 'url'=>array('/site/logout')),
												#array('label'=>$foto_fin, 'url'=>'#'),															
											)
										),
								//
								//array('label'=>$foto_fin,),
								),
		),
  '<ul class="nav pull-right">
  	<li class="divider-vertical" style="height:30px;"></li>
		  <li><a href="#sugerenciamodal" data-toggle="modal">
				 <i class="icon-tag"></i> Sugerencia</a>
		  </li>  
		  <li class="divider-vertical" style="height:30px;"></li>
		                 
  </ul>'
    ),
)); 
echo '<input type="text" style="display:none" name="usuario_id" id="usuario_id" value="'.$usuario_id.'" /> ';	
		$nip = '2344';

		$nip= $variable_datos_usuario[0]->usuario;

	$WSConsulta = new WSConsulta;
		$poli = $WSConsulta->ConsultaPersonalPNC($nip);
		$poli = json_decode($poli);
		$primerNombre = $poli->n1;
		$segundoNombre = $poli->n2;
		$primerApellido = $poli->a1;
		$segundoApellido = $poli->a2;
		$ncompleto = $primerNombre.' '.$segundoNombre.' '.$primerApellido.' '.$segundoApellido;

if($primerNombre =='Desconocido'){
	
}else {
	?>
	<div class="row-fluid">     
      <div class="col-md-12">
         <div style="position:fixed;left:85%; top:10%;">
         	<div class="span12 offset3"><img class="img-circle" style="max-width: 35%;" src="data:image/jpg;base64,<?php echo $poli->foto; ?>"></div>
     		
  	<h6><?php echo $ncompleto; ?></h6>
        </div>  
     </div>
</div>
<?php 
}	
?>



	

<?php
if( Yii::app()->session['notificacion_pass'] == 1)
{
	echo '<script type="text/javascript">
	$(document).ready(function(){
		$("#modalmensajesingresopass").modal({
			show: true,
		 keyboard: false,
  			backdrop: "static"
			});
	});
</script> ';
 Yii::app()->session['notificacion_pass'] = 0;
}
else if( Yii::app()->session['notificacion'] == 1)
{
	echo '<script type="text/javascript">
	$(document).ready(function(){
		$("#modalmensajesingreso").modal({
			show: true,
		 keyboard: false,
  			backdrop: "static"
			});
	});
</script> ';
 Yii::app()->session['notificacion'] = 0;
}else{

}
}//termina la funcion de la validacion
?>
</div><!-- mainmenu -->
	<?php 
}
?>
<div class="" id="page" style="margin-left:2%; margin-right:2%;" >
<!-- Modal -->
<div id="soportetecnico" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Soporte Técnico</h3>
  </div>
  <div class="modal-body">
  <h2><strong>Ministerio De Gobernación -PNC</strong><br></h2>

 <h4><img style ="padding-right:9px; padding-bottom: 7px;" src="images/icons/glyphicons_169_phone.png">Teléfono: <b>30249817</h4></b>
 <h4><img style ="padding-right:9px; padding-bottom: 7px;" src="images/icons/glyphicons_127_message_flag.png">Correo: <b>soportesipol@pnc.gob.gt</h4></b>
<legend>
<small><cite title="24 Horas"><strong>Disponible 24 Horas</strong></cite></small>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php echo $content; ?>
		<script>
		$('.dropdown-toggle').dropdown();
		</script>
	<div class="clear"></div>
<?php
}//if cuando el explorador es diferente de IE
?>
<style type="text/css">
	.futclass
	{
		    display: block;
    width: 100%;
    padding: 0;
    
    font-size: 15px;

    line-height: 30px;
    color: white;
    border: 0;

	}
	.mifut{
		   background-color: #424558;
		   padding: 2%;	
 
     line-height: 100%;
    text-align: center;
    color: #CCC;	
	}
</style>
	<div id="footer" style="padding-top: 5%;"">
	<hr>
	<div class="mifut">
		<img style ="max-width: 10%;" src="images/sgtic.PNG">
		<span class="futclass">
			Subdirección General de tecnologia de la información y la comunicación. &copy; <?php echo date('Y'); ?>
		</span>
	</div>
		
		
	</div><!-- footer -->





		<!-- Modal -->
		<div id="sugerenciamodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h4 id="myModalLabel"><img src="images/icons/glyphicons_064_lightbulb.png" style="height: auto; max-width: 5%;" alt=""> Modulo de Sugerencia/Reporte Sistema Sipol</h4>
		  </div>
		  <div class="modal-body well">  
		  	 <div id="cargandosugerencia" style="display:none; height: auto; max-width: 5%;"><img src="images/loading.gif" alt=""/>Enviando Sugerencia</div>
		 
			<!--blockquote>
				 <small><cite title="Source Title">Ministerio de Gobernación</cite></small>
				  <small><cite title="Source Title">Correo Electronico <a href="mailto:#">soporte@mingob.gob.gt</a></cite></small>
				  <small><cite title="Source Title">Telefono: 24138888 ext <strong>3202 / 3201</strong></cite></small>
			</blockquote-->
			 <p>Si tienes una (Idea,Sugerencia o Reporte de Error) sobre el Sistema Sipol  puedes escribir en la parte inferior y con gusto atenderemos lo solicitado.</p>
		<script type="text/javascript">
		  $(function(){
		    function initToolbarBootstrapBindings() {
		      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
		            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
		            'Times New Roman', 'Verdana'],
		            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
		      $.each(fonts, function (idx, fontName) {
		          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
		      });
		      $('a[title]').tooltip({container:'body'});
		      $('.dropdown-menu input').click(function() {return false;})
		        .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
		        .keydown('esc', function () {this.value='';$(this).change();});

		      $('[data-role=magic-overlay]').each(function () { 
		        var overlay = $(this), target = $(overlay.data('target')); 
		        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
		      });
		      if ("onwebkitspeechchange"  in document.createElement("input")) {
		        var editorOffset = $('#editorsugerencia').offset();
		        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editorsugerencia').innerWidth()-35});
		      } else {
		        $('#voiceBtn').hide();
		      }
		  };
		  function showErrorAlert (reason, detail) {
		    var msg='';
		    if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		    else {
		      console.log("error uploading file", reason, detail);
		    }
		    $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		     '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
		  };
		    initToolbarBootstrapBindings();  
		  $('#editorsugerencia').wysiwyg({ fileUploadError: showErrorAlert} );
		    window.prettyPrint && prettyPrint();
		  });
		</script>
		      <div class="btn-toolbar well well-small" data-role="editor-toolbar" data-target="#editorsugerencia">
		        <div class="btn-group">
		          <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i><img class="img_relato" src="images/icons/glyphicons_100_font.png"></i><b class="caret"></b></a>
		            <ul class="dropdown-menu">
		            </ul>
		          </div>
		        <div class="btn-group">
		          <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i><img class="img_relato" src="images/icons/glyphicons_105_text_height.png"></i>&nbsp;<b class="caret"></b></a>
		            <ul class="dropdown-menu">
		            <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
		            <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
		            <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
		            </ul>
		        </div>
		        <div class="btn-group">
		          <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i><img class="img_relato" src="images/icons/glyphicons_102_bold.png"></i></a>
		          <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i><img class="img_relato" src="images/icons/glyphicons_101_italic.png"></i></a>
		          <a class="btn" data-edit="strikethrough" title="Strikethrough"><i><img class="img_relato" src="images/icons/glyphicons_104_text_strike.png"></i></a>
		       </div>
		        <div class="btn-group">
		          <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i><img class="img_relato" src="images/icons/glyphicons_114_list.png"></i></a>
		          <!--<a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>-->
		       </div>
		        <div class="btn-group">
		          <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i><img class="img_relato" src="images/icons/glyphicons_110_align_left.png"></i></a>
		          <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i><img class="img_relato" src="images/icons/glyphicons_111_align_center.png"></i></a>
		          <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i><img class="img_relato" src="images/icons/glyphicons_112_align_right.png"></i></a>
		          <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i><img class="img_relato" src="images/icons/glyphicons_113_justify.png"></i></a>
		        </div>         
		      </div>
		      <div id="editorsugerencia" style="margin-bottom:1%;"></div>   
		</div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" type="submit" aria-hidden="true">Cerrar</button>
		    <button class="btn btn-primary" id="enviarsugerencia">Enviar Sugerencia</button>   
		  </div>
		</div><!--terminacion del modal para sugerencias-->
		<!-- Modal -->
		<div id="modalmensajesingreso" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form action="" method="POST" id="formulariodemensaje" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h4 id="myModalLabel"><img src="images/icons/glyphicons_325_wallet.png" style="height: auto; max-width: 5%;" alt="">  Mensajes Del Sistema</h4>
		  </div>
		  <div class="modal-body well">  
		  	 <div id="cargandoenviomensaje" style="display:none; height: auto; max-width: 5%;"><img src="images/loading.gif" alt=""/>Enviando Respuesta</div>	 
			<!--blockquote>
				 <small><cite title="Source Title">Ministerio de Gobernación</cite></small>
				  <small><cite title="Source Title">Correo Electronico <a href="mailto:#">soporte@mingob.gob.gt</a></cite></small>
				  <small><cite title="Source Title">Telefono: 24138888 ext <strong>3202 / 3201</strong></cite></small>
			</blockquote-->
			<?php
			if(isset($mensaje_ingreso_data)){
				echo $mensaje_ingreso_data;

			}else{
				//echo "";

			}
			 ?>      
		</div>
		  <!--div class="modal-footer">
		    <button class="btn btn-primary" id="entendido" data-dismiss="modal" type="submit" aria-hidden="true">Entendido</button> 
		  </div-->
		  </form>
		</div><!--terminacion del modal para sugerencias-->



			<div id="modalmensajesingresopass" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form action="" method="POST" id="formulariodemensajepass" >
		  <div class="modal-header">
		    <h4 id="myModalLabel"><img src="images/icons/glyphicons_280_settings.png" style="height: auto; max-width: 5%;" alt="">  Cambio de Contraseña Obligatorio</h4>
		  </div>
		  <div class="modal-body">  
		  	 <div id="cargandoenviomensaje" style="display:none; height: auto; max-width: 5%;"><img src="images/loading.gif" alt=""/>Enviando Respuesta</div>	 
			<!--blockquote>
				 <small><cite title="Source Title">Ministerio de Gobernación</cite></small>
				  <small><cite title="Source Title">Correo Electronico <a href="mailto:#">soporte@mingob.gob.gt</a></cite></small>
				  <small><cite title="Source Title">Telefono: 24138888 ext <strong>3202 / 3201</strong></cite></small>
			</blockquote-->
			<?php
			if(isset($mensaje_ingreso_data_pass)){
				echo $mensaje_ingreso_data_pass;

			}else{
				//echo "";

			}
			 ?>      
		</div>
		  <!--div class="modal-footer">
		    <button class="btn btn-primary" id="entendido" data-dismiss="modal" type="submit" aria-hidden="true">Entendido</button> 
		  </div-->
		  </form>
		</div><!--terminacion del modal para sugerencias-->



		<!--Modal para mensajes de ingreso procesando-->
		<div id="modalprocesando" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  </div>
		  <div class="modal-body">
		  	 <h3><img src="images/loading.gif" style="height: auto; max-width: 5%;"  alt=""/>  Estamos procesando su solicitud. </h3>
		  </div>
		  <div class="modal-footer">
		    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Terminar</button>
		  </div>
		</div>
		
		<!--Modal para cualquier tipo de mensaje-->
		<div id="modalPublico" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header" style="border-bottom: 0px;">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  </div>
		  <div class="modal-body" id="modalPublicoBody">
		  	 
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
		  </div>
		</div>
		<!--Fin del modal publico-->


</body>
</html>
<script src="lib/textrich/funciones.js"></script> 
<link href="lib/textrich/index.css" rel="stylesheet">
<script src="lib/textrich/bootstrap-wysiwyg.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#entendido').click(function(){
				var idusuario =  $('#usuario_id').val();
			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("Funcionesp/actualizarestadomensaje"); ?>',
				data:{
					idusuario:idusuario
				},
				beforeSend:function()
				{					
					$('#cargandoenviomensaje').show();
				},
				success:function(response)
				{	
					$('#modalmensajesingreso').modal('hide')
					$('#modalmensajesingreso').html('');		
					$('#modalmensajesingreso').hide();
				},
			});//fin del ajax
			return false;
		});
			$('#enviarsugerencia').click(function(){
				var sugerencia = $('#editorsugerencia').html();
				var idusuario =  $('#usuario_id').val();
				var url = document.URL;
			$.ajax({
				type:'POST',
				url:'<?php echo CController::createUrl("SoporteTecnico/EnviarSugerencia"); ?>',
				data:{
					sugerencia:sugerencia,
					idusuario:idusuario,
					url:url
				},
				beforeSend:function()
				{
					$('#cargandosugerencia').show();

				},
				success:function(response)
				{	
					$('#sugerenciamodal').modal('hide')
					$('#editorsugerencia').html('');		
					$('#cargandosugerencia').hide();
					alert('Gracias por la Sugerencia');
				},
			});//fin del ajax
			return false;
		});
	});
</script> 
<script type = "text/javascript" src = "<?php echo Yii::app()->request->baseUrl; ?>/lib/js/validador.js"></script>

<style type="text/css">
@media (max-width: 480px) { 
    .nav-tabs > li {
        float:none;
    }
}
</style>
