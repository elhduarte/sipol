<?php

class Drilldown extends CWidget
{
	//variables que seran publicas y que voy a utilizar
	public $titulo = "";
	public $legenda = "";
	public $titulo2 = "";
	public $serieDrilldown = "";
	public $data = "";
	public $divBarras ="" ;
	public $divPie="";

	//funcion que inicializa el widget
	public function init()
	{ 
		$salida="<script type=\"text/javascript\">
			// Internationalization
Highcharts.setOptions({
    lang: {
        drillUpText: '◁ Regresar'
    }
});

var options = {

    chart: {
        height: 300
    },
    
    title: {
        text: '".$this->titulo."'
    },

    xAxis: 
    {
        categories: true
    },
    
    drilldown: {
        series: ".$this->serieDrilldown."
    },
    
    legend: {
        enabled: ".$this->legenda."
    },
    
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true
            },
            shadow: false
        },
        pie: {
            size: '80%'
        }
    },
    
    series: ".$this->data."
};

		// Column chart
		options.chart.renderTo = '".$this->divBarras."';
		options.chart.type = 'column';
		var chart1 = new Highcharts.Chart(options);

		// Pie
		options.chart.renderTo = '".$this->divPie."';
		options.chart.type = 'pie';
		var chart2 = new Highcharts.Chart(options);
		</script>";

		echo $salida;

	}//fin de funcion init

}//fin de la clase drilldown

?>