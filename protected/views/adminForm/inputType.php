<?php 
	$tipoInput = $_POST['type'];
	//echo Yii::app()->getController()->getAction()->id;
	//$tipoInput = "input";

?>

<legend style="padding-top:1%;"></legend>

<?php if($tipoInput == 'input'){ ?>

<form class="form-horizontal" id="inputForm">
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="inputActivado" checked disabled> Activado
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="inputNombre">Etiqueta del Campo</label>
		<div class="controls">
			<input type="text" id="inputNombre" placeholder="Nombre del Campo" class="span12" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="inputIdentificador">ID</label>
		<div class="controls">
			<input type="text" id="inputIdentificador" placeholder="Identificador del Campo" class="span12" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="tipoTexto">Tipo de Campo </label>
		<div class="controls">
			<select class="span12" id="tipoTexto" required>
				<option value ="" disabled selected style='display:none;'>Seleccione un Tipo</option>
				<option value="dpi">DPI</option>
				<option value="email">Email</option>
				<option value="number">Numérico</option>
				<option value="url">Página Web</option>
				<option value="text">Texto</option>
				<option value="tel">Teléfono</option>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="inputDescripcion">Descripción</label>
		<div class="controls">
			<input type="text" id="inputDescripcion" placeholder="Descripción del campo" class="span12">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox" for="inputRequired">
				<input type="checkbox" id="inputRequired"> Obligatorio
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit">Cantidad de Caracteres</label>
		<div class="controls">
			<input type="number" id="inputSizeMin" placeholder="Minima" min="1" class="span6">
			<input type="number" id="inputSizeMax" placeholder="Máxima" min="1" class="span6">
		</div>
	</div>
	<button class="btn btn-primary" id="inputFormSubmit" type="submit" style="display:none;">Submit</button>
</form>

<?php 

	} 

	if($tipoInput == 'select'){
?>
<form class="form-horizontal" id="selectForm">
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="selectActivado" checked disabled> Activado
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="selectNombre">Etiqueta del Campo</label>
		<div class="controls">
			<input type="text" id="selectNombre" placeholder="Nombre del Campo" class="span12">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="selectIdentificador">ID</label>
		<div class="controls">
			<input type="text" id="selectIdentificador" placeholder="Identificador del Campo" class="span12">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="selectRequired"> Obligatorio
			</label>
		</div>
	</div>
	<div class="well">
		<div class="control-group">
			<label class="control-label campotit" for="inputAddOptions">Añadir Opciones</label>
			<div class="controls">
				<div class="row-fluid">
					<div class="span10">
						<input type="text" class="span12 search-query" placeholder="Nombre de la opción" id="inputAddOptions">
					</div>
					<div class="span2">
						<button type="button" class="btn btn-info span12" id="addOption">Añadir</button>
					</div>
				</div>
			</div>
		</div>
		<div id="tablaOptions" hidden>
			<legend style="padding-top:0.5%;"></legend>
			<table class="table table-striped table-bordered tablaAdd">
				<thead>
				<tr>
					<th id='tituloFila0'>#</th>
					<th id='tituloFila1'>Nombre de Opción</th>
					<th id='tituloFila2'>Eliminar</th>
				</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	<button class="btn btn-primary" id="selectFormSubmit" type="submit" style="display:none;">Submit</button>
</form>
<?php 

	} 

	if($tipoInput == 'button'){
?>
<form class="form-horizontal" id="buttonForm">
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="btnActivado" checked disabled> Activado
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="btnPjuridica">Persona Jurídica</label>
		<div class="controls">
			<input type="text" id="btnPjuridica" placeholder="Nombre del Campo" class="span12" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="btnNombre">Nombre del Botón</label>
		<div class="controls">
			<input type="text" id="btnNombre" placeholder="Nombre del Campo" class="span12" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="btnIdentificador">ID</label>
		<div class="controls">
			<input type="text" id="btnIdentificador" placeholder="Identificador del Campo" class="span12" required>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="btnRequired"> Obligatorio
			</label>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="btnShowFisicas"> Mostrar Características Fisicas
			</label>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="btnShowContact"> Mostrar Datos de Contacto
			</label>
		</div>
	</div>
	<button class="btn btn-primary" id="buttonFormSubmit" type="submit" style="display:none;">Submit</button>
</form>

<?php 

	} 

	if($tipoInput == 'textarea'){
?>
<form class="form-horizontal" id="textareaForm">
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="taActivado" checked disabled> Activado
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="taNombre">Etiqueta del Campo</label>
		<div class="controls">
			<input type="text" id="taNombre" placeholder="Nombre del Campo" class="span12" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="taIdentificador">ID</label>
		<div class="controls">
			<input type="text" id="taIdentificador" placeholder="Identificador del Campo" class="span12" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="taRows">Cantidad de Filas</label>
		<div class="controls">
			<input type="number" id="taRows" placeholder="Entre 1 y 4" min="1" max="4" class="span12">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit" for="taDescripcion">Descripción</label>
		<div class="controls">
			<input type="text" id="taDescripcion" placeholder="Descripción del campo" class="span12">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox" for="taRequired">
				<input type="checkbox" id="taRequired"> Obligatorio
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label campotit">Cantidad de Caracteres</label>
		<div class="controls">
			<input type="number" id="taSizeMin" placeholder="Minima" min="1" class="span6">
			<input type="number" id="taSizeMax" placeholder="Máxima" min="1" class="span6">
		</div>
	</div>
	<button class="btn btn-primary" id="textareaFormSubmit" type="submit" style="display:none;">Submit</button>
</form>
<?php 

	} 

	//if($tipoInput == 'textarea'){
