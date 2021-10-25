<link rel="stylesheet" type="text/css" href="css/institucional.css" />
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
$vd = mysql_query("SELECT texto, imagem FROM empresa WHERE id='1'");
?>
<div class="paginas">
	<div class="util">
		<div class="area_empresa">
			<div class="intro3">NOSSA HISTÓRIA</div>
			<?php if(file_exists('area/'.mysql_result($vd,0,"imagem"))){ ?>
				<a href="area/<?php echo mysql_result($vd,0,"imagem"); ?>" rel="images" title="Nossa História"><img src="area/<?php echo mysql_result($vd,0,"imagem"); ?>" style="float:left; padding: 50px 20px 20px 0px;" width="400" alt="Nossa História" title="Nossa História" /></a>
			<?php } ?>
			<p class="tahomanormal cornormal"><?php echo nl2br(mysql_result($vd,0,"texto")); ?></p>
			<div class="clear">&nbsp;</div>
			<div class="list_carousel">
				<ul id="foo2">
					<?php
					$vfe = mysql_query("SELECT * FROM fotos_empresa ORDER BY id_o ASC");
					while($ln = mysql_fetch_object($vfe)){
						if($ln->descricao!=''){ $desc = $ln->descricao; } else { $desc = $GLOBALS['config']['nome']; }
						echo '<li><a href="area/'.$ln->foto.'" rel="images" title="'.$desc.'"><img src="area/'.$ln->foto.'" width="171" height="171" alt="'.$desc.'" title="'.$desc.'" /></a></li>';
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