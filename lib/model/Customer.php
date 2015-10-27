<?php
class Customer extends Base {
  public $model = 'customer';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Customer;
  }
}
?>