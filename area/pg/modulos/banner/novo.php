<?php  
error_reporting(0);  
if(!isset($_SESSION['id_usuario'])) {
	header("Location: index.php?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!=1){
		header("Location: index.php?pg=inicial");
	}
}
if(!isset($_GET['local']) || $_GET['local']==''){
	header("Location: ./?pg=modulos/banner/direciona");
}
$vrf = mysql_query("SELECT * FROM banner WHERE local='".addslashes($_GET['local'])."' ORDER BY id_o ASC, evento ASC");
$cont = 0;
while($linha = mysql_fetch_array($vrf)) {
	$cont = $cont + 1;
	mysql_query("UPDATE banner SET id_o = '".$cont."' WHERE id=".limpa($linha[0]));
}	
if(isset($_GET['ativa'])) {
    $id = $_GET['ativa'];
	$status = mysql_query("SELECT status FROM banner WHERE id='".limpa($_GET["ativa"])."'");
	if (mysql_result($status, 0, "status") == "N") { $user = "S"; } else { $user = "N"; }
	mysql_query("UPDATE banner SET status = '".$user."' WHERE id = ".limpa($id));
	header("Location: ?pg=modulos/banner/novo&local=".$_GET['local']."#".$id);
}		
if (isset($_GET['acao'])) {
	$acao = $_GET['acao'];
	if ($acao == "up") {
		$idordenar = $_GET["id"];		
		$ordenar = mysql_query("SELECT * FROM banner WHERE local='".addslashes($_GET['local'])."' AND id='".limpa($idordenar)."'");
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem[5] != "1") {
				$ido = $ordem[5] - 1;
				$p2 = $ido + 1;						
				$proximo = mysql_query("SELECT * FROM banner WHERE local='".addslashes($_GET['local'])."' AND id_o='$ido'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera[5] + 1;
					$idup = $altera[5];					
					$redestaque = mysql_query("UPDATE banner SET
													local = '".addslashes($_GET['local'])."',
													id_o  = '".$ido2."'
													WHERE id=".limpa($altera[0]));
				}				
				$rdestaque = mysql_query("UPDATE banner SET
											local = '".addslashes($_GET['local'])."',
											id_o = '".$idup."'
											WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/banner/novo&local=".$_GET['local']."#".$idordenar);
		}
	}
	if ($acao == "down") {
		$idordenar = $_GET["id"];
		$ordenar = mysql_query("SELECT * FROM banner WHERE local='".addslashes($_GET['local'])."' AND id='".limpa($idordenar)."'");
		$st = mysql_query("SELECT * FROM banner WHERE local='".addslashes($_GET['local'])."'");
		$vttb = mysql_num_rows($st);
		while($ordem = mysql_fetch_array($ordenar)) {
			if ($ordem[5] != $vttb) {
				$ido = $ordem[5] + 1;
				$p2 = $ido - 1;							
				$proximo = mysql_query("SELECT * FROM banner WHERE local='".addslashes($_GET['local'])."' AND id_o='".limpa($ido)."'");
				while($altera = mysql_fetch_array($proximo)) {
					$ido2 = $altera[5] - 1;
					$idup = $altera[5];					
					$redestaque = mysql_query("UPDATE banner SET
													local = '".addslashes($_GET['local'])."',
													id_o = '".$ido2."'
													WHERE id=".limpa($altera[0]));			
				}				
				$rdestaque = mysql_query("UPDATE banner SET
												local = '".addslashes($_GET['local'])."',
												id_o = '".$idup."'
												WHERE id=".limpa($idordenar));
			}
			header ("Location: ?pg=modulos/banner/novo&local=".$_GET['local']."#".$idordenar);
		}
	}
	
	if ($acao == "add") {			
		$nomecliente = $_POST['empresa'];
		$url = $_POST['site'];
		if(isset($_FILES["arquivo"])){
			$arquivo = $_FILES["arquivo"];			
			$pasta_dir = "img/banners/";			
			if(!file_exists($pasta_dir)){
				mkdir($pasta_dir);
			}			
			preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);			
			$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];			
			move_uploaded_file($arquivo["tmp_name"], $imagem);	
			

		}

		$dlxTools = new Dlx_Tools_SpecialChar();
		$dvd = explode("/",$_POST['data']);
        if(isset($_POST['hora'])){
            $hr = $_POST['hora'];
        } else {
            $hr = date("H:i:s");
        }
        $datar = $dvd[2].'-'.$dvd[1].'-'.$dvd[0];

		$insereCliente = mysql_query("INSERT INTO banner (data_reg, hora, empresa, site, img, status, local) VALUES ('$datar', '$hr',  '$nomecliente', '$url', '$imagem', 'S', '".$_GET['local']."')");
		header ("Location: ?pg=modulos/banner/novo&local=".$_GET['local']);
	}
	if($acao=="att"){
		$envio = '?pg=modulos/banner/novo&acao=edit&id='.$_GET['id'].'&local='.$_GET['local'];
		$bt = 'Atualizar';
		$dpg = 'Gerenciamento de Banner';
		$sb = mysql_query("SELECT * FROM banner WHERE id='".limpa($_GET['id'])."'");
		while($linha = mysql_fetch_array($sb)) {
			$img = '<img src="'.$linha[3].'" width="300" alt="Banner" /><br />';
			$dlxTools = new Dlx_Tools_SpecialChar();

			$datar             = implode("/",array_reverse(explode('-',$linha['data_reg'])));
	        $hr               = $linha['hora'];
	      
			$descricao = $linha[1];
			$site = $linha[2];      
		}
	}
	if ($acao == "edit") {
		$idedit = $_GET["id"];
		$nomeempresa = $_POST['empresa'];
		$datar             = implode("-",array_reverse(explode('/',$_POST['data'])));
        $hr               = $_POST['hora'];
		$site = $_POST['site'];			
		if($_FILES["arquivo"] != "") {
			$arquivo = $_FILES["arquivo"];
			$pasta_dir = "img/banners/";				
			if(!file_exists($pasta_dir)){
				mkdir($pasta_dir);
			}
			$imgantiga = mysql_query("SELECT img FROM banner WHERE id='".limpa($idedit)."'");
			$imgbanco = mysql_result($imgantiga, 0, "img");				   
			preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);			   
			$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];									   
			if(move_uploaded_file($arquivo['tmp_name'],$imagem)){		
				$return = @unlink($imgbanco);
			}else{
				$imagem = $imgbanco;
			}
		}
		mysql_query("UPDATE banner SET
							empresa = '".$nomeempresa."',
							data_reg = '".$datar."',
                            hora = '".$hr."',
							site = '".$site."',
							img = '".$imagem."'
							WHERE id ='".limpa($idedit)."'");
		header ("Location: ?pg=modulos/banner/novo&local=".$_GET['local']);
	}
} else {
	$envio = '?pg=modulos/banner/novo&acao=add&local='.$_GET['local'];
	$bt = 'Cadastrar';
	$dpg = 'Gerenciamento de Banner';
	$datar  = date("d/m/Y");
    $hr    = date("H:i:s");
	$img = '';
	$descricao = '';
	$site = '';
}
?>
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script type="text/javascript" src="js/jquery.textarea-expander.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.24.custom.css" />
<script type="text/javascript" src="js/jquery-ui-1.8.24.custom.min.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js"></script>

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

	$('#hora').mask("99:99:99");
    $('#data').datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });

});
</script>
<form id="banner" name="banner" method="post" action="<?php echo $envio; ?>" enctype="multipart/form-data">
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="100" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" class="t20" align="center"><?php echo $dpg.' <font color="red">'.ucfirst($_GET['local']).'</font>'; ?></th>
    <th scope="col" width="10%" align="right"><a href='?pg=config/_meuPainel'><img src='img/icones/voltar.png' width='32' height='32' alt='Painel de Controle' /></a></th>
  </tr>
