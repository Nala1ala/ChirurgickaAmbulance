<?php

namespace app\models\daos;

use app\models\dtos\SicknessCertificate;

interface SicknessCertificateDAOInterface
{
    public function getActiveCertificates(): array;
    public function insertCertificate(SicknessCertificate $cert): bool;
    public function updateEndDate(int $patientId, string $startDate, string $endDate): bool;
    public function getCertificatesByPatientId(string $patientId): array;
}