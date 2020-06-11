<?php

//3. Сделать модель для любой сущности из БД.

interface IModel {
  public function Create(): IModel;
  public function Read(): IModel;
  public function Update(IModel $model);
  public function Delete(IModel $Model);
}

abstract class Repository implements IModel {
  abstract public function getAll(): array;
  abstract public function saveAll(array $models);
  abstract public function getByCondition(/* Condition $cond*/): array;
}

/*******************************************************************************************************/
abstract class DBRepository extends Repository {
  protected $db;

  abstract protected function getTable();
  /**
   * DBRepository constructor.
   */
  public function __construct()
  {
    //$db = mysqli_....
  }

  public function Create(): IModel {
    // $sql = "insert into {$this->getTable} ..."
  }
  public function Read(): IModel {
    // $sql = "select * from {$this->getTable} ... limit 1"
  }
  public function Update(IModel $model) {
    // $sql = "update {$this->getTable} ..."
  }

  public function Delete(IModel $mdel) {
    // $sql = "delete from {$this->getTable} ..."
  }

  public function getAll(): array {
    // get mysqli_fetch_array
  }
  public function saveAll(array $models) {
    // update ....
  }
  public function getByCondition(/* Condition $cond*/): array {
    // select * from {$getTable} where {$cond->prepare}
  }
}

/******************************************************************************************************/
abstract class FileRepository extends Repository {
  protected $fileSystem;

  abstract protected function getFileName();
  /**
   * FileRepository constructor.
   */
  public function __construct()
  {
    //$fileSystem = fopen(....
  }

  public function Create(): IModel {
    // $fileSystem->append(...)
  }
  public function Read(): IModel {
    // $fileSystem->get(...)
  }
  public function Update(IModel $model) {
  }

  public function Delete(IModel $Model) {
  }

  public function getAll(): array {
  }

  public function saveAll(array $models) {
  }

  public function getByCondition(/* Condition $cond*/): array {
  }
}

/*********************************************************************************************************/
class UserDbRepository extends DBRepository {
  protected function getTable() {
    return "users";
  }
}

class ProductDbRepository extends DBRepository {
  protected function getTable() {
    return "products";
  }
}

class UserFileRepository extends FileRepository {
  protected function getFileName() {
    return "users.dat";
  }
}

class ProductFileRepository extends FileRepository {
  protected function getFileName() {
    return "products.dat";
  }
}

/************************************************************************************************/
class Controller {

  /**
   * Controller constructor.
   */
  public function __construct(Repository $repo)
  {
  }
}

/*************************************************************************************************/
