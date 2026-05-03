<?php
include_once PatientDAO::class; include_once PrescriptionDAO::class; include_once DiagnosticRecordDAO::class; include_once SicknessCertificateDAO::class;
class PatientRepository {
    private PatientDAO $patientDao;
    private PrescriptionDAO $prescriptionDao;
    private DiagnosticRecordDAO $diagnosticDao;
    private SicknessCertificateDAO $certificateDao;

    /**
     * New instance initiator - initiates data access objects
     */
    public function __construct() {
        $this->patientDao = new PatientDAO();
        $this->prescriptionDao = new PrescriptionDAO();
        $this->diagnosticDao = new DiagnosticRecordDAO();
        $this->certificateDao = new SicknessCertificateDAO();
    }

    /**
     * Get's a patient's complete profile with all details, diagnoses, prescriptions and sickness certificates
     * @param int $birthCertificateNumber Patient identifier
     * @return Patient|null Patient DTO if patient exists in database
     */
    public function getCompletePatientProfile(int $birthCertificateNumber): ?Patient {
        $patient = $this->patientDao->getPatientById($birthCertificateNumber);

        if ($patient === null) {
            return null;
        }

        $patient->setPrescriptions($this->prescriptionDao->getPrescriptionsByPatientId($birthCertificateNumber));
        $patient->setDiagnoses($this->diagnosticDao->getRecordsByPatientId($birthCertificateNumber));
        // Poznámka: v SicknessCertificateDAO bychom přidali metodu getCertificatesByPatientId
        $patient->setCertificates($this->certificateDao->getCertificatesByPatientId($birthCertificateNumber));

        // Nyní vracíme jeden masivní, plně naplněný objekt
        return $patient;
    }
}