<?php
namespace app\models\daos;
use PDO;
use app\models\PDODatabase;
use PDOException;
use app\models\dtos\Prescription;

class PrescriptionDAO implements PrescriptionDAOInterface {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Saves a patient's new prescription into the database
     * @param Prescription $prescription Prescription DTO
     * @return bool Insertion successful?
     */
    public function insertPrescription(Prescription $prescription): bool {
        $sql = "INSERT INTO prescription (Date, Patient_id, Medicine_id, Commentary) 
                VALUES (:date, :patient_id, :medicine_id, :commentary)";
        $stmt = $this->db->prepare($sql);

        try {
            return $stmt->execute([
                ':date' => $prescription->getDate(),
                ':patient_id' => $prescription->getPatientId(),
                ':medicine_id' => $prescription->getMedicineId(),
                ':commentary' => $prescription->getCommentary()
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Gets all patients descriptions from the database
     * @param int $patientId Patient identifier
     * @return array of Prescription DTOs
     */
    public function getPrescriptionsByPatientId(string $patientId): array {
        $sql = "SELECT * FROM prescription WHERE Patient_id = :patient_id ORDER BY Date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':patient_id' => $patientId]);

        $prescriptions = [];
        while ($row = $stmt->fetch()) {
            $prescriptions[] = new Prescription(
                $row['Date'], (int)$row['Patient_id'], (int)$row['Medicine_id'], $row['Commentary']
            );
        }
        return $prescriptions;
    }
}