<?php
namespace app\controllers;
use app\models\daos\PatientDAOInterface;
use app\models\dtos\Patient;
use app\models\repositories\PatientRepository;

class PatientController {
    private PatientRepository $patientRepo;
    private PatientDAOInterface $patientDao;
    private \Twig\Environment $twig;

    /**
     * Creates a patient controller with required data access dependencies.
     * @param \Twig\Environment $twig Twig environment for rendering templates
     * @param PatientRepository $patientRepo Repository for complete patient profiles
     * @param PatientDAOInterface $patientDao Patient data access object
     */
    public function __construct(\Twig\Environment $twig, PatientRepository $patientRepo, PatientDAOInterface $patientDao) {
        $this->twig = $twig;
        $this->patientRepo = $patientRepo;
        $this->patientDao = $patientDao;
    }

    /**
     * Shows the default list of all patients.
     */
    public function index(): void {
        // V reálné aplikaci by zde mohla být metoda getAllPatients()
        // Pro jednoduchost použijeme search s prázdným dotazem.
        $patients = $this->patientDao->getAllPatients();

        echo $this->twig->render('patient_list.twig', [
            'patients' => $patients,
            'active_page' => 'patients'
        ]);
    }

    /**
     * Processes the patient search form and renders matching patients.
     */
    public function search(): void {
        $query = $_GET['query'] ?? '';
        $type = $_GET['searchType'] ?? 'surname';

        // Podle vybraného typu voláme příslušnou metodu v DAO
        if ($type === 'birth_certificate') {
            $patients = $this->patientDao->searchPatientsByNumber($query);
        } else if ($type === 'insurance_number') {
            $patients = $this->patientDao->searchPatientsByInsuranceCompanyNumber((int)$query);
        } else {
            $patients = $this->patientDao->searchPatientsByName($query);
        }

        echo $this->twig->render('patient_list.twig', [
            'patients' => $patients,
            'active_page' => 'patients',
            'search_query' => $query // Aby uživatel viděl, co hledal
        ]);
    }

    /**
     * Shows a complete patient profile including related medical records.
     */
    public function detail(): void {
        $id = ($_GET['id'] ?? 0);
        $patient = $this->patientRepo->getCompletePatientProfile($id);

        if (!$patient) {
            echo $this->twig->render('error.twig', [
                'message' => "Pacient s rodným číslem $id nebyl nalezen.",
                'active_page' => 'patients'
            ]);
            return;
        }

        echo $this->twig->render('patient_detail.twig', [
            'patient' => $patient,
            'active_page' => 'patients'
        ]);
    }

    /**
     * Shows an empty form for creating a new patient.
     */
    public function showAddPatientForm(): void {
        echo $this->twig->render('add_patient.twig', [
            'active_page' => 'patients'
        ]);
    }

    /**
     * Processes submitted patient data and stores a new patient.
     */
    public function processAddPatient(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        // 1. Sběr dat z formuláře
        $rc = $_POST['birthCertificateNumber'];

        if ($rc === '' || !ctype_digit($rc)) {
            echo $this->twig->render('error.twig', [
                'message' => 'Neplatný formát rodného čísla. Jsou povoleny pouze číslice.',
                'active_page' => 'patients'
            ]);
            return;
        }

        $newPatient = $this->getNewPatient($rc);

        // 3. Pokus o uložení
        $success = $this->patientDao->insertPatient($newPatient);

        if ($success) {
            // Po úspěchu přesměrujeme na detail, aby lékař mohl hned psát diagnózu
            header("Location: index.php?action=detail&id=" . $rc);
            exit;
        } else {
            echo $this->twig->render('add_patient.twig', [
                'error' => 'Chyba při ukládání. Rodné číslo je pravděpodobně již v systému.',
                'active_page' => 'patients'
            ]);
        }
    }

    /**
     * Shows a form for editing an existing patient.
     */
    public function showEditPatientForm(): void {
        $id = ($_GET['id'] ?? 0);

        // Získáme pacienta z databáze
        $patient = $this->patientDao->getPatientById($id);

        if (!$patient) {
            echo $this->twig->render('error.twig', [
                'message' => 'Pacient s tímto rodným číslem nebyl nalezen.',
                'active_page' => 'patients'
            ]);
            return;
        }

        echo $this->twig->render('edit_patient.twig', [
            'patient' => $patient,
            'active_page' => 'patients'
        ]);
    }

    /**
     * Processes submitted patient changes and updates the patient record.
     */
    public function processEditPatient(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        // Rodné číslo si vezmeme z URL, protože ve formuláři je disabled/readonly
        $rc = ($_GET['id'] ?? 0);

        $existingPatient = $this->patientDao->getPatientById($rc);
        if (!$existingPatient) {
            echo $this->twig->render('error.twig', ['message' => 'Pacient nenalezen.']);
            return;
        }

        $updatedPatient = new Patient(
            $rc,
            trim($_POST['givenName'] ?? ''),
            trim($_POST['surname'] ?? ''),
            trim($_POST['address'] ?? ''),
            (int)($_POST['insuranceCompanyNumber'] ?? 0),
            trim($_POST['phoneNumber'] ?? ''),
            $existingPatient->getBirthdate()
        );

        // Uložíme přes již existující metodu v DAO
        $success = $this->patientDao->updatePatient($updatedPatient);

        if ($success) {
            // Po úspěšné úpravě přesměrujeme zpět na detail pacienta
            header("Location: index.php?action=detail&id=" . $rc);
            exit;
        } else {
            echo $this->twig->render('error.twig', [
                'message' => 'Nastala chyba při aktualizaci údajů pacienta.',
                'active_page' => 'patients'
            ]);
        }
    }

    /**
     * Creates a Patient DTO from submitted form data.
     * @param string $rc Patient birth certificate number
     * @return Patient New patient DTO
     */
    public function getNewPatient(string $rc): Patient
    {
        $givenName = trim($_POST['givenName']);
        $surname = trim($_POST['surname']);
        $address = trim($_POST['address']);
        $insurance = (int)$_POST['insuranceCompanyNumber'];
        $phone = trim($_POST['phoneNumber']);
        $birthdate = $_POST['birthdate'];

        // 2. Vytvoření DTO (využívá tvou třídu Patient.class.php)
        $newPatient = new Patient(
            $rc,
            $givenName,
            $surname,
            $address,
            $insurance,
            $phone,
            $birthdate
        );
        return $newPatient;
    }
}
