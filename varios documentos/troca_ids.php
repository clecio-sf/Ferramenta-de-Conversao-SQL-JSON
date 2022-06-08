<?php
// arquivo auxiliar para troca de valores com base no dict
function troca($tableName, $arr, $dict, $keyName)
{
  $file = file_get_contents($dict);
  $json = json_decode($file, TRUE);
  $replace = $arr;
  for ($i = 0; $i < sizeof($arr); $i++) {
    for ($j = 0; $j < sizeof($json[$tableName]); $j++) {
      if (
        $arr[$i][$keyName] ==
        $json[$tableName][$j]['valor_antigo']
      ) {
        $replace[$i][$keyName] =
          $json[$tableName][$j]['valor_novo'];
      }
    }
  }
  return $replace;
}
