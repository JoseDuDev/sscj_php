<?php
if(!isset($_SESSION['id_usuario'])) {
	header("Location: ?pg=inicial");
}
$cfg = mysql_query("SELECT * FROM gerais WHERE id='1'");
while($linha = mysql_fetch_object($cfg)) {
  $mensagem3   = $linha->msg3;
  $mensagem4   = $linha->msg4;
}
if(isset($_GET['add'])) {
	mysql_query("UPDATE gerais SET msg3 = '".mysql_real_escape_string($_POST['mensagem3'])."', msg4 = '".mysql_real_escape_string($_POST['mensagem4'])."' WHERE id ='1'");
	header("Location: ?pg=config/interatividade");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
  tinyMCE.init({
    language : "pt",
    mode : "textareas",
    theme : "advanced",
    plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
theme_advanced_buttons1:
"bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,link,unlink,table,formatselect,fontselect,fontsizeselect,forecolor,backcolor",
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

<form id="gerais" name="gerais" method="post" action="?pg=config/interatividade&add=sim">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Interatividade</th>
    <th scope="col" width="10%" align="right"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr> 
    <tr>  
      <td width="20%" height="176" align="right" valign="middle">Intenções / Mensagem&nbsp;&nbsp;</td>
      <td height="176" align="left"><textarea id="mensagem3" name="mensagem3" rows="10" cols="80" style="width:85%; height:160px;"><?php echo $mensagem3; ?></textarea></td>
    </tr>
    <tr>  
      <td width="20%" height="176" align="right" valign="middle">Pedidos / Mensagem&nbsp;&nbsp;</td>
      <td height="176" align="left"><textarea id="mensagem4" name="mensagem4" rows="10" cols="80" style="width:85%; height:160px;"><?php echo $mensagem4; ?></textarea></td>
    </tr>
    <tr>
      <td height="80" valign="middle" colspan="2" align="center"><input name="cadastrar" type="button" onclick="validaform(form.id);" id="cadastrar" value="Atualizar Dados"></td>
    </tr>
    </table>
</form>
</body>
</html>