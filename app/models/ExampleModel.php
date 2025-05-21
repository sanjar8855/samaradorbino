<?php
namespace App\Models;

class ExampleModel {
    private $db;

    public function __construct() {
        $cfg = require __DIR__ . '/../../config/config.php';
        $this->db = Database::getInstance($cfg['db']);
    }

    public function getAllRegions(): array {
        $stmt = $this->db->query("SELECT * FROM regions ");
        return $stmt->fetchAll();
    }

    public function getAllCategories(): array {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll();
    }

    public function getAllWithCatId(int $catId): array {
        // – Prepared statement bilan xavfsizroq:
        $stmt = $this->db->prepare("
      SELECT * 
      FROM subcategories 
      WHERE category_id = :catId
    ");
        $stmt->execute(['catId' => $catId]);
        return $stmt->fetchAll();
    }

}
