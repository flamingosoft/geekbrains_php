<?php

/*
5. Написать функцию, которая заменяет в строке пробелы на подчеркивания и возвращает видоизмененную строчку.
*/

$phrase = "съешь еще этих мягких булочек...";
echo "Фраза: ", $phrase, PHP_EOL;
echo "fn(фраза): ", spaceToUnder($phrase), PHP_EOL;

// работает только для строчных букв пока
function spaceToUnder(string $phrase): string
{
  $res = preg_split("//u", $phrase, 0, PREG_SPLIT_NO_EMPTY);
  foreach ($res as &$symb) {
    if ($symb == ' ') {
      $symb = '_';
    }
  }
  return implode('', $res);
}



?>
