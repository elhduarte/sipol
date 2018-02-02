<?php
if ($evento == "Denuncias") {
	
	$id_evento ="1";
} else if($evento == "Extravios") {
	# code...
	$id_evento ="3";
}else if($evento == "Incidencias") {
	# code...
	$id_evento ="2";
}else{
	$id_evento = "4";
}
function validarconteo($entrada)
{
if($entrada == "")
{
  return "0";
}else{
 //$entrada ="<strong>".$entrada."</strong>";
  return $entrada;
}
}

function validarconteotablageneral($entrada)
{
if($entrada == "")
{
  return "0";
}else{
 $entrada ="<strong>".$entrada."</strong>";
  return $entrada;
}
}

$modeloestadistica= new Estadisticas();
$resultado = $modeloestadistica->TablaDenunciasActivas($id_evento, $tiempo);
$contado = 1;
$tablaprueba="";
 $tablaprueba_original ="";
foreach ($resultado as $key => $value) 
{

$tablaprueba_original = "
<tr>
<td style='text-align: left;'>Nombre-nombre_hecho".$contado."</td>
<td>a-jan".$contado."a</td>
<td>b-jan".$contado."</td>
<td>c-jan".$contado."c</td>

<td>a-feb".$contado."a</td>
<td>b-feb".$contado."</td>
<td>c-feb".$contado."c</td>

<td>a-mar".$contado."a</td>
<td>b-mar".$contado."</td>
<td>c-mar".$contado."c</td>

<td>a-apr".$contado."a</td>
<td>b-apr".$contado."</td>
<td>c-apr".$contado."c</td>

<td>a-may".$contado."a</td>
<td>b-may".$contado."</td>
<td>c-may".$contado."c</td>

<td>a-jun".$contado."a</td>
<td>b-jun".$contado."</td>
<td>c-jun".$contado."c</td>

<td>a-jul".$contado."a</td>
<td>b-jul".$contado."</td>
<td>c-jul".$contado."c</td>

<td>a-aug".$contado."a</td>
<td>b-aug".$contado."</td>
<td>c-aug".$contado."c</td>

<td>a-sep".$contado."a</td>
<td>b-sep".$contado."</td>
<td>c-sep".$contado."c</td>

<td>a-oct".$contado."a</td>
<td>b-oct".$contado."</td>
<td>c-oct".$contado."c</td>

<td>a-nov".$contado."a</td>
<td>b-nov".$contado."</td>
<td>c-nov".$contado."c</td>

<td>a-dec".$contado."a</td>
<td>b-dec".$contado."</td>
<td>c-dec".$contado."c</td>

</tr>";


  # code...
  $json = json_encode($value);
  $json = json_decode($json);
  $tablaprueba_original = str_replace("Nombre-nombre_hecho".$contado, $json->nombre_hecho, $tablaprueba_original);
  $tablaprueba_original = str_replace("b-jan".$contado, validarconteotablageneral($json->jan), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-feb".$contado, validarconteotablageneral($json->feb), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-mar".$contado, validarconteotablageneral($json->mar), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-apr".$contado, validarconteotablageneral($json->apr), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-may".$contado, validarconteotablageneral($json->may), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-jun".$contado, validarconteotablageneral($json->jun), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-jul".$contado, validarconteotablageneral($json->jul), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-aug".$contado, validarconteotablageneral($json->aug), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-sep".$contado, validarconteotablageneral($json->sep), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-oct".$contado, validarconteotablageneral($json->oct), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-nov".$contado, validarconteotablageneral($json->nov), $tablaprueba_original);
  $tablaprueba_original = str_replace("b-dec".$contado, validarconteotablageneral($json->dec), $tablaprueba_original);

$contado = $contado +1;

  $tablaprueba =  $tablaprueba.$tablaprueba_original;
  $tablaprueba_original = $tablaprueba;
}




$resultado = $modeloestadistica->TablaIngresosSistema($tiempo);


