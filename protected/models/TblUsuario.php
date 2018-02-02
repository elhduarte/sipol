<?php

/**
 * This is the model class for table "sipol_usuario.tbl_usuario".
 *
 * The followings are the available columns in table 'sipol_usuario.tbl_usuario':
 * @property integer $id_usuario
 * @property string $puesto
 * @property string $usuario
 * @property string $password
 * @property string $email
 * @property string $no_oficio_solicitud
 * @property integer $id_usuario_crea
 * @property string $fecha_crea
 * @property integer $estado
 * @property string $primer_nombre
 * @property string $segundo_nombre
 * @property string $primer_apellido
 * @property string $segundo_apellido
 * @property string $fecha_nacimiento
 * @property string $dpi
 * @property string $direccion
 * @property integer $departamento
 * @property integer $municipio
 * @property integer $sexo
 * @property string $no_registro
 * @property string $foto
 * @property integer $proceso
 * @property string $nip
 * @property integer $estado_mensaje
 * @property integer $estatuspass
 * @property string $no_orden
 */
class TblUsuario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblUsuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sipol_usuario.tbl_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password', 'required'),
			array('id_usuario_crea, estado, departamento, municipio, sexo, proceso, estado_mensaje, estatuspass', 'numerical', 'integerOnly'=>true),
			array('puesto, password, email', 'length', 'max'=>100),
			array('usuario', 'length', 'max'=>25),
			array('no_oficio_solicitud', 'length', 'max'=>60),
			array('fecha_crea, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, dpi, direccion, no_registro, foto, nip, no_orden', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_usuario, puesto, usuario, password, email, no_oficio_solicitud, id_usuario_crea, fecha_crea, estado, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, dpi, direccion, departamento, municipio, sexo, no_registro, foto, proceso, nip, estado_mensaje, estatuspass, no_orden', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_usuario' => 'Id Usuario',
			'puesto' => 'Puesto',
			'usuario' => 'Usuario',
			'password' => 'Password',
			'email' => 'Email',
			'no_oficio_solicitud' => 'No Oficio Solicitud',
			'id_usuario_crea' => 'Id Usuario Crea',
			'fecha_crea' => 'Fecha Crea',
			'estado' => 'Estado',
			'primer_nombre' => 'Primer Nombre',
			'segundo_nombre' => 'Segundo Nombre',
			'primer_apellido' => 'Primer Apellido',
			'segundo_apellido' => 'Segundo Apellido',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'dpi' => 'Dpi',
			'direccion' => 'Direccion',
			'departamento' => 'Departamento',
			'municipio' => 'Municipio',
			'sexo' => 'Sexo',
			'no_registro' => 'No Registro',
			'foto' => 'Foto',
			'proceso' => 'Proceso',
			'nip' => 'Nip',
			'estado_mensaje' => 'Estado Mensaje',
			'estatuspass' => 'Estatuspass',
			'no_orden' => 'Numero de Celular',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('puesto',$this->puesto,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('no_oficio_solicitud',$this->no_oficio_solicitud,true);
		$criteria->compare('id_usuario_crea',$this->id_usuario_crea);
		$criteria->compare('fecha_crea',$this->fecha_crea,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('primer_nombre',$this->primer_nombre,true);
		$criteria->compare('segundo_nombre',$this->segundo_nombre,true);
		$criteria->compare('primer_apellido',$this->primer_apellido,true);
		$criteria->compare('segundo_apellido',$this->segundo_apellido,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('dpi',$this->dpi,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('departamento',$this->departamento);
		$criteria->compare('municipio',$this->municipio);
		$criteria->compare('sexo',$this->sexo);
		$criteria->compare('no_registro',$this->no_registro,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('proceso',$this->proceso);
		$criteria->compare('nip',$this->nip,true);
		$criteria->compare('estado_mensaje',$this->estado_mensaje);
		$criteria->compare('estatuspass',$this->estatuspass);
		$criteria->compare('no_orden',$this->no_orden,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
public function searchusuario($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;


		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('puesto',$this->puesto,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('no_oficio_solicitud',$this->no_oficio_solicitud,true);		
		$criteria->compare('fecha_crea',$this->fecha_crea,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('primer_nombre',$this->primer_nombre,true);
		$criteria->compare('segundo_nombre',$this->segundo_nombre,true);
		$criteria->compare('primer_apellido',$this->primer_apellido,true);
		$criteria->compare('segundo_apellido',$this->segundo_apellido,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('dpi',$this->dpi,true);
		$criteria->compare('no_orden',$this->no_orden);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('departamento',$this->departamento);
		$criteria->compare('municipio',$this->municipio);
		$criteria->compare('sexo',$this->sexo);
		$criteria->compare('no_registro',$this->no_registro,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('proceso',$this->proceso);
		$criteria->compare('nip',$this->nip,true);
		$criteria->compare('estado_mensaje',$this->estado_mensaje);
		$criteria->condition='id_usuario_crea='.$id;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function procesa_movimientos_sede($id_usuario)
	{
		$queryvalidador ="select * from sipol_usuario.tbl_log_usuario where id_usuario = ".$id_usuario." ORDER BY id_log_usuario asc";
		
		//echo $queryvalidador;
		$resultado = Yii::app()->db->createCommand($queryvalidador)->queryAll();
		$conta = count($resultado);
		$a="";
		$inicial = "";
		//$id_sesde = "";
		$final = "";
		$contador = 0;
		$id_sede = "";
		$conteo_intentos = 0;
		$movimientos =  array();
		foreach ($resultado as $key => $value) 
		{
			$a = json_encode($value);
			$a = json_decode($a);
			if($contador == 0)
			{
				$inicial = $a->fecha;
				//$id_sesde = $a->id_sede;
				$id_sede = $a->id_sede;	
			}
			else if($id_sede !== $a->id_sede)
			{
				$cuerpo_tabla="";
				$final = $a->fecha;	
				$movimientos[$conteo_intentos] =  array('fecha_inicio' => $inicial ,'fecha_final' => $final,'id_sede' => $id_sede);
				$conteo_intentos = $conteo_intentos +1;
				$inicial = $final;
				//$id_sesde = $a->id_sede;
				$id_sede = $a->id_sede;
			}
			$contador = $contador+1;
			if($contador == $conta){
				$inicial = $a->fecha;
				//$id_sesde = $a->id_sede;
				$final = "now()";
				$movimientos[$conteo_intentos] =  array('fecha_inicio' => $inicial ,'fecha_final' => $final,'id_sede' => $a->id_sede );
				$conteo_intentos = $conteo_intentos +1;		
				$inicial = $final;
				//$id_sesde = $a->id_sede;
				$id_sede = $a->id_sede;
			}		
		}//fin del foreach
		return $movimientos;
	}

	public function procesa_movimientos_rol($id_usuario)
	{
		$queryvalidador ="select * from sipol_usuario.tbl_log_usuario where id_usuario = ".$id_usuario." ORDER BY id_log_usuario asc";
		
		//echo $queryvalidador;
		$resultado = Yii::app()->db->createCommand($queryvalidador)->queryAll();
		$conta = count($resultado);
		$a="";
		$inicial = "";
		//$id_sesde = "";
		$final = "";
		$contador = 0;
		$id_rol = "";
		$conteo_intentos = 0;
		$movimientos =  array();
		foreach ($resultado as $key => $value) 
		{
			$a = json_encode($value);
			$a = json_decode($a);
			if($contador == 0)
			{
				$inicial = $a->fecha;
				//$id_sesde = $a->id_rol;
				$id_rol = $a->id_rol;	
			}
			else if($id_rol !== $a->id_rol)
			{
				$cuerpo_tabla="";
				$final = $a->fecha;	
				$movimientos[$conteo_intentos] =  array('fecha_inicio' => $inicial ,'fecha_final' => $final,'id_rol' => $id_rol);
				$conteo_intentos = $conteo_intentos +1;
				$inicial = $final;
				//$id_sesde = $a->id_rol;
				$id_rol = $a->id_rol;
			}
			$contador = $contador+1;
			if($contador == $conta){
				$inicial = $a->fecha;
				//$id_sesde = $a->id_rol;
				$final = "now()";
				$movimientos[$conteo_intentos] =  array('fecha_inicio' => $inicial ,'fecha_final' => $final,'id_rol' => $a->id_rol );
				$conteo_intentos = $conteo_intentos +1;		
				$inicial = $final;
				//$id_sesde = $a->id_rol;
				$id_rol = $a->id_rol;
			}		
		}//fin del foreach
		return $movimientos;
	}

	public function procesar_consumo_servicios($id_usuario,$id_servicio, $inicial, $final)
	{
			$query ="select * from  sipol_usuario.tbl_log_consulta 
			where fecha between ('".$inicial."')::TIMESTAMP  and ('".$final."')::TIMESTAMP  AND id_servicio = ".$id_servicio." AND id_usuario = ".$id_usuario ."";
			$resul = Yii::app()->db->createCommand($query)->queryAll();
			$con = count($resul);
			$descripcion = "";
				$queryy="select descripcion from  sipol_catalogos.cat_servicios where id_servicio = ".$id_servicio."";
			$resull = Yii::app()->db->createCommand($queryy)->queryAll();
			foreach ($resull as $key => $value){
				$descripcion = $value['descripcion'];
			}			
			$cuerpo_tabla =  "<tr>
						      <td>".$descripcion."</td>
						      <td>".$con."</td>
						    </tr>";
			return $cuerpo_tabla;
	}
	public function consulta_dpi_existente($dpi)
	{
		$cod_dpi ="";
		$consultaDPI = "select dpi from sipol_usuario.tbl_usuario where dpi = ".$dpi."";
		$resultadoDPI = Yii::app()->db->createCommand($consultaDPI)->queryAll();
			if(count($resultadoDPI)>= 1)
			{
				$cod_dpi = 'si';
			}else{
				$cod_dpi = 'no';
			}		
		return $cod_dpi;
	}

	public function consulta_usuario_completo($idusuario)
	{

		$sql="SELECT 
			u.*,
			depto.departamento as nombredepartamento,
			mupio.municipio as nombremunicipio, 
			r.nombre_rol as nombrerol, 
			e.nombre_entidad||', '||ts.descripcion||', '||s.nombre as nombrecomisaria
			FROM sipol_usuario.tbl_rol_usuario ru
			LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
			LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
			LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
			LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
			LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
			LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
			LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
			WHERE u.id_usuario = ".$idusuario."";


      $resultado = Yii::app()->db->createCommand($sql)->queryAll();
      $trasfomacionusuario = $resultado[0];
      $trasfomacionusuario = json_encode($trasfomacionusuario);
       $usuariodatos = json_decode($trasfomacionusuario);
       return $usuariodatos;

	}
	public function consulta_usuario_completo_dpi($numerodpi)
	{

		$sql="SELECT 
			u.*,
			depto.departamento as nombredepartamento,
			mupio.municipio as nombremunicipio, 
			r.nombre_rol as nombrerol, 
			e.nombre_entidad||', '||ts.descripcion||', '||s.nombre as nombrecomisaria
			FROM sipol_usuario.tbl_rol_usuario ru
			LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
			LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
			LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
			LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
			LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
			LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
			LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
			WHERE u.dpi = ".$numerodpi."";


      $resultado = Yii::app()->db->createCommand($sql)->queryAll();
      $trasfomacionusuario = $resultado[0];
      $trasfomacionusuario = json_encode($trasfomacionusuario);
       $usuariodatos = json_decode($trasfomacionusuario);
       return $usuariodatos;

	}
	public function consulta_usuario_entidad_completo_usuario_crea($id_usuario_crea)
	{	
		$sqlsistema = " SELECT 
		e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as entidad,
		r.nombre_rol as nombre_rol, 
		u.id_usuario,
		u.primer_nombre || ' ' || u.segundo_nombre || ' ' || u.primer_apellido || ' ' ||u.segundo_apellido as nombre_completo,
		mupio.municipio || ',' ||depto.departamento as ubicacion
		FROM sipol_usuario.tbl_rol_usuario ru
		LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
		LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
		LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
		LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
		LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
		LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
		LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
		WHERE u.id_usuario = ".$id_usuario_crea."";
		$resultadosistemas = Yii::app()->db->createCommand($sqlsistema)->queryAll();
		$trasresultadosistemas = $resultadosistemas[0];
		$trasresultadosistemas = json_encode($trasresultadosistemas);
		$resultadosistemasquery = json_decode($trasresultadosistemas);
		return $resultadosistemasquery;
	}
	public function perfil_usuario()
	{
		$usuarioquery = "select a.id_usuario as id, b.usuario as usuario from sipol_usuario.tbl_session_usuario as a, sipol_usuario.tbl_usuario as b
		where  a.id_usuario = b.id_usuario
		GROUP BY a.id_usuario,b.usuario
		ORDER BY a.id_usuario,b.usuario";
		 $resultadoqueryusuario = Yii::app()->db->createCommand($usuarioquery)->queryAll();
		return $resultadoqueryusuario;
	}
	public function perfil_usuario_parametros()
	{
		$usuarioquery = "select a.id_usuario as id, b.usuario as usuario from sipol_usuario.tbl_session_usuario as a, sipol_usuario.tbl_usuario as b
		where  a.id_usuario = b.id_usuario
		GROUP BY a.id_usuario,b.usuario
		ORDER BY a.id_usuario,b.usuario";
		 $resultadoqueryusuario = Yii::app()->db->createCommand($usuarioquery)->queryAll();
		return $resultadoqueryusuario;
	}

		public function perfil_resumen_ingreso($fechajson)
	{
		$sql="SELECT a.fecha_ingreso, count(*) 
FROM sipol_usuario.tbl_session_usuario as a, sipol_usuario.tbl_rol_usuario as b, sipol_usuario.cat_rol as c
WHERE a.id_usuario = b.id_usuario and b.id_rol = c.id_rol  and a.id_usuario = ".$fechajson." and  a.fecha_ingreso 
BETWEEN CAST ('1970-01-01' AS DATE) AND CAST ( now() AS DATE) GROUP BY a.fecha_ingreso ORDER BY a.fecha_ingreso asc";

$sql ="SELECT (a.fecha_ingreso)::date, count(*) 
FROM sipol_usuario.tbl_session_usuario as a, sipol_usuario.tbl_rol_usuario as b, sipol_usuario.cat_rol as c
WHERE a.id_usuario = b.id_usuario 
and b.id_rol = c.id_rol  
and a.id_usuario = ".$fechajson." AND  (a.fecha_ingreso)::date BETWEEN now()::date - 900 AND now()::date  
GROUP BY (a.fecha_ingreso)::date ORDER BY (a.fecha_ingreso)::date asc";
      

      $resultadoconteovisitas = Yii::app()->db->createCommand($sql)->queryAll();
		return $resultadoconteovisitas;
	}

public function perfil_resumen_ingreso_dos()
{
	$sql ="SELECT a.fecha_ingreso, a.id_usuario,count(*) 
	FROM sipol_usuario.tbl_session_usuario as a, sipol_usuario.tbl_rol_usuario as b, sipol_usuario.cat_rol as c
	WHERE 
	a.id_usuario = b.id_usuario
	 and b.id_rol = c.id_rol 
	 --and a.id_usuario = 55 
	 and a.fecha_ingreso 
	BETWEEN 
	CAST ('1970-01-01' AS DATE)
	 AND CAST ( now() AS DATE) 
	 GROUP BY a.fecha_ingreso, a.id_usuario 
	 ORDER BY a.id_usuario  asc, a.fecha_ingreso asc";
	      $resultadousuarioscompletos = Yii::app()->db->createCommand($sql)->queryAll();
		return $resultadousuarioscompletos;
}

	public function perfil_carta_usuario($id)
	{
	$sql_datos ="
SELECT 
u.usuario AS usuario,
u.password AS password,
u.primer_nombre AS primer_nombre,
u.segundo_nombre AS segundo_nombre,
u.primer_apellido AS primer_apellido,
u.segundo_apellido AS segundo_apellido,
u.fecha_crea AS fecha_crea,
e.nombre_entidad||', '||ts.descripcion||', '||s.nombre as nombre_entidad,
r.nombre_rol AS nombre_rol,
s.cod_mupio AS municipio,
s.cod_depto AS departamento,
depto.departamento||', Municipio '||mupio.municipio as ubicacion
FROM sipol_usuario.tbl_rol_usuario ru
LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
WHERE u.id_usuario =".$id."";
$resultado = Yii::app()->db->createCommand($sql_datos)->queryAll();
		return $resultado;
	}

	public function perfil_carta_usuario_cuerpo($id)
	{
		#query que realiza la obtencion del cuerpo del reporte
	$sql = "select body_letter_user as body, observations_letter_user as observaciones from sipol_catalogos.config_opciones";
	$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		return $resultado;
	}
		public function perfil_seguimientos_rol($inicial,$final,$id_usuario)
	{
				$query ="select * from sipol_usuario.tbl_session_usuario 
			where fecha_ingreso between ('".$inicial."')::TIMESTAMP  and ('".$final."')::TIMESTAMP  AND id_usuario = ".$id_usuario ."";
			$resul = Yii::app()->db->createCommand($query)->queryAll();
		return $resul;
	}

		public function perfil_seguimientos_rol_dos($inicial,$final,$id_usuario)
	{
				$sql = "select (a.fecha_ingreso)::date as fecha_ingreso, count(a.fecha_ingreso)  from 
						sipol_usuario.tbl_session_usuario as a
						WHERE a.id_usuario = ".$id_usuario."
						AND a.fecha_ingreso between  ('".$inicial."')::date AND ('".$final."')::date
						GROUP BY (a.fecha_ingreso)::date 
						order by 1 asc";
      $resultadoconteovisitas = Yii::app()->db->createCommand($sql)->queryAll();
		return $resultadoconteovisitas;
	}
	public function perfil_seguimientos_rol_tres($id_usuario)
	{
				    $sql= "select fecha_ingreso, hora_ingreso  from sipol_usuario.tbl_session_usuario where id_usuario  = ".$id_usuario."
      ORDER BY fecha_ingreso DESC, hora_ingreso DESC limit 10 ";
      $resultado = Yii::app()->db->createCommand($sql)->queryAll();
		return $resultado;
	}


	public function consulta_usuario_entidad_completo_usuario_novedades()
	{	
		$sqlsistema = " SELECT 
		u.id_usuario as id_usuario,
		e.nombre_entidad||', '||ts.descripcion||', '||s.nombre||', '||s.referencia as entidad,
		r.nombre_rol as nombre_rol, 
		u.id_usuario,
		u.primer_nombre || ' ' || u.segundo_nombre || ' ' || u.primer_apellido || ' ' ||u.segundo_apellido as nombre_completo,
		mupio.municipio || ',' ||depto.departamento as ubicacion
		FROM sipol_usuario.tbl_rol_usuario ru
		LEFT JOIN sipol_usuario.tbl_usuario u ON ru.id_usuario = u.id_usuario
		LEFT JOIN sipol_usuario.cat_rol r ON ru.id_rol = r.id_rol
		LEFT JOIN catalogos_publicos.tbl_sede s ON ru.id_sede = s.id_sede
		LEFT JOIN catalogos_publicos.cat_entidad e ON s.id_cat_entidad = e.id_cat_entidad
		LEFT JOIN catalogos_publicos.cat_tipo_sede ts ON s.id_tipo_sede = ts.id_tipo_sede
		LEFT JOIN catalogos_publicos.cat_departamentos depto ON s.cod_depto = depto.cod_depto
		LEFT JOIN catalogos_publicos.cat_municipios mupio ON s.cod_mupio = mupio.cod_mupio
		";
		$array_sale = array();
		$resultadosistemas = Yii::app()->db->createCommand($sqlsistema)->queryAll();
		foreach ($resultadosistemas as $row) {
			$id_usuario  = $row['id_usuario'];
			$entidad  = $row['entidad'];
			$nombre_rol  = $row['nombre_rol'];
			$nombre_completo  = $row['nombre_completo'];
			$ubicacion = $row['ubicacion'];


			# code...
		$array_sale[] = array(
			'id_usuario'=>"<div valor='".$id_usuario."' class='asignacion_rol'><i class='icon-user'></i></div>",
			'entidad'=>$entidad,
			'nombre_rol'=>$nombre_rol,
			'nombre_completo'=>$nombre_completo,
			'ubicacion'=>$ubicacion,	
			);
		}
		
		return new CArrayDataProvider($array_sale, array(
		'id'=>'ranking_1',
		'keyField' => 'id_usuario',
		'pagination'=>array(
			'pageSize'=>10,
			//'route'=>'CTblEvento/grilla_incidencia&ajax=grid_tedst'

			),
		));
	}

	//funciones para validacion de usuario

	public function conteo_nip_usuario($usuario)
	{
		$sql="SELECT count(id_usuario) FROM  sipol_usuario.tbl_usuario WHERE usuario = '".$usuario."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}

	public function extraer_correo($usuario)
	{
		$sql="SELECT email AS email FROM sipol_usuario.tbl_usuario WHERE usuario = '".$usuario."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];

	}

	public function extraer_celular($usuario)
	{
		$sql="SELECT  no_orden AS celular FROM sipol_usuario.tbl_usuario WHERE usuario = '".$usuario."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];

	}

	public function extraer_celular_id_usuario($id_usuario)
	{
		$sql="SELECT  no_orden AS celular FROM sipol_usuario.tbl_usuario WHERE id_usuario = '".$id_usuario."';";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];

	}


//funciones de conteo en el sistema

	public function conteo_ingreso_sistema($id_usuario)
	{
		$sql="SELECT count(id_session_usuario) FROM  sipol_usuario.tbl_session_usuario WHERE id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}

	public function conteo_ticket_sistema($id_usuario)
	{
		$sql="SELECT count(id_ticket_delet) FROM soporte_aplicaciones.tbl_ticket_delete WHERE id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}

	public function conteo_sugerencia_sistema($id_usuario)
	{
		$sql="SELECT count(id_sugerencia) FROM soporte_aplicaciones.tbl_sugerencia WHERE id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}

	public function conteo_denuncia_activa_sistema($id_usuario)
	{
		$sql="SELECT count(id_evento) FROM sipol.tbl_evento WHERE  id_tipo_evento = 1 AND estado = TRUE AND id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}
	public function conteo_denuncia_inactiva_sistema($id_usuario)
	{
		$sql="SELECT count(id_evento) FROM sipol.tbl_evento WHERE  id_tipo_evento = 1 AND estado = FALSE AND id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}
	public function conteo_incidencia_activa_sistema($id_usuario)
	{
		$sql="SELECT count(id_evento) FROM sipol.tbl_evento WHERE  id_tipo_evento = 2 AND estado = TRUE AND id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}
	public function conteo_incidencia_inactiva_sistema($id_usuario)
	{
		$sql="SELECT count(id_evento) FROM sipol.tbl_evento WHERE  id_tipo_evento = 2 AND estado = FALSE AND id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}
	public function conteo_extravio_activa_sistema($id_usuario)
	{
		$sql="SELECT count(id_evento) FROM sipol.tbl_evento WHERE  id_tipo_evento = 3 AND estado = TRUE AND id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}
	public function conteo_extravio_inactiva_sistema($id_usuario)
	{
		$sql="SELECT count(id_evento) FROM sipol.tbl_evento WHERE  id_tipo_evento = 3 AND estado = FALSE AND id_usuario = ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}
	public function conteo_consumo_sistema($id_usuario,$id_comsumo)
	{
		$sql="SELECT count(id_log_consulta) FROM sipol_usuario.tbl_log_consulta WHERE  id_servicio = ".$id_comsumo." AND id_usuario =  ".$id_usuario.";";
		$resultado = Yii::app()->db->createCommand($sql)->queryColumn();
		return $resultado[0];
	}

	public function estadisticausuariofoto()
	{
		$sql="SELECT * FROM sipol_usuario.estadistica_usuario;";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		return $resultado;
	}
}