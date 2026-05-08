<?php

namespace app\models\dtos;
/**
 * prescription DTO
 */
class Prescription
{
    private string $date;
    private string $patientId;
    private int $medicineId;
    private string $commentary;

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
    public function getDate(): string
    {
        return $this->date;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getMedicineId(): int
    {
        return $this->medicineId;
    }

    public function getCommentary(): string
    {
        return $this->commentary;
    }
}