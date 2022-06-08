<?php
// dicionario utilizado para trocar os valores de uma determinada tabela
function dict($tableName, $arr, $valor)
{
  if (!file_exists('dict.json')) {
    for ($i = 0; $i < sizeof($arr); $i++) {
      $dict[$i] = array(
        "valor_antigo" => $arr[$i]['id'],
        "valor_novo" => "$valor"
      );
      $data[$tableName] = $dict;
      $valor++;
    }

    $fp = fopen('dict.json', 'w');
    fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
    fclose($fp);
  } else {
    $file = file_get_contents("dict.json");
    $json = json_decode($file, TRUE);

    for ($i = 0; $i < sizeof($arr); $i++) {
      $dict[$i] = array(
        "valor_antigo" => $arr[$i]['id'],
        "valor_novo" => "$valor"
      );
      $data[$tableName] = $dict;
      $valor++;
    }
    $final = array_merge($json, $data);
    $fp = fopen('dict.json', 'w');
    fwrite($fp, json_encode($final, JSON_PRETTY_PRINT));
    fclose($fp);
  }
}
