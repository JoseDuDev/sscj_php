<link rel="stylesheet" type="text/css" href="css/contato.css" />
<div class="paginas">
	<div class="util">
		<div class="area_contato">
			<div class="intro3">HORÁRIOS</div>
			<div class="topico">
				<div class="intro8">MISSAS NO SANTUÁRIO</div>
			</div>
			<ul class="missas">
				<?php 
				$vhora = mysql_query("SELECT * FROM horarios WHERE status='S' ORDER BY id_o ASC");
				while($row = mysql_fetch_object($vhora)){
					echo '<li><div class="dia">'.$row->nome.'</div><div class="horario">&nbsp;&nbsp;&nbsp;'.$row->horario.'</div></li>';
				}
				?>
			</ul>
			<div class="clear">&nbsp;</div>
			<div class="topico">
				<div class="intro8">INFORMAÇÕES IMPORTANTES</div>
			</div>
			<ul class="veavisos">
				<?php 
				$vhora = mysql_query("SELECT * FROM informacoes WHERE status='S' ORDER BY id_o ASC");
				while($row = mysql_fetch_object($vhora)){
					echo '<li><div class="dia">'.$row->nome.'</div><div class="horario">&nbsp;&nbsp;&nbsp;'.$row->horario.'</div></li>';
				}
				?>
			</ul>
			<div class="clear">&nbsp;</div>
			<div class="meia1">
				<div class="intro8">ATENDIMENTO E CONFISSÃO</div>
				<p><?php echo nl2br($GLOBALS['config']['msg2']); ?></p>
			</div>
			<div class="meia2">
				<div class="intro8">ATENDIMENTO DA SECRETARIA</div>
				<p><?php echo nl2br($GLOBALS['config']['msg3']); ?></p>
			</div>
			<div class="clear">&nbsp;</div>
			<div class="divisa">&nbsp;</div>
			<?php
			$vc = mysql_query("SELECT * FROM comunidades WHERE status='S' ORDER BY id_o ASC");
			while($vw = mysql_fetch_object($vc)){
				$vm = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$vw->id."' AND oque='missa' ORDER BY id_o ASC");
				$vt2 = mysql_num_rows($vm);
				if($vt2>0){
					echo '<div class="missas">
					<div class="intro8">'.$vw->titulo.'</div>';
			
					echo '<div class="vemais">
					<div class="entrada" style="height:'; if($vt2>1){ echo (25 * $vt2); } else { echo '30'; } echo 'px; line-height: '; if($vt2>1){ echo (25 * $vt2); } else { echo '30'; } echo 'px;">MISSAS</div>
					<ul class="listagem">';
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
					echo '</ul>
					</div>
					</div>';
				}
			}
			?>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>