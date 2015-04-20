<?php

class Entrycode extends Base {
  public $model = 'entrycode';

  public $relations = array(
    'challenge' => array('challenge', 'id'),
    'team' => array('team', 'id'),
  );

  public static function model()
  {
    return new Entrycode;
  }
}