<?php

namespace app\models\repositories;

/**
 * Defines diagnostic record read operations with joined diagnosis data.
 */
interface DiagnosticRecordRepositoryInterface
{
    /**
     * Gets diagnostic records with diagnosis names for a patient.
     * @param string $patientId Patient identifier
     * @return array Diagnostic records with names
     */
    public function getRecordsWithNames(string $patientId): array;
}
