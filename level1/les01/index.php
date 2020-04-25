<?php
$year = date("Y");
$title = 'Noname Company';
$brand = 'Noname - best clothes';
$menu = array(
  "/" => "Home",
  "/catalog/" => "Catalog",
  "/about" => "About"
);
?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $title ?></title>

  <style>
    header {
      height: 50px;
      display: flex;
      background-color: wheat;
      align-items: center;
      padding: 10px;
    }

    footer {
      height: 40px;
      background-color: silver;
      line-height: 40px;
      padding: 0 10px;
    }
  </style>
</head>
<body>
<header>
  <div class="logo"><?= $brand ?></div>
</header>
<nav>
  <ul>
    <?php foreach ($menu as $key => $menuItem) { ?>
      <li><a href="<?=$key?>"><?=$menuItem?></a></li>
    <?php } ?>
  </ul>
</nav>
<footer>
  &copy; Noname company, <?= $year ?>
</footer>
</body>
</html>
