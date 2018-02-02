<?php 
function validarcampo($valor)
 {
  $salida = "";
   if(empty($valor))
      {
         $salida = "Sin Registro"; 
      }else{
          $salida = $valor;
      }
    return $salida; 
 }

  function validarestado($valor)
 {

  $salida = "";
   if($valor == "Activo")
      {
            $salida ="<img id='imagen_estado_sistema' src='images/icons/glyphicons_198_ok.png' rel='popover'  data-content='<center><font color=\"blue\">ACTIVO</font> </center>' data-original-title='<center>Estado del Usuario</center>'>";
      
      }else{
          //$salida = '<strong><font color="red">Desactivado</font> </strong>';
       $salida ="<img id='imagen_estado_sistema' src='images/icons/glyphicons_199_ban.png' rel='popover'  data-content='<center><font color=\"red\">DESACTIVADO</font> </center>' data-original-title='<center>Estado del Usuario</center>'>";
      
      }
    return $salida;
 }
  function validarsexo($valor)
 {
  $salida = "";
   if($valor == "1")
      {
         $salida ='<strong>HOMBRE</strong>';
      }else{
          $salida = '<strong>MUJER</strong>';
      }
    return $salida;
 }
   function validarestadosistema($valor)
 {
  $salida = "";
   if($valor == "1")
      {
         $salida ='<strong><font color="blue">Activo</font> </strong>';
      }else{
          $salida = '<strong><font color="red">Eliminado</font> </strong>';
      }
    return $salida;
 }

  $id_usuario = $_GET['id'];
  $idusuario = $id_usuario ;
  $compilar = new Encrypter;
  $cartausuario = $compilar->compilarget($idusuario);
  $tblusuario = new TblUsuario;
  $usuariodatos = $tblusuario->consulta_usuario_completo($idusuario);
  $puesto = $usuariodatos->puesto;
  $usuario = $usuariodatos->usuario;
  $password = $usuariodatos->password;
  $email = $usuariodatos->email;
  $no_oficio_solicitud = $usuariodatos->no_oficio_solicitud;
  $id_usuario_crea = $usuariodatos->id_usuario_crea;
  $fecha_crea = $usuariodatos->fecha_crea;
  $estado = $usuariodatos->estado;
  $primer_nombre = $usuariodatos->primer_nombre;
  $segundo_nombre = $usuariodatos->segundo_nombre;
  $primer_apellido = $usuariodatos->primer_apellido;
  $segundo_apellido = $usuariodatos->segundo_apellido;
  $fecha_nacimiento = $usuariodatos->fecha_nacimiento;
  $dpi = $usuariodatos->dpi;
  $no_orden = $usuariodatos->no_orden;
  $direccion = $usuariodatos->direccion;
  $departamento = $usuariodatos->departamento;
  $municipio = $usuariodatos->municipio;
  $sexo = $usuariodatos->sexo;
  $no_registro = $usuariodatos->no_registro;
  $foto = $usuariodatos->foto;
  $proceso = $usuariodatos->proceso;
  $nombredepartamento = $usuariodatos->nombredepartamento;
  $nombremunicipio = $usuariodatos->nombremunicipio;
  $nombrerol = $usuariodatos->nombrerol;
  $nombrecomisaria = $usuariodatos->nombrecomisaria;


         if(empty($foto))
        {
          $fotografia = "images/noimagen.png";
          
        }
        else
        {
          
          $fotografia = "data:image/jpg;base64,".$foto;
          
        }     
  $resultadosistemasquery = $tblusuario->consulta_usuario_entidad_completo_usuario_crea($id_usuario_crea);
  $sistemaentidad=$resultadosistemasquery->entidad; 
  $sistemanombre_rol=$resultadosistemasquery->nombre_rol; 
  $sistemaid_usuario=$resultadosistemasquery->id_usuario; 
  $sistemanombre_completo=$resultadosistemasquery->nombre_completo; 
  $sistemaubicacion=$resultadosistemasquery->ubicacion;   
