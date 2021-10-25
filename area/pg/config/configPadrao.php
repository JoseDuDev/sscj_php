<?php
if(!isset($_SESSION['id_usuario'])) {
	header("Location: ?pg=inicial");
}
$cfg = mysql_query("SELECT * FROM gerais WHERE id='1'");
while($linha = mysql_fetch_object($cfg)) {
  $nome = $linha->nome;
  $url = $linha->url;
  $titulo = $linha->titulo;
  $des = $linha->des;
  $keyw = $linha->keyw;
	$email = $linha->email;
  $mascara = $linha->mascara;
  $telefone = $linha->telefone;
  $endereco = $linha->endereco;
  $src = $linha->src;
  $facebook = $linha->facebook;
  // $twitter = $linha->twitter;
  // $linkedin = $linha->linkedin;
  // $flickr = $linha->flickr;
  // $youtube = $linha->youtube;
}
if(isset($_GET['add'])) {
	$update = mysql_query("UPDATE gerais SET
              nome = '".$_POST['nome']."',
              url = '".$_POST['url']."',
              titulo = '".$_POST['titulo']."',
              des = '".$_POST['des']."',
              keyw = '".$_POST['keyw']."',
              email = '".$_POST['email']."',
              mascara = '".$_POST['mascara']."',
              telefone = '".$_POST['telefone']."',
              endereco = '".$_POST['endereco']."',
              src = '".$_POST['src']."',
              facebook = '".$_POST['facebook']."'
							WHERE id ='1'");
	header("Location: ?pg=config/configPadrao");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery.limit-1.2.source.js"></script>
</head>
<body>

<form id="gerais" name="gerais" method="post" action="?pg=config/configPadrao&add=sim">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Configurações Gerais</th>
    <th scope="col" width="10%" align="right"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr> 
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Nome do Site&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="nome" type="text" value="<?php echo $nome; ?>" style="width:550px;" /></td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Titulo do Site&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="titulo" type="text" value="<?php echo $titulo; ?>" style="width:550px;" /></td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Url do Site&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="url" type="text" value="<?php echo $url; ?>" style="width:550px;" />&nbsp;&nbsp;Sem http:// e sem a / no final</td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Mascara para E-mail's&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="mascara" type="text" value="<?php echo $mascara; ?>" style="width:550px;" /></td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Descriptions SEO&nbsp;&nbsp;</td>
      <td height="36" align="left"><textarea id="des" name="des" rows="10" cols="80" style="width:85%; height:50px;"><?php echo $des; ?></textarea><br />Você ainda tem <span id="resta1"></span> caracteres.</td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Keywords SEO&nbsp;&nbsp;</td>
      <td height="36" align="left"><textarea id="keyw" name="keyw" rows="10" cols="80" style="width:85%; height:50px;"><?php echo $keyw; ?></textarea><br />Você ainda tem <span id="resta2"></span> caracteres.</td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">E-mail de contato&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="email" type="text" value="<?php echo $email; ?>" style="width:350px;" /></td>
    </tr>
    <tr>  
      <td colspan="2" height="30" align="center">&nbsp;</td>
    </tr>
     <tr>
      <td width="25%" height="36" align="right" valign="middle">Telefone&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="telefone" id="telefone" type="text" value="<?php echo $telefone; ?>" style="width:350px;" /></td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Endereço&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="endereco" type="text" value="<?php echo $endereco; ?>" style="width:450px;"/></td>
    </tr>
    <tr>  
      <td width="25%" height="36" align="right" valign="middle">Endereço Google Maps SRC&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="src" type="text" value="<?php echo $src; ?>" style="width:450px;"/></td>
    </tr>
    <tr>  
      <td colspan="2" height="30" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">Facebook&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="facebook" type="text" value="<?php echo $facebook; ?>" style="width:450px;"/>&nbsp;Sem http://</td>
    </tr>
    <tr>
      <td height="80" valign="middle" colspan="2" align="center"><input name="cadastrar" type="button" onclick="validaform(form.id);" id="cadastrar" value="Atualizar Dados"></td>
    </tr>
    </table>
</form>
<script type="text/javascript">
	$('#des').limit('255','#resta1');
	$('#keyw').limit('255','#resta2');
</script>
</body>
</html>