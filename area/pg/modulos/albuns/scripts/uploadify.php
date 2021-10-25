<?php
include("../../../config/_conectaBanco.php");	
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	$Nome = $_FILES['Filedata']['name'];

    $id_album = $_GET['id_a'];
    settype($id_album, 'integer');

	$Destino = '../../../../img/albuns/'.$id_album.'/';
	
	if(!file_exists($Destino)){
		mkdir($Destino);
	}
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $Nome, $ext);		
	$Caminho = $Destino.uniqid(time()).".".$ext[1];
	move_uploaded_file($tempFile,$Caminho);

	$img = substr("$Caminho", 12, 512);
    
    //$maximo = mysql_result(mysql_query("SELECT COALESCE(MAX(id_o),0)+1 as maximo FROM fotos_biografia"),0,'maximo');
	$insereprodutos = mysql_query("INSERT INTO album_fotos (id_album, foto) VALUES ($id_album, '".$img."')");
    
	echo "1";
}
?>