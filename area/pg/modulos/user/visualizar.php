<?php
if(!isset($_SESSION['nivel_usuario'])){
	header("Location: ?pg=inicial");
} else {
	if($_SESSION['nivel_usuario']==2){
		header("Location: ?pg=inicial");
	}
}
if(isset($_GET['id'])){
	$eu = mysql_query("SELECT * FROM usuarios WHERE id='".$_GET['id']."'") or die("Erro no banco de dados!");	
  $user = mysql_fetch_object($eu);
  $nomeuser = $user->nome;
  $emailuser = $user->email;
  $empresa = $user->empresa;
  $cnpj = $user->cnpj;
  $cpf = $user->cpf;
  $rg = $user->rg;
  $cep = $user->cep;
  $rua = $user->rua;
  $numero = $user->numero;
  $bairro = $user->bairro;
  $complemento = $user->complemento;
  $telefone = $user->telefone;
  $celular = $user->celular;
  $estado = $user->estado;
  $cidade = $user->cidade;
  if(file_exists($user->logomarca)){
     $imgc = $user->logomarca;
  } else {
      $imgc = 'img/logomarca-padrao-hatus.jpg';
  }
  $img = "<img src='".$imgc."' width='200' alt='".$user->nome."' title='".$user->nome."' /><br />";
  $niveluser = $user->nivel;
  $sexo = $user->sexo;
  $ies = $user->ie;
  $tipo = $user->tipo;
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>  
<body>  

<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td colspan="2" height="80" valign="middle" align="center">
    
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="10%">&nbsp;</th>
    <th scope="col" width="80%" align="center" class="t20">Visualizando dados de <?php echo mysql_result(mysql_query("SELECT nome FROM usuarios WHERE id='".$_GET['id']."'"),0,"nome"); ?></th>
    <th scope="col" width="10%" align="right"><a href="javascript:history.back();"><img src="img/icones/voltar.png" width="32" height="32" alt="Voltar" /></a></th>
  </tr>
</table>

    </td>
</tr>
</table>

<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
  <td width="28%" height="50" align="right"></td>
  <td height="50" align="left" valign="top" class="corlaranja bold t15">
  	<?php if($tipo=='fisica'){echo 'Cadastrado como Pessoa Física.';} ?>
  	<?php if($tipo=='juridica'){echo 'Cadastrado como Pessoa Jurídica.';} ?>
  </td>
</tr> 
<tr>
  <td height="27" align="right" valign="middle" class="corcinza2 media">Logomarca / Foto&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td height="17" align="left"><?php echo $img; ?></td>
</tr>
<tr>
  <td colspan="2" height="32">&nbsp;</td>
</tr>
<?php if($empresa!=''){ ?>
<tr>
  <td height="17" align="right" class="corcinza2 media">Razão&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td height="17" align="left" class="media"><?php echo $empresa; ?></td>
</tr>
<?php } if($cnpj!=''){ ?>
<tr>
  <td height="17" align="right" class="corcinza2 media">CNPJ&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td height="17" align="left" class="media"><?php echo $cnpj; ?></td>
</tr>
<?php } if($ies!=''){ ?>
<tr>
  <td height="17" align="right" class="corcinza2 media">IE&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td height="17" align="left" class="media"><?php echo $ies; ?></td>
</tr>
<?php } if($cpf!=''){ ?>
<tr>
  <td height="17" align="right" class="corcinza2 media">CPF&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td height="17" align="left" class="media"><?php echo $cpf; ?></td>
</tr>
<?php } if($rg!=''){ ?>
<tr>
  <td height="17" align="right" class="corcinza2 media">RG&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td height="17" align="left" class="media"><?php echo $rg; ?></td>
</tr>
<?php } ?>
</table>

  <table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td colspan="2" height="15" align="center" valign="middle">&nbsp;</td>
    </tr>
<?php if($nomeuser!=''){ ?>
    <tr>
      <td width="28%" height="17" align="right" class="corcinza2 media">Responsável&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td height="17" align="left" class="media"><?php echo $nomeuser; ?></td>
    </tr>
<?php } if($emailuser!=''){ ?>
    <tr>
      <td height="17" align="right" class="corcinza2 media">E-mail&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td height="17" align="left" class="media"><?php echo '<a href="mailto:'.$emailuser.'" target="_blank">'.$emailuser.'</a>'; ?></td>
    </tr>
<?php } ?>
	<tr>
      <td height="17" align="right" class="corcinza2 media">Nível&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td height="17" align="left" class=" media">
      <?php
	  if($niveluser!=''){
          echo '<option value="'.$niveluser.'">';
		  if($niveluser=='1'){
			  echo 'Administrador';
		  } else if($niveluser=='2'){
				  echo 'Cliente';
		  }
		  echo '</option>';
	  }
	  ?>
        </td>
    </tr>
    <tr>
      <td colspan="2" height="15" align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td height="17" align="right" class="corcinza2 media">Endereço&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td height="17" align="left" class="media">
      <?php
      echo $rua;
      if($numero != 0 || $numero != '') {
      	echo ', '.$numero;
      }
      if($bairro != '') {
      	echo ' / '.$bairro;
      }
      if($cidade != '') {
      	echo ' / '.$cidade;
      }
      if($estado != '') {
      	echo ' / '.$estado;
      }
      if($cep != '') {
      	echo ' / '.$cep;
      }
      ?>
  </td>
    </tr> 
<?php if($complemento!=''){ ?>
    <tr>
      <td colspan="2" height="15" align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td height="17" align="right" valign="middle" style="padding-top:3px;" class="corcinza2 media">Complemento&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td height="17" align="left" class="media"><?php echo nl2br($complemento); ?></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="2" height="15" align="center" valign="middle">&nbsp;</td>
    </tr>
<?php if($telefone!=''){ ?>
    <tr>
      <td height="17" align="right" class="corcinza2 media">Telefone Fixo&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td height="17" align="left" class="media"><?php echo $telefone; ?></td>
    </tr>
<?php } if($celular!=''){ ?>
    <tr>
      <td height="17" align="right" class="corcinza2 media">Telefone Celular&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td height="17" align="left" class="media"><?php echo $celular; ?></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="2" height="80" align="center" valign="middle"><a href="?pg=modulos/user/user&acao=edit&id=<?php echo $_GET['id']; ?>"><input type="button" name="editar" id="editar" value="Editar Cliente" /></a></td>
    </tr>
  </table>

</body>
</html>