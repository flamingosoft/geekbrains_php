<?php

define('DOCUMENT_ROOT',
  mb_substr(__DIR__, 0, mb_strlen(__DIR__) - mb_strlen("config/"))
);// корневая папка сайта

define('DIR_ENGINE'     , DOCUMENT_ROOT . '/engine/');          // движок типа
define('DIR_LAYOUT'     , DOCUMENT_ROOT . '/layout/');
define('DIR_UPLOAD'     , DOCUMENT_ROOT . '/upload/');          // папкиа для загрузки
define('DIR_IMAGES'     , DOCUMENT_ROOT . '/images/');          // папка для изображений
define('DIR_THUMBNAILS' , DOCUMENT_ROOT . '/images/thumb/');    // папка для превьюх

define('DIR_VIEWS'      , DOCUMENT_ROOT . '/views/');           // папка для html шаблонов
define('DIR_PAGES'      , DOCUMENT_ROOT . '/public/');          // страницы
define('API_UTILS'      , DOCUMENT_ROOT . "/api/utils.php");    // утилиты
define('API_WEB'        , DOCUMENT_ROOT . "/api/web.php");      // БД
define('API_REVIEWS'    , DOCUMENT_ROOT . "/api/reviews.php");  // БД
define('API_PRODUCTS'   , DOCUMENT_ROOT . "/api/products.php"); // БД
define('API_AUTH'       , DOCUMENT_ROOT . "/api/auth.php");     // БД

define('DAO'            , DOCUMENT_ROOT . "/dao/db.php");       // БД
define('DAO_REVIEWS'    , DOCUMENT_ROOT . "/dao/reviews.php");  // БД
define('DAO_PRODUCTS'   , DOCUMENT_ROOT . "/dao/products.php"); // БД
define('DAO_CART'       , DOCUMENT_ROOT . "/dao/cart.php");     // БД
define('DAO_ORDER'      , DOCUMENT_ROOT . "/dao/order.php");     // БД

define('CONFIG'         , DOCUMENT_ROOT . '/config/config.php');// конфиг

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSW", "root");
define("DB_PRODUCTS", "instagram");
define("DB_NAME", "instagram");
define("DB_PRODUCTS_TABLE", "products");
define("DB_REVIEWS_TABLE", "reviews");

session_start();

//require_once DIR_ENGINE . "autoload.php";
