<?php

class MapaController extends Controller
{

	public function actiongetMupios()
	{

		$Criteria = new CDbCriteria();
		$Criteria->condition = 'cod_depto='.$_POST['param'];
		$Criteria->order ='municipio ASC';

			$data=CatMunicipios::model()->findAll($Criteria);

	       $data=CHtml::listData($data,'cod_mupio','municipio','getBoundMupio');
	       echo CHtml::tag('option', array('value'=>'fds'),CHtml::encode('Todos'),true);
	       $contador = '0';
	       foreach($data as $value=>$name)
	       {
	           if($contador =='0')
	           {
	           	echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Municipio'),true);
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }else
	           {
	           	
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

	           }
	        $contador = 1;
	       }
	}

   public function actiongetBoundDepto()
   {
	   if(isset($_POST['data']))
	   {
		$data = $_POST['data'];
	    $sql = 'SELECT * FROM catalogos_publicos.cat_departamentos where cod_depto = '.$data.'' ;
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$dataReader =$command->query();
			/**---------------------------------- Variable String que almacenara el json creado */
			
			foreach($dataReader as $row)
			{	
			echo $row['bbox'];
			}	
	   }   
   }

	public function actiongetBoundMupio()
	{
		if(isset($_POST['data']))
		{
		$data = $_POST['data'];
		$sql = 'SELECT * FROM catalogos_publicos.cat_municipios where cod_mupio = '.$data.'' ;
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$dataReader =$command->query();
			/**---------------------------------- Variable String que almacenara el json creado */
			
			foreach($dataReader as $row)
			{	
			echo $row['bbox'];
			}	
		}
	}

	public function actionBusca_lugar()
	{
	 if(isset($_POST['name']))
			$name=$_POST['name'];		
					//echo '[{"gid": 8,"campo_busq": "--RABINAL - Municipio","bbox": "-10084532,1688097.25,-10064646,1720283.375","mupio": null,"departamento": null}]';
			$row = Yii::app()->db->createCommand()
			    ->select("gid,
			 campo_busq,
			  st_xmin(the_geom) ||','|| st_ymin(the_geom) ||','||   st_xmax(the_geom) ||','||   st_ymax(the_geom) as bbox,
			  municipio as mupio,
			  departamento")
			    ->from("modulos_geoportal.toponimia")
			    ->where("campo_busq ILIKE '%".$name."%' ORDER BY campo_busq")
			    ->queryAll();
				
				/**************/
				
				echo json_encode($row);
					
	}

	public function actionBuscarDepto()
	{
		$depto = $_POST['depto'];
		$mupio = $_POST['mupio'];
			$row = Yii::app()->db->createCommand()
			->select("a.cod_depto,b.cod_mupio")
			->from("catalogos_publicos.cat_departamentos a, catalogos_publicos.cat_municipios b")
			->where("a.departamento ILIKE '%".$depto."%' and b.municipio ILIKE '%".$mupio."%'")
			->queryAll();

			echo json_encode($row);

	}

	public function actionPointDepto()
	{
		if(isset($_POST['point']))
		{
		$point = $_POST['point'];
		$command = Yii::app()->db->createCommand()
		->select("cod_depto,cod_mupio")
		->from("(select mupio.cod_depto,mupio.cod_mupio,ST_Contains(mupio.the_geom, ST_SetSRID('".$point."',900913)) as contains from catalogos_publicos.cat_municipios mupio) as punto")
		->where("punto.contains = 't'")
		->queryAll();
		
		foreach($command as $row)
			{	
			echo $row['cod_depto']."|".$row['cod_mupio'];
			}	
		}
	}

	public function actionIntoMupio()
	{
		if(isset($_POST['point']) && isset($_POST['depto']))
		{
			$point = $_POST['point'];
			$depto = $_POST['depto'];
			$command = Yii::app()->db->createCommand()
			->select("ST_Contains(municipio.the_geom, ST_SetSRID('".$point."',900913)) as contains")
			->from("catalogos_publicos.cat_municipios municipio")
			->where("cod_mupio = ".$depto)
			->queryAll();
			
			foreach($command as $row)
				{	
				echo $row['contains'];
				}	
		}
	}

}

?>