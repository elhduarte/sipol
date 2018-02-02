<?php
class Reportes
{
	public function Encabezado($id_evento)
	{
		$consulta = "SELECT te.descripcion_evento as tipo_evento,
					e.evento_num,
					e.fecha_ingreso, 
					e.hora_ingreso,
					u.usuario,
					u.primer_nombre ||' '|| u.primer_apellido as nombre_usuario, 
					en.nombre_entidad, 
					s.nombre  ||' / '|| s.referencia as nombre_sede
				FROM sipol.tbl_evento e, 
					sipol_catalogos.cat_tipo_evento te, 
					sipol_usuario.tbl_usuario u, 
					catalogos_publicos.tbl_sede s, 
					catalogos_publicos.cat_entidad en
				WHERE e.id_tipo_evento = te.id_tipo_evento
				AND e.id_usuario = u.id_usuario
				AND e.id_sede = s.id_sede
				AND s.id_cat_entidad = en.id_cat_entidad
				AND e.id_evento = ".$id_evento.";";

		 $result = Yii::app()->db->createCommand($consulta)->queryAll();

		 foreach ($result as $key => $value) {}

		$value['hora_ingreso'] = str_replace('{', '', $value['hora_ingreso']);
		$value['hora_ingreso'] = str_replace('}', '', $value['hora_ingreso']);

		 return $value;
	}

