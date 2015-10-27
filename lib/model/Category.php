<?php
class Category extends Base {
  public $model = 'category';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Category;
  }
}
?>