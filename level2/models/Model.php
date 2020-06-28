<?php


namespace models;

use interfaces\IModel;

abstract class Model implements IModel
{
  protected $id;
  protected $dbProps = ["id"];
  protected $changedProps = [];

  public function getId()
  {
    return $this->id;
  }

  public function getIdName()
  {
    return "id";
  }

  public function __set($name, $value)
  {
    if (property_exists($this, $name)) {
      if ($this->$name !== $value) {
        $this->$name = $value;
        if  (in_array($name, $this->dbProps)) {
          $this->changedProps[] = $name;
        }
      }
    }
  }

  public function __get($name)
  {
    if (property_exists($this, $name)) {
      return $this->$name;
    }
  }

  public function getDBProps(): array
  {
    return $this->dbProps;
  }

  public function getChangesProps(): array {
    return $this->changedProps;
  }
}
