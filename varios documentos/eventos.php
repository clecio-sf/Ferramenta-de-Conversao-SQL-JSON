<?php
include 'connection.php';

$sql = 'SELECT id FROM evento';
$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  $evento_ids[] = $row;
}
// coloca os resultados da query em um documento
for ($i = 0; $i < sizeof($evento_ids); $i++) {
  $query = "SELECT * FROM evento WHERE id =" . implode(', ', $evento_ids[$i]) . ";";
  $result = mysqli_query($connect, $query);

  $evento[$i] = mysqli_fetch_assoc($result);
}

// criar o json com os resultados das consultas
$fp = fopen('eventos.json', 'w');
fwrite($fp, json_encode($evento, JSON_PRETTY_PRINT));
fclose($fp);
