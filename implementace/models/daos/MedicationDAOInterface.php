<?php

namespace app\models\daos;
use app\models\dtos\Medication;

/**
 * Defines medication lookup operations.
 */
interface MedicationDAOInterface
{
    /**
     * Gets all medications.
     * @return Medication[] All medication DTOs
     */
    public function getAllMedicines(): array;

    /**
     * Gets medication by identifier.
     * @param int $id Medication identifier
     * @return Medication|null Medication DTO if found
     */
    public function getMedicationById(int $id): ?Medication;
}
