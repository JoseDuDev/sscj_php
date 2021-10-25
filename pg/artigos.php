<?php
$valida = isset($_POST["valida"]) ? $_POST["valida"] : null;
if($valida == "enviar"){	
	$nome 	 	 = utf8_decode($_POST["mnome"]);
	$email 		 = utf8_decode($_POST["memail"]);
	$anome 		 = utf8_decode($_POST["anome"]);
	$aemail 	 = utf8_decode($_POST["aemail"]);
	$mensagem 	 = utf8_decode($_POST["mensagem"]);
	
	$ass = $anome.", ".$nome." te indicou um artigo.";
					 
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "From: ".$nome." - ".$GLOBALS['config']['mascara']." <".$email.">\r\n"; 
	$headers .= "Return-Path: ".$email."\r\n";
	$headers .= "Content-Type: Text/HTML\r\n";
	
	$msg = "<font face=tahoma color=black size=2>";
	$msg .= "<strong>".$nome."</strong> está indicando este artigo ".$_POST["tnot"]."<br /><br />";
	$msg .= "<a href='".$_POST["endereco"]."' target='_blank'>Clique aqui para acessar!</a><br /><br />";
	$msg .= date("d/m/Y - H:i:s")."<br />";
	$msg .= "</font>";

	$envio = mail($aemail, utf8_decode($ass), $msg, $headers);

	if($envio)
		echo "<script>javascript:ok('Mensagem enviada com sucesso','".$_POST["endereco"]."')</script>";
	else
		echo "<script>javascript:error('Erro! Por Favor tente novamente','".$_POST["endereco"]."')</script>";
}
?>
<link rel="stylesheet" type="text/css" href="css/noticias.css" />
<script src="js/js-global/FancyZoom.js" type="text/javascript"></script>
<script src="js/js-global/FancyZoomHTML.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
	function indica(){
		$('#dados_indicacao').slideToggle();
	}
