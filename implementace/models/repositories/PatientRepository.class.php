<?php

namespace app\models\repositories;

use app\models\daos\DiagnosticRecordDAOInterface;
use app\models\daos\PatientDAO;
use app\models\daos\PatientDAOInterface;
use app\models\daos\PrescriptionDAO;
use app\models\daos\PrescriptionDAOInterface;
use app\models\daos\SicknessCertificateDAO;
use app\models\daos\SicknessCertificateDAOInterface;
use app\models\dtos\Patient;

class PatientRepository
{
    private PatientDAOInterface $patientDao;
    private PrescriptionRepository $prescriptionRep;
    private DiagnosticRecordRepository $diagnosticRep;
    private SicknessCertificateDAOInterface $certificateDao;

    /**
     * New instance initiator - initiates data access objects
     */
    public function __construct(PatientDAOInterface $patientDao, PrescriptionRepository $prescriptionRep, DiagnosticRecordRepository $diagnosticRep, SicknessCertificateDAO $certificateDao)
    {
        $this->patientDao = $patientDao;
        $this->prescriptionRep = $prescriptionRep;
        $this->diagnosticRep = $diagnosticRep;
        $this->certificateDao = $certificateDao;
    }

    /**
     * Get's a patient's complete profile with all details, diagnoses, prescriptions and sickness certificates
     * @param string $birthCertificateNumber Patient identifier
     * @return Patient|null Patient DTO if patient exists in database
     */
    public function getCompletePatientProfile(string $birthCertificateNumber): ?Patient
    {
        $patient = $this->patientDao->getPatientById($birthCertificateNumber);

        if ($patient === null) {
            return null;
        }

        $patient->setPrescriptions($this->prescriptionRep->getPrescriptionsWithNames($birthCertificateNumber));
        $patient->setDiagnoses($this->diagnosticRep->getRecordsWithNames($birthCertificateNumber));
        $patient->setCertificates($this->certificateDao->getCertificatesByPatientId($birthCertificateNumber));

        // Nyní vracíme jeden masivní, plně naplněný objekt
        return $patient;
    }
}