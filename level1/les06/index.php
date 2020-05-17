<?php
require_once __DIR__ . "/config/config.php";
require_once API_UTILS;

//$router = [
//  "image_full.php" => function() { return isset($_GET["id"]); },
//  "calc.php" => function() { return isset($_GET["calc"]); },
//  "main_template.php"=> function() { return true; }
//];

$router = [
  ["menu" => "/?gallery",
    "title" => "gallery",
    "func" => function () {
      return $_SERVER["QUERY_STRING"] === "gallery";
    },
    "template" => "main_template.php",],
  [
    "func" => function () {
      return isset($_GET["id"]);
    },
    "template" => "image_full.php",],
  [
    "menu" => "/?calc",
    "title" => "calculator",
    "func" => function () {
      return $_SERVER["QUERY_STRING"] === "calc";
    },
    "template" => "calc.php",
  ],
  [
    "menu" => "/",
    "title" => "main",
    "func" => function () {
      return $_SERVER["QUERY_STRING"] === "";
    },
    "template" => "main.php",
  ],
];

/**
 * Здесь типа роутинг :) если есть запрос по id, то показываем шаблон для полноразмерной картинки,
 * иначе показываем дерево папок и галерею с сортировкой по просмотрам
 */
$menu = [];
$template = "";

foreach ($router as $view) {
  if (isset($view["menu"])) {
    $menu[] = ["link" => $view["menu"], "anchor" => $view["title"],];
  }
  if ($template === "" && $view["func"]()) {
    $template = DIR_VIEWS . $view["template"];
  }
}

?>


<ul>
  <?php foreach ($menu as $item) : ?>
    <li><a href="<?= $item["link"] ?>"><?= $item["anchor"] ?></a></li>
  <?php endforeach; ?>
</ul>

<?php if(!empty($template)) { include $template; } ?>