	//s.nombre  ||' / '|| s.referencia as nombre_sede,
	public function Encabezadopdf($id_evento)
	{
		$consulta = "SELECT 
te.descripcion_evento as tipo_evento,
e.evento_num,
e.fecha_ingreso,
e.hora_ingreso,
u.usuario,
u.puesto,
u.primer_nombre ||' '|| u.primer_apellido as nombre_usuario,
en.nombre_entidad,
s.nombre as nombre_sede,
m.departamento,
m.municipio,
e.denuncia_mp
 FROM 
	sipol.tbl_evento e, 
	sipol_usuario.tbl_usuario u,
	sipol_catalogos.cat_tipo_evento te,
	catalogos_publicos.tbl_sede s,
	catalogos_publicos.cat_entidad en,
	catalogos_publicos.cat_municipios m
where e.id_evento = ".$id_evento."
and u.id_usuario = e.id_usuario
and te.id_tipo_evento = e.id_tipo_evento
and s.id_sede = e.id_sede
and en.id_cat_entidad = s.id_cat_entidad
and m.cod_mupio = e.id_mupio
		";

		 $result = Yii::app()->db->createCommand($consulta)->queryAll();

		 foreach ($result as $key => $value) {}

		$value['hora_ingreso'] = str_replace('{', '', $value['hora_ingreso']);
		$value['hora_ingreso'] = str_replace('}', '', $value['hora_ingreso']);

		 return $value;
	}
	public function getDenunciante($id_evento)
	{
		$consulta = "SELECT p.datos, p.caracteristicas, p.datos_contacto
					FROM sipol.tbl_persona p
					WHERE p.id_persona IN (
						SELECT pd.id_persona
						FROM sipol.tbl_persona_detalle pd
						WHERE pd.id_tipo_persona IN (
							SELECT tp.id_tipo_persona
							FROM sipol_catalogos.cat_tipo_persona tp
							WHERE tp.descripcion_tipo_persona LIKE 'Denunciante'
							)
						AND pd.id_evento_detalle IN (
							SELECT ed.id_evento_detalle
							FROM sipol.tbl_evento_detalle ed
							WHERE ed.id_evento = '".$id_evento."'
							AND ed.id_hecho_denuncia IS NULL
							)
						);";

		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		 foreach ($result as $key => $value) {}

		$datos = json_decode($value['datos']);
		$caracteristicas = json_decode($value['caracteristicas']);
		$datos_contacto = json_decode($value['datos_contacto']);

		$datos = (array) $datos;
		$caracteristicas = (array) $caracteristicas;
		$datos_contacto = (array) $datos_contacto;

		$nombreCompleto = $this->concatenaNombre($datos);
		$edad = $this->calculaEdad($datos['Fecha_de_Nacimiento']);

		$resultado = array_merge($datos, $caracteristicas, $datos_contacto);
		$resultado['Nombre_Completo'] = $nombreCompleto;
		$resultado['Edad'] = $edad;

		return $resultado;
	}
	public function getDenuncianteArray($id_evento)
	{
		$consulta = "SELECT p.datos, p.caracteristicas, p.datos_contacto, p.llave_renap
					FROM sipol.tbl_persona p
					WHERE p.id_persona IN (
						SELECT pd.id_persona
						FROM sipol.tbl_persona_detalle pd
						WHERE pd.id_tipo_persona IN (
							SELECT tp.id_tipo_persona
							FROM sipol_catalogos.cat_tipo_persona tp
							WHERE tp.descripcion_tipo_persona LIKE 'Denunciante'
							)
						AND pd.id_evento_detalle IN (
							SELECT ed.id_evento_detalle
							FROM sipol.tbl_evento_detalle ed
							WHERE ed.id_evento = '".$id_evento."'
							AND ed.id_hecho_denuncia IS NULL
							)
						);";

		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		 foreach ($result as $key => $value) {}

		$datos = json_decode($value['datos']);
		$caracteristicas = json_decode($value['caracteristicas']);
		$datos_contacto = json_decode($value['datos_contacto']);
		$llave_renap = $value['llave_renap'];
		

		$datos = (array) $datos;
		$caracteristicas = (array) $caracteristicas;
		$datos_contacto = (array) $datos_contacto;

		$deptoId = $this->getDeptoid($datos['Departamento_de_Nacimiento']);
		$mupioId = $this->getMupioid($datos['Municipio_de_Nacimiento'],$deptoId);

		$nombreCompleto = $this->concatenaNombre($datos);
		$edad = $this->calculaEdad($datos['Fecha_de_Nacimiento']);

		$resultado = array_merge($datos, $caracteristicas, $datos_contacto);
		$resultado['Nombre_Completo'] = $nombreCompleto;
		$resultado['Edad'] = $edad;
		$resultado['Llave_Renap'] = $llave_renap;
		$resultado['Id_Depto'] = $deptoId;
		$resultado['Id_Mupio'] = $mupioId;

		return $resultado;
	}
	public function getIdDenunciante($id_evento)
	{
		$consulta = "SELECT p.id_persona
					FROM sipol.tbl_persona p
					WHERE p.id_persona IN (
						SELECT pd.id_persona
						FROM sipol.tbl_persona_detalle pd
						WHERE pd.id_tipo_persona IN (
							SELECT tp.id_tipo_persona
							FROM sipol_catalogos.cat_tipo_persona tp
							WHERE tp.descripcion_tipo_persona LIKE 'Denunciante'
							)
						AND pd.id_evento_detalle IN (
							SELECT ed.id_evento_detalle
							FROM sipol.tbl_evento_detalle ed
							WHERE ed.id_evento = '".$id_evento."'
							AND ed.id_hecho_denuncia IS NULL
							)
						);";

		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		 foreach ($result as $key => $value) {}
		
		return $value['id_persona'];
	}
	public function getDenunciantepdf($id_evento)
	{
		$consulta = "SELECT p.datos, p.caracteristicas, p.datos_contacto
					FROM sipol.tbl_persona p
					WHERE p.id_persona IN (
						SELECT pd.id_persona
						FROM sipol.tbl_persona_detalle pd
						WHERE pd.id_tipo_persona IN (
							SELECT tp.id_tipo_persona
							FROM sipol_catalogos.cat_tipo_persona tp
							WHERE tp.descripcion_tipo_persona LIKE 'Denunciante'
							)
						AND pd.id_evento_detalle IN (
							SELECT ed.id_evento_detalle
							FROM sipol.tbl_evento_detalle ed
							WHERE ed.id_evento = '".$id_evento."'
							AND ed.id_hecho_denuncia IS NULL
							)
						);";

		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		 foreach ($result as $key => $value) {}

		$datos = json_decode($value['datos']);
		$caracteristicas = json_decode($value['caracteristicas']);
		$datos_contacto = json_decode($value['datos_contacto']);

		$datos = (array) $datos;
		$caracteristicas = (array) $caracteristicas;
		$datos_contacto = (array) $datos_contacto;

		$nombreCompleto = $this->concatenaNombre($datos);
		$edad = $this->calculaEdad($datos['Fecha_de_Nacimiento']);

		$resultado = array_merge($datos, $caracteristicas, $datos_contacto);
		$resultado['Nombre_Completo'] = $nombreCompleto;
		$resultado['Edad'] = $edad;

		return $resultado;
	}
	public function concatenaNombre($arrayDatos)
	{
		$nombreCompleto = "";

		foreach ($arrayDatos as $key => $value) 
		{
			if($key == 'Primer_Nombre')
			{
				if($value !=='')
				{
					$nombreCompleto = $value;
				}
			}
			if($key == 'Segundo_Nombre')
			{
				if($value !== '')
				{
					$nombreCompleto = $nombreCompleto." ".$value;
				}
			}
			if($key == 'Primer_Apellido')
			{
				if($value !== '')
				{
					$nombreCompleto = $nombreCompleto." ".$value;
				}
			}
			if($key == 'Segundo_Apellido')
			{
				if($value !== '')
				{
					$nombreCompleto = $nombreCompleto." ".$value;
				}
			}
		}

		return $nombreCompleto;
	}
	public function calculaEdad($fechaNacimiento)
	{
		$d = explode("-", $fechaNacimiento, 3);
		$a = $d[2]."-".$d[1]."-".$d[0];
		$dias = explode("-", $a, 3);
		$dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
		$edad = (int)((time()-$dias)/31556926 );
		return $edad;
	}
	public function getUbicacionDiv($id_evento)
	{

		$consulta = "SELECT e.direccion 
					FROM sipol.tbl_evento e
					WHERE e.id_evento = '".$id_evento."'
					";
		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		foreach ($result as $key => $value) {}

		$ubicación = json_decode($value['direccion']);
		$ubicación = (array) $ubicación;
		$devolver = "";

		foreach ($ubicación as $key => $value) 
		{
			if(!empty($value))
			{
				switch ($key) {
					case 'Departamento':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>";
						break;
					case 'Municipio':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>";
						break;
					case 'Zona':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>";
						break;
					case 'Colonia':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>";
						break;
					case 'Direccion':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>";
						break;
					case 'Referencia':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>";
						break;
				} //Fin del switch
			} //fin de condicion si no esta vacio
		} //Fin del foreach

		return $devolver;
	}
	public function getUbicacionIncidencia($id_evento)
	{

		$consulta = "SELECT e.direccion 
					FROM sipol.tbl_evento e
					WHERE e.id_evento = '".$id_evento."'
					";
		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		foreach ($result as $key => $value) {}

		$ubicacion = json_decode($value['direccion']);
		$ubicacion = (array) $ubicacion;
		$conteo = "0";
		$devolver = "<div class='row-fluid'> <div class='span6'>";

		foreach ($ubicacion as $key => $value) 
		{
			if(!empty($value))
			{
				switch ($key) {
					case 'Departamento':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>"; 
						$conteo = $conteo+1;
						break;

					case 'Municipio':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>"; 
						$conteo = $conteo+1;
						break;

					case 'Zona':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>"; 
						$conteo = $conteo+1;
						break;

					case 'Colonia':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>"; 
						$conteo = $conteo+1;
						break;

					case 'Direccion':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>"; 
						$conteo = $conteo+1;
						break;

					case 'Referencia':
						$devolver= $devolver."<div>".$key.": <b>".$value."</b></div>"; 
						$conteo = $conteo+1;
						break;
				} //Fin del Switch

				if($conteo == 3)
				{
					$devolver = $devolver."</div><div class='span6'>";
					$conteo = 100;
				}
			}//Fin de la condición para ver si el valor no está vacío
		}//Fin del foreach

		if($conteo > 99){ $devolver = $devolver."</div></div>"; }
		else { $devolver = $devolver."</div></div>"; }

		return $devolver;
	}
	public function getHechosDiv($id_evento)
	{
		#Devuelve todos los hechos en divs para impresión

		$ConstructorHechos = new ConstructorHechos;
		$Funcionesp = new Funcionesp;
		$hecho = "";
		$hechosJuntos = "";

		$sql = "SELECT ed.id_evento_detalle, 
				ed.id_hecho_denuncia, 
				ed.fecha_evento, 
				ed.hora_evento, 
				ed.atributos 
				FROM sipol.tbl_evento_detalle ed
				where ed.id_evento = '".$id_evento."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($resultado as $value) 
		{
			if(!empty($value['id_hecho_denuncia']))
			{
				$id_evento_detalle = $value['id_evento_detalle'];
				$nombreHecho = $value['id_hecho_denuncia'];
				$nombreHecho = $ConstructorHechos->nombreHecho($nombreHecho);
				$fechaHecho = $value['fecha_evento'];
				$horaHecho = $value['hora_evento'];
				$horaHecho = str_replace('{', '', $horaHecho);
				$horaHecho = str_replace('}', '', $horaHecho);
				$detalles = $value['atributos'];
				$personas = $Funcionesp->ListPJ_porEventoDet($id_evento_detalle);
				$detalles = $ConstructorHechos->explotaJsonGuion($detalles);

				$hecho =  "<div class='well well-small'>
							<b><i>".$nombreHecho."</i></b>:  
							Fecha del hecho: ".$fechaHecho.
							" - hora: ".$horaHecho.
							"<div style='padding-left:1%;'>".$detalles.$personas."</div></div>";
			
				$hechosJuntos = $hechosJuntos.$hecho;			
			}//fin del la condición
		}//fin del foreach
	
		return $hechosJuntos;
	}
	public function getHechosDivpdf($id_evento)
	{
		#Devuelve todos los hechos en divs para impresión
		$funciones = new Funcionesp;

		$ConstructorHechos = new ConstructorHechos;
		$hecho = "";
		$hechosJuntos = "";

		$sql = "SELECT ed.id_evento_detalle, 
				ed.id_hecho_denuncia, 
				ed.fecha_evento, 
				ed.hora_evento, 
				ed.atributos
				FROM sipol.tbl_evento_detalle ed
				where ed.id_evento = '".$id_evento."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($resultado as $value) 
		{
			if(!empty($value['id_hecho_denuncia']))
			{
				$id_evento_detalle = $value['id_evento_detalle'];
				$nombreHecho = $value['id_hecho_denuncia'];
				$nombreHecho = $ConstructorHechos->nombreHecho($nombreHecho);
				$fechaHecho = $value['fecha_evento'];
				$fechaHecho = $funciones->fechaATexto($fechaHecho);
				$horaHecho = $value['hora_evento'];
				$horaHecho = str_replace('{', '', $horaHecho);
				$horaHecho = str_replace('}', '', $horaHecho);
				$horaHecho =$funciones->horaALetras($horaHecho);
				$detalles = $value['atributos'];
				$detalles = $ConstructorHechos->explotaJsonGuion($detalles);
				$personas = $this->ListaPersonajuridicaPDF($id_evento_detalle);
				$hecho = $nombreHecho.":||Fecha del hecho: ".$fechaHecho.", a las: ".$horaHecho.", ".$detalles."|~|".$personas."-----";
				$hechosJuntos = $hechosJuntos.$hecho;			
			}//fin del la condición
		}//fin del foreach
	
		return $hechosJuntos;
	}
	public function ListaPersonajuridicaPDF($eventoDetalle)
	{		
		$funciones = new Funcionesp;
		$r = $funciones->ListPersonaJuridicaXed($eventoDetalle);
		$retorna = "";

		if(!empty($r))
		{
			$a = array();
			foreach ($r as $key => $value) 
			{
				$Primer_Nombre = "";
				$Segundo_Nombre = "";
				$Primer_Apellido = "";
				$Segundo_Apellido = "";
				$DPI = "";
				$id_persona_detalle = $value['id_persona_detalle'];
				$telefono = "";
				$direccion ="";

				$persona = json_decode($value['datos']);
				$persona = (array) $persona;
				$cJuridica = $value['id_tipo_persona'];
				$cJuridica = $funciones->getPersonaJuridica($cJuridica);

				$d_contacto = json_decode($value['datos_contacto']);
				$d_contacto = (array) $d_contacto;


				if(!empty($persona['Primer_Nombre'])) $Primer_Nombre = $persona['Primer_Nombre'];
				if(!empty($persona['Segundo_Nombre'])) $Segundo_Nombre = $persona['Segundo_Nombre'];
				if(!empty($persona['Primer_Apellido'])) $Primer_Apellido = $persona['Primer_Apellido'];
				if(!empty($persona['Segundo_Apellido'])) $Segundo_Apellido = $persona['Segundo_Apellido'];
				if(!empty($persona['Tipo_identificacion'])) $DatosDocumento = $persona['Tipo_identificacion'].": ".$persona['Numero_identificacion'];
				if(!empty($d_contacto['r_telefono_cnt'])) $telefono = $d_contacto['r_telefono_cnt'];
				if(!empty($d_contacto['Direccion_de_contacto'])) $direccion = $d_contacto['Direccion_de_contacto'];

				$nombreCompleto = ": ".$Primer_Nombre." ".$Segundo_Nombre." ".$Primer_Apellido." ".$Segundo_Apellido." - IDENTIFICACIÓN: ".$DatosDocumento.", - TELEFONO: ".$telefono.", - DIRECCION: ".$direccion.", ";

				//$retorna = $retorna.$cerrar;
				$retorna = $retorna.$cJuridica;
				$retorna = $retorna.$nombreCompleto;

			}

			$retorna = $retorna."~";
			$retorna = str_replace(", ~", ".", $retorna);
		}//Fin de la condición

		return $retorna;
	}

