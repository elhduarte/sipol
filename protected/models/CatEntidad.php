<?php

/**
 * This is the model class for table "catalogos_publicos.cat_entidad".
 *
 * The followings are the available columns in table 'catalogos_publicos.cat_entidad':
 * @property integer $id_cat_entidad
 * @property integer $numero_comisaria
 * @property string $nombre_entidad
 * @property integer $distrito
 * @property string $region
 */
class CatEntidad extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatEntidad the static model class
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
		return 'catalogos_publicos.cat_entidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cat_entidad', 'required'),
			array('id_cat_entidad, numero_comisaria, distrito', 'numerical', 'integerOnly'=>true),
			array('nombre_entidad', 'length', 'max'=>100),
			array('region', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cat_entidad, numero_comisaria, nombre_entidad, distrito, region', 'safe', 'on'=>'search'),
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
			'id_cat_entidad' => 'Id Cat Entidad',
			'numero_comisaria' => 'Numero Comisaria',
			'nombre_entidad' => 'Nombre Entidad',
			'distrito' => 'Distrito',
			'region' => 'Region',
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
		$criteria->compare('id_cat_entidad',$this->id_cat_entidad);
		$criteria->compare('numero_comisaria',$this->numero_comisaria);
		$criteria->compare('nombre_entidad',$this->nombre_entidad,true);
		$criteria->compare('distrito',$this->distrito);
		$criteria->compare('region',$this->region,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function crearcomboentidad($id_rol,$id_cat_entidad)
	{
		/*hace las funciones para evaluar que tiene el campo de asignacion del rol*/
			#$id_rol = '2';
			#$id_cat_entidad  = '5';
			$Criteria = new CDbCriteria();
        $Criteria->condition ="id_rol = ".$id_rol."";
          $Criteria->order ='id_rol ASC';
          $data=CatRol::model()->findAll($Criteria);
          $data=CHtml::listData($data,'id_rol','permisos_entidad');
          $valor = "";
          foreach($data as $value=>$name)
          {
            $valor = $valor.$name;
          }
          $criterianueva = new CDbCriteria();
          if($valor =="comisario")
          {            
            $valor =$id_cat_entidad;
            $criterianueva->condition = "id_cat_entidad IN(".$valor.")";
              #Echo "Este es el comisario";
          }else{
            #echo "Este no es comisario";
            $criterianueva->condition = "id_cat_entidad IN(".$valor.")";
          }
        $criterianueva->order ='id_cat_entidad ASC';
        $data=CatEntidad::model()->findAll($criterianueva);
        $data=CHtml::listData($data,'id_cat_entidad','nombre_entidad');
			return $data;
	}
}