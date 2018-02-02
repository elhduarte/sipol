<?php

/**
 * This is the model class for table "sipol_catalogos.cat_relaciones_tipo".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_relaciones_tipo':
 * @property integer $id_relaciones_tipo
 * @property string $tipo
 */
class CatRelacionesTipo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatRelacionesTipo the static model class
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
		return 'sipol_catalogos.cat_relaciones_tipo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_relaciones_tipo, tipo', 'safe', 'on'=>'search'),
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
			'id_relaciones_tipo' => 'Id Relaciones Tipo',
			'tipo' => 'Tipo',
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

		$criteria->compare('id_relaciones_tipo',$this->id_relaciones_tipo);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTipos()
	{
		$regresa="";
		$contador = 0;
		$Criteria = new CDbCriteria();
		$Criteria->order ='tipo ASC';
	    $data =  CHtml::listData(CatRelacionesTipo::model()->findAll($Criteria), 'id_relaciones_tipo','tipo');

		foreach ($data as $key => $value) 
		{
			if($contador =='0')
	           {
	           	$regresa = CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Tipo'),true);
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