<?php

    if(isset($_POST['acao'])) {
        $acao =  trim($_POST['acao']);
        
        include_once '_conectaBanco.php';
        
        if($acao === 'bio' && isset($_POST['dados'])) {
            $dados = json_decode(stripslashes($_POST['dados']));
        
            foreach($dados as $imagem) {
                $query = "UPDATE fotos_produtos SET id_o = ".$imagem->{"seq"}." WHERE id_p = '".trim($_POST['produto'])."' AND id = ".$imagem->{"codimg"};
                mysql_query($query);
            }
            
            exit;
        }
    }
