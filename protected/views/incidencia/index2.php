<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2 cuerpo">
			<div class="navegadorPt">sección1 <div class="arrow-right"></div></div>
			
			<div class="navegadorPt">sección2</div>
		</div>
		<div class="span10 cuerpo">
			Body content
		</div>
	</div>
</div>

<div class="cuerpo">
	<h3 style="text-align:center; margin-top:0px; margin-right:5px; line-height:40px;">Ingreso de Incidencia</h3>

	<div id="menuIncidenciaFloat" hidden>
		<div class="row-fluid">
			<div class="span8 offset2 well navegador">
				<div>
					<div class="pull-left navigationIcon arrowl">
						<img src="images/icons/glyphicons_210_left_arrow.png" class="BotonClose">
					</div>
					<div class="pull-right navigationIcon arrowr">
						<img src="images/icons/glyphicons_211_right_arrow.png" class="BotonClose">
					</div>
					<p>** Part of menu **</p>
				</div>
				
			</div>
		</div>
	</div>

	<div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs" id="menuIncidenciaUl">
			<li class="active"><a href="#tab1" data-toggle="tab">Section 1</a></li>
			<li><a href="#tab2" data-toggle="tab">Section 2</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<div class="accordion-inner">
					<p>I'm in Section 1.</p>
				</div>
			</div>
			<div class="tab-pane" id="tab2">
				<div class="accordion-inner">
					<p>Howdy, I'm in Section 2.</p>
				</div>
			</div>
		</div>
	</div>

</div><!-- FIN DEL CUERPO PRINCIPAL-->

<style type="text/css">

.navegador{
	border:5px solid rgb(227, 227, 227);
	border-radius: 30px 30px 30px 30px;
	text-align: center;
	margin-bottom: 1%;
	padding:0px;
}

.navegador .navigationIcon{
	padding:4.1%;
	background-color:rgb(227, 227, 227);
	cursor:pointer;
}

.navegador p{
	padding:4%;
    margin-bottom: 0px;
	font-size: 16px;
	font-family: inherit;
	font-weight: bold;
	color: inherit;
	text-rendering: optimizelegibility;
}

.navegador .arrowl{
	border-radius: 20px 0 0 20px;
}

.navegador .arrowr{
	border-radius: 0 20px 20px 0;
}	

@media (max-width: 768px){
	.navegador p{
		font-size: 14px;
	}

	#menuIncidenciaUl{
		display: none;
	}

	#menuIncidenciaFloat{
		display: block;
	}
}

.navegadorPt{
	/*padding: 10px;
	border: 4px solid rgb(221, 221, 221);*/
	/*border-radius: 6px 6px 6px 6px;*/
	padding: 8px 14px;
	border: 1px solid rgb(229, 229, 229);
	margin: 0 0 -1px;
	/*border-top-color: rgb(221, 221, 221);
	border-right-color: rgba(0, 0, 0, 0);
	border-bottom-color: rgb(221, 221, 221);
	border-left-color: rgb(221, 221, 221);*/
}

.arrow-right {
	width: 0; 
	height: 0; 
	border-top: 40px solid transparent;
	border-bottom: 40px solid transparent;
	border-left: 40px solid green;
	float: right;
}

</style>

<script type="text/javascript">

$(document).ready(function(){

	$('.navegadorPt').click(function(){
		var elemento = $(this);
		var posicion = elemento.position();
		alert( "left: " + posicion.left + ", top: " + posicion.top );
	}); //fin del click navegadorPt


	getPosition = function () {
      var el = this.$element[0]
      return $.extend({}, (typeof el.getBoundingClientRect == 'function') ? el.getBoundingClientRect() : {
        width: el.offsetWidth
      , height: el.offsetHeight
      }, this.$element.offset())
    }


});


</script>
