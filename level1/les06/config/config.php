<?php
define('DOCUMENT_ROOT',
  mb_substr(__DIR__, 0, mb_strlen(__DIR__) - mb_strlen("config/"))
);                                                          // корневая папка сайта
define('DIR_UPLOAD'     , DOCUMENT_ROOT . '/upload/');           // папкиа для загрузки
define('DIR_IMAGES'     , DOCUMENT_ROOT . '/images/');           // папка для изображений
define('DIR_THUMBNAILS' , DOCUMENT_ROOT . '/images/thumb/'); // папка для превьюх

define('DIR_VIEWS'      , DOCUMENT_ROOT . '/views/');             // папка для html шаблонов

define('API_UTILS'      , DOCUMENT_ROOT . "/api/utils.php");          // утилиты
define('API_WEB'        , DOCUMENT_ROOT . "/api/web.php");               // БД
define('API_REVIEWS'    , DOCUMENT_ROOT . "/api/reviews.php");               // БД
define('API_GALLERY'    , DOCUMENT_ROOT . "/api/gallery.php");               // БД

define('DAO'            , DOCUMENT_ROOT . "/dao/db.php");               // БД
define('DAO_REVIEWS'    , DOCUMENT_ROOT . "/dao/reviews.php");               // БД
define('DAO_GALLERY'    , DOCUMENT_ROOT . "/dao/gallery.php");               // БД

define('CONFIG'         , DOCUMENT_ROOT . '/config/config.php');     // конфиг

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSW", "root");
define("DB_GALLERY", "instagram");
define("DB_GALLERY_TABLE", "gallery");
define("DB_REVIEWS_TABLE", "reviews");

?>
