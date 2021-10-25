<?php
if(getenv("REQUEST_METHOD") == "POST"){
	require("_conectaBanco.php");
	$email = isset($_POST["email"]) ? limpa($_POST["email"]) : FALSE;
	$senha = isset($_POST["senha"]) ? limpa(md5($_POST["senha"])) : FALSE;
	if(!$email || !$senha) {
		echo "<script>javascript:error('Informe seu e-mail e senha','../login')</script>";
		exit;
	}
	if ( get_magic_quotes_gpc() ){
		$email = stripslashes($email);
	}
	$email = mysql_real_escape_string($email);
	$result_id = @mysql_query("SELECT * FROM usuarios WHERE email = '".$email."' AND senha = '".$senha."' AND status='S'") or die("Erro no banco de dados!");
	$total = @mysql_num_rows($result_id);
	if($total) {
		$dados = @mysql_fetch_array($result_id);
		if(!strcmp($senha, $dados["senha"])) {
			$_SESSION["id_usuario"]   			= $dados["id"];
			$_SESSION["nome_usuario"]    		= $dados["nome"];
			$_SESSION["email_usuario"]    		= $dados["email"];
			$_SESSION["nivel_usuario"]   		= $dados["nivel"];
			$_SESSION["sexo_usuario"]    		= $dados["sexo"];
			$_SESSION["logomarca_usuario"] 		= $dados["logomarca"];
			$_SESSION["uacesso_usuario"] 		= stripslashes($dados["uacesso"]);
			
			mysql_query("UPDATE usuarios SET uacesso ='".date("d/m/Y - H:i:s")."', time ='".time()."' WHERE id='".$dados["id"]."'");

			echo "<script>javascript:ok('Carregando painel, aguarde','?pg=config/meuPainel')</script>";
		} else {
			echo "<script>javascript:error('Dados incorretos','../login')</script>";
		}
	} else {
		echo "<script>javascript:error('Dados incorretos','../login')</script>";
	}
}
?>