<?php

/**
 * This is the model class for table "sipol_catalogos.cat_estado_persona".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_estado_persona':
 * @property integer $id_estado_persona
 * @property string $estado_persona
 */
class CatEstadoPersona extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatEstadoPersona the static model class
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
		return 'sipol_catalogos.cat_estado_persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado_persona', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_estado_persona, estado_persona', 'safe', 'on'=>'search'),
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
			'id_estado_persona' => 'Id Estado Persona',
			'estado_persona' => 'Estado Persona',
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

		$criteria->compare('id_estado_persona',$this->id_estado_persona);
		$criteria->compare('estado_persona',$this->estado_persona,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getEstadoFisico()
	{
		$regresa="";
		$contador = 0;
		$criterio = new CDbCriteria;
		$criterio->order ='estado_persona ASC';

	    $data =  CHtml::listData($this->findAll($criterio), 'id_estado_persona','estado_persona');

		foreach ($data as $key => $value) 
		{

			if($contador =='0')
	           {
	           	$regresa = CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione una Opción'),true);
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