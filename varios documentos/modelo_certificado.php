<?php
include 'connection.php';
include 'troca_ids_aux.php';

$sql1 = "SELECT modelo_certificado_id FROM certificado_tipo_funcao_evento";
$sql2 = "SELECT tipo_atividade_id, funcao_id FROM certificado_tipo_funcao_evento";
$resultado1 = mysqli_query($connect, $sql1);
$resultado2 = mysqli_query($connect, $sql2);

while ($aux = mysqli_fetch_assoc($resultado1)) {
  $modelo_certificados_ids[] = $aux;
}

while ($aux = mysqli_fetch_assoc($resultado2)) {
  $funcao_ids[] = $aux;
}

sort($modelo_certificados_ids);

for ($i = 0; $i < sizeof($modelo_certificados_ids); $i++) {

  $query1 = "SELECT modelo_certificado.id, modelo_certificado.nome, 
  modelo_certificado.cadastrado_em, certificado_tipo_funcao_evento.evento_id 
  FROM modelo_certificado JOIN certificado_tipo_funcao_evento 
  ON modelo_certificado.id = certificado_tipo_funcao_evento.modelo_certificado_id
  WHERE modelo_certificado.id=" . implode(', ', $modelo_certificados_ids[$i]) . ";";

  $query2 = "SELECT tipo_atividade_id, funcao_id FROM certificado_tipo_funcao_evento 
  WHERE modelo_certificado_id = " . implode(',', $modelo_certificados_ids[$i]) . ";";

  $query3 = "SELECT distinct texto_frente AS texto, descricao_frente AS descricao, 
  bg_frente AS imagem FROM modelo_certificado 
  JOIN certificado_tipo_funcao_evento 
  ON modelo_certificado.id = certificado_tipo_funcao_evento.modelo_certificado_id
  WHERE modelo_certificado.id= " . implode(', ', $modelo_certificados_ids[$i]) . ";";

  $result1 = mysqli_query($connect, $query1);
  $result2 = mysqli_query($connect, $query2);
  $result3 = mysqli_query($connect, $query3);

  $row = mysqli_fetch_assoc($result1);
  $json_array1[] = $row;
  $data[$i] = $json_array1[$i];

  // criar o array tipo_atividade
  while ($row = mysqli_fetch_assoc($result2)) {
    $json_array2[] = $row;
    $data[$i]['tipoAtividade_funcao'] = $json_array2;
  }
  $json_array2 = [];

  // criar o array paginas
  while ($row = mysqli_fetch_assoc($result3)) {
    $json_array3[] = $row;
    $data[$i]['paginas'] = $json_array3;
  }
  $json_array3 = [];
}
// troca os valores da chave pelos valores definidos no dict 
$data = troca('tipo_atividade', $data, 'tipoAtividade_funcao', 'dict.json', 'tipo_atividade_id');

// criar o json com os resultados das consultas
$fp = fopen('modelo_certificado.json', 'w');
fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
fclose($fp);
