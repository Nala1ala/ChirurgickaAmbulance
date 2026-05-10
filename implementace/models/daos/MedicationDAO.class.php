<?php
namespace app\models\daos;
use app\models\dtos\Medication;
use PDO;
use app\models\PDODatabase;

class MedicationDAO implements MedicationDAOInterface {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Gets a list of all medications from the database
     * @return Medication[] array of Medication DTOs
     */
    public function getAllMedicines(): array {
        $sql = "SELECT * FROM medication ORDER BY Name ASC";
        $stmt = $this->db->query($sql);

        $medicines = [];
        while ($row = $stmt->fetch()) {
            $medicines[] = new Medication(
                (int)$row['Id'],
                $row['Name'],
                $row['Medicinal_substance'],
                $row['Form']
            );
        }
        return $medicines;
    }

    /**
     * Gets a medication from database based on its id
     * @param int $id Medication identifier
     * @return Medication|null Medication DTO if exists
     */
    public function getMedicationById(int $id): ?Medication {
        $sql = "SELECT * FROM medication WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        return new Medication(
            (int)$row['Id'],
            $row['Name'],
            $row['Medicinal_substance'],
            $row['Form']
        );
    }
}
