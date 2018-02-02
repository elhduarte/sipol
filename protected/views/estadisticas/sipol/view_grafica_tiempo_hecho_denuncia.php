<legend>Vista Hecho: <?php echo $hecho; ?> </legend>
<?php
/*
ECHO $hecho;
ECHO "<BR>";
ECHO $tipo;
ECHO "<BR>";
ECHO $tiempo;
ECHO "<BR>";
ECHO $departamento;
ECHO "<BR>";
ECHO $municipio;
ECHO "<BR>";
ECHO $region;
ECHO "<BR>";
ECHO $comisaria;
ECHO "<BR>";
ECHO $tipo_sede;
ECHO "<BR>";
ECHO $sede;
ECHO "<BR>";
ECHO $tipo_hecho;
ECHO "<BR>";
ECHO $estadofecha;
ECHO "<BR>";*/

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

$condicion_hechos="";
switch ($tipo_hecho) {
    case 'Todos':
    $condicion_hechos="AND h.id_hecho_denuncia IS NOT NULL";
        
        break;
    
    default:
     $condicion_hechos="AND h.id_hecho_tipo = ".$tipo_hecho."";        
        break;
}

$subquery = "SELECT e.evento_num as numeroevento, e.denuncia_mp as numeromp, e.id_evento,e.fecha_ingreso as fecha , replace('Date.UTC(' || e.fecha_ingreso || ')', '-', ',')  as fecha_ingreso, e.hora_ingreso, e.id_usuario, chd.nombre_hecho, tblus.usuario as usuario 
FROM 
sipol.tbl_evento e, sipol_usuario.tbl_rol_usuario ru, catalogos_publicos.tbl_sede s, 
catalogos_publicos.cat_entidad ce, sipol.tbl_evento_detalle tbd, sipol_catalogos.cat_hecho_denuncia chd, sipol_usuario.tbl_usuario tblus
WHERE ru.id_usuario = e.id_usuario 
AND ru.id_sede = s.id_sede
AND s.id_cat_entidad = ce.id_cat_entidad
AND tblus.id_usuario = e.id_usuario 
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
AND tbd.id_evento = e.id_evento
AND tbd.id_hecho_denuncia = chd.id_hecho_denuncia
AND chd.nombre_hecho = '".$hecho."'
";
?>
<?php
//echo $subquery;
$filarsumen ="";
      $resultadoconteovisitas = Yii::app()->db->createCommand($subquery)->queryAll();
     // var_dump($resultadoconteovisitas);
      $datagraficatiempohecho = "[";
      $datatitulobanderas = "[";

      if(count($resultadoconteovisitas)=="0")
{

    echo "<center><div class='page-header'>
  <h3>Información del Sistema! <small>No se tienen Graficas Registradas...</small></h3>
</div></center>";

}else{

      foreach ($resultadoconteovisitas as $key => $value) 
      {
           $primernivelgrafica = json_encode($value);
            $jsonusuariografica = json_decode($primernivelgrafica);
            $fechajson = $jsonusuariografica->fecha_ingreso;
            $horaingreso = $jsonusuariografica->hora_ingreso;
            $fechaingresonormal = $jsonusuariografica->fecha;
           $fechaingresonormal=date("d-m-Y",strtotime($fechaingresonormal));

            $numeroevento= $jsonusuariografica->numeroevento;
            $numeromp= $jsonusuariografica->numeromp;
            $id_usuario= $jsonusuariografica->id_usuario;
            $nombreusuario= $jsonusuariografica->usuario;


            $nuevahora = str_replace("{", "", $horaingreso);
            $nuevahora = str_replace("}", "", $nuevahora);
            $horaexplote = explode(":", $nuevahora);

             $idevento = $jsonusuariografica->id_evento;
            $idusuario = $jsonusuariografica->id_usuario;


            /*Preparar el resumen para la grafoca */

            if($numeromp == "P")
            {
                $numeromp = "Pendiente";

            }

            $variableencript = new Encrypter;
            $ideventocompilado = $variableencript->compilarget("'".$idevento."'");

          
            $ideventocompilado = trim($ideventocompilado);
            //echo $idEvento; 


            $filarsumen = $filarsumen."<tr>
                              <td><a href='#modalpdfdenuncia'  idevento='".$ideventocompilado."' class='numeroeventoclase' data-toggle='modal'>".$numeroevento."</a></td>
                              <td>".$numeromp."</td>
                              <td>".$fechaingresonormal."</td>
                              <td>".$nuevahora."</td>
                              <td><a  target='_blank' href='index.php?r=tblUsuario/view&id=".$id_usuario."'><i class='icon-user'></i> ".$nombreusuario."</a></td>
                            </tr>";

            /*fin del preparado de la tabla*/
            
            if($horaexplote[0] == "00")
            {
            	//echo $horaexplote[0];
            	$horaexplote[0] = "0";
            }else{
            	//echo $horaexplote[0];

            }
			$horaenviada = $horaexplote[0].".".$horaexplote[1];
            $datagraficatiempohecho = $datagraficatiempohecho."[".$fechajson.",".$horaenviada."],";   


            //creacion de data para grafica de usuarios

           

            $datatitulobanderas =  $datatitulobanderas."{
					x : ".$fechajson.",
					title : '".$idevento."',
					text : 'Este es el Id de usuario ".$idusuario."'
				},";    
        # code...
      }

        $datagraficatiempohecho = $datagraficatiempohecho."&]";
        $datagraficatiempohecho = str_replace(",&", "", $datagraficatiempohecho);

        $datatitulobanderas = $datatitulobanderas."&]";
        $datatitulobanderas = str_replace(",&", "", $datatitulobanderas);
      //echo $datagraficatiempohecho;

