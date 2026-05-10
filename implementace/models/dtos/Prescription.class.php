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
    private string $medicineName;
    private string $form;

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
     * Gets the medication name.
     * @return string Medication name
     */
    public function getMedicineName(): string
    {
        return $this->medicineName;
    }

    /**
     * Gets the medication form.
     * @return string Medication form
     */
    public function getForm(): string
    {
        return $this->form;
    }

    /**
     * @param string $medicineName
     */
    public function setMedicineName(string $medicineName): void
    {
        $this->medicineName = $medicineName;
    }

    /**
     * Sets the medication form.
     * @param string $form Medication form
     */
    public function setForm(string $form): void
    {
        $this->form = $form;
    }
}
