<link rel="stylesheet" type="text/css" href="css/comunidades.css" />
<?php if(!isset($_GET['url'])){ ?>
	<div class="paginas">
		<div class="util">
			<div class="area_comunidades">
				<div class="intro3">COMUNIDADES</div>
			</div>
		</div>
		<div class="util">
			<ul class="itens_comunidades">
				<?php
				$ve = mysql_query("SELECT * FROM comunidades WHERE status='S' ORDER BY id_o ASC");
				while($ln = mysql_fetch_object($ve)){
					echo '<a href="./'.$ln->urlcheck.'">';
					echo '<li>';
						echo '<div class="cors" style="background-color:#'.$ln->cor.';">&nbsp;</div>';
						echo '<div class="image"><img src="area/'.$ln->icone.'" width="150" height="170" alt="" title="" /></div>';
						echo '<div class="info">'.$ln->titulo.'<div class="sub">'.$ln->rua.' - '.$ln->telefone.'</div><div>';
						if(strlen(strip_tags($ln->introducao))>370){ echo truncate(strip_tags($ln->introducao), 370, ' (...)'); } else { echo strip_tags($ln->introducao); }
						echo '</div></div>';
					echo '</li>';
					echo '</a>';
				}
				?>
			</ul>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
<?php } else {
	$vdc = mysql_query("SELECT * FROM comunidades WHERE urlcheck='".$_GET['url']."'");
	if(mysql_num_rows($vdc)==0){
		header("Location: ./home");
	}
	$ln = mysql_fetch_object($vdc);
	?>
	<script type="text/javascript" language="javascript" src="js/fancybox/jquery.fancybox-1.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
	<link rel="stylesheet" href="js/fancybox/style.css" />
	<script type="text/javascript" language="javascript">
		$(function() {
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
	<div class="paginas">
		<div class="util">
			<div class="area_comunidades">
				<div class="intro3"><?php echo $ln->titulo; ?></div>
			</div>
		</div>
		<div class="util">
			<ul class="item_comunidades">
				<?php
				echo '<li>';
					echo '<a href="./comunidades/"><div class="voltar"><img src="img/volta.png" width="32" height="32" alt="Voltar" title="Voltar" /></div></a>';
					echo '<div class="image"><a href="area/'.$ln->icone.'" rel="images" title="'.$ln->titulo.'"><img src="area/'.$ln->icone.'" width="400" alt="'.$ln->titulo.'" title="'.$ln->titulo.'" /></a></div>';
					echo '<div class="info">'.$ln->titulo.'<div class="sub">'.$ln->rua.' - '.$ln->telefone.'</div><div class="barra" style="background-color:#'.$ln->cor.';">&nbsp;</div><div>'.nl2br($ln->introducao).'</div></div>';
				echo '</li>';
				?>
			</ul>
		</div>
		<div class="clear">&nbsp;</div>
		<div class="util">
			<div class="vhorarios">
				<span class="intros esquerda tesquerda" style="background-color:#<?php echo $ln->cor; ?>; padding: 14px 20px 14px 20px;">HORÁRIOS</span>
				<div class="clear">&nbsp;</div>
				<?php
				$vm = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$ln->id."' AND oque='missa' ORDER BY id_o ASC");
				$vt = mysql_num_rows($vm);
				if($vt>0){
				?>
				<div class="vemais">
					<div class="entrada" style="height:<?php echo (25 * $vt); ?>px; line-height: <?php echo (25 * $vt); ?>px;">MISSAS</div>
					<ul class="listagem">
						<?php
						$c=0;
						while($row = mysql_fetch_object($vm)){
							$c++;
							$resultado = ($c % 2) ? 'Ímpar' : 'Par';
							if($vt>1){
								echo '<li '; if($resultado=='Par'){ echo ' style="background-color: #bdbdbd;" '; } else { echo ' style="background-color: #d6d6d6;" '; } echo '><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							} else {
								echo '<li style="background-color: #d6d6d6; padding: 15px 10px;"><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							}
						}
						?>
					</ul>
				</div>
				<?php } ?>
				<div class="clear">&nbsp;</div>
				<?php
				$vm = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$ln->id."' AND oque='confissao' ORDER BY id_o ASC");
				$vt2 = mysql_num_rows($vm);
				if($vt2>0){
				?>
				<div class="vemais">
					<div class="entrada" style="height:<?php echo (25 * $vt2); ?>px; line-height: <?php echo (25 * $vt2); ?>px;">CONFISSÃO</div>
					<ul class="listagem">
						<?php
						$c=0;
						while($row = mysql_fetch_object($vm)){
							$c++;
							$resultado = ($c % 2) ? 'Ímpar' : 'Par';
							if($vt2>1){
								echo '<li '; if($resultado=='Par'){ echo ' style="background-color: #bdbdbd;" '; } else { echo ' style="background-color: #d6d6d6;" '; } echo '><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							} else {
								echo '<li style="background-color: #d6d6d6; padding: 15px 10px;"><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							}
						}
						?>
					</ul>
				</div>
				<?php } ?>
				<div class="clear">&nbsp;</div>
				<?php
				$vm = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$ln->id."' AND oque='secretaria' ORDER BY id_o ASC");
				$vt3 = mysql_num_rows($vm);
				if($vt3>0){
				?>
				<div class="vemais">
					<div class="entrada" style="height:<?php if($vt3>1){ echo (25 * $vt3); } else { echo '55'; } ?>px; line-height: <?php echo (25 * $vt3); ?>px;">ATENDIMENTO SECRETARIA</div>
					<ul class="listagem">
						<?php
						$c=0;
						while($row = mysql_fetch_object($vm)){
							$c++;
							$resultado = ($c % 2) ? 'Ímpar' : 'Par';
							if($vt3>1){
								echo '<li '; if($resultado=='Par'){ echo ' style="background-color: #bdbdbd;" '; } else { echo ' style="background-color: #d6d6d6;" '; } echo '><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							} else {
								echo '<li style="background-color: #d6d6d6; padding: 30px 10px;"><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							}
						}
						?>
					</ul>
				</div>
				<?php } ?>
				<div class="clear">&nbsp;</div>
				<?php
				$vm = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$ln->id."' AND oque='outros' ORDER BY id_o ASC");
				$vt4 = mysql_num_rows($vm);
				if($vt4>0){
				?>
				<div class="vemais">
					<div class="entrada" style="height:<?php if($vt4>1){ echo (25 * $vt4); } else { echo '25'; } ?>px; line-height: <?php echo (25 * $vt4); ?>px;">OUTROS</div>
					<ul class="listagem">
						<?php
						$c=0;
						while($row = mysql_fetch_object($vm)){
							$c++;
							$resultado = ($c % 2) ? 'Ímpar' : 'Par';
							if($vt4>1){
								echo '<li '; if($resultado=='Par'){ echo ' style="background-color: #bdbdbd;" '; } else { echo ' style="background-color: #d6d6d6;" '; } echo '><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							} else {
								echo '<li style="background-color: #d6d6d6; padding: 15px 10px;"><strong>'.$row->nome.'</strong> &nbsp; '.$row->horario.'</li>';
							}
						}
						?>
					</ul>
				</div>
				<?php } $vtotal = ($vt + $vt2 + $vt3 + $vt4);
				if($vtotal=='0'){
					echo '<p style="padding: 90px 0px;">Em breve...</p>';
				}
				?>
			</div>
		</div>
		<div class="util">
			<div class="vnoticias">
				<span class="intros esquerda tesquerda paddingesquerda" style="background-color:#<?php echo $ln->cor; ?>">
				<?php
				$un = mysql_query("SELECT * FROM noticias WHERE status='S' AND comunidade='".$ln->id."' ORDER BY data_reg DESC,id DESC LIMIT 3");
				if(mysql_num_rows($un)>0){ ?>
					<a href="./comunidades/noticias/<?php echo $_GET['url']; ?>"><div class="vicone3">&nbsp;</div></a>
				<?php } else { ?>
					<div class="vicone3">&nbsp;</div>
				<?php } ?>NOTÍCIAS DA COMUNIDADE</span>
				<div class="clear">&nbsp;</div>
				<ul>
					<?php
					if(mysql_num_rows($un)>0){
						while($l = mysql_fetch_object($un)){
							$dv 	= explode(" ", $l->data_reg);
							$part   = explode("-", $dv[0]);
							echo '<a href="./comunidades/noticias/'.$_GET['url'].'/'.$l->url_check.'">';
							echo '<li>';
								echo '<div class="image"><img src="area/'.$l->imagem.'" width="130" height="100" alt="'.$l->titulo.'" title="'.$l->titulo.'" /></div>
								<div class="contexto"><div class="top">';
								if(strlen(strip_tags($l->titulo))>40){ echo truncate(strip_tags($l->titulo), 40, '...'); } else { echo strip_tags($l->titulo); } echo '</div>';
								if(strlen(strip_tags($l->conteudo))>220){ echo truncate(strip_tags($l->conteudo), 220, ' (...)'); } else { echo strip_tags($l->conteudo); }
								echo '</div>
							</li>';
							echo '</a>';
						}
					} else {
						echo '<p style="padding: 90px 0px;">Em breve...</p>';
					}
					?>
				</ul>
				<?php if(mysql_num_rows($un)>3){ ?>
					<a href="./comunidades/noticias/<?php echo $_GET['url']; ?>"><span class="maisn arial" style="background-color:#<?php echo $ln->cor; ?>;">MAIS NOTÍCIAS</span></a>
				<?php } ?>
			</div>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
<?php } ?>