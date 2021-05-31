<?php

namespace App\Core;

use PDO;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (is_null(self::$connection)) {
            $dbHost = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];
            $dbUsername = $_ENV['DB_USERNAME'];
            $dbPassword = $_ENV['DB_PASSWORD'];

            $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection = $dbConnection;
        }
        return self::$connection;
    }
}