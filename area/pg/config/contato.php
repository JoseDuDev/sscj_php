<?php
if(!isset($_SESSION['id_usuario'])) {
	header("Location: ?pg=inicial");
}
$cfg = mysql_query("SELECT * FROM gerais WHERE id='1'");
while($linha = mysql_fetch_object($cfg)) {
  $atende      = $linha->atende;
  $mensagem    = $linha->msg;
  $mensagem1   = $linha->msg1;
  $mensagem2   = $linha->msg2;
}
if(isset($_GET['add'])) {
	mysql_query("UPDATE gerais SET atende = '".mysql_real_escape_string($_POST['atendimento'])."', msg = '".mysql_real_escape_string($_POST['mensagem'])."', msg1 = '".mysql_real_escape_string($_POST['mensagem1'])."', msg2 = '".mysql_real_escape_string($_POST['mensagem2'])."' WHERE id ='1'");
	header("Location: ?pg=config/contato");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<form id="gerais" name="gerais" method="post" action="?pg=config/contato&add=sim">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Contato</th>
    <th scope="col" width="10%" align="right"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr> 
    <tr>  
      <td width="20%" height="126" align="right" valign="middle">Localização / Instruções&nbsp;&nbsp;</td>
      <td height="126" align="left"><textarea id="atendimento" name="atendimento" rows="10" cols="80" style="width:85%; height:110px;"><?php echo $atende; ?></textarea></td>
    </tr>
    <tr>  
      <td width="20%" height="126" align="right" valign="middle">Fale Conosco / Mensagem&nbsp;&nbsp;</td>
      <td height="126" align="left"><textarea id="mensagem" name="mensagem" rows="10" cols="80" style="width:85%; height:110px;"><?php echo $mensagem; ?></textarea></td>
    </tr>
    <tr>  
      <td width="20%" height="126" align="right" valign="middle">Horários / Atendimento Confissão&nbsp;&nbsp;</td>
      <td height="126" align="left"><textarea id="mensagem1" name="mensagem1" rows="10" cols="80" style="width:85%; height:110px;"><?php echo $mensagem1; ?></textarea></td>
    </tr>
    <tr>  
      <td width="20%" height="126" align="right" valign="middle">Horários / Atendimento Secretaria&nbsp;&nbsp;</td>
      <td height="126" align="left"><textarea id="mensagem2" name="mensagem2" rows="10" cols="80" style="width:85%; height:110px;"><?php echo $mensagem2; ?></textarea></td>
    </tr>
    <tr>
      <td height="80" valign="middle" colspan="2" align="center"><input name="cadastrar" type="button" onclick="validaform(form.id);" id="cadastrar" value="Atualizar Dados"></td>
    </tr>
    </table>
</form>
</body>
</html>