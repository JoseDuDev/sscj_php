<?php
ob_start();
session_start();

date_default_timezone_set('America/Sao_Paulo');
?>

<?php require_once 'config.php'; ?>
<?php require_once DBAPI; ?>

<?php include(HEAD_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php $db = open_database(); ?>

<h1>Dashboard</h1>
<hr />

<?php if ($db) : ?>

<div class="row">
  <div class="col-xs-6 col-sm-3 col-md-2">
    <a href="pg/pastorais/add.php" class="btn btn-primary">
      <div class="row">
        <div class="col-xs-12 text-center">
          <i class="fa fa-plus fa-5x"></i>
        </div>
        <div class="col-xs-12 text-center">
          <p>Nova pastoral</p>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xs-6 col-sm-3 col-md-2">
    <a href="pg/pastorais" class="btn btn-default">
      <div class="row">
        <div class="col-xs-12 text-center">
          <i class="fa fa-user fa-5x"></i>
        </div>
        <div class="col-xs-12 text-center">
          <p>Pastorais</p>
        </div>
      </div>
    </a>
  </div>
</div>

<?php else : ?>
<div class="alert alert-danger" role="alert">
  <p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
</div>

<?php endif; ?>

<?php include(FOOTER_TEMPLATE); ?>
<?php include(FOOT_TEMPLATE); ?>