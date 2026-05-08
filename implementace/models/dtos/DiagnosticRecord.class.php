<?php

namespace app\models\dtos;
/**
 * Diagnostic record of a specific patient DTO
 */
class DiagnosticRecord
{
    private string $date;
    private string $patientId;
    private int $diagnosisId;
    private string $description;

    /**
     * New instance constructor
     * @param string $date
     * @param string $patientId Patient identifier
     * @param int $diagnosisId Diagnosis identifier
     * @param string $description Doctor's description of specific case
     */
    public function __construct(string $date, string $patientId, int $diagnosisId, string $description)
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

    public function getPatientId(): string
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