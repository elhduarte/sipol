<style type="text/css">

.oculta { display: none; }

.timeline {
  list-style: none;
  padding: 20px 0 20px;
  position: relative;
}
.timeline:before {
  top: 0;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #eeeeee;
  left: 50%;
  margin-left: -1.5px;
}
.timeline > li {
  margin-bottom: 20px;
  position: relative;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li > .timeline-panel {
  width: 46%;
  float: left;
  border: 1px solid #d4d4d4;
  border-radius: 2px;
  padding: 20px;
  position: relative;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}
.timeline > li > .timeline-panel:before {
  position: absolute;
  top: 26px;
  right: -15px;
  display: inline-block;
  border-top: 15px solid transparent;
  border-left: 15px solid #ccc;
  border-right: 0 solid #ccc;
  border-bottom: 15px solid transparent;
  content: " ";
}
.timeline > li > .timeline-panel:after {
  position: absolute;
  top: 27px;
  right: -14px;
  display: inline-block;
  border-top: 14px solid transparent;
  border-left: 14px solid #fff;
  border-right: 0 solid #fff;
  border-bottom: 14px solid transparent;
  content: " ";
}
.timeline > li > .timeline-badge {
  color: #fff;
  width: 50px;
  height: 50px;
  line-height: 50px;
  font-size: 1.4em;
  text-align: center;
  position: absolute;
  top: 16px;
  left: 50%;
  margin-left: -25px;
  background-color: #999999;
  z-index: 100;
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
}
.timeline > li.timeline-inverted > .timeline-panel {
  float: right;
}
.timeline > li.timeline-inverted > .timeline-panel:before {
  border-left-width: 0;
  border-right-width: 15px;
  left: -15px;
  right: auto;
}
.timeline > li.timeline-inverted > .timeline-panel:after {
  border-left-width: 0;
  border-right-width: 14px;
  left: -14px;
  right: auto;
}
.timeline-badge.primary {
  background-color: #2e6da4 !important;
}
.timeline-badge.success {
  background-color: #3f903f !important;
}
.timeline-badge.warning {
  background-color: #f0ad4e !important;
}
.timeline-badge.danger {
  background-color: #d9534f !important;
}
.timeline-badge.info {
  background-color: #5bc0de !important;
}
.timeline-title {
  margin-top: 0;
  color: inherit;
}
.timeline-body > p,
.timeline-body > ul {
  margin-bottom: 0;
}
.timeline-body > p + p {
  margin-top: 5px;
}
</style>
<?php
$variable_datos_usuario = json_decode($_SESSION['ID_ROL_SIPOL']);
$id_cat_entidad = $variable_datos_usuario[0]->id_cat_entidad;
$nombre_entidad = $variable_datos_usuario[0]->nombre_entidad;
$remplazo = array('"','[',']');
$codigoLimpio = str_replace($remplazo,"",$codigo);
#print_r($codigoLimpio);



$query = "SELECT ed.id_evento_detalle, e.relato, e.fecha_ingreso, e.hora_ingreso, ce.nombre_entidad, ts.nombre, mupios.departamento, mupios.municipio, usu.usuario ,
CASE WHEN e.id_tipo_evento = 1
 THEN (te.descripcion_evento ||' - '||  cd.nombre_denuncia)
ELSE  te.descripcion_evento ||' - '||  ex.nombre_extravio 
END AS nombre_completo
FROM sipol.tbl_evento_detalle ed
INNER JOIN sipol.tbl_evento e ON ed.id_evento = e.id_evento
INNER JOIN catalogos_publicos.tbl_sede ts ON e.id_sede = ts.id_sede
INNER JOIN catalogos_publicos.cat_entidad ce ON ts.id_cat_entidad = ce.id_cat_entidad
INNER JOIN catalogos_publicos.cat_municipios mupios ON e.id_mupio = mupios.cod_mupio 
INNER JOIN sipol_usuario.tbl_usuario usu ON e.id_usuario = usu.id_usuario 
LEFT JOIN sipol_catalogos.cat_denuncia cd ON ed.id_hecho_denuncia = cd.id_cat_denuncia
LEFT JOIN sipol_catalogos.cat_extravios ex ON ed.id_hecho_denuncia = ex.id_extravio
INNER JOIN sipol_catalogos.cat_tipo_evento te ON e.id_tipo_evento = te.id_tipo_evento
WHERE ed.atributos IS NOT NULL 
AND e.estado = 't'
AND e.id_tipo_evento IN (".$codigoLimpio.")
AND ts.id_cat_entidad = ".$id_cat_entidad."
ORDER BY ed.id_evento_detalle DESC 
LIMIT 20
";
$resultado = Yii::app()->db->createCommand($query)->queryAll();
$contador = 1;
$textosalida = "";

//print_r($query);

foreach ($resultado as $key => $value) {
  //echo $value['relato'];
  //echo "<br>";
  $horareal = str_replace("{", "", $value['hora_ingreso']);
  $horareal = str_replace("}", "", $horareal);
 $fechareal=date("d-m-Y",strtotime($value['fecha_ingreso'])); 

  if ($contador%2==0){
   $textosalida .= '  <li class="timeline-inverted">
          <div class="timeline-badge info"><i class="glyphicon glyphicon-credit-card"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
        <h5 class="timeline-title">'.strtoupper($value['nombre_completo']).'</h5>
                 <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Usuario: <strong> '.strip_tags($value['usuario']).'</strong> ,   '.strip_tags($fechareal).', '.strip_tags($horareal).' Horas,  '.strip_tags($value['nombre']).', '.strip_tags($value['departamento']).',  '.strip_tags($value['municipio']).'</small></p>

           
            </div>
            <div class="timeline-body">
              <p>'.strip_tags($value['relato']).'</p>
           </div>
          </div>
        </li>';
}else{
    $textosalida .= ' <li>
          <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h5 class="timeline-title">'.strtoupper($value['nombre_completo']).'</h5>
                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Usuario:<strong> '.strip_tags($value['usuario']).'</strong> ,   '.strip_tags($fechareal).','.strip_tags($horareal).' Horas,  '.strip_tags($value['nombre']).', '.strip_tags($value['departamento']).',  '.strip_tags($value['municipio']).'</small></p>
            </div>
            <div class="timeline-body">
             <p><justify>'.strip_tags($value['relato']).'</justify></p>
             </div>

          </div>
        </li>';

}

$contador = $contador +1;
  # code...
}

echo $textosalida;

?>