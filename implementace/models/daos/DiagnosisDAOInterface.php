<?php

namespace app\models\daos;
use app\models\dtos\Diagnosis;

/**
 * Defines diagnosis persistence operations.
 */
interface DiagnosisDAOInterface
{
    /**
     * Gets all diagnoses from database
     * @return Diagnosis[] array of Diagnoses DTO
     */
    public function getAllDiagnoses(): array;
}