<?php
if(!isset($_SESSION['id_usuario'])) {
	header("Location: index.php?pg=home");
    exit;
} else {
	if($_SESSION['nivel_usuario']!=1){
		header("Location: index.php?pg=home");
        exit;
	}
}
$vrf = mysql_query("SELECT * FROM parceiros ORDER BY id_o ASC");
$cont = 0;
while($linha = mysql_fetch_array($vrf)) {
	$cont = $cont + 1;
	mysql_query("UPDATE parceiros SET id_o = '".$cont."' WHERE id=".limpa($linha[0]));
}	
if(isset($_GET['ativa'])) {
	$status = mysql_query("SELECT status FROM parceiros WHERE id='".limpa($_GET["ativa"])."'");
	if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
	mysql_query("UPDATE parceiros SET status = '".$user."' WHERE id = ".limpa($id));
	header("Location: ?pg=modulos/parceiros/novo#".$id);
}		
if (isset($_GET['acao'])) {
	$acao = $_GET['acao'];
    
	if ($acao == "up") {
		$idordenar = $_GET["id"];		
		$ordenar = mysql_query("SELECT * FROM parceiros WHERE id='".limpa($idordenar)."'");
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem[5] != "1") {
				$ido = $ordem[5] - 1;
				$p2 = $ido + 1;						
				$proximo = mysql_query("SELECT * FROM parceiros WHERE id_o='$ido'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera[5] + 1;
					$idup = $altera[5];					
					$redestaque = mysql_query("UPDATE parceiros SET
													 id_o = '".$ido2."'
													 WHERE id=".limpa($altera[0]));
				}				
				$rdestaque = mysql_query("UPDATE parceiros SET
											 id_o = '".$idup."'
											 WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/parceiros/novo#".$idordenar);
            exit;
		}
	}
	if ($acao == "down") {
		$idordenar = $_GET["id"];
		$ordenar = mysql_query("SELECT * FROM parceiros WHERE id='".limpa($idordenar)."'");
		$st = mysql_query("SELECT * FROM clientes");
		$vttb = mysql_num_rows($st);
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem[5] != $vttb) {
				$ido = $ordem[5] + 1;
				$p2 = $ido - 1;							
				$proximo = mysql_query("SELECT * FROM parceiros WHERE id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera[5] - 1;
					$idup = $altera[5];					
					$redestaque = mysql_query("UPDATE parceiros SET
													 id_o = '".$ido2."'
													 WHERE id=".limpa($altera[0]));			
				}				
				$rdestaque = mysql_query("UPDATE parceiros SET
												 id_o = '".$idup."'
												 WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/parceiros/novo#".$idordenar);
            exit;
		}
	}
	
	if ($acao == "add") {			
		$nomecliente = $_POST['empresa'];
		$url = $_POST['site'];
		if(isset($_FILES["arquivo"])){
			$arquivo = $_FILES["arquivo"];			
			$pasta_dir = "img/parceiros/";			
			if(!file_exists($pasta_dir)){
				mkdir($pasta_dir);
			}			
			preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);			
			$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];			
			move_uploaded_file($arquivo["tmp_name"], $imagem);
            
			
			$insereCliente = mysql_query("INSERT INTO parceiros (empresa, site, img, status) VALUES ('$nomecliente', '$url', '$imagem', 'S')");
			header ("Location: ?pg=modulos/parceiros/novo");
            exit;
		}
	}
	if($acao=="att"){
		$envio = '?pg=modulos/parceiros/novo&acao=edit&id='.$_GET['id'];
		$bt = 'Atualizar';
		$sb = mysql_query("SELECT * FROM parceiros WHERE id='".limpa($_GET['id'])."'");
		while($linha = mysql_fetch_array($sb)) {
			$img = '<img src="'.$linha[3].'" width="135" alt="'.$linha[1].'" title="'.$linha[1].'" /><br />';
			$descricao = $linha[1];
			$site = $linha[2];
		}
	}
	if ($acao == "edit") {
		$idedit = $_GET["id"];
		$nomeempresa = $_POST['empresa'];
		$site = $_POST['site'];			
		if($_FILES["arquivo"] != "") {
			$arquivo = $_FILES["arquivo"];
			$pasta_dir = "img/parceiros/";				
			if(!file_exists($pasta_dir)){
				mkdir($pasta_dir);
			}
			$imgantiga = mysql_query("SELECT img FROM parceiros WHERE id='".limpa($idedit)."'");
			$imgbanco = mysql_result($imgantiga, 0, "img");				   
			preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);			   
			$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];									   
			if(move_uploaded_file($arquivo['tmp_name'],$imagem)){		

				@unlink($imgbanco);
		        
				$update = mysql_query("UPDATE parceiros SET
											empresa = '".$nomeempresa."',
											site = '".$site."',
											img = '".$imagem."'
											WHERE id =" .limpa($idedit));
				
			}else{
				$imagem = $imgbanco;
				$update = mysql_query("UPDATE parceiros SET
            								empresa = '".$nomeempresa."',
            								site = '".$site."',
            								img = '".$imagem."'
            								WHERE id =" .limpa($idedit));
			}
			header ("Location: ?pg=modulos/parceiros/novo");
            exit;
		}
	}
} else {
	$envio = '?pg=modulos/parceiros/novo&acao=add';
	$bt = 'Cadastrar';
	$img = '';
	$descricao = '';
	$site = '';
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
</head>
<body>

<form id="simulador" name="simulador" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Gerencimanento de Patrocinadores - 990 x 163 pixels</th>
    <th scope="col" width="10%" align="right"><a href='?pg=config/_meuPainel'><img src='img/icones/voltar.png' width='32' height='32' alt='Painel de Controle' /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="30%" height="36" align="right" valign="middle">* Banner &nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $img; ?><input name="arquivo" <?php if(!isset($_GET['acao'])){ echo ' class="obrigatorio" '; } ?> type="file" id="arquivo" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Nome da Empresa&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="empresa" type="text" id="empresa" class="obrigatorio" value="<?php echo $descricao; ?>" style="width:450px;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">Url de destino&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="site" type="text" id="site" value="<?php echo $site; ?>" style="width:450px;" />&nbsp;Sem http://</td>
    </tr>
    <tr>
      <td colspan="2" height="60" valign="middle" align="center"><label><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></label></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
	$sql = mysql_query("SELECT * FROM parceiros ORDER BY id_o ASC");
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
		echo "    <th class='filter-false'>Logomarca</th>";
		echo "    <th>Nome da Empresa</th>";
		echo "    <th class='filter-false'>Url Destino</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "    <th>Ordem</th>";
		echo "    <th class='filter-false'>Logomarca</th>";
		echo "    <th>Nome da Empresa</th>";
		echo "    <th class='filter-false'>Url Destino</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";		
		while($linha = mysql_fetch_array($sql)) {
			echo "<tr>";
			echo "<td width='80'>";
			if($linha['id_o']!=1){
				echo "<a href='?pg=modulos/parceiros/novo&acao=up&id=$linha[0]'><img src='img/icones/up.png' width='16' height='16' alt='Subir Item' title='Subir Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "<span class='t15 corlaranja bold' style='padding:0px 15px;'>".$linha['id_o']."</span>";
			if($linha['id_o']!=mysql_num_rows($sql)){
				echo "<a href='?pg=modulos/parceiros/novo&acao=down&id=$linha[0]'><img src='img/icones/down.png' width='16' height='16' alt='Descer Item' title='Descer Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "<td width='230'>";
			echo "<img src='".$linha['img']."' width='200' alt='' /></td>";
			echo "<td>";
			if ($linha['status'] == "N") {
				echo "<strike>";
			}
			echo $linha['empresa'];
			if ($linha['status'] == "N") {
				echo "</strike>";
			}
			echo "</td>";
			echo "    <td width='130'>";
			if($linha['site']!=''){
				echo "<a href='http://".$linha['site']."' target='_blank'><img src='img/icones/url.png' width='16' height='16' alt='Visualizar Url' title='Visualizar Url' /></a>";	
			}
			echo "<td width='120'>";
			echo "
			<a href='?pg=modulos/parceiros/novo&ativa=$linha[0]' name='".$linha[0]."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar/Desativar' title='Ativar/Desativar' /></a>
			<a onclick=\"javascript:confirmaDel('?pg=modulos/parceiros/novo&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
			<a href='?pg=modulos/parceiros/novo&acao=att&id=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo '</tbody>';
		echo "</table>";
	}
	if(isset($_GET["del"])){
		$imgantiga = mysql_query("SELECT img, img_p FROM parceiros WHERE id='".limpa($_GET['del'])."'");
		$return = unlink(mysql_result($imgantiga, 0, "img"));
        $return = unlink(mysql_result($imgantiga, 0, "img_p"));
		mysql_query("DELETE FROM parceiros WHERE id='".limpa($_GET['del'])."'");
		header ("Location: ?pg=modulos/parceiros/novo");
	}
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>