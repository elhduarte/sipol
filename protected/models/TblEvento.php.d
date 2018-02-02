<?php

/**
 * This is the model class for table "sipol.tbl_evento".
 *
 * The followings are the available columns in table 'sipol.tbl_evento':
 * @property integer $id_evento
 * @property integer $id_tipo_evento
 * @property string $relato_denuncia
 * @property string $direccion
 * @property string $evento_num
 * @property boolean $estado
 * @property string $fecha_ingreso
 * @property string $hora_ingreso
 * @property integer $id_usuario
 * @property integer $id_sede
 * @property integer $id_evento_extiende
 * @property string $the_geom
 * @property string $denuncia_mp
 */
class TblEvento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblEvento the static model class
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
		return 'sipol.tbl_evento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_evento, id_usuario, id_sede, id_evento_extiende', 'numerical', 'integerOnly'=>true),
			array('evento_num', 'length', 'max'=>20),
			array('relato_denuncia, direccion, estado, fecha_ingreso, hora_ingreso, the_geom, denuncia_mp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_evento, id_tipo_evento, relato_denuncia, direccion, evento_num, estado, fecha_ingreso, hora_ingreso, id_usuario, id_sede, id_evento_extiende, the_geom, denuncia_mp', 'safe', 'on'=>'search'),
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
			'id_evento' => 'Id Evento',
			'id_tipo_evento' => 'Id Tipo Evento',
			'relato_denuncia' => 'Relato Denuncia',
			'direccion' => 'Direccion',
			'evento_num' => 'Evento Num',
			'estado' => 'Estado',
			'fecha_ingreso' => 'Fecha Ingreso',
			'hora_ingreso' => 'Hora Ingreso',
			'id_usuario' => 'Id Usuario',
			'id_sede' => 'Id Sede',
			'id_evento_extiende' => 'Id Evento Extiende',
			'the_geom' => 'The Geom',
			'denuncia_mp' => 'Denuncia Mp',
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

		$criteria->compare('id_evento',$this->id_evento);
		$criteria->compare('id_tipo_evento',$this->id_tipo_evento);
		$criteria->compare('relato_denuncia',$this->relato_denuncia,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('evento_num',$this->evento_num,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);
		$criteria->compare('hora_ingreso',$this->hora_ingreso,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_sede',$this->id_sede);
		$criteria->compare('id_evento_extiende',$this->id_evento_extiende);
		$criteria->compare('the_geom',$this->the_geom,true);
		$criteria->compare('denuncia_mp',$this->denuncia_mp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function fgrid($tipo,$fecha_ini,$fecha_fin,$estado,$depto,$mupio,$comisaria,$evento_num,$tipo_sede,$sede,$tipo_hecho,$hecho,$distrito)
	{
		if($tipo == "empty" || empty($tipo)) $tipo ="1";
		if($fecha_ini=="empty" )
    	{
    		$cond_fecha = " ";
    	}elseif ($fecha_ini=="" ) {
    		# code...
    		$cond_fecha = " ";
    	}else 
    	{
    		$cond_fecha = "AND e.fecha_ingreso BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'";
    	}


    		if($estado=='1')
    		{
    			$cond_estado = "AND e.estado = true";
    		} elseif($estado == '2')
    		{
    			$cond_estado = "AND e.estado = false";
    		} else 
    		{
    			$cond_estado =" ";
    		}

    		if($depto=='Todos' || $depto=='')
    	{
    		$cond_depto = " ";
    	}
    	else
    	{
    		$cond_depto = "AND e.direccion LIKE '%\"Departamento\":\"".$depto."\"%'";
    	}


    		if($mupio=='Seleccione Un Municipio' || $mupio=='')
    	{
    		$cond_mupio = " ";
    	}
    	else
    	{
    		$cond_mupio = "AND e.direccion LIKE '%\"Municipio\":\"".$mupio."\"%'";
    	}

    	if ($distrito == 0)
    	{
    		$cond_comisaria = '';
    	} else 
    	{
    		if ($comisaria=='')
    		{
    			$cond_comisaria = 'where id_cat_entidad IN (select id_cat_entidad from catalogos_publicos.cat_entidad WHERE distrito ='.$distrito.')';	
    		}
    		else
    		{
    			$cond_comisaria = 'where id_cat_entidad ='.$comisaria;
    		}
    		
    	}
		if ($tipo_sede == 0)
    	{
    		$cond_tipo_sede = '';
    	} else 
    	{
    		$cond_tipo_sede = 'AND id_tipo_sede ='.$tipo_sede;
    	}
    	if ($sede == 0)
    	{
    		$sede = '';
    	} else 
    	{
    		$sede = 'AND id_sede ='.$sede;
    	}

    	if ($evento_num == "")
    	{
    		$cond_evento = '';
    	} else 
    	{
    		$cond_evento = "AND e.evento_num = '".$evento_num."'";
    	}
    	if ($tipo_hecho == "")
    	{
    		$cond_tipo_hecho = '';
    	} else 
    	{
    		$cond_tipo_hecho = 'where id_hecho_tipo ='.$tipo_hecho;
    	}
    	if ($hecho == "")
    	{
    		$cond_hecho = '';
    	} else 
    	{
    		$cond_hecho = 'AND id_hecho_denuncia ='.$hecho;
    	}
		$sql = 
		"SELECT 
			e.evento_num,
			e.id_tipo_evento,
			e.direccion,
			e.fecha_ingreso, 
			e.estado,
			u.usuario,
			ce.nombre_entidad,
			ts.descripcion||'-'||en.nombre as nombre,			
			array_to_string(array_agg(h.nombre_hecho), ', ') as hechos,
			e.id_sede,
			e.relato_denuncia,
			e.id_evento 
		FROM 	sipol_usuario.tbl_usuario u, 
			catalogos_publicos.tbl_sede en,
			catalogos_publicos.cat_entidad ce,
			catalogos_publicos.cat_tipo_sede ts,
			sipol.tbl_evento e
		LEFT JOIN sipol.tbl_evento_detalle ed ON e.id_evento = ed.id_evento
		LEFT JOIN sipol_catalogos.cat_hecho_denuncia h ON h.id_hecho_denuncia = ed.id_hecho_denuncia
		WHERE u.id_usuario = e.id_usuario
		AND e.direccion IS NOT NULL
		AND ed.id_hecho_denuncia IN (SELECT id_hecho_denuncia FROM  sipol_catalogos.cat_hecho_denuncia ".$cond_tipo_hecho." ".$cond_hecho.")
		AND e.id_sede = en.id_sede
		AND en.id_sede IN (select id_sede from catalogos_publicos.tbl_sede ".$cond_comisaria." ".$cond_tipo_sede." ".$sede.")
		AND en.id_tipo_sede = ts.id_tipo_sede
		AND en.id_cat_entidad = ce.id_cat_entidad
		AND e.estado = true
		AND e.id_tipo_evento IN (".$tipo.")

		".$cond_fecha."
		".$cond_estado."
		".$cond_depto."
		".$cond_mupio."

		".$cond_evento."

		GROUP BY e.id_evento, u.usuario, en.nombre, ce.nombre_entidad, ts.descripcion 
		ORDER BY e.fecha_ingreso desc";
		// FIN Se arma el query para el data provider



		//INICIO Conexión a la base de datos y ejecución del query
		$connection=Yii::app()->db;
		$encrip = new Encrypter;

		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$a=array();
		$num = "1";

		foreach($dataReader as $row)
		{
			$id_evento  = $row['id_evento'];
			$evento_num = $row['evento_num'];
			$id_tipo_evento= $row['id_tipo_evento'];
			$id_usuario = $row['usuario'];
			$direccion = $row['direccion'];
			$relato_denuncia = strip_tags($row['relato_denuncia']);
			$fecha_ingreso = $row['fecha_ingreso'];
			$estado = $row['estado'];
			$id_sede = $row['id_sede'];
			$comisaria = $row['nombre_entidad'];
			$sede = $row['nombre'];
			$hechos = $row['hechos'];

			if ($estado==1)
			{
				$estado = "Confirmada";
			}
			else
			{
				$estado="Pendiente";
			}

			if($id_tipo_evento==1)
			{
				$id_tipo_evento="Denuncia";	
			}
			elseif ($id_tipo_evento== 2)
			{
				$id_tipo_evento="Incidencia";
			} elseif ($id_tipo_evento== 3) 
			{
				$id_tipo_evento="Extravio";

			}

			$u = json_decode($direccion);

			if($direccion=="")
			{
				$depto = "";
				$mupio = "";
			}
			else
			{
				$depto = $u->Departamento;
				$mupio = $u->Municipio;
			}
			$id_evento1 = $encrip->compilarget("'".$id_evento."'");
			$a[]=array(
			"num"=>$num++, 
			"id_evento"=>$id_evento1,
			"evento_num"=>$evento_num,
			"id_tipo_evento"=>$id_tipo_evento,
			"id_usuario"=>$id_usuario,
			"departamento"=>$depto,
			"municipio"=>$mupio,
			//"direccion"=>$direccion, 
			"relato_denuncia"=>$relato_denuncia, 
			"fecha_ingreso"=>$fecha_ingreso, 
			"estado"=>$estado,
			"id_sede"=>$id_sede,
			"comisaria"=>$comisaria,
			"sede"=>$sede,
			"hechos"=>$hechos
			);
			
		}
			echo "<div id='consulta' style='display:none;'>";	
			echo Encrypter::encrypt($sql);
			echo "</div>";
		
		return new CArrayDataProvider($a, array(
		'id'=>'ranking_1',
		'keyField' => 'id_evento',
		'pagination'=>array(
			'pageSize'=>10,
			//'route'=>'CTblEvento/grilla_incidencia&ajax=grid_tedst'

			),
		));
	}

}