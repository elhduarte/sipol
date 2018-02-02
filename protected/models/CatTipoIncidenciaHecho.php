<?php

/**
 * This is the model class for table "sipol_catalogos.cat_denuncia".
 *
 * The followings are the available columns in table 'sipol_catalogos.cat_denuncia':
 * @property integer $id_tipo_incidencia
 * @property string $nombre_tipo_incidencia
 * @property string $h1
 * @property string $h2
 * @property string $h3
 * @property string $h4
 * @property string $h5
 * @property string $h6
 * @property string $h7
 * @property string $h8
 * @property string $h9
 * @property string $h10
 * @property string $h11
 * @property string $h12
 * @property string $h13
 * @property string $h14
 * @property string $h15
 * @property string $h16
 * @property string $h17
 * @property string $h18
 * @property string $h19
 * @property string $h20
 * @property string $h21
 * @property string $h22
 * @property string $h23
 * @property string $h24
 * @property string $h25
 * @property string $h26
 * @property string $h27
 * @property string $h28
 * @property string $h29
 * @property string $h30
 * @property string $h31
 * @property string $h32
 * @property string $h33
 * @property string $h34
 * @property string $h35
 * @property string $h36
 * @property string $h37
 * @property string $h38
 * @property string $h39
 * @property string $h40
 * @property string $h41
 * @property string $h42
 * @property string $h43
 * @property string $h44
 * @property string $h45
 * @property string $h46
 * @property string $h47
 * @property string $h48
 * @property string $h49
 * @property string $h50
 * @property integer $tipo_hecho
 */
class CatTipoIncidenciaHecho extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatTipoIncidenciaHecho the static model class
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
		return 'sipol_catalogos.cat_denuncia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_tipo_incidencia', 'required'),
			array('tipo_hecho', 'numerical', 'integerOnly'=>true),
			array('h1, h2, h3, h4, h5, h6, h7, h8, h9, h10, h11, h12, h13, h14, h15, h16, h17, h18, h19, h20, h21, h22, h23, h24, h25, h26, h27, h28, h29, h30, h31, h32, h33, h34, h35, h36, h37, h38, h39, h40, h41, h42, h43, h44, h45, h46, h47, h48, h49, h50', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tipo_incidencia, nombre_tipo_incidencia, h1, h2, h3, h4, h5, h6, h7, h8, h9, h10, h11, h12, h13, h14, h15, h16, h17, h18, h19, h20, h21, h22, h23, h24, h25, h26, h27, h28, h29, h30, h31, h32, h33, h34, h35, h36, h37, h38, h39, h40, h41, h42, h43, h44, h45, h46, h47, h48, h49, h50, tipo_hecho', 'safe', 'on'=>'search'),
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
			'id_tipo_incidencia' => 'Id Tipo Incidencia',
			'nombre_tipo_incidencia' => 'Nombre Tipo Incidencia',
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
			'h7' => 'H7',
			'h8' => 'H8',
			'h9' => 'H9',
			'h10' => 'H10',
			'h11' => 'H11',
			'h12' => 'H12',
			'h13' => 'H13',
			'h14' => 'H14',
			'h15' => 'H15',
			'h16' => 'H16',
			'h17' => 'H17',
			'h18' => 'H18',
			'h19' => 'H19',
			'h20' => 'H20',
			'h21' => 'H21',
			'h22' => 'H22',
			'h23' => 'H23',
			'h24' => 'H24',
			'h25' => 'H25',
			'h26' => 'H26',
			'h27' => 'H27',
			'h28' => 'H28',
			'h29' => 'H29',
			'h30' => 'H30',
			'h31' => 'H31',
			'h32' => 'H32',
			'h33' => 'H33',
			'h34' => 'H34',
			'h35' => 'H35',
			'h36' => 'H36',
			'h37' => 'H37',
			'h38' => 'H38',
			'h39' => 'H39',
			'h40' => 'H40',
			'h41' => 'H41',
			'h42' => 'H42',
			'h43' => 'H43',
			'h44' => 'H44',
			'h45' => 'H45',
			'h46' => 'H46',
			'h47' => 'H47',
			'h48' => 'H48',
			'h49' => 'H49',
			'h50' => 'H50',
			'tipo_hecho' => 'Tipo Hecho',
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

		$criteria->compare('id_tipo_incidencia',$this->id_tipo_incidencia);
		$criteria->compare('nombre_tipo_incidencia',$this->nombre_tipo_incidencia,true);
		$criteria->compare('h1',$this->h1,true);
		$criteria->compare('h2',$this->h2,true);
		$criteria->compare('h3',$this->h3,true);
		$criteria->compare('h4',$this->h4,true);
		$criteria->compare('h5',$this->h5,true);
		$criteria->compare('h6',$this->h6,true);
		$criteria->compare('h7',$this->h7,true);
		$criteria->compare('h8',$this->h8,true);
		$criteria->compare('h9',$this->h9,true);
		$criteria->compare('h10',$this->h10,true);
		$criteria->compare('h11',$this->h11,true);
		$criteria->compare('h12',$this->h12,true);
		$criteria->compare('h13',$this->h13,true);
		$criteria->compare('h14',$this->h14,true);
		$criteria->compare('h15',$this->h15,true);
		$criteria->compare('h16',$this->h16,true);
		$criteria->compare('h17',$this->h17,true);
		$criteria->compare('h18',$this->h18,true);
		$criteria->compare('h19',$this->h19,true);
		$criteria->compare('h20',$this->h20,true);
		$criteria->compare('h21',$this->h21,true);
		$criteria->compare('h22',$this->h22,true);
		$criteria->compare('h23',$this->h23,true);
		$criteria->compare('h24',$this->h24,true);
		$criteria->compare('h25',$this->h25,true);
		$criteria->compare('h26',$this->h26,true);
		$criteria->compare('h27',$this->h27,true);
		$criteria->compare('h28',$this->h28,true);
		$criteria->compare('h29',$this->h29,true);
		$criteria->compare('h30',$this->h30,true);
		$criteria->compare('h31',$this->h31,true);
		$criteria->compare('h32',$this->h32,true);
		$criteria->compare('h33',$this->h33,true);
		$criteria->compare('h34',$this->h34,true);
		$criteria->compare('h35',$this->h35,true);
		$criteria->compare('h36',$this->h36,true);
		$criteria->compare('h37',$this->h37,true);
		$criteria->compare('h38',$this->h38,true);
		$criteria->compare('h39',$this->h39,true);
		$criteria->compare('h40',$this->h40,true);
		$criteria->compare('h41',$this->h41,true);
		$criteria->compare('h42',$this->h42,true);
		$criteria->compare('h43',$this->h43,true);
		$criteria->compare('h44',$this->h44,true);
		$criteria->compare('h45',$this->h45,true);
		$criteria->compare('h46',$this->h46,true);
		$criteria->compare('h47',$this->h47,true);
		$criteria->compare('h48',$this->h48,true);
		$criteria->compare('h49',$this->h49,true);
		$criteria->compare('h50',$this->h50,true);
		$criteria->compare('tipo_hecho',$this->tipo_hecho);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}