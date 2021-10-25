<?php
include("../../../config/_conectaBanco.php");	
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	$Nome = $_FILES['Filedata']['name'];

	$Destino = '../../../../img/empresa/';
	
	if(!file_exists($Destino)){
		mkdir($Destino);
	}
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $Nome, $ext);		
	$Caminho = $Destino.time()."-".strrev(date("dmYHis"))."-".strtotime(date("d-m-Y"))."-".uniqid(time()).".".$ext[1];
	move_uploaded_file($tempFile,$Caminho);

	$img = substr("$Caminho", 12, 512);
	$insereprodutos = mysql_query("INSERT INTO fotos_empresa (foto) VALUES ('".$img."')");
	echo "1";
}
?>