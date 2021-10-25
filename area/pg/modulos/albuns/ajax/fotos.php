<?php 

    require "../../../config/_conectaBanco.php";
    
    session_start();
    
    if(!isset($_SESSION['nome_usuario'])) {        
        die("Acesso restrito.");
    }
    
        
    
    if(isset($_POST['acao'])) {
        $acao   = $_POST['acao'];
        $id     = (isset($_POST['id'])) ? $_POST['id'] : false ;
        $tp     = (isset($_POST['tp'])) ? $_POST['tp'] : false ;
        $desc   = (isset($_POST['descricao'])) ? addslashes($_POST['descricao']) : "" ;
        
        $retorno = NULL;
        
        switch($acao) {          
            case 'upd':
                $retorno = atualizaFoto($id, $desc);
                echo json_encode($retorno);
                break;
            case 'del':
                $retorno = deletaFoto($id);
                echo json_encode($retorno);
                break;
            case 'del_v':
                $retorno = deletaFotos($id);
                echo json_encode($retorno);
                break;
            case 'lista':
                listaFotos($id);
                break;
            case 'content':
                imprimeConteudo($tp, $id); //$tp = 1 - BOTOES | 2 - FORM
                break;
        }
    }
    
    function atualizaFoto($id, $desc) {
        $result = "UPDATE album_fotos SET descricao = '". $desc ."' WHERE id = ". $id;
        
        $retorno = array("id" => $id);
        
        if(mysql_query($result)) {
            $retorno["status"] = 1;
        } else {
            $retorno["status"] = 0;
            $retorno["errmsg"] = mysql_error();
        }
        
        return $retorno;
    }
    
    function deletaFoto($id) {
        $retorno = array("status" => 1);
            
        $query = "SELECT foto FROM album_fotos WHERE id = ".$id;
        
        $result  = mysql_query($query); 
        $caminho = mysql_result($result, 0, "foto");
        
        unlink("../../../../".$caminho);
        
        $query = "DELETE FROM album_fotos WHERE id = ".$id;
        
        if(!mysql_query($query)){
            $retorno["status"] = 0;
            $retorno["errmsg"] = mysql_error();
        }
        
        return $retorno;
    }
    
    function deletaFotos($id) {
        $retorno = array("status" => 1, "itens" => explode('###',$id));
        
        foreach($retorno['itens'] as $item) {
            $query = "SELECT foto FROM album_fotos WHERE id = ".$item;
        
            $result  = mysql_query($query); 
            if(mysql_num_rows($result) > 0) {
                $caminho = mysql_result($result, 0, "foto");
                
                unlink("../../../../".$caminho);
                
                $query = "DELETE FROM album_fotos WHERE id = ".$item;
                mysql_query($query);   
            }
        }
        
        return $retorno;
    } 
    
    function imprimeConteudo($tp, $id) {
        if($tp == 1) {
            echo "<div class=\"foto-config-buttons\">";
            echo    "<a href=\"javascript:editFoto(". $id .");\"><img class=\"album-config-ico\" src=\"img/icones/editar.png\" title=\"Editar Descrição\" /></a>";
            echo    "<a href=\"javascript:removeFoto(". $id .");\"><img class=\"album-config-ico\" src=\"img/icones/deletar.png\" title=\"Deletar Foto\" /></a>";
            echo "</div>";
        } else if($tp == 2) {
            $result = mysql_query("SELECT coalesce(descricao, '') as descricao FROM album_fotos WHERE id =". $id);          
            $desc   = mysql_result($result, 0, "descricao");            
            
            echo "<div class=\"foto-config-form\">";
            echo    "<form id=\"f_album". $id ."\" method=\"post\" class=\"f_album\" action=\"javascript:void(0);\">";
            echo        "<input name=\"id\"   type=\"hidden\" value=\"". $id ."\" />";
            echo        "<input name=\"acao\" type=\"hidden\" value=\"upd\" />";
            echo        "<input name=\"descricao\" class=\"campo-texto\" value=\"". $desc ."\" style=\"width: 175px; margin-bottom: 10px;\" />";
            echo        "<input type=\"submit\" value=\"OK\" id=\"bt_o_alb". $id ."\" class=\"botao-album-ok\" />";
            echo        "<input type=\"button\" value=\"Cancelar\" id=\"bt_c_alb". $id ."\" class=\"botao-album\" />";
            echo    "</form>";
            echo "</div>";
        }
    }

    