<link rel="stylesheet" type="text/css" href="css/fotos.css" />
<?php if(!isset($_GET['album'])){ ?>
<div class="paginas">
	<div class="util">
		<div class="area_fotos">
			<div class="intro3">GALERIA DE FOTOS</div>
			<ul class="albuns">
				<?php
				$vf = mysql_query("SELECT * FROM album ORDER BY data_reg DESC");
				while($rw = mysql_fetch_object($vf)){
					echo '<a href="./interatividade/fotos/'.$rw->urlcheck.'"><li><img src="area/'.$rw->foto.'" width="280" height="230" alt="'.$rw->festa.'" title="'.$rw->festa.'" /><div class="info">'.$rw->festa.'<br />'.implode("/",array_reverse(explode('-',$rw->data_reg))).'</div></li></a>';
				}
				?>				
			</ul>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</div>
<?php } else if(isset($_GET['album'])){
	$vv = mysql_query("SELECT id, data_reg, festa FROM album WHERE urlcheck='".$_GET['album']."'");
	?>
<script type="text/javascript" language="javascript" src="js/fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<link rel="stylesheet" href="js/fancybox/style.css" />
<script type="text/javascript" language="javascript">
	$(function() {
		$("a[rel=images]").fancybox({
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
				return '<span id="fancybox-title-over"><font color="#efff00" size="2"><strong>(' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ') - ' + title : '') + '</strong></font></span>';
			}
		});
	});
</script>
<div class="paginas">
	<div class="util">
		<div class="area_fotos">
			<div class="intro3">GALERIA DE FOTOS / <?php echo mysql_result($vv,0,"festa"); ?></div>
			<a href="./interatividade/fotos/"><div class="voltar"><img src="img/volta.png" width="32" height="32" alt="Voltar" title="Voltar" /></div></a>
			<?php
			$vf = mysql_query("SELECT * FROM album_fotos WHERE id_album='".mysql_result($vv,0,"id")."' ORDER BY id ASC");
			if(mysql_num_rows($vf)>0){
				echo '<ul class="vefotos">';
				while($rw = mysql_fetch_object($vf)){
					if(!empty($rw->descricao)){
						$d = $rw->descricao;
					} else {
						$d = mysql_result($vv,0,"festa");
					}
					echo '<li><a href="area/'.$rw->foto.'" rel="images" title="'.$d.'"><img src="area/'.$rw->foto.'" width="300" height="250" alt="'.$d.'" title="'.$d.'" />';
					if(!empty($rw->descricao)){
						echo '<div class="info">'.$rw->descricao.'</div>';
					}
					echo '</a></li>';
				}
				echo '</ul>';
			} else {
				echo '<p class="tcentro">Em breve várias fotos aqui para você...</p>';
			}
			?>				
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</div>
<?php } ?>