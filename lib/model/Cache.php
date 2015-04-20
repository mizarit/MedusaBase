<?php

class Cache extends Base {
  public $model = 'cache';

  public $relations = array(

  );

  public static function model()
  {
    return new Cache;
  }
}