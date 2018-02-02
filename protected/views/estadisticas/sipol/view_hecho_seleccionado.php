<div class="alert alert-info">
<b><h4><i class="icon-filter"></i> Descripción Filtros de Busqueda:</h4></b>
<div id="titutlo" style="margin-left: 1.5%;">
        <b>Rango de Fechas </b> 
       <br>
       <b>Ubicación de los Hechos ( </b> Departamento: <i><?php echo $departamento; ?></i>, Municipio: <i><?php echo $municipio; ?></i><b> )</b> 
       <br>
       <b>Lugar de Emisión: ( </b> Region: <i><?php echo $region; ?></i>, Comisaria: <i><?php echo $comisaria; ?></i>, Tipo de Sede: <i><?php echo $tipo_sede; ?></i>, Sede: <i><?php echo $sede; ?></i><b> )</b> 
       <br>
       <b>Tipo de Hecho: </b>
</div>
</div>
<div class="row-fluid">
  <div class="span12">
    <div class="row-fluid">
      <div class="span6">

<?php
	$this->renderPartial('sipol/view_grafica_tiempo_hecho_denuncia',
	array(
	'hecho'=>$hecho,
	'tipo'=>$tipo,
	'tiempo'=>$tiempo,
	'departamento'=>$departamento,
	'municipio'=>$municipio,
	'region'=>$region,
	'comisaria'=>$comisaria,
	'tipo_sede'=>$tipo_sede,
	'sede'=>$sede,
	'tipo_hecho'=>$tipo_hecho,
	'estadofecha'=>$estadofecha,
	'fechainicio'=>$fechainicio,
	'fechafinal'=>$fechafinal
	));
?>

      </div>
      <div class="span6">

	<legend>Vista de Mapas</legend>              
	<?php            
		$this->renderPartial('sipol/view_mapas',array(
		'tipo'=>$tipo,
		'tiempo'=>$tiempo,
		'departamento'=>$departamento,
		'municipio'=>$municipio,
		'region'=>$region,
		'comisaria'=>$comisaria,
		'tipo_sede'=>$tipo_sede,
		'sede'=>$sede,
		'tipo_hecho'=>$tipo_hecho,
		'estadofecha'=>$estadofecha,
		'fechainicio'=>$fechainicio,
		'fechafinal'=>$fechafinal,
		'hecho'=>$hecho
		));       
	?>

      </div>
    </div>
  </div>
</div>

