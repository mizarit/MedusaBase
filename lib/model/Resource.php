<?php
class Resource extends Base {
  public $model = 'resource';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Resource;
  }
}
?>