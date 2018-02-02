<?php

/**
 * This is the model class for table "soporte_aplicaciones.tbl_ticket_delete".
 *
 * The followings are the available columns in table 'soporte_aplicaciones.tbl_ticket_delete':
 * @property integer $id_ticket_delet
 * @property integer $id_ticket
 * @property integer $id_aplicacion
 * @property integer $id_modulo
 * @property integer $id_prioridad
 * @property integer $id_usuario
 * @property string $fecha_ingreso
 * @property string $hora_ingreso
 * @property boolean $estado
 * @property string $inconveniente
 * @property string $fecha_elimnado
 * @property string $hora_eliminado
 * @property integer $id_usuario_elimina
 * @property string $telefono
 */
class TblTicketDelete extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblTicketDelete the static model class
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
		return 'soporte_aplicaciones.tbl_ticket_delete';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ticket, id_aplicacion, id_modulo, id_prioridad, id_usuario, id_usuario_elimina', 'numerical', 'integerOnly'=>true),
			array('fecha_ingreso, hora_ingreso, estado, inconveniente, fecha_elimnado, hora_eliminado, telefono', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_ticket_delet, id_ticket, id_aplicacion, id_modulo, id_prioridad, id_usuario, fecha_ingreso, hora_ingreso, estado, inconveniente, fecha_elimnado, hora_eliminado, id_usuario_elimina, telefono', 'safe', 'on'=>'search'),
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
			'id_ticket_delet' => 'Id Ticket Delet',
			'id_ticket' => 'Id Ticket',
			'id_aplicacion' => 'Id Aplicacion',
			'id_modulo' => 'Id Modulo',
			'id_prioridad' => 'Id Prioridad',
			'id_usuario' => 'Id Usuario',
			'fecha_ingreso' => 'Fecha Ingreso',
			'hora_ingreso' => 'Hora Ingreso',
			'estado' => 'Estado',
			'inconveniente' => 'Inconveniente',
			'fecha_elimnado' => 'Fecha Elimnado',
			'hora_eliminado' => 'Hora Eliminado',
			'id_usuario_elimina' => 'Id Usuario Elimina',
			'telefono' => 'Telefono',
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

		$criteria->compare('id_ticket_delet',$this->id_ticket_delet);
		$criteria->compare('id_ticket',$this->id_ticket);
		$criteria->compare('id_aplicacion',$this->id_aplicacion);
		$criteria->compare('id_modulo',$this->id_modulo);
		$criteria->compare('id_prioridad',$this->id_prioridad);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);
		$criteria->compare('hora_ingreso',$this->hora_ingreso,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('inconveniente',$this->inconveniente,true);
		$criteria->compare('fecha_elimnado',$this->fecha_elimnado,true);
		$criteria->compare('hora_eliminado',$this->hora_eliminado,true);
		$criteria->compare('id_usuario_elimina',$this->id_usuario_elimina);
		$criteria->compare('telefono',$this->telefono,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}