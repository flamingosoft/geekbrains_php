<?php

namespace services;
require realpath(__DIR__ . "/../config/config.php");


class Autoloader
{
  public function registerClass(string $className)
  {
    if (empty($className)) {
      return;
    }
    $path = realpath(__DIR__ . "/../" . $className . ".php");
//    var_dump($path);
    require_once $path;
  }
}
