<?php
    require_once('functions.php');
    index();
?>

<?php include(HEADER_TEMPLATE); ?>

<header>
	<div class="row">
		<div class="col-sm-6">
			<h2>Pastorais</h2>
		</div>
		<div class="col-sm-6 text-right h2">
	    	<a class="btn btn-primary" href="add.php"><i class="fa fa-plus"></i> Nova Pastoral</a>
	    	<a class="btn btn-default" href="index.php"><i class="fa fa-refresh"></i> Atualizar</a>
	    </div>
	</div>
</header>

<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
	</div>
	<?php clear_messages(); ?>
<?php endif; ?>

<hr>

<table class="table table-hover">
<thead>
	<tr>
		<th>ID</th>
		<th width="30%">Nome</th>
		<th>Logo</th>
		<th>Descrição</th>
		<th>URL</th>
		<th>Ordem</th>
		<th>Status</th>
		<th>Opções</th>
	</tr>
</thead>
<tbody>
<?php if ($pastorais) : ?>
<?php foreach ($pastorais as $pastoral) : ?>
	<tr>
		<td><?php echo $pastoral['id']; ?></td>
		<td><?php echo $pastoral['titulo']; ?></td>
		<td><?php echo $pastoral['icone']; ?></td>
		<td><?php echo $pastoral['introducao']; ?></td>
		<td><?php echo $pastoral['urlcheck']; ?></td>
		<td><?php echo $pastoral['id_o']; ?></td>
		<td><?php echo $pastoral['status']; ?></td>
		<td class="actions text-right">
			<a href="view.php?id=<?php echo $pastoral['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Visualizar</a>
			<a href="edit.php?id=<?php echo $pastoral['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Editar</a>
			<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" data-customer="<?php echo $pastoral['id']; ?>">
				<i class="fa fa-trash"></i> Excluir
			</a>
		</td>
	</tr>
<?php endforeach; ?>
<?php else : ?>
	<tr>
		<td colspan="6">Nenhum registro encontrado.</td>
	</tr>
<?php endif; ?>
</tbody>
</table>

<?php include(FOOTER_TEMPLATE); ?>