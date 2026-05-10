<?php

namespace app\models\daos;

use app\models\dtos\Prescription;

interface PrescriptionDAOInterface
{
    /**
     * Saves a new prescription.
     * @param Prescription $prescription Prescription DTO
     * @return bool Saving successful?
     */
    public function insertPrescription(Prescription $prescription): bool;

    /**
     * Gets prescriptions for a patient.
     * @param string $patientId Patient identifier
     * @return Prescription[] Patient prescriptions
     */
    public function getPrescriptionsByPatientId(string $patientId): array;
}
