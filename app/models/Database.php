<?php
namespace App\Models;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct(array $cfg) {
        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['name']};charset={$cfg['charset']}";
        try {
            $this->pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("DB Ulash xatosi: " . $e->getMessage());
        }
    }

    public static function getInstance(array $cfg) {
        if (self::$instance === null) {
            self::$instance = new self($cfg);
        }
        return self::$instance->pdo;
    }
}
