<?php

/**
 * This is the model class for table "sipol.tbl_objetos".
 *
 * The followings are the available columns in table 'sipol.tbl_objetos':
 * @property integer $id_objeto
 * @property integer $id_tipo_objeto
 * @property string $atributos
 * @property integer $id_evento_detalle
 * @property integer $id_calificacion_objeto
 */
class TblObjetos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblObjetos the static model class
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
		return 'sipol.tbl_objetos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_objeto, id_evento_detalle, id_calificacion_objeto', 'numerical', 'integerOnly'=>true),
			array('atributos', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_objeto, id_tipo_objeto, atributos, id_evento_detalle, id_calificacion_objeto', 'safe', 'on'=>'search'),
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
			'id_objeto' => 'Id Objeto',
			'id_tipo_objeto' => 'Id Tipo Objeto',
			'atributos' => 'Atributos',
			'id_evento_detalle' => 'Id Evento Detalle',
			'id_calificacion_objeto' => 'Id Calificacion Objeto',
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

		$criteria->compare('id_objeto',$this->id_objeto);
		$criteria->compare('id_tipo_objeto',$this->id_tipo_objeto);
		$criteria->compare('atributos',$this->atributos,true);
		$criteria->compare('id_evento_detalle',$this->id_evento_detalle);
		$criteria->compare('id_calificacion_objeto',$this->id_calificacion_objeto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}