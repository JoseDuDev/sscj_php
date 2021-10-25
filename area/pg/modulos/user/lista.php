<?php
if(!isset($_SESSION['nivel_usuario'])){
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']==2){
		header("Location: ?pg=inicial");
	}
}
if(isset($_GET['ativa'])) {
	$id = $_GET["ativa"];
	$status = mysql_query("SELECT id, email, status FROM usuarios WHERE id='".$id."'");
	if(mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
	mysql_query("UPDATE usuarios SET status = '".$user."' WHERE id = ".$id);
	header("Location: ?pg=modulos/user/lista#".mysql_result($status, 0, "id"));
}	
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
	span#loading {display: none;}
</style>

	<link rel="stylesheet" href="css/layout.css">
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

<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="60" valign="bottom" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" height="40" width="10%">&nbsp;</th>
    <th scope="col" width="80%" align="center" class="t20">Listagem de Usuários</th>
    <th scope="col" width="10%" align="right" valign="middle"><a href="?pg=modulos/user/direciona"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr>
</table>
<?php
if(!isset($_GET['acao'])){
	echo '<button class="reset bt">LIMPAR FILTROS</button>';
	$sql = mysql_query("SELECT * FROM usuarios ORDER BY nome ASC");
	echo "<table class='tablesorter' border='0' cellspacing='0' cellpadding='0' style='margin:10px;'>";
	echo "<thead>";
	echo "<tr>";
	echo "    <th>Desde</th>";
	echo "    <th>Nome / Responsável</th>";
	echo "    <th>E-mail</th>";
	echo "    <th class='filter-false'>Ações</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tfoot>";
	echo "<tr>";
	echo "    <th>Desde</th>";
	echo "    <th>Nome / Responsável</th>";
	echo "    <th>E-mail</th>";
	echo "    <th>Ações</th>";
	echo "</tr>";
	echo "</tfoot>";
	echo "<tbody>";
	while($rw = mysql_fetch_object($sql)) {
		$ndata = explode("-",$rw->data);
		$novadata = $ndata[2]."/".$ndata[1]."/".$ndata[0]."<br />".$rw->hora;

		$nivel = $rw->nivel;
		if(!file_exists($rw->logomarca)){
			$iemg = 'img/logomarca-padrao-hatus.jpg';
		} else {
			$iemg = $rw->logomarca;
		}
	
		echo "<tr>";
		echo "<td>";
		if ($rw->status == "N") {
			echo "<strike>";
		}
		echo $novadata;
		if ($rw->status == "N") {
			echo "</strike>";
		}
		echo "</td>";
		echo "<td>";
		if ($rw->status == "N") {
			echo "<strike>";
		}
		echo $rw->nome;
		if ($rw->status == "N") {
			echo "</strike>";
		}
		echo "</td>";
		echo "<td>";
		if ($rw->status == "N") {
			echo "<strike>";
		}
		echo $rw->email;
		if ($rw->status == "N") {
			echo "<strike>";
		}
		echo "</td>";	
		echo "<td>";
		echo "
		<a href='?pg=modulos/user/lista&ativa=".$rw->id."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar / Desativar' title='Ativar / Desativar' /></a>
		<a onclick=\"javascript:confirmaDel('?pg=modulos/user/lista&del=".$rw->id."')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
		<a href='?pg=modulos/user/user&acao=edit&id=".$rw->id."&r=sim'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
	if(isset($_GET["del"])) {
		mysql_query("DELETE FROM usuarios WHERE id=".$_GET['del']);
		header ("Location: ?pg=modulos/user/lista");
	}
}
?>

<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>

</body>
</html>