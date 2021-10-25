<?php
error_reporting(0);
$conexao = mysql_connect("localhost", "wwwagenc_user", "M%LE[vl}5@rF");
mysql_select_db("wwwagenc_db",$conexao);
mysql_set_charset("utf8", $conexao);

$valida = isset($_POST["valida"]) ? $_POST["valida"] : null;
if($valida == "enviar"){	
	$nome 	 	 = utf8_decode($_POST["mnome"]);
	$email 		 = utf8_decode($_POST["memail"]);
	$anome 		 = utf8_decode($_POST["anome"]);
	$aemail 	 = utf8_decode($_POST["aemail"]);
	$mensagem 	 = utf8_decode($_POST["mensagem"]);
	
	$ass = $anome.", ".$nome." te indicou uma liturgia.";
					 
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "From: ".$nome." - ".$GLOBALS['config']['mascara']." <".$email.">\r\n"; 
	$headers .= "Return-Path: ".$email."\r\n";
	$headers .= "Content-Type: Text/HTML\r\n";
	
	$msg = "<font face=tahoma color=black size=2>";
	$msg .= "<strong>".$nome."</strong> está indicando uma liturgia ".$_POST["tnot"]."<br /><br />";
	$msg .= "<a href='".$_POST["endereco"]."' target='_blank'>Clique aqui para acessar!</a><br /><br />";
	$msg .= date("d/m/Y - H:i:s")."<br />";
	$msg .= "</font>";

	$envio = mail($aemail, utf8_decode($ass), $msg, $headers);

	if($envio)
		echo "<script>javascript:ok('Mensagem enviada com sucesso','".$_POST["endereco"]."')</script>";
	else
		echo "<script>javascript:error('Erro! Por Favor tente novamente','".$_POST["endereco"]."')</script>";
}
?>
<link rel="stylesheet" type="text/css" href="css/liturgia.css" />
<script src="js/js-global/FancyZoom.js" type="text/javascript"></script>
<script src="js/js-global/FancyZoomHTML.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
	function indica(){
		$('#dados_indicacao').slideToggle();
	}
	function ve(item){
		$('.primeira, .segunda, .salmo, .evangelho').hide('fast');
		$('#primeira, #segunda, #salmo, #evangelho').removeClass('ativo');
		$('#'+item).addClass('ativo');
		$('.propNoti .'+item).slideToggle();
	}
</script>
<body id="whatever" onLoad="setupZoom()">
<?php
$data = implode("/",array_reverse(explode('-',$_GET['data'])));
$vdc = mysql_query("SELECT * FROM liturgia WHERE data_reg='".$data."'");
$vt = mysql_num_rows($vdc);
$row = mysql_fetch_object($vdc);
$part = explode("-",$_GET['data']);

