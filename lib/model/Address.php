<?php
class Address extends Base {
  public $model = 'address';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Address;
  }
}
?>