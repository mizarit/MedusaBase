<?php
class Setting extends Base {
  public $model = 'setting';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Setting;
  }
}
?>