<?php    
if(!isset($_SESSION['id_usuario'])) {
    header("Location: index.php?pg=home");
    exit;
} else {
    if($_SESSION['nivel_usuario']==2){
        header("Location: index.php?pg=home");
        exit;
    }
}       
if (isset($_GET['acao'])) {
    $dlxTools = new Dlx_Tools_SpecialChar();
    $acao = $_GET['acao'];    
    if ($acao == "add") {           
        $data = implode("-",array_reverse(explode('/',$_POST['data_reg'])));
        if(isset($_FILES["arquivo"])){
            $arquivo = $_FILES["arquivo"];          
            $pasta_dir = "img/albuns/";         
            if(!file_exists($pasta_dir)){
                mkdir($pasta_dir);
            }           
            preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);          
            $imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];           
            move_uploaded_file($arquivo["tmp_name"], $imagem);  
            
            mysql_query("INSERT INTO album (data_reg, festa, foto, urlcheck) VALUES ('$data', '".mysql_escape_string($_POST['festa'])."', '$imagem', '".$dlxTools->remove_accents(mysql_escape_string($_POST['festa']).'-'.$_POST['data_reg'])."')");
            header ("Location: ?pg=modulos/albuns/novo");
            exit;
        } else {
            mysql_query("INSERT INTO album (data_reg, festa, foto, urlcheck) VALUES ('$data', '".mysql_escape_string($_POST['festa'])."', '', '".$dlxTools->remove_accents(mysql_escape_string($_POST['festa']).'-'.$_POST['data_reg'])."')");
        }
    }
    if($acao=="att"){
        $envio = '?pg=modulos/albuns/novo&acao=edit&id='.$_GET['id'];
        $bt    = 'Atualizar';
        $dpg   = 'Gerenciamento de Albuns';
        $sb    = mysql_query("SELECT * FROM album WHERE id='".limpa($_GET['id'])."'");
        while($linha = mysql_fetch_array($sb)) {
            $img       = '<img src="'.$linha['foto'].'" width="150" alt="'.$linha['festa'].'" title="'.$linha['festa'].'" /><br />';
            $data_reg  = implode("/",array_reverse(explode('-',$linha['data_reg'])));
            $festa     = $linha['festa'];
        }
    }
    if ($acao == "edit") {
        $idedit = $_GET["id"];
        if($_FILES["arquivo"] != "") {
            $arquivo = $_FILES["arquivo"];
            $pasta_dir = "img/albuns/";
            if(!file_exists($pasta_dir)){
                mkdir($pasta_dir);
            }
            $data = implode("-",array_reverse(explode('/',$_POST['data_reg'])));
            
            $imgantiga = mysql_query("SELECT foto FROM album WHERE id='".limpa($idedit)."'");
            $imgbanco = mysql_result($imgantiga, 0, "foto");
            preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
            $imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
            if(move_uploaded_file($arquivo['tmp_name'],$imagem)){
                @unlink($imgbanco);
                $update = mysql_query("UPDATE album SET
                                            data_reg    = '".$data."',
                                            festa       = '".mysql_escape_string($_POST['festa'])."',
                                            foto        = '".$imagem."',
                                            urlcheck    = '".$dlxTools->remove_accents(mysql_escape_string($_POST['festa']).'-'.$_POST['data_reg'])."'
                                            WHERE id    =" .limpa($idedit));
                
            }else{
                $imagem = $imgbanco;
                $update = mysql_query("UPDATE album SET
                                            data_reg    = '".$data."',
                                            festa       = '".mysql_escape_string($_POST['festa'])."',
                                            foto        = '".$imagem."',
                                            urlcheck    = '".$dlxTools->remove_accents(mysql_escape_string($_POST['festa']).'-'.$_POST['data_reg'])."'
                                            WHERE id    =" .limpa($idedit));
            }
            header ("Location: ?pg=modulos/albuns/novo");
            exit;
        }
    }
} else {
    $envio = '?pg=modulos/albuns/novo&acao=add';
    $bt = 'Cadastrar';
    $dpg = 'Gerenciamento de Albuns';
    $img = '';
    $data_reg  = '';
    $festa = '';
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/jquery-ui-1.8.24.custom.css" />
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.widgets.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.24.custom.min.js"></script>
<script>
$(document).ready(function(){
    $('#data_reg').datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
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

tinyMCE.init({
    language : "pt",
        mode : "textareas",
        theme : "advanced",
        plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        theme_advanced_buttons1:
        "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,link,unlink,media,table,formatselect,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",
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

<form id="simulador" name="simulador" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center"><?php echo $dpg; ?></th>
    <th scope="col" width="10%" align="right"><a href='?pg=config/_meuPainel'><img src='img/icones/voltar.png' width='32' height='32' alt='Painel de Controle' /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="20%" height="36" align="right" valign="middle">* Foto&nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $img; ?><input name="arquivo" <?php if(!isset($_GET['acao'])){ echo ' class="obrigatorio" '; } ?> type="file" id="arquivo" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Data&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="data_reg" type="text" id="data_reg" class="obrigatorio" value="<?php echo (!isset($_GET['acao'])) ?  date('d/m/Y') : $data_reg; ?>" style="width:100px; text-align:center;" /></td>
    </tr>
    <tr>
      <td height="36" align="right" valign="middle">* Evento / Nome&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="festa" type="text" id="festa" class="obrigatorio" value="<?php echo $festa; ?>" style="width:650px;" /></td>
    </tr>
    <tr>
      <td colspan="2" height="60" valign="middle" align="center"><label><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></label></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
    $sql = mysql_query("SELECT * FROM album ORDER BY data_reg DESC, id DESC");
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
        echo "    <th>Data</th>";
        echo "    <th class='filter-false'>Foto</th>";
        echo "    <th>Nome</th>";
        echo "    <th>Qtd Fotos</th>";
        echo "    <th class='filter-false'>Ações</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tfoot>";
        echo "<tr>";
        echo "    <th>Data</th>";
        echo "    <th class='filter-false'>Foto</th>";
        echo "    <th>Nome</th>";
        echo "    <th>Qtd Fotos</th>";
        echo "    <th class='filter-false'>Ações</th>";
        echo "</tr>";
        echo "</tfoot>";
        echo "<tbody>";
        while($linha = mysql_fetch_array($sql)) {
            echo "<tr>";
            echo "<td width='130'>";
            echo implode("/",array_reverse(explode('-',$linha['data_reg'])));
            echo "</td>";
            echo "<td width='130'>";
            echo "<img src='".$linha['foto']."' alt='' style='max-width: 80px; max-height: 50px;' /></td>";
            echo "<td>";
            echo $linha['festa'];
            echo "</td>";
            echo "<td width='100'>";
            echo mysql_num_rows(mysql_query("SELECT * FROM album_fotos WHERE id_album='".$linha[0]."'"));
            echo "</td>";
            echo "<td width='130'>";
            echo "
            <a href='?pg=modulos/albuns/fotos&id=$linha[0]'><img src='img/icones/fotos.png' width='24' heigth='24' alt='Adicionar Fotos' title='Adicionar Fotos' /></a>
            <a onclick=\"javascript:confirmaDel('?pg=modulos/albuns/novo&del=$linha[0]')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
            <a href='?pg=modulos/albuns/novo&acao=att&id=$linha[0]'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
            echo "</td>";
            echo "</tr>";
        }
        echo '</tbody>';
        echo "</table>";
    }
    if(isset($_GET["del"])){
        $imgantiga = mysql_query("SELECT foto, id FROM album WHERE id='".limpa($_GET['del'])."'");
        unlink(mysql_result($imgantiga, 0, "foto"));
        
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
        
        mysql_query("DELETE FROM album WHERE id='".limpa($_GET['del'])."'");
        mysql_query("DELETE FROM album_fotos WHERE id_album='".limpa($_GET['del'])."'");
        header ("Location: ?pg=modulos/albuns/novo");
        exit;
    }
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>
</body>
</html>