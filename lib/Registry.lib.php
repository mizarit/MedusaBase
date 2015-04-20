<?php

class Registry {
    static $register;

    public static function set($key, $value)
    {
        self::$register[$key] = $value;
    }

    public static function get($key, $default_value = '')
    {
        return isset(self::$register[$key]) ? self::$register[$key] : $default_value;
    }
}