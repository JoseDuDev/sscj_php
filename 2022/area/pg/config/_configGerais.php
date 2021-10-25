<?php
//POPUP E AVISO
if(!isset($_SESSION['popup'])){ $_SESSION['popup']= 1; }

//SEGURANÇA
if(get_magic_quotes_runtime()){
	set_magic_quotes_runtime(0);
}

function remove_mq(&$var) {
	return is_array($var) ? array_map("remove_mq", $var) : stripslashes($var);
}

if (get_magic_quotes_gpc()) {
	$_GET    = array_map("remove_mq", $_GET);
	$_POST   = array_map("remove_mq", $_POST);
	$_COOKIE = array_map("remove_mq", $_COOKIE);
}

if (function_exists("ini_get")) {
	if(!ini_get("display_errors")){
		ini_set("display_errors", 1);
	}	
	if(ini_get("magic_quotes_sybase")){
		ini_set("magic_quotes_sybase", 0);
	}	
	if (ini_get("register_globals")) {
		foreach($GLOBALS as $s_variable_name => $m_variable_value) {
			if (!in_array($s_variable_name, array("GLOBALS", "argv", "argc", "_FILES", "_COOKIE", "_POST", "_GET", "_SERVER", "_ENV", "_SESSION", "s_variable_name", "m_variable_value"))){
				unset($GLOBALS[$s_variable_name]);
			}
		}
		unset($GLOBALS["s_variable_name"]);
		unset($GLOBALS["m_variable_value"]);
	}  
}

error_reporting(E_ALL);

//TRATA STRING DE REFERENCIA AO BANCO
function limpa($string){
	return addslashes(htmlentities(utf8_decode(trim($string))));
}

//TRATRAR STRING
function tratarStrings($string){
  return addslashes(htmlentities(utf8_decode(trim($string))));
}

//CORTAR PALAVRAS
function truncate($str, $len, $end='') {
  return substr($str, 0, strrpos(substr($str, 0, $len), ' ')) . $end;
}

//ESCREVE MÊS
function escreveMes($referencia = NULL){
    switch ($referencia){
        case 1: $mes = "Janeiro de "; break;
        case 2: $mes = "Fevereiro"; break;
        case 3: $mes = "Março"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Maio"; break;
        case 6: $mes = "Junho"; break;
        case 7: $mes = "Julho"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Setembro"; break;
        case 10: $mes = "Outubro"; break;
        case 11: $mes = "Novembro"; break;
        case 12: $mes = "Dezembro"; break;
        default: $mes = "";
    }
    return $mes;
}

//VARIÁVEIS PADRÃO
$row = find("gerais", 1);
$GLOBALS['config']["nome"]         = utf8_encode($row['nome']);
$GLOBALS['config']["url"]          = $row["url"];
$GLOBALS['config']["titulo"]       = utf8_encode($row["titulo"]);
$GLOBALS['config']["des"]          = utf8_encode($row["des"]);
$GLOBALS['config']["keyw"]         = utf8_encode($row["keyw"]);
$GLOBALS['config']["email"]        = $row["email"];
$GLOBALS['config']["mascara"]      = utf8_encode($row["mascara"]);
$GLOBALS['config']["telefone"]     = $row["telefone"];
$GLOBALS['config']["endereco"]     = utf8_encode($row["endereco"]);
$GLOBALS['config']["facebook"]     = $row["facebook"];
$GLOBALS['config']["twitter"]      = $row["twitter"];
$GLOBALS['config']["linkedin"]     = $row["linkedin"];
$GLOBALS['config']["googlem"]      = $row["flickr"];
$GLOBALS['config']["youtube"]      = $row["youtube"];
$GLOBALS['config']["atende"]       = utf8_encode($row["atende"]);
$GLOBALS['config']["razao"]         = $row["razao"];
$GLOBALS['config']["cnpj"]         = $row["cnpj"];
$GLOBALS['config']["msg1"]         = utf8_encode($row["msg"]);
$GLOBALS['config']["msg2"]         = utf8_encode($row["msg1"]);
$GLOBALS['config']["msg3"]         = utf8_encode($row["msg2"]);
$GLOBALS['config']["msg4"]         = utf8_encode($row["msg3"]);
$GLOBALS['config']["msg5"]         = utf8_encode($row["msg4"]);