?>
<legend style="padding:1%;"></legend>
<div align="right">
	<button type="button" class="btn btn-primary" id="btnSubmitForm">Añadir al Formulario</button>
</div>



<script type="text/javascript">
$(document).ready(function(){
	var correl = 1;
	var conteo = 0;

	$('#addOption').click(function(){
		var send = new Array();
		var app = '';
		var creaTabla;
		var close = '<i class="icon-trash"></i>';
		var value = $('#inputAddOptions').val();

		creaTabla = creaTabla+"<td>"+correl+"</td>";
		creaTabla= creaTabla + "<td class='valueSelect'>"+value+"</td>";
		creaTabla = creaTabla+"<td id='"+conteo+"' class='ButtonClose' style='text-align: center;'>"+close+"</td>";

		$('.tablaAdd').append("<tr class='filaNumero"+conteo+"'>"+creaTabla+"</tr>");
		$('#tablaOptions').show(500);

		conteo++;
		correl++;
		$('#inputAddOptions').val('');
		$('#inputAddOptions').focus();

		$('.ButtonClose').click(function(){
			var identificador = $(this).attr('id');
			$('tr.filaNumero'+identificador).remove();
    	});
	}); // Fin del click addOption

	$('#inputAddOptions').keypress(function(e){
		//Keypress # 13 is enter key
		if(e.which == 13)
			$('#addOption').click();
	});

	$('#btnSubmitForm').click(function(){
		var formulario = "#"+"<?php echo $tipoInput; ?>"+"FormSubmit";
		$(formulario).click();
	}); //Fin btnSubmitForm

	$('#inputForm').submit(function(e){
		e.preventDefault();
		
		var tipo = "input";
		var activado;
		var id = $('#inputIdentificador').val();
		var name = $('#inputNombre').val();
		var type = $('#tipoTexto').val();
		var placeholder = $('#inputDescripcion').val();
		var required;
		var sizeMin = $('#inputSizeMin').val();
		var sizeMax = $('#inputSizeMax').val();
		$('#inputActivado').attr('checked') ? activado="1" : activado="0";
		$('#inputRequired').attr('checked') ? required="1" : required="0";
		var idTabla = $('#idCampoSave').val();
		var modelo = $('#nombreModeloSave').val();

		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("AdminForm/SaveCampo"); ?>',
			data:
			{
				tipo:tipo,
				sizeMax:sizeMax,
				sizeMin:sizeMin,
				activado:activado,
				id:id,
				name:name,
				type:type,
				placeholder:placeholder,
				required:required,
				idTabla:idTabla,
				modelo:modelo
			},
			beforeSend:function()
			{
				$('#catalogosList').html('');
				$('#catalogosList').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error:function(error)
			{
				alert('error: '+error);
			},
			success:function(response)
			{
				//alert(response);
				$('#formType').hide(500);
				$('#catalogosList').html('');
				$('#catalogosList').html(response);
				$('#formType').html('');
				$('#tipoCampo').val('');
				refreshCatalogo();
			}
		});//End ajax function

	});//End inputForm Submit

	$('#textareaForm').submit(function(e){
		e.preventDefault();
		var tipo = "textarea";
		var idTabla = $('#idCampoSave').val();
		var modelo = $('#nombreModeloSave').val();
		var activado;
		var name = $('#taNombre').val();
		var id = $('#taIdentificador').val();
		var filasNum = $('#taRows').val();
		var placeholder = $('#taDescripcion').val();
		var required;
		var sizeMin = $('#taSizeMin').val();
		var sizeMax = $('#taSizeMax').val();
		$('#taActivado').attr('checked') ? activado="1" : activado="0";
		$('#taRequired').attr('checked') ? required="1" : required="0";

		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("AdminForm/SaveCampo"); ?>',
			data:
			{
				tipo:tipo,
				idTabla:idTabla,
				modelo:modelo,
				activado:activado,
				name:name,
				id:id,
				filasNum:filasNum,
				placeholder:placeholder,
				required:required,
				sizeMax:sizeMax,
				sizeMin:sizeMin
			},
			beforeSend:function()
			{
				$('#catalogosList').html('');
				$('#catalogosList').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error:function(xhr, status, error)
			{
				alert('error: '+status);
			},
			success:function(response)
			{
				//alert(response);
				$('#formType').hide(500);
				$('#catalogosList').html('');
				$('#catalogosList').html(response);
				$('#formType').html('');
				$('#tipoCampo').val('');
				refreshCatalogo();
			}
		});//End ajax function

	}); //Fin del textareaForm submit

	$('#buttonForm').submit(function(e){
		e.preventDefault();

		var tipo = "button";
		var idTabla = $('#idCampoSave').val();
		var modelo = $('#nombreModeloSave').val();
		var personaJuridica = $('#btnPjuridica').val();
		var name = $('#btnNombre').val();
		var id = $('#btnIdentificador').val();
		var activado;
		var fisicas;
		var contact;

		$('#btnActivado').attr('checked') ? activado="1" : activado="0";
		$('#btnRequired').attr('checked') ? required="1" : required="0";
		$('#btnShowFisicas').attr('checked') ? fisicas="1" : fisicas="0";
		$('#btnShowContact').attr('checked') ? contact="1" : contact="0";

		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("AdminForm/SaveCampo"); ?>',
			data:
			{
				tipo:tipo,
				idTabla:idTabla,
				modelo:modelo,
				personaJuridica:personaJuridica,
				activado:activado,
				name:name,
				id:id,
				required:required,
				fisicas:fisicas,
				contact:contact				
			},
			beforeSend:function()
			{
				$('#catalogosList').html('');
				$('#catalogosList').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error:function(error)
			{
				alert('error: '+error);
			},
			success:function(response)
			{
				//alert(response);
				$('#formType').hide(500);
				$('#catalogosList').html('');
				$('#catalogosList').html(response);
				$('#formType').html('');
				$('#tipoCampo').val('');
				refreshCatalogo();
			}
		});//End ajax function

	}); // Fin del buttonForm Submit

	$('#selectForm').submit(function(e){
		e.preventDefault();

		var tipo = "select";
		alert(tipo);
		var idTabla = $('#idCampoSave').val();
		var modelo = $('#nombreModeloSave').val();
		var name = $('#selectNombre').val();
		var id = $('#selectIdentificador').val();
		var required;
		var opciones = new Array();
		var count = 0;
		var activado;

		$('#selectActivado').attr('checked') ? activado="1" : activado="0";
		$('#selectRequired').attr('checked') ? required="1" : required="0";

		$('.valueSelect').each(function(){
			opciones[count] = $(this).text();
			count ++;
		}); // Fin del each a valueSelect

		$.ajax({
			type:'POST',
			url:'<?php echo CController::createUrl("AdminForm/SaveCampo"); ?>',
			data:{
				tipo:tipo,
				idTabla:idTabla,
				modelo:modelo,
				activado:activado,
				name:name,
				id:id,
				required:required,
				opciones:opciones
			},
			beforeSend:function()
			{
				alert('el beforeSend');
				$('#catalogosList').html('');
				$('#catalogosList').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error:function(xhr, status, error)
			{
				alert('error: '+status);
			},
			success:function(response)
			{
				//alert(response);
				$('#formType').hide(500);
				$('#catalogosList').html('');
				$('#catalogosList').html(response);
				$('#formType').html('');
				$('#tipoCampo').val('');
				refreshCatalogo();
			}
		}); //Fin del ajax
		
		alert(opciones);

	}); //Fin del SelectForm

	refreshCatalogo = function()
	{
		var idTabla = $('#idCampoSave').val();
		var modelo = $('#nombreModeloSave').val();
		$('#previewFather').show(500);

		$.ajax({
			type: 'POST',
			url: '<?php echo CController::createUrl("AdminForm/preview")?>',
			data: {
				idTabla:idTabla,
				modelo:modelo
			},
			beforeSend:function(){
				$('#previewCatalogo').html('');
				$('#previewCatalogo').html('<h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
			},
			error:function(xhr, status, error){
				$('#previewCatalogo').html('');
				$('#previewCatalogo').html('<h4>Ha ocurrido un error con la vista Previa... </h4>err: '+status);
			},
			success:function(response){
				$('#previewCatalogo').html('');
				$('#previewCatalogo').html(response);
			}
		}); // Fin del ajax
	}

});// Fin del Document Ready
</script>

<style type="text/css">
  .ButtonClose {
  	cursor:pointer;
  }
  .ButtonClose i {
  	opacity: .4;
  }
  .ButtonClose :hover {
  	opacity: .6;
  }
 </style>