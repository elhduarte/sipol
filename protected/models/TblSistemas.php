<?php

/**
 * This is the model class for table "catalogos_publicos.tbl_sistemas".
 *
 * The followings are the available columns in table 'catalogos_publicos.tbl_sistemas':
 * @property integer $id_sistema
 * @property string $descripcion
 * @property string $nombre_sistema
 */
class TblSistemas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblSistemas the static model class
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
		return 'catalogos_publicos.tbl_sistemas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion, nombre_sistema', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_sistema, descripcion, nombre_sistema', 'safe', 'on'=>'search'),
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
			'id_sistema' => 'Id Sistema',
			'descripcion' => 'Descripcion',
			'nombre_sistema' => 'Nombre Sistema',
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

		$criteria->compare('id_sistema',$this->id_sistema);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('nombre_sistema',$this->nombre_sistema,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}