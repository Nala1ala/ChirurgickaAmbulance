<?php
namespace app\models\repositories;

use app\models\PDODatabase;
use PDO;

class DiagnosticRecordRepository implements DiagnosticRecordRepositoryInterface {
    private PDO $db;

    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Vrátí seznam diagnóz pacienta i s jejich názvy z číselníku
     */
    public function getRecordsWithNames(string $patientId): array {
        $sql = "SELECT dr.Date, d.Name as DiagnosisName, dr.Description
                FROM diagnostic_record dr
                JOIN diagnosis d ON dr.Diagnosis_id = d.Id
                WHERE dr.Patient_id = :patient_id
                ORDER BY dr.Date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':patient_id' => $patientId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}