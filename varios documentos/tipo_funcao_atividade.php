<?php
include 'connection.php';
include 'troca_ids.php';

$sql1 = "SELECT id FROM tipo_atividade";
$sql2 = "SELECT id FROM funcao";

$resultado1 = mysqli_query($connect, $sql1);
$resultado2 = mysqli_query($connect, $sql2);

while ($aux = mysqli_fetch_ASsoc($resultado1)) {
  $tipoAtividade_ids[] = $aux;
}

while ($aux = mysqli_fetch_ASsoc($resultado2)) {
  $funcao_ids[] = $aux;
}

sort($tipoAtividade_ids);

// coloca os resultados da query em um documento
for ($i = 0; $i < sizeof($tipoAtividade_ids); $i++) {

  $query1 = "SELECT * FROM tipo_atividade WHERE id=" . implode(', ', $tipoAtividade_ids[$i]) . ";";
  $result1 = mysqli_query($connect, $query1);
  $data1[$i] = mysqli_fetch_ASsoc($result1);
  $data1[$i]["tipo"] = "Tipo Atividade";
}
// coloca os resultados da query em um documento
for ($i = 0; $i < sizeof($funcao_ids); $i++) {
  $query2 = "SELECT * FROM tipo_atividade WHERE id=" . implode(', ', $funcao_ids[$i]) . ";";
  $result2 = mysqli_query($connect, $query2);
  $data2[$i] = mysqli_fetch_ASsoc($result2);
  $data2[$i]["tipo"] = "Funcao";
}

// troca os valores da chave pelos valores definidos no dict 
$data1 = troca('tipo_atividade', $data1, 'dict.json', 'id');
// criar o json com os resultados das consultas
$final = array_merge($data1, $data2);
$fp = fopen('tipo_funcao_atividade.json', 'w');
fwrite($fp, json_encode($final, JSON_PRETTY_PRINT));
fclose($fp);
