<?php
namespace app\controllers;
use app\models\daos\DiagnosisDAO;
use app\models\daos\DiagnosticRecordDAO;
use app\models\daos\PatientDAO;
use app\models\dtos\DiagnosticRecord;

class DiagnosisController {
    private PatientDAO $patientDao;
    private DiagnosisDAO $diagnosisDao;
    private DiagnosticRecordDAO $recordDao;
    private \Twig\Environment $twig;

    public function __construct(\Twig\Environment $twig) {
        $this->twig = $twig;
        $this->patientDao = new PatientDAO();
        $this->diagnosisDao = new DiagnosisDAO();
        $this->recordDao = new DiagnosticRecordDAO();
    }

    /**
     * Zobrazí formulář pro přidání diagnózy (PU-05)
     */
    public function showAddDiagnosisForm(): void {
        $patientId = ($_GET['patient_id'] ?? 0);
        $patient = $this->patientDao->getPatientById($patientId);

        // Načteme číselník diagnóz!
        $diagnoses = $this->diagnosisDao->getAllDiagnoses();

        if (!$patient) {
            echo $this->twig->render('error.twig', ['message' => 'Pacient nebyl nalezen.']);
            return;
        }

        echo $this->twig->render('add_diagnosis.twig', [
            'patient_id' => $patientId,
            'patient_name' => $patient->getGivenName() . ' ' . $patient->getSurname(),
            'diagnoses' => $diagnoses, // Předáváme do šablony
            'active_page' => 'patients'
        ]);
    }

    /**
     * Zpracuje odeslaný formulář
     */
    public function processAddDiagnosis(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        $patientId = ($_GET['id'] ?? 0);
        $diagnosisId = (int)$_POST['diagnosis_id'];
        $description = trim($_POST['description']);
        $date = date("Y-m-d");

        if (!$patientId || !$diagnosisId) {
            echo $this->twig->render('error.twig', ['message' => 'Vyberte prosím diagnózu.']);
            return;
        }

        // Využíváme třídu DiagnosticRecord z tvého souboru
        $newRecord = new DiagnosticRecord($date, $patientId, $diagnosisId, $description);

        $success = $this->recordDao->insertDiagnosticRecord($newRecord);

        if ($success) {
            header("Location: index.php?action=detail&id=" . $patientId);
            exit;
        } else {
            echo $this->twig->render('error.twig', ['message' => 'Chyba při ukládání diagnózy.']);
        }
    }
}