<?php

class CorrigeJson

{
	public function denunciante($palabra)
	{
		switch ($palabra) 
		{
			case 'r_primer_nombre':
				$palabra = "Primer_Nombre";
				break;

			case 'pj_r_primer_nombre':
				$palabra = "Primer_Nombre";
				break;

			case 'r_segundo_nombre':
				$palabra = "Segundo_Nombre";
				break;

			case 'pj_r_segundo_nombre':
				$palabra = "Segundo_Nombre";
				break;

			case 'r_primer_apellido':
				$palabra = "Primer_Apellido";
				break;

			case 'pj_r_primer_apellido':
				$palabra = "Primer_Apellido";
				break;

			case 'r_segundo_apellido':
				$palabra = "Segundo_Apellido";
				break;

			case 'pj_r_segundo_apellido':
				$palabra = "Segundo_Apellido";
				break;

			case 'r_genero':
				$palabra = "Genero";
				break;

			case 'pj_r_genero':
				$palabra = "Genero";
				break;

			case 'r_dpi':
				$palabra = "Numero_identificacion";
				break;

			case 'r_nacimiento':
				$palabra = "Fecha_de_Nacimiento";
				break;

			case 'pj_r_nacimiento':
				$palabra = "Fecha_de_Nacimiento";
				break;

			case 'r_pais_nacimiento':
				$palabra = "Pais_de_Nacimiento";
				break;

			case 'r_departamento':
				$palabra = "Departamento_de_Nacimiento";
				break;

			case 'r_municipio':
				$palabra = "Municipio_de_Nacimiento";
				break;

			case 'r_nacionalidad':
				$palabra = "Nacionalidad";
				break;

			case 'r_ecivil':
				$palabra = "Estado_Civil";
				break;

			case 'r_npadre':
				$palabra = "Nombre_del_Padre";
				break;

			case 'r_nmadre':
				$palabra = "Nombre_de_la_Madre";
				break;

			case 'r_cabeza_cf':
				$palabra = "Tipo_de_Cabeza";
				break;

			case 'r_bigote_cf':
				$palabra = "Tipo_de_Bigote";
				break;

			case 'r_cejas_cf':
				$palabra = "Tipo_de_Cejas";
				break;

			case 'r_ojos_cf':
				$palabra = "Tipo_de_Ojos";
				break;

			case 'r_colorojos_cf':
				$palabra = "Color_de_Ojos";
				break;

			case 'r_peso_cf':
				$palabra = "Peso";
				break;

			case 'r_estatura_cf':
				$palabra = "Estatura";
				break;

			case 'r_colorpiel_cf':
				$palabra = "Color_de_Piel";
				break;

			case 'r_tipocabello_cf':
				$palabra = "Tipo_de_Cabello";
				break;

			case 'r_colorcabello_cf':
				$palabra = "Color_de_Cabello";
				break;

			case 'r_tiponariz_cf':
				$palabra = "Tipo_de_Nariz";
				break;

			case 'r_complexion_cf':
				$palabra = "Complexion_Fisica";
				break;

			case 'r_lentes_cf':
				$palabra = "Usa_Lentes";
				break;

			case 'r_tatuajes_cf':
				$palabra = "Tatuajes";
				break;

			case 'r_amputaciones_cf':
				$palabra = "Amputaciones";
				break;

			case 'r_cicatrices_cf':
				$palabra = "Caracteristicas_fisicas";
				break;

			case 'r_email_cnt':
				$palabra = "Email_contacto";
				break;

			case 'r_lugar_trabajo_cnt':
				$palabra = "Lugar_de_Trabajo";
				break;

			case 'r_telefono_trabajo_cnt':
				$palabra = "Telefono_de_Trabajo";
				break;

			case 'r_dirección_cnt':
				$palabra = "Direccion_de_contacto";
				break;

			case 'asoc_rSocial':
				$palabra = "Razon_Social";
				break;

			case 'asoc_nComercial':
				$palabra = "Nombre_Comercial";
				break;

			case 'asoc_dir':
				$palabra = "Direccion";
				break;

			case 'asoc_tel':
				$palabra = "Telefono";
				break;
				
			case 'r_profesion_cnt':
				$palabra = "Profesion";
				break;

			case 'r_tipo_ident':
				$palabra = "Tipo_identificacion";
				break;

			case 'pj_r_tipo_ident':
				$palabra = "Tipo_identificacion";
				break;

			case 'pj_r_dpi':
				$palabra = "Numero_identificacion";
				break;

			default:
				$palabra = $palabra;
			
		}

		return $palabra;
	}


	public function nuevoArray($recibe)
	{

	$CorrigeJson = new CorrigeJson;
	$recibe = explode('|', $recibe);
	foreach ($recibe as $value) 
		{
			$data_explo = explode('~', $value);
			$key = $CorrigeJson->denunciante($data_explo[0]);
			$array_guarda[$key] = $data_explo[1];
		}

		$array_guarda = json_encode($array_guarda); //El array que contiene los datos del denunciante
	return $array_guarda;
	}	
}

?>