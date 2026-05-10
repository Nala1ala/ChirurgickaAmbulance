<?php

namespace app\models\dtos;
class SicknessCertificate
{
    private string $patientId;
    private string $startDate;
    private ?string $endDate; // Nullable
    private string $activeAddress;
    private string $employer;

    /**
     * New instance constructor
     * @param string $patientId Patient identifier
     * @param string $startDate
     * @param string|null $endDate
     * @param string $activeAddress Address where patient will stay during the duration of the certificate
     * @param string $employer
     */
    public function __construct(string $patientId, string $startDate, ?string $endDate, string $activeAddress, string $employer)
    {
        $this->patientId = $patientId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->activeAddress = $activeAddress;
        $this->employer = $employer;
    }

    // Attribute getters
    /**
     * Gets the patient identifier.
     * @return string Patient identifier
     */
    public function getPatientId(): string
    {
        return $this->patientId;
    }

    /**
     * Gets the certificate start date.
     * @return string Start date
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * Gets the certificate end date.
     * @return string|null End date
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * Gets the patient's active address during sickness.
     * @return string Active address
     */
    public function getActiveAddress(): string
    {
        return $this->activeAddress;
    }

    /**
     * Gets the patient's employer.
     * @return string Employer
     */
    public function getEmployer(): string
    {
        return $this->employer;
    }

    // Attribute setters
    /**
     * Sets the certificate end date.
     * @param string $endDate End date
     */
    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * Determines whether a certificate has been terminated
     * @return bool Has the certificate no end date?
     */
    public function isActive(): bool
    {
        return $this->endDate === null;
    }
}
