<?php

class Actions {
    public function render()
    {
      
      header('Content-type: text/html;charset=utf-8');
      $tpl = 'lib/modules/'.$this->module.'/templates/'.$this->action.'Success.php';

      extract(get_object_vars($this));
      ob_start();
      require ($tpl);
      $content = ob_get_clean();
      require('templates/layout.php');
    }
}