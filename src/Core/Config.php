<?php

namespace App\Core;

class Config
{
    private static $config = [];

    public static function load($file)
    {
        if (file_exists($file)) {
            self::$config = require $file;
        }
    }

    public static function get($key, $default = null)
    {
        return self::$config[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        self::$config[$key] = $value;
    }
} 