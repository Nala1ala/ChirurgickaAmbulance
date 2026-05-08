<?php

namespace app\models\repositories;

interface DiagnosticRecordRepositoryInterface
{
    public function getRecordsWithNames(string $patientId): array;
}