$dia = $part[2];
$mes = $part[1];
if($mes<=11 && $mes>=2){
	$mesa = ($mes-1);
	$mesp = ($mes+1);
	$anoa = $part[0];
	$anop = $part[0];
} else {
	if($mes==12){
		$mesa = 11;
		$mesp = 01;
		$anoa = $part[0];
		$anop = ($part[0]+1);
	} else if($mes==1){
		$mesa = 12;
		$mesp = 02;
		$anoa = ($part[0]-1);
		$anop = $part[0];
	}
}
if(strlen($mes)==1){ $mes = '0'.$mes; }
if(strlen($mesa)==1){ $mesa = '0'.$mesa; }
if(strlen($mesp)==1){ $mesp = '0'.$mesp; }
$ano 	= $part[0];
$limite = diasMes($mes, $ano);
$comeca = (diaSemana('01/'.$mes.'/'.$ano) + 1);
?>
<div class="paginas">
	<div class="util">
		<div class="area_noticias">
			<div class="intro3">LITURGIA DIÁRIA - <?php echo $data; ?></div>
		</div>
	</div>
	<div class="relaciona">

		<div id="calendario">
			<div class="topo">
				<a href="./interatividade/liturgia-diaria/<?php echo $anoa.'-'.$mesa.'-'.$dia; ?>"><div class="mesanterior"><?php echo substr(escreveMes($mesa),0,3); ?></div></a>
				<div class="mesatual"><?php echo escreveMes($mes).' '.$ano; ?></div>
				<a href="./interatividade/liturgia-diaria/<?php echo $anop.'-'.$mesp.'-'.$dia; ?>"><div class="mesposterior"><?php echo substr(escreveMes($mesp),0,3); ?></div></a>
			</div>
			<div class="dias">
				<li>DOM</li>
				<li>SEG</li>
				<li>TER</li>
				<li>QUA</li>
				<li>QUI</li>
				<li>SEX</li>
				<li>SAB</li>
			</div>
			<div class="uteis">
				<?php
				$c=0;
				for($i=1; $i<=($limite + ($comeca - 1)); $i++){
					if($i>=$comeca){
						$c++;
						if(strlen($c)==1){ $c = '0'.$c; }
						echo '<a href="./interatividade/liturgia-diaria/'.$ano.'-'.$mes.'-'.$c.'" class="escrito"><li '; if($dia==$c){ echo ' class="ativo" '; } echo '>'.$c.'</li>';
					} else {
						echo '<li class="nohover">&nbsp;</li>';
					}
				}
				?>
			</div>
			<a href="./interatividade/liturgia-diaria/<?php echo date("Y-m-d"); ?>"><div class="hoje">HOJE, <?php echo date("d/m/Y"); ?></div></a>
		</div>

	</div>
	<div class="util">
		<div class="utiln">
			<div class="area_contato" style="min-height: 90px;">
				<?php echo '<div class="vdata">'.$part[2].'<div>'.substr(escreveMes($part[1]),0,3).'</div></div>'; ?>
				<div class="intro5 menos1"><?php if($vt>0){ echo $row->nome.'<p>'.$row->data_reg.'</p>'; } else { echo 'Nenhum registro nesta data...'; } ?></div>
			</div>
			<div class="clear"></div>

			<div class="abas">
				<?php $at=0; if(!empty($row->descricao)){ $at++; ?>
				<li id="primeira" onclick="ve('primeira');" class="ativo">1ª Leitura</li>
				<?php } if(!empty($row->salmo)){ $at++; ?>
				<li id="salmo" onclick="ve('salmo');" <?php if($at==0){ echo 'class="ativo"'; } ?>>Salmo</li>
				<?php } if(!empty($row->descricao2)){ $at++; ?>
				<li id="segunda" onclick="ve('segunda');" <?php if($at==0){ echo 'class="ativo"'; } ?>>2ª Leitura</li>
				<?php } if(!empty($row->evangelho)){ ?>
				<li id="evangelho" onclick="ve('evangelho');" <?php if($at==0){ echo 'class="ativo"'; } ?>>Evangelho</li>
				<?php } ?>
			</div>
			
			<div class="noticiaAtivo">
				<div class="propNoti">
					<?php if(!empty($row->descricao)){ ?>
					<div class="primeira"><?php echo nl2br($row->descricao); ?></div>
					<?php } if(!empty($row->descricao2)){ ?>
					<div class="segunda"><?php echo nl2br($row->descricao2); ?></div>
					<?php } if(!empty($row->salmo)){ ?>
					<div class="salmo"><?php echo nl2br($row->salmo); ?></div>
					<?php } if(!empty($row->evangelho)){ ?>
					<div class="evangelho"><?php echo nl2br($row->evangelho); ?></div>
					<?php } ?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>

			<?php if($vt>0){ ?>

			<div class="divulgacao">
				<a href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>&t=<?php echo urlencode($row->nome); ?>" target="_blank"><div class="compartilhe"><img src="img/bt-compartilhe.png" width="151" height="38" alt="Compartilhe está Notícia" title="Compartilhe está Notícia" /></div></a>
				<div onclick="window.print();" class="imprimir"></div>
				<div onclick="indica();" class="indicar"></div>
				<a href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>&t=<?php echo urlencode($row->nome); ?>" target="_blank"><div class="face"></div></a>
			</div>

			<div id="dados_indicacao">
				<div class="intro6">Indique a um amigo</div>
				<div class="clear"></div>
				<form name="indicao" id="indicacao" action="./?pg=liturgia&indica" method="post">
					<label>* Seu Nome</label><input type="text" name="mnome" id="mnome" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* Seu E-mail</label><input type="text" name="memail" id="memail" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* Nome do Amigo</label><input type="text" name="anome" id="anome" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* E-mail do Amigo</label><input type="text" name="aemail" id="aemail" class="obrigatorio" style="width:300px;" />
					<div class="clear"></div>
					<label>* Mensagem</label><textarea class="obrigatorio" name="mensagem" id="mensagem" style="width:300px;"></textarea>
					<input type="hidden" name="valida" id="valida" value="enviar" />
					<input type="hidden" name="endereco" id="endereco" value="http://<?php echo $GLOBALS['config']['url'].'/'.$_GET['url'].'/'.$_GET['noticia']; ?>" />
					<input type="hidden" name="tnot" id="tnot" value="<?php echo $row->nome; ?>" />
					<div class="clear"></div>
					<label>&nbsp;</label><input type="button" class="bte" onclick="validaform(form.id);" value="ENVIAR E-MAIL" />
					<div class="clear"></div>
				</form>
			</div>

			<?php } ?>

		</div>
	</div>
	<div class="clear"></div>
</div>