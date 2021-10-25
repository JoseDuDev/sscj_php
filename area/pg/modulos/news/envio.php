<?php
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ?pg=inicial");
} else {
    if($_SESSION['nivel_usuario']!='1'){
        header("Location: ?pg=inicial");
    }
}
$valida = isset($_POST["valida"]) ? $_POST["valida"] : null;
if($valida == "enviar"){
  $emails = '';
	if($_POST['tipo_email']=='L'){
		$emails = utf8_decode(@$_POST["emails"]);
	} else if($_POST['tipo_email']=='G'){
    if($_POST['grupo']=='0'){
      $vemail = mysql_query("SELECT * FROM emails");
      while($ln = mysql_fetch_object($vemail)){
        $emails .= $ln->email.'; ';
      }
    } else {
      $vemail = mysql_query("SELECT * FROM emails WHERE grupo='".$_POST['grupo']."'");
      while($ln = mysql_fetch_object($vemail)){
        $emails .= $ln->email.'; ';
      }
    }
	}

	$assunto = utf8_decode(@$_POST["assunto"]);
	$mensagem = nl2br(utf8_decode(@$_POST["mensagem"]));

	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "From: ".$GLOBALS['config']['mascara']." <".$GLOBALS['config']['email'].">\r\n"; 
	$headers .= "Return-Path: ".$GLOBALS['config']['mascara']." <".$GLOBALS['config']['email'].">\r\n";
	$headers .= "Content-Type: Text/HTML\r\n";

	$ac = explode(";",$emails);
	$qa = count($ac);
	for ($i = 0; $i < $qa; $i++) {
		if($i<200){
			$envio = mail(trim($ac[$i]), $assunto, $mensagem, $headers);
		}
	}
	echo "<script>javascript:ok('Mensagem enviada com sucesso','?pg=modulos/news/envio')</script>";
}
if(isset($_GET['acao'])){
	if($_GET['acao']=='add'){
	$ie = mysql_query("INSERT INTO emails (email, nome, data, grupo, nomegrupo) VALUES ('".$_POST['email']."', '".$_POST['nome']."', '".date("d/m/Y - h:i:s")."', '".$_POST['grupo']."', '".mysql_result(mysql_query("SELECT nome FROM grupos WHERE id='".$_POST['grupo']."'"),0,"nome")."')");
	header ("Location: ?pg=modulos/news/envio#EMAIL");
	} else if($_GET['acao'] =='att'){
		$envio = '?pg=modulos/news/envio&acao=edit&id='.$_GET['id'];
		$dpg = 'Edição de E-mails';
		$bt = 'ATUALIZAR';
		$apresenta = 'G';
		$vd = mysql_query("SELECT * FROM emails WHERE id='".$_GET['id']."'");
		$dados = mysql_fetch_object($vd);
		$nome = $dados->nome;
		$email = $dados->email;
		$grupo = $dados->grupo;
    $nomegrupo = $dados->nomegrupo;
	} else if($_GET['acao'] =='edit'){
		mysql_query("UPDATE emails SET email='".$_POST['email']."', nome='".$_POST['nome']."', grupo='".$_POST['grupo']."', nomegrupo='".mysql_result(mysql_query("SELECT nome FROM grupos WHERE id='".$_POST['grupo']."'"),0,"nome")."' WHERE id='".$_GET['id']."'");
		header("Location: ?pg=modulos/news/envio#EMAIL");
	}
} else {
	$envio = '?pg=modulos/news/envio&acao=add';
	$dpg = 'Novo E-mail';
	$nome = '';
	$email = '';
	$bt = 'CADASTRAR';
	$grupo = '0';
	$apresenta = 'G';
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style> #lista {display:none; position:relative; width:100%; padding: 20px 0px; background-color:#f1f1f1; border-bottom:#ffffff 4px dashed; border-top:#ffffff 4px dashed; } .tr_email { display: none; } </style>
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script>
$(document).ready(function(){
  $('input[name=tipo_email]').click(function(){
      if($(this).val() == 'G') {
          $('.tr_grupo').fadeIn(200);
          $('.tr_email').fadeOut(200);
          $('#email').removeClass('obrigatorio');
          $('#grupo').addClass('obrigatorio');
      } else {
          $('.tr_email').fadeIn(200);
          $('.tr_grupo').fadeOut(200);
          $('#grupo').removeClass('obrigatorio');
          $('#email').addClass('obrigatorio');
      }
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
function vemail() {
  $("#lista").slideToggle();
}
</script>
</head>
<body>
<form name="news" id="news" method="post">
<table width="1200" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" valign="middle" align="center">Sistema de Newsletter, <font color="red">limite de 200 e-mails por hora</font><br /><br /></th>
    <th scope="col" width="10%" align="right" valign="middle"><a href="?pg=modulos/news/direciona"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="200" height="36" align="right" valign="middle"> Tipo de Envio&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2" valign="middle">
          <input type="radio" name="tipo_email" value="G"<?php if($apresenta=='G'){ echo 'checked="true"'; } ?> /> <strong>Grupo de E-mail</strong>&nbsp;&nbsp;
          <input type="radio" name="tipo_email" value="L" <?php if($apresenta=='L'){ echo 'checked="true"'; } ?> /> <strong>Lista de E-mail</strong>&nbsp;&nbsp;
      </td>
    </tr>
    <tr class="tr_grupo">
      <td width="30%" height="36" align="right" valign="middle">Grupo de E-mail&nbsp;&nbsp;</td>
      <td height="36" align="left">
      	<select name="grupo" id="grupo" class="obrigatorio" style="width:400px; height:30px; padding: 5px;" >
      		<?php
      		$vg = mysql_query("SELECT * FROM grupos ORDER BY nome ASC");
          echo '<option value="0">Todos os e-mails ('.mysql_num_rows(mysql_query("SELECT * FROM emails")).')</option>';
      		while($dados = mysql_fetch_object($vg)){
            if(mysql_num_rows(mysql_query("SELECT * FROM emails WHERE grupo='".$dados->id."'"))>0){
      			   echo '<option value="'.$dados->id.'">'.$dados->nome.' ('.mysql_num_rows(mysql_query("SELECT * FROM emails WHERE grupo='".$dados->id."'")).')</option>';
            }
      		}
      		?>
      	</select>
      </td>
    </tr>
    <tr class="tr_email">
      <td width="30%" height="36" align="right" valign="middle">Lista de E-mail&nbsp;&nbsp;</td>
      <td height="36" align="left">
      	<input type="text" name="emails" id="emails" style="width:670px; height:20px;" >
      </td>
    </tr>
<tr>
  <td width="30%" height="36" align="right" valign="middle">Assunto do E-mail&nbsp;&nbsp;</td>
  <td height="36" align="left"><input type="text" name="assunto" id="assunto" size="24" class="obrigatorio" style="width:670px;" /></td>
</tr>
<tr>
  <td width="30%" height="340" align="right" valign="middle">Mensagem / Código&nbsp;&nbsp;</td>
  <td height="340" align="left"><textarea name="mensagem" id="mensagem" cols="61" rows="6" wrap="virtual" class="obrigatorio" style="width:670px; height:330px;"></textarea></td>
</tr>
<tr>
  <td height="70" valign="middle" align="center" colspan="2"><input type="hidden" name="valida" value="enviar" /><input name="btenviar" type="button" onclick="validaform(form.id);" value="ENVIAR" /></td>
</tr>
</table>
</form>

<form id="novoemail" name="novoemail" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table id="EMAIL" width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="70" valign="middle" align="center">
    
<table width="1200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center"><strong><?php echo $dpg; ?></strong></th>
    <th scope="col" width="10%">&nbsp;</th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="38%" height="34" align="right" valign="middle">Grupo&nbsp;&nbsp;</td>
      <td height="34" align="left">
      	<select name="grupo" id="grupo" style="width:414px; height:32px; padding: 5px;" >
      		<?php
      		if($grupo!='0'){
      			$vg = mysql_query("SELECT * FROM grupos WHERE id!='".$grupo."' ORDER BY nome ASC");
      			echo '<option value="'.$grupo.'">'.$nomegrupo.'</option>';
      		} else {
      			$vg = mysql_query("SELECT * FROM grupos ORDER BY nome ASC");
      		}
      		while($dados = mysql_fetch_object($vg)){
      			echo '<option value="'.$dados->id.'">'.$dados->nome.' ('.mysql_num_rows(mysql_query("SELECT * FROM emails WHERE grupo='".$dados->id."'")).')</option>';
      		}
      		?>
      	</select>
      </td>
    </tr>
    <tr>
      <td width="38%" height="36" align="right" valign="middle">* Nome&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="nome" type="text" id="nome" value="<?php echo $nome; ?>" class="obrigatorio" style="width:400px; height:22px;" /></td>
    </tr>
    <tr>
      <td width="38%" height="36" align="right" valign="middle">* E-mail&nbsp;&nbsp;</td>
      <td height="36" align="left"><input name="email" type="text" id="email" value="<?php echo $email; ?>" class="obrigatorio" style="width:400px; height:22px;" /></td>
    </tr>
    <tr>
      <td colspan="2" height="50" valign="middle" align="center"><label><input name="cadastrar" type="button" id="cadastrar" value="<?php echo $bt; ?>" onclick="validaform(form.id);" /></label></td>
    </tr>
</table>
</form>

<div id="lista">
<?php
$que = mysql_query("SELECT DISTINCT email FROM emails ORDER BY email ASC");
$c=0;
while($linha = mysql_fetch_array($que)) {
	$c=$c+1;
	echo $linha[0];
	if(mysql_num_rows($que)!=$c){
		echo '; ';
	}
}
?>
</div>

<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td align="center" valign="top" height="50"></td></tr>
  <tr>
    <td align="center">

<?php
echo "<table width='100%' border='0' cellspacing='1' cellpadding='0'>";
echo "<tr>";
echo '<td height="45" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="35" align="left"><a onclick="vemail();" style="cursor:pointer;"><img src="img/icones/baixar.png" width="24" height="24" alt="Visualizar lista de e-mails" title="Visualizar lista de e-mails" /></a></th>
    <th scope="col" width="905" class="t20" align="center"><strong>Lista de e-mails</strong></th>
    <th scope="col" width="35" align="right"><a href="?pg=modulos/news/direciona"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td></tr>';
echo "</table>\n";

$sql = mysql_query("SELECT * FROM emails ORDER BY grupo ASC, email ASC");
if(mysql_num_rows($sql) == 0) {
  echo "<table width='100%' border='0' cellspacing='1' cellpadding='0'>";
  echo "<tr>";
  echo "    <td height='150' align='center'>Aguardando cadastramento...</td>";
  echo "</tr>";
  echo "</table>\n";
} else {
  echo '<button class="reset bt">LIMPAR FILTROS</button>';
  echo "<table class='tablesorter' border='0' cellspacing='0' cellpadding='0' style='margin:10px;'>";
  echo "<thead>";
  echo "<tr>";
  echo "    <th>Grupo</th>";
  echo "    <th>Nome</th>";
  echo "    <th>E-mail</th>";
  echo "    <th>Data/Hora</th>";
  echo "    <th class='filter-false'>Ações</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tfoot>";
  echo "<tr>";
  echo "    <th>Grupo</th>";
  echo "    <th>Nome</th>";
  echo "    <th>E-mail</th>";
  echo "    <th>Data/Hora</th>";
  echo "    <th class='filter-false'>Ações</th>";
  echo "</tr>";
  echo "</tfoot>";
  echo "<tbody>"; 
  while($linha = mysql_fetch_array($sql)) {
  	echo "<tr>";
  	echo "<td height='25'><strong>".$linha['nomegrupo']."</strong></td>";
  	echo "<td>$linha[2]</td>";
  	echo "<td>$linha[1]</td>";
  	echo "<td>$linha[3]</td>";
  	echo "<td>";
  	echo "<a onclick=\"javascript:confirmaDel('?pg=modulos/news/envio&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>&nbsp;";
  	echo "<a href='?pg=modulos/news/envio&acao=att&id=$linha[0]#EMAIL'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
  	echo "</td>";
  	echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
  if(isset($_GET["del"])) {
  	$check = $_GET['del'];		
  	$query = mysql_query("DELETE FROM emails WHERE id=".limpa($check));
  	header("Location: ?pg=modulos/news/envio#EMAIL");
  }
}
?>
</td>
  </tr>
    <tr><td width="875" align="center" valign="top" height="55"></td></tr>
</table>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>