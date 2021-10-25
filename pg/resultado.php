<link rel="stylesheet" type="text/css" href="css/noticias.css" />
<div class="paginas">
	<div class="util">
		<div class="area_noticias">
			<div class="intro3">RESULTADO DA BUSCA</div>
		</div>
		<div class="historico">
			<ul>
				<?php
				$vdp = mysql_query("SELECT * FROM noticias WHERE url_check LIKE '%".$_GET['termo']."%' ORDER BY data_reg DESC");
				if(mysql_num_rows($vdp)>0){
					while($ln = mysql_fetch_object($vdp)){
						$dv 	= explode(" ", $ln->data_reg);
						$part   = explode("-", $dv[0]);
						if($ln->comunidade=='0'){
							echo '<a href="./noticias/'.mysql_result(mysql_query("SELECT urlcheck FROM categoria WHERE id='".$ln->categoria."'"),0,"urlcheck").'/'.$ln->url_check.'">';
						} else {
							echo '<a href="./comunidades/noticias/'.mysql_result(mysql_query("SELECT urlcheck FROM comunidades WHERE id='".$ln->comunidade."'"),0,"urlcheck").'/'.$ln->url_check.'">';
						}
						echo '<li>';
						echo '<div class="image"><img src="http://'.$GLOBALS['config']['url'].'/pg/timthumb.php?src=area/'.$ln->imagem.'&w=150&h=200&q=95" width="150" height="200" alt="'.$ln->titulo.'" title="'.$ln->titulo.'" /></div>';
							echo '<div class="topico">';
							echo '<div class="vdata">'.$part[2].'<div>'.substr(escreveMes($part[1]),0,3).'</div></div>'.$ln->titulo.'</div>
							<div class="contexto">';
							if(strlen(strip_tags($ln->conteudo))>450){ echo truncate(strip_tags($ln->conteudo), 450, ' (...)'); } else { echo strip_tags($ln->conteudo); }
							echo '</div>
						</li>';
						echo '</a>';
					}
				} else {
					echo '<p style="padding: 30px 0px; text-align: center;" class="t14">Nenhum resultado encontrado...</p>';
				}
				?>
			</ul>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>
