<?php

/**
 * This is the model class for table "sipol.tbl_persona".
 *
 * The followings are the available columns in table 'sipol.tbl_persona':
 * @property integer $id_persona
 * @property string $llave_renap
 * @property string $cui
 * @property string $datos
 * @property string $foto
 * @property string $caracteristicas
 * @property string $datos_contacto
 * @property string $correo
 */
class TblPersona extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblPersona the static model class
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
		return 'sipol.tbl_persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('llave_renap, cui, correo', 'length', 'max'=>100),
			array('datos, foto, caracteristicas, datos_contacto', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_persona, llave_renap, cui, datos, foto, caracteristicas, datos_contacto, correo', 'safe', 'on'=>'search'),
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
			'id_persona' => 'Id Persona',
			'llave_renap' => 'Llave Renap',
			'cui' => 'Cui',
			'datos' => 'Datos',
			'foto' => 'Foto',
			'caracteristicas' => 'Caracteristicas',
			'datos_contacto' => 'Datos Contacto',
			'correo' => 'Correo',
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

		$criteria->compare('id_persona',$this->id_persona);
		$criteria->compare('llave_renap',$this->llave_renap,true);
		$criteria->compare('cui',$this->cui,true);
		$criteria->compare('datos',$this->datos,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('caracteristicas',$this->caracteristicas,true);
		$criteria->compare('datos_contacto',$this->datos_contacto,true);
		$criteria->compare('correo',$this->correo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}