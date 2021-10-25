<link rel="stylesheet" type="text/css" href="css/noticias.css" />
<?php
if(!isset($_GET['area'])){
	$vdp = mysql_query("SELECT * FROM categoria WHERE urlcheck='".$_GET['url']."'");
	$row = mysql_fetch_object($vdp);
	$com = 0;
		$cat = " AND categoria='".$row->id."' ";
		$nnome = $row->nome;
		// ID CATEGORIA PADRÃO PARA NOTÍCIAS GERAIS
		$idcat = $row->id;
} else {
	$vdc = mysql_query("SELECT id, titulo FROM comunidades WHERE urlcheck='".$_GET['area']."'");
	$com = mysql_result($vdc,0,"id");
	$nnome = mysql_result($vdc,0,"titulo");
	$cat = 0;
	// ID CATEGORIA PADRÃO PARA NOTÍCIAS GERAIS
	$idcat = 0;
}
?>
<div class="paginas">
	<div class="util">
		<div class="area_noticias">
			<div class="intro3"><?php echo $nnome; ?></div>
		</div>
		<div class="historico">
			<ul>
				<?php
				$nots = array();
				$idapresenta = 1;
				if($idcat == $idapresenta){
					// BUSCA DAS NOTÍCIAS PADRÃO
					$apiarcanjo = file_get_contents('https://www.agenciaarcanjo.com.br/api.php?tipo=noticias');
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
				$vn = mysql_query("SELECT * FROM noticias WHERE status='S' ".$cat." ORDER BY data_reg DESC");
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
				for( $i=0; $i<count($nots); $i++ ){
					$dv 	= explode(" ", $nots[$i]['data']);
					$part   = explode("-", $dv[0]);
					if(!isset($_GET['area'])){
						echo '<a href="./noticias/'.$row->urlcheck.'/'.$nots[$i]['url'].'/'.$nots[$i]['final'].'">';
					} else if(isset($_GET['area'])){
						echo '<a href="./comunidades/noticias/'.$_GET['area'].'/'.$nots[$i]['url'].'/'.$nots[$i]['final'].'">';
					}
					echo '<li>';
					echo '<div class="image"><img src="https://'.$nots[$i]['local'].'area/'.$nots[$i]['imagem'].'" width="150" height="200" alt="'.$nots[$i]['titulo'].'" title="'.$nots[$i]['titulo'].'" /></div>';
						echo '<div class="topico">';
						echo '<div class="vdata">'.$part[2].'<div>'.substr(escreveMes($part[1]),0,3).'</div></div>'.$nots[$i]['titulo'].'</div>
						<div class="contexto">';
						if(strlen(strip_tags($nots[$i]['conteudo']))>450){ echo truncate(strip_tags($nots[$i]['conteudo']), 450, ' (...)'); } else { echo strip_tags($nots[$i]['conteudo']); }
						echo '</div>
					</li>';
					echo '</a>';
				}
				?>
			</ul>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>
