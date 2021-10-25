<?php if(isset($_SESSION['id_usuario'])){header("Location: ./?pg=config/meuPainel");} ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#email').focus();
		//$('#email, #senha').attr('autocomplete','off');
        $('#senha').keypress(function(e) {
            if (e.which == 13) {
                $('#acesso').submit();
            }
        });
	});
</script>
<div class="controle">
    <h3>Área Restrita</h3>
    <div class="linha">&nbsp;</div>
    <form id="acesso" name="acesso" action="./?pg=config/_liberaAcesso" method="post">
        <div class="campo"><span>E-mail</span><input type="text" class="obrigatorio" name="email" id="email" style="width:300px;" /></div>
        <div class="campo"><span>Senha</span><input type="password" class="obrigatorio" name="senha" id="senha" style="width:300px;" /></div>
        <div class="botao"><input type="hidden" name="valida" value="enviar" /><input type="button" onclick="validaform(form.id);" name="enviar" value="Enviar" /></div>
    </form>
</div>