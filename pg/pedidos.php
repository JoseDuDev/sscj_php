<?php
$valida = isset($_POST["valida"]) ? $_POST["valida"] : null;
if($valida == "enviar"){	
	$nomecont 	 = utf8_decode(@$_POST["cnome"]);
	$email 		 = utf8_decode(@$_POST["cemail"]);
	$mensagem 	 = utf8_decode(@$_POST["cmensagem"]);
	
	$ass = "Pedidos de Oração";
					 
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "From: ".utf8_decode($GLOBALS['config']["mascara"])." <".$email.">\r\n"; 
	$headers .= "Return-Path: ".$email."\r\n";
	$headers .= "Content-Type: Text/HTML\r\n";
	
	$msg = "<font face=tahoma color=black size=2>";
	$msg .= "<strong>".$nomecont."</strong> deixou seu pedido de oração pelo site, segue os dados abaixo!<br />";
	$msg .= "<strong>E-mail </strong>- ".$email."<br />";
	$msg .= "<strong>Pedido</strong><br />".$mensagem."<br /><br /><br />";
	$msg .= date("d/m/Y - H:i:s")."<br />";
	$msg .= "</font>";

	//$envio = mail($GLOBALS['config']['email'], utf8_decode($ass), $msg, $headers);
	//$envio = mail("danieli.herdt@hotmail.com", utf8_decode($ass), $msg, $headers);
	//$envio = mail("farias.marco@terra.com.br", utf8_decode($ass), $msg, $headers);

	$envio = mail("comunicacao@santuarioscj.com.br", utf8_decode($ass), $msg, $headers);

	if($envio)
		echo "<script>javascript:ok('Mensagem enviada com sucesso','./interatividade/pedidos-de-oracao')</script>";
	else
		echo "<script>javascript:error('Erro! Por Favor tente novamente','./interatividade/pedidos-de-oracao')</script>";
}
?>
<link rel="stylesheet" type="text/css" href="css/interatividade.css" />
<div class="paginas">
	<div class="util">
		<div class="area_contato">
			<div class="intro3">PEDIDOS DE ORAÇÃO</div>
			<p><?php echo nl2br($GLOBALS['config']["msg5"]); ?></p>
			<form name="contatos" id="contatos" action="./?pg=pedidos" method="post">
				<div class="area-formulario">
					<p>Nome</p>
					<p><input type="text" name="cnome" id="cnome" class="obrigatorio" /></p>
					<p>E-mail</p>
					<p><input type="text" name="cemail" id="cemail" class="obrigatorio" /></p>
					<p>Pedidos de Oração</p>
					<p><textarea name="cmensagem" id="cmensagem" class="obrigatorio" style="height: 90px;"></textarea></p>
					<input type="hidden" name="valida" id="valida" value="enviar" />
					<p><input name="cadastrar" type="button" onclick="validaform(form.id);" id="cadastrar" class="btc" value="ENVIAR" /></p>
				</div>
			</form>
		</div>
	</div>
	<div style="height: 200px; width: 100%;">&nbsp;</div>
	<div class="clear"></div>
</div>