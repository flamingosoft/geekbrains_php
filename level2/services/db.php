<?php


namespace services;

use drivers\MySQLDriver;
use PDO;
use traits\Singleton;


class Db
{
  use Singleton;
  protected static $dbObject = null;

  public function dbGetObjects(string $class, string $sql, array $params = [])
  {
    $pdo = $this->dbExecute($sql, $params);
    $pdo->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
    return $pdo->fetchAll();
  }

  public function dbGetObject(string $class, string $sql, array $params = [])
  {
    $pdo = $this->dbExecute($sql, $params);
    $pdo->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
    return $pdo->fetch();
  }

  public function dbExecute(string $sql, array $params = [])
  {
    try {
      $request = $this->get()->prepare($sql);
      $request->execute($params);
//      var_dump($request->errorCode());
//      var_dump($request->errorInfo());
    }catch(Exception $err) {
      print_r($err);
    }
    return $request;
  }

  /**
   * @return PDO
   */
  protected static function get()
  {
    if (is_null(static::$dbObject)) {
      static::$dbObject = MySQLDriver::getPDO();
    }
    return static::$dbObject;
  }

  public function dbGetOne(string $sql, array $params = [])
  {
    return $this->dbExecute($sql, $params)->fetch(PDO::FETCH_ASSOC);
  }

  public function getLastInsertedID()
  {
    return $this->get()->lastInsertId();
  }

  public function __destruct()
  {
    static::$dbObject = null;
  }

}
