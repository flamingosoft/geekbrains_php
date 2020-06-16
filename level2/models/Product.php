<?php


namespace models;


class Product extends Model
{
  public $notes;
  public $price;
  public $view;
  public $categoryId;

  /**
   * Product constructor.
   * @param $notes
   * @param $price
   * @param $view
   * @param $categoryId
   * @param null|int $id
   */
  public function __construct($notes, $price, $view, $categoryId, $id = null)
  {
    $this->notes = $notes;
    $this->price = $price;
    $this->view = $view;
    $this->categoryId = $categoryId;
    $this->setId($id);
  }

}
