<?php
if(!isset($_SESSION['id_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']==2){
		header("Location: ?pg=inicial");
	}
}
if(isset($_GET['ativa'])) {
	$status = mysql_query("SELECT status FROM popup WHERE id='1'");
	if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
	mysql_query("UPDATE popup SET status = '".$user."' WHERE id=1");
	header ("Location: ?pg=modulos/popup/novo");
}		
if (isset($_GET['edit'])) {
	if($_FILES["arquivo"] != "") {
		$arquivo = $_FILES["arquivo"];
		$pasta_dir = "img/popup/";				
		if(!file_exists($pasta_dir)){
			mkdir($pasta_dir);
		}
		$imgantiga = mysql_query("SELECT img FROM popup WHERE id='1'");
		$imgbanco = mysql_result($imgantiga, 0, "img");				   
		preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);			   
		$imagem = $pasta_dir.time().".".$ext[1];									   
		if(move_uploaded_file($arquivo['tmp_name'],$imagem)){		
			$return = @unlink($imgbanco);
			$update = mysql_query("UPDATE popup SET img = '".$imagem."', target = '".$_POST['target']."' WHERE id =1");			
		}else{
			$imagem = $imgbanco;
			$update = mysql_query("UPDATE popup SET img = '".$imagem."', link = '".$_POST['link']."', target = '".$_POST['target']."' WHERE id =1");
		}
		header ("Location: ?pg=modulos/popup/novo");
	}
}
$sb = mysql_query("SELECT * FROM popup WHERE id='1'");
while($linha = mysql_fetch_array($sb)) {
	$img = '<img src="'.$linha[1].'" width="250" alt="Popup" /><br />';
	$status = $linha[2];
	$link = $linha[3];
	$target = $linha[4];
}
?>
<form id="popup" name="popup" method="post" action="?pg=modulos/popup/novo&edit" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Gerenciamento de Popup</th>
    <th scope="col" width="10%" align="right"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Painel de Controle" /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="35%" height="36" align="right" valign="middle">Imagem&nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $img; ?><input name="arquivo" type="file" id="arquivo" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">Link&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="link" id="link" type="text" value="<?php echo $link; ?>" style="width:300px;" />&nbsp;Sem http://</td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">Abrir em&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2">
      	<select name="target" id="target" style="width:314px; text-align:center; height:30px; ">
      		<?php
      		if($target=='_blank'){
	      		echo '<option value="_blank">Nova Janela</option>
	      		<option value="_self">Mesma Janela</option>';
      		} else if($target=='_self'){
	      		echo '<option value="_self">Mesma Janela</option>
	      		<option value="_blank">Nova Janela</option>';
      		} else {
	      		echo '<option value="_blank">Nova Janela</option>
	      		<option value="_self">Mesma Janela</option>';
      		}
      		?>
    	</select>
  		</td>
    </tr>
    <tr>
      <td colspan="2" valign="middle" align="center"><input name="cadastrar" type="button" onclick="validaform(form.id);" id="cadastrar" value="Atualizar" /></td>
    </tr>
    <tr>
      <td colspan="2" height="80" valign="top" align="center"><a href="?pg=modulos/popup/novo&ativa">
      <?php
	  if($status=='S'){
      	echo '<img src="img/icones/desativa.png" width="48" height="48" alt="Desativar" title="Desativar" />';
      } else {
      	echo '<img src="img/icones/ativa.png" width="48" height="48" alt="Ativar" title="Ativar" />';
	  }
      ?>
      </a></td>
    </tr>
  </table>
</form>