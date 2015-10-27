<?php
class ChecklistValue extends Base {
  public $model = 'checklist_value';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new ChecklistValue;
  }
}
?>