$conteoingresonuevo = 1;
foreach ($resultado as $key => $value) 
{/*
  var_dump($conteoingresonuevo);
  var_dump($tablaprueba_original);

  $t = str_replace("a-jan".$conteoingresonuevo, validarconteo($json->jan), $tablaprueba_original);
*/
  $json = json_encode($value);
  $json = json_decode($json);
  //print_r($json);
  //$tablaprueba_original = str_replace("Nombre-nombre_hecho".$conteoingresonuevo."", $json->nombre_hecho, $tablaprueba_original);
  $tablaprueba_original = str_replace("a-jan".$conteoingresonuevo."a", validarconteotablageneral($json->jan), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-feb".$conteoingresonuevo."a", validarconteotablageneral($json->feb), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-mar".$conteoingresonuevo."a", validarconteotablageneral($json->mar), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-apr".$conteoingresonuevo."a", validarconteotablageneral($json->apr), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-may".$conteoingresonuevo."a", validarconteotablageneral($json->may), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-jun".$conteoingresonuevo."a", validarconteotablageneral($json->jun), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-jul".$conteoingresonuevo."a", validarconteotablageneral($json->jul), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-aug".$conteoingresonuevo."a", validarconteotablageneral($json->aug), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-sep".$conteoingresonuevo."a", validarconteotablageneral($json->sep), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-oct".$conteoingresonuevo."a", validarconteotablageneral($json->oct), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-nov".$conteoingresonuevo."a", validarconteotablageneral($json->nov), $tablaprueba_original);
  $tablaprueba_original = str_replace("a-dec".$conteoingresonuevo."a", validarconteotablageneral($json->dec), $tablaprueba_original);

$conteoingresonuevo = $conteoingresonuevo +1;

}

  //tablaprueba_original = $tablaprueba;
  $tablaprueba = $tablaprueba_original;

  

$resultado = $modeloestadistica->TablaDenunciasInactivas($id_evento, $tiempo);

$conteoingresonuevo = 1;
foreach ($resultado as $key => $value) 
{/*
  var_dump($conteoingresonuevo);
  var_dump($tablaprueba_original);

  $t = str_replace("a-jan".$conteoingresonuevo, validarconteo($json->jan), $tablaprueba_original);
*/
  $json = json_encode($value);
  $json = json_decode($json);
  //print_r($json);
  //$tablaprueba_original = str_replace("Nombre-nombre_hecho".$conteoingresonuevo."", $json->nombre_hecho, $tablaprueba_original);
  $tablaprueba_original = str_replace("c-jan".$conteoingresonuevo."c", validarconteotablageneral($json->jan), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-feb".$conteoingresonuevo."c", validarconteotablageneral($json->feb), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-mar".$conteoingresonuevo."c", validarconteotablageneral($json->mar), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-apr".$conteoingresonuevo."c", validarconteotablageneral($json->apr), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-may".$conteoingresonuevo."c", validarconteotablageneral($json->may), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-jun".$conteoingresonuevo."c", validarconteotablageneral($json->jun), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-jul".$conteoingresonuevo."c", validarconteotablageneral($json->jul), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-aug".$conteoingresonuevo."c", validarconteotablageneral($json->aug), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-sep".$conteoingresonuevo."c", validarconteotablageneral($json->sep), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-oct".$conteoingresonuevo."c", validarconteotablageneral($json->oct), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-nov".$conteoingresonuevo."c", validarconteotablageneral($json->nov), $tablaprueba_original);
  $tablaprueba_original = str_replace("c-dec".$conteoingresonuevo."c",validarconteotablageneral($json->dec), $tablaprueba_original);

$conteoingresonuevo = $conteoingresonuevo +1;

}
  $tablaprueba = $tablaprueba_original;
?>
<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
    <li><a href="#tab2" data-toggle="tab">Graficas</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">

        <div class="row-fluid">
                    <div class="span12">
                      <div class="row-fluid">
                        <div class="span12 ">

                        	<blockquote>
