<?php
//Consulta as música no banco de dados
$sql = mysql_query("SELECT * FROM player WHERE status='S' ORDER BY nome");
//Total de linhas
$row = mysql_num_rows($sql);
//VERIFICA SE A PESQUISA RETORNOU ALGUMA LINHA
if($row > 0){
	//arquivo
	$arquivo = "flash/musicas.xml";
	//ABRE O ARQUIVO(SE NÃO EXISTIR, CRIA)
	$ponteiro = fopen($arquivo, "w");
	//ESCREVE NO ARQUIVO XML
	fwrite($ponteiro, "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
	fwrite($ponteiro, "<playlist>\n");
	//Faz o loop
	for($i=0; $i<$row; $i++){
		//PEGA OS DADOS DO SQL
        $id = mysql_result($sql,$i,"id");
        $nome = mysql_result($sql,$i,"nome");
        $musica= mysql_result($sql,$i,"urlm");
		
		//MONTA AS TAGS DO XML
		/*$conteudo = "<song>\n";
		$conteudo .= "<title>$nome</title>\n";
		$conteudo .= "<url>$musica</url>\n";
		$conteudo .= "</song>\n";*/
		
		$conteudo  = "<musica url=\"../$musica\">\n";
		$conteudo .= "<dj>$nome</dj>\n";
		$conteudo .= "</musica>\n";
		
		//ESCREVE NO ARQUIVO
		fwrite($ponteiro, $conteudo);
    }
	//FECHA FOR
	//FECHA A TAG AGENDA
	fwrite($ponteiro, "</playlist>\n");
	//FECHA O ARQUIVO
	fclose($ponteiro);
}
//FECHA IF($row)
?>