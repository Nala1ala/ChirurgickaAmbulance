<?php

namespace app\models\daos;

use app\models\dtos\DiagnosticRecord;

interface DiagnosticRecordDAOInterface
{
    /**
     * Saves a new diagnostic record.
     * @param DiagnosticRecord $record Diagnostic record DTO
     * @return bool Saving successful?
     */
    public function insertDiagnosticRecord(DiagnosticRecord $record): bool;

    /**
     * Gets diagnostic records for a patient.
     * @param string $patientId Patient identifier
     * @return DiagnosticRecord[] Patient diagnostic records
     */
    public function getRecordsByPatientId(string $patientId): array;

}
