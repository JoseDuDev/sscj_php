<?php
ob_start();
session_start();
include("area/pg/config/_conectaBanco.php");
include("area/pg/config/_configGerais.php");
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Pragma" content="no-cache" />

  <meta content="product" property="og:type" />
  <meta content="<?php echo $GLOBALS['config']['nome']; ?>" property="og:site_name" />
  <meta content="<?php echo $_SESSION['titulo_atual']; ?>" property="og:title" />
  <meta content='https://<?php echo $GLOBALS['config']['url']; ?>/<?php echo $_SESSION['imagem_atual']; ?>'
    property='og:image'>
  <meta content='<?php echo "https://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>' property='og:url'>
  <meta content="<?php echo $_SESSION['descri_atual']; ?>" property="og:description" />

  <meta name="language" content="Portuguese" />
  <meta name="URL" content="https://<?php echo $GLOBALS['config']['url']; ?>" />
  <meta name="subject" content="<?php echo $GLOBALS['config']['nome']; ?>" />
  <meta name="rating" content="GENERAL" />
  <meta name="updated" CONTENT="daily" />
  <meta name="robots" content="index, follow" />
  <meta name="audience" content="all" />
  <meta name="Publisher" CONTENT="<?php echo $GLOBALS['config']['url']; ?>" />
  <meta name="ia_archiver" content="index, follow" />
  <meta name="googlebot" content="index, follow" />
  <meta name="msnbot" content="index, follow" />
  <meta name="Search Engines" content="AltaVista, AOLNet, Infoseek, Excite, Hotbot, Lycos, Magellan, LookSmart, CNET" />
  <meta name="audience" content="all" />
  <meta name="revisit-after" content="1 days" />
  <meta name="document-classification" content="<?php echo $_SESSION['titulo_atual']; ?>" />
  <meta name="TITLE" content="<?php echo $_SESSION['titulo_atual']; ?>" />
  <meta name="Description" content="<?php echo $_SESSION['descri_atual']; ?>" />
  <meta name="Keywords" content="<?php echo $GLOBALS['config']['keyw']; ?>" lang="pt-br" xml:lang="pt-br" />

  <base href="https://<?php echo $GLOBALS['config']['url']; ?>/" target="_self">

  <link rel="stylesheet" type="text/css" href="css/config.css" />
  <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" src="js/jquery.blockUI.js"></script>
  <script type="text/javascript" src="js/jQueryRotate.js"></script>
  <script type="text/javascript" src="js/mobilyslider.js"></script>
  <script type="text/javascript" src="js/msg.js"></script>
  <title><?php echo $_SESSION['titulo_atual']; ?></title>
  <link rel="shortcut icon" type="img/ico" href="https://<?php echo $GLOBALS['config']['url']; ?>/img/favicon.ico" />
</head>

<body>

  <?php
date_default_timezone_set('UTC');
if($_SESSION['popup']==1) {
	$imgp = mysql_query("SELECT img, status, link, target FROM popup WHERE id='".addslashes(1)."'");
	$stt = mysql_result($imgp, 0, "status");	
	if($stt=='S'){		
     $tam_img = getimagesize('area/'.mysql_result($imgp, 0, "img"));       
	 $posx = ceil($tam_img[0] / 2);
	 $posy = ceil($tam_img[1] / 2);
?>
  <div id="mascara">
    <div id="pop"
      style="position: fixed; z-index:50000; left: 50%; top: 50%; margin-left:-<?php echo $posx; ?>px; margin-top:-<?php echo $posy; ?>px;">
      <div id="fechar"
        style="width:25px; height:25px; top:50%; left:50%; margin-left:<?php echo ($posx - 12); ?>px; margin-top:-<?php echo ($posy + 12); ?>px;">
        <a onclick="closePopup();" style="cursor:pointer;"><img src="img/fechar-popup.png" width="25" height="25"
            alt="Fechar" title="Fechar" /></a>
      </div>
      <?php
		if(mysql_result($imgp, 0, "link")!=''){
			echo '<a onclick="closePopup();" href="https://'.mysql_result($imgp, 0, "link").'" target="'.mysql_result($imgp, 0, "target").'">';
		}
		echo '<img src="area/'.mysql_result($imgp, 0, "img").'" width="'.$tam_img[0].'" height="'.$tam_img[1].'" alt="Popup" usemap="#Map333"  />';
		if(mysql_result($imgp, 0, "link")!=''){
			echo '</a>';
		}
		?>
    </div>
  </div>
  <script>
  function closePopup() {
    $.ajax({
      url: 'pg/config/popup.php',
      type: 'post',
      data: 'status=2',
      success: function(data) {
        $("#mascara, #pop, #fechar").hide("slow");
      }
    });
    return false;
  }
  </script>
  <?php }}

