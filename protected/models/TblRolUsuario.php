<?php

/**
 * This is the model class for table "sipol_usuario.tbl_rol_usuario".
 *
 * The followings are the available columns in table 'sipol_usuario.tbl_rol_usuario':
 * @property integer $id_rol_usuario
 * @property integer $id_usuario
 * @property integer $id_rol
 * @property integer $id_sede
 */
class TblRolUsuario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblRolUsuario the static model class
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
		return 'sipol_usuario.tbl_rol_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_rol, id_sede', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_rol_usuario, id_usuario, id_rol, id_sede', 'safe', 'on'=>'search'),
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
			'id_rol_usuario' => 'Id Rol Usuario',
			'id_usuario' => 'Id Usuario',
			'id_rol' => 'Id Rol',
			'id_sede' => 'Id Sede',
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

		$criteria->compare('id_rol_usuario',$this->id_rol_usuario);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_rol',$this->id_rol);
		$criteria->compare('id_sede',$this->id_sede);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}