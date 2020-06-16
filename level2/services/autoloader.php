<?php

namespace services;
require realpath(__DIR__ . "/../config/config.php");


class Autoloader
{
  public function registerClass(string $className)
  {
    $path = realpath(__DIR__ . "/../" . $className . ".php");
    require $path;
  }
}