</script>
<body id="whatever" onLoad="setupZoom()">
<?php
if(!isset($_GET['noticia'])){
	$pun = mysql_query("SELECT * FROM artigos ORDER BY data_reg DESC, id DESC LIMIT 1");
	if(mysql_num_rows($pun)>0){
		$dados = mysql_fetch_object($pun);
		$vu = mysql_query("SELECT * FROM artigos WHERE id!='".$dados->id."' ORDER BY data_reg DESC LIMIT 10");
	}
} else {
	$pun = mysql_query("SELECT * FROM artigos WHERE url_check='".$_GET['noticia']."'");
	$dados = mysql_fetch_object($pun);
	$vu = mysql_query("SELECT * FROM artigos WHERE url_check!='".$_GET['noticia']."' ORDER BY data_reg DESC LIMIT 10");
}
if(mysql_num_rows($pun)==0){
	echo '<p style="text-align: center; width: 100% margin: 100px 0px; height:200px;">Em breve...</p>';
} else {
$part   = explode("-", $dados->data_reg);
?>
<div class="paginas">
	<div class="util" style="margin-top: 14px;">
		<div class="area_artigos">
			<div class="intro3">ARTIGOS</div>
		</div>
	</div>
	<div class="relaciona">
		<div class="intro6">Outros Artigos</div>
		<ul class="vemais">
			<?php
			if(!isset($_GET['noticia'])){
				$sql = mysql_query("SELECT * FROM artigos");
			} else {
				$sql = mysql_query("SELECT * FROM artigos WHERE url_check!='".$_GET['noticia']."'");
			}
			$lpp = 6;
			$total = mysql_num_rows($sql);
			$paginas = ceil($total / $lpp); 
			$pagina = (!isset($_GET['pagina']))?0:$_GET['pagina']; 
			$inicio = $pagina * $lpp;
			if(!isset($_GET['noticia'])){
				$vu = mysql_query("SELECT * FROM artigos ORDER BY data_reg DESC LIMIT $inicio, $lpp");
			} else {
				$vu = mysql_query("SELECT * FROM artigos WHERE url_check!='".$_GET['noticia']."' ORDER BY data_reg DESC LIMIT $inicio, $lpp");
			}
			while($ln = mysql_fetch_object($vu)){
				echo '<a href="./artigos/'.$ln->url_check.'">';
				echo '<li>';
					echo '<div class="topico">';
					if(strlen(strip_tags($ln->titulo))>24){ echo truncate(strip_tags($ln->titulo), 24, '...'); } else { echo strip_tags($ln->titulo); }
					echo '</div>
					<div class="contexto">';
					if(strlen(strip_tags($ln->conteudo))>80){ echo truncate(strip_tags($ln->conteudo), 80, ' (...)'); } else { echo strip_tags($ln->conteudo); }
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
					print " <a href='./artigos";
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
		<div class="utiln">
			<div class="area_contato" style="min-height: 90px;">
				<?php echo '<div class="vdata">'.$part[2].'<div>'.substr(escreveMes($part[1]),0,3).'</div></div>'; ?>
				<div class="intro5 menos1"><?php echo $dados->titulo.'<p>Em '.mudaData($dados->data_reg,"-","/").'</p>'; ?></div>
			</div>
			<div class="clear"></div>	
			
			<div class="noticiaAtivo">	
				<div class="propNoti">
					<?php
					if($dados->imagem!=''){
						echo '<a href="area/'.$dados->imagem.'" title="'.$dados->titulo.'"><img src="area/'.$dados->imagem.'" alt="'.$dados->titulo.'" title="'.$dados->titulo.'" /></a>';
					}
					echo nl2br($dados->conteudo).'<br />';
					if($dados->fonte!=''){
						echo '<p>Fonte: '.$dados->fonte.'</p>';
					}
					?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="divulgacao">
				<a href="http://www.facebook.com/share.php?u=http://<?php echo $GLOBALS['config']['url'].'/artigos/'; if(isset($_GET["noticia"])){ echo $_GET["noticia"]; } ?>&t=<?php echo urlencode($dados->titulo); ?>" target="_blank"><div class="compartilhe"><img src="img/bt-compartilhe.png" width="151" height="38" alt="Compartilhe está Notícia" title="Compartilhe está Notícia" /></div></a>
				<div onclick="window.print();" class="imprimir"></div>
				<div onclick="indica();" class="indicar"></div>
				<a href="http://www.facebook.com/share.php?u=http://<?php echo $GLOBALS['config']['url'].'/artigos/'; if(isset($_GET["noticia"])){ echo $_GET["noticia"]; } ?>&t=<?php echo urlencode($dados->titulo); ?>" target="_blank"><div class="face"></div></a>
			</div>

			<div id="dados_indicacao">
				<div class="intro6">Indique a um amigo</div>
				<div class="clear"></div>
				<form name="indicao" id="indicacao" action="./?pg=artigos&indica" method="post">
					<label>* Seu Nome</label><input type="text" name="mnome" id="mnome" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* Seu E-mail</label><input type="text" name="memail" id="memail" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* Nome do Amigo</label><input type="text" name="anome" id="anome" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* E-mail do Amigo</label><input type="text" name="aemail" id="aemail" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* Mensagem</label><textarea class="obrigatorio" name="mensagem" id="mensagem" style="width:300px;"></textarea>
					<input type="hidden" name="valida" id="valida" value="enviar" />
					<input type="hidden" name="endereco" id="endereco" value="http://<?php echo $GLOBALS['config']['url'].'/'.$_GET['noticia']; ?>" />
					<input type="hidden" name="tnot" id="tnot" value="<?php echo $dados->titulo; ?>" />
					<div class="clear"></div>
					<label>&nbsp;</label><input type="button" class="bte" onclick="validaform(form.id);" value="ENVIAR E-MAIL" />
					<div class="clear"></div>
				</form>
			</div>

		</div>
	</div>
	<div class="clear"></div>
	<div style="height: 100px; width: 100%;">&nbsp;</div>
	<div class="clear"></div>
</div>
<?php } ?>