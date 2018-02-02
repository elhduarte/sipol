<?php

/**
 * This is the model class for table "soporte_aplicaciones.tbl_sugerencia".
 *
 * The followings are the available columns in table 'soporte_aplicaciones.tbl_sugerencia':
 * @property integer $id_sugerencia
 * @property string $fecha_ingreso
 * @property string $sugerencia
 * @property string $url_sugerencia
 * @property integer $id_usuario
 * @property string $hora_ingreso
 */
class TblSugerencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblSugerencia the static model class
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
		return 'soporte_aplicaciones.tbl_sugerencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('fecha_ingreso, sugerencia, url_sugerencia, hora_ingreso', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_sugerencia, fecha_ingreso, sugerencia, url_sugerencia, id_usuario, hora_ingreso', 'safe', 'on'=>'search'),
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
			'id_sugerencia' => 'Id Sugerencia',
			'fecha_ingreso' => 'Fecha Ingreso',
			'sugerencia' => 'Sugerencia',
			'url_sugerencia' => 'Url Sugerencia',
			'id_usuario' => 'Id Usuario',
			'hora_ingreso' => 'Hora Ingreso',
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

		$criteria->compare('id_sugerencia',$this->id_sugerencia);
		$criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);
		$criteria->compare('sugerencia',$this->sugerencia,true);
		$criteria->compare('url_sugerencia',$this->url_sugerencia,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('hora_ingreso',$this->hora_ingreso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function view_sugerencias()
	{
			$Criteria = new CDbCriteria();
			$Criteria->order ='fecha_ingreso ASC';
			$data=TblSugerencia::model()->findAll($Criteria);
			
			return $data;
	}
}