<?php

class Hour extends Base {
  public $model = 'hour';

  public $relations = array(
    'day' => array('day', 'id'),
  );

  public static function model()
  {
    return new Hour;
  }
}