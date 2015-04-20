<?php

class Message extends Base {
  public $model = 'message';

  public $relations = array(
    'challenge' => array('challenge', 'id'),
    'team' => array('team', 'id'),
    'user' => array('user', 'id'),
  );

  public static function model()
  {
    return new Message;
  }
}