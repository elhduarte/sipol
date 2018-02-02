<?php

/**
 * This is the model class for table "sipol_usuario.tbl_agenda".
 *
 * The followings are the available columns in table 'sipol_usuario.tbl_agenda':
 * @property integer $id_agenda
 * @property integer $id_usuario
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha
 * @property string $clase
 * @property string $url
 * @property string $inicio
 * @property string $final
 */
class TblAgenda extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblAgenda the static model class
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
		return 'sipol_usuario.tbl_agenda';
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
			array('titulo, descripcion, fecha, clase, url, inicio, final', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_agenda, id_usuario, titulo, descripcion, fecha, clase, url, inicio, final', 'safe', 'on'=>'search'),
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
			'id_agenda' => 'Id Agenda',
			'id_usuario' => 'Id Usuario',
			'titulo' => 'Titulo',
			'descripcion' => 'Descripcion',
			'fecha' => 'Fecha',
			'clase' => 'Clase',
			'url' => 'Url',
			'inicio' => 'Inicio',
			'final' => 'Final',
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

		$criteria->compare('id_agenda',$this->id_agenda);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('final',$this->final,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}