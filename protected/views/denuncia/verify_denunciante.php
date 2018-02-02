<?php

//$idEvento = '2369';
$reportes = new Reportes;
$denunciante = $reportes->getDenunciante($idEvento);
$denunciante = (object) $denunciante;
$getHechosDenunciante = $reportes->getHechosDenunciante($idEvento);
$Primer_Nombre = "";
$Segundo_Nombre = "";
$Primer_Apellido = "";
$Segundo_Apellido = "";
$DatosDocumento = "Sin Documento de Identificación";
$f = "";

if(!empty($denunciante->Primer_Nombre)) $Primer_Nombre = $denunciante->Primer_Nombre;
if(!empty($denunciante->Segundo_Nombre)) $Segundo_Nombre = $denunciante->Segundo_Nombre;
if(!empty($denunciante->Primer_Apellido)) $Primer_Apellido = $denunciante->Primer_Apellido;	
if(!empty($denunciante->Segundo_Apellido)) $Segundo_Apellido = $denunciante->Segundo_Apellido;
if(!empty($denunciante->Tipo_identificacion)) $DatosDocumento = $denunciante->Tipo_identificacion.": ".$denunciante->Numero_identificacion;
$nombreCompleto = "<b>".$Primer_Nombre." ".$Segundo_Nombre." ".$Primer_Apellido." ".$Segundo_Apellido."</b>";

foreach ($getHechosDenunciante as $key => $value) {
	$value = (object) $value;
	$f = $f."<tr idpersonadetalle=".$value->id_persona_detalle."><td>".$value->id_evento_detalle."</td><td>".$value->nombre_hecho."</td><td>".
	$value->tipo_persona."</td><td style='text-align: center;'>".'<input class="recorreChk" type="checkbox" idpersonadetalle='.$value->id_persona_detalle.'></td></tr>';
	//var_dump($value);
}

?>

<div style="padding:3%">
<div style="padding:1%;">
	<label>Hechos relacionados con el denunciante: <?php echo $nombreCompleto." - ".$DatosDocumento; ?></label>
</div>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Número de Hecho</th>
			<th>Tipo de Hecho</th>
			<th>Denunciante se Relaciona como</th>
			<th>Utilizar el Nuevo Denunciante</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $f; ?>
	</tbody>
</table>
<div align="right">
	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	<button type="button" class="btn btn-primary" id="commitModify">Modificar Denunciante</button>
</div>
</div>


<script type="text/javascript">

$(document).ready(function(){

	$('#cancelModify').click(function(){

	}); //Final cancelModify
	
	$('#commitModify').click(function(){
		//alert('hizo el commit');
		var ipd = 'empty';

		$('.recorreChk').each(function(){
			if($(this).is(":checked"))
			{
				var idPersona = $(this).attr('idpersonadetalle');
				if(ipd !== 'empty'){
					ipd = ipd+"|"+idPersona;	
				}
				else{
					ipd = idPersona;
				}
				
				//alert(idPersona);
			}
		}); // Fin del recorrido
	
		//alert(ipd);

		var llave_clean = $('#llave_renap_clean').val();
		var cui_clean = $('#cui_renap_clean').val();
		var foto_clean = $('#foto_renap_clean').val();
		var contador = 0;
		var contador1 = 0;
		var contador2 = 0;
		var contador3 = 0;
		var datos_asociacion = new Array();
		var explotados_renap = new Array();
		var caracteristicas_fisicas = new Array();
		var datos_contacto = new Array();
		var inup = $('#denX').val();
		var hayHechos = $('#detX').val();
		var idEvento = $('#identificador_denuncia').val();
		var email = $('#r_email_cnt').val();
		
		if($("#es_asociacion").is(":checked"))
		{
			//alert('esta es una asoc');
			
			$('#datos_asociacion').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;
			
			datos_asociacion[contador3]= ident+ '~' +valor;   
	        contador3 = contador3 +1;
	        //alert('elemento.id='+ident+ ', elemento.value=' +valor);
			});

		}

		$('#explotados_renap').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;

			if(ident == 'r_nacimiento'){
				var h = new Array();
				h = valor.split('/');
				valor = h[2]+"-"+h[1]+"-"+h[0];
			}

			explotados_renap[contador]= ident+ '~' +valor;   
	        contador = contador +1;
	        //alert('elemento.id='+ident+ ', elemento.value=' +valor);
		});

		$('#caracteristicas_fisicas').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;
			
			caracteristicas_fisicas[contador1]= ident+ '~' +valor;   
	        contador1 = contador1 +1;
		});

		$('#datos_contacto').find(':input').each(function(){
			var elemento = this;
			var valor = elemento.value;
			var ident = elemento.id;
			
			datos_contacto[contador2]= ident+ '~' +valor;   
	        contador2 = contador2 +1;
		});

		saveDenunciante(datos_asociacion,explotados_renap,caracteristicas_fisicas,datos_contacto,llave_clean,cui_clean,foto_clean,idEvento,email,ipd);
		$(this).MostrarHechos(idEvento);
	}); //fin del commitModify
	
});// Fin del document Ready

</script>



