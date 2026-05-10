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
    private string $diagnosisName;

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
    /**
     * Gets the diagnostic record date.
     * @return string Record date
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Gets the patient identifier.
     * @return string Patient identifier
     */
    public function getPatientId(): string
    {
        return $this->patientId;
    }

    /**
     * Gets the diagnosis identifier.
     * @return int Diagnosis identifier
     */
    public function getDiagnosisId(): int
    {
        return $this->diagnosisId;
    }

    /**
     * Gets the diagnostic record description.
     * @return string Record description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Gets the diagnosis name.
     * @return string Diagnosis name
     */
    public function getDiagnosisName(): string {
        return $this->diagnosisName;
    }

    /**
     * Sets the diagnosis name.
     * @param string $diagnosisName Diagnosis name
     */
    public function setDiagnosisName(string $diagnosisName): void {
        $this->diagnosisName = $diagnosisName;
    }
}
