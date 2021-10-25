<link rel="stylesheet" type="text/css" href="css/pastorais.css" />
<?php if(isset($_GET['url'])){ ?>
<script type="text/javascript" language="javascript" src="js/jquery.carouFredSel-6.0.4-packed.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" language="javascript" src="js/fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<link rel="stylesheet" href="js/fancybox/style.css" />
<script type="text/javascript" language="javascript">
	$(function() {
		$('#foo2').carouFredSel({
			auto: false,
			prev: '#prev2',
			next: '#next2',
			pagination: "#pager2",
			mousewheel: true,
			scroll: 2,
			swipe: {
				onMouse: true,
				onTouch: true
			}
		});
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
<?php
$vd = mysql_query("SELECT id, titulo, introducao, icone FROM pastorais WHERE urlcheck='".$_GET['url']."'");
?>
<div class="paginas">
	<div class="util">
		<div class="area_empresa">
			<div class="intro3"><?php echo mysql_result($vd,0,"titulo"); ?></div>
			<a href="./pastorais/"><div class="voltar"><img src="img/volta.png" width="32" height="32" alt="Voltar" title="Voltar" /></div></a>
			<?php if(file_exists('area/'.mysql_result($vd,0,"icone"))){ ?>
				<a href="area/<?php echo mysql_result($vd,0,"icone"); ?>" rel="images" title="<?php echo mysql_result($vd,0,"titulo"); ?>"><img src="area/<?php echo mysql_result($vd,0,"icone"); ?>" style="float:left; padding: 50px 20px 20px 0px;" width="400" alt="<?php echo mysql_result($vd,0,"titulo"); ?>" title="<?php echo mysql_result($vd,0,"titulo"); ?>" /></a>
			<?php } ?>
			<p class="tahomanormal cornormal"><?php echo nl2br(mysql_result($vd,0,"introducao")); ?></p>
			<div class="clear">&nbsp;</div>
			<div class="list_carousel">
				<ul id="foo2">
					<?php
					$vfe = mysql_query("SELECT * FROM fotos_produtos WHERE id_p='".mysql_result($vd,0,"id")."' ORDER BY id_o ASC");
					while($lna = mysql_fetch_object($vfe)){
						if($lna->titulo!=''){ $desc = $lna->titulo; } else { $desc = mysql_result($vd,0,"titulo"); }
						echo '<li><a href="area/'.$lna->foto.'" rel="images" title="'.$desc.'"><img src="area/'.$lna->foto.'" width="171" height="171" alt="'.$desc.'" title="'.$desc.'" /></a></li>';
					}
					?>
				</ul>
				<div class="clearfix"></div>
				<a id="prev2" class="prev" href="#">&nbsp;</a>
				<a id="next2" class="next" href="#">&nbsp;</a>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="paginas">
	<div class="util">
		<div class="area_empresa">
			<div class="intro3">PASTORAIS E MOVIMENTOS</div>
			<div class="clear">&nbsp;</div>
			<ul id="pastoral">
				<?php
				$vfe = mysql_query("SELECT * FROM pastorais WHERE status='S' ORDER BY id_o ASC");
				while($ln = mysql_fetch_object($vfe)){
					echo '<a href="./pastorais/'.$ln->urlcheck.'">';
					echo '<li>';
						echo '<div class="image"><img src="area/'.$ln->icone.'" width="171" height="150" alt="'.$ln->titulo.'" title="'.$ln->titulo.'" /></div>';
						echo '<div class="contexto">'.$ln->titulo.'<div>';
						if(strlen(strip_tags($ln->introducao))>180){ echo truncate(strip_tags($ln->introducao), 180, ' (...)'); } else { echo strip_tags($ln->introducao); }
						echo '</div></div>';
					echo '</li>';
					echo '</a>';
				}
				?>
			</ul>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php } ?>