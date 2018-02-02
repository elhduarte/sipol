<?php

/**
 * This is the model class for table "soporte_aplicaciones.tbl_buzon".
 *
 * The followings are the available columns in table 'soporte_aplicaciones.tbl_buzon':
 * @property integer $id_buzon
 * @property string $text_buzon
 * @property integer $id_usuario
 * @property boolean $estado
 * @property integer $id_usuario_envia
 */
class TblBuzon extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblBuzon the static model class
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
		return 'soporte_aplicaciones.tbl_buzon';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_usuario_envia', 'numerical', 'integerOnly'=>true),
			array('text_buzon, estado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_buzon, text_buzon, id_usuario, estado, id_usuario_envia', 'safe', 'on'=>'search'),
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
			'id_buzon' => 'Id Buzon',
			'text_buzon' => 'Text Buzon',
			'id_usuario' => 'Id Usuario',
			'estado' => 'Estado',
			'id_usuario_envia' => 'Id Usuario Envia',
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

		$criteria->compare('id_buzon',$this->id_buzon);
		$criteria->compare('text_buzon',$this->text_buzon,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('id_usuario_envia',$this->id_usuario_envia);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}