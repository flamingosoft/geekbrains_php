<?php


namespace traits;


trait Singleton
{

  private static $instance = null;

  private function __construct()
  {
  }

  static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function out()
  {
  }

  private function __wakeup()
  {
  }

  private function __clone()
  {
  }

}
