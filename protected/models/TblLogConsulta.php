<?php

/**
 * This is the model class for table "sipol_usuario.tbl_log_consulta".
 *
 * The followings are the available columns in table 'sipol_usuario.tbl_log_consulta':
 * @property integer $id_log_consulta
 * @property integer $id_servicio
 * @property string $origen
 * @property integer $id_usuario
 * @property string $fecha
 * @property string $consulta
 */
class TblLogConsulta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblLogConsulta the static model class
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
		return 'sipol_usuario.tbl_log_consulta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_servicio, id_usuario', 'numerical', 'integerOnly'=>true),
			array('origen', 'length', 'max'=>150),
			array('fecha, consulta', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_log_consulta, id_servicio, origen, id_usuario, fecha, consulta', 'safe', 'on'=>'search'),
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
			'id_log_consulta' => 'Id Log Consulta',
			'id_servicio' => 'Id Servicio',
			'origen' => 'Origen',
			'id_usuario' => 'Id Usuario',
			'fecha' => 'Fecha',
			'consulta' => 'Consulta',
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

		$criteria->compare('id_log_consulta',$this->id_log_consulta);
		$criteria->compare('id_servicio',$this->id_servicio);
		$criteria->compare('origen',$this->origen,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('consulta',$this->consulta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}