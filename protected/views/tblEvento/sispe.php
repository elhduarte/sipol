<?php 
	
	$WSConsulta = new WSConsulta;

	$primerNombre = "";
	$segundoNombre = "";
	$primerApellido = "";
	$segundoApellido = "";
	$codEmpleado = "";
	$puestoFuncional = "";
	$puestoNominal = "";
	$estado = "";
	$nacimiento = "";
	$dpi = "";
	$nit = "";
	$nip = "";
	$foto = "images/noimagen.png";
	$style = " style='max-width: 60%;'";
	$readonly = "";
	$antiguedad = "";
	$poli = "";
	$alerta = '<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Aviso!</strong> No se encontraron datos con éste NIP
				</div>';
	$titulo = "";

	
		//$nip = $_POST['nip'];
		$nip = '35201';
		$poli = $WSConsulta->ConsultaPersonalPNC($nip);
		$poli = json_decode($poli);
	if(!empty($poli))
	{
		
		
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
		$alerta = "";
		$titulo = "<h4>NIP: ".$nip."</h4>";
		$style = "";
		//$readonly = " readonly";
	}

if($nip !== 0)
{

?>



<div class="container-fluid">
  <div class="row-fluid">
    <div class="span8">
      <!--Sidebar content-->

      <div class="row-fluid">
  <div class="span12">
   <?php echo $titulo; ?> 
   <hr>   
    <div class="row-fluid">
      <div class="span12">
        <b>Nombre: </b><?php echo $primerNombre." ".$segundoNombre." ".$primerApellido." ".$segundoApellido; ?>
      </div>
    </div>
      <div class="row-fluid">
      <div class="span12">
          <b>Estado: </b><?php echo $estado ?>
      </div>
    </div>
      <div class="row-fluid">
      <div class="span12">
          <b>Código de Empleado: </b><?php echo $codEmpleado ?>
      </div>
    </div>
      <div class="row-fluid">
      <div class="span12">
          <b>Puesto Funcional: </b><?php echo $puestoFuncional ?>
      </div>
    </div>
         <div class="row-fluid">
      <div class="span12">
          <b>Rango: </b><?php echo $rango ?>
      </div>
    </div>
         <div class="row-fluid">
      <div class="span12">
          <b>DPI: </b><?php echo $dpi ?>
      </div>
    </div>
     <div class="row-fluid">
      <div class="span12">
          <b>ANTIGUEDAD: </b><?php echo $antiguedad.' años' ?>
      </div>
    </div>
         <div class="row-fluid">
      <div class="span12">
          <b>NIT: </b><?php echo $nit ?>
      </div>
    </div>
  </div>
</div>


    </div>
    <div class="span4">
      <!--Body content-->
    <br>
	<br>
    <hr>
      	<div class="span12" align="center">
      		<img class="imagen_renap" src="data:image/jpg;base64,<?php echo $foto; ?> <?php echo $style; ?>">
      	</div>
    </div>
  </div>
</div>

<?php 

}
else{
	echo '<div class="alert alert-error">
		No se obtuvieron datos del usuario en SISPE.
		</div>';
}

?>


