<?php
namespace app\controllers;
use app\models\dtos\SicknessCertificate;
use app\models\daos\PatientDAO;
use app\models\daos\SicknessCertificateDAO;

class SicknessCertificateController {
    private PatientDAO $patientDao;
    private SicknessCertificateDAO $certificateDao;
    private \Twig\Environment $twig;

    public function __construct(\Twig\Environment $twig) {
        $this->twig = $twig;
        $this->patientDao = new PatientDAO();
        $this->certificateDao = new SicknessCertificateDAO();
    }

    /**
     * PU-08: Zobrazí formulář pro přidání neschopenky
     */
    public function showAddCertificateForm(): void {
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $patient = $this->patientDao->getPatientById($patientId);

        if (!$patient) {
            echo $this->twig->render('error.twig', ['message' => 'Pacient nebyl nalezen.']);
            return;
        }

        echo $this->twig->render('add_certificate.twig', [
            'patient_id' => $patientId,
            'patient_name' => $patient->getGivenName() . ' ' . $patient->getSurname(),
            'active_page' => 'patients'
        ]);
    }

    /**
     * PU-08: Zpracuje založení neschopenky
     */
    public function processAddCertificate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        $patientId = (int)($_GET['id'] ?? 0);
        $startDate = $_POST['start_date'];
        $activeAddress = trim($_POST['active_address']);
        $employer = trim($_POST['employer']);

        // Při založení je endDate logicky null
        $newCertificate = new SicknessCertificate($patientId, $startDate, null, $activeAddress, $employer);

        if ($this->certificateDao->insertCertificate($newCertificate)) {
            header("Location: index.php?action=detail&id=" . $patientId);
            exit;
        } else {
            echo $this->twig->render('error.twig', ['message' => 'Chyba při ukládání neschopenky.']);
        }
    }

    /**
     * PU-09: Zobrazí formulář pro ukončení neschopenky
     */
    public function showEndCertificateForm(): void {
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $startDate = $_GET['start_date'] ?? '';

        echo $this->twig->render('end_certificate.twig', [
            'patient_id' => $patientId,
            'start_date' => $startDate,
            'active_page' => 'patients'
        ]);
    }

    /**
     * PU-09: Zpracuje ukončení neschopenky
     */
    public function processEndCertificate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        $patientId = (int)($_GET['id'] ?? 0);
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        if ($this->certificateDao->updateEndDate($patientId, $startDate, $endDate)) {
            header("Location: index.php?action=detail&id=" . $patientId);
            exit;
        } else {
            echo $this->twig->render('error.twig', ['message' => 'Chyba při ukončování neschopenky.']);
        }
    }
}