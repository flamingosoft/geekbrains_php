<?php

$base = -2;
$power = 5;
$res = myPow($base, $power);

echo "$base ^ $power = $res";

function myPow($base, $power) {
  if ($power <= 1) return $base;
  else return myPow($base, $power - 1) * $base;
}
?>
