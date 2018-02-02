<?php 
$subqueryfecha =  "AND e.fecha_ingreso  = ('now'::text::date)";
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$comisaria = $variable_datos_usuario[0]->id_cat_entidad;

$sql="SELECT te.descripcion_evento,
  CASE 
    WHEN e.id_tipo_evento = 1 THEN cd.nombre_denuncia
    WHEN e.id_tipo_evento = 2 THEN ti.nombre_tipo_incidencia
    WHEN e.id_tipo_evento = 3 THEN ex.nombre_extravio
  END as nombre_denuncia,
  e.id_tipo_evento,
  cd.id_cat_denuncia, 
  e.fecha_ingreso,
  e.hora_ingreso,
  dep.departamento,
  mupio.municipio
FROM sipol.tbl_evento_detalle ed
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
INNER JOIN sipol_catalogos.cat_tipo_incidencia ti ON ed.id_hecho_denuncia = ti.id_tipo_incidencia
INNER JOIN sipol_catalogos.cat_extravios ex ON ed.id_hecho_denuncia = ex.id_extravio
INNER JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
INNER JOIN catalogos_publicos.cat_departamentos dep ON e.id_depto = dep.cod_depto
INNER JOIN catalogos_publicos.cat_municipios mupio ON e.id_mupio = mupio.cod_mupio
INNER JOIN sipol_catalogos.cat_tipo_evento te ON e.id_tipo_evento = te.id_tipo_evento
where e.estado = 't'
".$subqueryfecha."
and ed.atributos IS NOT NULL
and e.the_geom IS NOT NULL
and ts.id_cat_entidad = ".$comisaria."
ORDER BY e.hora_ingreso DESC
LIMIT 10";
echo $sql;
$resultado = Yii::app()->db->createCommand($sql)->queryAll();
$resultadomapa = "";

$tabla = '<table class="table table-bordered">
  <thead>
    <tr>
      <th>Tipo de Evento</th>
      <th>Nombre del Evento</th>
      <th>Fecha</th>
      <th>Hora</th>
      <th>Departamento</th>
      <th>Municipio</th>
    </tr>
  </thead> <tbody>';



foreach ($resultado as $key => $value) 
{

  $hora = str_replace('{',' ',$value['hora_ingreso']);
  $hora = str_replace('}',' ',$hora);

   $tabla .= '<tr>
   <td>'.$value['descripcion_evento'].'</td>
   <td>'.$value['nombre_denuncia'].'</td>
   <td>'.$value['fecha_ingreso'].'</td>
   <td>'.$hora.'</td>
   <td>'.$value['departamento'].'</td>
   <td>'.$value['municipio'].'</td>

   
    </tr>';

}

    $tabla .='</tbody></table>';
    echo "<br>";
    echo $tabla;

     echo '</div>
</div>';



?>
