<?php
/*
echo "hecho enviado".$hechosdenuncia;
echo "<br>";
echo $tipo;
echo "<br>";
echo $tiempo;
echo "<br>";
echo $departamento;
echo "<br>";
echo $municipio;
echo "<br>";
echo $region;
echo "<br>";
echo $comisaria;
echo "<br>";
echo $tipo_sede;
echo "<br>";
echo $sede;
echo "<br>";
echo $tipo_hecho;
echo "<br>";
echo $estadofecha;
echo "<br>";
echo $fechainicio;
echo "<br>";
echo $fechafinal;
echo "<br>";*/
switch ($tiempo) 
{
        case '1':
           $fecha = date('Y-m-j');
            $fecha_inicio_denuncia = $fecha;    
            $fecha_final_denuncia =$fecha;
            $comisaria_denuncia ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
            break;
        
      case '2':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '3':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '4':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-14 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '5':
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $fecha22 = date("Y-m-d",strtotime($nuevafecha));
        $fecha_inicio_denuncia =  $fecha22;  
        $fecha_final_denuncia =$fecha;
        $comisaria_denuncia ="11";
        $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
        $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
         case '6':
             $fecha = date('Y-m-j');
            $fecha_inicio_denuncia = $fecha;    
            $fecha_final_denuncia =$fecha;
            $comisaria_denuncia ="11";
            $fecha1 = date("d-m-Y",strtotime($fecha_inicio_denuncia));
            $fecha2 =date("d-m-Y",strtotime($fecha_final_denuncia));
        
        break;
}

if($estadofecha=='1')
{
    $fecha_inicio_denuncia = $fechainicio;
    $fecha_final_denuncia = $fechafinal;

}

$departamento_completo="";
switch ($departamento) {
    case 'Todos':
    $departamento_completo="";
        
        break;
    
    default:
     $departamento_completo="AND e.direccion like '%\"Departamento\":\"".$departamento."%'";

        
        break;
}

$municipio_completo="";
switch ($municipio) {
    case 'Todos':
    $municipio_completo="";
        
        break;
       
        case 'Seleccione un Municipio':
    $municipio_completo="";
        
        break;
    
    default:
     $municipio_completo="AND e.direccion LIKE '%\"Municipio\":\"".$municipio."%'";

        
        break;
}

$region_completo="";
switch ($region) {
    case 'Todos':
    $region_completo="";
        
        break;
    
    default:
     $region_completo="AND ce.region = '".$region."'";        
        break;
}

$comisaria_completo="";
switch ($comisaria) {
    case 'Todos':
    $comisaria_completo="";
        
        break;
    
    default:
     $comisaria_completo="AND ce.id_cat_entidad  = ".$comisaria."";        
        break;
}

$tipo_sede_completo="";
switch ($tipo_sede) {
    case 'Todos':
    $tipo_sede_completo="";
        
        break;
    
    default:
     $tipo_sede_completo="AND s.id_tipo_sede = ".$tipo_sede."";        
        break;
}

$sede_completo="";
switch ($sede) {
    case 'Todos':
    $sede_completo="";
        
        break;
    
    default:
     $sede_completo="AND ru.id_sede = ".$sede."";        
        break;
}


$condicion_tipo_hecho="";
switch ($tipo_hecho) {
    case 'Todos':
    $condicion_tipo_hecho="AND h.id_hecho_denuncia = h.id_hecho_denuncia";
        
        break;
    
    default:
     $condicion_tipo_hecho="AND h.id_hecho_tipo = ".$tipo_hecho."";        
        break;
}
$condicion_hecho="";
switch ($hechosdenuncia) {
    case 'Seleccione un Hecho':
    $condicion_hecho="";
    $condicionhechoglobal="";      
        break;    
    default:
         $condicion_hecho = "AND chd.nombre_hecho like '%".$hechosdenuncia."%'";
         $condicionhechoglobal ="AND h.nombre_hecho like '%".$hechosdenuncia."%'";              
     break;
}
?>
<?php 
 $sql = "SELECT th.tipo, th.id_hecho_tipo, count(ed.id_evento_detalle) 
                FROM sipol.tbl_evento_detalle ed 
                LEFT JOIN sipol_catalogos.cat_hecho_denuncia h ON ed.id_hecho_denuncia = h.id_hecho_denuncia 
                LEFT JOIN sipol_catalogos.cat_hecho_tipo th ON h.id_hecho_tipo = th.id_hecho_tipo 
                WHERE ed.id_evento IN ( 
                SELECT e.id_evento
                FROM sipol.tbl_evento e, 
                sipol_usuario.tbl_rol_usuario ru, 
                catalogos_publicos.tbl_sede s, 
                catalogos_publicos.cat_entidad ce, 
                sipol.tbl_evento_detalle tbd, 
                sipol_catalogos.cat_hecho_denuncia chd, 
                sipol_usuario.tbl_usuario tblus 
                WHERE ru.id_usuario = e.id_usuario
                AND ru.id_sede = s.id_sede
                AND s.id_cat_entidad = ce.id_cat_entidad
                AND e.fecha_ingreso 
                BETWEEN '$fecha_inicio_denuncia'
                AND '$fecha_final_denuncia'
                AND e.estado = 't'
                AND e.id_tipo_evento = 1
                AND chd.id_hecho_denuncia = tbd.id_hecho_denuncia
            ". $departamento_completo."   
            ".$municipio_completo." 
            ".$region_completo."
            ".$comisaria_completo."
            ".$tipo_sede_completo."
            ".$sede_completo."
            ".$condicion_hecho."
                ) 
                ".$condicionhechoglobal."
                ".$condicion_tipo_hecho." 
                 GROUP BY th.tipo, th.id_hecho_tipo;";

                 //echo $sql;
