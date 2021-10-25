<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adicionar Fotos</title>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link href="css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="scripts/swfobject.js"></script>
<script type="text/javascript" src="scripts/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader'       : 'scripts/uploadify.swf',
		'script'         : 'scripts/uploadify.php?idp=<?php echo $_GET["produto"]?>',
		'cancelImg'      : 'cancel.png',
		'folder'         : 'uploads',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true
	});
});
</script>
<script language="Javascript" type="text/Javascript">
<!--
function close_window() {
    window.close();
}
//-->
</script>
<style>
/* LINKS */
a:link{color:#21282b; text-decoration:none; font: bold 10px Tahoma, Verdana, Arial, Helvetica, sans-serif;}
a:visited{color:#21282b; text-decoration:none; font: bold 10px Tahoma, Verdana, Arial, Helvetica, sans-serif;}
a:hover{color:#21282b; text-decoration:underline; font: bold 10px Tahoma, Verdana, Arial, Helvetica, sans-serif;}
</style>
</head>

<body onUnload="window.opener.location.reload()">
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify" />
<p><a href="javascript:jQuery('#uploadify').uploadifyClearQueue()">Cancelar Todas</a> | <a href="javascript:;" onClick="close_window()">Fechar Janela</a>
</p>
</body>
</html>
