<?php

use models\ProductRepo;
use models\UsersRepo;
use services\Autoloader;

require __DIR__ . DIRECTORY_SEPARATOR
  . ".."
  . DIRECTORY_SEPARATOR
  . "services"
  . DIRECTORY_SEPARATOR
  . "autoloader.php";

spl_autoload_register([new Autoloader(), "registerClass"]);

$products = new ProductRepo();
$users = new UsersRepo();
$prodItem = $products->createProduct("test123", 123, 0);
$userItem = $users->createUser("abracadabra", "abraham", "unknown password");
var_dump($prodItem);
var_dump($userItem);
