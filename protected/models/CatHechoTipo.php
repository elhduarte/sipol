<?php

/**
 * This is the model class for table "sipol_catalogos.cat_hecho_tipo".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_hecho_tipo':
 * @property integer $id_hecho_tipo
 * @property string $tipo
 */
class CatHechoTipo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatHechoTipo the static model class
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
		return 'sipol_catalogos.cat_hecho_tipo';
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
			array('id_hecho_tipo, tipo', 'safe', 'on'=>'search'),
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
			'id_hecho_tipo' => 'Id Hecho Tipo',
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

		$criteria->compare('id_hecho_tipo',$this->id_hecho_tipo);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getHechosTipo()
	{
		$devuelve = "";
		$contador = 0;
		$filtro = new CDbCriteria;
		$filtro->order = "tipo ASC";

		$datos = CHtml::listData($this->findAll($filtro),'id_hecho_tipo','tipo');

		foreach ($datos as $key => $value) {
			
			if($contador == '0'){
				$devuelve = CHtml::tag('option', array('value'=>'','style'=>'display:none;'),CHtml::encode('Seleccione un tipo de Hecho'),true);
				$devuelve = $devuelve.CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
			}
			else{
				$devuelve = $devuelve.CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
			}

			$contador = 1;
		}
	
		return $devuelve;
	}
}