//ARQUIVOS PERMITIDOS
$permitidos = array('pg/home.php',
                    'pg/empresa.php',
                    'pg/dehonianos.php',
                    'pg/espiritualidade.php',
                    'pg/programas.php',
                    'pg/sacerdotes.php',
                    'pg/contato.php',
                    'pg/noticias.php',
                    'pg/historico.php',
                    'pg/artigos.php',
                    'pg/pedidos.php',
                    'pg/intencao.php',
                    'pg/horarios.php',
                    'pg/fotos.php',
                    'pg/agenda.php',
                    'pg/liturgia.php',
                    'pg/santos.php',
                    'pg/dizimo.php',
                    'pg/localizacao.php',
                    'pg/comunidades.php',
                    'pg/busca.php',
                    'pg/resultado.php',
                    'pg/pastorais.php',
                    'pg/jornalonline.php',
                    'pg/modulos/agenda/novo.php',
                    'pg/modulos/aviso/novo.php',
                    'pg/modulos/horarios/novo.php',
                    'pg/modulos/jornal/novo.php',
                    'pg/modulos/jornal/fotos.php',
                    'pg/modulos/parceiros/novo.php',
                    'pg/modulos/pastorais/novo.php',
                    'pg/modulos/pastorais/maisfotos.php',
                    'pg/modulos/comunidades/novo.php',
                    'pg/modulos/comunidades/noticias.php',
                    'pg/modulos/comunidades/horarios.php',
                    'pg/modulos/banner/novo.php',
                    'pg/modulos/banner/direciona.php',
                    'pg/modulos/conheca/sobre.php',
                    'pg/modulos/conheca/dehonianos.php',
                    'pg/modulos/conheca/sacerdotes.php',
                    'pg/modulos/conheca/espiritualidade.php',
                    'pg/modulos/conheca/programas.php',
                    'pg/modulos/conheca/radio.php',
                    'pg/modulos/artigos/novo.php',
                    'pg/modulos/albuns/novo.php',
                    'pg/modulos/albuns/fotos.php',
                    'pg/modulos/noticias/novo.php',
                    'pg/modulos/noticias/direciona.php',
                    'pg/modulos/noticias/categoria.php',
                    'pg/modulos/videos/novo.php',
                    'pg/modulos/informacoes/novo.php',
                    'pg/modulos/popup/novo.php',
                    'pg/modulos/news/envio.php',
                    'pg/modulos/news/direciona.php',
                    'pg/modulos/news/grupos.php',
                    'pg/config/_liberaAcesso.php',
                    'pg/config/configPadrao.php',
                    'pg/config/contato.php',
                    'pg/config/interatividade.php',
                    'pg/config/meuPainel.php',
                    'pg/config/_deslogaSistema.php',
                    'pg/modulos/user/direciona.php',
                    'pg/modulos/user/user.php',
                    'pg/modulos/user/lista.php',
                    'pg/modulos/user/visualizar.php',
                    'pg/deslogaSistema.php'
                    );

if(isset($_GET['pg'])){ $inc = $_GET['pg']; } else { $inc='home'; }

//SOMAR DATA
function addData($di,$dias,$tipo){
	$dt = explode("/", $di);
	$dataFinal = mktime(24*$dias, 0, 0, $dt[1], $dt[0], $dt[2]);
	if($tipo==1){ $dataFormatada = date('Y-m-d',$dataFinal); } else if($tipo==2){ $dataFormatada = date('d/m/Y',$dataFinal); }
	return $dataFormatada;
}

/* TOTAL DIAS DO MÊS */
function diasMes($month, $year) {
    return date('t', mktime(0, 0, 0, $month+1, 0, $year));
}

//IDADE APARTIR DE UMA DATA
function vIdade($data){
	list($dia, $mes, $ano) = explode('/', $data);
	$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
	$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
	if($idade>1){ $complemento = ' anos'; } else { echo ' ano'; }
	return $idade.$complemento;
}

//CONVERTE DATA
function mudaData($data,$extrai,$substitui){
	$part = explode($extrai, $data);
	$novadata = $part[2].$substitui.$part[1].$substitui.$part[0];
	return $novadata;
}

function diaSemana($data){
    $dia =  substr($data,0,2);
    $mes =  substr($data,3,2);
    $ano =  substr($data,6,9);
    $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
    return "$diasemana";
}

//REMOVE CARACTERES
class Dlx_Tools_SpecialChar {
    
