<?php

namespace app\models\dtos;
/**
 * Patient DTO
 */
class Patient
{

    private string $birthCertificateNumber;
    private string $givenName;
    private string $surname;
    private string $address;
    private int $insuranceCompanyNumber;
    private string $phoneNumber;
    private string $birthdate;

    private array $diagnoses = [];
    private array $prescriptions = [];
    private array $certificates = [];

    /**
     * New instance constructor
     * @param string|null $birthCertificateNumber Patient identifier
     * @param string $givenName First name(s)
     * @param string $surname Last name(s)
     * @param string $address Permanent address
     * @param int $insuranceCompanyNumber Insurance company identifier
     * @param string $phoneNumber Telephone number
     * @param string $birthdate
     */
    public function __construct(?string $birthCertificateNumber, string $givenName, string $surname, string $address, int $insuranceCompanyNumber, string $phoneNumber, string $birthdate)
    {
        $this->birthCertificateNumber = $birthCertificateNumber;
        $this->givenName = $givenName;
        $this->surname = $surname;
        $this->address = $address;
        $this->insuranceCompanyNumber = $insuranceCompanyNumber;
        $this->phoneNumber = $phoneNumber;
        $this->birthdate = $birthdate;
    }

    // Attribute getters
    /**
     * Gets the patient birth certificate number.
     * @return string|null Patient identifier
     */
    public function getBirthCertificateNumber(): ?string
    {
        return $this->birthCertificateNumber;
    }

    /**
     * Gets the patient given name.
     * @return string Given name
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * Gets the patient surname.
     * @return string Surname
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * Gets the patient permanent address.
     * @return string Permanent address
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Gets the patient insurance company number.
     * @return int Insurance company number
     */
    public function getInsuranceCompanyNumber(): int
    {
        return $this->insuranceCompanyNumber;
    }

    /**
     * Gets the patient phone number.
     * @return string Phone number
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * Gets the patient birthdate.
     * @return string Birthdate
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * Gets the patient diagnostic records.
     * @return DiagnosticRecord[] Diagnostic records
     */
    public function getDiagnoses(): array
    {
        return $this->diagnoses;
    }

    /**
     * Gets the patient prescriptions.
     * @return Prescription[] Prescriptions
     */
    public function getPrescriptions(): array
    {
        return $this->prescriptions;
    }

    /**
     * Gets the patient sickness certificates.
     * @return SicknessCertificate[] Sickness certificates
     */
    public function getCertificates(): array
    {
        return $this->certificates;
    }

    // Attribute setters
    /**
     * Sets the patient permanent address.
     * @param string $address Permanent address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * Sets the patient phone number.
     * @param string $phoneNumber Phone number
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Sets the patient insurance company number.
     * @param int $insuranceCompanyNumber Insurance company number
     */
    public function setInsuranceCompanyNumber(int $insuranceCompanyNumber): void
    {
        $this->insuranceCompanyNumber = $insuranceCompanyNumber;
    }

    /**
     * Sets the patient given name.
     * @param string $givenName Given name
     */
    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * Sets the patient surname.
     * @param string $surname Surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * Sets the patient diagnostic records.
     * @param DiagnosticRecord[] $diagnoses Diagnostic records
     */
    public function setDiagnoses(array $diagnoses): void
    {
        $this->diagnoses = $diagnoses;
    }

    /**
     * Sets the patient prescriptions.
     * @param Prescription[] $prescriptions Prescriptions
     */
    public function setPrescriptions(array $prescriptions): void
    {
        $this->prescriptions = $prescriptions;
    }

    /**
     * Sets the patient sickness certificates.
     * @param SicknessCertificate[] $certificates Sickness certificates
     */
    public function setCertificates(array $certificates): void
    {
        $this->certificates = $certificates;
    }
}
