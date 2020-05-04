<?php

/**
* 2. С помощью цикла do…while написать функцию для вывода чисел от 0 до 10, чтобы результат выглядел так:
* 0 – ноль.
* 1 – нечетное число.
* 2 – четное число.
* 3 – нечетное число.
* …
* 10 – четное число.
 */

function WhatIsNum(int $num): string {
  if ($num == 0) {
    return "ноль";
  } elseif ($num % 2 ) {
    return "нечетное число";
  } else {
    return "четное число";
  }
}

$num = 0;
do {
  echo $num , " - ", WhatIsNum($num);
  ++$num;
}while ($num <= 10);

?>
