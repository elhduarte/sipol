<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/lib/js/jquery-scrollspy.js"></script><div class="cuerpo">

<div class="row-fluid">
	<div class="span2">
		<div class="MenuPegado" id="menuPegado">
			<ul class="nav nav-tabs nav-stacked">
			<li class="activo" id="liResumen">
			<a href="#resumen" id="aResumen">Resumen</a>
			</li>
			<li id="liRelato"><a href="#relato" id="aRelato">Relato</a></li>
			<li id="liHechos"><a href="#hechos" id="aHechos">Hechos</a></li>
			</ul>
		</div>
	</div>
	<div class="span10 well">
		<div class="tab-content">
			<div class="tab-pane active" id="resumen">
				<?php $this->renderPartial('resumen', array('idEvento'=>'111')); ?>
			</div>
			<div class="tab-pane active" id="relato">
				<?php $this->renderPartial('relato', array('idEvento'=>'111')); ?>
			</div>
		</div>
	</div>
</div>


</div>

<script type="text/javascript">
       $(document).ready(function() {
       	 $('.color').each(function(i) {
       	 var position = $(this).position();
       	 console.log(position);
       	 console.log('min: ' + position.top + ' / max: ' + parseInt(position.top + $(this).height()));
       	 $(this).scrollspy({
       	 min: position.top,
       	 max: position.top + $(this).height(),
       	 onEnter: function(element, position) {
       	 if(console) console.log('entering ' +  element.id);
        $("body").css('background-color', element.id);
       	 },
       	 onLeave: function(element, position) {
       	 if(console) console.log('leaving ' +  element.id);
       	 // $('body').css('background-color','#eee');
       	 }
       	 });
       	 });
       	 });
       	</script>

<script type="text/javascript">

	$(document).ready(function(){
		
		$.fn.limpiarActivos = function()
		{
			$('#menuPegado').find('li').each(function(){
				$(this).removeClass('activo');
			});
		}

		$('#aRelato').click(function(){
			$(this).limpiarActivos();
			$('#liRelato').addClass('activo');
		});

		$('#aResumen').click(function(){
			$(this).limpiarActivos();
			$('#liResumen').addClass('activo');
		});

		$('#aHechos').click(function(){
			$(this).limpiarActivos();
			$('#liHechos').addClass('activo');
		});

	});// Fin del document ready

	var $window = $(window);

	$('.MenuPegado').affix({
        offset: {
          top: function () { return $window.width() <= 980 ? 290 : 135 }
        , bottom: 270
        }
      });

</script>

<style type="text/css">

	.MenuPegado{
		display: block;
		width: 200px;
	}

	.MenuPegado.affix{
		top:15px;
	}

	.MenuPegado.affix-bottom{
		position: absolute;
  		top: auto;
	}

	.nav-tabs>.activo>a, .nav-tabs>.activo>a:hover {
	color: rgb(255, 255, 255);
	cursor: default;
	background-color: rgb(65,139,202);

	}

</style>