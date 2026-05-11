<?php
namespace app\models\repositories;

use app\models\dtos\Diagnosis;
use app\models\dtos\DiagnosticRecord;
use app\models\PDODatabase;
use PDO;

/**
 * Repository for diagnostic records enriched with diagnosis names.
 */
class DiagnosticRecordRepository implements DiagnosticRecordRepositoryInterface {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Vrátí seznam diagnóz pacienta i s jejich názvy z číselníku
     */
    public function getRecordsWithNames(string $patientId): array {
        $sql = "SELECT dr.Date, d.Name as DiagnosisName, dr.Description, dr.Diagnosis_id
                FROM diagnostic_record dr
                JOIN diagnosis d ON dr.Diagnosis_id = d.Id
                WHERE dr.Patient_id = :patient_id
                ORDER BY dr.Date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':patient_id' => $patientId]);

        $records = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $record = new DiagnosticRecord($row['Date'], $patientId, (int)$row['Diagnosis_id'], $row['Description']);
            $diagnosis = new Diagnosis($row['Diagnosis_id'], $row['DiagnosisName']);
            $record->setDiagnosis($diagnosis);
            $records[] = $record;
        }

        return $records;
    }
}