	public function ListConsignadosPdf($eventoDetalle)
	{		
		$funciones = new Funcionesp;
		$r = $funciones->ListPersonaJuridicaXed($eventoDetalle);
		$retorna = "";

		if(!empty($r))
		{
			$a = array();
			foreach ($r as $key => $value) 
			{
				$Primer_Nombre = "";
				$Segundo_Nombre = "";
				$Primer_Apellido = "";
				$Segundo_Apellido = "";
				$DPI = "";
				$id_persona_detalle = $value['id_persona_detalle'];

				$persona = json_decode($value['datos']);
				$persona = (array) $persona;
				$cJuridica = $value['id_tipo_persona'];
				$cJuridica = $funciones->getPersonaJuridica($cJuridica);

				if(!empty($persona['Primer_Nombre'])) $Primer_Nombre = $persona['Primer_Nombre'];
				if(!empty($persona['Segundo_Nombre'])) $Segundo_Nombre = $persona['Segundo_Nombre'];
				if(!empty($persona['Primer_Apellido'])) $Primer_Apellido = $persona['Primer_Apellido'];
				if(!empty($persona['Segundo_Apellido'])) $Segundo_Apellido = $persona['Segundo_Apellido'];
				if(!empty($persona['Tipo_identificacion'])) $DatosDocumento = $persona['Tipo_identificacion'].": ".$persona['Numero_identificacion'];

				$nombreCompleto = $Primer_Nombre." ".$Segundo_Nombre." ".$Primer_Apellido." ".$Segundo_Apellido.", ";

				//$retorna = $retorna.$cerrar;
				//$retorna = $retorna.$cJuridica;
				$retorna = $retorna.$nombreCompleto;

			}

			$retorna = $retorna."~";
			$retorna = str_replace(", ~", "", $retorna);
		}//Fin de la condición

		return $retorna;
	}

