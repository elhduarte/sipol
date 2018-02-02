<?php

/**
 * This is the model class for table "dg_pnc_novedades.t_evento".
 *
 * The followings are the available columns in table 'dg_pnc_novedades.t_evento':
 * @property integer $id_evento
 * @property integer $id_hecho
 * @property string $nombre_evento
 */
class mTEvento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return mTEvento the static model class
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
		return 'dg_pnc_novedades.t_evento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_hecho', 'numerical', 'integerOnly'=>true),
			array('nombre_evento', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_evento, id_hecho, nombre_evento', 'safe', 'on'=>'search'),
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
			'id_evento' => 'Id Evento',
			'id_hecho' => 'Id Hecho',
			'nombre_evento' => 'Nombre Evento',
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

		$criteria->compare('id_evento',$this->id_evento);
		$criteria->compare('id_hecho',$this->id_hecho);
		$criteria->compare('nombre_evento',$this->nombre_evento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}