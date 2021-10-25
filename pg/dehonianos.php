<link rel="stylesheet" type="text/css" href="css/institucional.css" />
<div class="paginas">
	<div class="util">
		<div class="area_empresa">
			<div class="intro3">DEHONIANOS</div>
			<p class="tahomanormal cornormal"><?php echo nl2br(mysql_result(mysql_query("SELECT texto FROM empresa WHERE id='2'"),0,"texto")); ?></p>
		</div>
	</div>
</div>