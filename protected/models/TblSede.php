<?php

/**
 * This is the model class for table "catalogos_publicos.tbl_sede".
 *
 * The followings are the available columns in table 'catalogos_publicos.tbl_sede':
 * @property integer $id_sede
 * @property integer $id_cat_entidad
 * @property integer $id_tipo_sede
 * @property integer $cod_depto
 * @property integer $cod_mupio
 * @property string $nombre
 * @property string $referencia
 * @property string $the_geom
 */
class TblSede extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblSede the static model class
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
		return 'catalogos_publicos.tbl_sede';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cat_entidad, id_tipo_sede, cod_depto, cod_mupio', 'numerical', 'integerOnly'=>true),
			array('nombre, referencia', 'length', 'max'=>100),
			array('the_geom', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_sede, id_cat_entidad, id_tipo_sede, cod_depto, cod_mupio, nombre, referencia, the_geom', 'safe', 'on'=>'search'),
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
			'id_sede' => 'Id Sede',
			'id_cat_entidad' => 'Id Cat Entidad',
			'id_tipo_sede' => 'Id Tipo Sede',
			'cod_depto' => 'Cod Depto',
			'cod_mupio' => 'Cod Mupio',
			'nombre' => 'Nombre',
			'referencia' => 'Referencia',
			'the_geom' => 'The Geom',
		);
	}

		/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblEmpresas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TblSede::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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

		$criteria->compare('id_sede',$this->id_sede);
		$criteria->compare('id_cat_entidad',$this->id_cat_entidad);
		$criteria->compare('id_tipo_sede',$this->id_tipo_sede);
		$criteria->compare('cod_depto',$this->cod_depto);
		$criteria->compare('cod_mupio',$this->cod_mupio);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('the_geom',$this->the_geom,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

public function getSede($id_sede)
	{
		
		$sql = 
			"SELECT s.nombre, m.departamento, m.municipio FROM catalogos_publicos.tbl_sede s, catalogos_publicos.cat_municipios m 
where id_sede = '".$id_sede."'
and s.cod_mupio = m.cod_mupio;";

		$resultado = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($resultado as $key => $value) 
		{
			#foreach ($value as $clave => $valor) {}
		}

		//htmlspecialchars_decode
		$nombre= $value['nombre'];
		$departamento= $value['departamento'];
		$municipio= $value['municipio'];
		


			$a=array(
				'nombre'=>$nombre,
				'departamento'=>$departamento,
				'municipio'=>$municipio
				);
		return $a;
	}

	public function fgrid($entidad)
{
	if($entidad =='todos')
	{
		$condicion = '';

	}
	else 
	{
		$condicion = 'and s.id_cat_entidad= '.$entidad;
	}
		$sql = 
		"SELECT 
		s.id_sede, e.region, e.nombre_entidad,ts.descripcion, s.nombre  
		FROM  
		catalogos_publicos.tbl_sede s, catalogos_publicos.cat_entidad e, catalogos_publicos.cat_tipo_sede ts
		WHERE 
		s.id_cat_entidad = e.id_cat_entidad
		AND s.id_tipo_sede= ts.id_tipo_sede
		".$condicion."";

		//echo $sql;
		// FIN Se arma el query para el data provider

		//INICIO Conexión a la base de datos y ejecución del query
		$connection=Yii::app()->db;
		$encrip = new Encrypter;

		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$a=array();
		$num = "1";

		foreach($dataReader as $row)
		{
			$id_sede  = $row['id_sede'];
			$region = $row['region'];
			$nombre_entidad= $row['nombre_entidad'];
			$descripcion = $row['descripcion'];
			$nombre = $row['nombre'];
	
			//$usuario_enlace = htmlspecialchars("<b>".$usuario."</b>" ENT_QUOTES);


			$a[]=array(
			"num"=>$num++, 
			"id_sede"=>$id_sede,
			"region"=>$region,
			"nombre_entidad"=>$nombre_entidad,
			"descripcion"=>$descripcion,
			"nombre"=>$nombre, 
			);
			
		}
			echo "<div id='consulta' style='display:none;'>";	
			echo Encrypter::encrypt($sql);
			echo "</div>";
		
		return new CArrayDataProvider($a, array(
		'id'=>'ranking_1',
		'keyField' => 'id_sede',
		'pagination'=>array(
			'pageSize'=>10,
			//'route'=>'CTblEvento/grilla_incidencia&ajax=grid_tedst'

			),
		));
	}
}