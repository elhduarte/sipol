<?php

/**
 * This is the model class for table "dg_pnc_novedades.t_hecho".
 *
 * The followings are the available columns in table 'dg_pnc_novedades.t_hecho':
 * @property integer $id_hecho
 * @property string $nombre_hecho
 * @property string $positivonegativo
 */
class mTHecho extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return mTHecho the static model class
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
		return 'dg_pnc_novedades.t_hecho';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_hecho', 'length', 'max'=>50),
			array('positivonegativo', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_hecho, nombre_hecho, positivonegativo', 'safe', 'on'=>'search'),
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
			'id_hecho' => 'Id Hecho',
			'nombre_hecho' => 'Nombre Hecho',
			'positivonegativo' => 'Positivonegativo',
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

		$criteria->compare('id_hecho',$this->id_hecho);
		$criteria->compare('nombre_hecho',$this->nombre_hecho,true);
		$criteria->compare('positivonegativo',$this->positivonegativo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}