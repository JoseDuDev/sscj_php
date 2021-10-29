<link rel="stylesheet" type="text/css" href="css/home.css" />
<script type="text/javascript" language="javascript" src="js/jquery-easing-1.3.pack.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-easing-compatibility.1.2.pack.js"></script>
<script type="text/javascript" language="javascript" src="js/coda-slider.1.1.1.pack.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.carouFredSel-6.0.4-packed.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" language="javascript">
$(function() {
  $('#foo2').carouFredSel({
    auto: true,
    prev: '#prev2',
    next: '#next2',
    scroll: 1,
    swipe: {
      onMouse: true,
      onTouch: true
    }
  });
  $('#foo1').carouFredSel({
    width: 980,
    auto: {
      items: 6,
      duration: 18000,
      easing: "linear",
      timeoutDuration: 0,
      pauseOnHover: "immediate"
    }
  });
  $('.slider2').mobilyslider({
    content: '.sliderContent2',
    children: 'div',
    transition: 'fade',
    animationSpeed: 500,
    autoplay: true,
    autoplaySpeed: 5000,
    pauseOnHover: false,
    bullets: false,
    arrows: false,
    arrowsHide: false,
    animationStart: function() {},
    animationComplete: function() {}
  });
});
var theInt = null;
var $crosslink, $navthumb;
var curclicked = 0;
theInterval = function(cur) {
  clearInterval(theInt);
  if (typeof cur != 'undefined')
    curclicked = cur;
  $crosslink.removeClass("active-thumb");
  $navthumb.eq(curclicked).parent().addClass("active-thumb");
  $(".stripNav ul li a").eq(curclicked).trigger('click');
  theInt = setInterval(function() {
    $crosslink.removeClass("active-thumb");
    $navthumb.eq(curclicked).parent().addClass("active-thumb");
    $(".stripNav ul li a").eq(curclicked).trigger('click');
    curclicked++;
    if (6 == curclicked)
      curclicked = 0;
  }, 3000);
};
$(function() {
  $("#main-photo-slider").codaSlider();
  $navthumb = $(".nav-thumb");
  $crosslink = $(".cross-link");
  $navthumb
    .click(function() {
      var $this = $(this);
      theInterval($this.parent().attr('href').slice(1) - 1);
      return false;
    });
  theInterval();
});
</script>
<div class="banner_corpo">
  <?php
		$selb = mysql_query("SELECT * FROM banner WHERE status='S' AND local='principal' ORDER BY id_o DESC");	
		if(mysql_num_rows($selb)>1){
			echo '<div class="banner_paginas">
			<div class="linhab">&nbsp;</div>
			<div class="slider">
				<div class="sliderContent">';
					while($dados = mysql_fetch_object($selb)){
						if( strtotime(date("Y-m-d H:i:s")) > strtotime($dados->data_reg.' '.$dados->hora) ){
							$tam_img = getimagesize('area/'.$dados->img);
							$posx = ceil($tam_img[0] / 2);
							echo '<div class="item" style="margin-left:-'.$posx.'px;">';
						    if($dados->site != "") {
							   echo "<a href='https://".$dados->site."' target='_blank'>";
						    }
						    echo "<img src='area/".$dados->img."' title='".$dados->empresa."' heigth='600' alt='".$dados->empresa."' />";
						    if($dados->site != "") {
							   echo "</a>";
						    }
						    echo '</div>';
						}
					}
				echo '</div>
			</div>
		</div>';
		}
	?>
</div>
<div class="area_icones">
  <div class="util">
    <ul class="icones">
      <a href="./contato/horarios">
        <li class="horario"></li>
      </a>
      <a href="./interatividade/liturgia-diaria/<?php echo date("Y-m-d"); ?>">
        <li class="liturgia"></li>
      </a>
      <a href="./interatividade/santo-do-dia/<?php echo date("Y-m-d"); ?>">
        <li class="santo"></li>
      </a>
      <a href="./interatividade/pedidos-de-oracao">
        <li class="pedidos"></li>
      </a>
      <a href="./interatividade/intencoes">
        <li class="intencao"></li>
      </a>
      <a href="./interatividade/jornal-on-line">
        <li class="jonline"></li>
      </a>
    </ul>
  </div>
