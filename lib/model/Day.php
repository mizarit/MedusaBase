<?php

class Day extends Base {
  public $model = 'day';

  public $relations = array(
    'user' => array('user', 'id'),
  );

  public static function model()
  {
    return new Day;
  }
}