    private function seems_utf8($Str) { 
        for ($i=0; $i<strlen($Str); $i++) {
            if (ord($Str[$i]) < 0x80) continue; # 0bbbbbbb
            elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
            elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
            elseif ((ord($Str[$i]) & 0xF8) == 0xF0) $n=3; # 11110bbb
            elseif ((ord($Str[$i]) & 0xFC) == 0xF8) $n=4; # 111110bb
            elseif ((ord($Str[$i]) & 0xFE) == 0xFC) $n=5; # 1111110b
            else return false; # Does not match any model
            for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
                if ((++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80))
                return false;
            }
        }
        return true;
    }
    
    public function remove_accents($string) {
        if ($this->seems_utf8($string)) {
            $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
            chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
            chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
            chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
            chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
            chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
            chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
            chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
            chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
            chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
            chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
            chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
            chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
            chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
            chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
            chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
            chr(195).chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
            chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
            chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
            chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
            chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
            chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
            chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
            chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
            // Euro Sign
            chr(226).chr(130).chr(172) => 'E');
    
            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
                .chr(252).chr(253).chr(255);
    
            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
    
            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }
        
        $string = str_replace(" ", "-", trim($string));
        $string = str_replace(",", "-", trim($string));
        $string = str_replace("(", "-", trim($string));
        $string = str_replace(")", "-", trim($string));
        $string = str_replace(".", "-", trim($string));
        $string = str_replace("/", "-", trim($string));
        $string = str_replace("|", "-", trim($string));
        $string = str_replace("!", "-", trim($string));
        $string = str_replace("+", "-", trim($string));
        $string = str_replace("'", "-", trim($string));
        $string = str_replace("ª", "-", trim($string));
        $string = str_replace("º", "-", trim($string));
        $string = str_replace("\"", "-", trim($string));
        $string = str_replace("@", "-", trim($string));
        $string = str_replace("?", "-", trim($string));
        $string = str_replace("--", "-", trim($string));
        $string = str_replace(":", "-", trim($string));
        $string = str_replace("---", "-", trim($string));

        return strtolower($string);
    }    
}
if($inc=='noticias' && isset($_GET['url']) && !isset($_GET['local'])){
    $vn = mysql_query("SELECT * FROM noticias WHERE url_check='".addslashes($_GET['noticia'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->titulo.' - Notícias - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'area/'.$ln->imagem;
    $_SESSION['descri_atual'] = $ln->titulo.' - Notícias - '.$GLOBALS['config']['des'];
} else if($inc=='noticias' && isset($_GET['url']) && isset($_GET['local'])){
    $apiarcanjo = file_get_contents('https://www.agenciaarcanjo.com.br/api.php?tipo=noticia&id='.$_GET['noticia']);
    $dados = json_decode($apiarcanjo);
    $_SESSION['titulo_atual'] = $dados->titulo.' - Notícias - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'https://www.agenciaarcanjo.com.br/'.$dados->imagem;
    $_SESSION['descri_atual'] = $dados->introducao.' - Notícias - '.$GLOBALS['config']['des'];
} else if($inc=='noticias' && isset($_GET['area'])){
    $vn = mysql_query("SELECT * FROM noticias WHERE url_check='".addslashes($_GET['noticia'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->titulo.' - Comunidades - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'area/'.$ln->imagem;
    $_SESSION['descri_atual'] = $ln->titulo.' - Comunidades - '.$GLOBALS['config']['des'];
} else if($inc=='historico' && !isset($_GET['area'])){
    $vn = mysql_query("SELECT nome FROM categoria WHERE urlcheck='".addslashes($_GET['url'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->nome.' - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = $ln->nome.' - '.$GLOBALS['config']['des'];
} else if($inc=='historico' && isset($_GET['area'])){
    $vn = mysql_query("SELECT titulo FROM comunidades WHERE urlcheck='".addslashes($_GET['area'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->titulo.' - Comunidades - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = $ln->titulo.' - Comunidades - '.$GLOBALS['config']['des'];
} else if($inc=='artigos' && isset($_GET['noticia'])){
    $vn = mysql_query("SELECT * FROM artigos WHERE url_check='".addslashes($_GET['noticia'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->titulo.' - Artigos - '.$GLOBALS['config']['titulo'];
    if($ln->imagem!=''){
        $_SESSION['imagem_atual'] = 'area/'.$ln->imagem;
    } else {
        $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    }
    $_SESSION['descri_atual'] = $ln->titulo.' - Artigos - '.$GLOBALS['config']['des'];
} else if($inc=='artigos' && !isset($_GET['noticia'])){
    $_SESSION['titulo_atual'] = 'Artigos - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Artigos - '.$GLOBALS['config']['des'];
} else if($inc=='agenda' && isset($_GET['noticia'])){
    $vn = mysql_query("SELECT * FROM agenda WHERE urlcheck='".addslashes($_GET['noticia'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->nome.' - Agenda - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = $ln->nome.' - Agenda - '.$GLOBALS['config']['des'];
} else if($inc=='agenda' && !isset($_GET['noticia'])){
    $_SESSION['titulo_atual'] = 'Agenda - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Agenda - '.$GLOBALS['config']['des'];
} else if($inc=='fotos' && isset($_GET['album'])){
    $vn = mysql_query("SELECT * FROM album WHERE urlcheck='".addslashes($_GET['album'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->festa.' - Galeria de Fotos - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = $ln->festa.' - Galeria de Fotos - '.$GLOBALS['config']['des'];
} else if($inc=='fotos' && !isset($_GET['album'])){
    $_SESSION['titulo_atual'] = 'Galeria de Fotos - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Galeria de Fotos - '.$GLOBALS['config']['des'];
} else if($inc=='empresa'){
    $_SESSION['titulo_atual'] = 'Nossa História - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Nossa História - '.$GLOBALS['config']['des'];
} else if($inc=='dehonianos'){
    $_SESSION['titulo_atual'] = 'Dehonianos - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Dehonianos - '.$GLOBALS['config']['des'];
} else if($inc=='sacerdotes'){
    $_SESSION['titulo_atual'] = 'Sacerdotes - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Sacerdotes - '.$GLOBALS['config']['des'];
} else if($inc=='espiritualidade'){
    $_SESSION['titulo_atual'] = 'Espiritualidade - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Espiritualidade - '.$GLOBALS['config']['des'];
} else if($inc=='programas'){
    $_SESSION['titulo_atual'] = 'Programas de Rádio - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Programas de Rádio - '.$GLOBALS['config']['des'];
} else if($inc=='contato'){
    $_SESSION['titulo_atual'] = 'Contato - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Contato - '.$GLOBALS['config']['des'];
} else if($inc=='videos'){
    $_SESSION['titulo_atual'] = 'Vídeos - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Vídeos - '.$GLOBALS['config']['des'];
} else if($inc=='localizacao'){
    $_SESSION['titulo_atual'] = 'Localização - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Localização - '.$GLOBALS['config']['des'];
} else if($inc=='liturgia'){
    $_SESSION['titulo_atual'] = 'Liturgia Diária - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Liturgia Diária - '.$GLOBALS['config']['des'];
} else if($inc=='santos'){
    $_SESSION['titulo_atual'] = 'Santo do dia - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Santo do dia - '.$GLOBALS['config']['des'];
} else if($inc=='intencao'){
    $_SESSION['titulo_atual'] = 'Intenções para a Santa Missa - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Intenções para a Santa Missa - '.$GLOBALS['config']['des'];
} else if($inc=='pedidos'){
    $_SESSION['titulo_atual'] = 'Pedidos de Oração - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Pedidos de Oração - '.$GLOBALS['config']['des'];
} else if($inc=='jornalonline'){
    $_SESSION['titulo_atual'] = 'Jornal Online - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Jornal Online - '.$GLOBALS['config']['des'];
} else if($inc=='pastorais' && !isset($_GET['url'])){
    $_SESSION['titulo_atual'] = 'Pastorais - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Pastorais - '.$GLOBALS['config']['des'];
} else if($inc=='pastorais' && isset($_GET['url'])){
    $vn = mysql_query("SELECT * FROM pastorais WHERE urlcheck='".addslashes($_GET['url'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->titulo.' - Pastorais - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = $ln->titulo.' - Pastorais - '.$GLOBALS['config']['des'];
} else if($inc=='comunidades' && !isset($_GET['url'])){
    $_SESSION['titulo_atual'] = 'Comunidades - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = 'Comunidades - '.$GLOBALS['config']['des'];
} else if($inc=='comunidades' && isset($_GET['url'])){
    $vn = mysql_query("SELECT * FROM comunidades WHERE urlcheck='".addslashes($_GET['url'])."'");
    $ln = mysql_fetch_object($vn);
    $_SESSION['titulo_atual'] = $ln->titulo.' - Comunidades - '.$GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = $ln->titulo.' - Comunidades - '.$GLOBALS['config']['des'];
} else {
    $_SESSION['titulo_atual'] = $GLOBALS['config']['titulo'];
    $_SESSION['imagem_atual'] = 'assets/img/logomarca-padrao-scj.jpg';
    $_SESSION['descri_atual'] = $GLOBALS['config']['des'];
}
?>