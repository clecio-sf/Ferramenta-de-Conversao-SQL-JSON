<?php
include 'connection.php';
include 'troca_ids.php';

$sql = 'SELECT id FROM atividade';
$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  $atividade_ids[] = $row;
}
// coloca os resultados da query em um documento
for ($i = 0; $i < sizeof($atividade_ids); $i++) {
  $query = "SELECT * FROM atividade WHERE id =" . implode(', ', $atividade_ids[$i]) . ";";
  $result = mysqli_query($connect, $query);

  $data[$i] = mysqli_fetch_assoc($result);
}

// troca os valores da chave pelos valores definidos no dict 
$data = troca('tipo_atividade', $data, 'dict.json', 'tipo_atividade_id');

// criar o json com os resultados das consultas
$fp = fopen('atividade.json', 'w');
fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
fclose($fp);
