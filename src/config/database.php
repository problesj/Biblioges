<?php

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'bibliografia'),
            'username' => env('DB_USERNAME', 'biblioges'),
            'password' => env('DB_PASSWORD', 'joyal2025$'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],
    ],
]; 