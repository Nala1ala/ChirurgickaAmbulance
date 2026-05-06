<?php
namespace app\controllers;
use app\models\daos\MedicationDAO;
use app\models\daos\PatientDAO;
use app\models\daos\PrescriptionDAO;
use app\models\dtos\Prescription;

class PrescriptionController {
    private MedicationDAO $medicineDao;
    private PatientDAO $patientDao;
    private PrescriptionDAO $prescriptionDao;
    private \Twig\Environment $twig;

    /**
     * New instance initiator - initiates all data access objects
     * @param \Twig\Environment $twig Twig environment for displaying view templates
     */
    public function __construct(\Twig\Environment $twig) {
        $this->twig = $twig;
        $this->medicineDao = new MedicationDAO();
        $this->patientDao = new PatientDAO();
        $this->prescriptionDao = new PrescriptionDAO();
    }

    /**
     * Akce: add_prescription_form (PU-04)
     * Zobrazí formulář pro předpis léčiva
     */
    public function showAddPrescriptionForm(): void {
        $patientId = (int)($_GET['patient_id'] ?? 0);

        $patient = $this->patientDao->getPatientById($patientId);
        $medicines = $this->medicineDao->getAllMedicines();

        if (!$patient) {
            echo $this->twig->render('error.twig', [
                'message' => 'Pacient nebyl nalezen.',
                'active_page' => 'patients'
            ]);
            return;
        }

        echo $this->twig->render('add_prescription.twig', [
            'patient_id' => $patientId,
            'patient_name' => $patient->getGivenName() . ' ' . $patient->getSurname(),
            'medicines' => $medicines,
            'active_page' => 'patients'
        ]);
    }

    /**
     * Akce: add_prescription (PU-04)
     * Zpracuje odeslaný formulář (tuto metodu dopíšeme vzápětí)
     */
    /**
     * Akce: add_prescription (PU-04)
     * Zpracuje odeslaný formulář
     */
    public function processAddPrescription(): void {
        // Kontrola, že sem uživatel nepřišel jen zadáním URL, ale opravdu odeslal formulář
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=patients");
            exit;
        }

        // 1. Vyzvednutí dat z URL a z POST formuláře
        // Všimni si, že v šabloně máme action="index.php?action=add_prescription&id={{ patient_id }}"
        $patientId = (int)($_GET['id'] ?? 0);
        $medicineId = (int)$_POST['medicine_id'];
        $commentary = trim($_POST['commentary']);
        $date = date("Y-m-d");

        // Základní validace (kdyby náhodou někdo upravil HTML a něco neposlal)
        if (!$patientId || !$medicineId) {
            echo $this->twig->render('error.twig', [
                'message' => 'Vyberte prosím léčivo.',
                'active_page' => 'patients'
            ]);
            return;
        }

        // 2. Vytvoření DTO objektu
        $newPrescription = new Prescription($date, $patientId, $medicineId, $commentary);

        // 3. Pokus o uložení do databáze přes DAO ("odeslání objednávky do kuchyně")
        $success = $this->prescriptionDao->insertPrescription($newPrescription);

        if ($success) {
            // Po úspěšném uložení přesměrujeme lékaře zpět na detail pacienta,
            // kde hned uvidí nový lék v tabulce "Předepsaná léčiva"
            header("Location: index.php?action=detail&id=" . $patientId);
            exit;
        } else {
            echo $this->twig->render('error.twig', [
                'message' => 'Nastala chyba při ukládání předpisu do databáze.',
                'active_page' => 'patients'
            ]);
        }
    }
}