function EntreDatas( $inicio, $fim ){
      $aInicio = Explode( "/",$inicio );
      $aFim    = Explode( "/",$fim    );
      $nTempo = mktime(0,0,0,$aFim[1],$aFim[0],$aFim[2]);
      $nTempo1= mktime(0,0,0,$aInicio[1],$aInicio[0],$aInicio[2]);
      return round(($nTempo-$nTempo1)/86400);
 }

?>

  <div id="topo">
    <div class="util">
      <div class="cabecalho">
        <div class="faz-busca">
          <form name="buscar" id="buscar" action="./?pg=busca" method="post">
            <input type="submit" name="envia" class="lupa-busca" value="&nbsp;" />
            <input type="text" name="termo" class="termo" value="Buscar notícias..." />
          </form>
        </div>
        <?php if($GLOBALS['config']['facebook']!=''){ ?><a href="https://<?php echo $GLOBALS['config']['facebook']; ?>"
          target="_blank">
          <div class="facebook"></div>
        </a><?php } ?>
        <a href="./contato/fale-conosco">
          <div class="fcontato"></div>
        </a>
        <a href="./contato/localizacao">
          <div class="localizacao"></div>
        </a>
      </div>
      <div class="clear">&nbsp;</div>

      <div class="logomarca"><a href="./home"><img src="img/logomarca-scj.png" width="386" height="87"
            alt="<?php echo $GLOBALS['config']['nome']; ?>" title="<?php echo $GLOBALS['config']['nome']; ?>" /></a>
      </div>
      <ul class="menu">
        <li id="subinstitucional"
          class="minstitucional<?php if($inc=='empresa' || $inc=='espiritualidade' || $inc=='dehonianos' || $inc=='programas' || $inc=='sacerdotes'){ echo 'ativo'; } ?>">
          <ul class="subinstitucional">
            <a href="./institucional/historia">
              <li>Nossa História</li>
            </a>
            <a href="./institucional/dehonianos">
              <li>Dehonianos</li>
            </a>
            <a href="./institucional/espiritualidade">
              <li>Espiritualidade</li>
            </a>
            <a href="./institucional/sacerdotes">
              <li>Sacerdotes</li>
            </a>
            <a href="./institucional/programas-de-radio">
              <li>Programas de Rádio</li>
            </a>
          </ul>
        </li>
        <li id="subnoticias" class="mnoticias<?php if($inc=='noticias' || $inc=='historico'){ echo 'ativo'; } ?>">
          <ul class="subnoticias">
            <?php
					$vc = mysql_query("SELECT * FROM categoria WHERE status='S' ORDER BY id_o ASC");
					while($rw = mysql_fetch_object($vc)){
						echo '<a href="./noticias/'.$rw->urlcheck.'"><li>'.$rw->nome.'</li></a>';
					}
					?>
          </ul>
        </li>
        <!-- 			<li id="subcomunidades" class="mcomunidades<?php #if($inc=='comunidades'){ echo 'ativo'; } ?>">
				<ul class="subcomunidades">
					<?php
					// $vc = mysql_query("SELECT * FROM comunidades WHERE status='S' ORDER BY id_o ASC");
					// while($rw = mysql_fetch_object($vc)){
					// 	echo '<a href="./'.$rw->urlcheck.'"><li>'.$rw->titulo.'</li></a>';
					// }
					?>
				</ul>
			</li> -->
        <a href="./pastorais">
          <li class="mpastorais<?php if($inc=='pastorais'){ echo 'ativo'; } ?>"></li>
        </a>
        <a href="./artigos">
          <li class="martigos<?php if($inc=='artigos'){ echo 'ativo'; } ?>"></li>
        </a>
        <li id="subinteratividade"
          class="minteratividade<?php if($inc=='fotos' || $inc=='agenda' || $inc=='pedidos' || $inc=='intencao'){ echo 'ativo'; } ?>">
          <ul class="subinteratividade">
            <a href="./interatividade/agenda">
              <li>Agenda</li>
            </a>
            <a href="./interatividade/fotos">
              <li>Galeria de Fotos</li>
            </a>
            <a href="./interatividade/jornal-on-line">
              <li>Jornal On-line</li>
            </a>
            <a href="./interatividade/intencoes">
              <li>Intenções</li>
            </a>
            <a href="./interatividade/pedidos-de-oracao">
              <li>Pedidos de Oração</li>
            </a>
            <a href="./interatividade/liturgia-diaria/<?php echo date("Y-m-d"); ?>">
              <li>Liturgia Diária</li>
            </a>
            <a href="./interatividade/santo-do-dia/<?php echo date("Y-m-d"); ?>">
              <li>Santo do dia</li>
            </a>
          </ul>
        </li>
        <a href="./seja-dizimista">
          <li class="mdizimo<?php if($inc=='dizimo'){ echo 'ativo'; } ?>"></li>
        </a>
        <li id="subcontato"
          class="mcontato<?php if($inc=='localizacao' || $inc=='contato' || $inc=='horarios'){ echo 'ativo'; } ?>">
          <ul class="subcontato">
            <a href="./contato/fale-conosco">
              <li>Fale Conosco</li>
            </a>
            <a href="./contato/horarios">
              <li>Horários</li>
            </a>
            <a href="./contato/localizacao">
              <li>Localização</li>
            </a>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  <div class="conteudo">
    <?php if(isset($_GET['pg'])) { $atual = 'pg/'.$_GET['pg'].'.php'; if (isset($atual) AND (array_search($atual, $permitidos) !== false)) { $arquivo = 'pg/'.$_GET['pg'].'.php'; } else { $arquivo = 'pg/home.php'; } } else { $arquivo = 'pg/home.php'; } include($arquivo); ?>
  </div>
  <div class="clear">&nbsp;</div>

  <div class="rodape">
    <div class="util">
      <div class="direitos corbranco tahomanormal">
        <?php echo $GLOBALS['config']['nome']; ?><br />
        <?php echo $GLOBALS['config']['endereco'].'<br />'.$GLOBALS['config']['telefone']; ?>
        <p>Copyright © <?php echo date("Y").' '.$GLOBALS['config']['nome']; ?> . Todos os direitos reservados.</p>
      </div>
      <a href="https://www.agenciaarcanjo.com.br" target="_blank">
        <div class="arcanjo"></div>
      </a>
    </div>
  </div>

  <a href='#' id='btn-dinamic'><span></span></a>
  <script type='text/javascript'>
  $(function() {
    $.fn.scrollToTop = function() {
      $(this).hide().removeAttr("href");
      if ($(window).scrollTop() != "0") {
        $(this).fadeIn("slow")
      }
      var scrollDiv = $(this);
      $(window).scroll(function() {
        if ($(window).scrollTop() == "0") {
          $(scrollDiv).fadeOut("slow")
        } else {
          $(scrollDiv).fadeIn("slow")
        }
      });
      $(this).click(function() {
        $("html, body").animate({
          scrollTop: 0
        }, "slow")
      })
    }
  });
  $(function() {
    $("#btn-dinamic").scrollToTop();
  });
  </script>

  <script>
  (function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function() {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
      m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
  })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
  ga('create', 'UA-113020592-1', 'auto');
  ga('send', 'pageview');
  </script>

</body>

</html>