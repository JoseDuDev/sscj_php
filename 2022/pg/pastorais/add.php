<?php 
  require_once('functions.php'); 
  add();
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Nova Pastoral</h2>

<form action="add.php" method="post">
  <!-- area de campos do form -->
  <hr />
  <div class="row">
    <div class="form-group col-md-4">
      <label for="name">Título</label>
      <input type="text" class="form-control" name="pastoral['titulo']">
    </div>

    <div class="form-group col-md-8">
      <label for="campo2">Descrição</label>
      <textarea class="form-control" name="pastoral['introducao']"></textarea>
    </div>
  </div>
  
  <div class="row">
    <div class="form-group col-md-4">
      <label for="campo3">Selecione um Logo:</label>
      <input type="file" class="form-control" name="pastoral['icone']">
    </div>

    <div class="form-group col-md-4">
      <label for="campo1">Ordem</label>
      <input type="number" class="form-control" name="pastoral['id_o']">
    </div>

    <div class="form-group col-md-4">
      <label for="campo2">Bairro</label>
      <select name="pastoral['status']" class="form-control">
        <option value="S">Ativo</option>
        <option value="N">Cancelado</option>
      </select>
    </div>
  </div>
  <div id="actions" class="row">
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="index.php" class="btn btn-default">Cancelar</a>
    </div>
  </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>