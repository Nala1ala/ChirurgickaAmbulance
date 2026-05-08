<?php

namespace app\models\daos;

use app\models\dtos\Prescription;

interface PrescriptionDAOInterface
{
    public function insertPrescription(Prescription $prescription): bool;
    public function getPrescriptionsByPatientId(string $patientId): array;
}