</div>
<div class="util">
  <div class="area_agenda">
    <p>AGENDA DO SANTUÁRIO</p>
    <div class="list_carousel">
      <ul id="foo2">
        <?php
				$vagenda = mysql_query("SELECT * FROM agenda WHERE data_reg>='".date("Y-m-d")."' ORDER BY data_reg ASC");
				while($r = mysql_fetch_object($vagenda)){
					echo '<li><a href="./interatividade/agenda/'.$r->urlcheck.'" style="font-size: 18px; line-height: 25px; color: #ffffff; text-align: left; font-family: "Arial";">'.implode("/",array_reverse(explode('-',$r->data_reg))).'<div>'.$r->nome.'</div></a></li>';
				}
				?>
      </ul>
      <div class="clearfix"></div>
      <a id="prev2" class="prev" href="#">&nbsp;</a>
      <a id="next2" class="next" href="#">&nbsp;</a>
    </div>
  </div>
  <div class="area_noticias">
    <span class="intro direita tdireita paddingdireita">
      <div class="vicone1">&nbsp;</div>ÚLTIMAS NOTÍCIAS
    </span>
    <ul>
      <?php
			$nots = array();
			$idapresenta = 1;
			// BUSCA DAS NOTÍCIAS PADRÃO
			$apiarcanjo = file_get_contents('https://www.agenciaarcanjo.com.br/api.php?tipo=noticias&limite=10');
			$saida = json_decode($apiarcanjo);
			for($i=1; $i<=$saida->registros; $i++){
				$campo 		= 'registro'.$i;
				$nots[] 	= array(
								'data' 			=> $saida->$campo->data,
								'local' 		=> 'www.agenciaarcanjo.com.br/',
								'titulo' 		=> $saida->$campo->titulo,
								'imagem' 		=> $saida->$campo->imagem,
								'url' 			=> $saida->$campo->url,
								'conteudo' 		=> $saida->$campo->introducao,
								'categoria' 	=> $idapresenta,
								'introducao' 	=> $saida->$campo->introducao,
								'final' 		=> 'arcanjo'
							);
			}
			$vn = mysql_query("SELECT data_reg, imagem, titulo, url_check, conteudo, introducao, categoria FROM noticias WHERE status = 'S' ORDER BY data_reg DESC LIMIT 3");
			while($reg = mysql_fetch_object($vn)){
				$nots[] 	= array(
								'data' 			=> $reg->data_reg,
								'local' 		=> $GLOBALS['config']['url'].'/',
								'titulo' 		=> $reg->titulo,
								'imagem' 		=> $reg->imagem,
								'url' 			=> $reg->url_check,
								'categoria' 	=> $reg->categoria,
								'conteudo' 		=> $reg->conteudo,
								'introducao' 	=> $reg->introducao,
								'final' 		=> ''
							);
			}
			function cmp($a, $b) {
				return $a['data'] < $b['data'];
			}
			usort($nots, 'cmp');
			$cc=0;
			for( $i=0; $i<count($nots); $i++ ){
				$cc++;
				$dv 	= explode(" ", $nots[$i]['data']);
				$part   = explode("-", $dv[0]);
				echo '<a href="./noticias/'.mysql_result(mysql_query("SELECT urlcheck FROM categoria WHERE id='".$nots[$i]['categoria']."'"),0,"urlcheck").'/'.$nots[$i]['url'].'/'.$nots[$i]['final'].'">';
				echo '<li>';
					echo '<div class="topico">';
					echo '<div class="vdata">'.$part[2].'<div>'.substr(escreveMes($part[1]),0,3).'</div></div>';
					if(strlen(strip_tags($nots[$i]['titulo']))>40){ echo truncate(strip_tags($nots[$i]['titulo']), 40, '...'); } else { echo strip_tags($nots[$i]['titulo']); }
					echo '</div>';
					echo '<div class="image"><img src="https://'.$nots[$i]['local'].'area/'.$nots[$i]['imagem'].'" width="180" height="120" alt="'.$nots[$i]['titulo'].'" title="'.$nots[$i]['titulo'].'" /></div>
					<div class="contexto">';
					if(strlen(strip_tags($nots[$i]['conteudo']))>380){ echo truncate(strip_tags($nots[$i]['conteudo']), 380, ' (...)'); } else { echo strip_tags($nots[$i]['conteudo']); }
					echo '</div>
				</li>';
				echo '</a>';
				if($cc == 3){
					break;
				}
			}
			?>
    </ul>
  </div>
  <div class="area_fotos">
    <a href="./interatividade/fotos"><span class="intro esquerda tesquerda paddingesquerda">
        <div class="vicone2">&nbsp;</div>FOTOS RECENTES
      </span></a>
    <div class="slider-wrap">
      <div id="main-photo-slider" class="csw">
        <div class="panelContainer">
          <?php
					$vfoto = mysql_query("SELECT * FROM album_fotos ORDER BY id DESC LIMIT 5");
					$c=0;
					while($rw = mysql_fetch_object($vfoto)){
						$vdf = mysql_query("SELECT festa, urlcheck FROM album WHERE id='".$rw->id_album."'");
						$c++;
						echo '<a href="./interatividade/fotos/'.mysql_result($vdf,0,"urlcheck").'">';
						echo '<div class="panel" title="Panel '.$c.'">
							<div class="wrapper">
								<img src="area/'.$rw->foto.'" width="450" height="330" alt="temp" />';
								if(!empty($rw->descricao)){
									$des = $rw->descricao;
								} else {
									$des = mysql_result($vdf,0,"festa");
								}
								echo '<div class="photo-meta-data">'.$des.'</div>';
							echo '</div>
						</div>';
						echo '</a>';
					}
					?>
        </div>
      </div>
      <?php
			$vfoto = mysql_query("SELECT * FROM album_fotos ORDER BY id DESC LIMIT 5");
			$c=0;
			while($rw = mysql_fetch_object($vfoto)){
				$c++;
				if($c>1){
					echo '<div><a href="#'.$c.'" class="cross-link"><img src="area/'.$rw->foto.'" width="85" height="68" class="nav-thumb" alt="temp-thumb" /></a></div>';
				} else if($c==1){
					echo '<a href="#'.$c.'" class="cross-link active-thumb"><img src="area/'.$rw->foto.'" width="85" height="68" class="nav-thumb" alt="temp-thumb" /></a>
					<div id="movers-row">';
				}
			}
			echo '</div>';
			?>
    </div>
  </div>
</div>
<?php
$selb = mysql_query("SELECT * FROM parceiros WHERE status='S' ORDER BY id_o ASC");	
if(mysql_num_rows($selb)>1){
?>
<div class="util">
  <div class="area_patrocinio">
    <div class="intro2">PATROCINADORES</div>
    <div class="linhav" style="margin-top: 42px;"></div>
    <div class="image_carousel">
      <?php
		echo '<div class="slider2">
			<div class="sliderContent2">';
				while($dados = mysql_fetch_object($selb)){
					echo '<div class="item">';
				    if($dados->site != "") {
					   echo "<a href='https://".$dados->site."' target='_blank'>";
				    }
				    echo "<img src='area/".$dados->img."' title='".$dados->empresa."' heigth='600' alt='".$dados->empresa."' />";
				    if($dados->site != "") {
					   echo "</a>";
				    }
				    echo '</div>';
				}
			echo '</div>
		</div>';
		?>
    </div>
    <div class="linhav"></div>
  </div>
</div>
<?php } ?>