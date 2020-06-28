<?php


namespace interfaces;


interface IModelRepo
{
//  function getTableName();

//  function toObject(array $dbData): IModel;

  // class name of used objects
  public function getClass(): string;
  // CRUD = C
  public function createObject(): IModel;
  // CRUD = R
  public function getById($id);
  // CRUD = U
  public function saveOrUpdate(IModel &$model);
  // CRUD = D
  public function deleteObject(IModel $model);
}
