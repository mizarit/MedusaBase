<?php
class Payment extends Base {
  public $model = 'payment';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Payment;
  }
}
?>