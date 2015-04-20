<?php

class User extends Base {
  public $model = 'user';
  
  public $relations = array(
    'user' => array('user', 'id'),
  );
  
  public static function model()
  {
    return new User;
  }
}