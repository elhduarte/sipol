<?php
/* @var $this ConfigOpcionesController */
/* @var $dataProvider CActiveDataProvider */
/*
$this->breadcrumbs=array(
	'Config Opciones',
);

$this->menu=array(
	array('label'=>'Create ConfigOpciones', 'url'=>array('create')),
	array('label'=>'Manage ConfigOpciones', 'url'=>array('admin')),
);
?>

<h1>Config Opciones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));*/
 ?>
<div class="cuerpo">
	<legend><img src="images/icons/glyphicons_280_settings.png" alt=""> Configuración del Sistema</legend>
<div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">QR Reportes</a></li>
    <li><a href="#tab2" data-toggle="tab">Carta Usuarios</a></li>
     <li><a href="#tab3" data-toggle="tab">Mensajes Sistema</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
    	<legend style="font-size: 15px;"><img src="images/icons/glyphicons_258_qrcode.png" alt=""> Configuración Reportes con Imagenes QR</legend>
      

<form class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="rutaservidor">Ruta del Servidor</label>
    <div class="controls">
      <input type="text" id="rutaservidor" placeholder="Ruta Servidor" disabled> <a href=""><i class="icon-edit"></i></a>  <a href=""><i class="icon-check"></i></a>
      <p>*<small class="text-info"> /var/www/default/sipol_betha/lib/codigoqr</small></p>
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="rutaimagenes">Ruta de las Imagenes</label>
    <div class="controls">
      <input type="text" id="rutaimagenes" placeholder="Ruta Imagen" disabled><a href=""><i class="icon-edit"></i></a>  <a href=""><i class="icon-check"></i></a>
      <p>*<small class="text-info"> http://sipol.mingob.gob.gt/sipol_betha/lib/codigoqr/temp/</small></p>
    </div>
  </div>
    <div class="control-group">
    <label class="control-label" for="urlqr">Url QR</label>
    <div class="controls">
      <input type="text" id="urlqr" placeholder="Url QR" disabled><a href=""><i class="icon-edit"></i></a>  <a href=""><i class="icon-check"></i></a>
      <p>*<small class="text-info"> http://sipol.mingob.gob.gt/sipol_betha/lib/codigoqr/temp/</small></p>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
  </div>
</form>


    </div>
    <div class="tab-pane" id="tab2">

<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span5">
           <legend style="font-size: 15px;"><img src="images/icons/glyphicons_029_notes_2.png" alt=""> Configuración Texto de Carta De Responsabilidad.</legend>

           <label for="estimadousuario">Estimado Usuario:</label>
           <textarea  style="width: 100%;" rows="15" id="estimadousaurio" name="estimadousuario">
            Se hace de su conocimiento que el usuarios y contraseña se entrega de forma personal y posteriormente será habilitado, al recibir este acceso, usted se hace directamente responsable del uso que se le pueda dar a la misma, en cuanto a tener confidencialidad, no compartirla, ni prestarla a otro usuario, por urgente que esta sea. La cuenta es de uso personal e intransferible. Al ingresar al sistema se solicita ingrese en la primera pantalla el usuario y contraseña (estándar) que se le ha entregado en este documento, posteriormente en una segunda pantalla se solicita, cambie su contraseña por la que usted crea conveniente preferentemente debe  estar compuesta por letras y números (mínimo 6 dígitos) por Políticas de Seguridad en los Sistemas de Información, establecidas en la Dirección de Informática de este Ministerio y Código Penal, Capítulo VII, artículo 274. USO Y ACCESO DE LA INFORMACION. El incumplimiento de estas disposiciones dará lugar a iniciar procedimiento administrativo correspondiente.
           </textarea>

             <label for="observacionesusuario">Observaciones:</label>
           <textarea  style="width: 100%;" rows="15" id="estimadousaurio" name="observacionesusuario">
            Al recibir la presente sírvase brindar los siguientes datos: NIT,  copia documento unico de identificación (DPI), móvil, dirección correo electrónico y firma, para ingresarlos en la bitácora de accesos, brindarle soporte o capacitación. Cualquier información adicional sírvase comunicarse a nuestro servicio HELP DESK  ext.  3201- en la Dirección de Informática, del Ministerio de Gobernación, donde gustosamente se le atenderá. 
            </textarea>

 <button type="submit" class="btn btn-primary">Guardar Cambios</button>




      </div>
      <div class="span5">
        <legend style="font-size: 15px;"> Ejemplo de Carta de Responsabilidad</legend>

        

        <iframe src="images/carta.pdf" width="600" height="780" style="border: none;"></iframe>



      </div>
    </div>
  </div>
</div>







      
    </div>
     <div class="tab-pane" id="tab3">
      <div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6">
      <legend style="font-size: 15px;"><img src="images/icons/glyphicons_117_embed.png" alt=""> Configuración Mensaje de Ingreso Sistema.</legend>

        <label class="checkbox">
            <input type="checkbox" value="">
           Estado del Mensaje para el Sistema.
        </label>

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
            var editorOffset = $('#editormensajeingreso').offset();
            $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editormensajeingreso').innerWidth()-35});
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
      $('#editormensajeingreso').wysiwyg({ fileUploadError: showErrorAlert} );
        window.prettyPrint && prettyPrint();
      });
    </script>
          <div class="btn-toolbar well well-small" data-role="editor-toolbar" data-target="#editormensajeingreso">
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
          <div id="editormensajeingreso" style="margin-bottom:1%;"></div>  
       
      </div><!--termina el span6 para la introduccion de  texto para el mensaje-->
      <div class="span6">
        <legend>Vista Actual del Mensaje:</legend>


        <?php
         $mensaje_sistema = new LoginForm;
                $mensaje_ingreso_data = $mensaje_sistema->mensaje_ingreso();
      if(isset($mensaje_ingreso_data)){
        echo $mensaje_ingreso_data;

      }else{
        //echo "";

      }
       ?>   
      </div>
    </div>
  </div>
</div>
    </div>
  </div>
</div>
</div>