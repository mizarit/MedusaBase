<?php
class ProductCategory extends Base {
  public $model = 'product_category';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new ProductCategory;
  }
}
?>