/*CONSUMO DEL SISPE*/ 
  $WSConsulta = new WSConsulta;
  $primerNombre = "";
  $segundoNombre = "";
  $primerApellido = "";
  $segundoApellido = "";
  $codEmpleado = "";
  $puestoFuncional = "";
  $puestoNominal = "";
  $estadosispe = "";
  $nacimiento = "";
  //$dpi = "";
  $nit = "";
  $nip = "";
  $foto = "images/noimagen.png";
  $poli = ""; 
  //$nip = $_POST['nip'];
  $nip = '35201';
  $nip = validarcampo($usuario);
  $poli = $WSConsulta->ConsultaPersonalPNC($usuario);
  if(!empty($poli))
  {
    $poli = json_decode($poli);
    
    
    if($nip== 0){   
      $codEmpleado = "Sin registro";
      $puestoFuncional = "Sin registro";
      $puestoNominal = "Sin registro";
      $estadosispe = "Sin registro";
      $nacimiento = "Sin registro";
      //$dpi = "Sin registro";
      $nit = "Sin registro";
      $nip = "Sin registro";
      $fotosispe = "Sin registro";
      $fotosispe = "images/noimagen.png";
    }else{
   $primerNombre = $poli->n1;
    $segundoNombre = $poli->n2;
    $primerApellido = $poli->a1;
    $segundoApellido = $poli->a2;
    $codEmpleado = $poli->id;
    $puestoFuncional = $poli->puesto;
    $rango = $poli->rango;
    $estado = $poli->activo;
    $nacimiento = $poli->fecha_nacimiento;
    $dpi = $poli->cui;
    $nit = $poli->nit;
    $antiguedad = $poli->antiguedad;
    $nip = $poli->nip;
    $foto = $poli->foto;
      if(empty($fotosispe))
          {
            $fotosispe = "images/noimagen.png";          
          }
          else
          {          
            $fotosispe = "data:image/jpg;base64,".$fotosispe;          
          }
    }   
  }



?>



<style type="text/css">


#slider img {
width: auto; 
    max-width:50%; 
margin:0;
padding:0; 
border:0;
}


#slider p {
/*position: absolute;*/
bottom: 20px;
left: 0;
display: block ;
width: 100%;
height: 24px;
margin:0;
padding: 0px 0;
color: #eee;
background: #0056a3;
font-size: 22px;
line-height:22px;
text-align:center;
}

.vista_imagen
{
  margin: 1px;
    width: auto; 
    max-width:50%; 
    border-radius: 15px 15px 15px 15px; 
   
}
</style>

<style type="text/css">
.table-bordered td{
  vertical-align: middle;
  padding: 2px;
  font: normal 9pt Arial,Helvetica,sans-serif
}
.table-bordered th{
  vertical-align: middle;
  text-align: center;
  padding: 2px;
  font-weight:bold;
  font: normal 9pt Arial,Helvetica,sans-serif
}
</style>



<script type="text/javascript">

$(function(){
    $('#slider div:gt(0)').hide();
    setInterval(function(){
      $('#slider div:first-child').fadeOut(0)
         .next('div').fadeIn(1000)
         .end().appendTo('#slider');}, 4000);
});
</script>







