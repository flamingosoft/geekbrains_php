<?php

$time = getdate();
$hour = 22;//$time['hours'];
$min = 15;//$time['minutes'];

?>

<h1>Текущее время: <?= hourToText($hour) ?> <?= minuteToText($min) ?></h1>

<h3>Test:</h3>

<?php
for ($hour = 0; $hour < 24; ++$hour) {
  for ($minute = 0; $minute < 60; ++$minute) {
    echo "<h3>Время: " . hourToText($hour) . " " . minuteToTextSimple($minute) . "</h3 > ";
  }
}
?>

<?php
/**
 * Часы в текст
 * @param $hour
 * @return string
 */
function hourToText($hour)
{
  switch ($hour % 10) {
    case 0:
      return "$hour часов";
    case 1:
      return "$hour час";
    default:
      return "$hour часа";
  }
}

/**
 * Первый вариант функции преобразования минут в текст
 * @param $minute
 * @return string
 */
function minuteToText($minute)
{
  // сначала исключения из правил
  static $specials = [11, 12, 13, 14];
  if (in_array($minute, $specials)) return "$minute минут";

  // все что заканчивается на 1
  if ($minute % 10 == 1) return "$minute минута";

  // все, что заканчивается на 2, 3 или 4
  static $little = [2, 3, 4];
  if (in_array($minute % 10, $little)) return "$minute минуты";

  // остальное сюда
  return "$minute минут";
}

/**
 * Второй вариант функции преобразования минут в текст
 * @param $minute
 * @return string
 */
function minuteToTextSimple($minute)
{
  // исключения
  switch ($minute) {
    case 11:
    case 12:
    case 13:
    case 14:
      return "$minute минут";
  }

  // все что заканчивается на 1
  switch ($minute % 10) {
    case 1:
      return "$minute минута";
    case 2:
    case 3:
    case 4: // все, что заканчивается на 2, 3 или 4
      return "$minute минуты";
  }
  // остальное сюда
  return "$minute минут";
}

?>
