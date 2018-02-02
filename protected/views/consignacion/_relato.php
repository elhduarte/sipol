<script src="lib/textrich/funciones.js"></script> 
<link href="lib/textrich/index.css" rel="stylesheet">
<script src="lib/textrich/bootstrap-wysiwyg.js"></script>  

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
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
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
  $('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
</script>

<legend>Relato del Evento</legend> 
  <div class="row-fluid">
    <div class="span12">
      <div id="alerts"></div>
      <div class="btn-toolbar well well-small" data-role="editor-toolbar" data-target="#editor">
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
          <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i><img class="img_relato" src="images/icons/glyphicons_103_text_underline.png"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i><img class="img_relato" src="images/icons/glyphicons_114_list.png"></i></a>
          <!--<a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>-->
          <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i><img class="img_relato" src="images/icons/glyphicons_108_left_indent.png"></i></a>
          <a class="btn" data-edit="indent" title="Indent (Tab)"><i><img class="img_relato" src="images/icons/glyphicons_109_right_indent.png"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i><img class="img_relato" src="images/icons/glyphicons_110_align_left.png"></i></a>
          <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i><img class="img_relato" src="images/icons/glyphicons_111_align_center.png"></i></a>
          <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i><img class="img_relato" src="images/icons/glyphicons_112_align_right.png"></i></a>
          <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i><img class="img_relato" src="images/icons/glyphicons_113_justify.png"></i></a>
        </div>
       
        <div class="btn-group">
          <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i><img class="img_relato" src="images/icons/glyphicons_221_unshare.png"></i></a>
          <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i><img class="img_relato" src="images/icons/glyphicons_222_share.png"></i></a>
        </div>    
      </div>
      <div id="editor" style="margin-bottom:1%;"></div>

<?php 

  $MTblRelacionesTipo = new CatRelacionesTipo;
  $tipos = $MTblRelacionesTipo->getTipos();
  $MTblEntidad = new CatInstituciones;
  $instituciones = $MTblEntidad->getInstituciones();


?>
    <div class="cuerpo-small">  
      <legend>Personas y Entidades Relacionadas
        <div class="pull-right">
            <img src="images/info_icon.png"
            data-placement="left"
            id="ayuda_Obj"
            style="margin-top: 6px;">
        </div>
      </legend>
      <div class="row-fluid">
        <div class="span6 well well-small" style="margin-bottom: 0px;">
          <form id="personasEntidades">
            <div class="row-fluid">
              <div class="span6">
                <p class="campotit2">Tipo</p>
                <select class="span12" id="selectTipo" required>
                  <?php echo $tipos; ?>
                </select>
              </div>
              <div class="span6">
                <p class="campotit2">Entidad</p>
                <select class="span12" id="selectEntidad" required>
                  <?php echo $instituciones; ?>
                </select>
              </div>
            </div>
            <div>
              <p class="campotit2">Descripción</p>
              <textarea class="span12" rows="3" id="typeDescripcion"></textarea>
            </div>
            <legend style="margin-bottom:1%;"></legend>
            <div align="right">
              <button type="submit" class="btn btn-mini btn-info" id="AddType">Añadir</button>
            </div>
          </form>
        </div>
        
          

         <div class="span6" id="tblTypes">
          <table class="table table-striped table-bordered tabla_eventos_hechos">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Entidad</th>
                <th>Descripción</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div><!-- Fin del cuerpo -->
    <div class="cuerpo-small">
      <legend>Destinatario
        <div class="pull-right">
              <img src="images/info_icon.png"
              data-placement="left"
              id="ayuda_Destinatatio"
              style="margin-top: 6px;">
          </div>
      </legend>
      <div class="form-horizontal">
        <div class="control-group">
          <label for="contenidoDestinatario" class="control-label campotit">Dirigido a: </label>
          <div class="controls">
            <textarea id="contenidoDestinatario" type="text" value="" class="span10" placeholder="Nombre de la persona o Institución a quien dirige la denuncia" rows="4"></textarea>
          </div>
        </div>
      </div>
    </div>


      <legend style="padding-bottom:1%;"></legend>
      <div align="right">
        <button class='btn btn-primary' type='button' id='SaveRelato'>Guardar</button>
      </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    $('#ayuda_Destinatatio').tooltip({html: true, title:'<legend class="legend_tt"><i class="icon-question-sign icon-white">'+
      '</i>  AYUDA</legend><p style="line-height: 175%; text-align: justify;">Ingrese el dato de la persona o institución a quien va dirigida la incidencia. '+
      'El dato que ingrese en éste campo, se reflejará en el reporte final de la denuncia.'});
   
    $('#personasEntidades').submit(function(e){
      e.preventDefault();
      var tipo = $('#selectTipo option:selected').text();
      var entidad = $('#selectEntidad option:selected').text();
      var descripcion = $('#typeDescripcion').val();

      var tipoTrim = $(this).Trim(tipo);
      var entidadTrim = $(this).Trim(entidad);
      var descripcionTrim = $(this).Trim(descripcion);

      $('.tabla_eventos_hechos').append("<tr class=fila"+tipoTrim+entidadTrim+descripcionTrim+"><td>"+tipo+
            "</td><td>"+entidad+"</td><td>"+descripcion+"</td><td><div align='center'><a class='BotonClose eliminarType DeleteType' cual="+tipoTrim+entidadTrim+descripcionTrim+"><i class='icon-remove-sign'>"+
            "</i></a></div></td></tr>");
      $('#typeDescripcion').val('');
      $('#selectTipo').empty();
      $('#selectTipo').html('<?php echo $tipos; ?>');
      $('#selectEntidad').empty();
      $('#selectEntidad').html('<?php echo $instituciones; ?>');
      $('.eliminarType').tooltip({title:'Eliminar éste Objeto'});

      $('.DeleteType').click(function(){
        cual = $(this).attr('cual');
        $("tr.fila"+cual).remove();
        return false;
      }); //Fin deleteType

    });// Fin del submit personasEntidades

    $.fn.Trim = function(cadena)
    {
        var valor = cadena;
        var vse = valor.replace(/ /gi,'');
        vse = vse.replace('(','');
        vse = vse.replace(')','');
        vse = vse.replace(',','');
        return vse;
    }

    $('#SaveRelato').click(function(){

      var idEvento = $('#identificador_consignacion').val();
      //var idEvento = '83';
      var relato = $('#editor').html();
      var contadorpo = 0;
      var contadorgral = 0;
      var objetosjson = '[{"'+contadorgral+'":';
      var caracter = "";
      var destinatario = $('#contenidoDestinatario').val(); 

      if(relato == "")
      {
        $('#editor').popover({title:'Advertencia',placement:'top',content:'Por favor ingrese un relato del hecho para continuar...'});
        $('#editor').popover('show');
      }
      else if(destinatario == "")
      {
        $('#contenidoDestinatario').popover({title:'Advertencia',placement:'top',content:'Por favor ingrese un destinatario de la denuncia para continuar...'});
        $('#contenidoDestinatario').popover('show');
      }
      else
      {

        $('#tblTypes tr td').each(function(){
          if(contadorpo == 0)
          {
            objetosjson = objetosjson+'{"Tipo":';
            caracter = ",";
          }
          if(contadorpo == 1)
          {
            objetosjson = objetosjson+'"Entidad":';
            caracter = ",";
          }
          if(contadorpo == 2)
          {
            objetosjson = objetosjson+'"Descripcion":';
            caracter = "},";
          }
          if(contadorpo == 3)
          {
            contadorpo = 0;
            contadorgral=contadorgral+1;
            objetosjson = objetosjson+'"'+contadorgral+'":';
          }
          else
          {
            objetosjson = objetosjson+'"'+$(this).text()+'"'+caracter;
            contadorpo = contadorpo+1;
          }

        });// recorrer el each

        if(contadorgral==0)
        {
          objetosjson = "[{}]";
        }
        else
        {
          objetosjson = objetosjson+"||";
          var remp = ',"'+contadorgral+'":||';
          objetosjson = objetosjson.replace(remp,'}]');
        }

        $.ajax({
          type:'POST',
          url:'<?php echo CController::createUrl("Consignacion/SaveRelato"); ?>',
          data:{
                relato:relato,
                implicados:objetosjson,
                destinatario:destinatario,
                idEvento:idEvento
              },
          beforeSend: function()
          {
            $('#result_procesoModal').html('');
            $('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
            $('#procesoModal').modal('show'); 
          },
          success: function(respuesta)
          {
            
            $('#relX').val('1');
            $('#SaveRelato').actualizaResumen();
            $('#result_procesoModal').html('');
            $('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Relato del evento se ha registrado correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
            $('#aTab5').attr('href','#tab5');
            //$('#li_consigna').attr('class','enabled');
            ///$('#i_consignaciones').removeClass('BotonClose');
            //$('#aTab6').attr('href','#tab6');
            $('#cli_resumen').attr('class','enabled');
            $('#i_resumen').removeClass('BotonClose');                     
            
            $('#tab4').hide(50);
            $('#tab5').show(50);
            $('#nav_consignacion li:eq(4) a').tab('show');
          },
        });
      }
    });// Fin del click para salvar el relato

   


  });// Fin del Document ready
</script>