<link rel="stylesheet" type="text/css" href="css/programas.css" />
<div class="paginas">
	<div class="util">
		<div class="area_programas">
			<div class="intro3">PROGRAMAS DE RÁDIO</div>
		</div>
		<div class="intro4">PROGRAMAS</div>
	</div>
	<div class="util">
		<ul class="itens_programas">
			<?php
			$ve = mysql_query("SELECT * FROM radio WHERE status='S' ORDER BY id_o ASC");
			while($ln = mysql_fetch_object($ve)){
				echo '<li>';
					echo '<div class="info">';
						echo $ln->nome.'<p>'; if(strlen(strip_tags($ln->descricao))>550){ echo truncate(strip_tags($ln->descricao), 550, ' (...)'); } else { echo strip_tags($ln->descricao); } echo '</p>';
						echo '<span>'.$ln->info.'</span>';
						echo '<a href="http://'.$ln->link.'" target="_blank"><div class="ouca">Ouça ao vivo</div></a>';
					echo '</div>';
				echo '</li>';
			}
			?>
		</ul>
	</div>
	<div class="clear">&nbsp;</div>
</div>