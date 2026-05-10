<?php

namespace app\models\repositories;

interface DiagnosticRecordRepositoryInterface
{
    /**
     * Gets diagnostic records with diagnosis names for a patient.
     * @param string $patientId Patient identifier
     * @return array Diagnostic records with names
     */
    public function getRecordsWithNames(string $patientId): array;
}
