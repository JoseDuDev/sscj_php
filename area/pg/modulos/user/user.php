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
	$att = mysql_query("UPDATE usuarios SET status = '".$user."' WHERE id = ".$id);
	if(!isset($_GET['r'])){
		header("Location: ?pg=modulos/user/user#".mysql_result($status, 0, "id"));
	} else {
		header("Location: ?pg=modulos/user/lista#".mysql_result($status, 0, "id"));
	}
}	
if (!isset($_GET['acao'])) {
		$descricaopg = "Cadastro de Usuário";
		$envio = "?pg=modulos/user/user&acao=add";
		$bta = "Cadastrar";
		$nomeuser = "";
		$senhauser = "";
		$emailuser = "";
	} else {
		$acao = $_GET['acao'];
        
		if ($acao == "add") {	
			$verif = mysql_query("SELECT * FROM emails WHERE email='".$_POST['email']."'");
			if(mysql_num_rows($verif)==0){												
				$insertemail = mysql_query("INSERT INTO emails (email, nome, data) VALUES ('".$_POST['email']."', '".$_POST['nomeuser']."', '".date("d/m/Y - H:i:s")."')");
			}			
			
            $niveluser = $_POST['nivel'];
            
			$ic = mysql_query("INSERT INTO usuarios (data, hora, nome, email, senha, nivel) VALUES ('".date("Y-m-d")."', '".date("H:i:s")."', '".$_POST['nomeuser']."', '".$_POST['email']."', '".md5($_POST['senhauser'])."', '1')") or die("Erro no banco de dados!");
			header("Location: ?pg=modulos/user/user");
		}
        
		if ($acao == "edit") {			
			$eu = mysql_query("SELECT * FROM usuarios WHERE id='".$_GET['id']."'") or die("Erro no banco de dados!");	
			$descricaopg = "Edição de dados";
			$bta = "Atualizar";
			$envio = "?pg=modulos/user/user&acao=att&id=".$_GET['id'];
			if(isset($_GET['r'])){
				$envio .= '&r=';
			}
			while($user = mysql_fetch_object($eu)) {
				$nomeuser = $user->nome;
				$emailuser = $user->email;
				$empresa = $user->empresa;
			}
		}		
		if ($acao == "att") {
			if(!empty($_POST['senhauser'])){
				$update = mysql_query("UPDATE usuarios SET senha = '".md5($_POST['senhauser'])."' WHERE id =".$_GET['id']);
			}
			$update = mysql_query("UPDATE usuarios SET
								   nome = '".$_POST['nomeuser']."',
								   email = '".$_POST['email']."'
								   WHERE id =".$_GET['id']);

			if($_GET['id']==$_SESSION['id_usuario']){
				$att = mysql_query("SELECT * FROM usuarios WHERE id =".$_SESSION['id_usuario']);
				$dados = mysql_fetch_array($att);
				$_SESSION["id_usuario"]   			= $dados["id"];
				$_SESSION["nome_usuario"]    		= $dados["nome"];
				$_SESSION["email_usuario"]    		= $dados["email"];
				$_SESSION["nivel_usuario"]   		= $dados["nivel"];
				$_SESSION["uacesso_usuario"] 		= stripslashes($dados["uacesso"]);
			}

			if(!isset($_GET['r'])){
				header("Location: ?pg=modulos/user/user#".$_GET['id']);
			} else {
				header("Location: ?pg=modulos/user/lista#".$_GET['id']);
			}
		}	
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
	span#loading {display: none;}
</style>
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script>
function uniqval(len) {
	var i, chars='3WzE6hTYbUqI42O8PaASJwLZ5XCVyGBNMeHrtRuopKsdfgjklx7cvFnm10iD9', str='';
	if (!len)
		len = 15;
	for(i=0; i < len; i++)
		str += chars.substr((Math.floor(Math.random() * (chars.length + 1))), 1);
	return str;
}
function mudaPadrao(){
   document.user.senhauser.defaultValue = uniqval(6);
}
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

<form id="user" name="user" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" align="center" class="t20"><?php echo $descricaopg; ?></th>
    <th scope="col" width="10%" align="right"><a href="?pg=modulos/user/direciona"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr> 
</table>
  <table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td colspan="2" height="40" align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td width="35%" height="36" valign="middle" align="right">* Nome&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="nomeuser" id="nomeuser" type="text" value="<?php echo $nomeuser; ?>" class="obrigatorio" style="width:550px;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Escolha uma senha&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="senhauser" id="senhauser" type="text" <?php if(!isset($_GET['acao'])) { echo ' class="obrigatorio" '; } ?> style="width:350px;" />&nbsp;<img id="lancador" onClick="mudaPadrao()" src="img/icones/gerar.png" height="20" width="20" alt="Gerar Senha" title="Gerar Senha" style="cursor:pointer;" />
      </td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* E-mail válido&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza1"><input name="email" id="email" type="text" value="<?php echo $emailuser; ?>" class="obrigatorio" style="width:350px;" /></td>
    </tr>
    <tr>
      <td colspan="2" height="40" align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td height="60" valign="middle" colspan="2" align="center"><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" style="cursor:pointer" value="<?php echo $bta; ?>" /></td>
    </tr>
  </table>
</form>
<?php
if(!isset($_GET['acao'])){
	echo '<button class="reset bt">LIMPAR FILTROS</button>';
	$sql = mysql_query("SELECT * FROM usuarios ORDER BY id DESC LIMIT 20");
	echo "<table class='tablesorter' border='0' cellspacing='0' cellpadding='0' style='margin:10px;'>";
	echo "<thead>";
	echo "<tr>";
	echo "    <th>Desde</th>";
	echo "    <th>Nome</th>";
	echo "    <th>E-mail</th>";
	echo "    <th class='filter-false'>Ações</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tfoot>";
	echo "<tr>";
	echo "    <th>Desde</th>";
	echo "    <th>Nome</th>";
	echo "    <th>E-mail</th>";
	echo "    <th>Ações</th>";
	echo "</tr>";
	echo "</tfoot>";
	echo "<tbody>";
	while($rw = mysql_fetch_object($sql)) {
		$ndata = explode("-",$rw->data);
		$novadata = $ndata[2]."/".$ndata[1]."/".$ndata[0]."<br />".$rw->hora;
	
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
		echo "<td>
		<a href='?pg=modulos/user/user&ativa=".$rw->id."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar / Desativar' title='Ativar / Desativar' /></a>
		<a onclick=\"javascript:confirmaDel('?pg=modulos/user/user&del=".$rw->id."')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
		<a href='?pg=modulos/user/user&acao=edit&id=".$rw->id."'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";

	if(isset($_GET["del"])) {
		$sl = mysql_query("SELECT logomarca FROM usuarios WHERE id='".$_GET['del']."'");
		if(mysql_result($sl, 0, "logomarca") != "img/logomarca-padrao-hatus.jpg") {
			$return = @unlink(mysql_result($sl, 0, "logomarca"));
		}
		$query = mysql_query("DELETE FROM usuarios WHERE id=".$_GET['del']);
		header ("Location: ?pg=modulos/user/user");
	}
}
?>

<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>

</body>
</html>