<?php
namespace app;
// session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/myAutoloader.inc.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use app\controllers\PatientController;
use app\controllers\DiagnosisController;
use app\controllers\PrescriptionController;
use app\controllers\SicknessCertificateController;
use app\models\daos\DiagnosisDAO;
use app\models\daos\DiagnosticRecordDAO;
use app\models\daos\InteractionDAO;
use app\models\daos\MedicationDAO;
use app\models\daos\PatientDAO;
use app\models\daos\PrescriptionDAO;
use app\models\daos\SicknessCertificateDAO;
use app\models\repositories\DiagnosticRecordRepository;
use app\models\repositories\PatientRepository;
use app\models\repositories\PrescriptionRepository;

// Twig initialization
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views');
$twig = new \Twig\Environment($loader, [
    // 'cache' => __DIR__ . '/cache',
    'auto_reload' => true
]);

// Models
$patientDAO = new PatientDAO();
$diagnosisDAO = new DiagnosisDAO();
$prescriptionDAO = new PrescriptionDAO();
$sicknessCertificateDAO = new SicknessCertificateDAO();
$medicationDAO = new MedicationDAO();
$diagnosticRecordDAO = new DiagnosticRecordDAO();
$diagnosticRecordRepository = new DiagnosticRecordRepository();
$prescriptionRepository = new PrescriptionRepository();
$patientRepository = new PatientRepository($patientDAO, $prescriptionRepository, $diagnosticRecordRepository, $sicknessCertificateDAO);

// Controllers
$patientController = new PatientController($twig, $patientRepository, $patientDAO);
$diagnosisController = new DiagnosisController($twig, $patientDAO, $diagnosisDAO, $diagnosticRecordDAO);
$prescriptionController = new PrescriptionController($twig, $medicationDAO, $patientDAO, $prescriptionDAO);
$certificateController = new SicknessCertificateController($twig, $patientDAO, $sicknessCertificateDAO);

$action = $_GET['action'] ?? 'patients';

try {
    switch ($action) {

        // ==========================================
        // PATIENTS
        // ==========================================
        case 'patients':
            $patientController->index();
            break;

        case 'search_patients':
            $patientController->search();
            break;

        case 'detail':
            $patientController->detail(); // Detail pacienta
            break;

        case 'add_patient_form':
            $patientController->showAddPatientForm();
            break;

        case 'add_patient':
            $patientController->processAddPatient();
            break;

        case 'edit_patient_form':
            $patientController->showEditPatientForm();
            break;

        case 'edit_patient':
            $patientController->processEditPatient();
            break;

        // ==========================================
        // DIAGNOSES
        // ==========================================
        case 'add_diagnosis_form':
            $diagnosisController->showAddDiagnosisForm();
            break;

        case 'add_diagnosis':
            $diagnosisController->processAddDiagnosis();
            break;

        // ==========================================
        // MEDICATION PRESCRIPTIONS
        // ==========================================
        case 'add_prescription_form':
            $prescriptionController->showAddPrescriptionForm();
            break;

        case 'add_prescription':
            $prescriptionController->processAddPrescription();
            break;

        // ==========================================
        // SICKNESS CERTIFICATES
        // ==========================================
        case 'certificates':
            // $certificateController->index();
            break;

        case 'add_certificate_form':
            $certificateController->showAddCertificateForm();
            break;

        case 'add_certificate':
            $certificateController->processAddCertificate();
            break;

        case 'end_certificate_form':
            $certificateController->showEndCertificateForm();
            break;

        case 'end_certificate':
            $certificateController->processEndCertificate();
            break;

        // ==========================================
        // MEDICATION INTERACTIONS
        // ==========================================
        case 'interactions':
            // $interactionController->index();
            break;

        // ==========================================
        // ERROR STATE
        // ==========================================
        default:
            echo $twig->render('error.twig', [
                'message' => 'Požadovaná stránka neexistuje nebo k ní nemáte přístup.'
            ]);
            break;
    }

} catch (\Exception $e) {
    echo $twig->render('error.twig', [
        'message' => 'Kritická chyba systému: ' . $e->getMessage()
    ]);
}