<?php

require_once(__DIR__ . "/../config/config.php");

$operandLeft = post("operandLeft");
$operandRight = post("operandRight");
$operation = post("operation");

if ($operandLeft !== NULL && $operandRight !== NULL && $operation !== NULL) {
  $result = calc(
    (double)$operandLeft,
    (double)$operandRight,
    $operation);
} else {
  $result = "";
}

function calc(float $operandLeft, float $operandRight, string $operation)
{
  switch ($operation) {
    case "+":
      return $operandLeft + $operandRight;
    case "-":
      return $operandLeft - $operandRight;
    case "*":
      return $operandLeft * $operandRight;
    case "/":
      return $operandRight !== 0.0 ? $operandLeft / $operandRight: "Деление на 0";
    default:
      return "Unknown operation";
  }
}
?>

<form action="" method="post">
  <input type="number" name="operandLeft" value="<?= $operandLeft ?>" autofocus>
  <input type="number" name="operandRight" value="<?= $operandRight ?>"><br>
  <input type="submit" name="operation" value="+">
  <input type="submit" name="operation" value="/">
  <input type="submit" name="operation" value="*">
  <input type="submit" name="operation" value="-">
  <?php if (!empty($result)) : ?>
    <div>Результат: <?= $result ?></div>
  <?php endif; ?>
</form>

<form action="" method="post">
  <input type="number" name="operandLeft" value="<?= $operandLeft ?>" autofocus>
  <input type="number" name="operandRight" value="<?= $operandRight ?>">
  <select name="operation" id="">
    <option value="+">сложить</option>
    <option value="-">вычеесть</option>
    <option value="*">умножить</option>
    <option value="/">разделить</option>
  </select>
  <input type="submit" value="Посчитать">
  <?php if (!empty($result)) : ?>
    <div>Результат: <?= $result ?></div>
  <?php endif; ?>
</form>
