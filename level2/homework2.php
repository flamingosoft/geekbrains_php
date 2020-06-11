<?php
/**
 * Домашняя работа №2 (в одном файле)
 */


abstract class ShopModel
{
  protected $shop;
  protected $title;

  /**
   * @return mixed
   */
  abstract public function getType();

  public function totalCost(Shop $shop, float $total): float
  {
    return $shop->getPrice($this) * $total;
  }
}

abstract class Shop
{
  abstract public function getPrice(ShopModel $product, float $volume);
}

class DigitalProduct extends ShopModel
{
  public function getType()
  {
    return "digital";
  }
}

class PiecesProduct extends ShopModel
{
  public function getType()
  {
    return "pieces";
  }

}

class WeightedProduct extends ShopModel
{
  public function getType()
  {
    return "weighted";
  }

}

class MiniShop extends Shop
{
  public function getPrice(ShopModel $product, float $volume)
  {
    $basePrice = 100;

    $price = [
      "digital" => $basePrice / 2,
      "pieces" => $basePrice,
      "weighted" => $volume * $volume * $basePrice,
    ];

    if (in_array($product->getType(), $price)) {
      return $price[$product->getType()];
    } else {
      return -1;
    }
  }

}
