<?php
include("_conectaBanco.php");
$vo = mysql_query("SELECT * FROM usuarios WHERE time!='' AND nome!='' ORDER BY time DESC, nome ASC");
while($rw = mysql_fetch_object($vo)){
	echo '<p'; if($rw->time!=''){ echo ' class="on"'; } echo '>';
	if($rw->time!=''){ $contexto = 'Logado desde'; echo '<img src="img/icones/online.png" width="16" height="16" alt="Usuário Online" title="Usuário Online" />'; } else { $contexto = 'Último login em'; echo '<img src="img/icones/offline.png" width="16" height="16" alt="Usuário Offline" title="Usuário Offline" />'; }
	echo '<strong>'.$rw->nome.'</strong> - '.$contexto.' <strong>'.$rw->uacesso.'</strong></p>';
}
?>