<?php
$valida = isset($_POST["valida"]) ? $_POST["valida"] : null;
if($valida == "enviar"){
	
	$ass = "Seja um dizimista";
					 
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "From: ".$_POST["email"]."\r\n"; 
	$headers .= "Return-Path: ".$_POST["email"]."\r\n";
	$headers .= "Content-Type: Text/HTML\r\n";
	
	$msg = "<font face=tahoma color=black size=2>";
	$msg .= "<strong>".$_POST["nome"]."</strong> tem interesse em ser um dizimista, segue os dados abaixo!<br />";
	$msg .= "<strong>Data de Nascimento </strong>- ".$_POST["datanascimento"]."<br />";
	$msg .= "<strong>Endereço </strong>- ".$_POST["endereco"].", ".$_POST["numero"]." - ".$_POST["bairro"]." / ".$_POST["cidade"]." / ".$_POST["estado"]." / ".$_POST["cep"]." / ".$_POST["complemento"]."<br />";
	$msg .= "<strong>E-mail </strong>- ".$_POST["email"]."<br />";
	$msg .= "<strong>Telefone </strong>- ".$_POST["telefone"]."<br /><br /><br />";
	$msg .= date("d/m/Y - H:i:s")."<br />";
	$msg .= "</font>";

	$envio = mail("comunicacao@santuarioscj.com.br", $ass, $msg, $headers);

	if($envio)
		echo "<script>javascript:ok('Mensagem enviada com sucesso','./seja-dizimista')</script>";
	else
		echo "<script>javascript:error('Erro! Por Favor tente novamente','./seja-dizimista')</script>";
}
?>
<script type="text/javascript" language="javascript" src="js/jquery.maskedinput-1.2.2.js"></script>
<script>
	$(function(){
		$("#datanascimento").mask("99/99/9999");
		$("#cep").mask("99999-999");
	});
</script>
<link rel="stylesheet" type="text/css" href="css/contato.css" />
<div class="paginas">
	<div class="util">
		<div class="area_contato">
			<div class="intro3">SEJA UM DIZIMISTA</div>
			<p>No Santuário, o dízimo é ofertado pelo "Envelope do Dízimo". Caso você ainda não tenha o seu, retire na Secretaria, Plantão do Dízimo (missas do segundo domingo de cada mês) ou solicite pelo formulário abaixo.<br /><br />Com o envelope, você poderá ofertar o dízimo em qualquer missa no Santuário ou diretamente na Secretaria. Após a contabilização, o envelope será devolvido em seu endereço, permitindo que você faça nova oferta no mês seguinte.<br /><br />Preencha as informações abaixo com seus dados e receba o Envelope do Dízimo em seu endereço:</p>
			<form name="contatos" id="contatos" action="./?pg=dizimo" method="post">
				<div class="area-formulario" style="height:800px;">
					<p>Nome Completo</p>
					<p><input type="text" name="nome" id="nome" class="obrigatorio" /></p>
					<p>Data de Nascimento</p>
					<p><input type="text" name="datanascimento" id="datanascimento" class="obrigatorio" /></p>
					<p>Endereço</p>
					<p><input type="text" name="endereco" id="endereco" class="obrigatorio" /></p>
					<p>Número</p>
					<p><input type="text" name="numero" id="numero" class="obrigatorio" /></p>
					<p>Complemento (bloco, apartamento, casa)</p>
					<p><input type="text" name="complemento" id="complemento" class="obrigatorio" /></p>
					<p>Bairro</p>
					<p><input type="text" name="bairro" id="bairro" class="obrigatorio" /></p>
					<p>Cidade</p>
					<p><input type="text" name="cidade" id="cidade" class="obrigatorio" /></p>
					<p>Estado</p>
					<p><input type="text" name="estado" id="estado" class="obrigatorio" /></p>
					<p>CEP</p>
					<p><input type="text" name="cep" id="cep" class="obrigatorio" /></p>
					<p>Telefone</p>
					<p><input type="text" name="telefone" id="telefone" class="obrigatorio" /></p>
					<p>E-mail</p>
					<p><input type="text" name="email" id="email" class="obrigatorio" /></p>
					<input type="hidden" name="valida" id="valida" value="enviar" />
					<p><input name="cadastrar" type="button" onclick="validaform(form.id);" style="top:1400px; margin-left:410px;" id="cadastrar" class="btc" value="ENVIAR" /></p>
				</div>
			</form>
		</div>
	</div>
	<div style="height: 80px; width: 100%;">&nbsp;</div>
	<div class="clear"></div>
</div>