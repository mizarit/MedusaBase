<?php
class Product extends Base {
  public $model = 'product';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Product;
  }
}
?>