<p>Información Sobre <?php echo $evento; ?> Tabla General</p>
<small>C: <cite title="Source Title">Sumatoria de Ingresos al Sistema</cite></small>
<small>A: <cite title="Source Title">Sumatoria Denuncias Activas</cite></small>
<small>I: <cite title="Source Title">Sumatoria Denuncias Inactivas</cite></small>
</blockquote>
<table class="table table-striped table-bordered">
<tr>   
<th rowspan="3" style="font-weight: bold;" >Nombre de Sede</th>
<th colspan="3"  style="font-weight: bold;">Enero</th>
<th colspan="3" style="font-weight: bold;" >Febrero</th>
<th colspan="3" style="font-weight: bold;" >Marzo</th>
<th colspan="3" style="font-weight: bold;" >Abril</th>
<th colspan="3" style="font-weight: bold;">Mayo</th>
<th colspan="3" style="font-weight: bold;">Junio</th>
<th colspan="3" style="font-weight: bold;">Julio</th>
<th colspan="3" style="font-weight: bold;">Agosto</th>
<th colspan="3" style="font-weight: bold;">Septiembre</th>
<th colspan="3" style="font-weight: bold;">Octubre</th>
<th colspan="3" style="font-weight: bold;">Noviembre</th>
<th colspan="3" style="font-weight: bold;">Diciembre</th>   
</tr>
<tr >
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
<td rowspan="2" style="font-weight: bold;">C</td>
<td colspan="2" style="font-weight: bold;">Denuncias</td>
</tr>
<tr>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
<td style="font-weight: bold;">A</td>
<td style="font-weight: bold;">I</td>
</tr>
<?php echo $tablaprueba; ?>
</table>        
    </div>
  </div>
