<?php

namespace services;

class Autoloader
{
//  public $dirs = [
//    "models",
//    "services",
//  ];

  public function registerClass(string $className)
  {
    require __DIR__ . "\\..\\" . $className . ".php";
//    foreach ($this->dirs as $dir) {
//      $path = realpath(__DIR__ . "/../" . $dir . "/" . $className . ".php");
//      var_dump($path);
//      if (file_exists($path)) {
//        require $path;
//        break;
//      }
//    }
  }
}
