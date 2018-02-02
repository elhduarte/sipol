<div class=" row-fluid">
  <div  class="cuerpo span12">
    <div align="center" >
<strong>SECCIÓN DE NOVEDADES 
<br>
DEPARTAMENTO DE RECEPCIÓN DE INFORMACIÓN, ANALÍSIS Y ESTÁDISTICA 
<br> DIVISIÓN DE OPERACIONES CONJUNTAS, DE LA SUB-DIRECCIÓN GENERAL DE OPERACIONES 
<br> POLICIA NACIONAL CIVIL </strong>
<hr>
    </div>
    <div class=" row-fluid ">
     <div class=" span12 ">
       
<html>
<head>
<style type="text/css">
  .miestilo th, .miestilo td {
  border-top: 1px solid #DDDDDD;
  line-height: 20px;
  padding: 8px;
  text-align: center;
  vertical-align: top;
  }
</style>

<title>Cuadro Estadistico</title>
</head>
<body>
<script type="text/javascript">

$(document).ready(function(){

</script>
<?php $h =getdate(time());
  $hora = date("H:i:s",time()-21600);
  $dia = date("d-m-Y");
  $diaq= date ("Y-m-d");
  $horario = date('H:i:s');
  setlocale(LC_TIME, 'spanish');
  $afecha = strftime("   %A %#d de %B del %Y",time()-21600);
 $diaq = date("Y-m-d",time()-21600);
$afecha=(string)$afecha ;
$fecha=  utf8_encode ($afecha);
?>

<table class="table table-bordered miestilo">
<tr ><td colspan="31"><H4>ACCIONES POSITIVAS</H4></td></tr>


<div class="pull-right"><span class="comentario-fit"><?php echo $fecha.", ".$hora; ?></span></div>
<?php
$connection=Yii::app()->db;
$totalhom ="";
$totalhom ="SELECT SUM(suma.total) as sum FROM 
(SELECT SUM (a.cantidad) as total
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
  WHERE a.id_boleta = b.id_boleta
  and a.id_evento = c.id_evento
  and c.id_hecho = 1
  and b.fecha ='".$diaq."'
  GROUP BY  c.nombre_evento, a.cantidad) as suma";
  
$command=$connection->createCommand($totalhom);
      $dataReader=$command->query();
  
 foreach($dataReader as $d)
      {
  $d['sum'];
  //**********************SUMA DE HECHOS************************

$msqldn = " SELECT * FROM crosstab('
  SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
  WHERE a.id_boleta = b.id_boleta
  and c.id_hecho = 1
  and a.id_evento = c.id_evento
  AND b.fecha = ''".$diaq."''
  and b.id_comisaria = d.id_comisaria
  GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
  order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')  
as ( ". "\"0\"" . "character varying(300),
". "\"1\"" . "character varying(300),
". "\"2\"" . "character varying(300),
". "\"3\"" . "character varying(300),
". "\"4\"" . "character varying(300),
". "\"5\"" . "character varying(300),
". "\"6\"" . "character varying(300),
". "\"7\"" . "character varying(300),
". "\"8\"" . "character varying(300),
". "\"9\"" . "character varying(300),
". "\"10\"" . "character varying(300),
". "\"11\"" . "character varying(300),
". "\"12\"" . "character varying(300),
". "\"13\"" . "character varying(300),
". "\"14\"" . "character varying(300),
". "\"15\"" . "character varying(300),
". "\"16\"" . "character varying(300),
". "\"17\"" . "character varying(300),
". "\"18\"" . "character varying(300),
". "\"19\"" . "character varying(300),
". "\"20\"" . "character varying(300),
". "\"21\"" . "character varying(300),
". "\"22\"" . "character varying(300),
". "\"23\"" . "character varying(300),
". "\"24\"" . "character varying(300),
". "\"25\"" . "character varying(300),
". "\"26\"" . "character varying(300),
". "\"27\"" . "character varying(300));
";
    

//$damedn= pg_query($conn,$msqldn);
$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
if ($dataReader)
{

  echo "<tr class='info'><td><b> DETENIDOS POR/COMISARIAS<b></td>";
  echo "
      <td><b>   11 <b> </td>
      <td><b>   12</b> </td>
      <td><b>   13 </b></td>
      <td><b>   14 </b></td>
      <td><b>   15 </b></td>
      <td><b>   16 </b></td>
      <td> <b>TOTAL CAPITAL </b> </td>
      <td><b>   21 </b></td>
      <td><b>   22 </b></td>
      <td><b>   23 </b></td>
      <td><b>   24 </b></td>
      <td><b>   31 </b></td>
      <td><b>   32 </b></td>
      <td><b>   33 </b></td>
      <td><b>   34 </b></td>
      <td><b>   41 </b></td>
      <td><b>   42 </b></td>
      <td><b>   43 </b></td>
      <td><b>   44 </b></td>
      <td><b>   51 </b></td>
      <td><b>   52 </b></td>
      <td><b>   53 </b></td>
      <td><b>   61 </b></td>
      <td><b>   62 </b></td>
      <td><b>   71 </b></td>
      <td><b>   72 </b></td>
      <td><b>   73 </b></td>
      <td><b>   74 </b></td></B>
      <td> <b>TOTAL DEPTOS </b></td>
      <td> <b>TOTAL GENERAL</b></td>
      </tr>";
    
  $totalinte = 0;
  $totalcapi=0;   
  $totalgen =0;
  $t=0;
  
$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
      
      
      foreach($dataReader as $r)
      {
    $totalcapi= $r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6];
    $totalinte=$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    $totalgen=$r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6] +$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
  
    echo"<tr><td>".$r[0]."</td><td>" . $r[1] ."</td><td>" . $r[2] . "</td><td>" . $r[3] . "</td><td>" . $r[4] . "</td><td>" . $r[5] . "</td><td>" . $r[6] . "</td><td><b>" . $totalcapi . "</td>
    <td>" . $r[7] . "</td><td>" . $r[8] . "</td><td>" . $r[9] . "</td><td>" . $r[10] . "</td><td>" . $r[11] . "</td><td>" . $r[12] . "</td><td>" . $r[13] . "</td><td>" . $r[14] . "</td>
    <td>" . $r[15] . "</td><td>" . $r[16] . "</td><td>" . $r[17] . "</td><td>" . $r[18] . "</td><td>" . $r[19] . "</td><td>" . $r[20] . "</td>
    <td>" . $r[21] . "</td><td>" . $r[22] . "</td><td>" . $r[23] . "</td><td>" . $r[24] . "</td><td>" . $r[25] . "</td><td>" . $r[26] . "</td><td>" . $r[27] . "</td><td>".$totalinte."</td><td>".$totalgen."</td> </tr>";
    }
  echo "<td><H5>TOTAL</H5></td><td colspan='29'></td><td><strong>".$d['sum']."</strong></td></tr>";
} 
}  
$totalhom ="SELECT SUM(suma.total) as sum FROM 
(SELECT SUM (a.cantidad) as total
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
  WHERE a.id_boleta = b.id_boleta
  and a.id_evento = c.id_evento
  and c.id_hecho = 2
  and b.fecha ='".$diaq."'
  GROUP BY  c.nombre_evento, a.cantidad) as suma";
 $command=$connection->createCommand($totalhom);
      $dataReader=$command->query();
  
 foreach($dataReader as $di)
      {
  $di['sum'];                                                                              
$msqldn="SELECT * FROM crosstab('
  SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
  WHERE a.id_boleta = b.id_boleta
  and c.id_hecho = 2
  and a.id_evento = c.id_evento
  AND b.fecha = ''".$diaq."''
  and b.id_comisaria = d.id_comisaria
  GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
  order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')  
as ( ". "\"0\"" . "character varying(300),
". "\"1\"" . "character varying(300),
". "\"2\"" . "character varying(300),
". "\"3\"" . "character varying(300),
". "\"4\"" . "character varying(300),
". "\"5\"" . "character varying(300),
". "\"6\"" . "character varying(300),
". "\"7\"" . "character varying(300),
". "\"8\"" . "character varying(300),
". "\"9\"" . "character varying(300),
". "\"10\"" . "character varying(300),
". "\"11\"" . "character varying(300),
". "\"12\"" . "character varying(300),
". "\"13\"" . "character varying(300),
". "\"14\"" . "character varying(300),
". "\"15\"" . "character varying(300),
". "\"16\"" . "character varying(300),
". "\"17\"" . "character varying(300),
". "\"18\"" . "character varying(300),
". "\"19\"" . "character varying(300),
". "\"20\"" . "character varying(300),
". "\"21\"" . "character varying(300),
". "\"22\"" . "character varying(300),
". "\"23\"" . "character varying(300),
". "\"24\"" . "character varying(300),
". "\"25\"" . "character varying(300),
". "\"26\"" . "character varying(300),
". "\"27\"" . "character varying(300));
";
$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
if ($dataReader)
{   echo "<tr class='info'>
      <td> <B> DECOMISOS E INCAUTACIONES </B> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> <b>  </b> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td></td>
      <td> <b>  </b></td>
      <td> <b>  </b></td>
      </tr>";
      $totalgen=$totalcapi+$totalinte;
  $totalinte1 = 0;
  $totalcapi1=0;    
  $totalgen1 =0;
$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
      
      
      foreach($dataReader as $r)
      {
    $totalcapi1= $r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6];
    $totalinte1=$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    $totalgen1=$r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6] +$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    echo"<tr><td>".$r[0]."</td><td>" . $r[1] ."</td><td>" . $r[2] . "</td><td>" . $r[3] . "</td><td>" . $r[4] . "</td><td>" . $r[5] . "</td><td>" . $r[6] . "</td><td><b>" . $totalcapi1 . "</td>
    <td>" . $r[7] . "</td><td>" . $r[8] . "</td><td>" . $r[9] . "</td><td>" . $r[10] . "</td><td>" . $r[11] . "</td><td>" . $r[12] . "</td><td>" . $r[13] . "</td><td>" . $r[14] . "</td>
    <td>" . $r[15] . "</td><td>" . $r[16] . "</td><td>" . $r[17] . "</td><td>" . $r[18] . "</td><td>" . $r[19] . "</td><td>" . $r[20] . "</td>
    <td>" . $r[21] . "</td><td>" . $r[22] . "</td><td>" . $r[23] . "</td><td>" . $r[24] . "</td><td>" . $r[25] . "</td><td>" . $r[26] . "</td><td>" . $r[27] . "</td><td>".$totalinte1."</td><td>".$totalgen1."</td> </tr>";
  }
echo "<tr '><td><H5>TOTAL</H5></td><td colspan='29'></td><td><strong>".$di['sum']."</strong></td></tr>";
} 
}

