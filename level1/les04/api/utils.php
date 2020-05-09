<?php
require_once CONFIG;

/**
 * Принудительно создаёт иерархию каталогов для каждого элемента пути в массиве
 * @param string $Directory
 */
function forceDirectories(array $dirArray)
{
  foreach ($dirArray as $dir) {
    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }
  }
}

/**
 * генерит имя файла на основе имеющегося, заменяя путь, расширение и добаавляя префикс
 * @param string $dir
 * @param string $filename
 * @param string $ext
 * @param string $prefix
 * @return string
 */
function makeFilename(string $dir, string $filename, string $ext, string $prefix = "")
{
  $fn = pathinfo($filename);
  return $dir . $fn["filename"] . $prefix . "." . $ext;
}

/**
 * Формирует массив-ответ для функции acceptUploadedImage
 * @param bool $isOk
 * @param string $filename
 * @param string $msg
 * @return array
 */
function _answerUpload(bool $isOk, string $filename, string $msg = ""): array
{
  return [
    "result" => $isOk,
    "msg" => $isOk ?
      "accepted: {$filename}" :
      "${msg}: {$filename}"
  ];
}

/**
 * пытаемся принять заливаемые изображения. В случае успеха размещаем их в папке IMAGES, создавая превьюхи в папке THUMBNAils
 * возвращаем массив сообщений по каждому файлу
 * @param $_FILES [] $imgDataObject
 * @return array
 */
function acceptUploadedImage($imgDataObject)
{
  $result = [];
  for ($curImage = 0; $curImage < count($imgDataObject['name']); ++$curImage) {
    // тут есть идея для неподдерживаемых MIME создавать файл-заглушку, которая будет показываться для данного аплоада, чтобы обозначить
    // какой файл не подходит или загрузился с ошибкой, но будет потом затираться при следующем аплоаде
    if (!acceptedType($imgDataObject['type'][$curImage])) {
      $result[] = _answerUpload(false, $imgDataObject["name"][$curImage], "wrong type");
      continue;
    }

    $fileName = pathinfo($imgDataObject['name'][$curImage]);
    $newFileName = makeFilename(
      DIR_IMAGES,
      $imgDataObject['tmp_name'][$curImage],
      $fileName['extension']
    ); //DIR_IMAGES . basename($imgData['tmp_name']) . '.' . $fileName['extension'];
    $newFileNameThumb = makeFilename(
      DIR_THUMBNAILS,
      $imgDataObject['tmp_name'][$curImage],
      $fileName['extension']
    ); //DIR_UPLOAD . basename($imgData['tmp_name']) . '.' . $fileName['extension'];

    $success = move_uploaded_file($imgDataObject['tmp_name'][$curImage], $newFileName);

    if (!$success) {
      $result[] = _answerUpload(false, $imgDataObject["name"][$curImage], "unknown error");
      continue;
    }

    try {
      generateThumbnail($newFileName, $newFileNameThumb, 100);
    } catch (Exception $exc) {
      $result[] = _answerUpload(false, $imgDataObject["name"][$curImage], "wrong processing...");
      continue;
    }
    $result[] = _answerUpload(true, $imgDataObject["name"][$curImage]);
  }
  return $result;
}

/**
 * Создаём превьюхи для файла с изображением размера size
 * @param string $filename файл исходного изображения
 * @param string $thumbFilename файл, куда положим превьюху
 * @param int $size размер превьюхи
 * @throws ImagickException
 */
function generateThumbnail(string $filename, string $thumbFilename, int $size)
{
  $image = new Imagick($filename);
  $image->thumbnailImage($size, 0 /* auto proportion */);
  $image->writeImage($thumbFilename);
}

/**
 * Проверяем, соответствует ли тип нашим критериям (MIME TYPE должен быть изображением)
 * @param string $type
 * @return bool
 */
function acceptedType(string $type)
{
  return strpos($type, "image/") !== FALSE;
}

/**
 * Проверяем, заливают ли нам в этом сеансе изображения
 * @return bool
 */
function ifUploadingImages()
{
  return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']);
}

/**
 * Возвращает массив имен файлов для галереи для заданной папки
 * @param $folder
 * @return array
 */
function getGalleryForFolder($folder)
{
  return array_filter(scandir($folder),
    function ($image) use ($folder) {
      return !is_dir($folder . $image);
    });
}

/**
 * для превьюхи на диске создаем web-аналог ссылки
 * @param $image
 * @return string|string[]
 */
function getThumbLinkForGallery($image)
{
  return str_replace(DOCUMENT_ROOT, "", DIR_THUMBNAILS . $image);
}

/**
 * Для изображения на диске создаём web-аналог ссылки
 * @param $image
 * @return string|string[]
 */
function getAnchorLinkForGallery($image)
{
  return str_replace(DOCUMENT_ROOT, "", DIR_IMAGES . $image);
}

/**
 * Показываем дерево файлов и папок. Функция не чистая, болье для демонстрации
 * @param string $folder
 * @param int $level
 * @return string
 */
function showFolder(string $folder, $level = 0)
{
  $output = "";
  // получим файлы и папки без "корневых" папок прежнего уровня
  $files = array_filter(
    scandir($folder), function ($file) {
    return $file[0] != '.';
  });
  // отсортируем так, чтобы папки были сверху
  usort($files,
    function ($lhs, $rhs) use ($folder) {
      $isLeftFolder = is_dir($folder . "/" . $lhs);
      $isRightFolder = is_dir($folder . "/" . $rhs);
      if ($isLeftFolder & $isRightFolder) {
        return strcasecmp($lhs, $rhs);
      } else {
        return $isRightFolder - $isLeftFolder;
      }
    }
  );
  // сгенерим верстку
  foreach ($files as $item) {
    if (is_dir($folder . "/" . $item)) {
      $output .= "<details><summary class='folder level-{$level}'>" . mb_strtoupper($item) . "</summary> " . showFolder($folder . "/" . $item, $level + 1) . "</details>";
    } else {
      $output .= "<div class='file level-{$level}'>" . $item . "</div>";
    }
  }
  return $output;
}

?>
