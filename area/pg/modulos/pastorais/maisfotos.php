<?php
if(!isset($_SESSION['nome_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!=1) {
		header("Location: ?pg=inicial");
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
			url:'pg/config/delfotop.php',
			type:'post',
			data:'itens='+selecionados+'&produto=<?php echo $_GET["produto"]; ?>',
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
                url: "pg/config/ordena_produtos.php",
                type: "post",
                data: { "acao": "bio", "dados": saida, "produto": <?php echo $_GET['produto']; ?> }
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

<table width="1200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center">Fotos adicionais de <?php echo mysql_result(mysql_query("SELECT titulo FROM pastorais WHERE id='".addslashes($_GET['produto'])."'"),0,"titulo"); ?></th>
    <th scope="col" width="10%" align="right"><a href="?pg=modulos/pastorais/novo#<?php echo $_GET['produto']; ?>"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>
    </td>
</tr>
</table>

<div class="fotosEmpresa" name="fotosdaempresa">
  <?php echo "<a onClick=\"PopUpCentralizado('pg/modulos/pastorais/foto_adiciona.php?produto=".$_GET['produto']."', 'dlx', '417', '390', 'no');\" style='cursor: pointer;'>Adicionar Fotos</a>"; ?>
  <?php $vf = mysql_query("SELECT * FROM fotos_produtos WHERE id_p='".$_GET['produto']."' ORDER BY id_o ASC"); if(mysql_num_rows($vf)>0){ ?>
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