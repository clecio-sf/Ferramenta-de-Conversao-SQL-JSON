<?php
include 'connection.php';
ini_set('memory_limit', '-1');

$sql = 'SELECT id FROM participante';

$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  $participante_ids[] = $row;
}

sort($participante_ids);

// com base na query do participante faz um join nas tabelas do banco
for ($i = 0; $i < sizeof($participante_ids); $i++) {
  $sql1 = "SELECT * FROM participante WHERE id = " . implode(', ', $participante_ids[$i]) . ";";

  $result = mysqli_query($connect, $sql1);

  $sql2 = "SELECT id, data_inicio, data_fim, carga_horaria, data_ultima_emissao, 
           chave_validacao, qtd_bolsista, email_enviado_em, ordem_autoria, cadastrado_em
           FROM participacao 
           WHERE participante_id = " . implode(', ', $participante_ids[$i]) . ";";

  $result2 = mysqli_query($connect, $sql2);
  // enquanto houver resultados no participante faz a relação com as demais tabelas do banco
  while ($row = mysqli_fetch_assoc($result)) {
    $data[$i]['dados_pessoais'] = $row;

    while ($row = mysqli_fetch_assoc($result2)) {
      $json_array[] = $row;
      $data[$i]['participacao'] = $json_array;
    }

    for ($j = 0; $j < sizeof($json_array); $j++) {
      $sql3 = "SELECT evento.id, evento.nome, evento.sigla, evento.ano, evento.numero_edicao 
          FROM evento 
          JOIN atividade ON evento.id = atividade.evento_id 
          JOIN participacao ON atividade.id = participacao.atividade_id
          WHERE participacao.participante_id =" . implode(', ', $participante_ids[$i]) . ";";

      $result3 = mysqli_query($connect, $sql3);

      while ($row = mysqli_fetch_assoc($result3)) {
        $json_array2[] = $row;
        $data[$i]['participacao'][$j]['evento'] = $json_array2[$j];
      }
    }

    for ($k = 0; $k < sizeof($json_array); $k++) {
      $sql4 = "SELECT funcao.id, funcao.nome
      FROM funcao
      JOIN participacao ON funcao.id = participacao.funcao_id
      WHERE participacao.participante_id= " . implode(', ', $participante_ids[$i]) . ";";

      $result4 = mysqli_query($connect, $sql4);

      while ($row = mysqli_fetch_assoc($result4)) {
        $json_array3[] = $row;
        $data[$i]['participacao'][$k]['funcao'] = $json_array3[$k];
      }
    }

    for ($l = 0; $l < sizeof($json_array); $l++) {
      $sql5 = "SELECT atividade.id, atividade.titulo, atividade.data_inicio, atividade.data_fim,
             atividade.carga_horaria, atividade.cadastrado_em, tipo_atividade.nome AS 'tipo_atividade'
             FROM atividade
             JOIN tipo_atividade ON atividade.tipo_atividade_id = tipo_atividade.id
             JOIN participacao ON atividade.id = participacao.atividade_id
             WHERE participacao.participante_id = " . implode(', ', $participante_ids[$i]) . ";";

      $result5 = mysqli_query($connect, $sql5);

      while ($row = mysqli_fetch_assoc($result5)) {
        $json_array5[] = $row;
        $data[$i]['participacao'][$l]['tipo_atividade'] = $json_array5[$l];
      }
    }
    $json_array  = [];
    $json_array2 = [];
    $json_array3 = [];
    $json_array5 = [];
  }
}

// cria o json com o resultado das consultas
$fp = fopen('sample.json', 'w');
fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
fclose($fp);
