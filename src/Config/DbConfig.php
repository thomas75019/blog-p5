<?php

namespace Blog\Config;

/**
 * Class DbConfig
 *
 * Database configuration, modify it as you need
 *
 * @package Blog\Config
 */
class DbConfig
{
    public function DbInfo()
    {
        return [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'charset' => 'utf8',
            'user' => 'thomas',
            'password' => 'Kirsten75019',
            'dbname' => 'projet_5',
        ];
    }
}