</div>
</div>

    </div>
    <div class="tab-pane" id="tab2">
    	<?php

    	if($id_evento=="2" ||  $id_evento=="3" || $id_evento == "4")
    	{
 echo "<center><div class='page-header'>
  <h3>Información del Sistema! <small> Por el momento seguimos trabajando en estas graficas</small></h3>
</div></center>";
    	}else{

$table_contra_vida="<table class='table table-striped table-bordered table-hover'>
  <thead>
    <tr>
      <th>Nombre Hecho</th>
      <th>Ene</th>
      <th>Feb</th>
      <th>Mar</th>
      <th>Abr</th>
      <th>May</th>
      <th>Jun</th>
      <th>Jul</th>
      <th>Ago</th>
      <th>Sep</th>
      <th>Oct</th>
      <th>Nov</th>
      <th>Dic</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>";
$resultado = $modeloestadistica->TablaGraficauno($tiempo);
$total_vida = 0;
$series_vida = "[";
$Enero= 0;
$Febrero= 0;
$Marzo= 0;
$Abril= 0;
$Mayo= 0;
$Junio= 0;
$Julio= 0;
$Agosto= 0;
$Septiembre= 0;
$Octubre= 0;
$Noviembre= 0;
$Diciembre= 0;
foreach ($resultado as $key => $value) 
{
	# code...
	$json = json_encode($value);
	$json = json_decode($json);
	$total =  $json->jan+$json->feb+$json->mar+$json->apr+$json->may+$json->jun+$json->jul+$json->aug+$json->sep+$json->oct+$json->nov+$json->nov+$json->dec;
 	$table_contra_vida = $table_contra_vida."<tr>
	<td>".$json->nombre_hecho."</td>
	<td style='text-align: center;'>".validarconteo($json->jan)."</td>
	<td style='text-align: center;'>".validarconteo($json->feb)."</td>
	<td style='text-align: center;'>".validarconteo($json->mar)."</td>
	<td style='text-align: center;'>".validarconteo($json->apr)."</td>
	<td style='text-align: center;'>".validarconteo($json->may)."</td>
	<td style='text-align: center;'>".validarconteo($json->jun)."</td>
	<td style='text-align: center;'>".validarconteo($json->jul)."</td>
	<td style='text-align: center;'>".validarconteo($json->aug)."</td>
	<td style='text-align: center;'>".validarconteo($json->sep)."</td>
	<td style='text-align: center;'>".validarconteo($json->oct)."</td>
	<td style='text-align: center;'>".validarconteo($json->nov)."</td>
	<td style='text-align: center;'>".validarconteo($json->dec)."</td>
	<td style='text-align: center;'>".validarconteo($total)."</td>
	</tr>";
	$total_vida = $total_vida+validarconteo($total);

	$series_vida = $series_vida." {
                name: '".$json->nombre_hecho."',
                data: [
                ".validarconteo($json->jan).",
                ".validarconteo($json->feb).",
                ".validarconteo($json->mar).",
                ".validarconteo($json->apr).",
                ".validarconteo($json->may).",
                ".validarconteo($json->jun).",
                ".validarconteo($json->jul).",
                ".validarconteo($json->aug).",
                ".validarconteo($json->sep).",
                ".validarconteo($json->oct).",
                ".validarconteo($json->nov).",
                ".validarconteo($json->dec)." 
                ]
            },";

$Enero= $Enero + validarconteo($json->jan);
$Febrero= $Febrero + validarconteo($json->feb);
$Marzo= $Marzo + validarconteo($json->mar);
$Abril= $Abril + validarconteo($json->apr);
$Mayo= $Mayo + validarconteo($json->may);
$Junio= $Junio + validarconteo($json->jun);
$Julio= $Julio + validarconteo($json->jul);
$Agosto= $Agosto + validarconteo($json->aug);
$Septiembre= $Septiembre + validarconteo($json->sep);
$Octubre= $Octubre + validarconteo($json->oct);
$Noviembre= $Noviembre + validarconteo($json->nov);
$Diciembre= $Diciembre + validarconteo($json->dec);
}
$series_vida = $series_vida."&";
$series_vida = str_replace("},&", "}]",$series_vida);
//echo $series_vida;
$totales_entrada = "<tr><td>Totales</td>
	<td style='text-align: center;'>".$Enero."</td>
	<td style='text-align: center;'>".$Febrero."</td>
	<td style='text-align: center;'>".$Marzo."</td>
	<td style='text-align: center;'>".$Abril."</td>
	<td style='text-align: center;'>".$Mayo."</td>
	<td style='text-align: center;'>".$Junio."</td>
	<td style='text-align: center;'>".$Julio."</td>
	<td style='text-align: center;'>".$Agosto."</td>
	<td style='text-align: center;'>".$Septiembre."</td>
	<td style='text-align: center;'>".$Octubre."</td>
	<td style='text-align: center;'>".$Noviembre."</td>
	<td style='text-align: center;'>".$Diciembre."</td>
	<td style='text-align: center;'>".$total_vida."</td>
	</tr>";
$series_vida_pie = "[['Enero',".$Enero."],{
                        name: 'Febrero',
                        y: ".$Febrero.",
                        sliced: true,
                        selected: true
                    },['Marzo',".$Marzo."],['Abril',".$Abril."],['Mayo',".$Mayo."],['Junio',".$Junio."],['Julio',".$Julio."],['Agosto',".$Agosto."],
                    ['Septiembre',".$Septiembre."],
                    ['Octubre',".$Octubre."],
                    ['Noviembre',".$Noviembre."],
                    ['Diciembre',".$Diciembre."]
]";
//echo $series_vida_pie;
$fin_table_contra_vida ="</tbody></table>";
$tabla_salida_table_contra_vida = $table_contra_vida.$totales_entrada.$fin_table_contra_vida;

$resultado = $modeloestadistica->TablaGraficaDos($tiempo);


