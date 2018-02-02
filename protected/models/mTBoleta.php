<?php

/**
 * This is the model class for table "dg_pnc_novedades.t_boleta".
 *
 * The followings are the available columns in table 'dg_pnc_novedades.t_boleta':
 * @property integer $id_boleta
 * @property string $detalle
 * @property string $hora
 * @property string $fecha
 * @property integer $id_usuario
 * @property integer $id_comisaria
 * @property string $estado
 * @property integer $id_departamento
 * @property integer $id_municipio
 * @property integer $id_zona
 * @property string $kmreferencia
 * @property string $ruta
 * @property string $calle_avenida
 * @property string $colonia_barrio
 * @property string $casa_lote
 * @property string $the_geom
 * @property string $division_pnc
 * @property string $hora_registro
 * @property string $titulo
 * @property string $hora2
 */
class mTBoleta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return mTBoleta the static model class
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
		return 'dg_pnc_novedades.t_boleta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_comisaria, id_departamento, id_municipio, id_zona', 'numerical', 'integerOnly'=>true),
			array('estado', 'length', 'max'=>11),
			array('kmreferencia', 'length', 'max'=>200),
			array('ruta', 'length', 'max'=>50),
			array('calle_avenida, colonia_barrio, division_pnc', 'length', 'max'=>100),
			array('titulo', 'length', 'max'=>300),
			array('detalle, hora, fecha, casa_lote, the_geom, hora_registro, hora2', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_boleta, detalle, hora, fecha, id_usuario, id_comisaria, estado, id_departamento, id_municipio, id_zona, kmreferencia, ruta, calle_avenida, colonia_barrio, casa_lote, the_geom, division_pnc, hora_registro, titulo, hora2', 'safe', 'on'=>'search'),
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
			'id_boleta' => 'Id Boleta',
			'detalle' => '',
			'hora' => '',
			'fecha' => '',
			'id_usuario' => 'Id Usuario',
			'id_comisaria' => 'Id Comisaria',
			'estado' => 'Estado',
			'id_departamento' => 'Id Departamento',
			'id_municipio' => 'Id Municipio',
			'id_zona' => 'Id Zona',
			'kmreferencia' => 'Kmreferencia',
			'ruta' => 'Ruta',
			'calle_avenida' => 'Calle Avenida',
			'colonia_barrio' => 'Colonia Barrio',
			'casa_lote' => 'Casa Lote',
			'the_geom' => 'The Geom',
			'division_pnc' => 'Division Pnc',
			'hora_registro' => 'Hora Registro',
			'titulo' => 'Titulo',
			'hora2' => 'Hora2',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */


public function cuadro()
	{
		$dia = date("Y-m-d",time()-21600);
		$connection=Yii::app()->db;
			$sql1 = "SELECT * FROM crosstab('
	SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
	WHERE a.id_boleta = b.id_boleta
	and a.id_evento = c.id_evento
	AND b.fecha = ''2013-09-09''
	and b.id_comisaria = d.id_comisaria
	GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
	order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')	
as ( id_evento character varying (300),
". "\"comisaria 11\"" . "character varying(300),
". "\"comisaria 12\"" . "character varying(300),
". "\"comisaria 13\"" . "character varying(300),
". "\"comisaria 14\"" . "character varying(300),
". "\"comisaria 15\"" . "character varying(300),
". "\"comisaria 16\"" . "character varying(300),
". "\"comisaria 21\"" . "character varying(300),
". "\"comisaria 22\"" . "character varying(300),
". "\"comisaria 23\"" . "character varying(300),
". "\"comisaria 24\"" . "character varying(300),
". "\"comisaria 31\"" . "character varying(300),
". "\"comisaria 32\"" . "character varying(300),
". "\"comisaria 33\"" . "character varying(300),
". "\"comisaria 34\"" . "character varying(300),
". "\"comisaria 41\"" . "character varying(300),
". "\"comisaria 42\"" . "character varying(300),
". "\"comisaria 43\"" . "character varying(300),
". "\"comisaria 44\"" . "character varying(300),
". "\"comisaria 51\"" . "character varying(300),
". "\"comisaria 52\"" . "character varying(300),
". "\"comisaria 53\"" . "character varying(300),
". "\"comisaria 61\"" . "character varying(300),
". "\"comisaria 62\"" . "character varying(300),
". "\"comisaria 71\"" . "character varying(300),
". "\"comisaria 72\"" . "character varying(300),
". "\"comisaria 73\"" . "character varying(300),
". "\"comisaria 74\"" . "character varying(300));";	

			$command=$connection->createCommand($sql1);
			$dataReader=$command->queryAll();
			
			/*
			foreach($dataReader as $row)
			{
				$tipo[] = $row['id_evento'];
				$cantidad[] = $row['cantidad'];
				$elarray = array(
				'tipo'=>$tipo,
				'cantidad'=>$cantidad,
				); 
			}*/
			return $dataReader;
	}

	public function eventoresumen($id_boleta){
   	$connection=Yii::app()->db;
			$sql1 = "
			SELECT (b.nombre_hecho || ' - ' || c.nombre_evento) as Hecho, a.cantidad 
			FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_hecho b,
  			dg_pnc_novedades.t_evento c,
  			dg_pnc_novedades.t_boleta d 
  			WHERE c.id_hecho = b.id_hecho AND a.id_boleta = d.id_boleta AND c.id_evento = a.id_evento
   			and a.id_boleta =".$id_boleta;
			$command=$connection->createCommand($sql1);
			$dataReader=$command->query();
			
			
			foreach($dataReader as $row)
			{
				
				$arrays[] = array(
				'evento'=>$row["hecho"], 
				'cantidad'=>$row["cantidad"], 
				);
			} 
			
		return  new CArrayDataProvider($arrays, array(
   		'keyField' => 'cantidad',         // PRIMARY KEY attribute of $list member objects
   		'id' => 'resumen'                    // ID of the data provider itself
));
		
	
	}
	public function dataresumen()
	{
		$dia = date("Y-m-d",time()-21600);
		$connection=Yii::app()->db;
			$sql1 = "SELECT 
					b.id_evento,
					sum(b.cantidad) AS cantidad,
					( SELECT (cat.nombre_hecho::text || ' '::text) || cat.nombre_evento::text
					FROM ( SELECT a.id_hecho, a.nombre_hecho, a.positivonegativo, b.id_evento, b.id_hecho, b.nombre_evento
					FROM dg_pnc_novedades.t_hecho a
					LEFT JOIN dg_pnc_novedades.t_evento b ON a.id_hecho = b.id_hecho) cat  
					WHERE cat.id_evento = b.id_evento) AS tipo

					FROM dg_pnc_novedades.t_boleta a
					LEFT JOIN dg_pnc_novedades.t_total_eventos b ON a.id_boleta = b.id_boleta
					WHERE (b.id_evento = ANY (ARRAY[ 32, 33, 34, 43, 44, 45, 1, 2, 3, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 17, 18, 19, 20, 21, 22, 23, 11, 16, 71, 75, 77, 79, 80, 4, 97, 99, 100, 105, 117, 116, 122, 128, 130, 78, 133, 134, 136, 140, 141, 142, 143, 145]))
					AND a.fecha = '".$dia."'
					GROUP BY b.id_evento 
					ORDER BY b.id_evento
";	

			$command=$connection->createCommand($sql1);
			$dataReader=$command->queryAll();
			
			
			foreach($dataReader as $row)
			{
				$tipo[] = $row['id_evento'];
				$cantidad[] = $row['cantidad'];
				$elarray = array(
				'tipo'=>$tipo,
				'cantidad'=>$cantidad,
				); 
			}
			return $dataReader;
	}

	public function puntomapa($geom)
	{
			$connection=Yii::app()->db;
			$sql1 = ' select astext(the_geom) from dg_pnc_novedades.t_boleta
			where id_boleta ='.$geom;
			$command=$connection->createCommand($sql1);
			$dataReader=$command->query();
			
			
			foreach($dataReader as $row)
			{
				$the_geom = $row['astext'];
			}
			return $the_geom;
	}
	public function detnove($id_boleta)
	{
		$id = $id_boleta;
			$connection=Yii::app()->db;
			$sql1 = '
			select a.id_boleta,b.nombre_comisaria,a.fecha, a.hora, a.titulo,
			a.detalle,
			d.departamento, e.municipio, c.usuario  
			 from 
			dg_pnc_novedades.t_boleta a , dg_pnc_novedades.t_comisaria b, dg_pnc_novedades.t_usuario c, dg_pnc_novedades.cat_departamentos d, dg_pnc_novedades.cat_municipios e
			where  b.id_comisaria = a.id_comisaria
			and c.id_usuario = a.id_usuario
			and d.cod_depto = a.id_departamento
			and e.cod_mupio = a.id_municipio
			and a.id_boleta ='.$id;
			$command=$connection->createCommand($sql1);
			$dataReader=$command->query();
			
			
			foreach($dataReader as $row)
			{
				$nhora =$row['hora'];
				$busca = array("{","}");
				$bodytag = str_replace($busca, "",$nhora);
				$ndetalle =htmlspecialchars_decode($row['detalle']);
				

				$arrays = array('id'=>1, 
				'comisaria'=>$row["nombre_comisaria"], 
				'fecha'=>$row["fecha"],
				'hora'=>$bodytag,
				'titulo'=>$row["titulo"],
				'detalle'=>$ndetalle,
				'departamento'=>$row["departamento"],
				'municipio'=>utf8_decode($row["municipio"]),
				'usuario'=>$row["usuario"],);
			} 
			

		return $arrays;
	}


	public function griddata($param)
	{
		if($param =='vacio')
		{$cadena = '';
		}else
		{
			$cadena = 'and a.id_boleta ='.$param;
		}
			$connection=Yii::app()->db;
			$sql1 = "
			SELECT a.id_boleta,a.fecha, b.nombre_comisaria, d.departamento, e.municipio, a.titulo from 
			dg_pnc_novedades.t_boleta a, dg_pnc_novedades.t_comisaria b, dg_pnc_novedades.cat_departamentos_333 d, dg_pnc_novedades.cat_municipios e   
			where b.id_comisaria = a.id_comisaria
			and d.cod_depto = a.id_departamento
			and e.cod_mupio = a.id_municipio
			and a.estado = 'Preeliminar'
			".$cadena."order by a.fecha DESC";
			$command=$connection->createCommand($sql1);
			$dataReader=$command->query();
			
			
			foreach($dataReader as $row)
			{
				$nhora='20:00';
				$arrays[] = array(
				'id_boleta'=>$row["id_boleta"], 
				'comisaria'=>$row["nombre_comisaria"], 
				'fecha'=>$row["fecha"],
				'hora'=>$nhora,
				'titulo'=>$row["titulo"],
				'departamento'=>$row["departamento"],
				'municipio'=>$row["municipio"],
				);
			} 
			
		return  new CArrayDataProvider($arrays, array(
   		'keyField' => 'id_boleta',         // PRIMARY KEY attribute of $list member objects
   		'id' => 'id_boleta'                    // ID of the data provider itself
));
		
		

	}



	public function search($param)
	{
			if ($param =='vacio')
		{	
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_boleta',$this->id_boleta);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_comisaria',$this->id_comisaria,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('id_departamento',$this->id_departamento);
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_zona',$this->id_zona);
		$criteria->compare('kmreferencia',$this->kmreferencia,true);
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('calle_avenida',$this->calle_avenida,true);
		$criteria->compare('colonia_barrio',$this->colonia_barrio,true);
		$criteria->compare('casa_lote',$this->casa_lote,true);
		$criteria->compare('the_geom',$this->the_geom,true);
		$criteria->compare('division_pnc',$this->division_pnc,true);
		$criteria->compare('hora_registro',$this->hora_registro,true);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('hora2',$this->hora2,true);
		$criteria->order = 'fecha desc';
				
				return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
			}else
			{
			$criteria=new CDbCriteria;

		$criteria->compare('id_boleta',$this->id_boleta);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_comisaria',$this->id_comisaria,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('id_departamento',$this->id_departamento);
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_zona',$this->id_zona);
		$criteria->compare('kmreferencia',$this->kmreferencia,true);
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('calle_avenida',$this->calle_avenida,true);
		$criteria->compare('colonia_barrio',$this->colonia_barrio,true);
		$criteria->compare('casa_lote',$this->casa_lote,true);
		$criteria->compare('the_geom',$this->the_geom,true);
		$criteria->compare('division_pnc',$this->division_pnc,true);
		$criteria->compare('hora_registro',$this->hora_registro,true);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('hora2',$this->hora2,true);
		$criteria->order = 'fecha desc';
		$criteria->addCondition ('id_boleta ='.$param.'');
				return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));	
			}

		
	}
		






		public function buscadata($param)
	{
			if ($param =='vacio')
		{	
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_boleta',$this->id_boleta);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_comisaria',$this->id_comisaria,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('id_departamento',$this->id_departamento);
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_zona',$this->id_zona);
		$criteria->compare('kmreferencia',$this->kmreferencia,true);
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('calle_avenida',$this->calle_avenida,true);
		$criteria->compare('colonia_barrio',$this->colonia_barrio,true);
		$criteria->compare('casa_lote',$this->casa_lote,true);
		$criteria->compare('the_geom',$this->the_geom,true);
		$criteria->compare('division_pnc',$this->division_pnc,true);
		$criteria->compare('hora_registro',$this->hora_registro,true);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('hora2',$this->hora2,true);
		$criteria->order = 'fecha desc';
		$criteria->addCondition("estado = 'Preeliminar'");				
				return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
			}else
			{
			$criteria=new CDbCriteria;

		$criteria->compare('id_boleta',$this->id_boleta);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_comisaria',$this->id_comisaria,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('id_departamento',$this->id_departamento);
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('id_zona',$this->id_zona);
		$criteria->compare('kmreferencia',$this->kmreferencia,true);
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('calle_avenida',$this->calle_avenida,true);
		$criteria->compare('colonia_barrio',$this->colonia_barrio,true);
		$criteria->compare('casa_lote',$this->casa_lote,true);
		$criteria->compare('the_geom',$this->the_geom,true);
		$criteria->compare('division_pnc',$this->division_pnc,true);
		$criteria->compare('hora_registro',$this->hora_registro,true);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('hora2',$this->hora2,true);
		$criteria->order = 'fecha desc';
		$criteria->addCondition ('id_boleta ='.$param.'');
		$criteria->addCondition("estado = 'Preeliminar'");	
				return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));	
			}

		
	}
}