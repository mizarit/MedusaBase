<?php
class ChecklistAppointment extends Base {
  public $model = 'checklist_appointment';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new ChecklistAppointment;
  }
}
?>