<?php

namespace drivers;

use PDO;

class MySQLDriver extends DbDriver
{
  public static function getPDO()
  {
    //var_dump("create PDO instance");
    return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
      DB_USER,
      DB_PASSW
    );
  }
}

