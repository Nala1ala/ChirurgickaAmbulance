<?php

namespace app\models\daos;
use app\models\dtos\Patient;

interface PatientDAOInterface
{
    /**
     * Saves a new patient into the database.
     * @param Patient $patient Patient DTO
     * @return bool Saving successful?
     */
    public function insertPatient(Patient $patient): bool;

    /**
     * Gets a patient by birth certificate number.
     * @param string $birthCertificateNumber Patient identifier
     * @return Patient|null Patient DTO if found
     */
    public function getPatientById(string $birthCertificateNumber): ?Patient;

    /**
     * Searches patients by given name or surname.
     * @param string $nameQuery Patient name query
     * @return Patient[] Matching patients
     */
    public function searchPatientsByName(string $nameQuery): array;

    /**
     * Gets all patients.
     * @return Patient[] All patients
     */
    public function getAllPatients(): array;

    /**
     * Searches patients by birth certificate number.
     * @param string $numberQuery Birth certificate number query
     * @return Patient[] Matching patients
     */
    public function searchPatientsByNumber(string $numberQuery): array;

    /**
     * Searches patients by insurance company number.
     * @param int $insuranceCompanyNumberQuery Insurance company number query
     * @return Patient[] Matching patients
     */
    public function searchPatientsByInsuranceCompanyNumber(int $insuranceCompanyNumberQuery): array;

    /**
     * Executes a patient search query and maps rows to DTOs.
     * @param string $sql SQL query
     * @param array $queryParams Query parameters
     * @return Patient[] Matching patients
     */
    public function extracted(string $sql, array $queryParams): array;
}
