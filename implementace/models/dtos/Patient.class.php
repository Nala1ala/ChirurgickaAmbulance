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
    public function getBirthCertificateNumber(): ?string
    {
        return $this->birthCertificateNumber;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getInsuranceCompanyNumber(): int
    {
        return $this->insuranceCompanyNumber;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    public function getDiagnoses(): array
    {
        return $this->diagnoses;
    }

    public function getPrescriptions(): array
    {
        return $this->prescriptions;
    }

    public function getCertificates(): array
    {
        return $this->certificates;
    }

    // Attribute setters
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setInsuranceCompanyNumber(int $insuranceCompanyNumber): void
    {
        $this->insuranceCompanyNumber = $insuranceCompanyNumber;
    }

    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function setDiagnoses(array $diagnoses): void
    {
        $this->diagnoses = $diagnoses;
    }

    public function setPrescriptions(array $prescriptions): void
    {
        $this->prescriptions = $prescriptions;
    }

    public function setCertificates(array $certificates): void
    {
        $this->certificates = $certificates;
    }
}
