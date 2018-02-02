<?php

/**
 * This is the model class for table "dg_pnc_novedades.t_comisaria".
 *
 * The followings are the available columns in table 'dg_pnc_novedades.t_comisaria':
 * @property integer $id_comisaria
 * @property integer $numero_comisaria
 * @property string $nombre_comisaria
 * @property integer $distrito
 * @property string $region
 * @property string $municipio
 * @property string $departamento
 */
class mTComisaria extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return mTComisaria the static model class
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
		return 'dg_pnc_novedades.t_comisaria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_comisaria', 'required'),
			array('id_comisaria, numero_comisaria, distrito', 'numerical', 'integerOnly'=>true),
			array('nombre_comisaria', 'length', 'max'=>100),
			array('region, municipio, departamento', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_comisaria, numero_comisaria, nombre_comisaria, distrito, region, municipio, departamento', 'safe', 'on'=>'search'),
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
			'id_comisaria' => 'Id Comisaria',
			'numero_comisaria' => 'Numero Comisaria',
			'nombre_comisaria' => 'Nombre Comisaria',
			'distrito' => 'Distrito',
			'region' => 'Region',
			'municipio' => 'Municipio',
			'departamento' => 'Departamento',
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

		$criteria->compare('id_comisaria',$this->id_comisaria);
		$criteria->compare('numero_comisaria',$this->numero_comisaria);
		$criteria->compare('nombre_comisaria',$this->nombre_comisaria,true);
		$criteria->compare('distrito',$this->distrito);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('municipio',$this->municipio,true);
		$criteria->compare('departamento',$this->departamento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}