	public function getUbicacionDivpdf($id_evento)
	{

		$consulta = "SELECT e.direccion 
					FROM sipol.tbl_evento e
					WHERE e.id_evento = '".$id_evento."'
					";
		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		foreach ($result as $key => $value) {}

		$ubicación = json_decode($value['direccion']);
		$ubicación = (array) $ubicación;
		$devolver = "";

		foreach ($ubicación as $key => $value) 
		{
			if($key == 'Departamento')
			{
				if($value !== '')
				{ $devolver= $devolver.$key." ".$value.", "; }
			}
			if($key == 'Municipio')
			{
				if($value !== '')
				{ $devolver= $devolver.$key." ".$value.", "; }
			}
			if($key == 'Zona')
			{
				if($value !== '')
				{ $devolver= $devolver.$key." ".$value.", "; }
			}
			if($key == 'Colonia')
			{
				if($value !== '')
				{ $devolver= $devolver.$key." ".$value.", "; }
			}
			if($key == 'Direccion')
			{
				if($value !== '')
				{ $devolver= $devolver.$key." ".$value.", "; }
			}
			if($key == 'Referencia')
			{
				if($value !== '')
				{ $devolver= $devolver.$key." ".$value.", "; }
			}			
		}

		$devolver = $devolver."|";
		$devolver = str_replace(", |", "", $devolver);

		return $devolver;
	}
	public function getUbicacionArray($id_evento)
	{

		$consulta = "SELECT e.direccion 
					FROM sipol.tbl_evento e
					WHERE e.id_evento = '".$id_evento."'
					";
		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		foreach ($result as $key => $value) {}

		$ubicación = json_decode($value['direccion']);
		$ubicación = (array) $ubicación;

		$cod_depto = $this->getDeptoid($ubicación['Departamento']);
		$cod_mupio = $this->getMupioid($ubicación['Municipio'],$cod_depto);

		$ubicación['Departamento'] = $cod_depto;
		$ubicación['Municipio'] = $cod_mupio;

		return $ubicación;
	}
	public function getDeptoid($depto)
	{
		if(!empty($depto)){
			$consultaDepto = "SELECT cod_depto 
							FROM catalogos_publicos.cat_departamentos
							WHERE departamento iLIKE '".$depto."'";
			$resultQueryDepto = Yii::app()->db->createCommand($consultaDepto)->queryAll();

			if(!empty($resultQueryDepto)){
				foreach ($resultQueryDepto as $key => $al) {}
				$cod_depto = $al['cod_depto'];

				return $cod_depto;
			}
			else
			{
				
			}

			
			
		}
		
	}
	public function getMupioid($mupio,$cod_depto)
	{
		$consultaMupio = "
		SELECT cod_mupio FROM catalogos_publicos.cat_municipios WHERE SP_ASCII(municipio) ILIKE SP_ASCII('%".$mupio."%') AND cod_depto = ".$cod_depto.";";
		$resultQueryMupio = Yii::app()->db->createCommand($consultaMupio)->queryAll();
	
				foreach ($resultQueryMupio as $key => $value) {}
				$cod_mupio = $value['cod_mupio'];
				return $cod_mupio;
		
	
	}
	public function getExtraviosDiv($id_evento)
	{
		#Devuelve todos los hechos en divs para impresión

		$ConstructorHechos = new ConstructorHechos;
		$hecho = "";
		$hechosJuntos = "";

		$sql = "SELECT ed.id_evento_detalle, 
				ed.id_hecho_denuncia, 
				ed.fecha_evento, 
				ed.hora_evento, 
				ed.atributos 
				FROM sipol.tbl_evento_detalle ed
				where ed.id_evento = '".$id_evento."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($resultado as $value) 
		{
			if(!empty($value['id_hecho_denuncia']))
			{
				$id_evento_detalle = $value['id_evento_detalle'];
				$nombreHecho = $value['id_hecho_denuncia'];
				$nombreHecho = $ConstructorHechos->nombreHechoExt($nombreHecho);
				$fechaHecho = $value['fecha_evento'];
				$horaHecho = $value['hora_evento'];
				$horaHecho = str_replace('{', '', $horaHecho);
				$horaHecho = str_replace('}', '', $horaHecho);
				$detalles = $value['atributos'];
				$detalles = $ConstructorHechos->explotaJsonGuion($detalles);

				$hecho =  "<div class='well well-small'>
							<b><i>".$nombreHecho."</i></b>:  
							Fecha del hecho: ".$fechaHecho.
							" - hora: ".$horaHecho.
							"<div style='padding-left:1%;'>".$detalles."</div></div>";
			
				$hechosJuntos = $hechosJuntos.$hecho;			
			}//fin del la condición
		}//fin del foreach
	
		return $hechosJuntos;
	}
	public function getExtraviosPdf($id_evento)
	{
		#Devuelve todos los hechos en divs para impresión
		$funciones = new Funcionesp;
		$ConstructorHechos = new ConstructorHechos;
		$hecho = "";
		$hechosJuntos = "";

		$sql = "SELECT ed.id_evento_detalle, 
				ed.id_hecho_denuncia, 
				ed.fecha_evento, 
				ed.hora_evento, 
				ed.atributos 
				FROM sipol.tbl_evento_detalle ed
				where ed.id_evento = '".$id_evento."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($resultado as $value) 
		{
			if(!empty($value['id_hecho_denuncia']))
			{
				$id_evento_detalle = $value['id_evento_detalle'];
				$nombreHecho = $value['id_hecho_denuncia'];
				$nombreHecho = $ConstructorHechos->nombreHechoExt($nombreHecho);
				$fechaHecho = $value['fecha_evento'];
				$fechaHecho = $funciones->fechaATexto($fechaHecho);
				$horaHecho = $value['hora_evento'];
				$horaHecho = str_replace('{', '', $horaHecho);
				$horaHecho = str_replace('}', '', $horaHecho);
				$horaHecho = $funciones->horaALetras($horaHecho);
				$detalles = $value['atributos'];
				$detalles = $ConstructorHechos->explotaJsonGuion($detalles);

				$hecho =  $nombreHecho."|°| El día: ".$fechaHecho." a las: ".$horaHecho.". ".$detalles."||~||";
			
				$hechosJuntos = $hechosJuntos.$hecho;			
			}//fin del la condición
		}//fin del foreach
	
		return $hechosJuntos;
	}
	public function getRelato($id_evento)
	{
		$sql = "SELECT e.relato_denuncia
				FROM sipol.tbl_evento e
				where e.id_evento = '".$id_evento."';";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($resultado as $key => $value) 
		{
			#foreach ($value as $clave => $valor) {}
		}

		//htmlspecialchars_decode
		$relato = json_decode($value['relato_denuncia']);
		//$relato = htmlspecialchars_decode($relato);
		$relato = (array) $relato;
		//$relato = $relato['Relato'];

		return $relato;
	}
	public function getObjetosDiv($objetos)
	{
		$retorna = "<ul>";
		foreach ($objetos as $key => $value) {}
		$value = (array) $value;

		foreach ($value as $llave => $valor) {
			$retorna = $retorna."<li>".$llave.": ".$valor."</li>";
		}
		return $retorna."</ul>";
	}
	public function getObjetos($objetos)
	{
		foreach ($objetos as $key => $value) {}
		$value = (array) $value;

		return $value;
	}
	public function traeRelato($id_evento)
	{
		$sql = "SELECT e.relato
				FROM sipol.tbl_evento e
				where e.id_evento = '".$id_evento."';";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($resultado as $key => $value) 
		{
			#foreach ($value as $clave => $valor) {}
				$relato = $value['relato'];
		}

	

		return $relato;
	}
	public function getRelatopdf($id_evento)
	{
		$sql = "SELECT e.relato_denuncia
				FROM sipol.tbl_evento e
				where e.id_evento = '".$id_evento."';";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($resultado as $key => $value) 
		{
			#foreach ($value as $clave => $valor) {}
		}

		//htmlspecialchars_decode
		$relato = json_decode($value['relato_denuncia']);
		//$relato = htmlspecialchars_decode($relato);
		$relato = (array) $relato;
		//$relato = $relato['Relato'];

		return $relato;
	}	
		public function getRelatoExt($id_evento)
	{
		$sql = "SELECT e.relato_denuncia
				FROM sipol.tbl_evento e
				where e.id_evento_extiende = '".$id_evento."';";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($resultado as $key => $value) 
		{
			#foreach ($value as $clave => $valor) {}
		}

		//htmlspecialchars_decode
		$relato = json_decode($value['relato_denuncia']);
		//$relato = htmlspecialchars_decode($relato);
		$relato = (array) $relato;
		//$relato = $relato['Relato'];

		return $relato;
	}
	public function getObjetosDivpdf($objetos)
	{
		$retorna = "<ul>";
		foreach ($objetos as $key => $value) {}
		$value = (array) $value;

		foreach ($value as $llave => $valor) {
			$retorna = $retorna."<li>".$llave.": ".$valor."</li>";
		}
		return $retorna."</ul>";
	}
	public function getTipoIncidencia($idEvento)
	{
		$sql = "SELECT atributos 
			FROM sipol.tbl_evento_detalle 
			WHERE id_evento = ".$idEvento."
			AND id_hecho_denuncia IS NULL;";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($resultado as $key => $value) {}
		$devuelve = json_decode($value['atributos']);
		$devuelve = (array) $devuelve;

		return $devuelve;
	}
	public function getImplicadosTable($implicados)
	{
			$retorna = "<table class='table table-bordered table-striped'>
					<thead>
						<tr>
							<th>#</th>
							<th>Tipo</th>
							<th>Entidad</th>
							<th>Descripción</th>
						</tr>
					</thead>
					<tbody>";
			$conta = 1;

			foreach ($implicados as $key => $value) {
			}
			$v = (array) $value;

			foreach ($v as $key => $value) {

				$s = (array) $value;

				$retorna = $retorna."<tr><td>".$conta."</td>";
				$retorna = $retorna."<td>".$s['Tipo']."</td>";
				$retorna = $retorna."<td>".$s['Entidad']."</td>";
				$retorna = $retorna."<td>".$s['Descripcion']."</td></tr>";
				$conta = $conta+1;
			}

			$retorna = $retorna."</tbody>
						</table>
						";

			return $retorna;
	}
	public function getAgentes($idEvento)
	{
		$r = "";
		$devuelve = "";

		$idEdConsulta = "SELECT id_evento_detalle 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

		foreach ($result as $key => $value) {
			foreach ($value as $llave => $valor) {}
		}
		$idEventoDetalle = $valor;

		$sql = "SELECT id_patrulla, patrulla
				FROM sipol.tbl_patrullas
				WHERE id_evento_detalle = ".$idEventoDetalle.";";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		$sql2 = "SELECT id_agente, agente
				FROM sipol.tbl_agente
				WHERE id_evento_detalle = ".$idEventoDetalle.";";

		$resultado2 = Yii::app()->db->createCommand($sql2)->queryAll();

		$primer_nombre = "";
		$segundo_nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";

		$rota = '1';

		foreach ($resultado2 as $v) 
		{
			$id_agente = $v['id_agente'];
			$y = json_decode($v['agente']);
			$y = (array) $y;
		
			if(!empty($y['Primer_Nombre'])) $primer_nombre = $y['Primer_Nombre'];
			if(!empty($y['Segundo_Nombre'])) $segundo_nombre = $y['Segundo_Nombre'];
			if(!empty($y['Primer_Apellido'])) $primer_apellido = $y['Primer_Apellido'];
			if(!empty($y['Segundo_Apellido'])) $segundo_apellido = $y['Segundo_Apellido'];
			$e = " ";

			if($rota !== '1') $devuelve = $devuelve."<legend style='margin-bottom: 10px;'></legend>";
			$devuelve = $devuelve."<div style='margin-bottom:10px;'>";
			$devuelve = $devuelve."<b>AGENTE</b> - ";
			$devuelve = $devuelve."NIP: <b>".$y['Nip']."</b> - Nombre Completo: <b>".$primer_nombre.$e.$segundo_nombre.$e.$primer_apellido.$e.$segundo_apellido."</b>";
			$devuelve = $devuelve."</div>";
			$rota = '2';
		$primer_nombre = "";
		$segundo_nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";

		}

		if(!empty($resultado))
		{

			foreach ($resultado as $value) 
			{
				if($rota !== '1') $devuelve = $devuelve."<legend style='margin-top: 10px;margin-bottom: 10px;'></legend>";
				$id_patrulla = $value['id_patrulla'];
				$r = json_decode($value['patrulla']);
				$r = (array) $r;
				$devuelve = $devuelve."<div style='margin-bottom:10px;'>";
				$devuelve = $devuelve."<b>PATRULLA</b> - ";
				$devuelve = $devuelve."Nombre de Patrulla: <b>".$r['Nombre_de_la_Patrulla'].
				"</b> - Tipo: <b>".$r['Tipo']."</b> - Color: <b>".$r['Color']."</b> - Marca: <b>".$r['Marca']."</b>";
				$devuelve = $devuelve."</div>";
			}
		}


	
		return $devuelve;
	}
	public function getAgentesPdf($idEvento)
	{
		$r = "";
		$devuelve = "";
		$conteo = 0;
		$funciones = new Funcionesp;

		$idEdConsulta = "SELECT id_evento_detalle 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

		foreach ($result as $key => $value) {
			foreach ($value as $llave => $valor) {}
		}
		$idEventoDetalle = $valor;

		$sql2 = "SELECT id_agente, agente
				FROM sipol.tbl_agente
				WHERE id_evento_detalle = ".$idEventoDetalle.";";

		$resultado2 = Yii::app()->db->createCommand($sql2)->queryAll();

		$primer_nombre = "";
		$segundo_nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";

		foreach ($resultado2 as $v) 
		{
			$id_agente = $v['id_agente'];
			$y = json_decode($v['agente']);
			$y = (array) $y;
		
			if(!empty($y['Primer_Nombre'])) $primer_nombre = $y['Primer_Nombre'];
			if(!empty($y['Segundo_Nombre'])) $segundo_nombre = $y['Segundo_Nombre'];
			if(!empty($y['Primer_Apellido'])) $primer_apellido = $y['Primer_Apellido'];
			if(!empty($y['Segundo_Apellido'])) $segundo_apellido = $y['Segundo_Apellido'];
			$e = " ";
			$conteo = $conteo+1;

			$devuelve = $devuelve.$primer_nombre.$e.$segundo_nombre.$e.$primer_apellido.$e.$segundo_apellido." CON NIP: ".$y['Nip']."(".$funciones->numtoletras($y['Nip'])."), ";

		$primer_nombre = "";
		$segundo_nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";
		}

		$devuelve = $devuelve."|";
		$devuelve = str_replace(", |", "", $devuelve);
	
		return $devuelve."~".$conteo;
	}
	public function getAgentesList($idEvento)
	{
		$r = "";
		$devuelve = "";
		$devuelve = CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Agente'),true);
		$conteo = 0;
		$funciones = new Funcionesp;

		$idEdConsulta = "SELECT id_evento_detalle 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

		foreach ($result as $key => $value) {
			foreach ($value as $llave => $valor) {}
		}
		$idEventoDetalle = $valor;

		$sql2 = "SELECT id_agente, agente
				FROM sipol.tbl_agente
				WHERE id_evento_detalle = ".$idEventoDetalle.";";

		$resultado2 = Yii::app()->db->createCommand($sql2)->queryAll();

		$primer_nombre = "";
		$segundo_nombre = "";
		$primer_apellido = "";
		$segundo_apellido = "";

		foreach ($resultado2 as $v) 
		{
			$id_agente = $v['id_agente'];
			$y = json_decode($v['agente']);
			$y = (array) $y;
		
			if(!empty($y['Primer_Nombre'])) $primer_nombre = $y['Primer_Nombre'];
			if(!empty($y['Segundo_Nombre'])) $segundo_nombre = $y['Segundo_Nombre'];
			if(!empty($y['Primer_Apellido'])) $primer_apellido = $y['Primer_Apellido'];
			if(!empty($y['Segundo_Apellido'])) $segundo_apellido = $y['Segundo_Apellido'];
			$e = " ";
			$conteo = $conteo+1;

			$a = $primer_nombre.$e.$segundo_nombre.$e.$primer_apellido.$e.$segundo_apellido." - NIP: ".$y['Nip'];
			$devuelve = $devuelve.CHtml::tag('option', array('value'=>$id_agente),CHtml::encode($a),true);

		}
	
		return $devuelve;
	}
	public function getPatrullasPdf($idEvento)
	{
		$r = "";
		$devuelve = "";
		$conteo = 0;

		$idEdConsulta = "SELECT id_evento_detalle 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();

		foreach ($result as $key => $value) {
			foreach ($value as $llave => $valor) {}
		}
		$idEventoDetalle = $valor;

		$sql = "SELECT id_patrulla, patrulla
				FROM sipol.tbl_patrullas
				WHERE id_evento_detalle = ".$idEventoDetalle.";";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		if(empty($resultado))
		{
			$devuelve = "empty";
		}
		else
		{
			$p = " INDENTIFICADA CON EL NOMBRE: ";

			foreach ($resultado as $value) 
			{
				$id_patrulla = $value['id_patrulla'];
				$r = json_decode($value['patrulla']);
				$r = (array) $r;
				$devuelve = $devuelve.$r['Nombre_de_la_Patrulla'].", ";
				$conteo = $conteo +1;
			}
			if($conteo >1) $p = "IDENTIFICADAS CON LOS NOMBRES: ";

			$devuelve = $p.$devuelve;

			$devuelve = $devuelve."|";
			$devuelve = str_replace(", |", "", $devuelve);
		}

		return $devuelve."~".$conteo;
	}
	public function getConsignados($valor)
	{

		$ConstructorHechos = new ConstructorHechos;
		
			$sql = "SELECT ed.id_evento_detalle, ed.id_hecho_denuncia, ed.fecha_evento, ed.hora_evento, ed.atributos, 
						ed.id_motivo_consignados, ed.motivo, ed.id_lugar_remision, ed.atributos_lugar_remision
				FROM sipol.tbl_evento_detalle ed
				where id_evento = '".$valor."';";
			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			$devuelve = "";
			$rota = '1';
			
			foreach ($resultado as $value) 
			{
				if(!empty($value['id_hecho_denuncia']))
				{
					$id_evento_detalle = $value['id_evento_detalle'];
					$idHecho = $value['id_hecho_denuncia'];
					$nombreHecho = $ConstructorHechos->nombreHechoCon($idHecho);
					$nombreMotivo = $value['id_motivo_consignados'];
					$nombreMotivo = $ConstructorHechos->nombreHechoMo($nombreMotivo);
					$motivo = $value['motivo'];
					$motivo = $ConstructorHechos->explotaJsonGuion($motivo);
					$nombreLugar = $value['id_lugar_remision'];
					$nombreLugar = $ConstructorHechos->nombreHechoLu($nombreLugar);
					$lugar = $value['atributos_lugar_remision'];
					$lugar = $ConstructorHechos->explotaJsonGuion($lugar);
					$fechaHecho = $value['fecha_evento'];
					$horaHecho = $value['hora_evento'];
					
					if($idHecho == 1)
					{
						$detalles = $this->ListaPersonajuridicaPDF($id_evento_detalle);
						$detalles = " ".$detalles;
					}
					else
					{
						$detalles = $value['atributos'];
						$detalles = $ConstructorHechos->explotaJsonGuion($detalles);
					}

					//echo $id_evento_detalle;

					if($rota !== '1') $devuelve = $devuelve."<legend style='margin-bottom: 10px;'></legend>";
					$devuelve = $devuelve."<h5 style='line-height:10px;'>".$nombreHecho."</h5>";
					$devuelve = $devuelve."<div style='margin-bottom:10px;'>";
					$devuelve = $devuelve."Fecha de la Consignación: ".$fechaHecho;
					$devuelve = $devuelve." - hora: ".$horaHecho;
					$devuelve = $devuelve."<br>";
					$devuelve = $devuelve.$detalles;
					$devuelve = $devuelve."<br> Motivo de la Consignación: <b>".$nombreMotivo."</b> - ";
					$devuelve = $devuelve.$motivo;
					$devuelve = $devuelve."<br> Lugar a donde se traslada: <b>".$nombreLugar."</b> - ";
					$devuelve = $devuelve.$lugar;
					$devuelve = $devuelve."</div>";
					$rota = '2';

				}//fin del la condición
			}//fin del foreach

			return $devuelve;
	}
	public function getImplicadosPdf($implicados)
	{
		$retorna ="";
		foreach ($implicados as $key => $value) {
		}
		$v = (array) $value;

		foreach ($v as $key => $value) {

			$s = (array) $value;
			switch ($s['Tipo']) {
				case 'Vehiculo':
						$d = "El Vehículo ";
					break;
				case 'Persona':
						$d = "La Persona ";
					break;
				case 'Otro':
						$d = "";
					break;
				default:
						$d = "";
					break;

			}
			

			$retorna = $retorna."- En Representación de ".$s['Entidad'].", "
						.$d."con las características: ".$s['Descripcion'].".<br>";
		}

		return $retorna;
	}
	public function getConsignadosPdf($valor)
	{
		$devuelve = "";
		//$valor = 1236;
		$ConstructorHechos = new ConstructorHechos;
		$funciones = new Funcionesp;
		
			$sql = "SELECT ed.id_evento_detalle, ed.id_hecho_denuncia, ed.fecha_evento, ed.hora_evento, ed.atributos, 
						ed.id_motivo_consignados, ed.motivo, ed.id_motivo_consignados, ed.atributos_lugar_remision
				FROM sipol.tbl_evento_detalle ed
				where id_evento = '".$valor."';";
			$resultado = Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach ($resultado as $value) 
			{
				if(!empty($value['id_hecho_denuncia']))
				{
					$id_evento_detalle = $value['id_evento_detalle'];
					$idHecho = $value['id_hecho_denuncia'];
					$nombreHecho = $ConstructorHechos->nombreHechoCon($idHecho);
					$nombreMotivo = $value['id_motivo_consignados'];
					$nombreMotivo = $ConstructorHechos->nombreHechoMo($nombreMotivo);
					$motivo = $value['motivo'];
					$motivo = $ConstructorHechos->explotaJsonGuion($motivo);
					$nombreLugar = $value['id_motivo_consignados'];
					$nombreLugar = $ConstructorHechos->nombreHechoLu($nombreLugar);
					$lugar = $value['atributos_lugar_remision'];
					$lugar = $ConstructorHechos->explotaJsonGuion($lugar);
					$fechaHecho = $value['fecha_evento'];
					$horaHecho = $value['hora_evento'];
					$horaHecho = str_replace("{", "", $horaHecho);
					$horaHecho = str_replace("}", "", $horaHecho);

					if($idHecho == 1)
					{
						$detalles = $this->ListaPersonajuridicaPDF($id_evento_detalle);
						$detalles = ", ".$detalles;
					}
					else
					{
						$detalles = $value['atributos'];
						$detalles = $ConstructorHechos->explotaJsonGuion($detalles);
						$detalles = ", (Detalles: ".$detalles.").";
					}
					//echo $id_evento_detalle;
					$devuelve = $devuelve."- <b>".$nombreHecho.":</b>";
					$devuelve = $devuelve." Fecha de Consignación: ".$fechaHecho." (En letras: ".$funciones->fechaATexto($fechaHecho, 'u').")";

					$devuelve = $devuelve.", hora: ".$horaHecho." (En letras: ".$funciones->horaALetras($horaHecho).")";
					$devuelve = $devuelve.$detalles;
					$devuelve = $devuelve." Se CONSIGNÓ por el motivo siguiente: <b>".$nombreMotivo."</b> ";
					$devuelve = $devuelve."(".$motivo.")";
					$devuelve = $devuelve."; Se traslada a: <b>".$nombreLugar."</b>, ";
					$devuelve = $devuelve."(".$lugar.")<br><br>";
				}//fin del la condición
			}//fin del foreach

			return $devuelve;
	}
	public function getDenuncianteId($id_evento)
	{
		$consulta ="SELECT p.id_persona
			FROM sipol.tbl_persona p
			WHERE p.id_persona IN (
			SELECT pd.id_persona
			FROM sipol.tbl_persona_detalle pd
			WHERE pd.id_tipo_persona IN (
			SELECT tp.id_tipo_persona
			FROM sipol_catalogos.cat_tipo_persona tp
			WHERE tp.descripcion_tipo_persona LIKE 'Denunciante'
			)
			AND pd.id_evento_detalle IN (
			SELECT ed.id_evento_detalle
			FROM sipol.tbl_evento_detalle ed
			WHERE ed.id_evento = '".$id_evento."'
			AND ed.id_hecho_denuncia IS NULL))";

		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		foreach ($result as $key => $value) {}

		return $value;
	}

