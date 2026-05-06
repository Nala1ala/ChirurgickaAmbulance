<?php
namespace app\controllers;
use app\models\daos\PatientDAO;
use app\models\dtos\Patient;
use app\models\repositories\PatientRepository;

class PatientController {
    private PatientRepository $patientRepo;
    private PatientDAO $patientDao;
    private \Twig\Environment $twig;

    /**
     * Konstruktor přijímá Twig, aby mohl vykreslovat šablony.
     * Repozitář a DAO si inicializuje sám.
     */
    public function __construct(\Twig\Environment $twig) {
        $this->twig = $twig;
        $this->patientRepo = new PatientRepository();
        $this->patientDao = new PatientDAO();
    }

    /**
     * Akce: index
     * Zobrazí výchozí seznam všech pacientů.
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
     * Akce: search_patients
     * Zpracuje vyhledávací formulář z patient_list.twig
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
     * Akce: detail (PU-03)
     * Zobrazí kompletní kartu pacienta včetně historie.
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
     * Akce: add_patient_form (PU-01)
     * Pouze zobrazí prázdný formulář.
     */
    public function showAddPatientForm(): void {
        echo $this->twig->render('add_patient.twig', [
            'active_page' => 'patients'
        ]);
    }

    /**
     * Akce: add_patient (PU-01)
     * Zpracuje POST data z formuláře a uloží pacienta.
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
     * Akce: edit_patient_form (PU-10)
     * Zobrazí formulář pro úpravu pacienta předvyplněný stávajícími daty.
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
     * Akce: edit_patient (PU-10)
     * Zpracuje odeslaná data a aktualizuje záznam v databázi.
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
     * @param string $rc
     * @return Patient
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