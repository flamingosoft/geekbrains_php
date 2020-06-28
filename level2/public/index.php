<?php

use models\ProductRepo;
use models\UsersRepo;
use services\Autoloader;
use services\Db;

require __DIR__ . DIRECTORY_SEPARATOR
  . ".."
  . DIRECTORY_SEPARATOR
  . "services"
  . DIRECTORY_SEPARATOR
  . "autoloader.php";

spl_autoload_register([new Autoloader(), "registerClass"]);

//$test = db::getInstance()->dbGetObjects(get_class(new \models\Product()), "SELECT * FROM products", []);
//var_dump($test);

testRepo();


//$users = new UsersRepo();
//$userItem = $users->createUser("abracadabra", "abraham", "unknown password");
//var_dump($prodItem);
//var_dump($userItem);


function testRepo() {
  $products = new ProductRepo();
  echo "report created";

  assert_options(ASSERT_ACTIVE, 1);
  assert_options(ASSERT_BAIL, 1);

  // создаем пустой класс вне базы бз айдишника
  $prodItem = $products->createProduct("test123", 123, 0);
  // проверим тип созданного объекта и поля, правильно ли присвоились значения
  print_r(get_class($prodItem));
  print_r(get_class(new models\Product()));

  assert(get_class($prodItem) === get_class(new models\Product()));
  assert($prodItem->getNotes() == "test123");
  assert($prodItem->getPrice() == 123);
  assert($prodItem->getCategoryId() == 0);
  assert($prodItem->getId() == null);

  $products->saveOrUpdate($prodItem);

  assert($prodItem->getId() !== null);
  assert($prodItem->getId() !== 0);
  echo "save id: ", $prodItem->getId();

  $newprodItem = $products->getById($prodItem->getId());

  assert(get_class($newprodItem) === get_class(new models\Product()));
  assert($newprodItem->getNotes() == "test123");
  assert($newprodItem->getPrice() == 123);
  assert($newprodItem->getCategoryId() == 0);
  assert(!is_null($newprodItem->getId()));
  assert($prodItem->getId() === $newprodItem->getId());
  assert($prodItem->getNotes() === "test123");

  $prodItem->notes = "ahaha notes";
  $products->saveOrUpdate($prodItem);

  $newprodItem = $products->getById($prodItem->getId());

  assert($prodItem->getNotes() === "ahaha notes");

  $products->deleteObject($prodItem);

  assert(false === $products->getById($prodItem->getId()));

  $all = $products->getAll();
  print_r($all);
}
