<?php
include("funciones.php");
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	var $dpi = '';
	var $nombres_schema_sapo = '';
	var $nombres_schema_bi = '';
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	//funcion que hace loguout y borra sesion
	var $id;
	var $sesion;
	var $username;
	var $nombres='';
	var $nombre2='';
	var $apellidos='';
	var $apellido2='';
	var $fecha_nacimiento='';
	var $datos_arreglo_detalle=array();
	var $arreglo_renap=array();
	var $id_ciudadano_renap=0;
	var $sede_indice=0;
	var $id_opcion=0;
	var $primer_nombre='';
	var $segundo_nombre='';
	var $tercer_nombre='';
	var $primer_apellido='';
	var $segundo_apellido='';
	var $apellido_casada='';
	var $senias_particulares='';
	var $amputaciones='';
	var $peso='';
	var $estatura='';
	var $orden_cedula='';
	var $registro_cedula='';
	var $cod_depto_cedula='';
	var $cod_muni_cedula='';
	var $direc_calle='';
	var $direc_num_inmueble='';
	var $direc_ave='';
	var $direc_barrio='';
	var $direc_zona='';
	var $direc_cod_depto='';
	var $direc_cod_munic='';
	var $cod_depto_nacimiento='';
	var $cod_munic_nacimiento='';
	var $lugar_nacimiento='';
	var $cod_nacionalidad='';
	var $nombre_padre='';
	var $nombre_madre='';
	var $apodos='';
	var $fallecido='';
	var $fecha_defuncion='';
	var $pais_emision_pasaporte='';
	var $num_pasaporte='';
	var $profesion='';
	var $estado_civil='';
	var $genero='';
	var $estado_captura_persona='';
	var $id_orden_captura_persona=0;
	var $telefonema='';
	var $foto='';
	var $id_ciudadano_anonimo=0;
	var $fh_ingreso='';
	var $fh_ultima_mod='';
	var $usuario_ingreso='';
	var $usuario_ultima_mod='';
	var $madre_primer_nombre='';
	var $madre_segundo_nombre='';
	var $madre_tercer_nombre='';
	var $madre_primer_apellido='';
	var $madre_segundo_apellido='';
	var $madre_apellido_casada='';
	var $padre_primer_nombre='';
	var $padre_segundo_nombre='';
	var $padre_tercer_nombre='';
	var $padre_primer_apellido='';
	var $padre_segundo_apellido='';
	var $munic_cedula='';
	var $reg_nac='';
	var $primer_nombre_sndex='';
	var $segundo_nombre_sndex='';
	var $tercer_nombre_sndex='';
	var $primer_apellido_sndex='';
	var $segundo_apellido_sndex='';
	var $apellido_casada_sndex='';
	var $tooltip_i=0;
	var $tooltip_si=0;
	var $tooltip_r=0;
	var $tooltip_fc=0;
	var $tiene_rojo=0;


public function Logout()
	{
			$user = Yii::app()->user->name;

			/* se extrae el id del usuario en sesion activa */
			$conn = Yii::app()->db->createCommand();
			$conn->setFetchMode(PDO::FETCH_OBJ);

			$conn->select('*')
				 ->from('sapo_autentica.sapoat_usuario_t')
				 ->where('usuario=:usuario', array(':usuario'=>$user))
				 ->order('id_usuario desc')
				 ->limit('1');
		foreach($conn->queryAll() as $data){
			$id = $data->id_usuario;
		}

		/* si el id esta vacio, redirecciona al home*/
		if($this->id == null){
			$this->redirect(Yii::app()->homeUrl);
		}

		$ip =Yii::app()->request->userHostAddress;

		/* Guarda el logout del usuario  */
		/* accion: login=1 logout=2  fuera por que sesion no es igual=3*/
		$model = new log();
		$model->id_sesion_activa=Yii::app()->getSession()->get('sesion');
		$model->fecha_hora_sesion='NOW';
		$model->ip=$ip;
		$model->id_usuario=$id;
		$model->accion='3';
		$model->fh_ultima_mod='NOW';
		$model->usuario_ultima_mod=$id;
		$model->insert();

		/* query donde elimina la sesion activa del usuario a realizar logout */
		$borrado = sesion::model()->findByAttributes(array('id_sesion_activa'=>Yii::app()->getSession()->get('sesion')));
		if($borrado!==NULL){
			$borrado->delete();
		}

		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
//--------------------FUNCIONALIDADES GENERALES
function ver_var($arreglo=''){
  		 echo "<pre>";
         print_r($arreglo);
         echo "</pre>";
	}
public function tabla($atributos=array(),$arreglo_final_captura=array()){
	$tamano = sizeof($arreglo_final_captura);
	$gridDataProvider = new CArrayDataProvider($arreglo_final_captura, array( 'pagination'=>array(
        'pageSize'=>200,

    ),
    'totalItemCount' =>$tamano,

	));

	$this->widget('bootstrap.widgets.TbGridView', array(
	    'type'=>'striped bordered condensed',
	    'dataProvider'=>$gridDataProvider,
	    'template'=>"{items}",
	    'enablePagination' => false,
	    'columns'=>$atributos,


	));



/*$this->widget('CLinkPager', array(

    'pages'=>$gridDataProvider->getPagination(),
    'itemCount'=>$tamano,
     'pageSize'=>5,
    'maxButtonCount'=>1,
    'header'=>'<center>',
    'footer'=>'</center>',
    'id'=>'link_pager',
    'htmlOptions'=>array('class'=>'pagination pagination-centered')

));*/



}


	//orden de parametros: clase, titulo, mensaje (FUNCION DE ANDRES)
	public function error($error='')
	{
		$dato = explode(",",$error);

		echo "<div id='mens2' class='$dato[0]'>";
		echo "<button type='button' class='close' data-dismiss='alert'>x</button>";
		echo "<h3>$dato[1]</h3>";
		echo "$dato[2]";
		echo "</div>";
	}

public function tabla_titulo($atributos=''){

	?>
			<div class="page-header">
 		 	<h1><? echo $atributos; ?></h1>
			</div>
	<?
}

public function tabla_detalle($datos=array(), $columnas=array(), $data_vehiculos=array()){
	$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$datos,
	'attributes'=>$columnas));

	if (isset($data_vehiculos['descripcion']) && !empty($data_vehiculos['descripcion'])){
		?>
			<h6><i class="icon-flag"></i> Origen de los datos: <?=$data_vehiculos['descripcion']?></h2>
		<?
	}
}

public function tabla_detalle_inside($datos=array(), $columnas=array()){
	?><div class="row">
  <div class="span9"><?
	$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$datos,
	'htmlOptions' => array('class'=>'well well-small'),
	'attributes'=>$columnas));?></div>

</div><?

}
/*public function leyenda($titulo=''){
		?><div class="row">
  <div style="text-align: left;" class="span11"><? echo "<legend>".$titulo." </legend>";?></div>

</div><?


	}*/

public function leyenda($titulo=''){
	echo "<legend>$titulo </legend>";
}

public function leyenda_pdf($titulo=''){
	echo "<div class='linea_titulo'><h4>$titulo </h4></div>";

}

public function grid($datos=array(), $columnas=array()){
	$data_provider = new CArrayDataProvider($datos);
	$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$data_provider,
	'template'=>"{items}",
	'columns'=>$columnas,
));

}

public function grid_detail($datos=array(), $columnas=array(),$indices=array()){
		$tamano = sizeof($datos);
	$data_provider = new CArrayDataProvider($datos, array( 'pagination'=>array(
        'pageSize'=>200,

    ),
    'totalItemCount' =>$tamano,

	));
?><div class="row-fluid">
  <div class="span12 "><?
	$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	 //  'filter'=>$datos,
	    'type'=>'striped bordered',
	    'dataProvider' => $data_provider,
	    'template' => "{items}",
	    'enablePagination' => true,
	    'columns' => array_merge($columnas,
	    		array(
	  	        array(
	            'class'=>'bootstrap.widgets.TbRelationalColumn',
	            'name' => 'Detalle Captura',
				'url' => $this->createUrl('SolvenciaDpi/relational',array('indices'=>$indices)),
	            'value'=> '"Detalle"',
	   			)
	    )

		)
	));?></div>

</div><?
}

public function grid_detail_pdf($datos=array(), $columnas=array(),$indices=array()){
	$tamano = sizeof($datos);
	$data_provider = new CArrayDataProvider($datos,
		array(
			'pagination'=>false,
   			'totalItemCount' =>$tamano,
		)
	);
	?><div class="row-fluid">
	  <div class="span12 "><?
		$this->widget('bootstrap.widgets.TbExtendedGridView', array(
		 //  'filter'=>$datos,
		    'type'=>'striped bordered',
		    'dataProvider' => $data_provider,
		    'template' => "{items}",
		    'enablePagination' => true,
		    'columns' => array_merge($columnas)
		));?></div>

	</div><?
}


public function grid_detail_p($datos=array(), $columnas=array()){
	$tamano = sizeof($datos);
	$data_provider = new CArrayDataProvider($datos, array( 'pagination'=>array(
       	'pageSize'=>200,
	    ),
	    'totalItemCount' =>$tamano,
	));
?><div class="row-fluid">
  <div class="span12 "><?
	$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	 //  'filter'=>$datos,
	    'type'=>'striped bordered',
	    'dataProvider' => $data_provider,
	    'template' => "{items}",
	    'enablePagination' => true,
	    'columns' => $columnas


	));?></div>

</div><?
}

public function grid_detail_r($datos=array(), $columnas=array()){
		$tamano = sizeof($datos);
	$data_provider = new CArrayDataProvider($datos, array( 'pagination'=>array(
        'pageSize'=>200,

    ),
    'totalItemCount' =>$tamano,

	));
?><div class="row-fluid">
  <div class="span12 "><?
	$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	 //  'filter'=>$datos,
	    'type'=>'striped bordered',
	    'dataProvider' => $data_provider,
	    'template' => "{items}",
	    'enablePagination' => true,
	    'columns' => $columnas
	));?></div>

</div><?
}


public function grid_detail_nombres($datos=array(), $columnas=array(),$dpi=''){
	$dataProvider = new CArrayDataProvider($datos);
	// on your view

	$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	 //  'filter'=>$datos,
	    'type'=>'striped bordered',
	    'dataProvider' => $dataProvider,
	    'template' => "{items}",
	    'columns' => array_merge($columnas,
			array(
			array(
		 	 'header'=>'Accion',
		 	 'type'=>'raw',
		      'value'=>'\'
	           <form action="'.Yii::app()->createUrl("solvenciadpi/perfil").'" method="post">
	            <input type="hidden" name="id_ciudadano_renap" readonly="readonly" value="\'.$data["id_ciudadano_renap"].\'"/>
	              <button type="submit" class="btn btn-primary"> <i class="icon-list icon-black"></i> Ver Perfil</button>
	           </form>\'',
	        ),
		)
	 )
	));


}
//devuelve la descripcion de un criterio según la referencia renap
public function cf_descrip_renap($criterio=0, $ref_renap=0){
		$id='';
		$id = Yii::app()->db->createCommand()
				->select('descripcion')
				->from('sapo_gestion.sapogt_criterio_fijo')
				->where('id_criterio_fijo=:id_criterio_fijo and ref_renap=:ref_renap', array(':id_criterio_fijo'=>$criterio,'ref_renap'=>$ref_renap))
				->limit('1')
				->queryScalar();
		return $id;
}

public function transforma_fecha($fecnac){
		$fecnac = substr($fecnac,0,10);
		$arreglo_fecha = explode('-',$fecnac);
		$fecha = $arreglo_fecha[2]."/".$arreglo_fecha[1]."/".$arreglo_fecha[0];
		return $fecha;
	}
public function NombraJuzgado($cod_juzgado=0,$cod_depto=0, $cod_muni =0,$tipo=0){

	if($tipo==1 ){
		$cod_juzgado = Yii::app()->db->createCommand()
				->select('nombre_juzgado')
				->from('sapo_gestion.sapogt_juzgado')
				->where('cod_juzgado_bi=:cod_juzgado_bi and cod_depto_bi=:cod_depto_bi and cod_municipio_bi=:cod_municipio_bi', array(':cod_juzgado_bi'=>$cod_juzgado,':cod_depto_bi'=>$cod_depto,':cod_municipio_bi'=>$cod_muni))
				->limit('1')
				->queryScalar();
	}elseif($tipo==2 || $tipo==0){
		$cod_juzgado = Yii::app()->db->createCommand()
				->select('nombre_juzgado')
				->from('sapo_gestion.sapogt_juzgado')
			//	->where('cod_juzgado_pb=:cod_juzgado_pb and cod_depto_bi=:cod_depto_bi and cod_municipio_bi=:cod_municipio_bi', array(':cod_juzgado_pb'=>$cod_juzgado,':cod_depto_bi'=>$cod_depto,':cod_municipio_bi'=>$cod_muni))
				->where('cod_juzgado_pb=:cod_juzgado_pb ', array(':cod_juzgado_pb'=>$cod_juzgado))
				->limit('1')
				->queryScalar();

	}

		return $cod_juzgado;

}
public function DeptoRenap($cod_depto=0){
		$cod_depto = Yii::app()->db->createCommand()
				->select('descripcion')
				->from('sapo_gestion.sapogt_renap_departamento')
				->where('id_depto=:id_depto', array(':id_depto'=>$cod_depto))
				->limit('1')
				->queryScalar();
		return $cod_depto;

}
public function DeptoRenapid($cod_depto=0){
		$cod_depto = Yii::app()->db->createCommand()
				->select('descripcion')
				->from('sapo_gestion.sapogt_renap_departamento')
				->where('id_depto=:id_depto', array(':id_depto'=>$cod_depto))
				->limit('1')
				->queryScalar();
		return $cod_depto;

}

public function MuniRenap($cod_depto=0,$cod_muni=0){
		$cod_muni = Yii::app()->db->createCommand()
				->select('descripcion')
				->from('sapo_gestion.sapogt_renap_municipio')
				->where('id_depto=:id_depto and id_muni=:id_muni', array(':id_depto'=>$cod_depto,':id_muni'=>$cod_muni))
				->limit('1')
				->queryScalar();
		return $cod_muni;

}
public function DeptoBitoRenap($cod_depto=0){
		$cod_depto = Yii::app()->db->createCommand()
				->select('cod_depto_renap')
				->from('bi.geo_traductor')
				->where('cod_depto_oracle=:cod_depto_oracle', array(':cod_depto_oracle'=>$cod_depto))
				->limit('1')
				->queryScalar();
		return (int)$cod_depto;

}
public function MuniBitoRenap($cod_depto=0,$cod_muni=0){
		$cod_muni = Yii::app()->db->createCommand()
				->select('cod_muni_renap')
				->from('bi.geo_traductor')
				->where('cod_depto_oracle=:cod_depto_oracle and cod_muni_oracle=:cod_muni_oracle', array(':cod_depto_oracle'=>$cod_depto,':cod_muni_oracle'=>$cod_muni))
				->limit('1')
				->queryScalar();
		return (int)$cod_muni;

}

//-------------------FUNCIONALIDADES DE WEBSEVICES

/*public function ws_optimus_datos($cui=0,$sede=''){

		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_OP, "uri"=>URL_WS_OP));
		$data = $ws_cliente->DatosCiudadanoDPI_Renap($cui,CLIENTE,$sede,Yii::app()->user->name,true);
		return $data;
}*/
public function ws_optimus_datos($cui=0,$sede='',$no_cache=false){
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_OP, "uri"=>URL_WS_OP));
		$data = $ws_cliente->DatosCiudadanoDPI_Renap($cui,CLIENTE,$sede,$no_cache,Yii::app()->user->name,false);
		return $data;
}


//*************** FUNCIONES DE CONSULTA A WEB SERVICE **********************
	// Consulta webservice optimus (trae datos desde renap, por medio del dpi)
	public function consulta_optimus($dpi=0){
		$data = "";
		$sede = ''; // se pone la sede vacia porque optimus requiere el parametro
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_OP, "uri"=>URL_WS_OP));
		// "trae_datos_citripio" se llama la función del web service citripio
		$data = $ws_cliente->DatosCiudadanoDPI_Renap($dpi,CLIENTE,$sede,Yii::app()->user->name,true); // cliente es una constante en config.inc.php
		return $data;
	}
public function ws_megatron($dpi=0)
	{
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_MT, "uri"=>URL_WS_MT));
		$data = $ws_cliente->BuscaCapturasDPI($dpi,CLIENTE,Yii::app()->user->name);
		return $data;
	}

public function ws_starscream($dpi=0)
	{
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_SS, "uri"=>URL_WS_SS));
		$data = $ws_cliente->BuscaCapturasDPI($dpi,CLIENTE,Yii::app()->user->name);
		$guarda_auditoria = $this->auditoria_rojos($data);
		return $data;
	}
public function consulta_starscream($dpi=0){
		$data = "";
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_SS, "uri"=>URL_WS_SS));
		// "trae_datos_citripio" se llama la función del web service citripio
		$data = $ws_cliente->BuscaCapturasDPI($dpi,CLIENTE,Yii::app()->user->name); // cliente es una constante en config.inc.php
		$guarda_auditoria = $this->auditoria_rojos($data);
		return $data;
	}

public function auditoria_rojos($data=array())
{
	$id_ciudadano_renap = 0;
	$id_ciudadano_cedula = 0;
	$id_ciudadano_bi = 0;
	$exito_cancelada ='';
	if(isset($data['error']) && $data['error']==0 && $data['solvente']==1){
		$foto = $this->prioridad_ciudadano($data);
		//$this->ver_var($this->tiene_rojo);		
		//$this->ver_var($foto);		
		//exit();
		unset($data['error']);
		unset($data['solvente']);
		foreach($data as $result_c){
			foreach($result_c as $result_n){
				foreach($result_n as $result_c){
					if(isset($result_c['id_ciudadano_renap'])){
						$id_ciudadano_renap = $result_c['id_ciudadano_renap'];
					}
					if(isset($result_c['id_ciudadano_cedula'])){
						$id_ciudadano_cedula = $result_c['id_ciudadano_cedula'];
					}
					if(isset($result_c['id_ciudadano'])){
						$id_ciudadano_bi = $result_c['id_ciudadano'];
					}
				}
			}
		}
		if ($this->tiene_rojo == 1) {
			$fecha = date("Y-m-d H:i:s");
			$insert_rojo = array ();
			$insert_rojo['id_usuario'] = Yii::app()->getSession()->get('id_usuario');;
			$insert_rojo['id_modulo'] = MODULO;
			$insert_rojo['id_ciudadano_renap'] = $id_ciudadano_renap;
			$insert_rojo['id_ciudadano_cedula'] = $id_ciudadano_cedula;
			$insert_rojo['id_ciudadano_bi'] = $id_ciudadano_bi;
			$insert_rojo['fh_consulta']=$fecha;
			$insert_rojo['id_destino'] = $destino = Yii::app()->getSession()->get('id_destino');



	$transaction=Yii::app()->db->beginTransaction();

	try
		{
		$auditoria = $this->asigna_variable_session_trigger();
		$exito_cancelada  = Yii::app()->db->createCommand()->insert('sapo_auditoria.sapoau_rojo',$insert_rojo);

		$exito= $transaction->commit();

		}
		catch(Exception $e) // se arroja una excepción si una consulta falla
		{
		    $transaction->rollBack();
			$exito=false;
		}

			return $exito_cancelada;
		}else{
			return false;
		}
	}else{
		return false;
	}
}









public function ws_soundwave($dpi='', $primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada,$fecha_nacimiento,$nombre_padre,$nombre_madre, $orden_cedula, $registro_cedula, $nacionalidad_cod, $cod_depto_cedula, $cod_munic_cedula, $pais_nacimiento_cod, $depto_nacimiento_cod, $munic_nacimiento_cod, $genero, $estado_civil)
	{
		$ws_cliente = new  SoapClient(null, array("location"=>URL_WS_SW, "uri"=>URL_WS_SW));
		$dpi =0;
		$data = $ws_cliente->BuscaCapturasNombre($dpi='',CLIENTE,$primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada,$fecha_nacimiento,$nombre_padre,$nombre_madre, $orden_cedula, $registro_cedula, $nacionalidad_cod, $cod_depto_cedula, $cod_munic_cedula, $pais_nacimiento_cod, $depto_nacimiento_cod, $munic_nacimiento_cod, $genero, $estado_civil,Yii::app()->user->name);
		return $data;
	}

public function ws_fallen($primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada,$fecha_nacimiento,$nombre_padre,$nombre_madre, $orden_cedula, $registro_cedula, $nacionalidad_cod, $cod_depto_cedula, $cod_munic_cedula, $pais_nacimiento_cod, $depto_nacimiento_cod, $munic_nacimiento_cod, $genero, $estado_civil)
	{
		$sw_cliente = new SoapClient(null, array("location"=>URL_WS_FL, "uri"=>URL_WS_FL));
		$dpi = 0;
		$data = $sw_cliente->BuscaCapturasNombre($dpi,CLIENTE,$primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada,$fecha_nacimiento,$nombre_padre,$nombre_madre,$orden_cedula,$registro_cedula, $nacionalidad_cod,$cod_depto_cedula, $cod_munic_cedula, $pais_nacimiento_cod, $depto_nacimiento_cod,$munic_nacimiento_cod,$genero,$estado_civil,Yii::app()->user->name);
		return $data;

	}

//----------------------FUNCIONES PARA EL USO DE LA APLICACION

//funcion que controla la bitacora y acceso al sistema
public function valida($sesion, $username)
	{
		$this->sesion=$sesion;
		$this->username = $username;

						/*se extrae el id del usuario*/
						$dbC = Yii::app()->db->createCommand();
						$dbC->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object

							$dbC->select('*')
							->from('sapo_autentica.sapoat_usuario_t')
							->where('usuario=:usuario', array(':usuario'=>$this->username))
							->order ('id_usuario desc')
							->limit('1');

							foreach ($dbC->queryAll() as $row) {
						    // es el id del usuario que esta logueado
						    $this->id = $row->id_usuario;
							}

		$borrado = sesion::model()->findByAttributes(array('id_sesion_activa'=>$this->sesion, 'id_usuario'=>$this->id));
		if($borrado !==NULL){


		}else{
		// salir de sesion
		$this->Logout();
		}
	} // fin de la funcion valida


public function prioridad_ciudadano($data=array())
{

//	$this->ver_var($data);

	if(isset($data['error']) && $data['error']==0 && $data['solvente']==1){
				unset($data['error']);
				unset($data['solvente']);
				$criterio='';
				$prioridad_roja=0;
				$prioridad_amarilla=0;
				$prioridad_negra=0;
				 foreach($data as $result_c){
					foreach($result_c as $result_n){
						foreach($result_n as $result_c){

							
							if(isset($result_c['criterio_1'])){
								$prioridad_roja = 2;
							}
							if(isset($result_c['criterio_2'])){
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_amarilla = $prioridad_amarilla+1;
							}
							if(isset($result_c['criterio_3'])){
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_amarilla = $prioridad_amarilla+1;
							}
							if(isset($result_c['criterio_4'])){
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_negra = $prioridad_negra+1;
							}
							if(isset($result_c['criterio_5'])){
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_negra = $prioridad_negra+1;
							}
							if ($prioridad_roja >=2){
								$prioridad =1;
							}elseif($prioridad_amarilla >=1){
								$prioridad =2;
							}elseif($prioridad_negra >=1){
								$prioridad =3;
							}else{
								$prioridad =0;
							}

							if($prioridad ==1){
								$this->tiene_rojo = 1;
								$foto = Yii::app()->request->baseUrl.'/images/prioridad1.png';
							}elseif($prioridad ==2){
								$foto = Yii::app()->request->baseUrl.'/images/prioridad2.png';
							}elseif($prioridad ==3){
								$foto = Yii::app()->request->baseUrl.'/images/prioridad3.png';
							}

							

							}}}
							return $foto;

			}
}

public function CapturasDpi($data_renap = array(),$data=array()){


		$prioridad = $this->prioridad_ciudadano($data);

		$this->datosciudadano_cap($data_renap,$prioridad);
		$this->capturas($data);

/*		if(isset($data['error']) && $data['error']==0){
			if($data['solvente']==0){

				echo '<div class="modal-header">';
				$this->tabla_titulo('Capturas');
				echo '<span class="label label-important">NO TIENE CAPTURAS PENDIENTES</span>';
				echo '</div>';

			}elseif($data['solvente']==1){

			//$this->ver_var($data);
			$this->capturas($data);

			}
		}*/

}

public function ficha($data_renap=array(),$data_cap=array(),$data_ante=array(),$dpi=''){
	$resumen = array();

	$resumen=$this->resumen_cap($data_cap);
	if(count($resumen)==1){
		$orden = 1;
	}else{
		$orden = 2;
	}
	if(!empty($data_ante)){
		$fichas=0;
		$fichas = $this->resumen_fichas($data_ante);
		if($fichas>0){
			$orden = $orden+1;
			$resumen[3]['id']=$orden;
			$resumen[3]['total']=$fichas;
			$resumen[3]['target']='fichas';
			$resumen[3]['path_ima']=Yii::app()->request->baseUrl.'/images/ficha.png';
			$resumen[3]['out']=Yii::app()->request->baseUrl.'/images/ficha_out.png';
			$resumen[3]['descrip']='Total Fichas';
			$resumen[4]['id']=$orden+1;
			$resumen[4]['target']='fichas1';
			$resumen[4]['out']=Yii::app()->request->baseUrl.'/images/antecedente_out.png';
			$resumen[4]['total']=$this->resumen_ante($data_ante);
			$path = Yii::app()->request->baseUrl.'/images/antecedente.png';
			$resumen[4]['path_ima']=$path;
			$resumen[4]['descrip']='Total Delitos Cometidos';
		}else{
			$orden = $orden+1;
			$resumen[3]['id']=$orden;
			$resumen[3]['target']='fichas';
			$resumen[3]['descrip']='Sin Antecedentes';
			$resumen[3]['total']=0;
			$resumen[3]['out']=Yii::app()->request->baseUrl.'/images/prioridad0_out.png';
			$resumen[3]['path_ima']=Yii::app()->request->baseUrl.'/images/prioridad0.png';
		}
	}

	$valor = '$data[\'path_ima\']';
	$atributos=array(
					array('name'=>'id', 'header'=>'#'),
					array('name'=>'descrip', 'header'=>'Descripción'),
					array('header'=>'Indicador',
					'class'=>'bootstrap.widgets.TbImageColumn',
                					'imagePathExpression'=>$valor,
                					'usePlaceKitten'=>FALSE,
                					'link'=>true,
                					// 'url'=>'Yii::app()->controller->createUrl("#", array("id"=>$data[id]))',
                					'htmlOptions'=>array('style'=>'width: 20px')
               						),
					        array('name'=>'total', 'header'=>'Total'),
				    );?>

		<div class='row-fluid'>
			<div class="span8"><?$this->DatosRenap($data_renap);?></div>
			<div class="span4">
				<?$titulo= 'Resumen de Perfil';
				//$this->leyenda($titulo);
				$this->grid_detail_r($resumen,$atributos);?>
		</div></div>
	<?
}
public function resumen_ante($data_ante=array()){
	$data=$data_ante;
	$i=0;
	if(isset($data['error']) && $data['error']==0 && $data['solvente']>0){
		 	unset($data['error']);
			unset($data['solvente']);
			foreach($data as $result){
						$ficha = $result['fichas'];

					foreach($ficha as $result_f){
						$delito = $result_f['delitos'];
						foreach($delito as $result_d){
							$i++;
						}
					}
			}

		}else{
		$i=0;
		}
	return $i;
}

public function resumen_fichas($data_ante=array()){
	$data=$data_ante;
	$i=0;
	if(isset($data['error']) && $data['error']==0 && $data['solvente']>0){
	 	unset($data['error']);
		unset($data['solvente']);
		foreach($data as $result){
			$ficha = $result['fichas'];
			foreach($ficha as $result_f){
				$delito = $result_f['delitos'];
				$i++;
			}
		}
	}else{
		$i=0;
	}
	return $i;
}

public function resumen_cap($data_cap=array()){
	$data = $data_cap;
	$conteo = array();
	$c_rojo = 0;
	$c_amarillo = 0;
	$c_negro = 0;

	if(isset($data['error']) && $data['error']==0){
			unset($data['error']);
			unset($data['solvente']);
			if(count($data)>0){
				foreach($data as $result_c){
					foreach($result_c as $result_n){
						foreach($result_n as $result_c){
							$criterio='';
							$prioridad_roja=0;
							$prioridad_amarilla=0;
							$prioridad_negra=0;

							if(isset($result_c['criterio_1'])){
								$prioridad_roja = 2;
								$criterio = "|por dpi|";
							}
							if(isset($result_c['criterio_2'])){
								$criterio = $criterio."|por cedula|";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_amarilla = $prioridad_amarilla+1;
							}
							if(isset($result_c['criterio_3'])){
								$criterio = $criterio."|por nombres|";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_amarilla = $prioridad_amarilla+1;
							}
							if(isset($result_c['criterio_4'])){
								$criterio = $criterio."|por padres|";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_negra = $prioridad_negra+1;
							}
							if(isset($result_c['criterio_5'])){
								$criterio = $criterio."|por fecha nacimiento|";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_negra = $prioridad_negra+1;
							}
							if ($prioridad_roja >=2){
								$c_rojo=$c_rojo+1;
								$prioridad =1;
							}elseif($prioridad_amarilla >=1){
								$c_amarillo=$c_amarillo+1;
								$prioridad =2;
							}elseif($prioridad_negra >=1){
								$c_negro=$c_negro+1;
								$prioridad =3;
							}else{
								$prioridad =0;
							}
						}
					}
				}

			$total=0;
			$total=$c_rojo+$c_amarillo;
			if($total==0){
				$conteo[0]['id']=1;
				$conteo[0]['descrip']='Sin Orden de Captura';
				$conteo[0]['total']=$c_rojo;
				$conteo[0]['target']='capturast';
				$conteo[0]['out']=Yii::app()->request->baseUrl.'/images/prioridad0_out.png';
				$conteo[0]['path_ima']=Yii::app()->request->baseUrl.'/images/prioridad0.png';
				$conteo[0]['color']='VERDE';
			}else{
				if($c_rojo>0){
					$conteo[0]['id']=1;
					$conteo[0]['descrip']='OC Crítica';
					$conteo[0]['total']=$c_rojo;
					$conteo[0]['target']='capturast';
					$conteo[0]['out']=Yii::app()->request->baseUrl.'/images/prioridad1_out.png';
					$conteo[0]['path_ima']=Yii::app()->request->baseUrl.'/images/prioridad1.png';
					$conteo[0]['color']='ROJO';
				}

				if($c_amarillo>0){
					$conteo[1]['id']=2;
					$conteo[1]['descrip']='OC Posible';
					$conteo[1]['target']='capturast1';
					$conteo[1]['total']=$c_amarillo;
					$conteo[1]['out']=Yii::app()->request->baseUrl.'/images/prioridad2_out.png';
					$conteo[1]['path_ima']=Yii::app()->request->baseUrl.'/images/prioridad2.png';
					$conteo[1]['color']='AMARILLO';
				}

			}

		}
		else{
				$conteo[0]['id']=1;
			$conteo[0]['descrip']='Sin Orden de Captura';
			$conteo[0]['total']=$c_rojo;
			$conteo[0]['target']='capturast';
			$conteo[0]['out']=Yii::app()->request->baseUrl.'/images/prioridad0_out.png';
			$conteo[0]['path_ima']=Yii::app()->request->baseUrl.'/images/prioridad0.png';
			$conteo[0]['color']='VERDE';
		}

	}else{

		$conteo[0]['id']=1;
		$conteo[0]['descrip']='Error en consulta de Ordenes de Captura';
		$conteo[0]['total']=0;
		$conteo[0]['target']='capturast';
		$conteo[0]['out']=Yii::app()->request->baseUrl.'/images/prioridad1_out.png';
		$conteo[0]['path_ima']=Yii::app()->request->baseUrl.'/images/prioridad1_out.png';

	}

	return	$conteo;

}

/* funcion que hace la busqueda por nombres a capturas */
public function CapturasNombres($dpi='', $cliente='', $primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada,$fecha_nacimiento,$nombre_padre,$nombre_madre, $orden_cedula, $registro_cedula, $nacionalidad_cod, $cod_depto_cedula, $cod_munic_cedula, $pais_nacimiento_cod, $depto_nacimiento_cod, $munic_nacimiento_cod, $genero, $estado_civil)
	{	//inicio de funcion CapturasNombres

		if(!empty($fecha_nacimiento)){
		$this->fecha_nacimiento = $this->transforma_fecha_diagonal($fecha_nacimiento);
		}

		$data = $this->ws_fallen($dpi='', $this->primer_nombre,$this->segundo_nombre,$this->tercer_nombre,$this->primer_apellido,$this->segundo_apellido,$this->apellido_casada,$this->fecha_nacimiento,$this->nombre_padre,$this->nombre_madre, $this->orden_cedula, $this->registro_cedula, $this->nacionalidad_cod, $this->cod_depto_cedula, $this->cod_munic_cedula, $this->pais_nacimiento_cod, $this->depto_nacimiento_cod, $this->munic_nacimiento_cod, $this->genero, $this->estado_civil);
		$prioridad = $this->prioridad_ciudadano($data);

		$dataa['primer_nombre'] = $this->primer_nombre;
		$dataa['segundo_nombre'] = $this->segundo_nombre;
		$dataa['tercer_nombre'] = $this->tercer_nombre;
		$dataa['primer_apellido'] = $this->primer_apellido;
		$dataa['segundo_apellido'] = $this->segundo_apellido;
		$dataa['apellido_casada'] = $this->apellido_casada;
		$dataa['foto'] = NULL;

		$this->datosciudadano($dataa,$prioridad);


		if(isset($data['error']) && $data['error']==0){

			if($data['solvente']==0){
				//echo "si esta solvente";

				$this->tabla_titulo('Solvente');

			//	$this->datos_formulario($this->primer_nombre,$this->segundo_nombre,$this->tercer_nombre,$this->primer_apellido,$this->segundo_apellido,$this->apellido_casada,$this->fecha_nacimiento,$this->nombre_padre,$this->nombre_madre, $this->orden_cedula, $this->registro_cedula, $this->nacionalidad_cod, $this->cod_depto_cedula, $this->cod_munic_cedula, $this->pais_nacimiento_cod, $this->depto_nacimiento_cod, $this->munic_nacimiento_cod, $this->genero, $this->estado_civil);

			}else{
				//echo "tiene orden de captura";
			//	$this->tabla_titulo('Con orden de captura');
				echo "<center>";
				$dpi=0;
				$this->capturas($data,$dpi);
				echo "</center>";
			}
			$this->datos_formulario($this->primer_nombre,$this->segundo_nombre,$this->tercer_nombre,$this->primer_apellido,$this->segundo_apellido,$this->apellido_casada,$this->fecha_nacimiento,$this->nombre_padre,$this->nombre_madre, $this->orden_cedula, $this->registro_cedula, $this->nacionalidad_cod, $this->cod_depto_cedula, $this->cod_munic_cedula, $this->pais_nacimiento_cod, $this->depto_nacimiento_cod, $this->munic_nacimiento_cod, $this->genero, $this->estado_civil);
		}else{

			// aqui se muestran los errores

		} // fin del if del $data[error]


	}  //finaliza funcion de CapturasNombres


public function transforma_fecha_diagonal($fecnac){

		if(!empty($fecnac)){
	$fecnac = substr($fecnac,0,10);
	$arreglo_fecha = explode('/',$fecnac);
	$fecha = $arreglo_fecha[2]."/".$arreglo_fecha[1]."/".$arreglo_fecha[0];
	return $fecha;
	}
}




// funcion que muestra los datos de los usuarios de renap
public function datos_formulario($primer_nombre='',$segundo_nombre='',$tercer_nombre='',$primer_apellido='',$segundo_apellido='',$apellido_casada='',$fecha_nacimiento='',$nombre_padre='',$nombre_madre='', $orden_cedula='', $registro_cedula='', $nacionalidad_cod='', $cod_depto_cedula='', $cod_munic_cedula='', $pais_nacimiento_cod='', $depto_nacimiento_cod='', $munic_nacimiento_cod='', $genero='', $estado_civil='')
{
	if(strlen($primer_nombre)>0 && strlen($segundo_apellido)){

		$this->primer_nombre = $primer_nombre;
		$this->segundo_nombre = $segundo_nombre;
		$this->tercer_nombre = $tercer_nombre;
		$this->primer_apellido = $primer_apellido;
		$this->segundo_apellido = $segundo_apellido;
		$this->apellido_casada = $apellido_casada;
		$this->fecha_nacimiento = $fecha_nacimiento;
		$this->nombre_padre = $nombre_padre;
		$this->nombre_madre = $nombre_madre;
		$this->orden_cedula = $orden_cedula;
		$this->registro_cedula = $registro_cedula;
		$this->nacionalidad_cod = $nacionalidad_cod;
		}


			$datos_busqueda['nombre'] = $this->primer_nombre." ". $this->segundo_nombre." ".$this->tercer_nombre." ".$this->primer_apellido." ".$this->segundo_apellido." ".$this->apellido_casada;
			$datos_busqueda['fecha_nacimiento'] = $this->fecha_nacimiento;
			$datos_busqueda['cedula']=$this->orden_cedula." ".$this->registro_cedula;
			$id_opcion = $genero;
			$datos_busqueda['genero'] = $this->descripcion(2, $id_opcion);
			$id_opcion = $estado_civil;
			$datos_busqueda['estado_civil'] = $this->descripcion(3, $id_opcion);
			$id_cat_item = $this->nacionalidad_cod;
			$id_cat =6;
			$datos_busqueda['nacionalidad_cod'] = $this->nacionalidad($id_cat,$id_cat_item);
			$datos_busqueda['padres']= "padre: ".$this->nombre_padre." - madre: ".$this->nombre_madre;
$columnas= array(
					array('name'=>'nombre', 'label'=>'Nombre completo del ciudadano:'),
					array('name'=>'fecha_nacimiento', 'label'=>'Fecha de Nacimiento:'),
					array('name'=>'lugar_nacimiento', 'label'=>'Lugar de Nacimiento:'),
					array('name'=>'cedula', 'label'=>'Cedula de Vecindad'),
					array('name'=>'genero', 'label'=>'G&eacute;nero:'),
					array('name'=>'estado_civil', 'label'=>'Estado Civil:'),
					array('name'=>'nacionalidad_cod','label'=>'Nacionalidad'),
					array('name'=>'padres', 'label'=>'Madre y Padre del Ciudadano:'),
					);

$mensaje= '<center>Datos generales del ciudadano:</center><center><h3> '.$datos_busqueda['nombre']. "</h3></center>";

	?>


<div class="row">
  <div class="span12"><?$this->leyenda($mensaje);?></div>

</div>
<div class="row-fluid">
  <div class="span12"><?$this->tabla_detalle($datos_busqueda,$columnas);?></div>
</div><?

} // finaliza la funcion


public function DatosRenap($arr_info= array()){


			$datos_busqueda['dpi']= $this->dpi;
			$datos_busqueda['nombre'] = $arr_info['primer_nombre']." ". $arr_info['segundo_nombre']." ".$arr_info['tercer_nombre']." ".$arr_info['primer_apellido']." ".$arr_info['segundo_apellido']." ".$arr_info['apellido_casada'];
			$datos_busqueda['fecha_nacimiento'] = $this->transforma_fecha($arr_info['fecha_nacimiento']);
			$datos_busqueda['lugar_nacimiento'] = $arr_info['pais_nacimiento']."-".$arr_info['depto_nacimiento']."-".$arr_info['munic_nacimiento'];
			$datos_busqueda['cedula']=$arr_info['orden_cedula']." ".$arr_info['registro_cedula']." ".$arr_info['depto_cedula']." ".$arr_info['munic_cedula'];
			$genero=$arr_info['genero'];
			$datos_busqueda['genero'] =  $this->cf_descrip_renap(2,$genero);
			$estado_civil=$arr_info['estado_civil'];
			$datos_busqueda['estado_civil'] = $this->cf_descrip_renap(3,$estado_civil);
			$datos_busqueda['nacionalidad']=$arr_info['nacionalidad'];
			$datos_busqueda['reg_nac'] ="Libro de Nacimiento: ".$arr_info['libro_nac']." -- Partida de Nacimiento: ". $arr_info['partida_nac'];
			$datos_busqueda['padres']= "madre:".$arr_info['nombre_madre']." padre:".$arr_info['nombre_padre'];
			$foto = $arr_info['foto'];
$columnas= array(
					array('name'=>'dpi', 'label'=>'DPI:'),
					array('name'=>'nombre', 'label'=>'Nombre completo del ciudadano:'),
					array('name'=>'fecha_nacimiento', 'label'=>'Fecha de Nacimiento:'),
					array('name'=>'lugar_nacimiento', 'label'=>'Lugar de Nacimiento:'),
					array('name'=>'cedula', 'label'=>'Cedula de Vecindad'),
					array('name'=>'genero', 'label'=>'G&eacute;nero:'),
					array('name'=>'estado_civil', 'label'=>'Estado Civil:'),
					array('name'=>'nacionalidad', 'label'=>'Nacionalidad:'),
					array('name'=>'reg_nac', 'label'=>'Registro de Nacimiento:'),
					array('name'=>'padres', 'label'=>'Madre y Padre del Ciudadano:'),
					);

$mensaje= '1. Datos generales según RENAP para el dpi No.: '. $this->dpi;
?>


<div class="row-fluid">
  <div class="span12 offset1"><?$this->leyenda($mensaje);?></div>

</div>
<div class="row-fluid">
	  <div class="span4"><?

			 			if(strlen($foto)>500)
			 			{
			 					$res = $foto;

							$xml = new SimpleXMLElement($res);
			 				$newdataset = $xml->children();
			 				$objetos = get_object_vars($newdataset);
			 				$fotica=$objetos['PortraitImage'];
			 				echo '<img src="data:image/png;base64,'.$fotica.'" width="300" height="300" class="img-rounded">';

			 			}else{

							$src = Yii::app()->request->baseUrl.'/images/nodisponible.png';
							echo '<img src="'.$src.'" width="300" height="300"  class="img-rounded">';
			 			}

			 			?></div>
  <div class="span8"><? $this->tabla_detalle($datos_busqueda,$columnas); ?></div>

</div><?

}


/* funcion que muestra el nombre del ciudadano con pic en una linea */
public function datosciudadano($arr_info = array(), $prioridad=0){


			$datos_busqueda['nombre'] = $arr_info['primer_nombre']." ". $arr_info['segundo_nombre']." ".$arr_info['tercer_nombre']." ".$arr_info['primer_apellido']." ".$arr_info['segundo_apellido']." ".$arr_info['apellido_casada'];
			$foto = $arr_info['foto'];
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Información</h4>
</div>

<div class="modal-body">
   <p>
    	Ejecutar una orden de captura es un fenómeno complicado dentro de la Policía Nacional Civil, especialmente por la calidad de la información bajo la cual se emiten las órdenes de captura.<br/><br/>
    	Un ejemplo de lo anterior son aquellas órdenes de captura en las que se indican los sobrenombres de una persona: en estos casos, el policía que desee ejecutar la orden de captura, se arriesga a captura a la persona equivocada y se expone a una  acusación de detención ilegal.<br/><br/>
    	Para mejorar los niveles de certeza bajo los cuales se identifican las órdenes de captura dentro de la base de datos, el sistema utiliza diferentes criterios para localizar una orden de captura para una persona dada:<br /><br/>
    	1.- <strong>Nombres y apellidos:</strong> coincidencia de nombres y apellidos.  El sistema utiliza mecanismos que permiten identificar nombres “parecidos” como “karla” y “carla” o “Pérez”  y “peres”, incluso, si una persona tiene dos nombres, busca órdenes de captura en las que se identifica únicamente el segundo nombre, o únicamente por el primer nombre.<br /><br/>
    	2.-<strong>Cédula de vecindad:</strong> se utiliza como criterio de búsqueda el número de órden y el número de registro.  Se ignora el municipio donde se emitió la cédula ya que generalmente las órdenes de captura no indican dicho criterio.<br /><br/>
		3.-<strong>Número de CUI (DPI):</strong> Identificación emitida por el RENAP.  Este es el criterio de mayor certeza.<br /><br />
    	4.-<strong>Fecha de nacimiento:</strong> Fecha de nacimiento indicada en la orden de captura.<br /><br />
    	5.-<strong>Nombre de los padres:</strong> Si se indica nombres de los padres en la orden de captura, los mismos son utilizados a modo de referencia.<br /><br />
    	De acuerdo al criterio mediante el cual se encuentra una orden de captura, es mayor la certeza de que la orden de captura debe ejecutarse.  Esta certeza se presenta en tres diferentes colores:<br /><br />

    	<table border="1">
    		<tr bgcolor="#4F81BD">
    			<td style="color: white; font-weight: bold; font-size: 15px;">#</td>
    			<td style="color: white; font-weight: bold; font-size: 15px; width: 100px;">Color</td>
    			<td style="color: white; font-weight: bold; font-size: 15px; width: 200px;">Criterio</td>
    			<td style="color: white; font-weight: bold; font-size: 15px;">Recomendaciones</td>
    		</tr>
    		<tr bgcolor="#D3DFEE">
    			<td>1</td>
    			<td>ROJO <img src="images/prioridad1.png" width="25px" height="25px" /></td>
    			<td>Coincide por DPI</td>
    			<td>Ejecutar la orden de captura</td>
    		</tr>
    		<tr>
    			<td>2</td>
    			<td>ROJO <img src="images/prioridad1.png" width="25px" height="25px" /></td>
    			<td>
    				Coinciden dos de los cuatro criterios restantes <br />
					•	cédula,<br />
					•	nombres y apellidos<br />
					•	fecha de nacimiento<br />
					•	nombre de los padres

    			</td>
    			<td valign="top">Ejecutar la orden de captura</td>
    		</tr>
    		<tr bgcolor="#D3DFEE">
    			<td>3</td>
    			<td>AMARILLO <img src="images/prioridad2.png" width="25px" height="25px" /></td>
    			<td>
    				Coincide uno de los siguientes criterios:<br />
					•	cédula,<br />
					•	nombres y apellidos

    			</td>
    			<td>
    				Investigar mayor información, de acuerdo a lo que indique la orden de captura: nombre del cónyuge, lugar de residencia, etc.
    			</td>
    		</tr>
    		<tr>
    			<td>4</td>
    			<td>NEGRO <img src="images/prioridad3.png" width="25px" height="25px" /></td>
    			<td>
    				Únicamente coincide uno de los siguientes criterios:<br />
					•	cédula,<br />
					•	nombres y apellidos<br />
					•	fecha de nacimiento<br />
					•	nombre de los padres

    			</td>
    			<td>
    				Aunque es probable que se trate de la misma persona, no existe suficiente información para respaldar la orden de captura.
    			</td>
    		</tr>
    	</table>
</div>

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    	'type'=>'danger',
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>

<?php $this->endWidget(); ?>

<div class="row-fluid">
	<? echo "<div id='informa'><a href='#myModal' role='button' rel='tooltip' title='Información de prioridades' class='' data-toggle='modal'></a></div>"; ?>
  <div id='nciudadano' class="span12"><?

			 			if($foto==NULL)
			 			{
			 				echo "<div style='margin-top:10px;'>".$datos_busqueda['nombre']."</div>";
							echo "<div id='ft1'><img src='".$prioridad."'></div>";
			 				//	echo "no tiene fotografia";
			 			}else{
			 			if(strlen($foto)>500)
			 			{
			 					$res = $foto;

							$xml = new SimpleXMLElement($res);
			 				$newdataset = $xml->children();
			 				$objetos = get_object_vars($newdataset);
			 				$fotica=$objetos['PortraitImage'];
			 				echo '<img src="data:image/png;base64,'.$fotica.'" width="50" height="50">';

			 			}else{

							$src = Yii::app()->request->baseUrl.'/images/nodisponible.png';
							echo '<img src="'.$src.'" width="50" height="50">';
			 			}
							echo "<div style='margin-top:10px;'>".$datos_busqueda['nombre']."</div>";




							if($prioridad==0){

							}else{
							echo "<div id='ft'><img src='".$prioridad."'></div>";
							}




#	$this->widget('bootstrap.widgets.TbButton', array(
#    'label'=>'Click me',
#    'type'=>'primary',
#    'htmlOptions'=>array(
#        'data-toggle'=>'modal',
#        'data-target'=>'#myModal',
#    ),));
			 			}

			 			?></div></div><?

}
public function datosciudadano_cap($arr_info = array(), $prioridad=0){


			$datos_busqueda['nombre'] = $arr_info['primer_nombre']." ". $arr_info['segundo_nombre']." ".$arr_info['tercer_nombre']." ".$arr_info['primer_apellido']." ".$arr_info['segundo_apellido']." ".$arr_info['apellido_casada'];
			$foto = $arr_info['foto'];

	$id_ciudadano_renap= $arr_info['id_ciudadano_renap'];
 	$a_datos_renap = $this->trae_datos_ciudadano_renap($id_ciudadano_renap);
	$ordena =1;
	$titulo = "Información de RENAP";
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModalc')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Información</h4>
</div>

<div class="modal-body">
   <p>
    	Ejecutar una orden de captura es un fenómeno complicado dentro de la Policía Nacional Civil, especialmente por la calidad de la información bajo la cual se emiten las órdenes de captura.<br/><br/>
    	Un ejemplo de lo anterior son aquellas órdenes de captura en las que se indican los sobrenombres de una persona: en estos casos, el policía que desee ejecutar la orden de captura, se arriesga a captura a la persona equivocada y se expone a una  acusación de detención ilegal.<br/><br/>
    	Para mejorar los niveles de certeza bajo los cuales se identifican las órdenes de captura dentro de la base de datos, el sistema utiliza diferentes criterios para localizar una orden de captura para una persona dada:<br /><br/>
    	1.- <strong>Nombres y apellidos:</strong> coincidencia de nombres y apellidos.  El sistema utiliza mecanismos que permiten identificar nombres “parecidos” como “karla” y “carla” o “Pérez”  y “peres”, incluso, si una persona tiene dos nombres, busca órdenes de captura en las que se identifica únicamente el segundo nombre, o únicamente por el primer nombre.<br /><br/>
    	2.-<strong>Cédula de vecindad:</strong> se utiliza como criterio de búsqueda el número de órden y el número de registro.  Se ignora el municipio donde se emitió la cédula ya que generalmente las órdenes de captura no indican dicho criterio.<br /><br/>
		3.-<strong>Número de CUI (DPI):</strong> Identificación emitida por el RENAP.  Este es el criterio de mayor certeza.<br /><br />
    	4.-<strong>Fecha de nacimiento:</strong> Fecha de nacimiento indicada en la orden de captura.<br /><br />
    	5.-<strong>Nombre de los padres:</strong> Si se indica nombres de los padres en la orden de captura, los mismos son utilizados a modo de referencia.<br /><br />
    	De acuerdo al criterio mediante el cual se encuentra una orden de captura, es mayor la certeza de que la orden de captura debe ejecutarse.  Esta certeza se presenta en tres diferentes colores:<br /><br />

    	<table border="1">
    		<tr bgcolor="#4F81BD">
    			<td style="color: white; font-weight: bold; font-size: 15px;">#</td>
    			<td style="color: white; font-weight: bold; font-size: 15px; width: 100px;">Color</td>
    			<td style="color: white; font-weight: bold; font-size: 15px; width: 200px;">Criterio</td>
    			<td style="color: white; font-weight: bold; font-size: 15px;">Recomendaciones</td>
    		</tr>
    		<tr bgcolor="#D3DFEE">
    			<td>1</td>
    			<td>ROJO <img src="images/prioridad1.png" width="25px" height="25px" /></td>
    			<td>Coincide por DPI</td>
    			<td>Ejecutar la orden de captura</td>
    		</tr>
    		<tr>
    			<td>2</td>
    			<td>ROJO <img src="images/prioridad1.png" width="25px" height="25px" /></td>
    			<td>
    				Coinciden dos de los cuatro criterios restantes <br />
					•	cédula,<br />
					•	nombres y apellidos<br />
					•	fecha de nacimiento<br />
					•	nombre de los padres

    			</td>
    			<td valign="top">Ejecutar la orden de captura</td>
    		</tr>
    		<tr bgcolor="#D3DFEE">
    			<td>3</td>
    			<td>AMARILLO <img src="images/prioridad2.png" width="25px" height="25px" /></td>
    			<td>
    				Coincide uno de los siguientes criterios:<br />
					•	cédula,<br />
					•	nombres y apellidos

    			</td>
    			<td>
    				Investigar mayor información, de acuerdo a lo que indique la orden de captura: nombre del cónyuge, lugar de residencia, etc.
    			</td>
    		</tr>
    		<tr>
    			<td>4</td>
    			<td>NEGRO <img src="images/prioridad3.png" width="25px" height="25px" /></td>
    			<td>
    				Únicamente coincide uno de los siguientes criterios:<br />
					•	cédula,<br />
					•	nombres y apellidos<br />
					•	fecha de nacimiento<br />
					•	nombre de los padres

    			</td>
    			<td>
    				Aunque es probable que se trate de la misma persona, no existe suficiente información para respaldar la orden de captura.
    			</td>
    		</tr>
    	</table>
</div>

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    	'type'=>'danger',
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>

<?php $this->endWidget(); ?>
		 			<div class="row">
		<div class="span9"><?php $this->leyenda($titulo);?></div>
	</div>
	<?php
	$this->renap_fichita($a_datos_renap);?>
<div class="row-fluid">
	<? echo "<div id='informa'><a href='#myModalc' role='button' rel='tooltip' title='Información de prioridades' class='' data-toggle='modal'><img src='images/informa.png' width='30px' height='30px' ></a></div>"; ?>
  <div id='nciudadano' class="span12">

	<?if($prioridad==0){

							}else{
							echo "<div id='ft'><img src='".$prioridad."'></div>";
							}

			 			?></div></div>



<?}

public function datos_ciudadano_renap_id($id_ciudadano_renap=0){
		$dbw = Yii::app()->db->createCommand();
		$dbw->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object

		$estado = 1;
		$datos = $dbw->select('*')
			->from('sapo_gestion.sapogt_ciudadano_renap_t')
			->where('id_ciudadano_renap=:id_ciudadano_renap', array(':id_ciudadano_renap'=>$id_ciudadano_renap))
			->limit('1')
			->queryAll();
			$arreglo_ciudadano_renap = $datos;
		return $arreglo_ciudadano_renap;


	}



public function nombres_ciudadano_orca_bi($id_ciudadano=0){
	if($id_ciudadano>0){


		$datos_captura =Yii::app()->db->createCommand()
					->select('nombres, nombre2, apellidos, apellido2, apellido_casada')
					->from('orca_bi.nombres_ciudadano')
					->where('id_ciudadano=:id_ciudadano ', array(':id_ciudadano'=>$id_ciudadano))
					->queryAll();
		return $datos_captura;

	}else{
		return "Sin nombres para este ciudadano";
	}

}
public function sinonimos_ciudadano_orca_bi($id_ciudadano=0){
	if($id_ciudadano>0){


		$datos_captura =Yii::app()->db->createCommand()
					->select('nombres, nombre2, apellidos, apellido2, apellido_casada')
					->from('orca_bi.sinonimos_ciudadano')
					->where('id_ciudadano=:id_ciudadano ', array(':id_ciudadano'=>$id_ciudadano))
					->queryAll();
		return $datos_captura;

	}else{
		return "Sin nombres para este ciudadano";
	}

}

public function nombres_ciudadano_orca($id_orden_captura_persona=0){
	if($id_orden_captura_persona>0){

		$datos_captura =Yii::app()->db->createCommand()
					->select('primer_nombre, segundo_nombre, tercer_nombre,primer_apellido, segundo_apellido, apellido_casada')
					->from('orca_gestion.ogt_orden_captura_persona')
					->where('id_orden_captura_persona=:id_orden_captura_persona ', array(':id_orden_captura_persona'=>$id_orden_captura_persona))
					->queryRow();
		return $datos_captura;

	}else{
		return "Sin nombres para este ciudadano";
	}

}

public function capturas($data=array())
{

			$i=0;
			$valor = '$data[\'prioridad\']';
			$atributos=array(
							array('name'=>'no', 'header'=>'#'),
							array( 'class'=>'bootstrap.widgets.TbImageColumn',
                					'imagePathExpression'=>$valor,
                					'usePlaceKitten'=>FALSE,
                					'htmlOptions'=>array('style'=>'width: 50px')

               						),
					        array('name'=>'id', 'header'=>'No. de Captura'),
					        array('name'=>'criterio', 'header'=>'Criterios','type'=>'raw'),
					        array('name'=>'nombre_completo', 'header'=>'Nombre Completo','type'=>'raw'),
					        array('name'=>'delito', 'header'=>'Delito', 'type'=>'raw'),


					    );
			if(isset($data['error']) && $data['error']==0){
				unset($data['error']);
				unset($data['solvente']);
					$arreglo_indices=array();


					?>
				<? foreach($data as $result_c){
					foreach($result_c as $result_n){

						foreach($result_n as $result_c){
							$nombre_completo=array();

							$criterio='';
							$prioridad_roja=0;
							$prioridad_amarilla=0;
							$prioridad_negra=0;
							if(isset($result_c['criterio_1'])){
								$prioridad_roja = 2;
								$criterio = "<li>por dpi </li><br>";
							}
							if(isset($result_c['criterio_2'])){
								$criterio = $criterio."<li>por cedula</li><br>";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_amarilla = $prioridad_amarilla+1;
							}
							if(isset($result_c['criterio_3'])){
								$criterio = $criterio."<li>por nombres</li><br>";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_amarilla = $prioridad_amarilla+1;
							}
							if(isset($result_c['criterio_4'])){
								$criterio = $criterio."<li>por fecha nacimiento</li><br>";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_negra = $prioridad_negra+1;
							}
							if(isset($result_c['criterio_5'])){
								$criterio = $criterio."<li>por padres</li><br>";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_negra = $prioridad_negra+1;
							}
							if(isset($result_c['criterio_6'])){
								$criterio = $criterio."<li>por pasaporte</li><br>";
								$prioridad_roja = $prioridad_roja+1;
								$prioridad_negra = $prioridad_negra+1;
							}
							if ($prioridad_roja >=2){
								$prioridad =1;
							}elseif($prioridad_amarilla >=1){
								$prioridad =2;
							}elseif($prioridad_negra >=1){
								$prioridad =3;
							}else{
								$prioridad =0;
							}
							if($prioridad ==1){
								$foto = Yii::app()->request->baseUrl.'/images/prioridad1.png';
							}elseif($prioridad ==2){
								$foto = Yii::app()->request->baseUrl.'/images/prioridad2.png';
							}elseif($prioridad ==3){
								$foto = Yii::app()->request->baseUrl.'/images/prioridad3.png';
							}

						if($prioridad<3){
							$i++;
							$arreglo_delitos['prioridad'] =$foto;
							$arreglo_delitos['no']=$i;
							$arreglo_delitos['criterio']=$criterio;
						if($result_c['tipo']==1){
							$id_ciudadano=$result_c['id_ciudadano'];
							$arreglo_delitos['id_ciudadano']=$id_ciudadano;
							$arreglo_delitos['id']=$result_c['id_captura'];
							$nombres=array();
							$nombres = $this->nombres_ciudadano_orca_bi($id_ciudadano);
									if(sizeof($nombres)>0){
										foreach($nombres as $d_nombres){
											$primer_nombre = $d_nombres['nombres'];
											$segundo_nombre = $d_nombres['nombre2'];
											$primer_apellido = $d_nombres['apellidos'];
											$segundo_apellido = $d_nombres['apellido2'];
											$apellido_casada= $d_nombres['apellido_casada'];
											$nombre_completo[]=$primer_nombre." ".$segundo_nombre." ".$primer_apellido." ".$segundo_apellido." ".$apellido_casada;
										}
									}
							$nombres=array();
							$nombres = $this->sinonimos_ciudadano_orca_bi($id_ciudadano);
									if(sizeof($nombres)>0){
										foreach($nombres as $d_nombres){
											$primer_nombre = $d_nombres['nombres'];
											$segundo_nombre = $d_nombres['nombre2'];
											$primer_apellido = $d_nombres['apellidos'];
											$segundo_apellido = $d_nombres['apellido2'];
											$apellido_casada= $d_nombres['apellido_casada'];
											$nombre_completo[]=$primer_nombre." ".$segundo_nombre." ".$primer_apellido." ".$segundo_apellido." ".$apellido_casada;
										}
									}
									$nombre_texto='';
							foreach($nombre_completo as $key=>$value){

									$nombre_texto="<li>".$nombre_completo[$key]."</li><br>".$nombre_texto;
							}
							}
						if($result_c['tipo']==2){
							$arreglo_delitos['id']=$result_c['id_orden_captura_persona'];
							$id_orden_captura_persona= $result_c['id_orden_captura_persona'];
							$nombres = $this->nombres_ciudadano_orca($id_orden_captura_persona);
							$nombre_texto = implode(' ',$nombres);
						}
						$delitos = $result_c['delitos'];
						$delito_texto="";
						if(is_array($delitos)){
								foreach($delitos as $result_d){
										$delito_texto="<li>".$result_d['descripcion']."</li><br>".$delito_texto;
								}
								$arreglo_delitos['delito']= $delito_texto;
							}
						$arreglo_delitos['nombre_completo']=$nombre_texto;
						$arreglo_final_captura[] =$arreglo_delitos;
						$arreglo_indices[$arreglo_delitos['id']]=$result_c['tipo'];
						}
					}
				}
			}


		if(count($arreglo_indices)>0){
				$titulo= '3. Detalle de Orden de Captura';
				$this->leyenda($titulo);
				$this->grid_detail($arreglo_final_captura,$atributos,$arreglo_indices);
		}else{
				echo '<div class="modal-header">';
				$this->tabla_titulo('Capturas');
				echo '<span class="label label-important">NO TIENE CAPTURAS PENDIENTES</span>';
				echo '</div>';



		}

		}else{
			//	echo "Su Ficha no tiene capturas";
		}


	}

	function obtiene_datos_capturas($id_captura=0,$id_tipo=0){

		if($id_tipo==1){

			$datos_captura =Yii::app()->db->createCommand()
					->selectDistinct('oc.id_captura, oc.id_ciudadano, oc.num_nombre, oc.numero_causa  as causa_no, oc.id_hecho as telefonema, oc.observa_captura as observaciones, oc.estado_captura, oc.fecha_hora_inicial as fecha, oc.cod_depto_juzgado, oc.cod_mun_juzgado, oc.cod_juzgado, oca.anotacion')
					->from('orca_bi.orden_captura oc')
					->leftJoin('orca_bi.orden_captura_anotaciones oca', 'oc.id_captura = oca.id_captura')
					->where('oc.id_captura=:id_captura ', array(':id_captura'=>$id_captura))
					->queryRow();
				$num_nombre =0;
				$num_nombre =$datos_captura['num_nombre'];

		if($num_nombre!=null){
		$datos_ciudadano =Yii::app()->db->createCommand()
					->selectDistinct('nc.nombres_madre,nc.nombre2_madre, nc.apellidos_madre, nc.apellido2_madre, nc.nombres_padre, nc.nombre2_padre, nc.apellidos_padre, nc.apellido2_padre, nc.fecha_nacimiento, nc.lugar_nacimiento, nc.orden_cedula, nc.registro_cedula, nc.cod_depto_cedula, nc.cod_municipio_cedula')
					->from('orca_bi.orden_captura oc')
					->leftJoin('orca_bi.nombres_ciudadano nc', 'oc.id_ciudadano = nc.id_ciudadano')
					->where('oc.id_captura=:id_captura and oc.num_nombre=:num_nombre', array(':id_captura'=>$id_captura, ':num_nombre'=>$num_nombre))
					->queryRow();
		}else{
			$datos_ciudadano =Yii::app()->db->createCommand()
					->selectDistinct('nc.nombres_madre,nc.nombre2_madre, nc.apellidos_madre, nc.apellido2_madre, nc.nombres_padre, nc.nombre2_padre, nc.apellidos_padre, nc.apellido2_padre, nc.fecha_nacimiento, nc.lugar_nacimiento, nc.orden_cedula, nc.registro_cedula, nc.cod_depto_cedula, nc.cod_municipio_cedula')
					->from('orca_bi.orden_captura oc')
					->leftJoin('orca_bi.nombres_ciudadano nc', 'oc.id_ciudadano = nc.id_ciudadano')
					->where('oc.id_captura=:id_captura ', array(':id_captura'=>$id_captura))
					->queryRow();
		}

		$arreglo_total = array_merge($datos_captura,$datos_ciudadano);
		$arreglo_total = $this->llena_arreglo_det_captura($arreglo_total);

		return $arreglo_total;

		}
		elseif($id_tipo==2){

			$query = "Select ocp.id_orden_captura_persona, oc.id_orden_captura, ocp.nombre_madre, ocp.nombre_padre, ocp.fecha_nacimiento, oc.num_telefonema as telefonema, oc.numero_causa as causa_no, oc.observacion as observaciones,
							(ocp.orden_cedula||' '||ocp.registro_cedula||' '||dep.descripcion||' '|| mun.descripcion) as cedula, ocp.lugar_nacimiento,
							oc.fh_emision_captura as fecha, (j.nombre_juzgado||' '|| d.descripcion||' '|| m.descripcion) as juzgado
						from orca_gestion.ogt_orden_captura_persona as ocp
						join orca_gestion.ogt_orden_captura as oc on  ocp.id_orden_captura = oc.id_orden_captura
						left join sapo_gestion.sapogt_juzgado as j on j.id_juzgado = oc.id_juzgado
						left join sapo_gestion.sapogt_renap_departamento as d on d.id_depto = j.cod_depto
						left join sapo_gestion.sapogt_renap_municipio as m on m.id_depto = j.cod_depto and m.id_muni = j.cod_municipio
						left join sapo_gestion.sapogt_renap_departamento as dep on dep.id_depto = ocp.cod_depto_cedula
						left join sapo_gestion.sapogt_renap_municipio as mun on mun.id_depto = ocp.cod_depto_cedula and mun.id_muni = ocp.cod_muni_cedula
						where ocp.id_orden_captura_persona=".$id_captura;

			$datos_captura = Yii::app()->db->createCommand($query)->queryRow();
			$arreglo_total = $this->llena_arreglo_det_captura_sapo($datos_captura);
			return $arreglo_total;



		}



	}


function VistaDetalleCaptura($arreglo=array()){
	foreach($arreglo as $key => $value){
		$columna_det['name'] = $key;
		$columna_det['label'] = str_replace('_', ' ' , $key);
		$columnas[]=$columna_det;
	}

	//$this->tabla_detalle_inside($arreglo,$columnas);
	$this->despliega_orden_captura($arreglo);



}

	function llena_arreglo_det_captura($arreglo=array()){


		foreach($arreglo as $key=>$value){

			if(strlen($arreglo[$key])==0){
			unset($arreglo[$key]);
		}
		}
		if(isset($arreglo['cod_juzgado']) && isset($arreglo['cod_mun_juzgado']) &&  isset($arreglo['cod_depto_juzgado'])  ){
			$arreglo['juzgado']=$this->NombraJuzgado($arreglo['cod_juzgado'],$arreglo['cod_depto_juzgado'],$arreglo['cod_mun_juzgado'],1);
			$depto_juzgado=$this->DeptoRenap($this->DeptoBitoRenap($arreglo['cod_depto_juzgado']));
			$mun_juzgado=$this->MuniRenap($this->DeptoBitoRenap($arreglo['cod_depto_juzgado']),$this->MuniBitoRenap($arreglo['cod_depto_juzgado'],$arreglo['cod_mun_juzgado']));
			$arreglo['juzgado']= $arreglo['juzgado']." ".$depto_juzgado." ".$mun_juzgado;
			unset($arreglo['cod_juzgado']);
			unset($arreglo['cod_mun_juzgado']);
			unset($arreglo['cod_depto_juzgado']);
		}
		if(isset($arreglo['nombres_madre'])){

			$arreglo['madre']= $arreglo['nombres_madre'];
			unset($arreglo['nombres_madre']);
		}if(isset($arreglo['nombre2_madre'])) {

			if(isset($arreglo['madre'])){
				$arreglo['madre']= $arreglo['madre']." ".$arreglo['nombre2_madre'];
			 }else{
			 	$arreglo['madre']= $arreglo['nombre2_madre'];
			 }

			unset($arreglo['nombre2_madre']);

		}if (isset($arreglo['apellidos_madre'])){
			 if(isset($arreglo['madre'])){
				$arreglo['madre']= $arreglo['madre']." ".$arreglo['apellidos_madre'];
			 }else{
			 	$arreglo['madre']= $arreglo['apellidos_madre'];
			 }

			unset($arreglo['apellidos_madre']);

		}if(isset($arreglo['apellido2_madre'])){
			if(isset($arreglo['madre'])){
				$arreglo['madre']= $arreglo['madre']." ".$arreglo['apellido2_madre'];
			 }else{
			 	$arreglo['madre']= $arreglo['apellido2_madre'];
			 }

			unset($arreglo['apellido2_madre']);
		}
		if(isset($arreglo['nombres_padre'])){

			 	$arreglo['padre']= $arreglo['nombres_padre'];

			unset($arreglo['nombres_padre']);
		}if(isset($arreglo['nombre2_padre'])) {

			if(isset($arreglo['padre'])){
				$arreglo['padre']= $arreglo['padre']." ".$arreglo['nombre2_padre'];
			 }else{
			 	$arreglo['padre']= $arreglo['nombre2_padre'];
			 }
			unset($arreglo['nombre2_padre']);

		}if (isset($arreglo['apellidos_padre'])){

			if(isset($arreglo['padre'])){
				$arreglo['padre']= $arreglo['padre']." ".$arreglo['apellidos_padre'];
			 }else{
			 	$arreglo['padre']= $arreglo['apellidos_padre'];
			 }

			unset($arreglo['apellidos_padre']);
		}if(isset($arreglo['apellido2_padre'])){
						if(isset($arreglo['padre'])){
				$arreglo['padre']= $arreglo['padre']." ".$arreglo['apellido2_padre'];
			 }else{
			 	$arreglo['padre']= $arreglo['apellido2_padre'];
			 }


			unset($arreglo['apellido2_padre']);
		}
		$arreglo['cedula']='';
		if(isset($arreglo['orden_cedula'])){
			$arreglo['cedula']=$arreglo['orden_cedula'];
			unset($arreglo['orden_cedula']);
		}
		if(isset($arreglo['registro_cedula'])){
			if(isset( $arreglo['cedula'])){
				$arreglo['cedula'] = $arreglo['cedula']." ".$arreglo['registro_cedula'];
			}else{
				$arreglo['cedula'] = $arreglo['registro_cedula'];
			}

			unset($arreglo['registro_cedula']);
		}
		if(isset($arreglo['cod_depto_cedula']) ){
			$depto_cedula = $this->DeptoRenap($this->DeptoBitoRenap($arreglo['cod_depto_cedula']));
			$arreglo['cedula'] = $arreglo['cedula']." ".$depto_cedula;
				if(isset($arreglo['cod_municipio_cedula'])){
						$mun_cedula=$this->MuniRenap($this->DeptoBitoRenap($arreglo['cod_depto_cedula']),$this->MuniBitoRenap($arreglo['cod_depto_cedula'],$arreglo['cod_municipio_cedula']));
						$arreglo['cedula'] = $arreglo['cedula']." ".$mun_cedula;
						unset($arreglo['cod_municipio_cedula']);
					}
			unset($arreglo['cod_depto_cedula']);
		}else{
			if(isset($arreglo['cod_municipio_cedula'])){
						unset($arreglo['cod_municipio_cedula']);
			}
		}
	unset($arreglo['id_captura']);
	unset($arreglo['id_ciudadano']);
	unset($arreglo['num_nombre']);
	return $arreglo;
	}
	function llena_arreglo_det_captura_sapo($arreglo=array()){
		foreach($arreglo as $key=>$value){
			if(strlen($arreglo[$key])==0){
				unset($arreglo[$key]);
			}
		}
	return $arreglo;
	}

/**/
public static function detect() {
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

        // Identify the browser. Check Opera and Safari first in case of spoof. Let Google Chrome be identified as Safari.
        if (preg_match('/opera/', $userAgent)) {
            $name = 'opera';
        }
        elseif (preg_match('/webkit/', $userAgent)) {
if (preg_match('/chrome/', $userAgent)) {
$name = 'chrome';
}
else {
$name = 'safari';
}
        }
        elseif (preg_match('/msie/', $userAgent)) {
            $name = 'msie';
        }
        elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) {
            $name = 'mozilla';
        }
        else {
            $name = 'unrecognized';
        }

        // What version?
        if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) {
            $version = $matches[1];
        }
        else {
            $version = 'unknown';
        }

        // Running on what platform?
        if (preg_match('/linux/', $userAgent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/', $userAgent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/', $userAgent)) {
            $platform = 'windows';
        }
        else {
            $platform = 'unrecognized';
        }

        return array(
            'name'      => $name,
            'version'   => $version,
            'platform'  => $platform,
            'userAgent' => $userAgent
        );
    }
public function detalle_delitos($data_renap=array(),$data_dpi=array(),$dpi=0, $id_ciudadano_renap=0){
	$this->datosciudadano($data_renap);
	$this->delitos($data_dpi,$dpi,$id_ciudadano_renap);

}
public function delitos($data_dpi=array(),$dpi=0,$id_ciudadano_renap=0)
{

			$arreglo_final_ante=array();

			if($dpi>0){
				$data = $data_dpi;

			}else{
				$data = $this->datos_ciudadano($id_ciudadano_renap);
			}
			$atributos=array(array('name'=>'id', 'header'=>'#'),array('name'=>'id_ficha', 'header'=>'No. de Ficha'),array('name'=>'delito', 'header'=>'Delito'),array('name'=>'fecha_emision', 'header'=>'Fecha de emisión'),);

		if(isset($data['error']) && $data['error']==0 && $data['solvente']>0){
		 	unset($data['error']);
			unset($data['solvente']);
			foreach($data as $result){
						$ficha = $result['fichas'];
					$i=0;
					foreach($ficha as $result_f){
						$f_ficha= $result_f['id_ficha'];
						$delito = $result_f['delitos'];
						foreach($delito as $result_d){
							$i++;
							$arreglo_ante['id']=$i;
							$arreglo_ante['id_ficha']=$f_ficha;
							$arreglo_ante['delito']=$result_d['delito'];

							if(strlen($result_d['fecha_emision'])>0){
								$date = new DateTime($result_d['fecha_emision']);
								$arreglo_ante['fecha_emision']=$date->format('d/m/Y');
								$arreglo_ante['fecha_emision']='hola';

							}else{
								$arreglo_ante['fecha_emision']='hola';
							}

							$arreglo_final_ante[]=$arreglo_ante;
						}
					}
			}
			$titulo= '2. Antecedentes';
			$this->leyenda($titulo);
			$this->tabla($atributos,$arreglo_final_ante);
		}else{
			$this->tabla_titulo('Solvente');
			/*$titulo= '2. Antecedentes';
			$this->leyenda($titulo);
			echo "<pre>No hay antecedentes para este ciudadano.</pre><br><br>";*/
		}

	}

public function datos_ciudadano($id_ciudadano=0){
		$dbw = Yii::app()->db->createCommand();
		$dbw->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object

		$estado = 1;
		$dbw->select('*')
			->from('sapo_gestion.sapogt_ciudadano_cedula')
			->where('id_ciudadano_renap=:id_ciudadano_renap', array(':id_ciudadano_renap'=>$id_ciudadano))
			->limit('1');

		$arreglo_ciudadano = $dbw->queryAll();

		$retorna = $this->asigna_variables_cedula($arreglo_ciudadano);

		if($retorna){
			$data = $this->ws_jazz($this->primer_nombre,$this->segundo_nombre,$this->tercer_nombre,$this->primer_apellido,$this->segundo_apellido,$this->apellido_casada,$this->fecha_nacimiento,$this->nombre_padre,$this->nombre_madre,$this->orden_cedula,$this->registro_cedula, $this->nacionalidad_cod,$this->cod_depto_cedula, $this->cod_munic_cedula, $this->pais_nacimiento_cod, $this->depto_nacimiento_cod,$this->munic_nacimiento_cod,$this->genero,$this->estado_civil);
			return $data;
		}

	}
		public function asigna_variables_cedula($arreglo_ciudadano){
		foreach ($arreglo_ciudadano as $row) {
			$this->primer_nombre=$row->primer_nombre;
			$this->segundo_nombre=$row->segundo_nombre;
			$this->tercer_nombre=$row->tercer_nombre;
			$this->primer_apellido=$row->primer_apellido;
			$this->segundo_apellido=$row->segundo_apellido;
			$this->apellido_casada=$row->apellido_casada;
			$this->id_cedula = $row->id_cedula;
			$this->id_ciudadano_cedula = $row->id_ciudadano_cedula;
			$this->cod_depto_cedula = $row->cod_depto_cedula;
			$this->cod_munic_cedula = $row->cod_munic_cedula;
			$this->registro_cedula = $row->registro_cedula;
			$this->orden_cedula = $row->orden_cedula;
			$this->fecha_nacimiento = str_replace('-', '/', substr($row->fecha_nacimiento,0,10));
			$this->nombre_padre = $row->nombre_padre;
			$this->nombre_madre = $row->nombre_madre;
			$this->nacionalidad_cod = $row->nacionalidad_cod;
			$this->pais_nacimiento_cod = $row->pais_nacimiento_cod;
			$this->depto_nacimiento_cod = $row->depto_nacimiento_cod;
			$this->munic_nacimiento_cod = $row->munic_nacimiento_cod;
			$this->genero = $row->genero;
			$this->estado_civil = $row->estado_civil;
			return true;
	  }

	}

public function conteo_datos($datos_c = array(), $antecedentes=0,$dpi=0){



}
////////////////webservices

public function ws_citripio_dpi($dpi=0)
{
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_CT, "uri"=>URL_WS_CT));
		$data = $ws_cliente->BuscaDetalleAntecedentes($dpi,CLIENTE,Yii::app()->user->name);
		return $data;
}
public function ws_bombolbi($primer_nombre='',$segundo_nombre='',$primer_apellido='',$segundo_apellido='',$fecha_nacimiento='')
	{
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_BB, "uri"=>URL_WS_BB));
		$data = $ws_cliente->DatosCiudadanoNombres_Renap($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$fecha_nacimiento,CLIENTE,Yii::app()->user->name);
		return $data;
	}
public function ws_jazz($primer_nombre='',$segundo_nombre='',$tercer_nombre='',$primer_apellido='',$segundo_apellido='',$apellido_casada='',$fecha_nacimiento='',$nombre_padre='',$nombre_madre='',$orden_cedula='',$registro_cedula='', $nacionalidad_cod='',$cod_depto_cedula='', $cod_munic_cedula='', $pais_nacimiento_cod='', $depto_nacimiento_cod='',$munic_nacimiento_cod='',$genero='',$estado_civil='')
{		$dpi=0;
		$id_ciudadano_renap=0;
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_JZ, "uri"=>URL_WS_JZ));
		$data = $ws_cliente->BuscaAntecedentes($dpi,CLIENTE,$id_ciudadano_renap,$primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada,$fecha_nacimiento,$nombre_padre,$nombre_madre,$orden_cedula,$registro_cedula, $nacionalidad_cod,$cod_depto_cedula, $cod_munic_cedula, $pais_nacimiento_cod, $depto_nacimiento_cod,$munic_nacimiento_cod,$genero,$estado_civil,Yii::app()->user->name);
		return $data;
}

////////////////////---------llamada a las funciones de ENma
	// Genera una ventana de alerta para algun mensaje dependiendo su clase
	public function a_error($clase='',$mensaje='',$error='') //clase = error, info, success (ver main.css y bootstrap.css)
	{														 //Mensaje: Encabezado de la ventana
		echo "<div id='mens2' class='$clase'>";				 //Error: Mensaje que se quiere desplegar (puede ser un array de mensajes)
		echo "<button type='button' class='close' data-dismiss='alert'>x</button>";
		echo "<h3>$mensaje</h3>";
		if (is_array($error)) {
			$i=1;
			foreach($error as $er){
				echo $i++." - ".$er."<br>";
			}
		}
		else{
			echo $error;
		}
		echo "</div>";
	}
	//
	public function muestra_antecedentes_capturas_gestion($dpi=0,$gestion_url='')
	{
		$data = '';
		$data_op = '';

		// Consulta el DPI que se obtiene en el web service citripio para saber el detalle de sus antecedentes (fichas y delitos)
		$data =$this->consulta_citripio($dpi);
		/*echo Yii::app()->user->name;
		print_r($data);
		exit();*/

		// Si la consulta al web service citripio tiene error lo muestra
		$id_ciudadano_renap=0;
		if ($data['error'] <> 0) {
			echo "error";
			$this->a_error('alert-error','ERROR',$data['descripcion']);
		}
		elseif ($data['error']==0 && $data['solvente']>0){
			unset($data['error']);
			$tiene_antecedentes = $data['solvente'];
			unset($data['solvente']);

			foreach($data as $datos){
				$id_ciudadano_renap = $datos['id_ciudadano_renap'];

			}

			if($id_ciudadano_renap==0){

				$this->redirect('index.php?r=/solvenciadpi/solvencia');
			}


			//********************************
			//*****		ANTECEDENTES    ******
			//********************************
			$error = '';
			// Muestra en pantalla los resultados
			if (strlen($error)>0) {
				$this->a_error('alert-error','ERROR',$error);
			}
			elseif ($tiene_antecedentes>0) {
				echo '<div class="modal-header">';
				$this->leyenda('2. Antecedentes');
				// Muestra en un grid las fichas para la gestion de homonimos

				$dataProvider = $this->muestraFichas($data,$dpi,$id_ciudadano_renap);
				$this->widget('bootstrap.widgets.TbGridView', array(
					'id'=>'ficha-grid',
					'dataProvider'=>$dataProvider,
					//'selectionChanged'=>'userClicks',
					'columns' => array(
						array(
								'name'  => '#',
								'value' => '$data["#"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Ficha',
								'value' => '$data["id_ficha"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Expediente',
								'value' => '$data["num_expediente"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Fecha',
								'value' => '$data["fecha"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Juzgado',
								'value' => '$data["juzgado"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Delitos',
								'value' => '$data["delitos"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Criterios',
								'value' => '$data["criterios"]',
								'type'  => 'raw',
							),
						//<form action="'.Yii::app()->createUrl("gestionhomonimo/informacion_ficha").'" method="post" target="_blank">
						array(
							 	 'header'=>'Ver Detalle',
							 	 'type'=>'raw',
							      'value'=>'\'

								           <form action="'.Yii::app()->createUrl($gestion_url).'" method="post" target="_blank">
								             <input type="hidden" name="id_ficha" readonly="readonly" value="\'.$data["id_ficha"].\'"/>
								             <input type="hidden" name="tipo" readonly="readonly" value="\'.$data["tipo"].\'"/>
								             <input type="hidden" name="id_ciudadano_renap" readonly="readonly" value="\'.$data["id_ciudadano_renap"].\'"/>
								             <input type="image" src="images/vista_previa.jpg" height="30" width="173" border="0" onmouseover="this.src=" alt="submit form">
								           </form>\'',
							),
						),
					)
				);

				echo '</div>';
			}
			else{
				echo '<div class="modal-header">';
				$this->tabla_titulo('Antecedentes');
				echo '<span class="label label-important">NO TIENE ANTECEDENTES</span>';
				echo '</div>';
			}

		}//fin elseif
		else{
			echo '<div class="modal-header">';
				$this->tabla_titulo('Antecedentes');
				echo '<span class="label label-important">NO TIENE ANTECEDENTES</span>';
				echo '</div>';
		}



	}




// Retorna los datos del ciudadano según el id que recibe
	public function trae_datos_ciudadano_renap($id_ciudadano_renap=0,$dpi=0)
	{
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);
		$a_valores = array();
		if ($id_ciudadano_renap > 0) {
			$conn->select('*, soundexesp(primer_nombre) as primer_nombre_sndex, soundexesp(segundo_nombre) as segundo_nombre_sndex, soundexesp(tercer_nombre) as tercer_nombre_sndex,soundexesp(primer_apellido) as primer_apellido_sndex, soundexesp(segundo_apellido) as segundo_apellido_sndex, soundexesp(apellido_casada) as apellido_casada_sndex')
				 ->from('sapo_gestion.sapogt_ciudadano_renap_t')
				 ->where('id_ciudadano_renap=:id_ciudadano_renap', array(':id_ciudadano_renap'=>$id_ciudadano_renap));
			$a_valores = $conn->queryAll();

		}
		elseif($dpi > 0){
			$conn->select('*, soundexesp(primer_nombre) as primer_nombre_sndex, soundexesp(segundo_nombre) as segundo_nombre_sndex, soundexesp(tercer_nombre) as tercer_nombre_sndex, soundexesp(primer_apellido) as primer_apellido_sndex, soundexesp(segundo_apellido) as segundo_apellido_sndex, soundexesp(apellido_casada) as apellido_casada_sndex')
			 ->from('sapo_gestion.sapogt_ciudadano_renap_t')
			 ->where('dpi=:dpi', array(':dpi'=>$dpi));
			$a_valores = $conn->queryAll();
		}
		return $a_valores;
	}

public function muestra_datos_ciudadano_renap($a_datos_renap=''){
		foreach($a_datos_renap as $arr_info){
			$nombre = $this->formato_nombre_completo($arr_info->primer_nombre,$arr_info->segundo_nombre,$arr_info->tercer_nombre,$arr_info->primer_apellido,$arr_info->segundo_apellido,$arr_info->apellido_casada);
			$fecha = Yii::app()->dateformatter->format("dd",$arr_info->fecha_nacimiento)." de ".$this->trae_nombre_mes(Yii::app()->dateformatter->format("M",$arr_info->fecha_nacimiento))." de ".Yii::app()->dateformatter->format("yyyy",$arr_info->fecha_nacimiento). ", Edad: ".$this->trae_edad($arr_info->fecha_nacimiento). " años";
			$datos_busqueda['dpi']= $arr_info->dpi;
			$datos_busqueda['nombre'] = $nombre;
			$datos_busqueda['fecha_nacimiento'] = $fecha;
			$datos_busqueda['lugar_nacimiento'] = $arr_info->pais_nacimiento."-".$arr_info->depto_nacimiento."-".$arr_info->munic_nacimiento;
			$datos_busqueda['cedula']=$arr_info->orden_cedula." ".$arr_info->registro_cedula." ".$arr_info->depto_cedula." ".$arr_info->munic_cedula;
			$datos_busqueda['genero'] = $this->busca_criterio_fijo($arr_info->genero,2);
			$datos_busqueda['estado_civil'] = $this->busca_criterio_fijo($arr_info->estado_civil,3);
			$datos_busqueda['nacionalidad']=$arr_info->nacionalidad;
			$datos_busqueda['reg_nac'] ="Libro de Nacimiento: ".$arr_info->libro_nac." -- Partida de Nacimiento: ". $arr_info->partida_nac;
			$datos_busqueda['padres']= "Madre:".$arr_info->nombre_madre." Padre:".$arr_info->nombre_padre;
			$foto = $arr_info->foto;
			$columnas= array(
			array('name'=>'dpi', 'label'=>'<i class="icon-search"></i>DPI:'),
			array('name'=>'nombre', 'label'=>'Nombre completo del ciudadano:'),
			array('name'=>'fecha_nacimiento', 'label'=>'Fecha de Nacimiento:'),
			array('name'=>'lugar_nacimiento', 'label'=>'Lugar de Nacimiento:'),
			array('name'=>'cedula', 'label'=>'Cedula de Vecindad'),
			array('name'=>'genero', 'label'=>'G&eacute;nero:'),
			array('name'=>'estado_civil', 'label'=>'Estado Civil:'),
			array('name'=>'nacionalidad', 'label'=>'Nacionalidad:'),
			array('name'=>'reg_nac', 'label'=>'Registro de Nacimiento:'),
			array('name'=>'padres', 'label'=>'Madre y Padre del Ciudadano:'),
			);
			?>
			<div class="row-fluid">
			  <div class="span8"><?$this->tabla_detalle($datos_busqueda,$columnas);?></div>
			  <div class="span4"><?

			  if($foto==NULL)
			  {
			  	//	echo "no tiene fotografia";
			  }else{
			  	$res = $foto;

			  	$xml = new SimpleXMLElement($res);
			  	$newdataset = $xml->children();
			  	$objetos = get_object_vars($newdataset);
			  	$fotica=$objetos['PortraitImage'];
			  	echo '<img src="data:image/png;base64,'.$fotica.'" width="300" height="300">';

			  }

			  ?></div>
			</div><?
		}// fin de for

	}

public function formato_nombre_completo($primer_nombre='',$segundo_nombre='',$tercer_nombre='',$primer_apellido='',$segundo_apellido='',$apellido_casada='')
	{
		$nombre = trim($primer_nombre);
		if (strlen($segundo_nombre)>0) {
			$nombre .= " ".trim($segundo_nombre);
		}
		else{
			$nombre .= "";
		}
		if (strlen($tercer_nombre)>0) {
			$nombre .= " ".trim($tercer_nombre);
		}
		else{
			$nombre .= "";
		}

		$nombre .= " ".trim($primer_apellido);

		if (strlen($segundo_apellido)>0) {
			$nombre .= " ".trim($segundo_apellido);
		}
		else{
			$nombre	.= "";
		}
		if (strlen($apellido_casada)>0) {
			$nombre .= " de ".trim($apellido_casada);
		}
		else{
			$nombre .= "";
		}
		return $nombre;
	}


	public function trae_nombre_mes($mes=0){
		$nombre_mes = '';
		switch($mes){
			case 1:
				$nombre_mes = 'Enero';
				break;
			case 2:
				$nombre_mes = 'Febrero';
				break;
			case 3:
				$nombre_mes = 'Marzo';
				break;
			case 4:
				$nombre_mes = 'Abril';
				break;
			case 5:
				$nombre_mes = 'Mayo';
				break;
			case 6:
				$nombre_mes = 'Junio';
				break;
			case 7:
				$nombre_mes = 'Julio';
				break;
			case 8:
				$nombre_mes = 'Agosto';
				break;
			case 9:
				$nombre_mes = 'Septiembre';
				break;
			case 10:
				$nombre_mes = 'Octubre';
				break;
			case 11:
				$nombre_mes = 'Noviembre';
				break;
			case 12:
				$nombre_mes = 'Diciembre';
				break;
		} // switch
		return $nombre_mes;
	}


	public function trae_edad($fecha_nacimiento = ''){
		$fechanacimiento = substr($fecha_nacimiento, 0 , 10);
	$dia=date("j");
			$mes=date("n");
			$anno=date("Y");

				// separamos las dia, mes y anio
				$dia_nac = substr($fechanacimiento, 8,2);
				$mes_nac = substr($fechanacimiento, 5,2);
				$anno_nac = substr($fechanacimiento, 0,4);

			if($mes_nac>$mes){
			$calc_edad= $anno-$anno_nac-1;
			}else{
			if($mes==$mes_nac AND $dia_nac>$dia){
			$calc_edad= $anno-$anno_nac-1;
			}else{
			$calc_edad= $anno-$anno_nac;
			}
			}
			return $calc_edad;
	}


	// Retorna la descripción del criterio fijo según la opción y el criterio que recibe
	public function busca_criterio_fijo($id_opcion=0,$id_criterio=0)
	{
		$valor='';
		$sql = "SELECT descripcion FROM sapo_gestion.sapogt_criterio_fijo where id_criterio_fijo = ".$id_criterio." and id_opcion = ".$id_opcion." and estado = 1";
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ); //fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {
			$valor = $resultado->descripcion;
		}
		return $valor;
	}

// Consulta webservice citripio (Detalle antecedentes)
	public function consulta_citripio($dpi=0){
		$data = "";
		$ws_cliente = new SoapClient(null, array("location"=>URL_WS_CT, "uri"=>URL_WS_CT));
		// "trae_datos_citripio" se llama la función del web service citripio
		$data = $ws_cliente->BuscaDetalleAntecedentes($dpi,CLIENTE,FALSE,Yii::app()->user->name); // cliente es una constante en config.inc.php
		return $data;
	}

public function muestraFichas($data='',$dpi=0,$id_ciudadano_renap=0){// Opcion 1= Ingreso de Ficha, 2= Gestion de Homonimos
		$a_datos = array();
		$arreglo_fichas = array();
		$arreglo_fichas_delitos = array();
		$a_delitos = array();
		$arreglo_delitos = array();
		$agrupa_delitos = array();
		$i = 1;

		foreach($data as $datos){
			$a = $datos['fichas'];
			foreach($a as $num_ficha => $datos_ficha){
				if ($datos_ficha['tipo'] == 1) {
					// Busqueda en BI
					$sql = "SELECT f.id_ficha_bi as id_ficha, c.expediente as num_expediente, f.fecha_emision, j.nombre_juzgado, r1.descripcion as depto, r2.descripcion as munic
							FROM bi.fichas f
							LEFT JOIN bi.ciudadanos1 c ON f.id_ciudadano = c.id_ciudadano
							LEFT JOIN bi.juzgados j ON f.cod_juzgado = j.cod_juzgado AND f.cod_depto_juzgado = j.cod_depto AND f.cod_municipio_juzgado = j.cod_municipio
							LEFT JOIN bi.geo_traductor g1 ON g1.cod_depto_oracle = f.cod_depto and g1.cod_muni_oracle = f.cod_municipio
							LEFT JOIN sapo_gestion.sapogt_renap_departamento r1 ON r1.id_depto = g1.cod_depto_renap
							LEFT JOIN sapo_gestion.sapogt_renap_municipio r2 ON r2.id_muni = g1.cod_muni_renap and r2.id_depto = g1.cod_depto_renap
							WHERE f.id_ficha_bi = ".$datos_ficha['id_ficha'];
					$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
				}else{
					// Busqueda en SAPO
					$sql = "SELECT 	f.id_ficha_criminal as id_ficha, f.num_expediente, f.fecha_emision, j.nombre_juzgado, r1.descripcion as depto, r2.descripcion as munic
							FROM sapo_gestion.sapogt_ficha_criminal f
							LEFT JOIN sapo_gestion.sapogt_juzgado j ON f.cod_juzgado = j.id_juzgado
							LEFT JOIN sapo_gestion.sapogt_renap_departamento r1 ON r1.id_depto = f.cod_depto_emision_ficha
							LEFT JOIN sapo_gestion.sapogt_renap_municipio r2 ON r2.id_muni = f.cod_muni_emision_ficha AND r2.id_depto = f.cod_depto_emision_ficha
							WHERE id_ficha_criminal = ".$datos_ficha['id_ficha'];
					$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
				}// fin del else

				foreach ($respuesta as $info_ficha){
					$id_ficha = $info_ficha['id_ficha'];
					$num_expediente = $info_ficha['num_expediente'];
					$tipo_schema = $datos_ficha['tipo']; // 1: BI 2: Sapo
					$arreglo_fichas['id_ficha'] = $info_ficha['id_ficha'];
					$arreglo_fichas['id_ciudadano_renap'] = $id_ciudadano_renap;
					$arreglo_fichas['num_expediente'] = $info_ficha['num_expediente'];
					$arreglo_fichas['tipo'] = $datos_ficha['tipo'];
					$date = new DateTime($info_ficha['fecha_emision']);
					$arreglo_fichas['fecha'] =$date->format('d/m/Y');
					if(strlen($info_ficha['fecha_emision'])>0){
						$arreglo_fichas['fecha_sort'] = $arreglo_fichas['fecha'];
					}else{
						$arreglo_fichas['fecha_sort'] = '01/01/0001';
					}

					$arreglo_fichas['juzgado'] = $info_ficha['nombre_juzgado'].",".$info_ficha['depto'].",".$info_ficha['munic'];
					$arreglo_fichas['departamento'] = $info_ficha['depto'];
					$arreglo_fichas['municipio'] = $info_ficha['munic'];
					$arreglo_fichas['criterios'] = $this->muestraCriteriosFichas($info_ficha['id_ficha'],$datos_ficha['tipo'],$id_ciudadano_renap);

					$delitos = $datos_ficha['delitos'];
					$delito_texto="";
					if(is_array($delitos)){
							foreach($delitos as $result_d){
									$delito_texto="<li>".$result_d['delito']."</li><br>".$delito_texto;
							}
							$arreglo_fichas['delitos']= $delito_texto;
						}

				}// fin for
				$a_datos[] = $arreglo_fichas;
			}// fin del for
		}//fin for

		// Se ordena el arreglo por el campo fecha_sort

		$arreglo_ordenado = $this->orderMultiDimensionalArray($a_datos,'fecha_sort',false);
		$arreglo_final = array();
		$i = sizeof($a);
		foreach($arreglo_ordenado as $datos){
			$datos['#']=$i; // Se agrega al arreglo el numero de fila
			$i--;
			$arreglo_final[] =$datos;
		}

		$count = sizeof($arreglo_final);
		// Se crea el dataprovider para el griedview
		$dataProvider = new CArrayDataProvider(
		$arreglo_final, array(
				'keyField' => 'id_ficha',
		        'sort'=>array(
		        	'attributes'=>array('fecha_sort'),
		        	'defaultOrder'=>'fecha_sort DESC',
		        	//'defaultOrder'=>array('id_ficha' => false),
				    ),
		        'totalItemCount'=>$count,
		        'pagination'=>false,
			)
		);

		return $dataProvider;
	}

public function muestraCriteriosFichas($id_ficha=0,$tipo=0,$id_ciudadano_renap=0){
		$a_criterios = array();
		$str_criterios = '';
		if ($tipo == 1) {
			$sql = "SELECT 	criterio
						FROM sapo_gestion.sapogt_consulta_fichas_vp
						WHERE id_ficha = ".$id_ficha." and estado = 1 and id_ciudadano_renap=".$id_ciudadano_renap."
						GROUP BY criterio Order by criterio";


		}

		else
		{
			$sql = "SELECT 	criterio
					FROM sapo_gestion.sapogt_consulta_fichas_vps
					WHERE id_ficha_criminal = ".$id_ficha." and estado = 1 and id_ciudadano_renap=".$id_ciudadano_renap."
					GROUP BY criterio Order by criterio";

		}

		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $a) {
			foreach($a as $b){
				switch ($b) {
					case 1:
						$a_criterios[] = 'DPI';
						break;
					case 2:
						$a_criterios[] = 'Cedula';
						break;
					case 3:
						$a_criterios[] = 'Nombres';
						break;
					case 4:
						$a_criterios[] = 'Fecha Nacimiento/Nombres Padres';
						break;
				/*	case 5:
						$a_criterios[] = 'Pasaporte';
						break;*/
					case 6:
						$a_criterios[] = 'Alias';
						break;
					case 7:
						$a_criterios[] = 'Reincidencia';
						break;
				}// fin switch
			}//fin for
		}// fin for
	if(is_array($a_criterios)){
		foreach($a_criterios as $criterios){
			$str_criterios .= '*'.$criterios.' ';
		}
	}
		return $str_criterios;

	}




	public function mostrar_modal_gestion_homonimo($id_ficha=0,$num_expediente=0,$dpi=0,$tipo_schema=0,$id_ciudadano_renap=0,$arreglo_delitos='')
	{
		$nombre = '';
		$datos_renap = $this->trae_datos_ciudadano_renap($id_ciudadano_renap);
		foreach($datos_renap as $datos){
			$nombre = trim($datos->primer_nombre);

			if (strlen($datos->segundo_nombre)>0) {
				$nombre .= " ".trim($datos->segundo_nombre);
			}
			else{
				$nombre .= "";
			}
			if (strlen($datos->tercer_nombre)>0) {
				$nombre .= " ".trim($datos->tercer_nombre);
			}
			else{
				$nombre .= "";
			}

			$nombre .= " ".trim($datos->primer_apellido);

			if (strlen($datos->segundo_apellido)>0) {
				$nombre .= " ".trim($datos->segundo_apellido);
			}
			else{
				$nombre	.= "";
			}
			if (strlen($datos->apellido_casada)>0) {
				$nombre .= " de ".trim($datos->apellido_casada);
			}
			else{
				$nombre .= "";
			}
		}
		$nombres_schema_sapo = '';
		$nombres_schema_bi = '';
		if ($tipo_schema == 1) {
			$id_ciudadano_bi = $this->trae_id_ciudadano_bi($id_ficha);
			$nombres_ciudadano = $this->trae_nombres_ciudadano_bi($id_ciudadano_bi);
			foreach($nombres_ciudadano as $dato_nombre){
				$nombres_schema_bi .= $dato_nombre['nombre']." ";
			}
			$sinonimos = $this->trae_sinonimos_bi($id_ciudadano_bi);
			if(count($sinonimos)>0){
				foreach($sinonimos as $dato_sinonimo){
					$nombres_schema_bi .= ", alias: ".$dato_sinonimo['nombre'];
				}
			}
			else{
				$nombres_schema_bi = $nombres_schema_bi;
			}
			$apodos = $this->trae_apodos_bi($id_ciudadano_bi);
			if(count($apodos)>0){
				foreach($apodos as $dato_apodo){
					$nombres_schema_bi .= ", alias: ".$dato_apodo['nombre_apodo'];
				}
			}
			else{
				$nombres_schema_bi = $nombres_schema_bi;
			}
		}
		elseif($tipo_schema == 2){
			$ficha_sapo = $this->trae_fichas_sapo($id_ficha);
			if(count($ficha_sapo)>0){
				foreach($ficha_sapo as $dato_ficha){
					$nombres_schema_sapo = $dato_ficha['nombre'];
				}
			}
			else{
				$nombres_schema_sapo = $nombres_schema_sapo;
			}
		}
	?>
		<script type="text/javascript">
			function userClicks(id_ficha) {
				id_modal = parseInt($.fn.yiiGridView.getSelection(id_ficha));
				$("#myModalGH"+id_modal).modal('show');
	        }

			$(document).ready(function() {
			     /*
			     $('input[type="submit"]').attr('disabled','disabled');
			     $('input[type="text"]').keyup (function() {
				     if ($(this).val().length == 0) {
					    $(":submit").attr("disabled", true);
					  } else {
					    $(":submit").removeAttr("disabled");
					  }
			     });
			     */
			     $('input#upload', this).attr('disabled','disabled');
			     $('textarea#resolucion').keyup (function() {
				     if (($(this).val().length == 0)&&($('input#archivo1').val().length == 0)) {
					    $('input#upload').attr("disabled", true);
					  } else {
					    $('input#upload').removeAttr("disabled");
					  }
			     });
			 });
		</script>
	<?
	$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModalGH'.$id_ficha)); ?>
    	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="myModalLabel">GESTION HOMONIMOS #<? echo $id_ficha; ?> - Expediente No. <? echo $num_expediente; ?> </h3>
		</div>
		<form enctype="multipart/form-data" id = "formulario" name="formulario" method="post" action="index.php?r=FichaCriminal/guarda_gestion_homonimo">
		<div class="modal-body">
				<input id="tipo_schema" type="hidden" name="tipo_schema" value="<?php echo $tipo_schema; ?>" readonly>
				<input id="id_ciudadano_renap" type="hidden" name="id_ciudadano_renap" value="<?php echo $id_ciudadano_renap; ?>" readonly>
				<input id="id_ficha" type="hidden" name="id_ficha" value="<?php echo $id_ficha; ?>" readonly>
				<table bgcolor="#f4f4f4">
					<tr>
						<td style="border-bottom:1px solid black; ">
							<p>
						Por este medio Yo: <b><? echo $this->username; ?></b> he revisado los datos del ciudadano <b><? echo $nombre; ?></b>
						que se identifica con DPI: <b><? echo $dpi; ?></b>, y tras realizar un cotejo de huellas se determina
						que  este ciudadano <b>NO</b> es la persona que esta registrada en el expediente No.<? echo $num_expediente; ?>
						con el nombre de
						<?
						if ($tipo_schema == 1) {
							echo $nombres_schema_bi;
						}
						elseif($tipo_schema == 2){
						}
						echo $nombres_schema_sapo;
						?>
						.<br>
						Y para los usos que el interesado convenga.<br>
						Ratifico.<br>
						Fecha: <? echo date('d'); ?> de <? echo $this->trae_nombre_mes(date('m')); ?> de <? echo date('Y'); ?>.
						</p>
					</td>
				</tr>
				<tr>
				<td style="border-bottom:1px solid black; ">
					Resolucion:<textarea id="resolucion" name="resolucion" ROWS=3 COLS=30></textarea>
				</td>
				</tr>
				<tr>
				<td style="border-bottom:1px solid black; ">
					<input name="archivo" type="file" id="archivo" size="50">
				</td>
				</tr>
			</table>
		</div>
		<div class="modal-footer">
		<table>
			<tr>
				<td colspan="2" style="text-align: center">
				<input class="btn btn-success" name="upload" type="submit" id="upload" value="GUARDAR">
				</td>
				<td colspan="2" style="text-align: center">
				<? $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'CERRAR',
				'url'=>'#',
				'htmlOptions'=>array('class'=>'btn btn-danger','data-dismiss'=>'modal'),
			)
				);
				?>
				</td>
			</tr>
		</table>
		</div>
		</form>
	<?
	$this->endWidget();
	}




	public function trae_id_ciudadano_bi($id_ficha=0)
	{
		$sql = "Select id_ciudadano From bi.fichas Where id_ficha_bi = ".$id_ficha;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {
			foreach($resultado as $d){
				$id_ciudadano_bi = $d;
			}
		}
		return $id_ciudadano_bi;
	}
	public function trae_nombres_ciudadano_bi($id_ciudadano_bi=0)
	{
		$datos =array();
		$sql = "Select id_ciudadano, concat( nombres,' ', nombre2,' ',apellidos,' ',apellido2,' ',apellido_casada) as nombre_completo,
					soundexesp(nombres) as nombres_sndex, soundexesp(nombre2) as nombre2_sndex, soundexesp(apellidos) as apellidos_sndex,
					soundexesp(apellido2) as apellido2_sndex, soundexesp(apellido_casada) as apellido_casada_sndex,
					fecha_nacimiento,
					(orden_cedula||' '||registro_cedula_cln) as cedula,
					cod_depto_cedula, cod_municipio_cedula, dpi_cln as dpi,
					concat(nombres_padre,' ',nombre2_padre,' ',apellidos_padre,' ',apellido2_padre) as nombre_padre,
					concat(nombres_madre,' ',nombre2_madre,' ',apellidos_madre,' ',apellido2_madre,' ',ape_casa_madre) as nombre_madre,
					lugar_nacimiento, cod_depto as depto_nacimiento, cod_municipio as muni_nacimiento, estado_civil,
					cod_nacionalidad, expediente as num_tarjeta
					from bi.nombres_ciudadano where id_ciudadano = ".$id_ciudadano_bi;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$i = 0;
		foreach ($dbO->queryAll() as $resultado) {
			$i++;
			$datos['id'] = $i;
			$datos['nombre'] = $resultado->nombre_completo;
				$variable_tooltip = '';
			if(strlen($resultado->nombres_sndex)>0){
				$variable_tooltip = 'Primer Nombre : '.$resultado->nombres_sndex.'<br>';
			}
			if(strlen($resultado->nombre2_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Segundo Nombre : '.$resultado->nombre2_sndex.'<br>';
			}


			if(strlen($resultado->apellidos_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Primer Apellido : '.$resultado->apellidos_sndex.'<br>';
			}

			if(strlen($resultado->apellido2_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Segundo Apellido : '.$resultado->apellido2_sndex.'<br>';
			}

			if(strlen($resultado->apellido_casada_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Apellido de Casada : '.$resultado->apellido_casada_sndex;
			}

			$datos['tooltip'] = $variable_tooltip;

			if(strlen($resultado->fecha_nacimiento)>0){
				$date = new DateTime($resultado->fecha_nacimiento);
				$datos['fecha_nacimiento'] =$date->format('d/m/Y');
			}

			if(strlen($resultado->cedula)>4){
				$datos['cedula'] = $resultado->cedula." ".$this->traduce_departamento_bi($resultado->cod_depto_cedula).", ".$this->traduce_municipio_bi($resultado->cod_municipio_cedula,$resultado->cod_depto_cedula);
			}else{
				$datos['cedula']='';
			}

			$datos['dpi'] = $resultado->dpi;
			$datos['nombre_padre'] =$resultado->nombre_padre;
			$datos['nombre_madre'] =$resultado->nombre_madre;
			if(strlen($resultado->lugar_nacimiento)>0){
				$datos['lugar_nacimiento'] = $resultado->lugar_nacimiento.", ".$this->traduce_departamento_bi($resultado->depto_nacimiento).", ". $this->traduce_municipio_bi($resultado->muni_nacimiento,$resultado->depto_nacimiento);
			}else{
				$datos['lugar_nacimiento'] = '';
			}

			$datos['estado_civil'] = $this->traduce_criterio_fijo_bi($resultado->estado_civil,3);

			$datos_generales[]=$datos;
		}
		return $datos_generales;
	}
public function trae_nombres_ciudadano_bi_c($id_ciudadano_bi=0)
	{
		$datos =array();
		$sql = "Select id_ciudadano, concat( nombres,' ', nombre2,' ',apellidos,' ',apellido2,' ',apellido_casada) as nombre_completo
					from bi.nombres_ciudadano where id_ciudadano = ".$id_ciudadano_bi;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$i = 0;
		foreach ($dbO->queryAll() as $resultado) {
			$i++;
			$datos['nombre'] = $resultado->nombre_completo;
			$datos_generales[]=$datos;
		}
		return $datos_generales;
	}

	public function trae_nombres_ciudadano_ficha($id_ficha=0)
	{
		$datos =array();
		$nombre = '';
		$sql = "Select *
					from sapo_gestion.sapogt_ficha_criminal where id_ficha_criminal = ".$id_ficha;
		$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($respuesta as $info_ficha){
			$nombre = $this->formato_nombre_completo($info_ficha['primer_nombre'],$info_ficha['segundo_nombre'],$info_ficha['tercer_nombre'],$info_ficha['primer_apellido'],$info_ficha['segundo_apellido'],$info_ficha['apellido_casada']);
		}
		return $nombre;
	}
	public function traduce_departamento_bi($id_depto=0){
		$id_depto_renap = 0;
		$departamento = '';
		if ($id_depto>0) {
			$sql = "Select cod_depto_renap From bi.geo_traductor Where cod_depto_oracle = ".$id_depto." Group by cod_depto_renap";
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			foreach ($dbO->queryAll() as $resultado) {
				foreach($resultado as $record){
					$id_depto_renap = $record;
				}
			}
			$departamento = $this->trae_departamento_renap($id_depto_renap);
		}
		return $departamento;
	}

public function traduce_municipio_bi($id_depto=0,$id_munic=0){
		$id_depto_renap = 0;
		$id_munic_renap = 0;

		$municipio = '';
		if ($id_depto>0 && $id_munic >0) {
			$sql = "Select cod_depto_renap, cod_muni_renap From bi.geo_traductor Where cod_depto_oracle = ".$id_depto." and cod_muni_oracle = ".$id_munic;
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			foreach ($dbO->queryAll() as $resultado) {
				$id_depto_renap = $resultado->cod_depto_renap;
				$id_munic_renap = $resultado->cod_muni_renap;
			}

			$sql = "SELECT descripcion FROM sapo_gestion.sapogt_renap_municipio Where id_depto = ".$id_depto_renap." and id_muni=".$id_munic_renap;
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			foreach ($dbO->queryAll() as $resultado) {
				$municipio = $resultado->descripcion;
			}
		}
		else{

		}
		return $municipio;
	}

public function trae_departamento_renap($id_depto=0){
		$departamento = array();
		$depto = RenapDepartamento::model()->findAll('id_depto = :id_depto',array(':id_depto'=>$id_depto));
		foreach ($depto as $record) {
			$departamento = $record->getAttributes();
		}
		if(sizeof($departamento)>0){
				return $departamento['descripcion'];
		}else{

			$depa='';
			return $depa;

		}

	}

		public function trae_municipio_renap($id_depto_muni=0){
			$municipio = array();
		$munic = RenapMunicipio::model()->findAll('id_depto_muni = :id_depto_muni',array(':id_depto_muni'=>$id_depto_muni));
		foreach ($munic as $record) {
			$municipio = $record->getAttributes();
		}
		if(sizeof($municipio)>0){
				return $municipio['descripcion'];
		}else{

			$depa='';
			return $depa;

		}

	}

public function trae_municipio_renap_por_depto_muni($id_depto=0,$id_muni=0){
	$munic = RenapMunicipio::model()->findAll('id_depto = :id_depto and id_muni = :id_muni',array(':id_depto'=>$id_depto,':id_muni'=>$id_muni));
	foreach ($munic as $record) {
		$municipio = $record->getAttributes();
	}
	if (!empty($municipio)) {
		return $municipio['descripcion'];
	}
	else{
		return '';
	}
}


	public function traduce_criterio_fijo_bi($id_referencia_bi='',$id_criterio=0)
	{
		$id_opcion=0;
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('id_opcion')
			 ->from('sapo_gestion.sapogt_criterio_fijo')
			 ->where('id_referencia_bi=:id_referencia_bi and id_criterio_fijo=:id_criterio and estado=:estado', array(':id_referencia_bi'=>$id_referencia_bi,'id_criterio'=>$id_criterio,':estado'=>1));
		$valor = array();
		foreach($conn->queryAll() as $data)
		{
			$id_opcion = $data->id_opcion;
		}
		$valor = $this->busca_criterio_fijo($id_opcion,$id_criterio);

		return $valor;
	}

	public function trae_sinonimos_bi($id_ciudadano_bi=0)
	{
		$datos =array();
		$a_datos =array();
		$sql = "Select id_ciudadano, concat(nombres,' ',nombre2,' ',apellidos,' ',apellido2,' ',apellido_casada) as nombre_completo,
					soundexesp(nombres) as nombres_sndex, soundexesp(nombre2) as nombre2_sndex, soundexesp(apellidos) as apellidos_sndex,
					soundexesp(apellido2) as apellido2_sndex, soundexesp(apellido_casada) as apellido_casada_sndex
					from bi.sinonimos_ciudadano where id_ciudadano = ".$id_ciudadano_bi;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$i = 0;
		foreach ($dbO->queryAll() as $resultado) {
			$i++;
			$datos['id'] = $i;
			$datos['nombre'] = $resultado->nombre_completo;
				$variable_tooltip = '';
			if(strlen($resultado->nombres_sndex)>0){
				$variable_tooltip = 'Primer Nombre : '.$resultado->nombres_sndex.'<br>';
			}
			if(strlen($resultado->nombre2_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Segundo Nombre : '.$resultado->nombre2_sndex.'<br>';
			}


			if(strlen($resultado->apellidos_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Primer Apellido : '.$resultado->apellidos_sndex.'<br>';
			}

			if(strlen($resultado->apellido2_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Segundo Apellido : '.$resultado->apellido2_sndex.'<br>';
			}

			if(strlen($resultado->apellido_casada_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Apellido de Casada : '.$resultado->apellido_casada_sndex;
			}

			$datos['tooltip'] = $variable_tooltip;


			$a_datos[]=$datos;
		}
		return $a_datos;
	}
		public function trae_apodos_bi($id_ciudadano_bi=0)
	{
		$datos =array();
		$datos_final =array();
		$sql = "Select id_ciudadano, nombre_apodo
					from bi.apodos where id_ciudadano = ".$id_ciudadano_bi;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {
			$datos['apodo'] = $resultado->nombre_apodo;
			$datos_final[]=$datos;
		}
		return $datos_final;
	}
		public function orderMultiDimensionalArray ($toOrderArray, $field, $inverse = false) {
		$position = array();
		$newRow = array();
		foreach ($toOrderArray as $key => $row) {
			$position[$key]  = $row[$field];
			$newRow[$key] = $row;
		}
		if ($inverse) {
			arsort($position);
		}
		else {
			asort($position);
		}
		$returnArray = array();
		foreach ($position as $key => $pos) {
			$returnArray[] = $newRow[$key];
		}
		return $returnArray;
	}

	public function valida_session(){
		//valida la sesion nuevamente antes de mostrar datos
		Yii::app()->user->setState('salt', rand(10, 99));
		$sesion= Yii::app()->getSession()->get('sesion');
		if($sesion==NULL){
			$this->redirect(Yii::app()->homeUrl);
		}
		if(isset($sesion) && !empty($sesion))
		{
			$username= Yii::app()->user->name;
			$this->valida($sesion, $username);
		}
		return true;
	}

	///////////////--- funciones enma para el detalle

	public function trae_delitos_ficha($id_ficha=0,$data='')
	{
		// Muestra en un grid los delitos de una ficha
		$a_delitos = array();
		foreach($data as $key => $values){
			if ($key != 'error' and $key != 'solvente') {
				foreach($values['fichas'] as $fichas){
					if ($fichas['id_ficha'] == $id_ficha) {
						foreach($fichas['delitos'] as $datos_delitos){
							$a_delitos[] = $datos_delitos;
						}
					}
				}
			}
		}
		return $a_delitos;
	}

	public function muestra_tabla_ficha_detalle($id_ficha=0,$tipo_schema=0,$id_ciudadano_renap=0)
	{
		$a_datos = array();
		$arreglo_fichas = array();
		if ($tipo_schema == 1) {
			// Busqueda en BI
			$sql = "SELECT f.id_ficha_bi as id_ficha, c.expediente as num_expediente, f.fecha_emision, j.nombre_juzgado, r1.descripcion as depto, r2.descripcion as munic
							FROM bi.fichas f
							LEFT JOIN bi.ciudadanos1 c ON f.id_ciudadano = c.id_ciudadano
							LEFT JOIN bi.juzgados j ON f.cod_juzgado = j.cod_juzgado AND f.cod_depto_juzgado = j.cod_depto AND f.cod_municipio_juzgado = j.cod_municipio
							LEFT JOIN bi.geo_traductor g1 ON g1.cod_depto_oracle = f.cod_depto and g1.cod_muni_oracle = f.cod_municipio
							LEFT JOIN sapo_gestion.sapogt_renap_departamento r1 ON r1.id_depto = g1.cod_depto_renap
							LEFT JOIN sapo_gestion.sapogt_renap_municipio r2 ON r2.id_muni = g1.cod_muni_renap and r2.id_depto = g1.cod_depto_renap
							WHERE f.id_ficha_bi = ".$id_ficha;
			$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
		}
		else{
			// Busqueda en SAPO
			$sql = "SELECT 	f.id_ficha_criminal as id_ficha, f.num_expediente, f.fecha_emision, j.nombre_juzgado, r1.descripcion as depto, r2.descripcion as munic
							FROM sapo_gestion.sapogt_ficha_criminal f
							LEFT JOIN sapo_gestion.sapogt_juzgado j ON f.cod_juzgado = j.id_juzgado
							LEFT JOIN sapo_gestion.sapogt_renap_departamento r1 ON r1.id_depto = f.cod_depto_emision_ficha
							LEFT JOIN sapo_gestion.sapogt_renap_municipio r2 ON r2.id_muni = f.cod_muni_emision_ficha AND r2.id_depto = f.cod_depto_emision_ficha
							WHERE id_ficha_criminal = ".$id_ficha;
			$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
		}// fin del else

		foreach ($respuesta as $info_ficha){
			$num_expediente = $info_ficha['num_expediente'];
			$arreglo_fichas['id_ficha'] = $info_ficha['id_ficha'];
			$arreglo_fichas['num_expediente'] = $info_ficha['num_expediente'];
			$arreglo_fichas['tipo'] = $tipo_schema;
			$arreglo_fichas['fecha'] = date("d/m/Y",strtotime($info_ficha['fecha_emision']));
			$arreglo_fichas['juzgado'] = $info_ficha['nombre_juzgado'];
			$arreglo_fichas['departamento'] = $info_ficha['depto'];
			$arreglo_fichas['municipio'] = $info_ficha['munic'];
			$arreglo_fichas['criterios'] = $this->muestraCriteriosFichas($id_ficha,$tipo_schema,$id_ciudadano_renap);
		}// fin for
		$a_datos[] = $arreglo_fichas;


		$dataProvider = new CArrayDataProvider(
								$a_datos, array(
										'keyField' => 'id_ficha',
								        'sort'=>array(
								        	'attributes'=>array('id_ficha'),
								        	'defaultOrder'=>array('id_ficha' => false),
										    ),

								       				)
								);

		return 	$this->widget('bootstrap.widgets.TbGridView', array(
					'id'=>'ficha-grid',
					'dataProvider'=>$dataProvider,
					'pager'=>false,
					//'selectionChanged'=>'userClicks',
					'columns' => array(
						array(
								'name'  => 'Ficha',
								'value' => '$data["id_ficha"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Expediente',
								'value' => '$data["num_expediente"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Fecha',
								'value' => '$data["fecha"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Juzgado',
								'value' => '$data["juzgado"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Departamento',
								'value' => '$data["departamento"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Municipio',
								'value' => '$data["municipio"]',
								'type'  => 'raw',
							),
						array(
								'name'  => 'Criterios',
								'value' => '$data["criterios"]',
								'type'  => 'raw',
							),
						),
					)
				);
	}

	public function num_expediente_bi($id_ficha=0){
		$num_expediente = 0;
		$sql = "SELECT c.expediente as num_expediente
				FROM bi.fichas f
				INNER JOIN bi.ciudadanos1 c ON f.id_ciudadano = c.id_ciudadano
				WHERE f.id_ficha_bi = " . $id_ficha;
		$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($respuesta as $info_ficha) {
			$num_expediente = $info_ficha['num_expediente'];
		}
		return $num_expediente;
	}

	public function nombres_ciudadano_bi($id_ciudadano_bi=0){
		$atributos = array(
            array('name' => 'id', 'header' => '#'),
            array('name' => 'nombre', 'header' => 'Nombre Completo'),
            array('name' => 'fecha_nacimiento', 'header' => 'Fecha de Nacimiento'),
            array('name' => 'cedula', 'header' => 'Cedula'),
            array('name' => 'dpi', 'header' => 'DPI'),
            array('name' => 'nombre_padres', 'header' => 'Padres'),
            array('name' => 'lugar_nacimiento', 'header' => 'Lugar de Nacimiento'),
            array('name' => 'estado_civil', 'header' => 'Estado Civil'),
            );
		// ********************* NOMBRES CIUDADANOS *********************
		$nombres_ciudadano = $this->trae_nombres_ciudadano_bi($id_ciudadano_bi);
		foreach($nombres_ciudadano as $dato_nombre) {
			$this->nombres_schema_bi .= $dato_nombre['nombre'] . " ";
		}
		if (count($nombres_ciudadano) > 0) {
			echo $this->tabla($atributos, $nombres_ciudadano);
		}
		else
		{
			echo "No tiene Nombres";
		}
	}

public function despliega_nombres_bi($id_ciudadano_bi){

	$sinonimos = array();
	$nombres_ciudadano = $this->trae_nombres_ciudadano_bi($id_ciudadano_bi);
    $sinonimos = $this->trae_sinonimos_bi($id_ciudadano_bi);
	$apodos = $this->trae_apodos_bi($id_ciudadano_bi);

	?>

		<div class="well">
	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span12" style="text">
				<br/> <?
				$i=0;
					foreach($nombres_ciudadano as $info){
					$this->tooltip_i++;
					$i++;	?>
				<script>
				    $(function () {
		                $('#tooltip<?echo $this->tooltip_i;?>').tooltip();

		            });
				</script>
				<div class="well well-small">

				<span class="badge badge-info"><?echo $i.". Nombre:";?></span> <a href="#"  id="tooltip<?echo $this->tooltip_i;?>" data-toggle="tooltip" data-html="true" title="<? echo $info['tooltip']; ?>" data-placement="right">  <? echo $info['nombre'];?></a><br>
		      		<div class="row-fluid">
						<div class="span6 offset1">
		        <? if(isset($info['lugar_nacimiento']) && strlen($info['lugar_nacimiento'])>0){ ?>

		        	     <blockquote>
		        			<small><cite title="Lugar de nacimiento"><? echo $info['lugar_nacimiento'];?><i class="icon-map-marker"></i></cite></small>
		        	     </blockquote>

		        <?}?>
		     <?if(sizeof($sinonimos)>0){?>
					<i class="icon-user"></i> <span class="bold">Conocido/a como: </span>
		     	<?$this->despliega_sinonimos_bi($sinonimos);
			 }?>
			 <?if(sizeof($apodos)>0){?>
					<i class="icon-user"></i> <span class="bold">Sus apodos son: </span>
		     	<?$this->despliega_apodos_bi($apodos);
			 }?>

		      	     <?	if(isset($info['dpi']) && !empty($info['dpi']) && isset($info['cedula']) && !empty($info['cedula'])){
		        		// aqui se muestra el dpi y cedula
		        		// echo "dpi y cedula";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> DPI: ".$info['dpi']." Cédula: ".$info['cedula']."<br>";
		        	}elseif(isset($info['dpi']) && !empty($info['dpi'])){
		        		// aqui se muestra el dpi
		        		// echo "dpi";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> DPI: ".$info['dpi']."<br>";
		        	}elseif(isset($info['cedula']) && !empty($info['cedula'])){
		        		// aqui muestro la cedula
		        		// echo "cedula";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> Cédula: ".$info['cedula']."<br>";
		        	}else{
		        		// aqui va en blanco
		        		echo " ";
		        	}

		        ?>


		        <? if(isset($info['fecha_nacimiento']) && !empty($info['fecha_nacimiento'])){


		        	?>
				<i class="icon-gift"></i> <span class="bold"> Fecha nacimiento:</span> <? echo $info['fecha_nacimiento']."<br>";  }  ?>

				<? if(isset($info['estado_civil']) && strlen($info['estado_civil'])>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Estado Civil: </span><? echo $info['estado_civil']."<br>";} ?>

		        <? if(isset($info['nombre_madre']) || !empty($info['nombre_madre'])){ ?>
				<i class="icon-user"></i> <span class="bold">Nombre de la Madre: </span><? echo $info['nombre_madre']."<br>";} ?>
				<? if(isset($info['nombre_padre']) || !empty($info['nombre_padre'])){ ?>
				<i class="icon-user"></i> <span class="bold">Nombre del Padre: </span><? echo $info['nombre_padre']."<br>";} ?>
			  	<br>
			  	<br>
			  			</div> <!-- FIN DEL SPAN  -->
					</div><!-- FIN DEL ROW -->
		     	</div><!-- FIN DEL WELL RECURSIVO  -->

			  		<?}

				?>
		      </p>
			</div>

		</div>
	</div>

	</div> <!-- fin del well -->


	<?


}

public function despliega_orden_captura($info=array()){

		?>
<div class="well">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" style="text">
				<blockquote>
		        <p><?
		        if(isset($info['estado_captura'])){
		         if($info['estado_captura']=='P'){
		        	echo "Estado Captura: <bold>Pendiente";
		        } }?></p>
		        <small><cite title="Info"><?
		        if(isset($info['telefonema'])){
		        	echo "Telefonema:".$info['telefonema'];
		        }
		        ?>,<?
		        if(isset($info['causa_no'])){
		        	echo  '<span class="bold">Número de Causa: </span>'.$info['causa_no'];
				}
		        ?>
		        	<i class="icon-map-marker"></i></cite></small>
		     	</blockquote>
				<br/>
				<? if(isset($info['fecha_nacimiento']) && !empty($info['fecha_nacimiento'])){ ?>
				<i class="icon-calendar"></i> <span class="bold"> Fecha de Nacimiento:</span> <? echo $info['fecha_nacimiento']."<br/>";  }  ?>
				<? if(isset($info['lugar_nacimiento']) && strlen($info['lugar_nacimiento'])>2){ ?>
				<i class=" icon-map-marker"></i> <span class="bold">Lugar de Nacimiento: </span><? echo $info['lugar_nacimiento']."<br/>";} ?>
				<? if(isset($info['cedula']) && strlen($info['cedula'])>2){ ?>
				<i class="icon-home"></i> <span class="bold">Cédula: </span><? echo $info['cedula']."<br/>";} ?>
				<? if(isset($info['padre']) && strlen($info['padre'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Padre: </span><? echo $info['padre']."<br/>";} ?>
				<? if(isset($info['madre']) && strlen($info['madre'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Madre: </span><? echo $info['madre']."<br/>";} ?>
		       <? if(isset($info['observaciones']) && strlen($info['observaciones'])>0){ ?>
				<i class="icon-arrow-right"></i> <span class="bold">Observaciones: </span><? echo $info['observaciones']."<br/>";} ?>
		        <? if(isset($info['fecha']) && strlen($info['fecha'])>0){ ?>
				<i class="icon-calendar"></i> <span class="bold">Fecha de Emisión: </span><? echo $info['fecha']."<br/>";} ?>
				<? if(isset($info['juzgado']) && strlen($info['juzgado'])>0){ ?>
				<i class="icon-align-justify"></i> <span class="bold">Juzgado que emite: </span><? echo $info['juzgado']."<br/>";} ?>
			</div>
		</div>
	</div>

	</div> <!-- fin del well --><?

}

public function despliega_ficha_bi($id_ficha=0,$a_delitos=array(),$id_ciudadano_bi=0){
		$ficha_bi = $this->trae_fichas_bi($id_ficha);
		foreach($ficha_bi as $info){
		?>
<div class="well">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" style="text">
				<br/>
				<? if(isset($info['fecha_emision']) && !empty($info['fecha_emision'])){ ?>
				<i class="icon-calendar"></i> <span class="bold"> Fecha de Emisión de la Ficha:</span> <? echo $info['fecha_emision']."<br/>";  }  ?>
				<? if(isset($info['emision']) && strlen($info['emision'])>2){ ?>
				<i class=" icon-map-marker"></i> <span class="bold">Lugar de Emisión de la Ficha: </span><? echo $info['emision']."<br/>";} ?>
				<? if(isset($info['juzgado_emite']) && strlen($info['juzgado_emite'])>2){ ?>
				<i class="icon-home"></i> <span class="bold">Juzgado que Emite: </span><? echo $info['juzgado_emite']."<br/>";} ?>
				<? if(isset($info['cuerpo_pn']) && strlen($info['cuerpo_pn'])>2){ ?>
				<i class="icon-home"></i> <span class="bold">Cuerpo Refiere: </span><? echo $info['cuerpo_pn']."<br/>";} ?>
				<? if(isset($info['fecha_captura']) && strlen($info['fecha_captura'])>2){ ?>
				<i class="icon-calendar"></i> <span class="bold">Fecha Captura: </span><? echo $info['fecha_captura']."<br/>";} ?>
		        <? if(isset($info['referencia_foto']) || strlen($info['referencia_foto'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Referencia Fotografíca: </span><? echo $info['referencia_foto']."<br/>";} ?>
				<? if(isset($info['observaciones']) && strlen($info['observaciones'])>0){ ?>
				<i class="icon-arrow-right"></i> <span class="bold">Observaciones: </span><? echo $info['observaciones']."<br/>";} ?>
		        <? if(isset($info['fecha_ingreso']) && strlen($info['fecha_ingreso'])>0){ ?>
				<i class="icon-calendar"></i> <span class="bold">Fecha de Ingreso: </span><? echo $info['fecha_ingreso']."<br/>";} ?>
				<? if(isset($info['motivo_ficha']) && strlen($info['motivo_ficha'])>0){ ?>
				<i class="icon-align-justify"></i> <span class="bold">Motivo de la Ficha: </span><? echo $info['motivo_ficha']."<br/>";} ?>
				<? if(isset($info['resolucion_caso']) && strlen($info['resolucion_caso'])>0){ ?>
				<i class="icon-align-justify"></i> <span class="bold">Resolución del Caso: </span><? echo $info['resolucion_caso']."<br/>";} ?>
		      <?
		      if(sizeof($a_delitos)>0){
		      $delitos_bi = $this->muestra_delitos_ficha_grid($a_delitos);
		      $atributos = array(array('name' => 'id', 'header' => '#'),array('name' => 'delito', 'header' => 'Delito'), );
			        if (count($delitos_bi) > 0) {?>
			        	<i class="icon-remove"></i> <span class="bold">Delitos Vigentes: </span><? $this->tabla($atributos, $delitos_bi); ?>

			      <?  } else {
			            echo "No tiene delitos asociados la ficha";
			        }

			  }
			$formulas_bi = $this->trae_formula_dactilar_bi($id_ciudadano_bi);


		if (count($formulas_bi) > 0) {
			$atributos = array( array('name' => 'id', 'header' => '#'), array('name' => 'num_formula', 'header' => 'No.Formula'), array('name' => 'formula_mano_derecha', 'header' => 'Mano Derecha'),  array('name' => 'formula_mano_izquierda', 'header' => 'Mano Izquierda'),    array('name' => 'tipo_formula', 'header' => 'Tipo Formula'),);
			?>
			        	<i class="icon-thumbs-up"></i> <span class="bold">Formula Dactilar: </span><? echo $this->tabla($atributos, $formulas_bi);?>

			      <?
		} else {
			echo "No tiene formula dactilar";
		}


				        ?>


			</div>
		</div>
	</div>

	</div> <!-- fin del well --><?}

}


public function despliega_ficha_sapo($id_ficha=0,$a_delitos=array()){
		$ficha_sapo = $this->trae_fichas_sapo($id_ficha);
	foreach($ficha_sapo as $row){

				$this->nombres_schema_sapo = $row['nombre'];
				$num_expediente = $row['num_expediente'];
				$this->tooltip_fc++;
	?>
	<script>
		    $(function () {
                $('#tooltip_fc<?echo $this->tooltip_fc;?>').tooltip();

            });
	</script>

	<div class="well">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?  if($row['id_ciudadano_renap'] > 0) {
						$src = $this->foto_ciudadano_renap($row['id_ciudadano_renap']);
						if(strlen($src) <= 300){
			 				echo '<img src="images/nodisponible.png">';
			 			}else{
			 				$res = $src;
							$xml = new SimpleXMLElement($res);
			 				$newdataset = $xml->children();
			 				$objetos = get_object_vars($newdataset);
			 				$fotica=$objetos['PortraitImage'];
			 				echo '<img src="data:image/png;base64,'.$fotica.'" width="300" height="300" class="img-rounded">';
			 			}
					}
					else{
						echo '<img src="images/nodisponible.png" class="img-rounded">';
					}

					?>
			</div>
			<?
				$variable_tooltip = '';
			if(strlen($row['primer_nombre_sndex'])>0){
				$variable_tooltip = 'Primer Nombre : '.$row['primer_nombre_sndex'].'<br>';
			}
			if(strlen($row['segundo_nombre_sndex'])>0){
				$variable_tooltip =$variable_tooltip.'Segundo Nombre : '.$row['segundo_nombre_sndex'].'<br>';
			}

			if(strlen($row['tercer_nombre_sndex'])>0){
				$variable_tooltip =$variable_tooltip.'Tercer Nombre : '.$row['tercer_nombre_sndex'].'<br>';
			}

			if(strlen($row['primer_apellido_sndex'])>0){
				$variable_tooltip =$variable_tooltip.'Primer Apellido : '.$row['primer_apellido_sndex'].'<br>';
			}

			if(strlen($row['segundo_apellido_sndex'])>0){
				$variable_tooltip =$variable_tooltip.'Segundo Apellido : '.$row['segundo_apellido_sndex'].'<br>';
			}

			if(strlen($row['apellido_casada_sndex'])>0){
				$variable_tooltip =$variable_tooltip.'Apellido de Casada : '.$row['apellido_casada_sndex'];
			}

			?>

			<div class="span6" style="text">
				<blockquote>
					 <p> <a href="#"  id="tooltip_fc<?echo $this->tooltip_fc;?>" data-toggle="tooltip" data-html="true" title="<? echo $variable_tooltip; ?>" data-placement="right"><?echo $row['nombre'];?></a></p>

		        <small><cite title="Lugar de nacimiento"><? echo $row['cod_depto_nacimiento']; ?>,<? echo  $row['cod_munic_nacimiento'];?>
		        	<? if(strlen($row['lugar_nacimiento'])>0){echo $row['lugar_nacimiento'];}?><i class="icon-map-marker"></i></cite></small>
		     	</blockquote>

		      	     <?

		        	if(isset($row['dpi']) && !empty($row['dpi']) && isset($row['cedula']) && !empty($row['cedula'])){
		        		// aqui se muestra el dpi y cedula
		        		// echo "dpi y cedula";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> DPI: ".$row['dpi']." Cédula: ".$row['cedula'];
		        	}elseif(isset($row['dpi']) && !empty($row['dpi'])){
		        		// aqui se muestra el dpi
		        		// echo "dpi";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> DPI: ".$row['dpi'];
		        	}elseif(isset($row['cedula']) && !empty($row['cedula'])){
		        		// aqui muestro la cedula
		        		// echo "cedula";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> Cédula: ".$row['cedula'];
		        	}else{
		        		// aqui va en blanco
		        		echo " ";
		        	}

		        ?> <br>


 				<? if(isset($row['nacionalidad']) && !empty($row['nacionalidad'])){ ?>
				<i class="icon-map-marker"></i> <span class="bold"> Nacionalidad</span> <? echo $row['nacionalidad']."<br/>";  }  ?>
		        <? if(isset($row['fecha_nacimiento']) && !empty($row['fecha_nacimiento'])){ ?>
				<i class="icon-gift"></i> <span class="bold"> Fecha nacimiento:</span> <? echo $row['fecha_nacimiento']."<br/>";  }  ?>
				<? if(isset($row['genero']) && strlen($row['genero'])>2){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Genero: </span><? echo $row['genero']."<br/>";} ?>
				<? if(isset($row['estado_civil']) && strlen($row['estado_civil'])>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Estado Civil: </span><? echo $row['estado_civil']."<br/>";} ?>
				<? if(isset($row['profesion']) && strlen($row['profesion'])>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Profesión: </span><? echo $row['profesion']."<br/>";} ?>
				<? if(isset($row['direccion']) && strlen($row['direccion'])>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Dirección: </span><? echo $row['direccion']."<br/>";} ?>
		        <? if(isset($row['nombre_padre']) && strlen($row['nombre_padre'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Padre: </span><? echo $row['nombre_padre']."<br/>";} ?>
				 <? if(isset($row['nombre_madre']) && strlen($row['nombre_madre'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Madre: </span><? echo $row['nombre_madre']."<br/>";} ?>
				</div>
			</div>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
 				<br>
				<div class="span12" style="text">
					<?
						$sql2 = "SELECT * FROM sapo_gestion.sapogt_ficha_criminal_alias Where id_ficha_criminal = ".$id_ficha;
						$respuesta2 = Yii::app()->db->createCommand($sql2)->queryAll();
						$i=1;
						if($respuesta2 == true){
						?><i class="icon-user"></i> <span class="bold">Alias: </span><?
							foreach($respuesta2 as $info){
								// se muestra el listado de alias
								if($i == 1){
									echo $this->formato_nombre_completo($info['primer_nombre'],$info['segundo_nombre'],$info['tercer_nombre'],$info['primer_apellido'],$info['segundo_apellido'],$info['apellido_casada']);
								}else{
									echo " - ".$this->formato_nombre_completo($info['primer_nombre'],$info['segundo_nombre'],$info['tercer_nombre'],$info['primer_apellido'],$info['segundo_apellido'],$info['apellido_casada']);
								}
								$i++;
				      		}
						}
				  ?>
				  <br>
				  <br>
				<blockquote>
	  				<p><bold>Descripción fisica del ciudadano</bold></p>
				</blockquote>
				 <? if(isset($row['senias_particulares']) && !empty($row['senias_particulares'])){ ?>
				<i class="icon-gift"></i> <span class="bold"> Señas Particulares:</span> <? echo $row['senias_particulares']."<br/>";  }  ?>
		        <? if(isset($row['amputaciones']) && !empty($row['amputaciones'])){ ?>
				<i class="icon-gift"></i> <span class="bold"> Amputaciones:</span> <? echo $row['amputaciones']."<br/>";  }  ?>
				<? if(isset($row['peso']) && $row['peso']>0){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Peso: </span><? echo $row['peso']."<br/>";} ?>
				<? if(isset($row['estatura']) && $row['estatura']>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Estatura: </span><? echo $row['estatura']."<br/>";} ?>
				<? if(isset($row['cod_complexion']) && strlen($row['cod_complexion'])>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Complexión: </span><? echo $row['cod_complexion']."<br/>";} ?>
				<? if(isset($row['cod_codigo_grupo']) && strlen($row['cod_codigo_grupo'])>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Grupo: </span><? echo $row['cod_codigo_grupo']."<br/>";} ?>
		        <? if(isset($row['cabello']) && strlen($row['cabello'])>31){ ?>
				<i class="icon-user"></i> <span class="bold">Cabello: </span><? echo $row['cabello']."<br/>";} ?>
				 <? if(isset($row['cod_color_ojos']) && strlen($row['cod_color_ojos'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Color de Ojos: </span><? echo $row['cod_color_ojos']."<br/>";} ?>
				 <? if(isset($row['cod_color_tez']) && strlen($row['cod_color_tez'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Color de Tez: </span><? echo $row['cod_color_tez']."<br/>";} ?>
				 <? if(isset($row['cod_codigo_nariz']) && strlen($row['cod_codigo_nariz'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Tipo de Nariz: </span><? echo $row['cod_codigo_nariz']."<br/><br/>";} ?>
			<blockquote>
	  			<p><bold>Datos Generales de la Ficha</bold></p>
			</blockquote>

			 <?


				if(isset($row['cod_depto_emision_ficha']) && strlen($row['cod_depto_emision_ficha'])>0){
						$lugar = $row['lugar_emision_ficha']." ".$row['cod_depto_emision_ficha']." ".$row['cod_muni_emision_ficha'];
					 ?>
				<i class="icon-chevron-right"></i> <span class="bold"> Lugar de Emisión:</span> <? echo $lugar."<br/>";  }  ?>
		        <? if(isset($row['fecha_emision']) && !empty($row['fecha_emision'])){ ?>
				<i class="icon-chevron-right"></i> <span class="bold"> Fecha de Emisión:</span> <? echo $row['fecha_emision']."<br/>";  }  ?>
				<? if(isset($row['observaciones']) && strlen($row['observaciones'])>0){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Observaciones: </span><? echo $row['observaciones']."<br/>";} ?>
				<? if(isset($row['cod_motivo_ficha']) && strlen($row['cod_motivo_ficha'])>0){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Motivo de la Ficha: </span><? echo $row['cod_motivo_ficha']."<br/>";} ?>
				<? if(isset($row['juzgado']) && strlen($row['juzgado'])>0){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Juzgado: </span><? echo $row['juzgado']."<br/>";} ?>
				<? if(isset($row['num_expediente']) && strlen($row['num_expediente'])>0){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Número de expediente: </span><? echo $row['num_expediente']."<br/>";} ?>
		        <? if(isset($row['agentes_captores']) && strlen($row['agentes_captores'])>0){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Agentes Captores: </span><? echo $row['agentes_captores']."<br/>";} ?>
				 <? if(isset($row['resolucion_caso']) && strlen($row['resolucion_caso'])>2){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Resolución del Caso: </span><? echo $row['resolucion_caso']."<br/>";} ?>

				 <?
		      if(sizeof($a_delitos)>0){
		      $delitos_sapo = $this->muestra_delitos_ficha_grid($a_delitos);
		      $atributos = array(array('name' => 'id', 'header' => '#'),array('name' => 'delito', 'header' => 'Delito'), );
			        if (count($delitos_sapo) > 0) {?>
			        	<i class="icon-remove"></i> <span class="bold">Delitos Vigentes: </span><? $this->tabla($atributos, $delitos_sapo); ?>

			      <?  } else {
			            echo "No tiene delitos asociados la ficha";
			        }

			  }
			$formula_sapo = $this->trae_formula_dactilar_sapo($id_ficha);

		if (count($formula_sapo) > 0) {
			$atributos = array(
            array('name' => 'id', 'header' => '#'),
            array('name' => 'tipo', 'header' => 'Tipo'),
            array('name' => 'valor', 'header' => 'Formula'),
            array('name' => 'lado_mano', 'header' => 'Lado Mano'),
            );
			?>
        	<i class="icon-thumbs-up"></i> <span class="bold">Formula Dactilar: </span><? echo $this->tabla($atributos, $formula_sapo);?>
			      <?
		} else {
			echo "No tiene formula dactilar";
		} ?>




			</div>
		</div>
	</div>

	</div> <!-- fin del well -->






<?}
}

public function despliega_generales_bi($id_bi_ciudadano=0){
	$arreglo = $this->trae_ciudadanos_bi($id_bi_ciudadano);

	foreach($arreglo as $info){?>

<div class="well">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" style="text">
				<br/>
				<? if(isset($info['numero_tarjeta']) && !empty($info['numero_tarjeta'])){ ?>
				<i class="icon-list-alt"></i> <span class="bold"> Número de Tarjeta:</span> <? echo $info['numero_tarjeta']."<br/>";  }  ?>
				 <?	if(strlen($info['cedula'])>4){?>
        		<i class='icon-star'></i> <span class='bold'>Identificación: </span> <?echo $info['cedula']."<br/>";     	}  ?>
		        <? if(isset($info['fecha_nacimiento']) && !empty($info['fecha_nacimiento'])){ ?>
				<i class="icon-gift"></i> <span class="bold"> Fecha nacimiento:</span> <? echo $info['fecha_nacimiento']."<br/>";  }  ?>
				<? if(isset($info['estado_civil']) && strlen($info['estado_civil'])>0){ ?>
				<i class="icon-heart"></i> <span class="bold">Estado Civil: </span><? echo $info['estado_civil']."<br/>";} ?>
				<? if(isset($info['genero']) && strlen($info['genero'])>2){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Genero: </span><? echo $info['genero']."<br/>";} ?>
				<? if(isset($info['nacionalidad']) && strlen($info['nacionalidad'])>2){ ?>
				<i class="icon-home"></i> <span class="bold">Nacionalidad: </span><? echo $info['nacionalidad']."<br/>";} ?>
				<? if(isset($info['profesion']) && strlen($info['profesion'])>2){ ?>
				<i class="icon-tag"></i> <span class="bold">Profesión: </span><? echo $info['profesion']."<br/>";} ?>
		        <? if(isset($info['nombre_madre']) && strlen($info['nombre_madre'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Nombre de la Madre: </span><? echo $info['nombre_madre']."<br/>";} ?>
				 <? if(isset($info['nombre_padre']) && strlen($info['nombre_padre'])>2){ ?>
				<i class="icon-user"></i> <span class="bold">Nombre del Padre: </span><? echo $info['nombre_padre']."<br/>";} ?>
				<? if(isset($info['senias_particulares']) && strlen($info['senias_particulares'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Señas Particulares: </span><? echo $info['senias_particulares']."<br/>";} ?>
		        <? if(isset($info['amputaciones']) && strlen($info['amputaciones'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Amputaciones: </span><? echo $info['amputaciones']."<br/>";} ?>
				<? if(isset($info['estatura']) && strlen($info['estatura'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Estatura: </span><? echo $info['estatura']."<br/>";} ?>
				<? if(isset($info['peso']) && strlen($info['peso'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Peso: </span><? echo $info['peso']."<br/>";} ?>
				<? if(isset($info['complexion']) && strlen($info['complexion'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Complexión: </span><? echo $info['complexion']."<br/>";} ?>
				<? if(isset($info['cabello']) && strlen($info['cabello'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Cabello: </span><? echo $info['cabello']."<br/>";} ?>
				<? if(isset($info['color_tez']) && strlen($info['color_tez'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Color de Tez: </span><? echo $info['color_tez']."<br/>";} ?>
				<? if(isset($info['color_ojos']) && strlen($info['color_ojos'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Color de ojos: </span><? echo $info['color_ojos']."<br/>";} ?>
				<? if(isset($info['tipo_nariz']) && strlen($info['tipo_nariz'])>0){ ?>
				<i class=" icon-arrow-right"></i> <span class="bold">Tipo de Nariz: </span><? echo $info['tipo_nariz']."<br/>";} ?>

		      </p>
			</div>
		</div>
	</div>

	</div> <!-- fin del well -->

<?}
}

public function despliega_sinonimos_bi($sinonimos=array()){

$this->tooltip_si++;
	?>
	<script>
		    $(function () {
                $('#tooltips<?echo $this->tooltip_si;?>').tooltip();

            });
	</script>

	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span12" style="text">
				<br/> <?
				$i=0;
					foreach($sinonimos as $info){

						$i++;?>

		        <? if(isset($info['nombre']) && !empty($info['nombre'])){ ?>
				     <blockquote>
				<a href="#"  id="tooltips<?echo $this->tooltip_si;?>" data-toggle="tooltip" data-html="true" title="<? echo $info['tooltip']; ?>" data-placement="right">  <? echo $info['nombre'];?></a><br><?  }  ?>

				     </blockquote>
			  		<?}

				?>
		      </p>
			</div>
		</div>
	</div>




	<?


}
public function despliega_apodos_bi($apodos=array()){

	?>

	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span12" style="text">
				<?
				$i=0;
					foreach($apodos as $info){

						$i++;?>

		        <? if(isset($info['apodo']) && !empty($info['apodo'])){ ?>
				    <i class="icon-chevron-right"></i>  <? echo $i.".".$info['apodo'];?></a><br><?  }  ?>
			  		<?}

				?>
		      </p>
			</div>
		</div>
	</div>




	<?


}

	public function sinonimos_bi($id_ciudadano_bi=0){
		$atributos_sinonimos = array(
            array('name' => 'id', 'header' => '#'),
            array('name' => 'nombre', 'header' => 'Nombre Completo'),
            );
		$sinonimos = $this->trae_sinonimos_bi($id_ciudadano_bi);
		if (count($sinonimos) > 0) {
			foreach($sinonimos as $dato_sinonimo) {
				$this->nombres_schema_bi .= ", alias: " . $dato_sinonimo['nombre'];
			}
			echo $this->tabla($atributos_sinonimos, $sinonimos);
		} else {
			$this->nombres_schema_bi = $this->nombres_schema_bi;
			echo "No tiene Sinonimos";
		}
	}

public function apodos_bi($id_ciudadano_bi=0){
		$atributos_apodos = array(
            array('name' => 'id', 'header' => '#'),
            array('name' => 'apodo', 'header' => 'Apodos'),
            );
		$apodos = $this->trae_apodos_bi($id_ciudadano_bi);
		if (count($apodos) > 0) {
			foreach($apodos as $dato_apodo) {
				$this->nombres_schema_bi .= ", alias: " . $dato_apodo['nombre_apodo'];
			}
			echo $this->tabla($atributos_sinonimos, $apodos);
		} else {
			$this->nombres_schema_bi = $this->nombres_schema_bi;
			echo "No tiene Apodos";
		}
	}
public function ciudadanos_bi($id_ciudadano_bi){
		$atributos_ciudadano = array(
            array('name' => 'numero_tarjeta', 'header' => 'Numero de Tarjeta'), //0
            array('name' => 'fecha_nacimiento', 'header' => 'Fecha Nacimiento'),//1
            array('name' => 'cedula', 'header' => 'Cedula'),					//2
            array('name' => 'padres', 'label' => 'Padre y Madre:'),				//3
            array('name' => 'lugar_nacimiento', 'header' => 'Lugar Nacimiento'),//4
            array('name' => 'genero', 'header' => 'G&eacute;nero'),					//5
            array('name' => 'estado_civil', 'header' => 'Estado Civil'),		//6
            array('name' => 'nacionalidad', 'header' => 'Nacionalidad'),		//7
            array('name' => 'profesion', 'header' => 'Profesion'),				//8
            array('name' => 'senias_particulares', 'header' => 'Senias Particulares'),//9
            array('name' => 'amputaciones', 'header' => 'Amputaciones'),		//10
            array('name' => 'estatura', 'header' => 'Estatura'),				//11
            array('name' => 'peso', 'header' => 'Peso'),						//12
            array('name' => 'complexion', 'header' => 'Complexion'),			//13
            array('name' => 'cabello', 'header' => 'Cabello'),					//14
            array('name' => 'color_tez', 'header' => 'Color Tez'),				//15
            array('name' => 'color_ojos', 'header' => 'Color Ojos'),			//16
            array('name' => 'tipo_nariz', 'header' => 'Tipo Nariz'),			//17
            );
		$ciudadano = $this->trae_ciudadanos_bi($id_ciudadano_bi);
		if (count($ciudadano) > 0) {
			foreach($ciudadano as $datos) {
				$datos_busqueda['numero_tarjeta'] = $datos['numero_tarjeta'];
				$datos_busqueda['fecha_nacimiento'] = $datos['fecha_nacimiento'];
				$datos_busqueda['cedula'] = $datos['cedula'];
				$datos_busqueda['padres'] = "Padre: " . $datos['nombre_padre'] . "   Madre: " . $datos['nombre_madre'];
				$datos_busqueda['lugar_nacimiento'] = $datos['lugar_nacimiento'] . ",   Depto: " . $datos['departamento_nacimiento'] . "   Munic: " . $datos['municipio_nacimiento'];
				$datos_busqueda['genero'] = $datos['genero'];
				$datos_busqueda['estado_civil'] = $datos['estado_civil'];
				$datos_busqueda['nacionalidad'] = $datos['nacionalidad'];
				$datos_busqueda['profesion'] = $datos['profesion'];
				$datos_busqueda['senias_particulares'] = $datos['senias_particulares'];
				$datos_busqueda['amputaciones'] = $datos['amputaciones'];
				$datos_busqueda['estatura'] = $datos['estatura'];
				$datos_busqueda['peso'] = $datos['peso'];
				$datos_busqueda['complexion'] = $datos['complexion'];
				$datos_busqueda['cabello'] = "Tipo Cabello: " . $datos['tipo_cabello'] . "   Color Cabello: " . $datos['color_cabello'];
				$datos_busqueda['color_tez'] = $datos['color_tez'];
				$datos_busqueda['color_ojos'] = $datos['color_ojos'];
				$datos_busqueda['tipo_nariz'] = $datos['tipo_nariz'];
			} // fin  for
			echo $this->tabla_detalle($datos_busqueda, $atributos_ciudadano);
		} else {
			echo "No tiene Ciudadano";
		}
	}
public function trae_dpi($id_ciudadano_renap=0){
	$sql = "SELECT dpi FROM sapo_gestion.sapogt_ciudadano_renap_t WHERE id_ciudadano_renap = " . $id_ciudadano_renap;
    $dbO = Yii::app()->db->createCommand($sql);
    $dpi = $dbO->queryScalar();
	return $dpi;
}
public function trae_id_ciudadano_renap($dpi=0){
	$sql = "SELECT id_ciudadano_renap FROM sapo_gestion.sapogt_ciudadano_renap_t WHERE dpi = " . $dpi;
    $dbO = Yii::app()->db->createCommand($sql);
    $id_ciudadano_renap = $dbO->queryScalar();
	return $id_ciudadano_renap;


}
public function trae_ciudadanos_bi($id_ciudadano_bi=0)
	{
		$datos =array();
		$a_datos =array();
		$sql = "Select id_ciudadano, fecha_nacimiento, concat (orden_cedula,' ', registro_cedula ) as cedula,
				concat(nombres_padre,' ',nombre2_padre,' ',apellidos_padre,' ',apellido2_padre) as nombre_padre,
				concat(nombres_madre,' ',nombre2_madre,' ',apellidos_madre,' ',apellido2_madre,' ',ape_casa_madre) as nombre_madre,
				lugar_nacimiento, cod_depto as depto_nacimiento, cod_municipio as muni_nacimiento, sexo, estado_civil,
				cod_nacionalidad, cod_profesion, senias_particulares, amputaciones, cod_color_tez, peso, cod_complexion,
				cod_color_cabello,cod_tipo_cabello, cod_color_ojos, cod_codigo_nariz, estatura, expediente as num_tarjeta
				from bi.ciudadanos1 where id_ciudadano = ".$id_ciudadano_bi;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$i = 0;
		foreach ($dbO->queryAll() as $resultado) {
			if(strlen($resultado->fecha_nacimiento)>0){
				$date = new DateTime($resultado->fecha_nacimiento);
				$datos['fecha_nacimiento'] =$date->format('d/m/Y');
			}
			if(strlen($resultado->cedula)>0){
				$datos['cedula'] = trim($resultado->cedula);
			}
			if(strlen($resultado->nombre_padre)>0){
				$datos['nombre_padre'] = trim($resultado->nombre_padre);
			}
			if(strlen($resultado->nombre_madre)>0){
				$datos['nombre_madre'] = trim($resultado->nombre_madre);
			}
			if(strlen($resultado->lugar_nacimiento)>0){
				$datos['lugar_nacimiento'] = $resultado->lugar_nacimiento;
			}
			if($resultado->depto_nacimiento>0){
				$datos['departamento_nacimiento'] = $this->traduce_departamento_bi($resultado->depto_nacimiento);
					if($resultado->muni_nacimiento>0){
						$datos['municipio_nacimiento'] = $this->traduce_municipio_bi($resultado->muni_nacimiento,$resultado->depto_nacimiento);
					}
			}
			if($resultado->sexo>0){
				$datos['genero'] = $this->traduce_criterio_fijo_bi($resultado->sexo,2);
			}
			if($resultado->estado_civil>0){
				$datos['estado_civil'] = $this->traduce_criterio_fijo_bi($resultado->estado_civil,3);
			}
			if($resultado->cod_nacionalidad>0){
				$datos['nacionalidad'] = $this->traduce_cat_item_bi($resultado->cod_nacionalidad,6);
			}
			if($resultado->cod_profesion>0){
				$datos['profesion'] = $this->traduce_cat_item_bi($resultado->cod_profesion,9);
			}
			if(strlen($resultado->senias_particulares)>0){
				$datos['senias_particulares'] = $resultado->senias_particulares;
			}
			if(strlen($resultado->amputaciones)>0){
				$datos['amputaciones'] = $resultado->amputaciones;
			}
			if($resultado->cod_color_tez>0){
				$datos['color_tez'] = $this->traduce_cat_item_bi($resultado->cod_color_tez,13);
			}
			if($resultado->peso>0){
				$datos['peso'] = $resultado->peso;
			}
			if($resultado->cod_complexion>0){
				$datos['complexion'] = $this->traduce_cat_item_bi($resultado->cod_complexion,3);
			}
			if($resultado->cod_color_cabello>0){
				$datos['color_cabello'] = $this->traduce_cat_item_bi($resultado->cod_color_cabello,1);
			}
			if($resultado->cod_tipo_cabello>0){
				$datos['tipo_cabello'] = $this->traduce_cat_item_bi($resultado->cod_tipo_cabello,10);
			}
			if($resultado->cod_color_ojos>0){
				$datos['color_ojos'] = $this->traduce_cat_item_bi($resultado->cod_color_ojos,2);
			}
			if($resultado->cod_codigo_nariz>0){
				$datos['tipo_nariz'] = $this->traduce_cat_item_bi($resultado->cod_codigo_nariz,12);
			}
			if($resultado->estatura>0){
				$datos['estatura'] = $resultado->estatura;
			}
			if($resultado->num_tarjeta>0){
				$datos['numero_tarjeta'] = $resultado->num_tarjeta;
			}
			$a_datos[] = $datos;
		}
		return $a_datos;
	}

	public function traduce_cat_item_bi($id_cat_item_bi=0,$id_cat=0){
		$valor = '';
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('descripcion')
				 ->from('sapo_gestion.sapogt_cat_item')
				 ->where('id_codigo_bi=:id_codigo_bi and id_cat=:id_cat and estado=:estado', array(':id_codigo_bi'=>$id_cat_item_bi, ':id_cat'=>$id_cat, ':estado'=>1));
		foreach($conn->queryAll() as $data)
		{
			$valor = $data->descripcion;
		}
		return $valor;
	}


		public function fichas_bi($id_ficha=0){
		$atributos_ficha = array(
            array('name' => 'fecha_emision', 'header' => 'Fecha de Emision'),
            array('name' => 'lugar_emision', 'header' => 'Lugar de Emision'),
            array('name' => 'juzgado', 'header' => 'Juzgado'),
            array('name' => 'cuerpo_pn', 'header' => 'Cuerpo PN'),
            array('name' => 'fecha_captura', 'header' => 'Fecha de Captura'),
            array('name' => 'referencia_foto', 'header' => 'Referencia Foto'),
            array('name' => 'observaciones', 'header' => 'Observaciones'),
            array('name' => 'fecha_ingreso', 'header' => 'Fecha de Ingreso'),
            array('name' => 'motivo_fecha', 'header' => 'Motivo'),
            array('name' => 'agentes_captores', 'header' => 'Lugar de Emision'),
            array('name' => 'resolucion_caso', 'header' => 'Lugar de Emision'),
            );
		$ficha_bi = $this->trae_fichas_bi($id_ficha);
		if (count($ficha_bi) > 0) {
			foreach($ficha_bi as $datos) {
				$datos_busqueda['fecha_emision'] = $datos['fecha_emision'];
				$datos_busqueda['lugar_emision'] = $datos['lugar_emision'] . ",   Depto: " . $datos['departamento_emision'] . "   Munic: " . $datos['municipio_emision'];
				$datos_busqueda['juzgado'] = $datos['juzgado'] . ",   Depto: " . $datos['departamento_juzgado'] . "   Munic: " . $datos['municipio_juzgado'];
				$datos_busqueda['cuerpo_pn'] = $datos['cuerpo_pn'];
				$datos_busqueda['fecha_captura'] = $datos['fecha_captura'];
				$datos_busqueda['referencia_foto'] = $datos['referencia_foto'];
				$datos_busqueda['observaciones'] = $datos['observaciones'];
				$datos_busqueda['fecha_ingreso'] = $datos['fecha_ingreso'];
				$datos_busqueda['motivo_ficha'] = $datos['motivo_ficha'];
				$datos_busqueda['agentes_captores'] = $datos['agentes_captores'];
				$datos_busqueda['resolucion_caso'] = $datos['resolucion_caso'];
			}
			echo $this->tabla_detalle($datos_busqueda, $atributos_ficha);
		} else {
			echo "No tiene Ficha";
		}
	}

	public function formula_dactilar_bi($id_ciudadano_bi=0){
		$atributos = array(
            array('name' => 'id', 'header' => '#'),
            array('name' => 'num_formula', 'header' => 'No.Formula'),
            array('name' => 'formula_mano_derecha', 'header' => 'Mano Derecha'),
            array('name' => 'formula_mano_izquierda', 'header' => 'Mano Izquierda'),
            array('name' => 'tipo_formula', 'header' => 'Tipo Formula'),
            );
		$formulas_bi = $this->trae_formula_dactilar_bi($id_ciudadano_bi);
		if (count($formulas_bi) > 0) {
			echo $this->tabla($atributos, $formulas_bi);
		} else {
			echo "No tiene formula dactilar";
		}
	}

	public function fichas_sapo($id_ficha=0)
	{
		$atributos_fichas_sapo = array(
            array('name' => 'nombre', 'label' => 'Nombre Completo'),
            array('name' => 'fecha_nacimiento', 'header' => 'Fecha de Nacimiento'),
            array('name' => 'lugar_nacimiento', 'header' => 'Lugar de Nacimiento'),
            array('name' => 'dpi', 'header' => 'DPI'),
            array('name' => 'cedula', 'header' => 'Cedula'),
            array('name' => 'nacionalidad', 'header' => 'Nacionalidad'),
            array('name' => 'genero', 'header' => 'G&eacute;nero'),
            array('name' => 'estado_civil', 'header' => 'Estado Civil'),
            array('name' => 'padres', 'label' => 'Padre y Madre'),
            array('name' => 'profesion', 'header' => 'Nit'),
            array('name' => 'senias_particulares', 'header' => 'Fecha de Defuncion'),
            array('name' => 'amputaciones', 'header' => 'Amputaciones'),
            array('name' => 'peso', 'header' => 'Peso'),
            array('name' => 'estatura', 'header' => 'Estatura'),
            array('name' => 'cod_complexion', 'label' => 'Complexion'),
            array('name' => 'cod_codigo_grupo', 'label' => 'Grupo'),
            array('name' => 'cabello', 'header' => 'Cabello'),
            array('name' => 'cod_color_ojos', 'label' => 'Color Ojos'),
            array('name' => 'cod_color_tez', 'label' => 'Color Tez'),
            array('name' => 'cod_codigo_nariz', 'label' => 'Tipo Nariz'),
            array('name' => 'lugar_emision', 'label' => 'Lugar de Emision de Ficha'),
            array('name' => 'fecha_emision', 'label' => 'Fecha de Emision de Ficha'),
            array('name' => 'observaciones', 'header' => 'Observaciones'),
            array('name' => 'cod_motivo_ficha', 'label' => 'Motivo de Ficha'),
            array('name' => 'juzgado', 'label' => 'Juzgado'),
            array('name' => 'num_expediente', 'label' => 'Numero de Expediente'),
            array('name' => 'agentes_captores', 'label' => 'Agentes Captores'),
            array('name' => 'resolucion_caso', 'label' => 'Resolucion de Caso'),
            array('name' => 'fallecido', 'label' => 'Esta Fallecido'),
            array('name' => 'fecha_defuncion', 'header' => 'Fecha de Defuncion'),
            array('name' => 'acta_defuncion', 'header' => 'Acta de Defuncion'),
            );
		$ficha_sapo = $this->trae_fichas_sapo($id_ficha);
		if (count($ficha_sapo) > 0) {
			$num_expediente = 0;
			foreach($ficha_sapo as $datos) {
				$this->nombres_schema_sapo = $datos['nombre'];
				$num_expediente = $datos['num_expediente'];
				$datos_busqueda['nombre'] = $datos['nombre'];
				$datos_busqueda['fecha_nacimiento'] = $datos['fecha_nacimiento'];
				$datos_busqueda['lugar_nacimiento'] = $datos['lugar_nacimiento'] . ",   Depto: " . $datos['cod_depto_nacimiento'] . "   Munic: " . $datos['cod_munic_nacimiento'];
				$datos_busqueda['dpi'] = $datos['dpi'];
				$datos_busqueda['cedula'] = $datos['cedula'] . " Extendida: " . $datos['cod_depto_cedula'] . ", " . $datos['cod_muni_cedula'];
				$datos_busqueda['nacionalidad'] = $datos['cod_nacionalidad'];
				$datos_busqueda['genero'] = $datos['genero'];
				$datos_busqueda['estado_civil'] = $datos['estado_civil'];
				$datos_busqueda['padres'] = "Padre: " . $datos['nombre_padre'] . "    Madre: " . $datos['nombre_madre'];
				$datos_busqueda['profesion'] = $datos['profesion'];
				$datos_busqueda['senias_particulares'] = $datos['senias_particulares'];
				$datos_busqueda['amputaciones'] = $datos['amputaciones'];
				$datos_busqueda['peso'] = $datos['peso'];
				$datos_busqueda['estatura'] = $datos['estatura'];
				$datos_busqueda['cod_complexion'] = $datos['cod_complexion'];
				$datos_busqueda['cod_codigo_grupo'] = $datos['cod_codigo_grupo'];
				$datos_busqueda['cabello'] = "Tipo Cabello: " . $datos['cod_tipo_cabello'] . "  Color Cabello: " . $datos['cod_color_cabello'];
				$datos_busqueda['cod_color_ojos'] = $datos['cod_color_ojos'];
				$datos_busqueda['cod_color_tez'] = $datos['cod_color_tez'];
				$datos_busqueda['cod_codigo_nariz'] = $datos['cod_codigo_nariz'];
				$datos_busqueda['lugar_emision'] = $datos['lugar_emision_ficha'] . ", Depto: " . $datos['cod_depto_emision_ficha'] . " Munic: " . $datos['cod_muni_emision_ficha'];
				$datos_busqueda['fecha_emision'] = $datos['fecha_emision'];
				$datos_busqueda['observaciones'] = $datos['observaciones'];
				$datos_busqueda['cod_motivo_ficha'] = $datos['cod_motivo_ficha'];
				$datos_busqueda['juzgado'] = $datos['juzgado'];
				$datos_busqueda['num_expediente'] = $datos['num_expediente'];
				$datos_busqueda['agentes_captores'] = $datos['agentes_captores'];
				$datos_busqueda['resolucion_caso'] = $datos['resolucion_caso'];
				$datos_busqueda['fallecido'] = $datos['fallecido'];
				$datos_busqueda['fecha_defuncion'] = $datos['fecha_defuncion'];
				$datos_busqueda['acta_defuncion'] = $datos['acta_defuncion'];
			}
			echo $this->tabla_detalle($datos_busqueda, $atributos_fichas_sapo);
		} else {
			$this->nombres_schema_sapo = $this->nombres_schema_sapo;
			echo "No tiene datos ciudadano";
		}
	}

	public function formula_dactilar_sapo($id_ficha=0)
	{
		$atributos = array(
            array('name' => 'id', 'header' => '#'),
            array('name' => 'tipo', 'header' => 'Tipo'),
            array('name' => 'valor', 'header' => 'Formula'),
            array('name' => 'lado_mano', 'header' => 'Lado Mano'),
            );
		$formula_sapo = $this->trae_formula_dactilar_sapo($id_ficha);
		if (count($formula_sapo) > 0) {
			$this->tabla($atributos, $formula_sapo);
		} else {
			echo "No tiene formula dactilar";
		}
	}
	public function trae_fichas_sapo($id_ficha_sapo=0)
	{
		$datos =array();
		$dpi =0;
		$a_datos =array();
		$sql = "Select * from sapo_gestion.sapogt_ficha_criminal where id_ficha_criminal = ".$id_ficha_sapo;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {

			$nombre = trim($resultado->primer_nombre);

			if (strlen($resultado->segundo_nombre)>0) {
				$nombre .= " ".trim($resultado->segundo_nombre);
			}
			else{
				$nombre .= "";
			}
			if (strlen($resultado->tercer_nombre)>0) {
				$nombre .= " ".trim($resultado->tercer_nombre);
			}
			else{
				$nombre .= "";
			}

			$nombre .= " ".trim($resultado->primer_apellido);

			if (strlen($resultado->segundo_apellido)>0) {
				$nombre .= " ".trim($resultado->segundo_apellido);
			}
			else{
				$nombre	.= "";
			}
			if (strlen($resultado->apellido_casada)>0) {
				$nombre .= " de ".trim($resultado->apellido_casada);
			}
			else{
				$nombre .= "";
			}

			$this->nombres_schema_sapo = $nombre;
			$datos['nombre'] = $nombre;

				$datos['primer_nombre_sndex'] = $resultado->primer_nombre_sndex;
			$datos['segundo_nombre_sndex'] = $resultado->segundo_nombre_sndex;
			$datos['tercer_nombre_sndex'] = $resultado->tercer_nombre_sndex;
			$datos['primer_apellido_sndex'] = $resultado->primer_apellido_sndex;
			$datos['segundo_apellido_sndex'] = $resultado->segundo_apellido_sndex;
			$datos['apellido_casada_sndex'] = $resultado->apellido_casada_sndex;


			$datos['id_ficha_criminal'] = $resultado->id_ficha_criminal;
			$datos['num_expediente'] = $resultado->num_expediente;
			$datos['id_ciudadano_renap'] = $resultado->id_ciudadano_renap;

			// buscar el dpi por medio de esta funcion
			$dpi='';
			if($resultado->id_ciudadano_renap>0){
				$d = $this->trae_datos_ciudadano_renap_formato($resultado->id_ciudadano_renap);
				foreach ($d as $valor){
										$dpi = $valor['dpi'];
									}
			}
			if(strlen($resultado->fecha_nacimiento)>0){
				$date = new DateTime($resultado->fecha_nacimiento);
				$datos['fecha_nacimiento'] =$date->format('d/m/Y');
			}

			$datos['dpi'] = $dpi;
			$datos['cedula'] = trim($resultado->orden_cedula)." ".trim($resultado->registro_cedula);
			if($resultado->cod_depto_cedula>0){
				$datos['cod_depto_cedula'] = $this->trae_departamento_renap($resultado->cod_depto_cedula);
			}
			if($resultado->cod_muni_cedula>0){
				$datos['cod_muni_cedula'] = $this->trae_municipio_renap($resultado->cod_muni_cedula);
			}
			if($resultado->estado_civil>0){
				$datos['estado_civil'] = $this->busca_criterio_fijo($resultado->estado_civil,3);
			}
			if($resultado->genero>0){
			$datos['genero'] = $this->busca_criterio_fijo($resultado->genero,2);
			}




			if (strlen($resultado->direc_calle)>0) {
				$direccion = trim($resultado->direc_calle)." Calle ";
			}
			else{
				$direccion = "";
			}
			if (strlen($resultado->direc_ave)>0) {
				$direccion .= trim($resultado->direc_ave)." Av. ";
			}
			else{
				$direccion .= "";
			}
			if (strlen($resultado->direc_num_inmueble)>0) {
				$direccion .= trim($resultado->direc_num_inmueble)." ";
			}
			else{
				$direccion .= "";
			}
			if (strlen($resultado->direc_barrio)>0) {
				$direccion .= trim($resultado->direc_barrio)." ";
			}
			else{
				$direccion .= "";
			}
			if (strlen($resultado->direc_zona)>0) {
				$direccion .= " Zona ".trim($resultado->direc_zona);
			}
			else{
				$direccion .= "";
			}
			$datos['direccion']=$direccion;
			if($resultado->direc_cod_depto>0){
				$datos['direc_cod_depto'] = $this->trae_departamento_renap($resultado->direc_cod_depto);
			}
			if($resultado->direc_cod_munic>0){
				$datos['direc_cod_munic'] = $this->trae_municipio_renap($resultado->direc_cod_munic);
			}
			if($resultado->cod_depto_nacimiento>0){
				$datos['cod_depto_nacimiento'] = $this->trae_departamento_renap($resultado->cod_depto_nacimiento);
			}
			if($resultado->cod_munic_nacimiento>0){
			$datos['cod_munic_nacimiento'] = $this->trae_municipio_renap($resultado->cod_munic_nacimiento);
			}


			$datos['lugar_nacimiento'] = $resultado->lugar_nacimiento;
			if($resultado->cod_nacionalidad>0){
				$datos['nacionalidad'] =$this->busca_cat_item($resultado->cod_nacionalidad);
			}

			$datos['profesion'] = $resultado->profesion;
			$nombre_madre = trim($resultado->madre_primer_nombre);

			if (strlen($resultado->madre_segundo_nombre)>0) {
				$nombre_madre .= " ".trim($resultado->madre_segundo_nombre);
			}
			else{
				$nombre_madre .= "";
			}
			if (strlen($resultado->madre_tercer_nombre)>0) {
				$nombre_madre .= " ".trim($resultado->madre_tercer_nombre);
			}
			else{
				$nombre_madre .= "";
			}

			$nombre_madre .= " ".trim($resultado->madre_primer_apellido);

			if (strlen($resultado->madre_segundo_apellido)>0) {
				$nombre_madre .= " ".trim($resultado->madre_segundo_apellido);
			}
			else{
				$nombre_madre	.= "";
			}
			if (strlen($resultado->madre_apellido_casada)>0) {
				$nombre_madre .= " de ".trim($resultado->madre_apellido_casada);
			}
			else{
				$nombre_madre .= "";
			}
			$datos['nombre_madre'] =$nombre_madre;


			$nombre_padre = trim($resultado->padre_primer_nombre);
			if (strlen($resultado->padre_segundo_nombre)>0) {
				$nombre_padre .= " ".trim($resultado->padre_segundo_nombre);
			}
			else{
				$nombre_padre .= "";
			}
			if (strlen($resultado->padre_tercer_nombre)>0) {
				$nombre_padre .= " ".trim($resultado->padre_tercer_nombre);
			}
			else{
				$nombre_padre .= "";
			}
			$nombre_padre .= " ".trim($resultado->padre_primer_apellido);
			if (strlen($resultado->padre_segundo_apellido)>0) {
				$nombre_padre .= " ".trim($resultado->padre_segundo_apellido);
			}
			else{
				$nombre_padre	.= "";
			}
			$datos['nombre_padre'] =$nombre_padre;
			$datos['senias_particulares'] = $resultado->senias_particulares;
			$datos['amputaciones'] = $resultado->amputaciones;
			$datos['peso'] = $resultado->peso;
			$datos['cod_tipo_cabello'] = $this->busca_cat_item($resultado->cod_tipo_cabello);
			$datos['cod_color_cabello'] = $this->busca_cat_item($resultado->cod_color_cabello);
			$datos['cod_color_ojos'] = $this->busca_cat_item($resultado->cod_color_ojos);
			$datos['cod_color_tez'] = $this->busca_cat_item($resultado->cod_color_tez);
			$datos['cod_codigo_nariz'] = $this->busca_cat_item($resultado->cod_codigo_nariz);
			$datos['cod_complexion'] = $this->busca_cat_item($resultado->cod_complexion);
			$datos['cod_codigo_grupo'] = $this->busca_cat_item($resultado->cod_codigo_grupo);
			$datos['estatura'] = $resultado->estatura;
			$datos['id_afis'] = $resultado->id_afis;
			$datos['lugar_emision_ficha'] = $resultado->lugar_emision_ficha;
			if($resultado->cod_depto_emision_ficha>0){
				$datos['cod_depto_emision_ficha'] = $this->trae_departamento_renap($resultado->cod_depto_emision_ficha);
			}
			if($resultado->cod_muni_emision_ficha>0){
				$datos['cod_muni_emision_ficha'] = $this->trae_municipio_renap($resultado->cod_muni_emision_ficha);
			}

				if(strlen($resultado->fecha_emision)>0){
				$date = new DateTime($resultado->fecha_emision);
				$datos['fecha_emision'] =$date->format('d/m/Y');
			}

			$datos['observaciones'] = $resultado->observaciones;
			$datos['cod_motivo_ficha'] = $this->busca_cat_item($resultado->cod_motivo_ficha);
			$datos['fallecido'] = $resultado->fallecido;
			if (!empty($resultado->fecha_defuncion)) {
				$datos['fecha_defuncion'] = date("d/m/Y",strtotime($resultado->fecha_defuncion));
			}
			else{
				$datos['fecha_defuncion'] = '';
			}
			$datos['acta_defuncion'] = $resultado->acta_defuncion;
			$datos['num_expediente'] = $resultado->num_expediente;
			if($resultado->cod_juzgado>0 && $resultado->cod_depto_juzgado>0 && $resultado->cod_muni_juzgado>0){
				$datos['juzgado']= $this->trae_juzgado_sapo($resultado->cod_juzgado,$resultado->cod_depto_juzgado,$resultado->cod_muni_juzgado);
			}
			$datos['agentes_captores'] = $resultado->agentes_captores;
			$datos['resolucion_caso'] = $resultado->resolucion_caso;
			$a_datos[] = $datos;
		}
		return $a_datos;
	}
	public function trae_datos_ciudadano_renap_formato($id_ciudadano_renap=0)
	{
		$a_datos = array();
		$datos = array();
		$datos_renap = $this->trae_datos_ciudadano_renap($id_ciudadano_renap);
		foreach($datos_renap as $resultado){
			$nombre = trim($resultado->primer_nombre);

			if (strlen($resultado->segundo_nombre)>0) {
				$nombre .= " ".trim($resultado->segundo_nombre);
			}
			else{
				$nombre .= "";
			}
			if (strlen($resultado->tercer_nombre)>0) {
				$nombre .= " ".trim($resultado->tercer_nombre);
			}
			else{
				$nombre .= "";
			}

			$nombre .= " ".trim($resultado->primer_apellido);

			if (strlen($resultado->segundo_apellido)>0) {
				$nombre .= " ".trim($resultado->segundo_apellido);
			}
			else{
				$nombre	.= "";
			}
			if (strlen($resultado->apellido_casada)>0) {
				$nombre .= " de ".trim($resultado->apellido_casada);
			}
			else{
				$nombre .= "";
			}

			$datos['nombre'] = $nombre;
			$datos['fecha_nacimiento'] = date("d/m/Y",strtotime($resultado->fecha_nacimiento));
			$datos['pais_nacimiento'] =$resultado->pais_nacimiento;
			$datos['depto_nacimiento'] = $resultado->depto_nacimiento;
			$datos['munic_nacimiento'] = $resultado->munic_nacimiento;
			$datos['nombre_padre'] = $resultado->nombre_padre;
			$datos['nombre_madre'] = $resultado->nombre_madre;
			$datos['dpi'] = $resultado->dpi;
			$datos['cedula'] = $resultado->orden_cedula." ".$resultado->registro_cedula;
			$datos['depto_cedula'] = $resultado->depto_cedula;
			$datos['munic_cedula'] = $resultado->munic_cedula;
			$datos['nacionalidad'] = $resultado->nacionalidad;
			$datos['estado_civil'] = $this->busca_criterio_fijo($resultado->estado_civil,3);
			$datos['genero'] = $this->busca_criterio_fijo($resultado->genero,2);
			$datos['nit'] = $resultado->nit;
			$datos['fallecido'] = $resultado->fallecido;
			if (!empty($resultado->fecha_defuncion)) {
				$datos['fecha_defuncion'] = date("d/m/Y",strtotime($resultado->fecha_defuncion));
			}
			else{
				$datos['fecha_defuncion'] = '';
			}
			$datos['acta_defuncion'] = $resultado->acta_defuncion;
			$a_datos[] = $datos;
		}
		return $a_datos;
	}
/*public function trae_fichas_sapo($id_ficha_sapo=0)
	{
		$datos =array();
		$a_datos =array();
		$sql = "Select * from sapo_gestion.sapogt_ficha_criminal where id_ficha_criminal = ".$id_ficha_sapo;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {
	//		$datos['dpi'] = $resultado->dpi;

			$nombre = trim($resultado->primer_nombre);

			if (strlen($resultado->segundo_nombre)>0) {
				$nombre .= " ".trim($resultado->segundo_nombre);
			}
			else{
				$nombre .= "";
			}
			if (strlen($resultado->tercer_nombre)>0) {
				$nombre .= " ".trim($resultado->tercer_nombre);
			}
			else{
				$nombre .= "";
			}

			$nombre .= " ".trim($resultado->primer_apellido);

			if (strlen($resultado->segundo_apellido)>0) {
				$nombre .= " ".trim($resultado->segundo_apellido);
			}
			else{
				$nombre	.= "";
			}
			if (strlen($resultado->apellido_casada)>0) {
				$nombre .= " de ".trim($resultado->apellido_casada);
			}
			else{
				$nombre .= "";
			}

			$this->nombres_schema_sapo = $nombre;
			$datos['nombre'] = $nombre;
			$datos['fecha_nacimiento'] = date("d/m/Y",strtotime($resultado->fecha_nacimiento));
			$datos['cedula'] = trim($resultado->orden_cedula)." ".trim($resultado->registro_cedula);
			$datos['cod_depto_cedula'] = $this->trae_departamento_renap($resultado->cod_depto_cedula);
			$datos['cod_muni_cedula'] = $this->trae_municipio_renap($resultado->cod_muni_cedula);
			$datos['estado_civil'] = $this->busca_criterio_fijo($resultado->estado_civil,3);
			$datos['genero'] = $this->busca_criterio_fijo($resultado->genero,2);
			if (strlen($resultado->direc_calle)>0) {
				$direccion = trim($resultado->direc_calle)." Calle ";
			}
			else{
				$direccion = "";
			}
			if (strlen($resultado->direc_ave)>0) {
				$direccion .= trim($resultado->direc_ave)." Av. ";
			}
			else{
				$direccion .= "";
			}
			if (strlen($resultado->direc_num_inmueble)>0) {
				$direccion .= trim($resultado->direc_num_inmueble)." ";
			}
			else{
				$direccion .= "";
			}
			if (strlen($resultado->direc_barrio)>0) {
				$direccion .= trim($resultado->direc_barrio)." ";
			}
			else{
				$direccion .= "";
			}
			if (strlen($resultado->direc_zona)>0) {
				$direccion .= " Zona ".trim($resultado->direc_zona);
			}
			else{
				$direccion .= "";
			}
			$datos['direc_cod_depto'] = $this->trae_departamento_renap($resultado->direc_cod_depto);
			$datos['direc_cod_munic'] = $this->trae_municipio_renap($resultado->direc_cod_munic);
			$datos['cod_depto_nacimiento'] = $this->trae_departamento_renap($resultado->cod_depto_nacimiento);
			$datos['cod_munic_nacimiento'] = $this->trae_municipio_renap($resultado->cod_munic_nacimiento);
			$datos['lugar_nacimiento'] = $resultado->lugar_nacimiento;
			$datos['cod_nacionalidad'] = $resultado->cod_nacionalidad;//$this->busca_cat_item($resultado->cod_nacionalidad);
			$datos['profesion'] = $resultado->profesion;

			$nombre_madre = trim($resultado->madre_primer_nombre);

			if (strlen($resultado->madre_segundo_nombre)>0) {
				$nombre_madre .= " ".trim($resultado->madre_segundo_nombre);
			}
			else{
				$nombre_madre .= "";
			}
			if (strlen($resultado->madre_tercer_nombre)>0) {
				$nombre_madre .= " ".trim($resultado->madre_tercer_nombre);
			}
			else{
				$nombre_madre .= "";
			}

			$nombre_madre .= " ".trim($resultado->madre_primer_apellido);

			if (strlen($resultado->madre_segundo_apellido)>0) {
				$nombre_madre .= " ".trim($resultado->madre_segundo_apellido);
			}
			else{
				$nombre_madre	.= "";
			}
			if (strlen($resultado->madre_apellido_casada)>0) {
				$nombre_madre .= " de ".trim($resultado->madre_apellido_casada);
			}
			else{
				$nombre_madre .= "";
			}
			$datos['nombre_madre'] =$nombre_madre;


			$nombre_padre = trim($resultado->padre_primer_nombre);
			if (strlen($resultado->padre_segundo_nombre)>0) {
				$nombre_padre .= " ".trim($resultado->padre_segundo_nombre);
			}
			else{
				$nombre_padre .= "";
			}
			if (strlen($resultado->padre_tercer_nombre)>0) {
				$nombre_padre .= " ".trim($resultado->padre_tercer_nombre);
			}
			else{
				$nombre_padre .= "";
			}
			$nombre_padre .= " ".trim($resultado->padre_primer_apellido);
			if (strlen($resultado->padre_segundo_apellido)>0) {
				$nombre_padre .= " ".trim($resultado->padre_segundo_apellido);
			}
			else{
				$nombre_padre	.= "";
			}
			$datos['nombre_padre'] =$nombre_padre;

			$datos['senias_particulares'] = $resultado->senias_particulares;
			$datos['amputaciones'] = $resultado->amputaciones;
			$datos['peso'] = $resultado->peso;
			$datos['cod_tipo_cabello'] = $this->busca_cat_item($resultado->cod_tipo_cabello);
			$datos['cod_color_cabello'] = $this->busca_cat_item($resultado->cod_color_cabello);
			$datos['cod_color_ojos'] = $this->busca_cat_item($resultado->cod_color_ojos);
			$datos['cod_color_tez'] = $this->busca_cat_item($resultado->cod_color_tez);
			$datos['cod_codigo_nariz'] = $this->busca_cat_item($resultado->cod_codigo_nariz);
			$datos['cod_complexion'] = $this->busca_cat_item($resultado->cod_complexion);
			$datos['cod_codigo_grupo'] = $this->busca_cat_item($resultado->cod_codigo_grupo);
			$datos['estatura'] = $resultado->estatura;
			$datos['id_afis'] = $resultado->id_afis;
			$datos['lugar_emision_ficha'] = $resultado->lugar_emision_ficha;
			$datos['cod_depto_emision_ficha'] = $this->trae_departamento_renap($resultado->cod_depto_emision_ficha);
			$datos['cod_muni_emision_ficha'] = $this->trae_municipio_renap($resultado->cod_muni_emision_ficha);
			$datos['fecha_emision'] = date("d/m/Y",strtotime($resultado->fecha_emision));
			$datos['observaciones'] = $resultado->observaciones;
			$datos['cod_motivo_ficha'] = $resultado->cod_motivo_ficha;
			$datos['fallecido'] = $resultado->fallecido;
			if (!empty($resultado->fecha_defuncion)) {
				$datos['fecha_defuncion'] = date("d/m/Y",strtotime($resultado->fecha_defuncion));
			}
			else{
				$datos['fecha_defuncion'] = '';
			}
			$datos['acta_defuncion'] = $resultado->acta_defuncion;
			$datos['num_expediente'] = $resultado->num_expediente;
			$datos['juzgado']= $this->trae_juzgado_sapo($resultado->cod_juzgado,$resultado->cod_depto_juzgado,$resultado->cod_muni_juzgado);
			$datos['agentes_captores'] = $resultado->agentes_captores;
			$datos['resolucion_caso'] = $resultado->resolucion_caso;
			$a_datos[] = $datos;
		}
		return $a_datos;
	}*/
	public function trae_fichas_bi($id_ficha_bi=0)
	{
		$datos =array();
		$a_datos =array();
		$sql = "Select id_ficha_bi as id_ficha, id_ciudadano, lugar_emision_ficha, cod_depto, cod_municipio,
				fecha_emision, cod_juzgado, cod_depto_juzgado, cod_municipio_juzgado, cod_cuerpo_pn, fecha_captura,
				motivo_ficha as ref_foto, observaciones, fecha_ingreso, cod_motivo_ficha, agentes_captores, resolucion_caso
				from bi.fichas where id_ficha_bi = ".$id_ficha_bi;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {
			if(strlen($resultado->fecha_emision)){
				$date = new DateTime($resultado->fecha_emision);
				$datos['fecha_emision'] =$date->format('d/m/Y');
			}
			if(strlen($resultado->lugar_emision_ficha)>2){
				$datos['lugar_emision'] = $resultado->lugar_emision_ficha;
				$emision = $datos['lugar_emision'];
			}else{
				$emision='';
			}
			if($resultado->cod_depto>0){
				$datos['departamento_emision'] = $this->traduce_departamento_bi($resultado->cod_depto);
				$emision = $emision." ".$datos['departamento_emision'];
			}
			if($resultado->cod_depto>0 && $resultado->cod_municipio>0){
			$datos['municipio_emision'] = $this->traduce_municipio_bi($resultado->cod_municipio,$resultado->cod_depto);
			$emision = $emision." ".$datos['departamento_emision'];
			}
			$datos['emision'] = $emision;

			if($resultado->cod_depto_juzgado>0){
				$datos['departamento_juzgado'] = $this->traduce_departamento_bi($resultado->cod_depto_juzgado);
				$datos['juzgado_emite']  = $datos['departamento_juzgado'];
			}
			if($resultado->cod_municipio_juzgado>0 && $resultado->cod_depto_juzgado>0){
				$datos['municipio_juzgado'] = $this->traduce_municipio_bi($resultado->cod_municipio_juzgado,$resultado->cod_depto_juzgado);
					$datos['juzgado_emite'] = 	$datos['juzgado_emite']." ".$datos['municipio_juzgado'];
			}
			if($resultado->cod_municipio_juzgado>0 && $resultado->cod_depto_juzgado>0 && $resultado->cod_juzgado){
				$datos['juzgado'] = $this->trae_juzgado_bi($resultado->cod_juzgado,$resultado->cod_depto_juzgado,$resultado->cod_municipio_juzgado);
				$datos['juzgado_emite']= $datos['juzgado_emite']." ".$datos['juzgado'];
			}
			$datos['cuerpo_pn'] = $this->traduce_cat_item_bi($resultado->cod_cuerpo_pn,7);

				if(strlen($resultado->fecha_captura)){
				$date = new DateTime($resultado->fecha_captura);
				$datos['fecha_captura']=$date->format('d/m/Y');
			}
			$datos['referencia_foto'] = $resultado->ref_foto;
			$datos['observaciones'] = $resultado->observaciones;
			if(strlen($resultado->fecha_ingreso)){
				$date = new DateTime($resultado->fecha_ingreso);
				$datos['fecha_ingreso']=$date->format('d/m/Y');
			}
			$datos['motivo_ficha'] = $this->traduce_cat_item_bi($resultado->cod_motivo_ficha,5);
			$datos['agentes_captores'] = $resultado->agentes_captores;
			$datos['resolucion_caso'] = $resultado->resolucion_caso;
			$a_datos[] = $datos;
		}

		return $a_datos;
	}

	public function trae_juzgado_bi($cod_juzgado=0,$cod_depto_juzgado=0,$cod_munic_juzgado=0){
		$valor = '';
		$sql = "Select nombre_juzgado From bi.juzgados where cod_juzgado = ".$cod_juzgado." and cod_depto = ".$cod_depto_juzgado." and cod_municipio = ".$cod_munic_juzgado;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {
			$valor = $resultado->nombre_juzgado;
		}
		return $valor;
	}
	// Retorna el nombre del juzgado según el codigo, departamento y municipio que recibe en el schema
	public function trae_juzgado_sapo($cod_juzgado=0,$cod_depto_juzgado=0,$cod_munic_juzgado=0){
		$valor = '';
		$sql = "Select nombre_juzgado From sapo_gestion.sapogt_juzgado where cod_juzgado_pb = ".$cod_juzgado." and cod_depto = ".$cod_depto_juzgado." and cod_municipio = ".$cod_munic_juzgado;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		foreach ($dbO->queryAll() as $resultado) {
			$valor = $resultado->nombre_juzgado;
		}
		return $valor;
	}
public function muestra_delitos_ficha_grid($a_delitos='')
	{
		$datos =array();
		$a_datos =array();
		$i=0;
		foreach ($a_delitos as $resultado) {
			foreach($resultado as $key => $value){
				if ($key == 'delito') {
					$i++;
					$datos['id'] = $i;
					$datos['delito'] = $value;
					$a_datos[] = $datos;
				}
			}
		}
		return $a_datos;
	}
		public function trae_formula_dactilar_sapo($id_ficha=0)
	{
		$datos =array();
		$a_datos =array();
		$sql = "Select *
					from sapo_gestion.sapogt_formula_dactilar where id_ficha_criminal = ".$id_ficha;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$i=0;
		foreach ($dbO->queryAll() as $resultado) {
			$i++;
			$datos['id'] = $i;
			$datos['tipo'] = $this->busca_criterio_fijo($resultado->tipo,11);
			$datos['valor'] = $resultado->valor;
			$datos['lado_mano'] = $this->busca_criterio_fijo($resultado->lado_mano,10);
			$a_datos[]=$datos;
		}
		return $a_datos;
	}

	public function trae_formula_dactilar_bi($id_ciudadano_bi=0)
	{
		$datos =array();
		$a_datos =array();
		$sql = "Select id_formula, num_formula, formula_mano_derecha, formula_mano_izquierda, tipo_formula
				from bi.formulas_dactilares where id_ciudadano = ".$id_ciudadano_bi;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$i=0;
		foreach ($dbO->queryAll() as $resultado) {
			$i++;
			$datos['id'] = $i;
			$datos['num_formula'] = $resultado->num_formula;
			$datos['formula_mano_derecha'] = $resultado->formula_mano_derecha;
			$datos['formula_mano_izquierda'] = $resultado->formula_mano_izquierda;
			$datos['tipo_formula'] = $resultado->tipo_formula;
			$a_datos[] = $datos;
		}
		return $a_datos;
	}
		public function busca_cat_item($id_cat_item=0)
	{
		$valor = '';
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);
		if($id_cat_item==0){
			$valor='';

		}else{
			$conn->select('descripcion')
				 ->from('sapo_gestion.sapogt_cat_item')
				 ->where('id_cat_item=:id_cat_item and estado=:estado', array(':id_cat_item'=>$id_cat_item, ':estado'=>1));
			$valor = $conn->queryScalar();
		}
		return $valor;
	}


public function busca_cat_item_por_categoria($id_cat_item=0,$id_cat=0)
{
	$valor = '';
	$conn = Yii::app()->db->createCommand();
	$conn->setFetchMode(PDO::FETCH_OBJ);

	$conn->select('descripcion')
			 ->from('sapo_gestion.sapogt_cat_item')
			 ->where('id_cat_item=:id_cat_item and id_cat=:id_cat and estado=:estado', array(':id_cat_item'=>$id_cat_item, ':id_cat'=>$id_cat, ':estado'=>1));
	foreach($conn->queryAll() as $data)
	{
		$valor = $data->descripcion;
	}
	return $valor;
}

	public function valida_sesion(){
			Yii::app()->getSession()->remove('unico');

		//valida la sesion nuevamente antes de mostrar datos

			$sesion= Yii::app()->getSession()->get('sesion');
			if($sesion==NULL){
				$this->redirect(Yii::app()->homeUrl);
			}

		/* hace la verificacion del logueo*/
			if(isset($sesion) && !empty($sesion))
			{
			$username= Yii::app()->user->name;
			$this->valida($sesion, $username);
			}
			return true;
	}
		// Crea un combo box con los criterios fijos filtrados por el id_criterio_fijo que recibe
	public function combo_criterio_fijo($id_criterio_fijo=0)
	{
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('id_opcion,descripcion')
			 ->from('sapo_gestion.sapogt_criterio_fijo')
			 ->where('id_criterio_fijo=:id_criterio_fijo and estado=:estado', array(':id_criterio_fijo'=>$id_criterio_fijo, ':estado'=>1))
			 ->order('id_opcion asc');
		$a_valores = array();
		$i = 1;
		$a_valores[0]['id_opcion'] = 0;
		$a_valores[0]['descripcion'] = 'Seleccione';
		foreach($conn->queryAll() as $data)
		{
			$a_valores[$i]['id_opcion'] = $data->id_opcion;
			$a_valores[$i]['descripcion'] = $data->descripcion;
			$i++;
		}
		return $a_valores;
	}
	public function nombre_destino($id_destino=0){
		if($id_destino==0){
				$id_destino = Yii::app()->getSession()->get('id_destino');
		}
		$sql = "Select descripcion from sapo_gestion.sapogt_cat_item where id_cat=14 and id_cat_item=$id_destino";
		$destino = Yii::app()->db->createCommand($sql)->queryScalar();
	return 	$destino;
	}
	public function destino(){

		$destino = Yii::app()->getSession()->get('id_destino');
		$id_cat = 14;
		$dbC = Yii::app()->db->createCommand();
		$dbC->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$dbC->select('descripcion')
			->from('sapo_gestion.sapogt_cat_item')
			->where('id_cat_item=:id_cat_item and id_cat=:id_cat', array(':id_cat_item'=>$destino,':id_cat'=>$id_cat,));

		$descripcion = 	$dbC->queryScalar();
	   return $descripcion;

}
public function trae_municipios_list($id_depto=0,$id_muni=0,$id_depto_muni=0){
		if ($id_muni > 0) {
			$list_municipios =CHtml::listData(RenapMunicipio::model()->findAll('id_depto = :id_depto AND id_muni = :id_muni',
																array(
																	':id_depto'=>intval($id_depto),
																	':id_muni'=>intval($id_muni)
																	)
																),'id_muni','descripcion'
															);
		}
		elseif($id_depto_muni > 0){
			$list_municipios =CHtml::listData(RenapMunicipio::model()->findAll('id_depto = :id_depto AND id_depto_muni = :id_depto_muni',
																array(
																	':id_depto'=>intval($id_depto),
																	':id_depto_muni'=>intval($id_depto_muni)
																	)
																),'id_muni','descripcion'
															);
		}
		else{
			$list_municipios =CHtml::listData(RenapMunicipio::model()->findAll('id_depto = :id_depto',
																					 array(':id_depto'=>intval($id_depto))),
																							 'id_muni','descripcion');
		}
		return $list_municipios;
	}




// empieza la funcion del menu y creacion del mismo dinamicamente

//funcion que valida al usuario y al modulo que pertenece
	public function autenticacion($id_usuario=0, $id_modulo=0){
		// verificamos si el usuario tiene acceso al modulo, y obtenemos el id_usuario_mod de respuesta
		$sql="Select id_usuario_mod from sapo_autentica.sapoat_usuario_modulo_t where id_usuario = $id_usuario and id_modulo = ".MODULO;
		$id_usuario_modulo = Yii::app()->db->createCommand($sql)->queryAll();
		$valor = array();
		$info = array();

		foreach($id_usuario_modulo as $info){
			$valor[] = $info['id_usuario_mod'];
		}

		$valor = implode(',',$valor);

		$arreglo_menu = array();
		if($valor){
			$arreglo_roles=array();
			$sql="Select id_rol from sapo_autentica.sapoat_usuario_modulo_rol where id_usuario_modulo in ($valor)";
			$arreglo_roles = Yii::app()->db->createCommand($sql)->queryAll();

			$roles = array();
			$dato = array();

			foreach($arreglo_roles as $dato){
				$roles[] = $dato['id_rol'];
			}

			$roles_total = implode(',',$roles);

			if(sizeof($arreglo_roles)>0){
				$arreglo_menu_final = array();
				foreach($arreglo_roles as $result){
					$arreglo_menu=array();
					$sql="Select m.id_menu, m.menu, m.ruta, m.id_padre, m.id_modulo
						from sapo_autentica.sapoat_menu_rol mr
						join sapo_autentica.sapoat_menu m on mr.id_menu= m.id_menu where mr.id_rol in ($roles_total) and m.id_modulo = ".MODULO;
				$arreglo_menu = Yii::app()->db->createCommand($sql)->queryAll();


					foreach($arreglo_menu as $resultado){
						$id_menu = $resultado['id_menu'];
						$id_padre = $resultado['id_padre'];
						if($id_padre==0){
							$id_padre = $id_menu;
						}
						$arreglo_menu_final[$id_padre][$id_menu]['id_menu'] =$id_menu;
						$arreglo_menu_final[$id_padre][$id_menu]['menu'] = $resultado['menu'];
						$arreglo_menu_final[$id_padre][$id_menu]['ruta'] = $resultado['ruta'];
						$arreglo_menu_final[$id_padre][$id_menu]['id_padre'] = $resultado['id_padre'];
					}

				}
				return $arreglo_menu_final;

			}else{
				return $arreglo_menu;
			}
		}else{
			return $arreglo_menu;
		}

	}


	//función que arma el menu interactivo
	function menu($arreglo = array()){
			$result=array();
		foreach($arreglo as $result){
			$ordenado =array();
			?>
		<ul class="nav">
	  		<li class="dropdown">
			<?
			foreach($result as $ordenado){
				$padre = $ordenado['id_padre'];
				$ruta = $ordenado['ruta'];
				if($padre==0 && $ruta == '#'){?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><? echo $ordenado['menu'];?><b class="caret"></b></a>
	    			<ul class="dropdown-menu">
				<?}else{?>
					<li><a href="index.php?r=<?echo $ordenado['ruta']?>"><? echo $ordenado['menu'];?></a></li>
				<?
				}

			} ?>
			 </ul>
			  </li>
			  </ul>

			<?
		}

	} // finaliza funcion de menu

// devuelve el id del usuario que se encuentra logueado
public function trae_id_usuario($usuario=''){
	$sql = "Select id_usuario from sapo_autentica.sapoat_usuario_t where usuario = '".$usuario."'";
	/*se extrae el id del usuario*/
	$dbC = Yii::app()->db->createCommand($sql);
	$id = $dbC->queryScalar();
	return $id;
}// finaliza funcion de trae_id_usuario



//despliega el menu superior
	public function menu_superior()
	{
	?>
		<div class="navbar navbar-fixed-top">
		 <div class="navbar-inner">
			<div class="container container1">
				<a class="brand" href="index.php">SAPO-P</a>
			<?
			if(Yii::app()->user->name!=='Guest'){
	    	$usuario = $this->trae_id_usuario(Yii::app()->user->name);
			$modulo = MODULO;
	    	$arreglo = array();

			$arreglo=$this->autenticacion($usuario,$modulo);
		 	$this->menu($arreglo);

	    	} ?>


				<div class='pull-right' style="margin-top: 5px"><?
				//muestra el formulario
				if(Yii::app()->user->name=='Guest'){

				$model = new LoginForm();
				$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'login-form',
				'type'=>'search',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
				'focus'=>array($model,'username'),
				));

				//muestra el formulario
				$browser = Controller::detect();


					echo CHtml::submitButton('Entrar',array('submit'=>array('Site/Login'),'class'=>'pull-right btn', 'style'=>'margin-top:0px','tabindex'=>'3'));
					echo "&nbsp;&nbsp;";
					echo $form->passwordField($model,'password', array('class'=>'pull-right input-small search-query redondo','placeholder'=>'Contraseña','tabindex'=>'2'));
					echo "&nbsp;&nbsp;";
					echo $form->textField($model,'username', array('class'=>'pull-right input-small search-query redondo','placeholder'=>'Usuario','tabindex'=>'1'));

				?>
				<a href="index.php?r=site/contact" rel="tooltip" title="¿Olvidaste tu contraseña?" data-placement="bottom" class="color"><img src="<?php echo Yii:: app() ->baseUrl.'/images/fp.png' ?>" width="32px" heigth="32px"/></a>
				<?

				echo "<div id='msjerror'>";
				echo Yii::app()->getSession()->get('error');
				Yii::app()->getSession()->remove('error');
				echo $form->error($model,'username');
				echo $form->error($model,'password');
				echo "</div>";


				$this->endWidget();

				}else{
				//muestra el boton derecho para cerrar sesion y cambiar clave
				?>
				<div class='btn-group pull-right' style="margin-top: 0px">
				          <a class='btn dropdown-toggle' data-toggle='dropdown' href='#'>
				            <i ><img src="<?php echo Yii::app()->baseUrl.'/images/user.png' ?>" />&nbsp;<span style="font-weight: bold; color:#5A8692; font-family: Arial; margin-left: 3px;"><? echo Yii::app()->user->name; ?></span></i>
				            <span class='caret'></span>
				          </a>
				          <ul class='dropdown-menu'>
				            <li><a href='index.php?r=mantenimiento/cambio'>Cambiar clave</a></li>
				            <li><a href='index.php?r=site/logout'>Cerrar sesi&oacute;n</a></li>
				          </ul>
				        </div>
				<?
				}  //fin del else que muestra el formualario
				?>
				 </div>
			</div>
		 </div>
	 </div>
	<?
	} // fin de la funcion que muestra el menu


	public function titulo_centrado($atributos=''){
	?>
		<div class="linea_titulo">
		<h1><? echo $atributos; ?></h1>
		</div>

		<?
	}

	public function valida_permiso_rol($id_roles=''){
		$a_rol = $this->trae_rol_usuario(Yii::app()->getSession()->get('id_usuario'));
		$rol = explode(',',$id_roles);
		$valido = false;
		foreach ($rol as $datos){
			foreach ($a_rol as $id_rol){
				if ($id_rol == $datos) {
					$valido = true;
				}
			}
		}// fin for
		if ($valido == false) {
			$this->redirect(Yii::app()->homeUrl);
		}
	}

	public function trae_rol_usuario($id_usuario=0){
		$id_rol = array();
		$sql = "Select umr.id_rol
					From sapo_autentica.sapoat_usuario_modulo_t um
					Inner join sapo_autentica.sapoat_usuario_modulo_rol umr on um.id_usuario_mod = umr.id_usuario_modulo
					Where um.id_usuario = $id_usuario and um.id_modulo = ".MODULO;
		$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($respuesta as $row) {
			$id_rol[] = $row['id_rol'];
		}
		return $id_rol;
	}



/*public function asigna_variable_session_trigger($model=''){
	//Usuario ultima modificacion - trigger
	$user_name = Yii::app()->user->name;
	$sql = "Select set_var('usuario','".$user_name."')";
	$dbC = Yii::app()->db->createCommand($sql);
	$z = $dbC->queryAll();

	// validar si viene un id_ciudadano_renap o si se deber�a de poner un id_ciudadano_anonimo
	if($model->save()){
		return true;
	}
	else{
		return false;
	}

}*/
/// Asigna variable sesion
public function asigna_variable_session_trigger($model=array()){
	//Usuario ultima modificacion - trigger
	$user_name = Yii::app()->user->name;
	$user_ip = Yii::app()->request->userHostAddress;

	$sql = "Select set_var('usuario','".$user_name."')";
	$dbC = Yii::app()->db->createCommand($sql);
	$z = $dbC->queryScalar();

	$sql = "Select set_var('ip','".$user_ip."')";
	$dbC = Yii::app()->db->createCommand($sql);
	$z = $dbC->queryScalar();
}

public function renap_fichita($arreglo=array()){


foreach($arreglo as $row){

		$this->id_ciudadano_renap = $row->id_ciudadano_renap;
		$this->primer_nombre = $row->primer_nombre;

		$this->segundo_nombre = $row->segundo_nombre;
		$this->tercer_nombre = $row->tercer_nombre;
		$this->primer_apellido = $row->primer_apellido;
		$this->segundo_apellido = $row->segundo_apellido;
		$this->apellido_casada = $row->apellido_casada;
		$this->orden_cedula = $row->orden_cedula;

		$this->primer_nombre_sndex = $row->primer_nombre_sndex;
		$this->segundo_nombre_sndex = $row->segundo_nombre_sndex;
		$this->tercer_nombre_sndex = $row->tercer_nombre_sndex;
		$this->primer_apellido_sndex = $row->primer_apellido_sndex;
		$this->segundo_apellido_sndex = $row->segundo_apellido_sndex;
		$this->apellido_casada_sndex = $row->apellido_casada_sndex;

		$this->registro_cedula = $row->registro_cedula;
		$this->cod_depto_cedula = $row->cod_depto_cedula;
		if(isset($row->cod_munic_cedula)){
		$this->cod_muni_cedula = $row->cod_munic_cedula;
		}

		$this->fecha_nacimiento = $row->fecha_nacimiento;
		$this->cod_depto_nacimiento = $row->depto_nacimiento_cod;
		$this->cod_munic_nacimiento = $row->munic_nacimiento_cod;
		$this->cod_nacionalidad = $row->nacionalidad_cod;
		$this->nombre_padre = $row->nombre_padre;
		$this->nombre_madre = $row->nombre_madre;
		$this->fallecido = $row->fallecido;
		$this->fecha_defuncion = $row->fecha_defuncion;
		$this->estado_civil=$this->descripcion_criterio_fijo(3,$row->estado_civil);
		$this->genero = $this->descripcion_criterio_fijo(2,$row->genero);


		$this->dpi = $row->dpi;
		$this->reg_nac ="Libro: ".$row->libro_nac." -- Partida: ". $row->partida_nac;
		$this->formulario_datos_autores();
		}
} // fin de funcion de listado autores

// funcion que muestra el formulario de los datos de los autores para agregar alias
public function formulario_datos_autores($muestra_botones=false){
//	echo $this->telefonema;
$this->tooltip_r++;
	?>
	<script>
		    $(function () {
                $('#tooltip_r<?echo $this->tooltip_r;?>').tooltip();

            });
	</script>
	<div class="well">
	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span2">
				<?  if($this->id_ciudadano_renap <> 0) {
						$src = $this->foto_ciudadano_renap($this->id_ciudadano_renap);
						if(strlen($src) <= 300){
			 				echo '<img src="images/nodisponible.png">';
			 			}else{
			 				$res = $src;
							$xml = new SimpleXMLElement($res);
			 				$newdataset = $xml->children();
			 				$objetos = get_object_vars($newdataset);
			 				$fotica=$objetos['PortraitImage'];
			 				echo '<img src="data:image/png;base64,'.$fotica.'" width="300" height="300" class="img-rounded">';
			 			}
					}
					else{
						echo '<img src="images/nodisponible.png" class="img-rounded">';
					}

					?>
			</div>
			<?
				$variable_tooltip = '';
			if(strlen($this->primer_nombre_sndex)>0){
				$variable_tooltip = 'Primer Nombre : '.$this->primer_nombre_sndex.'<br>';
			}
			if(strlen($this->segundo_nombre_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Segundo Nombre : '.$this->segundo_nombre_sndex.'<br>';
			}

			if(strlen($this->tercer_nombre_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Tercer Nombre : '.$this->tercer_nombre_sndex.'<br>';
			}

			if(strlen($this->primer_apellido_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Primer Apellido : '.$this->primer_apellido_sndex.'<br>';
			}

			if(strlen($this->segundo_apellido_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Segundo Apellido : '.$this->segundo_apellido_sndex.'<br>';
			}

			if(strlen($this->apellido_casada_sndex)>0){
				$variable_tooltip =$variable_tooltip.'Apellido de Casada : '.$this->apellido_casada_sndex;
			}

			?>

			<div class="span6" style="text">
				<blockquote>
		        <p> <a href="#"  id="tooltip_r<?echo $this->tooltip_r;?>" data-toggle="tooltip" data-html="true" title="<? echo $variable_tooltip; ?>" data-placement="right"><? echo $this->formato_nombre_completo($this->primer_nombre,$this->segundo_nombre,$this->tercer_nombre,$this->primer_apellido,$this->segundo_apellido,$this->apellido_casada); ?></a></p>

		        <small><cite title="Lugar de nacimiento"><? echo $this->nombre_depto($this->cod_depto_nacimiento); ?>,<? echo  $this->nombre_municipio($this->cod_depto_nacimiento,$this->cod_munic_nacimiento); ?>, <? echo $this->lugar_nacimiento; ?><i class="icon-map-marker"></i></cite></small>
		     	</blockquote>
		      <p>
		      	     <?

		        	if(isset($this->dpi) && !empty($this->dpi) && isset($this->orden_cedula) && !empty($this->orden_cedula) && isset($this->registro_cedula) && !empty($this->registro_cedula)){
		        		// aqui se muestra el dpi y cedula
		        		// echo "dpi y cedula";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> DPI: ".$this->dpi." Cédula: ".$this->orden_cedula." ".$this->registro_cedula." ".$this->nombre_depto($this->cod_depto_cedula)." ".$this->nombre_municipio($this->cod_depto_cedula,$this->cod_muni_cedula);
		        	}elseif(isset($this->dpi) && !empty($this->dpi)){
		        		// aqui se muestra el dpi
		        		// echo "dpi";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> DPI: ".$this->dpi;
		        	}elseif(isset($this->orden_cedula) && !empty($this->orden_cedula) && isset($this->registro_cedula) && !empty($this->registro_cedula)){
		        		// aqui muestro la cedula
		        		// echo "cedula";
		        		echo "<i class='icon-star'></i> <span class='bold'>Identificación:</span> Cédula: ".$this->orden_cedula." ".$this->registro_cedula." ".$this->nombre_depto($this->cod_depto_cedula)." ".$this->nombre_municipio($this->cod_depto_cedula,$this->cod_muni_cedula);
		        	}else{
		        		// aqui va en blanco
		        		echo " ";
		        	}

		        ?> <br>


		        <? if(isset($this->fecha_nacimiento) && !empty($this->fecha_nacimiento)){ ?>
				<i class="icon-gift"></i> <span class="bold"> Fecha nacimiento:</span> <? echo $this->fecha_diagonal($this->fecha_nacimiento)."<br/>";  }  ?>

				<? if(isset($this->genero) || !empty($this->genero)){ ?>
				<i class="icon-chevron-right"></i> <span class="bold">Genero: </span><? echo $this->genero;} ?><br/>
				<? if(isset($this->estado_civil) || !empty($this->estado_civil)){ ?>
				<i class="icon-heart"></i> <span class="bold">Estado Civil: </span><? echo $this->estado_civil;} ?><br/>

		        <? if(isset($this->nombre_madre) || !empty($this->nombre_madre)){ ?>
				<i class="icon-user"></i> <span class="bold">Nombre madre: </span><? echo $this->nombre_madre;} ?><br/>
				<? if(isset($this->nombre_padre) || !empty($this->nombre_padre)){ ?>
		        <i class="icon-user"></i> <span class="bold">Nombre padre: </span><? echo $this->nombre_padre;}?><br/>
		        <? if(isset($this->reg_nac) || !empty($this->reg_nac)){ ?>
		        <i class="icon-folder-open"></i> <span class="bold">Registro de Nacimiento: </span><? echo $this->reg_nac;}?><br/>



		      </p>
			</div>
		</div>
	</div>

	</div> <!-- fin del well -->
	<?

	} // fin del formulario formulario_datos_autores

	//muestra nombre departamento
	public function nombre_depto($cod_depto_cedula){
		$depto = RenapDepartamento::model()->find('id_depto = :id_depto',array(':id_depto'=>$cod_depto_cedula));
		if(isset($depto) && !empty($depto)){
		return $depto->descripcion;
		}
	}




	public function fecha_diagonal($fecnac){
		$fecnac = substr($fecnac,0,10);
		$arreglo_fecha = explode('-',$fecnac);
		$fecha = $arreglo_fecha[2]."/".$arreglo_fecha[1]."/".$arreglo_fecha[0];
		return $fecha;
	}



	// muestra nombre del municipio
	public function nombre_municipio($cod_depto_cedula,$cod_muni_cedula){
		$muni = RenapMunicipio::model()->find('id_depto=:id_depto and id_muni = :id_muni',array(':id_depto'=>$cod_depto_cedula,':id_muni'=>$cod_muni_cedula));

		if(isset($muni) && !empty($muni)){
		return $muni->descripcion;

		}
	}
	// trae el nombre del estado de la captura
	public function descripcion_criterio_fijo($id_criterio_fijo=0,$id_opcion=0)
	{
		$this->id_opcion = $id_opcion;
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('id_opcion,descripcion')
			 ->from('sapo_gestion.sapogt_criterio_fijo')
			 ->where('id_criterio_fijo=:id_criterio_fijo and estado=:estado and id_opcion=:id_opcion', array(':id_criterio_fijo'=>$id_criterio_fijo, ':estado'=>1,':id_opcion'=>$this->id_opcion))
			 ->order('id_opcion asc');
		$a_valores = array();

		foreach($conn->queryAll() as $data)
		{
			return $data->descripcion;

		}
	//	return $a_valores;
	}

	// trae foto y dpi del ciudadano
	public function foto_ciudadano_renap($id_ciudadano_renap=0){
		$this->id_ciudadano_renap;
		$sql = "SELECT foto FROM sapo_gestion.sapogt_ciudadano_renap_t WHERE id_ciudadano_renap = ".$id_ciudadano_renap;
		$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
		if($respuesta == true){
			foreach($respuesta as $info){
				// se muestra el listado de alias
				return $info['foto'];

      			}
		}
	}

	public function form_genera_pdf($variables_pdf='',$titulo=''){
		//$this->ver_var($variables_pdf);
		//$variables_pdf = json_decode($variables_pdf);
		//$this->ver_var($variables_pdf);
		//$variables_pdf = base64_decode($variables_pdf);
		//$this->ver_var($variables_pdf);
		//$variables_pdf = json_decode($variables_pdf);
		//$this->ver_var($variables_pdf);
	
		//$variables_pdf = json_encode($variables_pdf);
		//$this->ver_var($variables_pdf);
		//exit();
		?>
	 	<div style="float:right; margin-right:25px">
	 	<center>
	 	<form action="index.php?r=reportes/generarpdf" method="post" target="_blank">
	     <input  name="valor" type="hidden" id="valor" readonly="readonly" value="<?php echo $variables_pdf;?>">
	     <input type="image" src="images/printer.png" title="<?php echo $titulo; ?>" style="width: 75px; height: 75px; " onmouseover="this.src='images/printer_gray.png';" onmouseout="this.src='images/printer.png';" />
	    </form>
	    <p><? echo $titulo; ?></p>
	    </center>
	    </div>
	 	<?

	}
	public function form_genera_pdf_rojos($variables_pdf='',$titulo=''){
		//$this->ver_var($variables_pdf);
		//$variables_pdf = json_decode($variables_pdf);
		//$this->ver_var($variables_pdf);
		//$variables_pdf = base64_decode($variables_pdf);
		//$this->ver_var($variables_pdf);
		//$variables_pdf = json_decode($variables_pdf);
		//$this->ver_var($variables_pdf);
	
		//$variables_pdf = json_encode($variables_pdf);
		//$this->ver_var($variables_pdf);
		//exit();
		?>
	 	<div style="float:right; margin-right:25px">
	 	<center>
	 	<form action="index.php?r=reportes/generarpdfrojos" method="post" target="_blank">
	     <input  name="valor" type="hidden" id="valor" readonly="readonly" value="<?php echo $variables_pdf;?>">
	     <input type="image" src="images/printer.png" title="<?php echo $titulo; ?>" style="width: 75px; height: 75px; " onmouseover="this.src='images/printer_gray.png';" onmouseout="this.src='images/printer.png';" />
	    </form>
	    <p><? echo $titulo; ?></p>
	    </center>
	    </div>
	 	<?

	}

	public function genera_pdf($valor= array()){
		//$valor = json_decode($valor, TRUE);
		
		$url = $valor['url'];
		$sello_agua = $valor['sello_agua'];
		$guardar_titulo = $valor['sello_agua'];

		$usuario = Yii::app()->user->name;
		$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','A4','','',12,12,35,15,9,9,'P'); //Esto lo pueden configurar como quieren, para eso deben de entrar en la web de MPDF para ver todo lo que permite.
		$mPDF1->useOnlyCoreFonts = true;
		//$mPDF1->SetTitle("Reporte"); // titulo de la pagina
		$mPDF1->SetAuthor("$usuario"); // nombre del autor del archivo.pdf
		$mPDF1->SetWatermarkText("$sello_agua"); //nombre que sello de agua del documento (opcional)
		$mPDF1->showWatermarkText = true;
		$mPDF1->watermark_font = 'DejaVuSansCondensed';
		$mPDF1->watermarkTextAlpha = 0.1; // el alpha del color del texto
		$mPDF1->SetDisplayMode('fullpage'); // modo de depliegue en toda la pagina
		//$this->ver_var("BEFORE WRITEHTML function: ". $url);
		//$this->ver_var($mPDF1);
		//$mPDF1->WriteHTML($this->renderPartial('delitos_pdf', array('localizador'=>$localizador), true)); //hacemos un render partial a una vista preparada, en este caso es la vista pdfReport
		//$this->ver_var($this->render("$url", array('valor'=>$valor), true));
		//exit();
		$mPDF1->WriteHTML($this->renderPartial("$url", array('valor'=>$valor), true)); //hacemos un render partial a una vista preparada, en este caso es la vista pdfReport
		//$this->renderPartial("$url", array('valor'=>$valor));
		//$mPDF1->WriteHTML($foto); //hacemos un render partial a una vista preparada, en este caso es la vista pdfReport
		//$this->ver_var("After WRITEHTML function");
		//$this->ver_var($mPDF1);
		//exit();
		$mPDF1->Output($guardar_titulo.'-'.date('YmdHis'),'I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.

	}

	public function encabezado_print_pdf($unidad=''){

		//$filePath = "/d_perfil/images/pncw.png";
		?>
		<div class='reporte_encabezado_pdf' >

			<div class="titulo_1_pdf">SISTEMA DE ANTECEDENTES POLICIALES</div>
			<div class="titulo_2_pdf">POLICIA NACIONAL CIVIL</div>
			<div class="titulo_3_pdf">MÓDULO PERFIL CIUDADANO</div>
			<div class="titulo_3_pdf"><? echo $unidad; ?></div>
			<div class='reporte_cierre'><img src="<?php echo Yii:: app() ->baseUrl.'/images/pncw.jpg' ?>" width="50px"><img src="<?php echo Yii:: app() ->baseUrl.'/images/lgob.jpg' ?>" width="100px"> <img src="<?php echo Yii:: app() ->baseUrl.'/images/lpnc.jpg' ?>" width="100px"></div>
		</div>
		
		<?php
	}

	public function muestra_datos_renap_pdf($data_renap=array(),$numero_orden_titulo_renap=0){
		$titulo = $numero_orden_titulo_renap.". DATOS RENAP";

		$datos_busqueda['dpi']= $data_renap['dpi'];
		$datos_busqueda['nombre'] = $data_renap['primer_nombre']." ". $data_renap['segundo_nombre']." ".$data_renap['tercer_nombre']." ".$data_renap['primer_apellido']." ".$data_renap['segundo_apellido']." ".$data_renap['apellido_casada'];
		$datos_busqueda['fecha_nacimiento'] = $this->transforma_fecha($data_renap['fecha_nacimiento']);
		$datos_busqueda['lugar_nacimiento'] = $data_renap['pais_nacimiento']."-".$data_renap['depto_nacimiento']."-".$data_renap['munic_nacimiento'];
		$datos_busqueda['cedula']=$data_renap['orden_cedula']." ".$data_renap['registro_cedula']." ".$data_renap['depto_cedula']." ".$data_renap['munic_cedula'];
		$genero=$data_renap['genero'];
		$datos_busqueda['genero'] =  $this->cf_descrip_renap(2,$genero);
		$estado_civil=$data_renap['estado_civil'];
		$datos_busqueda['estado_civil'] = $this->cf_descrip_renap(3,$estado_civil);
		$datos_busqueda['nacionalidad']=$data_renap['nacionalidad'];
		$datos_busqueda['reg_nac'] ="Libro de Nacimiento: ".$data_renap['libro_nac']." -- Partida de Nacimiento: ". $data_renap['partida_nac'];
		$datos_busqueda['padres']= "Madre: ".$data_renap['nombre_madre']."  Padre: ".$data_renap['nombre_padre'];
		$foto = $data_renap['foto'];

		$columnas= array(
					array('name'=>'dpi', 'label'=>'DPI:'),
					array('name'=>'nombre', 'label'=>'Nombre completo del ciudadano:'),
					array('name'=>'fecha_nacimiento', 'label'=>'Fecha de Nacimiento:'),
					array('name'=>'lugar_nacimiento', 'label'=>'Lugar de Nacimiento:'),
					array('name'=>'cedula', 'label'=>'Cedula de Vecindad'),
					array('name'=>'genero', 'label'=>'G&eacute;nero:'),
					array('name'=>'estado_civil', 'label'=>'Estado Civil:'),
					array('name'=>'nacionalidad', 'label'=>'Nacionalidad:'),
					array('name'=>'reg_nac', 'label'=>'Registro de Nacimiento:'),
					array('name'=>'padres', 'label'=>'Madre y Padre del Ciudadano:'),
				);

		?>
		<table border="0">
		<tr>
			<td colspan="3" style="font-size:18px">
			<b>
			<? echo $titulo;?>
			</b>
			<hr>
			</td>
		</tr>
		<tr>
			<td>
			<?
			if(strlen($foto)>500)
			{
				$res = $foto;
				$xml = new SimpleXMLElement($res);
				$newdataset = $xml->children();
				$objetos = get_object_vars($newdataset);
				$fotica=$objetos['PortraitImage'];
				echo '<img src="data:image/jpeg;base64,'.$fotica.'" width="160" height="190" class="img-rounded">';

			}else{

				$src = Yii::app()->request->baseUrl.'/images/nodisponible.png';
				echo '<img src="'.$src.'" width="160" height="190"  class="img-rounded">';
			}
			?>
			</td>
			<td>
			<?
			$this->tabla_detalle($datos_busqueda,$columnas);
			?>
			</td>
		</tr>
		</table>
		<?
	}

	public function muestra_tabla_resumen_perfil_pdf($data_cap=array(),$data_antecedentes=array(),$numero_orden_titulo_resumen=0){
		$resumen=$this->resumen_cap($data_cap);
		if(count($resumen)==1){
			$orden = 1;
		}else{
			$orden = 2;
		}
		if(!empty($data_antecedentes)){
			$fichas=0;
			$fichas = $this->resumen_fichas($data_antecedentes);
			if($fichas>0){
				$orden = $orden+1;
				$resumen[3]['id']=$orden;
				$resumen[3]['total']=$fichas;
				$resumen[3]['target']='fichas';
				$resumen[3]['path_ima']=Yii::app()->request->baseUrl.'/images/ficha.png';
				$resumen[3]['out']=Yii::app()->request->baseUrl.'/images/ficha_out.png';
				$resumen[3]['descrip']='Total Fichas';
				$resumen[3]['color']='';
				$resumen[4]['id']=$orden+1;
				$resumen[4]['target']='fichas1';
				$resumen[4]['out']=Yii::app()->request->baseUrl.'/images/antecedente_out.png';
				$resumen[4]['total']=$this->resumen_ante($data_antecedentes);
				$path = Yii::app()->request->baseUrl.'/images/antecedente.png';
				$resumen[4]['path_ima']=$path;
				$resumen[4]['descrip']='Total Delitos Cometidos';
				$resumen[4]['color']='';
			}
			else{
				$orden = $orden+1;
				$resumen[3]['id']=$orden;
				$resumen[3]['target']='fichas';
				$resumen[3]['descrip']='Sin Antecedentes';
				$resumen[3]['color']='VERDE';
				$resumen[3]['total']=0;
				$resumen[3]['out']=Yii::app()->request->baseUrl.'/images/prioridad0_out.png';
				$resumen[3]['path_ima']=Yii::app()->request->baseUrl.'/images/prioridad0.png';
			}
		}

		$valor = '$data[\'path_ima\']';
		$atributos=array(
					array('name'=>'id', 'header'=>'#'),
					array('name'=>'descrip', 'header'=>'Descripci&oacute;n'),
					array('header'=>'Indicador',
							'class'=>'bootstrap.widgets.TbImageColumn',
                					'imagePathExpression'=>$valor,
                					'usePlaceKitten'=>FALSE,
                					'link'=>true,
                					// 'url'=>'Yii::app()->controller->createUrl("#", array("id"=>$data[id]))',
                					'htmlOptions'=>array('style'=>'width: 20px')
               						),
					array('name'=>'color', 'header'=>''),
					array('name'=>'total', 'header'=>'Total'),
				    );

		$titulo_resumen = $numero_orden_titulo_resumen.". RESUMEN";
		?>
		<table border="0" style="width: 800px;">
		<tr>
			<td colspan="3" style="font-size:18px">
			<b>
			<? echo $titulo_resumen; ?>
			</b>
			<hr>
			</td>
		</tr>
		<tr>
		<td>
		<?
		$this->grid_detail_r($resumen,$atributos);
		?>
		</td>
		</tr>
		</table>
		<?
	}

	public function linea_informacion_juzgado_bi($cod_juzgado=0,$depto_juzgado=0,$munic_juzgado=0){
		$valor = '';
		$juz = $this->traduce_cod_juzgado_bi($cod_juzgado,$depto_juzgado,$munic_juzgado);
		$valor = $this->linea_informacion_juzgado_sapo($juz);
		return $valor;
	}

	// Retorna el nombre del juzgado, depto y municipio según el codigo, departamento y municipio que recibe en el schema sapo
	public function linea_informacion_juzgado_sapo($id_juzgado=0){
		$valor = '';
		if ($id_juzgado>0) {
			$sql = "Select nombre_juzgado || ' - ' || d.descripcion || ' - ' || m.descripcion as  juzgado
							From sapo_gestion.sapogt_juzgado j
							Inner Join sapo_gestion.sapogt_renap_departamento d on j.cod_depto = d.id_depto
							Inner Join sapo_gestion.sapogt_renap_municipio m on j.cod_depto = m.id_depto and j.cod_municipio = m.id_muni
							where id_juzgado = ".$id_juzgado;
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			foreach ($dbO->queryAll() as $resultado) {
				$valor = $resultado->juzgado;
			}
		}
		return $valor;
	}

	public function muestra_antecedentes_pdf($data_antecedentes=array(),$numero_orden_titulo_antecedentes=0){
		?>
		<table border="0" style="width: 800px;">
		<tr>
			<td colspan="3" style="font-size:18px">
			<b>
			<? echo $numero_orden_titulo_antecedentes.". ANTECEDENTES"; ?>
			</b>
			<hr>
			</td>
		</tr>
		</table>
		<?
		if (!empty($data_antecedentes)) {
			if ($data_antecedentes['error'] <> 0) {
				echo '<div class="modal-header">';
				$this->tabla_titulo('Antecedentes');
				echo '<span class="label label-important">'.$data_antecedentes['descripcion'].'</span>';
				echo '</div>';
			}
			elseif ($data_antecedentes['error']==0 && $data_antecedentes['solvente']>0){
				unset($data_antecedentes['error']);
				$tiene_antecedentes = $data_antecedentes['solvente'];
				unset($data_antecedentes['solvente']);

				if ($tiene_antecedentes) {
					$a_datos = array();
					$arreglo_fichas = array();
					$arreglo_fichas_delitos = array();
					$a_delitos = array();
					$arreglo_delitos = array();
					$agrupa_delitos = array();
					$i = 1;

					if (sizeof($data_antecedentes)==0) {
						echo '<div class="modal-header">';
						echo '<span class="label label-important">NO TIENE ANTECEDENTES</span>';
						echo '</div>';
						echo '<br>';
					}

					foreach($data_antecedentes as $datos){
						$a = $datos['fichas'];
						$id_ciudadano_renap = $datos['id_ciudadano_renap'];
						foreach($a as $num_ficha => $datos_ficha){
							if ($datos_ficha['tipo'] == 1) {
								// Busqueda en BI
								$sql = "SELECT 	f.id_ficha_bi as id_ficha, c.expediente as num_expediente,
												f.fecha_emision, j.nombre_juzgado,
												r1.descripcion as depto, r2.descripcion as munic, c.id_ciudadano as id_ciudadano_bi,
												c.orden_cedula,c.registro_cedula, c.cod_depto as cod_depto_cedula, c.cod_municipio as cod_muni_cedula,
												0 as reincidente, c.num_pasaporte, c.cod_nacionalidad as pais_emision_pasaporte,
												c.nombres_madre as madre_primer_nombre,
												c.nombre2_madre as madre_segundo_nombre,
												'' as madre_tercer_nombre,
												c.apellidos_madre as madre_primer_apellido,
												c.apellido2_madre as madre_segundo_apellido,
												c.ape_casa_madre as madre_apellido_casada,
												c.nombres_padre as padre_primer_nombre,
												c.nombre2_padre as padre_segundo_nombre,
												'' as padre_tercer_nombre,
												c.apellidos_padre as padre_primer_apellido,
												c.apellido2_padre as padre_segundo_apellido,
												f.fecha_ingreso as fh_ingreso,
												f.usuario as usuario_ingreso,
												f.fecha_ult_modificacion as fh_ultima_mod,
												f.usuario_ult_modificacion as usuario_ultima_mod
										FROM bi.fichas f
										LEFT JOIN bi.ciudadanos1 c ON f.id_ciudadano = c.id_ciudadano
										LEFT JOIN bi.juzgados j ON f.cod_juzgado = j.cod_juzgado AND f.cod_depto_juzgado = j.cod_depto AND f.cod_municipio_juzgado = j.cod_municipio
										LEFT JOIN bi.geo_traductor g1 ON g1.cod_depto_oracle = f.cod_depto and g1.cod_muni_oracle = f.cod_municipio
										LEFT JOIN sapo_gestion.sapogt_renap_departamento r1 ON r1.id_depto = g1.cod_depto_renap
										LEFT JOIN sapo_gestion.sapogt_renap_municipio r2 ON r2.id_muni = g1.cod_muni_renap and r2.id_depto = g1.cod_depto_renap
										WHERE f.id_ficha_bi = ".$datos_ficha['id_ficha'];
								$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
							}else{
								// Busqueda en SAPO
								$sql = "SELECT 	f.id_ficha_criminal as id_ficha, f.num_expediente,
												f.fecha_emision, j.nombre_juzgado,
												r1.descripcion as depto, r2.descripcion as munic, f.id_ciudadano_oracle as id_ciudadano_bi,
												f.orden_cedula, f.registro_cedula, f.cod_depto_cedula, f.cod_muni_cedula,
												f.id_reincidente as reincidente,
												f.fecha_nacimiento, f.num_pasaporte, f.pais_emision_pasaporte,
												f.madre_primer_nombre,
											    f.madre_segundo_nombre,
											    f.madre_tercer_nombre,
											    f.madre_primer_apellido,
											    f.madre_segundo_apellido,
											    f.madre_apellido_casada,
											    f.padre_primer_nombre,
											    f.padre_segundo_nombre,
											    f.padre_tercer_nombre,
											    f.padre_primer_apellido,
											    f.padre_segundo_apellido,
											    f.fh_ingreso,
											    f.usuario_ingreso,
											    f.fh_ultima_mod,
											    f.usuario_ultima_mod
										FROM sapo_gestion.sapogt_ficha_criminal f
										LEFT JOIN sapo_gestion.sapogt_juzgado j ON f.cod_juzgado = j.id_juzgado
										LEFT JOIN sapo_gestion.sapogt_renap_departamento r1 ON r1.id_depto = f.cod_depto_emision_ficha
										LEFT JOIN sapo_gestion.sapogt_renap_municipio r2 ON r2.id_muni = f.cod_muni_emision_ficha AND r2.id_depto = f.cod_depto_emision_ficha
										WHERE id_ficha_criminal = ".$datos_ficha['id_ficha'];
								$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
							}// fin del else

							foreach ($respuesta as $info_ficha){
								$arreglo_fichas['fila'] = $i++;
								$id_ficha = $info_ficha['id_ficha'];
								$num_expediente = $info_ficha['num_expediente'];
								$tipo_schema = $datos_ficha['tipo']; // 1: BI 2: Sapo
								$arreglo_fichas['id_ficha'] = $info_ficha['id_ficha'];
								$arreglo_fichas['id_ciudadano_renap'] = $id_ciudadano_renap;
								if ($info_ficha['reincidente']>0) {
									$reincidente = $this->trae_num_reincidente_sapo($info_ficha['reincidente'],0);
									$arreglo_fichas['reincidente'] = $reincidente;
								}
								else{
									$arreglo_fichas['reincidente'] = 0;
								}
								$arreglo_fichas['num_expediente'] = $info_ficha['num_expediente'];
								$arreglo_fichas['tipo'] = $datos_ficha['tipo'];
								if ($datos_ficha['tipo'] == 1) {
									$nombres_bi = $this->trae_nombres_ciudadano_bi_c($info_ficha['id_ciudadano_bi']);
									foreach ($nombres_bi as $bi_nombres){
										$nombres_bi_texto="*".$bi_nombres['nombre']."<br>";
									}
									$arreglo_fichas['nombre_completo'] = $nombres_bi_texto;
									// CEDULA
									if (!empty($info_ficha['orden_cedula']) && !empty($info_ficha['registro_cedula'])) {
										$arreglo_fichas['cedula'] = $info_ficha['orden_cedula']." ".$info_ficha['registro_cedula']." ".$this->traduce_departamento_bi($info_ficha['cod_depto_cedula']).", ".$this->traduce_municipio_bi($info_ficha['cod_muni_cedula'],$info_ficha['cod_depto_cedula']);
									}else{
										$arreglo_fichas['cedula'] = '';
									}

									$datos_nombre_ciudadano_bi = $this->trae_nombres_ciudadano_bi($info_ficha['id_ciudadano_bi']);
									foreach ($datos_nombre_ciudadano_bi as $datos_bi){
										$arreglo_fichas['dpi'] = $datos_bi['dpi'];
										$fec_nac = $datos_bi['fecha_nacimiento'];
									}

									if (strlen($info_ficha['num_pasaporte'])>0 && $info_ficha['pais_emision_pasaporte'] > 0) {
										$pais_pasaporte = $this->busca_cat_item_por_categoria($info_ficha['pais_emision_pasaporte'],6); // cat item 6 nacionalidad porque ese trae la ficha en bi
										$arreglo_fichas['pasaporte'] = $info_ficha['num_pasaporte']." - ".$pais_pasaporte;
									}else{
										$arreglo_fichas['pasaporte'] = null;
									}


									$arreglo_fichas['fecha_nacimiento'] = $fec_nac;

								}else{
									$arreglo_fichas['nombre_completo'] = $this->trae_nombres_ciudadano_ficha($info_ficha['id_ficha'])."<br>";
									// CEDULA
									if (!empty($info_ficha['orden_cedula']) && !empty($info_ficha['registro_cedula'])) {
										$arreglo_fichas['cedula'] = $info_ficha['orden_cedula']." ".$info_ficha['registro_cedula']." ".$this->trae_departamento_renap($info_ficha['cod_depto_cedula']).", ".$this->trae_municipio_renap_por_depto_muni($info_ficha['cod_depto_cedula'],$info_ficha['cod_muni_cedula']);
									}else{
										$arreglo_fichas['cedula'] = '';
									}

									$renap_a = $this->trae_datos_ciudadano_renap($id_ciudadano_renap,0);
									foreach ($renap_a as $a_renap){
										$arreglo_fichas['dpi'] = $a_renap->dpi;
									}
									$pais_pasaporte = $this->busca_cat_item_por_categoria($info_ficha['pais_emision_pasaporte'],8);
									$arreglo_fichas['pasaporte'] = $info_ficha['num_pasaporte']." - ".$pais_pasaporte;

									if(strlen($info_ficha['fecha_nacimiento'])>0){
										$fec_nac = $info_ficha['fecha_nacimiento'];
										$date = new DateTime($fec_nac);
										$arreglo_fichas['fecha_nacimiento'] = $date->format('d/m/Y');
									}
								}

								$date = new DateTime($info_ficha['fecha_emision']);
								$arreglo_fichas['fecha'] =$date->format('d/m/Y');
								if(strlen($info_ficha['fecha_emision'])>0){
									$arreglo_fichas['fecha_sort'] = $arreglo_fichas['fecha'];
								}else{
									$arreglo_fichas['fecha_sort'] = '01/01/0001';
								}

								$arreglo_fichas['juzgado'] = $info_ficha['nombre_juzgado'].",".$info_ficha['depto'].",".$info_ficha['munic'];
								$arreglo_fichas['departamento'] = $info_ficha['depto'];
								$arreglo_fichas['municipio'] = $info_ficha['munic'];

								$nombre_madre = $this->formato_nombre_completo($info_ficha['madre_primer_nombre'],$info_ficha['madre_segundo_nombre'],$info_ficha['madre_tercer_nombre'],$info_ficha['madre_primer_apellido'],$info_ficha['madre_segundo_apellido'],$info_ficha['madre_apellido_casada']);
								$arreglo_fichas['nombre_madre'] = $nombre_madre;

								$nombre_padre = $this->formato_nombre_completo($info_ficha['padre_primer_nombre'],$info_ficha['padre_segundo_nombre'],$info_ficha['padre_tercer_nombre'],$info_ficha['padre_primer_apellido'],$info_ficha['padre_segundo_apellido'],'');
								$arreglo_fichas['nombre_padre'] = $nombre_padre;

								$arreglo_fichas['criterios'] = $this->muestraCriteriosFichas($info_ficha['id_ficha'],$datos_ficha['tipo'],$id_ciudadano_renap);

								$delitos = $datos_ficha['delitos'];
								$arreglo_fichas['delitos']= $delitos;
							}// fin for
							$a_datos[] = $arreglo_fichas;
						}// fin for
					}// fin for

					$arreglo_ordenado = $this->orderMultiDimensionalArray($a_datos,'fecha_sort',false);
					$arreglo_final = array();
					$i = sizeof($a);
					$i = 1;
					foreach($arreglo_ordenado as $datos){
						$datos['fila']=$i; // Se agrega al arreglo el numero de fila
						$i++;
						$arreglo_final[] =$datos;
					}
					$count = sizeof($arreglo_final);

					foreach ($arreglo_final as $data){?>
						<table border="1" style="width: 800px;">
						<tr>
							<td>
							<?
							echo '<font color="red" style="font-size:12px"><strong>No.Expediente: '.$data['num_expediente'].'</strong></font>';
							echo "<br>";
							if($data['id_ciudadano_renap'] <> 0) {
								$src = $this->foto_ciudadano_renap($data['id_ciudadano_renap']);
								if(strlen($src) <= 100){
									echo '<img src="images/nodisponible.png" width="160" height="200" class="img-rounded">';
									echo "<br>";
									echo "<center>Ciudadano RENAP</center>";
								}else{
									$res = $src;
									$xml = new SimpleXMLElement($res);
									$newdataset = $xml->children();
									$objetos = get_object_vars($newdataset);
									$objetos = get_object_vars($newdataset);
									$fotica=$objetos['PortraitImage'];
									echo '<img src="data:image/jpeg;base64,'.$fotica.'" width="160" height="200" class="img-rounded">';
									echo "<br>";
									echo "<center>Ciudadano RENAP</center>";
								}
							}else{
								echo '<img src="images/nodisponible.png" width="160" height="200" class="img-rounded">';
								echo "<br>";
								echo "<center>Ciudadano</center>";
							}
							?>
							</td>
							<td>
							<table style="width: 800px;">
								<tr>
								<td>
								<?
								echo "<strong>DATOS CIUDADANO</strong>";
								//$this->ver_var($data);
								echo "<br>";
								echo "<br>";
								echo "<strong>ID Ficha: </strong>".$data['id_ficha'];
								echo "<br>";
								echo "<strong>No.Expediente: </strong>".$data['num_expediente'];
								echo "<br>";
								echo "<strong>No.Reincidente: </strong>".$data['reincidente'];
								echo "<br>";
								echo "<strong>Nombre Completo: </strong>".$data['nombre_completo'];
								echo "<strong>Lugar de Nacimiento: </strong>".$this->nombre_depto($data['cod_depto_nacimiento']); ?>,<? echo  $this->nombre_municipio($data['cod_depto_nacimiento'],$data['cod_munic_nacimiento']); ?>, <? echo $data['lugar_nacimiento'];
								echo "<br>";
								// IDENTIFICACION
								if(isset($data['dpi']) && !empty($data['dpi']) && isset($data['cedula']) && !empty($data['cedula'])){
									// aqui se muestra el dpi y cedula
									if (isset($data['pasaporte']) && !empty($data['pasaporte'])){
										echo "<strong>Identificaci&oacute;n: DPI: </strong>".$data['dpi']." <strong> C&eacute;dula: </strong>".$data['cedula']."<strong> Pasaporte: </strong>".$data['pasaporte'];}
									else{
										echo "<strong>Identificaci&oacute;n: DPI: </strong>".$data['dpi']." <strong> C&eacute;dula: </strong>".$data['cedula'];
									}
									echo "<br>";
								}elseif(isset($data['dpi']) && !empty($data['dpi'])){
									// aqui se muestra el dpi
									echo "<strong>Identificaci&oacute;n: DPI: </strong>".$data['dpi'];
									echo "<br>";
								}elseif(isset($data['cedula']) && !empty($data['cedula'])){
									// aqui muestro la cedula
									echo "<strong>Identificaci&oacute;n: C&eacute;dula: </strong>".$data['cedula'];
									echo "<br>";
								}else{
									if (isset($data['pasaporte']) && !empty($data['pasaporte'])){
										echo "<strong>Identificaci&oacute;n: Pasaporte: </strong>".$data['pasaporte'];
									}else{
										echo " ";
									}
								}

								// FECHA DE NACIMIENTO
								if(isset($data['fecha_nacimiento']) && !empty($data['fecha_nacimiento'])){
									echo "<strong>Fecha de Nacimiento: </strong>".$this->fecha_diagonal($data['fecha_nacimiento']);
									echo "<br>";
								}

								// NOMBRES DE PADRES
								if(isset($data['nombre_madre']) || !empty($data['nombre_madre'])){
									echo "<strong>Nombre Madre: </strong>".$data['nombre_madre'];
									echo "<br>";
								}

								if(isset($data['nombre_padre']) || !empty($data['nombre_padre'])){
									echo "<strong>Nombre Padre: </strong>".$data['nombre_padre'];
									echo "<br>";
								}

								//JUZGADO
								if(isset($data['juzgado']) || !empty($data['juzgado'])){
									echo "<strong>Juzgado: </strong>".$data['juzgado'];
									echo "<br>";
								}

								if(isset($data['fecha']) || !empty($data['fecha'])){
									echo "<strong>Fecha de Emisi&oacute;n: </strong>".$data['fecha'];
									echo "<br>";
								}

								if(isset($data['criterios']) || !empty($data['criterios'])){
									echo "<strong>Criterios: </strong>".$data['criterios'];
									echo "<br>";
								}
								?>
								</td>
								</tr>
								<tr>
								<td>
								<?
								echo "<br>";
								$this->leyenda('INFORMACI&Oacute;N AUDITORIA');
								?>
							        <table border="1" style="width: 800px;">
									<tr>
									<td>
							        <?
							        if (!empty($data['fh_ingreso'])) {
							        	echo "<strong>Fh. Ingreso: </strong>".$this->fecha_diagonal($data['fh_ingreso'])." ".substr($data['fh_ingreso'],10,9 );
							        }
							        else{
							        	echo "<strong>Fh. Ingreso: </strong>";
							        }
							        ?>
								    </td>
								    <td>
								    <?
								    if (!empty($data['fh_ultima_mod'])) {
								    	echo "<strong>Fh. Ult. Modificaci&oacute;n: </strong>".$this->fecha_diagonal($data['fh_ultima_mod'])." ".substr($data['fh_ultima_mod'],10,9 );
								    }
								    else{
								    	echo "<strong>Fh. Ult. Modificaci&oacute;n: </strong>";
								    }
								    ?>
							        </td>
									</tr>
									<tr>
									<td>
							        <?
							        echo "<strong>Usu. Ingreso: </strong>".$data['usuario_ingreso'];
							        ?>
								    </td>
								    <td>
								    <?
								    echo "<strong>Usu. Ult. Modificaci&oacute;n: </strong>".$data['usuario_ultima_mod'];
								    ?>
							        </td>
									</tr>
									</table>
								</td>
								</tr>
							</table>
						</td>
						<td style="width: 150px;">
						<?
						echo "<strong>DELITOS</strong>";
						echo "<br>";
						echo "<br>";
						foreach ($data['delitos'] as $res_delitos){
							echo "* ".$res_delitos['delito'];
							echo "<br>";
						}
						?>
						</td>
						</tr>
						</table>
						<br>
						<?

					}
				}else{
					echo '<div class="modal-header">';
					echo '<span class="label label-important">NO TIENE ANTECEDENTES</span>';
					echo '</div>';
					echo '<br>';
				}
			}else{
				echo '<div class="modal-header">';
				echo '<span class="label label-important">NO TIENE ANTECEDENTES</span>';
				echo '</div>';
				echo '<br>';
			}
		}else{
			echo '<div class="modal-header">';
			echo '<span class="label label-important">NO TIENE ANTECEDENTES</span>';
			echo '</div>';
			echo '<br>';
		}
	}// fin de funcion


	public function muestra_capturas_pdf($data_cap=array(),$numero_orden_titulo_capturas=0){
		?>
		<table border="0" style="width: 800px;">
		<tr>
			<td colspan="3" style="font-size:18px">
			<b>
			<? echo $numero_orden_titulo_capturas.". CAPTURAS"; ?>
			</b>
			<hr>
			</td>
		</tr>
		</table>
		<?
		$a_cap_datos = array();
		$i = 0;
		if(isset($data_cap['error']) && $data_cap['error']==0){
			unset($data_cap['error']);
			unset($data_cap['solvente']);
			$arreglo_indices=array();
			foreach($data_cap as $result_c){
				foreach($result_c as $result_n){
					foreach($result_n as $result_c){
						$ocp = $result_c['id_orden_captura_persona'];

						$criterio='';
						$prioridad_roja=0;
						$prioridad_amarilla=0;
						$prioridad_negra=0;
						if(isset($result_c['criterio_1'])){
							$prioridad_roja = 2;
							$criterio = "* por dpi<br>";
						}
						if(isset($result_c['criterio_2'])){
							$criterio = $criterio."* por cedula<br>";
							$prioridad_roja = $prioridad_roja+1;
							$prioridad_amarilla = $prioridad_amarilla+1;
						}
						if(isset($result_c['criterio_3'])){
							$criterio = $criterio."* por nombres<br>";
							$prioridad_roja = $prioridad_roja+1;
							$prioridad_amarilla = $prioridad_amarilla+1;
						}
						if(isset($result_c['criterio_4'])){
							$criterio = $criterio."* por fecha nacimiento<br>";
							$prioridad_roja = $prioridad_roja+1;
							$prioridad_negra = $prioridad_negra+1;
						}
						if(isset($result_c['criterio_5'])){
							$criterio = $criterio."* por padres<br>";
							$prioridad_roja = $prioridad_roja+1;
							$prioridad_negra = $prioridad_negra+1;
						}
						if(isset($result_c['criterio_6'])){
							$criterio = $criterio."* por pasaporte<br>";
							$prioridad_roja = $prioridad_roja+1;
							$prioridad_negra = $prioridad_negra+1;
						}
						if ($prioridad_roja >=2){
							$prioridad =1;
						}elseif($prioridad_amarilla >=1){
							$prioridad =2;
						}elseif($prioridad_negra >=1){
							$prioridad =3;
						}else{
							$prioridad =0;
						}
						$color = '';
						if($prioridad ==1){
							$color = 'Rojo';
							$foto = 'prioridad1.png';
						}elseif($prioridad ==2){
							$color = 'Amarillo';
							$foto = 'prioridad2.png';
						}elseif($prioridad ==3){
							$color = 'Negro';
							$foto = 'prioridad3.png';
						}

						$result_c['prioridad'] = $prioridad;
						$result_c['foto'] = $foto;
						$result_c['color'] = $color;
						if ($prioridad < 3) {
							$a_cap_datos[$i] = $result_c;
							$i++;
						}
						$ocp = 0;
					}// fin for
				}// fin for
			}// fin for


		$a_capturas = $this->orderMultiDimensionalArray($a_cap_datos,'prioridad',false);
		//$this->ver_var($a_capturas);
		$num_vineta = 0;
		foreach ($a_capturas as $result_c){

			$criterio = '';
			$id_ciudadano = 0;
			$tipo = $result_c['tipo'];
			$foto = $result_c['foto'];
			$color = $result_c['color'];

			if(isset($result_c['criterio_1'])){
				$criterio = "* por dpi ";
			}
			if(isset($result_c['criterio_2'])){
				$criterio = $criterio."* por cedula ";
			}
			if(isset($result_c['criterio_3'])){
				$criterio = $criterio."* por nombres ";
			}
			if(isset($result_c['criterio_4'])){
				$criterio = $criterio."* por fecha nacimiento ";
			}
			if(isset($result_c['criterio_5'])){
				$criterio = $criterio."* por padres ";
			}
			if(isset($result_c['criterio_6'])){
				$criterio = $criterio."* por pasaporte ";
			}

			if ($tipo == 1) {
				$id_orden_captura = $result_c['id_captura'];
				$bi_data = $this->trae_datos_orden_captura_bi($id_orden_captura,0,0);
				foreach ($bi_data as $data_bi){
					$id_ciudadano = $data_bi->id_ciudadano;
				}
			}else{
				$id_orden_captura = $result_c['id_orden_captura'];
			}


				if( $id_orden_captura>0 && $tipo>0 ){
					$num_vineta++;
					$vineta = '';
					for ($i = 1; $i <= $num_vineta; $i++) {
						$vineta = $i;
					}

					if ($tipo==1) {
						$telefonema = $this->trae_num_telefonema_bi($id_orden_captura);
						$this->leyenda_pdf($vineta.'). ORDEN DE CAPTURA');
						if ($telefonema > 0) {
							?>
							<table border="0" style="width: 800px;">
							<tr>
							<td>
							<?
							echo "<center>";
							echo "<span style='color: #2A5E93; font-size: 15px; font-weight: bold'>No.Telefonema: <span style='color: #C12222; font-size: 15px; font-weight: bold'> $telefonema ";
							echo "</center>";
							?>
							</td>
							</tr>
							</table>
							<?
						}

						$datos_bi = $this->trae_datos_orden_captura_bi($id_orden_captura,0,$id_ciudadano);
						foreach ($datos_bi as $datos){

							$juzgado = $this->linea_informacion_juzgado_bi($datos->cod_juzgado,$datos->cod_depto_juzgado,$datos->cod_mun_juzgado);
							if ($datos->num_autores > 0) {
								$num_autores = $datos->num_autores;
							}else{
								$num_autores = '';
							}
							$fh_recepcion_captura = '';
							if (!empty($datos->fecha_hora_inicial)) {
								$date = new DateTime($datos->fecha_hora_inicial);
								$fh_emision_captura = $date->format('d/m/Y');
							}else{
								$fh_emision_captura = "";
							}

							if(isset($datos->observa_captura) && !empty($datos->observa_captura) && strlen($datos->observa_captura)>0){
								$observacion = $datos->observa_captura;
							}else{
								$observacion = '';
							}

						}

						$columnas= array(
										array('name'=>'num_telefonema', 'label'=>'N&uacute;mero Telefonema'),
										array('name'=>'numero_causa', 'label'=>'N&uacute;mero de causa'),
										array('name'=>'num_implicado', 'label'=>'N&uacute;mero de implicados'),
										array('name'=>'fecha_emision_captura', 'label'=>'Fecha emisi&oacute;n captura'),
										array('name'=>'fecha_recepcion_captura', 'label'=>'Fecha de recepci&oacute;n'),
										array('name'=>'juzgado', 'label'=>'Juzgado'),
										array('name'=>'observacion', 'label'=>'Observaci&oacute;n'),
										array('name'=>'criterios', 'label'=>'Criterios'),
										);

						$datos_busqueda = array(
												'num_telefonema'=>$telefonema,
												'numero_causa'=>$datos->numero_causa,
												'num_implicado'=>$num_autores,
												'fecha_emision_captura'=>$fh_emision_captura,
												'fecha_recepcion_captura'=>$fh_recepcion_captura,
												'juzgado'=>$juzgado,
												'observacion'=>$observacion,
												'criterios'=>$criterio,
						   					);
						$this->tabla_detalle($datos_busqueda,$columnas);
						echo "<br>";
					}else{
						$telefonema = $this->trae_num_telefonema($id_orden_captura);
						$this->leyenda_pdf($vineta.'). ORDEN DE CAPTURA');
						if ($telefonema > 0) {
							?>
							<table border="0" style="width: 800px;">
							<tr>
							<td>
							<?
							echo "<center>";
							echo "<span style='color: #2A5E93; font-size: 15px; font-weight: bold'>No.Telefonema: <span style='color: #C12222; font-size: 15px; font-weight: bold'> $telefonema ";
							echo "</center>";
							?>
							</td>
							</tr>
							</table>
							<?
						}
						$num_telefonema = $this->trae_num_telefonema($id_orden_captura);
						$tipo_gestion = 0;
						$agrega_autores=false;
						$modifica=false;
						$actualiza_autores=false;
						$id_ciudadano_sigap = 0;

						$datos_orca = Ordencapturaorca::model()->findByAttributes(array('id_orden_captura'=>$id_orden_captura));
						$columnas= array(
										array('name'=>'num_telefonema', 'label'=>'N&uacute;mero Telefonema'),
										array('name'=>'numero_causa', 'label'=>'N&uacute;mero de causa'),
										array('name'=>'num_implicado', 'label'=>'N&uacute;mero de implicados'),
										array('name'=>'fecha_emision_captura', 'label'=>'Fecha emisi&oacute;n captura'),
										array('name'=>'fecha_recepcion_captura', 'label'=>'Fecha de recepci&oacute;n'),
										array('name'=>'juzgado', 'label'=>'Juzgado'),
										array('name'=>'observacion', 'label'=>'Observaci&oacute;n'),
										array('name'=>'criterios', 'label'=>'Criterios'),
										);

						$fh_em_cap = $datos_orca->fh_emision_captura;
						$date_emision_captura = new DateTime($fh_em_cap);
						$fh_emision_captura = $date_emision_captura->format('d/m/Y');

						$fh_rec_cap = $datos_orca->fh_recepcion;
						$date_rec_captura = new DateTime($fh_rec_cap);
						$fh_recepcion_captura = $date_rec_captura->format('d/m/Y');

						$juzgado = $this->linea_informacion_juzgado_sapo($datos_orca->id_juzgado);

						$datos_busqueda = array(
												'num_telefonema'=>$num_telefonema,
												'numero_causa'=>$datos_orca->numero_causa,
												'num_implicado'=>$datos_orca->num_implicado,
												'fecha_emision_captura'=>$fh_emision_captura,
												'fecha_recepcion_captura'=>$fh_recepcion_captura,
												'juzgado'=>$juzgado,
												'observacion'=>$datos_orca->observacion,
												'criterios'=>$criterio,
						   					);
						$this->tabla_detalle($datos_busqueda,$columnas);
						echo "<br>";
						echo "<strong><font style='font-size: 12px;'>INFORMACI&Oacute;N AUDITORIA ORDEN CAPTURA</font></strong>";

						?>
				        <table border="1" style="width: 800px;">
						<tr>
						<td>
				        <?
				        if (!empty($datos_orca->fh_ingreso)) {
				        	echo "<strong>Fh. Ingreso: </strong>".$this->fecha_diagonal($datos_orca->fh_ingreso)." ".substr($datos_orca->fh_ingreso,10,9 );
				        }
				        else{
				        	echo "<strong>Fh. Ingreso: </strong>";
				        }
				        ?>
					    </td>
					    <td>
					    <?
					    if (!empty($datos_orca->fh_ultima_mod)) {
					    	echo "<strong>Fh. Ult. Modificaci&oacute;n: </strong>".$this->fecha_diagonal($datos_orca->fh_ultima_mod)." ".substr($datos_orca->fh_ultima_mod,10,9 );
					    }
					    else{
					    	echo "<strong>Fh. Ult. Modificaci&oacute;n: <strong>";
					    }
					    ?>
				        </td>
						</tr>
						<tr>
						<td>
				        <?
				        echo "<strong>Usu. Ingreso: </strong>".$datos_orca->usuario_ingreso;
				        ?>
					    </td>
					    <td>
					    <?
					    echo "<strong>Usu. Ult. Modificaci&oacute;n: </strong>".$datos_orca->usuario_ultima_mod;
					    ?>
				        </td>
						</tr>
						</table>
						<br>
						<?
					}

					// AUTORES
					if ($tipo==1) {
						$this->leyenda_pdf('LISTADO DE AUTORES');
						$sql = "select distinct  oc.id_captura as id_orden_captura, '1' as tipo, oc.id_hecho as num_telefonema, n.nombres as primer_nombre, n.nombre2 as segundo_nombre, '' as tercer_nombre,
									 n.apellidos as primer_apellido, n.apellido2  as segundo_apellido, n.apellido_casada as apellido_casada,
									 c.senias_particulares, c.amputaciones, c.peso, c.estatura, c.sexo as genero, c.estado_civil,
									 n.fecha_nacimiento as fecha_nacimiento, n.cod_nacionalidad,
									 n.orden_cedula,n.registro_cedula,n.cod_depto_cedula,n.cod_municipio_cedula as cod_muni_cedula,
									 n.lugar_nacimiento,
									 oc.estado_captura as estado_captura_persona,
									 oc.usuario as usuario_ingreso,
									 oc.fecha_hora_inicial as fh_ingreso, oc.fecha_ult_modificacion as fh_ultima_mod,
									 oc.usuario_ult_modificacion as usuario_ultima_mod, oc.fecha_ult_modificacion as fh_ultima_mod,
									 n.nombres_madre as madre_primer_nombre, n.nombre2_madre as madre_segundo_nombre, '' as madre_tercer_nombre,
									 n.apellidos_madre as madre_primer_apellido, n.apellido2_madre as madre_segundo_apellido, n.ape_casa_madre as madre_apellido_casada,
									 n.nombres_padre as padre_primer_nombre, n.nombre2_padre as padre_segundo_nombre, '' as padre_tercer_nombre, n.apellidos_padre as padre_primer_apellido, n.apellido2_padre as padre_segundo_apellido,
									 oc.fecha_hora_inicial as fecha_emision, oc.cod_depto_juzgado as depto_juzgado, oc.cod_mun_juzgado as muni_juzgado, oc.cod_juzgado as cod_juzgado,
									 oc.id_ciudadano as ciudadano, n.dpi, n.orden_cedula as cedula_orden, n.registro_cedula as cedula_registro
								from orca_bi.nombres_ciudadano n
								join orca_bi.ciudadanos1 c on (n.id_ciudadano=c.id_ciudadano)
								join orca_bi.orden_captura oc on (n.id_ciudadano=oc.id_ciudadano)
								where oc.id_captura = ".$id_orden_captura." and n.id_ciudadano = ".$id_ciudadano;
						$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
						foreach ($respuesta as $row) {
							?>
							<table border="1">
							<?
							//  Recogemos variables a mostrar
							$id_orden_captura_persona = 0;
							$id_orden_captura = $row['id_orden_captura'];
							$telefonema = $this->trae_num_telefonema_bi($id_orden_captura);

							$id_ciudadano_sigap = $id_ciudadano;

							$id_ciudadano_renap = 0;
							$id_ciudadano_anonimo = 0;
							$primer_nombre = $row['primer_nombre'];
							$segundo_nombre = $row['segundo_nombre'];
							$tercer_nombre = $row['tercer_nombre'];
							$primer_apellido = $row['primer_apellido'];
							$segundo_apellido = $row['segundo_apellido'];
							$apellido_casada = $row['apellido_casada'];
							$senias_particulares = $row['senias_particulares'];
							$amputaciones = $row['amputaciones'];
							$peso = $row['peso'];
							$estatura = $row['estatura'];
							$orden_cedula = $row['orden_cedula'];
							$registro_cedula = $row['registro_cedula'];
							$cod_depto_cedula = $this->traduce_cod_depto_bi($row['cod_depto_cedula']);
							$cod_muni_cedula = $this->traduce_cod_muni_bi($row['cod_depto_cedula'],$row['cod_muni_cedula']);
							$direc_calle = '';
							$direc_num_inmueble = '';
							$direc_ave = '';
							$direc_barrio = '';
							$direc_zona = 0;
							$direc_cod_depto = 0;
							$direc_cod_munic = 0;
							$fecha_nacimiento = $row['fecha_nacimiento'];
							$cod_depto_nacimiento = 0;
							$cod_munic_nacimiento = 0;
							$lugar_nacimiento = $row['lugar_nacimiento'];
							$cod_nacionalidad = $this->traduce_cat_item_bi($row['cod_nacionalidad'],6);
							$nombre_padre = $this->formato_nombre_completo($row['padre_primer_nombre'],$row['padre_segundo_nombre'],$row['padre_tercer_nombre'],$row['padre_primer_apellido'],$row['padre_segundo_apellido'],'');
							$nombre_madre = $this->formato_nombre_completo($row['madre_primer_nombre'],$row['madre_segundo_nombre'],$row['madre_tercer_nombre'],$row['madre_primer_apellido'],$row['madre_segundo_apellido'],$row['madre_apellido_casada']);
							$apodos = '';
							$fallecido = 0;
							$fecha_defuncion = '';
							$pais_emision_pasaporte = 0;
							$num_pasaporte = 0;
							$profesion = '';
							$estado_civil=$this->traduce_criterio_fijo_bi($row['estado_civil'],3);
							$genero = $this->traduce_criterio_fijo_bi($row['genero'],2);
							$estado_captura_persona = $row['estado_captura_persona'];
							$fh_ingreso = $row['fh_ingreso'];
							$fh_ultima_mod = $row['fh_ultima_mod'];
							$usuario_ingreso = $row['usuario_ingreso'];
							$usuario_ultima_mod = $row['usuario_ultima_mod'];

							$madre_primer_nombre= $row['madre_primer_nombre'];
							$madre_segundo_nombre= $row['madre_segundo_nombre'];
							$madre_tercer_nombre= $row['madre_tercer_nombre'];
							$madre_primer_apellido= $row['madre_primer_apellido'];
							$madre_segundo_apellido= $row['madre_segundo_apellido'];
							$madre_apellido_casada= $row['madre_apellido_casada'];
							$padre_primer_nombre= $row['padre_primer_nombre'];
							$padre_segundo_nombre= $row['padre_segundo_nombre'];
							$padre_tercer_nombre= $row['padre_tercer_nombre'];
							$padre_primer_apellido= $row['padre_primer_apellido'];
							$padre_segundo_apellido= $row['padre_segundo_apellido'];
							$dpi = $row['dpi'];
							?>
							<tr>
							<td>
							<?
							echo '<font color="red" style="font-size:12px"><strong>ID: '.$id_orden_captura.'</strong></font>';
							echo "<br>";
							if($id_ciudadano_renap <> 0) {
								$src = $foto_ciudadano_renap($id_ciudadano_renap);
								if(strlen($src) <= 300){
									echo '<img src="images/nodisponible.png" width="160" height="200" class="img-rounded">';
									echo "<br>";
									echo "<center><font style='font-size:12px'>Ciudadano RENAP</font></center>";
								}else{
									$res = $src;
									$xml = new SimpleXMLElement($res);
									$newdataset = $xml->children();
									$objetos = get_object_vars($newdataset);
									$objetos = get_object_vars($newdataset);
									$fotica=$objetos['PortraitImage'];
									echo '<img src="data:image/jpeg;base64,'.$fotica.'" width="160" height="200" class="img-rounded">';
									echo "<br>";
									echo "<center><font style='font-size:12px'>Ciudadano RENAP</font></center>";
								}
							}
							else{
								echo '<img src="images/nodisponible.png" width="160" height="200" class="img-rounded">';
								echo "<br>";
								echo "<center><font style='font-size:12px'>Ciudadano</font></center>";
							}
							echo "<br>";
							if (isset($foto)) {
								echo '<img src="images/'.$foto.'" width="60" height="60" class="img-rounded">';
								echo "<br>";
							}
							echo "<br>";
							if (isset($color)) {
								echo "<center><font style='font-size:12px'>".$color."</font></center>";
								echo "<br>";
							}
							?>
							</td>
							<td>
								<table style="width: 800px;">
								<tr>
								<td>
									<?
									$this->leyenda_pdf("DATOS CIUDADANO");
									echo "<br>";
									echo "<strong>Nombre Completo: </strong>".$this->formato_nombre_completo($primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada);
									echo "<br>";
							        echo "<strong>Lugar de Nacimiento: </strong>".$this->nombre_depto($cod_depto_nacimiento); ?>,<? echo  $this->nombre_municipio($cod_depto_nacimiento,$cod_munic_nacimiento); ?>, <? echo $lugar_nacimiento;
							     	echo "<br>";
							        if($estado_captura_persona == 2){
							        	echo "<strong>Estado captura: </strong>".$this->traduce_criterio_fijo_bi($estado_captura_persona,20);
							        	echo "<br/>";
							        }elseif($estado_captura_persona == 4){
							        	echo "<strong>Estado captura: </strong>".$this->traduce_criterio_fijo_bi($estado_captura_persona,20);
							        	echo "<br/>";
							        }else{
							        	echo "<strong>Estado captura: </strong>".$this->traduce_criterio_fijo_bi($estado_captura_persona,20);
							        	echo "<br/>";
							        }

							        if(isset($dpi) && !empty($dpi) && isset($orden_cedula) && !empty($orden_cedula) && isset($registro_cedula) && !empty($registro_cedula)){
							        	// aqui se muestra el dpi y cedula
							        	if (strlen($num_pasaporte)>0 && $pais_emision_pasaporte > 0){
							        		$pais = $this->busca_cat_item_por_categoria($pais_emision_pasaporte,8);
							        		echo "<strong>Identificaci&oacute;n: DPI: </strong>".$dpi." <strong>C&eacute;dula: </strong>".$orden_cedula." ".$registro_cedula." ".$this->nombre_depto($cod_depto_cedula).", ".$this->nombre_municipio($cod_depto_cedula,$cod_muni_cedula)."<strong> Pasaporte: </strong>".$num_pasaporte." - ".$pais;			        		}else{
							        			echo "<strong>Identificaci&oacute;n: DPI: </strong>".$dpi." <strong>C&eacute;dula: </strong>".$orden_cedula." ".$registro_cedula." ".$this->nombre_depto($cod_depto_cedula).", ".$this->nombre_municipio($cod_depto_cedula,$cod_muni_cedula);
							        		}
							        	echo "<br>";
							        }elseif(isset($dpi) && !empty($dpi)){
							        	// aqui se muestra el dpi
							        	echo "<strong>Identificaci&oacute;n: DPI: </strong>".$dpi;
							        	echo "<br>";
							        }elseif(isset($orden_cedula) && !empty($orden_cedula) && isset($registro_cedula) && !empty($registro_cedula)){
							        	// aqui muestro la cedula
							        	echo "<strong>Identificaci&oacute;n: C&eacute;dula: </strong>".$orden_cedula." ".$registro_cedula." ".$this->nombre_depto($cod_depto_cedula)." ".$this->nombre_municipio($cod_depto_cedula,$cod_muni_cedula);
							        	echo "<br>";
							        }else{
							        	if (strlen($num_pasaporte)>0 && $pais_emision_pasaporte > 0){
							        		$pais = $this->busca_cat_item_por_categoria($pais_emision_pasaporte,8);
							        		echo "<strong>Identificaci&oacute;n: Pasaporte: </strong>".$num_pasaporte." - ".$pais;
							        	}else{
							        		echo " ";
							        	}
							        }

							        if(isset($fecha_nacimiento) && !empty($fecha_nacimiento)){
							        	echo "<strong>Fecha de Nacimiento: </strong>".$this->fecha_diagonal($fecha_nacimiento);
							        	echo "<br>";
							        }

							        if(isset($fecha_solvencia) && !empty($fecha_solvencia)){
							        	echo "<strong>Fecha de Solvencia: </strong>".$this->fecha_diagonal($fecha_solvencia);
							        	echo "<br>";
							        }

							        if(isset($madre_primer_nombre) || !empty($madre_primer_nombre)){
							        	echo "<strong>Nombre Madre: </strong>".$this->formato_nombre_completo($madre_primer_nombre,$madre_segundo_nombre,$madre_tercer_nombre,$madre_primer_apellido,$madre_segundo_apellido,$madre_apellido_casada);
							        	echo "<br>";
							        }

							        if(isset($padre_primer_nombre) || !empty($padre_primer_nombre)){
							        	echo "<strong>Nombre Padre: </strong>".$this->formato_nombre_completo($padre_primer_nombre,$padre_segundo_nombre,$padre_tercer_nombre,$padre_primer_apellido,$padre_segundo_apellido,'');
							        	echo "<br>";
							        }

							        if(isset($apodos) && !empty($apodos)){
							        	echo "<strong>Apodos: </strong>".$apodos;
							        	echo "<br>";
							        }

							        if(isset($senias_particulares) && !empty($senias_particulares)){
							        	echo "<strong>Se&ntilde;as Particulares: </strong>".$senias_particulares;
							        	echo "<br>";
							        }

							        if(isset($amputaciones) && !empty($amputaciones)){
							        	echo "<strong>Amputaciones: </strong>".$amputaciones;
							        	echo "<br>";
							        }

							        if(isset($direc_calle) && !empty($direc_calle)){
							        	echo $direc_calle.' <strong>Calle </strong>';
							        }

							        if(isset($direc_ave) && !empty($direc_ave)){
							        	echo $direc_ave. ' <strong>Ave.</strong> ';
							        }

							        if(isset($direc_num_inmueble) && !empty($direc_num_inmueble)){
							        	echo " <strong>#casa: </strong>".$direc_num_inmueble.' ';
							        }

							        if(isset($direc_barrio) && !empty($direc_barrio)){
							        	echo "<strong>Barrio: </strong>".$direc_barrio.' ';
							        }

							        if(isset($direc_zona)&&!empty($direc_zona)){
							        	echo "<strong>Zona: </strong>".$direc_zona;
							        	echo "<br>";
							        }
						        	?>
								</td>
								</tr>
								<tr>
								<td>
								<br>
								<?
								$this->leyenda_pdf('INFORMACI&Oacute;N AUDITORIA');
								?>
								    <table border="1" style="width: 800px;">
									<tr>
									<td>
							        <?
							        if (!empty($fh_ingreso)) {
							        	echo "<strong>Fh. Ingreso: </strong>".$this->fecha_diagonal($fh_ingreso)." ".substr($fh_ingreso,10,9 );
							        }
							        else{
							        	echo "<strong>Fh. Ingreso: </strong>";
							        }
							        ?>
								    </td>
								    <td>
								    <?
								    if (!empty($fh_ultima_mod)) {
								    	echo "<strong>Fh. Ult. Modificaci&oacute;n: </strong>".$this->fecha_diagonal($fh_ultima_mod)." ".substr($fh_ultima_mod,10,9 );
								    }
								    else{
								    	echo "<strong>Fh. Ult. Modificaci&oacute;n: <strong>";
								    }
								    ?>
							        </td>
									</tr>
									<tr>
									<td>
							        <?
							        echo "<strong>Usu. Ingreso: </strong>".$usuario_ingreso;
							        ?>
								    </td>
								    <td>
								    <?
								    echo "<strong>Usu. Ult. Modificaci&oacute;n: </strong>".$usuario_ultima_mod;
								    ?>
							        </td>
									</tr>
									</table>
								</td>
								</tr>
								</table>
							</td>
							<td style="font-size:10px">
								<?
								$this->leyenda_pdf("DELITOS");
								echo "<br>";
								$respuesta3 = $this->delitos_bi($id_orden_captura);
								if($respuesta3 == true){
									foreach($respuesta3 as $info){
										echo "* ";
							      		echo $this->delitos_ciudadano($info['cod_delito'],false)."<br>";
									}
								}
								?>
							</td>
							</tr>
							</table>
							<br>
							<?
						}// fin for

					}else{
						$muestra_alias = false;
						$modifica_autor = false;
						$modifica_delito = false;
						$gestiona_autor = false;
						$elimina_autor = false;
						$tipo_gestion=0;
						$id_orden_captura_persona=0;

						$this->leyenda_pdf('LISTADO DE AUTORES');
						//if ($id_orden_captura_persona > 0) {
						if ($ocp > 0) {
							$sql = "SELECT * FROM orca_gestion.ogt_orden_captura_persona Where id_orden_captura = ".$id_orden_captura." and id_orden_captura_persona = ".$ocp." and id_reiteracion = 0 order by id_orden_captura_persona asc";
						}else{
							$sql = "SELECT * FROM orca_gestion.ogt_orden_captura_persona Where id_orden_captura = ".$id_orden_captura." and id_reiteracion = 0 order by id_orden_captura_persona asc";
						}
						$respuesta = Yii::app()->db->createCommand($sql)->queryAll();

						// mostramos  los autores sin id_reiteracion
						//<table cellspacing="2" style="width: 100%; border: 1;  text-align: center; font-size: 10pt; ">
						?>
						<table border="1">
						<?

						foreach ($respuesta as $row) {
							?>
							<tr>
							<td>
							<?
							// recorremos el arreglo y le enviamos el array para asignacion de variables
							$id_reiteracion = $row['id_reiteracion'];
							$id_orden_captura_persona = $row['id_orden_captura_persona'];
							$id_orden_captura = $row['id_orden_captura'];
							$telefonema = $this->trae_num_telefonema($id_orden_captura);
							$id_ciudadano_renap = $row['id_ciudadano_renap'];
							$id_ciudadano_anonimo = $row['id_ciudadano_anonimo'];
							$primer_nombre = $row['primer_nombre'];
							$segundo_nombre = $row['segundo_nombre'];
							$tercer_nombre = $row['tercer_nombre'];
							$primer_apellido = $row['primer_apellido'];
							$segundo_apellido = $row['segundo_apellido'];
							$apellido_casada = $row['apellido_casada'];
							$senias_particulares = $row['senias_particulares'];
							$amputaciones = $row['amputaciones'];
							$peso = $row['peso'];
							$estatura = $row['estatura'];
							$orden_cedula = $row['orden_cedula'];
							$registro_cedula = $row['registro_cedula'];
							$cod_depto_cedula = $row['cod_depto_cedula'];
							$cod_muni_cedula = $row['cod_muni_cedula'];
							$direc_calle = $row['direc_calle'];
							$direc_num_inmueble = $row['direc_num_inmueble'];
							$direc_ave = $row['direc_ave'];
							$direc_barrio = $row['direc_barrio'];
							$direc_zona = $row['direc_zona'];
							$direc_cod_depto = $row['direc_cod_depto'];
							$direc_cod_munic = $row['direc_cod_munic'];
							$fecha_nacimiento = $row['fecha_nacimiento'];
							$cod_depto_nacimiento = $row['cod_depto_nacimiento'];
							$cod_munic_nacimiento = $row['cod_munic_nacimiento'];
							$lugar_nacimiento = $row['lugar_nacimiento'];
							$cod_nacionalidad = $row['cod_nacionalidad'];
							$nombre_padre = $row['nombre_padre'];
							$nombre_madre = $row['nombre_madre'];
							$apodos = $row['apodos'];
							$fallecido = $row['fallecido'];
							$fecha_defuncion = $row['fecha_defuncion'];
							$pais_emision_pasaporte = $row['pais_emision_pasaporte'];
							$num_pasaporte = $row['num_pasaporte'];
							$profesion = $row['profesion'];
							$estado_civil=$row['estado_civil'];
							$genero = $row['genero'];
							$estado_captura_persona = $row['estado_captura_persona'];
							$fh_ingreso = $row['fh_ingreso'];
							$fh_ultima_mod = $row['fh_ultima_mod'];
							$usuario_ingreso = $row['usuario_ingreso'];
							$usuario_ultima_mod = $row['usuario_ultima_mod'];

							$madre_primer_nombre= $row['madre_primer_nombre'];
							$madre_segundo_nombre= $row['madre_segundo_nombre'];
							$madre_tercer_nombre= $row['madre_tercer_nombre'];
							$madre_primer_apellido= $row['madre_primer_apellido'];
							$madre_segundo_apellido= $row['madre_segundo_apellido'];
							$madre_apellido_casada= $row['madre_apellido_casada'];
							$padre_primer_nombre= $row['padre_primer_nombre'];
							$padre_segundo_nombre= $row['padre_segundo_nombre'];
							$padre_tercer_nombre= $row['padre_tercer_nombre'];
							$padre_primer_apellido= $row['padre_primer_apellido'];
							$padre_segundo_apellido= $row['padre_segundo_apellido'];
							$dpi = $row['dpi'];
							$fecha_solvencia = $row['fecha_solvencia_bi'];
							// inicio a mostrar mi formulario con datos de autores
							//$this->leyenda("ID: ".$id_orden_captura_persona);
							echo '<font color="red" style="font-size:12px"><strong>ID: '.$id_orden_captura_persona.'</strong></font>';
							echo "<br>";
								if($id_ciudadano_renap <> 0) {
									$src = $this->foto_ciudadano_renap($id_ciudadano_renap);
									if(strlen($src) <= 300){
										echo '<img src="images/nodisponible.png" width="160" height="200" class="img-rounded">';
										echo "<br>";
										echo "<center><font style='font-size:12px'>Ciudadano RENAP</font></center>";
						 			}else{
						 				$res = $src;
										$xml = new SimpleXMLElement($res);
						 				$newdataset = $xml->children();
						 				$objetos = get_object_vars($newdataset);
						 				$objetos = get_object_vars($newdataset);
						 				$fotica=$objetos['PortraitImage'];
										echo '<img src="data:image/jpeg;base64,'.$fotica.'" width="160" height="200" class="img-rounded">';
						 				echo "<br>";
						 				echo "<center><font style='font-size:12px'>Ciudadano RENAP</font></center>";
						 			}
								}
								else{
									echo '<img src="images/nodisponible.png" width="160" height="200" class="img-rounded">';
									echo "<br>";
									echo "<center><font style='font-size:12px'>Ciudadano</font></center>";
								}
								echo "<br>";
								if (isset($foto)) {
									echo '<img src="images/'.$foto.'" width="60" height="60" class="img-rounded">';
									echo "<br>";
								}
								if (isset($color)) {
									echo "<center><font style='font-size:12px'>".$color."</font></center>";
									echo "<br>";
								}
							?>
							</td>
							<td>
								<table style="width: 800px;">
								<tr>
								<td>
								<?
								$this->leyenda_pdf("DATOS CIUDADANO");
								echo "<br>";
								echo "<strong>Nombre Completo: </strong>".$this->formato_nombre_completo($primer_nombre,$segundo_nombre,$tercer_nombre,$primer_apellido,$segundo_apellido,$apellido_casada);
								echo "<br>";
						        echo "<strong>Lugar de Nacimiento: </strong>".$this->nombre_depto($cod_depto_nacimiento); ?>,<? echo  $this->nombre_municipio($cod_depto_nacimiento,$cod_munic_nacimiento); ?>, <? echo $lugar_nacimiento;
						     	echo "<br>";

						      	if($estado_captura_persona == 2){
						      		echo "<strong>Estado captura: </strong>".$this->descripcion_criterio_fijo(20,$estado_captura_persona);
									echo "<br/>";
								}elseif($estado_captura_persona == 4){
						      		echo "<strong>Estado captura: </strong>".$this->descripcion_criterio_fijo(20,$estado_captura_persona);
									echo "<br/>";
								}else{
						      		echo "<strong>Estado captura: </strong>".$this->descripcion_criterio_fijo(20,$estado_captura_persona);
									echo "<br/>";
								}

					        	if(isset($dpi) && !empty($dpi) && isset($orden_cedula) && !empty($orden_cedula) && isset($registro_cedula) && !empty($registro_cedula)){
					        		// aqui se muestra el dpi y cedula
					        		if (strlen($num_pasaporte)>0 && $pais_emision_pasaporte > 0){
					        			$pais = $this->busca_cat_item_por_categoria($pais_emision_pasaporte,8);
					        			echo "<strong>Identificaci&oacute;n: DPI: </strong>".$dpi." <strong>C&eacute;dula: </strong>".$orden_cedula." ".$registro_cedula." ".$this->nombre_depto($cod_depto_cedula).", ".$this->nombre_municipio($cod_depto_cedula,$cod_muni_cedula)."<strong> Pasaporte: </strong>".$num_pasaporte." - ".$pais;			        		}else{
					        			echo "<strong>Identificaci&oacute;n: DPI: </strong>".$dpi." <strong>C&eacute;dula: </strong>".$orden_cedula." ".$registro_cedula." ".$this->nombre_depto($cod_depto_cedula).", ".$this->nombre_municipio($cod_depto_cedula,$cod_muni_cedula);
					        		}
					        		echo "<br>";
					        	}elseif(isset($dpi) && !empty($dpi)){
					        		// aqui se muestra el dpi
					        		echo "<strong>Identificaci&oacute;n: DPI: </strong>".$dpi;
					        		echo "<br>";
					        	}elseif(isset($orden_cedula) && !empty($orden_cedula) && isset($registro_cedula) && !empty($registro_cedula)){
					        		// aqui muestro la cedula
					        		echo "<strong>Identificaci&oacute;n: C&eacute;dula: </strong>".$orden_cedula." ".$registro_cedula." ".$this->nombre_depto($cod_depto_cedula)." ".$this->nombre_municipio($cod_depto_cedula,$cod_muni_cedula);
					        		echo "<br>";
					        	}else{
					        		if (strlen($num_pasaporte)>0 && $pais_emision_pasaporte > 0){
					        			$pais = $this->busca_cat_item_por_categoria($pais_emision_pasaporte,8);
					        			echo "<strong>Identificaci&oacute;n: Pasaporte: </strong>".$num_pasaporte." - ".$pais;
					        		}else{
					        			echo " ";
					        		}
					        	}

						        if(isset($fecha_nacimiento) && !empty($fecha_nacimiento)){
						        	echo "<strong>Fecha de Nacimiento: </strong>".$this->fecha_diagonal($fecha_nacimiento);
						        	echo "<br>";
						        }

								if(isset($fecha_solvencia) && !empty($fecha_solvencia)){
									echo "<strong>Fecha de Solvencia: </strong>".$this->fecha_diagonal($fecha_solvencia);
									echo "<br>";
								}

								if(isset($madre_primer_nombre) || !empty($madre_primer_nombre)){
									echo "<strong>Nombre Madre: </strong>".$this->formato_nombre_completo($madre_primer_nombre,$madre_segundo_nombre,$madre_tercer_nombre,$madre_primer_apellido,$madre_segundo_apellido,$madre_apellido_casada);
									echo "<br>";
								}

								if(isset($padre_primer_nombre) || !empty($padre_primer_nombre)){
									echo "<strong>Nombre Padre: </strong>".$this->formato_nombre_completo($padre_primer_nombre,$padre_segundo_nombre,$padre_tercer_nombre,$padre_primer_apellido,$padre_segundo_apellido,'');
									echo "<br>";
								}

								if(isset($apodos) && !empty($apodos)){
									echo "<strong>Apodos: </strong>".$apodos;
									echo "<br>";
								}

								if(isset($senias_particulares) && !empty($senias_particulares)){
									echo "<strong>Se&ntilde;as Particulares: </strong>".$senias_particulares;
									echo "<br>";
								}

								if(isset($amputaciones) && !empty($amputaciones)){
									echo "<strong>Amputaciones: </strong>".$amputaciones;
									echo "<br>";
								}

								if(isset($direc_calle) && !empty($direc_calle)){
									echo $direc_calle.' <strong>Calle </strong>';
								}

								if(isset($direc_ave) && !empty($direc_ave)){
									echo $direc_ave. ' <strong>Ave.</strong> ';
								}

								if(isset($direc_num_inmueble) && !empty($direc_num_inmueble)){
									echo " <strong>#casa: </strong>".$direc_num_inmueble.' ';
								}

								if(isset($direc_barrio) && !empty($direc_barrio)){
									echo "<strong>Barrio: </strong>".$direc_barrio.' ';
								}

								if(isset($direc_zona)&&!empty($direc_zona)){
									echo "<strong>Zona: </strong>".$direc_zona;
									echo "<br>";
								}

								echo "<br>";
								$sql2 = "Select * From orca_gestion.ogt_orden_captura_persona_alias Where id_orden_captura_persona = ".$id_orden_captura_persona;
								$respuesta2 = Yii::app()->db->createCommand($sql2)->queryAll();
								$i=1;
								if ($respuesta2) {
									$this->leyenda("ALIAS");
								}
								if($respuesta2 == true){
									foreach($respuesta2 as $info){
										// se muestra el listado de alias
										if($i == 1){
											echo $this->formato_nombre_completo($info['primer_nombre'],$info['segundo_nombre'],$info['tercer_nombre'],$info['primer_apellido'],$info['segundo_apellido'],$info['apellido_casada']);
										}else{
											echo " - ".$this->formato_nombre_completo($info['primer_nombre'],$info['segundo_nombre'],$info['tercer_nombre'],$info['primer_apellido'],$info['segundo_apellido'],$info['apellido_casada']);
										}
										$i++;
						      		}
									echo "<br>";
								}
								echo "<br>";
								echo "<br>";
								?>
								</td>
								</tr>
								<tr>
								<td>
								<?
						        $this->leyenda_pdf('INFORMACI&Oacute;N AUDITORIA');
						        ?>
							        <table border="1" style="width: 800px;">
									<tr>
									<td>
							        <?
								        if (!empty($fh_ingreso)) {
								        	echo "<strong>Fh. Ingreso: </strong>".$this->fecha_diagonal($fh_ingreso)." ".substr($fh_ingreso,10,9 );
								        }
								        else{
								        	echo "Fh. Ingreso: ";
								        }
								    ?>
								    </td>
								    <td>
								    <?
									    if (!empty($fh_ultima_mod)) {
									    	echo "<strong>Fh. Ult. Modificaci&oacute;n: </strong>".$this->fecha_diagonal($fh_ultima_mod)." ".substr($fh_ultima_mod,10,9 );
									    }
									    else{
									    	echo "<strong>Fh. Ult. Modificaci&oacute;n: <strong>";
									    }
							        ?>
							        </td>
									</tr>
									<tr>
									<td>
							        <?
							        	echo "<strong>Usu. Ingreso: </strong>".$usuario_ingreso;
							        ?>
								    </td>
								    <td>
								    <?
								    	echo "<strong>Usu. Ult. Modificaci&oacute;n: </strong>".$usuario_ultima_mod;
							        ?>
							        </td>
									</tr>
									</table>

								</td>
								</tr>
								</table>

								</td>
								<td style="font-size:10px">
								<?
								echo "<br>";
								$this->leyenda_pdf("DELITOS");
								$sql3 = "SELECT * FROM orca_gestion.ogt_orden_captura_persona_delito Where id_orden_captura_persona = ".$id_orden_captura_persona;
								$respuesta3 = Yii::app()->db->createCommand($sql3)->queryAll();
								if($respuesta3 == true){
									foreach($respuesta3 as $info){
										$cod_delito = $this->busca_cat_item($info['cod_delito']);
										echo '* '.$cod_delito;
										echo "<br>";
									}
								}
								?>
								</td>
								</tr>

								</td>
								</tr>
								<tr>
								<td colspan="3" bgcolor="#909090">
								<br>
								</td>
								</tr>
								<?
						} // fin del foreach
						?>
						</table>
						<br>
						<?
					}
				}else{
					echo '<div class="modal-header">';
					echo '<span class="label label-important">NO HAY N&Uacute;MERO DE ORDEN DE CAPTURA</span>';
					echo '</div>';
					echo '<br>';
				}
			}// fin for
		}else{
			echo '<div class="modal-header">';
			echo '<span class="label label-important">NO TIENE CAPTURAS</span>';
			echo '</div>';
			echo '<br>';
		}
	}// fin funcion

	// funciones de capturas
	public function trae_num_telefonema_bi($id_orden_captura=0,$id_ciudadano=0){
		$num_telefonema=0;
		if ($id_ciudadano>0) {
			$sql = "Select id_hecho from orca_bi.orden_captura where id_captura = ".$id_orden_captura." and id_ciudadano = ".$id_ciudadano;
		}else{
			$sql = "Select id_hecho from orca_bi.orden_captura where id_captura = ".$id_orden_captura;
		}
		$dbC = Yii::app()->db->createCommand($sql);
		$num_telefonema = $dbC->queryScalar();
		return $num_telefonema;
	}

	public function trae_datos_orden_captura_bi($id_captura_bi=0,$id_orden_captura=0,$id_ciudadano=0)
	{
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);
		$a_valores = array();
		if ($id_captura_bi > 0 && $id_orden_captura > 0) {
			$conn->select('*')
				 ->from('orca_bi.orden_captura')
				 ->where('id_captura=:id_captura and id_captura_orca=:id_captura_orca', array(':id_captura'=>$id_captura_bi,':id_captura_orca'=>$id_orden_captura));
			$a_valores = $conn->queryAll();
		}elseif ($id_captura_bi > 0 && $id_orden_captura == 0) {

			if ($id_ciudadano > 0) {
				$conn->select('*')
					 ->from('orca_bi.orden_captura')
					 ->where('id_captura=:id_captura and id_ciudadano=:id_ciudadano', array(':id_captura'=>$id_captura_bi,':id_ciudadano'=>$id_ciudadano));
				$a_valores = $conn->queryAll();
			}else{
				$conn->select('*')
					 ->from('orca_bi.orden_captura')
					 ->where('id_captura=:id_captura', array(':id_captura'=>$id_captura_bi));
				$a_valores = $conn->queryAll();
			}
		}elseif ($id_captura_bi == 0 && $id_orden_captura > 0) {
			$conn->select('*')
				 ->from('orca_bi.orden_captura')
				 ->where('id_captura_orca=:id_captura_orca', array(':id_captura_orca'=>$id_orden_captura));
			$a_valores = $conn->queryAll();
		}
		return $a_valores;
	}

	public function trae_num_telefonema($id_orden_captura=0){
		$num_telefonema=0;
		$sql = "Select num_telefonema from orca_gestion.ogt_orden_captura where id_orden_captura = ".$id_orden_captura;
		$dbC = Yii::app()->db->createCommand($sql);
		$num_telefonema = $dbC->queryScalar();
		return $num_telefonema;
	}

	public function delitos_bi($id_orden_captura=0){
		$sql = "SELECT a.id_referencia FROM bi.delitos a
					INNER JOIN
						(SELECT d.cod_delito FROM orca_bi.orden_captura oc
					 	 INNER JOIN orca_bi.orden_captura_delitos d ON oc.id_captura = d.id_captura
						 WHERE oc.id_captura = ".$id_orden_captura.") b
					ON a.cod_delito = b.cod_delito
					Order by a.id_referencia";
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
		$datos =array();
		$a_datos =array();
		foreach ($dbO->queryAll() as $resultado) {
			$sql = "SELECT id_cat_item,descripcion as delito
											FROM sapo_gestion.sapogt_cat_item where id_cat = 4
											and estado = 1 and id_referencia = ".$resultado->id_referencia;
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			$i=1;
			foreach ($dbO->queryAll() as $nombre_delito) {
				$datos['cod_delito'] = $nombre_delito->id_cat_item;;
				$datos['delito'] = $nombre_delito->delito;
				$a_datos[] = $datos;
			}
		}
		return $a_datos;
	}

	public function delitos_ciudadano($cod_delito,$retorna=false){
		$sql = "SELECT * FROM sapo_gestion.sapogt_cat_item WHERE id_cat_item = ".$cod_delito;
		$respuesta = Yii::app()->db->createCommand($sql)->queryAll();
		$delito = '';
		if($respuesta == true){
			foreach($respuesta as $info){
				// se muestra el listado de alias
				if ($retorna) {
					$delito =  $info['descripcion'];
				}else{
					echo $info['descripcion'];
				}
			}
		}
		if ($retorna) {
			return $delito;
		}
	}

	public function traduce_cod_juzgado_bi($cod_juzgado=0,$cod_depto_juzgado=0,$cod_munic_juzgado=0){
		$valor = '';
		if ($cod_juzgado>0 && $cod_depto_juzgado>0 && $cod_munic_juzgado>0) {
			$sql = "Select id_referencia  From bi.juzgados where cod_juzgado = ".$cod_juzgado." and cod_depto = ".$cod_depto_juzgado." and cod_municipio = ".$cod_munic_juzgado;
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			foreach ($dbO->queryAll() as $resultado) {
				$valor = $resultado->id_referencia;
			}
		}
		return $valor;
	}

	// Retorna el nombre del departamento renap haciendo traducción del id_depto en el schema bi
	public function traduce_cod_depto_bi($id_depto=0){
		$id_depto_renap = 0;
		if ($id_depto>0) {
			$sql = "Select cod_depto_renap From bi.geo_traductor Where cod_depto_oracle = ".$id_depto." Group by cod_depto_renap";
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			foreach ($dbO->queryAll() as $resultado) {
				foreach($resultado as $record){
					$id_depto_renap = $record;
				}
			}
		}
		return $id_depto_renap;
	}

	// Retorna el nombre del municipio renap haciendo traducción del id_municipio en el schema bi
	public function traduce_cod_muni_bi($id_depto=0,$id_munic=0){
		$id_depto_renap = 0;
		$id_munic_renap = 0;
		if ($id_depto>0 && $id_munic >0) {
			$sql = "Select cod_depto_renap, cod_muni_renap From bi.geo_traductor Where cod_depto_oracle = ".$id_depto." and cod_muni_oracle = ".$id_munic;
			$dbO = Yii::app()->db->createCommand($sql);
			$dbO->setFetchMode(PDO::FETCH_OBJ);//fetch each row as Object
			foreach ($dbO->queryAll() as $resultado) {
				$id_depto_renap = $resultado->cod_depto_renap;
				$id_munic_renap = $resultado->cod_muni_renap;
			}
		}
		else{

		}
		return $id_munic_renap;
	}

	public function trae_num_reincidente_sapo($id_reincidente=0,$id_ficha_criminal=0){
		$num_reincidente = 0;
		$resultado = array();
		if ($id_reincidente>0) {
			$resultado = Yii::app()->db->createCommand()
						//->selectDistinct('num_reincidente')
						->select('(case when num_reincidente > 0 then num_reincidente else num_cuache end) as num_reincidente')
						->from('sapo_gestion.sapogt_ficha_reincidencia')
						->where('id_ficha_reincidencia=:id_ficha_reincidencia', array(':id_ficha_reincidencia'=>$id_reincidente))
						->queryAll();
		}
		elseif($id_ficha_criminal>0){
			$resultado = Yii::app()->db->createCommand()
						//->selectDistinct('num_reincidente')
						->select('(case when num_reincidente > 0 then num_reincidente else num_cuache end) as num_reincidente')
						->from('sapo_gestion.sapogt_ficha_reincidencia r')
						->join('sapo_gestion.sapogt_ficha_criminal f','r.id_ficha_reincidencia = f.id_reincidente')
						->where('f.id_ficha_criminal=:id_ficha_criminal', array(':id_ficha_criminal'=>$id_ficha_criminal))
						->queryAll();

		}

		foreach($resultado as $key => $value){
			$num_reincidente =  $value['num_reincidente'];
		}
		return $num_reincidente;

	}

	public function ws_rvr($tipo='',$placa=''){
		$data = array();
		$usuario = Yii::app()->user->name;
		$arreglo_cliente['placa'] =$placa;
		$arreglo_cliente['tipo'] =$tipo;
		$arreglo_cliente['motor'] ='';
		$arreglo_cliente['chasis'] ='';
		$arreglo_cliente['usuario'] =$usuario;
		$arreglo_cliente['cliente'] =CLIENTE;
		try{
			$ws_cliente = new SoapClient(null, array("location"=>URL_WS_RVR, "uri"=>URL_WS_RVR));
			$data=$ws_cliente->BuscaRoboVehiculo($arreglo_cliente);
		}
		catch(Exception $e){
			try{
				$ws_cliente = new SoapClient(null, array("location"=>URL_WS_RVR, "uri"=>URL_WS_RVR));
				$data=$ws_cliente->BuscaRoboVehiculo($arreglo_cliente);
			}
			catch(Exception $e){
				$data = array();
				$data['error'] = 1;
				$data['error_descripcion'] = 'Error en el web service de consulta de vehiculos robados';
			}
		}

		return $data;
	}

	public function combo_criterio_fijo_sin_seleccione($id_criterio_fijo=0)
	{
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('id_opcion,descripcion')
			 ->from('sapo_gestion.sapogt_criterio_fijo')
			 ->where('id_criterio_fijo=:id_criterio_fijo and estado=:estado', array(':id_criterio_fijo'=>$id_criterio_fijo, ':estado'=>1))
			 ->order('id_opcion asc');
		$a_valores = array();
		$i = 1;
		foreach($conn->queryAll() as $data)
		{
			$a_valores[$i]['id_opcion'] = $data->id_opcion;
			$a_valores[$i]['descripcion'] = $data->descripcion;
			$i++;
		}
		return $a_valores;
	}

	public function trae_parametro($id){
		$sql = "SELECT valor
				      		FROM sapo_gestion.sapogt_parametro
				  		    WHERE id_parametro = ".$id ;
		$dbO = Yii::app()->db->createCommand($sql);
		$dbO->setFetchMode(PDO::FETCH_OBJ);

		foreach ($dbO->queryAll() as $resultado) {
			return $resultado->valor;
		}
	}// fin funcion
	//De aqui para abajo se agrego el 16/9/2014 para consulta de rojos
    //encabezado de los reportes
	public function encabezado_reporte($strFecha='',$nombre_usuario='',$comisaria=''){
		?>
		<br>
		<div class="row-fluid">
			<div class="span1">
			</div>
			<div class="span4">
				<i class="icon-calendar"></i> <span class="bold">Fecha: </span><? echo $strFecha; ?>
			</div>
			<div class="span3">
				<i class="icon-user"></i> <span class="bold">Usuario: </span> <? echo $nombre_usuario; ?>
			</div>
			<div class="span3">
				<i class="icon-home"></i> <span class="bold">Ubicación: </span> <? echo $comisaria; ?>
			</div>
		</div>

		<br>
		<?
	}

	public function combo_cat_item($id_cat=0,$order='')
	{
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		if ($order == '') {
			$conn->select('id_cat_item,descripcion')
				 ->from('sapo_gestion.sapogt_cat_item')
				 ->where('id_cat=:id_cat and estado=:estado', array(':id_cat'=>$id_cat, ':estado'=>1))
				 ->order('orden desc');
		}
		else{
			$conn->select('id_cat_item,descripcion')
				 ->from('sapo_gestion.sapogt_cat_item')
				 ->where('id_cat=:id_cat and estado=:estado', array(':id_cat'=>$id_cat, ':estado'=>1))
				 ->order($order);
		}
		$a_valores = array();
		$i = 1;
		foreach($conn->queryAll() as $data)
		{
			$a_valores[$i]['id_cat_item'] = $data->id_cat_item;
			$a_valores[$i]['descripcion'] = $data->descripcion;
			$i++;
		}
		return $a_valores;
	}
	public function busca_modulo($id_modulo=0)
	{
		$valor = '';
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('modulo')
				 ->from('sapo_autentica.sapoat_modulo_t')
				 ->where('id_modulo=:id_modulo', array(':id_modulo'=>$id_modulo));
		foreach($conn->queryAll() as $data)
		{
			$valor = $data->modulo;
		}
		return $valor;
	}
	public function pie_print(){
		$date = new DateTime();
		$fecha_imp=$date->format('d-m-Y h:i:s');
		$usuario = Yii::app()->user->name;
		$mensaje = "Usuario: $usuario Fecha y Hora de Impresión: $fecha_imp";
		?>
		<table>
		    <tfoot>
		        <td><?echo $mensaje;?></td>
		    </tfoot>
		</table>
		<?
	}
	
	public function DatosFormaReportesCompleto()
	{
		if(isset($_POST['RangoFechas'])){
			if ($_POST['RangoFechas']['id_comisaria'] == '') {
				$_POST['RangoFechas']['id_comisaria'] = 0;
			}
			if ($_POST['RangoFechas']['id_modulo'] == '') {
				$_POST['RangoFechas']['id_modulo'] = 0;
			}
			$model=new RangoFechas;
			$model->attributes=$_POST['RangoFechas'];
		}

		if(isset($_POST['ajax']) && $_POST['ajax']==='busqueda')
		{
			echo CActiveForm::validate( array($model));
			Yii::app()->end();

		}

		if(isset($_POST['RangoFechas']))
		{
			$model->attributes=$_POST['RangoFechas'];
			$valid=$model->validate();
		}

		if($valid){
			return $model;
			Yii::app()->end();
		} else{
			$error = CActiveForm::validate($model);
			if($error!='[]')
				echo $error;
			Yii::app()->end();
		}
	}
	public function combo_modulo()
	{
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('id_modulo, modulo')
			 ->from('sapo_autentica.sapoat_modulo_t')
			 ->order('modulo');

		$a_valores = array();
		$i = 0;
		foreach($conn->queryAll() as $data)
		{
			$a_valores[$i]['id_modulo'] = $data->id_modulo;
			$a_valores[$i]['modulo'] = $data->modulo;
			$i++;
		}
		return $a_valores;
	}// Trae el combo de los modulos
	public function combo_grupos()
	{
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('id_grupo, descripcion')
			 ->from('sapo_autentica.sapoat_grupo')
			 ->order('descripcion');

		$a_valores = array();
		$i = 0;
		foreach($conn->queryAll() as $data)
		{
			//$this->ver_var($data);
			$a_valores[$i]['id_grupo'] = $data->id_grupo;
			$a_valores[$i]['descripcion'] = $data->descripcion;
			$i++;
		}
		//$this->ver_var($a_valores);
		return $a_valores;
	}// Trae el combo de los modulos

	public function trae_nombre_usuario($id=''){
		$sql = "SELECT usuario from sapo_autentica.sapoat_usuario_t
					WHERE id_usuario = ".$id."";
		/*se extrae el id del usuario*/
		$dbC = Yii::app()->db->createCommand($sql);
		$id = $dbC->queryScalar();
		return $id;
    }// finaliza funcion de trae_id_usuario
    //Funcion para agarrar el nombre del modulo en auditoria
	public function busca_modulo_nombre($id_modulo_valor=0)
	{
		$valor = '';
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('modulo')
				 ->from('sapo_autentica.sapoat_modulo_t')
				 ->where('id_modulo=:id_modulo', array(':id_modulo'=>$id_modulo_valor));
		foreach($conn->queryAll() as $data)
		{
			$valor = $data->modulo;
		}
		return $valor;
	}
	public function cambiarColor($newArray, $oldArray, $currentValue){
		$returnValue = '';
		$arrayTest = $newArray;
		$keys = array_keys($arrayTest);
		$keysNewArray = array_keys($newArray);
		$keysOldArray = array_keys($oldArray);
		for ($i=0; $i < count($arrayTest) ; $i++) {
			$arrayTest[$keys[$i]] = 0;
			# code...
		}
		for ($r=0; $r < count($arrayTest); $r++) {
			if($newArray[$keysNewArray[$r]] === $oldArray[$keysOldArray[$r]]){

			}else{
				$arrayTest[$keys[$r]] = 1;
			}
			# code...
		}
		//$this->ver_var($arrayTest);
		//$this->ver_var($newArray);
		//$this->ver_var($oldArray);
		//exit();
		if(1 == $arrayTest[$currentValue] ){

			$returnValue = "<strong><font color='red'>".$newArray[$currentValue]."</font></strong>";
			return $returnValue;
		}
		//$this->ver_var($arrayTest);
		//$this->ver_var($newArray);
		//$this->ver_var($oldArray);
		//$this->ver_var($keysNewArray);
		//exit();
		$returnValue = $newArray[$currentValue];
		return $returnValue;
	}

	//cambia color para ARRAYS con un subarray
	public function cambiarColorArray($newArray, $oldArray, $currentValue){
		$keys = array();
		$keysNewArray = array();
		$keysOldArray = array();

		$returnValue = '';
		$arrayTest = $newArray;
		//$keys = array_keys($arrayTest);
		//$keysNewArray = array_keys($newArray);
		//$keysOldArray = array_keys($oldArray);









		for($blah=0; $blah < count($arrayTest) ; $blah++) {
			$keys[$blah] = array_keys($arrayTest[$blah]);
			$keysNewArray[$blah] = array_keys($newArray[$blah]);
			$keysOldArray[$blah] = array_keys($oldArray[$blah]);
		}
		//$i = 0;



		for ($row=0; $row < count($arrayTest) ; $row++) {
			for ($i=0; $i < count($arrayTest[$row][$i]) ; $i++) {
				$arrayTest[$keys[$row][$i]] = 0;
		 		# code...
			}
		}
		$this->ver_var($arrayTest);
		//for ($row=0; $row < count($arrayTest[$row]) ; $row++) {
			//$this->ver_var($arrayTest[1]);
		//}
		//$this->ver_var($keysNewArray);
		//$this->ver_var($arrayTest);
		//$this->ver_var($newArray);
		//$this->ver_var($oldArray);
		exit();

		for ($r=0; $r < count($arrayTest); $r++) {
			if($newArray[$keysNewArray[$r]] === $oldArray[$keysOldArray[$r]]){

			}else{
				$arrayTest[$keys[$r]] = 1;
			}
			# code...
		}

		if(1 == $arrayTest[$currentValue] ){

			$returnValue = "<strong><font color='red'>".$newArray[$currentValue]."</font></strong>";
			return $returnValue;
		}
		//$this->ver_var($arrayTest);
		//$this->ver_var($newArray);
		//$this->ver_var($oldArray);
		//$this->ver_var($keysNewArray);
		//exit();
		$returnValue = $newArray[$currentValue];
		return $returnValue;
	}

	//Funcion para revisar el valor si es color rojo o no y sacar su categoria llamando la otra funccion
	//Tambien siver para otras funciones miscelaneas que se llaman por medio de otra funcion
	public function revisarColor($variableRevisar,$num_correlativo=0,$tipo_funcion=0){
		if ($tipo_funcion == 0){    //0 es para buscar item por categoria en el catalogo
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$nombre_colorizado = "<strong><font color='red'>".$this->busca_cat_item_por_categoria($valor_extraido,$num_correlativo)."</font></strong>";
				return $nombre_colorizado;

			}else{
				return $this->busca_cat_item_por_categoria($variableRevisar,$num_correlativo);

			}
		}else if($tipo_funcion == 1){  //1 es para traer departamento renap
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$nombre_colorizado = "<strong><font color='red'>".$this->trae_departamento_renap($valor_extraido)."</font></strong>";
				return $nombre_colorizado;

			}else{
				return $this->trae_departamento_renap($variableRevisar);

			}
		}else if($tipo_funcion == 2){  //2 es para traer el municipio renap por medio del municipio y departamento
			$valor_extraido = '';
			$segundo_valor_extraido = '';
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$variableRevisar = $valor_extraido;
			}
			if (strpos($num_correlativo,'<strong>') !== false) {
				$posicion_comienzo = strpos($num_correlativo, 'red\'>')+5;
				$posicion_fin = strpos($num_correlativo, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$segundo_valor_extraido = substr($num_correlativo,$posicion_comienzo,$valor_longitud);
				$num_correlativo = $segundo_valor_extraido;
			}
			if($valor_extraido != '' || $segundo_valor_extraido != ''){
				$nombre_colorizado = "<strong><font color='red'>".$this->trae_municipio_renap_por_depto_muni($variableRevisar,$num_correlativo)."</font></strong>";
				return $nombre_colorizado;
			}
			else{
				return $this->trae_municipio_renap_por_depto_muni($variableRevisar,$num_correlativo);
			}
		}else if($tipo_funcion == 3){ // 3 es para traer el juzgado por medio de SAPO
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$nombre_colorizado = "<strong><font color='red'>".$this->linea_informacion_juzgado_sapo($valor_extraido)."</font></strong>";
				return $nombre_colorizado;

			}else{
				return $this->linea_informacion_juzgado_sapo($variableRevisar);

			}
		}else if($tipo_funcion == 4){ //4 was para buscar por criterio fijo
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$nombre_colorizado = "<strong><font color='red'>".$this->busca_criterio_fijo($valor_extraido,$num_correlativo)."</font></strong>";
				//$this->busca_criterio_fijo(2,2);
				//exit();

				return $nombre_colorizado;
			}else{
				return $this->busca_criterio_fijo($variableRevisar,$num_correlativo);
				//$this->busca_criterio_fijo($resultado->genero,2);

			}
		}else if($tipo_funcion == 5){ //5 es para buscar nombre del modulo
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$nombre_colorizado = "<strong><font color='red'>".$this->busca_modulo_nombre($valor_extraido)."</font></strong>";
				//$this->busca_criterio_fijo(2,2);
				//exit();

				return $nombre_colorizado;
			}else{
				return $this->busca_modulo_nombre($variableRevisar);
				//$this->busca_criterio_fijo($resultado->genero,2);

			}
		}else if($tipo_funcion == 6){ //6 trae el nombre del usuario
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$nombre_colorizado = "<strong><font color='red'>".$this->trae_nombre_usuario($valor_extraido)."</font></strong>";
				//$this->busca_criterio_fijo(2,2);
				//exit();

				return $nombre_colorizado;
			}else{
				return $this->trae_nombre_usuario($variableRevisar);
				//$this->busca_criterio_fijo($resultado->genero,2);

			}
		}else if ($tipo_funcion == 7){    //0 es para buscar item por categoria en el catalogo
			if (strpos($variableRevisar,'<strong>') !== false) {
				$posicion_comienzo = strpos($variableRevisar, 'red\'>')+5;
				$posicion_fin = strpos($variableRevisar, '</font>');
				$valor_longitud = $posicion_fin-$posicion_comienzo;
				$valor_extraido = substr($variableRevisar,$posicion_comienzo,$valor_longitud);
				$nombre_colorizado = "<strong><font color='red'>".$this->descripcion_criterio_fijo($num_correlativo, $valor_extraido)."</font></strong>";
				return $nombre_colorizado;

			}else{
				return $this->descripcion_criterio_fijo($num_correlativo, $variableRevisar);

			}
		}

	}// fin de funcion
	public function trae_nombre_grupo($id_grupo=0)
	{
		$valor = '';
		$conn = Yii::app()->db->createCommand();
		$conn->setFetchMode(PDO::FETCH_OBJ);

		$conn->select('descripcion')
				 ->from('sapo_autentica.sapoat_grupo')
				 ->where('id_grupo=:id_grupo', array(':id_grupo'=>$id_grupo));
		foreach($conn->queryAll() as $data)
		{
			$valor = $data->descripcion;
		}
		return $valor;
	}

	public function redirecciona_accion_ficha_criminal($url='',$a_input=array(),$button_titulo='',$tipo_boton=''){

		$forma=	$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'action'=>'index.php?r='.$url,
			'method'=>'post',
			'id'=>'busqueda',
			'type'=>'horizontal',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>false,
			'clientOptions' => array(
					'validateOnSubmit'=>true,
					'validateOnChange'=>true,
					'validateOnType'=>false,
					),
			'htmlOptions' => array('name'=>'busqueda',
									'class'=>'linea_oc'
									),
			));

			foreach ($a_input as $datos){
				foreach($datos as $key => $value){
					?>
					<input type="hidden" name="<? echo $key; ?>" value="<?echo $value;?>" readonly="readonly">
					<?
				}
			}

		$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>"$tipo_boton", 'icon'=>'check', 'label'=>"$button_titulo"));
		$this->endWidget();

	}


	public function consume_transito_multas($tipo='',$placa='')
	{
		#$user = Yii::app()->user->name;

		$swcliente = new SoapClient(null,array("location"=>URL_MULTAS,"uri"=>URL_MULTAS));
		$array_cliente['usuario']=Yii::app()->user->name;
		$array_cliente['cliente']=CLIENTE;
		
		$array_cliente['tipo']=$tipo;
		$array_cliente['placa']=$placa;
		$data = $swcliente->consulta_multas(json_encode($array_cliente));
	/*echo '<br>'; 
		echo '<pre>'; 
		var_dump($data); 
		#print_r($data); 
		echo '</pre>';*/

		return $data;
	}	


} // fin de la clase
