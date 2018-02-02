



    <link href="<?php echo Yii::app()->request->baseUrl; ?>/lib//agenda_policial/css/tribal-bootstrap.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib//agenda_policial/css/tribal-timetable.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/agenda_policial/js/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/agenda_policial/js/bootstrap-collapse.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/agenda_policial/js/tribal.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/agenda_policial/js/tribal-shared.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/agenda_policial/js/tribal-timetable.js"></script>

<div class="row-fluid">
  <div class="span12 well">
       <div class="timetable" data-days="5" data-hours="25">
            <ul class="tt-events">
<?php 

if(isset($_SESSION['fechaagenda']))
{
$horai=0;
$minutosi =0;
$segundosi= 0;
$horaf=0;
$minutosf =0;
$segundosf= 0;	
$restahoras =0;			
$variableprioridad = "tt-event btn-primary";
$contador = 0;
$variableingresada =0;
$asuntodeagenda ="";
$horain = "";
$horafi ="";
$ubicacionfinal ="";
        $sql = "select b.id_detalle_parte_policial, b.hora_inicio, b.hora_final,b.ubicacion,b.asunto, b.prioridad 
 from  sipol_2.tbl_parte_policial_detalle b,  sipol_2.tbl_parte_policial  a
where a.id_parte_policial = b.id_parte_policial
and a.id_agente =511 and a.fecha_parte = ".$_SESSION['fechaagenda']."";
        
            $resultado = Yii::app()->db->createCommand($sql)->queryAll();
            //echo count($resultado);

            if (count($resultado)>=1)
            {
                                foreach($resultado as $key => $value)
                                    {
                                        $variablearray = $value;
                                        //print_r($value);
                                        //echo "<br>";
                                        while (list($clave, $valor) = each($value)) 
                                          {

                                                if($clave=="hora_inicio")
                                                    {          
                                                    
                                   
                                                       $nueva = str_replace("{", "", $valor);
                                                       $nueva = str_replace("}", "",  $nueva);
                                                       $horain = $nueva;

                                                        $nuevo  = explode(":",  $nueva);
                                                            
                                                                foreach ($nuevo as $keyy => $valuey) 
                                                                {
                                                                    if($keyy==0)
                                                                        {
                                                                            $horai= $valuey;
                                                                        }elseif ($keyy==1) 
                                                                        {
                                                                                  $minutosi = (($valuey * 100)/60);
                                                                        }elseif ($keyy==2) 
                                                                        {
                                                                                  $segundosi= $valuey;
                                                                        }//FIN DLE IF ELSE
                                                                }//FIN DEL FOR                                                                
                                                    }//FIN DEL IF HORA INICIO
                                                    else if($clave=="hora_final")
                                                    {          
                                                                                           
                                                            $nueva = str_replace("{", "", $valor);
                                                            $nueva = str_replace("}", "",  $nueva);
                                                            $horafi =$nueva; 
                                                            $nuevo  = explode(":",  $nueva);
                                                            
                                                                foreach ($nuevo as $keyy => $valuey) 
                                                                {
                                                                    if($keyy==0)
                                                                        {
                                                                            $horaf= $valuey;
                                                                        }elseif ($keyy==1)
                                                                         {
                                                                            $minutosf = (($valuey * 100)/60); 
                                                                        }elseif ($keyy==2) 
                                                                        {
                                                                                  $segundosf= $valuey;                                                                     
                                                                        }                                                                
                                                                }//FIN DEL FOR
                                                                $horainiciofinal = $horai.".".$minutosi;
                                                                $horafinalfinal = $horaf.".".$minutosf;
                                                                $restahoras = $horafinalfinal - $horainiciofinal;
                                                    }//FIN DE IF HORA FINAL
											if($clave =="prioridad")
                                            {
                                                //echo "esta es la prioridad".$valor;
                                                //echo "<br>";

                                                if($valor=="1")
                                                {
                                                    $variableprioridad = "tt-event btn-success";

                                                }elseif($valor=="2")
                                                {
                                                    $variableprioridad = "tt-event btn-warning";

                                                }elseif($valor=="3")
                                                {
                                                    $variableprioridad = "tt-event btn-danger";

                                                }

                                            }
                                                if($clave =="asunto")
                                            {
                                               $asuntodeagenda = $valor;

                                            }if($clave == "ubicacion")
                                            {
                                                $ubicacionfinal = $valor;
                                            }


                                                  



                                            } //while
											    echo "<li class='".$variableprioridad."' data-id='10' data-day='0' data-start='".$horai."' data-duration='".$restahoras."'>
                    $asuntodeagenda<br />
                    $horain - $horafi<br />
                    $ubicacionfinal<br />                    
                    </li>";
											
											
                                    }//foreach                                                             
            }//fin del if
            else
            {
                //echo "no ingreso al if";
            }




}else
{
//echo "la session no esta isset... !";

}




                       
 ?>
            </ul>
            
                 <div class="tt-times">
                <div class="tt-time" data-time="0">
                    00<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="1">
                    01<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="2">
                    02<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="3">
                    03<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="4">
                    04<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="5">
                    05<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="6">
                    06<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="7">
                    07<span class="hidden-phone"></span></div>
                    <div class="tt-time" data-time="8">
                    08<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="9">
                    09<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="10">
                    10<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="11">
                    11<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="12">
                    12<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="13">
                    13<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="14">
                    14<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="15">
                    15<span class="hidden-phone"></span></div>
                    <div class="tt-time" data-time="16">
                    16<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="17">
                    17<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="18">
                    18<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="19">
                    19<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="20">
                    20<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="21">
                    21<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="22">
                    22<span class="hidden-phone"></span></div>
                <div class="tt-time" data-time="23">
                    23<span class="hidden-phone"></span></div>
                     <div class="" data-time="24">
                   .<span class=""></span></div>
            </div>
            <div class="tt-days">
                <div class="tt-day" data-day="0">
                    Hoy<span class="hidden-phone"></span></div>
            </div>
        </div>  
  </div>
</div>
