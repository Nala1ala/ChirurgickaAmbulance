<?php
namespace app\controllers;
use app\models\daos\PatientDAOInterface;
use app\models\daos\SicknessCertificateDAOInterface;
use app\models\dtos\SicknessCertificate;

/**
 * Handles sickness certificate creation and termination actions.
 */
class SicknessCertificateController {
    private PatientDAOInterface $patientDao;
    private SicknessCertificateDAOInterface $certificateDao;
    private \Twig\Environment $twig;

    /**
     * Creates a sickness certificate controller with required data access dependencies.
     * @param \Twig\Environment $twig Twig environment for rendering templates
     * @param PatientDAOInterface $patientDao Patient data access object
     * @param SicknessCertificateDAOInterface $certificateDao Sickness certificate data access object
     */
    public function __construct(\Twig\Environment $twig, PatientDAOInterface $patientDao, SicknessCertificateDAOInterface $certificateDao) {
        $this->twig = $twig;
        $this->patientDao = $patientDao;
        $this->certificateDao = $certificateDao;
    }


    /**
     * Shows the form for adding a sickness certificate to a patient.
     */
    public function showAddCertificateForm(): void {
        $patientId = ($_GET['patient_id'] ?? 0);
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
     * Processes submitted sickness certificate data and stores a new certificate.
     */
    public function processAddCertificate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        $patientId = ($_GET['id'] ?? 0);
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
     * Shows the form for ending an active sickness certificate.
     */
    public function showEndCertificateForm(): void {
        $patientId = ($_GET['patient_id'] ?? 0);
        $startDate = $_GET['start_date'] ?? '';

        echo $this->twig->render('end_certificate.twig', [
            'patient_id' => $patientId,
            'start_date' => $startDate,
            'active_page' => 'patients'
        ]);
    }

    /**
     * Processes submitted sickness certificate end date data.
     */
    public function processEndCertificate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        $patientId = ($_GET['id'] ?? 0);
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
