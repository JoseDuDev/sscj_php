<link rel="stylesheet" type="text/css" href="css/noticias.css" />
<?php
if(isset($_GET['noticia'])){
	$vu = mysql_query("SELECT * FROM agenda WHERE urlcheck='".$_GET['noticia']."'");
	$dados = mysql_fetch_object($vu);
	?>
	<div class="paginas">
		<div class="util" style="margin-top: 14px;">
			<div class="area_agenda">
				<div class="intro3">agenda</div>
			</div>
		</div>
		<div class="relacionados">
			<div class="intro10">Outros Eventos</div>
			<ul class="vemais">
				<?php
				if(!isset($_GET['noticia'])){
					$sql = mysql_query("SELECT * FROM agenda");
				} else {
					$sql = mysql_query("SELECT * FROM agenda WHERE urlcheck!='".$_GET['noticia']."'");
				}
				$lpp = 6;
				$total = mysql_num_rows($sql);
				$paginas = ceil($total / $lpp); 
				$pagina = (!isset($_GET['pagina']))?0:$_GET['pagina']; 
				$inicio = $pagina * $lpp;
				if(!isset($_GET['noticia'])){
					$vu = mysql_query("SELECT * FROM agenda ORDER BY data_reg DESC LIMIT $inicio, $lpp");
				} else {
					$vu = mysql_query("SELECT * FROM agenda WHERE urlcheck!='".$_GET['noticia']."' ORDER BY data_reg DESC LIMIT $inicio, $lpp");
				}
				while($ln = mysql_fetch_object($vu)){
					echo '<a href="./interatividade/agenda/'.$ln->urlcheck.'">';
					echo '<li>';
						echo '<div class="topico">';
						if(strlen(strip_tags($ln->nome))>15){ echo truncate(strip_tags($ln->nome), 15, '...'); } else { echo strip_tags($ln->nome); }
						echo '</div>
						<div class="contexto">';
						if(strlen(strip_tags($ln->descricao))>80){ echo truncate(strip_tags($ln->descricao), 80, ' (...)'); } else { echo strip_tags($ln->descricao); }
						echo '</div>
					</li>';
					echo '</a>';
				}
				?>
			</ul>
			<?php
			if($total > $lpp) {
				echo '<div class="clear"></div>';
				echo '<div class="paginacao">';
				for($i = 0; $i < $paginas; $i++) {
					$linksp = $i + 1;
					if ($pagina == $i) {
						print " <span class='sera'>$linksp</span>";
					} else {
						print " <a href='./interatividade/agenda";
						if(isset($_GET['noticia'])){
							echo "/".$_GET['noticia'];
						}
						echo "/pagina/$i' class='ser'>$linksp</a>";
					}
				}
				echo '</div>';	
			}
			?>
		</div>
		<div class="util">
			<div class="utilnn">
				<div class="area_contato" style="min-height: 50px;">
					<div class="intro9 menos1"><?php echo $dados->nome; ?></div>
				</div>
				<div class="clear"></div>
				<div class="noticiaAtivo">	
					<div class="propNoti">
						<?php echo nl2br($dados->descricao); ?>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php } else {
	$sql 		= mysql_query("SELECT * FROM agenda WHERE data_reg>='".date("Y-m-d")."'");
	$lpp 		= 6;
	$total 		= mysql_num_rows($sql);
	$paginas 	= ceil($total / $lpp); 
	$pagina 	= (!isset($_GET['pagina']))?0:$_GET['pagina']; 
	$inicio 	= $pagina * $lpp;
	$vu 		= mysql_query("SELECT * FROM agenda WHERE data_reg>='".date("Y-m-d")."' ORDER BY data_reg ASC LIMIT $inicio, $lpp");
?>
<div class="paginas">
	<div class="util" style="margin-top: 14px;">
		<div class="area_agenda">
			<div class="intro3">AGENDA</div>
		</div>
	</div>
	<?php
	while($dados = mysql_fetch_object($vu)){
		$part 		= explode("-", $dados->data_reg);
		?>
		<a href="./interatividade/agenda/<?php echo $dados->urlcheck; ?>"><div class="util">
			<div class="area_contato" style="min-height: 65px; margin: 40px 0px;">
				<?php echo '<div class="vdata">'.$part[2].'<div>'.substr(escreveMes($part[1]),0,3).'</div></div>'; ?>
				<div class="intro5 menos1" style="padding-top: 20px;"><?php echo $dados->nome.'<br /><div class="t14 menos0 arial normal">'.$dados->local_reg.'</div>'; ?></div>
			</div>
			<div class="clear"></div>
		</div></a>
	<?php
	}	
	if($total > $lpp) {
		echo '<div class="clear"></div>';
		echo '<div class="paginacao2">';
		for($i = 0; $i < $paginas; $i++) {
			$linksp = $i + 1;
			if ($pagina == $i) {
				print " <span class='sera'>$linksp</span>";
			} else {
				print " <a href='./interatividade/agenda";
				if(isset($_GET['noticia'])){
					echo "/".$_GET['noticia'];
				}
				echo "/pagina/$i' class='ser'>$linksp</a>";
			}
		}
		echo '</div>';	
	}
	?>
	<div class="clear" style="height:100px;"></div>
</div>
<?php } ?>