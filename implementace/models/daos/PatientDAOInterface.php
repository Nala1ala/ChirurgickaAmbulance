<?php

namespace app\models\daos;
use app\models\dtos\Patient;

interface PatientDAOInterface
{
    public function insertPatient(Patient $patient): bool;
    public function getPatientById(string $birthCertificateNumber): ?Patient;
    public function searchPatientsByName(string $nameQuery): array;
    public function getAllPatients(): array;
    public function searchPatientsByNumber(string $numberQuery): array;
    public function searchPatientsByInsuranceCompanyNumber(int $insuranceCompanyNumberQuery): array;
    public function extracted(string $sql, array $queryParams): array;
}