<?php

namespace App\Libs;

use PDO;


final class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $dns = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DB . ';charset=utf8';
        $this->pdo = new PDO($dns, DB_USER, DB_PASS);
    }

    public static function getInstance(): Database
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
