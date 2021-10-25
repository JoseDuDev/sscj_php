<?php
if(!isset($_SESSION['nome_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!=1) {
		header("Location: ?pg=inicial");
	}
}
$vrf = mysql_query("SELECT * FROM sacerdotes ORDER BY id_o ASC");
$cont = 0;
while($linha = mysql_fetch_array($vrf)) {
  $cont = $cont + 1;
  mysql_query("UPDATE sacerdotes SET id_o = '".$cont."' WHERE id=".limpa($linha[0]));
} 
if(isset($_GET['ativa'])) {
  $status = mysql_query("SELECT status FROM sacerdotes WHERE id='".limpa($_GET["ativa"])."'");
  if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
  mysql_query("UPDATE sacerdotes SET status = '".$user."' WHERE id = ".limpa($_GET["ativa"]));
  header("Location: ?pg=modulos/conheca/sacerdotes#".$_GET["ativa"]);
}
if (isset($_GET['acao'])) {
  $dlxTools = new Dlx_Tools_SpecialChar();
  $acao = $_GET['acao'];
  if ($acao == "up") {
    $idordenar = $_GET["id"];   
    $ordenar = mysql_query("SELECT * FROM sacerdotes WHERE id='".limpa($idordenar)."'");
    while($ordem = mysql_fetch_array($ordenar)) {
      if ($ordem[5] != "1") {
        $ido = $ordem[5] - 1;
        $p2 = $ido + 1;           
        $proximo = mysql_query("SELECT * FROM sacerdotes WHERE id_o='$ido'");
        while($altera = mysql_fetch_array($proximo)) {
          $ido2 = $altera[5] + 1;
          $idup = $altera[5];         
          $redestaque = mysql_query("UPDATE sacerdotes SET
                           id_o = '".$ido2."'
                           WHERE id=".limpa($altera[0]));
        }       
        $rdestaque = mysql_query("UPDATE sacerdotes SET
                       id_o = '".$idup."'
                       WHERE id=".limpa($idordenar));
      }
      header ("Location: ?pg=modulos/conheca/sacerdotes#".$idordenar);
            exit;
    }
  }
  if ($acao == "down") {
    $idordenar = $_GET["id"];
    $ordenar = mysql_query("SELECT * FROM sacerdotes WHERE id='".limpa($idordenar)."'");
    $st = mysql_query("SELECT * FROM sacerdotes");
    $vttb = mysql_num_rows($st);
    while($ordem = mysql_fetch_array($ordenar)) {
      if ($ordem[5] != $vttb) {
        $ido = $ordem[5] + 1;
        $p2 = $ido - 1;             
        $proximo = mysql_query("SELECT * FROM sacerdotes WHERE id_o='".limpa($ido)."'");
        while($altera = mysql_fetch_array($proximo)) {
          $ido2 = $altera[5] - 1;
          $idup = $altera[5];         
          $redestaque = mysql_query("UPDATE sacerdotes SET
                           id_o = '".$ido2."'
                           WHERE id=".limpa($altera[0]));     
        }       
        $rdestaque = mysql_query("UPDATE sacerdotes SET
                         id_o = '".$idup."'
                         WHERE id=".limpa($idordenar));
      }
      header ("Location: ?pg=modulos/conheca/sacerdotes#".$idordenar);
            exit;
    }
  }
  
  if ($acao == "add") {
    if(isset($_FILES["icones"])){
      $icones = $_FILES["icones"];      
      $pasta_dir = "img/sacerdotes/";     
      if(!file_exists($pasta_dir)){
        mkdir($pasta_dir);
      }     
      preg_match("/\.(gif|png|jpg|jpeg){1}$/i", $icones["name"], $ext);     
      $icone = $pasta_dir.md5(uniqid(time())).".".$ext[1];      
      move_uploaded_file($icones["tmp_name"], $icone);
    }
    mysql_query("INSERT INTO sacerdotes (imagem, titulo, descricao, urlcheck) VALUES ('".$icone."', '".mysql_real_escape_string($_POST['titulo'])."', '".mysql_real_escape_string($_POST['descricao'])."', '".$dlxTools->remove_accents($_POST['titulo'])."')");
    header ("Location: ?pg=modulos/conheca/sacerdotes");
    exit;
  }
  if($acao=="att"){
    $envio = '?pg=modulos/conheca/sacerdotes&acao=edit&id='.$_GET['id'];
    $bt = 'Atualizar';
    $sb = mysql_query("SELECT * FROM sacerdotes WHERE id='".limpa($_GET['id'])."'");
    while($linha = mysql_fetch_array($sb)) {
      $icone      = '<img src="'.$linha['imagem'].'" width="103" alt="'.$linha['titulo'].'" title="'.$linha['titulo'].'" /><br />';
      $titulo     = $linha['titulo'];
      $descricao  = $linha['descricao'];
    }
  }
  if ($acao == "edit") {
    $idedit = $_GET["id"];   
    if($_FILES["icones"] != "") {
      $icones = $_FILES["icones"];
      $pasta_dir = "img/sacerdotes/";
      if(!file_exists($pasta_dir)){
        mkdir($pasta_dir);
      }
      $imgantiga = mysql_query("SELECT imagem FROM sacerdotes WHERE id='".limpa($idedit)."'");
      $imgbanco = mysql_result($imgantiga, 0, "imagem");
      preg_match("/\.(gif|png|jpg|jpeg){1}$/i", $icones["name"], $ext);
      $icone = $pasta_dir.md5(uniqid(time())).".".$ext[1];
      if(move_uploaded_file($icones['tmp_name'],$icone)){
        @unlink($imgbanco);
      }else{
        $icone = $imgbanco;
      }
    }
    mysql_query("UPDATE sacerdotes SET
              imagem     = '".$icone."',
              titulo     = '".mysql_real_escape_string($_POST['titulo'])."',
              descricao  = '".mysql_real_escape_string($_POST['descricao'])."',
              urlcheck   = '".$dlxTools->remove_accents($_POST['titulo'])."'
              WHERE id   =" .limpa($idedit));
    header ("Location: ?pg=modulos/conheca/sacerdotes");
        exit;
  }
} else {
  $envio      = '?pg=modulos/conheca/sacerdotes&acao=add';
  $bt         = 'Cadastrar';
  $icone      = '';
  $titulo     = '';
  $descricao  = '';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<form id="noticias" name="noticias" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Institucional / Sacerdotes</th>
    <th scope="col" width="10%" align="right"><a href="?pg=config/_meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>
    </td>
</tr>
    <tr>
      <td width="250" height="36" align="right" valign="middle">* Foto / Imagem &nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $icone; ?><input name="icones" <?php if(!isset($_GET['acao'])){ echo ' class="obrigatorio" '; } ?> type="file" id="icones" />&nbsp;&nbsp;Formato aceito, .jpg .png .gif</td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Nome&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="titulo" type="text" id="titulo" class="obrigatorio" value="<?php echo $titulo; ?>" style="width:650px;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">Descrição&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><textarea id="descricao" name="descricao" style="width: 90%; height:250px;"><?php echo $descricao; ?></textarea></td>
    </tr>
  <tr>
    <td colspan="2" height="90" valign="middle" align="center"><input type="button" onclick="validaform(form.id);" name="save" value="Atualizar" /></td>
  </tr>
</table>     
</form>

<?php
if(!isset($_GET['acao'])){
  $sql = mysql_query("SELECT * FROM sacerdotes ORDER BY id_o ASC");
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
    echo "    <th>Ordem</th>";
    echo "    <th class='filter-false'>Imagem</th>";
    echo "    <th>Nome</th>";
    echo "    <th class='filter-false'>Ações</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tfoot>";
    echo "<tr>";
    echo "    <th>Ordem</th>";
    echo "    <th class='filter-false'>Imagem</th>";
    echo "    <th>Nome</th>";
    echo "    <th class='filter-false'>Ações</th>";
    echo "</tr>";
    echo "</tfoot>";
    echo "<tbody>";   
    while($linha = mysql_fetch_array($sql)) {
      echo "<tr>";
      echo "<td width='120'>";
      if($linha['id_o']!=1){
        echo "<a href='?pg=modulos/conheca/sacerdotes&acao=up&id=$linha[0]'><img src='img/icones/up.png' width='16' height='16' alt='Subir Item' title='Subir Item' /></a>";
      } else {
        echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
      }
      echo "<span class='t15 corlaranja bold' style='padding:0px 15px;'>".$linha['id_o']."</span>";
      if($linha['id_o']!=mysql_num_rows($sql)){
        echo "<a href='?pg=modulos/conheca/sacerdotes&acao=down&id=$linha[0]'><img src='img/icones/down.png' width='16' height='16' alt='Descer Item' title='Descer Item' /></a>";
      } else {
        echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
      }
      echo "</td>";
      echo "<td width='130' align='center'>";
      echo "<img src='".$linha['imagem']."' width='100' alt='".$linha['titulo']."' title='".$linha['titulo']."' /></td>";
      echo "<td>";
      if ($linha['status'] == "N") {
        echo "<strike>";
      }
      echo $linha['titulo'];
      if ($linha['status'] == "N") {
        echo "</strike>";
      }
      echo "</td>";
      echo "<td width='160'>";
      echo "
      <a href='?pg=modulos/conheca/sacerdotes&ativa=$linha[0]' name='".$linha[0]."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar/Desativar' title='Ativar/Desativar' /></a>
      <a onclick=\"javascript:confirmaDel('?pg=modulos/conheca/sacerdotes&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
      <a href='?pg=modulos/conheca/sacerdotes&acao=att&id=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
      echo "</td>";
      echo "</tr>";
    }
    echo '</tbody>';
    echo "</table>";
  }
  if(isset($_GET["del"])){
    $imgantiga = mysql_query("SELECT imagem FROM sacerdotes WHERE id='".limpa($_GET['del'])."'");
    $return = unlink(mysql_result($imgantiga, 0, "imagem"));
    mysql_query("DELETE FROM sacerdotes WHERE id='".limpa($_GET['del'])."'");
    header ("Location: ?pg=modulos/conheca/sacerdotes");
  }
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>