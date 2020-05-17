<?php
require_once(__DIR__ . "/../config/config.php");
require_once(DAO);


/**
 * Добавляем информацию о добавленном на хостинг файле в БД
 * @param $db
 * @param string $imageLink - имя файла
 * @param string $imageTitle - описание (исходное имя файла)
 * @return bool
 */
function dbAddProduct(float $price, string $notes, array $imageLink, array $imageTitle)
{
  $db = dbConnect();
  // добавим продукт, чтобы получить его айдишник
  $sql = "INSERT INTO `gallery` (price, notes) VALUES ('{$price}', '{$notes}')";
  dbExecute($sql);

  // получим сгенерированный айдишник
  $productId = mysqli_insert_id($db);

  $ins = [];
  for ($index = 0; $index < count($imageLink); ++$index) {
    $ins[] = "( '{$productId}', '{$imageTitle[$index]}', '{$imageLink[$index]}' )";
  }

  // привяжем изображения к этому айдишнику
  $sql = "INSERT INTO `images` " .
    "(productId, originalName, newName) " .
    "VALUES " . implode(", ", $ins);
  return dbExecute($sql);
}

/**
 * Возвращаем из базы массив данных об изображениях для отображения в галерее. Галерея отсортирована по просмотрам
 * @param $db
 * @return array
 */
function dbGetProducts()
{
  //$sql = "SELECT id, link, title, view FROM `" . DB_GALLERY_TABLE . "` ORDER BY view DESC";
  // как получить из правой таблицы только 1 строку ?
  //$sql = "SELECT gallery.*, images.* FROM `gallery` LEFT JOIN `images` ON gallery.id = images.productId";

  $sql = "SELECT * FROM `gallery` LIMIt 1000";
  $products = dbGetAll($sql);

  foreach ($products as &$prod) {
    $sql = "SELECT * FROM `images` WHERE `productId` = {$prod['id']} LIMIT 1";
    $prod["images"] = dbGetAll($sql);
  }
  unset($peod);
  return $products;
}

/**
 * Получаем данные по конкретному продукту
 * @param $db
 * @param $idProduct
 * @return bool|string[]|null
 */
function dbGetProduct($idProduct)
{
  //$sql = "SELECT gallery.*, images.* FROM `gallery` LEFT JOIN `images` ON gallery.id = {$idProduct} AND images.productId = {$idProduct}";
  $sql = "SELECT id, view, price, notes FROM `gallery` WHERE id={$idProduct} LIMIT 1";
  $product = dbGetOne($sql);
if (!empty($product)) {
  $sql = "SELECT originalName, newName FROM `images` WHERE productId = {$product['id']}";
  $product['images'] = dbGetAll($sql);
  return $product;

}
else {
  return [];}
}

/**
 * Добавляем просмотр для конкретного изображения
 * @param $db
 * @param $imgId
 * @return bool
 */
function dbAddView($imgId)
{
  $sql = "UPDATE `" . DB_GALLERY_TABLE . "`
    SET view = view + 1
    WHERE id = '" . $imgId . "'";
  return dbExecute($sql);
}

