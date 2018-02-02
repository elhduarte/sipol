
<div class="span9">

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
                 <div id="graficatiemposporhechos">
                 	<?php

						$this->renderPartial('sipol/view_grafica_tiempo_hecho_denuncia',
						array(
						'hecho'=>$hechosdenuncia,
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