<?php

class Base
{
  public $values = array();
  protected $relations = array();
  protected $db = 'db';

  public function prefix()
  {
    return '';
  }
  
  public function table()
  { 
    return $this->prefix().$this->model;
  }
  
  public function __get($key)
  {
    if (isset($this->values[$key])) {
      return $this->values[$key];
    }
    
    // try to find it in relations
    if (isset($this->relations[$key])) {
      // autoload the relation
      if (is_string($this->relations[$key])) {
        // simple one-to-many relation
        list($foreign_table, $foreign_key) = explode('_', $this->relations[$key]);
        
        $local_key = $this->{$this->prefix().$this->relations[$key]};
        $class = $this->classMap($foreign_table);
        $object = $class::model()->findByPk($local_key);
        $this->values[$key] = $object;
        return $object;
      }
      else {
        // many-to-?
        $foreign_table = $this->prefix().$this->relations[$key][0];
        $foreign_key = $this->table().'_'.$this->relations[$key][1];
        $local_key = $this->{$this->relations[$key][1]};
        $class = $this->classMap($this->relations[$key][0]);
        $peer = $class::model();
        $objects = $peer->findAllByAttributes(new Criteria(array($foreign_key => $local_key)));
        if (strpos($this->relations[$key][0], '_')) {
          $parts = explode('_', $this->relations[$key][0]);
          $class = $this->classMap($parts[1]);
          if (class_exists($class)) {
            // many-to-many
            $objects2 = array();
            foreach ($objects as $object) {
              $k = $this->prefix().$parts[1].'_'.$this->relations[$key][1];
              $object2 = $class::model()->findByPk($object->$k);
              if ($object2) {
                $object2->link = $object;
                $objects2[] = $object2;
              }
            }
            $objects = $objects2;
          }
        }
        
        if (isset($this->relations[$key][2]) && $this->relations[$key][2]) {
          // return single object
          $objects = array_shift($objects);
        }
      }
      
      $this->values[$key] = $objects;
      return $objects;
    }
    
    return null;
  }
  
  public function __set($key, $value)
  {
    $this->values[$key] = $value;
  }
  
  private function classMap($model)
  {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $model)));
  }

  private function get_row($sql)
  {
    $db = Registry::get($this->db);

    $rs = $db->query($sql);
    if (!$rs) {
      return null;
    }
    $row = $rs->fetch_assoc();
    return $row;
  }

  private function get_results($sql)
  {

    $db = Registry::get($this->db);
    $return = array();

    $rs = $db->query($sql);
    if (!$rs) {
      return $return;
    }

    while($row = $rs->fetch_assoc()) {
      $return[] = $row;
    }
    return $return;
  }

  private function get_var($sql)
  {

  }

  public function delete($id = null)
  {
    if (!$id) {
      $id = $this->id;
    }

    $db = Registry::get($this->db);

    $sql = sprintf('DELETE FROM %s WHERE id = %s', $this->table(), $id);
    return $db->query($sql);
  }

  public function findByPk($pk)
  {
    $row = $this->get_row(sprintf('SELECT * FROM %s WHERE id = %s', $this->table(), (int)$pk));
    if (!$row) {
      return null;
    }

    $class = $this->classMap($this->model);
    $object = new $class;
    foreach ($row as $key => $value) {
      $object->$key = $value;
    }
    return $object;
  }
  
  public function findByAttributes($criteria = null)
  {

    $where = $criteria?$criteria->sql():'';
    $sql = sprintf('SELECT * FROM %s %s LIMIT 1', $this->table(), $where);
    $records = $this->get_results($sql);
    $return = array();
    $class = $this->classMap($this->model);
    foreach ($records as $record) {
      $object = new $class;
      foreach ($record as $key => $value) {
        $object->$key = $value;
      }
      return $object;
    }
    return null;
  }
  
  public function findAll()
  {
    $records = $this->get_results(sprintf('SELECT * FROM %s', $this->table()));
    $return = array();
    $class = $this->classMap($this->model);
    foreach ($records as $record) {
      $object = new $class;
      foreach ($record as $key => $value) {
        $object->$key = $value;
      }
      $return[] = $object;
    }
    return $return;
  }
  
  public function findAllByAttributes($criteria = null)
  {
    $where = $criteria?$criteria->sql():'';
    $sql = sprintf('SELECT * FROM %s %s', $this->table(), $where);
    //echo $sql;
    $records = $this->get_results($sql);
    $return = array();
    $class = $this->classMap($this->model);
    foreach ($records as $record) {
      $object = new $class;
      foreach ($record as $key => $value) {
        $object->$key = $value;
      }
      $return[] = $object;
    }
    return $return;
  }
  
  public function count($criteria = null)
  {
    $where = $criteria?$criteria->sql():'';
    $sql = sprintf('SELECT COUNT(*) as c FROM %s %s', $this->table(), $where);
    $row = $this->get_results($sql);
    return $row[0]['c'];
  }

  public function deleteAll($criteria)
  {
    
  }
  
  public function save($forceNew = false, $send = false)
  {
    $db = Registry::get($this->db);

    $values = $this->values;
    foreach ($values as $k => $v) {
      $x = json_decode($v);
      if (!$x) {
        $values[$k] = addslashes($v);
      }
    }
    //echo '<pre>';
    if (isset($values['id']) && $forceNew === false) {
      $id = $values['id'];
      unset($values['id']);
      $fields = array();
      foreach ($values as $key => $value) {
        if (isset($this->relations[$key])) continue;
        //if ($value) {
          if (is_numeric($value)) {
            $fields[] = "`{$key}` = {$value}";
          }
          else if (is_null($value)) {
            $fields[] = "`{$key}` = NULL";
          }
          else {
            $value = $db->real_escape_string($value);
            $fields[] = "`{$key}` = '{$value}'";
          }
        //}
      } 
      $sql = sprintf('UPDATE %s SET %s WHERE id = %s', $this->table(), implode(', ', $fields), $id);
      //echo $sql."\n";
      //var_dump($wpdb->query($sql));
      $db->query($sql);
    }
    else {
      foreach ($this->relations as $key => $value) {
        unset($values[$key]);
      }
      $fields = '`'.implode('`, `', array_keys($values)).'`';
      $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table(), $fields, "'".implode("', '", array_values($values))."'");
      //echo $sql;

      $db->query($sql);
      $this->id = $db->insert_id;
      
      if ($send) {
        //mail('ricardo.matters@mizar-it.nl', 'SQL', $sql."\n\nInsert ID ".$this->id);
      }
    }
   // var_dump($this->values);
   // echo $sql;
  }
}