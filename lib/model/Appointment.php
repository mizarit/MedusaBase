<?php
class Appointment extends Base {
  public $model = 'appointment';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Appointment;
  }
}
?>