	public function getHechosDenunciante($idEvento)
	{
		$idDenunciante = $this->getDenuncianteId($idEvento);

		$sql = "SELECT pd.id_evento_detalle,
				pd.id_persona_detalle,
				p.id_persona,
				/*p.datos,*/
				chd.nombre_hecho,
				ctp.descripcion_tipo_persona as tipo_persona
			FROM sipol.tbl_persona_detalle pd, 
				sipol.tbl_evento_detalle ed, 
				sipol_catalogos.cat_tipo_persona ctp,
				sipol_catalogos.cat_hecho_denuncia chd,
				sipol.tbl_persona p
			WHERE pd.id_evento_detalle IN(
				SELECT id_evento_detalle
				FROM sipol.tbl_evento_detalle
				WHERE id_evento = ".$idEvento." 
				AND id_hecho_denuncia IS NOT NULL
			)
			AND pd.id_persona = ".$idDenunciante['id_persona']." 
			AND pd.id_evento_detalle = ed.id_evento_detalle
			AND pd.id_tipo_persona = ctp.id_tipo_persona
			AND ed.id_hecho_denuncia = chd.id_hecho_denuncia
			AND pd.id_persona = p.id_persona";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		return $resultado;
	}

	public function getDenuncianteIpd($idEvento)
	{
		$sql = "SELECT pd.id_persona_detalle 
				FROM sipol.tbl_persona_detalle pd
				WHERE pd.id_evento_detalle = (
				SELECT ed.id_evento_detalle
					FROM sipol.tbl_evento_detalle ed
					WHERE ed.id_evento = ".$idEvento." 
					AND ed.id_hecho_denuncia IS NULL)";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		
		return $resultado[0];
	}