$totalhom ="SELECT SUM(suma.total) as sum FROM 
(SELECT SUM (a.cantidad) as total
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
  WHERE a.id_boleta = b.id_boleta
  and a.id_evento = c.id_evento
  and c.id_hecho = 3
  and b.fecha ='".$diaq."'
  GROUP BY  c.nombre_evento, a.cantidad) as suma";
  $command=$connection->createCommand($totalhom);
      $dataReader=$command->query();
  
 foreach($dataReader as $hp)
      {
  $hp['sum']; 
$msqldn="
SELECT * FROM crosstab('
  SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
  WHERE a.id_boleta = b.id_boleta
  and c.id_hecho = 3
  and a.id_evento = c.id_evento
  AND b.fecha = ''".$diaq."''
  and b.id_comisaria = d.id_comisaria
  GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
  order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')  
as ( ". "\"0\"" . "character varying(300),
". "\"1\"" . "character varying(300),
". "\"2\"" . "character varying(300),
". "\"3\"" . "character varying(300),
". "\"4\"" . "character varying(300),
". "\"5\"" . "character varying(300),
". "\"6\"" . "character varying(300),
". "\"7\"" . "character varying(300),
". "\"8\"" . "character varying(300),
". "\"9\"" . "character varying(300),
". "\"10\"" . "character varying(300),
". "\"11\"" . "character varying(300),
". "\"12\"" . "character varying(300),
". "\"13\"" . "character varying(300),
". "\"14\"" . "character varying(300),
". "\"15\"" . "character varying(300),
". "\"16\"" . "character varying(300),
". "\"17\"" . "character varying(300),
". "\"18\"" . "character varying(300),
". "\"19\"" . "character varying(300),
". "\"20\"" . "character varying(300),
". "\"21\"" . "character varying(300),
". "\"22\"" . "character varying(300),
". "\"23\"" . "character varying(300),
". "\"24\"" . "character varying(300),
". "\"25\"" . "character varying(300),
". "\"26\"" . "character varying(300),
". "\"27\"" . "character varying(300));
";
$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
if ($dataReader)
{ 

  echo "<tr class='info'>
      <td> <B> HECHOS VARIOS POSITIVOS </B> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> <b>  </b> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td> <b>  </b></td>
      <td> <b>  </b></td>
      </tr>";
      $totalgen1=$totalcapi1+$totalinte1;
  $totalinte2 = 0;
  $totalcapi2 =0;   
  $totalgen2 =0;    
$command=$connection->createCommand($msqldn);
$dataReader=$command->query();
    foreach($dataReader as $r)
    {
      $totalcapi2= $r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6];
    $totalinte2=$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    $totalgen2=$r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6] +$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    echo"<tr><td>".$r[0]."</td><td>" . $r[1] ."</td><td>" . $r[2] . "</td><td>" . $r[3] . "</td><td>" . $r[4] . "</td><td>" . $r[5] . "</td><td>" . $r[6] . "</td><td><b>" . $totalcapi2. "</td>
    <td>" . $r[7] . "</td><td>" . $r[8] . "</td><td>" . $r[9] . "</td><td>" . $r[10] . "</td><td>" . $r[11] . "</td><td>" . $r[12] . "</td><td>" . $r[13] . "</td><td>" . $r[14] . "</td>
    <td>" . $r[15] . "</td><td>" . $r[16] . "</td><td>" . $r[17] . "</td><td>" . $r[18] . "</td><td>" . $r[19] . "</td><td>" . $r[20] . "</td>
    <td>" . $r[21] . "</td><td>" . $r[22] . "</td><td>" . $r[23] . "</td><td>" . $r[24] . "</td><td>" . $r[25] . "</td><td>" . $r[26] . "</td><td>" . $r[27] . "</td><td>".$totalinte2."</td><td>".$totalgen2."</td> </tr>";
  }
  echo "<tr ' ><td><H5>TOTAL</H5></td><td colspan='29'></td><td><strong>".$hp['sum']."</strong></td></tr>";
  }
} 
?>
<tr>
      <td colspan="32"><H4>ACCIONES NEGATIVAS</H4></td>
      
      
      
      </tr>
