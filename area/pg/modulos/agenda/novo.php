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
if (isset($_GET['acao'])) {
	$dlxTools = new Dlx_Tools_SpecialChar();
	$acao = $_GET['acao'];	
	if ($acao == "add") {			
		$data = implode("-",array_reverse(explode('/',$_POST['data_reg'])));
		mysql_query("INSERT INTO agenda (data_reg, local_reg, nome, descricao, urlcheck) VALUES ('$data', '".mysql_escape_string($_POST['local_reg'])."', '".mysql_escape_string($_POST['nome'])."', '".mysql_escape_string($_POST['descricao'])."', '".$dlxTools->remove_accents(mysql_escape_string($_POST['nome'].'-'.$data))."')");
		header ("Location: ?pg=modulos/agenda/novo");
		exit;
	}
	if($acao=="att"){
		$envio = '?pg=modulos/agenda/novo&acao=edit&id='.$_GET['id'];
		$bt = 'Atualizar';
		$dpg = 'Gerenciamento da Agenda';
		$sb = mysql_query("SELECT * FROM agenda WHERE id='".limpa($_GET['id'])."'");
		while($linha = mysql_fetch_array($sb)) {
			$data_reg  = implode("/",array_reverse(explode('-',$linha['data_reg'])));
			$local_reg = $linha['local_reg'];
			$nome     = $linha['nome'];
			$conteudo  = $linha['descricao'];
		}
	}
	if ($acao == "edit") {
		$idedit = $_GET["id"];
		$data = implode("-",array_reverse(explode('/',$_POST['data_reg'])));
		$update = mysql_query("UPDATE agenda SET
								data_reg  = '".$data."',
								local_reg = '".mysql_escape_string($_POST['local_reg'])."',
								nome      = '".mysql_escape_string($_POST['nome'])."',
								descricao = '".mysql_escape_string($_POST['descricao'])."',
								urlcheck  = '".$dlxTools->remove_accents(mysql_escape_string($_POST['nome'].'-'.$data))."'
								WHERE id  = " .limpa($idedit));
		header ("Location: ?pg=modulos/agenda/novo");
		exit;
	}
} else {
	$envio = '?pg=modulos/agenda/novo&acao=add';
	$bt = 'Cadastrar';
	$dpg = 'Gerenciamento da Agenda';
	$data_reg  = '';
	$local_reg = '';
	$nome = '';
	$conteudo = '';
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/jquery-ui-1.8.24.custom.css" />
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.widgets.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.24.custom.min.js"></script>
<script>
$(document).ready(function(){
    $('#data_reg').datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
    
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

tinyMCE.init({
    language : "pt",
        mode : "textareas",
        theme : "advanced",
        plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
theme_advanced_buttons1:
"bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,link,unlink,media,table,formatselect,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",
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

<form id="simulador" name="simulador" method="post" action="<?php echo $envio; ?>">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center"><?php echo $dpg; ?></th>
    <th scope="col" width="10%" align="right"><a href='?pg=config/_meuPainel'><img src='img/icones/voltar.png' width='32' height='32' alt='Painel de Controle' /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="20%" height="36" align="right" valign="middle">* Data&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="data_reg" type="text" id="data_reg" class="obrigatorio" value="<?php echo (!isset($_GET['acao'])) ?  date('d/m/Y') : $data_reg; ?>" style="width:100px; text-align:center;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Nome / Evento&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="nome" type="text" id="nome" class="obrigatorio" value="<?php echo $nome; ?>" style="width:450px;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Local / Informações&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="local_reg" type="text" id="local_reg" class="obrigatorio" value="<?php echo $local_reg; ?>" style="width:450px;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Descricao&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><textarea id="descricao" name="descricao" style="width: 90%; height:220px;"><?php echo $conteudo; ?></textarea></td>
    </tr>    
    <tr>
      <td colspan="2" height="60" valign="middle" align="center"><label><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></label></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
	$sql = mysql_query("SELECT * FROM agenda ORDER BY data_reg DESC, id DESC");
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
        echo "    <th>Data</th>";
		echo "    <th>Nome</th>";
		echo "    <th>Local</th>";
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "    <th>Data</th>";
        echo "    <th>Nome</th>";
        echo "    <th>Local</th>";
        echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";		
		while($linha = mysql_fetch_array($sql)) {
			echo "<tr>";
			echo "<td width='140'>";
			echo implode("/",array_reverse(explode('-',$linha['data_reg'])));
			echo "</td>";
            echo "<td>";
            echo $linha['nome'];
            echo "</td>";
			echo "<td>";
			echo $linha['local_reg'];
			echo "</td>";
			echo "<td width='140'>";
			echo "
			<a onclick=\"javascript:confirmaDel('?pg=modulos/agenda/novo&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
			<a href='?pg=modulos/agenda/novo&acao=att&id=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo '</tbody>';
		echo "</table>";
	}
	if(isset($_GET["del"])){
		$imgantiga = mysql_query("SELECT foto FROM agenda WHERE id='".limpa($_GET['del'])."'");
		unlink(mysql_result($imgantiga, 0, "foto"));
		mysql_query("DELETE FROM agenda WHERE id='".limpa($_GET['del'])."'");
		header ("Location: ?pg=modulos/agenda/novo");
        exit;
	}
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>