<?php

class Credentials extends Base {
  public $model = 'credentials';
  protected $db = 'db_site';

  public $relations = array(
   // 'user' => array('user', 'id'),
  );

  public static function model()
  {
    return new Credentials;
  }
}