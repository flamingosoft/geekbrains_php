<?php


namespace models;

use interfaces\IModel;

class User implements IModel
{
  public $id;
  public $name;
  public $hash;
  public $login;

  /**
   * User constructor.
   * @param $id
   * @param $name
   * @param $hash
   * @param $login
   */
  public function __construct($name, $login, $id = null)
  {
    $this->id = $id;
    $this->name = $name;
    $this->login = $login;
  }

}
