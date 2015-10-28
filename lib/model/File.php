<?php
class File extends Base {
  public $model = 'file';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new File;
  }
}
?>