<?php


namespace interfaces;


interface IModel
{
  public function getIdName();
  public function getId();
  public function getDBProps(): array;
  public function getChangesProps(): array;
}
