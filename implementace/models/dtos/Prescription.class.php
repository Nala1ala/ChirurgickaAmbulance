<?php

namespace app\models\dtos;
use app\models\dtos\Medication;
/**
 * Prescription DTO
 */
class Prescription
{
    private string $date;
    private string $patientId;
    private int $medicineId;
    private string $commentary;
    private Medication $medication;

    /**
     * New instance identifier
     * @param string $date Date issued
     * @param string $patientId Patient identifier
     * @param int $medicineId Medication identifier
     * @param string $commentary Doctor's comment
     */
    public function __construct(string $date, string $patientId, int $medicineId, string $commentary)
    {
        $this->date = $date;
        $this->patientId = $patientId;
        $this->medicineId = $medicineId;
        $this->commentary = $commentary;
    }

    // Attribute getters
    /**
     * Gets the prescription issue date.
     * @return string Prescription date
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
     * Gets the medication identifier.
     * @return int Medication identifier
     */
    public function getMedicineId(): int
    {
        return $this->medicineId;
    }

    /**
     * Gets the doctor's prescription comment.
     * @return string Prescription comment
     */
    public function getCommentary(): string
    {
        return $this->commentary;
    }

    /**
     * Gets the medication object
     * @return \app\models\dtos\Medication Medication
     */
    public function getMedication(): Medication {
        return $this->medication;
    }

    /**
     * Sets the medication object
     * @param \app\models\dtos\Medication $medication Medication
     * @return void
     */
    public function setMedication(Medication $medication): void
    {
        $this->medication = $medication;
    }
}
