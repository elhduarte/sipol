<div class="form-inline" hidden>
	<label class="campotit" for="hechoInsert">Insert/Update</label>
	<input id="hechoInsert" type="text" value="I" class="input-mini">
	<label class="campotit" for="idEventoDetalleHecho">ID EventoDetalle</label>
	<input id="idEventoDetalleHecho" type="text" value="" class="input-mini">
</div>
<div class="alert alert-info">
	<label class="checkbox">
		<input type="checkbox" id="extensionSinHechos"> Deseo añadir nuevos hechos a ésta denuncia
	</label>
</div>

<div align="center" id="divAddOtroHecho" hidden>
	<legend></legend>
	<button type="button" class="btn btn-primary btn-large" id="addOtroHecho">
		<i class="icon-plus icon-white"></i> 
		Añadir otro Hecho
	</button>
	<legend style="margin-top:20px;"></legend>
</div>

<div id="extensionConHechos" hidden>
	<div class="well" id="hecho_prin" style="margin-bottom: 0px;">
		<input type="text" id="IdsPersonas" class="span4" style="display:none;">

		<?php 

			$model = new CatDenuncia;

			$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'form_select_hecho',
				'type'=>'vertical',
				'method' => 'post',
				'action' => Yii::app()->createUrl('Denuncia/ProcesaHechos'),
				'htmlOptions'=>array('class'=>'form-inline','name'=>'form_select_hecho','style'=>'margin-bottom:0px;',),
			)); 
		?>
			<div align="center">
			<span class="campotit"> Seleccione un Hecho</span>
			    <?php 
			    $criteria = new CDbCriteria;
			    $criteria->order = 'nombre_denuncia asc';
			    echo $form->dropDownListRow($model,'id_cat_denuncia',
			        CHtml::listData(CatDenuncia::model()->findAll($criteria),'id_cat_denuncia','nombre_denuncia'),
					array('class'=>'span6',
						'method'=>'post',
						'labelOptions'=>array('label'=>'',),
						'maxlength'=>12,
						'prompt'=>'Seleccione Un Hecho',
						'required'=>'true',
						'name'=>'hechos_dw',
						'id'=>'hechos_dw'));
				?>
				<!--button type="submit" class="btn  btn-primary" id="submit_hecho_select">Seleccionar</button-->
				<div class="pull-right">
					<img src="images/info_icon.png" data-placement="left" id="ayuda_hechos_select">
				</div>
			</div>
	
		<?php $this->endWidget(); ?>
	</div> <!-- fin del div hecho_prin well -->
		<div id="hecho_formulario" style="padding:0% 1%;">
		</div>


	<div style="display:none;" id="hechos_resumen_well" style="margin-top: 2%;">
		<legend>Hechos contenidos en ésta Denuncia:</legend>
		<div id="hechos_resumen"></div>
	</div>
</div>

<script type="text/javascript">


	$(document).ready(function(){
		$('#ayuda_hechos_select').tooltip({html: true, title: '<legend class="legend_tt"><i class="icon-question-sign icon-white"></i> AYUDA</legend><p style="line-height: 175%; text-align: justify;">Seleccione un hecho de la lista para llenar los datos que corresponden al mismo.</p>'});

		$('#hechos_dw').change(function(){
			$('#form_select_hecho').submit();
		});

		$('#form_select_hecho').submit(function(e){
			e.preventDefault();
			var nuevo_id_evento = $('#identificador_id_evento_nuevo').val();
			$.ajaxq('actionSubmit',{
				type:'POST',
				url:$(this).attr('action'),
				data:
					$(this).serialize()+'&id_denuncia='+nuevo_id_evento
					
				,
				beforeSend:function()
				{
					$('#hecho_formulario').html('');
					$('#hecho_formulario').html('<legend></legend><h4><img  height ="30px"  width="30px" src="images/loading.gif" style="padding:10px;"/>Procesando... Espere un momento por favor</h4>');
				},
				success:function(response)
				{
					$('#hechoInsert').val('I');
					$('#idEventoDetalleHecho').val('');
					$('#IdsPersonas').val('');
					$('#hecho_formulario').html('');
					$('#hecho_formulario').html(response);
				},
			});

		});

		$("#extensionSinHechos").live("click", function(){
			var id = parseInt($(this).val(), 10);
			var idEventoNuevo = $('#identificador_denuncia').val();
			if($(this).is(":checked")) 
			{
				if(idEventoNuevo=='')
				{
					$('#result_procesoModal').html('');
		            $('#result_procesoModal').html('<div class=\"modal-body\"><h4>Debe añadir un nuevo relato antes de poder añadir hechos a ésta extensión de denuncia...</h4></div><div class=\"modal-footer\"><button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Continuar</button></div>');
		            $('#procesoModal').modal('show');
		            $(this).removeAttr('checked');
				}
				else
				{
					$('#extensionConHechos').show(500);
				}
				
			}
			else
			{
				$('#extensionConHechos').hide(500);
			}
		});

		$.fn.actualizaResumen = function()
		{
			var a; 
			a = $('#nuevoIdEvento').val();
			//alert('EL NUEVO ID_EVENTO = '+a);
			//alert('actualizaResumen');


			if(a !== 'empty')
			{
				//alert('No es empty');
				$.ajax({
					type:'POST',
					url:'<?php echo CController::createUrl("ExtensionDenuncia/ResumenExtension"); ?>',
					data: { idEventonuevo:a },
					beforeSend: function()
					{

					},
					error:function(e)
					{
						//alert('tronitos');
					},
					success:function(r)
					{
						$('#commit').html('');
						$('#commit').html(r);
					}	
				});
			}
		}

		$('#addOtroHecho').click(function(){
			$('#divAddOtroHecho').hide(500);
			$('#hecho_prin').show(500);
		}); // Fin del click addOtroHecho

	}); //Fin del document ready
</script>