<?php


namespace drivers;
use traits\Singleton;


abstract class dbDriver
{
  use Singleton;
  abstract static function getPDO();
}
