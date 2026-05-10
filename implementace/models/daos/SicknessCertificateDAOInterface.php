<?php

namespace app\models\daos;

use app\models\dtos\SicknessCertificate;

interface SicknessCertificateDAOInterface
{
    /**
     * Gets all active sickness certificates.
     * @return SicknessCertificate[] Active sickness certificates
     */
    public function getActiveCertificates(): array;

    /**
     * Saves a new sickness certificate.
     * @param SicknessCertificate $cert Sickness certificate DTO
     * @return bool Saving successful?
     */
    public function insertCertificate(SicknessCertificate $cert): bool;

    /**
     * Updates the end date of a sickness certificate.
     * @param int $patientId Patient identifier
     * @param string $startDate Certificate start date
     * @param string $endDate Certificate end date
     * @return bool Update successful?
     */
    public function updateEndDate(int $patientId, string $startDate, string $endDate): bool;

    /**
     * Gets sickness certificates for a patient.
     * @param string $patientId Patient identifier
     * @return SicknessCertificate[] Patient sickness certificates
     */
    public function getCertificatesByPatientId(string $patientId): array;
}
