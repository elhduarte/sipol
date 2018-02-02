<?php

/**
 * This is the model class for table "sipol.tbl_evento_detalle".
 *
 * The followings are the available columns in table 'sipol.tbl_evento_detalle':
 * @property integer $id_evento_detalle
 * @property integer $id_evento
 * @property integer $id_hecho_denuncia
 * @property string $atributos
 * @property string $novedad_relacionada
 * @property string $fecha_evento
 * @property string $hora_evento
 * @property string $motivo
 * @property integer $id_motivo_consignados
 * @property integer $id_lugar_remision
 * @property string $atributos_lugar_remision
 * @property integer $id_tipo_incidencia
 * @property integer $id_motivo_incidencia
 */
class TblEventoDetalle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblEventoDetalle the static model class
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
		return 'sipol.tbl_evento_detalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_evento, id_hecho_denuncia, id_motivo_consignados, id_lugar_remision, id_tipo_incidencia, id_motivo_incidencia', 'numerical', 'integerOnly'=>true),
			array('atributos_lugar_remision', 'length', 'max'=>100),
			array('atributos, novedad_relacionada, fecha_evento, hora_evento, motivo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_evento_detalle, id_evento, id_hecho_denuncia, atributos, novedad_relacionada, fecha_evento, hora_evento, motivo, id_motivo_consignados, id_lugar_remision, atributos_lugar_remision, id_tipo_incidencia, id_motivo_incidencia', 'safe', 'on'=>'search'),
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
			'id_evento_detalle' => 'Id Evento Detalle',
			'id_evento' => 'Id Evento',
			'id_hecho_denuncia' => 'Id Hecho Denuncia',
			'atributos' => 'Atributos',
			'novedad_relacionada' => 'Novedad Relacionada',
			'fecha_evento' => 'Fecha Evento',
			'hora_evento' => 'Hora Evento',
			'motivo' => 'Motivo',
			'id_motivo_consignados' => 'Id Motivo Consignados',
			'id_lugar_remision' => 'Id Lugar Remision',
			'atributos_lugar_remision' => 'Atributos Lugar Remision',
			'id_tipo_incidencia' => 'Id Tipo Incidencia',
			'id_motivo_incidencia' => 'Id Motivo Incidencia',
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

		$criteria->compare('id_evento_detalle',$this->id_evento_detalle);
		$criteria->compare('id_evento',$this->id_evento);
		$criteria->compare('id_hecho_denuncia',$this->id_hecho_denuncia);
		$criteria->compare('atributos',$this->atributos,true);
		$criteria->compare('novedad_relacionada',$this->novedad_relacionada,true);
		$criteria->compare('fecha_evento',$this->fecha_evento,true);
		$criteria->compare('hora_evento',$this->hora_evento,true);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('id_motivo_consignados',$this->id_motivo_consignados);
		$criteria->compare('id_lugar_remision',$this->id_lugar_remision);
		$criteria->compare('atributos_lugar_remision',$this->atributos_lugar_remision,true);
		$criteria->compare('id_tipo_incidencia',$this->id_tipo_incidencia);
		$criteria->compare('id_motivo_incidencia',$this->id_motivo_incidencia);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}