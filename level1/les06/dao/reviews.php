<?php
require_once(__DIR__ . "/../config/config.php");
require_once DAO;
require_once DAO_REVIEWS;

function addReviewForId($idProduct, string $author, string $text)
{
  $idProduct = htmlspecialchars(strip_tags($idProduct));
  $sql = "INSERT INTO `" . DB_REVIEWS_TABLE . "` (idProduct, author, text) VALUES ( '{$idProduct}', '{$author}', '{$text}' )";
  return dbExecute($sql);
}

function getReviewsForId($idProduct)
{
  $idProduct = htmlspecialchars(strip_tags($idProduct));
  $sql = "SELECT `id`, `author`, `text`, `time` FROM `" . DB_REVIEWS_TABLE . "` WHERE idProduct = '{$idProduct}' LIMIT 1000";
  return dbGetAll($sql);
}

function updateReviewForId($id, $newText)
{
  $id = htmlspecialchars(strip_tags($id));
  $sql = "UPDATE `" . DB_REVIEWS_TABLE . "` SET text='{$newText}' WHERE id = {$id}";
  return dbExecute($sql);
}

function deleteReview($id)
{
  $id = htmlspecialchars(strip_tags($id));
  $sql = "DELETE FROM `" . DB_REVIEWS_TABLE . "` WHERE id = ('{$id}')";
  return dbExecute($sql);
}
