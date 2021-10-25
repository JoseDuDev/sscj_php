<?php
ob_start();
session_start();
include("pg/config/_conectaBanco.php");
include("pg/config/_configGerais.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="pt-br" />
<meta http-equiv="Pragma" content="no-cache" />
<title><?php echo $GLOBALS['config']["titulo"]; ?></title>
<link rel="shortcut icon" type="img/ico" href="https://<?php echo $GLOBALS['config']["url"]; ?>/img/favicon.ico" />

<link type="text/css" href="css/limpar.css" rel="stylesheet" />
<link type="text/css" href="css/layout.css" rel="stylesheet" />

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/msg.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>

</head>
<body>

<div id="corpo">
	<div id="carregando"><img src="img/carregando.gif" width="32" height="32" alt="" title="" /></div>
	<div id="conteudo">

		<?php if(isset($_SESSION['id_usuario'])) { ?>
		<div class="controle">
		<div id='topo-painel'>
			
			<span id='pinfo' class='t20 bold corlaranja'>Olá <?php echo $_SESSION['nome_usuario']; ?><p class='t10 corcinza2'>Logado desde <?php echo $_SESSION['uacesso_usuario']; ?></p></span>
			<span id='sinfo'>
			<a href='?pg=config/meuPainel'><img src='img/icones/meupainel.png' width='16' height='16' alt='Voltar ao Painel Principal' title='Voltar ao Painel Principal' />&nbsp;PAINEL</a>
			<?php
			if($_SESSION['nivel_usuario']==1){
				echo "<a onclick='vonline();' style='cursor:pointer;'><img src='img/icones/online.png' width='16' height='16' alt='Visualizar Usuários Online' title='Visualizar Usuários Online' />&nbsp;ONLINE</a>";
			}
			?>
			<a href='https://<?php echo $GLOBALS['config']["url"]; ?>' target='_blank'><img src='img/icones/visualizar.png' width='16' height='16' alt='Visualizar Site em Nova Aba' title='Visualizar Site em Nova Aba' />&nbsp;SITE</a>
			<a href='?pg=config/_deslogaSistema'><img src='img/icones/remover.png' width='16' height='16' alt='Deslogar do Sistema' title='Deslogar do Sistema' />&nbsp;DESLOGAR</a>
			</span>
		</div>
		<div id='vonline'>&nbsp;</div>
		<?php } ?>

		<?php if(isset($_GET['pg'])) { $atual = 'pg/'.$_GET['pg'].'.php'; if (isset($atual) AND (array_search($atual, $permitidos) !== false)) { $arquivo = 'pg/'.$_GET['pg'].'.php'; } else { $arquivo = 'pg/principal.php'; } } else { $arquivo = 'pg/principal.php'; } include($arquivo); ?>

		<?php if(isset($_SESSION['id_usuario'])) { echo '</div>'; } ?>
	</div>
</div>

</body>
</html>