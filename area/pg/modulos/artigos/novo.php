<?php
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ?pg=inicial");
    exit;
} else {
    if($_SESSION['nivel_usuario']!=1){
        header("Location: ?pg=inicial");
        exit;
    }
}
if(isset($_GET['ativa'])) {
    $id = limpa($_GET['ativa']);
    $status = mysql_query("SELECT status FROM artigos WHERE id='".limpa($_GET["ativa"])."'");
    if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
    mysql_query("UPDATE artigos SET status = '".$user."' WHERE id = ".limpa($id));
    header("Location: ?pg=modulos/artigos/novo#".$id);
    exit;
}       
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];    
    if ($acao == "add") {
        $titulo    = mysql_real_escape_string($_POST['titulo']);
        $conteudo  = mysql_real_escape_string($_POST['conteudoo']);
        $fonte     = $_POST['fonte'];
        
        if(isset($_FILES["arquivo"])){
            $arquivo = $_FILES["arquivo"];
            $pasta_dir = "img/artigos/";
            if(!file_exists($pasta_dir)){
                mkdir($pasta_dir);
            }
            preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
            $imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
            move_uploaded_file($arquivo["tmp_name"], $imagem);            
            $dlxTools = new Dlx_Tools_SpecialChar();
        }
        if(!file_exists($imagem)){
            $imagem = '';
        }
        $insereCliente = mysql_query("INSERT INTO artigos(data_reg, imagem, id_usuario, titulo, url_check, conteudo, fonte, status) 
                                                    VALUES('".date("Y-m-d")."', '$imagem', ".$_SESSION['id_usuario'].", '$titulo', '".$dlxTools->remove_accents($titulo)."', '$conteudo', '$fonte', 'S')");
                                                    
        header("Location: ?pg=modulos/artigos/novo");
        exit;
    }
    if($acao=="att"){
        $envio = '?pg=modulos/artigos/novo&acao=edit&id='.$_GET['id'];
        $bt  = 'Atualizar';
        $dpg = 'Gerenciamento de artigos';
        $sb = mysql_query("SELECT * FROM artigos WHERE id='".limpa($_GET['id'])."'");
        while($linha = mysql_fetch_array($sb)) {
            $img      = '<img src="'.$linha['imagem'].'" width="150" alt="'.$linha['titulo'].'" title="'.$linha['titulo'].'" /><br />';
            $conteudo  = $linha['conteudo'];
            $titulo    = $linha['titulo'];
            $fonte     = $linha['fonte'];
        }
    }
    if ($acao == "edit") {
        $idedit = $_GET["id"];
        $titulo    = mysql_real_escape_string($_POST['titulo']);
        $conteudo  = mysql_real_escape_string($_POST['conteudoo']);
        $introd    = mysql_real_escape_string($_POST['introducao']);
        $fonte     = $_POST['fonte'];

        $d         = explode("/", $_POST['data']);
        $datar     = $d[2].'-'.$d[1].'-'.$d[0];
        
        $dlxTools = new Dlx_Tools_SpecialChar();
        
        if($_FILES["arquivo"] != "") {
            $arquivo = $_FILES["arquivo"];
            $pasta_dir = "img/artigos/";             
            if(!file_exists($pasta_dir)){
                mkdir($pasta_dir);
            }
            $imgantiga = mysql_query("SELECT imagem FROM artigos WHERE id='".limpa($idedit)."'");
            $imgbanco = mysql_result($imgantiga, 0, "imagem");                
            preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);             
            $imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];                                      
            if(move_uploaded_file($arquivo['tmp_name'],$imagem)){
                @unlink($imgbanco);
            }else{
                $imagem = $imgbanco;
            }
        }
        $update = mysql_query("UPDATE artigos SET
                                    titulo      = '$titulo',
                                    url_check   = '".$dlxTools->remove_accents($titulo)."',
                                    conteudo    = '".$conteudo."',
                                    fonte       = '".$fonte."',
                                    imagem      = '".$imagem."'
                                    WHERE id =" .limpa($idedit));
        header ("Location: ?pg=modulos/artigos/novo");
        exit;
    }
} else {
    $envio = '?pg=modulos/artigos/novo&acao=add';
    $bt = 'Cadastrar';
    $dpg = 'Gerenciamento de artigos';
    $img       = '';
    $titulo    = '';
    $conteudo  = '';
    $fonte     = '';
}
?>
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
<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    language : "pt_BR",
    selector: "textarea",
    theme: "modern",
    width: 850,
    height: 280,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media fullpage | forecolor backcolor", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
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
    <th scope="col" width="80%" class="t20" align="center"><?php echo $dpg; ?></th>
    <th scope="col" width="10%" align="right"><a href='?pg=config/meuPainel'><img src='img/icones/voltar.png' width='32' height='32' alt='Painel de Controle' /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="18%" height="36" align="right" valign="middle">Foto Principal &nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $img; ?><input name="arquivo" type="file" id="arquivo" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Titulo da Notícia&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="titulo" type="text" id="titulo" class="obrigatorio" value="<?php echo $titulo; ?>" style="width:840px;" /></td>
    </tr>
    <tr>
      <td height="310" align="right" valign="middle">* Conteudo&nbsp;&nbsp;</td>
      <td height="310" valign="top" align="left"><textarea name="conteudoo" id="conteudoo" style="width:850px; height: 300px;"><?php echo $conteudo; ?></textarea></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle"> Fonte&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="fonte" type="text" id="fonte" value="<?php echo $fonte; ?>" style="width:450px;" /></td>
    </tr>
    <tr>
      <td colspan="2" height="60" valign="middle" align="center"><label><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></label></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
    $sql = mysql_query("SELECT * FROM artigos ORDER BY data_reg DESC");
    if(mysql_num_rows($sql)==0) {
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
        echo "    <th>Autor</th>";
        echo "    <th class='filter-false'>Imagem</th>";
        echo "    <th>Titulo</th>";
        echo "    <th class='filter-false'>Ações</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tfoot>";
        echo "<tr>";
        echo "    <th>Data</th>";
        echo "    <th>Autor</th>";
        echo "    <th class='filter-false'>Imagem</th>";
        echo "    <th>Titulo</th>";
        echo "    <th class='filter-false'>Ações</th>";
        echo "</tr>";
        echo "</tfoot>";
        echo "<tbody>";     
        while($linha = mysql_fetch_array($sql)) {
            $datareg = implode("/",array_reverse(explode('-',$linha['data_reg'])));
            echo "<tr>";
            echo "<td height='65' width='100'>";
            if ($linha['status'] == "N") {
                echo "<strike>";
            }
            echo $datareg;
            if ($linha['status'] == "N") {
                echo "</strike>";
            }
            echo "</td>";
            echo "<td width='180'>";
            if ($linha['status'] == "N") {
                echo "<strike>";
            }
            echo mysql_result(mysql_query("SELECT nome FROM usuarios WHERE id='".$linha['id_usuario']."'"),0,"nome");
            if ($linha['status'] == "N") {
                echo "</strike>";
            }
            echo "</td>";
            echo "<td>";
            echo "<img src='".$linha['imagem']."' width='80' height='60' alt='' /></td>";
            echo "<td>";
            if ($linha['status'] == "N") {
                echo "<strike>";
            }
            echo $linha['titulo'];
            if ($linha['status'] == "N") {
                echo "</strike>";
            }
            echo "</td>";
            echo "<td>";
            echo "
            <a href='?pg=modulos/artigos/novo&ativa=$linha[0]' name='".$linha[0]."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar/Desativar' title='Ativar/Desativar' /></a>
            <a onclick=\"javascript:confirmaDel('?pg=modulos/artigos/novo&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
            <a href='?pg=modulos/artigos/novo&acao=att&id=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
            echo "</td>";
            echo "</tr>";
        }
        echo '</tbody>';
        echo "</table>";
    }
    if(isset($_GET["del"])){
        $imgantiga = mysql_query("SELECT imagem FROM artigos WHERE id='".limpa($_GET['del'])."'");
        $return = unlink(mysql_result($imgantiga, 0, "imagem"));
        mysql_query("DELETE FROM artigos WHERE id='".limpa($_GET['del'])."'");
        header("Location: ?pg=modulos/artigos/novo");
        exit;
    }
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>