<?php
namespace app\models\daos;
use app\models\dtos\Patient;
use app\models\PDO;
use app\models\PDODatabase;
use Exception;
use PDOException;

/**
 * Data access object for Patient
 */
class PatientDAO {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Saves a new patient into the database
     * @param Patient $patient Patient DTO
     * @return bool Saving successful?
     * @throws Exception Insertion error
     */
    public function insertPatient(Patient $patient): bool {
        $sql = "INSERT INTO patient (Birth_certificate_number, Given_name, Surname, Permanent_address, Insurance_company_number, Telephone_number, Birthdate) 
                VALUES (:bcn, :given_name, :surname, :address, :icn, :phone, :birthdate)";

        $stmt = $this->db->prepare($sql);

        try {
            return $stmt->execute([
                ':bcn' => $patient->getBirthCertificateNumber(),
                ':given_name' => $patient->getGivenName(),
                ':surname' => $patient->getSurname(),
                ':address' => $patient->getAddress(),
                ':icn' => $patient->getInsuranceCompanyNumber(),
                ':phone' => $patient->getPhoneNumber(),
                ':birthdate' => $patient->getBirthdate()
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new Exception("Pacient s tímto rodným číslem již existuje.");
            }
            throw $e;
        }
    }

    /**
     * Requests patients data from database based on birth certificate number (identifier))
     * @param int $birthCertificateNumber Patient identifier
     * @return Patient|null Patient DTO if patient exists
     */
    public function getPatientById(int $birthCertificateNumber): ?Patient {
        $sql = "SELECT * FROM patient WHERE Birth_certificate_number = :bcn";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':bcn' => $birthCertificateNumber]);

        $row = $stmt->fetch();

        if (!$row) {
            return null; // Patient not found
        }

        return new Patient(
            (int)$row['Birth_certificate_number'],
            $row['Given_name'],
            $row['Surname'],
            $row['Permanent_address'],
            (int)$row['Insurance_company_number'],
            $row['Telephone_number'],
            $row['Birthdate']
        );
    }

    /**
     * Searches for a patient in database by name/surname
     * @param string $nameQuery Patient's name/surname query
     * @return array of Patient DTOs
     */
    public function searchPatientsByName(string $nameQuery): array {
        $sql = "SELECT * FROM patient WHERE Given_name LIKE :q OR Surname LIKE :q";
        return $this->extracted($sql, $nameQuery);
    }

    /**
     * Gets all patients from database
     * @return array of Patient DTOs
     */
    public function getAllPatients(): array
    {
        $sql = "SELECT * FROM patient";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $patients = [];
        foreach ($rows as $row) {
            $patients[] = new Patient(
                (int)$row['Birth_certificate_number'],
                $row['Given_name'],
                $row['Surname'],
                $row['Permanent_address'],
                (int)$row['Insurance_company_number'],
                $row['Telephone_number'],
                $row['Birthdate']
            );
        }

        return $patients;
    }

    /**
     * Searches for a patient in database by birth certificate number
     * @param string $numberQuery Patient's birth certificate number query
     * @return array of Patient DTOs
     */
    public function searchPatientsByNumber(string $numberQuery): array
    {
        $sql = "SELECT * FROM patient WHERE Birth_certificate_number LIKE :q";
        return $this->extracted($sql, $numberQuery);
    }

    /**
     * Searches for a patient in database by insurance company number
     * @param int $insuranceCompanyNumberQuery Patient's name/surname query
     * @return array of Patient DTOs
     */
    public function searchPatientsByInsuranceCompanyNumber(int $insuranceCompanyNumberQuery): array {
        $sql = "SELECT * FROM patient WHERE Insurance_company_number = :icn";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':icn' => $insuranceCompanyNumberQuery]);
        $rows = $stmt->fetchAll();

        $patients = [];
        foreach ($rows as $row) {
            $patients[] = new Patient(
                (int)$row['Birth_certificate_number'],
                $row['Given_name'],
                $row['Surname'],
                $row['Permanent_address'],
                (int)$row['Insurance_company_number'],
                $row['Telephone_number'],
                $row['Birthdate']
            );
        }

        return $patients;
    }

    /**
     * Updates an existing patients data
     * @param Patient $patient Patient DTO
     * @return bool Update successful?
     */
    public function updatePatient(Patient $patient): bool {
        $sql = "UPDATE patient 
                SET Given_name = :given_name, Surname = :surname, Permanent_address = :address, 
                    Insurance_company_number = :icn, Telephone_number = :phone, Birthdate = :birthdate
                WHERE Birth_certificate_number = :bcn";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':given_name' => $patient->getGivenName(),
            ':surname' => $patient->getSurname(),
            ':address' => $patient->getAddress(),
            ':icn' => $patient->getInsuranceCompanyNumber(),
            ':phone' => $patient->getPhoneNumber(),
            ':birthdate' => $patient->getBirthdate(),
            ':bcn' => $patient->getBirthCertificateNumber()
        ]);
    }

    /**
     * Executes a database query patient search and extracts all matching Patient DTOs
     * @param string $sql search query
     * @param string $query expression to match
     * @return array of Patient DTOs
     */
    public function extracted(string $sql, string $query): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':q' => '%' . $query . '%']);

        $patients = [];
        while ($row = $stmt->fetch()) {
            $patients[] = new Patient(
                (int)$row['Birth_certificate_number'],
                $row['Given_name'],
                $row['Surname'],
                $row['Permanent_address'],
                (int)$row['Insurance_company_number'],
                $row['Telephone_number'],
                $row['Birthdate']
            );
        }

        return $patients;
    }
}