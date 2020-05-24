<?php

/**
 * Подключение к нужной нам БД
 * @return false|mysqli
 */
function dbConnect()
{
  static $db = null;
  if (is_null($db)) {
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSW);
    $useDB = mysqli_select_db($db, DB_GALLERY);
    if ($db === false && $useDB === false) {
      die("ERROR SELECT DB");
//      return false;
    }
  }
  return $db;
}

/**
 * Закрываем соединение с базой
 * @param $db
 */
function dbClose(&$db)
{
  mysqli_close($db);
  $db = null;
}

function dbExecute(string $sql)
{
  return mysqli_query(dbConnect(), $sql);
}

function dbGetAll(string $sql)
{
  $query = dbExecute($sql);
  return $query === false ? [] : mysqli_fetch_all($query, MYSQLI_ASSOC);
}

function dbGetOne(string $sql)
{
  return mysqli_fetch_assoc(dbExecute($sql));
}

