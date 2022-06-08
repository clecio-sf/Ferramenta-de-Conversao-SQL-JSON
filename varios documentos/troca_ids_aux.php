<?php
// arquivo auxiliar para troca de valores com base no dict
function troca($tableName, $arr, $arrayName, $dict, $keyName)
{
  $file = file_get_contents($dict);
  $json = json_decode($file, TRUE);
  $replace = $arr;
  for ($i = 0; $i < sizeof($arr); $i++) {
    if (isset($arr[$i][$arrayName])) {
      for ($j = 0; $j < sizeof($arr[$i][$arrayName]); $j++) {
        for ($k = 0; $k < sizeof($json[$tableName]); $k++) {
          if (
            $arr[$i][$arrayName][$j][$keyName] ==
            $json[$tableName][$k]['valor_antigo']
          ) {
            $replace[$i][$arrayName][$j][$keyName] =
              $json[$tableName][$k]['valor_novo'];
          }
        }
      }
    }
  }
  return $replace;
}
