<?php

namespace app\models\daos;
use app\models\dtos\Diagnosis;

interface DiagnosisDAOInterface
{
    public function getAllDiagnoses(): array;
}