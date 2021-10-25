<?php
if(!isset($_SESSION['nivel_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!='1') {
		header("Location: ?pg=inicial");
	}
}
$vrf = mysql_query("SELECT * FROM radio ORDER BY id_o ASC");
$cont = 0;
while($linha = mysql_fetch_array($vrf)) {
	$cont = $cont + 1;
	mysql_query("UPDATE radio SET id_o = '".$cont."' WHERE id=".limpa($linha[0]));
}	
if(isset($_GET['ativa'])) {
	$status = mysql_query("SELECT status FROM radio WHERE id='".limpa($_GET["ativa"])."'");
	if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
	mysql_query("UPDATE radio SET status = '".limpa($user)."' WHERE id = ".limpa($_GET["ativa"]));
	header("Location: ?pg=modulos/conheca/radio#".$_GET["ativa"]);
}
if (isset($_GET['acao'])) {
	$acao = $_GET['acao'];
	if ($acao == "up") {
		$idordenar = $_GET["id"];		
		$ordenar = mysql_query("SELECT * FROM radio WHERE id='".limpa($idordenar)."'");
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem['id_o'] != "1") {
				$ido = $ordem['id_o'] - 1;
				$p2 = $ido + 1;						
				$proximo = mysql_query("SELECT * FROM radio WHERE id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera['id_o'] + 1;
					$idup = $altera['id_o'];					
					mysql_query("UPDATE radio SET id_o = '".limpa($ido2)."' WHERE id=".limpa($altera[0]));
				}				
				mysql_query("UPDATE radio SET id_o = '".limpa($idup)."' WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/conheca/radio#".$idordenar);
		}
	}
	if ($acao == "down") {
		$idordenar = $_GET["id"];
		$ordenar = mysql_query("SELECT * FROM radio WHERE id='".limpa($idordenar)."'");
		$st = mysql_query("SELECT * FROM radio");
		$vttb = mysql_num_rows($st);
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem['id_o'] != $vttb) {
				$ido = $ordem['id_o'] + 1;
				$p2 = $ido - 1;							
				$proximo = mysql_query("SELECT * FROM radio WHERE id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera['id_o'] - 1;
					$idup = $altera['id_o'];					
					mysql_query("UPDATE radio SET id_o = '".limpa($ido2)."' WHERE id=".limpa($altera[0]));			
				}				
				mysql_query("UPDATE radio SET id_o = '".limpa($idup)."' WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/conheca/radio#".$idordenar);
		}
	}
	if ($acao=="add") {
	    $maximo = mysql_result(mysql_query("SELECT COALESCE(MAX(id_o),0)+1 as maximo FROM setores"),0,'maximo');
		mysql_query("INSERT INTO radio (nome, descricao, info, link, id_o) VALUES ('".mysql_real_escape_string($_POST['setor'])."', '".mysql_real_escape_string($_POST['descricao'])."','".$_POST['horario']."','".$_POST['link']."', '".$maximo."')");
		header ("Location: ?pg=modulos/conheca/radio");
	}
	if ($acao=="att") {
		$envio = '?pg=modulos/conheca/radio&acao=edit&i='.$_GET['i'];
		$bt = 'Cadastrar';
		$resultado = mysql_query("SELECT * FROM radio WHERE id='".limpa($_GET['i'])."'");
		while ($linha = mysql_fetch_array($resultado)) {
			$set   		= $linha['nome'];
            $descricao  = $linha['descricao'];
            $horario 	= $linha['info'];
            $link 		= $linha['link'];
		}
	}
	if ($acao=="edit") {	
		mysql_query("UPDATE radio SET nome = '".mysql_real_escape_string($_POST['setor'])."', descricao = '".mysql_real_escape_string($_POST['descricao'])."', info='".$_POST['horario']."', link='".$_POST['link']."'  WHERE id =" .limpa($_GET["i"]));
		header ("Location: ?pg=modulos/conheca/radio");			
	}	
} else {
	$envio 		= '?pg=modulos/conheca/radio&acao=add';
	$bt 		= 'Cadastrar';
	$set 		= '';
	$descricao  = '';
	$horario 	= '';
	$link 		= '';
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
<form id="estagio" name="estagio" method="post" action="<?php echo $envio; ?>">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Institucional / Programas de Rádio</th>
    <th scope="col" width="10%" align="center"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="20%" height="36" align="right" valign="middle">* Nome&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="setor" type="text" value="<?php echo $set; ?>" id="setor" class="obrigatorio" style="width:450px;" /></td>
    </tr>
    <tr>
      <td width="20%" height="36" align="right" valign="middle">* Descrição&nbsp;&nbsp;</td>
      <td height="36" align="left"><textarea id="descricao" name="descricao" style="width: 90%; height:80px;"><?php echo $descricao; ?></textarea></td>
    </tr>
    <tr>
      <td width="20%" height="36" align="right" valign="middle">* Horário&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="horario" type="text" value="<?php echo $horario; ?>" id="horario" class="obrigatorio" style="width:450px;" /></td>
    </tr>
    <tr>
      <td width="20%" height="36" align="right" valign="middle">* Link&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="link" type="text" value="<?php echo $link; ?>" id="link" class="obrigatorio" style="width:450px;" />&nbsp;&nbsp;Sem http://</td>
    </tr>
    <tr>
      <td valign="middle" colspan="2" align="center"><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
	$sql = mysql_query("SELECT * FROM radio ORDER BY id_o ASC");
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
		echo "    <th>Rádio</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "    <th>Ordem</th>";
		echo "    <th>Rádio</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";	
		while($linha = mysql_fetch_array($sql)) {
			echo "<tr>";
			echo "<td width='140'>";
			if($linha['id_o']!=1){
				echo "<a href='?pg=modulos/conheca/radio&acao=up&id=$linha[0]'><img src='img/icones/up.png' width='16' height='16' alt='Subir Item' title='Subir Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "<span class='t15 corlaranja bold' style='padding:0px 15px;'>".$linha['id_o']."</span>";
			if($linha['id_o']!=mysql_num_rows($sql)){
				echo "<a href='?pg=modulos/conheca/radio&acao=down&id=$linha[0]'><img src='img/icones/down.png' width='16' height='16' alt='Descer Item' title='Descer Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "</td>";
			echo "<td>";
			if ($linha['status'] == "N") {
				echo "<strike>";
			}
			echo $linha['nome'];
			if ($linha['status'] == "N") {
				echo "</strike>";
			}
			echo "</td>";
			echo "<td width='140'>";
			echo "<a href='?pg=modulos/conheca/radio&ativa=$linha[0]' name='".$linha[0]."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar/Desativar' title='Ativar/Desativar' /></a>";
			echo "<a onclick=\"javascript:confirmaDel('?pg=modulos/conheca/radio&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>";
			echo "<a href='?pg=modulos/conheca/radio&acao=att&i=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo '</tbody>';
		echo "</table>";
		if(isset($_GET["del"])) {
			mysql_query("DELETE FROM radio WHERE id='".limpa($_GET['del'])."'");
			header ("Location: ?pg=modulos/conheca/radio");
		}
	}
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>