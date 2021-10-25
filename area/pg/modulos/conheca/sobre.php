<?php
if(!isset($_SESSION['nome_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!=1) {
		header("Location: ?pg=inicial");
	}
}
if(isset($_GET['remover'])){
  $return = @unlink(mysql_result(mysql_query("SELECT imagem FROM empresa WHERE id='1'"), 0, "imagem"));
  header("Location: ?pg=modulos/conheca/sobre");
}
if (isset($_GET['edit'])) {
  if($_FILES["arquivo"] != "") {
    $arquivo = $_FILES["arquivo"];
    $pasta_dir = "img/institucional/";        
    if(!file_exists($pasta_dir)){
      mkdir($pasta_dir);
    }
    $imgantiga = mysql_query("SELECT imagem FROM empresa WHERE id='1'");
    $imgbanco = mysql_result($imgantiga, 0, "imagem");          
    preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);         
    $imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];                    
    if(move_uploaded_file($arquivo['tmp_name'],$imagem)){
      $return = @unlink($imgbanco);
    }else{
      $imagem = $imgbanco;
    }
  }
  if(!file_exists($imagem)){
    $imagem = '';
  }
	mysql_query("UPDATE empresa SET texto = '".mysql_real_escape_string($_POST['desc'])."', imagem='".$imagem."' WHERE id ='1'");
	header("Location: ?pg=modulos/conheca/sobre");
} else {
	$envio = "?pg=modulos/conheca/sobre&edit";		
	$ed = mysql_query("SELECT * FROM empresa WHERE id='1'");
	$rw = mysql_fetch_object($ed);
	$conteudo = $rw->texto;
  if(file_exists($rw->imagem)){
    $imagem   = '<img src="'.$rw->imagem.'" width="200" />&nbsp;&nbsp;<a href="./?pg=modulos/conheca/sobre&remover=foto"><img src="img/icones/remover.png" width="16" height="16" alt="Remover" title="Remover" /></a><br />';
  } else {
    $imagem   = '';
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
	function attdel(){
	    var cont = $("input[type=checkbox][name='deletar[]']:checked").length;
	    if(cont > 0) {
	       $(".rem").html('REMOVER SELEÇÃO ('+cont+')');
	    } else {
		  $(".rem").html('REMOVER SELEÇÃO');
	    }
	}
	function delfoto(){
		$('#carregando').fadeIn(500);
		$('.fotos-empresa').hide('fast');
		var selecionados = '';
		$("input[type=checkbox][name='deletar[]']:checked").each(function(){
			selecionados += $(this).val()+'###';
		});
		$.ajax({
			url:'pg/config/delfoto.php',
			type:'post',
			data:'itens='+selecionados,
			success: function(data){
				$(".fotos-empresa").html(data);
			}
		});
		$(".rem").html('REMOVER SELEÇÃO');
		$('.fotos-empresa').fadeIn(500);
		$('#carregando').fadeOut(500);
	}
	$(function(){
	    function atualizaOrdemFotos() {
	        var elemento = $();
            var codImg = "";
            var cont   = 1;
            
            var saida = '[';
            
            elemento = $("#lista-fotos-empresa");    
            
            $(elemento).find("li").each(function() {
                if(saida.length > 1) {
                    saida = saida+', ';
                }
                                                 
                codImg = $(this).attr('id').substr(3);
                saida = saida+'{ "codimg" : "'+codImg+'", "seq" : "'+cont+'" }';
                
                cont++;
            });
            
            saida = saida+"]";
            
            $.ajax({
                url: "pg/config/ordena_fotos.php",
                type: "post",
                data: { "acao": "bio", "dados": saida }
            });
	    } 
	   
	    function habilitaArrastar() {
	        $("#lista-fotos-empresa").sortable({
                stop: function() {
                    atualizaOrdemFotos();
                }
            });
            $("#lista-fotos-empresa").disableSelection();
	    } 

        habilitaArrastar();
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
    <th scope="col" width="80%" class="t20" align="center">Institucional / Nossa História</th>
    <th scope="col" width="10%" align="right"><a href="?pg=config/meuPainel"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>
    </td>
</tr>
    <tr>
      <td width="20%" height="36" align="right" valign="middle">Imagem&nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $imagem; ?><input name="arquivo" type="file" id="arquivo" /></td>
    </tr>
  <tr>
    <td width="200" height="310" align="right" valign="middle">Nossa História&nbsp;&nbsp;</td>
    <td height="310" align="left"><textarea id="desc" name="desc" style="width: 90%; height:350px;"><?php echo $conteudo; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" height="90" valign="middle" align="center"><input type="button" onclick="validaform(form.id);" name="save" value="Atualizar" /></td>
  </tr>
</table>     
</form>

<div class="fotosEmpresa" name="fotosdaempresa">
  <?php echo "<a onClick=\"PopUpCentralizado('pg/modulos/conheca/foto_adiciona.php', 'dlx', '417', '390', 'no');\" style='cursor: pointer;'>Adicionar Fotos</a>"; ?>
  <?php $vf = mysql_query("SELECT * FROM fotos_empresa ORDER BY id_o ASC"); if(mysql_num_rows($vf)>0){ ?>
  <a onclick="delfoto();" class="rem" style="cursor:pointer;">Remover Seleção</a>
  <span style="padding: 10px 15px; display: inline-block; ">(Para <b>ordenar</b> as fotos, clique e <b>arraste</b>)</span>
  <ul id="lista-fotos-empresa" class="fotos-empresa">
    <?php
    while($rw=mysql_fetch_object($vf)){
      echo '<li id="fto'.$rw->id.'">
              <div class="checkBdel"><input onclick="attdel();" class="fotose" name="deletar[]" type="checkbox" id="deleta" value="'.$rw->id.'"></div>
              <img src="'.$rw->foto.'" />
            </li>';
    }
    ?>    
    <div class="clear"></div>
  </ul>
  <?php } else { ?>
  <p style="padding-bottom: 60px; text-align:center;">Nenhuma foto até o momento...</p>
  <?php } ?>
</div>

</body>
</html>