$table_contra_patrimoniales="<table class='table table-striped table-bordered table-hover'>
  <thead>
    <tr>
      <th>Nombre Hecho</th>
      <th>Ene</th>
      <th>Feb</th>
      <th>Mar</th>
      <th>Abr</th>
      <th>May</th>
      <th>Jun</th>
      <th>Jul</th>
      <th>Ago</th>
      <th>Sep</th>
      <th>Oct</th>
      <th>Nov</th>
      <th>Dic</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>";
 
$total_patrimoniales = 0;
$series_patrimoniales = "[";

$Enero= 0;
$Febrero= 0;
$Marzo= 0;
$Abril= 0;
$Mayo= 0;
$Junio= 0;
$Julio= 0;
$Agosto= 0;
$Septiembre= 0;
$Octubre= 0;
$Noviembre= 0;
$Diciembre= 0;
foreach ($resultado as $key => $value) 
{
	# code...
	$json = json_encode($value);
	$json = json_decode($json);
	$total =  $json->jan+$json->feb+$json->mar+$json->apr+$json->may+$json->jun+$json->jul+$json->aug+$json->sep+$json->oct+$json->nov+$json->nov+$json->dec;
	$table_contra_patrimoniales = $table_contra_patrimoniales."<tr>
	<td>".$json->nombre_hecho."</td>
	<td style='text-align: center;'>".validarconteo($json->jan)."</td>
	<td style='text-align: center;'>".validarconteo($json->feb)."</td>
	<td style='text-align: center;'>".validarconteo($json->mar)."</td>
	<td style='text-align: center;'>".validarconteo($json->apr)."</td>
	<td style='text-align: center;'>".validarconteo($json->may)."</td>
	<td style='text-align: center;'>".validarconteo($json->jun)."</td>
	<td style='text-align: center;'>".validarconteo($json->jul)."</td>
	<td style='text-align: center;'>".validarconteo($json->aug)."</td>
	<td style='text-align: center;'>".validarconteo($json->sep)."</td>
	<td style='text-align: center;'>".validarconteo($json->oct)."</td>
	<td style='text-align: center;'>".validarconteo($json->nov)."</td>
	<td style='text-align: center;'>".validarconteo($json->dec)."</td>
	<td style='text-align: center;'>".validarconteo($total)."</td>
	</tr>";
	$total_patrimoniales = $total_patrimoniales+validarconteo($total);

	$series_patrimoniales = $series_patrimoniales." {
                name: '".$json->nombre_hecho."',
                data: [
                ".validarconteo($json->jan).",
                ".validarconteo($json->feb).",
                ".validarconteo($json->mar).",
                ".validarconteo($json->apr).",
                ".validarconteo($json->may).",
                ".validarconteo($json->jun).",
                ".validarconteo($json->jul).",
                ".validarconteo($json->aug).",
                ".validarconteo($json->sep).",
                ".validarconteo($json->oct).",
                ".validarconteo($json->nov).",
                ".validarconteo($json->dec)." 
                ]
            },";

$Enero= $Enero + validarconteo($json->jan);
$Febrero= $Febrero + validarconteo($json->feb);
$Marzo= $Marzo + validarconteo($json->mar);
$Abril= $Abril + validarconteo($json->apr);
$Mayo= $Mayo + validarconteo($json->may);
$Junio= $Junio + validarconteo($json->jun);
$Julio= $Julio + validarconteo($json->jul);
$Agosto= $Agosto + validarconteo($json->aug);
$Septiembre= $Septiembre + validarconteo($json->sep);
$Octubre= $Octubre + validarconteo($json->oct);
$Noviembre= $Noviembre + validarconteo($json->nov);
$Diciembre= $Diciembre + validarconteo($json->dec);
}
$series_patrimoniales = $series_patrimoniales."&";
$series_patrimoniales = str_replace("},&", "}]",$series_patrimoniales);
//echo $series_patrimoniales;
$totales_entrada = "<tr><td>Totales</td>
	<td style='text-align: center;'>".$Enero."</td>
	<td style='text-align: center;'>".$Febrero."</td>
	<td style='text-align: center;'>".$Marzo."</td>
	<td style='text-align: center;'>".$Abril."</td>
	<td style='text-align: center;'>".$Mayo."</td>
	<td style='text-align: center;'>".$Junio."</td>
	<td style='text-align: center;'>".$Julio."</td>
	<td style='text-align: center;'>".$Agosto."</td>
	<td style='text-align: center;'>".$Septiembre."</td>
	<td style='text-align: center;'>".$Octubre."</td>
	<td style='text-align: center;'>".$Noviembre."</td>
	<td style='text-align: center;'>".$Diciembre."</td>
	<td style='text-align: center;'>".$total_patrimoniales."</td>
	</tr>";