$resultado = Yii::app()->db->createCommand($sql)->queryAll();
$cabezatabla="";
foreach ($resultado as $key => $value) 
{
    $json = json_encode($value);
    $json = json_decode($json);
    $id_tipo_hecho = $json->id_hecho_tipo;
    if($id_tipo_hecho=="")
    {
    }else{

             $cabezatabla = $cabezatabla."<div class='cuerpo-estadistica'><legend>".$json->tipo ."</legend><table class='table table-hover'>
  <thead>
    <tr>
      <th>Hecho</th>
      <th>Conteo</th>
    </tr>
  </thead>
  <tbody>";
        $subquery = "SELECT e.id_evento
    FROM sipol.tbl_evento e, sipol_usuario.tbl_rol_usuario ru, catalogos_publicos.tbl_sede s, catalogos_publicos.cat_entidad ce
    WHERE ru.id_usuario = e.id_usuario
    AND ru.id_sede = s.id_sede
    AND s.id_cat_entidad = ce.id_cat_entidad
    AND e.fecha_ingreso 
    BETWEEN '$fecha_inicio_denuncia'
    AND '$fecha_final_denuncia'
    AND e.estado = 't'
    AND e.id_tipo_evento = 1
    ". $departamento_completo."   
    ".$municipio_completo." 
    ".$region_completo."
    ".$comisaria_completo."
    ".$tipo_sede_completo."
    ".$sede_completo."
    ";
    $sql2 = "SELECT h.nombre_hecho, count(ed.id_evento_detalle)
    FROM sipol.tbl_evento_detalle ed
    LEFT JOIN sipol_catalogos.cat_hecho_denuncia h ON ed.id_hecho_denuncia = h.id_hecho_denuncia
    WHERE h.id_hecho_tipo IN(".$json->id_hecho_tipo.")
    AND ed.id_evento IN ( ".$subquery.") 
    GROUP BY ed.id_hecho_denuncia, h.nombre_hecho;";
     $resultad2 = Yii::app()->db->createCommand($sql2)->queryAll();


     //echo $sql2;
     //echo "<hr>";
     foreach ($resultad2 as $keyy => $valuee) 
     {
        $jsonnuevo = json_encode($valuee);
        $jsonnuevo = json_decode($jsonnuevo);
        $cabezatabla = $cabezatabla."<tr class='lishechos' nomhecho='".$jsonnuevo->nombre_hecho."'><td>".$jsonnuevo->nombre_hecho."</td><td>".$jsonnuevo->count."</td><tr>";
     }
        $cabezatabla = $cabezatabla."</tbody></table></div>";
    }//fin si el tipo de hecho viene vacio    
}
?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
      <!--Imprime el contedo de los objetos-->
    <?php echo $cabezatabla;?>
    </div>
    <div id="resumenesporhechos">
    <div class="span9">


       
            <?php
            $this->renderPartial('sipol/view_graficas_denuncias',
            array(
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
                'hechosdenuncia'=> $hechosdenuncia
                ));

                ?>


                 <div id="graficatiemposporhechos"></div>

                <?php

       /* $this->renderPartial('sipol/view_mapas',array(
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
                'hechosdenuncia'=> $hechosdenuncia
                ));*/
      ?>


    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
 $('.lishechos').click(function(){
                var nomhecho =  $(this).attr('nomhecho');
               // alert(nomhecho);
                $(this).validarrequeridoslistahechos(nomhecho); 
                });

</script>