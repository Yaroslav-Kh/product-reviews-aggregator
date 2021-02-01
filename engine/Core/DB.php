<?php


namespace Engine\Core;

use PDO;

use Engine\Libraries\Helpers;

abstract class DB
{

    public $db;


    public function __construct()
    {
        $config = loadFile('config','db');

        $host       = $config['host'];
        $username   = $config['username'];
        $password   = $config['password'];
        $database   = $config['database'];
        $charset    = $config['charset'];


        $dsn = "mysql:host=$host;dbname=$database;charset=$charset";

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        $this->db = new PDO($dsn, $username, $password, $opt);
    }

}