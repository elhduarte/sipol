<?php

/**
 * This is the model class for table "sipol_2.tbl_parte_policial".
 *
 * The followings are the available columns in table 'sipol_2.tbl_parte_policial':
 * @property integer $id_parte_policial
 * @property integer $id_agente
 * @property string $fecha_parte
 */
class MTblPartePolicial extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MTblPartePolicial the static model class
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
		return 'sipol_2.tbl_parte_policial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_agente', 'numerical', 'integerOnly'=>true),
			array('fecha_parte', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_parte_policial, id_agente, fecha_parte', 'safe', 'on'=>'search'),
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
			'id_parte_policial' => 'Id Parte Policial',
			'id_agente' => 'Id Agente',
			'fecha_parte' => 'Fecha Parte',
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

		$criteria->compare('id_parte_policial',$this->id_parte_policial);
		$criteria->compare('id_agente',$this->id_agente);
		$criteria->compare('fecha_parte',$this->fecha_parte,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}