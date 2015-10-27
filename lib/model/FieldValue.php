<?php
class FieldValue extends Base {
  public $model = 'field_value';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new FieldValue;
  }
}
?>