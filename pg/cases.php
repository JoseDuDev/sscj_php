<?php
$vcases = mysql_query("SELECT * FROM cases WHERE urlcheck='".addslashes($_GET['url'])."'");
$r = mysql_fetch_object($vcases);
?>
<link rel="stylesheet" type="text/css" href="css/cases.css" />
<script type="text/javascript" language="javascript">
	$(function() {
		$(".tipos li:last-child").addClass("last-item");
	});
</script>
<div class="util">
	<div class="area_cases">
		<div class="intro menos1">CASES <span class="ubuntubold"><?php echo $r->titulo; ?></span></div>
	</div>
	<div class="tipos">
		<li>
			<?php
			if(file_exists('area/'.$r->imagem)){
				echo '<div class="foto circulo"><img src="area/'.$r->imagem.'" width="200" height="200" alt="" title="" /></div>';
				echo '<div class="infor">
					<p>'.nl2br($r->descricao).'</p>
				</div>';
			} else {
				echo '<div class="infor2">
					<p>'.nl2br($r->descricao).'</p>
				</div>';
			}
			?>
		</li>
		<li>
			<?php
			if(file_exists('area/'.$r->imagem1)){
				echo '<div class="foto circulo"><img src="area/'.$r->imagem1.'" width="200" height="200" alt="" title="" /></div>';
				echo '<div class="infor">
					<div class="titulo">DESAFIO</div>
					<p>'.nl2br($r->descricao1).'</p>
				</div>';
			} else if($r->descricao1!=''){
				echo '<div class="infor2">
					<div class="titulo">DESAFIO</div>
					<p>'.nl2br($r->descricao1).'</p>
				</div>';
			}
			?>
		</li>
		<li>
			<?php
			if(file_exists('area/'.$r->imagem2)){
				echo '<div class="foto circulo"><img src="area/'.$r->imagem2.'" width="200" height="200" alt="" title="" /></div>';
				echo '<div class="infor">
					<div class="titulo">SOLUÇÃO</div>
					<p>'.nl2br($r->descricao2).'</p>
				</div>';
			} else if($r->descricao1!=''){
				echo '<div class="infor2">
					<div class="titulo">SOLUÇÃO</div>
					<p>'.nl2br($r->descricao2).'</p>
				</div>';
			}
			?>
		</li>
	</div>
	<?php if($r->apps!=''){ ?>
	<div class="apps">
		<?php
		$app = explode("#",$r->apps);
		for($i=0; $i<count($app); $i++){
			if(!empty($app[$i])){
				$vapp = mysql_query("SELECT * FROM apps_produtos WHERE id='".$app[$i]."'");
				while($ln = mysql_fetch_object($vapp)){
					echo '<li><a href="./produtos/google-apps/produtos#'.$ln->urlcheck.'"><img src="area/'.$ln->icone.'" class="circulo" width="103" height="103" alt="'.$ln->titulo.'" title="'.$ln->titulo.'" /></a></li>';
				}
			}
		}
		echo '<li><a href="./produtos/google-apps/produtos"><img src="area/img/icones/vejamais.png" class="circulo" width="103" height="103" alt="Veja Mais" title="Veja Mais" /></a></li>';
		?>
	</div>
	<?php } ?>
	<div class="tipos">
		<li>
			<?php
			if(file_exists('area/'.$r->imagem3)){
				echo '<div class="foto circulo"><img src="area/'.$r->imagem3.'" width="200" height="200" alt="" title="" /></div>';
				echo '<div class="infor">
					<div class="titulo">CONCLUSÃO</div>
					<p>'.nl2br($r->descricao3).'</p>
				</div>';
			} else if($r->descricao1!=''){
				echo '<div class="infor2">
					<div class="titulo">CONCLUSÃO</div>
					<p>'.nl2br($r->descricao3).'</p>
				</div>';
			}
			?>
		</li>
	</div>
</div>