$series_patrimoniales_pie = "[['Enero',".$Enero."],{
                        name: 'Febrero',
                        y: ".$Febrero.",
                        sliced: true,
                        selected: true
                    },['Marzo',".$Marzo."],['Abril',".$Abril."],['Mayo',".$Mayo."],['Junio',".$Junio."],['Julio',".$Julio."],['Agosto',".$Agosto."],
                    ['Septiembre',".$Septiembre."],
                    ['Octubre',".$Octubre."],
                    ['Noviembre',".$Noviembre."],
                    ['Diciembre',".$Diciembre."]
]";
//echo $series_patrimoniales_pie;
$fin_table_contra_patrimoniales ="</tbody></table>";
$tabla_salida_table_contra_patrimoniales = $table_contra_patrimoniales.$totales_entrada.$fin_table_contra_patrimoniales;
?>
  <div class="row-fluid">
  <div class="span12 ">
    <div class="row-fluid"> 
      <div class="span12 cuerpo-estadistica">
          <legend>Tabla Delitos Contra la Vida</legend>
          <div class="row-fluid">
            <div class="span6">
              <div id="graficauno"></div>       
            </div>
            <div class="span6">
              <div id="graficados"></div>       
            </div>
        </div>
        <?php echo $tabla_salida_table_contra_vida; ?>
      </div>
      </div>
    <div class="row-fluid">
        <div class="span12 cuerpo-estadistica">
          <legend>Tabla Delitos Patrimoniales</legend>
                <div class="row-fluid">
                  <div class="span6">
                      <div id="graficatres"></div>       
                  </div>
                  <div class="span6">
                      <div id="graficacuatro"></div>       
                  </div>   
                </div>
          <?php echo $tabla_salida_table_contra_patrimoniales; ?>
      </div>
    </div>

  </div>
</div> 
<script type="text/javascript">
	$(function () {
        $('#graficauno').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Hechos contra la Vida'
            },
            xAxis: {
                categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Delitos Contra la Vida'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
                   series: <?php echo $series_vida; ?>
        });
    });




$(function () {
    var chart;
    
    $(document).ready(function () {
    	
    	// Build the chart
        $('#graficados').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Participacion En Porcentajes'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                          formatter: function() {
                              return '<b>'+ this.point.name +'</b><br>'+ this.percentage.toFixed(2) +' %';
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Mes:',
              data: <?php echo $series_vida_pie; ?>
            }]
        });
    });
    
});
$(function () {
        $('#graficatres').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Hechos contra la patrimoniales'
            },
            xAxis: {
                categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Delitos Patrimoniales'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
                   series: <?php echo $series_patrimoniales; ?>
        });
    });
$(function () {
    var chart;
    
    $(document).ready(function () {
    	
    	// Build the chart
        $('#graficacuatro').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Participacion En Porcentajes'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                          formatter: function() {
                              return '<b>'+ this.point.name +'</b><br>'+ this.percentage.toFixed(2) +' %';
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Mes',
              data: <?php echo $series_patrimoniales_pie; ?>
            }]
        });
    });
 });
</script>
<?php
}//fin de la condicion para hacer la graficas
?>
    </div>
  </div>
</div>