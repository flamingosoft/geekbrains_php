<?php
require_once(__DIR__ . "/config/config.php");
require_once(UTILS);

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
    <input type="file" name="image[]" multiple accept="image/jpeg, image/png, image/bmp, image/gif">
    <button type="submit">Upload</button>
  </form>
</div>

<main>
  <div class="explorer">
    <?php
    echo showFolder(DOCUMENT_ROOT);
    ?>
  </div>

  <div class="messages">
    <?php foreach ($uploaded as $oper): ?>
      <div class="<?= $oper["result"] ? "good" : "failed" ?>">
        <?= $oper["msg"] ?>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="gallery">
    <?php
    $gallery = getGalleryForFolder(DIR_IMAGES);
    foreach ($gallery as $image):
      ?>
      <div class="image">
        <a href="<?= getAnchorLinkForGallery($image) ?>" target="new">
          <img src="<?= getThumbLinkForGallery($image) ?>" alt="">
        </a>
      </div>
    <?php endforeach; ?>
  </div>

</main>
</body>
</html>

