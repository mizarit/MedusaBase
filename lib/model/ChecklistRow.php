<?php
class ChecklistRow extends Base {
  public $model = 'checklist_row';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new ChecklistRow;
  }
}
?>