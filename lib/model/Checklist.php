<?php
class Checklist extends Base {
  public $model = 'checklist';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Checklist;
  }
}
?>