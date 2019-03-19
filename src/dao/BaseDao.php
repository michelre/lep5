<?php

namespace App\Dao;

use PDO;

class BaseDao
{
    protected $db;

    public function __construct()
    {

        $env = parse_ini_file(__DIR__ . '/../../.env');

        $this->db = new PDO('mysql:host=' . $env['database_host'] . ';dbname=' . $env['database_name'], $env['database_user'], $env['database_password']);
    }

}


