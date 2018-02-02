<?php

/**
 * This is the model class for table "sipol.tbl_agente".
 *
 * The followings are the available columns in table 'sipol.tbl_agente':
 * @property integer $id_agente
 * @property string $agente
 * @property integer $id_tipo_agente
 * @property integer $id_evento_detalle
 */
class TblAgente extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblAgente the static model class
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
		return 'sipol.tbl_agente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_agente, id_evento_detalle', 'numerical', 'integerOnly'=>true),
			array('agente', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_agente, agente, id_tipo_agente, id_evento_detalle', 'safe', 'on'=>'search'),
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
			'id_agente' => 'Id Agente',
			'agente' => 'Agente',
			'id_tipo_agente' => 'Id Tipo Agente',
			'id_evento_detalle' => 'Id Evento Detalle',
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

		$criteria->compare('id_agente',$this->id_agente);
		$criteria->compare('agente',$this->agente,true);
		$criteria->compare('id_tipo_agente',$this->id_tipo_agente);
		$criteria->compare('id_evento_detalle',$this->id_evento_detalle);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}