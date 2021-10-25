<?php
if(!isset($_SESSION['id_usuario'])) {
    header("Location: index.php?pg=home");
    exit;
} else {
    if($_SESSION['nivel_usuario']==2){
        header("Location: index.php?pg=home");
        exit;
    }
}  
if(!isset($_GET['id'])) {
    header("Location: ?pg=modulos/albuns/novo");
    exit;
}
    
$id_album = $_GET['id'];
settype($id_album, 'integer');

$q_infos = mysql_query("SELECT data_reg, festa FROM album WHERE id = ".$id_album);

if(mysql_num_rows($q_infos) == 0) {
    header("Location: ?pg=modulos/albuns/novo");
    exit;
}

list($data_a, $festa_a) = mysql_fetch_array($q_infos, MYSQL_NUM);
?>
<link rel="stylesheet" href="pg/modulos/albuns/css/albumfotos.css" />
<script type="text/javascript" src="pg/modulos/albuns/js/fotos.js"></script>
<div class="form_painel">
    
    <table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th scope="col" width="10%">&nbsp;</th>
            <th scope="col" width="80%" class="t20" align="center">Fotos</th>
            <th scope="col" width="10%" align="right"><a href='?pg=modulos/albuns/novo'><img src='img/icones/voltar.png' width='32' height='32' alt='Gerenciador de Albuns' /></a></th>
        </tr>
        <tr>
            <td scope="col" width="10%">&nbsp;</td>
            <td scope="col" width="80%" class="t14" align="center">(Album do dia: <?php echo implode("/",array_reverse(explode('-',$data_a))) . ' - ' . $festa_a; ?>)</td>
            <td scope="col" width="10%">&nbsp;</td>
        </tr>
    </table>
    
    <div class="botoes">
        <a onClick="PopUpCentralizado('pg/modulos/albuns/foto_adiciona.php?id_a=<?php echo $id_album; ?>', 'dlx', '417', '390', 'no');" style='cursor: pointer;'>Adicionar Fotos</a>
        <a onclick="removeFotos();" class="rem" style="cursor:pointer;">Remover Seleção</a>
    </div>
    
    <div id="lista_holder">
        
        <?php 
            $query = mysql_query("SELECT * FROM album_fotos WHERE id_album = ".$id_album." ORDER BY id ASC");
            
            if(mysql_num_rows($query) > 0):
        ?>        
        
            <ul class="lista_fotos">

                <?php while($item = mysql_fetch_array($query)): ?>
                    <li id="fto<?php echo $item['id']?>" class="li_foto">
                        <div class="foto-box">
                            <div class="foto-photo">
                                <img src="<?php echo $item["foto"]?>" width="200" height="160"/>
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