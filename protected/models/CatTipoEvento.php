<?php

/**
 * This is the model class for table "sipol_catalogos.cat_tipo_evento".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_tipo_evento':
 * @property integer $id_tipo_evento
 * @property string $descripcion_evento
 */
class CatTipoEvento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatTipoEvento the static model class
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
		return 'sipol_catalogos.cat_tipo_evento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion_evento', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tipo_evento, descripcion_evento', 'safe', 'on'=>'search'),
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
			'id_tipo_evento' => 'Id Tipo Evento',
			'descripcion_evento' => 'Descripcion Evento',
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

		$criteria->compare('id_tipo_evento',$this->id_tipo_evento);
		$criteria->compare('descripcion_evento',$this->descripcion_evento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getEventos()
	{
		$devuelve = "";
		$contador = 0;
		$filtro = new CDbCriteria;
		$filtro->order = "descripcion_evento ASC";
		$filtro->condition = "id_tipo_evento <> 4";

		$datos = CHtml::listData($this->findAll($filtro),'id_tipo_evento','descripcion_evento');

		foreach ($datos as $key => $value) {
			
			if($contador == '0'){
				$devuelve = CHtml::tag('option', array('value'=>'','style'=>'display:none;'),CHtml::encode('Seleccione un Evento'),true);
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