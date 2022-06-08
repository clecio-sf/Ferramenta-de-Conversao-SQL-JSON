<?php
include 'connection.php';
include 'troca_ids_aux.php';
ini_set('memory_limit', '-1');

$doc_name = 'dados_pessoais';
$array_name = 'participacao';
$data = [];
$sql1 = "SELECT id FROM usuario";
$sql2 = "SELECT id FROM participante";
$resultado1 = mysqli_query($connect, $sql1);
$resultado2 = mysqli_query($connect, $sql2);

while ($aux = mysqli_fetch_ASsoc($resultado1)) {
  $usuario_ids[] = $aux;
}
while ($aux = mysqli_fetch_ASsoc($resultado2)) {
  $participante_ids[] = $aux;
}
sort($usuario_ids);
sort($participante_ids);

for ($i = 0; $i < sizeof($usuario_ids); $i++) {

  $query1 = "SELECT * FROM usuario WHERE id=" . implode(', ', $usuario_ids[$i]) . ";";
  $result1 = mysqli_query($connect, $query1);
  $data1[$i] = mysqli_fetch_ASsoc($result1);
}

// coloca os resultados da query em um documento
for ($i = 0; $i < sizeof($participante_ids); $i++) {
  $query2 = "SELECT * FROM participante WHERE id=" . implode(',', $participante_ids[$i]) . ";";
  $query3 = "SELECT * FROM participacao WHERE participante_id=" . implode(',', $participante_ids[$i]) . ";";
  $result2 = mysqli_query($connect, $query2);
  $result3 = mysqli_query($connect, $query3);

  // enquanto houver resultados no participante adciona as participacoes em um array
  while ($row = mysqli_fetch_ASsoc($result2)) {
    $data2[$i][$doc_name] = $row;

    while ($row = mysqli_fetch_ASsoc($result3)) {
      $json_array[] = $row;
      $data2[$i][$array_name] = $json_array;
    }
    $json_array = [];
  }
}
// troca os valores da chave pelos valores definidos no dict 
$data2 = troca('tipo_atividade', $data2, 'participacao', 'dict.json', 'tipo_atividade_id');

// criar o json com os resultados das consultas
$final = array_merge($data1, $data2);
$fp = fopen('participante_participacao.json', 'w');
fwrite($fp, json_encode($final, JSON_PRETTY_PRINT));
fclose($fp);
