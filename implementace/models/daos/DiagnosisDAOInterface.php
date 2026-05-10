<?php

namespace app\models\daos;
use app\models\dtos\Diagnosis;

/**
 * Inrterface for data access object for Diagnosis
 */
interface DiagnosisDAOInterface
{
    /**
     * Gets all diagnoses from database
     * @return Diagnosis[] array of Diagnoses DTO
     */
    public function getAllDiagnoses(): array;
}