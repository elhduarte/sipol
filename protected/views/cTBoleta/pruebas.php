<?php
 $diaq = '2013-09-11';
$connection=Yii::app()->db;
$msqldn = "	SELECT * FROM crosstab('
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
			$command=$connection->createCommand($msqldn);
			$dataReader=$command->query();
			
			
			foreach($dataReader as $row)
			{
				echo"saf";
	var_dump($row[0]);
			}
	
?>

<?php

$msqldn="
SELECT * FROM crosstab('
  SELECT  (c.nombre_evento ||'' ''||  a.complemento) AS Nombre_Completo, d.id_comisaria,SUM (a.cantidad) as scantidad
       FROM dg_pnc_novedades.t_total_eventos a, dg_pnc_novedades.t_boleta  b, dg_pnc_novedades.t_evento c, dg_pnc_novedades.t_comisaria d
  WHERE a.id_boleta = b.id_boleta
  
  and a.id_evento = c.id_evento
  AND b.fecha = ''".$diaq."''
  and b.id_comisaria = d.id_comisaria
  GROUP BY d.id_comisaria, c.nombre_evento,  c.id_evento, a.complemento, Nombre_Completo
  order by c.id_evento',
'select id_comisaria from DG_PNC_NOVEDADES.t_comisaria ORDER BY numero_comisaria')  
as ( id_evento character varying (300),
". "\"comisaria 11\"" . "character varying(300),
". "\"comisaria 12\"" . "character varying(300),
". "\"comisaria 13\"" . "character varying(300),
". "\"comisaria 14\"" . "character varying(300),
". "\"comisaria 15\"" . "character varying(300),
". "\"comisaria 16\"" . "character varying(300),
". "\"comisaria 21\"" . "character varying(300),
". "\"comisaria 22\"" . "character varying(300),
". "\"comisaria 23\"" . "character varying(300),
". "\"comisaria 24\"" . "character varying(300),
". "\"comisaria 31\"" . "character varying(300),
". "\"comisaria 32\"" . "character varying(300),
". "\"comisaria 33\"" . "character varying(300),
". "\"comisaria 34\"" . "character varying(300),
". "\"comisaria 41\"" . "character varying(300),
". "\"comisaria 42\"" . "character varying(300),
". "\"comisaria 43\"" . "character varying(300),
". "\"comisaria 44\"" . "character varying(300),
". "\"comisaria 51\"" . "character varying(300),
". "\"comisaria 52\"" . "character varying(300),
". "\"comisaria 53\"" . "character varying(300),
". "\"comisaria 61\"" . "character varying(300),
". "\"comisaria 62\"" . "character varying(300),
". "\"comisaria 71\"" . "character varying(300),
". "\"comisaria 72\"" . "character varying(300),
". "\"comisaria 73\"" . "character varying(300),
". "\"comisaria 74\"" . "character varying(300));
";

$damedn= pg_query($conn,$msqldn);

if ($damedn)
{
  while ($r = pg_fetch_row($damedn))
  {
 	var_dump($r[0]);
  } 
}
?>

<input id ='dp1'type="text" placeholder="Text input">

<script type="text/javascript">

$(document).ready(function(){

$('#dp1').datepicker({
  format: 'yyyy-mm-dd',
  language:"es",
});





});
</script>
