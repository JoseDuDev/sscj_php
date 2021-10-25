<?php
$valida = isset($_POST["valida"]) ? $_POST["valida"] : null;
if($valida == "enviar"){	
	$nome 	 	 = utf8_decode($_POST["mnome"]);
	$email 		 = utf8_decode($_POST["memail"]);
	$anome 		 = utf8_decode($_POST["anome"]);
	$aemail 	 = utf8_decode($_POST["aemail"]);
	$mensagem 	 = utf8_decode($_POST["mensagem"]);
	
	$ass = $anome.", ".$nome." te indicou um notícia.";
					 
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "From: ".$nome." - ".$GLOBALS['config']['mascara']." <".$email.">\r\n"; 
	$headers .= "Return-Path: ".$email."\r\n";
	$headers .= "Content-Type: Text/HTML\r\n";
	
	$msg = "<font face=tahoma color=black size=2>";
	$msg .= "<strong>".$nome."</strong> está indicando a notícia ".$_POST["tnot"]."<br /><br />";
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
if(!isset($_GET['area'])){
	$com = 0;
	$vdc = mysql_query("SELECT id, nome FROM categoria WHERE urlcheck='".$_GET['url']."'");
	$nnome = mysql_result($vdc,0,"nome");
	$cat = mysql_result($vdc,0,"id");
	$idcat = mysql_result($vdc,0,"id");
} else {
	$vdc = mysql_query("SELECT id, titulo FROM comunidades WHERE urlcheck='".$_GET['area']."'");
	$com = mysql_result($vdc,0,"id");
	$nnome = mysql_result($vdc,0,"titulo");
	$cat = 0;
	$idcat = 0;
}
if(!isset($_GET['noticia'])){
	$pun = mysql_query("SELECT * FROM noticias ORDER BY data_reg DESC LIMIT 1");
	$dados = mysql_fetch_object($pun);
	$vu = mysql_query("SELECT * FROM noticias WHERE id!='".$dados->id."' AND comunidade='".$com."' ORDER BY data_reg DESC LIMIT 10");
} else if(isset($_GET['local']) && $_GET['local'] == 'arcanjo'){
	$apiarcanjo = file_get_contents('http://www.agenciaarcanjo.com.br/api.php?tipo=noticia&id='.$_GET['noticia']);
	$dados = json_decode($apiarcanjo);
} else {
	$pun = mysql_query("SELECT * FROM noticias WHERE url_check='".$_GET['noticia']."'");
	$dados = mysql_fetch_object($pun);
	$vu = mysql_query("SELECT * FROM noticias WHERE url_check!='".$_GET['noticia']."' ORDER BY data_reg DESC LIMIT 10");
}
$part   = explode("-", $dados->data_reg);
?>
<div class="paginas">
	<div class="util">
		<div class="area_noticias">
			<div class="intro3"><?php echo $nnome; ?></div>
		</div>
	</div>
	<div class="relaciona">
		<div class="intro6">Notícias Relacionadas</div>
		<ul class="vemais">
			<?php
			$nots = array();
			$idapresenta = 1;
			if($idcat == $idapresenta){
				// BUSCA DAS NOTÍCIAS PADRÃO
				$apiarcanjo = file_get_contents('http://www.agenciaarcanjo.com.br/api.php?tipo=noticias&limite=10');
				$saida = json_decode($apiarcanjo);
				for($i=1; $i<=$saida->registros; $i++){
					$campo 		= 'registro'.$i;
					$nots[] 	= array(
									'data' 			=> $saida->$campo->data,
									'local' 		=> 'www.agenciaarcanjo.com.br/',
									'titulo' 		=> $saida->$campo->titulo,
									'imagem' 		=> $saida->$campo->imagem,
									'url' 			=> $saida->$campo->url,
									'conteudo' 		=> $saida->$campo->conteudo,
									'categoria' 	=> $idapresenta,
									'introducao' 	=> $saida->$campo->introducao,
									'final' 		=> 'arcanjo'
								);
				}
			}
			$vn = mysql_query("SELECT * FROM noticias WHERE categoria='".$cat."' AND status='S' AND url_check!='".$_GET['noticia']."' ORDER BY data_reg DESC LIMIT 10");
			while($reg = mysql_fetch_object($vn)){
				$nots[] 	= array(
								'data' 			=> $reg->data_reg,
								'local' 		=> $GLOBALS['config']['url'].'/',
								'titulo' 		=> $reg->titulo,
								'imagem' 		=> $reg->imagem,
								'url' 			=> $reg->url_check,
								'conteudo' 		=> $reg->conteudo,
								'categoria' 	=> $reg->categoria,
								'introducao' 	=> $reg->introducao,
								'final' 		=> ''
							);
			}
			function cmp($a, $b) {
				return $a['data'] < $b['data'];
			}
			usort($nots, 'cmp');
			$c=0;
			for( $i=0; $i<count($nots); $i++ ){
				if($_GET['noticia'] != $nots[$i]['url']){
					$c++;
					if(!isset($_GET['area'])){
						echo '<a href="./noticias/'.$_GET['url'].'/'.$nots[$i]['url'].'/'.$nots[$i]['final'].'">';
					} else if(isset($_GET['area'])){
						echo '<a href="./comunidades/noticias/'.$_GET['area'].'/'.$nots[$i]['url'].'/'.$nots[$i]['final'].'">';
					}
					echo '<li>';
						echo '<div class="image"><img src="http://'.$nots[$i]['local'].'area/'.$nots[$i]['imagem'].'" width="70" height="60" alt="'.$nots[$i]['titulo'].'" title="'.$nots[$i]['titulo'].'" /></div>';
						echo '<div class="topico">';
						if(strlen(strip_tags($nots[$i]['titulo']))>15){ echo truncate(strip_tags($nots[$i]['titulo']), 15, '...'); } else { echo strip_tags($nots[$i]['titulo']); }
						echo '</div>
						<div class="contexto">';
						if(strlen(strip_tags($nots[$i]['conteudo']))>45){ echo truncate(strip_tags($nots[$i]['conteudo']), 45, ' (...)'); } else { echo strip_tags($nots[$i]['conteudo']); }
						echo '</div>
					</li>';
					echo '</a>';
					if($c==8){
						break;
					}
				}
			}
			?>
		</ul>
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
					if(isset($_GET['local'])){
						$imgs = $dados->imagem;
					} else {
						$imgs = 'area/'.$dados->imagem;
					}
					echo '<a href="'.$imgs.'" title="'.$dados->titulo.'"><img src="'.$imgs.'" alt="'.$dados->titulo.'" title="'.$dados->titulo.'" /></a>';
					echo nl2br($dados->conteudo).'<br />';
					if($dados->fotografo!=''){
						echo '<p>Fotógrafo: '.$dados->fotografo.'</p>';
					}
					if($dados->fonte!=''){
						echo '<p>Fonte: '.$dados->fonte.'</p>';
					}
					?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="divulgacao">
				<a href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>&t=<?php echo urlencode($dados->titulo); ?>" target="_blank"><div class="compartilhe"><img src="img/bt-compartilhe.png" width="151" height="38" alt="Compartilhe está Notícia" title="Compartilhe está Notícia" /></div></a>
				<div onclick="window.print();" class="imprimir"></div>
				<div onclick="indica();" class="indicar"></div>
				<a href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>&t=<?php echo urlencode($dados->titulo); ?>" target="_blank"><div class="face"></div></a>
			</div>

			<div id="dados_indicacao">
				<div class="intro6">Indique a um amigo</div>
				<div class="clear"></div>
				<form name="indicao" id="indicacao" action="./?pg=noticias&indica" method="post">
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
					<input type="hidden" name="endereco" id="endereco" value="http://<?php echo $GLOBALS['config']['url'].'/'.$_GET['url'].'/'.$_GET['noticia']; ?>" />
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