<?php

/**
 * This is the model class for table "sipol.tbl_patrullas".
 *
 * The followings are the available columns in table 'sipol.tbl_patrullas':
 * @property integer $id_patrulla
 * @property integer $id_evento_detalle
 * @property string $patrulla
 */
class TblPatrullas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblPatrullas the static model class
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
		return 'sipol.tbl_patrullas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_evento_detalle', 'required'),
			array('id_evento_detalle', 'numerical', 'integerOnly'=>true),
			array('patrulla', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_patrulla, id_evento_detalle, patrulla', 'safe', 'on'=>'search'),
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
			'id_patrulla' => 'Id Patrulla',
			'id_evento_detalle' => 'Id Evento Detalle',
			'patrulla' => 'Patrulla',
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

		$criteria->compare('id_patrulla',$this->id_patrulla);
		$criteria->compare('id_evento_detalle',$this->id_evento_detalle);
		$criteria->compare('patrulla',$this->patrulla,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}