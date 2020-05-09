<?php
define('DOCUMENT_ROOT',
  mb_substr(__DIR__, 0, mb_strlen(__DIR__) - mb_strlen("config/"))
);                                                          // корневая папка сайта
define('DIR_UPLOAD', DOCUMENT_ROOT . '/upload/');           // папкиа для загрузки
define('DIR_IMAGES', DOCUMENT_ROOT . '/images/');           // папка для изображений
define('DIR_THUMBNAILS', DOCUMENT_ROOT . '/images/thumb/'); // папка для превьюх
define('UTILS', DOCUMENT_ROOT . "/api/utils.php");          // утилиты
define('CONFIG', DOCUMENT_ROOT . '/config/config.php');     // конфиг
?>
