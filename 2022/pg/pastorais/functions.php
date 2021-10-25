<?php

require_once('../../config.php');
require_once(DBAPI);

$pastorais = null;
$pastoral = null;

function index() {
	global $pastorais;
	$pastorais = find_all('pastorais');
}

function add() {

  if (!empty($_POST['pastoral'])) {
    
    $today = 
      date_create('now', new DateTimeZone('America/Sao_Paulo'));

    $pastoral = $_POST['pastoral'];
    $pastoral['modified'] = $pastoral['created'] = $today->format("Y-m-d H:i:s");
    
    save('pastoral', $pastoral);
    header('location: index.php');
  }
}

function edit() {

  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

  if (isset($_GET['id'])) {

    $id = $_GET['id'];

    if (isset($_POST['pastoral'])) {

      $pastoral = $_POST['pastoral'];
      $pastoral['modified'] = $now->format("Y-m-d H:i:s");

      update('pastorais', $id, $pastoral);
      header('location: index.php');
    } else {

      global $pastoral;
      $pastoral = find('pastorais', $id);
    } 
  } else {
    header('location: index.php');
  }
}

function view($id = null) {
  global $pastoral;
  $pastoral = find('pastorais', $id);
}

function delete($id = null) {

  global $pastoral;
  $pastoral = remove('pastorais', $id);

  header('location: index.php');
}
?>