<?php
namespace app\models\daos;
use app\models\dtos\DiagnosticRecord;
use app\models\PDO;
use app\models\PDODatabase;
use app\models\PDOException;

include_once \app\models\dtos\DiagnosticRecord::class;
class DiagnosticRecordDAO {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Saves a patient's new diagnostic record into the database
     * @param DiagnosticRecord $record DiagnosticRecord DTO
     * @return bool Insertion successful?
     */
    public function insertDiagnosticRecord(DiagnosticRecord $record): bool {
        $sql = "INSERT INTO diagnostic_record (Date, Patient_id, Diagnosis_id, Description) 
                VALUES (:date, :patient_id, :diagnosis_id, :description)";
        $stmt = $this->db->prepare($sql);

        try {
            return $stmt->execute([
                ':date' => $record->getDate(),
                ':patient_id' => $record->getPatientId(),
                ':diagnosis_id' => $record->getDiagnosisId(),
                ':description' => $record->getDescription()
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Gets all patient's diagnostic records
     * @param int $patientId Patient identifier
     * @return array of DiagnosticRecord DTOs
     */
    public function getRecordsByPatientId(int $patientId): array {
        $sql = "SELECT * FROM diagnostics WHERE Patient_id = :patient_id ORDER BY Date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':patient_id' => $patientId]);

        $records = [];
        while ($row = $stmt->fetch()) {
            $records[] = new DiagnosticRecord(
                $row['Date'], (int)$row['Patient_id'], (int)$row['Diagnosis_id'], $row['Description']
            );
        }
        return $records;
    }
}
?>