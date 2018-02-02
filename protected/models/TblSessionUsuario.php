<?php

/**
 * This is the model class for table "sipol_usuario.tbl_session_usuario".
 *
 * The followings are the available columns in table 'sipol_usuario.tbl_session_usuario':
 * @property integer $id_session_usuario
 * @property string $id_usuario
 * @property string $fecha_ingreso
 * @property string $ip_ingreso
 * @property string $hora_ingreso
 * @property string $origen
 */
class TblSessionUsuario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblSessionUsuario the static model class
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
		return 'sipol_usuario.tbl_session_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip_ingreso', 'length', 'max'=>200),
			array('id_usuario, fecha_ingreso, hora_ingreso, origen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_session_usuario, id_usuario, fecha_ingreso, ip_ingreso, hora_ingreso, origen', 'safe', 'on'=>'search'),
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
			'id_session_usuario' => 'Id Session Usuario',
			'id_usuario' => 'Id Usuario',
			'fecha_ingreso' => 'Fecha Ingreso',
			'ip_ingreso' => 'Ip Ingreso',
			'hora_ingreso' => 'Hora Ingreso',
			'origen' => 'Origen',
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

		$criteria->compare('id_session_usuario',$this->id_session_usuario);
		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);
		$criteria->compare('ip_ingreso',$this->ip_ingreso,true);
		$criteria->compare('hora_ingreso',$this->hora_ingreso,true);
		$criteria->compare('origen',$this->origen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}