<?php

/**
 * This is the model class for table "soporte_aplicaciones.cat_modulos".
 *
 * The followings are the available columns in table 'soporte_aplicaciones.cat_modulos':
 * @property integer $id_modulo
 * @property integer $id_aplicacion
 * @property string $nombre_modulo
 */
class CatModulos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatModulos the static model class
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
		return 'soporte_aplicaciones.cat_modulos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_aplicacion', 'numerical', 'integerOnly'=>true),
			array('nombre_modulo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_modulo, id_aplicacion, nombre_modulo', 'safe', 'on'=>'search'),
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
			'id_modulo' => 'Id Modulo',
			'id_aplicacion' => 'Id Aplicacion',
			'nombre_modulo' => 'Nombre Modulo',
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

		$criteria->compare('id_modulo',$this->id_modulo);
		$criteria->compare('id_aplicacion',$this->id_aplicacion);
		$criteria->compare('nombre_modulo',$this->nombre_modulo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}