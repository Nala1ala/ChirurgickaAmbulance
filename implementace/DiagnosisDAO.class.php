<?php
include_once PDODatabase::class; include_once Diagnosis::class;
class DiagnosisDAO {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Gets all diagnoses from database
     * @return Diagnosis[] array of Diagnoses DTO
     */
    public function getAllDiagnoses(): array {
        $sql = "SELECT * FROM diagnosis ORDER BY name ASC";
        $stmt = $this->db->query($sql);

        $diagnoses = [];
        while ($row = $stmt->fetch()) {
            $diagnoses[] = new Diagnosis(
                (int)$row['id'],
                $row['name']
            );
        }
        return $diagnoses;
    }
}