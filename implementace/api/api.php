<?php
// api.php - simple REST API for ČSSZ / employer
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once '../MyAutoloader.inc.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use app\models\daos\SicknessCertificateDAO;

header('Content-Type: application/json; charset=utf-8');

try {
    $dao = new SicknessCertificateDAO();
    $rc = $_GET['rc'] ?? null;
    $result = [];

    if ($rc) {
        // active sickness certificates of a specific patient
        $certificates = $dao->getCertificatesByPatientId($rc);
        $activeCerts = array_filter($certificates, fn($c) => $c->getEndDate() === null);
    } else {
        // all active sickness certificates
        $activeCerts = $dao->getActiveCertificates();
    }

    foreach ($activeCerts as $cert) {
        $result[] = [
            'patient_id' => $cert->getPatientId(),
            'start_date' => $cert->getStartDate()
        ];
    }

    // response
    echo json_encode([
        'status' => 'success',
        'count' => count($result),
        'data' => array_values($result)
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Chyba serveru: '. $e->getMessage()]);
}