</div>


<?php
$totalhom ="SELECT SUM(suma.total) as sum FROM 
(SELECT SUM (a.cantidad) as total
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
  WHERE a.id_boleta = b.id_boleta
  and a.id_evento = c.id_evento
  and c.id_hecho = 4
  and b.fecha ='".$diaq."'
  GROUP BY  c.nombre_evento, a.cantidad) as suma";
  $command=$connection->createCommand($totalhom);
      $dataReader=$command->query();
  
 foreach($dataReader as $h)
      {
  $h['sum'];  
$msqldn="
SELECT * FROM crosstab('
  SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
  WHERE a.id_boleta = b.id_boleta
  and c.id_hecho = 4
  and a.id_evento = c.id_evento
  AND b.fecha = ''".$diaq."''
  and b.id_comisaria = d.id_comisaria
  GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
  order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')  
as ( ". "\"0\"" . "character varying(300),
". "\"1\"" . "character varying(300),
". "\"2\"" . "character varying(300),
". "\"3\"" . "character varying(300),
". "\"4\"" . "character varying(300),
". "\"5\"" . "character varying(300),
". "\"6\"" . "character varying(300),
". "\"7\"" . "character varying(300),
". "\"8\"" . "character varying(300),
". "\"9\"" . "character varying(300),
". "\"10\"" . "character varying(300),
". "\"11\"" . "character varying(300),
". "\"12\"" . "character varying(300),
". "\"13\"" . "character varying(300),
". "\"14\"" . "character varying(300),
". "\"15\"" . "character varying(300),
". "\"16\"" . "character varying(300),
". "\"17\"" . "character varying(300),
". "\"18\"" . "character varying(300),
". "\"19\"" . "character varying(300),
". "\"20\"" . "character varying(300),
". "\"21\"" . "character varying(300),
". "\"22\"" . "character varying(300),
". "\"23\"" . "character varying(300),
". "\"24\"" . "character varying(300),
". "\"25\"" . "character varying(300),
". "\"26\"" . "character varying(300),
". "\"27\"" . "character varying(300));
";

$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
if ($dataReader)
{ 
echo "<tr class='info'>
      <td> <B> HOMICIDIOS POR </B> </td>";
  echo "
      <td><b>   11 <b> </td>
      <td><b>   12</b> </td>
      <td><b>   13 </b></td>
      <td><b>   14 </b></td>
      <td><b>   15 </b></td>
      <td><b>   16 </b></td>
      <td> <b>TOTAL CAPITAL </b> </td>
      <td><b>   21 </b></td>
      <td><b>   22 </b></td>
      <td><b>   23 </b></td>
      <td><b>   24 </b></td>
      <td><b>   31 </b></td>
      <td><b>   32 </b></td>
      <td><b>   33 </b></td>
      <td><b>   34 </b></td>
      <td><b>   41 </b></td>
      <td><b>   42 </b></td>
      <td><b>   43 </b></td>
      <td><b>   44 </b></td>
      <td><b>   51 </b></td>
      <td><b>   52 </b></td>
      <td><b>   53 </b></td>
      <td><b>   61 </b></td>
      <td><b>   62 </b></td>
      <td><b>   71 </b></td>
      <td><b>   72 </b></td>
      <td><b>   73 </b></td>
      <td><b>   74 </b></td></B>
      <td> <b>TOTAL DEPTOS </b></td>
      <td> <b>TOTAL GENERAL </b></td>
      </tr>";
  $totalinte3 = 0;
  $totalcapi3 =0;   
  $totalgen3 =0;    
$command=$connection->createCommand($msqldn);
$dataReader=$command->query();
    foreach($dataReader as $r)
    {
    $totalcapi3= $r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6];
    $totalinte3=$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    $totalgen3=$r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6] +$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    echo"<tr><td>".$r[0]."</td><td>" . $r[1] ."</td><td>" . $r[2] . "</td><td>" . $r[3] . "</td><td>" . $r[4] . "</td><td>" . $r[5] . "</td><td>" . $r[6] . "</td><td><b>" . $totalcapi3 . "</td>
    <td>" . $r[7] . "</td><td>" . $r[8] . "</td><td>" . $r[9] . "</td><td>" . $r[10] . "</td><td>" . $r[11] . "</td><td>" . $r[12] . "</td><td>" . $r[13] . "</td><td>" . $r[14] . "</td>
    <td>" . $r[15] . "</td><td>" . $r[16] . "</td><td>" . $r[17] . "</td><td>" . $r[18] . "</td><td>" . $r[19] . "</td><td>" . $r[20] . "</td>
    <td>" . $r[21] . "</td><td>" . $r[22] . "</td><td>" . $r[23] . "</td><td>" . $r[24] . "</td><td>" . $r[25] . "</td><td>" . $r[26] . "</td><td>" . $r[27] . "</td><td>".$totalinte3."</td><td>".$totalgen3."</td> </tr>";
  }
echo "<tr '><td><H5>TOTAL</H5></td><td colspan='29'></td><td><strong>".$h['sum']."</strong></td></tr>";
  }
} 
$totalhom ="SELECT SUM(suma.total) FROM 
(SELECT SUM (a.cantidad) as total
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
  WHERE a.id_boleta = b.id_boleta
  and a.id_evento = c.id_evento
  and c.id_hecho = 5
  and b.fecha ='".$diaq."'
  GROUP BY  c.nombre_evento, a.cantidad) as suma";
  $command=$connection->createCommand($totalhom);
      $dataReader=$command->query();
  
 foreach($dataReader as $l)
      {
  $l['sum'];
  $msqldn="
SELECT * FROM crosstab('
  SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
  WHERE a.id_boleta = b.id_boleta
  and c.id_hecho = 5
  and a.id_evento = c.id_evento
  AND b.fecha = ''".$diaq."''
  and b.id_comisaria = d.id_comisaria
  GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
  order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')  
as ( ". "\"0\"" . "character varying(300),
". "\"1\"" . "character varying(300),
". "\"2\"" . "character varying(300),
". "\"3\"" . "character varying(300),
". "\"4\"" . "character varying(300),
". "\"5\"" . "character varying(300),
". "\"6\"" . "character varying(300),
". "\"7\"" . "character varying(300),
". "\"8\"" . "character varying(300),
". "\"9\"" . "character varying(300),
". "\"10\"" . "character varying(300),
". "\"11\"" . "character varying(300),
". "\"12\"" . "character varying(300),
". "\"13\"" . "character varying(300),
". "\"14\"" . "character varying(300),
". "\"15\"" . "character varying(300),
". "\"16\"" . "character varying(300),
". "\"17\"" . "character varying(300),
". "\"18\"" . "character varying(300),
". "\"19\"" . "character varying(300),
". "\"20\"" . "character varying(300),
". "\"21\"" . "character varying(300),
". "\"22\"" . "character varying(300),
". "\"23\"" . "character varying(300),
". "\"24\"" . "character varying(300),
". "\"25\"" . "character varying(300),
". "\"26\"" . "character varying(300),
". "\"27\"" . "character varying(300));
";
$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
if ($dataReader)
{    echo "<tr class='info'>
      <td> <B> LESIONADOS POR </B> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> <b>  </b> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td> <b>  </b></td>
      <td> <b>  </b></td>
      </tr>";
      $totalgen3=$totalcapi3+$totalinte3;
  $totalinte4 = 0;
  $totalcapi4 =0;   
  $totalgen4 =0; 
$command=$connection->createCommand($msqldn);
$dataReader=$command->query();
    foreach($dataReader as $r)
    {
    $totalcapi4= $r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6];
    $totalinte4=$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    $totalgen4=$r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6] +$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    echo"<tr><td>".$r[0]."</td><td>" . $r[1] ."</td><td>" . $r[2] . "</td><td>" . $r[3] . "</td><td>" . $r[4] . "</td><td>" . $r[5] . "</td><td>" . $r[6] . "</td><td><b>" . $totalcapi4 . "</td>
    <td>" . $r[7] . "</td><td>" . $r[8] . "</td><td>" . $r[9] . "</td><td>" . $r[10] . "</td><td>" . $r[11] . "</td><td>" . $r[12] . "</td><td>" . $r[13] . "</td><td>" . $r[14] . "</td>
    <td>" . $r[15] . "</td><td>" . $r[16] . "</td><td>" . $r[17] . "</td><td>" . $r[18] . "</td><td>" . $r[19] . "</td><td>" . $r[20] . "</td>
    <td>" . $r[21] . "</td><td>" . $r[22] . "</td><td>" . $r[23] . "</td><td>" . $r[24] . "</td><td>" . $r[25] . "</td><td>" . $r[26] . "</td><td>" . $r[27] . "</td><td>".$totalinte4."</td><td>".$totalgen4."</td> </tr>";
  }
echo "<tr '><td><H5>TOTAL</H5></td><td colspan='29'></td><td><strong>".$l['sum']."</strong></td></tr>";
  }
} 
$totalhom ="SELECT SUM(suma.total) as sum FROM 
(SELECT SUM (a.cantidad) as total
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c
  WHERE a.id_boleta = b.id_boleta
  and a.id_evento = c.id_evento
  and c.id_hecho = 6
  and b.fecha ='".$diaq."'
  GROUP BY  c.nombre_evento, a.cantidad) as suma";
  $command=$connection->createCommand($totalhom);
      $dataReader=$command->query();
  
 foreach($dataReader as $hn)
      {
  $hn['sum'];
  
$msqldn="
SELECT * FROM crosstab('
  SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
  WHERE a.id_boleta = b.id_boleta
  and c.id_hecho = 6
  and a.id_evento = c.id_evento
  AND b.fecha = ''".$diaq."''
  and b.id_comisaria = d.id_comisaria
  GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
  order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')  
as ( ". "\"0\"" . "character varying(300),
". "\"1\"" . "character varying(300),
". "\"2\"" . "character varying(300),
". "\"3\"" . "character varying(300),
". "\"4\"" . "character varying(300),
". "\"5\"" . "character varying(300),
". "\"6\"" . "character varying(300),
". "\"7\"" . "character varying(300),
". "\"8\"" . "character varying(300),
". "\"9\"" . "character varying(300),
". "\"10\"" . "character varying(300),
". "\"11\"" . "character varying(300),
". "\"12\"" . "character varying(300),
". "\"13\"" . "character varying(300),
". "\"14\"" . "character varying(300),
". "\"15\"" . "character varying(300),
". "\"16\"" . "character varying(300),
". "\"17\"" . "character varying(300),
". "\"18\"" . "character varying(300),
". "\"19\"" . "character varying(300),
". "\"20\"" . "character varying(300),
". "\"21\"" . "character varying(300),
". "\"22\"" . "character varying(300),
". "\"23\"" . "character varying(300),
". "\"24\"" . "character varying(300),
". "\"25\"" . "character varying(300),
". "\"26\"" . "character varying(300),
". "\"27\"" . "character varying(300));
";
$command=$connection->createCommand($msqldn);
      $dataReader=$command->query();
if ($dataReader)
{
    echo "<tr class='info'>
      <td> <B> HECHOS VARIOS NEGATIVOS  </B> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> <b>  
      <td> <b>  
      </b> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td> <b>  </b></td>
      <td> <b>  </b></td>
      </tr>";
      $totalgen4=$totalcapi4+$totalinte4;
  $totalinte5 = 0;
  $totalcapi5=0;    
  $totalgen5 =0;
$command=$connection->createCommand($msqldn);
$dataReader=$command->query();
    foreach($dataReader as $r)
    {
    $totalcapi5= $r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6];
    $totalinte5=$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    $totalgen5=$r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6] +$r[7]+$r[8]+$r[9]+$r[10]+$r[11]+$r[12]+$r[13]+$r[14]+$r[15]+$r[16]+$r[17]+$r[18]+$r[19]+$r[20]+$r[21]+$r[22]+$r[23]+$r[24]+$r[25]+$r[26]+$r[27];
    echo"<tr><td>".$r[0]."</td><td>" . $r[1] ."</td><td>" . $r[2] . "</td><td>" . $r[3] . "</td><td>" . $r[4] . "</td><td>" . $r[5] . "</td><td>" . $r[6] . "</td><td><b>" . $totalcapi5 . "</td>
    <td>" . $r[7] . "</td><td>" . $r[8] . "</td><td>" . $r[9] . "</td><td>" . $r[10] . "</td><td>" . $r[11] . "</td><td>" . $r[12] . "</td><td>" . $r[13] . "</td><td>" . $r[14] . "</td>
    <td>" . $r[15] . "</td><td>" . $r[16] . "</td><td>" . $r[17] . "</td><td>" . $r[18] . "</td><td>" . $r[19] . "</td><td>" . $r[20] . "</td>
    <td>" . $r[21] . "</td><td>" . $r[22] . "</td><td>" . $r[23] . "</td><td>" . $r[24] . "</td><td>" . $r[25] . "</td><td>" . $r[26] . "</td><td>" . $r[27] . "</td> <td>".$totalinte5."</td><td>".$totalgen5."</td> </tr>";
  }
echo "<tr '><td><H5>TOTAL</H5></td><td colspan='29'></td><td><strong>".$hn['sum']."</strong></td></tr>";
}
} 
?>
</table>

</div>
</body>

</html>






     </div>
    </div>
  </div>
</div>