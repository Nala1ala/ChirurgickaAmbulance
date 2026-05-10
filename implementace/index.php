<?php
namespace app;
// Zapneme sessions (užitečné např. pro budoucí přihlašování lékaře nebo flash messages)
session_start();

// 1. Načtení závislostí a knihoven (Twig)
// Předpokládáme použití Composeru pro načtení Twigu
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

// 3. Inicializace šablonovacího systému Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views');
$twig = new \Twig\Environment($loader, [
    // 'cache' => __DIR__ . '/cache', // Pro produkci odkomentovat
    'auto_reload' => true // Během vývoje chceme hned vidět změny v šablonách
]);

$patientDAO = new PatientDAO();
$diagnosisDAO = new DiagnosisDAO();
$prescriptionDAO = new PrescriptionDAO();
$sicknessCertificateDAO = new SicknessCertificateDAO();
$medicationDAO = new MedicationDAO();
$diagnosticRecordDAO = new DiagnosticRecordDAO();
$diagnosticRecordRepository = new DiagnosticRecordRepository();
$prescriptionRepository = new PrescriptionRepository();
$patientRepository = new PatientRepository($patientDAO, $prescriptionRepository, $diagnosticRecordRepository, $sicknessCertificateDAO);

// 4. Inicializace jednotlivých kontrolerů (předáváme jim Twig)
$patientController = new PatientController($twig, $patientRepository, $patientDAO);
$diagnosisController = new DiagnosisController($twig, $patientDAO, $diagnosisDAO, $diagnosticRecordDAO);
$prescriptionController = new PrescriptionController($twig, $medicationDAO, $patientDAO, $prescriptionDAO);
$certificateController = new SicknessCertificateController($twig, $patientDAO, $sicknessCertificateDAO);

// 5. Získání požadované akce z URL (výchozí je seznam pacientů)
$action = $_GET['action'] ?? 'patients';

// 6. Hlavní směrovač (Router)
try {
    switch ($action) {

        // ==========================================
        // PACIENTI (PU-01, PU-03, PU-10)
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
        // DIAGNÓZY (PU-05)
        // ==========================================
        case 'add_diagnosis_form':
            $diagnosisController->showAddDiagnosisForm();
            break;

        case 'add_diagnosis':
            $diagnosisController->processAddDiagnosis();
            break;

        // ==========================================
        // PŘEDPISY LÉKŮ (PU-04)
        // ==========================================
        case 'add_prescription_form':
            $prescriptionController->showAddPrescriptionForm();
            break;

        case 'add_prescription':
            $prescriptionController->processAddPrescription();
            break;

        // ==========================================
        // NESCHOPENKY (PU-02, PU-08, PU-09)
        // ==========================================
        case 'certificates':
            // PU-02 Zobrazit aktivní neschopenky
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
        // LÉKOVÉ INTERAKCE (PU-06, PU-07)
        // ==========================================
        case 'interactions':
            // $interactionController->index();
            break;

        // ==========================================
        // CHYBOVÝ STAV - Neznámá akce
        // ==========================================
        default:
            echo $twig->render('error.twig', [
                'message' => 'Požadovaná stránka neexistuje nebo k ní nemáte přístup.'
            ]);
            break;
    }

} catch (\Exception $e) {
    // Globální zachycení chyb – pokud selže DB nebo cokoliv jiného, zobrazíme to hezky
    echo $twig->render('error.twig', [
        'message' => 'Kritická chyba systému: ' . $e->getMessage()
    ]);
}