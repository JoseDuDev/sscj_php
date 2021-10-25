<?php
if(!isset($_SESSION['nivel_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!='1') {
		header("Location: ?pg=inicial");
	}
}
if (isset($_GET['conceito'])) {
	mysql_query("UPDATE empresa SET texto = '".mysql_real_escape_string($_POST['desc'])."' WHERE id ='3'");
	header("Location: ?pg=modulos/conheca/espiritualidade");
} else {
	$envio2 = "?pg=modulos/conheca/espiritualidade&conceito";		
	$ed = mysql_query("SELECT * FROM empresa WHERE id='3'");
	$rw = mysql_fetch_object($ed);
	$conteudo = $rw->texto;
}
$vrf = mysql_query("SELECT * FROM espiritualidade ORDER BY id_o ASC");
$cont = 0;
while($linha = mysql_fetch_array($vrf)) {
	$cont = $cont + 1;
	mysql_query("UPDATE espiritualidade SET id_o = '".$cont."' WHERE id=".limpa($linha[0]));
}	
if(isset($_GET['ativa'])) {
	$status = mysql_query("SELECT status FROM espiritualidade WHERE id='".limpa($_GET["ativa"])."'");
	if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
	mysql_query("UPDATE espiritualidade SET status = '".limpa($user)."' WHERE id = ".limpa($_GET["ativa"]));
	header("Location: ?pg=modulos/conheca/espiritualidade#".$_GET["ativa"]);
}
if (isset($_GET['acao'])) {
	$acao = $_GET['acao'];
	if ($acao == "up") {
		$idordenar = $_GET["id"];		
		$ordenar = mysql_query("SELECT * FROM espiritualidade WHERE id='".limpa($idordenar)."'");
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem['id_o'] != "1") {
				$ido = $ordem['id_o'] - 1;
				$p2 = $ido + 1;						
				$proximo = mysql_query("SELECT * FROM espiritualidade WHERE id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera['id_o'] + 1;
					$idup = $altera['id_o'];					
					mysql_query("UPDATE espiritualidade SET id_o = '".limpa($ido2)."' WHERE id=".limpa($altera[0]));
				}				
				mysql_query("UPDATE espiritualidade SET id_o = '".limpa($idup)."' WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/conheca/espiritualidade#".$idordenar);
		}
	}
	if ($acao == "down") {
		$idordenar = $_GET["id"];
		$ordenar = mysql_query("SELECT * FROM espiritualidade WHERE id='".limpa($idordenar)."'");
		$st = mysql_query("SELECT * FROM espiritualidade");
		$vttb = mysql_num_rows($st);
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem['id_o'] != $vttb) {
				$ido = $ordem['id_o'] + 1;
				$p2 = $ido - 1;							
				$proximo = mysql_query("SELECT * FROM espiritualidade WHERE id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera['id_o'] - 1;
					$idup = $altera['id_o'];					
					mysql_query("UPDATE espiritualidade SET id_o = '".limpa($ido2)."' WHERE id=".limpa($altera[0]));			
				}				
				mysql_query("UPDATE espiritualidade SET id_o = '".limpa($idup)."' WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/conheca/espiritualidade#".$idordenar);
		}
	}
	if ($acao=="add") {
		if(isset($_FILES["arquivo"])){
			$arquivo = $_FILES["arquivo"];			
			$pasta_dir = "img/sons/";			
			if(!file_exists($pasta_dir)){
				mkdir($pasta_dir);
			}			
			preg_match("/\.(mp3){1}$/i", $arquivo["name"], $ext);			
			$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
			move_uploaded_file($arquivo["tmp_name"], $imagem);
		}
	    $maximo = mysql_result(mysql_query("SELECT COALESCE(MAX(id_o),0)+1 as maximo FROM espiritualidade"),0,'maximo');
		mysql_query("INSERT INTO espiritualidade (titulo, id_o, som) VALUES ('".mysql_real_escape_string($_POST['titulo'])."', '".$maximo."','".$imagem."')");
		header ("Location: ?pg=modulos/conheca/espiritualidade");
	}
	if ($acao=="att") {
		$envio = '?pg=modulos/conheca/espiritualidade&acao=edit&i='.$_GET['i'];
		$bt = 'Cadastrar';
		$dpg = 'Espiritualidade';
		$resultado = mysql_query("SELECT * FROM espiritualidade WHERE id='".limpa($_GET['i'])."'");
		while ($linha = mysql_fetch_array($resultado)) {
			$titulo   = $linha['titulo'];
		}
	}
	if ($acao=="edit") {
		if($_FILES["arquivo"] != "") {
			$arquivo = $_FILES["arquivo"];
			$pasta_dir = "img/sons/";				
			if(!file_exists($pasta_dir)){
				mkdir($pasta_dir);
			}
			$imgantiga = mysql_query("SELECT som FROM espiritualidade WHERE id='".limpa($idedit)."'");
			$imgbanco = mysql_result($imgantiga, 0, "som");				   
			preg_match("/\.(mp3){1}$/i", $arquivo["name"], $ext);			   
			$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];									   
			if(move_uploaded_file($arquivo['tmp_name'],$imagem)){		
				$return = @unlink($imgbanco);
			}else{
				$imagem = $imgbanco;
			}
		}
		mysql_query("UPDATE espiritualidade SET titulo = '".mysql_real_escape_string($_POST['titulo'])."', som = '".$imagem."'  WHERE id =" .limpa($_GET["i"]));
		header ("Location: ?pg=modulos/conheca/espiritualidade");			
	}	
} else {
	$envio = '?pg=modulos/conheca/espiritualidade&acao=add';
	$bt = 'Cadastrar';
	$dpg = 'Espiritualidade';
	$titulo = '';
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script>
$(document).ready(function(){
	$("table.tablesorter").tablesorter({
		theme: 'blue',
		widthFixed : true,
		widgets: ["zebra", "filter"],
		widgetOptions : {
			filter_childRows : false,
			filter_columnFilters : true,
			filter_cssFilter : 'tablesorter-filter',
			filter_functions : null,
			filter_hideFilters : true,
			filter_ignoreCase : true,
			filter_reset : 'button.reset',
			filter_searchDelay : 300,
			filter_startsWith : false,
			filter_useParsedData : false
		}
	});

	$('button.search').click(function(){
		var filters = $('table').find('input.tablesorter-filter'),
			col = $(this).data('filter-column'),
			txt = $(this).data('filter-text');
		filters.val('');
		filters.eq(col).val(txt).trigger('search', false);
	});
});
</script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
  tinyMCE.init({
    language : "pt",
    mode : "textareas",
    theme : "advanced",
    plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
theme_advanced_buttons1:
"bold,italic,underline,strikethrough",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_buttons4 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
   content_css : "css/content.css",
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",
    file_browser_callback : "tinyBrowser",
    template_replace_values : {
      username : "Some User",
      staffid : "991234"
    }
  });
</script>
</head>
<body>
<form id="estagio" name="estagio" method="post" action="<?php echo $envio2; ?>">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Introdução</th>
    <th scope="col" width="10%" align="center"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr>
  <tr>
    <td height="160" align="center"><textarea id="desc" name="desc" style="width: 85%; height:150px;"><?php echo $conteudo; ?></textarea></td>
  </tr>
    <tr>
      <td valign="middle" colspan="2" align="center"><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="Atualizar Introdução" /></td>
    </tr>
</table>
</form>
<form id="estagios" name="estagios" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center"><?php echo $dpg; ?></th>
    <th scope="col" width="10%">&nbsp;</th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="15%" height="36" align="right" valign="middle">* Titulo&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="titulo" type="text" value="<?php echo $titulo; ?>" id="titulo" class="obrigatorio" style="width:900px;" /></td>
    </tr>
    <tr>
      <td width="30%" height="36" align="right" valign="middle">Som / Música&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="arquivo" type="file" id="arquivo" />&nbsp;&nbsp;Máximo de 6M - Formato .mp3</td>
    </tr>
    <tr>
      <td valign="middle" colspan="2" align="center"><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
	$sql = mysql_query("SELECT * FROM espiritualidade ORDER BY id_o ASC");
	if(mysql_num_rows($sql)==0){
		echo "<table width='1180' border='0' cellspacing='0' cellpadding='0'>";
		echo "<tr>";
		echo "    <td height='90' align='center'>Aguardando cadastramento...</td>";
		echo "</tr>";
		echo "</table>\n";
	} else {
		echo '<button class="reset bt">LIMPAR FILTROS</button>';
		echo "<table class='tablesorter' border='0' cellspacing='0' cellpadding='0' style='margin:10px;'>";
		echo "<thead>";
		echo "<tr>";
		echo "    <th>Ordem</th>";
        echo "    <th>Titulo</th>";
        echo "    <th>Áudio</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "    <th>Ordem</th>";
        echo "    <th>Titulo</th>";
        echo "    <th>Áudio</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";	
		while($linha = mysql_fetch_array($sql)) {
			$vf = explode(".", $linha['som']);
			echo "<tr>";
			echo "<td width='120'>";
			if($linha['id_o']!=1){
				echo "<a href='?pg=modulos/conheca/espiritualidade&acao=up&id=$linha[0]'><img src='img/icones/up.png' width='16' height='16' alt='Subir Item' title='Subir Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "<span class='t15 corlaranja bold' style='padding:0px 15px;'>".$linha['id_o']."</span>";
			if($linha['id_o']!=mysql_num_rows($sql)){
				echo "<a href='?pg=modulos/conheca/espiritualidade&acao=down&id=$linha[0]'><img src='img/icones/down.png' width='16' height='16' alt='Descer Item' title='Descer Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "</td>";
			echo "<td width='350' height='40'>".$linha['titulo']."</td>";
			echo "<td width='300' align='center'>";
			if(!empty($vf[1])){
				echo "<object type='application/x-shockwave-flash' data='../flash/player.swf' id='audioplayer1' height='24' width='290'><param name='movie' value='../flash/player.swf'><param name='FlashVars' value='playerID=1&bg=0xf8f8f8&leftbg=0xeeeeee&lefticon=0x666666&rightbg=0xb8b160&rightbghover=0x999999&righticon=0x323232&righticonhover=0xffffff&text=0x666666&slider=0x666666&track=0xFFFFFF&border=0x666666&loader=0xb8b160&loop=yes&autostart=no&soundFile=".$linha['som']."'><param name='quality' value='high'><param name='menu' value='false'><param name='wmode' value='transparent'></object>";
			} else {
				echo '---';
			}
			echo "</td>";
			echo "<td width='70'>";
			echo "<a onclick=\"javascript:confirmaDel('?pg=modulos/conheca/espiritualidade&del=$linha[0]')\" name='".$linha[0]."' style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>";
			echo "<a href='?pg=modulos/conheca/espiritualidade&acao=att&i=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo '</tbody>';
		echo "</table>";
		if(isset($_GET["del"])) {
			mysql_query("DELETE FROM espiritualidade WHERE id='".limpa($_GET['del'])."'");
			$return = @unlink('area/'.mysql_result(mysql_query("SELECT * FROM espiritualidade WHERE id='".$_GET['del']."'"),0,"som"));
			header ("Location: ?pg=modulos/conheca/espiritualidade");
		}
	}
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>