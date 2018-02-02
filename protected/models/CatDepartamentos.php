<?php

/**
 * This is the model class for table "catalogos_publicos.cat_departamentos".
 *
 * The followings are the available columns in table 'catalogos_publicos.cat_departamentos':
 * @property integer $gid
 * @property double $cod_depto
 * @property string $departamento
 * @property string $the_geom
 * @property string $bbox
 */
class CatDepartamentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatDepartamentos the static model class
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
		return 'catalogos_publicos.cat_departamentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gid', 'required'),
			array('gid', 'numerical', 'integerOnly'=>true),
			array('cod_depto', 'numerical'),
			array('departamento', 'length', 'max'=>50),
			array('bbox', 'length', 'max'=>255),
			array('the_geom', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gid, cod_depto, departamento, the_geom, bbox', 'safe', 'on'=>'search'),
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
			'gid' => 'Gid',
			'cod_depto' => 'Cod Depto',
			'departamento' => 'Departamento',
			'the_geom' => 'The Geom',
			'bbox' => 'Bbox',
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

		$criteria->compare('gid',$this->gid);
		$criteria->compare('cod_depto',$this->cod_depto);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('the_geom',$this->the_geom,true);
		$criteria->compare('bbox',$this->bbox,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}