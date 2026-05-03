<?php

class SicknessCertificate {
    private int $patientId;
    private string $startDate;
    private ?string $endDate; // Nullable
    private string $activeAddress;
    private string $employer;

    /**
     * New instance constructor
     * @param int $patientId Patient identifier
     * @param string $startDate
     * @param string|null $endDate
     * @param string $activeAddress Address where patient will stay during the duration of the certificate
     * @param string $employer
     */
    public function __construct(int $patientId, string $startDate, ?string $endDate, string $activeAddress, string $employer) {
        $this->patientId = $patientId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->activeAddress = $activeAddress;
        $this->employer = $employer;
    }

    // Attribute getters
    public function getPatientId(): int { return $this->patientId; }
    public function getStartDate(): string { return $this->startDate; }
    public function getEndDate(): ?string { return $this->endDate; }
    public function getActiveAddress(): string { return $this->activeAddress; }
    public function getEmployer(): string { return $this->employer; }

    // Attribute setters
    public function setEndDate(string $endDate): void {
        $this->endDate = $endDate;
    }

    /**
     * Determines whether a certificate has been terminated
     * @return bool Has the certificate no end date?
     */
    public function isActive(): bool {
        return $this->endDate === null;
    }
}