<div class="cuerpo">
  <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
        <div align="center"><img class="vista_imagen"  src='<?php echo $fotografia; ?>'/><p><span class="label label-inverse"><i class="icon-camera icon-white"></i> Fotografia Renap</span></p></div>    
        <div align="center"><img class="vista_imagen" src='<?php echo $fotosispe; ?>'  alt="banner2" /><p><span class="label label-inverse"><i class="icon-camera icon-white"></i> Fotografia SISPE</span></p></div>
        <hr>

        <div style="height: 90px;"></div>
        <div align="center" id="imagen_estado_responsable" rel="popover"  data-content="<center><?php echo $sistemanombre_completo; ?>  </center>" data-original-title="<center>Usuario Responsable</center>"></div>


      </div>
        <div class="span10">
          <div id="estados_sistema" class="pull-right">
                <?php echo validarestado($estado); ?>
              </div>
        <div class="row-fluid">
            <div class="span12">                
              <legend><strong>Usuario: </strong> <?php echo $primer_nombre." ".$segundo_nombre ." ".$primer_apellido ." ".$segundo_apellido;  ?>    
              
              </legend>

            <div class="row-fluid">
                <div class="span4">
               <table class="table table-striped">
                <caption><h4>Información Personal</h4></caption>
                <thead>
                  <tr>
                   <th style="width: 35%;"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                   <tr>
                    <td><strong><i class="icon- icon-info-sign"></i> CUI:</strong></td>
                    <td><?php echo validarcampo($dpi); ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon- icon-gift"></i> Fecha:</strong></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime(validarcampo($fecha_nacimiento))); ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon- icon-flag"></i> Departamento:</strong></td>
                    <td> <?php echo validarcampo($nombredepartamento); ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon- icon-flag"></i> Municipio:</strong></td>
                    <td><?php echo validarcampo($nombremunicipio); ?></td>
                  </tr>
                    <tr>
                    <td><strong><i class="icon- icon-info-sign"></i> Genero:</strong></td>
                    <td><?php echo validarsexo($sexo); ?></td>
                  </tr>   
                   <tr>
                    <td><strong><i class="icon- icon-tags"></i> Direccion:</strong></td>
                    <td><?php echo validarcampo($direccion); ?></td>
                  </tr>
                  <tr>
                    <td><strong><i class="icon- icon-print"></i> Carta: </strong></td>
                    <td><?php echo "<a href='index.php?r=tblUsuario/Responsabilidad&carta=".$cartausuario."' target='_blank'>Responsabilidad</i></a>"; ?>  </td>
                  </tr>
                </tbody>
              </table>
                </div>
                <div class="span4">
                 <table class="table table-striped">
                  <caption><h4>Información SIPOL</h4></caption>
                <thead>
                  <tr>
                     <th style="width: 35%;"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> Rol:</strong></td>
                    <td><?php echo $nombrerol; ?></td>
                  </tr>
                  <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> Puesto:</strong></td>
                    <td><?php echo validarcampo($puesto); ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon- icon-user"></i> Usuario:</strong></td>
                    <td><?php echo validarcampo($usuario); ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon- icon-envelope"></i> Correo:</strong></td>
                    <td><?php echo validarcampo($email); ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon- icon-map-marker"></i> Sede:</strong></td>
                    <td> <?php echo $nombrecomisaria; ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> Celular:</strong></td>
                    <td><?php echo validarcampo($no_orden); ?></td>
                  </tr>
                    <tr>
                      <td><strong><i class="icon- icon-calendar"></i> Ingreso:</strong></td>
                      <td><?php   echo date("d-m-Y H:i:s",strtotime(validarcampo($fecha_crea))); ?></td>
                  </tr>
                  <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> Sistema:</strong></td>
                    <td><?php echo validarestadosistema($proceso); ?></td>
                  </tr>
                
                </tbody>
              </table>
                </div>
                <div class="span4">
                 <table class="table table-striped">
                  <caption><h4>Información SISPE</h4></caption>
                <thead>
                  <tr>
                      <th style="width: 45%;"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                   <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> NIP:</strong></td>
                    <td><?php echo $nip; ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon- icon-barcode"></i> Codigo Empleado:</strong></td>
                    <td><?php echo $codEmpleado; ?></td>
                  </tr>
                  <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> Puesto Funcional:</strong></td>
                    <td><?php echo $puestoFuncional; ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> Puesto Nominal:</strong></td>
                    <td><?php echo $rango; ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> Estado:</strong></td>
                    <td><?php echo $estadosispe; ?></td>
                  </tr>
                   <tr>
                    <td><strong><i class="icon-  icon-info-sign"></i> NIT:</strong></td>
                    <td> <?php echo $nit; ?></td>
                  </tr>      
                </tbody>
              </table>
              <br>
              <div id="botonreporte" style="text-align: right;"> 
                <a href="index.php?r=reportespdf/usuario&nip=<?php echo $cartausuario; ?>" target="_blank" class="btn btn-primary">Generar Reporte</a>
              </div>

                </div>


            </div>
            </div>
        </div>
        </div>
      </div>
  </div>

