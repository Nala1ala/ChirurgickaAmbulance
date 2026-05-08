<?php

namespace app\models\daos;
use app\models\dtos\Medication;

interface MedicationDAOInterface
{
    public function getAllMedicines(): array;
    public function getMedicationById(int $id): ?Medication;
}