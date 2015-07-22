<?php
class Company extends Base {
  public $model = 'company';
  protected $db = 'db_site';

  public $relations = array(
  );

  public static function model()
  {
    return new Company;
  }

  public function getSetting($key, $default = '')
  {
    $setting = Setting::model()->findByAttributes(new Criteria(array('company_id' => $this->id, 'skey' => $key)));
    if ($setting) {
      return $setting->svalue;
    }
    return $default;
  }
}
?>