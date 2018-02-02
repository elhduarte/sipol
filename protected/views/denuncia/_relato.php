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
<legend style="margin-bottom: 0px;">Relato del Evento</legend> 
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
      <div id="editor" name ="editor" style="margin-bottom:0.5%;"></div>

<?php 

  $m_objetos = new CatObjetosDenuncia;
  $opciones = $m_objetos->getObjetos();
  //echo CHtml::tag('img', array('src'=>'images/denuncia.png'));
?>
<div class="cuerpo">
  <legend>Objetos Relacionados
    <div class="pull-right">
        <img src="images/info_icon.png"
        data-placement="left"
        id="ayuda_Obj"
        name ="ayuda_Obj"
        style="margin-top: 6px;">
    </div>
  </legend>
  <div class="row-fluid">
    <div class="well span7 well-small">
      <div class="row-fluid">
        <div class="span4">
          <p class="campotit2">Objeto</p>
          <select class="span12" id="select">
            <?php echo $opciones; ?>
          </select>
        </div>
        <div class="span8">
          <p class="campotit2">Descripción</p>
          <textarea class="span12" rows="3" name="informacion" id="informacion"></textarea>
        </div>  
      </div>
      <legend style="margin-bottom:1%;"></legend>
      <div align="right">
        <button class="btn btn-mini btn-info" id="agregar">Agregar Objeto</button>
      </div>
    </div>
    <div class="span5" id="tbl_objetos">
      <table class="table table-striped table-bordered tabla_eventos_hechos">
        <thead>
          <tr>
            <th>Objeto</th>
            <th>Descripcion</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>



<div class="cuerpo">
  <legend>Destinatario
    <div class="pull-right">
          <img src="images/info_icon.png"
          data-placement="left"
          id="ayuda_Destinatatio"
          style="margin-top: 6px;">
      </div>
  </legend>
  <div>
    <div class="row-fluid">
      <div class="span2" align="right">
        <label for="contenidoDestinatario" class="campotit2">Dirigido a: </label>
      </div>
      <div class="span10">
        <textarea id="contenidoDestinatario" type="text" value="" class="span12" placeholder="Nombre de la persona o Institución a quien dirige la denuncia" rows="4"></textarea>
      </div>
    </div>
  </div>
</div>

<div align="right">
  <button class='btn btn-primary' type='button' id='SaveRelato'>Guardar</button>
</div>





<script type="text/javascript">
  function borrar(cual) 
  {
  $("tr.fila"+cual).remove();
  return false;
  }
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('#ayuda_Obj').tooltip({html: true, title:'<legend class="legend_tt"><i class="icon-question-sign icon-white">'+
                        '</i>  AYUDA</legend><p style="line-height: 175%; text-align: justify;">Ingrese los objetos implicados según el relato que reciba del denunciante. '+
                        'Seleccione un objeto de la lista y escriba la descripción, luego haga clic en el botón "Agregar Objeto".'});

  $('#contenidoDestinatario').tooltip({html: true, title:'<legend class="legend_tt"><i class="icon-question-sign icon-white">'+
                        '</i>  AYUDA</legend><p style="line-height: 175%; text-align: justify;">Ingrese el dato de la persona o institución a quien va dirigida la denuncia. '+
                        'El dato que ingrese en éste campo, se reflejará en el reporte final de la denuncia.'});
  
$('#ayuda_Obj').tooltip({title:'Seleccione Un Departamento'});

  $('#select').change(function(){
    $('#select').popover('hide');
  });
  
  $('#agregar').click(function(){
    var selectValue = $('#select').val();
    if(selectValue == '')
    {
      $('#select').popover({content:'Seleccione un elemento de la lista para añadirlo', placement:'top',trigger:'manual'});
      $('#select').popover('show');
    }
    else
    {
      var objeto = $('#select option:selected').text();
      var descripcion = $('#informacion').val();

      var obTrim = mitrim(objeto);
      var desTrim = mitrim(descripcion);

       $('.tabla_eventos_hechos').append("<tr class=fila"+obTrim+desTrim+"><td>"+objeto+
                  "</td><td>"+descripcion+"</td><td><div align='center'><button class='BotonClose eliminarObjeto' onclick='borrar("+'"'+obTrim+desTrim+'"'+
                    ");'><i class='icon-remove-sign'></i></button></div></td></tr>");
       $('#informacion').val('');
       $('#select').empty();
       $('#select').html('<?php echo $opciones; ?>');
       $('.eliminarObjeto').tooltip({title:'Eliminar éste Objeto'});
    }
  });//Fin click Agregar

  function mitrim(cadena)
  {
    var valor = cadena;
    var vse = valor.replace(/ /gi,'');
    vse = vse.replace('(','');
    vse = vse.replace(')','');
    vse = vse.replace(',','');
    return vse;
  }

  $('#SaveRelato').click(function(){

    var id_denuncia = $('#identificador_denuncia').val();
    var relato = $('#editor').html();
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
      var contadorpo= 0;
      var contadordata = 0;
      var objetosjson = "[{";
        $('#tbl_objetos tr td').each(function(){
            if(contadorpo==1)
            {
              objetosjson = objetosjson + ':'
            }  
            if(contadorpo==2)
            {
              //alert('esta en el espacio');
              objetosjson = objetosjson + ',' 
              contadorpo= 0;

            }else{

              //alert($(this).text());

              objetosjson = objetosjson+'"'+$(this).text()+'"';
              contadorpo = contadorpo +1;
            }  
        });// Fin del each

        objetosjson = objetosjson+"--";
        objetosjson = objetosjson.replace(',--','');
        objetosjson = objetosjson+"}]";
        objetosjson = objetosjson.replace('[{--}]','""');

        //relatojson = relatojson+objetosjson;
        //alert(objetosjson);
        //alert(relatojson);
        //console.log(relatojson);

        $.ajax({
          type:'POST',
          url:'<?php echo CController::createUrl("Denuncia/Save_Relato"); ?>',
          data:{relato:relato,
                objetos:objetosjson,
                destinatario:destinatario,
                id_denuncia:id_denuncia},
          beforeSend: function()
          {
            $('#result_procesoModal').html('');
            $('#result_procesoModal').html('<h4><img  height =\"30px\"  width=\"30px\" src=\"images/loading.gif\" style=\"padding:10px;\"/>Estamos Procesando su petición...</h4>');
            $('#procesoModal').modal('show'); 
          },
          success: function()
          {
            $('#relX').val('1');
            $('#SaveRelato').actualizaResumen();
            $('#result_procesoModal').html('');
            $('#result_procesoModal').html('<div class=\"modal-body\"><h4>El Relato del evento se ha registrado correctamente</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
            $('#aTab5').attr('href','#tab5');
            $('#dli_resumen').attr('class','enabled');
            $('#i_resumen').removeClass('BotonClose');                     
            $('#tab4').hide(50);
            $('#tab5').show(50);
            $('#nav_denuncia li:eq(4) a').tab('show');
          },
        });
      }
    




  }); //fin del save formulario



}); // Fin del document ready





</script>