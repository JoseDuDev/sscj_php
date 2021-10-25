<?php
error_reporting(0);
//$conexao = mysql_connect("localhost", "scj_novo", "libes2013");
$conexao = mysql_connect("localhost:3306", "root", "");
mysql_select_db("scj_novo",$conexao);
mysql_set_charset("utf8", $conexao);