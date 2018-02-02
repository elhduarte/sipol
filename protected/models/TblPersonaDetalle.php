<?php

/**
 * This is the model class for table "sipol.tbl_persona_detalle".
 *
 * The followings are the available columns in table 'sipol.tbl_persona_detalle':
 * @property integer $id_persona_detalle
 * @property integer $id_persona
 * @property integer $id_tipo_persona
 * @property integer $id_evento_detalle
 * @property integer $id_estado_persona
 */
class TblPersonaDetalle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblPersonaDetalle the static model class
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
		return 'sipol.tbl_persona_detalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_persona, id_tipo_persona, id_evento_detalle, id_estado_persona', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_persona_detalle, id_persona, id_tipo_persona, id_evento_detalle, id_estado_persona', 'safe', 'on'=>'search'),
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
			'id_persona_detalle' => 'Id Persona Detalle',
			'id_persona' => 'Id Persona',
			'id_tipo_persona' => 'Id Tipo Persona',
			'id_evento_detalle' => 'Id Evento Detalle',
			'id_estado_persona' => 'Id Estado Persona',
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

		$criteria->compare('id_persona_detalle',$this->id_persona_detalle);
		$criteria->compare('id_persona',$this->id_persona);
		$criteria->compare('id_tipo_persona',$this->id_tipo_persona);
		$criteria->compare('id_evento_detalle',$this->id_evento_detalle);
		$criteria->compare('id_estado_persona',$this->id_estado_persona);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}