<legend></legend>


</div>

<script> 
$(function ()  
{ 
  $("#imagen_estado_sistema").popover(
    {
      placement:'left',
      html: true
    });

  $('#imagen_estado_sistema').popover('show');

  $("#imagen_estado_responsable").popover(
    {
      placement:'top',
      html: true
    });

  $('#imagen_estado_responsable').popover('show');




  
});  
</script> 
<div class='cuerpo'>
<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6">
        <h4>Información del sistema</h4>
        <div class="row-fluid">


      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th><h6>Información</h6></th>
            <th><h6>Conteo</h6></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Total Ingresos Sistema</td>
            <td><?php echo $tblusuario->conteo_ingreso_sistema($id_usuario); ?></td>
          </tr>
          <tr>
            <td>Total de Tickets</td>
            <td><?php echo $tblusuario->conteo_ticket_sistema($id_usuario); ?></td>
          </tr>
          <tr>
            <td>Total de Sugerencias</td>
             <td><?php echo $tblusuario->conteo_sugerencia_sistema($id_usuario); ?></td>
          </tr> 
          <tr>
            <td>Total de Denuncias Activas</td>
            <td><?php echo $tblusuario->conteo_denuncia_activa_sistema($id_usuario); ?></td>
          </tr>
          <tr>
            <td>Total de Denuncias Inactivas</td>
           <td><?php echo $tblusuario->conteo_denuncia_inactiva_sistema($id_usuario); ?></td>
          </tr>
          <tr>
            <td>Total de Extravios Activos</td>
            <td><?php echo $tblusuario->conteo_extravio_activa_sistema($id_usuario); ?></td>
          </tr>
          <tr>
            <td>Total de Extravios Inactivos</td>
            <td><?php echo $tblusuario->conteo_extravio_inactiva_sistema($id_usuario); ?></td>
          </tr>
            <tr>
            <td>Total de Incidencias Activas </td>
            <td><?php echo $tblusuario->conteo_incidencia_activa_sistema($id_usuario); ?></td>
          </tr>
            <tr>
            <td>Total de Incidencias Inactivas</td>
            <td><?php echo $tblusuario->conteo_incidencia_inactiva_sistema($id_usuario); ?></td>
          </tr>
        </tbody>
      </table>


        </div>
      </div>
      <div class="span6">
        <h4>Información de comsumos</h4>

          <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th><h6>Información</h6></th>
            <th><h6>Conteo</h6></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Consulta DPI Nombre </td>
           <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,1); ?></td>
          </tr>
          <tr>
            <td>Consulta Indice DPI</td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,2); ?></td>
          </tr>
          <tr>
            <td>Consulta DPI </td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,3); ?></td>
          </tr>
          <tr>
            <td>Consulta Orden Captura Nombre</td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,4); ?></td>
          </tr>
          <tr>
            <td>Consulta Licencia Nombre </td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,5); ?></td>
          </tr>
          <tr>
            <td>Consulta Vehiculo Preliminar</td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,6); ?></td>
          </tr>
          <tr>
            <td>Consulta Vehiculo Placa Transito </td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,7); ?></td>
          </tr>
            <tr>
            <td>Consulta Novedades </td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,8); ?></td>
          </tr>
            <tr>
            <td>Consulta Persona PNC</td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,9); ?></td>
          </tr>
          <tr>
            <td>Consulta Vehiculo Placa </td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,10); ?></td>
          </tr>
            <td>Envio SMS</td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,11); ?></td>
          </tr>
             <tr>
            <td>Ingreso Denuncia MP</td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,12); ?></td>
          </tr>
             <tr>
            <td>Consulta Patrulla</td>
            <td><?php echo $tblusuario->conteo_consumo_sistema($id_usuario,13); ?></td>
          </tr>
        </tbody>
      </table>

      </div>
    </div>
  </div>
</div>


</div>
<div id="combo_reportes">
</div>
<script src="lib/highcharts/Highstock-1.3.5/js/highstock.js"></script>
<script src="lib/highcharts/Highstock-1.3.5/js/modules/exporting.js"></script>
