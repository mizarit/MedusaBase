<?php

class Criteria
{
  private $validators;
  private $variables;
  private $order = false;
  
  public function __construct($validators = null, $variables = null, $order = null)
  {
    $this->validators = $validators;  
    $this->variables = $variables;  
    $this->order = $order;
  }
  
  public function sql()
  {
    $order = '';
    if ($this->order) {
      $order = ' ORDER BY '.$this->order;
    }
    if (is_array($this->validators)) {
      $wheres = array();
      foreach ($this->validators as $key => $value) {
        if (is_array($value)) {
          list($value, $method) = $value;
          if (is_array($value)) {
            // todo: escape when strings are passed
            $value = '('.implode(', ', $value).')';
          }
          else {
            $value = is_numeric($value) ? $value : "'{$value}'";
          }
          $wheres[] = "{$key} {$method} {$value}";
        }
        else {
          $value = is_numeric($value) ? $value : "'{$value}'";
          $wheres[] = "{$key} = {$value}";
        }
      }
      return 'WHERE '.implode(' AND ', $wheres).$order;
    }
    else if (is_string($this->validators)) {
      return 'WHERE '.call_user_func_array('sprintf', array_merge(array($this->validators), $this->variables)).$order;
    }
    return '';
  }
}