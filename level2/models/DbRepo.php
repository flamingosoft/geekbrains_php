<?php


namespace models;

use Exception;
use interfaces\IModel;
use interfaces\IModelRepo;
use services\Db;


abstract class DbRepo implements IModelRepo
{
  /**
   * @var db|null
   */
  protected $db = null;
  protected $props = null;

  /**
   * ModelRepo constructor.
   */
  public function __construct()
  {
    $this->db = Db::getInstance();
  }

  // CRUD = C

  /**
   * @param $id
   * @return IModel|mixed
   * @throws Exception
   */
  public function getById($id)
  {
    $props = implode(",", $this->props);
    $table = $this->getTableName();
    $product = $this->createObject();
    $idName = $product->getIdName();
    $values = [":{$idName}" => $id];
    $sql = "SELECT {$props} FROM {$table} WHERE {$idName} = :{$idName}";

    $class = $this->getClass();
    $object = $this->db->dbGetObject($class, $sql, $values);
    return $object;
  }

  public function createObject(): IModel
  {
    return new $this->getClass();
  }

  // CRUD = R

  public function getClass(): string
  {
    throw new Exception("method is not implementation");
  }
  // CRUD = U

  /**
   * @param Product $model
   */
  public function saveOrUpdate(IModel &$model)
  {
    if (is_null($model->getId())) {
      assert($this->save($model));
      $idName = $model->getIdName();
      $model->$idName = $this->db->getLastInsertedID();
    } else {
      $this->update($model);
    }
    //TO DO: reset changedProps in model
  }

  // CRUD = D

  /**
   * @param IModel $model
   * @return bool|\PDOStatement
   */
  private function save(IModel $model)
  {
    $request = $this->prepareRequest($model, true, false);
//
//    $table = $this->getTableName();
//    $fields = array_filter($model->getDBProps(), function ($item) use ($model) {
//      return $item !== $model->getIdName();
//    }); // для создания объекта берем все поля
//    $values = [];
//
//    $vars = array_filter(array_map(function ($item) use (&$values, $model) {
//      $values[":{$item}"] = $model->$item;
//      return ":{$item}";
//    }, $fields));
//    $vars = implode(",", array_keys($values));
//    $idName = $model->getIdName();
//    $fields = implode(",", $fields);
    $sql = "INSERT INTO {$request["table"]} ({$request['fields']}) VALUES ({$request['keys']})";
    $res  = $this->db->dbExecute($sql, $request['values']);
    return $res->errorCode() == 0 ? $res: false;
  }

  public function prepareRequest(IModel $model, $allProps = false, $withId = true): array
  {
    $table = $this->getTableName();
    $idName = $model->getIdName();
    $fields = $allProps ? $model->getDBProps() : $model->getChangesProps(); // для создания объекта берем все поля
    if (!$withId) {
      $fields = array_diff($fields, ["id"]);
    }
    $setVals = [];
    foreach ($fields as $item) {
      $values[":{$item}"] = /*is_null($model->$item) ? "null": */$model->$item;
      $setVals[] = "{$item} = :{$item}";
    }
    return [
      "table" => $this->getTableName(),
      "set" => implode(",", $setVals),
      "values" => $withId ? array_merge($values, [":{$idName}" => $model->getId()]) : $values,
      "keys" => implode(",", array_keys($values)),
      "fields" => implode(",", $fields),
      "id" => $idName,
    ];
  }

  private function update(IModel $model)
  {
    $request = $this->prepareRequest($model, false, true);
    $sql = "UPDATE {$request['table']} set {$request["set"]} WHERE {$request['id']} = :{$request['id']} ";
    return $this->db->dbExecute($sql, $request["values"]);
  }

  public function deleteObject(IModel $model): bool
  {
    $request = $this->prepareRequest($model);
//    $table = $this->getTableName();
//    $values = [":id" => $model->getId()];
//    $idName = $model->getIdName();
    $sql = "DELETE FROM {$request['table']} WHERE {$request['id']} = :{$request['id']} ";
    $params = [":{$request["id"]}" => $request['values'][':id']];
    return $this->db->dbExecute($sql, $params)->errorCode() == 0;
  }

  public function getAll(): array
  {
    $props = implode(",", $this->props);
    $table = $this->getTableName();
    $product = $this->createObject();
    $idName = $product->getIdName();
    $values = [];
    $sql = "SELECT {$props} FROM {$table}";

    $class = get_class($product);
    $object = $this->db->dbGetObjects($class, $sql, $values);
    return $object;
  }
  //  {
//    $sql = "SELECT {$this->prepareFields($properties)} FROM {$this->getTableName()}";
//    return $this->arrayToObjectArray($this->db->dbGetAll($sql, []));
//  }

//  protected function prepareFields(array $properties)
//  {
//    return empty($properties) ? "*" : join(", ", $properties);
//  }
//
//  protected function arrayToObjectArray(array $objects)
//  {
//    return array_map(function ($item) {
//      return $this->toObject($item);
//    }, $objects);
//  }
//
//  public function getById($id, array $properties = [])
//  {
//    $sql = "SELECT {$this->prepareFields($properties)} FROM {$this->getTableName()} WHERE id = :id";
//    return $this->toObject($this->db->dbGetOne($sql, ['id' => $id]));
//  }
//
//  protected function delete(IModel $model)
//  {
//    $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id";
//    return $this->db->dbExecute($sql, ["id" => $model->getId()]);
//  }
//
//  protected function createModel(IModel &$model)
//  {
//    $keyVal = $this->getKeyValues($model);
//
//    $sql = "INSERT INTO {$this->getTableName()} (" .
//      implode(",", array_keys($keyVal))
//      . ") VALUES (" .
//      implode(",", array_map(function ($item) {
//        return ":" . $item;
//      }, array_keys($keyVal)))
//      . ")";
//
//    var_dump($sql);
//    var_dump(array_values($keyVal));

//    $this->db->dbExecute($sql, $keyVal);
//    $model->id = $this->db->getLastInsertedID();
//
//    return $model;
//  }
//

  protected function getKeyValues(IModel $model): array
  {
    $newModel = array_filter((array)$model,
      function ($item) {
        return !is_null($item) && mb_substr($item, 0, 1) != "*";
      }
    );

    $values = [];
    $params = [];

    foreach ($model as $key => $value) {
      $params["{$key}"] = $value;
    }

    return $params;

    $keys = join(",", array_keys($newModel));
    return ["keys" => $keys, "params" => $params, "values" => $values];
  }
}
