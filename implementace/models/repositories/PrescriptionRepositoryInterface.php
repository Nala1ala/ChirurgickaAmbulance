<?php

namespace app\models\repositories;

/**
 * Defines prescription read operations with joined medication data.
 */
interface PrescriptionRepositoryInterface
{
    /**
     * Gets prescriptions with medication names and forms for a patient.
     * @param string $patientId Patient identifier
     * @return array Prescriptions with medication details
     */
    public function getPrescriptionsWithNames(string $patientId): array;
}
