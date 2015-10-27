<?php
class Workorder extends Base {
  public $model = 'workorder';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Workorder;
  }
}
?>