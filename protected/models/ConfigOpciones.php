<?php

/**
 * This is the model class for table "sipol_catalogos.config_opciones".
 *
 * The followings are the available columns in table 'sipol_catalogos.config_opciones':
 * @property integer $id_opciones
 * @property string $qr_tbl_evento
 * @property string $png_web_dir_tbl_evento
 * @property string $urldenuncia_tbl_evento
 * @property string $body_letter_user
 * @property string $observations_letter_user
 * @property string $mensaje_ingreso
 * @property integer $estado_mensaje
 */
class ConfigOpciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConfigOpciones the static model class
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
		return 'sipol_catalogos.config_opciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado_mensaje', 'numerical', 'integerOnly'=>true),
			array('qr_tbl_evento, png_web_dir_tbl_evento, urldenuncia_tbl_evento', 'length', 'max'=>500),
			array('body_letter_user, observations_letter_user, mensaje_ingreso', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_opciones, qr_tbl_evento, png_web_dir_tbl_evento, urldenuncia_tbl_evento, body_letter_user, observations_letter_user, mensaje_ingreso, estado_mensaje', 'safe', 'on'=>'search'),
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
			'id_opciones' => 'Id Opciones',
			'qr_tbl_evento' => 'Qr Tbl Evento',
			'png_web_dir_tbl_evento' => 'Png Web Dir Tbl Evento',
			'urldenuncia_tbl_evento' => 'Urldenuncia Tbl Evento',
			'body_letter_user' => 'Body Letter User',
			'observations_letter_user' => 'Observations Letter User',
			'mensaje_ingreso' => 'Mensaje Ingreso',
			'estado_mensaje' => 'Estado Mensaje',
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

		$criteria->compare('id_opciones',$this->id_opciones);
		$criteria->compare('qr_tbl_evento',$this->qr_tbl_evento,true);
		$criteria->compare('png_web_dir_tbl_evento',$this->png_web_dir_tbl_evento,true);
		$criteria->compare('urldenuncia_tbl_evento',$this->urldenuncia_tbl_evento,true);
		$criteria->compare('body_letter_user',$this->body_letter_user,true);
		$criteria->compare('observations_letter_user',$this->observations_letter_user,true);
		$criteria->compare('mensaje_ingreso',$this->mensaje_ingreso,true);
		$criteria->compare('estado_mensaje',$this->estado_mensaje);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}