</table>

    </td>
</tr>
    <tr>
      <td width="30%" height="36" align="right" valign="middle">* Banner&nbsp;&nbsp;</td>
      <td height="36" align="left"><?php echo $img; ?><input name="arquivo" <?php if(!isset($_GET['acao'])){ echo ' class="obrigatorio" '; } ?> type="file" id="arquivo" /><br /><?php if($_GET['local']=='principal'){ echo 'Home - Indicado 2000x600pixels '; } else { echo 'Tamanho Indicado 2000x530pixels'; } ?></td>
    </tr>
    <td height="36" align="right" valign="middle">* Data&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="data" type="text" id="data" class="obrigatorio" value="<?php echo $datar; ?>" style="width:80px; text-align: center;" />&nbsp;&nbsp;&nbsp;&nbsp;Hora&nbsp;&nbsp;<input name="hora" type="text" id="hora" class="obrigatorio" value="<?php echo $hr; ?>" style="width:80px; text-align: center;" /></td>
    <tr>
    <tr>
      <td height="36" align="right" valign="middle">Comentário&nbsp;&nbsp;</td>
      <td height="36" valign="top" align="left"><input name="empresa" type="text" id="empresa" value="<?php echo $descricao; ?>" style="width:450px;" /></td>
    </tr>
    <?php if($_GET['local']=='principal'){ ?>
    <tr>
      <td height="36" align="right" valign="middle">Url de destino&nbsp;&nbsp;</td>
      <td height="36" align="left" class="corcinza2"><input name="site" type="text" id="site" value="<?php echo $site; ?>" style="width:450px;" />&nbsp;Sem http://</td>
    </tr>
    
    <?php } else { ?>

    <?php } ?>
    <tr>
      <td colspan="2" height="60" valign="middle" align="center"><label><input name="cadastrar" onclick="validaform(form.id);" type="button" id="cadastrar" value="<?php echo $bt; ?>" /></label></td>
    </tr>
