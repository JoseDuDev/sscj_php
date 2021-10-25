<link rel="stylesheet" type="text/css" href="css/contato.css" />
<?php
	$vdg = mysql_query("SELECT * FROM gerais");
	$linha = mysql_fetch_object($vdg);
?>
<div class="paginas">
	<div class="util">
		<div class="area_contato">
			<div class="intro3">LOCALIZAÇÃO</div>
			<iframe id="mapa" src="<?php echo $linha->src; ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
			<p><img src="img/icone-mapa2.png" style="float:left; padding: 2px 7px 0px 0px;" alt="" width="14" height="20" />
				<?php
				echo '<span class="maiuscula t16 arial bold">'.$GLOBALS['config']['nome'].'</span><br />';
				echo $GLOBALS['config']['endereco'].'<br />';
				echo $GLOBALS['config']['telefone'];
				?>
			</p>
			<div class="intro7">INSTRUÇÕES</div>
			<div class="clear">&nbsp;</div>
			<p>
				<?php echo nl2br($GLOBALS['config']["atende"]); ?>
			</p>
		</div>
	</div>
</div>