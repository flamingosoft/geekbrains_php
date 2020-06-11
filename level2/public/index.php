<?php


require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "services" . DIRECTORY_SEPARATOR . "autoloader.php";

spl_autoload_register([new \services\Autoloader(), "registerClass"]);

$prod = new \models\Product();
echo $prod->toString();
