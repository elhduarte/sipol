<?php

/**
 * This is the model class for table "sipol_catalogos.cat_instituciones".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_instituciones':
 * @property integer $id_institucion
 * @property string $institucion
 */
class CatInstituciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatInstituciones the static model class
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
		return 'sipol_catalogos.cat_instituciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('institucion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_institucion, institucion', 'safe', 'on'=>'search'),
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
			'id_institucion' => 'Id Institucion',
			'institucion' => 'Institucion',
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

		$criteria->compare('id_institucion',$this->id_institucion);
		$criteria->compare('institucion',$this->institucion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getInstituciones()
	{
		$regresa="";
		$contador = 0;
		$Criteria = new CDbCriteria();
		$Criteria->order ='institucion ASC';
	    $data =  CHtml::listData(CatInstituciones::model()->findAll($Criteria), 'id_institucion','institucion');

		foreach ($data as $key => $value) 
		{

			if($contador =='0')
	           {
	           	$regresa = CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione una Institución'),true);
	           	$regresa = $regresa.CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
	           }else
	           {
	           	$regresa = $regresa.CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
	           }
	    $contador = 1;
		}

		return $regresa;
	}
}