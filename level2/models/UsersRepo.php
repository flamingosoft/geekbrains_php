<?php


namespace models;


use interfaces\IModel;

class UsersRepo extends DbRepo
{
  public function __toString()
  {
    return "I am a users";
  }

  public function getTableName()
  {
    return "users";
  }

  public function createUser(
    $name,
    $login,
    $password)
  {
    $user = new User($name, $login);
    $user->hash = $this->getHash($password);
    return parent::create($user);
  }

  function getHash(string $password)
  {
    return sha1($password . "geekbrains");
  }

  public function toObject(array $dbData): IModel
  {
    $user = new User(
      $dbData["name"],
      $dbData["login"],
      $dbData["id"]
    );
    $user->hash = $dbData["hash"];
    return $user;
  }

}
