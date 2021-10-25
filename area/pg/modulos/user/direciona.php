<?php
if(!isset($_SESSION['id_usuario'])) {
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']!='1'){
		header("Location: ?pg=inicial");
	}
}

echo "<table width='1200' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr>";
echo "<td colspan='3' height='60'>&nbsp;</td>";
echo "</tr>";
echo "<tr>";
echo "<td width='10%'>&nbsp;</td>";
echo "<td width='80%' align='center' class='t20'>O que você deseja fazer?</td>";
echo "<td width='10%' align='center'><a href='?pg=config/meuPainel'><img src='img/icones/voltar.png' width='32' height='32' alt='Painel de Controle' /></a></td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='3' align='center' valign='middle' height='350'>";

echo "<table width='90%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr>";
echo "<td width='50%' height='190' align='center'><br /><a href='?pg=modulos/user/user' class='hover3' style='text-decoration:none;'><img src='img/icones/add.png' width='64' height='64' alt='' title='Novo Usuário'><br />Novo Usuário</a><br /><br /></td>";
echo "<td width='50%' height='190' align='center'><br /><a href='?pg=modulos/user/lista' class='hover3' style='text-decoration:none;'><img src='img/icones/lista.png' width='64' height='64' alt='' title='Listar Cadastrados'><br />Listar Cadastrados</a><br /><br /></td>";
echo "</tr>";
echo "</table>";

echo "</td>";
echo "</tr>";
echo "</table>";
?> 