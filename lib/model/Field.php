<?php
class Field extends Base {
  public $model = 'field';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Field;
  }
}
?>