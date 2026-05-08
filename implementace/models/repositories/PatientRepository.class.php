<?php

namespace app\models\repositories;

use app\models\daos\DiagnosticRecordDAOInterface;
use app\models\daos\PatientDAO;
use app\models\daos\PrescriptionDAO;
use app\models\daos\SicknessCertificateDAO;
use app\models\dtos\Patient;

class PatientRepository
{
    private PatientDAO $patientDao;
    private PrescriptionRepository $prescriptionRep;
    private DiagnosticRecordRepository $diagnosticRep;
    private SicknessCertificateDAO $certificateDao;

    /**
     * New instance initiator - initiates data access objects
     */
    public function __construct()
    {
        $this->patientDao = new PatientDAO();
        $this->prescriptionRep = new PrescriptionRepository();
        $this->diagnosticRep = new DiagnosticRecordRepository();
        $this->certificateDao = new SicknessCertificateDAO();
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