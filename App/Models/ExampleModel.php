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

    public function getAllWithCatId(int $catId): array {
        $stmt = $this->db->prepare("SELECT * FROM subcategories WHERE category_id = :catId");
        $stmt->execute(['catId' => $catId]);
        return $stmt->fetchAll();
    }

    /**
     * Berilgan subcategory ID bo'yicha perm_coeff qiymatini qaytaradi.
     *
     * @param int $subcatId
     * @return float|null — qiymat topilmasa null, topilsa float
     */
    public function getPermCoeffBySubcatId(int $subcatId): ?float
    {
        // faqat perm_coeff ustunini tanlaymiz
        $stmt = $this->db->prepare(
            'SELECT perm_coeff 
           FROM subcategories 
          WHERE id = :id 
          LIMIT 1'
        );
        // parametrni bog‘laymiz va so‘rovni bajarimiz
        $stmt->execute(['id' => $subcatId]);

        // bitta ustunni qaytaradi (false bo‘lsa topilmadi)
        $coeff = $stmt->fetchColumn();

        return ($coeff !== false)
            ? (float) $coeff
            : null;
    }

    /**
     * Berilgan qiymatga eng yaqin degrees_per_day qiymatiga ega
     * satrni aniqlaydi va uning id sini, shuningdek o‘zi va
     * degrees_per_day qiymatini qaytaradi.
     *
     * @param float $value
     * @return array|null  — ['id'=>…, 'degrees_per_day'=>…] yoki null
     */
    public function getClosestStandardHeat(float $value): ?array
    {
        $sql = "
              SELECT *
                FROM standard_heats
            ORDER BY ABS(degrees_per_day - :val)
               LIMIT 1
            ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['val' => $value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
