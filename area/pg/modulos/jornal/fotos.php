<?php 
    if(!isset($_GET['id'])) {
        header("Location: ?pg=modulos/jornal/novo");
        exit;
    }
        
    $id_album = $_GET['id'];
    settype($id_album, 'integer');
    
    $q_infos = mysql_query("SELECT titulo FROM jornal WHERE id = ".$id_album);
    
    if(mysql_num_rows($q_infos) == 0) {
        header("Location: ?pg=modulos/jornal/novo");
        exit;
    }
    
    $titulo_jornal = mysql_result($q_infos, 0, 'titulo');
?>
<link rel="stylesheet" href="pg/modulos/jornal/css/albumfotos.css" />
<link rel="stylesheet" href="css/jquery-ui-1.8.24.custom.css" />

<script type="text/javascript" src="js/jquery-ui-1.8.24.custom.min.js"></script>
<script type="text/javascript" src="pg/modulos/jornal/js/fotos.js"></script>

<div class="form_painel">
    
    <table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th scope="col" width="10%">&nbsp;</th>
            <th scope="col" width="80%" class="t20" align="center" valign="middle">Paginas de <?php echo $titulo_jornal; ?></th>
            <th scope="col" width="10%" align="right"><a href='?pg=modulos/jornal/novo'><img src='img/icones/voltar.png' width='32' height='32' alt='Gerenciador de Albuns' /></a></th>
        </tr>
    </table>
    
    <div class="botoes">
        <a onClick="PopUpCentralizado('pg/modulos/jornal/foto_adiciona.php?id_a=<?php echo $id_album; ?>', 'dlx', '417', '390', 'no');" style='cursor: pointer;'>Adicionar Fotos</a>
        <a onclick="removeFotos();" class="rem" style="cursor:pointer;">Remover Seleção</a>
    </div>
    
    <div id="lista_holder">
        
        <?php 
            $query = mysql_query("SELECT * FROM jornal_fotos WHERE id_jornal = ".$id_album." ORDER BY id_o ASC");
            
            if(mysql_num_rows($query) > 0):
        ?>        
        
            <ul class="lista_fotos">

                <?php while($item = mysql_fetch_array($query)): ?>
                    <li id="fto<?php echo $item['id']?>" class="li_foto">
                        <div class="foto-box">
                            <div class="foto-photo">
                                <img src="<?php echo $item["foto"]?>" alt="<?php echo $item["descricao"]?>" title="<?php echo $item["descricao"]?>" width="200" height="200"/>
                                <input type="checkbox" name="ck_del[]" value="<?php echo $item["id"]?>"  class="rd-capa" onclick="attdelFts();" />
                            </div>
                            <div class="foto-config">
                                <div class="foto-config-buttons">
                                    <a href="javascript:editFoto(<?php echo $item["id"]?>);"><img class="album-config-ico" src="img/icones/editar.png" title="Editar Descrição" /></a>
                                    <a href="javascript:removeFoto(<?php echo $item["id"]?>);"><img class="album-config-ico" src="img/icones/deletar.png" title="Deletar Foto" /></a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
                
                <div class="clear"></div>
            </ul>
                               
        <?php endif; ?>
        
    </div>
    
</div>