<?php
mysqli_report(MYSQLI_REPORT_STRICT);

function abrir_conexao() {
	try {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		return $conn;
	} catch (Exception $e) {
		echo $e->getMessage();
		return null;
	}
}

function fechar_conexao($conn) {
	try {
		$conn->close();
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function consultar($sql = null){
  $conn = abrir_conexao();
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
  	return $result;
  }else {
    echo "0 results";
  }
  fechar_conexao($conn);
}

// while($row = $result->fetch_assoc()) {
  //   echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
  // }
?>