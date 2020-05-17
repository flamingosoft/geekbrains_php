<?php
require_once DAO;
require_once DAO_REVIEWS;
require_once API_WEB;
require_once API_REVIEWS;

unset($product);
unset($idProduct);
unset($addReview);
unset($reviews);

// получим изображение
$idProduct = get("id");
if (!is_null($idProduct)) {

  dbAddView($idProduct);
  $product = dbGetProduct($idProduct);
}

// и отзывы
$author = post("author");
$text = post("text");
if (!is_null($author) && !is_null($text) && !is_null($idProduct)) {
  // добавим сначала новый отзыв
  $addReview = addReviewForId($idProduct, $author, $text);
}

// а потом получим все отзывы
if (!is_null($idProduct)) {
  $reviews = getReviewsForId($idProduct);
}


if (!isset($reviews) || empty($reviews)) {
//  exit;
}

?>


<h1>Image ID: <?= $idProduct ?></h1>
<h3>Original name: <?= $product['title'] ?></h3>
<h4>Views: <?= $product['view'] ?></h4>
<h3>Price: <?=$product['price']?></h3>
<?php foreach ($product["images"] as $image): ?>
<img src="/images/<?= $image["newName"] ?>" style="max-height: 100px"/>
<?php endforeach; ?>

<div>
  <h2>Отзывы</h2>

  <ul>
    <?php foreach ($reviews as $review): ?>
      <li>
        <h4><?= $review["author"] ?> / <small><?= date("d M Y", mktime($reviews["time"])) ?></small></h4>
        <?= $review["text"] ?>
      </li>
    <?php endforeach; ?>
  </ul>

  <form action="" method="post">
    <h3>Оставьте отзыв</h3>
    <input type="text" name="author" required>
    <textarea name="text" cols="30" rows="20" required></textarea>
    <input type="submit" value="Отправить отзыв">
    <div>
      <?php if ($addReview === false): ?>
        Отзыв не добавлен, произошла ошибка
      <?php endif; ?>
    </div>
  </form>
</div>
