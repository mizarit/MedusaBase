<?php

class Notifier extends Base {
  public $model = 'notifier';

  public $relations = array(
    'user' => array('user', 'id'),
  );

  public static function model()
  {
    return new Notifier;
  }
}