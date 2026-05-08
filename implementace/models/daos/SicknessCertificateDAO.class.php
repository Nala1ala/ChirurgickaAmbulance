<?php
namespace app\models\daos;
use app\models\PDODatabase;
use app\models\dtos\SicknessCertificate;
use PDO;

class SicknessCertificateDAO implements SicknessCertificateDAOInterface {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Gets yet not terminated certificates
     * @return array of SicknessCertificate DTOs
     */
    public function getActiveCertificates(): array {
        $sql = "SELECT * FROM sickness_certificate WHERE End_date IS NULL";
        $stmt = $this->db->query($sql);

        $certificates = [];
        while ($row = $stmt->fetch()) {
            $certificates[] = new SicknessCertificate(
                (int)$row['Patient_id'], $row['Date_beginning'], $row['Date_end'],
                $row['Active_address'], $row['Employer']
            );
        }
        return $certificates;
    }

    /**
     * Saves a patient's new certificate into the database
     * @param SicknessCertificate $cert SicknessCertificate DTO
     * @return bool Insertion successful?
     */
    public function insertCertificate(SicknessCertificate $cert): bool {
        $sql = "INSERT INTO sickness_certificate (Patient_id, Date_beginning, Date_end, Active_address, Employer) 
                VALUES (:patient_id, :start_date, :end_date, :address, :employer)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':patient_id' => $cert->getPatientId(),
            ':start_date' => $cert->getStartDate(),
            ':end_date' => $cert->getEndDate(), // Může být null
            ':address' => $cert->getActiveAddress(),
            ':employer' => $cert->getEmployer()
        ]);
    }

    // PU-09: Ukončit neschopenku (UPDATE existující)

    /**
     * Terminates a patient's sickness certificate
     * @param int $patientId Patient identifier
     * @param string $startDate
     * @param string $endDate
     * @return bool Update successful?
     */
    public function updateEndDate(int $patientId, string $startDate, string $endDate): bool {
        $sql = "UPDATE sickness_certificate SET Date_end = :end_date 
                WHERE Patient_id = :patient_id AND Date_beginning = :start_date";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':end_date' => $endDate,
            ':patient_id' => $patientId,
            ':start_date' => $startDate
        ]);
    }

    /**
     * Gets all patient's sickness certificates ordered by date issued
     * @param string $patientId Patient identifier
     * @return array of SicknessCertificate DTOs
     */
    public function getCertificatesByPatientId(string $patientId): array {
        $sql = "SELECT * FROM sickness_certificate WHERE Patient_id = :patient_id ORDER BY Date_beginning DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':patient_id' => $patientId]);

        $certificates = [];
        while ($row = $stmt->fetch()) {
            $certificates[] = new SicknessCertificate($patientId, $row['Date_beginning'], $row['Date_end'], $row['Active_address'], $row['Employer']);
        }

        return $certificates;
    }
}