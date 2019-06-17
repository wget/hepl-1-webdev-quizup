<?php

class Database {
    private static $instance = null;
    private static $connection;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct() {
        self::$connection = new PDO(
            "mysql:host=localhost;dbname=" . DATABASE_NAME,
            DATABASE_USERNAME,
            DATABASE_PASSWORD);
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getConnection() {
        if (self::$instance == null) {
            self::$instance = new DataBase();
        }

        return self::$connection;
    }
}
