<link rel="stylesheet" type="text/css" href="css/sacerdotes.css" />
<?php if(!isset($_GET['url'])){ ?>
	<div class="paginas">
		<div class="util">
			<div class="area_sacerdotes">
				<div class="intro3">SACERDOTES</div>
			</div>
		</div>
		<div class="util">
			<ul class="itens_sacerdotes">
				<?php
				$ve = mysql_query("SELECT * FROM sacerdotes WHERE status='S' ORDER BY id_o ASC");
				while($ln = mysql_fetch_object($ve)){
					echo '<a href="./institucional/sacerdotes/'.$ln->urlcheck.'">';
					echo '<li>';
						echo '<div class="image"><img src="area/'.$ln->imagem.'" width="150" height="170" alt="" title="" /></div>';
						echo '<div class="info">'.$ln->titulo.'<div>';
						if(strlen(strip_tags($ln->descricao))>550){ echo truncate(strip_tags($ln->descricao), 550, ' (...)'); } else { echo strip_tags($ln->descricao); }
						echo '</div></div>';
					echo '</li>';
					echo '</a>';
				}
				?>
			</ul>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
<?php } else { ?>
	<div class="paginas">
		<div class="util">
			<div class="area_sacerdotes">
				<div class="intro3">SACERDOTES</div>
			</div>
		</div>
		<div class="util">
			<ul class="item_sacerdotes">
				<?php
				$ve = mysql_query("SELECT * FROM sacerdotes WHERE urlcheck='".$_GET['url']."'");
				while($ln = mysql_fetch_object($ve)){
					echo '<li>';
						echo '<a href="./institucional/sacerdotes/"><div class="voltar"><img src="img/volta.png" width="32" height="32" alt="Voltar" title="Voltar" /></div></a>';
						echo '<div class="image"><img src="area/'.$ln->imagem.'" width="350" alt="'.$ln->titulo.'" title="'.$ln->titulo.'" /></div>';
						echo '<div class="info">'.$ln->titulo.'<div>'.nl2br($ln->descricao).'</div></div>';
					echo '</li>';
				}
				?>
			</ul>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
<?php } ?>