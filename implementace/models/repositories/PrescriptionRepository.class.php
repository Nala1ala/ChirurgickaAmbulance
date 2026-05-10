<?php
namespace app\models\repositories;

use app\models\dtos\Prescription;
use app\models\PDODatabase;
use PDO;

class PrescriptionRepository implements PrescriptionRepositoryInterface {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Vrátí seznam receptů pacienta včetně názvu a formy léku
     */
    public function getPrescriptionsWithNames(string $patientId): array {
        $sql = "SELECT p.Date, m.Name as MedicineName, m.Form, p.Commentary, p.Medicine_Id
                FROM prescription p
                JOIN medication m ON p.Medicine_id = m.Id
                WHERE p.Patient_id = :patient_id
                ORDER BY p.Date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':patient_id' => $patientId]);

        $prescriptions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prescription = new Prescription($row['Date'], $patientId, (int)$row['Medicine_Id'], $row['Commentary']);
            $prescription->setMedicineName($row['MedicineName']);
            $prescription->setForm($row['Form']);
            $prescriptions[] = $prescription;
        }

        return $prescriptions;
    }
}
