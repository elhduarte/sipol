<?php

/**
 * This is the model class for table "sipol_catalogos.cat_motivo_incidencia".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_motivo_incidencia':
 * @property integer $id_motivo_incidencia
 * @property string $motivo_incidencia
 */
class CatMotivoIncidencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatMotivoIncidencia the static model class
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
		return 'sipol_catalogos.cat_motivo_incidencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('motivo_incidencia', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_motivo_incidencia, motivo_incidencia', 'safe', 'on'=>'search'),
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
			'id_motivo_incidencia' => 'Id Motivo Incidencia',
			'motivo_incidencia' => 'Motivo Incidencia',
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

		$criteria->compare('id_motivo_incidencia',$this->id_motivo_incidencia);
		$criteria->compare('motivo_incidencia',$this->motivo_incidencia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}