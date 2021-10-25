<?php
if(!isset($_SESSION['id_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']==1){
		echo "<div id='menu-painel'>";
			echo "<ul>";
                echo "<li><a href='?pg=modulos/user/direciona' class='hover3'><img src='img/icones/usuarios.png' width='64' height='64' alt='Usuários' title='Usuários' /><br />Usuários</a></li>";
				echo "<li><a href='?pg=modulos/banner/novo&local=principal' class='hover3'><img src='img/icones/banners.png' width='64' height='64' alt='Banners' title='Banners' /><br />Banners</a></li>";
				echo "<li><a href='?pg=modulos/conheca/sobre' class='hover3'><img src='img/icones/empresa.png' width='64' height='64' alt='Nossa História' title='Nossa História' /><br />Nossa História</a></li>";	
				echo "<li><a href='?pg=modulos/conheca/dehonianos' class='hover3'><img src='img/icones/dehonianos.png' width='64' height='64' alt='Dehonianos' title='Dehonianos' /><br />Dehonianos</a></li>";	
				echo "<li><a href='?pg=modulos/conheca/espiritualidade' class='hover3'><img src='img/icones/espiritualidade.png' width='64' height='64' alt='Espiritualidade' title='Espiritualidade' /><br />Espiritualidade</a></li>";	
				echo "<li><a href='?pg=modulos/conheca/sacerdotes' class='hover3'><img src='img/icones/sacerdotes.png' width='64' height='64' alt='Sacerdotes' title='Sacerdotes' /><br />Sacerdotes</a></li>";	
				echo "<li><a href='?pg=modulos/conheca/radio' class='hover3'><img src='img/icones/radio.png' width='64' height='64' alt='Programas de Rádio' title='Programas de Rádio' /><br />Programas de Rádio</a></li>";	
				echo "<li><a href='?pg=modulos/noticias/direciona' class='hover3'><img src='img/icones/noticia.png' width='64' height='64' alt='Noticias' title='Noticias' /><br />Noticias</a></li>";
				echo "<li><a href='?pg=modulos/pastorais/novo' class='hover3'><img src='img/icones/pastorais.png' width='64' height='64' alt='Pastorais' title='Pastorais' /><br />Pastorais</a></li>";
				echo "<li><a href='?pg=modulos/comunidades/novo' class='hover3'><img src='img/icones/comunidade.png' width='64' height='64' alt='Comunidades' title='Comunidades' /><br />Comunidades</a></li>";
				echo "<li><a href='?pg=modulos/artigos/novo' class='hover3'><img src='img/icones/artigos.png' width='64' height='64' alt='Artigos' title='Artigos' /><br />Artigos</a></li>";
				echo "<li><a href='?pg=modulos/horarios/novo' class='hover3'><img src='img/icones/horarios.png' width='64' height='64' alt='Horários de Missa' title='Horários de Missa' /><br />Horários de Missa</a></li>";
				echo "<li><a href='?pg=modulos/informacoes/novo' class='hover3'><img src='img/icones/info.png' width='64' height='64' alt='Info. Importantes' title='Info. Importantes' /><br />Info. Importantes</a></li>";
				echo "<li><a href='?pg=modulos/agenda/novo' class='hover3'><img src='img/icones/agenda.png' width='64' height='64' alt='Agenda' title='Agenda' /><br />Agenda</a></li>";
				echo "<li><a href='?pg=modulos/albuns/novo' class='hover3'><img src='img/icones/afotos.png' width='64' height='64' alt='Galeria de Fotos' title='Galeria de Fotos' /><br />Galeria de Fotos</a></li>";
				echo "<li><a href='?pg=modulos/parceiros/novo' class='hover3'><img src='img/icones/parceiros.png' width='64' height='64' alt='Patrocinadores' title='Patrocinadores' /><br />Patrocinadores</a></li>";
				echo "<li><a href='?pg=modulos/jornal/novo' class='hover3'><img src='img/icones/jornal.png' width='64' height='64' alt='Jornal Online' title='Jornal Online' /><br />Jornal Online</a></li>";
				echo "<li><a href='?pg=config/contato' class='hover3'><img src='img/icones/contato.png' width='64' height='64' alt='Contato' title='Contato' /><br />Contato</a></li>";
				echo "<li><a href='?pg=config/interatividade' class='hover3'><img src='img/icones/interatividade.png' width='64' height='64' alt='Interatividade' title='Interatividade' /><br />Interatividade</a></li>";
				echo "<li><a href='?pg=modulos/news/direciona' class='hover3'><img src='img/icones/news.png' width='64' height='64' alt='Newsletter' title='Newsletter' /><br />Newsletter</a></li>";
				echo "<li><a href='?pg=modulos/popup/novo' class='hover3'><img src='img/icones/popup.png' width='64' height='64' alt='Popup' title='Popup' /><br />Popup</a></li>";
				echo "<li><a href='?pg=config/configPadrao' class='hover3'><img src='img/icones/config.png' width='64' height='64' alt='Configurações' title='Configurações' /><br />Configurações</a></li>";
				echo "<li><a href='http://".$GLOBALS['config']['url']."/stats' target='_blank' class='hover3'><img src='img/icones/stats.png' width='64' height='64' alt='Estatísticas' title='Estatísticas' /><br />Estatísticas</a></li>";
			echo '</ul>';
		echo '</div>';
	}
}
?>