	public function getLostChild($id_evento)
	{
		$funciones = new Funcionesp;

		$ConstructorHechos = new ConstructorHechos;
		$hecho = "";
		$hechosJuntos = "";
		$retorno = array();

		$sql = "SELECT ed.id_evento_detalle, 
				ed.id_hecho_denuncia, 
				ed.fecha_evento, 
				ed.hora_evento, 
				ed.atributos 
				FROM sipol.tbl_evento_detalle ed
				WHERE ed.id_evento = '".$id_evento."'
				AND ed.id_hecho_denuncia = '36';";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($resultado as $value) 
		{
			if(!empty($value['id_hecho_denuncia']))
			{
				$id_evento_detalle = $value['id_evento_detalle'];
				$nombreHecho = $value['id_hecho_denuncia'];
				$nombreHecho = $ConstructorHechos->nombreHecho($nombreHecho);
				$fechaHecho = $value['fecha_evento'];
				$horaHecho = $value['hora_evento'];
				$horaHecho = str_replace('{', '', $horaHecho);
				$horaHecho = str_replace('}', '', $horaHecho);
				$data = json_decode($value['atributos']);
				$data = (array) $data;

				$dataChild = $this->getPersona($id_evento_detalle,"Niño Desaparecido");
				$dataChild['Parentesco_Denunciante'] = $data['Parentesco con el Denunciante'];
				$dataChild['Etnia'] = $data['Etnia'];
				$dataChild['Vestimenta'] = $data['Vestimenta'];

				$dataAgresor = $this->getPersona($id_evento_detalle,"Agresor");
				$dataAgresor['Parentesco_Agresor'] = $data['Parentesco con el Agresor'];
				$dataAgresor['observaciones'] = $data['Observaciones'];

				$retorno['fecha'] = $fechaHecho;
				$retorno['hora'] = $horaHecho;
				$retorno['nino_desaparecido'] = $dataChild;
				$retorno['agresor'] = $dataAgresor;

			}//fin del la condición
		}//fin del foreach
	
		return json_encode($retorno);
	}

