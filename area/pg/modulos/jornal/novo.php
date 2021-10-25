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

$vrf = mysql_query("SELECT * FROM jornal ORDER BY id_o ASC");
$cont = 0;
while($linha = mysql_fetch_array($vrf)) {
    $cont = $cont + 1;
    mysql_query("UPDATE jornal SET id_o = '".$cont."' WHERE id=".limpa($linha[0]));
}

if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    
    
    if ($acao == "up") {
        $idordenar = $_GET["id"];       
        $ordenar = mysql_query("SELECT * FROM jornal WHERE id='".limpa($idordenar)."'");
        while($ordem = mysql_fetch_array($ordenar)) {
            if ($ordem['id_o'] != "1") {
                $ido = $ordem['id_o'] - 1;
                $p2 = $ido + 1;                     
                $proximo = mysql_query("SELECT * FROM jornal WHERE id_o='$ido'");
                while($altera = mysql_fetch_array($proximo)) {
                    $ido2 = $altera['id_o'] + 1;
                    $idup = $altera['id_o'];                 
                    $redestaque = mysql_query("UPDATE jornal SET
                                                     id_o = '".$ido2."'
                                                     WHERE id=".limpa($altera[0]));
                }               
                $rdestaque = mysql_query("UPDATE jornal SET
                                             id_o = '".$idup."'
                                             WHERE id=".limpa($idordenar));
            }
            header ("Location: ?pg=modulos/jornal/novo#".$idordenar);
            exit;
        }
    }
    if ($acao == "down") {
        $idordenar = $_GET["id"];
        $ordenar = mysql_query("SELECT * FROM jornal WHERE id='".limpa($idordenar)."'");
        $st = mysql_query("SELECT * FROM jornal");
        $vttb = mysql_num_rows($st);
        while($ordem = mysql_fetch_array($ordenar)) {
            if ($ordem['id_o'] != $vttb) {
                $ido = $ordem['id_o'] + 1;
                $p2 = $ido - 1;                         
                $proximo = mysql_query("SELECT * FROM jornal WHERE id_o='".limpa($ido)."'");
                while($altera = mysql_fetch_array($proximo)) {
                    $ido2 = $altera['id_o'] - 1;
                    $idup = $altera['id_o'];                 
                    $redestaque = mysql_query("UPDATE jornal SET
                                                     id_o = '".$ido2."'
                                                     WHERE id=".limpa($altera[0]));         
                }               
                $rdestaque = mysql_query("UPDATE jornal SET
                                                 id_o = '".$idup."'
                                                 WHERE id=".limpa($idordenar));
            }
            header ("Location: ?pg=modulos/jornal/novo#".$idordenar);
            exit;
        }
    }
    
    if ($acao == "add") {           
        $titulo = mysql_real_escape_string($_POST['titulo']);

        $classe = new Dlx_Tools_SpecialChar();
        $novaurl = $classe->remove_accents($_POST['titulo']);

        if(isset($_FILES["arquivo"])){
            $arquivo = $_FILES["arquivo"];          
            $pasta_dir = "img/jornal/";            
            if(!file_exists($pasta_dir)){
                mkdir($pasta_dir);
            }           
            preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);          
            $imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];           
            move_uploaded_file($arquivo["tmp_name"], $imagem);  
        }
                    
        mysql_query("INSERT INTO jornal (titulo, urlcheck, capa, isuu) VALUES ('$titulo', '".$novaurl."', '".$imagem."', '".$_POST['isuu']."')");
        header ("Location: ?pg=modulos/jornal/novo");
        exit;
    }
    if($acao=="att"){
        $envio = '?pg=modulos/jornal/novo&acao=edit&id='.$_GET['id'];
        $bt    = 'Atualizar';
        $dpg   = 'Gerenciamento de Guias';
        $sb    = mysql_query("SELECT * FROM jornal WHERE id='".limpa($_GET['id'])."'");
        while($linha = mysql_fetch_array($sb)) {
            $titulo  = $linha['titulo'];
            $capa    = '<img src="'.$linha['capa'].'" width="200" alt="Jornal" /><br />';
            $isuu    = $linha['isuu'];
        }
    }
    if ($acao == "edit") {
        $idedit = $_GET["id"];
        $titulo = mysql_real_escape_string($_POST['titulo']);

        $classe = new Dlx_Tools_SpecialChar();
        $novaurl = $classe->remove_accents($_POST['titulo']);

        if($_FILES["arquivo"] != "") {
            $arquivo = $_FILES["arquivo"];
            $pasta_dir = "img/jornal/";                
            if(!file_exists($pasta_dir)){
                mkdir($pasta_dir);
            }
            $imgantiga = mysql_query("SELECT capa FROM jornal WHERE id='".limpa($idedit)."'");
            $imgbanco = mysql_result($imgantiga, 0, "capa");                
            preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);             
            $imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];                                      
            if(move_uploaded_file($arquivo['tmp_name'],$imagem)){       
                $return = @unlink($imgbanco);
            }else{
                $imagem = $imgbanco;
            }
        }
        
        mysql_query("UPDATE jornal SET titulo = '".$titulo."', urlcheck = '".$novaurl."', capa = '".$imagem."', isuu = '".$_POST['isuu']."' WHERE id =" .limpa($idedit));
        
        header ("Location: ?pg=modulos/jornal/novo");
        exit;
    }
    
} else {
    $envio = '?pg=modulos/jornal/novo&acao=add';
    $bt = 'Cadastrar';
    $dpg = 'Gerenciamento de Guias';
    $isuu = '';
    $capa = '';
    $titulo = '';
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.widgets.js"></script>
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

<form id="simulador" name="simulador" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Jornal Online</th>
    <th scope="col" width="10%" align="right"><a href='?pg=config/_meuPainel'><img src='img/icones/voltar.png' width='32' height='32' alt='Painel de Controle' /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="30%" height="36" align="right" valign="middle">* Capa&nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $capa; ?><input name="arquivo" <?php if(!isset($_GET['acao'])){ echo ' class="obrigatorio" '; } ?> type="file" id="arquivo" /></td>
    </tr>
    <tr>
      <td height="36" align="right" width="32%" valign="middle">* Titulo&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="titulo" type="text" id="titulo" class="obrigatorio" value="<?php echo $titulo; ?>" style="width:450px;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" width="32%" valign="middle">Link Isuu&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="isuu" type="text" id="isuu" value="<?php echo $isuu; ?>" style="width:450px;" /></td>
    </tr>
    <tr>
      <td colspan="2" height="60" valign="middle" align="center"><label><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></label></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
    $sql = mysql_query("SELECT a.id,
                               a.titulo,
                               a.capa,
                               (SELECT count(*) FROM jornal_fotos f WHERE f.id_jornal = a.id) as paginas,
                               a.id_o
                          FROM jornal a
                          ORDER BY id_o ASC");
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
        echo "    <th>Capa</th>";
        echo "    <th>Titulo</th>";
        echo "    <th>Paginas</th>";
        echo "    <th class='filter-false'>Ações</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tfoot>";
        echo "<tr>";
        echo "    <th>Ordem</th>";
        echo "    <th>Capa</th>";
        echo "    <th>Titulo</th>";
        echo "    <th>Paginas</th>";
        echo "    <th class='filter-false'>Ações</th>";
        echo "</tr>";
        echo "</tfoot>";
        echo "<tbody>";
        while($linha = mysql_fetch_array($sql)) {
            echo "<tr>";
            echo "<td>";
            if($linha['id_o']!=1){
                echo "<a href='?pg=modulos/jornal/novo&acao=up&id=$linha[0]'><img src='img/icones/up.png' width='16' height='16' alt='Subir Item' title='Subir Item' /></a>";
            } else {
                echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
            }
            echo "<span class='t15 corlaranja bold' style='padding:0px 15px;'>".$linha['id_o']."</span>";
            if($linha['id_o']!=mysql_num_rows($sql)){
                echo "<a href='?pg=modulos/jornal/novo&acao=down&id=$linha[0]'><img src='img/icones/down.png' width='16' height='16' alt='Descer Item' title='Descer Item' /></a>";
            } else {
                echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
            }
            echo "</td>";
            echo "<td><img src='".$linha['capa']."' height='60' alt='Jornal' /></td>";
            echo "<td>";
            echo $linha['titulo'];
            echo "<td>";
            echo $linha['paginas'];
            echo "</td>";
            echo "<td>";
            echo "
            <a href='?pg=modulos/jornal/fotos&id=$linha[0]'><img src='img/icones/fotos.png' width='24' heigth='24' alt='Adicionar Fotos' title='Adicionar Fotos' /></a>
            <a onclick=\"javascript:confirmaDel('?pg=modulos/jornal/novo&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
            <a href='?pg=modulos/jornal/novo&acao=att&id=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
            echo "</td>";
            echo "</tr>";
        }
        echo '</tbody>';
        echo "</table>";
    }
    if(isset($_GET["del"])){
        $imgantiga = mysql_query("SELECT id FROM jornal WHERE id='".limpa($_GET['del'])."'");
        
        $caminho = 'img/albuns/'.mysql_result($imgantiga, 0, "id");
        
        if(file_exists($caminho)) {
            $arquivos = scandir($caminho);
            foreach($arquivos as $arquivo) {
                if(!is_dir($arquivo)) {
                    unlink($caminho."/".$arquivo);  
                }
            }
            
            rmdir($caminho);
        }
        
        mysql_query("DELETE FROM jornal WHERE id='".limpa($_GET['del'])."'");
        mysql_query("DELETE FROM jornal_fotos WHERE id_jornal='".limpa($_GET['del'])."'");
        header ("Location: ?pg=modulos/jornal/novo");
        exit;
    }
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>