<?php

/*
4. Объявить массив, индексами которого являются буквы русского языка, а значениями – соответствующие латинские буквосочетания
(‘а’=> ’a’, ‘б’ => ‘b’, ‘в’ => ‘v’, ‘г’ => ‘g’, …, ‘э’ => ‘e’, ‘ю’ => ‘yu’, ‘я’ => ‘ya’).
Написать функцию транслитерации строк.
*/

$rus = explode(",", "а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ь,ы,ъ,э,ю,я");
$lat = explode(",", "a,b,v,g,d,e,yo,zh,z,i,y,k,l,m,n,o,p,r,s,t,u,f,h,c,ch,sh,sch,',y,'',ea,yu,ya");
$dict = generateDict($rus, $lat);
// подготовим ассоциативный массив транслитерации

$phrase = "съешь еще этих мягких булочек...";
echo "Фраза: ", $phrase, PHP_EOL;
echo "Транслит: ", getTranslit($phrase, $dict), PHP_EOL;

function generateDict(array $from, array $to): array {
  $dict = [];
  foreach ($from as $key => $value) {
    $dict[$value] = $to[$key];
  }
  return $dict;
}

// работает только для строчных букв пока
function getTranslit(string $phrase, array $dict)
{
  $trans = preg_split("//u", $phrase, 0, PREG_SPLIT_NO_EMPTY);
  foreach ($trans as &$symb) {
    if ($symb == ' ') {
      $symb = "_";
    } elseif (isset($dict[$symb])) {
      $symb = $dict[$symb];
    }
  }
  return implode('', $trans);
}


?>