	public function getPersona($idEventoDetalle,$cJuridica)
	{
		#Recibe el evento detalle y el nombre de la calidad Juridica para devolver los datos de la persona

		$consulta = "SELECT p.datos, p.caracteristicas, p.datos_contacto
					FROM sipol.tbl_persona p
					WHERE p.id_persona IN (
						SELECT pd.id_persona
						FROM sipol.tbl_persona_detalle pd
						WHERE pd.id_tipo_persona IN (
							SELECT tp.id_tipo_persona
							FROM sipol_catalogos.cat_tipo_persona tp
							WHERE tp.descripcion_tipo_persona LIKE '".$cJuridica."'
							)
						AND pd.id_evento_detalle = '".$idEventoDetalle."'
					);";

		$result = Yii::app()->db->createCommand($consulta)->queryAll();

		 foreach ($result as $key => $value) {}

		$datos = json_decode($value['datos']);
		$caracteristicas = json_decode($value['caracteristicas']);
		$datos_contacto = json_decode($value['datos_contacto']);

		$datos = (array) $datos;
		$caracteristicas = (array) $caracteristicas;
		$datos_contacto = (array) $datos_contacto;

		$deptoId = $this->getDeptoid($datos['Departamento_de_Nacimiento']);
		$mupioId = $this->getMupioid($datos['Municipio_de_Nacimiento'],$deptoId);

		$nombreCompleto = $this->concatenaNombre($datos);
		$edad = $this->calculaEdad($datos['Fecha_de_Nacimiento']);

		$resultado = array_merge($datos, $caracteristicas, $datos_contacto);
		$resultado['Nombre_Completo'] = $nombreCompleto;
		$resultado['Edad'] = $edad;
		$resultado['Id_Depto'] = $deptoId;
		$resultado['Id_Mupio'] = $mupioId;

		return $resultado;
	}

	public function getHechoId($idEventoDetalle)
	{
		$sql = "SELECT id_hecho_denuncia
				FROM sipol.tbl_evento_detalle
				WHERE id_evento_detalle = ".$idEventoDetalle;

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($resultado as $key => $value) {
		}

		return $value['id_hecho_denuncia'];
	}

	public function getAtributrosHecho($idEventoDetalle)
	{
		$devuelve = array();
		$sql = "SELECT atributos, fecha_evento, hora_evento
		FROM sipol.tbl_evento_detalle
		WHERE id_evento_detalle = ".$idEventoDetalle;

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		$objeto = (object) $resultado[0];

		$f = explode('-', $objeto->fecha_evento); 
		$fecha = $f[2]."/".$f[1]."/".$f[0];

		$h = str_replace('{', '', $objeto->hora_evento);
		$h = str_replace('}', '', $h);
		$h = explode(':', $h); 
		$hora = $h[0].':'.$h[1];

		$devuelve['fecha_evento'] = $fecha;
		$devuelve['hora_evento'] = $hora;

		$atributos = json_decode($objeto->atributos);
		$atributos = (array) $atributos;

		foreach ($atributos as $key => $value) {
			$devuelve[$key] = $value;
		}

		return $devuelve;
	}

