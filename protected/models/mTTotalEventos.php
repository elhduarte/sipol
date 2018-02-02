<?php

/**
 * This is the model class for table "dg_pnc_novedades.t_total_eventos".
 *
 * The followings are the available columns in table 'dg_pnc_novedades.t_total_eventos':
 * @property integer $id_totales
 * @property integer $id_boleta
 * @property integer $id_evento
 * @property integer $cantidad
 * @property string $complemento
 */
class mTTotalEventos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return mTTotalEventos the static model class
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
		return 'dg_pnc_novedades.t_total_eventos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_boleta, id_evento, cantidad', 'numerical', 'integerOnly'=>true),
			array('complemento', 'length', 'max'=>120),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_totales, id_boleta, id_evento, cantidad, complemento', 'safe', 'on'=>'search'),
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
			'id_totales' => 'Id Totales',
			'id_boleta' => 'Id Boleta',
			'id_evento' => 'Id Evento',
			'cantidad' => 'Cantidad',
			'complemento' => 'Complemento',
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

		$criteria->compare('id_totales',$this->id_totales);
		$criteria->compare('id_boleta',$this->id_boleta);
		$criteria->compare('id_evento',$this->id_evento);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('complemento',$this->complemento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}