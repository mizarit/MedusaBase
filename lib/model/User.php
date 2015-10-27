<?php

class User extends Base {
  public $model = 'user';
  protected $db = 'db_site';

  public $relations = array(
    'user' => array('user', 'id'),
  );
  
  public static function model()
  {
    return new User;
  }
/*
  public function getApiKey()
  {
    $connection = $this->getApiConnection();
    return $connection['api_key'];
  }

  public function getApiSecret()
  {
    $connection = $this->getApiConnection();
    return $connection['api_secret'];
  }

  public function getApiServer()
  {
    $connection = $this->getApiConnection();
    return $connection['api_server'];
  }

  public function createSiteLink($calendar_id)
  {
    $db = Registry::get('db_site');
    $rs1  = $db->query("SELECT id FROM company WHERE calendar_id = ".$calendar_id);
    $row = $rs1->fetch_assoc();
    $company_id = $row['id'];
    $db->query("INSERT INTO resource ( company_id, name, xid) VALUES ({$company_id}, '{$this->firstName}', '{$this->xid}')");
  }

  private function getApiConnection()
  {
    static $connection = false;
    if (!$connection) {
      $db = Registry::get('db_site');

      $sql = "SELECT company.id FROM company, resource WHERE resource.company_id = company.id AND resource.xid = '".$this->xid."'";
      $rs1 = $db->query($sql);
      if (!$rs1) return null;
      $row = $rs1->fetch_assoc();
      $company_id = $row['id'];
      $rs = $db->query("SELECT api_key, api_secret, api_server FROM connection WHERE company_id = ".$company_id." AND datatype = 'appointments' AND adapter = 'onlineafspraken'");
      if (!$rs)  return null;

      $connection = $rs->fetch_assoc();
    }
    return $connection;
  }
*/
}