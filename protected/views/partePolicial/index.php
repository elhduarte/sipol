  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/lib/textrich/funciones.js"></script> 
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/textrich/index.css" rel="stylesheet">
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/lib/textrich/bootstrap-wysiwyg.js"></script>
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>


<script type="text/javascript">
  $(function() {
    $('#datetimepicker3').datetimepicker({
      pickDate: false,
    });
  });
</script>

<script type="text/javascript">
  $(function() {
    $('#datetimepicker2').datetimepicker({
      pickDate: false
    });
  });
</script>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker4').datetimepicker({
      pickTime: false,
      //startDate: new Date(),
      endDate: new Date(),
    });
  });
</script>


<div class="cuerpo">

 <legend><center><h4>Diario Policial</h4></center></legend>
  <div class="row-fluid">
     <div class="span12">
       <h4>Información Parte Policial</h4>  
        <form action='' method="GET" id="form_relato_policial" name="form_relato_policial">


<div class ="row-fluid">
  <div class = "span7 well">
    <div class = "row-fluid">
      <div class="span2" style="text-align:right; padding:5px;">
        <span class="campotit2">Titulo: </span>
      </div>
      <div class="span10">
        <input class="span12"  type="text" name="titulo" id="titulo">
      </div> 
    </div>
    <div class = "row-fluid">
      <div class="span2" style="text-align:right; padding:5px;">
        <span class="campotit2">Prioridad: </span>
      </div>
      <div class="span10">
        <div class="row-fluid">
          <div class="span1" style="padding:5px; text-align:right;">
              <input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked>
          </div>
          <div class="span1" style="padding-top:5px; margin-left:0px;">
            Bajo
          </div>
          <div class="span1" style="padding:5px; text-align:right;">
              <input type="radio" name="optionsRadios" id="optionsRadios2" value="2">
          </div>
          <div class="span1" style="padding-top:5px; margin-left:0px;">
            Medio
          </div>
          <div class="span1" style="padding:5px; text-align:right;">
              <input type="radio" name="optionsRadios" id="optionsRadios3" value="3">
          </div>
          <div class="span1" style="padding-top:5px; margin-left:0px;">
            Alto
          </div>

           <div class="span3" style="padding-top:15px; text-align:right;">
               <span class="campotit2">Seleccione Fecha:</span> 
          </div>
          <div class="span3" style="padding-top:5px; margin-left:0px;">
                  <div id="datetimepicker4" class="input-append">
                    <input data-format="yyyy-MM-dd"  name ="fechar" type="text" class="span11">
                     <span class="add-on">
                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                      </span>
                  </div>
          </div>


        </div>
      </div> 
    </div>
  </div>



<div class = "span5 well">
  <div class="row-fluid">
    <div class="span4" style="padding-top:5px; text-align:right;">
      <span class="campotit2">Hora inicio:</span> 
    </div>
    <div class="span8" style="height: 40px;">
      <div id="datetimepicker3" class="input-append">
      <input data-format="hh:mm:ss" name ="horai" type="text" class="span11">
        <span class="add-on">
          <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
        </span>
      </div>
    </div> 
  </div> <!-- fin del row fluid -->

  <div class="row-fluid">
    <div class="span4" style="padding-top:5px; text-align:right;">
      <span class="campotit2">Hora Fin:</span> 
    </div>
    <div class="span8">
      <div id="datetimepicker2" class="input-append">
      <input data-format="hh:mm:ss" name ="horaf" type="text" class="span11"></input>
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
      </div>
    </div> 
  </div> <!-- fin del row fluid -->
</div>
</div>
          <h4>Parte Policial</h4> 
            <div class="row-fluid">              
               <div class="span12 well">
                    <div id="alerts"></div>
                  <div class="btn-toolbar well" data-role="editor-toolbar" data-target="#editor">
                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        </ul>
                      </div>
                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                        <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                        <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                      <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                      <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                      <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                      <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                    </div>
                    <div class="btn-group">
                      <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                      <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                      <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                      <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                    </div>
                    <div class="btn-group">
                      <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                      <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                      <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                      <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                    </div>
                    <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
                      <div class="dropdown-menu input-append">
                        <input class="span12" placeholder="URL" type="text" data-edit="createLink"/>
                        <button class="btn" type="button">Add</button>
                      </div>
                      <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

                    </div>      
                    <div class="btn-group">
                      <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
                      <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                    </div>
                    <div class="btn-group">
                      <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                      <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                    </div>    
                  </div>
                    <div id="editor">
                    </div>
                     </div><!--div class="span8 well"-->
                        <br>
                        <hr>
                        <p ALIGN=right>
                       <button type="submit" class="btn btn-primary" value="Filtrar">Guardar Parte Policial</button>
                       </p>
                      </form>
                  <div id="accion">
                  </div> 
          </div><!--div class="row-fluid"-->
        </div><!--div class="span12 well"-->
  </div><!--div class="row-fluid"-->
</div><!--cuerpo-->