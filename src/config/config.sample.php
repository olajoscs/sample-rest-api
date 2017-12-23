<?php

return [
    'database' => [
        'type'     => 'mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'database' => 'backend',
        'options'  => [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ],
    ],

    'error' => [
        'display' => true,
    ],
];
