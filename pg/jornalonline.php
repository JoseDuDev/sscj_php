<link rel="stylesheet" type="text/css" href="css/jornalonline.css" />
<?php if(isset($_GET['ver'])) { ?>
<script type="text/javascript" src="pg/forma-guia/swfobject/swfobject.js"></script>
<script type="text/javascript" src="pg/forma-guia/swfaddress/swfaddress.js"></script>
<script type="text/javascript">
	swfobject.embedSWF("pg/forma-guia/megazine.swf", "megazine", "950", "850", "9.0.115", "megazine/swfobject/expressInstall.swf", null, {bgcolor : "#ffffff", allowFullscreen : "true"}, {id : "megazine"});
</script>    
<style type="text/css">
	h1				{ color: #FFFFFF; }
	img 			{ border: none; }
	p 				{ color: #ffffff; font-size: 0.8em; }
	#megazine 		{ outline: none; }
	div#alttext 	{ margin: 0 auto 0 auto; width: 950px; }
</style>
<?php } ?>
<div class="paginas">
	<div class="util">
		<div class="area_noticias">
			<div class="intro3">JORNAL ON-LINE</div>
		</div>
	</div>

	<div id="util">
		<div class="guia-on">		
			<?php
			if(!isset($_GET['ver'])){
				$vuo = mysql_query("SELECT * FROM jornal ORDER BY id_o ASC");
				echo '<ul>';
				while($lna = mysql_fetch_object($vuo)){
					if(!empty($lna->capa)){
						echo '<li>';
						if(empty($lna->isuu)){
							echo '<a href="./interatividade/jornal-on-line/'.$lna->urlcheck.'" class="cat">';
						} else {
							echo '<a href="'.$lna->isuu.'" class="cat" target="_blank">';
						}
						echo '<img src="area/'.$lna->capa.'" width="280px;" height="406" /><br /><span>'.$lna->titulo.'</span></a></li>';
					} else {
						$vtf = mysql_query("SELECT foto FROM jornal_fotos WHERE id_jornal='".limpa($lna->id)."' ORDER BY id_o ASC LIMIT 1");
						if(mysql_num_rows($vtf)>0){
							echo '<li>';
							if(empty($lna->isuu)){
								echo '<a href="./interatividade/jornal-on-line/'.$lna->urlcheck.'" class="cat">';
							} else {
								echo '<a href="'.$lna->isuu.'" class="cat" target="_blank">';
							}
							echo '<img src="area/'.mysql_result($vtf,0,"foto").'" width="280px;" height="406" /><br /><span>'.$lna->titulo.'</span></a></li>';
						}
					}
				}
				echo '</ul>';
			} else {
				echo '<a href="./interatividade/jornal-on-line/"><div class="voltar"><img src="img/volta.png" width="32" height="32" alt="Voltar" title="Voltar" /></div></a>';
				$idguia = mysql_result(mysql_query("SELECT id FROM jornal WHERE urlcheck='".limpa($_GET['ver'])."'"),0,"id");
				function alteraxml($idg){
					$ttf = mysql_query("SELECT * FROM jornal_fotos WHERE id_jornal='".limpa($idg)."' ORDER BY id_o ASC");
					$arquivo = "pg/forma-guia/megazine.xml";
					$ponteiro = fopen($arquivo, "w");
					fwrite($ponteiro, "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n");
					fwrite($ponteiro, "<book bgcolor='0xCCCC99' pageheight='620' pagewidth='457' lang='en'>\r\n");
					fwrite($ponteiro, "	 <chapter>");
					$conteudo  = "\r\n";
					$c=0;
					while($linha = mysql_fetch_object($ttf)) {
						$c++;
						$conteudo .= "		<page";
						if($c == "1" && $c == mysql_num_rows($ttf)) { $conteudo .= " stiff='true'"; }
						$conteudo .= ">
							<img src='../../area/".$linha->foto."' aa='true' width='457' height='620'/>
						</page>\r\n";
					}  
					$conteudo .= "	 </chapter>\r\n";
					fwrite($ponteiro, $conteudo);
					fwrite($ponteiro, "</book>");
					fclose($ponteiro);
				}
		    	alteraxml($idguia);
			    echo '<div>
			        <div id="megazine">
			            <div id="alttext">
			                <h1>Atualize seu FlashPlayer!</h1>
			                <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
			                <p>Por favor deixe seu JavaScript ativado.</p>
			            </div>
			        </div>
			    </div>';
			}
			?>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>