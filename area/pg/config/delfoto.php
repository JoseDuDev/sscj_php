<?php
include("_conectaBanco.php");
$dv = explode("###",$_POST['itens']);
for($i=0; $i<count($dv); $i++){
	if(!empty($dv[$i])){
		$vr = mysql_fetch_object(mysql_query("SELECT foto FROM fotos_empresa WHERE id='".$dv[$i]."'"));
		unlink('../../'.$vr->foto);
		mysql_query("DELETE FROM fotos_empresa WHERE id='".$dv[$i]."'");
	}
}

$vf = mysql_query("SELECT * FROM fotos_empresa ORDER BY id_o ASC");
if(mysql_num_rows($vf)>0){
	while($rw=mysql_fetch_object($vf)){
		echo '<li id="fto'.$rw->id.'">
			<div class="checkBdel"><input onclick="attdel();" class="fotose" name="deletar[]" type="checkbox" id="deleta" value="'.$rw->id.'"></div>
			<img src="'.$rw->foto.'" />
		</li>';
	}
	echo '<div class="clear"></div>';
} else {
	echo '<p style="padding-bottom: 30px; text-align:center;">Nenhuma foto até o momento...</p>';
}
?>