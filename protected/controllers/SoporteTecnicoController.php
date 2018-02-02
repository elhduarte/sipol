<?php
class SoporteTecnicoController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	/**}
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
	 return array(
		 array('allow', // allow all users to perform 'index' and 'view' actions
		 'actions'=>array('NuevoTicket','AdminTicket','AdminTicketEliminados','ChatEliminados'),
			 'users'=>array('root', 'developer','soporte'),
		 ),
		 array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 'actions'=>array('NuevoTicket','AbrirTicket','Buzon'),
		 'users'=>array('@'),
		 ),
		  array('allow', // allow authenticated user to perform 'create' and 'update' actions
		 'actions'=>array('Index','AdminMovil','Chat','VerChat','InsertarMensaje','ActualizarModulo','TerminarChat','Sugerencias','EnviarSugerencia','ChatMsn'),
		 'users'=>array('*'),
		 ),			
		 array('deny', // deny all users
		 'users'=>array('*'),
		 ),
	 );
	}	
	public function actionActualizarModulo()
	{

		$Criteria = new CDbCriteria();
		$Criteria->condition = 'id_aplicacion='.$_POST['aplicacion'];
		$Criteria->order ='nombre_modulo ASC';
			$data=CatModulos::model()->findAll($Criteria);
	       $data=CHtml::listData($data,'id_modulo','nombre_modulo');
	       $contador = '0';
	       foreach($data as $value=>$name)
	       {
	           if($contador =='0')
	           {
	           	echo CHtml::tag('option', array('value'=>'', 'style'=>'display:none;'),CHtml::encode('Seleccione un Modulo'),true);
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }else
	           {
	           	echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	           }
	        $contador = 1;
	       }
			//$this->render('nuevoticket');
	}
	public function actionTerminarChat()
	{
			$id_ticket =$_POST['idticket']; 
			$id_usuario= $_POST['idusuario'];
			$correoticket = new EnvioCorreo;
			$correoticket->terminachatcabeza($id_ticket,$id_usuario);
			$enviomsn = new WSConsulta;
			$enviomsn->EnviarMensajeTexto('30249817','Ticket Terminado: '.$id_ticket);
			
		$sql = "UPDATE soporte_aplicaciones.tbl_ticket  SET estado = 'false', id_usuario_elimina =".$id_usuario."
 WHERE id_ticket=".$id_ticket.";";
		$resultado = Yii::app()->db->createCommand($sql)->execute();

	}
	public function actionNuevoTicket()
	{
			$this->render('nuevoticket');
	}
	public function actionAdminTicket()
	{
			$this->render('adminticket');
	}	
	public function actionAdminTicketEliminados()
	{
			$this->render('adminticketeliminados');
	}	
	public function actionBuzon()
	{
			$this->render('buzon');
	}	
	public function actionInsertarMensaje()
	{

				$id_ticket =$_POST['idticket']; 
				$id_usuario= $_POST['idusuario']; 
				$inconveniente= $_POST['inconveniente']; 
			
			$modelodetalleticket = new TblDetalleTicket;	
			$modelodetalleticket->attributes= array(
				'id_ticket'=>$id_ticket,
				'id_usuario'=>$id_usuario,
				'seguimiento'=>$inconveniente,
				);
			$modelodetalleticket->save();	
				//$this->renderPartial('chat');
		$trasladoconversacion = "";
		$valor =$_POST['idticket']; 
		$usuariologin = $_POST['idusuario']; 
		$sql = "SELECT  a.*, b.primer_nombre || ' ' ||  b.primer_apellido as usuario
		FROM 
		soporte_aplicaciones.tbl_detalle_ticket as a, sipol_usuario.tbl_usuario as b
		WHERE 
		a.id_ticket = ".$valor." 
		and
		b.id_usuario = a.id_usuario
		order by a.id_detalle_ticket asc";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		$variablearray = "";
		$chatusuariocolor ="";
		foreach($resultado as $key => $value)
			{
				$conversacion = json_encode($value);
				$conversacion = json_decode($conversacion);
				$hora_atencion = explode(".", $conversacion->hora_atencion);
				if($conversacion->id_usuario==$usuariologin){
					$chatusuariocolor ="<strong class='usuarioroot'>".$conversacion->usuario.": </strong>";

				}else{
					$chatusuariocolor ="<strong class='usuario'>".$conversacion->usuario.": </strong>";
				}	
	$trasladoconversacion = $trasladoconversacion.'<blockquote>
		   <small><cite title="Source Title">'.$chatusuariocolor.'</cite></small>
		  <small><cite title="Source Title"><strong class="hora">'.$hora_atencion[0].'</strong> '.$conversacion->seguimiento.'</cite></small>
		</blockquote>';
			}
			echo $trasladoconversacion;


			//$this->render('insertarmensaje');
	}
	public function actionChat()
	{
			$this->renderPartial('chat');
	}
	public function actionChatEliminados()
	{
			$this->render('chateliminados');
	}
	public function actionVerChat()
	{
			//$this->renderPartial('chat');
		
		$trasladoconversacion = "";
		$valor =$_POST['idticket']; 
		$usuariologin = $_POST['idusuario']; 
		$sql = "SELECT  a.*, b.primer_nombre || ' ' ||  b.primer_apellido as usuario
		FROM 
		soporte_aplicaciones.tbl_detalle_ticket as a, sipol_usuario.tbl_usuario as b
		WHERE 
		a.id_ticket = ".$valor." 
		and
		b.id_usuario = a.id_usuario
		order by a.id_detalle_ticket asc";
		$resultado = Yii::app()->db->createCommand($sql)->queryAll();
		$variablearray = "";
		$chatusuariocolor ="";
		foreach($resultado as $key => $value)
			{
				$conversacion = json_encode($value);
				$conversacion = json_decode($conversacion);
				$hora_atencion = explode(".", $conversacion->hora_atencion);
				if($conversacion->id_usuario==$usuariologin){
					$chatusuariocolor ="<strong class='usuarioroot'>".$conversacion->usuario.": </strong>";

				}else{
					$chatusuariocolor ="<strong class='usuario'>".$conversacion->usuario.": </strong>";
				}	
	$trasladoconversacion = $trasladoconversacion.'<blockquote>
		   <small><cite title="Source Title">'.$chatusuariocolor.'</cite></small>
		  <small><cite title="Source Title"><strong class="hora">'.$hora_atencion[0].'</strong> '.$conversacion->seguimiento.'</cite></small>
		</blockquote>';
			}
			echo $trasladoconversacion;

	}
	public function actionAbrirTicket()
	{
		$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
		$id_usuario = $variable_datos_usuario[0]->id_usuario;
		$id_prioridad =$_POST['id_prioridad']; 
		$inconveniente= $_POST['inconveniente']; 
		$telefono = $_POST['telefono']; 
		$modeloticket = new TblTicket;	
			$modeloticket->attributes= array(
				'id_usuario'=>$id_usuario,
				'id_prioridad'=>$id_prioridad,
				'inconveniente'=>$inconveniente,
				'telefono'=>$telefono,
				);
			$modeloticket->save();	

			/*$correoticket = new EnvioCorreo;
			$correoticket->ticketchat($inconveniente,$telefono);*/

			$decrypt = new Encrypter;			
			$chatencriptado = $decrypt->compilarget("'".$modeloticket->id_ticket."'");			
			$resultadoretorno = "index.php?r=SoporteTecnico/Chat&par=".$chatencriptado;

			$modelodetalleticket = new TblDetalleTicket;	
			$modelodetalleticket->attributes= array(
				'id_ticket'=>$modeloticket->id_ticket,
				'id_usuario'=>$id_usuario,
				'seguimiento'=>$inconveniente,
				);
			$modelodetalleticket->save();	
			

			$correoticket = new EnvioCorreo;
			$correoticket->correoSoporteTecnico('alejandropr1@gmail.com;mingob.correo@gmail.com;hugoduarteq@gmail.com;alejandropr1@gmail.com;hugoduarteq@gmail.com', 'Se ha abierto un nuevo chat', 'Un nuevo chat se ha abierto con el numero de ticket:'.$modeloticket->id_ticket);	
			#$correoticket->correoSoporteTecnico('mingob.correo@gmail.com', 'Se ha abierto un nuevo chat', 'Un nuevo chat se ha abierto con el numero de ticket:'.$modeloticket->id_ticket);	
			/*Envio de Mensaje de texto cuando ingresa un nuevo ticket*/	

			$enviomsn = new WSConsulta;
			$decrypt = new Encrypter;
			$chatencriptado = $decrypt->compilarget("'".$modeloticket->id_ticket."'");
			$rutaurlparachat = "/soporteTecnico/chatmsn%26par=";
			$rutaurlparachat =  Yii::app()->createUrl($rutaurlparachat);	
			$enviomsn->EnviarMensajeTexto('30249817','Juan Fernando, Nuevo ticket '.$modeloticket->id_ticket.'. Ingresa: '.$rutaurlparachat.''.$chatencriptado.'');

			echo  $resultadoretorno;
	}

	public function actionChatMsn()
	{
			$this->renderPartial('chatmsn');
	}

	public function actionAdminMovil()
	{
		$this->renderPartial('adminmovil');
	}	
		public function actionEnviarSugerencia()
	{
			$sugerencia =$_POST['sugerencia']; 
			$id_usuario= $_POST['idusuario'];
			$url = $_POST['url']; 
			/*$sugerencia ="Esta es la Sugerencia"; 
			$id_usuario= 255;*/

				$modelo_sugerencia = new TblSugerencia;	
			$modelo_sugerencia->attributes= array(
				'sugerencia'=>$sugerencia,
				'url_sugerencia'=>$url,
				'id_usuario'=>$id_usuario,
				);
			$modelo_sugerencia->save();	
			$correoticket = new EnvioCorreo;
			$correoticket->enviarsugerencia($sugerencia,$id_usuario);
			$enviomsn = new WSConsulta;
			$enviomsn->EnviarMensajeTexto('30249817','Lester, Existe una nueva sugerencia para SIPOL.');
			
	}
}

