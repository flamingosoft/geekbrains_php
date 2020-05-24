<?php
require_once DAO;

// создадим папки для изображений, если они еще не созданы
forceDirectories([DIR_UPLOAD, DIR_IMAGES, DIR_THUMBNAILS]);

// если изображения закинуты, то попробуем принять их
$uploaded = [];
if (ifUploadingImages()) {
  $uploaded = acceptUploadedImage($_FILES['image']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="form">
  <form name="uploadForm" action="" enctype="multipart/form-data" method="post">
    <input type="number" name="price" required>
    <textarea name="notes" cols="30" rows="10">notes</textarea>
    <input type="file" name="image[]" multiple accept="image/jpeg, image/png, image/bmp, image/gif">
    <button type="submit">Create product</button>
  </form>
</div>

<main>
  <div class="explorer">
    <?= showFolder(DOCUMENT_ROOT); ?>
  </div>

  <div class="messages">
    <?php foreach ($uploaded as $oper): ?>
      <div class="<?= $oper["result"] ? "good" : "failed" ?>">
        <?= $oper["msg"] ?>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="gallery">
    <?php $products = getProducts();
    foreach ($products as $image):
      ?>
      <a href="<?= getAnchorLinkForGallery($image["images"][0]) ?>" target="new">
        <div class="image">
          <img src="<?= getThumbLinkForGallery($image["images"][0]) ?>" alt="">
          <br>
          views:<?= $image['view']; ?>
          <br>
          price: <?= $image['price']; ?>
          <br>
          <span><?= $image['notes'] ?></span>
        </div>
      </a>
    <?php endforeach;
    ?>
  </div>

</main>
</body>
</html>
