<?php

function post(string $name) {
  return isset($_POST[$name]) ? htmlspecialchars(strip_tags($_POST[$name])) : null;
}

function get(string $name) {
  return isset($_GET[$name]) ? htmlspecialchars(strip_tags($_GET[$name])) : null;
}

function redirect($url) {
  header("Location: {$url}");
}
