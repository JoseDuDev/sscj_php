<?php 
	require_once('functions.php'); 
	view($_GET['id']);
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Pastoral <?php echo $pastoral['id']; ?></h2>
<hr>

<?php if (!empty($_SESSION['message'])) : ?>
<div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
<?php endif; ?>

<dl class="dl-horizontal">
  <dt>Nome:</dt>
  <dd><?php echo $pastoral['titulo']; ?></dd>

  <dt>Descrição:</dt>
  <dd><?php echo $pastoral['introducao']; ?></dd>

  <dt>Logo:</dt>
  <dd><?php echo $pastoral['icone']; ?></dd>
</dl>

<dl class="dl-horizontal">
  <dt>Ordem:</dt>
  <dd><?php echo $pastoral['id_o']; ?></dd>

  <dt>URL:</dt>
  <dd><?php echo $pastoral['urlcheck']; ?></dd>

  <dt>Status:</dt>
  <dd><?php echo $pastoral['status']; ?></dd>
</dl>

<div id="actions" class="row">
  <div class="col-md-12">
    <a href="edit.php?id=<?php echo $pastoral['id']; ?>" class="btn btn-primary">Editar</a>
    <a href="index.php" class="btn btn-default">Voltar</a>
  </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>