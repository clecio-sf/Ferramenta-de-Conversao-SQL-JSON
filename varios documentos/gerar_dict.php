<?php
include 'connection.php';
include 'dict.php';

// gera um dicionario a partir de uma consulta
$sql = 'SELECT id FROM tipo_atividade';
$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_ASsoc($result)) {
  $tipo_atividade_ids[] = $row;
}

dict('tipo_atividade', $tipo_atividade_ids, '50');
