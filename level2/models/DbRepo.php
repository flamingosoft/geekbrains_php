<?php


namespace models;

use interfaces\IModel;
use interfaces\IModelRepo;
use services\Db;


abstract class DbRepo implements IModelRepo
{
  /**
   * @var db|null
   */
  protected $db = null;

  /**
   * ModelRepo constructor.
   */
  public function __construct()
  {
    $this->db = Db::getInstance();
  }

  public function getAll(array $properties = []): array
  {
    $sql = "SELECT {$this->prepareFields($properties)} FROM {$this->getTableName()}";
    return $this->arrayToObjectArray($this->db->dbGetAll($sql, []));
  }

  protected function prepareFields(array $properties)
  {
    return empty($properties) ? "*" : join(", ", $properties);
  }

  protected function arrayToObjectArray(array $objects)
  {
    return array_map(function ($item) {
      return $this->toObject($item);
    }, $objects);
  }

  public function getById($id, array $properties = [])
  {
    $sql = "SELECT {$this->prepareFields($properties)} FROM {$this->getTableName()} WHERE id = :id";
    return $this->toObject($this->db->dbGetOne($sql, ['id' => $id]));
  }

  protected function delete(IModel $model)
  {
    $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id";
    return $this->db->dbExecute($sql, ["id" => $model->getId()]);
  }

  protected function create(IModel &$model)
  {
    $keyVal = $this->getKeyValues($model);

    $sql = "INSERT INTO {$this->getTableName()} ({$keyVal["keys"]}) VALUES ({$keyVal["values"]})";
    $this->db->dbExecute($sql);

    $model->setId($this->db->getLastInsertedID());
    return $model;
  }

  protected function getKeyValues(IModel $model): array
  {
    $newModel = array_filter((array)$model,
      function ($item) {
        return !is_null($item) && mb_substr($item, 0, 1) != "*";
      }
    );

    $values = join(", ", array_map(function ($item) {
      return "'{$item}'";
    }, $newModel));

    $keys = join(",", array_keys($newModel));
    return ["keys" => $keys, "values" => $values];
  }
}
