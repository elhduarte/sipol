<?php
 function validarestado($valor)
 {

  $salida = "";
   if($valor == "1")
      {
      	     $salida ='<strong><font color="blue">Activo</font> </strong>';
      }else{
          //$salida = '<strong><font color="red">Desactivado</font> </strong>';
      $salida = '<strong><font color="red">Inactivo</font> </strong>';
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


$tblusuario = new TblUsuario;
$usuariodatos = $tblusuario->consulta_usuario_completo_dpi($numerodpi);

	$puesto = $usuariodatos->puesto;
	$usuario = $usuariodatos->usuario;
	$estado = $usuariodatos->estado;
	$primer_nombre = $usuariodatos->primer_nombre;
	$segundo_nombre = $usuariodatos->segundo_nombre;
	$primer_apellido = $usuariodatos->primer_apellido;
	$segundo_apellido = $usuariodatos->segundo_apellido;
	$foto = $usuariodatos->foto;
	$proceso = $usuariodatos->proceso;
	$nombrerol = $usuariodatos->nombrerol;
	$nombrecomisaria = $usuariodatos->nombrecomisaria;
	$nombrecompleto = $primer_nombre." ".$segundo_nombre." ".$primer_apellido." ".$segundo_apellido;
?>



<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<h4><img src="images/icons/glyphicons_195_circle_info.png"> Información del Sistema! Usuario Registrado</h4>
<blockquote>
<small><cite title="Source Title"><b>Numero DPI:</b> <?php echo $numerodpi; ?>.</cite></small>
<small><cite title="Source Title"><b>Nombre Completo: </b><?php echo $nombrecompleto; ?>.</cite></small>
<small><cite title="Source Title"><b>Puesto:</b> <?php echo $puesto; ?>.</cite></small>
<small><cite title="Source Title"><b>Rol:</b> <?php echo $nombrerol; ?>.</cite></small>
<small><cite title="Source Title"><b>Sede:</b> <?php echo $nombrecomisaria; ?>.</cite></small>
<small><cite title="Source Title"><b>Estado de Sipol: </b><?php echo validarestado($estado); ?>.</cite></small>
<small><cite title="Source Title"><b>Estado del Sistema:</b> <?php echo validarestadosistema($proceso); ?>.</cite></small>

</blockquote>
</div>

				





<?php
echo '<script type="text/javascript">
$(document).ready(function(){
$("#formulariobusquedadpi").html("");
});';	
$this->renderPartial('buscardpi');
?>