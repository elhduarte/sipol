<?php

/**
 * This is the model class for table "sipol_catalogos.cat_tipo_persona".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_tipo_persona':
 * @property integer $id_tipo_persona
 * @property string $descripcion_tipo_persona
 * @property integer $id_evento_tipo
 */
class CatTipoPersona extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatTipoPersona the static model class
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
		return 'sipol_catalogos.cat_tipo_persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_evento_tipo', 'numerical', 'integerOnly'=>true),
			array('descripcion_tipo_persona', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tipo_persona, descripcion_tipo_persona, id_evento_tipo', 'safe', 'on'=>'search'),
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
			'id_tipo_persona' => 'Id Tipo Persona',
			'descripcion_tipo_persona' => 'Descripcion Tipo Persona',
			'id_evento_tipo' => 'Id Evento Tipo',
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

		$criteria->compare('id_tipo_persona',$this->id_tipo_persona);
		$criteria->compare('descripcion_tipo_persona',$this->descripcion_tipo_persona,true);
		$criteria->compare('id_evento_tipo',$this->id_evento_tipo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPersonasIncidencia()
	{
		$regresa="";
		$contador = 0;
		$criterio = new CDbCriteria;
		$criterio->condition = "id_evento_tipo='2'";
		$criterio->order ='descripcion_tipo_persona ASC';

	    $data =  CHtml::listData($this->findAll($criterio), 'id_tipo_persona','descripcion_tipo_persona');

		foreach ($data as $key => $value) 
		{
			if($contador =='0')
	           {
	           	$regresa = CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione una Persona'),true);
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