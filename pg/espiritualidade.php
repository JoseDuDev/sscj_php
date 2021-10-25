<link rel="stylesheet" type="text/css" href="css/espiritualidade.css" />
<script type="text/javascript" language="javascript">
	$(function() {
		$('.fechaudio').click(function(){
			$('.audio, .maskaudio, .fechaudio').fadeOut(150);
			$('.audio').html('');
		});
	});
	function ouveSom(som,id){
		$('#audio'+id).html('').html("<object type='application/x-shockwave-flash' data='flash/player.swf' id='audioplayer1' height='24' width='290'><param name='movie' value='flash/player.swf'><param name='FlashVars' value='playerID=1&bg=0xf8f8f8&leftbg=0xeeeeee&lefticon=0x666666&rightbg=0xb8b160&rightbghover=0x999999&righticon=0x323232&righticonhover=0xffffff&text=0x666666&slider=0x666666&track=0xFFFFFF&border=0x666666&loader=0xb8b160&loop=yes&autostart=yes&soundFile=area/"+som+"'><param name='quality' value='high'><param name='menu' value='false'><param name='wmode' value='transparent'></object>");
		$('#audio'+id+', .maskaudio, .fechaudio').fadeIn(250);
	}
</script>

<div class="fechaudio">&nbsp;</div>
<div class="maskaudio">&nbsp;</div>

<div class="paginas">
	<div class="util">
		<div class="area_espiritualidade">
			<div class="intro3">ESPIRITUALIDADE</div>
			<p class="tahomanormal cornormal tcentro"><?php echo nl2br(mysql_result(mysql_query("SELECT texto FROM empresa WHERE id='3'"),0,"texto")); ?></p>
			<div class="titulo">AS DOZE PROMESSAS DO SAGRADO CORAÇÃO DE JESUS<div>A SANTA MARGARIDA MARIA ALACOQUE</div></div>
		</div>
	</div>
	<div class="util">
		<ul class="itens_espiritualidade">
			<?php
			$ve = mysql_query("SELECT * FROM espiritualidade ORDER BY id_o ASC");
			while($ln = mysql_fetch_object($ve)){
				$vf = explode(".", $ln->som);
				echo '<li><span>'.$ln->id_o.'</span>';
				if($ln->som!='' && $vf[1]!=''){
					echo ' <div class="player" onclick="ouveSom(\''.$ln->som.'\','.$ln->id.');">&nbsp;</div>';
					echo '<div class="audio" id="audio'.$ln->id.'">&nbsp;</div>';
				}
				echo ' <p>'.$ln->titulo.'</p></li>';
			}
			?>
		</ul>
	</div>
	<div class="clear">&nbsp;</div>
	<div style="height: 100px; width: 100%;">&nbsp;</div>
	<div class="clear"></div>
</div>