	public function getPersonasDetalles($idEventoDetalle)
	{
		$sql = "SELECT id_persona_detalle
				FROM sipol.tbl_persona_detalle 
				WHERE id_evento_detalle = ".$idEventoDetalle;

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		$d = "empty";

		if(!empty($resultado)){
			$d = "";
			foreach ($resultado as $key => $value) {
				$value = (object) $value;
				$d = $d.$value->id_persona_detalle.",";
			}

			$d = $d."-";
			$d = str_replace(",-", "", $d);
		}

		return $d;

		#return $resultado;
	}

	public function getGeneralesincidencia($idEvento)
	{
		$idEdConsulta = "SELECT id_evento_detalle, atributos 
					FROM sipol.tbl_evento_detalle
					WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($idEdConsulta)->queryAll();
		$result = (object) $result[0];
		
		//$idEventoDetalle = $result->id_evento_detalle;
		$atributos = json_decode($result->atributos);
		//var_dump($atributos);
		
		return $atributos;
	}

	public function getPersonasIncidencia($idEvento)
	{
		$consulta = "SELECT id_evento_detalle, atributos 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($consulta)->queryAll();
		$result = (object) $result[0];
		$idEventoDetalle = $result->id_evento_detalle;

		$Funcionesp = new Funcionesp;
		$personas = $Funcionesp->ListPJ_porEventoDet($idEventoDetalle);

		$r = $Funcionesp->ListPersonaJuridicaXed($idEventoDetalle);
		$retorna = "";
		$ctr = "1";

		if(!empty($r))
		{		
			$a = array();
			foreach ($r as $key => $value) 
			{
				if($ctr !== "1") $retorna = $retorna."<legend style='margin-bottom: 10px;'></legend>";
				$retorna = $retorna."<div style='margin-bottom: 10px;'>";
				$Primer_Nombre = "";
				$Segundo_Nombre = "";
				$Primer_Apellido = "";
				$Segundo_Apellido = "";
				$DatosDocumento = "";
				$id_persona_detalle = $value['id_persona_detalle'];

				$persona = json_decode($value['datos']);
				$persona = (array) $persona;
				$cJuridica = $Funcionesp->getPersonaJuridica($value['id_tipo_persona']);
				$estadoFisico = $Funcionesp->getEstadoPersona($value['id_estado_persona']);

				if(!empty($persona['Primer_Nombre'])) $Primer_Nombre = $persona['Primer_Nombre'];
				if(!empty($persona['Segundo_Nombre'])) $Segundo_Nombre = $persona['Segundo_Nombre'];
				if(!empty($persona['Primer_Apellido'])) $Primer_Apellido = $persona['Primer_Apellido'];
				if(!empty($persona['Segundo_Apellido'])) $Segundo_Apellido = $persona['Segundo_Apellido'];
				if(!empty($persona['Tipo_identificacion'])) $DatosDocumento = $persona['Tipo_identificacion'].": ".$persona['Numero_identificacion'];

				$nombreCompleto = ": ".$Primer_Nombre." ".$Segundo_Nombre." ".$Primer_Apellido." ".$Segundo_Apellido." - Identificación: ".$DatosDocumento;

				$retorna = $retorna."<b>".$cJuridica."</b> - Estado Físico: <b>".$estadoFisico."</b>";
				$retorna = $retorna.$nombreCompleto;
				$retorna = $retorna."</div>";
				$ctr = '2';
			}
		}//Fin de la condición

		return $retorna;
	}

	public function getObjetosIncidencia($idEvento)
	{
		$consulta = "SELECT id_evento_detalle, atributos 
						FROM sipol.tbl_evento_detalle
						WHERE id_evento = ".$idEvento." AND id_hecho_denuncia IS NULL";
		$result = Yii::app()->db->createCommand($consulta)->queryAll();
		$result = (object) $result[0];
		$idEventoDetalle = $result->id_evento_detalle;

		$cn = "SELECT o.id_tipo_objeto, oi.nombre_objeto, o.atributos, o.id_calificacion_objeto, co.calificacion_objeto 
				FROM sipol.tbl_objetos o
				LEFT JOIN sipol_catalogos.cat_objeto_incidencia oi ON o.id_tipo_objeto = id_objeto_incidencia
				LEFT JOIN sipol_catalogos.cat_calificacion_objeto co ON co.id_calificacion_objeto = o.id_calificacion_objeto
				WHERE id_evento_detalle = ".$idEventoDetalle.";";
		$res = Yii::app()->db->createCommand($cn)->queryAll();
		$retorna = "";
		$ctr = "1";

		foreach ($res as $k => $v) 
		{
			$v = (object) $v;

			$jsonIterator = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($v->atributos, TRUE)),
			RecursiveIteratorIterator::SELF_FIRST);
			foreach ($jsonIterator as $key => $val) 
			{
				$objeto_atrr= " $key: $val- ";
			}	
			if($ctr !== "1") $retorna = $retorna."<legend style='margin-bottom: 10px;'></legend>";
			$retorna = $retorna."<div style='margin-bottom: 10px;'>";
			$retorna = $retorna.'Tipo de Objeto: <b>'.$v->nombre_objeto."</b> - Calificación de Objeto: <b>".$v->calificacion_objeto."</b>";
			$retorna = $retorna."</div>";
			$ctr = '2';
			
		}

		return $retorna;
	}

	public function getConsignadosDos($idEvento)
	{
		$ConstructorHechos = new ConstructorHechos;
		$funciones = new Funcionesp;
	
		$sql = "SELECT ed.id_evento_detalle, ed.id_hecho_denuncia, ed.fecha_evento, ed.hora_evento, ed.atributos, 
					ed.id_motivo_consignados, ed.motivo, ed.id_motivo_consignados, ed.id_lugar_remision, 
					ed.atributos_lugar_remision
			FROM sipol.tbl_evento_detalle ed
			where id_evento = '".$idEvento."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		$arreglo = array();
		$gral = array();
		$cont = 0;
		
		foreach ($resultado as $value) 
		{
			if(!empty($value['id_hecho_denuncia']))
			{
				if($value['id_hecho_denuncia'] == 1){
					$arreglo['tipo'] = $nombreHecho = $ConstructorHechos->nombreHechoCon($value['id_hecho_denuncia']);
					$arreglo['fecha'] = $value['fecha_evento'];
					$arreglo['fecha_letras'] = $funciones->fechaATexto($value['fecha_evento']);
					$arreglo['hora'] = $value['hora_evento'];
					$arreglo['hora_letras'] = $funciones->horaALetras($value['hora_evento']);
					$arreglo['persona'] = $this->ListConsignadosPdf($value['id_evento_detalle']);

					if($value['id_lugar_remision']==1){
						$lugar = $value['atributos_lugar_remision'];
						$lugar = json_decode($lugar);
						$arreglo['depto_juzgado'] = $lugar->Departamento;
						$arreglo['mupio_juzgado'] = $lugar->Municipio;
						$arreglo['nombre_juzgado'] = $lugar->Juzgado;

					}

					$gral[$cont] = $arreglo;
					$cont = $cont+1;
				}
			}//fin del la condición
		}//fin del foreach

		return $gral;
	}
}
?>