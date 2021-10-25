<?php
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ?pg=inicial");
} else {
    if($_SESSION['nivel_usuario']!='1'){
        header("Location: ?pg=inicial");
    }
}
if (isset($_GET['acao'])) {
	$acao = $_GET['acao'];
	if ($acao == "add") {
		$ic = mysql_query("INSERT INTO grupos (nome) VALUES ('".$_POST['nome']."')");
		header("Location: ?pg=modulos/news/grupos");
	}
	if($acao=="att"){
		$resultado = mysql_query("SELECT * FROM grupos WHERE id = '".$_GET['i']."'");
		$envio = '?pg=modulos/news/grupos&acao=edit&id='.$_GET['i'];
		$bt = 'Atualizar';
		$dpg = 'Edição de Grupo';
		while ($linha = mysql_fetch_row($resultado)) {
			$nome = $linha[1];
		}
	}
	if ($acao == "edit") {
		$update = mysql_query("UPDATE grupos SET nome = '".$_POST['nome']."' WHERE id =" .$_GET["id"]);							
		header("Location: ?pg=modulos/news/grupos");
	}
} else {
	$envio = '?pg=modulos/news/grupos&acao=add';
	$bt = 'Cadastrar';
	$dpg = 'Gerenciamento de Grupo';
	$nome = '';
}
?>
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
<form id="grupo" name="grupo" method="post" action="<?php echo $envio; ?>">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td colspan="2" height="100" valign="middle" align="center">
        
    <table width="95%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th scope="col" width="10%">&nbsp;</th>
        <th scope="col" width="80%" class="t20" align="center"><strong><br /><?php echo $dpg; ?></strong><br /><br /></th>
        <th scope="col" width="10%" align="center"><a href="?pg=modulos/news/direciona" style="cursor: pointer;"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
      </tr>
    </table>
    
        </td>
    </tr>
    <tr>
      <td width="35%" height="36" align="right" valign="middle">* Digite o Nome&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="nome" type="text" id="nome" value="<?php echo $nome; ?>" class="obrigatorio" style="width:350px;" /></td>
    </tr>
    <tr>
      <td height="60" valign="middle" colspan="2" align="center"><input name="cadastrar" type="button" id="cadastrar" onclick="validaform(form.id);" value="<?php echo $bt; ?>" class="bt" /></td>
    </tr>
  </table>
</form>
            
<?php
if(!isset($_GET['acao'])){
	$sql = mysql_query("SELECT * FROM grupos ORDER BY nome ASC");
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
		echo "    <th>Nome do Grupo</th>";
		echo "    <th>Qtd E-mails</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "    <th>Nome do Grupo</th>";
		echo "    <th>Qtd E-mails</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";		
		$cont = 0;
		while($linha = mysql_fetch_array($sql)) {
			$cont = $cont + 1;
			$resultado = ($cont % 2) ? 'Ímpar' : 'Par';

			$qtd = mysql_num_rows(mysql_query("SELECT * FROM emails WHERE grupo='".$linha[0]."'"));

			echo "<tr>";
			echo "<td>&nbsp;&nbsp;$linha[1]</td>";
			echo "<td>".$qtd."</td>";
			echo "<td>";
			if($qtd!='0'){
				echo "<a href=\"javascript:erro('Existem e-mail's ligadas a este grupo')\">";
			} else {
				echo "<a onclick=\"javascript:confirmaDel('?pg=modulos/news/grupos&del=$linha[0]')\" style='cursor:pointer;'>";
			}
			if($linha["id"]!='1'){
				echo "<img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>&nbsp;&nbsp;";
			}
			echo "<a href='?pg=modulos/news/grupos&acao=att&i=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}	
	if(isset($_GET["del"])) {
		mysql_query("DELETE FROM grupos WHERE id='".$_GET['del']."'");
		header("Location: ?pg=modulos/news/grupos");
	}        
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>