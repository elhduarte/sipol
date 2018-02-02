<?php
	class ConstructorHechos
	{
		public function nombreHechoExt($valor)
		{
			$sql = "SELECT  h.nombre_extravio
				FROM sipol_catalogos.cat_extravios h
				WHERE id_extravio = '".$valor."';";

			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			$variablearray = array();
			
			foreach($resultado as $key => $value)
			{
				foreach ($value as $llave => $valor) {
				}
			}

			return $valor;
		}
		public function obtenerCamposExt($idForm)
		{
			$countDesign = 0;
			$sql = "SELECT  *
				FROM sipol_catalogos.cat_extravios
				WHERE id_extravio = '".$idForm."';";

			$consulta = Yii::app()->db->createCommand($sql)->queryAll();
			$result = array();
			foreach($consulta as $key => $value)
			{
				$result = $value;				
			}

			$retorna = $this->FabricarCampos($result);
			return $retorna;
		}
		public function nombreHecho($valor)
		{
			$sql = "SELECT  h.nombre_denuncia
				FROM sipol_catalogos.cat_denuncia h
				WHERE id_cat_denuncia = '".$valor."';";

			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			$variablearray = array();
			
			foreach($resultado as $key => $value)
			{
				foreach ($value as $llave => $valor) {
				}
			}

			return $valor;
		}
		public function obtenerCampos($idForm)
		{
			$countDesign = 0;
			$sql = "SELECT  *
				FROM sipol_catalogos.cat_denuncia
				WHERE id_cat_denuncia = '".$idForm."';";

			$consulta = Yii::app()->db->createCommand($sql)->queryAll();
			$result = array();
			foreach($consulta as $key => $value)
			{
				$result = $value;				
			}

			$retorna = $this->FabricarCampos($result);
			return $retorna;
		}

		public function FabricarCampos($consulta)
		{
			$form_final = "";
			$form_print = "";
			$variable_campo ="";
			$contador = 1;
			$omisos = array("id_cat_denuncia","id_hecho_tipo","nombre_denuncia","tipo_hecho","id_extravio",
				"nombre_extravio","id_cat_consignados","nombre_consignado","id_motivo_consignados",
				"nombre_motivo_consignados","id_lugar_remision","nombre_lugar","id_objeto_incidencia",
				"nombre_objeto","id_tipo_incidencia","nombre_tipo_incidencia");

		foreach ($consulta as $key => $value)
		{
			if(!in_array($key, $omisos))
			{
			$variable_salida = json_decode($value);

				if($variable_salida->estado=="1")
				{
					if($variable_salida->catalogo == "1")
					{
							$required = '';
							if(isset($variable_salida->tipo->required) && !empty($variable_salida->tipo->required))
							{
								$required = ' required ';
							}
							$variable_campo="<label class='campotit' for='".$variable_salida->tipo->id."'>".
							$variable_salida->nombre."</label>
							<select type='select' class='".$variable_salida->tipo->class."' 
							name='".$variable_salida->tipo->name."' 
							id='".$variable_salida->tipo->id."' 
							nombre='".$variable_salida->nombre."'". $required ."
							><option value='' disabled selected style='display:none;'>Seleccione una Opción</option>";

						foreach ($variable_salida->datos as $keiy => $valuie) 
						{
							$keiy = str_replace(" ","_",$keiy);
							$variable_campo = $variable_campo."<option value=".$keiy.">".$valuie."</option>";                      
						}

						$variable_campo = $variable_campo."</select>";

						if(fmod($contador,4) == 0)
						{
							$form_final = "<div class='span3'> ".$variable_campo."</div>";
							$form_final = $form_final."</div>";
							$form_final = $form_final."<div class='row-fluid'>";
						}
						else
						{
							$form_final = "<div class='span3'> ".$variable_campo."</div>";
						}//fin del if

					}//fin de condición si es catalogo normal

					else if($variable_salida->catalogo == "2")
					{
						$required = '';
						if(isset($variable_salida->tipo->required) && !empty($variable_salida->tipo->required))
						{
							$required = ' required ';
						}

						$f = "";

						foreach ($variable_salida->datos as $keiy => $valuie) 
						{	
							//var_dump($valuie->hijos);
							if($valuie->hijos == '0')
							{
								$hijos = "false";
								$myChilds = "";
								$requerido = "";
								$nombreCampo = "";
								$sotro = "false";
							}
							else if($valuie->hijos == '1')
							{
								$hijos = "true";
								$requerido = $valuie->required;
								$registrosHijos = (array) $valuie->datos;
								$nombreCampo = $valuie->nombre;
								$myChilds = "";
								$sotro = "true";
								$c = 1;
								$cc = count($registrosHijos);
								foreach ($registrosHijos as $key => $value) {
									if($c !== $cc){
										 $myChilds = $myChilds.$value."~";
									}
									else{
										$myChilds = $myChilds.$value;
									}
									$c = $c+1;
								}
							}
							
							if(!empty($requerido) && $requerido !== "false") $requerido = 'required';

							$f = $f."<option opcionotros='".$sotro."' value=".$keiy." hijos='".$hijos."' myChilds='".$myChilds."' esrequerido='".$requerido."' nombreCampo='".
											$nombreCampo."' >".
												$keiy."</option>";                      
						}

						$variable_campo="<label class='campotit' for='".$variable_salida->tipo->id."'>".
						$variable_salida->nombre."</label>
						<select type='select' class='".$variable_salida->tipo->class." withchilds' 
						name='".$variable_salida->tipo->name."' 
						id='".$variable_salida->tipo->id."' 
						nombre='".$variable_salida->nombre."'". $required ."
						><option value='' disabled selected style='display:none;'>
						Seleccione una Opción</option>".$f."</select>
						<div id='divSelChild".$variable_salida->tipo->id."'></div>";

						if(fmod($contador,4) == 0)
						{
							$form_final = "<div class='span3'> ".$variable_campo."</div>";
							$form_final = $form_final."</div>";
							$form_final = $form_final."<div class='row-fluid'>";
						}
						else
						{
							$form_final = "<div class='span3'> ".$variable_campo."</div>";
						}//fin del if
					}// Fin de la condición si es un catálogo con hijos

					else
					{
						if($variable_salida->tipo->indice == "input")
						{
							if(($variable_salida->tipo->type =="text") || ($variable_salida->tipo->type =="email") || ($variable_salida->tipo->type =="url") || ($variable_salida->tipo->type =="tel") || ($variable_salida->tipo->type =="color")  )
							{
								if($variable_salida->tipo->required == "")
								{      
									$requerido = "";
								}
								else
								{
									$requerido = " required ";
								}//fin del campo requerido
								$title ='';
								$pattern='';
								if(isset($variable_salida->tipo->title))
								{
									$title=' title="'.$variable_salida->tipo->title.'" ';
								}
								if(isset($variable_salida->tipo->pattern))
								{
									$pattern=' pattern="'.$variable_salida->tipo->pattern.'" ';
								}

								$variable_campo = "<label class='campotit' for='".$variable_salida->tipo->id."'>".
									$variable_salida->nombre."</label>
									<input type='".$variable_salida->tipo->type."' 
									name='".$variable_salida->tipo->name."' 
									id='".$variable_salida->tipo->id."' 
									placeholder='".$variable_salida->tipo->placeholder."'
									class ='".$variable_salida->tipo->class."'
									nombre ='".$variable_salida->nombre."'".
										$requerido. $title. $pattern.">";			                
							}
						}// Fin condición si es un input

						if($variable_salida->tipo->indice == "boton")
						{
							$variable_campo = "<br><button type='".$variable_salida->tipo->type."' 
							name='".$variable_salida->tipo->name."'
							id='".$variable_salida->tipo->id."'
							class='".$variable_salida->tipo->class."' 
							personaJ='".$variable_salida->tipo->personaJ."' 
							pcontact='".$variable_salida->tipo->pcontact."' 
							pcaract='".$variable_salida->tipo->pcaract."' 
							style='margin-top:5px;'>".
							$variable_salida->nombre."</button>";
						}//Fin de else si es un boton

						if($variable_salida->tipo->indice == "textarea")
						{
							if($variable_salida->tipo->required == "")
							{      
								$requerido = "";
							}
							else
							{
								$requerido = " required ";
							}//fin del campo requerido

						$variable_campo = "<label class='campotit' for='".$variable_salida->tipo->id."'>".
							$variable_salida->nombre."</label>
							<textarea type='".$variable_salida->tipo->type."' 
							name='".$variable_salida->tipo->name."' 
							id='".$variable_salida->tipo->id."' 
							placeholder='".$variable_salida->tipo->placeholder."'
							class ='".$variable_salida->tipo->class."'
							nombre ='".$variable_salida->nombre."'".
							$requerido." rows='3'></textarea>";	
						}// Fin del constructor del textarea

						if(fmod($contador,4) == 0)
						{
							$form_final = "<div class='span3'> ".$variable_campo."</div>";
							$form_final = $form_final."</div>";
							$form_final = $form_final."<div class='row-fluid'>";
						}
						else
						{
							$form_final = "<div class='span3'> ".$variable_campo."</div>";
						}

					}// Fin de else de condición si es catalogo

					$contador = $contador +1;
					$form_print = $form_print.$form_final;

				}//fin del estado 1
			}//Fin de condición si la columna es la correcta
		}//termina el forech completo para recorere lo que tiene la base de datos
		return $form_print;
		}

		public function consultaArray($recibe)
		{
			#devuelve un solo array de la consulta enviada

			foreach($recibe as $key => $value)
			{
				$result = $value;				
			}
			return $result;
		}

		public function explotaJsonGuion($json)
		{
			#devuelve los key y los values separados por ":" y entre ellos por un "-" 
			#Ej: "Departamento: Guatemala - Municipio: Guatemala"
			$var = json_decode($json);
			$varPrint = "";

			foreach ($var as $key => $value) 
			{
				$varPrint = $varPrint.$key.": ".$value." - ";
			}

			$varPrint = $varPrint."--";
			$varPrint = str_replace("- --", "", $varPrint);
			return $varPrint;
		}

		public function consumoVehiculos()
		{
			$controlador = Yii::app()->createUrl("Vehiculos/ConsultaVehiculos");
			$dropCall = '<span style=\"padding-left: 3%; padding-right: 3%;\">|</span>
					<button class=\"btn btn-mini cancelCall\" type=\"button\">Cancelar Petición</button>';
			$formularioVehiculos = '<legend style="padding-top:1%"></legend>
			<form id="frmConsumoVehiculos">
				<div class="alert alert-info">
					<div class="row-fluid" align=>
						<div class="span2 offset2" align="center">
							<img src="images/pnctransito.JPG">

						</div>
						<div class="span2">
							<label class="campotit" for="SATtipoPlaca">Tipo Placa</label>
							<select class="span12 ttOp" id="SATtipoPlaca" required>
								<option value ="" disabled selected style="display:none;">Seleccione una Opción</option>
								<option value="A" title="ALQUILER" data-toggle="tooltip">A</option>
								<option value="C" title="COMERCIAL">C</option>
								<option value="CC" title="CUERPO CONSULAR">CC</option>
								<option value="CD" title="CUERPO DIPLOMATICO">CD</option>
								<option value="CO" title="CONSULAR">CO</option>
								<option value="EXT" title="EXTRANJERO">EXT</option>
								<option value="M" title="MOTO">M</option>
								<option value="MI" title="MISION INTERNACIONAL">MI</option>
								<option value="MO" title="MOTO OFICIAL">MO</option>
								<option value="O" title="OFICIAL">O</option>
								<option value="P" title="PARTICULAR">P</option>
								<option value="T" title="TRACTOR">T</option>
								<option value="TC" title="TRANSCARGA">TC</option>
								<option value="TCE" title="TRANSCARGA EXT">TCE</option>
								<option value="U" title="URBANO">U</option>
							</select>
						</div>
						<div class="span2">
							<label class="campotit" for="SATnumeroPlaca">Número de Placa</label>
							<input class="span12" id="SATnumeroPlaca" type="text" maxlength="6" minlength="6" required>
						</div>
						<div class="span2">
							<br>
							<button type="submit" class="btn btn-info" style="margin-top:5px;"><i class="icon-search icon-white"></i> Buscar Vehículo</button>
						</div>
						<div class="span2">
							<img src="images/sat.png" width="100%" height="100%">
						</div>
						<div class="span2" id="VehiculosProcesando" style="padding-top:1.5%;">
						</div>	
					</div>
				</div>
			</form>
			<div class="alert alert-error" id="respuestaSolvencias" style="display:none;">respuestaSolvencias</div>
			<div class="alert alert-success" id="respuestaSat" style="display:none;">respuestaSat</div>
			<div class="well" id="respuestaNovedades" style="display:none;">respgguestaNovedades</div>
			<div class="alert alert-info" id="errorVehiculos" style="display:none;"></div>'.
			'<script type="text/javascript">
		$(document).ready(function(){
			var llamada;
			var dropCall = "<span style=\"padding-left: 5%; padding-right: 5%;\">|</span>"+
					"<button class=\"btn btn-mini cancelCall\" type=\"button\">Cancelar</button>";
			//alert(dropCall);
			$("#frmConsumoVehiculos").submit(function(e){
				e.preventDefault();
				$("#respuestaSat").hide(500);
				$("#errorVehiculos").hide(500);
				$("#respuestaSolvencias").hide(500);
				$("#respuestaNovedades").hide(500);
				var tipoPlaca = $("#SATtipoPlaca option:selected").html();
				var numeroPlaca = $("#SATnumeroPlaca").val();
				//alert(tipoPlaca+" "+numeroPlaca);
				var vehiculosResponse = Array();
				var novedades = "";
				var noveHTML = "";
				var contador = 0;
				var datoSat = "";

				llamada = $.ajax({
					type:"POST",
					url:"'.$controlador.'",
					data:
					{
						tipoPlaca:tipoPlaca,
						numeroPlaca:numeroPlaca,
					},
					timeout:30000,
					beforeSend:function()
					{
						$("#VehiculosProcesando").html("");
						$("#VehiculosProcesando").html("<img src=\"images/loading.gif\" style=\"height:35px;\">"+dropCall);
						$(".cancelCall").click(function(){ llamada.abort(); });
					},
					error: function(xhr, status, error)
					{	
						if(status === "abort"){
							$("#VehiculosProcesando").html("");
						}
						else{
							$("#VehiculosProcesando").html("");
							$("#errorVehiculos").show(500);
							$("#errorVehiculos").html("<i class=\"icon-warning-sign\"></i> No he econtraron resultados en tránsito con el numero de placa: "+tipoPlaca+" "+numeroPlaca)
						}
					},
					success:function(result)
					{
						$("#VehiculosProcesando").html("");
						//alert(result);
						vehiculosResponse = result.split("|-|");
						if(vehiculosResponse[0] !== "empty")
						{
							$("#respuestaSolvencias").html(vehiculosResponse[0]);
							$("#respuestaSolvencias").show(500);
						}
						
						if(vehiculosResponse[1] == "empty")
						{
							$("#VehiculosProcesando").html("");
							$("#errorVehiculos").show(500);
							$("#errorVehiculos").html("<i class=\"icon-warning-sign\"></i> No he econtraron resultados en tránsito con el numero de placa: "+tipoPlaca+" "+numeroPlaca);
							$("#tipo_placa").val("");
							$("#no_placa").val("");
							$("#Tipo_Vehiculo").val("");
							$("#no_motor").val("");
							$("#no_chasis").val("");
							$("#no_modelo").val("");
							$("#marca").val("");
							$("#Linea_Vehiculo").val("");
							$("#color").val("");
						}
						else
						{
							$("#tipo_placa").val("");
							$("#no_placa").val("");
							$("#Tipo_Vehiculo").val("");
							$("#no_motor").val("");
							$("#no_chasis").val("");
							$("#no_modelo").val("");
							$("#marca").val("");
							$("#Linea_Vehiculo").val("");
							$("#color").val("");
							datoSat = JSON.parse(vehiculosResponse[1]);
							$("#tipo_placa").val(tipoPlaca);
							$("#no_placa").val(numeroPlaca);
							$("#Tipo_Vehiculo").val(datoSat["tipo"]);
							$("#no_motor").val(datoSat["motor"]);
							$("#no_chasis").val(datoSat["chasis"]);
							$("#no_modelo").val(datoSat["modelo"]);
							$("#marca").val(datoSat["marca"]);
							$("#Linea_Vehiculo").val(datoSat["linea"]);
							$("#color").val(datoSat["color"]);
							$("#propietario").val(datoSat["propietario"]);
							$("#respuestaSat").html("<i class=\"icon-info-sign\"></i> Los datos obtenidos del Departamento de Tránsito con la placa: "+tipoPlaca+" "+numeroPlaca+", han completado los campos, verifique que éstos sean correctos.");
							$("#respuestaSat").show(500);
						}

						if(vehiculosResponse[2] == "[]")
						{
							
						}else
						{
							try
							{
								//alert(vehiculosResponse[2]);
								var respuestapar = "";
								respuestapar = vehiculosResponse[2];
								respuestapar = respuestapar.replace("[", "");
								respuestapar = respuestapar.replace("]", "");
								//alert(respuestapar);
								$("#respuestaNovedades").show(500);
								novedades = JSON.parse(respuestapar);
								//console.log(novedades.id_boleta);
								var noveHTML = "<legend>Novedades Relacionadas con la placa: "+tipoPlaca+" "+numeroPlaca+"</legend>";
								//$.each(novedades, function(index, val) {
									noveHTML += "<div class=\"well well-small\"><div>ID Boleta: <b>"+novedades.id_boleta+
												"</b> Fecha: <b>"+novedades.fecha+"</b></div>"+
												"<div class=\"row-fluid\"><div class=\"span10\" align=\"justify\">"+novedades.detalle+"</div>"+
												"<div class=\"span2\" align=\"center\"><legend style=\"font-size: 14px; line-height: 20px;\">"+
												"Relacionar Novedad</legend><input type=\"checkbox\" id=\""+novedades.id_boleta+"\"> "+
												"</div></div></div>";
									//contador = contador + 1;

								//});
					
								$("#respuestaNovedades").html(noveHTML);
								//alert(noveHTML);
							}
							catch(e)
							{
								console.log(e);
							}
							
						
						}

						
					}
				});
			});//Fin del submit de frmConsumoVehiculos
		});
	</script>';

			return $formularioVehiculos;
		}

		public function nombreHechoLu($valor)
		{
			$sql = "SELECT  nombre_lugar
				FROM sipol_catalogos.cat_lugar_remision
				WHERE id_lugar_remision = '".$valor."';";

			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			$variablearray = array();
			
			foreach($resultado as $key => $value)
			{
				foreach ($value as $llave => $valor) {
				}
			}

			return $valor;
		}

		public function obtenerCamposLu($idForm)
		{
			$countDesign = 0;
			$sql = "SELECT *
				FROM sipol_catalogos.cat_lugar_remision
				WHERE id_lugar_remision = '".$idForm."';";

			$consulta = Yii::app()->db->createCommand($sql)->queryAll();
			$result = array();
			foreach($consulta as $key => $value)
			{
				$result = $value;				
			}

			$retorna = $this->FabricarCampos($result);
			return $retorna;
		}



	public function nombreHechoMo($valor)
		{
			$sql = "SELECT  nombre_motivo_consignados
				FROM sipol_catalogos.cat_motivo_consignados
				WHERE id_motivo_consignados = '".$valor."';";

			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			$variablearray = array();
			
			foreach($resultado as $key => $value)
			{
				foreach ($value as $llave => $valor) {
				}
			}

			return $valor;
		}

		public function obtenerCamposMo($idForm)
		{
			$countDesign = 0;
			$sql = "SELECT  *
				FROM sipol_catalogos.cat_motivo_consignados
				WHERE id_motivo_consignados= '".$idForm."';";

			$consulta = Yii::app()->db->createCommand($sql)->queryAll();
			$result = array();
			foreach($consulta as $key => $value)
			{
				$result = $value;				
			}

			$retorna = $this->FabricarCampos($result);
			return $retorna;
		}

		public function nombreHechoCon($valor)
		{
			$sql = "SELECT  c.nombre_consignado
				FROM sipol_catalogos.cat_consignados c
				WHERE id_cat_consignados = '".$valor."';";

			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			$variablearray = array();
			
			foreach($resultado as $key => $value)
			{
				foreach ($value as $llave => $valor) {
				}
			}

			return $valor;
		}

		public function obtenerCamposCon($idForm)
		{
			$countDesign = 0;
			$sql = "SELECT *
				FROM sipol_catalogos.cat_consignados 
				WHERE id_cat_consignados = '".$idForm."';";

			$consulta = Yii::app()->db->createCommand($sql)->queryAll();
			$result = array();
			foreach($consulta as $key => $value)
			{
				$result = $value;				
			}

			$retorna = $this->FabricarCampos($result);
			return $retorna;
		}

		public function nombreObjeto($valor)
		{
			$sql = "SELECT  oi.nombre_objeto
				FROM sipol_catalogos.cat_objeto_incidencia oi
				WHERE oi.id_objeto_incidencia = '".$valor."';";

			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			$variablearray = array();
			
			foreach($resultado as $key => $value)
			{
				foreach ($value as $llave => $valor) {
				}
			}

			return $valor;
		}
		public function getFormObjetos($idForm)
		{
			$countDesign = 0;
			$sql = "SELECT  *
				FROM sipol_catalogos.cat_objeto_incidencia
				WHERE id_objeto_incidencia = '".$idForm."';";

			$consulta = Yii::app()->db->createCommand($sql)->queryAll();
			$result = array();
			foreach($consulta as $key => $value)
			{
				$result = $value;				
			}

			$retorna = $this->FabricarCampos($result);
			return $retorna;
		}

		public function getCamposTipoIncidencia($idForm)
		{
			$sql = "SELECT * 
				FROM sipol_catalogos.cat_tipo_incidencia
				WHERE id_tipo_incidencia = '".$idForm."';";

			$consulta = Yii::app()->db->createCommand($sql)->queryAll();

			if(!empty($consulta))
			{
				$resultado = $consulta[0];
				$retorna = $this->FabricarCampos($resultado);
				return $retorna;
			}
			
			
			/*
			foreach($consulta as $key => $value)
			{
				$result = $value;				
			}

			$retorna = $this->FabricarCampos($result);
			return $retorna;
			*/
		}


	}
?>