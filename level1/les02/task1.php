<?php
$a = rand(-50, 50);
$b = rand(-50, 50);

echo "a: {$a}, b: {$b}, func res: " . MegaFunc($a, $b);

/**
 * PHP, Урок 2, уровень 1
 * если $a и $b положительные, вывести их разность;
 * если $а и $b отрицательные, вывести их произведение;
 * если $а и $b разных знаков, вывести их сумму;
 * Ноль можно считать положительным числом.
 * @param int $a
 * @param int $b
 * @return int
 */
function MegaFunc(int $a, int $b)
{
  $signA = $a <=> 0;
  $signB = $b <=> 0;

  switch ($signA + $signB) {
    case -2:
      return $a * $b;
    case 2:
      return $b - $a;
    default:
      return $a + $b;
  }
}
?>