/*
echo $datagraficatiempohecho;
echo "<hr><br>";
echo $datatitulobanderas;
echo "<hr><br>";*/

?>


<SCRIPT TYPE="text/javascript">
 $(document).ready(function()
 {

$(function() {
		var data = <?php echo $datagraficatiempohecho; ?>;
		var datatitulo = <?php echo $datatitulobanderas; ?>;
		$('#graficatipotiempohecho').highcharts('StockChart', {
			

			rangeSelector : {
				selected : 1
			},

			title : {
				text : 'Resumen de Ingresos por Hora'
			},         
			
			tooltip: {
				style: {
					width: '200px'
				},
				valueDecimals: 2
			},
			
			yAxis : {
				title : {
					text : 'Rango de Horas'
				},
                /*plotLines : [{
                    value : 23.59,
                    color : 'green',
                    dashStyle : 'shortdash',
                    width : 2,
                    label : {
                        text : '23:59 Horas'
                    }
                }, {
                    value : 0.00,
                    color : 'red',
                    dashStyle : 'shortdash',
                    width : 2,
                    label : {
                        text : '00:00 Horas'
                    }
                }]*/
			},

			series : [{
				name : 'Hora Denuncia',
				data : data,
				id : 'dataseries'
			},
			// the event marker flags
			{
				type : 'flags',
				data : datatitulo,			
				onSeries : 'dataseries',
				shape :  "url(http://localhost/sipol/images/ICON_DENUNCIA.png)",
				width : 16,
				style: { // text style
	        	color: 'white'
	        },
			}]
		});
});
});

 <?php
   $datagraficatiempohecho = "";
   $datatitulobanderas = "";
 ?>
</script>
<div id="graficatipotiempohecho" style="height: 300px;" ></div>

<table class="table table-striped">
  <caption>Resumen de Filtro</caption>
  <thead>
    <tr>
        <th>Numero Denuncia </th>
        <th>Numero de MP </th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Usuario</th>

    </tr>
  </thead>
  <tbody>
   <?php echo $filarsumen; ?>
  </tbody>
</table>


<script type="text/javascript">
$(document).ready(function(){
    $('.numeroeventoclase').click(function(){
        var par =  $(this).attr('idevento');
        //alert($(this).html());
        //alert(par);

    $.ajax({
    type: "POST",
    url: 'index.php?r=Reportespdf/DenunciaEstadistica',
    data: {
        par:par
    },
     beforeSend: function(html)
    {
       $('#modalprocesando').modal({
                show: true,
                keyboard: false,
                backdrop: "static"
            });
    },//fin beforesend
    success: function(result)
    {           
       $('#modalprocesando').modal('hide'); 
      /*$("#cmb_mupio").empty();
      $("#cmb_mupio").html(result);
      $("#cmb_mupio").removeAttr('disabled');  */ 
      //var urldenuncia = '<iframe src="http://172.17.46.77/sipol/temp/denuncias/'+result+'" width="500" height="680" style="border: none;"></iframe>'; 
      var urldenuncia = '<iframe src="http://sipol.mingob.gob.gt/sipol_betha/temp/denuncias/'+result+'" width="500" height="680" style="border: none;"></iframe>'; 
       
       $("#iframedenuncia").html(urldenuncia);        
    }
  });
    //return false;
});



});
</script>

<?php

}
?>

  

