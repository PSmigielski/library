<?php

namespace App\Model;

use PDO;
use PDOException;

class Dbh
{
    protected function connect()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ":" . DB_PORT . ";dbname=" . DB_DATABASE_NAME . ";";
            $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
