<?php
class Invoice extends Base {
  public $model = 'invoice';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Invoice;
  }
}
?>