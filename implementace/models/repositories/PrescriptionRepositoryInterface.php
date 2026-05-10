<?php

namespace app\models\repositories;

interface PrescriptionRepositoryInterface
{
    /**
     * Gets prescriptions with medication names and forms for a patient.
     * @param string $patientId Patient identifier
     * @return array Prescriptions with medication details
     */
    public function getPrescriptionsWithNames(string $patientId): array;
}