</table>
</form>
<?php
if(!isset($_GET['acao'])){
	$sql = mysql_query("SELECT * FROM banner WHERE local='".addslashes($_GET['local'])."' ORDER BY id_o ASC");
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
		echo "    <th class='filter-false'>Banner</th>";
		echo "    <th>Descrição</th>";
		if($_GET['local']=='principal'){ echo "    <th class='filter-false'>Url Destino</th>"; }
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "    <th>Ordem</th>";
		echo "    <th class='filter-false'>Banner</th>";
		echo "    <th>Descrição</th>";
		if($_GET['local']=='principal'){ echo "    <th class='filter-false'>Url Destino</th>"; }
		echo "    <th class='filter-false'>Ações</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";		
		while($linha = mysql_fetch_array($sql)) {
			echo "<tr>";
			echo "<td width='100'>";
			if($_GET['local']=='principal'){
				if($linha[5]!=1){
					echo "<a href='?pg=modulos/banner/novo&acao=up&id=$linha[0]&local=".$_GET['local']."'><img src='img/icones/up.png' width='16' height='16' alt='Subir Item' title='Subir Item' /></a>";
				} else {
					echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
				}
				echo "<span class='t15 corlaranja bold' style='padding:0px 15px;'>".$linha[5]."</span>";
				if($linha[5]!=mysql_num_rows($sql)){
					echo "<a href='?pg=modulos/banner/novo&acao=down&id=$linha[0]&local=".$_GET['local']."'><img src='img/icones/down.png' width='16' height='16' alt='Descer Item' title='Descer Item' /></a>";
				} else {
					echo "<img src='img/icones/espaco.png' width='16' height='16' alt='' />";
				}
			} else {
				echo '---';
			}
			echo "</td>";
			echo "<td width='180'>";
			echo "<img src='".$linha[3]."' width='160' height='55' alt='' /></td>";
			echo "<td>";
			if ($linha[4] == "N") {
				echo "<strike>";
			}
			echo $linha[1];
			if ($linha[4] == "N") {
				echo "</strike>";
			}
			echo "</td>";
			if($_GET['local']=='principal'){
				echo "    <td width='100'>";
				if($linha[2]!=''){
					echo "<a href='http://".$linha[2]."' target='_blank'><img src='img/icones/url.png' width='16' height='16' alt='Visualizar Url' title='Visualizar Url' /></a>";	
				}
				echo "</td>";
				
			} else {
				echo "<td>";
				if ($linha[4] == "N") {
					echo "<strike>";
				}
				if(!empty($linha['pagina'])){
					echo mysql_result(mysql_query("SELECT nome FROM banner_paginas WHERE id='".$linha['pagina']."' LIMIT 1"),0,"nome");
				} else {
					echo '0';
				}
				if ($linha[4] == "N") {
					echo "</strike>";
				}
				echo "</td>";
			}
			echo "<td width='100'>";
			echo "
			<a href='?pg=modulos/banner/novo&ativa=$linha[0]&local=".$_GET['local']."' name='".$linha[0]."'><img src='img/icones/status.png' width='24' heigth='24' alt='Ativar/Desativar' title='Ativar/Desativar' /></a>
			<a onclick=\"javascript:confirmaDel('?pg=modulos/banner/novo&del=$linha[0]&local=".$_GET['local']."')\" style='cursor:pointer;'><img src='img/icones/deletar.png' width='24' heigth='24' alt='Remover' title='Remover' /></a>
			<a href='?pg=modulos/banner/novo&acao=att&id=$linha[0]&local=".$_GET['local']."'><img src='img/icones/editar.png' width='24' heigth='24' alt='Alterar' title='Alterar' /></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo '</tbody>';
		echo "</table>";
	}
	if(isset($_GET["del"])){
		$imgantiga = mysql_query("SELECT img FROM banner WHERE id='".limpa($_GET['del'])."'");
		$return = unlink(mysql_result($imgantiga, 0, "img"));
		mysql_query("DELETE FROM banner WHERE id='".limpa($_GET['del'])."'");
		header ("Location: ?pg=modulos/banner/novo&local=".$_GET['local']);
	}
}
?>
<script type="text/javascript" src="js/jquery.blockUI.js?v2.34"></script>