<?php

namespace models;

use interfaces\IModel;

class ProductRepo extends DbRepo
{
  public function __toString()
  {
    return "I am a product";
  }

  public function getTableName()
  {
    return "products";
  }

  public function createProduct(
    $notes,
    $price,
    $categoryId)
  {
    $prod = new Product($notes, $price, 0, $categoryId);
    return parent::create($prod);
  }

  public function toObject(array $dbData): IModel
  {
    return new Product(
      $dbData["notes"],
      $dbData["price"],
      $dbData["view"],
      $dbData["categoryId"],
      $dbData["id"]
    );
  }

}
