<?php

/**
 * This is the model class for table "catalogos_publicos.cat_paises".
 *
 * The followings are the available columns in table 'catalogos_publicos.cat_paises':
 * @property integer $id_pais
 * @property string $nombre_pais
 */
class CatPaises extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatPaises the static model class
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
		return 'catalogos_publicos.cat_paises';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_pais', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_pais, nombre_pais', 'safe', 'on'=>'search'),
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
			'id_pais' => 'Id Pais',
			'nombre_pais' => 'Nombre Pais',
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

		$criteria->compare('id_pais',$this->id_pais);
		$criteria->compare('nombre_pais',$this->nombre_pais,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function combo()
	{
		$Criteria = new CDbCriteria();
		$Criteria->order ='nombre_pais ASC';

			$data=CatPaises::model()->findAll($Criteria);

	       $data=CHtml::listData($data,'nombre_pais','nombre_pais');
	       
	       $contador = '0';
	       foreach($data as $value=>$name)
	       {
	           if($contador =='0')
	           {
	           	echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Pais'),true);
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }else
	           {
	           	
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

	           }
	        $contador = 1;
	       }
	}
}