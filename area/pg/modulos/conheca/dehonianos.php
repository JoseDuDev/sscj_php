<?php
if(!isset($_SESSION['nome_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!=1) {
		header("Location: ?pg=inicial");
	}
}
if (isset($_GET['edit'])) {
	mysql_query("UPDATE empresa SET texto = '".mysql_real_escape_string($_POST['desc'])."' WHERE id ='2'");
	header("Location: ?pg=modulos/conheca/dehonianos");
} else {
	$envio = "?pg=modulos/conheca/dehonianos&edit";		
	$ed = mysql_query("SELECT * FROM empresa WHERE id='2'");
	$rw = mysql_fetch_object($ed);
	$conteudo = $rw->texto;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form id="noticias" name="noticias" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Institucional / Dehonianos</th>
    <th scope="col" width="10%" align="right"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>
    </td>
</tr>
  <tr>
    <td width="200" height="310" align="right" valign="middle">Dehonianos&nbsp;&nbsp;</td>
    <td height="310" align="left"><textarea id="desc" name="desc" style="width: 90%; height:500px;"><?php echo $conteudo; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" height="90" valign="middle" align="center"><input type="button" onclick="validaform(form.id);" name="save" value="Atualizar" /></td>
  </tr>
</table>     
</form>

</body>
</html>