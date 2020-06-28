<?php

namespace models;

use interfaces\IModel;

class ProductRepo extends DbRepo
{

  public function __construct()
  {
    parent::__construct();
    $this->props = $this->createObject()->getDBProps();
  }

  public function createObject(): IModel
  {
    return new Product();
  }

  public function __toString()
  {
    return "I am a product";
  }

  public function createProduct(
    $notes,
    $price,
    $categoryId): Product
  {
    echo "create product ";
    $prod = $this->createObject();
    $prod->notes = $notes;
    $prod->price = $price;
    $prod->categoryId = $categoryId;
    $prod->view = 0;

//    var_dump($prod);
    return $prod;
  }

  public function getTableName()
  {
    return "products";
  }

  public function getClass(): string {
    return Product::class;
  }
}
