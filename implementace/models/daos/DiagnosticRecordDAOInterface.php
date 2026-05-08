<?php

namespace app\models\daos;

use app\models\dtos\DiagnosticRecord;

interface DiagnosticRecordDAOInterface
{
    public function insertDiagnosticRecord(DiagnosticRecord $record): bool;
    public function getRecordsByPatientId(string $patientId): array;

}