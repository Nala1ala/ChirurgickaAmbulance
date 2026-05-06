<?php

namespace app\models\dtos;
/**
 * Diagnostic record of a specific patient DTO
 */
class DiagnosticRecord
{
    private string $date;
    private int $patientId;
    private int $diagnosisId;
    private string $description;

    /**
     * New instance constructor
     * @param string $date
     * @param int $patientId Patient identifier
     * @param int $diagnosisId Diagnosis identifier
     * @param string $description Doctor's description of specific case
     */
    public function __construct(string $date, int $patientId, int $diagnosisId, string $description)
    {
        $this->date = $date;
        $this->patientId = $patientId;
        $this->diagnosisId = $diagnosisId;
        $this->description = $description;
    }

    // Attribute getters
    public function getDate(): string
    {
        return $this->date;
    }

    public function getPatientId(): int
    {
        return $this->patientId;
    }

    public function getDiagnosisId(): int
    {
        return $this->diagnosisId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

?>