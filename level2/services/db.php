<?php


namespace services;

use drivers\MySQLDriver;
use PDO;
use traits\Singleton;


class Db
{
  use Singleton;
  protected static $dbObject = null;

  public function dbGetAll(string $sql, array $params = [])
  {
    return $this->dbExecute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
  }

  public function dbExecute(string $sql, array $params = [])
  {
    $request = $this->get()->prepare($sql);
    $request->execute($params);
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
