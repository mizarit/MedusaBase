<?php

class Route {
    public static function url($module, $action, $params = array()) {

    }

    public static function resolve()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        if(strlen($uri) == 0) {
          $uri = 'main/index';
      } else if ($uri[0]=='?') {
        $uri = 'main/index'.$uri;
      }
        $params = array();

        if (strstr($uri, '?')) {
            $args = substr($uri, strpos($uri, '?') + 1);
            parse_str($args, $params);
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

      if ($uri=='')$uri='main/index';

        $parts = explode('/', $uri);
        $module = array_shift($parts);
        $action = array_shift($parts);
        $p = 0;
        $k = '';

        foreach ($parts as $t) {
            if ($p == 0 || $p % 2 == 0) {
                $k = $t;
            }
            else {
                $params[$k] = $t;
            }
            $p++;
        }
        return array(
            'module' => $module?$module:'main',
            'action' => $action?$action:'index',
            'params' => $params,

        );
    }
}