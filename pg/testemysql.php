<?php
$step = $_GET['step'];
if (!$step) {
	$page_title = 'Formulario';
}
else{
	$page_title = 'Teste MySQL - Passo '.$step;
}
############## Inicio das funções ##############################
# Função que testa os campos Usuario, Senha e Host
function db_connect($server, $username, $password, $link = 'db_link') {
	global $$link, $db_error;
	$db_error = false;
	if (!$server) {
		$db_error = 'Sem servidor selecionado';
		return false;
	}
	$$link = @mysql_connect($server, $username, $password) or $db_error = mysql_error();
	return $$link;
}
# Função que seleciona a base de dados
function db_select_db($database) {
	echo mysql_error();
	return mysql_select_db($database);
}
# Função que testa o acesso a base de dados
function db_test_create_db_permission($database) {
	global $db_error;
	$db_created = false;
	$db_error = false;
	if (!$database) {
		$db_error = 'Sem Base de Dados selecionada';
		return false;
	}
	if ($db_error) {
		return false;
	} else {
		if (!@db_select_db($database)) {
			$db_error = mysql_error();
			return false;
		}else {
			return true;
		}
	return true;
	}
}

function step1 ($error) {
	echo '<h1 style="color:#FF0000">'.$error.'</h1><hr>';
?>
<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>?step=2">
<table border="0" cellspacing="5" cellpadding="5">
<tr>
<td><div align="right">Servido MySQL:</div></td>
<td><input name="server" type="text" value="<?php echo $_REQUEST['server']; ?>"> 
(endere&ccedil;o do Servidor MySQL - mysql.dominio.extens&atilde;o)</td>
</tr>
<tr>
<td><div align="right">Usuario:</div></td>
<td><input type="text" name="username" value="<?php echo $_REQUEST['username']; ?>"></td>
</tr>
<tr>
<td><div align="right">Senha:</div></td>
<td><input type="text" name="password" value="<?php echo $_REQUEST['password']; ?>"></td>
</tr>
<tr>
<td><div align="right">Base de Dados:</div></td>
<td><input type="text" name="database" value="<?php echo $_REQUEST['database']; ?>"></td>
</tr>
<tr>
<td colspan="2"><input type="submit" name="Submit" value="Enviar"></td>
</tr>
</table>
</form>
<?php
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>MYSQL TESTE - <?php echo $page_title; ?></title> 
</head>
<body>
<h1><?php echo $page_title; ?></h1>
<?php
############## Fim das Funções ##############################
switch ($step) {
	case '2':
		if ($_REQUEST['server']) {
				$db = array();
				$db['DB_SERVER'] = trim(stripslashes($_REQUEST['server']));
				$db['DB_SERVER_USERNAME'] = trim(stripslashes($_REQUEST['username']));
				$db['DB_SERVER_PASSWORD'] = trim(stripslashes($_REQUEST['password']));
				$db['DB_DATABASE'] = trim(stripslashes($_REQUEST['database']));
				$db_error = false;
				db_connect($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);
				if ($db_error == false) {
					if (!db_test_create_db_permission($db['DB_DATABASE'])) {
						$error = $db_error;
					}
				} else {
					$error = $db_error;
				}
				if ($db_error != false) {
					$error = "failed";
					echo step1($db_error);
				} else {
					echo '<h1 style="color:green">Parabens!</h1>
					<p>Conectado ao Banco de Dados </p>';
				}
		} else {
			$error = "ERRO: Informe o servidor MySQL";
			echo step1($error);
		}
	break;

	default:
	echo step1('Passo 1');
	break;
}
?>
</body>
</html>