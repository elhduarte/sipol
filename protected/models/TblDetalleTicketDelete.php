<?php

/**
 * This is the model class for table "soporte_aplicaciones.tbl_detalle_ticket_delete".
 *
 * The followings are the available columns in table 'soporte_aplicaciones.tbl_detalle_ticket_delete':
 * @property integer $id_detalle_ticket_delete
 * @property integer $id_detalle_ticket
 * @property integer $id_ticket
 * @property string $fecha_detalle
 * @property string $hora_atencion
 * @property integer $id_usuario
 * @property string $seguimiento
 */
class TblDetalleTicketDelete extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblDetalleTicketDelete the static model class
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
		return 'soporte_aplicaciones.tbl_detalle_ticket_delete';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_detalle_ticket, id_ticket, id_usuario', 'numerical', 'integerOnly'=>true),
			array('fecha_detalle, hora_atencion, seguimiento', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_detalle_ticket_delete, id_detalle_ticket, id_ticket, fecha_detalle, hora_atencion, id_usuario, seguimiento', 'safe', 'on'=>'search'),
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
			'id_detalle_ticket_delete' => 'Id Detalle Ticket Delete',
			'id_detalle_ticket' => 'Id Detalle Ticket',
			'id_ticket' => 'Id Ticket',
			'fecha_detalle' => 'Fecha Detalle',
			'hora_atencion' => 'Hora Atencion',
			'id_usuario' => 'Id Usuario',
			'seguimiento' => 'Seguimiento',
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

		$criteria->compare('id_detalle_ticket_delete',$this->id_detalle_ticket_delete);
		$criteria->compare('id_detalle_ticket',$this->id_detalle_ticket);
		$criteria->compare('id_ticket',$this->id_ticket);
		$criteria->compare('fecha_detalle',$this->fecha_detalle,true);
		$criteria->compare('hora_atencion',$this->hora_atencion,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('seguimiento',$this->seguimiento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}