<?php


namespace interfaces;


interface IModelRepo
{
  function getTableName();

  function toObject(array $dbData): IModel;
}
