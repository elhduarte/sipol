<?php

/**
 * This is the model class for table "sipol_usuario.cat_rol".
 *
 * The followings are the available columns in table 'sipol_usuario.cat_rol':
 * @property integer $id_rol
 * @property string $nombre_rol
 * @property string $permisos
 * @property integer $id_sistema
 * @property string $permisos_entidad
 * @property string $permisos_rol
 */
class CatRol extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatRol the static model class
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
		return 'sipol_usuario.cat_rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_sistema', 'numerical', 'integerOnly'=>true),
			array('nombre_rol, permisos, permisos_entidad, permisos_rol', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_rol, nombre_rol, permisos, id_sistema, permisos_entidad, permisos_rol', 'safe', 'on'=>'search'),
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
			'id_rol' => 'Id Rol',
			'nombre_rol' => 'Nombre Rol',
			'permisos' => 'Permisos',
			'id_sistema' => 'Id Sistema',
			'permisos_entidad' => 'Permisos Entidad',
			'permisos_rol' => 'Permisos Rol',
		);
	}

	public function loadModel($id)
	{
		$model=CatRol::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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

		$criteria->compare('id_rol',$this->id_rol);
		$criteria->compare('nombre_rol',$this->nombre_rol,true);
		$criteria->compare('permisos',$this->permisos,true);
		$criteria->compare('id_sistema',$this->id_sistema);
		$criteria->compare('permisos_entidad',$this->permisos_entidad,true);
		$criteria->compare('permisos_rol',$this->permisos_rol,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function crearcomborol($rol)
	{
			/*hace las funciones para evaluar que tiene el campo de asignacion del rol*/
			$Criteria = new CDbCriteria();
			$Criteria->condition = "id_rol =".$rol."";
			$Criteria->order ='id_rol ASC';
			$data=CatRol::model()->findAll($Criteria);
			$data=CHtml::listData($data,'id_rol','permisos_rol');
			$valor = "";
				foreach($data as $value=>$name)
				{
					$valor = $valor.$name; 
				} 
				$Criteria = new CDbCriteria();
				$Criteria->condition = "id_rol IN(".$valor.")";
				$Criteria->order ='id_rol ASC';
				$data=CatRol::model()->findAll($Criteria);
				$data=CHtml::listData($data,'id_rol','nombre_rol');
			return $data;
	}
}