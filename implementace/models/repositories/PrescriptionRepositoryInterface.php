<?php

namespace app\models\repositories;

interface PrescriptionRepositoryInterface
{
    public function getPrescriptionsWithNames(string $patientId): array;
}