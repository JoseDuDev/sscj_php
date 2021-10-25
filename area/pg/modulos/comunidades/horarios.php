<?php
if(!isset($_SESSION['nivel_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!='1') {
		header("Location: ?pg=inicial");
	}
}
$vrf = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$_GET['comunidade']."' ORDER BY id_o ASC");
$cont = 0;
while($linha = mysql_fetch_array($vrf)) {
	$cont = $cont + 1;
	mysql_query("UPDATE comunidades_horarios SET id_o = '".$cont."' WHERE id=".limpa($linha[0]));
}	
if(isset($_GET['ativa'])) {
	$status = mysql_query("SELECT status FROM comunidades_horarios WHERE comunidade='".$_GET['comunidade']."' AND id='".limpa($_GET["ativa"])."'");
	if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
	mysql_query("UPDATE comunidades_horarios SET status = '".limpa($user)."' WHERE id = ".limpa($_GET["ativa"]));
	header("Location: ?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']."#".$_GET["ativa"]);
}
if (isset($_GET['acao'])) {
	$acao = $_GET['acao'];
	if ($acao == "up") {
		$idordenar = $_GET["id"];		
		$ordenar = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$_GET['comunidade']."' AND id='".limpa($idordenar)."'");
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem['id_o'] != "1") {
				$ido = $ordem['id_o'] - 1;
				$p2 = $ido + 1;						
				$proximo = mysql_query("SELECT * FROM comunidades_horarios WHERE id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera['id_o'] + 1;
					$idup = $altera['id_o'];					
					mysql_query("UPDATE comunidades_horarios SET id_o = '".limpa($ido2)."' WHERE id=".limpa($altera[0]));
				}				
				mysql_query("UPDATE comunidades_horarios SET id_o = '".limpa($idup)."' WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']."#".$idordenar);
		}
	}
	if ($acao == "down") {
		$idordenar = $_GET["id"];
		$ordenar = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$_GET['comunidade']."' AND id='".limpa($idordenar)."'");
		$st = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$_GET['comunidade']."'");
		$vttb = mysql_num_rows($st);
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem['id_o'] != $vttb) {
				$ido = $ordem['id_o'] + 1;
				$p2 = $ido - 1;							
				$proximo = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$_GET['comunidade']."' AND id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera['id_o'] - 1;
					$idup = $altera['id_o'];					
					mysql_query("UPDATE comunidades_horarios SET id_o = '".limpa($ido2)."' WHERE id=".limpa($altera[0]));			
				}				
				mysql_query("UPDATE comunidades_horarios SET id_o = '".limpa($idup)."' WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']."#".$idordenar);
		}
	}
	if ($acao=="add") {
	    $maximo = mysql_result(mysql_query("SELECT COALESCE(MAX(id_o),0)+1 as maximo FROM comunidades_horarios WHERE oque='".$_POST['oque']."'"),0,'maximo');
		mysql_query("INSERT INTO comunidades_horarios (nome, horario, id_o, oque, comunidade) VALUES ('".mysql_real_escape_string($_POST['setor'])."', '".mysql_real_escape_string($_POST['horario'])."', '".$maximo."', '".mysql_real_escape_string($_POST['oque'])."', '".$_GET['comunidade']."')");
		header ("Location: ?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']);
	}
	if ($acao=="att") {
		$envio = '?pg=modulos/comunidades/horarios&acao=edit&i='.$_GET['i'].'&comunidade='.$_GET['comunidade'];
		$bt = 'Cadastrar';
		$resultado = mysql_query("SELECT * FROM comunidades_horarios WHERE id='".limpa($_GET['i'])."'");
		while ($linha = mysql_fetch_array($resultado)) {
			$set   	   = $linha['nome'];
            $horario   = $linha['horario'];
            $oque 	   = $linha['oque'];
		}
	}
	if ($acao=="edit") {	
		mysql_query("UPDATE comunidades_horarios SET nome = '".mysql_real_escape_string($_POST['setor'])."', horario = '".mysql_real_escape_string($_POST['horario'])."', oque = '".mysql_real_escape_string($_POST['oque'])."'  WHERE id =" .limpa($_GET["i"]));
		header ("Location: ?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']);			
	}	
} else {
	$envio 	 = '?pg=modulos/comunidades/horarios&acao=add&comunidade='.$_GET['comunidade'];
	$bt 	 = 'Cadastrar';
	$set 	 = '';
	$horario = '';
	$oque 	 = '';
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
<form id="horarios" name="horarios" method="post" action="<?php echo $envio; ?>">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Horários de <?php echo '<font color="red">'.mysql_result(mysql_query("SELECT titulo FROM comunidades WHERE id='".$_GET['comunidade']."'"),0,"titulo").'</font>'; ?></th>
    <th scope="col" width="10%" align="center"><a href="?pg=modulos/comunidades/novo#<?php echo $_GET['comunidade']; ?>"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="30%" height="36" align="right" valign="middle">O que&nbsp;&nbsp;</td>
      <td height="36" align="left">
      	<select name="oque" style="text-align: center; width: 462px; height: 30px;">
      		<?php
      		if($oque!=''){
      			echo '<option value="'.$oque.'">';
      			if($oque=='confissao'){
      				echo 'Confissão';
      			} else if($oque=='secretaria'){
					echo 'Atendimento Secretaria';
				} else if($oque=='missa'){
					echo 'Missa';
      			} else {
      				echo 'Outros';
      			}
      			echo '</option>';
      		}
      		?>
      		<option value="missa">Missa</option>
      		<option value="confissao">Confissão</option>
      		<option value="secretaria">Atendimento Secretaria</option>
      		<option value="outros">Outros</option>
      	</select>
  	</td>
    </tr>
    <tr>
      <td width="30%" height="36" align="right" valign="middle">* Dia / Nome&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="setor" type="text" value="<?php echo $set; ?>" id="setor" class="obrigatorio" style="width:450px;" /></td>
    </tr>
    <tr>
      <td width="30%" height="36" align="right" valign="middle">* Horários&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="horario" type="text" value="<?php echo $horario; ?>" id="horario" class="obrigatorio" style="width:450px;" /></td>
    </tr>
    <tr>
      <td valign="middle" colspan="2" align="center"><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
	$sql = mysql_query("SELECT * FROM comunidades_horarios WHERE comunidade='".$_GET['comunidade']."' ORDER BY id_o ASC");
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
		echo "    <th>O que</th>";
		echo "    <th>Dia</th>";
        echo "    <th>Horário</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "    <th>Ordem</th>";
		echo "    <th>O que</th>";
		echo "    <th>Dia</th>";
        echo "    <th>Horário</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";	
		while($linha = mysql_fetch_array($sql)) {
			echo "<tr>";
			echo "<td width='130'>";
			if($linha['id_o']!=1){
				echo "<a href='?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']."&acao=up&id=$linha[0]'><img src='img/icones/up.png' width='16' height='16' alt='Subir Item' title='Subir Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "<span class='t15 corlaranja bold' style='padding:0px 15px;'>".$linha['id_o']."</span>";
			if($linha['id_o']!=mysql_num_rows($sql)){
				echo "<a href='?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']."&acao=down&id=$linha[0]'><img src='img/icones/down.png' width='16' height='16' alt='Descer Item' title='Descer Item' /></a>";
			} else {
				echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
			}
			echo "</td>";
			echo "<td>";
			if ($linha['status'] == "N") {
				echo "<strike>";
			}
  			if($linha['oque']=='confissao'){
  				echo 'Confissão';
  			} else if($linha['oque']=='secretaria'){
				echo 'Atendimento Secretaria';
  			} else if($linha['oque']=='missa'){
				echo 'Missa';
  			} else {
  				echo 'Outros';
  			}
			if ($linha['status'] == "N") {
				echo "</strike>";
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
            echo "<td>";
            if ($linha['status'] == "N") {
                echo "<strike>";
            }
            echo $linha['horario'];
            if ($linha['status'] == "N") {
                echo "</strike>";
            }
            echo "</td>";
			echo "<td width='130'>";
			echo "<a href='?pg=modulos/comunidades/horarios&ativa=$linha[0]&comunidade=".$_GET['comunidade']."' name='".$linha[0]."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar/Desativar' title='Ativar/Desativar' /></a>";
			echo "<a onclick=\"javascript:confirmaDel('?pg=modulos/comunidades/horarios&del=$linha[0]&comunidade=".$_GET['comunidade']."')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>";
			echo "<a href='?pg=modulos/comunidades/horarios&acao=att&i=$linha[0]&comunidade=".$_GET['comunidade']."'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo '</tbody>';
		echo "</table>";
		if(isset($_GET["del"])) {
			mysql_query("DELETE FROM comunidades_horarios WHERE id='".limpa($_GET['del'])."'");
			header ("Location: ?pg=modulos/comunidades/horarios&comunidade=".$_GET['comunidade']."");
		}
	}
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>